<?php

use App\Services\Session;

$old = Session::flash('old') ?? [];
$errors = Session::flash('errors') ?? [];

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Register</title>
  <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>

</head>

<body class="bg-gray-100 flex items-center justify-center min-h-screen">
  <div class="bg-white p-8 rounded-lg shadow-lg w-full max-w-md">
    <h2 class="text-2xl font-bold text-gray-800 mb-6 text-center">Student Registration</h2>

    <form action="/student-register" method="POST" class="space-y-4" enctype="multipart/form-data">
      <input type="hidden" name="csrf_token" value="<?= $csrf_token ?>">
      <div>
        <label for="name" class="block text-gray-700 mb-1">First Name</label>
        <input type="text" name="first_name" id="name" placeholder="Your Name" value="<?= $old['first_name'] ?? "" ?>"
          class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400">

        <p class="text-red-500"><?= $errors['first_name'] ?? "" ?></p>
      </div>

      <div>
        <label for="name" class="block text-gray-700 mb-1">Last Name</label>
        <input type="text" name="last_name" id="name" placeholder="Your Name" value="<?= $old['last_name'] ?? "" ?>"
          class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400">
        <p class="text-red-500"><?= $errors['last_name'] ?? "" ?></p>

      </div>

      <div>
        <label for="email" class="block text-gray-700 mb-1">Email</label>
        <input type="email" name="email" id="email" placeholder="you@example.com" value="<?= $old['email'] ?? "" ?>"
          class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400">
        <p class="text-red-500"><?= $errors['email'] ?? "" ?></p>

      </div>

      <div>
        <label for="password" class="block text-gray-700 mb-1">Password</label>
        <input type="password" name="password" id="password" placeholder="Password" value="<?= $old['password'] ?? "" ?>"
          class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400">
        <p class="text-red-500"><?= $errors['password'] ?? "" ?></p>

      </div>
      <!-- phone  -->
      <div>
        <label for="password" class="block text-gray-700 mb-1">Phone</label>
        <input type="phone" name="phone" id="phone" placeholder="Phone" value="<?= $old['phone'] ?? "" ?>"
          class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400">
        <p class="text-red-500"><?= $errors['phone'] ?? "" ?></p>

      </div>
      <!-- profile  -->
      <div>
        <label for="name" class="block text-gray-700 mb-1">Profile</label>
        <input type="file" name="profile" id="profile" placeholder="Your Name"
          class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400">
        <p class="text-red-500"><?= $errors['profile'] ?? "" ?></p>

      </div>

      <button type="submit" name="register"
        class="cursor-pointer w-full bg-gray-900 text-white py-2 rounded-lg hover:bg-gray-600 transition duration-200">Register</button>
    </form>

    <p class="text-center text-gray-900 mt-4">
      Already have an account?
      <a href="/" class="text-gray-500 hover:underline">Login</a>
    </p>
  </div>
</body>

</html>