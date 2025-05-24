<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Page Not Found | Compass</title>
  <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
  <script src="https://kit.fontawesome.com/2251ecbe6b.js" crossorigin="anonymous"></script>
  <link rel="stylesheet" href="/app/styles/index.css">
  <style>
    :root {
      --blue: #069;
      --gold: #fc6;
      --text-dark: #1f2937;
      --bg-light: #f8fafc;
    }

    .compass-animation {
      animation: spin 20s linear infinite;
    }

    @keyframes spin {
      from {
        transform: rotate(0deg);
      }

      to {
        transform: rotate(360deg);
      }
    }

    .floating {
      animation: floating 3s ease-in-out infinite;
    }

    @keyframes floating {

      0%,
      100% {
        transform: translateY(0px);
      }

      50% {
        transform: translateY(-10px);
      }
    }

    .fade-in {
      animation: fadeIn 1s ease-in;
    }

    @keyframes fadeIn {
      from {
        opacity: 0;
        transform: translateY(20px);
      }

      to {
        opacity: 1;
        transform: translateY(0);
      }
    }
  </style>
</head>

<body class="bg-gradient-to-br from-blue-50 to-amber-50 min-h-screen flex items-center justify-center">
  <div class="container mx-auto px-4 text-center fade-in">
    <!-- Compass Logo Animation -->
    <div class="mb-8">
      <div class="inline-block relative">
        <i class="fa-solid fa-compass text-8xl text-[var(--blue)] compass-animation"></i>
        <div class="absolute -top-2 -right-2">
          <i class="fa-solid fa-question-circle text-2xl text-[var(--gold)] floating"></i>
        </div>
      </div>
    </div>

    <!-- Main Content -->
    <div class="max-w-lg mx-auto">
      <h1 class="text-6xl font-bold text-[var(--text-dark)] mb-4">404</h1>
      <h2 class="text-3xl font-semibold text-[var(--blue)] mb-6">Lost Your Way?</h2>
      <p class="text-lg text-gray-600 mb-8 leading-relaxed">
        Looks like you've wandered off the beaten path! Don't worry, even the best explorers sometimes take a wrong turn.
      </p>

      <!-- Action Buttons -->
      <div class="space-y-4 sm:space-y-0 sm:space-x-4 sm:flex sm:justify-center">
        <a href="/" class="inline-flex items-center px-6 py-3 bg-[var(--blue)] text-white rounded-full font-semibold hover:bg-blue-700 transition-colors duration-300 shadow-lg hover:shadow-xl">
          <i class="fa-solid fa-home mr-2"></i>
          Back to Home
        </a>
        <a href="/destinations" class="inline-flex items-center px-6 py-3 bg-[var(--gold)] text-[var(--text-dark)] rounded-full font-semibold hover:bg-amber-500 transition-colors duration-300 shadow-lg hover:shadow-xl">
          <i class="fa-solid fa-map-location-dot mr-2"></i>
          Explore Destinations
        </a>
      </div>

      <!-- Helpful Links -->
      <div class="mt-12 pt-8 border-t border-gray-200">
        <p class="text-gray-500 mb-4">Or try one of these popular destinations:</p>
        <div class="flex flex-wrap justify-center gap-3">
          <a href="/book/1" class="px-4 py-2 bg-white text-[var(--blue)] rounded-lg border border-blue-200 hover:bg-blue-50 transition-colors duration-200 text-sm font-medium">
            <i class="fa-solid fa-plane mr-1"></i>
            Book a Trip
          </a>
          <a href="/travel-logs" class="px-4 py-2 bg-white text-[var(--blue)] rounded-lg border border-blue-200 hover:bg-blue-50 transition-colors duration-200 text-sm font-medium">
            <i class="fa-solid fa-clipboard mr-1"></i>
            Travel Logs
          </a>
          <a href="/login" class="px-4 py-2 bg-white text-[var(--blue)] rounded-lg border border-blue-200 hover:bg-blue-50 transition-colors duration-200 text-sm font-medium">
            <i class="fa-solid fa-user mr-1"></i>
            Sign In
          </a>
        </div>
      </div>
    </div>

    <!-- Decorative Elements -->
    <div class="absolute top-10 left-10 text-blue-200 text-2xl floating" style="animation-delay: 0.5s;">
      <i class="fa-solid fa-map-pin"></i>
    </div>
    <div class="absolute top-20 right-20 text-amber-200 text-xl floating" style="animation-delay: 1s;">
      <i class="fa-solid fa-plane"></i>
    </div>
    <div class="absolute bottom-20 left-20 text-blue-200 text-lg floating" style="animation-delay: 1.5s;">
      <i class="fa-solid fa-location-dot"></i>
    </div>
    <div class="absolute bottom-10 right-10 text-amber-200 text-2xl floating" style="animation-delay: 2s;">
      <i class="fa-solid fa-suitcase-rolling"></i>
    </div>

    <footer class="bg-[var(--text-dark)] h-50">
      <?php

      $travel = "/";
      $destination = "/destinations";
      $trips = "/travel-logs";

      $fees = "airline-fees.php";
      $lowFare = "low-fare-tips.php";
      $security = "security.php";

      $privacy = "privacy.php";
      $terms = "terms.php";
      ?>

      <!-- Footer Starts -->
      <div style="background-color: #fff6f3; padding: 20px; font-family: Arial, sans-serif; font-size: 14px; color: #333; margin-top: 20px;">
        <div style="display: flex; flex-wrap: wrap; justify-content: space-between; max-width: 1000px; margin: auto;">
          <div style="min-width: 200px; margin-bottom: 20px;">
            <b>Company</b><br>
            <a href="<?php echo $travel; ?>" style="text-decoration: none; color: #000;">Home</a><br>
            <a href="<?php echo $destination; ?>" style="text-decoration: none; color: #000;">Destination</a><br>
            <a href="<?php echo $trips; ?>" style="text-decoration: none; color: #000;">Travel Logs</a>
          </div>

          <div style="min-width: 200px; margin-bottom: 20px;">
            <b>More</b><br>
            <a href="<?php echo $fees; ?>" style="text-decoration: none; color: #000;">Airline fees</a><br>
            <a href="<?php echo $lowFare; ?>" style="text-decoration: none; color: #000;">Low fare tips</a><br>
            <a href="<?php echo $security; ?>" style="text-decoration: none; color: #000;">Security</a>
          </div>

          <div style="min-width: 200px; margin-bottom: 20px;">
            <b>Get the Compass app</b>
          </div>
        </div>

        <hr style="margin-top: 20px; border: none; border-top: 1px solid #ccc;">

        <div style="text-align: center; font-size: 13px; color: #666; margin-top: 10px;">
          &copy; <?php echo date("Y"); ?> Compass |
          <a href="<?php echo $privacy; ?>" style="color: #555;">Privacy</a> |
          <a href="<?php echo $terms; ?>" style="color: #555;">Terms & Condition</a><br><br>

          <span style="font-weight: bold;">Contact us! tel no. 09612312312, <br />Our email: Contact: contact@compass.com</span><br><br>

          English
          <img src="https://upload.wikimedia.org/wikipedia/commons/2/27/PHP-logo.svg" alt="PHP" style="height: 18px; vertical-align: middle;">
        </div>
      </div>
    </footer>
  </div>

  <script>
    // Add some interactive effects
    document.addEventListener('DOMContentLoaded', function() {
      // Random floating animation delays for decorative elements
      const floatingElements = document.querySelectorAll('.floating');
      floatingElements.forEach((element, index) => {
        element.style.animationDelay = `${Math.random() * 2}s`;
      });

      // Add click effect to compass
      const compass = document.querySelector('.compass-animation');
      compass.addEventListener('click', function() {
        this.style.animationDuration = '0.5s';
        setTimeout(() => {
          this.style.animationDuration = '20s';
        }, 1000);
      });
    });
  </script>
</body>

</html>