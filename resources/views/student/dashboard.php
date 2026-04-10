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

        <h1 class="text-base font-medium text-gray-800 mb-5">Dashboard</h1>
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