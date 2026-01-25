<?php
// contact.php
require_once 'config/db.php';
require_once 'includes/functions.php';

$pageTitle = 'Contact Us';
$msg = '';
$msgType = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (!isset($_POST['csrf_token']) || !verifyCsrfToken($_POST['csrf_token'])) {
        die("Invalid CSRF Token. Please refresh the page and try again.");
    }

    $name = cleanInput($_POST['name']);
    $email = cleanInput($_POST['email']);
    $subject = cleanInput($_POST['subject']);
    $message = cleanInput($_POST['message']);

    try {
        $stmt = $pdo->prepare("INSERT INTO contact_messages (name, email, subject, message) VALUES (?, ?, ?, ?)");
        $stmt->execute([$name, $email, $subject, $message]);
        
        // Send Email to Company
        $to = 'info.ddsolutionscdl@gmail.com'; // Company Email
        $mailSubject = "New Contact Message: " . $subject;
        $mailBody = "
        <html>
        <head>
          <title>New Contact Message</title>
        </head>
        <body>
          <h2>New Message from Contact Form</h2>
          <p><strong>Name:</strong> " . htmlspecialchars($name) . "</p>
          <p><strong>Email:</strong> " . htmlspecialchars($email) . "</p>
          <p><strong>Subject:</strong> " . htmlspecialchars($subject) . "</p>
          <p><strong>Message:</strong><br>" . nl2br(htmlspecialchars($message)) . "</p>
        </body>
        </html>
        ";

        $headers = "MIME-Version: 1.0" . "\r\n";
        $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
        $headers .= "From: DD Solutions <no-reply@ddsolutions.in>" . "\r\n";
        $headers .= "Reply-To: " . $email . "\r\n";

        @mail($to, $mailSubject, $mailBody, $headers);

        $msg = "Thank you! Your message has been sent successfully.";
        $msgType = "success";
    } catch (PDOException $e) {
        $msg = "Error sending message. Please try again.";
        $msgType = "error";
    }
}

include 'includes/header.php';
?>



<div class="hero contact-hero static-bg" style="height: 100vh; background: url('assets/images/contact-cover.jpg') no-repeat center center/cover fixed; position: relative; display: flex; align-items: center; margin-bottom: 50px;">
    <div style="position: absolute; inset: 0; background: linear-gradient(to right, rgba(0,0,0,0.8), rgba(0,0,0,0.4));"></div>
    <div class="container" style="position: relative; z-index: 2; color: white;">
        <h1 style="font-size: 3.5rem; font-weight: 700; margin-bottom: 15px;">Contact Us</h1>
        <p style="font-size: 1.2rem; opacity: 0.9; max-width: 600px; margin-bottom: 20px;">We're here to help. Reach out to us for any queries or support.</p>
        <p style="font-size: 1.1rem; opacity: 0.85; max-width: 700px; line-height: 1.6;">Connect with our expert team for personalized office automation solutions. Whether you need technical support, product inquiries, or a custom quote, we are ready to assist you with speed and precision. Experience our commitment to excellence firsthand.</p>
    </div>
</div>

<div class="container section-padding" style="max-width: 1200px;">
    <div style="text-align: center; margin-bottom: 50px;">
        <h2 style="font-size: 2.5rem; color: #1a1a2e; margin-bottom: 15px; font-weight: 800;">Get In Touch</h2>
        <p style="color: #666; font-size: 1.1rem; max-width: 600px; margin: 0 auto;">We are here to help you with all your printing and construction solution needs.</p>
    </div>

    <div style="display: grid; grid-template-columns: 1fr 1.5fr; gap: 40px; margin-bottom: 50px;">
        
        <!-- Left: Contact Info Cards -->
        <div data-aos="fade-right">
            <!-- Address Card -->
            <div style="background: white; border-radius: 16px; padding: 25px; margin-bottom: 20px; box-shadow: 0 4px 20px rgba(0,0,0,0.08); border-left: 4px solid #667eea;">
                <div style="display: flex; gap: 15px; align-items: start;">
                    <div style="width: 50px; height: 50px; background: linear-gradient(135deg, #667eea, #764ba2); border-radius: 12px; display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
                        <i class="fas fa-map-marker-alt" style="color: white; font-size: 1.3rem;"></i>
                    </div>
                    <div>
                        <h4 style="color: #1a1a2e; font-size: 1.1rem; margin-bottom: 8px; font-weight: 600;">Address</h4>
                        <p style="color: #666; font-size: 0.95rem; line-height: 1.6; margin: 0;">No 14B, 3rd Cross, Pondicherry – Cuddalore Road, near IDBI Bank, Manjakuppam, Cuddalore, Tamil Nadu 607001.</p>
                    </div>
                </div>
            </div>

            <!-- Phone Card -->
            <div style="background: white; border-radius: 16px; padding: 25px; margin-bottom: 20px; box-shadow: 0 4px 20px rgba(0,0,0,0.08); border-left: 4px solid #667eea;">
                <div style="display: flex; gap: 15px; align-items: start;">
                    <div style="width: 50px; height: 50px; background: linear-gradient(135deg, #667eea, #764ba2); border-radius: 12px; display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
                        <i class="fas fa-phone-alt" style="color: white; font-size: 1.3rem;"></i>
                    </div>
                    <div>
                        <h4 style="color: #1a1a2e; font-size: 1.1rem; margin-bottom: 8px; font-weight: 600;">Phone</h4>
                        <a href="tel:+919025142474" style="color: #667eea; font-size: 1.05rem; text-decoration: none; font-weight: 500;">+91 9025142474</a>
                    </div>
                </div>
            </div>

            <!-- Email Card -->
            <div style="background: white; border-radius: 16px; padding: 25px; margin-bottom: 20px; box-shadow: 0 4px 20px rgba(0,0,0,0.08); border-left: 4px solid #667eea;">
                <div style="display: flex; gap: 15px; align-items: start;">
                    <div style="width: 50px; height: 50px; background: linear-gradient(135deg, #667eea, #764ba2); border-radius: 12px; display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
                        <i class="fas fa-envelope" style="color: white; font-size: 1.3rem;"></i>
                    </div>
                    <div>
                        <h4 style="color: #1a1a2e; font-size: 1.1rem; margin-bottom: 8px; font-weight: 600;">Email</h4>
                        <a href="mailto:info.ddsolutionscdl@gmail.com" style="color: #667eea; font-size: 1.05rem; text-decoration: none; font-weight: 500;">info.ddsolutionscdl@gmail.com</a>
                    </div>
                </div>
            </div>

            <!-- Social Media Card -->
            <div style="background: white; border-radius: 16px; padding: 25px; margin-bottom: 20px; box-shadow: 0 4px 20px rgba(0,0,0,0.08); border-left: 4px solid #667eea;">
                <h4 style="color: #1a1a2e; font-size: 1.1rem; margin-bottom: 15px; font-weight: 600;">Follow Us</h4>
                <div style="display: flex; gap: 12px;">
                    <a href="https://www.facebook.com/DDSOLUTIONS.CUD/" target="_blank" style="width: 45px; height: 45px; background: linear-gradient(135deg, #667eea, #764ba2); border-radius: 10px; display: flex; align-items: center; justify-content: center; transition: all 0.3s;" onmouseover="this.style.transform='translateY(-3px)'; this.style.boxShadow='0 6px 20px rgba(102, 126, 234, 0.4)'" onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='none'">
                        <i class="fab fa-facebook-f" style="color: white; font-size: 1.2rem;"></i>
                    </a>
                    <a href="https://www.instagram.com/ddsolutionscuddalore/#" target="_blank" style="width: 45px; height: 45px; background: linear-gradient(135deg, #667eea, #764ba2); border-radius: 10px; display: flex; align-items: center; justify-content: center; transition: all 0.3s;" onmouseover="this.style.transform='translateY(-3px)'; this.style.boxShadow='0 6px 20px rgba(102, 126, 234, 0.4)'" onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='none'">
                        <i class="fab fa-instagram" style="color: white; font-size: 1.2rem;"></i>
                    </a>
                    <a href="https://youtube.com/@ddsolutions4868?si=tOXthYav1X4P6K7X" target="_blank" style="width: 45px; height: 45px; background: linear-gradient(135deg, #667eea, #764ba2); border-radius: 10px; display: flex; align-items: center; justify-content: center; transition: all 0.3s;" onmouseover="this.style.transform='translateY(-3px)'; this.style.boxShadow='0 6px 20px rgba(102, 126, 234, 0.4)'" onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='none'">
                        <i class="fab fa-youtube" style="color: white; font-size: 1.2rem;"></i>
                    </a>
                </div>
            </div>

            <!-- Service Response Guarantee -->
            <div style="background: linear-gradient(135deg, #f59e0b, #f97316); border-radius: 16px; padding: 30px; box-shadow: 0 8px 30px rgba(245, 158, 11, 0.3); text-align: center;" data-aos="pulse">
                <div style="font-size: 3rem; color: white; margin-bottom: 15px;">
                    <i class="fas fa-clock"></i>
                </div>
                <h4 style="color: white; font-size: 1.3rem; margin-bottom: 10px; font-weight: 700;">1-Hour Service Response</h4>
                <p style="color: rgba(255,255,255,0.95); font-size: 0.95rem; margin: 0;">We guarantee a response to your service queries within 60 minutes!</p>
            </div>

            <!-- Google Map moved to bottom -->
        </div>
        
        <div data-aos="fade-left">
            <div style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); padding: 3px; border-radius: 20px; box-shadow: 0 20px 60px rgba(102, 126, 234, 0.4);">
                <div style="background: white; padding: 40px; border-radius: 18px;">
                    <h3 style="font-size: 2rem; color: #1a1a2e; margin-bottom: 10px; font-weight: 700;">Send us a Message</h3>
                    <p style="color: #666; margin-bottom: 30px;">We'd love to hear from you. Fill out the form below and we'll get back to you shortly.</p>
                    
                    <?php if ($msg): ?>
                        <div style="background: linear-gradient(135deg, #4ade80, #22c55e); color: white; padding: 15px 20px; border-radius: 12px; margin-bottom: 25px; display: flex; align-items: center; gap: 10px;">
                            <i class="fas fa-check-circle" style="font-size: 1.3rem;"></i>
                            <span><?php echo $msg; ?></span>
                        </div>
                    <?php endif; ?>
                    
                    <form method="POST">
                        <?php echo csrfInput(); ?>
                        <div style="margin-bottom: 25px; position: relative;">
                            <label style="display: block; color: #1a1a2e; font-weight: 600; margin-bottom: 8px; font-size: 0.95rem;">
                                <i class="fas fa-user" style="margin-right: 8px; color: #667eea;"></i>Your Name
                            </label>
                            <input type="text" name="name" required style="width: 100%; padding: 14px 18px; border: 2px solid #e5e7eb; border-radius: 12px; font-size: 1rem; transition: all 0.3s; outline: none;" 
                                   onfocus="this.style.borderColor='#667eea'; this.style.boxShadow='0 0 0 3px rgba(102, 126, 234, 0.1)'" 
                                   onblur="this.style.borderColor='#e5e7eb'; this.style.boxShadow='none'">
                        </div>
                        
                        <div style="margin-bottom: 25px; position: relative;">
                            <label style="display: block; color: #1a1a2e; font-weight: 600; margin-bottom: 8px; font-size: 0.95rem;">
                                <i class="fas fa-envelope" style="margin-right: 8px; color: #667eea;"></i>Email Address
                            </label>
                            <input type="email" name="email" required style="width: 100%; padding: 14px 18px; border: 2px solid #e5e7eb; border-radius: 12px; font-size: 1rem; transition: all 0.3s; outline: none;" 
                                   onfocus="this.style.borderColor='#667eea'; this.style.boxShadow='0 0 0 3px rgba(102, 126, 234, 0.1)'" 
                                   onblur="this.style.borderColor='#e5e7eb'; this.style.boxShadow='none'">
                        </div>
                        
                        <div style="margin-bottom: 25px; position: relative;">
                            <label style="display: block; color: #1a1a2e; font-weight: 600; margin-bottom: 8px; font-size: 0.95rem;">
                                <i class="fas fa-tag" style="margin-right: 8px; color: #667eea;"></i>Subject
                            </label>
                            <input type="text" name="subject" required style="width: 100%; padding: 14px 18px; border: 2px solid #e5e7eb; border-radius: 12px; font-size: 1rem; transition: all 0.3s; outline: none;" 
                                   onfocus="this.style.borderColor='#667eea'; this.style.boxShadow='0 0 0 3px rgba(102, 126, 234, 0.1)'" 
                                   onblur="this.style.borderColor='#e5e7eb'; this.style.boxShadow='none'">
                        </div>
                        
                        <div style="margin-bottom: 25px; position: relative;">
                            <label style="display: block; color: #1a1a2e; font-weight: 600; margin-bottom: 8px; font-size: 0.95rem;">
                                <i class="fas fa-comment-dots" style="margin-right: 8px; color: #667eea;"></i>Message
                            </label>
                            <textarea name="message" rows="5" required style="width: 100%; padding: 14px 18px; border: 2px solid #e5e7eb; border-radius: 12px; font-size: 1rem; transition: all 0.3s; outline: none; resize: vertical; font-family: inherit;" 
                                      onfocus="this.style.borderColor='#667eea'; this.style.boxShadow='0 0 0 3px rgba(102, 126, 234, 0.1)'" 
                                      onblur="this.style.borderColor='#e5e7eb'; this.style.boxShadow='none'"></textarea>
                        </div>
                        
                        <button type="submit" style="width: 100%; padding: 16px; background: linear-gradient(135deg, #667eea, #764ba2); color: white; border: none; border-radius: 12px; font-size: 1.1rem; font-weight: 600; cursor: pointer; transition: all 0.3s; box-shadow: 0 4px 15px rgba(102, 126, 234, 0.4);"
                                onmouseover="this.style.transform='translateY(-2px)'; this.style.boxShadow='0 6px 20px rgba(102, 126, 234, 0.5)'"
                                onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 4px 15px rgba(102, 126, 234, 0.4)'">
                            <i class="fas fa-paper-plane" style="margin-right: 10px;"></i>Send Message
                        </button>
                    </form>
                </div>
            </div>
        </div>

    </div>

    <!-- Centered Google Map Section -->
    <div style="margin-top: 50px; border-radius: 20px; overflow: hidden; box-shadow: 0 10px 40px rgba(0,0,0,0.15); max-width: 900px; margin-left: auto; margin-right: auto;" data-aos="fade-up">
        <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3905.9719951488073!2d79.7630707!3d11.7670228!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3a54991ab79d4b9f%3A0x18f8a1afe9435069!2sDD%20SOLUTIONS%20-%20Copier%20-%20Xerox%20Machines%20-%20Printers%20-%20Sales%20Service%20Rental%20%26%20Spares!5e0!3m2!1sen!2sin!4v1766649423819!5m2!1sen!2sin" width="100%" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
    </div>
</div>

<?php include 'includes/footer.php'; ?>
