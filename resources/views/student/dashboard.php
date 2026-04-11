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

      <?php require_once VIEWS_PATH . '/includes/header.php' ?>


      <!-- Content -->
      <main class="flex-1 overflow-y-auto p-5">

        <h1 class="text-base font-medium text-gray-800 mb-5">Profile</h1>

        <div class="relative profile-wrapper p-10 bg-white rounded-lg shadow-lg flex gap-10 ">
          <a href="/student/dashboard/edit-profile" class="absolute top-0 right-0 m-5 text-white rounded-md text-md font-medium px-6 py-3 bg-purple-500 hover:bg-purple-600">
            Edit
          </a>
          <div class="h-40 w-40 rounded-full overflow-hidden">
            <img
              src="<?= BASE_URL . '/' . $data['profile'] ?>" alt="user_Profile"
              class="h-full w-full object-cover">
          </div>
          <div class="info">
            <h1 class="text-4xl font-bold mb-2">Name: <?= $data['first_name'] . " " . $data['last_name'] ?></h1>
            <p class="text-gray-600 mb-2 text-lg font-medium">Email: <?= $data['email'] ?></p>
            <p class="text-gray-600 mb-2 text-lg font-medium">Phone: <?= $data['phone'] ?></p>
          </div>
        </div>
      </main>
    </div>
  </div>

  <script>
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
        document.getElementById('menu-dd').classList.add('hidden');
      }
    });
  </script>

</body>

</html>