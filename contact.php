<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact - CyberAnalyze</title>
    <link rel="stylesheet" href="contact.css">
    <script src="script_main.js"></script>
    <script src="https://cdn.jsdelivr.net/particles.js/2.0.0/particles.min.js"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">

</head>
<body>
    <div id="particles-js"></div>
    
    <?php include 'includes/header.php' ?>
    
    <main class="container">
        <section class="contact-section">
            <h2>Contact Us</h2>
            <p class="tagline">OUR TEAM IS HERE TO SUPPORT YOUR CYBERSECURITY NEEDS </p>
            
            <div class="contact-container">
                <div class="contact-info">
                    <h3>Our Contact Information</h3>
                    <div class="info-item">
                        <i class="icon location-icon"></i>
                        <p>Levent Mah. Teknoloji Cad. No:23<br>İstanbul, Turkey</p>
                    </div>
                    <div class="info-item">
                        <i class="icon phone-icon"></i>
                        <p>+90 212 935 0362</p>
                    </div>
                    <div class="info-item">
                        <i class="icon email-icon"></i>
                        <p>info@cyberanalyze.com</p>
                    </div>
                    
                    <div class="social-media">
                        <h4>Follow Us</h4>
                        <div class="social-icons">
                            <a href="#" class="social-icon"><i class="fab fa-facebook"></i></a>
                            <a href="#" class="social-icon"><i class="fab fa-twitter"></i></a>
                            <a href="#" class="social-icon"><i class="fab fa-linkedin"></i></a>
                            <a href="#" class="social-icon"><i class="fab fa-instagram"></i></a>
                        </div>
                    </div>
                </div>
                
                <div class="contact-form-container">
                    <h3>Send Us a Message</h3>
                    <form id="contact-form" action="process_form.php" method="POST">
                        <div class="form-group">
                            <input type="text" id="name" name="name" placeholder="Your Name" required>
                        </div>
                        <div class="form-group">
                            <input type="email" id="email" name="email" placeholder="Your Email" required>
                        </div>
                        <div class="form-group">
                            <input type="text" id="subject" name="subject" placeholder="Subject" required>
                        </div>
                        <div class="form-group">
                            <textarea id="message" name="message" placeholder="Your Message" rows="5" required></textarea>
                        </div>
                        <div class="form-group">
                            <button type="submit" class="submit-btn">Send</button>
                        </div>
                    </form>
                </div>
            </div>
        </section>
        
        <section class="map-section">
            <h3>Visit Us</h3>
            <div class="map-container">
                <!-- Map section - Google Maps iframe example -->
                <div class="map-placeholder">
                <iframe
              src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3008.5881650280863!2d29.01126211526833!3d41.07808487929205!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x14cab0d9e58a8a45%3A0x962df11df7ed7ef0!2sLevent%2C%20Be%C5%9Fikta%C5%9F%2F%C4%B0stanbul!5e0!3m2!1str!2str!4v1714976188045!5m2!1str!2str"
             width="100%"
             height="100%"
             style="border:0;"
             allowfullscreen=""
              loading="lazy"
             referrerpolicy="no-referrer-when-downgrade">
             </iframe>
                </div>
            </div>
        </section>
        
        <section class="faq-section">
            <h3>Frequently Asked Questions</h3>
            <div class="faq-container">
                <div class="faq-item">
                    <div class="faq-question">What does your cybersecurity consulting service include?</div>
                    <div class="faq-answer">
                        <p>Our cybersecurity consulting services include security vulnerability assessments, penetration testing, security policy development, and risk management.</p>
                    </div>
                </div>
                <div class="faq-item">
                    <div class="faq-question">How quickly do you respond to a cyberattack?</div>
                    <div class="faq-answer">
                        <p>Thanks to our 24/7 monitoring team, we typically respond to cyberattacks within the first 15 minutes. Our emergency response teams are always on standby for critical situations.</p>
                    </div>
                </div>
                <div class="faq-item">
                    <div class="faq-question">Do you have special solutions for small businesses?</div>
                    <div class="faq-answer">
                        <p>Yes, we offer customized solutions for businesses of all sizes. We have cost-effective security packages specifically designed for small businesses.</p>
                    </div>
                </div>
            </div>
        </section>
    </main>
    
    <?php include 'includes/footer.php' ?>
    
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Particles.js configuration
            particlesJS('particles-js', {
                particles: {
                    number: {
                        value: 80,
                        density: {
                            enable: true,
                            value_area: 800
                        }
                    },
                    color: {
                        value: '#663fd2'
                    },
                    shape: {
                        type: 'circle'
                    },
                    opacity: {
                        value: 0.5,
                        random: false
                    },
                    size: {
                        value: 3,
                        random: true
                    },
                    line_linked: {
                        enable: true,
                        distance: 150,
                        color: '#663fd2',
                        opacity: 0.4,
                        width: 1
                    },
                    move: {
                        enable: true,
                        speed: 2,
                        direction: 'none',
                        random: false,
                        straight: false,
                        out_mode: 'out',
                        bounce: false
                    }
                },
                interactivity: {
                    detect_on: 'canvas',
                    events: {
                        onhover: {
                            enable: true,
                            mode: 'grab'
                        },
                        onclick: {
                            enable: true,
                            mode: 'push'
                        },
                        resize: true
                    }
                },
                retina_detect: true
            });
            
            // FAQ functionality
            const faqQuestions = document.querySelectorAll('.faq-question');
            
            faqQuestions.forEach(question => {
                question.addEventListener('click', () => {
                    question.parentElement.classList.toggle('active');
                });
            });
        });
    </script>
</body>
</html>
