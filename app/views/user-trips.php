<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Your Trips</title>
  <link rel="stylesheet" href="/app/styles/index.css">
</head>
<body>
  <div class="max-w-4xl mx-auto mt-10">
    <h1 class="text-3xl font-bold mb-6 text-[var(--blue)]">Your Trips</h1>
    <?php if (empty($userTrips)): ?>
      <div class="p-6 bg-yellow-50 border border-yellow-200 rounded-lg text-yellow-700">
        You have no trips booked yet.
      </div>
    <?php else: ?>
      <table class="w-full border-collapse bg-white shadow rounded-lg">
        <thead>
          <tr class="bg-[var(--gold)] text-[var(--text-dark)]">
            <th class="p-3 text-left">Booking Ref</th>
            <th class="p-3 text-left">From</th>
            <th class="p-3 text-left">To</th>
            <th class="p-3 text-left">Departure</th>
            <th class="p-3 text-left">Return</th>
            <th class="p-3 text-left">Status</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($userTrips as $trip): ?>
            <tr class="border-b hover:bg-gray-50">
              <td class="p-3"><?= htmlspecialchars($trip['booking_reference'] ?? '-') ?></td>
              <td class="p-3"><?= htmlspecialchars($trip['from_location'] ?? '-') ?></td>
              <td class="p-3"><?= htmlspecialchars($trip['to_location'] ?? '-') ?></td>
              <td class="p-3"><?= htmlspecialchars($trip['travel_date'] ?? '-') ?></td>
              <td class="p-3"><?= htmlspecialchars($trip['return_date'] ?? '-') ?></td>
              <td class="p-3"><?= htmlspecialchars($trip['status'] ?? '-') ?></td>
            </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    <?php endif; ?>
    <a href="/" class="inline-block mt-8 text-[var(--blue)] hover:underline">&larr; Back to Home</a>
  </div>
</body>
</html>
