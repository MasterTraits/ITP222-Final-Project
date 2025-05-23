<?php

namespace App\Controllers;

use App\Models\TripModel;

class TripController
{
  private $tripModel;

  public function __construct($db)
  {
    $this->tripModel = new TripModel($db);
  }

  // --------------------------------------------------
  //                FORM DATA HANDLING
  // -------------------------------------------------
  public function saveFormData()
  {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
      if (isset($_POST['step'])) {
        $step = $_POST['step'];
        unset($_POST['step']);

        $_SESSION['booking_data']['step' . $step] = $_POST;

        header('Location: /book/' . $step);
        exit;
      } else {
        $_SESSION['booking_data']['step3'] = $_POST;
        $_SESSION['booking_reference'] = 'COM' . strtoupper(substr(md5(time()), 0, 6));
        
        $this->tripModel->finalizeBooking();

        header('Location: /booking-success');
        exit;
      }
    }

    // Default fallback redirect
    header('Location: /book/1');
    exit;
  }

  // --------------------------------------------------
  //                USER TRIPS UI
  // --------------------------------------------------
  public function userTrips()
  {
    if (!isset($_SESSION['user']['id'])) {
      header('Location: /login');
      exit;
    }
    $userId = $_SESSION['user']['id'];
    $allTrips = $this->tripModel->getAllTrips();
    $userTrips = array_filter($allTrips, function($trip) use ($userId) {
      return isset($trip['user_id']) && $trip['user_id'] == $userId;
    });
    require __DIR__ . '/../views/trips/travel-logs.php';
  }

  // Handle POST from travel log form
  public function createPost()
  {
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_SESSION['user']['id'])) {
      $userId = $_SESSION['user']['id'];
      $given = $_SESSION['user']['given'];
      $surname = $_SESSION['user']['surname'];

      $content = isset($_POST['content']) ? trim($_POST['content']) : '';
      $location = isset($_POST['location']) ? trim($_POST['location']) : '';
      
      // Get images from $_FILES
      $images = isset($_FILES['images']) && !empty($_FILES['images']['name'][0]) ? $_FILES['images'] : null;

      // Handle image uploads directly in controller
      $imagePaths = [];
      $uploadsDir = $_SERVER['DOCUMENT_ROOT'] . '/uploads/';
      
      if (!is_dir($uploadsDir)) {
        mkdir($uploadsDir, 0777, true);
      }

      // Process multiple images
      if ($images && isset($images['name']) && !empty($images['name'])) {
        if (is_array($images['name'])) {
          foreach ($images['name'] as $idx => $imageName) {
            if (empty($imageName) || empty($images['tmp_name'][$idx])) {
              continue;
            }

            if ($images['error'][$idx] !== UPLOAD_ERR_OK || !is_uploaded_file($images['tmp_name'][$idx])) {
              continue;
            }

            $check = @getimagesize($images['tmp_name'][$idx]);
            if ($check === false) {
              continue;
            }

            $allowedFormats = ["jpg", "jpeg", "png", "gif", "webp"];
            $imageFileType = strtolower(pathinfo($imageName, PATHINFO_EXTENSION));
            if (!in_array($imageFileType, $allowedFormats)) {
              continue;
            }

            $maxFileSize = 5 * 1024 * 1024; // 5MB
            if ($images['size'][$idx] > $maxFileSize) {
              continue;
            }

            $filename = uniqid('tripimg_', true) . '.' . $imageFileType;
            $targetPath = $uploadsDir . $filename;
            if (move_uploaded_file($images['tmp_name'][$idx], $targetPath)) {
              $imagePaths[] = '/uploads/' . $filename;
            }
          }
        }
      }

      $imageList = !empty($imagePaths) ? implode(',', $imagePaths) : '';

      // Insert directly into database using existing model connection
      try {
        $stmt = $this->tripModel->getDb()->prepare(
          "INSERT INTO travels (user_id, from_location, to_location, travel_date, booking_date, first_name, last_name, content, activities, images) 
           VALUES (:user_id, :from_location, :to_location, :travel_date, :booking_date, :first_name, :last_name, :content, :activities, :images)"
        );
        
        $stmt->bindValue(':user_id', $userId, \PDO::PARAM_INT);
        $stmt->bindValue(':from_location', $location);
        $stmt->bindValue(':to_location', $location);
        $stmt->bindValue(':travel_date', date('Y-m-d'));
        $stmt->bindValue(':booking_date', date('Y-m-d'));
        $stmt->bindValue(':first_name', $given);
        $stmt->bindValue(':last_name', $surname);
        $stmt->bindValue(':content', $content);
        $stmt->bindValue(':activities', 'travel-log');
        $stmt->bindValue(':images', $imageList);
        
        $stmt->execute();
        
        error_log('Travel post successfully saved with images: ' . $imageList);
      } catch (\Exception $e) {
        error_log('Trip post error: ' . $e->getMessage());
      }

      header('Location: /travel-logs');
      exit;
    }
    header('Location: /travel-logs');
    exit;
  }

}
