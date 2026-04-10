<?php

use App\Services\Session;

$user = Session::get('user');
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Student Dashboard</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
</head>

<body class="bg-gray-100 font-sans">

  <div class="flex h-screen overflow-hidden">

    <?php require_once RESOURCE_PATH . '/views/includes/sidebar.php' ?>

    <!-- Main -->
    <div class="flex-1 flex flex-col overflow-hidden">

      <?= require_once VIEWS_PATH . '/includes/header.php' ?>

      <!-- Content -->
      <main class="flex-1 overflow-y-auto p-5">
        <?php if (isset($success)) { ?>
          <div class="message p-4 rounded-lg bg-green-400 border-green-500 border-2 mb-5">
            <?= $success ?>
          </div>
        <?php   } ?>
        <h1 class="text-base font-medium text-gray-800 mb-5">Students Activities</h1>


        <!-- Table -->
        <div class="bg-white rounded-xl border border-gray-200 shadow-sm overflow-hidden">
          <table class="w-full text-sm">
            <thead>
              <tr class="bg-gray-50 border-b border-gray-200">
                <th class="text-left px-5 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">#</th>
                <th class="text-left px-5 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">Student Name</th>
                <th class="text-left px-5 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">Activity</th>
                <th class="text-left px-5 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">Performed At</th>
              </tr>
            </thead>
            <tbody id="studentTable" class="divide-y divide-gray-100">
              <?php foreach ($activities as $id =>  $activitiy) { ?>
                <tr class="hover:bg-gray-50 transition-colors student-row">
                  <td class="px-5 py-3.5 text-gray-400 text-xs"><?= $id + 1 ?></td>
                  <td class="px-5 py-3.5 font-medium text-gray-800"><?= $activitiy['first_name'] . " " . $activitiy['last_name'] ?></td>
                  <td class="px-5 py-3.5 text-gray-500"><?= $activitiy['message'] ?></td>
                  <td class="px-5 py-3.5 text-gray-600"><?= $activitiy['created_at'] ?></td>
                </tr>
              <?php } ?>
            </tbody>
          </table>

          <!-- No results row -->
          <div id="noResults" class="hidden text-center py-10 text-sm text-gray-400">
            <i class="fa fa-search mb-2 text-lg block"></i>
            No students found matching your search.
          </div>
        </div>

      </main>
    </div>
  </div>

  <script>
    // Search logic
    const searchInput = document.getElementById('searchInput');

    searchInput.addEventListener('input', filterTable);

    function filterTable() {
      const query = searchInput.value.toLowerCase().trim();
      const rows = document.querySelectorAll('.student-row');
      let visibleCount = 0;

      rows.forEach(row => {
        const text = row.innerText.toLowerCase();
        const match = text.includes(query);
        row.classList.toggle('hidden', !match);
        if (match) visibleCount++;
      });

      document.getElementById('noResults').classList.toggle('hidden', visibleCount > 0);
    }

    function clearSearch() {
      searchInput.value = '';
      filterTable();
      searchInput.focus();
    }

    // Dropdown toggle
    function toggle(id) {
      const all = ['notif-dd'];
      all.forEach(d => {
        if (d !== id) document.getElementById(d).classList.add('hidden');
      });
      document.getElementById(id).classList.toggle('hidden');
    }

    document.addEventListener('click', function(e) {
      if (!e.target.closest('#notif-wrap') && !e.target.closest('#menu-wrap')) {
        document.getElementById('notif-dd').classList.add('hidden');
        document.getElementById('menu-dd')?.classList.add('hidden');
      }
    });
  </script>

</body>

</html>