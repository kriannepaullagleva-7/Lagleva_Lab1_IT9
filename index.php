<?php
session_start();

// Show errors (remove in production)
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Redirect if not logged in
if (!isset($_SESSION['username'])) {
    header("Location: /assessment_beginner/pages/login.php");
    exit();
}

// Database connection
include "db.php";

if (!$conn) {
    die("Database connection failed: " . mysqli_connect_error());
}

// Function to get total count from a table
function getCount($conn, $table) {
    $sql = "SELECT COUNT(*) AS total FROM $table";
    $result = mysqli_query($conn, $sql);

    if ($result) {
        $row = mysqli_fetch_assoc($result);
        return $row['total'];
    }

    return 0;
}

// Get dashboard data
$clients  = getCount($conn, "clients");
$services = getCount($conn, "services");
$bookings = getCount($conn, "bookings");

// Get total revenue
$revenue = 0;
$revSQL = "SELECT IFNULL(SUM(amount_paid),0) AS total FROM payments";
$revResult = mysqli_query($conn, $revSQL);

if ($revResult) {
    $revRow = mysqli_fetch_assoc($revResult);
    $revenue = $revRow['total'];
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Dashboard</title>

    <!-- Main CSS -->
    <link rel="stylesheet" href="css/style.css">
</head>

<body>

<?php include "nav.php"; ?>

<div class="dashboard-container">

    <h1>Dashboard</h1>
    <h3>Welcome, <?php echo htmlspecialchars($_SESSION['username']); ?>!</h3>

    <ul class="stats-list">
        <li>Total Clients: <b><?php echo $clients; ?></b></li>
        <li>Total Services: <b><?php echo $services; ?></b></li>
        <li>Total Bookings: <b><?php echo $bookings; ?></b></li>
        <li>Total Revenue: 
            <b>₱<?php echo number_format($revenue, 2); ?></b>
        </li>
    </ul>

    <div class="quick-links">
        <h4>Quick Links</h4>

        <a href="/assessment_beginner/pages/clients_add.php">
            ➕ Add Client
        </a>

        <a href="/assessment_beginner/pages/bookings_create.php">
            📅 Create Booking
        </a>
    </div>

</div>

</body>
</html>