/**
 * HaveIBeenPwned API entegrasyonu
 */

// API sabitleri
const PWNED_API_URL = 'https://api.pwnedpasswords.com/range/';

/**
 * Şifre için SHA-1 hash oluşturur
 * @param {string} password - Hash'lenecek şifre
 * @return {Promise<string>} - SHA-1 hash
 */
async function sha1Hash(password) {
    const encoder = new TextEncoder();
    const data = encoder.encode(password);
    const hashBuffer = await crypto.subtle.digest('SHA-1', data);
    
    // Hash'i hex string'e dönüştür
    const hashArray = Array.from(new Uint8Array(hashBuffer));
    const hashHex = hashArray.map(b => b.toString(16).padStart(2, '0')).join('');
    return hashHex.toUpperCase();
}

/**
 * Şifrenin güvenli bir şekilde k-anonymity yöntemiyle HIBP servisinde kontrol edilmesi
 * @param {string} password - Kontrol edilecek şifre
 * @return {Promise<Object>} - Sonuç objesi {found: boolean, count: number}
 */
async function checkHIBP(password) {
    try {
        // Şifreyi SHA-1 ile hash'le
        const hash = await sha1Hash(password);
        
        // k-anonymity için ilk 5 karakteri al
        const prefix = hash.substring(0, 5);
        const suffix = hash.substring(5);
        
        // API'yi çağır
        const response = await fetch(`${PWNED_API_URL}${prefix}`);
        if (!response.ok) {
            throw new Error(`API hatası: ${response.status}`);
        }
        
        const data = await response.text();
        
        // Sonuçları analiz et
        const lines = data.split('\r\n');
        for (const line of lines) {
            const [hashSuffix, count] = line.split(':');
            if (hashSuffix.toUpperCase() === suffix) {
                return { found: true, count: parseInt(count) };
            }
        }
        
        return { found: false, count: 0 };
    } catch (error) {
        console.error('HIBP kontrolü sırasında hata:', error);
        return { error: true, message: error.message };
    }
}

/**
 * HaveIBeenPwned kontrolünü yapar ve sonucu gösterir
 * @param {string} password - Kontrol edilecek şifre
 */
async function checkPwnedPassword(password) {
    if (!password) return;
    
    // Sonuç alanını temizle ve yükleniyor göster
    const resultContainer = document.getElementById('pwned-result');
    if (resultContainer) {
        resultContainer.innerHTML = '<div class="loading">Veri ihlali kontrolü yapılıyor...</div>';
    }
    
    try {
        const result = await checkHIBP(password);
        
        if (result.error) {
            resultContainer.innerHTML = `
                <div class="pwned-error">
                    <h4>Kontrol sırasında bir hata oluştu</h4>
                    <p>${result.message}</p>
                </div>
            `;
            return;
        }
        
        if (result.found) {
            resultContainer.innerHTML = `
                <div class="pwned-found">
                    <h4>Password is at risk!</h4>
                    <p>This password was found in ${result.count.toLocaleString('en-US')} data breaches.</p>
                    <p>It is <strong>not recommended</strong> to use this password. Please choose another one.</p>
                </div>
            `;
        } else {
            resultContainer.innerHTML = `
                <div class="pwned-safe">
                    <h4>Good News!!</h4>
                    <p>This password was not found in known data breaches.</p>
                    <p>However, you should still consider other security criteria.</p>
                </div>
            `;
        }
    } catch (e) {
        resultContainer.innerHTML = `
            <div class="pwned-error">
                <h4>An error occurred during the check</h4>
                <p>${e.message}</p>
            </div>
        `;
    }
}

// Global kapsamda kullanılabilir yap
window.checkPwnedPassword = checkPwnedPassword;