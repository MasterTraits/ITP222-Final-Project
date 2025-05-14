<?php
$env = parse_ini_file(__DIR__ . '/../../../.env');
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Compass | Forgot Password</title>
  <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
  <script src="https://www.google.com/recaptcha/api.js" async defer></script>
  <script>
    function onSubmit(token) {
      document.getElementById("forgot-pass-submit").submit();
    }
  </script>
</head>

<body class="bg-[#FFF8F5] font-inter h-screen w-full flex items-center justify-center">
  <form
    action="/auth/forgot-pass"
    method="post"
    id="forgot-pass-submit"
    class="p-10 sm:p-20 flex flex-col justify-between items-center h-full w-full max-w-xl">
    <img src="assets/logo.svg" alt="Compass Logo" class="h-10 w-auto">
    <div class="w-full">
      <h1 class="text-3xl tracking-tighter font-bold mb-2">Forgot your Password?</h1>
      <p class="font-semibold mb-8">Don't worry! we have you covered :)</p>

      <?php if (isset($_SESSION['error'])): ?>
        <div class="w-full bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
          <?= $_SESSION['error'];
          unset($_SESSION['error']); ?>
        </div>
      <?php endif; ?>

      <?php if (isset($_SESSION['success'])): ?>
        <div class="w-full bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
          <?= $_SESSION['success'];
          unset($_SESSION['success']); ?>
        </div>
      <?php endif; ?>


      <label for="email" class="block mb-2 text-lg font-semibold text-[333333]">Email</label>
      <input
        id="email"
        type="email"
        placeholder="e.g. example@ex.com"
        name="email"
        class="w-full h-12 bg-[#F4EEEC] border border-[#E2E8F0] rounded-lg px-4 mb-4 transition duration-300 ease-in-out"
        aria-label="Email address"
        aria-required="true"
        required>
    </div>
    <div class="w-full">
      <p class="text-sm text-[#333333]">Go back? <a href="login" class="text-[#FFBF40] font-semibold" aria-label="Return to sign in page">Sign-in</a></p>
      <button
        type="submit"
        class="g-recaptcha w-full mt-3 bg-[#FFCC66] text-[#333333] py-2 px-5 rounded-lg transition duration-300 ease-in-out hover:bg-[#FFBF40] font-bold tracking-tight"
        data-sitekey="<?= $env['RECAPTCHA_SITE_KEY'] ?? getenv('RECAPTCHA_SITE_KEY') ?? '' ?>"
        data-callback='onSubmit'
        aria-label="Reset Password button"
      >
        Reset Password
      </button>
    </div>
  </form>
</body>

</html>