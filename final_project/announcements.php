<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($_POST['announcement'])) {
    $announcement = strip_tags(trim($_POST['announcement']));
    file_put_contents('announcements.txt', $announcement . PHP_EOL, FILE_APPEND);
}
?>
<div style='background-color: #e5e7eb; padding: 20px; border-radius: 10px; max-width: 700px;'>
    <h2>Announcements</h2>
    <form method='POST'>
        <label><strong>Post New Announcement</strong></label><br>
        <textarea name='announcement' rows='4' style='width:100%; border-radius:10px; margin-top:10px;'></textarea><br>
        <button class='add-button' type='submit' style='margin-top:10px;'>📢 Post</button>
    </form>
    <?php
    if (file_exists('announcements.txt')) {
        $lines = file('announcements.txt', FILE_IGNORE_NEW_LINES);
        echo "<hr><h3>Previous Announcements:</h3><ul>";
        foreach (array_reverse($lines) as $line) {
            echo "<li>" . htmlspecialchars($line) . "</li>";
        }
        echo "</ul>";
    }
    ?>
</div>
