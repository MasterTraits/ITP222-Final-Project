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
    require __DIR__ . '/../views/user-trips.php';
  }

}
