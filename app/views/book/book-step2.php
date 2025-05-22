<?php
$_SESSION['booking_step'] = 2;

// Retrieve data from previous step if needed
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $_SESSION['booking_data']['step1'] = $_POST;
}

// Get saved data for this step if it exists
$savedData = isset($_SESSION['booking_data']['step2']) ? $_SESSION['booking_data']['step2'] : [];

// Default values or saved values
$adults = isset($savedData['adults']) ? $savedData['adults'] : 1;
$children = isset($savedData['children']) ? $savedData['children'] : 0;
$infants = isset($savedData['infants']) ? $savedData['infants'] : 0;
$travelClass = isset($savedData['travel_class']) ? $savedData['travel_class'] : 'economy';
$accommodation = isset($savedData['accommodation']) ? $savedData['accommodation'] : 'no';

$savedActivities = isset($savedData['activities']) ? $savedData['activities'] : [];
if (!is_array($savedActivities)) {
  $savedActivities = [$savedActivities];
}

$savedInfoNeeds = isset($savedData['info_needs']) ? $savedData['info_needs'] : [];
if (!is_array($savedInfoNeeds)) {
  $savedInfoNeeds = [$savedInfoNeeds];
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Compass | Book - Passenger Details</title>
  <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
  <script src="https://kit.fontawesome.com/2251ecbe6b.js" crossorigin="anonymous"></script>
  <link rel="stylesheet" href="/app/styles/index.css">
  <link rel="stylesheet" href="/app/styles/animations.css">
</head>

<body class="scroll-smooth h-screen">
  <header class="w-full bg-[var(--gold)] h-20 flex items-center px-20 text-white mb-10 sm:mb-20">
    <img src="/assets/logo.svg" alt="Compass Logo" class="h-10 w-auto">
  </header>

  <!-- Progress Indicator -->
  <main class="w-full flex flex-col items-center justify-around pb-10">
    <div class="w-full max-w-4xl px-5 sm:px-10 mt-6">
      <div class="flex items-center justify-between mb-8">
        <div class="flex flex-col items-center">
          <div class="w-10 h-10 bg-[var(--blue)] rounded-full flex items-center justify-center text-white font-bold">
            <i class="fa-solid fa-check"></i>
          </div>
          <span class="text-sm mt-1 text-[var(--blue)] font-medium">Trip Details</span>
        </div>
        <div class="flex-1 h-1 bg-[var(--blue)] mx-2"></div>
        <div class="flex flex-col items-center">
          <div class="w-10 h-10 bg-[var(--blue)] rounded-full flex items-center justify-center text-white font-bold">2</div>
          <span class="text-sm mt-1 text-[var(--blue)] font-medium">Planning</span>
        </div>
        <div class="flex-1 h-1 bg-gray-200 mx-2"></div>
        <div class="flex flex-col items-center">
          <div class="w-10 h-10 bg-gray-200 rounded-full flex items-center justify-center text-gray-500 font-bold">3</div>
          <span class="text-sm mt-1 text-gray-500">Payment</span>
        </div>
      </div>
    </div>

    <form id="passengerForm" action="/book/3" method="POST" class="w-full max-w-4xl px-5 sm:px-10">
      <h1 class="text-3xl pb-6 mb-10 border-b-2 text-[var(--blue)]">Passenger Information</h1>

      <!-- Passenger Count -->
      <div class="mb-8">
        <h2 class="text-xl mb-4 text-[var(--blue)]">How many travelers?</h2>
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-6">
          <!-- Adults -->
          <div class="border border-[var(--blue)] rounded-lg p-4">
            <div class="flex justify-between items-center mb-2">
              <label for="adults" class="text-lg">Adults</label>
              <div class="flex items-center">
                <button type="button" class="counter-btn decrease bg-gray-200 hover:bg-gray-300 w-8 h-8 rounded-full">-</button>
                <input type="number" id="adults" name="adults" value="<?= $adults ?>" min="1" max="9" class="w-8 text-center mx-2" readonly>
                <button type="button" class="counter-btn increase bg-gray-200 hover:bg-gray-300 w-8 h-8 rounded-full">+</button>
              </div>
            </div>
            <p class="text-sm text-gray-500">Age 12+</p>
          </div>

          <!-- Children -->
          <div class="border border-[var(--blue)] rounded-lg p-4">
            <div class="flex justify-between items-center mb-2">
              <label for="children" class="text-lg">Children</label>
              <div class="flex items-center">
                <button type="button" class="counter-btn decrease bg-gray-200 hover:bg-gray-300 w-8 h-8 rounded-full">-</button>
                <input type="number" id="children" name="children" value="<?= $children ?>" min="0" max="9" class="w-8 text-center mx-2" readonly>
                <button type="button" class="counter-btn increase bg-gray-200 hover:bg-gray-300 w-8 h-8 rounded-full">+</button>
              </div>
            </div>
            <p class="text-sm text-gray-500">Age 2-11</p>
          </div>

          <!-- Infants -->
          <div class="border border-[var(--blue)] rounded-lg p-4">
            <div class="flex justify-between items-center mb-2">
              <label for="infants" class="text-lg">Infants</label>
              <div class="flex items-center">
                <button type="button" class="counter-btn decrease bg-gray-200 hover:bg-gray-300 w-8 h-8 rounded-full">-</button>
                <input type="number" id="infants" name="infants" value="<?= $infants ?>" min="0" max="4" class="w-8 text-center mx-2" readonly>
                <button type="button" class="counter-btn increase bg-gray-200 hover:bg-gray-300 w-8 h-8 rounded-full">+</button>
              </div>
            </div>
            <p class="text-sm text-gray-500">Under 2</p>
          </div>
        </div>
      </div>

      <!-- Travel Class -->
      <div class="mb-8">
        <h2 class="text-xl mb-4 text-[var(--blue)]">Travel Class</h2>
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
          <label class="border border-[var(--blue)] rounded-lg p-4 cursor-pointer hover:bg-gray-50">
            <input type="radio" name="travel_class" value="economy" class="hidden" <?= $travelClass == 'economy' ? 'checked' : '' ?>>
            <div class="flex items-center justify-between">
              <span class="text-lg">Economy</span>
              <i class="fa-solid fa-check text-[var(--blue)] opacity-0 radio-check"></i>
            </div>
            <p class="text-sm text-gray-500 mt-2">Standard seating</p>
          </label>

          <label class="border border-[var(--blue)] rounded-lg p-4 cursor-pointer hover:bg-gray-50">
            <input type="radio" name="travel_class" value="business" class="hidden" <?= $travelClass == 'business' ? 'checked' : '' ?>>
            <div class="flex items-center justify-between">
              <span class="text-lg">Business</span>
              <i class="fa-solid fa-check text-[var(--blue)] opacity-0 radio-check"></i>
            </div>
            <p class="text-sm text-gray-500 mt-2">More legroom & amenities</p>
          </label>

          <label class="border border-[var(--blue)] rounded-lg p-4 cursor-pointer hover:bg-gray-50">
            <input type="radio" name="travel_class" value="first" class="hidden" <?= $travelClass == 'first' ? 'checked' : '' ?>>
            <div class="flex items-center justify-between">
              <span class="text-lg">First Class</span>
              <i class="fa-solid fa-check text-[var(--blue)] opacity-0 radio-check"></i>
            </div>
            <p class="text-sm text-gray-500 mt-2">Premium service & comfort</p>
          </label>
        </div>
      </div>

      <!-- Activities Selection -->
      <div class="mb-8">
        <h2 class="text-xl mb-4 text-[var(--blue)]">Tell us what kind of things you'll be doing there</h2>
        <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 gap-3">
          <!-- Activity: Hiking -->
          <label class="border border-[var(--blue)] rounded-lg p-3 cursor-pointer hover:bg-gray-50 flex flex-col items-center transition-all duration-200 relative" for="activity-hiking">
            <input type="checkbox" name="activities[]" value="hiking" class="hidden activity-checkbox" id="activity-hiking"
              <?= in_array('hiking', $savedActivities) ? 'checked' : '' ?>>
            <div class="w-12 h-12 rounded-full <?= in_array('hiking', $savedActivities) ? 'bg-[var(--blue)]' : 'bg-gray-100' ?> flex items-center justify-center mb-2 activity-icon-container">
              <i class="fa-solid fa-person-hiking <?= in_array('hiking', $savedActivities) ? 'text-white' : 'text-gray-600' ?> text-xl"></i>
            </div>
            <span class="text-base">Hiking</span>
            <div class="absolute top-2 right-2 <?= in_array('hiking', $savedActivities) ? '' : 'opacity-0' ?> text-[var(--blue)]">
              <i class="fa-solid fa-check"></i>
            </div>
          </label>

          <!-- Activity: Kayaking -->
          <label class="border border-[var(--blue)] rounded-lg p-3 cursor-pointer hover:bg-gray-50 flex flex-col items-center transition-all duration-200 relative" for="activity-kayaking">
            <input type="checkbox" name="activities[]" value="kayaking" class="hidden activity-checkbox" id="activity-kayaking"
              <?= in_array('kayaking', $savedActivities) ? 'checked' : '' ?>>
            <div class="w-12 h-12 rounded-full <?= in_array('kayaking', $savedActivities) ? 'bg-[var(--blue)]' : 'bg-gray-100' ?> flex items-center justify-center mb-2 activity-icon-container">
              <i class="fa-solid fa-water <?= in_array('kayaking', $savedActivities) ? 'text-white' : 'text-gray-600' ?> text-xl"></i>
            </div>
            <span class="text-base">Kayaking</span>
            <div class="absolute top-2 right-2 <?= in_array('kayaking', $savedActivities) ? '' : 'opacity-0' ?> text-[var(--blue)]">
              <i class="fa-solid fa-check"></i>
            </div>
          </label>

          <!-- Activity: Fishing -->
          <label class="border border-[var(--blue)] rounded-lg p-3 cursor-pointer hover:bg-gray-50 flex flex-col items-center transition-all duration-200 relative" for="activity-fishing">
            <input type="checkbox" name="activities[]" value="fishing" class="hidden activity-checkbox" id="activity-fishing"
              <?= in_array('fishing', $savedActivities) ? 'checked' : '' ?>>
            <div class="w-12 h-12 rounded-full <?= in_array('fishing', $savedActivities) ? 'bg-[var(--blue)]' : 'bg-gray-100' ?> flex items-center justify-center mb-2 activity-icon-container">
              <i class="fa-solid fa-fish <?= in_array('fishing', $savedActivities) ? 'text-white' : 'text-gray-600' ?> text-xl"></i>
            </div>
            <span class="text-base">Fishing</span>
            <div class="absolute top-2 right-2 <?= in_array('fishing', $savedActivities) ? '' : 'opacity-0' ?> text-[var(--blue)]">
              <i class="fa-solid fa-check"></i>
            </div>
          </label>

          <!-- Activity: Mountain Biking -->
          <label class="border border-[var(--blue)] rounded-lg p-3 cursor-pointer hover:bg-gray-50 flex flex-col items-center transition-all duration-200 relative" for="activity-biking">
            <input type="checkbox" name="activities[]" value="mountain_biking" class="hidden activity-checkbox" id="activity-biking"
              <?= in_array('mountain_biking', $savedActivities) ? 'checked' : '' ?>>
            <div class="w-12 h-12 rounded-full <?= in_array('mountain_biking', $savedActivities) ? 'bg-[var(--blue)]' : 'bg-gray-100' ?> flex items-center justify-center mb-2 activity-icon-container">
              <i class="fa-solid fa-bicycle <?= in_array('mountain_biking', $savedActivities) ? 'text-white' : 'text-gray-600' ?> text-xl"></i>
            </div>
            <span class="text-base">Mountain Biking</span>
            <div class="absolute top-2 right-2 <?= in_array('mountain_biking', $savedActivities) ? '' : 'opacity-0' ?> text-[var(--blue)]">
              <i class="fa-solid fa-check"></i>
            </div>
          </label>

          <!-- Activity: Skiing -->
          <label class="border border-[var(--blue)] rounded-lg p-3 cursor-pointer hover:bg-gray-50 flex flex-col items-center transition-all duration-200 relative" for="activity-skiing">
            <input type="checkbox" name="activities[]" value="skiing" class="hidden activity-checkbox" id="activity-skiing"
              <?= in_array('skiing', $savedActivities) ? 'checked' : '' ?>>
            <div class="w-12 h-12 rounded-full <?= in_array('skiing', $savedActivities) ? 'bg-[var(--blue)]' : 'bg-gray-100' ?> flex items-center justify-center mb-2 activity-icon-container">
              <i class="fa-solid fa-person-skiing <?= in_array('skiing', $savedActivities) ? 'text-white' : 'text-gray-600' ?> text-xl"></i>
            </div>
            <span class="text-base">Skiing</span>
            <div class="absolute top-2 right-2 <?= in_array('skiing', $savedActivities) ? '' : 'opacity-0' ?> text-[var(--blue)]">
              <i class="fa-solid fa-check"></i>
            </div>
          </label>

          <!-- Activity: Surfing -->
          <label class="border border-[var(--blue)] rounded-lg p-3 cursor-pointer hover:bg-gray-50 flex flex-col items-center transition-all duration-200 relative" for="activity-surfing">
            <input type="checkbox" name="activities[]" value="surfing" class="hidden activity-checkbox" id="activity-surfing"
              <?= in_array('surfing', $savedActivities) ? 'checked' : '' ?>>
            <div class="w-12 h-12 rounded-full <?= in_array('surfing', $savedActivities) ? 'bg-[var(--blue)]' : 'bg-gray-100' ?> flex items-center justify-center mb-2 activity-icon-container">
              <i class="fa-solid fa-water-ladder <?= in_array('surfing', $savedActivities) ? 'text-white' : 'text-gray-600' ?> text-xl"></i>
            </div>
            <span class="text-base">Surfing</span>
            <div class="absolute top-2 right-2 <?= in_array('surfing', $savedActivities) ? '' : 'opacity-0' ?> text-[var(--blue)]">
              <i class="fa-solid fa-check"></i>
            </div>
          </label>
        </div>
      </div>

      <!-- Accommodation section -->
      <div class="mb-8">
        <h2 class="text-xl mb-4 text-[var(--blue)]">Do you need accommodation?</h2>
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
          <label class="border border-[var(--blue)] rounded-lg p-4 cursor-pointer hover:bg-gray-50">
            <input type="radio" name="accommodation" value="yes" class="hidden" <?= $accommodation == 'yes' ? 'checked' : '' ?>>
            <div class="flex items-center justify-between">
              <div>
                <span class="text-lg flex items-center"><i class="fa-solid fa-hotel mr-2"></i> Include Hotel</span>
                <p class="text-sm text-gray-500 mt-2">Bundle and save up to 20%</p>
              </div>
              <i class="fa-solid fa-check text-[var(--blue)] opacity-0 radio-check"></i>
            </div>
          </label>

          <label class="border border-[var(--blue)] rounded-lg p-4 cursor-pointer hover:bg-gray-50">
            <input type="radio" name="accommodation" value="no" class="hidden" <?= $accommodation == 'no' ? 'checked' : '' ?>>
            <div class="flex items-center justify-between">
              <div>
                <span class="text-lg">No, thanks</span>
                <p class="text-sm text-gray-500 mt-2">I'll book separately</p>
              </div>
              <i class="fa-solid fa-check text-[var(--blue)] opacity-0 radio-check"></i>
            </div>
          </label>
        </div>
      </div>

      <!-- Information Needs -->
      <div class="mb-8">
        <h2 class="text-xl mb-4 text-[var(--blue)]">What kind of information do you want about this trip?</h2>
        <div class="grid grid-cols-2 sm:grid-cols-3 gap-3">
          <!-- Info: Transportation -->
          <label class="border border-[var(--blue)] rounded-lg p-3 cursor-pointer hover:bg-gray-50 flex items-center transition-all duration-200 relative" for="info-transportation">
            <input type="checkbox" name="info_needs[]" value="transportation" class="hidden info-checkbox" id="info-transportation"
              <?= in_array('transportation', $savedInfoNeeds) ? 'checked' : '' ?>>
            <div class="w-10 h-10 rounded-full <?= in_array('transportation', $savedInfoNeeds) ? 'bg-[var(--blue)]' : 'bg-gray-100' ?> flex items-center justify-center mr-3 info-icon-container">
              <i class="fa-solid fa-bus <?= in_array('transportation', $savedInfoNeeds) ? 'text-white' : 'text-gray-600' ?> text-lg"></i>
            </div>
            <span class="text-base flex-grow">Transportation</span>
            <div class="<?= in_array('transportation', $savedInfoNeeds) ? '' : 'opacity-0' ?> text-[var(--blue)]">
              <i class="fa-solid fa-check"></i>
            </div>
          </label>

          <!-- Info: Health -->
          <label class="border border-[var(--blue)] rounded-lg p-3 cursor-pointer hover:bg-gray-50 flex items-center transition-all duration-200 relative" for="info-health">
            <input type="checkbox" name="info_needs[]" value="health" class="hidden info-checkbox" id="info-health"
              <?= in_array('health', $savedInfoNeeds) ? 'checked' : '' ?>>
            <div class="w-10 h-10 rounded-full <?= in_array('health', $savedInfoNeeds) ? 'bg-[var(--blue)]' : 'bg-gray-100' ?> flex items-center justify-center mr-3 info-icon-container">
              <i class="fa-solid fa-kit-medical <?= in_array('health', $savedInfoNeeds) ? 'text-white' : 'text-gray-600' ?> text-lg"></i>
            </div>
            <span class="text-base flex-grow">Health</span>
            <div class="<?= in_array('health', $savedInfoNeeds) ? '' : 'opacity-0' ?> text-[var(--blue)]">
              <i class="fa-solid fa-check"></i>
            </div>
          </label>

          <!-- Info: Weather -->
          <label class="border border-[var(--blue)] rounded-lg p-3 cursor-pointer hover:bg-gray-50 flex items-center transition-all duration-200 relative" for="info-weather">
            <input type="checkbox" name="info_needs[]" value="weather" class="hidden info-checkbox" id="info-weather"
              <?= in_array('weather', $savedInfoNeeds) ? 'checked' : '' ?>>
            <div class="w-10 h-10 rounded-full <?= in_array('weather', $savedInfoNeeds) ? 'bg-[var(--blue)]' : 'bg-gray-100' ?> flex items-center justify-center mr-3 info-icon-container">
              <i class="fa-solid fa-cloud-sun <?= in_array('weather', $savedInfoNeeds) ? 'text-white' : 'text-gray-600' ?> text-lg"></i>
            </div>
            <span class="text-base flex-grow">Weather</span>
            <div class="<?= in_array('weather', $savedInfoNeeds) ? '' : 'opacity-0' ?> text-[var(--blue)]">
              <i class="fa-solid fa-check"></i>
            </div>
          </label>

          <!-- Info: Gear -->
          <label class="border border-[var(--blue)] rounded-lg p-3 cursor-pointer hover:bg-gray-50 flex items-center transition-all duration-200 relative" for="info-gear">
            <input type="checkbox" name="info_needs[]" value="gear" class="hidden info-checkbox" id="info-gear"
              <?= in_array('gear', $savedInfoNeeds) ? 'checked' : '' ?>>
            <div class="w-10 h-10 rounded-full <?= in_array('gear', $savedInfoNeeds) ? 'bg-[var(--blue)]' : 'bg-gray-100' ?> flex items-center justify-center mr-3 info-icon-container">
              <i class="fa-solid fa-suitcase <?= in_array('gear', $savedInfoNeeds) ? 'text-white' : 'text-gray-600' ?> text-lg"></i>
            </div>
            <span class="text-base flex-grow">Gear</span>
            <div class="<?= in_array('gear', $savedInfoNeeds) ? '' : 'opacity-0' ?> text-[var(--blue)]">
              <i class="fa-solid fa-check"></i>
            </div>
          </label>

          <!-- Info: Political Info -->
          <label class="border border-[var(--blue)] rounded-lg p-3 cursor-pointer hover:bg-gray-50 flex items-center transition-all duration-200 relative" for="info-political">
            <input type="checkbox" name="info_needs[]" value="political" class="hidden info-checkbox" id="info-political"
              <?= in_array('political', $savedInfoNeeds) ? 'checked' : '' ?>>
            <div class="w-10 h-10 rounded-full <?= in_array('political', $savedInfoNeeds) ? 'bg-[var(--blue)]' : 'bg-gray-100' ?> flex items-center justify-center mr-3 info-icon-container">
              <i class="fa-solid fa-landmark <?= in_array('political', $savedInfoNeeds) ? 'text-white' : 'text-gray-600' ?> text-lg"></i>
            </div>
            <span class="text-base flex-grow">Political Info</span>
            <div class="<?= in_array('political', $savedInfoNeeds) ? '' : 'opacity-0' ?> text-[var(--blue)]">
              <i class="fa-solid fa-check"></i>
            </div>
          </label>

          <!-- Info: Activity Specific -->
          <label class="border border-[var(--blue)] rounded-lg p-3 cursor-pointer hover:bg-gray-50 flex items-center transition-all duration-200 relative" for="info-activity">
            <input type="checkbox" name="info_needs[]" value="activity" class="hidden info-checkbox" id="info-activity"
              <?= in_array('activity', $savedInfoNeeds) ? 'checked' : '' ?>>
            <div class="w-10 h-10 rounded-full <?= in_array('activity', $savedInfoNeeds) ? 'bg-[var(--blue)]' : 'bg-gray-100' ?> flex items-center justify-center mr-3 info-icon-container">
              <i class="fa-solid fa-person-running <?= in_array('activity', $savedInfoNeeds) ? 'text-white' : 'text-gray-600' ?> text-lg"></i>
            </div>
            <span class="text-base flex-grow">Activity Specific</span>
            <div class="<?= in_array('activity', $savedInfoNeeds) ? '' : 'opacity-0' ?> text-[var(--blue)]">
              <i class="fa-solid fa-check"></i>
            </div>
          </label>
        </div>
      </div>

      <div class="flex gap-4 mt-10">
        <button type="button" id="backBtn" class="bg-gray-200 text-gray-700 rounded-full py-4 px-6 w-full text-center hover:bg-gray-300 transition duration-300 ease-in-out">Back</button>
        <button type="submit" form="passengerForm" class="bg-[var(--blue)] text-white rounded-full py-4 px-6 w-full hover:bg-[var(--gold)] transition duration-300 ease-in-out">Next</button>
      </div>
    </form>

    <footer>
    </footer>
  </main>

  <script>
    document.addEventListener('DOMContentLoaded', function() {
      // Counter buttons functionality
      document.querySelectorAll('.counter-btn').forEach(button => {
        button.addEventListener('click', function() {
          const input = this.parentNode.querySelector('input');
          const currentValue = parseInt(input.value);
          const min = parseInt(input.min);
          const max = parseInt(input.max);

          if (this.classList.contains('increase')) {
            if (currentValue < max) input.value = currentValue + 1;
          } else if (this.classList.contains('decrease')) {
            if (currentValue > min) input.value = currentValue - 1;
          }
        });
      });

      // Radio buttons functionality
      document.querySelectorAll('input[type="radio"]').forEach(radio => {
        radio.addEventListener('change', function() {
          // Hide all check icons in the same group
          const name = this.name;
          document.querySelectorAll(`input[name="${name}"] ~ div .radio-check`).forEach(check => {
            check.style.opacity = '0';
          });

          // Show the check icon for the selected option
          if (this.checked) {
            this.parentNode.querySelector('.radio-check').style.opacity = '1';
          }
        });

        // Set initial state
        if (radio.checked) {
          radio.parentNode.querySelector('.radio-check').style.opacity = '1';
        }
      });

      // Handle activity checkbox selection
      document.querySelectorAll('.activity-checkbox').forEach(checkbox => {
        checkbox.addEventListener('change', function() {
          const label = this.closest('label');
          const checkmark = label.querySelector('.fa-check').parentElement;
          const iconContainer = label.querySelector('.activity-icon-container');

          if (this.checked) {
            label.classList.add('bg-blue-50', 'border-[var(--blue)]');
            iconContainer.classList.add('bg-[var(--blue)]');
            iconContainer.classList.remove('bg-gray-100');
            iconContainer.querySelector('i').classList.add('text-white');
            iconContainer.querySelector('i').classList.remove('text-gray-600');
            checkmark.classList.remove('opacity-0');
          } else {
            label.classList.remove('bg-blue-50', 'border-[var(--blue)]');
            iconContainer.classList.remove('bg-[var(--blue)]');
            iconContainer.classList.add('bg-gray-100');
            iconContainer.querySelector('i').classList.remove('text-white');
            iconContainer.querySelector('i').classList.add('text-gray-600');
            checkmark.classList.add('opacity-0');
          }
        });
      });

      // Initialize activity checkbox UI states
      document.querySelectorAll('.activity-checkbox').forEach(checkbox => {
        if (checkbox.checked) {
          const label = checkbox.closest('label');
          label.classList.add('bg-blue-50', 'border-[var(--blue)]');
        }
      });

      // Handle info needs checkbox selection
      document.querySelectorAll('.info-checkbox').forEach(checkbox => {
        checkbox.addEventListener('change', function() {
          const label = this.closest('label');
          const checkmark = label.querySelector('.fa-check').parentElement;
          const iconContainer = label.querySelector('.info-icon-container');

          if (this.checked) {
            label.classList.add('bg-blue-50', 'border-[var(--blue)]');
            iconContainer.classList.add('bg-[var(--blue)]');
            iconContainer.classList.remove('bg-gray-100');
            iconContainer.querySelector('i').classList.add('text-white');
            iconContainer.querySelector('i').classList.remove('text-gray-600');
            checkmark.classList.remove('opacity-0');
          } else {
            label.classList.remove('bg-blue-50', 'border-[var(--blue)]');
            iconContainer.classList.remove('bg-[var(--blue)]');
            iconContainer.classList.add('bg-gray-100');
            iconContainer.querySelector('i').classList.remove('text-white');
            iconContainer.querySelector('i').classList.add('text-gray-600');
            checkmark.classList.add('opacity-0');
          }
        });
      });

      // Initialize info checkbox UI states
      document.querySelectorAll('.info-checkbox').forEach(checkbox => {
        if (checkbox.checked) {
          const label = checkbox.closest('label');
          label.classList.add('bg-blue-50', 'border-[var(--blue)]');
        }
      });

      // Handle back button click
      document.getElementById('backBtn').addEventListener('click', function() {
        // Get form data for storage
        const formData = new FormData(document.getElementById('passengerForm'));

        // Create hidden form and submit
        const hiddenForm = document.createElement('form');
        hiddenForm.method = 'POST';
        hiddenForm.action = '/book/1'; // Go directly to step 1

        // Store current data as hidden fields
        for (const pair of formData.entries()) {
          const hiddenField = document.createElement('input');
          hiddenField.type = 'hidden';
          hiddenField.name = pair[0];
          hiddenField.value = pair[1];
          hiddenForm.appendChild(hiddenField);
        }

        // Add to body and submit
        document.body.appendChild(hiddenForm);
        hiddenForm.submit();
      });
    });
  </script>
</body>

</html>