<?php
// admin_panel.php
$page = isset($_GET['page']) ? $_GET['page'] : 'dashboard';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Panel</title>
    <style>
        body {
            margin: 0;
            font-family: Arial, sans-serif;
            display: flex;
        }
        .sidebar {
            width: 250px;
            background-color: #1d4ed8;
            color: white;
            height: 100vh;
            padding: 20px;
        }
        .sidebar h2 {
            font-size: 24px;
            margin-bottom: 30px;
        }
        .sidebar a {
            display: block;
            color: white;
            text-decoration: none;
            margin: 15px 0;
            font-size: 18px;
        }
        .sidebar a.active {
            font-weight: bold;
            background-color: #2563eb;
            padding: 10px;
            border-radius: 8px;
        }
        .content {
            flex: 1;
            padding: 30px;
            background-color: #f9fafb;
            overflow-y: auto;
        }
        .card {
            background-color: #e5e7eb;
            padding: 20px;
            margin-bottom: 20px;
            display: inline-block;
            border-radius: 8px;
            margin-right: 20px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        th, td {
            border: 1px solid #1d4ed8;
            padding: 10px;
            text-align: left;
        }
        th {
            background-color: #1d4ed8;
            color: white;
        }
        .add-button {
            background-color: #1d4ed8;
            color: white;
            padding: 10px 15px;
            border: none;
            border-radius: 5px;
            margin-top: 10px;
            cursor: pointer;
        }
    </style>

    <!-- Google Charts Loader -->
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript">
      google.charts.load('current', {'packages':['corechart']});
      google.charts.setOnLoadCallback(drawComboChart);

      function drawComboChart() {
        var data = google.visualization.arrayToDataTable([
          ['Category', 'Count', {type: 'number', role: 'annotation'}],
          ['Total Members', 50, 50],
          ['Borrowed Equipment', 15, 15],
          ['Announcements', 3, 3]
        ]);

        var options = {
          title : 'System Overview',
          vAxis: {title: 'Count'},
          hAxis: {title: 'Category'},
          seriesType: 'bars',
          series: {2: {type: 'line'}},
          annotations: {
            alwaysOutside: true
          }
        };

        var chart = new google.visualization.ComboChart(document.getElementById('combochart_div'));
        chart.draw(data, options);
      }
    </script>
</head>
<body>

<div class="sidebar">
    <h2>Admin Panel</h2>
    <a href="?page=dashboard" class="<?= $page == 'dashboard' ? 'active' : '' ?>">🏠 Dashboard</a>
    <a href="?page=members" class="<?= $page == 'members' ? 'active' : '' ?>">👤 Manage Members</a>
    <a href="?page=equipment" class="<?= $page == 'equipment' ? 'active' : '' ?>">🏀 Manage Equipment</a>
    <a href="?page=announcements" class="<?= $page == 'announcements' ? 'active' : '' ?>">📢 Announcements</a>
    <a href="?page=reports" class="<?= $page == 'reports' ? 'active' : '' ?>">📊 Reports</a>
    <a href="?page=settings" class="<?= $page == 'settings' ? 'active' : '' ?>">⚙️ Settings</a>
</div>

<div class="content">
    <?php
    if ($page == 'dashboard') {
        echo "<h1>Dashboard</h1>";
        echo "<div class='card'>Total Members: 50</div>";
        echo "<div class='card'>Borrowed Equipment: 15</div>";
        echo "<div class='card'>Announcements: 3</div>";
        echo "<div id='combochart_div' style='width: 900px; height: 500px; margin-top: 30px;'></div>";
    } elseif ($page == 'members') {
        echo "<h1>Manage Members</h1>";
        echo "<button class='add-button'>+ Add Member</button>";
        echo "<table>";
        echo "<tr><th>ID</th><th>NAME</th><th>EMAIL</th><th>ROLE</th><th>ACTION</th></tr>";
        echo "<tr><td>1</td><td>benz</td><td>benz@example.com</td><td>Member</td><td>Edit | Delete</td></tr>";
        echo "<tr><td>2</td><td>bebe</td><td>ebeb@example.com</td><td>Member</td><td>Edit | Delete</td></tr>";
        echo "</table>";
    } elseif ($page == 'equipment') {
        echo "<h1>Manage Equipment</h1>";
        echo "<button class='add-button'>+ Add Equipment</button>";
        echo "<table>";
        echo "<tr><th>ID</th><th>Name</th><th>Status</th><th>Actions</th></tr>";
        echo "<tr><td>1</td><td>Basketball</td><td>Available</td><td>Edit | Delete</td></tr>";
        echo "<tr><td>2</td><td>Volleyball Net</td><td>Borrowed</td><td>Edit | Delete</td></tr>";
        echo "<tr><td>3</td><td>Whistle</td><td>Available</td><td>Edit | Delete</td></tr>";
        echo "</table>";
    } elseif ($page == 'announcements') {
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($_POST['announcement'])) {
            $announcement = strip_tags(trim($_POST['announcement']));
            file_put_contents('announcements.txt', $announcement . PHP_EOL, FILE_APPEND);
        }

        echo "<div style='background-color: #e5e7eb; padding: 20px; border-radius: 10px; max-width: 700px;'>";
        echo "<h2>Announcements</h2>";
        echo "<form method='POST'>";
        echo "<label><strong>Post New Announcement</strong></label><br>";
        echo "<textarea name='announcement' rows='4' style='width:100%; border-radius:10px; margin-top:10px;'></textarea><br>";
        echo "<button class='add-button' type='submit' style='margin-top:10px;'>📢 Post</button>";
        echo "</form>";

        if (file_exists('announcements.txt')) {
            $lines = file('announcements.txt', FILE_IGNORE_NEW_LINES);
            echo "<hr><h3>Previous Announcements:</h3><ul>";
            foreach (array_reverse($lines) as $line) {
                echo "<li>" . htmlspecialchars($line) . "</li>";
            }
            echo "</ul>";
        }
        echo "</div>";
    } elseif ($page == 'reports') {
        echo "<h1>Reports</h1>";
        echo "<h3>Borrowed Equipment Report</h3>";
        echo "<table>";
        echo "<tr><th>Equipment</th><th>Borrower</th><th>Date Borrowed</th><th>Return Date</th></tr>";
        echo "<tr><td>Basketball</td><td>Benz tinga</td><td>March 15, 2025</td><td>March 20, 2025</td></tr>";
        echo "<tr><td>Tennis Racket</td><td>Loren Dacol</td><td>March 18, 2025</td><td>March 25, 2025</td></tr>";
        echo "</table>";
        echo "<button class='add-button'>📥 Download Report</button>";
    } elseif ($page == 'settings') {
        echo "<h1>Settings</h1>";
        echo "<p>Configure system settings here.</p>";
    } else {
        echo "<h1>Page not found.</h1>";
    }
    ?>
</div>

</body>
</html>