<?php
require_once(getenv('PROJECT_ROOT').'/vendor/autoload.php');
if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}

if (!isset($_SESSION['access_token'])) {
    header('Location: index.php');
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Easy KSE schedule</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<div class="container">
    <h1>You are now logged in</h1>
    <form action="action/schedule_request.php">
        <label for="timeframe">Select a timeframe:</label>
        <select name="timeframe" id="timeframe">
            <option value="this_week">This week</option>
            <option value="this_month">This month</option>
            <option value="next_week">Next week</option>
            <option value="next_month">Next month</option>
        </select>

        <label for="end_date">Or choose an end date:</label>
        <input type="date" id="end_date" name="end_date">

        <label for="format">I want my schedule in:</label>
        <select name="format" id="format">
            <option value="pdf">.pdf</option>
            <option value="ical">.ics</option>
        </select>

        <input type="submit" value="Get schedule">
    </form>
</div>
</body>
</html>
