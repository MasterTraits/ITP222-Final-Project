<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Compass | Login</title>
  <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
</head>

<body class="bg-[#FFF8F5] font-inter">
  <main class="grid grid-cols-2 h-screen w-full">
    <img src="" alt="Compass Travel Showcase" class="h-full w-full bg-black">
    <article class="p-20 h-full w-full flex flex-col justify-between">
      <img src="../assets/logo.svg" alt="Compass Logo" class="h-10 w-auto self-end">
      <div>
        <h1 class="text-3xl tracking-tighter font-bold mb-2">Sign-in</h1>
        <p class="font-semibold mb-8">Glad to have you back with us!</p>
        <form>
          <label for="email" class="block mb-2 text-lg font-semibold text-[333333]">Email</label>
          <input
            id="email"
            type="email"
            placeholder="e.g. example@ex.com"
            name="email"
            class="w-2/3 h-12 bg-[#F4EEEC] border border-[#E2E8F0] rounded-lg px-4 mb-4 transition duration-300 ease-in-out"
            required>
          <label for="password" class="block mb-2 text-lg font-semibold text-[#333333]">Password</label>
          <div class="relative w-2/3">
            <input
              id="password"
              type="password"
              placeholder="Enter your password"
              name="password"
              class="w-full h-12 bg-[#F4EEEC] border border-[#E2E8F0] rounded-lg px-4 mb-4 transition duration-300 ease-in-out"
              required>
            <button
              type="button"
              id="togglePassword"
              class="absolute right-3 top-3.5 text-gray-500 hover:text-gray-700"
              aria-label="Show password">
              <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" viewBox="0 0 16 16">
                <path d="M10.5 8a2.5 2.5 0 1 1-5 0 2.5 2.5 0 0 1 5 0z" />
                <path d="M0 8s3-5.5 8-5.5S16 8 16 8s-3 5.5-8 5.5S0 8 0 8zm8 3.5a3.5 3.5 0 1 0 0-7 3.5 3.5 0 0 0 0 7z" />
              </svg>
            </button>
          </div>
        </form>
      </div>
      <div class="flex justify-between items-end">
        <p class="text-sm text-[#333333]">Don't have an account? <a href="register.php" class="text-[#FFBF40] font-semibold">Sign-up</a></p>
        <button type="submit" class="bg-[#FFCC66] text-[#333333] py-2 px-5 rounded-lg transition duration-300 ease-in-out hover:bg-[#FFBF40] font-bold tracking-tight">Let's Travel</button>
      </div>
    </article>
  </main>

  <script>
    document.getElementById('togglePassword').addEventListener('click', function() {
      const passwordInput = document.getElementById('password');
      const icon = this.querySelector('svg');

      if (passwordInput.type === 'password') {
        passwordInput.type = 'text';
        icon.innerHTML = '<path d="M13.359 11.238C15.06 9.72 16 8 16 8s-3-5.5-8-5.5a7.028 7.028 0 0 0-2.79.588l.77.771A5.944 5.944 0 0 1 8 3.5c2.12 0 3.879 1.168 5.168 2.457A13.134 13.134 0 0 1 14.828 8c-.058.087-.122.183-.195.288-.335.48-.83 1.12-1.465 1.755-.165.165-.337.328-.517.486l.708.709z"/><path d="M11.297 9.176a3.5 3.5 0 0 0-4.474-4.474l.823.823a2.5 2.5 0 0 1 2.829 2.829l.822.822zm-2.943 1.299.822.822a3.5 3.5 0 0 1-4.474-4.474l.823.823a2.5 2.5 0 0 0 2.829 2.829z"/><path d="M3.35 5.47c-.18.16-.353.322-.518.487A13.134 13.134 0 0 0 1.172 8l.195.288c.335.48.83 1.12 1.465 1.755C4.121 11.332 5.881 12.5 8 12.5c.716 0 1.39-.133 2.02-.36l.77.772A7.029 7.029 0 0 1 8 13.5C3 13.5 0 8 0 8s.939-1.721 2.641-3.238l.708.709zm10.296 8.884-12-12 .708-.708 12 12-.708.708z"/>';
      } else {
        passwordInput.type = 'password';
        icon.innerHTML = '<path d="M10.5 8a2.5 2.5 0 1 1-5 0 2.5 2.5 0 0 1 5 0z"/><path d="M0 8s3-5.5 8-5.5S16 8 16 8s-3 5.5-8 5.5S0 8 0 8zm8 3.5a3.5 3.5 0 1 0 0-7 3.5 3.5 0 0 0 0 7z"/>';
      }
    });
  </script>
</body>






</html>