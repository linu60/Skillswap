<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['skill_id'])) {
    $user_id = $_SESSION['user_id'];
    $skill_id = intval($_POST['skill_id']);

    $conn = new mysqli("localhost", "root", "", "skillswap");
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Check if booking already exists
    $check = $conn->prepare("SELECT id FROM bookings WHERE user_id = ? AND skill_id = ?");
    $check->bind_param("ii", $user_id, $skill_id);
    $check->execute();
    $result = $check->get_result();

    if ($result->num_rows > 0) {
        $_SESSION['message'] = "⚠️ You already booked this skill.";
    } else {
        $stmt = $conn->prepare("INSERT INTO bookings (user_id, skill_id) VALUES (?, ?)");
        $stmt->bind_param("ii", $user_id, $skill_id);

        if ($stmt->execute()) {
            $_SESSION['message'] = "✅ Skill booked successfully!";
        } else {
            $_SESSION['message'] = "❌ Failed to book the skill.";
        }
    }

    header("Location: browseskills.php");
    exit();
} else {
    // Invalid request
    header("Location: browseskills.php");
    exit();
}
?>
