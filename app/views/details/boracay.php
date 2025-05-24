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
        <img src="/assets/boracay.jpg" alt="Boracay Island" class="inset-0 w-full h-full object-cover object-center">
        </div>
        <div class="absolute bottom-4 w-full max-w-6xl flex items-center justify-between px-4">
            <h1 class="text-5xl font-bold mb-2 drop-shadow-lg text-white">Boracay Island, Philippines</h1>
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
                    <h2 class="text-3xl font-bold">₱15,500</h2>
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
                            <div class="text-sm">Boracay Island, Philippines</div>
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
                            <div class="text-sm">Dec 15 - Dec 22</div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Rating -->
            <div class="flex items-center gap-2 bg-gray-50 p-3 rounded-md">
                <span class="text-sm font-medium">Excellent</span>
                <div class="flex">
                    <span class="star text-amber-400 text-xl">★</span>
                    <span class="star text-amber-400 text-xl">★</span>
                    <span class="star text-amber-400 text-xl">★</span>
                    <span class="star text-amber-400 text-xl">★</span>
                    <span class="star text-amber-400 text-xl">★</span>
                </div>
            </div>

            <!-- Image Gallery -->
            <div class="grid grid-cols-3 gap-2 h-48">
                <img src="/assets/details/boracay-diving.jpg" class="h-50 w-full border-gray-300 bg-gradient-to-br from-cyan-500 to-sky-500 rounded-md flex items-center justify-center text-white text-sm font-medium">
                <img src="/assets/details/boracay-tutel.jpg" class="h-50 w-full border-gray-300 bg-gradient-to-br from-cyan-500 to-sky-500 rounded-md flex items-center justify-center text-white text-sm font-medium">
                <img src="/assets/details/boracay-sunset.jpg" class="h-50 w-full border-gray-300 bg-gradient-to-br from-cyan-500 to-sky-500 rounded-md flex items-center justify-center text-white text-sm font-medium">
            </div>

            <!-- Description -->
            <div class="space-y-4">
                <p class="text-gray-700 leading-relaxed">Boracay Island is a tropical paradise located in the central Philippines, renowned for its pristine white sand beaches and crystal-clear turquoise waters. White Beach, the island's main attraction, stretches for 4 kilometers and is consistently ranked among the world's best beaches.</p>
                <p class="text-gray-700 leading-relaxed">From thrilling water sports like kitesurfing and parasailing to peaceful sunset cruises and island hopping adventures, Boracay offers the perfect blend of relaxation and excitement. Experience vibrant nightlife, world-class dining, and the warm hospitality that the Philippines is famous for.</p>
            </div>

            <!-- Fun Facts -->
            <div class="border border-gray-200 rounded-lg p-6 bg-gradient-to-br from-amber-50 to-amber-100">
                <div class="flex items-center gap-2 mb-4">
                    <svg class="text-amber-500" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M9 21h6"></path>
                        <path d="M12 17v4"></path>
                        <path d="M12 3a6 6 0 0 1 6 6c0 3-2 5.5-2 8H8c0-2.5-2-5-2-8a6 6 0 0 1 6-6z"></path>
                    </svg>
                    <h3 class="text-lg font-bold text-amber-800">Island Facts!</h3>
                </div>
                <ol class="list-decimal list-inside space-y-3 text-sm text-amber-800">
                    <li><strong>World's Best Beach:</strong> White Beach has been consistently ranked among the top beaches in the world by various travel publications and websites.</li>
                    <li><strong>Powdery White Sand:</strong> The famous white sand is made of crushed coral and shells, creating an incredibly fine and soft texture that stays cool even under the hot sun.</li>
                    <li><strong>Three Beach Stations:</strong> White Beach is divided into three stations, each offering different vibes - Station 1 for luxury, Station 2 for activities, and Station 3 for budget-friendly options.</li>
                    <li><strong>Kitesurfing Capital:</strong> Boracay is considered one of Asia's premier kitesurfing destinations, with Bulabog Beach offering perfect wind conditions from November to April.</li>
                    <li><strong>Island Rehabilitation:</strong> The island underwent a major environmental rehabilitation in 2018, emerging cleaner and more sustainable than ever before.</li>
                </ol>
            </div>

            <!-- Reviews -->
            <div class="space-y-6">
                <h3 class="text-xl font-bold">Traveler Reviews</h3>
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
                        <div class="text-xs text-gray-400">Overall rating of 127 traveler reviews</div>
                    </div>
                </div>

                <!-- Rating Bars -->
                <div class="space-y-2">
                    <div class="flex items-center gap-2">
                        <div class="w-12 text-sm">5 Stars</div>
                        <div class="flex-1 bg-gray-200 h-2 rounded-full overflow-hidden">
                            <div class="bg-cyan-500 h-full rounded-full" style="width: 82%"></div>
                        </div>
                        <div class="w-8 text-right text-sm text-gray-600">104</div>
                    </div>
                    <div class="flex items-center gap-2">
                        <div class="w-12 text-sm">4 Stars</div>
                        <div class="flex-1 bg-gray-200 h-2 rounded-full overflow-hidden">
                            <div class="bg-cyan-500 h-full rounded-full" style="width: 15%"></div>
                        </div>
                        <div class="w-8 text-right text-sm text-gray-600">19</div>
                    </div>
                    <div class="flex items-center gap-2">
                        <div class="w-12 text-sm">3 Stars</div>
                        <div class="flex-1 bg-gray-200 h-2 rounded-full overflow-hidden">
                            <div class="bg-cyan-500 h-full rounded-full" style="width: 2%"></div>
                        </div>
                        <div class="w-8 text-right text-sm text-gray-600">3</div>
                    </div>
                    <div class="flex items-center gap-2">
                        <div class="w-12 text-sm">2 Stars</div>
                        <div class="flex-1 bg-gray-200 h-2 rounded-full overflow-hidden">
                            <div class="bg-cyan-500 h-full rounded-full" style="width: 1%"></div>
                        </div>
                        <div class="w-8 text-right text-sm text-gray-600">1</div>
                    </div>
                    <div class="flex items-center gap-2">
                        <div class="w-12 text-sm">1 Stars</div>
                        <div class="flex-1 bg-gray-200 h-2 rounded-full overflow-hidden">
                            <div class="bg-cyan-500 h-full rounded-full" style="width: 0%"></div>
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
                                What is the best time to visit Boracay?
                                <span class="accordion-icon text-xl transition-transform">+</span>
                            </button>
                            <div class="accordion-content max-h-0 overflow-hidden transition-all duration-300">
                                <p class="text-sm text-gray-700 leading-relaxed pb-4">The best time to visit Boracay is during the dry season from November to April, when you'll experience sunny skies, calm seas, and minimal rainfall. December to February offers the coolest temperatures, while March to May can be quite hot but perfect for beach activities.</p>
                            </div>
                        </div>

                        <div class="accordion-item border-b border-gray-200 last:border-b-0">
                            <button class="accordion-header w-full py-4 text-left text-sm font-medium flex justify-between items-center" onclick="toggleAccordion(this)">
                                How do I get to Boracay Island?
                                <span class="accordion-icon text-xl transition-transform">+</span>
                            </button>
                            <div class="accordion-content max-h-0 overflow-hidden transition-all duration-300">
                                <p class="text-sm text-gray-700 leading-relaxed pb-4">Fly to Kalibo (KLO) or Caticlan (MPH) airports. From Kalibo, take a 1.5-hour bus ride to Caticlan jetty port. From Caticlan airport, it's just a 10-minute tricycle ride to the jetty. Then take a 15-minute boat ride to Boracay Island. We can arrange all transfers for you.</p>
                            </div>
                        </div>

                        <div class="accordion-item border-b border-gray-200 last:border-b-0">
                            <button class="accordion-header w-full py-4 text-left text-sm font-medium flex justify-between items-center" onclick="toggleAccordion(this)">
                                What activities are included in the package?
                                <span class="accordion-icon text-xl transition-transform">+</span>
                            </button>
                            <div class="accordion-content max-h-0 overflow-hidden transition-all duration-300">
                                <p class="text-sm text-gray-700 leading-relaxed pb-4">Our package includes island hopping tours, sunset sailing, snorkeling equipment, beach activities, and access to water sports. Optional activities like parasailing, jet skiing, and scuba diving can be arranged at additional cost.</p>
                            </div>
                        </div>

                        <div class="accordion-item border-b border-gray-200 last:border-b-0">
                            <button class="accordion-header w-full py-4 text-left text-sm font-medium flex justify-between items-center" onclick="toggleAccordion(this)">
                                Is Boracay suitable for families with children?
                                <span class="accordion-icon text-xl transition-transform">+</span>
                            </button>
                            <div class="accordion-content max-h-0 overflow-hidden transition-all duration-300">
                                <p class="text-sm text-gray-700 leading-relaxed pb-4">Boracay is very family-friendly with calm, shallow waters perfect for children, family resorts, kid-friendly restaurants, and activities suitable for all ages. The beach is safe for swimming and the local community is welcoming to families.</p>
                            </div>
                        </div>

                        <div class="accordion-item border-b border-gray-200 last:border-b-0">
                            <button class="accordion-header w-full py-4 text-left text-sm font-medium flex justify-between items-center" onclick="toggleAccordion(this)">
                                What should I pack for Boracay?
                                <span class="accordion-icon text-xl transition-transform">+</span>
                            </button>
                            <div class="accordion-content max-h-0 overflow-hidden transition-all duration-300">
                                <p class="text-sm text-gray-700 leading-relaxed pb-4">Pack light, breathable clothing, swimwear, sunscreen (reef-safe), hat, sunglasses, flip-flops, and a light jacket for evening. Don't forget underwater camera, snorkeling gear if you have your own, and any prescription medications.</p>
                            </div>
                        </div>

                        <div class="accordion-item border-b border-gray-200 last:border-b-0">
                            <button class="accordion-header w-full py-4 text-left text-sm font-medium flex justify-between items-center" onclick="toggleAccordion(this)">
                                Are there dining options for different dietary requirements?
                                <span class="accordion-icon text-xl transition-transform">+</span>
                            </button>
                            <div class="accordion-content max-h-0 overflow-hidden transition-all duration-300">
                                <p class="text-sm text-gray-700 leading-relaxed pb-4">Yes! Boracay offers diverse dining options including vegetarian, vegan, halal, and international cuisines. From local Filipino dishes to Italian, Korean, and Indian restaurants, there's something for every palate and dietary requirement.</p>
                            </div>
                        </div>

                        <div class="accordion-item border-b border-gray-200 last:border-b-0">
                            <button class="accordion-header w-full py-4 text-left text-sm font-medium flex justify-between items-center" onclick="toggleAccordion(this)">
                                Is WiFi available on the island?
                                <span class="accordion-icon text-xl transition-transform">+</span>
                            </button>
                            <div class="accordion-content max-h-0 overflow-hidden transition-all duration-300">
                                <p class="text-sm text-gray-700 leading-relaxed pb-4">Most hotels, restaurants, and cafes offer free WiFi. The connection quality varies but is generally reliable for basic internet needs. For better connectivity, consider purchasing a local SIM card with data plan from convenience stores on the island.</p>
                            </div>
                        </div>

                        <div class="accordion-item border-b border-gray-200 last:border-b-0">
                            <button class="accordion-header w-full py-4 text-left text-sm font-medium flex justify-between items-center" onclick="toggleAccordion(this)">
                                What is the local currency and payment methods?
                                <span class="accordion-icon text-xl transition-transform">+</span>
                            </button>
                            <div class="accordion-content max-h-0 overflow-hidden transition-all duration-300">
                                <p class="text-sm text-gray-700 leading-relaxed pb-4">The local currency is Philippine Peso (PHP). While many establishments accept credit cards, it's advisable to carry cash for small vendors, tricycle rides, and tips. ATMs are available throughout the island, especially in Station 2.</p>
                            </div>
                        </div>

                        <div class="accordion-item border-b border-gray-200 last:border-b-0">
                            <button class="accordion-header w-full py-4 text-left text-sm font-medium flex justify-between items-center" onclick="toggleAccordion(this)">
                                Are there medical facilities on the island?
                                <span class="accordion-icon text-xl transition-transform">+</span>
                            </button>
                            <div class="accordion-content max-h-0 overflow-hidden transition-all duration-300">
                                <p class="text-sm text-gray-700 leading-relaxed pb-4">Yes, Boracay has several medical clinics and a hospital. For serious emergencies, patients can be transported to larger hospitals in Kalibo or Iloilo. We recommend travel insurance that covers medical emergencies and evacuation.</p>
                            </div>
                        </div>

                        <div class="accordion-item border-b border-gray-200 last:border-b-0">
                            <button class="accordion-header w-full py-4 text-left text-sm font-medium flex justify-between items-center" onclick="toggleAccordion(this)">
                                What environmental guidelines should I follow?
                                <span class="accordion-icon text-xl transition-transform">+</span>
                            </button>
                            <div class="accordion-content max-h-0 overflow-hidden transition-all duration-300">
                                <p class="text-sm text-gray-700 leading-relaxed pb-4">Please use reef-safe sunscreen, avoid single-use plastics, don't touch or step on coral reefs, dispose of waste properly, and respect marine life. Boracay has strict environmental regulations to preserve its natural beauty for future generations.</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Policies Tab -->
                <div id="policies-tab" class="tab-content p-4 hidden">
                    <div class="space-y-4">
                        <div class="policy-item">
                            <h4 class="font-bold mb-1">Booking & Payment</h4>
                            <p class="text-sm text-gray-700">25% deposit required at booking, with the remaining balance due 30 days before arrival. Full payment required for bookings made within 30 days of arrival. Payment accepted via credit card, bank transfer, or PayPal.</p>
                        </div>
                        <div class="policy-item">
                            <h4 class="font-bold mb-1">Cancellation Policy</h4>
                            <p class="text-sm text-gray-700">Full refund if canceled 45+ days before arrival. 50% refund if canceled 15-44 days before arrival. No refund if canceled less than 15 days before arrival. Travel insurance is highly recommended.</p>
                        </div>
                        <div class="policy-item">
                            <h4 class="font-bold mb-1">Weather Conditions</h4>
                            <p class="text-sm text-gray-700">Activities may be modified due to weather conditions for safety reasons. During typhoon season (June-October), we may need to reschedule or relocate activities. No refunds for weather-related changes, but alternative activities will be provided.</p>
                        </div>
                        <div class="policy-item">
                            <h4 class="font-bold mb-1">Environmental Responsibility</h4>
                            <p class="text-sm text-gray-700">All guests must follow Boracay's environmental guidelines including proper waste disposal, use of reef-safe sunscreen, and respect for marine life. Violations may result in fines imposed by local authorities.</p>
                        </div>
                        <div class="policy-item">
                            <h4 class="font-bold mb-1">Health & Safety</h4>
                            <p class="text-sm text-gray-700">Guests must be able to swim or wear life jackets during water activities. Children under 12 must be supervised by adults at all times. Please inform us of any medical conditions or allergies before arrival.</p>
                        </div>
                        <div class="policy-item">
                            <h4 class="font-bold mb-1">Travel Requirements</h4>
                            <p class="text-sm text-gray-700">Valid passport required for international visitors. Check visa requirements for your nationality. Proof of onward travel may be required. Travel insurance covering medical emergencies and trip cancellation is strongly recommended.</p>
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
            const boracayCoords = [11.95620, 121.93176];

            const map = L.map('map').setView(boracayCoords, 13);

            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '&copy; <a href="https://www.openstreetmap.org/">OpenStreetMap</a> contributors'
            }).addTo(map);

            L.marker(boracayCoords)
                .addTo(map)
                .bindPopup('Boracay, Philippines')
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