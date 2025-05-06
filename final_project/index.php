<?php
require 'db.php'; // Include database connection

// Fetch total members count
$totalMembers = $conn->query("SELECT COUNT(*) FROM members")->fetchColumn();
// index.php
$page = isset($_GET['page']) ? $_GET['page'] : 'dashboard';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Panel</title>
    <link rel="stylesheet" href="style.css">

    <!-- Google Charts -->
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript">
    google.charts.load('current', {'packages':['corechart']});
    google.charts.setOnLoadCallback(drawComboChart);

    function drawComboChart() {
        var data = google.visualization.arrayToDataTable([
            ['Category', 'Count', {type: 'number', role: 'annotation'}],
            ['Total Members', <?= $totalMembers ?>, <?= $totalMembers ?>],
            ['Borrowed Equipment', 15, 15],
            ['Announcements', 3, 3]
        ]);

        var options = {
            title: 'System Overview',
            vAxis: {title: 'Count'},
            hAxis: {title: 'Category'},
            seriesType: 'bars',
            series: {2: {type: 'line'}},
            annotations: { alwaysOutside: true }
        };

        var chart = new google.visualization.ComboChart(document.getElementById('combochart_div'));
        chart.draw(data, options);
    }
</script>
</head>
<body>
    <?php include 'sidebar.php'; ?>
    <div class="content">
        <?php
        $allowed_pages = ['dashboard', 'members', 'equipment', 'announcements', 'reports', 'settings'];
        if (in_array($page, $allowed_pages)) {
            include $page . '.php';
        } else {
            echo "<h1>Page not found.</h1>";
        }
        ?>
    </div>
</body>
</html>
