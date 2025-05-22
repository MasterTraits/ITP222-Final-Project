<?php
$_SESSION['booking_step'] = 1;

// Prefer POST data, then session, then defaults
function getField($name, $default = '') {
  if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST[$name])) {
    return $_POST[$name];
  }
  global $savedData;
  return isset($savedData[$name]) ? $savedData[$name] : $default;
}

// Get saved data for this step if it exists
$savedData = isset($_SESSION['booking_data']['step1']) ? $_SESSION['booking_data']['step1'] : [];

// Get values for selects and inputs
$transportType = getField('transport_type', 'flight');
$tripType = getField('trip_type', 'roundtrip');
$from = getField('from', 'Manila, PHL');
$country = getField('country', '');
$city = getField('city', '');
$departureDate = getField('departure_date', '');
$returnDate = getField('return_date', '');
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Compass | Book</title>
  <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
  <script src="https://kit.fontawesome.com/2251ecbe6b.js" crossorigin="anonymous"></script>
  <!-- Change to absolute paths starting with / -->
  <link rel="stylesheet" href="/app/styles/animations.css">
  <link rel="stylesheet" href="/app/styles/index.css">
  <style>
    /* Add your styles here */
  </style>
</head>

<body class="scroll-smooth h-screen">
  <header class="w-full bg-[var(--gold)] h-20 flex items-center px-20 text-white mb-10 sm:mb-20">
    <img src="/assets/logo.svg" alt="Compass Logo" class="h-10 w-auto">
  </header>

  <main class="w-full flex flex-col items-center justify-around ">
    <div class="w-full max-w-4xl px-5 sm:px-10 mt-6">
      <div class="flex items-center justify-between mb-8">
        <div class="flex flex-col items-center">
          <div class="w-10 h-10 bg-[var(--blue)] rounded-full flex items-center justify-center text-white font-bold">1</div>
          <span class="text-sm mt-1 text-[var(--blue)] font-medium">Trip Details</span>
        </div>
        <div class="flex-1 h-1 bg-gray-200 mx-2">
          <div class="h-full bg-[var(--blue)] w-0"></div>
        </div>
        <div class="flex flex-col items-center">
          <div class="w-10 h-10 bg-gray-200 rounded-full flex items-center justify-center text-gray-500 font-bold">2</div>
          <span class="text-sm mt-1 text-gray-500">Planning</span>
        </div>
        <div class="flex-1 h-1 bg-gray-200 mx-2"></div>
        <div class="flex flex-col items-center">
          <div class="w-10 h-10 bg-gray-200 rounded-full flex items-center justify-center text-gray-500 font-bold">3</div>
          <span class="text-sm mt-1 text-gray-500">Payment</span>
        </div>
      </div>
    </div>

    <form id="tripForm" action="/book/2" method="POST" class="w-full max-w-4xl px-5 sm:px-10">
      <h1 class="text-3xl pb-6 mb-10 border-b-2 text-[var(--blue)] text-balance">Hi where would you like go?</h1>

      <!-- Custom dropdown for transport type -->
      <div class="custom-dropdown mb-2.5 group-select hover:text-[var(--blue)] text-base" data-value="<?= $transportType ?>">
        <div class="custom-dropdown-selected">
          <?php if ($transportType == 'flight'): ?>
            <i class="fa-solid fa-plane-up"></i> Flight <i class="fa-solid fa-chevron-down"></i>
          <?php else: ?>
            <i class="fa-solid fa-ship"></i> Ship <i class="fa-solid fa-chevron-down"></i>
          <?php endif; ?>
        </div>
        <input type="hidden" name="transport_type" value="<?= htmlspecialchars($transportType) ?>">
        <div class="custom-dropdown-options group-hover/select:text-[var(--text-dark)]">
          <div class="custom-dropdown-option" data-value="flight">
            <i class="fa-solid fa-plane-up"></i> Flight
          </div>
          <div class="custom-dropdown-option" data-value="ship">
            <i class="fa-solid fa-ship"></i> Ship
          </div>
        </div>
      </div>

      <article class="pl-1 grid grid-cols-1 sm:grid-cols-2 gap-4 ">
        <div>
          <label for="from" class="text-sm">From</label>
          <select id="from" name="from" class="border border-[var(--blue)] rounded-lg text-black rounded-full rounded-bl-none py-4 px-4 w-full hover:bg-white *:p-1 transition duration-300 ease-in-out">
            <option value="Manila, PHL" <?= $from == 'Manila, PHL' ? 'selected' : '' ?>>Manila, PHL</option>
            <option value="El Nido, PHL" <?= $from == 'El Nido, PHL' ? 'selected' : '' ?>>El Nido, PHL</option>
            <option value="Boracay, PHL" <?= $from == 'Boracay, PHL' ? 'selected' : '' ?>>Boracay, PHL</option>
            <option value="Panglao, PHL" <?= $from == 'Panglao, PHL' ? 'selected' : '' ?>>Panglao, PHL</option>
            <option value="Wyoming, US" <?= $from == 'Wyoming, US' ? 'selected' : '' ?>>Wyoming, US</option>
            <option value="Los Angeles, US" <?= $from == 'Los Angeles, US' ? 'selected' : '' ?>>Los Angeles, US</option>
            <option value="Upper Hutt, NZL" <?= $from == 'Upper Hutt, NZL' ? 'selected' : '' ?>>Upper Hutt, NZL</option>
          </select>
        </div>
        <div class="w-full">
          <label for="country" class="text-sm">To</label>
          <div class="grid grid-cols-2 gap-2 w-full">
            <select id="country" name="country" class="border border-[var(--blue)] rounded-lg text-black rounded-full rounded-tr-none py-4 px-2 w-full hover:bg-white *:p-1 transition duration-300 ease-in-out">
              <option value="" hidden disabled <?= empty($country) ? 'selected' : '' ?>>Country</option>
              <option value="Philippines" <?= $country == 'Philippines' ? 'selected' : '' ?>>Philippines</option>
              <option value="United States" <?= $country == 'United States' ? 'selected' : '' ?>>United States</option>
              <option value="New Zealand" <?= $country == 'New Zealand' ? 'selected' : '' ?>>New Zealand</option>
            </select>
            <select id="city" name="city" class="border border-[var(--blue)] rounded-lg text-black rounded-full rounded-tr-none py-4 px-4 w-full hover:bg-white *:p-1 transition duration-300 ease-in-out">
              <option value="" hidden disabled <?= empty($city) ? 'selected' : '' ?>>City</option>
              <option value="Manila" data-country="Philippines" <?= $city == 'Manila' ? 'selected' : '' ?>>Manila</option>
              <option value="El Nido" data-country="Philippines" <?= $city == 'El Nido' ? 'selected' : '' ?>>El Nido, Palawan</option>
              <option value="Boracay" data-country="Philippines" <?= $city == 'Boracay' ? 'selected' : '' ?>>Boracay, Aklan</option>
              <option value="Panglao" data-country="Philippines" <?= $city == 'Panglao' ? 'selected' : '' ?>>Panglao, Bohol</option>
              <option value="New York" data-country="United States" <?= $city == 'New York' ? 'selected' : '' ?>>New York</option>
              <option value="Los Angeles" data-country="United States" <?= $city == 'Los Angeles' ? 'selected' : '' ?>>Los Angeles</option>
              <option value="Wyoming" data-country="United States" <?= $city == 'Wyoming' ? 'selected' : '' ?>>Wyoming</option>
              <option value="Upper Hutt" data-country="New Zealand" <?= $city == 'Upper Hutt' ? 'selected' : '' ?>>Upper Hutt</option>
              <option value="Auckland" data-country="New Zealand" <?= $city == 'Auckland' ? 'selected' : '' ?>>Auckland</option>
              <option value="Wellington" data-country="New Zealand" <?= $city == 'Wellington' ? 'selected' : '' ?>>Wellington</option>
            </select>
          </div>
        </div>
      </article>

      <div class="custom-dropdown mt-6 my-2.5 group-select hover:text-[var(--blue)] text-base" data-value="<?= $tripType ?>">
        <div class="custom-dropdown-selected">
          <?php if ($tripType == 'roundtrip'): ?>
            <i class="fa-solid fa-arrows-rotate"></i> Round-trip <i class="fa-solid fa-chevron-down"></i>
          <?php elseif ($tripType == 'oneway'): ?>
            <i class="fa-solid fa-arrow-right"></i> One-way <i class="fa-solid fa-chevron-down"></i>
          <?php else: ?>
            <i class="fa-solid fa-arrows-split-up-and-left"></i> Multi-city <i class="fa-solid fa-chevron-down"></i>
          <?php endif; ?>
        </div>
        <input type="hidden" name="trip_type" value="<?= htmlspecialchars($tripType) ?>">
        <div class="custom-dropdown-options group-hover/select:text-[var(--text-dark)]">
          <div class="custom-dropdown-option" data-value="roundtrip">
            <i class="fa-solid fa-arrows-rotate"></i> Round-trip
          </div>
          <div class="custom-dropdown-option" data-value="oneway">
            <i class="fa-solid fa-arrow-right"></i> One-way
          </div>
          <div class="custom-dropdown-option" data-value="multicity">
            <i class="fa-solid fa-arrows-split-up-and-left"></i> Multi-city
          </div>
        </div>
      </div>
      <div class="grid grid-cols-1 sm:grid-cols-2 gap-2 pl-1">
        <div>
          <label for="departure_date" class="text-sm">Departure</label>
          <input type="date" id="departure_date" name="departure_date" value="<?= htmlspecialchars($departureDate) ?>"
            class="border border-[var(--blue)] rounded-lg text-black rounded-full rounded-bl-none py-3 px-4 w-full hover:bg-white *:p-1 transition duration-300 ease-in-out">
        </div>
        <div>
          <label for="return_date" class="text-sm">Return</label>
          <input type="date" id="return_date" name="return_date" value="<?= htmlspecialchars($returnDate) ?>"
            class="border border-[var(--blue)] rounded-lg text-black rounded-full rounded-tr-none py-3 px-4 w-full hover:bg-white *:p-1 transition duration-300 ease-in-out">
        </div>
      </div>

      <button type="submit" class="bg-[var(--blue)] text-white rounded-full py-4 px-6 mt-10 w-full hover:bg-[var(--gold)] transition duration-300 ease-in-out mb-10">
        Next
      </button>

      <footer>
      </footer>
  </main>
  </form>

  <script>
    document.addEventListener('DOMContentLoaded', function() {
      // Custom dropdown code
      const dropdowns = document.querySelectorAll('.custom-dropdown');

      dropdowns.forEach(dropdown => {
        const selected = dropdown.querySelector('.custom-dropdown-selected');
        const options = dropdown.querySelector('.custom-dropdown-options');
        const optionItems = dropdown.querySelectorAll('.custom-dropdown-option');
        const hiddenInput = dropdown.querySelector('input[type="hidden"]');

        // Toggle dropdown on click
        selected.addEventListener('click', () => {
          options.style.display = options.style.display === 'block' ? 'none' : 'block';
        });

        // Select option
        optionItems.forEach(option => {
          option.addEventListener('click', () => {
            const value = option.getAttribute('data-value');
            const content = option.innerHTML;

            selected.innerHTML = content + ' <i class="fa-solid fa-chevron-down"></i>';
            dropdown.setAttribute('data-value', value);

            // Also update the hidden input
            if (hiddenInput) {
              hiddenInput.value = value;
            }

            options.style.display = 'none';
          });
        });

        // Close dropdown when clicking outside
        document.addEventListener('click', (e) => {
          if (!dropdown.contains(e.target)) {
            options.style.display = 'none';
          }
        });

        // Country-City filtering
        const countrySelect = document.getElementById('country');
        const citySelect = document.getElementById('city');
        const cityOptions = citySelect.querySelectorAll('option');

        function filterCities() {
          const selectedCountry = countrySelect.value;
          let hasSelectedOption = false;

          // Reset city selection if country changes
          if (!citySelect.querySelector('option[data-country="' + selectedCountry + '"][selected]')) {
            citySelect.value = "";
          }

          // Show/hide city options based on selected country
          cityOptions.forEach(option => {
            if (option.value === "" || option.getAttribute('data-country') === selectedCountry) {
              option.style.display = '';
            } else {
              option.style.display = 'none';
            }
          });
        }

        // Initial filtering
        filterCities();

        // Filter cities when country changes
        countrySelect.addEventListener('change', filterCities);
      });
    });
  </script>
</body>

</html>