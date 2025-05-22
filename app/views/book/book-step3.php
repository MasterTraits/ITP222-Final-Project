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


  <header class="w-full bg-[var(--gold)] h-20 flex items-center px-20 text-white mb-10">
    <img src="/assets/logo.svg" alt="Compass Logo" class="h-10 w-auto">
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
        <div class="flex-1 h-1 bg-[var(--blue)] mx-2"></div>
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
                  class="bg-[var(--bg-input)] border border-[var(--blue)] text-black rounded-lg py-3 px-4 w-full hover:bg-white transition duration-300 ease-in-out">
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