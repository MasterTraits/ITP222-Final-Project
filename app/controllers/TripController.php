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

    // Get posts data (travel logs with content)
    $allPosts = $this->getAllPosts();
    $userPosts = array_filter($allPosts, function($post) use ($userId) {
      return isset($post['user_id']) && $post['user_id'] == $userId;
    });

    require __DIR__ . '/../views/trips/travel-logs.php';
  }

  // Get all posts from the trips table
  public function getAllPosts()
  {
    try {
      $stmt = $this->tripModel->getDb()->prepare(
        "SELECT t.*, u.given, u.surname 
         FROM trips t 
         LEFT JOIN users u ON t.user_id = u.id 
         ORDER BY t.created_at DESC, t.id DESC"
      );
      $stmt->execute();
      return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    } catch (\Exception $e) {
      error_log('Error fetching posts: ' . $e->getMessage());
      return [];
    }
  }

  // Get posts for a specific user
  public function getUserPosts($userId)
  {
    try {
      $stmt = $this->tripModel->getDb()->prepare(
        "SELECT t.*, u.given, u.surname 
         FROM trips t 
         LEFT JOIN users u ON t.user_id = u.id 
         WHERE t.user_id = :user_id 
         ORDER BY t.created_at DESC, t.id DESC"
      );
      $stmt->bindValue(':user_id', $userId, \PDO::PARAM_INT);
      $stmt->execute();
      return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    } catch (\Exception $e) {
      error_log('Error fetching user posts: ' . $e->getMessage());
      return [];
    }
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
      
      // Validate required content
      if (empty($content)) {
        header('Location: /travel-logs?error=content_required');
        exit;
      }

      // Handle single image upload
      $imagePath = '';
      $uploadsDir = $_SERVER['DOCUMENT_ROOT'] . '/uploads/';
      
      if (!is_dir($uploadsDir)) {
        mkdir($uploadsDir, 0777, true);
      }

      // Process single image if uploaded
      if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
        $image = $_FILES['image'];
        
        // Validate image
        $check = @getimagesize($image['tmp_name']);
        if ($check !== false) {
          $allowedFormats = ["jpg", "jpeg", "png", "gif", "webp"];
          $imageFileType = strtolower(pathinfo($image['name'], PATHINFO_EXTENSION));
          
          if (in_array($imageFileType, $allowedFormats)) {
            $maxFileSize = 5 * 1024 * 1024; // 5MB
            if ($image['size'] <= $maxFileSize) {
              $filename = uniqid('tripimg_', true) . '.' . $imageFileType;
              $targetPath = $uploadsDir . $filename;
              if (move_uploaded_file($image['tmp_name'], $targetPath)) {
                $imagePath = '/uploads/' . $filename;
                error_log('Image uploaded successfully: ' . $imagePath);
              } else {
                error_log('Failed to move uploaded file');
              }
            } else {
              error_log('File size too large: ' . $image['size']);
            }
          } else {
            error_log('Invalid file format: ' . $imageFileType);
          }
        } else {
          error_log('Invalid image file');
        }
      }

      // Insert into trips table
      try {
        $stmt = $this->tripModel->getDb()->prepare(
          "INSERT INTO trips (user_id, given, surname, content, location, images, created_at) 
           VALUES (:user_id, :given, :surname, :content, :location, :images, :created_at)"
        );
        
        $stmt->bindValue(':user_id', $userId, \PDO::PARAM_INT);
        $stmt->bindValue(':given', $given);
        $stmt->bindValue(':surname', $surname);
        $stmt->bindValue(':content', $content);
        $stmt->bindValue(':location', $location);
        $stmt->bindValue(':images', $imagePath);
        $stmt->bindValue(':created_at', date('Y-m-d H:i:s'));
        
        if ($stmt->execute()) {
          error_log('Travel post successfully saved with image: ' . $imagePath);
          header('Location: /travel-logs?success=post_created');
        } else {
          error_log('Database execution failed: ' . json_encode($stmt->errorInfo()));
          header('Location: /travel-logs?error=save_failed');
        }
      } catch (\Exception $e) {
        error_log('Trip post error: ' . $e->getMessage());
        header('Location: /travel-logs?error=save_failed');
      }
      exit;
    }
    header('Location: /travel-logs');
    exit;
  }

}
