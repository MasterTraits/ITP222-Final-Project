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
        <img src="/assets/destinations/palawan.jpg" alt="Boracay Island" class="inset-0 w-full h-full object-cover object-center">
        </div>
        <div class="absolute bottom-4 w-full max-w-6xl flex items-center justify-between px-4">
            <h1 class="text-5xl font-bold mb-2 drop-shadow-lg text-white">El Nido, Palawan, Philippines</h1>
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
                    <h2 class="text-3xl font-bold">₱22,500</h2>
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
                            <div class="text-sm">Manila, Philippines</div>
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
                            <div class="text-sm">May 23 - June 3</div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Rating -->
            <div class="flex items-center gap-2 bg-gray-50 p-3 rounded-md">
                <span class="text-sm font-medium">Great</span>
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
                <img src="/assets/details/palawan-diving.jpg" class="h-50 w-full border-gray-300 bg-gradient-to-br from-cyan-500 to-sky-500 rounded-md flex items-center justify-center text-white text-sm font-medium object-cover">
                <img src="/assets/details/palawan-tutel.jpg" class="h-50 w-full border-gray-300 bg-gradient-to-br from-cyan-500 to-sky-500 rounded-md flex items-center justify-center text-white text-sm font-medium object-cover">
                <img src="/assets/details/palawan2.jpg" class="h-50 w-full border-gray-300 bg-gradient-to-br from-cyan-500 to-sky-500 rounded-md flex items-center justify-center text-white text-sm font-medium object-cover">
            </div>

            <!-- Description -->
            <div>
                <p class="text-gray-700 leading-relaxed">Palawan is a breathtaking sanctuary of unspoiled nature, where jagged limestone cliffs rise above turquoise waters, underground rivers carve through lush forests, and every island feels like a hidden paradise untouched by time</p>
            </div>

            <!-- Fun Facts -->
            <div class="border border-gray-200 rounded-lg p-6">
                <div class="flex items-center gap-2 mb-4">
                    <svg class="text-amber-400" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M9 21h6"></path>
                        <path d="M12 17v4"></path>
                        <path d="M12 3a6 6 0 0 1 6 6c0 3-2 5.5-2 8H8c0-2.5-2-5-2-8a6 6 0 0 1 6-6z"></path>
                    </svg>
                    <h3 class="text-lg font-bold">Fun Facts!</h3>
                </div>
                <ol class="list-decimal list-inside space-y-3 text-sm">
                    <li><strong>UNESCO World Heritage Site:</strong> The Puerto Princesa Subterranean River is one of the New 7 Wonders of Nature.</li>
                    <li><strong>Diverse Marine Life:</strong> Palawan has one of the richest marine biodiversity in the world, especially in Tubbataha Reefs Natural Park.</li>
                    <li><strong>El Nido and Coron:</strong> Famous for limestone cliffs, clear lagoons, and WWII shipwreck diving spots.</li>
                    <li><strong>Eco-Friendly Province:</strong> Palawan consistently ranks as one of the cleanest and greenest provinces in the Philippines.</li>
                    <li><strong>Malampaya Sound:</strong> Known as the <em>"fish bowl of the Philippines"</em> for its abundant fish supply.</li>
                </ol>
            </div>

            <!-- Reviews -->
            <div class="space-y-6">
                <h3 class="text-xl font-bold">Our Reviews</h3>
                <div class="flex items-center gap-4 mb-6">
                    <div class="text-4xl font-bold">4.5</div>
                    <div>
                        <div class="flex">
                            <span class="text-amber-400 text-xl">★</span>
                            <span class="text-amber-400 text-xl">★</span>
                            <span class="text-amber-400 text-xl">★</span>
                            <span class="text-amber-400 text-xl">★</span>
                            <span class="text-amber-400 text-xl bg-gradient-to-r from-amber-400 to-gray-300 bg-clip-text text-transparent">★</span>
                        </div>
                        <div class="text-sm text-gray-600">Out of 5 Stars</div>
                        <div class="text-xs text-gray-400">Overall rating of 50 reviews</div>
                    </div>
                </div>

                <!-- Rating Bars -->
                <div class="space-y-2">
                    <div class="flex items-center gap-2">
                        <div class="w-12 text-sm">5 Stars</div>
                        <div class="flex-1 bg-gray-200 h-2 rounded-full overflow-hidden">
                            <div class="bg-blue-500 h-full rounded-full" style="width: 70%"></div>
                        </div>
                        <div class="w-8 text-right text-sm text-gray-600">230</div>
                    </div>
                    <div class="flex items-center gap-2">
                        <div class="w-12 text-sm">4 Stars</div>
                        <div class="flex-1 bg-gray-200 h-2 rounded-full overflow-hidden">
                            <div class="bg-blue-500 h-full rounded-full" style="width: 20%"></div>
                        </div>
                        <div class="w-8 text-right text-sm text-gray-600">57</div>
                    </div>
                    <div class="flex items-center gap-2">
                        <div class="w-12 text-sm">3 Stars</div>
                        <div class="flex-1 bg-gray-200 h-2 rounded-full overflow-hidden">
                            <div class="bg-blue-500 h-full rounded-full" style="width: 10%"></div>
                        </div>
                        <div class="w-8 text-right text-sm text-gray-600">30</div>
                    </div>
                    <div class="flex items-center gap-2">
                        <div class="w-12 text-sm">2 Stars</div>
                        <div class="flex-1 bg-gray-200 h-2 rounded-full overflow-hidden">
                            <div class="bg-blue-500 h-full rounded-full" style="width: 5%"></div>
                        </div>
                        <div class="w-8 text-right text-sm text-gray-600">7</div>
                    </div>
                    <div class="flex items-center gap-2">
                        <div class="w-12 text-sm">1 Stars</div>
                        <div class="flex-1 bg-gray-200 h-2 rounded-full overflow-hidden">
                            <div class="bg-blue-500 h-full rounded-full" style="width: 8%"></div>
                        </div>
                        <div class="w-8 text-right text-sm text-gray-600">23</div>
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
                                Is El Nido Beach pet-friendly?
                                <span class="accordion-icon text-xl transition-transform">+</span>
                            </button>
                            <div class="accordion-content max-h-0 overflow-hidden transition-all duration-300">
                                <p class="text-sm text-gray-700 leading-relaxed pb-4">Some areas of El Nido Beach and a few resorts allow pets, but policies vary. It's best to check with your specific accommodation ahead of time. Always keep pets leashed and clean up after them.</p>
                            </div>
                        </div>

                        <div class="accordion-item border-b border-gray-200 last:border-b-0">
                            <button class="accordion-header w-full py-4 text-left text-sm font-medium flex justify-between items-center" onclick="toggleAccordion(this)">
                                Is there parking available at El Nido Beach?
                                <span class="accordion-icon text-xl transition-transform">+</span>
                            </button>
                            <div class="accordion-content max-h-0 overflow-hidden transition-all duration-300">
                                <p class="text-sm text-gray-700 leading-relaxed pb-4">Parking is limited in the town proper, especially near the beachfront. Some hotels and resorts offer private parking, but public parking can be scarce. Early arrival is recommended if you have a vehicle.</p>
                            </div>
                        </div>

                        <div class="accordion-item border-b border-gray-200 last:border-b-0">
                            <button class="accordion-header w-full py-4 text-left text-sm font-medium flex justify-between items-center" onclick="toggleAccordion(this)">
                                When is the best time to go swimming at El Nido beach?
                                <span class="accordion-icon text-xl transition-transform">+</span>
                            </button>
                            <div class="accordion-content max-h-0 overflow-hidden transition-all duration-300">
                                <p class="text-sm text-gray-700 leading-relaxed pb-4">The best time to swim is between <strong>December and May</strong>, during the dry season. For calm waters, swim in the morning (7 AM to 11 AM) when the tide is moderate and the sun isn't too strong.</p>
                            </div>
                        </div>

                        <div class="accordion-item border-b border-gray-200 last:border-b-0">
                            <button class="accordion-header w-full py-4 text-left text-sm font-medium flex justify-between items-center" onclick="toggleAccordion(this)">
                                Is there a curfew for swimming at El Nido Beach?
                                <span class="accordion-icon text-xl transition-transform">+</span>
                            </button>
                            <div class="accordion-content max-h-0 overflow-hidden transition-all duration-300">
                                <p class="text-sm text-gray-700 leading-relaxed pb-4">There's no official swimming curfew, but for safety reasons, swimming is discouraged <strong>after dark</strong>. Lifeguards are usually not present, and some areas have strong currents at night.</p>
                            </div>
                        </div>

                        <div class="accordion-item border-b border-gray-200 last:border-b-0">
                            <button class="accordion-header w-full py-4 text-left text-sm font-medium flex justify-between items-center" onclick="toggleAccordion(this)">
                                Is there public transportation available to nearby hotels from El Nido Beach?
                                <span class="accordion-icon text-xl transition-transform">+</span>
                            </button>
                            <div class="accordion-content max-h-0 overflow-hidden transition-all duration-300">
                                <p class="text-sm text-gray-700 leading-relaxed pb-4">Yes. <strong>Tricycles</strong> are the main form of local transportation and are readily available near the beach. Some resorts also offer shuttle services for pick-up and drop-off.</p>
                            </div>
                        </div>

                        <div class="accordion-item border-b border-gray-200 last:border-b-0">
                            <button class="accordion-header w-full py-4 text-left text-sm font-medium flex justify-between items-center" onclick="toggleAccordion(this)">
                                Where is El Nido Beach located?
                                <span class="accordion-icon text-xl transition-transform">+</span>
                            </button>
                            <div class="accordion-content max-h-0 overflow-hidden transition-all duration-300">
                                <p class="text-sm text-gray-700 leading-relaxed pb-4">El Nido Beach is located in <strong>El Nido town</strong>, in the northern part of <strong>Palawan, Philippines</strong>. It faces Bacuit Bay and is surrounded by dramatic limestone cliffs and island scenery.</p>
                            </div>
                        </div>

                        <div class="accordion-item border-b border-gray-200 last:border-b-0">
                            <button class="accordion-header w-full py-4 text-left text-sm font-medium flex justify-between items-center" onclick="toggleAccordion(this)">
                                Are there ATMs or money changers near El Nido Beach?
                                <span class="accordion-icon text-xl transition-transform">+</span>
                            </button>
                            <div class="accordion-content max-h-0 overflow-hidden transition-all duration-300">
                                <p class="text-sm text-gray-700 leading-relaxed pb-4">Yes, but they are limited. There are a few <strong>ATMs and money changers</strong> in the town proper. It's a good idea to bring enough <strong>cash</strong>, especially if visiting nearby islands where electronic payments are not accepted.</p>
                            </div>
                        </div>

                        <div class="accordion-item border-b border-gray-200 last:border-b-0">
                            <button class="accordion-header w-full py-4 text-left text-sm font-medium flex justify-between items-center" onclick="toggleAccordion(this)">
                                Can I rent snorkeling or diving gear at El Nido Beach?
                                <span class="accordion-icon text-xl transition-transform">+</span>
                            </button>
                            <div class="accordion-content max-h-0 overflow-hidden transition-all duration-300">
                                <p class="text-sm text-gray-700 leading-relaxed pb-4">Yes. Several dive shops and tour operators offer <strong>snorkeling and scuba gear rentals</strong>. Most island-hopping tours also include basic gear as part of the package.</p>
                            </div>
                        </div>

                        <div class="accordion-item border-b border-gray-200 last:border-b-0">
                            <button class="accordion-header w-full py-4 text-left text-sm font-medium flex justify-between items-center" onclick="toggleAccordion(this)">
                                Are there restaurants or food stalls near El Nido Beach?
                                <span class="accordion-icon text-xl transition-transform">+</span>
                            </button>
                            <div class="accordion-content max-h-0 overflow-hidden transition-all duration-300">
                                <p class="text-sm text-gray-700 leading-relaxed pb-4">El Nido town has a wide range of dining options, from <strong>beachfront restaurants</strong> to <strong>local eateries</strong> serving Filipino and international cuisine.</p>
                            </div>
                        </div>

                        <div class="accordion-item border-b border-gray-200 last:border-b-0">
                            <button class="accordion-header w-full py-4 text-left text-sm font-medium flex justify-between items-center" onclick="toggleAccordion(this)">
                                Is El Nido Beach safe for solo travelers?
                                <span class="accordion-icon text-xl transition-transform">+</span>
                            </button>
                            <div class="accordion-content max-h-0 overflow-hidden transition-all duration-300">
                                <p class="text-sm text-gray-700 leading-relaxed pb-4">Yes, El Nido is generally safe for solo travelers. The locals are friendly and helpful, and the town has a laid-back vibe. Still, as with any destination, it's wise to stay alert and take basic safety precautions.</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Policies Tab -->
                <div id="policies-tab" class="tab-content p-4 hidden">
                    <div class="space-y-4">
                        <div class="policy-item">
                            <h4 class="font-bold mb-1">No Touching or Taking of Marine Life</h4>
                            <p class="text-sm text-gray-700">Touching coral reefs, collecting seashells, and disturbing wildlife (especially in El Nido and Tubbataha) are strictly prohibited.</p>
                        </div>
                        <div class="policy-item">
                            <h4 class="font-bold mb-1">Waste Segregation and Disposal</h4>
                            <p class="text-sm text-gray-700">Visitors and businesses must follow strict waste segregation rules and are responsible for properly disposing of their trash.</p>
                        </div>
                        <div class="policy-item">
                            <h4 class="font-bold mb-1">Eco-Tourism Fees and Permits</h4>
                            <p class="text-sm text-gray-700">Tourists are required to pay environmental fees and secure permits for activities like island hopping and trekking.</p>
                        </div>
                        <div class="policy-item">
                            <h4 class="font-bold mb-1">No Anchoring on Coral Reefs</h4>
                            <p class="text-sm text-gray-700">Boats must use designated mooring buoys to prevent anchor damage to coral reefs, especially in protected marine areas.</p>
                        </div>
                        <div class="policy-item">
                            <h4 class="font-bold mb-1">Ban on Single-Use Plastics</h4>
                            <p class="text-sm text-gray-700">Many towns (like El Nido and Coron) have implemented bans on plastic bags, straws, and other single-use plastics to reduce pollution.</p>
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
            const palawanCoords = [9.7392, 118.7312];
            
            const map = L.map('map').setView(palawanCoords, 8);
            
            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '&copy; <a href="https://www.openstreetmap.org/">OpenStreetMap</a> contributors'
            }).addTo(map);
            
            L.marker(palawanCoords)
                .addTo(map)
                .bindPopup('Palawan, Philippines')
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