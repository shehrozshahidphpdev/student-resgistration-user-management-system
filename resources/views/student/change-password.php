<?php

use App\Services\Session;



$old = Session::flash('old') ?? [];
$errors = Session::flash('errors') ?? [];
$successMessage = Session::flash('success') ?? null;

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

        <?php if (isset($successMessage)) { ?>
          <div class="rounded-md p-4 bg-green-300 border-green-500 mb-5">
            <?= $successMessage ?? "" ?>
          </div>
        <?php }  ?>

        <div class="wrapper bg-white shadow-2xl rounded-2xl p-10">
          <h1 class="font-medium text-gray-800 mb-5 text-3xl">change password</h1>

          <form action="/student/update-password" method="post">
            <input type="hidden" name="csrf_token" value="<?= $csrf_token ?>">
            <div class="flex gap-5">
              <div class="group w-full">
                <div class="mb-5 ">
                  <label for="password" class="block mb-2.5 text-sm font-medium text-heading">Old Password</label>
                  <input type="text" id="password" name="old_password" value="<?= $old['old_password'] ?? "" ?>" class="bg-neutral-secondary-medium  border-gray-800 border-2 text-heading text-sm rounded-lg focus:ring-brand focus:border-brand block w-full px-3 py-2.5 shadow-xs " />
                  <p class="text-rose-500"><?= $errors['old_password'] ?? "" ?></p>
                </div>
              </div>
              <div class="group w-full">
                <div class="mb-5 ">
                  <label for="password" class="block mb-2.5 text-sm font-medium text-heading">New Password</label>
                  <input type="text" id="password" name="new_password" value="<?= $old['new_password'] ?? "" ?>" class="bg-neutral-secondary-medium  border-gray-800 border-2 text-heading text-sm rounded-lg focus:ring-brand focus:border-brand block w-full px-3 py-2.5 shadow-xs " />
                  <p class="text-rose-500"><?= $errors['new_password'] ?? "" ?></p>
                </div>
              </div>
            </div>
            <div class="">
              <button type="submit" name="submit" class="px-6 py-2 bg-purple-500 rounded-lg text-white">
                Save
              </button>
            </div>
          </form>

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