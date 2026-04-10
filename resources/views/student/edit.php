<?php

use App\Services\Session;

$user = Session::get('user');
$old = Session::flash('old') ?? [];
$errors = Session::flash('errors') ?? [];
$success = Session::flash('success');


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

        <h1 class="text-base font-medium text-gray-800 mb-5">Profile Edit</h1>

        <div class="form-wrapper">
          <form action="/student/profile/update" method="post" enctype="multipart/form-data">
            <input type="hidden" name="csrf_token" value="<?= $csrf_token ?>">

            <div class="flex gap-5">
              <div class="group w-full">

                <div class="mb-2 w-full">
                  <label for="first_name" class="block mb-2.5 text-sm font-medium text-heading">First Name</label>
                  <input type="text" id="first_name" value="<?= $data['first_name'] ?>" name="first_name" class="bg-neutral-secondary-medium border border-default-medium text-heading text-sm rounded-lg focus:ring-brand focus:border-brand block w-full px-3 py-2.5 shadow-xs placeholder:text-body" placeholder="Ahmed" />
                </div>
                <p class="text-rose-500"><?= $errors['first_name'] ?? "" ?></p>
              </div>
              <div class="group w-full">
                <div class="mb-2 w-full">
                  <label for="last_name" class="block mb-2.5 text-sm font-medium text-heading">Last Name</label>
                  <input type="last_name" id="last_name" name="last_name" value="<?= $data['last_name'] ?>" class="bg-neutral-secondary-medium border border-default-medium text-heading text-sm rounded-lg focus:ring-brand focus:border-brand block w-full px-3 py-2.5 shadow-xs placeholder:text-body" placeholder="Khan" />
                </div>
                <p class="text-rose-500"><?= $errors['last_name'] ?? "" ?></p>
              </div>
            </div>
            <div class="flex gap-5">
              <div class="group w-full">
                <div class="mb-2 w-full">
                  <label for="phone" class="block mb-2.5 text-sm font-medium text-heading">Phone</label>
                  <input type="text" id="phone" name="phone" value="<?= $data['phone'] ?>" class="bg-neutral-secondary-medium border border-default-medium text-heading text-sm rounded-lg focus:ring-brand focus:border-brand block w-full px-3 py-2.5 shadow-xs placeholder:text-body" placeholder="09887654363" />
                </div>
                <p class="text-rose-500"><?= $errors['phone'] ?? "" ?></p>
              </div>
              <div class="group w-full">
                <div class="mb-2 w-full">
                  <label for="profile" class="block mb-2.5 text-sm font-medium text-heading">Profile</label>
                  <input type="file" id="profile" name="profile" class="bg-neutral-secondary-medium border border-default-medium text-heading text-sm rounded-lg focus:ring-brand focus:border-brand block w-full px-3 py-2.5 shadow-xs placeholder:text-body" />
                </div>
                <p class="text-rose-500"><?= $errors['profile'] ?? "" ?></p>
              </div>

            </div>
            <div class="mt-3 flex gap-3">
              <button type="submit" class="rounded-md px-6 py-2 bg-purple-500 hover:bg-purple-600 text-white">
                Save
              </button>
              <a href="/student/dashboard/profile" class="rounded-md px-6 py-2 bg-gray-500 hover:bg-gray-600 text-white">
                Back
              </a>
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