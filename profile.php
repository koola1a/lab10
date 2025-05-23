<?php
session_start();
require_once("settings.php");

// Check if user is logged in
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

$username = $_SESSION['username'];

// Fetch user data from DB
$username_esc = mysqli_real_escape_string($conn, $username);
$sql = "SELECT username, email FROM Users WHERE username='$username_esc'";
$result = mysqli_query($conn, $sql);

if ($result && mysqli_num_rows($result) === 1) {
    $user = mysqli_fetch_assoc($result);
} else {
    // Something wrong - logout user
    session_destroy();
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8" />
<title>Profile Page</title>
</head>
<body>

<h2>Your Profile</h2>

<p><strong>Username:</strong> <?php echo htmlspecialchars($user['username']); ?></p>
<p><strong>Email:</strong> <?php echo htmlspecialchars($user['email']); ?></p>

<h3>Edit Profile</h3>
<form method="post" action="update_profile.php">
    <label>New Email:
        <input type="email" name="email" value="<?php echo htmlspecialchars($user['email']); ?>" required>
    </label><br><br>
    <input type="submit" value="Update Email">
</form>

<br>
<form method="post" action="login.php">
    <input type="submit" value="Logout">
</form>

</body>
</html>