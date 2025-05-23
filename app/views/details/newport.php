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
    <!-- Navigation Bar -->
    <header class="bg-white/80 backdrop-blur-md fixed w-full top-0 z-[9999] border-b border-gray-200">
        <nav class="rounded-tl-lg rounded-br-lg shadow-lg px-4 py-2 w-[95%] max-w-5xl   
    bg-[var(--bg-transparent-light)] backdrop-blur-md border border-[#E2E8F0] 
    fixed top-5 left-1/2 transform -translate-x-1/2 z-40
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
                            <p class="text-sm text-[var,--text-dark)]">Redeem your travel vouchers before they expire</p>
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
    </header>

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

    <section class="relative w-full relative h-96 flex flex-col items-center justify-center">
        <img src="/assets/details/newport.png" alt="Boracay Island" class="inset-0 w-full h-full object-cover object-center">
        </div>
        <div class="absolute bottom-4 w-full max-w-6xl flex items-center justify-between px-4">
            <h1 class="text-5xl font-bold mb-2 drop-shadow-lg text-white">Newport Beach, California</h1>
            <a href="/book/1" class="bg-[var(--gold)] hover:bg-amber-300 text-black font-medium px-6 py-3 rounded-lg flex items-center gap-2 transition-colors">
                <span>🏖️</span> Book Now
            </a>
        </div>
    </section>


    <!-- Main Content -->
    <div class="max-w-6xl mx-auto px-4 py-8 grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Left Column - Main Content -->
        <div class="lg:col-span-2 space-y-8">
            <!-- Price and Location -->
            <div class="space-y-4">
                <div class="flex items-center gap-2">
                    <h2 class="text-3xl font-bold">₱75,000</h2>
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
                            <div class="text-sm">Newport Beach, CA</div>
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
                            <div class="text-sm">July 15 - July 22</div>
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
                    <span class="="text-amber-400 text-xl">★</span>
                    <span class="text-amber-400 text-xl">★</span>
                </div>
            </div>

            <!-- Image Gallery -->
            <div class="grid grid-cols-3 gap-2 h-48">
                <img src="/assets/destinations/newport.jpg" class="h-50 w-full border-gray-300 bg-gradient-to-br from-cyan-500 to-sky-500 rounded-md flex items-center justify-center text-white text-sm font-medium">
                <img src="/assets/details/newport2.webp" class="h-50 w-full border-gray-300 bg-gradient-to-br from-cyan-500 to-sky-500 rounded-md flex items-center justify-center text-white text-sm font-medium">
            </div>

            <!-- Description -->
            <div>
                <p class="text-gray-700 leading-relaxed">Newport Beach is a coastal paradise in Southern California, offering pristine beaches, world-class surfing, and a laid-back luxury lifestyle. With 10 miles of stunning coastline, charming villages, and a perfect Mediterranean climate, it's an ideal destination for beach lovers, water sports enthusiasts, and those seeking a sophisticated coastal getaway.</p>
            </div>

            <!-- Fun Facts -->
            <div class="border border-gray-200 rounded-lg p-6 from-amber-50 to-amber-100">
                <div class="flex items-center gap-2 mb-4">
                    <svg class="text-amber-500" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M9 21h6"></path>
                        <path d="M12 17v4"></path>
                        <path d="M12 3a6 6 0 0 1 6 6c0 3-2 5.5-2 8H8c0-2.5-2-5-2-8a6 6 0 0 1 6-6z"></path>
                    </svg>
                    <h3 class="text-lg font-bold text-amber-800">Fun Facts!</h3>
                </div>
                <ol class="list-decimal list-inside space-y-3 text-smtext-amber-800">
                    <li><strong>The Wedge:</strong> Newport Beach is home to "The Wedge," one of the most famous bodysurfing spots in the world, known for its massive waves that can reach heights of 30 feet.</li>
                    <li><strong>Balboa Island:</strong> This man-made island features a charming marine village and is famous for its frozen bananas and Balboa Bars, which inspired treats on the TV show "Arrested Development."</li>
                    <li><strong>Newport Harbor:</strong> One of the largest recreational boat harbors on the U.S. west coast, with nearly 9,000 boats and a rich maritime history dating back to the early 1900s.</li>
                    <li><strong>Celebrity Haven:</strong> Newport Beach has been home to many celebrities, including John Wayne, whose former yacht, the Wild Goose, still cruises the harbor today.</li>
                    <li><strong>Film Location:</strong> The area has been featured in numerous TV shows and movies, including "The O.C.," "Beaches," and "Gilligan's Island" (the opening scenes).</li>
                </ol>
            </div>

            <!-- Reviews -->
            <div class="space-y-6">
                <h3 class="text-xl font-bold">Our Reviews</h3>
                <div class="flex items-center gap-4 mb-6">
                    <div class="text-4xl font-bold">4.8</div>
                    <div>
                        <div class="flex">
                            <span class="text-amber-400 text-xl">★</span>
                            <span class="text-amber-400 text-xl">★</span>
                            <span class="text-amber-400 text-xl">★</span>
                            <span class="text-amber-400 text-xl">★</span>
                            <span class="text-amber-400 text-xl bg-gradient-to-r from-amber-400 to-gray-300 bg-clip-text text-transparent">★</span>
                        </div>
                        <div class="text-sm text-gray-600">Out of 5 Stars</div>
                        <div class="text-xs text-gray-400">Overall rating of 78 reviews</div>
                    </div>
                </div>

                <!-- Rating Bars -->
                <div class="space-y-2">
                    <div class="flex items-center gap-2">
                        <div class="w-12 text-sm">5 Stars</div>
                        <div class="flex-1 bg-gray-200 h-2 rounded-full overflow-hidden">
                            <div class="bg-blue-500 h-full rounded-full" style="width: 75%"></div>
                        </div>
                        <div class="w-8 text-right text-sm text-gray-600">58</div>
                    </div>
                    <div class="flex items-center gap-2">
                        <div class="w-12 text-sm">4 Stars</div>
                        <div class="flex-1 bg-gray-200 h-2 rounded-full overflow-hidden">
                            <div class="bg-blue-500 h-full rounded-full" style="width: 15%"></div>
                        </div>
                        <div class="w-8 text-right text-sm text-gray-600">12</div>
                    </div>
                    <div class="flex items-center gap-2">
                        <div class="w-12 text-sm">3 Stars</div>
                        <div class="flex-1 bg-gray-200 h-2 rounded-full overflow-hidden">
                            <div class="bg-blue-500 h-full rounded-full" style="width: 6%"></div>
                        </div>
                        <div class="w-8 text-right text-sm text-gray-600">5</div>
                    </div>
                    <div class="flex items-center gap-2">
                        <div class="w-12 text-sm">2 Stars</div>
                        <div class="flex-1 bg-gray-200 h-2 rounded-full overflow-hidden">
                            <div class="bg-blue-500 h-full rounded-full" style="width: 2%"></div>
                        </div>
                        <div class="w-8 text-right text-sm text-gray-600">2</div>
                    </div>
                    <div class="flex items-center gap-2">
                        <div class="w-12 text-sm">1 Stars</div>
                        <div class="flex-1 bg-gray-200 h-2 rounded-full overflow-hidden">
                            <div class="bg-blue-500 h-full rounded-full" style="width: 1%"></div>
                        </div>
                        <div class="w-8 text-right text-sm text-gray-600">1</div>
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
                                When's the best time to visit Newport Beach?
                                <span class="accordion-icon text-xl transition-transform">+</span>
                            </button>
                            <div class="accordion-content max-h-0 overflow-hidden transition-all duration-300">
                                <p class="text-sm text-gray-700 leading-relaxed pb-4">Newport Beach enjoys beautiful weather year-round, but the best time to visit is from <strong>June to October</strong> when temperatures are warm and rainfall is minimal. September and October offer fewer crowds with still-perfect beach weather.</p>
                            </div>
                        </div>

                        <div class="accordion-item border-b border-gray-200 last:border-b-0">
                            <button class="accordion-header w-full py-4 text-left text-sm font-medium flex justify-between items-center" onclick="toggleAccordion(this)">
                                Where are the best surfing spots in Newport Beach?
                                <span class="accordion-icon text-xl transition-transform">+</span>
                            </button>
                            <div class="accordion-content max-h-0 overflow-hidden transition-all duration-300">
                                <p class="text-sm text-gray-700 leading-relaxed pb-4">Newport Beach offers several excellent surfing spots: <strong>The Wedge</strong> (for experienced surfers only), <strong>56th Street</strong> (great for intermediate surfers), <strong>Blackies</strong> near Newport Pier (good for beginners), and <strong>Echo Beach</strong> between 52nd and 56th streets.</p>
                            </div>
                        </div>

                        <div class="accordion-item border-b border-gray-200 last:border-b-0">
                            <button class="accordion-header w-full py-4 text-left text-sm font-medium flex justify-between items-center" onclick="toggleAccordion(this)">
                                Is Newport Beach family-friendly?
                                <span class="accordion-icon text-xl transition-transform">+</span>
                            </button>
                            <div class="accordion-content max-h-0 overflow-hidden transition-all duration-300">
                                <p class="text-sm text-gray-700 leading-relaxed pb-4">Yes, Newport Beach is very family-friendly with calm beaches like <strong>Corona del Mar State Beach</strong>, the <strong>Balboa Fun Zone</strong> with rides and games, <strong>ExplorOcean</strong> interactive maritime museum, and numerous parks and playgrounds throughout the city.</p>
                            </div>
                        </div>

                        <div class="accordion-item border-b border-gray-200 last:border-b-0">
                            <button class="accordion-header w-full py-4 text-left text-sm font-medium flex justify-between items-center" onclick="toggleAccordion(this)">
                                How do I get around Newport Beach?
                                <span class="accordion-icon text-xl transition-transform">+</span>
                            </button>
                            <div class="accordion-content max-h-0 overflow-hidden transition-all duration-300">
                                <p class="text-sm text-gray-700 leading-relaxed pb-4">Newport Beach offers several transportation options: rent a car for flexibility, use rideshare services like Uber and Lyft, take the seasonal trolley service (summer months), rent bicycles for the extensive bike paths, or enjoy the Balboa Island Ferry for crossing the harbor.</p>
                            </div>
                        </div>

                        <div class="accordion-item border-b border-gray-200 last:border-b-0">
                            <button class="accordion-header w-full py-4 text-left text-sm font-medium flex justify-between items-center" onclick="toggleAccordion(this)">
                                What are the must-visit beaches in Newport Beach?
                                <span class="accordion-icon text-xl transition-transform">+</span>
                            </button>
                            <div class="accordion-content max-h-0 overflow-hidden transition-all duration-300">
                                <p class="text-sm text-gray-700 leading-relaxed pb-4">Don't miss <strong>Corona del Mar State Beach</strong> (family-friendly with tide pools), <strong>Crystal Cove State Park</strong> (historic cottages and natural beauty), <strong>The Wedge</strong> (famous for huge waves), and <strong>Balboa Peninsula Beach</strong> (lively atmosphere with Newport and Balboa piers).</p>
                            </div>
                        </div>

                        <div class="accordion-item border-b border-gray-200 last:border-b-0">
                            <button class="accordion-header w-full py-4 text-left text-sm font-medium flex justify-between items-center" onclick="toggleAccordion(this)">
                                Where can I rent surf equipment?
                                <span class="accordion-icon text-xl transition-transform">+</span>
                            </button>
                            <div class="accordion-content max-h-0 overflow-hidden transition-all duration-300">
                                <p class="text-sm text-gray-700 leading-relaxed pb-4">Several shops offer surf equipment rentals including <strong>Blackies by the Sea</strong> near Newport Pier, <strong>The Newport Surf Shop</strong> on the peninsula, and <strong>Endless Sun Surf School</strong> which offers both rentals and lessons for beginners.</p>
                            </div>
                        </div>

                        <div class="accordion-item border-b border-gray-200 last:border-b-0">
                            <button class="accordion-header w-full py-4 text-left text-sm font-medium flex justify-between items-center" onclick="toggleAccordion(this)">
                                What dining experiences shouldn't I miss?
                                <span class="accordion-icon text-xl transition-transform">+</span>
                            </button>
                            <div class="accordion-content max-h-0 overflow-hidden transition-all duration-300">
                                <p class="text-sm text-gray-700 leading-relaxed pb-4">Newport Beach offers excellent dining options including <strong>waterfront restaurants</strong> along Mariner's Mile, <strong>seafood shacks</strong> on the Balboa Peninsula, <strong>upscale dining</strong> at Fashion Island, and don't miss trying a frozen banana on Balboa Island, a local specialty!</p>
                            </div>
                        </div>

                        <div class="accordion-item border-b border-gray-200 last:border-b-0">
                            <button class="accordion-header w-full py-4 text-left text-sm font-medium flex justify-between items-center" onclick="toggleAccordion(this)">
                                Is parking difficult in Newport Beach?
                                <span class="accordion-icon text-xl transition-transform">+</span>
                            </button>
                            <div class="accordion-content max-h-0 overflow-hidden transition-all duration-300">
                                <p class="text-sm text-gray-700 leading-relaxed pb-4">Parking can be challenging during summer and weekends. Most beaches have paid lots that fill up early. Street parking is available but often limited. Consider using rideshare services or the seasonal trolley during peak times. Some hotels offer shuttle services to popular destinations.</p>
                            </div>
                        </div>

                        <div class="accordion-item border-b border-gray-200 last:border-b-0">
                            <button class="accordion-header w-full py-4 text-left text-sm font-medium flex justify-between items-center" onclick="toggleAccordion(this)">
                                Are there any whale watching tours available?
                                <span class="accordion-icon text-xl transition-transform">+</span>
                            </button>
                            <div class="accordion-content max-h-0 overflow-hidden transition-all duration-300">
                                <p class="text-sm text-gray-700 leading-relaxed pb-4">Yes! Newport Beach is a top spot for whale watching. Companies like Newport Landing and Davey’s Locker offer year-round tours to see gray whales, blue whales, and dolphins.</p>
                            </div>
                        </div>

                        <div class="accordion-item border-b border-gray-200 last:border-b-0">
                            <button class="accordion-header w-full py-4 text-left text-sm font-medium flex justify-between items-center" onclick="toggleAccordion(this)">
                                Can I take a ferry to Balboa Island?
                                <span class="accordion-icon text-xl transition-transform">+</span>
                            </button>
                            <div class="accordion-content max-h-0 overflow-hidden transition-all duration-300">
                                <p class="text-sm text-gray-700 leading-relaxed pb-4">Absolutely! The Balboa Island Ferry offers a short and scenic ride for pedestrians, cyclists, and cars between Balboa Peninsula and Balboa Island, operating daily.</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Policies Tab -->
                <div id="policies-tab" class="tab-content p-4 hidden">
                    <div class="space-y-4">
                        <div class="policy-item">
                            <h4 class="font-bold mb-1">Beach Rules and Regulations</h4>
                            <p class="text-sm text-gray-700">Newport Beach enforces strict rules including no alcohol, no glass containers, no smoking, and dogs are only allowed on certain beaches at specific times. Beach hours are typically 6 AM to 10 PM.</p>
                        </div>
                        <div class="policy-item">
                            <h4 class="font-bold mb-1">Environmental Protection</h4>
                            <p class="text-sm text-gray-700">Help preserve Newport Beach's natural beauty by staying on designated paths in protected areas, properly disposing of trash, and not disturbing wildlife or collecting shells/marine life from tide pools.</p>
                        </div>
                        <div class="policy-item">
                            <h4 class="font-bold mb-1">Water Safety</h4>
                            <p class="text-sm text-gray-700">Always swim near lifeguard towers and obey posted flags and warnings. The Wedge has specific blackball hours (when boards are prohibited) during summer months to protect bodysurfers.</p>
                        </div>
                        <div class="policy-item">
                            <h4 class="font-bold mb-1">Boating and Harbor Regulations</h4>
                            <p class="text-sm text-gray-700">Newport Harbor has a strict 5 mph speed limit, no-wake zones, and requires permits for mooring. All watercraft must follow California boating laws and Coast Guard regulations.</p>
                        </div>
                        <div class="policy-item">
                            <h4 class="font-bold mb-1">Noise Ordinances</h4>
                            <p class="text-sm text-gray-700">Newport Beach enforces noise ordinances, particularly in residential areas. Quiet hours are generally from 10 PM to 7 AM, and excessive noise at any time may result in citations.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

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
            const newportCoords = [33.6189, -117.9298];

            const map = L.map('map').setView(newportCoords, 13);

            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '&copy; <a href="https://www.openstreetmap.org/">OpenStreetMap</a> contributors'
            }).addTo(map);

            L.marker(newportCoords)
                .addTo(map)
                .bindPopup('Newport Beach, California')
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