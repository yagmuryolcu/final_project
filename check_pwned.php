<?php
/**
 * HaveIBeenPwned API ile şifre kontrolü yapan PHP betiği
 * 
 * Bu betik, bir şifrenin haveibeenpwned.com veritabanında yer alan veri ihlallerinde
 * yer alıp almadığını kontrol eder.
 */

// CSRF ve güvenlik kontrolleri
session_start();
header('X-Content-Type-Options: nosniff');
header('X-Frame-Options: DENY');
header('Content-Type: text/html; charset=utf-8');

// Gelen şifre verisini alalım
$password = isset($_POST['password']) ? $_POST['password'] : '';
$hash = isset($_POST['hash']) ? $_POST['hash'] : '';

// Ya şifre ya da hash değeri gereklidir
if (empty($password) && empty($hash)) {
    echo '<div class="pwned-check-result danger">Lütfen bir şifre girin.</div>';
    exit;
}

// Eğer ham şifre gönderildiyse, SHA-1 hashe çevirelim
if (!empty($password)) {
    $hash = strtoupper(sha1($password));
}

// SHA-1 hash formatı kontrolü
if (!preg_match('/^[A-F0-9]{40}$/', $hash)) {
    echo '<div class="pwned-check-result danger">Geçersiz hash formatı.</div>';
    exit;
}

// HaveIBeenPwned API ile k-Anonymity kullanarak check yapalım
// Sadece hash'in ilk 5 karakterini gönderiyoruz (k-Anonymity)
$prefix = substr($hash, 0, 5);
$suffix = substr($hash, 5);

try {
    // API'ye istek gönderelim
    $ch = curl_init("https://api.pwnedpasswords.com/range/" . $prefix);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_USERAGENT, 'Password-Checker-App');
    
    $response = curl_exec($ch);
    $status = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    
    curl_close($ch);
    
    // İstek başarılı mı kontrol edelim
    if ($status !== 200) {
        throw new Exception("API isteği başarısız: HTTP $status");
    }
    
    // Yanıtı işle
    $lines = explode("\r\n", $response);
    $found = false;
    $count = 0;
    
    foreach ($lines as $line) {
        $parts = explode(":", $line);
        if (count($parts) == 2) {
            $hashSuffix = $parts[0];
            if (strcasecmp($hashSuffix, $suffix) === 0) {
                $count = intval($parts[1]);
                $found = true;
                break;
            }
        }
    }
    
    // Sonucu gösterelim
    if ($found) {
        echo '<div class="pwned-check-result danger">';
        echo '<strong>Dikkat!</strong> Bu şifre ' . number_format($count, 0, ',', '.') . ' kez veri ihlallerinde görüldü. ';
        echo 'Güvenliğiniz için bu şifreyi değiştirmenizi öneririz.</div>';
    } else {
        echo '<div class="pwned-check-result safe">';
        echo '<strong>Güvenli!</strong> Bu şifre bilinen veri ihlallerinde görülmedi. ';
        echo 'Ancak güçlü, benzersiz şifreler kullanmayı her zaman tavsiye ederiz.</div>';
    }
    
} catch (Exception $e) {
    // Hata durumunda
    echo '<div class="pwned-check-result danger">Şifre kontrolü sırasında bir hata oluştu: ' . $e->getMessage() . '</div>';
}