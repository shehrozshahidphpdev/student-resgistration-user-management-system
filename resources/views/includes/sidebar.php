   <?php

    use App\Services\Session;

    $user = Session::get('user');
    ?>
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

       <a href="/student/dashboard" class="flex items-center gap-2.5 px-3 py-2 rounded-lg text-sm  text-gray-500 hover:00 hover:text-gray-800  font-medium">
         <i class="fa-solid fa-house w-4 text-purple-600 text-xs"></i>
         Dashboard
       </a>
       <?php if ($user['role'] == 'admin') { ?>
         <a href="/admin/dashboard/dashboard/students" class="flex items-center gap-2.5 px-3 py-2 rounded-lg text-sm  text-gray-500 hover:00 hover:text-gray-800  font-medium">
           <i class="fa-solid fa-user w-4 text-gray-600 text-xs"></i>
           Students
         </a>
       <?php   } ?>

       <a href="/student/dashboard/profile" class="flex items-center gap-2.5 px-3 py-2 rounded-lg text-sm text-gray-500 hover:00 hover:text-gray-800 bg-gray-1transition">
         <i class="fa-solid fa-user w-4 text-gray-400 text-xs"></i>
         My Profile
       </a>
       <?php if ($user['role'] == 'admin') { ?>
         <a href="/admin/dashboard/dashboard/students/activities" class="flex items-center gap-2.5 px-3 py-2 rounded-lg text-sm text-gray-500 hover:bg-gray-100 hover:text-gray-800 transition">
           <i class="fa-solid fa-clock-rotate-left w-4 text-gray-400 text-xs"></i>
           Activity Log
         </a>
       <?php } ?>

       <p class="text-xs text-gray-400 uppercase tracking-wide px-2 py-1 pt-3">Account</p>

       <a href="/student/dashboard/password" class="flex items-center gap-2.5 px-3 py-2 rounded-lg text-sm text-gray-500 hover:bg-gray-100 hover:text-gray-800 transition">
         <i class="fa-solid fa-lock w-4 text-gray-400 text-xs"></i>
         Change Password
       </a>

     </nav>

     <form action="/logout" method="POST">
       <input type="hidden" name="csrf_token" value="<?= Session::get('csrf_token') ?>">
       <button type="submit" name="logout" class="flex items-center gap-2.5 px-3 py-2 rounded-lg text-sm text-red-600 hover:bg-red-50 transition w-full">
         <i class="fa-solid fa-right-from-bracket text-xs w-4"></i>
         Logout
       </button>
     </form>

   </aside>