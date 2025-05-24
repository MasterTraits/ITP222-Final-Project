<?php
$_SESSION['booking_step'] = 3;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $_SESSION['booking_data']['step2'] = $_POST;
}

$savedData = isset($_SESSION['booking_data']['step3']) ? $_SESSION['booking_data']['step3'] : [];
$bookingRef = 'COM' . strtoupper(substr(md5(time()), 0, 6));
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Compass | Book - Payment</title>
  <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
  <script src="https://kit.fontawesome.com/2251ecbe6b.js" crossorigin="anonymous"></script>
  <link rel="stylesheet" href="/app/styles/index.css">
  <link rel="stylesheet" href="/app/styles/animations.css">
</head>

<body class="scroll-smooth h-screen">

  <?php if (!isset($_SESSION['user'])): ?>
    <div class="fixed inset-0 z-[1000] flex items-center justify-center">
      <div class="bg-white rounded-2xl shadow-2xl px-8 py-10 text-center min-w-[320px] max-w-[90vw]">
        <img src="/assets/illustrations/auth.svg" alt="Login Required" class="w-32 h-32 mx-auto mb-4">
        <h1 class="text-2xl font-bold mb-4 text-[var(--blue)]">Login Required</h1>
        <p class="mb-6">You must be logged in to access the booking page.</p>
        <a href="/login" class="bg-[var(--blue)] text-white px-6 py-3 rounded-full hover:bg-[var(--gold)] transition">Go to Login</a>
      </div>
      <div class="fixed top-0 left-0 h-full w-full bg-black opacity-50 -z-1"></div>
    </div>
  <?php endif; ?>

  <!-- Beautiful Responsive Header -->
  <header class="bg-[#fc6] border-b border-yellow-300 shadow-sm sticky top-0 z-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
      <div class="flex justify-between items-center h-16">
        <!-- Logo -->
        <div class="flex-shrink-0">
          <a href="/" class="flex items-center space-x-2">
            <div class="w-10 h-10 bg-gradient-to-br from-[var(--blue)] to-[var(--gold)] rounded-lg flex items-center justify-center">
              <i class="fa-solid fa-compass text-white text-lg"></i>
            </div>
            <span class="text-xl font-bold text-[var(--text-dark)] hidden sm:block">Compass</span>
          </a>
        </div>

        <!-- Desktop Navigation -->
        <div class="hidden md:block">
          <div class="ml-10 flex items-baseline space-x-8">
            <a href="/" class="text-gray-800 hover:text-[var(--blue)] px-3 py-2 rounded-md text-sm font-medium transition-colors duration-200">
              <i class="fa-solid fa-home mr-1"></i>Home
            </a>
            <a href="/book/1" class="text-[var(--blue)] bg-white/30 px-3 py-2 rounded-md text-sm font-medium">
              <i class="fa-solid fa-plane mr-1"></i>Book
            </a>
            <a href="/destinations" class="text-gray-800 hover:text-[var(--blue)] px-3 py-2 rounded-md text-sm font-medium transition-colors duration-200">
              <i class="fa-solid fa-map-location-dot mr-1"></i>Destinations
            </a>
            <?php if (isset($_SESSION['user'])): ?>
              <a href="/travel-logs" class="text-gray-800 hover:text-[var(--blue)] px-3 py-2 rounded-md text-sm font-medium transition-colors duration-200">
                <i class="fa-solid fa-clipboard mr-1"></i>Travel Logs
              </a>
            <?php endif; ?>
          </div>
        </div>

        <!-- User Menu / Auth Buttons (Desktop) -->
        <div class="hidden md:block">
          <div class="ml-4 flex items-center md:ml-6">
            <?php if (!isset($_SESSION['user'])): ?>
              <div class="flex items-center space-x-4">
                <a href="/login" class="text-gray-800 hover:text-[var(--blue)] px-3 py-2 rounded-md text-sm font-medium transition-colors duration-200">
                  Sign In
                </a>
                <a href="/register" class="bg-[var(--blue)] hover:bg-[var(--text-dark)] text-white px-4 py-2 rounded-full text-sm font-medium transition-all duration-200 shadow-md hover:shadow-lg">
                  Sign Up
                </a>
              </div>
            <?php else: ?>
              <div class="relative group">
                <div class="flex items-center space-x-2 px-3 py-2 rounded-md hover:bg-white/20 transition-colors duration-200 cursor-pointer">
                  <i class="fa-solid fa-user text-gray-800"></i>
                  <span class="text-gray-800 font-medium">
                    <?= htmlspecialchars($_SESSION['user']['given'] . ' ' . $_SESSION['user']['surname']) ?>
                  </span>
                  <i class="fa-solid fa-chevron-down text-gray-800 text-xs"></i>
                </div>
                <div class="invisible group-hover:visible absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg py-1 z-50">
                  <a href="/travel-logs" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                    <i class="fa-solid fa-clipboard mr-2"></i>Travel Logs
                  </a>
                  <a href="/logout" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                    <i class="fa-solid fa-sign-out-alt mr-2"></i>Sign Out
                  </a>
                </div>
              </div>
            <?php endif; ?>
          </div>
        </div>

        <!-- Mobile menu button -->
        <div class="md:hidden">
          <button type="button" id="mobile-menu-button" class="bg-white/20 inline-flex items-center justify-center p-2 rounded-md text-gray-800 hover:text-gray-600 hover:bg-white/30 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-[var(--blue)]">
            <span class="sr-only">Open main menu</span>
            <i class="fa-solid fa-bars h-6 w-6"></i>
          </button>
        </div>
      </div>
    </div>

    <!-- Mobile menu, show/hide based on menu state -->
    <div class="md:hidden hidden" id="mobile-menu">
      <div class="px-2 pt-2 pb-3 space-y-1 sm:px-3 bg-[#fc6] border-t border-yellow-300">
        <a href="/" class="text-gray-600 hover:text-[var(--blue)] hover:bg-gray-50 block px-3 py-2 rounded-md text-base font-medium">
          <i class="fa-solid fa-home mr-2"></i>Home
        </a>
        <a href="/book/1" class="text-[var(--blue)] bg-blue-50 block px-3 py-2 rounded-md text-base font-medium">
          <i class="fa-solid fa-plane mr-2"></i>Book
        </a>
        <a href="/destinations" class="text-gray-600 hover:text-[var,--blue)] hover:bg-gray-50 block px-3 py-2 rounded-md text-base font-medium">
          <i class="fa-solid fa-map-location-dot mr-2"></i>Destinations
        </a>
        <?php if (isset($_SESSION['user'])): ?>
          <a href="/travel-logs" class="text-gray-600 hover:text-[var(--blue)] hover:bg-gray-50 block px-3 py-2 rounded-md text-base font-medium">
            <i class="fa-solid fa-clipboard mr-2"></i>Travel Logs
          </a>
        <?php endif; ?>
        
        <!-- Mobile Auth Section -->
        <div class="border-t border-gray-200 pt-4">
          <?php if (!isset($_SESSION['user'])): ?>
            <a href="/login" class="text-gray-600 hover:text-[var(--blue)] hover:bg-gray-50 block px-3 py-2 rounded-md text-base font-medium">
              <i class="fa-solid fa-sign-in-alt mr-2"></i>Sign In
            </a>
            <a href="/register" class="bg-[var(--blue)] text-white block px-3 py-2 rounded-md text-base font-medium mt-2">
              <i class="fa-solid fa-user-plus mr-2"></i>Sign Up
            </a>
          <?php else: ?>
            <div class="px-3 py-2 text-base font-medium text-gray-700 border-b border-gray-200 mb-2">
              <i class="fa-solid fa-user mr-2"></i><?= htmlspecialchars($_SESSION['user']['given'] . ' ' . $_SESSION['user']['surname']) ?>
            </div>
            <a href="/logout" class="text-gray-600 hover:text-[var(--blue)] hover:bg-gray-50 block px-3 py-2 rounded-md text-base font-medium">
              <i class="fa-solid fa-sign-out-alt mr-2"></i>Sign Out
            </a>
          <?php endif; ?>
        </div>
      </div>
    </div>
  </header>

  <!-- Progress Indicator -->
  <main class="flex flex-col items-center justify-center ">
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
          <div class="w-10 h-10 bg-[var(--blue)] rounded-full flex items-center justify-center text-white font-bold">
            <i class="fa-solid fa-check"></i>
          </div>
          <span class="text-sm mt-1 text-[var(--blue)] font-medium">Planning</span>
        </div>
        <div class="flex-1 h-1 bg-[var,--blue)] mx-2"></div>
        <div class="flex flex-col items-center">
          <div class="w-10 h-10 bg-[var(--blue)] rounded-full flex items-center justify-center text-white font-bold">3</div>
          <span class="text-sm mt-1 text-[var(--blue)] font-medium">Payment</span>
        </div>
      </div>
    </div>

    <form id="paymentForm" action="/booking-confirmation" method="POST" class="w-full max-w-4xl px-5 sm:px-10 pb-10">
      <h1 class="text-3xl pb-6 mb-10 border-b-2 text-[var(--blue)]">Complete Your Booking</h1>

      <div class="flex flex-col md:flex-row gap-8">
        <div class="w-full md:w-2/3">
          <!-- Contact Information -->
          <div class="mb-8">
            <h2 class="text-xl mb-4 text-[var(--blue)]">Contact Information</h2>
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
              <div>
                <label for="firstName" class="block text-sm mb-1">First Name</label>
                <input type="text" id="firstName" name="firstName" value="<?= isset($savedData['firstName']) ? $savedData['firstName'] : '' ?>" required
                  class="bg-[var(--bg-input)] border border-[var(--blue)] text-black rounded-lg py-3 px-4 w-full hover:bg-white transition duration-300 ease-in-out">
              </div>
              <div>
                <label for="lastName" class="block text-sm mb-1">Last Name</label>
                <input type="text" id="lastName" name="lastName" value="<?= isset($savedData['lastName']) ? $savedData['lastName'] : '' ?>" required
                  class="bg-[var(--bg-input)] border border-[var(--blue)] text-black rounded-lg py-3 px-4 w-full hover:bg-white transition duration-300 ease-in-out">
              </div>
              <div>
                <label for="email" class="block text-sm mb-1">Email</label>
                <input type="email" id="email" name="email" value="<?= isset($savedData['email']) ? $savedData['email'] : '' ?>" required
                  class="bg-[var(--bg-input)] border border-[var(--blue)] text-black rounded-lg py-3 px-4 w-full hover:bg-white transition duration-300 ease-in-out">
              </div>
              <div>
                <label for="phone" class="block text-sm mb-1">Phone</label>
                <input type="tel" id="phone" name="phone" value="<?= isset($savedData['phone']) ? $savedData['phone'] : '' ?>" required
                  class="bg-[var(--bg-input)] border border-[var,--blue)] text-black rounded-lg py-3 px-4 w-full hover:bg-white transition duration-300 ease-in-out">
              </div>
            </div>
          </div>

          <!-- Payment Information -->
          <div class="mb-8">
            <h2 class="text-xl mb-4 text-[var(--blue)]">Payment Information</h2>

            <div class="mb-4">
              <label class="block text-sm mb-1">Card Type</label>
              <div class="flex gap-4">
                <label class="flex items-center">
                  <input type="radio" name="cardType" value="visa" class="mr-2" <?= (!isset($savedData['cardType']) || $savedData['cardType'] == 'visa') ? 'checked' : '' ?>>
                  <i class="fa-brands fa-cc-visa text-2xl"></i>
                </label>
                <label class="flex items-center">
                  <input type="radio" name="cardType" value="mastercard" class="mr-2" <?= (isset($savedData['cardType']) && $savedData['cardType'] == 'mastercard') ? 'checked' : '' ?>>
                  <i class="fa-brands fa-cc-mastercard text-2xl"></i>
                </label>
                <label class="flex items-center">
                  <input type="radio" name="cardType" value="amex" class="mr-2" <?= (isset($savedData['cardType']) && $savedData['cardType'] == 'amex') ? 'checked' : '' ?>>
                  <i class="fa-brands fa-cc-amex text-2xl"></i>
                </label>
              </div>
            </div>

            <div class="grid grid-cols-1 gap-4">
              <div>
                <label for="cardName" class="block text-sm mb-1">Name on Card</label>
                <input type="text" id="cardName" name="cardName" value="<?= isset($savedData['cardName']) ? $savedData['cardName'] : '' ?>" required
                  class="bg-[var(--bg-input)] border border-[var,--blue)] text-black rounded-lg py-3 px-4 w-full hover:bg-white transition duration-300 ease-in-out">
              </div>
              <div>
                <label for="cardNumber" class="block text-sm mb-1">Card Number</label>
                <input type="text" id="cardNumber" name="cardNumber" value="<?= isset($savedData['cardNumber']) ? $savedData['cardNumber'] : '' ?>" placeholder="xxxx xxxx xxxx xxxx" required maxlength="19"
                  class="bg-[var(--bg-input)] border border-[var,--blue)] text-black rounded-lg py-3 px-4 w-full hover:bg-white transition duration-300 ease-in-out">
              </div>
              <div class="grid grid-cols-2 gap-4">
                <div>
                  <label for="expiry" class="block text-sm mb-1">Expiry Date (MM/YY)</label>
                  <input type="text" id="expiry" name="expiry" value="<?= isset($savedData['expiry']) ? $savedData['expiry'] : '' ?>" placeholder="MM/YY" required maxlength="5"
                    class="bg-[var(--bg-input)] border border-[var,--blue)] text-black rounded-lg py-3 px-4 w-full hover:bg-white transition duration-300 ease-in-out">
                </div>
                <div>
                  <label for="cvc" class="block text-sm mb-1">CVC</label>
                  <input type="text" id="cvc" name="cvc" value="<?= isset($savedData['cvc']) ? $savedData['cvc'] : '' ?>" required maxlength="4"
                    class="bg-[var(--bg-input)] border border-[var,--blue)] text-black rounded-lg py-3 px-4 w-full hover:bg-white transition duration-300 ease-in-out">
                </div>
              </div>
            </div>
          </div>
        </div>

        <!-- Order Summary -->
        <div class="w-full md:w-1/3">
          <div class="bg-gray-50 border border-[var(--blue)] rounded-lg p-6">
            <h2 class="text-xl mb-4 text-[var,--blue)]">Order Summary</h2>

            <div class="border-b border-gray-200 pb-4 mb-4">
              <p class="flex justify-between mb-2">
                <span>Adult x1</span>
                <span>₱8,500</span>
              </p>
              <p class="flex justify-between text-sm text-gray-600 mb-2">
                <span>Base fare</span>
                <span>₱7,000</span>
              </p>
              <p class="flex justify-between text-sm text-gray-600">
                <span>Taxes & fees</span>
                <span>₱1,500</span>
              </p>
            </div>

            <div class="mb-4">
              <p class="flex justify-between font-bold text-lg">
                <span>Total</span>
                <span>₱8,500</span>
              </p>
            </div>

            <div class="bg-blue-50 border border-blue-200 rounded p-3 mb-4">
              <p class="text-sm">
                <i class="fa-solid fa-info-circle text-[var(--blue)] mr-1"></i>
                By completing this booking you agree to our <a href="#" class="text-[var(--blue)]">Terms & Conditions</a> and <a href="#" class="text-[var,--blue)]">Privacy Policy</a>.
              </p>
            </div>

            <div class="mb-1 text-sm text-center text-gray-600">
              <p>Booking Reference: <span class="font-bold"><?= $bookingRef ?></span></p>
            </div>
          </div>
        </div>
      </div>

      <div class="flex gap-4 mt-10">
        <button type="button" id="backBtn" class="bg-gray-200 text-gray-700 rounded-full py-4 px-6 w-full text-center hover:bg-gray-300 transition duration-300 ease-in-out">Back</button>
        <button type="submit" form="paymentForm" class="bg-[var(--blue)] text-white rounded-full py-4 px-6 w-full hover:bg-[var(--gold)] transition duration-300 ease-in-out">Complete Booking</button>
      </div>
    </form>
  </main>

  <footer>
  </footer>

  <script>
    // Mobile menu toggle
    document.getElementById('mobile-menu-button').addEventListener('click', function() {
      const mobileMenu = document.getElementById('mobile-menu');
      mobileMenu.classList.toggle('hidden');
    });

    document.addEventListener('DOMContentLoaded', function() {
      // Format card number with spaces
      document.getElementById('cardNumber').addEventListener('input', function(e) {
        let value = e.target.value.replace(/\s+/g, '').replace(/[^0-9]/gi, '');
        let formattedValue = '';

        for (let i = 0; i < value.length; i++) {
          if (i > 0 && i % 4 === 0) {
            formattedValue += ' ';
          }
          formattedValue += value[i];
        }

        e.target.value = formattedValue;
      });

      // Format expiry date with slash
      document.getElementById('expiry').addEventListener('input', function(e) {
        let value = e.target.value.replace(/\D/g, '');

        if (value.length > 2) {
          value = value.substr(0, 2) + '/' + value.substr(2, 2);
        }

        e.target.value = value;
      });

      // Handle back button click
      document.getElementById('backBtn').addEventListener('click', function() {
        // Get form data for storage
        const formData = new FormData(document.getElementById('paymentForm'));

        // Create hidden form and submit
        const hiddenForm = document.createElement('form');
        hiddenForm.method = 'POST';
        hiddenForm.action = '/book/2'; // Go directly to step 2

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