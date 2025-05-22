<?php
// Check if we have booking data
if (!isset($_SESSION['booking_data']) || !isset($_SESSION['booking_reference'])) {
  header('Location: /book/1');
  exit;
}
$bookingRef = $_SESSION['booking_reference'];
$bookingData = $_SESSION['booking_data'];
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Compass | Booking Confirmation</title>
  <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
  <script src="https://kit.fontawesome.com/2251ecbe6b.js" crossorigin="anonymous"></script>
  <link rel="stylesheet" href="/app/styles/index.css">
  <link rel="stylesheet" href="/app/styles/animations.css">
</head>

<body class="scroll-smooth h-screen">
  <header class="w-full bg-[var(--gold)] h-20 flex items-center justify-between px-20 text-white mb-10 sm:mb-20">
    <img src="/assets/logo.svg" alt="Compass Logo" class="h-10 w-auto">
  </header>

  <main class="w-full flex items-center justify-center">
    <div class="w-full max-w-4xl px-5 sm:px-10 mt-10 flex flex-col">
      <div class="bg-green-50 border-l-4 border-green-500 p-6 mb-8 rounded-lg">
        <div class="flex items-center mb-4">
          <i class="fa-solid fa-circle-check text-green-500 text-3xl mr-3"></i>
          <h1 class="text-2xl font-bold text-green-800">Booking Confirmed!</h1>
        </div>
        <p class="text-green-700 mb-2">Your booking reference: <span class="font-bold"><?= $bookingRef ?></span></p>
        <p class="text-green-700">A confirmation email has been sent to your email address.</p>
      </div>

      <div class="bg-white rounded-lg shadow-md p-6 mb-8">
        <h2 class="text-xl font-bold mb-4 text-[var(--blue)]">Trip Details</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
          <?php if (isset($bookingData['step1'])): ?>
            <div>
              <p class="text-sm text-gray-500">From</p>
              <p class="font-semibold"><?= htmlspecialchars($bookingData['step1']['from'] ?? 'Not specified') ?></p>
            </div>
            <div>
              <p class="text-sm text-gray-500">To</p>
              <p class="font-semibold">
                <?= htmlspecialchars($bookingData['step1']['city'] ?? 'Not specified') ?>,
                <?= htmlspecialchars($bookingData['step1']['country'] ?? '') ?>
              </p>
            </div>
            <div>
              <p class="text-sm text-gray-500">Departure</p>
              <p class="font-semibold"><?= htmlspecialchars($bookingData['step1']['departure_date'] ?? 'Not specified') ?></p>
            </div>
            <div>
              <p class="text-sm text-gray-500">Return</p>
              <p class="font-semibold"><?= htmlspecialchars($bookingData['step1']['return_date'] ?? 'Not specified') ?></p>
            </div>
          <?php endif; ?>
        </div>
      </div>

      <div class="bg-white rounded-lg shadow-md p-6 mb-8">
        <h2 class="text-xl font-bold mb-4 text-[var(--blue)]">Passenger Information</h2>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
          <?php if (isset($bookingData['step2'])): ?>
            <div>
              <p class="text-sm text-gray-500">Adults</p>
              <p class="font-semibold"><?= htmlspecialchars($bookingData['step2']['adults'] ?? '1') ?></p>
            </div>
            <div>
              <p class="text-sm text-gray-500">Children</p>
              <p class="font-semibold"><?= htmlspecialchars($bookingData['step2']['children'] ?? '0') ?></p>
            </div>
            <div>
              <p class="text-sm text-gray-500">Infants</p>
              <p class="font-semibold"><?= htmlspecialchars($bookingData['step2']['infants'] ?? '0') ?></p>
            </div>
            <div>
              <p class="text-sm text-gray-500">Travel Class</p>
              <p class="font-semibold"><?= ucfirst(htmlspecialchars($bookingData['step2']['travel_class'] ?? 'economy')) ?></p>
            </div>
            <div>
              <p class="text-sm text-gray-500">Accommodation</p>
              <p class="font-semibold"><?= $bookingData['step2']['accommodation'] == 'yes' ? 'Included' : 'Not included' ?></p>
            </div>
          <?php endif; ?>
        </div>
      </div>

      <!-- Activities Section -->
      <?php if (isset($bookingData['step2']) && isset($bookingData['step2']['activities'])): ?>
        <div class="bg-white rounded-lg shadow-md p-6 mb-8">
          <h2 class="text-xl font-bold mb-4 text-[var(--blue)]">Planned Activities</h2>
          <div class="flex flex-wrap gap-2">
            <?php
            $activities = is_array($bookingData['step2']['activities']) ?
              $bookingData['step2']['activities'] :
              [$bookingData['step2']['activities']];

            if (!empty($activities)):
              foreach ($activities as $activity):
                $activityName = ucfirst(str_replace('_', ' ', $activity));
                $iconClass = getActivityIcon($activity);
            ?>
                <div class="bg-blue-50 text-[var(--blue)] px-3 py-1.5 rounded-full flex items-center">
                  <i class="<?= $iconClass ?> mr-2"></i>
                  <?= htmlspecialchars($activityName) ?>
                </div>
              <?php
              endforeach;
            else:
              ?>
              <p>No specific activities selected.</p>
            <?php endif; ?>
          </div>
        </div>
      <?php endif; ?>

      <!-- Information Needs Section -->
      <?php if (isset($bookingData['step2']) && isset($bookingData['step2']['info_needs'])): ?>
        <div class="bg-white rounded-lg shadow-md p-6 mb-8">
          <h2 class="text-xl font-bold mb-4 text-[var(--blue)]">Requested Travel Information</h2>
          <div class="flex flex-wrap gap-2">
            <?php
            $infoNeeds = is_array($bookingData['step2']['info_needs']) ?
              $bookingData['step2']['info_needs'] :
              [$bookingData['step2']['info_needs']];

            if (!empty($infoNeeds)):
              foreach ($infoNeeds as $info):
                $infoName = ucfirst($info);
                $iconClass = getInfoIcon($info);
            ?>
                <div class="bg-green-50 text-green-700 px-3 py-1.5 rounded-full flex items-center">
                  <i class="<?= $iconClass ?> mr-2"></i>
                  <?= htmlspecialchars($infoName) ?>
                </div>
              <?php
              endforeach;
            else:
              ?>
              <p>No specific information requested.</p>
            <?php endif; ?>
          </div>
        </div>
      <?php endif; ?>

      <div class="bg-white rounded-lg shadow-md p-6 mb-8">
        <h2 class="text-xl font-bold mb-4 text-[var(--blue)]">Contact Information</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
          <?php if (isset($bookingData['step3'])): ?>
            <div>
              <p class="text-sm text-gray-500">Full Name</p>
              <p class="font-semibold">
                <?= htmlspecialchars($bookingData['step3']['firstName'] ?? '') ?>
                <?= htmlspecialchars($bookingData['step3']['lastName'] ?? '') ?>
              </p>
            </div>
            <div>
              <p class="text-sm text-gray-500">Email</p>
              <p class="font-semibold"><?= htmlspecialchars($bookingData['step3']['email'] ?? '') ?></p>
            </div>
            <div>
              <p class="text-sm text-gray-500">Phone</p>
              <p class="font-semibold"><?= htmlspecialchars($bookingData['step3']['phone'] ?? '') ?></p>
            </div>
          <?php endif; ?>
        </div>
      </div>


      <div class="flex justify-center mt-8 mb-10">
        <a href="/" class="bg-[var(--blue)] text-white rounded-full py-4 px-8 hover:bg-[var(--gold)] transition duration-300 ease-in-out">
          Return to Homepage
        </a>
      </div>
    </div>
  </main>
</body>

</html>

<?php
// Helper functions to get appropriate icons
function getActivityIcon($activity)
{
  switch ($activity) {
    case 'hiking':
      return 'fa-solid fa-person-hiking';
    case 'kayaking':
      return 'fa-solid fa-water';
    case 'fishing':
      return 'fa-solid fa-fish';
    case 'mountain_biking':
      return 'fa-solid fa-bicycle';
    case 'skiing':
      return 'fa-solid fa-person-skiing';
    case 'surfing':
      return 'fa-solid fa-water-ladder';
    default:
      return 'fa-solid fa-map-pin';
  }
}

function getInfoIcon($info)
{
  switch ($info) {
    case 'transportation':
      return 'fa-solid fa-bus';
    case 'health':
      return 'fa-solid fa-kit-medical';
    case 'weather':
      return 'fa-solid fa-cloud-sun';
    case 'gear':
      return 'fa-solid fa-suitcase';
    case 'political':
      return 'fa-solid fa-landmark';
    case 'activity':
      return 'fa-solid fa-person-running';
    default:
      return 'fa-solid fa-circle-info';
  }
}
?>