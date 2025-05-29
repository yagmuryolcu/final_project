<?php
include 'includes/config.php';

if (isset($_GET['query']) && !empty(trim($_GET['query']))) {
    // 1. Girdiyi temizle (XSS koruması)
    $searchTerm = strtolower(trim($_GET['query']));
    $cleaned = htmlspecialchars($searchTerm, ENT_QUOTES, 'UTF-8');

    // 2. Hazırlanmış ifade ile güvenli veri tabanı kaydı (SQL Injection koruması)
    $stmt = $conn->prepare("INSERT INTO records (words) VALUES (?)");
    $stmt->bind_param("s", $cleaned);
    $stmt->execute();
    $stmt->close();

    // Yönlendirme
    switch ($searchTerm) {
        case 'home':
        case 'anasayfa':
            header("Location: index.php");
            break;

        case 'about':
        case 'hakkımızda':
            header("Location: about.php");
            break;

        case 'services':
        case 'service':
        case 'hizmetler':
            header("Location: services.php");
            break;

        case 'contact':
        case 'iletişim':
            header("Location: contact.php");
            break;

        case 'education':
        case 'eğitim':
        case 'video':
        case 'videos':
        case 'videolar':
        case 'eğitim videoları':
            header("Location: education_videos.php");
            break;

        default:
            // Eşleşme yoksa ana sayfaya yönlendir
            header("Location: notfound.php");
            break;
    }

    exit;
}
?>
