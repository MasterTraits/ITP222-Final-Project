<?

use App\controllers\Auth;
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Boracay Island Paradise | Compass Travel</title>
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css" />
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <script src="https://kit.fontawesome.com/2251ecbe6b.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="/app/styles/index.css">
</head>

<body class="font-sans leading-relaxed text-gray-800 bg-white">
    <nav class="rounded-tl-lg rounded-br-lg shadow-lg px-4 py-2 w-[95%] max-w-5xl   
    bg-[var(--bg-transparent-light)] backdrop-blur-md border border-[#E2E8F0] 
    fixed top-5 left-1/2 transform -translate-x-1/2 z-[9999]
    flex items-center justify-between">
        <a href="/" class="flex items-center">
            <img src="/assets/logo.svg" alt="Compass Logo" class="h-10 w-auto">
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
                        <p class="text-sm mb-4 text-[var,--text-dark)]">Manage your notification preferences here</p>
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
    <div id="mobile-menu" class="fixed top-0 left-0 w-full h-screen bg-[var(--bg-transparent-light)] backdrop-blur-lg z-[10000] hidden flex-col items-center pt-20">
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

    <!-- Hero Section -->
    <section class="relative w-full relative h-96 flex flex-col items-center justify-center">
        <img src="/assets/details/upper-hut-bridge.jpg" alt="Boracay Island" class="inset-0 w-full h-full object-cover object-bottom">
        </div>
        <div class="absolute bottom-4 w-full max-w-6xl flex items-center justify-between px-4">
            <h1 class="text-5xl font-bold mb-2 drop-shadow-lg text-white">Upper Hut, New Zealand</h1>
            <a href="/book/1" class="bg-[var(--gold)] hover:bg-amber-300 text-black font-medium px-6 py-3 rounded-lg flex items-center gap-2 transition-colors">
                <span>🏖️</span> Book Now
            </a>
        </div>
    </section>

    <!-- Main Content -->
    <div class="max-w-6xl mx-auto px-4 py-8 grid grid-cols-1 lg:grid-cols-3 gap-8"> <!-- Left Column - Main Content -->
        <!-- Left Column - Main Content -->
        <div class="lg:col-span-2 space-y-8">
            <!-- Price and Location -->
            <div class="space-y-4">
                <div class="flex items-center gap-2">
                    <h2 class="text-3xl font-bold">₱68,000</h2>
                    <span class="bg-amber-100 text-amber-800 text-xs px-2 py-1 rounded-full">Bundle & Save</span>
                </div>
                <div class="flex flex-col sm:flex-row gap-2">
                    <div class="flex items-center gap-2 border border-gray-300 rounded-md p-2 bg-white">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"></path>
                            <circle cx="12" cy="10" r="3"></circle>
                        </svg>
                        <div>
                            <div class="text-xs text-gray-500">Where to?</div>
                            <div class="text-sm">Upper Hutt, New Zealand</div>
                        </div>
                    </div>
                    <div class="flex items-center gap-2 border border-gray-300 rounded-md p-2 bg-white">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect>
                            <line x1="16" y1="2" x2="16" y2="6"></line>
                            <line x1="8" y1="2" x2="8" y2="6"></line>
                            <line x1="3" y1="10" x2="21" y2="10"></line>
                        </svg>
                        <div>
                            <div class="text-xs text-gray-500">Dates</div>
                            <div class="text-sm">Feb 25 - Mar 5</div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Rating -->
            <div class="flex items-center gap-2 bg-gray-50 p-3 rounded-md">
                <span class="text-sm font-medium">Excellent</span>
                <div class="flex">
                    <span class="text-amber-400 text-xl">★</span>
                    <span class="text-amber-400 text-xl">★</span>
                    <span class="text-amber-400 text-xl">★</span>
                    <span class="text-amber-400 text-xl">★</span>
                    <span class="text-amber-400 text-xl">★</span>
                </div>
            </div>

            <!-- Image Gallery -->
            <div class="grid grid-cols-3 gap-2 h-48">
                <img src="/assets/destinations/upper-hutt.jpg" class="h-50 w-full border-gray-300 bg-gradient-to-br from-cyan-500 to-sky-500 rounded-md flex items-center justify-center text-white text-sm font-medium">
                <img src="/assets/details/upper-hut-lake.jpg" class="h-50 w-full border-gray-300 bg-gradient-to-br from-cyan-500 to-sky-500 rounded-md flex items-center justify-center text-white text-sm font-medium">
                <img src="/assets/details/upper-hut-tower.jpg" class="h-50 w-full border-gray-300 bg-gradient-to-br from-cyan-500 to-sky-500 rounded-md flex items-center justify-center text-white text-sm font-medium">
            </div>

            <!-- Description -->
            <div class="space-y-4">
                <p class="text-gray-700 leading-relaxed">The Karapoti Trail, home to the Trek Karapoti Classic, twists around the Akatarawa Range and delivers 31 miles of technical single track and challenging fire road climbs. During the ride there are several vistas to soothe those eyes while you reward your burning legs by taking a quick breather.</p>
                <p class="text-gray-700 leading-relaxed">Upper Hutt is New Zealand's mountain biking hub, and if you're looking for a group ride, stop by Mountain Trails bike shop. Or if you want a number plate on your handlebar, the Trek Karapoti Classic is scheduled for March 4, 2001.</p>
            </div>

            <!-- Fun Facts -->
            <div class="border border-gray-200 rounded-lg p-6">
                <div class="flex items-center gap-2 mb-4">
                    <svg class="text-amber-400" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M9 21h6"></path>
                        <path d="M12 17v4"></path>
                        <path d="M12 3a6 6 0 0 1 6 6c0 3-2 5.5-2 8H8c0-2.5-2-5-2-8a6 6 0 0 1 6-6z"></path>
                    </svg>
                    <h3 class="text-lg font-bold">Trail Facts!</h3>
                </div>
                <ol class="list-decimal list-inside space-y-3 text-sm">
                    <li><strong>Karapoti Classic:</strong> The Trek Karapoti Classic is New Zealand's oldest mountain bike race, first held in 1986 and attracting riders from around the world.</li>
                    <li><strong>31-Mile Challenge:</strong> The Karapoti Trail covers 31 miles (50km) of diverse terrain including technical single track, fire roads, and challenging climbs through native bush.</li>
                    <li><strong>Akatarawa Range:</strong> The trail winds through the stunning Akatarawa Range, offering breathtaking vistas of the Wellington region and Tararua Ranges.</li>
                    <li><strong>Mountain Biking Hub:</strong> Upper Hutt is recognized as New Zealand's premier mountain biking destination with over 100km of trails suitable for all skill levels.</li>
                    <li><strong>Native Bush Experience:</strong> Riders experience authentic New Zealand native forest with towering rimu, rata, and kahikatea trees along the trail.</li>
                </ol>
            </div>

            <!-- Reviews -->
            <div class="space-y-6">
                <h3 class="text-xl font-bold">Rider Reviews</h3>
                <div class="flex items-center gap-4 mb-6">
                    <div class="text-4xl font-bold">4.7</div>
                    <div>
                        <div class="flex">
                            <span class="text-amber-400 text-xl">★</span>
                            <span class="text-amber-400 text-xl">★</span>
                            <span class="text-amber-400 text-xl">★</span>
                            <span class="text-amber-400 text-xl">★</span>
                            <span class="text-amber-400 text-xl bg-gradient-to-r from-amber-400 via-amber-400 to-gray-300 bg-clip-text text-transparent" style="background: linear-gradient(90deg, #fbbf24 70%, #d1d5db 70%); -webkit-background-clip: text; -webkit-text-fill-color: transparent;">★</span>
                        </div>
                        <div class="text-sm text-gray-600">Out of 5 Stars</div>
                        <div class="text-xs text-gray-400">Overall rating of 45 mountain biking reviews</div>
                    </div>
                </div>

                <!-- Rating Bars -->
                <div class="space-y-2">
                    <div class="flex items-center gap-2">
                        <div class="w-12 text-sm">5 Stars</div>
                        <div class="flex-1 bg-gray-200 h-2 rounded-full overflow-hidden">
                            <div class="bg-blue-500 h-full rounded-full" style="width: 78%"></div>
                        </div>
                        <div class="w-8 text-right text-sm text-gray-600">35</div>
                    </div>
                    <div class="flex items-center gap-2">
                        <div class="w-12 text-sm">4 Stars</div>
                        <div class="flex-1 bg-gray-200 h-2 rounded-full overflow-hidden">
                            <div class="bg-blue-500 h-full rounded-full" style="width: 18%"></div>
                        </div>
                        <div class="w-8 text-right text-sm text-gray-600">8</div>
                    </div>
                    <div class="flex items-center gap-2">
                        <div class="w-12 text-sm">3 Stars</div>
                        <div class="flex-1 bg-gray-200 h-2 rounded-full overflow-hidden">
                            <div class="bg-blue-500 h-full rounded-full" style="width: 4%"></div>
                        </div>
                        <div class="w-8 text-right text-sm text-gray-600">2</div>
                    </div>
                    <div class="flex items-center gap-2">
                        <div class="w-12 text-sm">2 Stars</div>
                        <div class="flex-1 bg-gray-200 h-2 rounded-full overflow-hidden">
                            <div class="bg-blue-500 h-full rounded-full" style="width: 0%"></div>
                        </div>
                        <div class="w-8 text-right text-sm text-gray-600">0</div>
                    </div>
                    <div class="flex items-center gap-2">
                        <div class="w-12 text-sm">1 Stars</div>
                        <div class="flex-1 bg-gray-200 h-2 rounded-full overflow-hidden">
                            <div class="bg-blue-500 h-full rounded-full" style="width: 0%"></div>
                        </div>
                        <div class="w-8 text-right text-sm text-gray-600">0</div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Right Column - Sidebar -->
        <div class="space-y-6">
            <!-- Map -->
            <div class="border border-gray-200 rounded-lg overflow-hidden">
                <div id="map" class="h-64 w-full"></div>
            </div>

            <!-- Tabs -->
            <div class="border border-gray-200 rounded-lg overflow-hidden">
                <div class="grid grid-cols-2">
                    <button class="tab-button px-4 py-3 text-sm border-b border-gray-200 bg-white font-medium" onclick="showTab('questions')">Frequently asked questions</button>
                    <button class="tab-button px-4 py-3 text-sm border-b border-gray-200 bg-gray-50" onclick="showTab('policies')">Policies</button>
                </div>

                <!-- FAQ Tab -->
                <div id="questions-tab" class="tab-content p-4">
                    <div class="space-y-0">
                        <div class="accordion-item border-b border-gray-200 last:border-b-0">
                            <button class="accordion-header w-full py-4 text-left text-sm font-medium flex justify-between items-center" onclick="toggleAccordion(this)">
                                What skill level is required for the Karapoti Trail?
                                <span class="accordion-icon text-xl transition-transform">+</span>
                            </button>
                            <div class="accordion-content max-h-0 overflow-hidden transition-all duration-300">
                                <p class="text-sm text-gray-700 leading-relaxed pb-4">The Karapoti Trail is designed for intermediate to advanced mountain bikers. You should be comfortable riding technical single track, navigating roots and rocks, and handling moderate to challenging climbs. Strong beginners with some off-road experience can participate with proper preparation.</p>
                            </div>
                        </div>

                        <div class="accordion-item border-b border-gray-200 last:border-b-0">
                            <button class="accordion-header w-full py-4 text-left text-sm font-medium flex justify-between items-center" onclick="toggleAccordion(this)">
                                Do I need to bring my own mountain bike?
                                <span class="accordion-icon text-xl transition-transform">+</span>
                            </button>
                            <div class="accordion-content max-h-0 overflow-hidden transition-all duration-300">
                                <p class="text-sm text-gray-700 leading-relaxed pb-4">No, high-quality full suspension mountain bikes are included in the package. We offer various sizes and can adjust the setup to your preferences. If you prefer to bring your own bike, we can arrange shipping logistics for an additional fee.</p>
                            </div>
                        </div>

                        <div class="accordion-item border-b border-gray-200 last:border-b-0">
                            <button class="accordion-header w-full py-4 text-left text-sm font-medium flex justify-between items-center" onclick="toggleAccordion(this)">
                                When is the best time to ride in New Zealand?
                                <span class="accordion-icon text-xl transition-transform">+</span>
                            </button>
                            <div class="accordion-content max-h-0 overflow-hidden transition-all duration-300">
                                <p class="text-sm text-gray-700 leading-relaxed pb-4">The prime mountain biking season is from November to April (summer and early autumn in the Southern Hemisphere). February and March typically offer the most stable weather conditions with warm temperatures and less rainfall, making it ideal for the Karapoti Trail.</p>
                            </div>
                        </div>

                        <div class="accordion-item border-b border-gray-200 last:border-b-0">
                            <button class="accordion-header w-full py-4 text-left text-sm font-medium flex justify-between items-center" onclick="toggleAccordion(this)">
                                Can I participate in the Trek Karapoti Classic?
                                <span class="accordion-icon text-xl transition-transform">+</span>
                            </button>
                            <div class="accordion-content max-h-0 overflow-hidden transition-all duration-300">
                                <p class="text-sm text-gray-700 leading-relaxed pb-4">Yes! If your trip coincides with the event (usually held in early March), we'll handle your registration and provide race-day support. The Karapoti Classic is New Zealand's oldest mountain bike race and a fantastic experience for enthusiasts.</p>
                            </div>
                        </div>

                        <div class="accordion-item border-b border-gray-200 last:border-b-0">
                            <button class="accordion-header w-full py-4 text-left text-sm font-medium flex justify-between items-center" onclick="toggleAccordion(this)">
                                What should I pack for the mountain biking trip?
                                <span class="accordion-icon text-xl transition-transform">+</span>
                            </button>
                            <div class="accordion-content max-h-0 overflow-hidden transition-all duration-300">
                                <p class="text-sm text-gray-700 leading-relaxed pb-4">Bring your own helmet (or use ours), cycling shorts/pants, jerseys, gloves, cycling shoes, rain jacket, casual clothes, and personal items. New Zealand weather can change quickly, so layers are essential. A detailed packing list will be provided upon booking.</p>
                            </div>
                        </div>

                        <div class="accordion-item border-b border-gray-200 last:border-b-0">
                            <button class="accordion-header w-full py-4 text-left text-sm font-medium flex justify-between items-center" onclick="toggleAccordion(this)">
                                How challenging is the 31-mile Karapoti Trail?
                                <span class="accordion-icon text-xl transition-transform">+</span>
                            </button>
                            <div class="accordion-content max-h-0 overflow-hidden transition-all duration-300">
                                <p class="text-sm text-gray-700 leading-relaxed pb-4">The Karapoti Trail is considered moderately challenging with technical single track sections, fire road climbs, and varied terrain. Most riders complete it in 3-6 hours depending on fitness level and trail conditions. There are several rest points with scenic vistas along the way.</p>
                            </div>
                        </div>

                        <div class="accordion-item border-b border-gray-200 last:border-b-0">
                            <button class="accordion-header w-full py-4 text-left text-sm font-medium flex justify-between items-center" onclick="toggleAccordion(this)">
                                Are there other trails available in Upper Hutt?
                                <span class="accordion-icon text-xl transition-transform">+</span>
                            </button>
                            <div class="accordion-content max-h-0 overflow-hidden transition-all duration-300">
                                <p class="text-sm text-gray-700 leading-relaxed pb-4">Yes! Upper Hutt offers over 100km of mountain biking trails ranging from beginner-friendly to expert level. Popular alternatives include the Tunnel Gully Track, Whakatiki Track, and various trails in the Rimutaka Forest Park. Our guides can recommend trails based on your skill level.</p>
                            </div>
                        </div>

                        <div class="accordion-item border-b border-gray-200 last:border-b-0">
                            <button class="accordion-header w-full py-4 text-left text-sm font-medium flex justify-between items-center" onclick="toggleAccordion(this)">
                                What wildlife might I encounter on the trails?
                                <span class="accordion-icon text-xl transition-transform">+</span>
                            </button>
                            <div class="accordion-content max-h-0 overflow-hidden transition-all duration-300">
                                <p class="text-sm text-gray-700 leading-relaxed pb-4">You may encounter native New Zealand birds like tui, bellbirds, and fantails. The native bush is home to various insects and occasionally you might spot native geckos. Always respect wildlife and maintain a safe distance. The trails pass through beautiful native forest ecosystems.</p>
                            </div>
                        </div>

                        <div class="accordion-item border-b border-gray-200 last:border-b-0">
                            <button class="accordion-header w-full py-4 text-left text-sm font-medium flex justify-between items-center" onclick="toggleAccordion(this)">
                                What are the weather concerns for mountain biking?
                                <span class="accordion-icon text-xl transition-transform">+</span>
                            </button>
                            <div class="accordion-content max-h-0 overflow-hidden transition-all duration-300">
                                <p class="text-sm text-gray-700 leading-relaxed pb-4">New Zealand weather can change rapidly, especially in the mountains. Rain can make trails slippery and muddy. We monitor weather conditions closely and may adjust routes or reschedule rides for safety. Always be prepared with rain gear and warm layers.</p>
                            </div>
                        </div>

                        <div class="accordion-item border-b border-gray-200 last:border-b-0">
                            <button class="accordion-header w-full py-4 text-left text-sm font-medium flex justify-between items-center" onclick="toggleAccordion(this)">
                                Where can I stay near the trails?
                                <span class="accordion-icon text-xl transition-transform">+</span>
                            </button>
                            <div class="accordion-content max-h-0 overflow-hidden transition-all duration-300">
                                <p class="text-sm text-gray-700 leading-relaxed pb-4">Our package includes accommodation at the Upper Hutt Mountain Lodge. There are also various hotels, motels, and holiday parks in Upper Hutt and nearby Wellington. The area is well-connected with good access to trails and local amenities.</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Policies Tab -->
                <div id="policies-tab" class="tab-content p-4 hidden">
                    <div class="space-y-4">
                        <div class="policy-item">
                            <h4 class="font-bold mb-1">Booking & Payment</h4>
                            <p class="text-sm text-gray-700">30% deposit required at booking, with the remaining balance due 60 days before arrival. Full payment required for bookings made within 60 days of arrival. Payment can be made via credit card or bank transfer.</p>
                        </div>
                        <div class="policy-item">
                            <h4 class="font-bold mb-1">Cancellation Policy</h4>
                            <p class="text-sm text-gray-700">Full refund minus $250 admin fee if canceled 90+ days before arrival. 50% refund if canceled 60-89 days before arrival. No refund if canceled less than 60 days before arrival. Travel insurance is strongly recommended.</p>
                        </div>
                        <div class="policy-item">
                            <h4 class="font-bold mb-1">Weather Conditions</h4>
                            <p class="text-sm text-gray-700">Riding may be rescheduled due to unsafe weather conditions. New Zealand weather can change rapidly, so be prepared for all conditions. No refunds for poor weather, but guides will arrange alternative activities when possible.</p>
                        </div>
                        <div class="policy-item">
                            <h4 class="font-bold mb-1">Trail Safety</h4>
                            <p class="text-sm text-gray-700">Helmets are mandatory for all riders. Riders must follow guide instructions and stay on designated trails. Mountain biking involves inherent risks, and participants ride at their own risk. Basic first aid training is provided to all guides.</p>
                        </div>
                        <div class="policy-item">
                            <h4 class="font-bold mb-1">Environmental Responsibility</h4>
                            <p class="text-sm text-gray-700">We follow Leave No Trace principles. Stay on designated trails to protect native vegetation. Pack out all rubbish and respect wildlife. Some trails may have seasonal closures to protect nesting birds or during hunting seasons.</p>
                        </div>
                        <div class="policy-item">
                            <h4 class="font-bold mb-1">Insurance Requirements</h4>
                            <p class="text-sm text-gray-700">Comprehensive travel and medical insurance with mountain biking coverage is required for all participants. Proof of insurance must be provided before the trip. Coverage should include emergency evacuation and repatriation.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

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

    <script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js"></script>
    <script>
        // Tab functionality
        function showTab(tabName) {
            const tabContents = document.querySelectorAll('.tab-content');
            tabContents.forEach(content => {
                content.classList.add('hidden');
            });

            const tabButtons = document.querySelectorAll('.tab-button');
            tabButtons.forEach(button => {
                button.classList.remove('bg-white');
                button.classList.add('bg-gray-50');
            });

            document.getElementById(tabName + '-tab').classList.remove('hidden');
            event.target.classList.remove('bg-gray-50');
            event.target.classList.add('bg-white');
        }

        // Accordion functionality
        function toggleAccordion(header) {
            const item = header.parentElement;
            const content = item.querySelector('.accordion-content');
            const icon = item.querySelector('.accordion-icon');
            const isActive = content.style.maxHeight && content.style.maxHeight !== '0px';

            // Close all accordion items
            document.querySelectorAll('.accordion-content').forEach(content => {
                content.style.maxHeight = '0px';
            });
            document.querySelectorAll('.accordion-icon').forEach(icon => {
                icon.style.transform = 'rotate(0deg)';
            });

            // If the clicked item wasn't active, open it
            if (!isActive) {
                content.style.maxHeight = content.scrollHeight + 'px';
                icon.style.transform = 'rotate(45deg)';
            }
        }

        // Initialize map
        function initMap() {
            const upperHuttCoords = [-41.1242, 175.0723];

            const map = L.map('map').setView(upperHuttCoords, 11);

            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '&copy; <a href="https://www.openstreetmap.org/">OpenStreetMap</a> contributors'
            }).addTo(map);

            L.marker(upperHuttCoords)
                .addTo(map)
                .bindPopup('Upper Hutt, New Zealand')
                .openPopup();
        }

        // Initialize when page loads
        document.addEventListener('DOMContentLoaded', function() {
            if (typeof L !== 'undefined') {
                initMap();
            }
        });
    </script>
</body>

</html>