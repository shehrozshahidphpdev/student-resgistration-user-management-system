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

    <!-- Sidebar -->
    <aside class="w-56 bg-white border-r border-gray-200 flex flex-col shrink-0">

      <!-- Brand -->
      <div class="px-4 py-5 border-b border-gray-200">
        <div class="text-sm font-medium text-gray-800">Student</div>
        <div class="text-xs text-gray-400 mt-0.5">Management system</div>
      </div>

      <!-- Nav -->
      <nav class="flex-1 px-2 py-3 space-y-0.5">
        <p class="text-xs text-gray-400 uppercase tracking-wide px-2 py-1">Main</p>

        <a href="#" class="flex items-center gap-2.5 px-3 py-2 rounded-lg text-sm bg-purple-50 text-purple-700 font-medium">
          <i class="fa-solid fa-house w-4 text-purple-600 text-xs"></i>
          Dashboard
        </a>
        <a href="#" class="flex items-center gap-2.5 px-3 py-2 rounded-lg text-sm text-gray-500 hover:bg-gray-100 hover:text-gray-800 transition">
          <i class="fa-solid fa-user w-4 text-gray-400 text-xs"></i>
          My Profile
        </a>
        <a href="#" class="flex items-center gap-2.5 px-3 py-2 rounded-lg text-sm text-gray-500 hover:bg-gray-100 hover:text-gray-800 transition">
          <i class="fa-solid fa-clock-rotate-left w-4 text-gray-400 text-xs"></i>
          Activity Log
        </a>

        <p class="text-xs text-gray-400 uppercase tracking-wide px-2 py-1 pt-3">Account</p>

        <a href="#" class="flex items-center gap-2.5 px-3 py-2 rounded-lg text-sm text-gray-500 hover:bg-gray-100 hover:text-gray-800 transition">
          <i class="fa-solid fa-lock w-4 text-gray-400 text-xs"></i>
          Change Password
        </a>
        <a href="#" class="flex items-center gap-2.5 px-3 py-2 rounded-lg text-sm text-gray-500 hover:bg-gray-100 hover:text-gray-800 transition">
          <i class="fa-solid fa-gear w-4 text-gray-400 text-xs"></i>
          Settings
        </a>
      </nav>

      <!-- Logout -->
      <div class="px-2 py-3 border-t border-gray-200">
        <form action="/logout" method="POST">
          <input type="hidden">
        </form>
        <a href="/logout" class="flex items-center gap-2.5 px-3 py-2 rounded-lg text-sm text-red-600 hover:bg-red-50 transition w-full">
          <i class="fa-solid fa-right-from-bracket text-xs w-4"></i>
          Logout
        </a>
      </div>

    </aside>

    <!-- Main -->
    <div class="flex-1 flex flex-col overflow-hidden">

      <!-- Header -->
      <header class="h-14 bg-white border-b border-gray-200 flex items-center justify-between px-5 flex-shrink-0">
        <div class="text-sm font-medium text-gray-800">Welcome <?= $user['first_name'] ?></div>

        <div class="flex items-center gap-2">
          <!-- Notification Bell -->
          <div class="relative" id="notif-wrap">
            <button onclick="toggle('notif-dd')" class="w-8 h-8 rounded-lg border border-gray-200 flex items-center justify-center text-gray-500 hover:bg-gray-100 transition text-sm relative">
              <i class="fa-solid fa-bell"></i>
              <span class="absolute top-1.5 right-1.5 w-1.5 h-1.5 rounded-full bg-purple-600 border border-white"></span>
            </button>
            <div id="notif-dd" class="hidden absolute right-0 top-10 w-52 bg-white border border-gray-200 rounded-xl shadow-lg z-20 overflow-hidden"> <!-- ✅ only this keeps notif-dd -->
              <div class="px-3 py-2 text-xs font-medium text-gray-400 border-b border-gray-100">Notifications</div>
              <div class="flex items-center gap-2 px-3 py-2 text-xs text-gray-600 hover:bg-gray-50 cursor-pointer">
                <i class="fa-solid fa-circle-info text-purple-500"></i> Profile updated
              </div>
              <div class="flex items-center gap-2 px-3 py-2 text-xs text-gray-600 hover:bg-gray-50 cursor-pointer">
                <i class="fa-solid fa-circle-info text-green-500"></i> Login from new device
              </div>
              <div class="flex items-center gap-2 px-3 py-2 text-xs text-gray-600 hover:bg-gray-50 cursor-pointer">
                <i class="fa-solid fa-circle-info text-amber-500"></i> Password changed
              </div>
            </div>
          </div>


          <!-- Avatar -->
          <div class="w-8 h-8 rounded-full bg-purple-100 flex items-center justify-center text-xs font-medium text-purple-700 cursor-pointer">
            <?= strtoupper(substr($user['first_name'], 0, 2)) ?>
          </div>

        </div>
      </header>

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