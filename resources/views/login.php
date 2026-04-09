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
    <h2 class="text-2xl font-bold text-gray-800 mb-6 text-center">Login</h2>

    <form action="login.php" method="POST" class="space-y-4">
      <div>
        <label for="email" class="block text-gray-700 mb-1">Email</label>
        <input type="email" name="email" id="email" placeholder="you@example.com"
          class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400">
      </div>

      <div>
        <label for="password" class="block text-gray-700 mb-1">Password</label>
        <input type="password" name="password" id="password" placeholder="Password"
          class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400">
      </div>

      <div class="flex items-center">
        <input type="checkbox" name="remember" id="remember" class="mr-2">
        <label for="remember" class="text-gray-700">Remember Me</label>
      </div>

      <button type="submit"
        class="w-full bg-blue-500 text-white py-2 rounded-lg hover:bg-blue-600 transition duration-200">Login</button>
    </form>

    <p class="text-center text-gray-500 mt-4">
      Don’t have an account?
      <a href="/register" class="text-blue-500 hover:underline">Register</a>
    </p>
  </div>
</body>

</html>