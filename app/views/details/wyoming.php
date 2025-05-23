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
    <section class="relative w-full relative h-96 flex flex-col items-center justify-center ">
        <img src="/assets/details/wyoming-mountains.jpg" alt="Boracay Island" class="inset-0 w-full h-full object-cover object-top">
        </div>
        <div class="absolute bottom-4 w-full max-w-6xl flex items-center justify-between px-4">
            <h1 class="text-5xl font-bold mb-2 drop-shadow-lg text-white">Devil's Tower, Wyoming, US</h1>
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
                    <h2 class="text-3xl font-bold">₱82,000</h2>
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
                            <div class="text-sm">Rapid City, South Dakota</div>
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
                            <div class="text-sm">Jul 10 - Jul 17</div>
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
                <img src="/assets/destinations/wyoming.jpg" class="h-50 w-full border-gray-300 bg-gradient-to-br from-cyan-500 to-sky-500 rounded-md flex items-center justify-center text-white text-sm font-medium">
                <img src="/assets/details/wyoming-acid.jpg" class="h-50 w-full border-gray-300 bg-gradient-to-br from-cyan-500 to-sky-500 rounded-md flex items-center justify-center text-white text-sm font-medium">
                <img src="/assets/details/wyoming-nature.jpg" class="h-50 w-full border-gray-300 bg-gradient-to-br from-cyan-500 to-sky-500 rounded-md flex items-center justify-center text-white text-sm font-medium">
            </div>

            <!-- Description -->
            <div class="space-y-4">
                <p class="text-gray-700 leading-relaxed">Wyoming's climbing Mecca, Devil's Tower, stands at 865 feet and offers the beginner or the expert 200 fun and challenging routes. (In fact, a 6-year-old boy conquered the tower in 1994.) The array of cracks in the walls allows you to use your imagination as you test your climbing skills.</p>
                <p class="text-gray-700 leading-relaxed">President Teddy Roosevelt named Devil's Tower the first national monument in 1906. Today, the park hosts approximately 450,000 visitors annually. And 5,000 of those visitors are climbers. But beware, environmentalists are trying to limit that number, so treat the park with respect.</p>
            </div>

            <!-- Fun Facts -->
            <div class="border border-gray-200 rounded-lg p-6">
                <div class="flex items-center gap-2 mb-4">
                    <svg class="text-amber-400" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M9 21h6"></path>
                        <path d="M12 17v4"></path>
                        <path d="M12 3a6 6 0 0 1 6 6c0 3-2 5.5-2 8H8c0-2.5-2-5-2-8a6 6 0 0 1 6-6z"></path>
                    </svg>
                    <h3 class="text-lg font-bold">Climbing Facts!</h3>
                </div>
                <ol class="list-decimal list-inside space-y-3 text-sm">
                    <li><strong>First National Monument:</strong> Devil's Tower was designated as America's first national monument by President Theodore Roosevelt in 1906.</li>
                    <li><strong>Youngest Climber:</strong> A 6-year-old boy successfully conquered the tower in 1994, proving that the routes accommodate all skill levels.</li>
                    <li><strong>200 Climbing Routes:</strong> The tower offers over 200 different climbing routes, ranging from beginner-friendly to expert-level challenges.</li>
                    <li><strong>Annual Climbers:</strong> Out of 450,000 annual visitors to the park, approximately 5,000 are dedicated climbers seeking the ultimate challenge.</li>
                    <li><strong>Unique Rock Formation:</strong> The tower's distinctive columnar basalt structure creates an array of natural cracks perfect for traditional climbing techniques.</li>
                </ol>
            </div>

            <!-- Reviews -->
            <div class="space-y-6">
                <h3 class="text-xl font-bold">Climber Reviews</h3>
                <div class="flex items-center gap-4 mb-6">
                    <div class="text-4xl font-bold">4.9</div>
                    <div>
                        <div class="flex">
                            <span class="text-amber-400 text-xl">★</span>
                            <span class="text-amber-400 text-xl">★</span>
                            <span class="text-amber-400 text-xl">★</span>
                            <span class="text-amber-400 text-xl">★</span>
                            <span class="text-amber-400 text-xl">★</span>
                        </div>
                        <div class="text-sm text-gray-600">Out of 5 Stars</div>
                        <div class="text-xs text-gray-400">Overall rating of 38 climbing reviews</div>
                    </div>
                </div>

                <!-- Rating Bars -->
                <div class="space-y-2">
                    <div class="flex items-center gap-2">
                        <div class="w-12 text-sm">5 Stars</div>
                        <div class="flex-1 bg-gray-200 h-2 rounded-full overflow-hidden">
                            <div class="bg-blue-500 h-full rounded-full" style="width: 90%"></div>
                        </div>
                        <div class="w-8 text-right text-sm text-gray-600">34</div>
                    </div>
                    <div class="flex items-center gap-2">
                        <div class="w-12 text-sm">4 Stars</div>
                        <div class="flex-1 bg-gray-200 h-2 rounded-full overflow-hidden">
                            <div class="bg-blue-500 h-full rounded-full" style="width: 10%"></div>
                        </div>
                        <div class="w-8 text-right text-sm text-gray-600">4</div>
                    </div>
                    <div class="flex items-center gap-2">
                        <div class="w-12 text-sm">3 Stars</div>
                        <div class="flex-1 bg-gray-200 h-2 rounded-full overflow-hidden">
                            <div class="bg-blue-500 h-full rounded-full" style="width: 0%"></div>
                        </div>
                        <div class="w-8 text-right text-sm text-gray-600">0</div>
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
                                What is the best time to climb Devil's Tower?
                                <span class="accordion-icon text-xl transition-transform">+</span>
                            </button>
                            <div class="accordion-content max-h-0 overflow-hidden transition-all duration-300">
                                <p class="text-sm text-gray-700 leading-relaxed pb-4">The best time to climb Devil's Tower is from late spring to early fall (May through September). June through August offers the most stable weather conditions. However, be aware that there is a voluntary climbing closure during the month of June out of respect for Native American cultural ceremonies.</p>
                            </div>
                        </div>

                        <div class="accordion-item border-b border-gray-200 last:border-b-0">
                            <button class="accordion-header w-full py-4 text-left text-sm font-medium flex justify-between items-center" onclick="toggleAccordion(this)">
                                Do I need a permit to climb Devil's Tower?
                                <span class="accordion-icon text-xl transition-transform">+</span>
                            </button>
                            <div class="accordion-content max-h-0 overflow-hidden transition-all duration-300">
                                <p class="text-sm text-gray-700 leading-relaxed pb-4">Yes, all climbers must register with the park by obtaining a free climbing permit at the Visitor Center before and after each climb. No advance reservations are needed for the permits. Climbers must also check out after completing their climb.</p>
                            </div>
                        </div>

                        <div class="accordion-item border-b border-gray-200 last:border-b-0">
                            <button class="accordion-header w-full py-4 text-left text-sm font-medium flex justify-between items-center" onclick="toggleAccordion(this)">
                                What skill level is required to climb Devil's Tower?
                                <span class="accordion-icon text-xl transition-transform">+</span>
                            </button>
                            <div class="accordion-content max-h-0 overflow-hidden transition-all duration-300">
                                <p class="text-sm text-gray-700 leading-relaxed pb-4">Devil's Tower offers routes for all skill levels, but most routes are rated 5.7 to 5.13 on the Yosemite Decimal System. Beginners should climb with an experienced guide. The most popular route, Durrance, is rated 5.7 and involves crack climbing techniques. Even for experienced climbers, a guide is recommended for your first time on the Tower.</p>
                            </div>
                        </div>

                        <div class="accordion-item border-b border-gray-200 last:border-b-0">
                            <button class="accordion-header w-full py-4 text-left text-sm font-medium flex justify-between items-center" onclick="toggleAccordion(this)">
                                What is the June Voluntary Climbing Closure?
                                <span class="accordion-icon text-xl transition-transform">+</span>
                            </button>
                            <div class="accordion-content max-h-0 overflow-hidden transition-all duration-300">
                                <p class="text-sm text-gray-700 leading-relaxed pb-4">The June Voluntary Climbing Closure is a request that climbers not climb on the Tower during the month of June when Native American traditional cultural ceremonies are taking place. This is out of respect for the indigenous peoples who consider the Tower sacred. While not mandatory, most climbers honor this request.</p>
                            </div>
                        </div>

                        <div class="accordion-item border-b border-gray-200 last:border-b-0">
                            <button class="accordion-header w-full py-4 text-left text-sm font-medium flex justify-between items-center" onclick="toggleAccordion(this)">
                                What equipment do I need to climb Devil's Tower?
                                <span class="accordion-icon text-xl transition-transform">+</span>
                            </button>
                            <div class="accordion-content max-h-0 overflow-hidden transition-all duration-300">
                                <p class="text-sm text-gray-700 leading-relaxed pb-4">Standard rock climbing gear is required, including a helmet, harness, climbing shoes, and traditional protection (cams, nuts, etc.) for crack climbing. Most routes require a 60m rope. If climbing with our guided service, all technical equipment is provided, but you should bring appropriate clothing, water, and sun protection.</p>
                            </div>
                        </div>

                        <div class="accordion-item border-b border-gray-200 last:border-b-0">
                            <button class="accordion-header w-full py-4 text-left text-sm font-medium flex justify-between items-center" onclick="toggleAccordion(this)">
                                How long does it take to climb Devil's Tower?
                                <span class="accordion-icon text-xl transition-transform">+</span>
                            </button>
                            <div class="accordion-content max-h-0 overflow-hidden transition-all duration-300">
                                <p class="text-sm text-gray-700 leading-relaxed pb-4">Most routes take 4-6 hours to complete round trip from the base to the summit and back down. The Durrance route, the most popular, typically takes 3-5 hours for experienced climbers. Plan for a full day activity including approach, climbing, and descent.</p>
                            </div>
                        </div>

                        <div class="accordion-item border-b border-gray-200 last:border-b-0">
                            <button class="accordion-header w-full py-4 text-left text-sm font-medium flex justify-between items-center" onclick="toggleAccordion(this)">
                                Are there climbing guides available at Devil's Tower?
                                <span class="accordion-icon text-xl transition-transform">+</span>
                            </button>
                            <div class="accordion-content max-h-0 overflow-hidden transition-all duration-300">
                                <p class="text-sm text-gray-700 leading-relaxed pb-4">Yes, several authorized guide services operate in Devil's Tower National Monument. Licensed guides can provide equipment, instruction, and lead climbs for all skill levels. Advance reservations are recommended, especially during peak season (summer months).</p>
                            </div>
                        </div>

                        <div class="accordion-item border-b border-gray-200 last:border-b-0">
                            <button class="accordion-header w-full py-4 text-left text-sm font-medium flex justify-between items-center" onclick="toggleAccordion(this)">
                                What wildlife might I encounter while climbing?
                                <span class="accordion-icon text-xl transition-transform">+</span>
                            </button>
                            <div class="accordion-content max-h-0 overflow-hidden transition-all duration-300">
                                <p class="text-sm text-gray-700 leading-relaxed pb-4">Prairie falcons and other raptors nest on the Tower, and temporary closures of certain routes may be in effect to protect nesting birds. You might also encounter swifts, swallows, chipmunks, and occasionally snakes. Always respect wildlife and maintain a safe distance.</p>
                            </div>
                        </div>

                        <div class="accordion-item border-b border-gray-200 last:border-b-0">
                            <button class="accordion-header w-full py-4 text-left text-sm font-medium flex justify-between items-center" onclick="toggleAccordion(this)">
                                What are the weather concerns for climbing Devil's Tower?
                                <span class="accordion-icon text-xl transition-transform">+</span>
                            </button>
                            <div class="accordion-content max-h-0 overflow-hidden transition-all duration-300">
                                <p class="text-sm text-gray-700 leading-relaxed pb-4">Summer thunderstorms are common and can develop quickly. Lightning is a serious hazard on the Tower. Check weather forecasts before climbing and be prepared to descend if storms approach. The rock can also become very hot in direct sunlight, making climbing uncomfortable in mid-summer afternoons.</p>
                            </div>
                        </div>

                        <div class="accordion-item border-b border-gray-200 last:border-b-0">
                            <button class="accordion-header w-full py-4 text-left text-sm font-medium flex justify-between items-center" onclick="toggleAccordion(this)">
                                Can I camp near Devil's Tower?
                                <span class="accordion-icon text-xl transition-transform">+</span>
                            </button>
                            <div class="accordion-content max-h-0 overflow-hidden transition-all duration-300">
                                <p class="text-sm text-gray-700 leading-relaxed pb-4">Yes, Belle Fourche River Campground is located within the monument and operates on a first-come, first-served basis. There are also several private campgrounds and lodging options just outside the monument boundaries. Reservations are recommended during peak season.</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Policies Tab -->
                <div id="policies-tab" class="tab-content p-4 hidden">
                    <div class="space-y-4">
                        <div class="policy-item">
                            <h4 class="font-bold mb-1">Climbing Registration</h4>
                            <p class="text-sm text-gray-700">All climbers must register at the Visitor Center before climbing and check in after completing their climb. Registration is free and helps park staff monitor climbing activity and ensure climber safety.</p>
                        </div>
                        <div class="policy-item">
                            <h4 class="font-bold mb-1">June Voluntary Closure</h4>
                            <p class="text-sm text-gray-700">Climbers are asked to voluntarily refrain from climbing during the month of June out of respect for Native American cultural ceremonies. This voluntary closure has been in effect since 1995 and is respected by most climbers.</p>
                        </div>
                        <div class="policy-item">
                            <h4 class="font-bold mb-1">Environmental Protection</h4>
                            <p class="text-sm text-gray-700">Fixed anchors are prohibited without prior approval. Climbers must pack out all trash and waste. Chalk use should be minimized, and colored chalk is prohibited. Stay on established trails during approach and descent to minimize erosion.</p>
                        </div>
                        <div class="policy-item">
                            <h4 class="font-bold mb-1">Raptor Nesting Closures</h4>
                            <p class="text-sm text-gray-700">Temporary closures of certain climbing routes may be implemented to protect nesting prairie falcons and other raptors. These closures typically occur from March through July and are posted at the Visitor Center and on the NPS website.</p>
                        </div>
                        <div class="policy-item">
                            <h4 class="font-bold mb-1">Safety Requirements</h4>
                            <p class="text-sm text-gray-700">Helmets are strongly recommended for all climbers. Solo climbing is discouraged. All climbers should carry adequate water, sun protection, and be prepared for sudden weather changes. Emergency services may be delayed due to the remote location.</p>
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
            const wyomingCoords = [44.5902, -104.7154];

            const map = L.map('map').setView(wyomingCoords, 12);

            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '&copy; <a href="https://www.openstreetmap.org/">OpenStreetMap</a> contributors'
            }).addTo(map);

            L.marker(wyomingCoords)
                .addTo(map)
                .bindPopup("Devil's Tower, Wyoming")
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