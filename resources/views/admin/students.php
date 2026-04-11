<?php

use App\Services\Session;

$user = Session::get('user');
$success = Session::flash('success');
// dd($students);
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

      <?php require_once VIEWS_PATH . '/includes/header.php' ?>

      <!-- Content -->
      <main class="flex-1 overflow-y-auto p-5">
        <?php if (isset($success)) { ?>
          <div class="message p-4 rounded-lg bg-green-400 border-green-500 border-2 mb-5">
            <?= $success ?>
          </div>
        <?php   } ?>
        <h1 class="text-base font-medium text-gray-800 mb-5">Students</h1>

        <!-- Search Bar -->
        <div class="flex items-center gap-2 mb-4">
          <form action="/admin/dashboard/dashboard/students" method="get" class="flex gap-3">
            <div class="relative flex-1 max-w-sm">
              <span class="absolute inset-y-0 left-3 flex items-center text-gray-400">
              </span>
              <input
                type="text"
                name="search"
                id="searchInput"
                placeholder="Search students..."
                class="w-full pl-9 pr-4 py-2 text-sm border border-gray-200 rounded-lg bg-white focus:outline-none focus:ring-2 focus:ring-gray-300 text-gray-700 placeholder-gray-400" />

            </div>
            <button type="submit" class="px-6 py-2 bg-green-300 text-white rounded-lg">
              search
            </button>
          </form>

          <a href="/admin/dashboard/dashboard/students"
            class="flex items-center gap-1.5 px-3 py-2 text-sm text-gray-500 border border-gray-200 bg-white rounded-lg hover:bg-gray-50 hover:text-gray-700 transition-colors">
            <i class="fa fa-times text-xs"></i>
            Clear
          </a>
        </div>

        <!-- Table -->
        <div class="bg-white rounded-xl border border-gray-200 shadow-sm overflow-hidden">
          <table class="w-full text-sm">
            <thead>
              <tr class="bg-gray-50 border-b border-gray-200">
                <th class="text-left px-5 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">#</th>
                <th class="text-left px-5 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">Student Name</th>
                <th class="text-left px-5 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">Email</th>
                <th class="text-left px-5 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">Registration Date</th>
                <th class="text-left px-5 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">Actions</th>
              </tr>
            </thead>
            <tbody id="studentTable" class="divide-y divide-gray-100">
              <?php foreach ($students as $id =>  $student) { ?>
                <tr class="hover:bg-gray-50 transition-colors student-row">
                  <td class="px-5 py-3.5 text-gray-400 text-xs"><?= $id + 1 ?></td>
                  <td class="px-5 py-3.5 font-medium text-gray-800"><?= $student['first_name'] . " " . $student['last_name'] ?></td>
                  <td class="px-5 py-3.5 text-gray-500"><?= $student['email'] ?></td>
                  <td class="px-5 py-3.5 text-gray-600"><?= $student['created_at'] ?></td>

                  <td class="px-5 py-3.5">
                    <div class="flex gap-2">
                      <a href="/student/status/update?id=<?= $student['id'] ?>&status=<?= $student['status'] ?>">
                        <?php if ($student['status'] == 'active') {  ?>
                          <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-700">
                            Block</span>
                        <?php  } else { ?>
                          <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-700">
                            Active</span>
                        <?php  } ?>
                      </a>
                      <a href="/student/delete?id=<?= $student['id']; ?>" onclick="return confirm('are you sure you want to delete that account')" class="text-xs text-white border bg-red-500 border-red-100 hover:border-red-300 rounded-md px-2.5 py-1 transition-colors">
                        Delete</a>
                    </div>
                  </td>
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