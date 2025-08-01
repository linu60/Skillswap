<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Dashboard</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    animation: {
                        fadeIn: 'fadeIn 1s ease-out forwards',
                        slideInLeft: 'slideInLeft 1s ease-out forwards',
                        slideInRight: 'slideInRight 1s ease-out forwards',
                        zoomIn: 'zoomIn 0.8s ease-out forwards',
                        rotateIn: 'rotateIn 0.8s ease-out forwards',
                        glowPulse: 'glowPulse 2s ease-in-out infinite',
                    },
                    keyframes: {
                        fadeIn: {
                            '0%': { opacity: 0 },
                            '100%': { opacity: 1 }
                        },
                        slideInLeft: {
                            '0%': { transform: 'translateX(-100%)', opacity: 0 },
                            '100%': { transform: 'translateX(0)', opacity: 1 }
                        },
                        slideInRight: {
                            '0%': { transform: 'translateX(100%)', opacity: 0 },
                            '100%': { transform: 'translateX(0)', opacity: 1 }
                        },
                        zoomIn: {
                            '0%': { transform: 'scale(0.7)', opacity: 0 },
                            '100%': { transform: 'scale(1)', opacity: 1 }
                        },
                        rotateIn: {
                            '0%': { transform: 'rotate(-180deg)', opacity: 0 },
                            '100%': { transform: 'rotate(0)', opacity: 1 }
                        },
                        glowPulse: {
                            '0%, 100%': { boxShadow: '0 0 0px transparent' },
                            '50%': { boxShadow: '0 0 20px 5px rgba(255,255,255,0.4)' }
                        }
                    }
                }
            }
        };
    </script>
</head>
<body class="bg-gradient-to-br from-indigo-700 via-purple-700 to-pink-700 min-h-screen flex items-center justify-center p-6">

    <div class="bg-white/90 backdrop-blur-xl p-10 shadow-2xl rounded-3xl max-w-xl w-full animate-fadeIn">
        <h2 class="text-4xl font-bold text-center text-indigo-800 mb-8 animate-zoomIn">
            👋 Welcome, <?= strtoupper($_SESSION['user_name']) ?>
        </h2>

        <div class="space-y-6">
            <!-- Add Skill -->
            <a href="addskill.php"
               class="block bg-gradient-to-r from-pink-500 to-red-500 text-white text-xl py-3 rounded-xl shadow-lg transform transition-all duration-300 hover:scale-105 hover:brightness-110 hover:animate-glowPulse animate-slideInLeft">
                ➕ Add a Skill
            </a>

            <!-- Browse Skills -->
            <a href="browseskills.php"
               class="block bg-gradient-to-r from-green-400 via-lime-500 to-green-600 text-white text-xl py-3 rounded-xl shadow-lg transform transition-all duration-300 hover:scale-105 hover:contrast-125 hover:animate-glowPulse animate-slideInRight">
                🔍 Browse Skills
            </a>

            <!-- My Bookings -->
            <a href="bookings.php"
               class="block bg-gradient-to-r from-yellow-400 via-orange-500 to-red-400 text-black text-xl py-3 rounded-xl shadow-lg transform transition-all duration-300 hover:scale-105 hover:animate-glowPulse animate-rotateIn">
                📅 My Bookings
            </a>

            <!-- Logout -->
            <a href="logout.php"
               class="block mt-6 text-blue-800 font-semibold hover:underline hover:text-blue-600 transition-all duration-200 text-center animate-fadeIn">
                🚪 Logout
            </a>
        </div>
    </div>

</body>
</html>
