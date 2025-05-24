<?php

use App\controllers\Auth;
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Compass | Travel Logs</title>
  <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
  <script src="https://kit.fontawesome.com/2251ecbe6b.js" crossorigin="anonymous"></script>
  <link rel="stylesheet" href="/app/styles/index.css">
  <link rel="stylesheet" href="/app/styles/animations.css">

</head>

<body class="bg-gray-50 text-gray-800">
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

            <div class="flex items-center gap-2 mt-5 mb-1 text-[var(--blue)]"><i class="fa-solid fa-gift"></i> Travel Vouchers</div>
            <p class="text-sm text-[var,--text-dark)]">Redeem your travel vouchers before they expire</p>
            <div class="flex items-center gap-2 mt-2 mb-1 text-[var(--blue)]"><i class="fa-solid fa-gear"></i> Settings</div>
            <p class="text-sm mb-4 text-[var,--text-dark)]">Manage your notification preferences here</p>
          </div>
        <?php else: ?>
          <i class="fa-solid fa-user text-sm"></i> <?= $_SESSION["user"]["given"] . " " . $_SESSION["user"]["surname"] ?>
          <div class="invisible absolute bg-[#F4EEEC] p-5 h-68 w-60 rounded-lg leading-tight
          group-hover/account:visible top-9 -right-3 ">
            <div class="flex items-center gap-2 mt-5 mb-1 text-[var(--blue)]"><i class="fa-solid fa-gift"></i> Travel Vouchers</div>
            <p class="text-sm text-[var,--text-dark)]">Redeem your travel vouchers before they expire</p>
            <div class="flex items-center gap-2 mt-2 mb-1 text-[var(--blue)]"><i class="fa-solid fa-gear"></i> Settings</div>
            <p class="text-sm mb-4 text-[var,--text-dark)]">Manage your notification preferences here</p>
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
      <a href="/destinations" class="font-semibold text-[var(--text-dark)] hover:text-[var,--blue]">Travel</a>
      <?php if (Auth::check()): ?>
        <a href="/travel-logs" class="font-semibold text-[var,--text-dark)] hover:text-[var,--blue]">Travel Logs</a>
      <?php endif; ?>
      <?php if (!Auth::check()): ?>
        <a href="/login" class="bg-[var(--blue)] text-white rounded-full py-2 px-8 font-semibold">Sign in</a>
        <p class="text-sm">Not a user yet? <a href="/register" class="text-[var(--blue)]">Sign-up</a></p>
      <?php else: ?>
        <a href="/logout" class="bg-[var(--blue)] text-white rounded-full py-2 px-8 font-semibold">Log out</a>
      <?php endif; ?>
    </div>
  </div>

  <!-- Main Content -->
  <main class="container mx-auto px-4 py-6 grid grid-cols-1 md:grid-cols-3 gap-6 mt-20">
    <!-- Left Sidebar - Profile -->
    <aside class="hidden md:block">
      <div class="bg-white rounded-lg shadow-sm p-4 sticky top-20">
        <div class="flex items-center space-x-3 mb-4">
          <div class="w-12 h-12 rounded-full bg-[var(--blue)] flex items-center justify-center">
            <i class="fa-solid fa-user text-white text-lg"></i>
          </div>
          <h2 class="font-bold"><?= $_SESSION["user"]["given"] . " " . $_SESSION["user"]["surname"] ?></h2>
        </div>
        <div class="flex justify-between text-sm mb-4">
          <div>
            <p class="font-bold">42</p>
            <p class="text-gray-500">Posts</p>
          </div>
          <div>
            <p class="font-bold">256</p>
            <p class="text-gray-500">Following</p>
          </div>
          <div>
            <p class="font-bold">1.2k</p>
            <p class="text-gray-500">Followers</p>
          </div>
        </div>
        <div class="mb-4">
          <h3 class="font-medium mb-2">About Me</h3>
          <p class="text-sm text-gray-600">Adventure seeker, photography enthusiast. Visited 23 countries and counting! ✈️ 🌍</p>
        </div>
        <div>
          <h3 class="font-medium mb-2">Recent Destinations</h3>
          <ul class="space-y-2">
            <?php
            $recentTrips = array_slice($userTrips, 0, 3);
            foreach ($recentTrips as $trip): ?>
              <li class="flex items-center gap-2 text-sm">
                <i class="fa-solid fa-location-dot text-[var(--blue)]"></i>
                <span>
                  <?= htmlspecialchars($trip['to_location'] ?? '-') ?>
                  <span class="text-gray-400">(
                    <?= htmlspecialchars(date('M d', strtotime($trip['travel_date'] ?? ''))) ?>
                    )</span>
                </span>
              </li>
            <?php endforeach; ?>
            <?php if (empty($recentTrips)): ?>
              <li class="text-gray-400">No recent trips.</li>
            <?php endif; ?>
          </ul>
        </div>
      </div>
    </aside>

    <!-- Center - Feed -->
    <div class="md:col-span-2">
      <!-- Tabs for Your Trips and Posts -->
      <div class="mb-8">
        <div class="w-full flex border-b border-gray-200 mb-4">
          <button id="tab-trips" class="w-full tab-btn px-4 py-3 text-sm font-semibold text-[var(--blue)] border-b-2 border-[var(--blue)] bg-white focus:outline-none" type="button">
            Your Trips
          </button>
          <button id="tab-posts" class="w-full tab-btn px-4 py-3 text-sm font-semibold text-gray-500 border-b-2 border-transparent bg-white focus:outline-none" type="button">
            Posts
          </button>
        </div>
        <!-- User Trips Cards -->
        <section id="user-trips-section">
          <?php if (empty($userTrips)): ?>
            <div class="p-6 bg-yellow-50 border border-yellow-200 rounded-lg text-yellow-700 user-trips-content">
              You have no trips booked yet.
            </div>
          <?php else: ?>
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 user-trips-content">
              <?php foreach ($userTrips as $trip): ?>
                <div class="bg-white rounded-xl shadow-md p-5 flex flex-col gap-2 border border-[var(--hero-border)] hover:shadow-lg transition">
                  <div class="flex items-center justify-between mb-2">
                    <span class="text-xs bg-[var(--gold)] text-[var(--text-dark)] px-2 py-1 rounded-full font-semibold">
                      <?= htmlspecialchars($trip['booking_reference'] ?? '-') ?>
                    </span>
                    <span class="text-xs text-gray-500">
                      <?= htmlspecialchars(date('M d, Y', strtotime($trip['booking_date'] ?? $trip['travel_date'] ?? ''))) ?>
                    </span>
                  </div>
                  <div class="flex items-center gap-2 text-lg font-semibold">
                    <i class="fa-solid fa-plane-departure text-[var(--blue)]"></i>
                    <?= htmlspecialchars($trip['from_location'] ?? '-') ?>
                    <span class="mx-2 text-gray-400">→</span>
                    <i class="fa-solid fa-location-dot text-[var(--blue)]"></i>
                    <?= htmlspecialchars($trip['to_location'] ?? '-') ?>
                  </div>
                  <div class="flex items-center gap-4 text-sm mt-1">
                    <span>
                      <i class="fa-regular fa-calendar"></i>
                      <?= htmlspecialchars(date('M d, Y', strtotime($trip['travel_date'] ?? '-'))) ?>
                    </span>
                    <?php if (!empty($trip['return_date'])): ?>
                      <span>
                        <i class="fa-solid fa-arrow-right-arrow-left"></i>
                        <?= htmlspecialchars(date('M d, Y', strtotime($trip['return_date']))) ?>
                      </span>
                    <?php endif; ?>
                  </div>
                  <div class="flex items-center gap-2 text-xs mt-2">
                    <span class="px-2 py-1 rounded bg-[var(--blue)] text-white">
                      <?= ucfirst(htmlspecialchars($trip['transport_type'] ?? '')) ?>
                    </span>
                    <span class="px-2 py-1 rounded bg-gray-100 text-gray-700">
                      <?= ucfirst(htmlspecialchars($trip['trip_type'] ?? '')) ?>
                    </span>
                    <span class="px-2 py-1 rounded bg-green-100 text-green-700">
                      <?= htmlspecialchars($trip['status'] ?? 'Confirmed') ?>
                    </span>
                  </div>
                </div>
              <?php endforeach; ?>
            </div>
          <?php endif; ?>
        </section>
        <!-- Posts Feed -->
        <section id="posts-section" style="display:none;">
          <!-- Post Creation -->
          <form id="post-form" action="/travel-logs/create" method="POST" enctype="multipart/form-data" class="bg-white rounded-lg shadow-sm p-4 mb-6">
            <div class="flex space-x-3">
              <div class="flex-1">
                <textarea id="post-content" name="content" class="w-full rounded-lg p-3 focus:outline-none focus:ring-2 focus:ring-primary-500 resize-none" rows="3" placeholder="Share your travel adventure..."></textarea>
                <div class="flex justify-between items-center mt-3">
                  <div class="flex gap-4 pl-4">
                    <!-- Upload Image Button -->
                    <label class="flex items-center text-gray-500 hover:text-[var(--text-dark)] cursor-pointer" title="Add Photo">
                      <i class="fas fa-image"></i>
                      <span class="tracking-tighter">&nbsp;&nbsp;Upload image</span>
                      <input type="file" id="post-image" name="image" accept="image/*" class="hidden">
                    </label>
                    <!-- Location Button -->
                    <button type="button" id="add-location-btn" class="text-gray-500 hover:text-[var(--text-dark)] flex items-center" title="Add Location">
                      <i class="fas fa-map-marker-alt"></i>
                      <span class="tracking-tighter">&nbsp;&nbsp;Location</span>
                    </button>
                  </div>
                  <button id="post-button" type="submit" class="bg-[var(--gold)] hover:bg-primary-700 text-[var(--text-dark)] pb-2 px-4 py-2 rounded-full text-sm font-medium transition">
                    Post Adventure
                  </button>
                </div>
                <!-- Location input, hidden by default -->
                <input type="text" id="location-input" name="location" placeholder="Enter location..." class="mt-3 w-full rounded-lg border border-gray-300 p-2 text-sm hidden placeholder:text-neutral-500 text-[var(--blue)]" />
                <!-- Image preview, hidden by default -->
                <div id="image-preview" class="mt-3"></div>
              </div>
            </div>
          </form>

          <!-- Filter Options -->
          <div class="flex space-x-2 mb-6 overflow-x-auto pb-2">
            <button class="filter-btn bg-[var(--text-dark)] text-white px-4 py-2 rounded-full text-sm font-medium" data-filter="all">All Posts</button>
            <button class="filter-btn bg-white text-gray-700 hover:bg-gray-100 px-4 py-2 rounded-full text-sm font-medium" data-filter="user">Your Posts</button>
            <button class="filter-btn bg-white text-gray-700 hover:bg-gray-100 px-4 py-2 rounded-full text-sm font-medium" data-filter="philippines">Philippines</button>
            <button class="filter-btn bg-white text-gray-700 hover:bg-gray-100 px-4 py-2 rounded-full text-sm font-medium" data-filter="international">International</button>
          </div>

          <div id="posts-container">
            <!-- Posts will be dynamically loaded here -->
          </div>
        </section>
      </div>
    </div>
  </main>

  <!-- Footer Starts -->
  <div style="background-color: #fff6f3; padding: 20px; font-family: Arial, sans-serif; font-size: 14px; color: #333; margin-top: 150px;">
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


  <script>
    // Global posts data
    let allPosts = <?= json_encode($allPosts ?? []) ?>;
    let userPosts = <?= json_encode($userPosts ?? []) ?>;
    let currentUserId = <?= json_encode($_SESSION['user']['id'] ?? null) ?>;

    // Tab switching logic
    document.getElementById('tab-trips').addEventListener('click', function() {
      document.getElementById('user-trips-section').style.display = '';
      document.getElementById('posts-section').style.display = 'none';
      this.classList.add('text-[var(--blue)]', 'border-[var(--blue)]', 'border-b-2');
      this.classList.remove('text-gray-500', 'border-transparent');
      document.getElementById('tab-posts').classList.remove('text-[var(--blue)]', 'border-[var(--blue)]', 'border-b-2');
      document.getElementById('tab-posts').classList.add('text-gray-500', 'border-transparent');
    });
    document.getElementById('tab-posts').addEventListener('click', function() {
      document.getElementById('user-trips-section').style.display = 'none';
      document.getElementById('posts-section').style.display = '';
      this.classList.add('text-[var(--blue)]', 'border-[var(--blue)]', 'border-b-2');
      this.classList.remove('text-gray-500', 'border-transparent');
      document.getElementById('tab-trips').classList.remove('text-[var(--blue)]', 'border-[var(--blue)]', 'border-b-2');
      document.getElementById('tab-trips').classList.add('text-gray-500', 'border-transparent');
      loadPosts('all');
    });

    // Filter posts functionality
    document.querySelectorAll('.filter-btn').forEach(btn => {
      btn.addEventListener('click', function() {
        const filter = this.getAttribute('data-filter');

        // Update active filter button
        document.querySelectorAll('.filter-btn').forEach(b => {
          b.classList.remove('bg-[var(--text-dark)]', 'text-white');
          b.classList.add('bg-white', 'text-gray-700');
        });
        this.classList.add('bg-[var(--text-dark)]', 'text-white');
        this.classList.remove('bg-white', 'text-gray-700');

        loadPosts(filter);
      });
    });

    // Load and display posts
    function loadPosts(filter = 'all') {
      const container = document.getElementById('posts-container');
      let postsToShow = [];

      switch (filter) {
        case 'user':
          postsToShow = userPosts;
          break;
        case 'philippines':
          postsToShow = allPosts.filter(post =>
            post.location && (
              post.location.toLowerCase().includes('philippines') ||
              post.location.toLowerCase().includes('manila') ||
              post.location.toLowerCase().includes('cebu') ||
              post.location.toLowerCase().includes('palawan') ||
              post.location.toLowerCase().includes('boracay') ||
              post.location.toLowerCase().includes('baguio') ||
              post.location.toLowerCase().includes('siargao') ||
              post.location.toLowerCase().includes('bohol')
            )
          );
          break;
        case 'international':
          postsToShow = allPosts.filter(post =>
            post.location && !(
              post.location.toLowerCase().includes('philippines') ||
              post.location.toLowerCase().includes('manila') ||
              post.location.toLowerCase().includes('cebu') ||
              post.location.toLowerCase().includes('palawan') ||
              post.location.toLowerCase().includes('boracay') ||
              post.location.toLowerCase().includes('baguio') ||
              post.location.toLowerCase().includes('siargao') ||
              post.location.toLowerCase().includes('bohol')
            )
          );
          break;
        default:
          postsToShow = allPosts;
      }

      if (postsToShow.length === 0) {
        container.innerHTML = `
          <div class="text-center py-10 text-gray-500">
            <h3 class="text-lg font-semibold">No posts found</h3>
            <p>Be the first to share your travel adventure!</p>
          </div>
        `;
        return;
      }

      container.innerHTML = postsToShow.map(post => createPostHTML(post)).join('');
    }

    // Create HTML for a single post
    function createPostHTML(post) {
      const userName = post.given && post.surname ? `${post.given} ${post.surname}` : 'Anonymous';
      const isCurrentUser = post.user_id == currentUserId;
      const postDate = new Date(post.created_at).toLocaleDateString('en-US', {
        year: 'numeric',
        month: 'short',
        day: 'numeric'
      });

      // Handle single image
      let imageHTML = '';
      if (post.images && post.images.trim()) {
        const imageSrc = post.images.trim();
        imageHTML = `
          <div class="mt-3">
            <img src="${imageSrc}" alt="Travel photo" class="rounded-lg object-cover w-full max-h-96 cursor-pointer" onclick="openImageModal('${imageSrc}')">
          </div>
        `;
      }

      return `
        <div class="bg-white rounded-lg shadow-sm p-6 mb-6">
          <div class="flex items-center space-x-3 mb-4">
            <div class="w-10 h-10 rounded-full bg-[var(--blue)] flex items-center justify-center">
              <i class="fa-solid fa-user text-white text-sm"></i>
            </div>
            <div class="flex-1">
              <h3 class="font-semibold text-gray-900">${userName} ${isCurrentUser ? '(You)' : ''}</h3>
              <div class="flex items-center text-sm text-gray-500">
                ${post.location ? `<i class="fas fa-map-marker-alt mr-1"></i><span class="mr-3">${post.location}</span>` : ''}
                <span>${postDate}</span>
              </div>
            </div>
          </div>
          <div class="text-gray-800 mb-3">${post.content || ''}</div>
          ${imageHTML}
          <div class="flex items-center justify-between pt-4 border-t border-gray-100">
            <div class="flex space-x-4">
              <button class="flex items-center text-gray-500 hover:text-blue-600">
                <i class="fas fa-heart mr-1"></i>
                <span>Like</span>
              </button>
              <button class="flex items-center text-gray-500 hover:text-blue-600">
                <i class="fas fa-comment mr-1"></i>
                <span>Comment</span>
              </button>
              <button class="flex items-center text-gray-500 hover:text-blue-600">
                <i class="fas fa-share mr-1"></i>
                <span>Share</span>
              </button>
            </div>
          </div>
        </div>
      `;
    }

    // Image modal functionality
    function openImageModal(imageSrc) {
      const modal = document.createElement('div');
      modal.className = 'fixed inset-0 bg-black bg-opacity-75 flex items-center justify-center z-50';
      modal.innerHTML = `
        <div class="relative max-w-4xl max-h-full p-4">
          <img src="${imageSrc}" alt="Full size image" class="max-w-full max-h-full object-contain">
          <button class="absolute top-4 right-4 text-white text-xl bg-black bg-opacity-50 rounded-full w-8 h-8 flex items-center justify-center" onclick="this.parentElement.parentElement.remove()">×</button>
        </div>
      `;
      modal.onclick = function(e) {
        if (e.target === modal) modal.remove();
      };
      document.body.appendChild(modal);
    }

    // Show/hide location input
    document.getElementById('add-location-btn').addEventListener('click', function() {
      const locInput = document.getElementById('location-input');
      locInput.classList.toggle('hidden');
      if (!locInput.classList.contains('hidden')) {
        locInput.focus();
      }
    });

    // Image preview for upload (single image) with remove button
    const imageInput = document.getElementById('post-image');
    const preview = document.getElementById('image-preview');
    let imageData = null;

    function renderImage() {
      preview.innerHTML = '';
      if (imageData) {
        const wrapper = document.createElement('div');
        wrapper.className = "relative inline-block";

        // Image
        const img = document.createElement('img');
        img.src = imageData.dataUrl;
        img.className = "max-h-40 rounded-lg mt-2 inline-block";

        // Remove button
        const removeBtn = document.createElement('button');
        removeBtn.type = "button";
        removeBtn.innerHTML = '<span class="absolute top-1 right-1 bg-white rounded-full border border-gray-300 text-gray-500 hover:text-red-600 px-2 py-0.5 text-xs font-bold cursor-pointer" title="Remove">&times;</span>';
        removeBtn.className = "absolute top-0 right-0 z-10";
        removeBtn.onclick = function() {
          imageData = null;
          renderImage();
          imageInput.value = '';
        };

        wrapper.appendChild(img);
        wrapper.appendChild(removeBtn);
        preview.appendChild(wrapper);
      }
    }

    imageInput.addEventListener('change', function(e) {
      const file = e.target.files[0];
      if (file && file.type.startsWith('image/')) {
        const reader = new FileReader();
        reader.onload = function(evt) {
          imageData = {
            file,
            dataUrl: evt.target.result
          };
          renderImage();
        };
        reader.readAsDataURL(file);
      }
    });
  </script>
</body>

</html>