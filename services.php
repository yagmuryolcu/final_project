<?php
// Secure Password Generator and Strength Analysis Page
// This page allows users to generate secure passwords and analyze the strength of existing ones

session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Secure Password Generator and Checker</title>
    <link rel="stylesheet" href="services.css">
    <link rel="stylesheet" href="pwned_styles.css">
    
    <script src="password.js"></script>
    <script src="pwned_integration.js"></script>
</head>
<body>
    <div class="container">
        <h1>Secure Password Manager</h1>
        
        <!-- Tab Menu -->
        <div class="tabs">
            <button class="tab active" data-tab="generator">Password Generator</button>
            <button class="tab" data-tab="strength">Password Strength Checker</button>
            <button class="tab" data-tab="tips">Security Tips</button>
        </div>
        
        <!-- Password Generator Tab -->
        <div class="tab-content" id="generator-tab">
            <h2>Generate a Secure Password</h2>
            
            <div class="form-group">
                <label for="password-length">Password Length: <span id="length-value">12</span></label>
                <input type="range" id="password-length" min="6" max="32" value="12">
            </div>
            
            <div class="checkbox-group">
                <div class="form-check">
                    <input type="checkbox" id="include-lowercase" checked>
                    <label for="include-lowercase">Lowercase Letters (a-z)</label>
                </div>
                <div class="form-check">
                    <input type="checkbox" id="include-uppercase" checked>
                    <label for="include-uppercase">Uppercase Letters (A-Z)</label>
                </div>
                <div class="form-check">
                    <input type="checkbox" id="include-numbers" checked>
                    <label for="include-numbers">Numbers (0-9)</label>
                </div>
                <div class="form-check">
                    <input type="checkbox" id="include-symbols" checked>
                    <label for="include-symbols">Special Characters (!@#$...)</label>
                </div>
            </div>
            
            <div class="form-group">
                <label for="generated-password">Generated Password</label>
                <div class="password-input">
                    <input type="text" id="generated-password" readonly>
                    <button class="copy-password">📋</button>
                </div>
            </div>
            
            <!-- Strength Indicator -->
            <div class="strength-text">Password Strength: <span class="strength-value">-</span></div>
            <div class="strength-meter">
                <div class="strength-bar"></div>
            </div>
            
            <div class="form-actions">
                <button id="generate-password" class="btn primary">Generate Password</button>
                <button id="analyze-generated" class="btn">Analyze Strength</button>
            </div>
        </div>
        
        <!-- Password Strength Checker Tab -->
        <div class="tab-content hidden" id="strength-tab">
            <h2>Password Strength Checker</h2>
            
            <form id="password-check-form">
                <div class="form-group">
                    <label for="password">Enter Your Password</label>
                    <div class="password-input">
                        <input type="password" id="password" placeholder="Enter password to analyze">
                        <button type="button" class="toggle-password"><i>👁️</i></button>
                    </div>
                </div>
                
                <div class="strength-text">Password Strength: <span id="strength-value">Very Weak</span></div>
                <div class="strength-meter">
                    <div class="strength-bar"></div>
                </div>
                
                <div class="analysis-results">
                    <h3>Analysis Details</h3>
                    <ul id="strength-details"></ul>
                </div>
                
                <div id="pwned-result"></div>
                
                <div class="form-actions">
                    <button type="submit" class="btn primary">Check Data Breach</button>
                    <button type="button" id="clear-password" class="btn">Clear</button>
                </div>
            </form>
            
            <!-- Hidden form for HaveIBeenPwned -->
            <form id="pwned-check-form" action="check_pwned.php" method="post" target="pwned-results-frame" style="display:none">
                <input type="hidden" id="pwned-hash" name="password">
            </form>
            <iframe name="pwned-results-frame" style="display:none"></iframe>
        </div>
        
        <!-- Security Tips Tab -->
        <div class="tab-content hidden" id="tips-tab">
            <h2>Password Security Tips</h2>
            
            <div class="tips-section">
                <h3>How to Create a Strong Password?</h3>
                <ul>
                    <li>Use passwords that are at least 12 characters long. Longer passwords are harder to crack.</li>
                    <li>Include a mix of uppercase letters, lowercase letters, numbers, and special characters (e.g., !@#$%^&*).</li>
                    <li>Avoid using easily guessed information (birth dates, names, common words).</li>
                    <li>Use unique passwords for every account. Reusing passwords puts all your accounts at risk if one gets compromised.</li>
                    <li>Change your passwords regularly, especially after a data breach.</li>
                </ul>
                
                <h3>Best Practices for Password Security</h3>
                <ul>
                    <li>Enable two-factor authentication (2FA) wherever possible. This adds an extra layer of security.</li>
                    <li>Use a password manager to securely store your passwords. Managing complex and unique passwords becomes easier.</li>
                    <li>Use random answers for password recovery questions (avoid real or guessable info).</li>
                    <li>Keep your devices protected with up-to-date antivirus software. Malware can steal your passwords using keyloggers.</li>
                    <li>Be cautious of phishing emails and fake websites. These are common attack methods.</li>
                </ul>
            </div>
        </div>
    </div>
      
    
    <script src="password_script.js"></script>

    
</body>
</html>
