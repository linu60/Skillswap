<?php
session_start();
include 'config.php'; // make sure this file connects to DB with $conn

$message = ""; // for displaying error/success

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email'] ?? '');
    $password = trim($_POST['password'] ?? '');

    if (!empty($email) && !empty($password)) {
        // Prepare statement
        $stmt = $conn->prepare("SELECT * FROM users WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();

        // Check if user found
        if ($result->num_rows === 1) {
            $user = $result->fetch_assoc();

            // Verify password using password_verify
            if (password_verify($password, $user['password'])) {
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['user_name'] = $user['name'];
                header("Location: dashboard.php");
                exit();
            } else {
                $message = "❌ Invalid email or password.";
            }
        } else {
            $message = "❌ Invalid email or password.";
        }
    } else {
        $message = "⚠️ Please enter both email and password.";
    }
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    animation: {
                        'fade-in': 'fadeIn 1s ease-out both',
                        'slide-in': 'slideIn 0.8s ease-out both',
                        'float': 'float 3s ease-in-out infinite'
                    },
                    keyframes: {
                        fadeIn: {
                            '0%': { opacity: 0 },
                            '100%': { opacity: 1 }
                        },
                        slideIn: {
                            '0%': { transform: 'translateY(40px)', opacity: 0 },
                            '100%': { transform: 'translateY(0)', opacity: 1 }
                        },
                        float: {
                            '0%, 100%': { transform: 'translateY(0px)' },
                            '50%': { transform: 'translateY(-8px)' }
                        }
                    }
                }
            }
        };
    </script>
</head>
<body class="h-screen w-screen flex items-center justify-center  animate-fade-in bg-[url('bg.jpg')] bg-cover bg-center min-h-screen flex relative overflow-hidden">

    <form method="POST" class="bg-white/90 backdrop-blur-lg border border-white/30 shadow-2xl rounded-2xl p-8 w-full max-w-md animate-slide-in">
        <h2 class="text-3xl font-extrabold text-center text-purple-700 mb-6 drop-shadow-md">🔐 Login to SkillSwap</h2>

        <?php if($message): ?>
            <p class="mb-4 text-center font-medium text-red-700 animate-fade-in"><?= $message ?></p>
        <?php endif; ?>

        <input type="email" name="email" placeholder="Email" required
            class="mb-4 w-full px-4 py-3 bg-white/70 border-2 border-pink-300 rounded-xl shadow-md focus:outline-none focus:ring-2 focus:ring-pink-400 transition-all duration-300 placeholder-gray-600 text-gray-900 font-semibold hover:scale-[1.02] animate-float" />

        <input type="password" name="password" placeholder="Password" required
            class="mb-6 w-full px-4 py-3 bg-white/70 border-2 border-red-300 rounded-xl shadow-md focus:outline-none focus:ring-2 focus:ring-red-400 transition-all duration-300 placeholder-gray-600 text-gray-900 font-semibold hover:scale-[1.02] animate-float" />

        <button type="submit"
            class="w-full py-3 rounded-xl text-white font-bold text-lg bg-gradient-to-r from-purple-600 via-pink-500 to-red-500 hover:from-red-600 hover:to-purple-600 shadow-lg hover:shadow-xl transition-transform transform hover:scale-105 duration-300">
            🚀 Login
        </button>

        <p class="text-sm mt-6 text-center text-gray-700">
            Don’t have an account?
            <a href="register.php" class="text-blue-700 font-semibold hover:underline">Register here</a>
        </p>
    </form>
</body>
</html>

