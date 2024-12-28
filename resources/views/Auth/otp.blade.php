<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login Page</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <meta name="csrf-token" content="{{csrf_token()}}">
</head>
<body class="bg-gray-100 flex items-center justify-center min-h-screen">

  <div class="bg-white shadow-lg rounded-lg p-8 max-w-sm w-full">
    <h2 class="text-2xl font-bold text-center mb-6 text-gray-700">Verify OTP</h2>
    <form action="/verify-otp" method="POST">
        @csrf
      <div class="mb-4">
        <label for="password" class="block text-gray-600 mb-2">OTP</label>
        <input
          type="text"
          id="password"
          name="otp"
          placeholder="Enter your OTP"
          required
          class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring focus:ring-blue-300 border-gray-300"
        >
      </div>


      <!-- Submit Button -->
      <button
        type="submit"
        class="w-full bg-blue-500 text-white py-2 px-4 rounded-lg hover:bg-blue-600 transition duration-200"
      >
        Verfiy
      </button>
    </form>
  </div>

</body>
</html>
