<?php

use App\Services\Session;

$successMessage = Session::flash('success');
$old = Session::flash('old') ?? [];
$errors = Session::flash('errors') ?? [];
$generalError = Session::flash('error') ?? [];
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login</title>
  <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
</head>

<body class="bg-gray-100 flex items-center justify-center min-h-screen">
  <div class="bg-white p-8 rounded-lg shadow-lg w-full max-w-md">
    <?php if (!empty($successMessage)) { ?>
      <div class="rounded-md bg-green-300 text-green-800 p-4"><?= $successMessage ?? "" ?></div>
    <?php } else if (! empty($generalError)) { ?>
      <div class="rounded-md bg-rose-300 text-green-800 p-4"><?= $generalError ?? "" ?></div>
    <?php } ?>
    <h2 class="text-2xl font-bold text-gray-800 mb-6 text-center">Login</h2>

    <form action="/login" method="POST" class="space-y-4">
      <input type="hidden" name="csrf_token" value="<?= $csrf_token ?>">
      <div>
        <label for="email" class="block text-gray-700 mb-1">Email</label>
        <input type="email" name="email" id="email" placeholder="you@example.com"
          class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400">
        <p class="text-red-500"><?= $errors['email'] ?? "" ?></p>

      </div>

      <div>
        <label for="password" class="block text-gray-700 mb-1">Password</label>
        <input type="password" name="password" id="password" placeholder="Password"
          class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400">
        <p class="text-red-500"><?= $errors['password'] ?? "" ?></p>

      </div>

      <div class="flex items-center">
        <input type="checkbox" name="remember" id="remember" value="1" class="mr-2">
        <label for="remember" class="text-gray-700">Remember Me</label>
      </div>

      <button type="submit" name="login"
        class="w-full bg-gray-500 cursor-pointer text-white py-2 rounded-lg hover:bg-gray-600 transition duration-200">Login</button>
    </form>

    <p class="text-center text-gray-500 mt-4">
      Don’t have an account?
      <a href="/register" class="text-gray-500 hover:underline">Register</a>
    </p>
  </div>
</body>

</html>