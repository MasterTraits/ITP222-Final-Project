<?php
require_once 'app/models/fake-data.php';
require_once 'app/controllers/Auth.php';

use App\controllers\Auth;
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Compass</title>
  <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
  <script src="https://kit.fontawesome.com/2251ecbe6b.js" crossorigin="anonymous"></script>
  <link rel="stylesheet" href="/app/styles/index.css">
  <link rel="stylesheet" href="/app/styles/animations.css">
</head>

<body class="scroll-smooth overflow-x-hidden">
  <!-------------------------------
      REUSABLE NAVIGATION BAR 
  -------------------------------->
  <nav class="rounded-tl-lg rounded-br-lg shadow-lg px-4 py-2 w-[95%] max-w-5xl   
    bg-[var(--bg-transparent-light)] backdrop-blur-md border border-[#E2E8F0] 
    fixed top-5 left-1/2 transform -translate-x-1/2 z-40
    flex items-center justify-between">
    <a href="/" class="flex items-center">
      <img src="assets/logo.svg" alt="Compass Logo" class="h-10 w-auto">
    </a>

    <!-- Mobile menu button -->
    <button id="mobile-menu-button" class="md:hidden text-[var(--text-dark)] focus:outline-none">
      <i class="fa-solid fa-bars text-xl"></i>
    </button>

    <!-- Desktop menu -->
    <aside class="hidden md:flex items-center space-x-6">
      <a href="/" class="font-semibold text-[var(--text-dark)] hover:text-[var(--blue)]">Home</a>
      <a href="/book/1" class="font-semibold text-[var(--text-dark)] hover:text-[var(--blue)]">Book</a>
      <a href="/destinations" class="font-semibold text-[var(--text-dark)] hover:text-[var(--blue)]">Destinations</a>
      <?php if (Auth::check()): ?>
        <a href="/travel-logs" class="font-semibold text-[var(--text-dark)] hover:text-[var,--blue]">Travel Logs</a>
      <?php endif; ?>
      <div class="relative py-1 px-4 rounded-full border flex items-center gap-2 group/account hover:bg-[var(--blue)] hover:text-white transition 400ms ease-out">
        <?php if (!Auth::check()): ?>
          <i class="fa-solid fa-user text-sm"></i> Login
          <div class="invisible absolute bg-[#F4EEEC] p-5 h-70 w-60 rounded-lg leading-tight
          group-hover/account:visible top-9 -right-3 ">
            <div class="w-full pb-4 mb-2 border-b-1 border-[var(--text-dark)]">
              <a href="/login" class="block text-center bg-[var(--blue)] rounded-full py-2 px-5 text-white w-full mb-2 text-semibold">Sign-in</a>
              <p class="text-sm text-[var(--text-dark)]">Not a user yet? <a href="/register" class="text-[var(--blue)]">Sign-up</a></p>
            </div>

            <div class="flex items-center gap-2 mt-5 mb-1 text-[var(--blue)]"><i class="fa-solid fa-gift"></i></i> Travel Vouchers</div>
            <p class="text-sm text-[var(--text-dark)]">Redeem your travel vouchers before they expire</p>
            <div class="flex items-center gap-2 mt-2 mb-1 text-[var(--blue)]"><i class="fa-solid fa-gear"></i> Settings</div>
            <p class="text-sm mb-4 text-[var(--text-dark)]">Manage your notification preferences here</p>
          </div>
        <?php else: ?>
          <i class="fa-solid fa-user text-sm"></i> <?= $_SESSION["user"]["given"] . " " . $_SESSION["user"]["surname"] ?>
          <div class="invisible absolute bg-[#F4EEEC] p-5 h-68 w-60 rounded-lg leading-tight
          group-hover/account:visible top-9 -right-3 ">
            <div class="flex items-center gap-2 mt-5 mb-1 text-[var(--blue)]"><i class="fa-solid fa-gift"></i></i> Travel Vouchers</div>
            <p class="text-sm text-[var(--text-dark)]">Redeem your travel vouchers before they expire</p>
            <div class="flex items-center gap-2 mt-2 mb-1 text-[var(--blue)]"><i class="fa-solid fa-gear"></i> Settings</div>
            <p class="text-sm mb-4 text-[var(--text-dark)]">Manage your notification preferences here</p>
            <div class="w-full pt-4 mb-2 border-t-1 border-[var(--text-dark)]">
              <a href="/logout" class="block text-center bg-[var(--blue)] rounded-full py-2 px-5 text-white w-full mb-2 text-semibold">Log-out</a>
            </div>
          </div>
        <?php endif; ?>
      </div>
    </aside>
  </nav>

  <!-- Mobile menu (hidden by default) -->
  <div id="mobile-menu" class="fixed top-0 left-0 w-full h-screen bg-[var(--bg-transparent-light)] backdrop-blur-lg z-50 hidden flex-col items-center pt-20">
    <button id="close-menu-button" class="absolute top-5 right-5 text-[var(--text-dark)] text-2xl">
      <i class="fa-solid fa-times"></i>
    </button>
    <div class="flex flex-col items-center gap-8 text-xl">
      <a href="/" class="font-semibold text-[var(--text-dark)] hover:text-[var(--blue)]">Home</a>
      <a href="/book/1" class="font-semibold text-[var(--text-dark)] hover:text-[var(--blue)]">Book</a>
      <a href="/destinations" class="font-semibold text-[var,--text-dark)] hover:text-[var(--blue)]">Travel</a>
      <?php if (Auth::check()): ?>
        <a href="/travel-logs" class="font-semibold text-[var(--text-dark)] hover:text-[var,--blue]">Travel Logs</a>
      <?php endif; ?>
      <?php if (!Auth::check()): ?>
        <a href="/login" class="bg-[var(--blue)] text-white rounded-full py-2 px-8 font-semibold">Sign in</a>
        <p class="text-sm">Not a user yet? <a href="/register" class="text-[var(--blue)]">Sign-up</a></p>
      <?php else: ?>
        <a href="/logout" class="bg-[var(--blue)] text-white rounded-full py-2 px-8 font-semibold">Log out</a>
      <?php endif; ?>
    </div>
  </div>

  <!-------------------------------
        HERO LANDING PAGE 
  -------------------------------->
  <section class="carousel-section-wrapper relative min-h-[500px] h-[90vh] md:h-180 text-white flex flex-col justify-between items-center p-5 md:p-10">
    <div class="h-10"></div>
    <div class="carousel-slides-container absolute inset-0">
      <?php
      $itemIndex = 0;
      foreach ($carouselItems as $item) {
        $activeClass = ($itemIndex === 0) ? 'active opacity-100 visible' : 'opacity-0 invisible';
      ?>
        <div class="carousel-item absolute inset-0 transition-opacity duration-500 ease-in-out <?= $activeClass ?> flex flex-col justify-between items-center p-10 box-border">
          <div class="absolute inset-0 bg-[linear-gradient(180deg,rgba(0,0,0,0)_58.03%,rgba(0,0,0,0.5)_100%),linear-gradient(0deg,rgba(0,0,0,0.25)_0%,rgba(0,0,0,0.25)_100%)] shadow-[inset_0px_0px_100px_10px_rgba(0,0,0,0.5)] -z-1"></div>
          <?php if (isset($item['image'])): ?>
            <img src="<?= htmlspecialchars($item['image']) ?>" alt="<?= htmlspecialchars($item['title'] ?? 'Carousel image') ?>" class="absolute inset-0 object-cover object-bottom w-full min-w-full h-full -z-2">
          <?php endif; ?>

          <article class="slide-content max-w-5xl w-full relative z-10 mx-auto flex flex-col items-center justify-center text-center md:items-start md:text-left mt-auto mb-auto">
            <?php if (isset($item['title'])): ?>
              <h1 class="tracking-widest text-5xl font-light mb-4 text-shadow-xl"><?= htmlspecialchars($item['title']) ?></h1>
            <?php endif; ?>
            <?php if (isset($item['description'])): ?>
              <p class="w-full md:w-1/2 text-shadow-2xl"><?= nl2br(htmlspecialchars($item['description'])) ?></p>
            <?php endif; ?>
          </article>
        </div>
      <?php
        $itemIndex++;
      }
      ?>
    </div>
    <article class="carousel-controls-indicators absolute bottom-0 left-1/2 transform -translate-x-1/2 z-20 w-full max-w-5xl pb-30 flex justify-between items-center">
      <a href="/travel" class="explore-link flex items-center gap-3 bg-[var(--bg-transparent-dark)] backdrop-blur-md rounded-full p-2 pr-4 font-light group-destinations hover:bg-gradient-to-r from-[var(--blue)] to-[var(--gold)] transition animated-gradient-hover">
        <i class="fa-solid fa-arrow-up transform -rotate-55 bg-white text-black size-8 text-center p-2 rounded-full"></i>
        <p>Explore Destinations</p>
      </a>

      <div class="flex gap-2">
        <button class="carousel-control-btn prev bg-[var(--bg-transparent-dark)] size-11 rounded-full cursor-pointer flex items-center justify-center text-white text-2xl p-0">
          <i class="fa-solid fa-chevron-left"></i>
        </button>
        <button class="carousel-control-btn next bg-[var(--bg-transparent-dark)] size-11 rounded-full cursor-pointer flex items-center justify-center text-white text-2xl p-0">
          <i class="fa-solid fa-chevron-right"></i>
        </button>
      </div>
    </article>
    <div class="carousel-previews absolute right-4 top-1/2 transform -translate-y-1/2 z-20 flex flex-col gap-y-2">
      <?php
      // Generate preview indicators using another loop
      $previewIndex = 0;
      foreach ($carouselItems as $item) {
        // Add active class to the first preview only - this will be used by JavaScript
        $activeClass = ($previewIndex === 0) ? 'active' : '';
      ?>
        <div class="carousel-preview-item relative w-30 h-20 border-2 border-transparent rounded-lg overflow-hidden cursor-pointer transition-all duration-300 ease-in-out <?= $activeClass ?>" data-slide-to="<?= $previewIndex ?>">
          <?php if (isset($item['image'])): ?>
            <img src="<?= htmlspecialchars($item['image']) ?>" alt="<?= htmlspecialchars($item['title'] ?? 'Preview image') ?>" class="w-full h-full object-cover">
          <?php endif; ?>
          <div class="preview-overlay absolute inset-0 bg-black/50 flex items-center justify-center transition-opacity duration-300 ease-in-out pointer-events-none">
            <?php if (isset($item['title'])): ?>
              <div class="text-white text-xs font-bold text-center px-1.5 overflow-hidden text-ellipsis whitespace-nowrap"><?= htmlspecialchars($item['title']) ?></div>
            <?php endif; ?>
          </div>
        </div>
      <?php
        $previewIndex++;
      }
      ?>
    </div>
    <div class="absolute top-1/2 left-5 transform -translate-y-1/2 text-xl shadow-2xl hidden sm:flex flex-col gap-6 z-40">
      <i class="fa-brands fa-facebook"></i>
      <i class="fa-brands fa-instagram"></i>
      <i class="fa-brands fa-x-twitter"></i>
    </div>
    <!-------------------------------
            FORMS HANDLING
    -------------------------------->
    <form action="/book/1" method="POST" class="absolute flex flex-col md:flex-row md:items-center justify-around gap-4 bg-[var(--bg-transparent-light)] backdrop-blur-md w-[95%] max-w-5xl text-black -bottom-[8rem] md:-bottom-13 p-4 rounded-tl-lg rounded-br-lg shadow-lg z-10">
      <div class="w-full">
        <!-- Custom dropdown for transport type -->
        <div class="custom-dropdown group-select hover:text-[var(--blue)] text-base" data-value="flight">
          <div class="custom-dropdown-selected" data-value="flight">
            <i class="fa-solid fa-plane-up"></i> Flight <i class="fa-solid fa-chevron-down"></i>
          </div>
          <input type="hidden" name="transport_type">
          <div class="custom-dropdown-options group-hover/select:text-[var(--text-dark)]">
            <div class="custom-dropdown-option" data-value="flight">
              <i class="fa-solid fa-plane-up"></i> Flight
            </div>
            <div class="custom-dropdown-option" data-value="ship">
              <i class="fa-solid fa-ship"></i> Ship
            </div>
          </div>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-2 sm:items-center">
          <div>
            <label for="from" class="text-sm">From</label>
            <select
              id="from"
              name="from"
              class="bg-[var(--bg-input)] border border-[var(--blue)] text-black rounded-full rounded-bl-none py-3 px-4 w-full hover:bg-white *:p-1 transition duration-300 ease-in-out">
              <option value="Manila, PHL" selected>Manila, PHL</option>
              <option value="El Nido, PHL">El Nido, PHL</option>
              <option value="Boracay, PHL">Boracay, PHL</option>
              <option value="Panglao, PHL">Panglao, PHL</option>
              <option value="Wyoming, US">Wyoming, US</option>
              <option value="Los Angeles, US">Los Angeles, US</option>
              <option value="Upper Hutt, NZL">Upper Hutt, NZL</option>
            </select>
          </div>
          <div class="w-full">
            <label for="country" class="text-sm">To</label>
            <div class="grid grid-cols-2 gap-2 w-full">
              <select id="country" name="country" class="bg-[var(--bg-input)] border border-[var(--blue)] text-black rounded-full rounded-tr-none py-4 px-2 w-full hover:bg-white *:p-1 transition duration-300 ease-in-out">
                <option value="" hidden disabled>Country</option>
                <option value="Philippines">Philippines</option>
                <option value="United States">United States</option>
                <option value="New Zealand">New Zealand</option>
              </select>
              <select id="city" name="city" class="bg-[var(--bg-input)] border border-[var(--blue)] text-black rounded-full rounded-tr-none py-4 px-4 w-full hover:bg-white *:p-1 transition duration-300 ease-in-out">
                <option value="" hidden disabled>City</option>
                <option value="Manila" data-country="Philippines">Manila</option>
                <option value="El Nido" data-country="Philippines">El Nido, Palawan</option>
                <option value="Boracay" data-country="Philippines">Boracay, Aklan</option>
                <option value="Panglao" data-country="Philippines">Panglao, Bohol</option>
                <option value="New York" data-country="United States">New York</option>
                <option value="Los Angeles" data-country="United States">Los Angeles</option>
                <option value="Wyoming" data-country="United States">Wyoming</option>
                <option value="Upper Hutt" data-country="New Zealand">Upper Hutt</option>
                <option value="Auckland" data-country="New Zealand">Auckland</option>
                <option value="Wellington" data-country="New Zealand">Wellington</option>
              </select>
            </div>
          </div>
        </div>
      </div>
      <div class="w-full">
        <div class="custom-dropdown group-select hover:text-[var(--blue)] text-base" data-value="roundtrip">
          <div class="custom-dropdown-selected" data-value="roundtrip">
            <i class="fa-solid fa-arrows-rotate"></i> Round-trip <i class="fa-solid fa-chevron-down"></i>
          </div>
          <input type="hidden" name="trip_type">
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
            <input
              type="date"
              id="departure_date"
              name="departure_date"
              class="bg-[var(--bg-input)] border border-[var(--blue)] text-black rounded-full rounded-bl-none py-3 px-4 w-full">
          </div>
          <div>
            <label for="return_date" class="text-sm">Return</label>
            <input
              type="date"
              id="return_date"
              name="return_date"
              class="bg-[var(--bg-input)] border border-[var(--blue)] text-black rounded-full rounded-tr-none py-3 px-4 w-full">
          </div>
        </div>
      </div>
      <div class="md:self-end">
        <button
          type="submit"
          class="bg-[var(--gold)] text-black rounded-full mt-4 md:mt-1 py-3 px-5 font-semibold hover:bg-[var(--gold)] text-nowrap w-full">
          Let's Travel!
        </button>
      </div>
    </form>
  </section>

  <!-------------------------------
        UNIQUE SELLING POINT 
  -------------------------------->
  <?php if (!Auth::check()): ?>
    <section class="w-full flex flex-col items-center mb-30">
      <div class="h-[12rem] md:h-45"></div>
      <article class="max-w-5xl grid grid-cols-1 md:grid-cols-3 gap-4 px-4">
        <div class="md:col-span-2">
          <h2 class="text-3xl tracking-tighter font-bold text-[var(--blue)]">Guiding you to a memorable trip.</h2>
          <p class="text-[var(--text-dark)] mt-8 font-semibold text-balance">
            We believe every Filipino deserves to explore the beauty of our 7,641 islands without emptying their wallets.
            We negotiate directly with local businesses to bring you authentic experiences at prices
            that respect your budget. Whether you're planning a weekend getaway or an extended island-hopping adventure,
            let Compass be your guide to discovering the Philippines' treasures affordably.
          </p>
        </div>
        <img
          src="assets/campfire.svg"
          alt="Compass Logo"
          class="h-[80%] w-auto mx-auto md:col-span-1 transform -scale-x-100">
      </article>
      <article class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-4 max-w-5xl w-full px-4 mt-8">
        <div class="w-full rounded-3xl border border-[var(--hero-border)] p-6 *:leading-tight">
          <div class="flex *:-mr-2 mb-4">
            <?php foreach ($logos as $logo) { ?>
              <img src="<?= $logo ?>" alt="" class="h-10 w-10 bg-[var(--blue)] rounded-full border object-cover object-center">
            <?php } ?>
          </div>
          <h4 class="text-lg font-semibold tracking-tight mb-1">Save when you compare.</h4>
          <p class="font-light">More deals. More sites. One search</p>
        </div>
        <div class="w-full rounded-3xl border border-[var(--hero-border)] p-6 *:leading-tight">
          <div class="flex *:-mr-2 mb-4">
            <?php foreach ($random_people as $person) { ?>
              <img src="<?= $person ?>" alt="" class="h-10 w-10 bg-[var(--blue)] rounded-full border object-cover object-center">
            <?php } ?>
          </div>
          <h4 class="text-lg font-semibold tracking-tight mb-1">1,500,000+</h4>
          <p class="font-light">Searches at our site!</p>
        </div>
        <div class="w-full rounded-3xl border border-[var(--hero-border)] p-6 *:leading-tight">
          <div class="flex mb-4 *:text-2xl *:text-[var(--gold)] my-2">
            <i class="fa-solid fa-star"></i>
            <i class="fa-solid fa-star"></i>
            <i class="fa-solid fa-star"></i>
            <i class="fa-solid fa-star"></i>
            <i class="fa-solid fa-star"></i>
          </div>
          <h4 class="text-lg font-semibold tracking-tight mb-1">Explorers love us.</h4>
          <p class="font-light">50k+ ratings in our app</p>
        </div>
      </article>
    </section>
  <?php endif; ?>

  <!-------------------------------
        TRAVEL DESTINATIONS 
  -------------------------------->
  <section class="bg-[#F4EEEC] relative min-h-[500px] md:h-185 w-full flex flex-col items-center px-4 py-12 md:py-0">
    <h3 class="mt-25 mb-10 text-[27px] tracking-tight text-[var(--blue)]">Discover what we offer!</h3>

    <article class="flex gap-6 max-w-5xl overflow-x-auto flex-nowrap p-5 scroll-smooth">
      <?php foreach ($destinations as $destination) { ?>
        <a
          href="/travel/palawan"
          class="w-70 shrink-0 rounded-xl bg-[var(--background)] border border-[var(--hero-border)] hover:scale-105">
          <img src="assets/login-sample.jpeg" alt="Philippines" class="rounded-t-lg h-40 w-full object-fit">
          <div class="p-3 tracking-tight flex flex-col ">
            <p class="text-lg tracking-tight font-semibold -mb-1"><?= $destination['package'] ?></p>
            <p class="tracking-tight mb-2"><?= $destination['location'] ?></p>
            <div class="text-sm py-1 px-2 rounded-lg <?= ($destination['rating'] > 8) ? "border-2 border-[var(--blue)]" : (($destination['rating'] > 5) ? "border-2 border-[var(--blue)]" : "bg-[var(--hero-border)]") ?> mb-2">
              <?= $destination['rating'] ?>/10 Recommended (<?= $destination['users_rated'] ?>)
            </div>
            <div class="text-sm flex items-center gap-2.5">
              <i class="fa-regular fa-building text-xl mb-3"></i>
              <?= $destination['star'] ?> star
            </div>
            <div class="text-sm flex items-center gap-2 mb-8 "><i class="fa-solid fa-plane-departure "></i>
              <?= $destination['from'] ?> - <?= $destination['to'] ?>
            </div>
            <p class="inline-block text-sm text-[var(--blue)] p-2 bg-[var(--gold)] font-semibold self-end">Bundle Save</p>
            <div class="flex items-center gap-1 text-xl mt-3 my-2 self-end">
              ₱<?= number_format($destination['price'], 0, '.', ',') ?>
              <i class="fa-solid fa-circle-info text-neutral-400"></i>
              <s class="text-neutral-400">₱<?= number_format($destination['original_price'], 0, '.', ',') ?></s>
            </div>
          </div>
        </a>
      <?php } ?>
    </article>
    <div></div>
  </section>

  <!-------------------------------
      LATEST EXPLORATION UPDATES 
  -------------------------------->
  <section class="w-full flex flex-col items-center my-40">
    <h2 class="text-3xl text-left tracking-tight font-bold text-[var(--blue)] mb-5 w-full max-w-5xl">Hear our Stories.</h2>
    <article class="grid grid-cols-4 gap-4 p-4 w-full max-w-5xl">
      <div class="col-span-3 row-span-3 relative overflow-hidden rounded-lg">
        <img src="assets/login-sample.webp" alt="Description of the image" class="w-full h-100 object-cover">
        <p class="absolute bottom-0 left-0 w-full p-4 text-white bg-[var(--bg-transparent-dark)] bg-opacity-50">
          Caption here
        </p>
      </div>

      <div class="col-start-4 flex flex-col gap-4">
        <div class="relative rounded-lg w-full h-28 overflow-hidden">
          <img src="" class="w-full h-full object-cover brightness-75">
          <p class="absolute bottom-0 left-0 w-full p-2 text-white bg-[var(--bg-transparent-dark)]">Caption here</p>
        </div>
        <div class="relative rounded-lg w-full h-28 overflow-hidden">
          <img src="" class="w-full h-full object-cover brightness-75">
          <p class="absolute bottom-0 left-0 w-full p-2 text-white bg-[var(--bg-transparent-dark)]">Caption here</p>
        </div>
        <div class="relative rounded-lg w-full h-28 overflow-hidden">
          <img src="" class="w-full h-full object-cover brightness-75">
          <p class="absolute bottom-0 left-0 w-full p-2 text-white bg-[var(--bg-transparent-dark)]">Caption here</p>
        </div>
      </div>
    </article>
  </section>

  <footer class="bg-[var(--text-dark)] h-50">
    <?php

    $travel = "travel.php";
    $destination = "destination.php";
    $trips = "your-trips.php";

    $fees = "airline-fees.php";
    $lowFare = "low-fare-tips.php";
    $security = "security.php";

    $privacy = "privacy.php";
    $terms = "terms.php";
    ?>

    <!-- Footer Starts -->
    <div style="background-color: #fff6f3; padding: 20px; font-family: Arial, sans-serif; font-size: 14px; color: #333;">
      <div style="display: flex; flex-wrap: wrap; justify-content: space-between; max-width: 1000px; margin: auto;">
        <div style="min-width: 200px; margin-bottom: 20px;">
          <b>Company</b><br>
          <a href="<?php echo $travel; ?>" style="text-decoration: none; color: #000;">Travel</a><br>
          <a href="<?php echo $destination; ?>" style="text-decoration: none; color: #000;">Destination</a><br>
          <a href="<?php echo $trips; ?>" style="text-decoration: none; color: #000;">Your Trips</a>
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

        <span style="font-weight: bold;">compass.com</span><br><br>
        English
        <img src="https://upload.wikimedia.org/wikipedia/commons/2/27/PHP-logo.svg" alt="PHP" style="height: 18px; vertical-align: middle;">
      </div>
    </div>
  </footer>

  <script>
    document.addEventListener('DOMContentLoaded', function() {
      // Carousel logic
      const carouselSection = document.querySelector('.carousel-section-wrapper');
      const items = carouselSection.querySelectorAll('.carousel-item');
      const prevButton = carouselSection.querySelector('.carousel-control-btn.prev');
      const nextButton = carouselSection.querySelector('.carousel-control-btn.next');
      const previewsContainer = carouselSection.querySelector('.carousel-previews');
      const previews = previewsContainer.querySelectorAll('.carousel-preview-item');

      let currentIndex = 0;
      const totalItems = items.length;

      // Find the index of the initially active item/preview set by PHP
      let initialActiveIndex = 0;
      items.forEach((item, index) => {
        if (item.classList.contains('active')) {
          initialActiveIndex = index;
        }
      });
      currentIndex = initialActiveIndex;

      // Ensure the corresponding preview is also marked active initially
      if (previews[currentIndex]) {
        previews[currentIndex].classList.add('active');
      }

      // Function to show a specific slide and update previews
      function showSlide(index) {
        if (index >= totalItems) {
          index = 0;
        } else if (index < 0) {
          index = totalItems - 1;
        }
        items[currentIndex].classList.remove('active', 'opacity-100', 'visible');
        items[currentIndex].classList.add('opacity-0', 'invisible');
        if (previews[currentIndex]) {
          previews[currentIndex].classList.remove('active');
          previews[currentIndex].classList.remove('border-white', 'scale-105', 'shadow-lg', 'shadow-white/50');
          previews[currentIndex].classList.add('border-transparent');
          const overlay = previews[currentIndex].querySelector('.preview-overlay');
          if (overlay) overlay.classList.remove('opacity-0');
          if (overlay) overlay.classList.add('opacity-100');
        }
        items[index].classList.add('active', 'opacity-100', 'visible');
        items[index].classList.remove('opacity-0', 'invisible');
        if (previews[index]) {
          previews[index].classList.add('active');
          previews[index].classList.add('border-white', 'scale-105', 'shadow-lg', 'shadow-white/50');
          previews[index].classList.remove('border-transparent');
          const overlay = previews[index].querySelector('.preview-overlay');
          if (overlay) overlay.classList.add('opacity-0');
          if (overlay) overlay.classList.remove('opacity-100');
        }
        currentIndex = index;
      }

      prevButton.addEventListener('click', () => {
        showSlide(currentIndex - 1);
      });

      nextButton.addEventListener('click', () => {
        showSlide(currentIndex + 1);
      });

      previews.forEach(preview => {
        preview.addEventListener('click', (event) => {
          const slideIndex = parseInt(event.currentTarget.getAttribute('data-slide-to'), 10);
          showSlide(slideIndex);
        });
      });

      // Intersection Observer for fade-in effects
      const fadeInElements = document.querySelectorAll('.fade-in-element');
      const observerOptions = {
        root: null,
        rootMargin: '0px',
        threshold: 0.1
      };
      const observer = new IntersectionObserver((entries, observer) => {
        entries.forEach(entry => {
          if (entry.isIntersecting) {
            entry.target.classList.add('is-visible');
            observer.unobserve(entry.target);
          }
        });
      }, observerOptions);
      fadeInElements.forEach(element => {
        observer.observe(element);
      });

      // Mobile menu toggle
      const mobileMenuButton = document.getElementById('mobile-menu-button');
      const closeMenuButton = document.getElementById('close-menu-button');
      const mobileMenu = document.getElementById('mobile-menu');

      if (mobileMenuButton && mobileMenu && closeMenuButton) {
        mobileMenuButton.addEventListener('click', () => {
          mobileMenu.style.display = 'flex';
          document.body.style.overflow = 'hidden';
        });

        closeMenuButton.addEventListener('click', () => {
          mobileMenu.style.display = 'none';
          document.body.style.overflow = 'auto';
        });
      }

      window.addEventListener('resize', function() {
        if (window.innerWidth >= 768 && mobileMenu) {
          mobileMenu.style.display = 'none';
          document.body.style.overflow = 'auto';
        }
      });

      // Custom dropdown code
      const dropdowns = document.querySelectorAll('.custom-dropdown');
      let openDropdown = null;

      dropdowns.forEach(dropdown => {
        const selected = dropdown.querySelector('.custom-dropdown-selected');
        const options = dropdown.querySelector('.custom-dropdown-options');
        const optionItems = dropdown.querySelectorAll('.custom-dropdown-option');
        const hiddenInput = dropdown.querySelector('input[type="hidden"]');

        // Toggle dropdown on click
        selected.addEventListener('click', (e) => {
          e.stopPropagation();
          // Close other open dropdowns
          if (openDropdown && openDropdown !== options) {
            openDropdown.style.display = 'none';
          }
          // Toggle current dropdown
          if (options.style.display === 'block') {
            options.style.display = 'none';
            openDropdown = null;
          } else {
            options.style.display = 'block';
            openDropdown = options;
          }
        });

        // Select option
        optionItems.forEach(option => {
          option.addEventListener('click', (e) => {
            e.stopPropagation();
            const value = option.getAttribute('data-value');
            const content = option.innerHTML;

            selected.innerHTML = content + ' <i class="fa-solid fa-chevron-down"></i>';
            dropdown.setAttribute('data-value', value);

            // Also update the hidden input
            if (hiddenInput) {
              hiddenInput.value = value;
            }

            // Set data-value on selected for reference
            selected.setAttribute('data-value', value);

            options.style.display = 'none';
            openDropdown = null;
          });
        });

        // Country-City filtering
        const countrySelect = document.getElementById('country');
        const citySelect = document.getElementById('city');
        const cityOptions = citySelect.querySelectorAll('option');

        function filterCities() {
          const selectedCountry = countrySelect.value;
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

      // Close dropdown when clicking outside any dropdown
      document.addEventListener('click', function(e) {
        if (openDropdown) {
          openDropdown.style.display = 'none';
          openDropdown = null;
        }
      });
    });
  </script>

</body>

</html>