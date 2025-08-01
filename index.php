<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Welcome to SkillSwap</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <style>
    body {
      cursor: none;
    }

    .cursor-bubble {
      position: fixed;
      width: 20px;
      height: 20px;
      border-radius: 50%;
      background-color: rgba(0, 0, 9, 0.6);
      pointer-events: none;
      z-index: 9999;
      transition: transform 0.1s ease-out;
      mix-blend-mode: multiply;
    }

    @keyframes fadeInUp {
      from { opacity: 0; transform: translateY(20px); }
      to { opacity: 1; transform: translateY(0); }
    }

    .fade-up {
      animation: fadeInUp 0.8s ease-out both;
    }

    .menu-link:hover {
      transform: translateX(5px);
      background-color: rgba(255, 255, 255, 0.15);
    }

    .sidebar {
      background: linear-gradient(to bottom right, #cfd9ff, #e4e9ff);
    }

    .footer-transparent {
      background-color: rgba(255, 255, 255, 0.75);
      backdrop-filter: blur(6px);
    }

    .footer-title {
      font-weight: 700;
      font-size: 1.25rem;
      animation: bounceText 2s infinite ease-in-out;
    }

    .footer-text {
      color: #1f2937;
      animation: bounceText 2s infinite ease-in-out;
    }

    .footer-link {
      color: #1f2937;
      transition: all 0.3s ease-in-out;
      animation: bounceText 2s infinite ease-in-out;
    }

    .footer-link:hover {
      color: #4f46e5;
      transform: scale(1.05);
    }

    @keyframes bounceText {
      0%, 100% {
        transform: translateY(0);
      }
      50% {
        transform: translateY(-5px);
      }
    }
  </style>
</head>
<body class="bg-[url('bg.jpg')] bg-cover bg-center min-h-screen overflow-y-auto flex flex-col">

  <!-- Custom Cursor -->
  <div id="cursor" class="cursor-bubble"></div>

  <div class="flex flex-1 overflow-hidden">
    <!-- Sidebar -->
    <aside class="sidebar w-64 text-gray-800 flex flex-col justify-between p-6 shadow-lg">
      <div>
        <h1 class="text-3xl font-extrabold mb-10 animate-pulse">🔁 SkillSwap</h1>
        <nav class="space-y-3">
          <a href="index.php" class="block menu-link transition-all p-2 rounded">🏠 Home</a>
          <a href="login.php" class="block menu-link transition-all p-2 rounded">🔐 Login</a>
          <a href="register.php" class="block menu-link transition-all p-2 rounded">📝 Register</a>
          <a href="bookings.php" class="block menu-link transition-all p-2 rounded">📅 My Bookings</a>
          <a href="addskill.php" class="block menu-link transition-all p-2 rounded">➕ Add Skill</a>
          <a href="browseskills.php" class="block menu-link transition-all p-2 rounded">🔍 Browse Skills</a>
        </nav>
      </div>
      <div class="mt-8">
        <a href="logout.php" class="block menu-link transition-all p-2 rounded">🚪 Logout</a>
      </div>
    </aside>

    <!-- Main Content -->
    <main class="flex-1 p-10 overflow-y-auto">
      <div class="max-w-4xl mx-auto bg-white/75 backdrop-blur-md rounded-2xl shadow-xl p-10 fade-up mb-16">
        <h2 class="text-4xl font-bold text-indigo-700 mb-6 fade-up">Welcome to SkillSwap! 🚀</h2>
        <p class="text-lg text-gray-800 leading-relaxed mb-6 fade-up delay-100">
          SkillSwap is your gateway to learning and teaching real-world skills. Whether you're great at coding, singing, cooking, or anything else — share your talent and learn from others for free.
        </p>

        <ul class="list-disc pl-6 text-gray-800 space-y-2 fade-up delay-200">
          <li><strong>Register:</strong> Sign up and join our growing learning community.</li>
          <li><strong>Add Skills:</strong> Post what you know and want to teach.</li>
          <li><strong>Book Sessions:</strong> Browse and book skills to learn.</li>
          <li><strong>Track Bookings:</strong> Manage all your booked sessions.</li>
        </ul>

        <div class="mt-10 fade-up delay-300">
          <?php if (!isset($_SESSION['user_id'])): ?>
            <a href="register.php" class="bg-indigo-400 text-white px-6 py-3 rounded-lg shadow-lg hover:bg-indigo-500 transition">
              ✨ Get Started Now
            </a>
          <?php else: ?>
            <a href="dashboard.php" class="bg-green-500 text-white px-6 py-3 rounded-lg shadow-lg hover:bg-green-600 transition">
              🚀 Go to Dashboard
            </a>
          <?php endif; ?>
        </div>
      </div>
    </main>
  </div>

  <!-- Footer -->
  <footer class="footer-transparent px-6 py-12 text-center mt-auto">
    <div class="flex flex-col items-center space-y-8 max-w-4xl mx-auto">

      <div>
        <h3 class="footer-title mb-2 text-gray-800">About SkillSwap</h3>
        <p class="footer-text text-base max-w-md mx-auto">
          A platform where you can share your knowledge and learn from others. We believe in community-powered education for everyone.
        </p>
      </div>

      <div>
        <h3 class="footer-title mb-2 text-gray-800">Quick Link</h3>
        <a href="index.php" class="footer-link text-base">🏠 Home</a>
      </div>

      <div>
        <h3 class="footer-title mb-2 text-gray-800">Developed By</h3>
        <p class="footer-text">LINU UPRASI</p>
      </div>
    </div>

    <div class="border-t border-gray-300 mt-10 pt-4 text-sm text-gray-700">
      &copy; <?php echo date("Y"); ?> SkillSwap. All rights reserved.
    </div>
  </footer>

  <!-- Cursor Script -->
  <script>
    const cursor = document.getElementById("cursor");
    document.addEventListener("mousemove", (e) => {
      cursor.style.left = e.clientX + "px";
      cursor.style.top = e.clientY + "px";
    });
  </script>
</body>
</html>
