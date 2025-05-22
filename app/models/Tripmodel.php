<?php

namespace App\Models;

use PDO;

class TripModel 
{
  private $db;

  public function __construct($db) {
    
  }

  public function getAllTrips() {
    // Assuming you have a database connection in $this->db
    $query = "SELECT * FROM trips";
    $stmt = $this->db->prepare($query);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
  }

  public function getTripDetails($trip_id)
  {

  }

}

?>