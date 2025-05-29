<?php
header("Content-Type: text/html; charset=UTF-8");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>Education Images - CyberAnalyze</title>
    <link rel="stylesheet" href="video_styles.css" />
    <script src="script_main.js" defer></script>
    <script src="https://cdn.jsdelivr.net/particles.js/2.0.0/particles.min.js"></script>
</head>
<body class="edu-page">

<?php include 'includes/header.php'; ?>
<div id="particles-js"></div>

<h2>Education Videos</h2>

<div class="video-container">
    <?php
    $items = [
        "attack_types_v1" => "Attack Types",
        "hacker_types_v2" => "Hacker Types",
        "malware_attacks_v3" => "Malware Attacks",
        "phishing_attacks_v4" => "Phishing Attacks",
        "social_engineering_v5" => "Social Engineering",
        "threat_actor_types_v6" => "Threat Actor Types"
    ];

    $folder = "education_videos"; // resimlerin olduğu klasör

    foreach ($items as $filename => $title) {
        $imagePath = "$folder/{$filename}.jpg";
        echo '<section class="video-block">';
        echo '<h4 class="video-title">' . htmlspecialchars($title) . '</h4>';
        echo '<div class="video-card">';
        if (file_exists($imagePath)) {
            echo '<img src="' . $imagePath . '" alt="' . htmlspecialchars($title) . '" class="thumbnail">';
        } else {
            echo '<div class="no-thumbnail">No image available</div>';
        }
        echo '</div>';
        echo '</section>';
    }
    ?>
</div>

<?php include 'includes/footer.php'; ?>

</body>
</html>
