<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

// DB connection
$conn = new mysqli("localhost", "root", "", "skillswap");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$user_id = $_SESSION['user_id'];

// Fetch booked skills for the user
$sql = "SELECT skills.skill_name, skills.description, skills.skill_type, users.name AS provider_name
        FROM bookings
        JOIN skills ON bookings.skill_id = skills.id
        JOIN users ON skills.user_id = users.id
        WHERE bookings.user_id = ?";

$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html>
<head>
    <title>My Bookings</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    animation: {
                        fade: 'fadeIn 1s ease-out both',
                        bouncein: 'bounceIn 1.2s ease-out both',
                    },
                    keyframes: {
                        fadeIn: {
                            '0%': { opacity: 0 },
                            '100%': { opacity: 1 }
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
<body class="bg-gradient-to-br from-yellow-100 to-pink-200 min-h-screen flex items-center justify-center p-6">

    <div class="bg-white shadow-2xl rounded-xl p-10 w-full max-w-2xl animate-fade">
        <h2 class="text-3xl font-extrabold text-center text-pink-600 mb-6 animate-bouncein">
            📅 Your Bookings
        </h2>

        <?php if ($result->num_rows === 0): ?>
            <p class="text-center text-gray-500">You haven't booked any sessions yet.</p>
        <?php else: ?>
            <ul class="space-y-4">
                <?php while ($row = $result->fetch_assoc()): ?>
                    <li class="bg-pink-100 border-l-4 border-pink-500 rounded-md p-4 shadow-md hover:scale-[1.02] transition">
                        <p class="font-semibold text-lg text-pink-700">Skill: <?= htmlspecialchars($row['skill_name']) ?></p>
                        <p class="text-sm text-gray-600"><?= htmlspecialchars($row['description']) ?></p>
                        <p class="text-sm text-gray-600">Type: <?= htmlspecialchars($row['skill_type']) ?></p>
                        <p class="text-sm text-gray-500">By: <?= htmlspecialchars($row['provider_name']) ?></p>
                    </li>
                <?php endwhile; ?>
            </ul>
        <?php endif; ?>

        <div class="mt-6 text-center">
            <a href="dashboard.php" class="text-blue-600 hover:underline">← Back to Dashboard</a>
        </div>
    </div>
</body>
</html>
