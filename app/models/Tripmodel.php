<?php

namespace App\Models;

use PDO;

class TripModel
{
  private $db;

  public function __construct(PDO $db)
  {
    $this->db = $db;
  }

  public function getAllTrips()
  {
    // Assuming you have a database connection in $this->db
    $query = "SELECT * FROM travels";
    $stmt = $this->db->prepare($query);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
  }

  public function finalizeBooking()
  {
    try {
      // Extract booking data from session
      $step1 = $_SESSION['booking_data']['step1'] ?? [];
      $step2 = $_SESSION['booking_data']['step2'] ?? [];
      $step3 = $_SESSION['booking_data']['step3'] ?? [];
      $bookingRef = $_SESSION['booking_reference'];

      // Consolidate for session storage
      $_SESSION['complete_booking'] = [
        'booking_reference' => $bookingRef,
        'booking_date' => date('Y-m-d H:i:s'),
        'step1' => $step1,
        'step2' => $step2,
        'step3' => $step3,
        'status' => 'confirmed'
      ];

      // Build to_location string
      $toLocation = '';
      if (!empty($step1['country'])) {
        $toLocation .= $step1['country'];
        if (!empty($step1['city'])) {
          $toLocation .= ', ' . $step1['city'];
        }
      } else if (!empty($step1['city'])) {
        $toLocation = $step1['city'];
      }

      // Process arrays into strings
      $activities = !empty($step2['activities']) ?
        (is_array($step2['activities']) ? implode(',', $step2['activities']) : $step2['activities']) :
        '';

      $infoNeeds = !empty($step2['info_needs']) ?
        (is_array($step2['info_needs']) ? implode(',', $step2['info_needs']) : $step2['info_needs']) :
        '';

      // Fix: Map departure_date to travel_date according to DB schema
      $departureDate = !empty($step1['departure_date']) ? $step1['departure_date'] : null;

      $this->db->beginTransaction();

      // Debug: Check what columns are available in the table
      $columns = $this->db->query("SHOW COLUMNS FROM travels")->fetchAll(\PDO::FETCH_COLUMN);
      error_log('Available columns in travels table: ' . json_encode($columns));

      $columnMap = [
        'booking_reference' => $bookingRef,
        'user_id' => $_SESSION['user']["id"] ?? null,
        'from_location' => $step1['from'] ?? null,
        'to_location' => $toLocation,
        'travel_date' => $departureDate,
        'return_date' => !empty($step1['return_date']) ? $step1['return_date'] : null,
        'transport_type' => $step1['transport_type'] ?? '1',
        'trip_type' => $step1['trip_type'] ?? '1',
        'adults' => $step2['adults'] ?? 1,
        'children' => $step2['children'] ?? 0,
        'infants' => $step2['infants'] ?? 0,
        'travel_class' => $step2['travel_class'] ?? 'economy',
        'accommodation' => $step2['accommodation'] ?? 'no',
        'activities' => $activities,
        'info_needs' => $infoNeeds,
        'first_name' => $step3['firstName'] ?? null,
        'last_name' => $step3['lastName'] ?? null,
        'email' => filter_var($step3['email'] ?? '', FILTER_SANITIZE_EMAIL),
        'phone' => preg_replace('/[^0-9]/', '', $step3['phone'] ?? ''),
        'payment_method' => $step3['cardType'] ?? 'credit card',
        'total_amount' => 8500.00,
        'booking_date' => date('Y-m-d')
      ];

      // Debug the column mapping
      error_log('Column mapping: ' . json_encode($columnMap));

      // Filter columns and build SQL
      $availableColumns = [];
      $valuePlaceholders = [];
      $boundValues = [];

      foreach ($columnMap as $column => $value) {
        if (in_array($column, $columns)) {
          $availableColumns[] = $column;
          $valuePlaceholders[] = ':' . $column;
          $boundValues[':' . $column] = $value;
        }
      }

      if (count($availableColumns) == 0) {
        throw new \Exception('No matching columns found in travels table');
      }

      $sql = "INSERT INTO travels (" . implode(", ", $availableColumns) . ") 
              VALUES (" . implode(", ", $valuePlaceholders) . ")";

      // Debug the SQL
      error_log('SQL Query: ' . $sql);
      error_log('Bound values: ' . json_encode($boundValues));

      $stmt = $this->db->prepare($sql);

      // Bind parameters
      foreach ($availableColumns as $column) {
        $stmt->bindValue(':' . $column, $columnMap[$column]);
      }

      // Execute the query
      if ($stmt->execute()) {
        $_SESSION['booking_id'] = $this->db->lastInsertId();
        $this->db->commit();
        error_log('Booking successfully saved with ID: ' . $_SESSION['booking_id']);
      } else {
        error_log('Database execution error: ' . json_encode($stmt->errorInfo()));
        $this->db->rollBack();
        throw new \Exception('Failed to save booking: ' . implode(', ', $stmt->errorInfo()));
      }
    } catch (\PDOException $e) {
      error_log('Database error: ' . $e->getMessage());
      if ($this->db->inTransaction()) $this->db->rollBack();
    } catch (\Exception $e) {
      error_log('General error: ' . $e->getMessage());
      if ($this->db->inTransaction()) $this->db->rollBack();
    }
  }

  public function getDb()
  {
    return $this->db;
  }

}
