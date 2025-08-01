<?php
session_start();

// Redirect if not logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// DB Connection
$conn = new mysqli("localhost", "root", "", "skillswap");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch skills with user name
$sql = "SELECT skills.*, users.name FROM skills JOIN users ON skills.user_id = users.id";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Browse Skills</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gradient-to-br from-blue-100 to-purple-200 min-h-screen p-6">

    <div class="max-w-4xl mx-auto bg-white rounded-xl shadow-md p-8">
        <h1 class="text-3xl font-bold text-center text-indigo-700 mb-6">📚 Browse Available Skills</h1>

        <?php if (isset($_SESSION['message'])): ?>
            <div class="bg-yellow-100 border border-yellow-400 text-yellow-800 p-3 rounded mb-4 text-center">
                <?= htmlspecialchars($_SESSION['message']) ?>
            </div>
            <?php unset($_SESSION['message']); ?>
        <?php endif; ?>

        <?php if ($result->num_rows > 0): ?>
            <div class="space-y-6">
                <?php while ($row = $result->fetch_assoc()): ?>
                    <div class="p-6 bg-indigo-50 border-l-4 border-indigo-400 rounded-lg shadow-sm">
                        <h2 class="text-xl font-semibold text-indigo-900"><?= htmlspecialchars($row['skill_name']) ?></h2>
                        <p class="text-gray-700 mb-2"><?= nl2br(htmlspecialchars($row['description'])) ?></p>
                        <p class="text-sm text-gray-500">By <strong><?= htmlspecialchars($row['name']) ?></strong></p>

                        <!-- Book Button Form -->
                        <form action="book.php" method="POST" class="mt-3 inline-block">
                            <input type="hidden" name="skill_id" value="<?= $row['id'] ?>">
                            <button type="submit"
                                    class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700 transition">
                                ✅ Book
                            </button>
                        </form>
                    </div>
                <?php endwhile; ?>
            </div>
        <?php else: ?>
            <p class="text-center text-gray-600">No skills available at the moment.</p>
        <?php endif; ?>

        <div class="mt-6 text-center">
            <a href="dashboard.php" class="text-indigo-600 hover:underline">← Back to Dashboard</a>
        </div>
    </div>

</body>
</html>
