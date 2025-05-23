<?php
header('Content-Type: application/json');

// In a real application, this would connect to a database
// For this example, we'll use a static array of destinations

// Get filter parameters
$searchTerm = isset($_GET['search']) ? strtolower($_GET['search']) : '';
$priceFilter = isset($_GET['price']) ? $_GET['price'] : 'all';
$durationFilter = isset($_GET['duration']) ? $_GET['duration'] : 'all';
$activityFilter = isset($_GET['activity']) ? $_GET['activity'] : 'all';
$infoFilter = isset($_GET['info']) ? $_GET['info'] : 'all';

// Sample destinations data with more realistic Philippine prices
$destinations = [
    [
        "image" => "cebu.jpg",
        "name" => "Cebu, Lapu-Lapu City",
        "country" => "Philippines",
        "start_date" => "April 10, 2025",
        "end_date" => "April 17, 2025",
        "trip_id" => "214238732",
        "price" => 12500,
        "departure" => "Manila",
        "arrival" => "Cebu",
        "activities" => ["surfing", "kayaking"],
        "info_needs" => ["transportation", "weather", "gear"]
    ],
    [
        "image" => "siargao.jpeg",
        "name" => "Siargao, General Luna",
        "country" => "Philippines",
        "start_date" => "May 5, 2025",
        "end_date" => "May 15, 2025",
        "trip_id" => "214238733",
        "price" => 18900,
        "departure" => "Manila",
        "arrival" => "Siargao",
        "activities" => ["surfing", "kayaking", "fishing"],
        "info_needs" => ["transportation", "weather", "gear", "activity-specific"]
    ],
    [
        "image" => "boracay.jpg",
        "name" => "Boracay, Malay Aklan",
        "country" => "Philippines",
        "start_date" => "June 10, 2025",
        "end_date" => "June 17, 2025",
        "trip_id" => "214238734",
        "price" => 15500,
        "departure" => "Manila",
        "arrival" => "Caticlan",
        "activities" => ["surfing", "kayaking"],
        "info_needs" => ["transportation", "weather", "health"]
    ],
    [
        "image" => "palawan.jpg",
        "name" => "Palawan, Puerto Princesa",
        "country" => "Philippines",
        "start_date" => "July 5, 2025",
        "end_date" => "July 20, 2025",
        "trip_id" => "214238735",
        "price" => 22500,
        "departure" => "Manila",
        "arrival" => "Puerto Princesa",
        "activities" => ["kayaking", "hiking", "fishing"],
        "info_needs" => ["transportation", "health", "gear", "political-info"]
    ],
    [
        "image" => "baguio.jpg",
        "name" => "Baguio City",
        "country" => "Philippines",
        "start_date" => "August 1, 2025",
        "end_date" => "August 5, 2025",
        "trip_id" => "214238736",
        "price" => 8500,
        "departure" => "Manila",
        "arrival" => "Baguio",
        "activities" => ["hiking", "mountain-biking"],
        "info_needs" => ["transportation", "weather", "gear"]
    ],
    [
        "image" => "bohol.jpg",
        "name" => "Bohol, Panglao Island",
        "country" => "Philippines",
        "start_date" => "September 10, 2025",
        "end_date" => "September 20, 2025",
        "trip_id" => "214238737",
        "price" => 16900,
        "departure" => "Manila",
        "arrival" => "Tagbilaran",
        "activities" => ["kayaking", "fishing", "hiking"],
        "info_needs" => ["transportation", "weather", "health"]
    ],
    [
        "image" => "bangkok.jpg",
        "name" => "Bangkok",
        "country" => "Thailand",
        "start_date" => "October 5, 2025",
        "end_date" => "October 12, 2025",
        "trip_id" => "214238738",
        "price" => 28500,
        "departure" => "Manila",
        "arrival" => "Bangkok",
        "activities" => ["hiking"],
        "info_needs" => ["transportation", "health", "political-info"]
    ],
    [
        "image" => "tokyo.jpg",
        "name" => "Tokyo",
        "country" => "Japan",
        "start_date" => "November 15, 2025",
        "end_date" => "November 25, 2025",
        "trip_id" => "214238739",
        "price" => 45000,
        "departure" => "Manila",
        "arrival" => "Tokyo",
        "activities" => ["skiing", "hiking"],
        "info_needs" => ["transportation", "weather", "gear", "political-info"]
    ],
    [
        "image" => "newport.jpg",
        "name" => "Newport Beach, Los Angeles",
        "country" => "United States",
        "start_date" => "June 15, 2025",
        "end_date" => "June 25, 2025",
        "trip_id" => "214238740",
        "price" => 75000,
        "departure" => "Manila",
        "arrival" => "Los Angeles",
        "activities" => ["surfing", "fishing", "kayaking"],
        "info_needs" => ["transportation", "weather", "gear", "political-info"]
    ],
    [
        "image" => "upper-hutt.jpg",
        "name" => "Upper Hutt",
        "country" => "New Zealand",
        "start_date" => "February 10, 2025",
        "end_date" => "February 24, 2025",
        "trip_id" => "214238741",
        "price" => 68000,
        "departure" => "Manila",
        "arrival" => "Wellington",
        "activities" => ["hiking", "mountain-biking", "fishing"],
        "info_needs" => ["transportation", "weather", "gear", "activity-specific"]
    ],
    [
        "image" => "wyoming.jpg",
        "name" => "Wyoming",
        "country" => "United States",
        "start_date" => "December 5, 2025",
        "end_date" => "December 15, 2025",
        "trip_id" => "214238742",
        "price" => 82000,
        "departure" => "Manila",
        "arrival" => "Jackson Hole",
        "activities" => ["skiing", "hiking", "fishing", "mountain-biking"],
        "info_needs" => ["transportation", "weather", "gear", "health", "activity-specific"]
    ]
];

// Filter destinations based on search term and filters
$filteredDestinations = [];

foreach ($destinations as $destination) {
    // Search filter
    $matchesSearch = empty($searchTerm) || 
                    stripos($destination['name'], $searchTerm) !== false || 
                    stripos($destination['country'], $searchTerm) !== false;
    
    // Price filter
    $matchesPrice = true;
    if ($priceFilter === 'budget') {
        $matchesPrice = $destination['price'] < 15000;
    } elseif ($priceFilter === 'mid') {
        $matchesPrice = $destination['price'] >= 15000 && $destination['price'] <= 40000;
    } elseif ($priceFilter === 'luxury') {
        $matchesPrice = $destination['price'] > 40000;
    }
    
    // Duration filter
    $matchesDuration = true;
    $startDate = new DateTime($destination['start_date']);
    $endDate = new DateTime($destination['end_date']);
    $duration = $startDate->diff($endDate)->days;
    
    if ($durationFilter === 'short') {
        $matchesDuration = $duration <= 7;
    } elseif ($durationFilter === 'medium') {
        $matchesDuration = $duration > 7 && $duration <= 14;
    } elseif ($durationFilter === 'long') {
        $matchesDuration = $duration > 14;
    }
    
    // Activity filter
    $matchesActivity = $activityFilter === 'all';
    if (!$matchesActivity && isset($destination['activities'])) {
        foreach ($destination['activities'] as $activity) {
            if ($activity === $activityFilter) {
                $matchesActivity = true;
                break;
            }
        }
    }
    
    // Information needs filter
    $matchesInfo = $infoFilter === 'all';
    if (!$matchesInfo && isset($destination['info_needs'])) {
        foreach ($destination['info_needs'] as $info) {
            if ($info === $infoFilter) {
                $matchesInfo = true;
                break;
            }
        }
    }
    
    // Add to filtered destinations if all conditions match
    if ($matchesSearch && $matchesPrice && $matchesDuration && $matchesActivity && $matchesInfo) {
        $filteredDestinations[] = $destination;
    }
}

// Return JSON response
echo json_encode($filteredDestinations);
?>
