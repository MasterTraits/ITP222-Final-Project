<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Compass | Reset</title>
  <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
</head>

<body class="bg-[#FFF8F5] font-inter h-screen w-full flex items-center justify-center">
  <form
    action="/auth/reset" method="post"
    class="p-10 sm:p-20 flex flex-col justify-between items-center h-full w-full max-w-xl">
    <img src="assets/logo.svg" alt="Compass Logo" class="h-10 w-auto">
    <div class="w-full">
      <h1 class="text-3xl tracking-tighter font-bold mb-10">Let's reset your password!</h1>
      
      <input type="hidden" name="token" value="<?= htmlspecialchars($_GET['token'] ?? ''); ?>">
      
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


      <label for="new_password" class="block mb-2 text-lg font-semibold text-[333333]">New Password</label>
      <div class="relative w-full">
        <input
          id="new_password"
          type="password"
          placeholder="Enter your new password"
          name="new_password"
          class="w-full h-12 bg-[#F4EEEC] border border-[#E2E8F0] rounded-lg px-4 mb-4 transition duration-300 ease-in-out"
          required>
        <button
          type="button"
          id="toggleNewPassword"
          class="absolute right-3 top-3.5 text-gray-500 hover:text-gray-700"
          aria-label="Show password">
          <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" viewBox="0 0 16 16">
            <path d="M10.5 8a2.5 2.5 0 1 1-5 0 2.5 2.5 0 0 1 5 0z" />
            <path d="M0 8s3-5.5 8-5.5S16 8 16 8s-3 5.5-8 5.5S0 8 0 8zm8 3.5a3.5 3.5 0 1 0 0-7 3.5 3.5 0 0 0 0 7z" />
          </svg>
        </button>
      </div>
      <label for="confirm_password" class="block mb-2 text-lg font-semibold text-[333333]">Confirm Password</label>
      <div class="relative w-full">
        <input
          id="confirm_password"
          type="password"
          placeholder="Confirm your password"
          name="confirm_password"
          class="w-full h-12 bg-[#F4EEEC] border border-[#E2E8F0] rounded-lg px-4 mb-2 transition duration-300 ease-in-out"
          required>
        <button
          type="button"
          id="toggleConfirmPassword"
          class="absolute right-3 top-3.5 text-gray-500 hover:text-gray-700"
          aria-label="Show password">
          <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" viewBox="0 0 16 16">
            <path d="M10.5 8a2.5 2.5 0 1 1-5 0 2.5 2.5 0 0 1 5 0z" />
            <path d="M0 8s3-5.5 8-5.5S16 8 16 8s-3 5.5-8 5.5S0 8 0 8zm8 3.5a3.5 3.5 0 1 0 0-7 3.5 3.5 0 0 0 0 7z" />
          </svg>
        </button>
      </div>
      <div id="password-message" class="text-sm mb-4 hidden"></div>
      <div class="w-full p-4 bg-gray-50 rounded-lg mb-6">
        <h3 class="font-semibold text-sm mb-2">Password Requirements:</h3>
        <ul class="space-y-1 text-sm">
          <li id="req-length" class="flex items-center text-gray-500">
            <span class="inline-block w-4 h-4 mr-2">●</span> At least 8 characters
          </li>
          <li id="req-uppercase" class="flex items-center text-gray-500">
            <span class="inline-block w-4 h-4 mr-2">●</span> At least one uppercase letter (A-Z)
          </li>
          <li id="req-lowercase" class="flex items-center text-gray-500">
            <span class="inline-block w-4 h-4 mr-2">●</span> At least one lowercase letter (a-z)
          </li>
          <li id="req-number" class="flex items-center text-gray-500">
            <span class="inline-block w-4 h-4 mr-2">●</span> At least one number (0-9)
          </li>
          <li id="req-special" class="flex items-center text-gray-500">
            <span class="inline-block w-4 h-4 mr-2">●</span> At least one special character (!@#$%^&*)
          </li>
          <li id="req-match" class="flex items-center text-gray-500">
            <span class="inline-block w-4 h-4 mr-2">●</span> Passwords match
          </li>
        </ul>
      </div>
    </div>
    <div class="w-full">
      <button id="resetButton" type="submit" class="w-full mt-3 bg-[#FFCC66] text-[#333333] py-2 px-5 rounded-lg transition duration-300 ease-in-out hover:bg-[#FFBF40] font-bold tracking-tight disabled:opacity-50" disabled>Reset Password</button>
    </div>
  </form>

  <script>
    // Create a reusable function for toggling password visibility
    function togglePasswordVisibility(toggleBtnId, passwordFieldId) {
      const eyeOpenPath = '<path d="M10.5 8a2.5 2.5 0 1 1-5 0 2.5 2.5 0 0 1 5 0z"/><path d="M0 8s3-5.5 8-5.5S16 8 16 8s-3 5.5-8 5.5S0 8 0 8zm8 3.5a3.5 3.5 0 1 0 0-7 3.5 3.5 0 0 0 0 7z"/>';
      const eyeClosedPath = '<path d="M13.359 11.238C15.06 9.72 16 8 16 8s-3-5.5-8-5.5a7.028 7.028 0 0 0-2.79.588l.77.771A5.944 5.944 0 0 1 8 3.5c2.12 0 3.879 1.168 5.168 2.457A13.134 13.134 0 0 1 14.828 8c-.058.087-.122.183-.195.288-.335.48-.83 1.12-1.465 1.755-.165.165-.337.328-.517.486l.708.709z"/><path d="M11.297 9.176a3.5 3.5 0 0 0-4.474-4.474l.823.823a2.5 2.5 0 0 1 2.829 2.829l.822.822zm-2.943 1.299.822.822a3.5 3.5 0 0 1-4.474-4.474l.823.823a2.5 2.5 0 0 0 2.829 2.829z"/><path d="M3.35 5.47c-.18.16-.353.322-.518.487A13.134 13.134 0 0 0 1.172 8l.195.288c.335.48.83 1.12 1.465 1.755C4.121 11.332 5.881 12.5 8 12.5c.716 0 1.39-.133 2.02-.36l.77.772A7.029 7.029 0 0 1 8 13.5C3 13.5 0 8 0 8s.939-1.721 2.641-3.238l.708.709zm10.296 8.884-12-12 .708-.708 12 12-.708.708z"/>';
      
      document.getElementById(toggleBtnId).addEventListener('click', function() {
        const passwordInput = document.getElementById(passwordFieldId);
        const icon = this.querySelector('svg');
        
        if (passwordInput.type === 'password') {
          passwordInput.type = 'text';
          icon.innerHTML = eyeClosedPath;
        } else {
          passwordInput.type = 'password';
          icon.innerHTML = eyeOpenPath;
        }
      });
    }

    // Initialize both toggle buttons
    togglePasswordVisibility('toggleNewPassword', 'new_password');
    togglePasswordVisibility('toggleConfirmPassword', 'confirm_password');

    // Password validation function
    function validatePasswords() {
      const newPassword = document.getElementById('new_password').value;
      const confirmPassword = document.getElementById('confirm_password').value;
      const submitButton = document.getElementById('resetButton');
      const passwordMessage = document.getElementById('password-message');
      
      // Check if both fields have values
      if (newPassword === '' || confirmPassword === '') {
        submitButton.disabled = true;
        passwordMessage.textContent = 'Please fill in both password fields';
        passwordMessage.className = 'text-sm mb-4 text-amber-600';
        passwordMessage.classList.remove('hidden');
        return;
      }
      
      // Check if passwords match
      if (newPassword !== confirmPassword) {
        submitButton.disabled = true;
        passwordMessage.textContent = 'Passwords do not match';
        passwordMessage.className = 'text-sm mb-4 text-red-600';
        passwordMessage.classList.remove('hidden');
        return;
      }
      
      // Everything is valid
      submitButton.disabled = false;
      passwordMessage.textContent = 'Passwords match';
      passwordMessage.className = 'text-sm mb-4 text-green-600';
      passwordMessage.classList.remove('hidden');
    }

    // Add event listeners to password fields
    document.getElementById('new_password').addEventListener('input', validatePasswords);
    document.getElementById('confirm_password').addEventListener('input', validatePasswords);
    
    // Initial validation
    validatePasswords();
  </script>
</body>

</html>