<?php
session_start();
require_once("settings.php");

if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $new_email = $_POST['email'] ?? '';
    $username = $_SESSION['username'];

    // Validate email format
    if (!filter_var($new_email, FILTER_VALIDATE_EMAIL)) {
        die("Invalid email format");
    }

    $username_esc = mysqli_real_escape_string($conn, $username);
    $email_esc = mysqli_real_escape_string($conn, $new_email);

    $sql = "UPDATE Users SET email='$email_esc' WHERE username='$username_esc'";

    if (mysqli_query($conn, $sql)) {
        // Redirect back to profile with updated info
        header("Location: profile.php");
        exit();
    } else {
        die("Error updating profile: " . mysqli_error($conn));
    }
} else {
    // Not a POST request
    header("Location: profile.php");
    exit();
}
?>