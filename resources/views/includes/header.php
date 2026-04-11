<?php

use App\Services\Session;

$user = Session::get('user');
$conn = $GLOBALS['conn'];
$stmt = $conn->prepare("
SELECT a.id, a.user_id, a.action, a.message, a.created_at
FROM activity_logs AS a
WHERE a.user_id = :id LIMIT 5
");

$stmt->execute([
  ':id' => $user['id'],
]);

$activityLogs = $stmt->fetchAll(PDO::FETCH_ASSOC);
// dd($activityLogs);
?>

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
        <div class="px-3 py-2 text-xs font-medium text-gray-400 border-b border-gray-100">Recent Activity</div>

        <?php
        foreach ($activityLogs as $log) {
        ?>
          <div class="flex items-center gap-2 px-3 py-2 text-xs text-gray-600 hover:bg-gray-50 cursor-pointer">
            <i class="fa-solid fa-circle-info  text-green-500"></i>
            <?= $log['message'] ?>
          </div>
        <?php } ?>
      </div>
    </div>


    <!-- Avatar -->
    <div class="w-8 h-8 rounded-full bg-purple-100 flex items-center justify-center text-xs font-medium text-purple-700 cursor-pointer">
      <?= strtoupper(substr($user['first_name'], 0, 2)) ?>
    </div>

  </div>
</header>