/**
 * Güvenli Şifre Oluşturucu ve Güç Analizi JavaScript Kodu
 */


document.addEventListener('DOMContentLoaded', function() {
    // Sekme değiştirme işlevi
    const tabs = document.querySelectorAll('.tab');
    const tabContents = document.querySelectorAll('.tab-content');
    
    tabs.forEach(tab => {
        tab.addEventListener('click', () => {
            const targetId = tab.getAttribute('data-tab');
            
            // Sekmeleri güncelle
            tabs.forEach(t => t.classList.remove('active'));
            tab.classList.add('active');
            
            // İçeriği güncelle
            tabContents.forEach(content => {
                content.classList.add('hidden');
                if (content.id === `${targetId}-tab`) {
                    content.classList.remove('hidden');
                }
            });
        });
    });
    
    // Şifre görünürlüğünü değiştir
    const togglePassword = document.querySelector('.toggle-password');
    const passwordInput = document.getElementById('password');
    
    if(togglePassword && passwordInput) {
        togglePassword.addEventListener('click', function() {
            const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
            passwordInput.setAttribute('type', type);
            
            // İkon değiştir
            this.querySelector('i').textContent = type === 'password' ? '👁️' : '❌';
        });
    }
    
    // Şifre gücü ölçümü
    const passwordField = document.getElementById('password');
    const strengthBar = document.querySelector('.strength-bar');
    const strengthValue = document.getElementById('strength-value');
    const strengthDetails = document.getElementById('strength-details');
    
    if(passwordField) {
        passwordField.addEventListener('input', () => {
            const password = passwordField.value;
            const result = calculatePasswordStrength(password);
            
            // Şifre gücü göstergesini güncelle
            updateStrengthIndicator(result.score);
            
            // Ayrıntıları göster
            displayStrengthDetails(result);
        });
    }
    
    // Oluşturulan şifreleri kopyala
    const copyButton = document.querySelector('.copy-password');
    const generatedPasswordField = document.getElementById('generated-password');
    
    if(copyButton && generatedPasswordField) {
        copyButton.addEventListener('click', () => {
            generatedPasswordField.select();
            document.execCommand('copy');
            
            // Kopyalandı bildirimi
            const originalText = copyButton.textContent;
            copyButton.textContent = '✓';
            setTimeout(() => {
                copyButton.textContent = originalText;
            }, 1500);
        });
    }
    
    // Şifre uzunluğu kaydırıcı
    const lengthSlider = document.getElementById('password-length');
    const lengthValue = document.getElementById('length-value');
    
    if(lengthSlider && lengthValue) {
        lengthSlider.addEventListener('input', () => {
            lengthValue.textContent = lengthSlider.value;
        });
    }
    
    // Şifre oluşturma
    const generateButton = document.getElementById('generate-password');
    
    if(generateButton) {
        generateButton.addEventListener('click', () => {
            const length = parseInt(document.getElementById('password-length').value);
            const includeUppercase = document.getElementById('include-uppercase').checked;
            const includeLowercase = document.getElementById('include-lowercase').checked;
            const includeNumbers = document.getElementById('include-numbers').checked;
            const includeSymbols = document.getElementById('include-symbols').checked;
            
            const password = generatePassword(length, includeUppercase, includeLowercase, includeNumbers, includeSymbols);
            document.getElementById('generated-password').value = password;
            
            // Oluşturulan şifrenin gücünü hemen hesapla
            const result = calculatePasswordStrength(password);
            // Şifre oluşturma sekmesinde de güç göstergesi varsa güncelle
            const genStrengthBar = document.querySelector('#generator-tab .strength-bar');
            const genStrengthValue = document.querySelector('#generator-tab .strength-value');
            
            if(genStrengthBar && genStrengthValue) {
                updateStrengthIndicatorElement(genStrengthBar, genStrengthValue, result.score);
            }
        });
    }
    
    // Oluşturulan şifrenin analizini yap
    const analyzeGenerated = document.getElementById('analyze-generated');
    
    if(analyzeGenerated) {
        analyzeGenerated.addEventListener('click', () => {
            const generatedPassword = document.getElementById('generated-password').value;
            
            if(generatedPassword) {
                // Şifre gücü sekmesine geç
                document.querySelector('[data-tab="strength"]').click();
                
                // Şifreyi analiz alanına yerleştir
                document.getElementById('password').value = generatedPassword;
                
                // Analizi yap (input olayını tetikle)
                const inputEvent = new Event('input', {
                    bubbles: true,
                    cancelable: true,
                });
                document.getElementById('password').dispatchEvent(inputEvent);
                
                // HaveIBeenPwned kontrolü için check_pwned.php'ye hash'i gönder
                checkPwnedPassword(generatedPassword);
            }
        });
    }
    
    // Şifre temizleme
    const clearButton = document.getElementById('clear-password');
    
    if(clearButton) {
        clearButton.addEventListener('click', () => {
            document.getElementById('password').value = '';
            updateStrengthIndicator(0);
            strengthDetails.innerHTML = '';
            document.getElementById('pwned-result').innerHTML = '';
        });
    }
    
    // Şifre formu gönderildiğinde
    const passwordCheckForm = document.getElementById('password-check-form');
    
    if(passwordCheckForm) {
        passwordCheckForm.addEventListener('submit', function(e) {
            e.preventDefault();
            const password = document.getElementById('password').value;
            
            // HaveIBeenPwned kontrolü
            checkPwnedPassword(password);
        });
    }
    
    // Sayfa yüklendiğinde başlangıç şifre gücü göstergelerini sıfırla
    updateStrengthIndicator(0);
});

/**
 * Şifre gücünü hesaplar
 * @param {string} password - Kullanıcının girdiği şifre
 * @return {object} - Şifre gücü sonucu ve ayrıntıları
 */
function calculatePasswordStrength(password) {
    // Şifre boşsa
    if (!password) {
        return { 
            score: 0, 
            feedback: ['Please enter a password'] 
        };
    }
    
    let score = 0;
    const feedback = [];
    
    // Uzunluk kontrolü - çok daha katı bir puanlama sistemi
    // Uzunluk katsayısı: 
    // < 6 karakter: çok zayıf
    // 6-7 karakter: zayıf
    // 8-9 karakter: orta
    // 10-11 karakter: iyi
    // 12+ karakter: en iyi uzunluk
    let lengthScore = 0;
    
  if (password.length < 6) {
    lengthScore = 5;
    feedback.push('Password is too short! It must be at least 8 characters.');
} else if (password.length < 8) {
    lengthScore = 10;
    feedback.push('Password is short. It should be at least 8 characters.');
} else if (password.length < 10) {
    lengthScore = 15;
    feedback.push('Acceptable length. Using 10+ characters is recommended.');
} else if (password.length < 12) {
    lengthScore = 20;
    feedback.push('Good length: 10+ characters.');
} else if (password.length < 16) {
    lengthScore = 25;
    feedback.push('Very good length: 12+ characters.');
} else {
    lengthScore = 30;
    feedback.push('Excellent length: 16+ characters.');
}

    
    // Uzun ama karmaşık olmayan şifreler için maksimum puanı sınırla
    lengthScore = Math.min(lengthScore, 30);
    score += lengthScore;
    
    // Karakter çeşitliliği kontrolleri
    const hasUpperCase = /[A-Z]/.test(password);
    const hasLowerCase = /[a-z]/.test(password);
    const hasNumbers = /[0-9]/.test(password);
    const hasSymbols = /[^A-Za-z0-9]/.test(password);
    
    // Karakter çeşitliliği puanlama - daha az cömert
    let charTypeCount = 0;
    let charTypeScore = 0;
    
    if (hasUpperCase) {
        charTypeScore += 7;
        charTypeCount++;
    }
    if (hasLowerCase) {
        charTypeScore += 7;
        charTypeCount++;
    }
    if (hasNumbers) {
        charTypeScore += 7;
        charTypeCount++;
    }
    if (hasSymbols) {
        charTypeScore += 9;
        charTypeCount++;
    }
    
    // Extra bonus points for diversity
if (charTypeCount === 4) {
    charTypeScore += 10;
    feedback.push('Good diversity: Includes uppercase, lowercase, number, and special character.');
} else if (charTypeCount === 3) {
    charTypeScore += 5;
}

// Very weak if only one type of character is used
if (charTypeCount === 1) {
    charTypeScore = Math.max(charTypeScore - 10, 0);
    feedback.push('Very weak diversity: Only one type of character is used.');
}

    
    score += charTypeScore;
    
   // Feedback messages
if (!hasUpperCase) feedback.push('Add an uppercase letter.');
if (!hasLowerCase) feedback.push('Add a lowercase letter.');
if (!hasNumbers) feedback.push('Add a number.');
if (!hasSymbols) feedback.push('Add a special character (e.g., !@#$%^&*).');

// Character distribution analysis
const charDistribution = analyzeCharacterDistribution(password);
if (charDistribution < 0.7) {
    score -= 10;
    feedback.push('Characters are not well distributed in the password.');
}

// Repeated characters check – more precise
const repeatingPattern = /(.)\1{2,}/;
if (repeatingPattern.test(password)) {
    score -= 15;
    feedback.push('Avoid repeated characters (e.g., "aaa", "111").');
}

// Sequential characters check
if (checkSequentialChars(password)) {
    score -= 20;
    feedback.push('Avoid sequential characters (e.g., abc, 123, qwerty).');
}

    
   // Check for common passwords
if (isCommonPassword(password)) {
    score = Math.max(score - 40, 5); // Reduce score significantly but not to zero
    feedback.push('This is a very common password. Choose something more unique.');
}

// Complexity check – mix of letters and numbers/symbols
const mixedPattern = /(?=.*[a-zA-Z])(?=.*[0-9\W])/;
if (mixedPattern.test(password)) {
    score += 8;
    feedback.push('Good: Contains a mix of letters and numbers/symbols.');
}

// Check for common words
if (containsCommonWord(password)) {
    score -= 15;
    feedback.push('Your password contains simple words, which makes it easier to guess.');
}

// Password entropy (randomness) value
const entropy = calculateEntropy(password);
if (entropy > 80) {
    score += 10;
    feedback.push('High entropy: Your password appears random, which is good.');
} else if (entropy < 40 && password.length > 8) {
    score -= 10;
    feedback.push('Low entropy: Your password is not random enough.');
}

    // Toplam puanı 0-100 arasında tut
    score = Math.max(0, Math.min(100, score));
    
  // Stricter rating system
let strengthCategory = '';
if (score >= 85) {
    strengthCategory = 'Excellent! This password is very strong.';
} else if (score >= 70) {
    strengthCategory = 'Good! This password is strong.';
} else if (score >= 50) {
    strengthCategory = 'Moderate. Follow the tips to make it stronger.';
} else if (score >= 25) {
    strengthCategory = 'Weak password. Follow the tips to improve it.';
} else {
    strengthCategory = 'Very weak password. Not secure!';
}

    
    feedback.push(strengthCategory);
    
    return {
        score: score,
        feedback: feedback
    };
}

/**
 * Karakter dağılımını analiz eder (0-1 arası bir değer döndürür, 1 en iyi)
 * @param {string} password - Şifre
 * @return {number} - Dağılım skoru
 */
function analyzeCharacterDistribution(password) {
    if (password.length < 4) return 0;
    
    // Karakter sınıflarını say
    const charCount = {};
    for (let i = 0; i < password.length; i++) {
        const char = password[i];
        charCount[char] = (charCount[char] || 0) + 1;
    }
    
    // En çok ve en az kullanılan karakterlerin oranını hesapla
    const counts = Object.values(charCount);
    const maxCount = Math.max(...counts);
    const uniqueChars = counts.length;
    
    // Tekil karakter oranı (daha yüksek = daha iyi)
    return uniqueChars / password.length;
}

/**
 * Şifrenin içinde yaygın kelime var mı diye kontrol eder
 * @param {string} password - Şifre
 * @return {boolean} - Yaygın kelime içeriyor mu
 */
function containsCommonWord(password) {
    const commonWords = [
        'password', 'admin', 'welcome', 'login', 'user', 
        'parola', 'sifre', 'giris', 'kullanici', 'test',
        'love', 'secret', 'qwerty', 'letmein', 'money',
        'asdf', 'asdfjkl', 'pass', 'football', 'baseball'
    ];
    
    const lowerPass = password.toLowerCase();
    
    for (let word of commonWords) {
        if (lowerPass.includes(word)) {
            return true;
        }
    }
    
    return false;
}

/**
 * Şifre entropisi (rastgelelik ölçüsü) hesaplar
 * @param {string} password - Şifre
 * @return {number} - Entropi değeri
 */
function calculateEntropy(password) {
    if (!password) return 0;
    
    // Kullanılan farklı karakter setlerini belirle
    const hasUppercase = /[A-Z]/.test(password);
    const hasLowercase = /[a-z]/.test(password);
    const hasDigits = /[0-9]/.test(password);
    const hasSymbols = /[^A-Za-z0-9]/.test(password);
    
    // Potansiyel karakter havuzu boyutunu hesapla
    let poolSize = 0;
    if (hasUppercase) poolSize += 26;
    if (hasLowercase) poolSize += 26;
    if (hasDigits) poolSize += 10;
    if (hasSymbols) poolSize += 33; // Genel sembol sayısı
    
    // Shannon entropi formülü: E = L * log2(R)
    // L: şifre uzunluğu, R: karakter havuzu boyutu
    if (poolSize > 0) {
        return Math.round(password.length * Math.log2(poolSize));
    }
    
    return 0;
}

/**
 * Şifre gücü göstergesini günceller
 * @param {number} score - Şifre gücü puanı (0-100)
 */
function updateStrengthIndicator(score) {
    const strengthBar = document.querySelector('.strength-bar');
    const strengthValue = document.getElementById('strength-value');
    
    if (strengthBar && strengthValue) {
        updateStrengthIndicatorElement(strengthBar, strengthValue, score);
    }
}

/**
 * Belirli bir şifre gücü göstergesini günceller
 * @param {HTMLElement} strengthBar - Güç çubuğu elementi
 * @param {HTMLElement} strengthValue - Güç değeri elementi
 * @param {number} score - Şifre gücü puanı (0-100)
 */
function updateStrengthIndicatorElement(strengthBar, strengthValue, score) {
    // Çubuğu güncelle
    strengthBar.style.width = `${score}%`;
    
   // Update color and text – more precise categories
if (score >= 85) {
    strengthBar.style.backgroundColor = '#28a745'; // Dark Green
    strengthValue.textContent = 'Very Strong';
} else if (score >= 70) {
    strengthBar.style.backgroundColor = '#5cb85c'; // Light Green
    strengthValue.textContent = 'Strong';
} else if (score >= 50) {
    strengthBar.style.backgroundColor = '#ffc107'; // Yellow
    strengthValue.textContent = 'Moderate';
} else if (score >= 25) {
    strengthBar.style.backgroundColor = '#ff9800'; // Orange
    strengthValue.textContent = 'Weak';
} else {
    strengthBar.style.backgroundColor = '#dc3545'; // Red
    strengthValue.textContent = 'Very Weak';
}

}

/**
 * Şifre gücü ayrıntılarını gösterir
 * @param {object} result - Şifre gücü sonucu
 */
function displayStrengthDetails(result) {
    const strengthDetails = document.getElementById('strength-details');
    if (!strengthDetails) return;
    
    strengthDetails.innerHTML = '';
    
    // Önce negatif, sonra pozitif geri bildirimleri gösterme
    const negativeFeedback = [];
    const positiveFeedback = [];
    
    result.feedback.forEach(feedback => {
        if (feedback.includes('Mükemmel') || feedback.includes('İyi') || feedback.includes('güçlü')) {
            positiveFeedback.push(feedback);
        } else {
            negativeFeedback.push(feedback);
        }
    });
    
    // Önce önerileri göster
    negativeFeedback.forEach(feedback => {
        const li = document.createElement('li');
        li.textContent = feedback;
        strengthDetails.appendChild(li);
    });
    
    // Sonra olumlu yorumları göster
    positiveFeedback.forEach(feedback => {
        const li = document.createElement('li');
        li.textContent = feedback;
        li.style.color = '#28a745'; // Pozitif geri bildirimleri yeşil renkte göster
        strengthDetails.appendChild(li);
    });
}

/**
 * Şifre oluşturur
 * @param {number} length - Şifre uzunluğu
 * @param {boolean} uppercase - Büyük harf içersin mi
 * @param {boolean} lowercase - Küçük harf içersin mi
 * @param {boolean} numbers - Rakam içersin mi
 * @param {boolean} symbols - Özel karakter içersin mi
 * @return {string} - Oluşturulan şifre
 */
function generatePassword(length, uppercase, lowercase, numbers, symbols) {
    let chars = '';
    
    // En az bir karakter tipinin seçili olduğundan emin ol
    if (!uppercase && !lowercase && !numbers && !symbols) {
        lowercase = true;
    }
    
    if (uppercase) chars += 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
    if (lowercase) chars += 'abcdefghijklmnopqrstuvwxyz';
    if (numbers) chars += '0123456789';
    if (symbols) chars += '!@#$%^&*()_+[]{}|;:,.<>?';
    
    // Her karakter türünden en az bir tane olduğundan emin olmak için
    let password = '';
    const charTypes = [];
    
    if (uppercase) charTypes.push('ABCDEFGHIJKLMNOPQRSTUVWXYZ');
    if (lowercase) charTypes.push('abcdefghijklmnopqrstuvwxyz');
    if (numbers) charTypes.push('0123456789');
    if (symbols) charTypes.push('!@#$%^&*()_+[]{}|;:,.<>?');
    
    // İlk karakterleri her bir karakter türünden seçerek ekleyelim
    if (length >= charTypes.length) {
        // Her karakter türünden rastgele birer karakter seçelim
        const shuffledTypes = shuffleArray([...charTypes]);
        
        for (let i = 0; i < shuffledTypes.length; i++) {
            const charSet = shuffledTypes[i];
            const randomIndex = Math.floor(Math.random() * charSet.length);
            password += charSet.charAt(randomIndex);
        }
    }
    
    // Kalan karakterleri rastgele ekleyelim
    for (let i = password.length; i < length; i++) {
        const randomIndex = Math.floor(Math.random() * chars.length);
        password += chars.charAt(randomIndex);
    }
    
    // Şifreyi karıştıralım
    return shuffleString(password);
}

/**
 * Bir diziyi karıştırmak için yardımcı fonksiyon
 * @param {Array} array - Karıştırılacak dizi
 * @return {Array} - Karıştırılmış dizi
 */
function shuffleArray(array) {
    for (let i = array.length - 1; i > 0; i--) {
        const j = Math.floor(Math.random() * (i + 1));
        [array[i], array[j]] = [array[j], array[i]];
    }
    return array;
}

/**
 * Bir stringi karıştırmak için yardımcı fonksiyon
 * @param {string} str - Karıştırılacak string
 * @return {string} - Karıştırılmış string
 */
function shuffleString(str) {
    const array = str.split('');
    const shuffled = shuffleArray(array);
    return shuffled.join('');
}

/**
 * Sıralı karakterleri kontrol eder
 * @param {string} password - Kontrol edilecek şifre
 * @return {boolean} - Sıralı karakter içeriyor mu
 */
function checkSequentialChars(password) {
    const sequences = [
        'abcdefghijklmnopqrstuvwxyz',
        'ABCDEFGHIJKLMNOPQRSTUVWXYZ',
        '0123456789',
        'qwertyuiop',
        'asdfghjkl',
        'zxcvbnm'
    ];
    
    const lowerPassword = password.toLowerCase();
    
    for (let seq of sequences) {
        for (let i = 0; i < seq.length - 2; i++) {
            const fragment = seq.substring(i, i + 3);
            if (lowerPassword.includes(fragment)) {
                return true;
            }
            
            // Ters sıralı kontrolü (cba, 321 gibi)
            const reverseFragment = fragment.split('').reverse().join('');
            if (lowerPassword.includes(reverseFragment)) {
                return true;
            }
        }
    }
    
    return false;
}

/**
 * Yaygın şifreleri kontrol eder
 * @param {string} password - Kontrol edilecek şifre
 * @return {boolean} - Yaygın bir şifre mi
 */
function isCommonPassword(password) {
    // Çok bilinen yaygın şifrelerin listesi (gerçekte daha kapsamlı olmalı)
    const commonPasswords = [
        'password', '123456', 'qwerty', 'admin', 'welcome',
        '1234', '12345', 'abc123', 'letmein', 'monkey',
        'password1', '123456789', '1234567', 'football', 'iloveyou',
        'welcome1', 'login', 'admin123', 'qwerty123', 'passw0rd',
        'parola', 'sifre', 'şifre', 'türkiye', 'turkiye',
        '123abc', '123qwe', 'q1w2e3', '1q2w3e', 'dragon',
        'sunshine', 'princess', '654321', 'superman', 'qazwsx',
        'michael', 'football', 'baseball', 'master', 'jennifer',
        'jordan', 'liverpool', 'batman', '1234qwer'
    ];
    
    return commonPasswords.includes(password.toLowerCase());
}

/**
 * HaveIBeenPwned API ile şifre kontrolü
 * @param {string} password - Kontrol edilecek şifre
 */
function checkPwnedPassword(password) {
    if (!password) return;
    
    // Form verilerini hazırla
    const form = document.getElementById('pwned-check-form');
    const hashInput = document.getElementById('pwned-hash');
    
    if (!form || !hashInput) {
        console.error('Pwned check form veya hash input bulunamadı');
        return;
    }
    
    // Şifreyi form aracılığıyla gönder
    hashInput.value = password;
    form.submit();
}