<?php
require_once 'app/controllers/Auth.php';

use App\controllers\Auth;
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Compass - Travel Booking</title>
  <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
  <link rel="stylesheet" href="/app/styles/index.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>

<body class="bg-gray-100">
  <div class="w-full max-w-full mx-auto">

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


    <div class="search-container max-w-3xl mx-auto mt-40 mb-5 p-5 bg-white rounded-xl shadow relative z-10">
      <div class="search-box flex mb-4">
        <input type="text" id="search-input" placeholder="Search destinations..." class="flex-1 p-3 border border-gray-300 rounded-l-md text-base">
        <button id="search-button" class="bg-gray-800 text-white px-5 rounded-r-md"><i class="fas fa-search"></i></button>
      </div>
      <div class="filters flex flex-wrap gap-4">
        <div class="filter-group flex flex-col flex-1 min-w-[150px]">
          <label for="price-filter" class="text-sm mb-1 text-gray-600">Price Range:</label>
          <select id="price-filter" class="p-2 border border-gray-300 rounded bg-gray-50">
            <option value="all">All Prices</option>
            <option value="budget">Budget (Under ₱15,000)</option>
            <option value="mid">Mid-range (₱15,000-₱40,000)</option>
            <option value="luxury">Luxury (Over ₱40,000)</option>
          </select>
        </div>
        <div class="filter-group flex flex-col flex-1 min-w-[150px]">
          <label for="duration-filter" class="text-sm mb-1 text-gray-600">Duration:</label>
          <select id="duration-filter" class="p-2 border border-gray-300 rounded bg-gray-50">
            <option value="all">All Durations</option>
            <option value="short">Short (1-7 days)</option>
            <option value="medium">Medium (8-14 days)</option>
            <option value="long">Long (15+ days)</option>
          </select>
        </div>
        <div class="filter-group flex flex-col flex-1 min-w-[150px]">
          <label for="activity-filter" class="text-sm mb-1 text-gray-600">Activities:</label>
          <select id="activity-filter" class="p-2 border border-gray-300 rounded bg-gray-50">
            <option value="all">All Activities</option>
            <option value="hiking">Hiking</option>
            <option value="kayaking">Kayaking</option>
            <option value="fishing">Fishing</option>
            <option value="mountain-biking">Mountain Biking</option>
            <option value="skiing">Skiing</option>
            <option value="surfing">Surfing</option>
          </select>
        </div>
        <div class="filter-group flex flex-col flex-1 min-w-[150px]">
          <label for="info-filter" class="text-sm mb-1 text-gray-600">Information Needs:</label>
          <select id="info-filter" class="p-2 border border-gray-300 rounded bg-gray-50">
            <option value="all">All Information</option>
            <option value="transportation">Transportation</option>
            <option value="health">Health</option>
            <option value="weather">Weather</option>
            <option value="gear">Gear</option>
            <option value="political-info">Political Info</option>
            <option value="activity-specific">Activity Specific</option>
          </select>
        </div>
      </div>
    </div>
    <div class="destinations-container w-full max-w-3xl mx-auto p-5" id="destinations-container">
      <!-- Destinations will be loaded dynamically via JavaScript -->
    </div>
  </div>
  <script>
    // Utility: debounce for search input
    function debounce(fn, delay) {
      let timeout;
      return function(...args) {
        clearTimeout(timeout);
        timeout = setTimeout(() => fn.apply(this, args), delay);
      };
    }

    // Mobile menu toggle logic
    document.addEventListener("DOMContentLoaded", () => {
      // Mobile menu
      const mobileMenuBtn = document.getElementById("mobile-menu-button");
      const closeMenuBtn = document.getElementById("close-menu-button");
      const mobileMenu = document.getElementById("mobile-menu");

      if (mobileMenuBtn && mobileMenu) {
        mobileMenuBtn.addEventListener("click", () => {
          mobileMenu.classList.remove("hidden");
        });
      }
      if (closeMenuBtn && mobileMenu) {
        closeMenuBtn.addEventListener("click", () => {
          mobileMenu.classList.add("hidden");
        });
      }

      // Responsive nav: close menu on link click (mobile)
      mobileMenu?.querySelectorAll("a").forEach(link => {
        link.addEventListener("click", () => {
          mobileMenu.classList.add("hidden");
        });
      });

      // Load destinations data
      loadDestinations();

      // Set up search and filter functionality
      const searchInput = document.getElementById("search-input");
      const searchButton = document.getElementById("search-button");
      const priceFilter = document.getElementById("price-filter");
      const durationFilter = document.getElementById("duration-filter");
      const activityFilter = document.getElementById("activity-filter");
      const infoFilter = document.getElementById("info-filter");

      // Debounced search for better UX
      const debouncedFilter = debounce(filterDestinations, 300);

      // Search button click event
      searchButton.addEventListener("click", filterDestinations);

      // Search input enter key event and live search
      searchInput.addEventListener("keyup", (event) => {
        if (event.key === "Enter") {
          filterDestinations();
        } else {
          debouncedFilter();
        }
      });

      // Filter change events
      [priceFilter, durationFilter, activityFilter, infoFilter].forEach(el => {
        el.addEventListener("change", filterDestinations);
      });
    });

    // Function to load destinations from the server
    function loadDestinations() {
      fetch("get_destinations.php")
        .then((response) => {
          if (!response.ok) throw new Error("Network error");
          return response.json();
        })
        .then((data) => {
          displayDestinations(data);
        })
        .catch((error) => {
          console.error("Error fetching destinations:", error);
          // Fallback to sample data if fetch fails
          const sampleData = getSampleDestinations();
          displayDestinations(sampleData);
        });
    }

    // Function to filter destinations based on search and filters
    function filterDestinations() {
      const searchTerm = document.getElementById("search-input").value.trim().toLowerCase();
      const priceFilter = document.getElementById("price-filter").value;
      const durationFilter = document.getElementById("duration-filter").value;
      const activityFilter = document.getElementById("activity-filter").value;
      const infoFilter = document.getElementById("info-filter").value;

      // Try server-side filtering first
      fetch(
          `get_destinations.php?search=${encodeURIComponent(searchTerm)}&price=${encodeURIComponent(priceFilter)}&duration=${encodeURIComponent(durationFilter)}&activity=${encodeURIComponent(activityFilter)}&info=${encodeURIComponent(infoFilter)}`
        )
        .then((response) => {
          if (!response.ok) throw new Error("Network error");
          return response.json();
        })
        .then((data) => {
          displayDestinations(data);
        })
        .catch((error) => {
          console.error("Error filtering destinations:", error);
          // Fallback to client-side filtering if fetch fails
          const allDestinations = getSampleDestinations();
          const filteredDestinations = allDestinations.filter((destination) => {
            // Search term filter
            const matchesSearch = !searchTerm ||
              destination.name.toLowerCase().includes(searchTerm) ||
              (destination.country && destination.country.toLowerCase().includes(searchTerm));

            // Price filter
            let matchesPrice = true;
            if (priceFilter === "budget") {
              matchesPrice = destination.price < 15000;
            } else if (priceFilter === "mid") {
              matchesPrice = destination.price >= 15000 && destination.price <= 40000;
            } else if (priceFilter === "luxury") {
              matchesPrice = destination.price > 40000;
            }

            // Duration filter
            let matchesDuration = true;
            const duration = getDurationDays(destination.start_date, destination.end_date);
            if (durationFilter === "short") {
              matchesDuration = duration <= 7;
            } else if (durationFilter === "medium") {
              matchesDuration = duration > 7 && duration <= 14;
            } else if (durationFilter === "long") {
              matchesDuration = duration > 14;
            }

            // Activity filter
            const matchesActivity =
              activityFilter === "all" ||
              (Array.isArray(destination.activities) && destination.activities.includes(activityFilter));

            // Information filter
            const matchesInfo =
              infoFilter === "all" ||
              (Array.isArray(destination.info_needs) && destination.info_needs.includes(infoFilter));

            return matchesSearch && matchesPrice && matchesDuration && matchesActivity && matchesInfo;
          });

          displayDestinations(filteredDestinations);
        });
    }

    // Function to display destinations in the container
    function displayDestinations(destinations) {
      const container = document.getElementById("destinations-container");
      container.innerHTML = "";

      if (!Array.isArray(destinations) || destinations.length === 0) {
        container.innerHTML =
          '<div class="text-center py-10 text-gray-500"><h3 class="text-lg font-semibold">No destinations found</h3><p>Try adjusting your search or filters</p></div>';
        return;
      }

      destinations.forEach((destination) => {
        const card = document.createElement("div");
        card.className =
          "flex bg-white rounded-xl overflow-hidden mb-5 shadow transition-transform duration-200 hover:-translate-y-1 hover:shadow-lg flex-col md:flex-row";

        const duration = getDurationDays(destination.start_date, destination.end_date);

        // Fix image path: ensure /assets/destinations/ prefix if not already present
        let imgSrc = destination.image || "";
        // Try /assets/destinations/ first, fallback to /assets/ if not found
        if (imgSrc && !imgSrc.startsWith("/") && !imgSrc.startsWith("http")) {
          // Try /assets/destinations/ + imgSrc
          let testImg = new Image();
          testImg.src = "/assets/destinations/" + imgSrc;
          testImg.onload = function() {
            card.querySelector('.destination-img').style.backgroundImage = `url('${testImg.src}')`;
          };
          testImg.onerror = function() {
            card.querySelector('.destination-img').style.backgroundImage = `url('/assets/${imgSrc}')`;
          };
        }

        // Defensive: handle missing fields
        const activities = Array.isArray(destination.activities) ? destination.activities.join(", ") : "";
        const infoNeeds = Array.isArray(destination.info_needs) ? destination.info_needs.join(", ") : "";
        const country = destination.country || "";
        const price = typeof destination.price === "number" ? destination.price.toLocaleString() : "";

        card.innerHTML = `
            <div class="destination-img w-full md:w-[150px] h-[180px] md:h-[150px] bg-cover bg-center" style="background-image: url('/assets/destinations/${imgSrc}');"></div>
            <div class="flex-1 p-4 relative">
                <h2 class="text-lg font-semibold mb-2">${destination.name || ""}</h2>
                <div class="absolute top-4 right-5 text-right">
                    <p class="text-sm text-gray-700">${destination.start_date || ""} - ${destination.end_date || ""}</p>
                    <p class="text-xs text-gray-500">Trip #${destination.trip_id || ""}</p>
                    <p class="text-xl font-bold text-green-700 mt-1">₱${price}</p>
                </div>
                <div class="flex items-center gap-2 mt-6 text-gray-600 text-sm">
                    <i class="fas fa-plane transform rotate-45 text-base"></i>
                    <span>${destination.departure || ""} - ${destination.arrival || ""}</span>
                </div>
                <div class="flex flex-wrap gap-2 mt-3">
                  <span class="inline-block bg-gray-100 px-2 py-1 rounded text-xs text-gray-700">${activities}</span>
                  <span class="inline-block bg-gray-100 px-2 py-1 rounded text-xs text-gray-700">${duration} days</span>
                  <span class="inline-block bg-gray-100 px-2 py-1 rounded text-xs text-gray-700">${country}</span>
                  <span class="inline-block bg-gray-100 px-2 py-1 rounded text-xs text-gray-700">Info: ${infoNeeds}</span>
                </div>
            </div>
        `;
        container.appendChild(card);
      });
    }

    // Helper function to calculate duration in days
    function getDurationDays(startDate, endDate) {
      if (!startDate || !endDate) return "";
      const start = new Date(startDate);
      const end = new Date(endDate);
      if (isNaN(start) || isNaN(end)) return "";
      const diffTime = Math.abs(end - start);
      const diffDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24));
      return diffDays;
    }

    // Sample destinations data for fallback
    function getSampleDestinations() {
      return [{
          image: "cebu.jpg",
          name: "Cebu, Lapu-Lapu City",
          country: "Philippines",
          start_date: "April 10, 2025",
          end_date: "April 17, 2025",
          trip_id: "214238732",
          price: 12500,
          departure: "Manila",
          arrival: "Cebu",
          activities: ["surfing", "kayaking"],
          info_needs: ["transportation", "weather", "gear"],
        },
        {
          image: "siargao.jpeg",
          name: "Siargao, General Luna",
          country: "Philippines",
          start_date: "May 5, 2025",
          end_date: "May 15, 2025",
          trip_id: "214238733",
          price: 18900, // More realistic Philippine price
          departure: "Manila",
          arrival: "Siargao",
          activities: ["surfing", "kayaking", "fishing"],
          info_needs: ["transportation", "weather", "gear", "activity-specific"],
        },
        {
          image: "boracay.jpg",
          name: "Boracay, Malay Aklan",
          country: "Philippines",
          start_date: "June 10, 2025",
          end_date: "June 17, 2025",
          trip_id: "214238734",
          price: 15500, // More realistic Philippine price
          departure: "Manila",
          arrival: "Caticlan",
          activities: ["surfing", "kayaking"],
          info_needs: ["transportation", "weather", "health"],
        },
        {
          image: "palawan.jpg",
          name: "Palawan, Puerto Princesa",
          country: "Philippines",
          start_date: "July 5, 2025",
          end_date: "July 20, 2025",
          trip_id: "214238735",
          price: 22500, // More realistic Philippine price
          departure: "Manila",
          arrival: "Puerto Princesa",
          activities: ["kayaking", "hiking", "fishing"],
          info_needs: ["transportation", "health", "gear", "political-info"],
        },
        {
          image: "baguio.jpg",
          name: "Baguio City",
          country: "Philippines",
          start_date: "August 1, 2025",
          end_date: "August 5, 2025",
          trip_id: "214238736",
          price: 8500, // More realistic Philippine price
          departure: "Manila",
          arrival: "Baguio",
          activities: ["hiking", "mountain-biking"],
          info_needs: ["transportation", "weather", "gear"],
        },
        {
          image: "bohol.jpg",
          name: "Bohol, Panglao Island",
          country: "Philippines",
          start_date: "September 10, 2025",
          end_date: "September 20, 2025",
          trip_id: "214238737",
          price: 16900, // More realistic Philippine price
          departure: "Manila",
          arrival: "Tagbilaran",
          activities: ["kayaking", "fishing", "hiking"],
          info_needs: ["transportation", "weather", "health"],
        },
        {
          image: "bangkok.jpg",
          name: "Bangkok",
          country: "Thailand",
          start_date: "October 5, 2025",
          end_date: "October 12, 2025",
          trip_id: "214238738",
          price: 28500, // More realistic Philippine price
          departure: "Manila",
          arrival: "Bangkok",
          activities: ["hiking"],
          info_needs: ["transportation", "health", "political-info"],
        },
        {
          image: "tokyo.jpg",
          name: "Tokyo",
          country: "Japan",
          start_date: "November 15, 2025",
          end_date: "November 25, 2025",
          trip_id: "214238739",
          price: 45000, // More realistic Philippine price
          departure: "Manila",
          arrival: "Tokyo",
          activities: ["skiing", "hiking"],
          info_needs: ["transportation", "weather", "gear", "political-info"],
        },
        {
          image: "newport.jpg",
          name: "Newport Beach, Los Angeles",
          country: "United States",
          start_date: "June 15, 2025",
          end_date: "June 25, 2025",
          trip_id: "214238740",
          price: 75000, // More realistic Philippine price
          departure: "Manila",
          arrival: "Los Angeles",
          activities: ["surfing", "fishing", "kayaking"],
          info_needs: ["transportation", "weather", "gear", "political-info"],
        },
        {
          image: "upper-hutt.jpg",
          name: "Upper Hutt",
          country: "New Zealand",
          start_date: "February 10, 2025",
          end_date: "February 24, 2025",
          trip_id: "214238741",
          price: 68000, // More realistic Philippine price
          departure: "Manila",
          arrival: "Wellington",
          activities: ["hiking", "mountain-biking", "fishing"],
          info_needs: ["transportation", "weather", "gear", "activity-specific"],
        },
        {
          image: "wyoming.jpg",
          name: "Wyoming",
          country: "United States",
          start_date: "December 5, 2025",
          end_date: "December 15, 2025",
          trip_id: "214238742",
          price: 82000, // More realistic Philippine price
          departure: "Manila",
          arrival: "Jackson Hole",
          activities: ["skiing", "hiking", "fishing", "mountain-biking"],
          info_needs: ["transportation", "weather", "gear", "health", "activity-specific"],
        },
      ]
    }
  </script>
</body>

</html>