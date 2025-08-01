<?php
session_start();

// Redirect if not logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Database insert logic
$inserted = false;
$error = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $conn = new mysqli("localhost", "root", "", "skillswap");

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $skill_name = trim($_POST['skill_name']);
    $skill_type = trim($_POST['skill_type']);
    $description = trim($_POST['description']);
    $user_id = $_SESSION['user_id'];

    if (!empty($skill_name) && !empty($skill_type) && !empty($description)) {
        $stmt = $conn->prepare("INSERT INTO skills (user_id, skill_name, skill_type, description) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("isss", $user_id, $skill_name, $skill_type, $description);

        if ($stmt->execute()) {
            $inserted = true;
        } else {
            $error = "Error: " . $stmt->error;
        }

        $stmt->close();
    } else {
        $error = "Please fill in all fields.";
    }

    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Add Skill</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    animation: {
                        fadeInUp: 'fadeInUp 0.8s ease-out both',
                        pulseGlow: 'pulseGlow 2s ease-in-out infinite',
                        wiggle: 'wiggle 1s ease-in-out',
                        bounceIn: 'bounceIn 0.6s ease-out both'
                    },
                    keyframes: {
                        fadeInUp: {
                            '0%': { opacity: 0, transform: 'translateY(40px)' },
                            '100%': { opacity: 1, transform: 'translateY(0)' }
                        },
                        pulseGlow: {
                            '0%, 100%': { boxShadow: '0 0 0px transparent' },
                            '50%': { boxShadow: '0 0 25px rgba(99,102,241,0.6)' }
                        },
                        wiggle: {
                            '0%, 100%': { transform: 'rotate(-3deg)' },
                            '50%': { transform: 'rotate(3deg)' }
                        },
                        bounceIn: {
                            '0%': { transform: 'scale(0.9)', opacity: 0 },
                            '100%': { transform: 'scale(1)', opacity: 1 }
                        }
                    }
                }
            }
        };
    </script>
</head>
<body class="bg-gradient-to-br from-indigo-300 via-purple-300 to-pink-200 min-h-screen flex items-center justify-center px-4">

    <form method="POST" class="bg-white/90 backdrop-blur-lg p-10 rounded-3xl shadow-2xl w-full max-w-lg animate-fadeInUp">
        <h2 class="text-3xl font-bold text-center text-indigo-700 mb-6 animate-fadeInUp">🚀 Add a New Skill</h2>

        <?php if ($inserted): ?>
            <div class="bg-green-100 border border-green-400 text-green-700 p-3 rounded mb-4 text-center">
                ✅ Skill added successfully!
            </div>
        <?php elseif (!empty($error)): ?>
            <div class="bg-red-100 border border-red-400 text-red-700 p-3 rounded mb-4 text-center">
                ❌ <?= htmlspecialchars($error) ?>
            </div>
        <?php endif; ?>

        <!-- Skill Name -->
        <label class="block mb-4 animate-bounceIn">
            <span class="text-gray-700 font-medium">Skill Name</span>
            <input type="text" name="skill_name" required
                   class="mt-1 w-full p-3 border-2 border-indigo-200 rounded-xl focus:ring-2 focus:ring-indigo-400 focus:outline-none transition duration-300 hover:animate-wiggle" />
        </label>

        <!-- Skill Type -->
        <label class="block mb-4 animate-bounceIn delay-50">
            <span class="text-gray-700 font-medium">Skill Type</span>
            <input type="text" name="skill_type" required
                   class="mt-1 w-full p-3 border-2 border-indigo-200 rounded-xl focus:ring-2 focus:ring-indigo-400 focus:outline-none transition duration-300 hover:animate-wiggle" />
        </label>

        <!-- Description -->
        <label class="block mb-6 animate-bounceIn delay-100">
            <span class="text-gray-700 font-medium">Description</span>
            <textarea name="description" required rows="4"
                      class="mt-1 w-full p-3 border-2 border-indigo-200 rounded-xl focus:ring-2 focus:ring-indigo-400 focus:outline-none transition duration-300 resize-none hover:animate-wiggle"></textarea>
        </label>

        <!-- Submit Button -->
        <button type="submit"
                class="w-full py-3 bg-indigo-600 text-white font-semibold text-lg rounded-xl shadow-md hover:bg-indigo-700 transition duration-300 animate-pulseGlow">
            💾 Submit
        </button>

        <div class="text-center mt-4">
            <a href="dashboard.php" class="text-indigo-600 hover:underline">← Back to Dashboard</a>
        </div>
    </form>

</body>
</html>
