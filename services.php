<?php
// services.php
$pageTitle = 'Our Services';
include 'includes/header.php';
?>

<div class="container section-padding" style="max-width: 1200px;">
    <div class="text-center" style="margin-bottom: 60px;">
        <h1 style="font-size: 2.8rem; color: #1a1a2e; margin-bottom: 15px; font-weight: 800;">Our Services</h1>
        <p style="color: #666; font-size: 1.15rem;">Comprehensive solutions for your business needs</p>
    </div>
    
    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(350px, 1fr)); gap: 30px;">
        <!-- Automation Services -->
        <div style="background: linear-gradient(rgba(0,0,0,0.7), rgba(0,0,0,0.7)), url('assets/images/service-repair.jpg') no-repeat center center/cover; border-radius: 20px; padding: 35px; box-shadow: 0 8px 30px rgba(0,0,0,0.08); border-top: 4px solid #667eea; transition: all 0.3s;" data-aos="fade-up" onmouseover="this.style.transform='translateY(-8px)'; this.style.boxShadow='0 12px 40px rgba(102, 126, 234, 0.15)'" onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 8px 30px rgba(0,0,0,0.08)'">
            <div style="width: 70px; height: 70px; background: rgba(255,255,255,0.1); backdrop-filter: blur(5px); border-radius: 16px; display: flex; align-items: center; justify-content: center; margin-bottom: 20px;">
                <i class="fas fa-print" style="color: white; font-size: 2rem;"></i>
            </div>
            <h3 style="font-size: 1.5rem; color: white; margin-bottom: 15px; font-weight: 700;">Printer & Copier Repair</h3>
            <p style="color: rgba(255,255,255,0.9); line-height: 1.7; margin-bottom: 20px;">On-site and carry-in service for all brand printers. We handle paper jams, error codes, and network issues.</p>
            <ul style="list-style: none; padding: 0;">
                <li style="padding: 8px 0; color: rgba(255,255,255,0.9);"><i class="fas fa-check-circle" style="color: #667eea; margin-right: 10px;"></i>Fault diagnosis</li>
                <li style="padding: 8px 0; color: rgba(255,255,255,0.9);"><i class="fas fa-check-circle" style="color: #667eea; margin-right: 10px;"></i>Part replacement</li>
                <li style="padding: 8px 0; color: rgba(255,255,255,0.9);"><i class="fas fa-check-circle" style="color: #667eea; margin-right: 10px;"></i>Quality testing</li>
            </ul>
        </div>
        
        <div style="background: linear-gradient(rgba(0,0,0,0.7), rgba(0,0,0,0.7)), url('assets/images/service-amc.jpg') no-repeat center center/cover; border-radius: 20px; padding: 35px; box-shadow: 0 8px 30px rgba(0,0,0,0.08); border-top: 4px solid #667eea; transition: all 0.3s;" data-aos="fade-up" data-aos-delay="100" onmouseover="this.style.transform='translateY(-8px)'; this.style.boxShadow='0 12px 40px rgba(102, 126, 234, 0.15)'" onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 8px 30px rgba(0,0,0,0.08)'">
            <div style="width: 70px; height: 70px; background: rgba(255,255,255,0.1); backdrop-filter: blur(5px); border-radius: 16px; display: flex; align-items: center; justify-content: center; margin-bottom: 20px;">
                <i class="fas fa-calendar-check" style="color: white; font-size: 2rem;"></i>
            </div>
            <h3 style="font-size: 1.5rem; color: white; margin-bottom: 15px; font-weight: 700;">Annual Maintenance (AMC)</h3>
            <p style="color: rgba(255,255,255,0.9); line-height: 1.7;">Scheduled preventive service for offices and schools. Includes priority support and discounted spares.</p>
        </div>

        <div style="background: linear-gradient(rgba(0,0,0,0.7), rgba(0,0,0,0.7)), url('assets/images/service-Machine Rental.jpg') no-repeat center center/cover; border-radius: 20px; padding: 35px; box-shadow: 0 8px 30px rgba(0,0,0,0.08); border-top: 4px solid #667eea; transition: all 0.3s;" data-aos="fade-up" data-aos-delay="200" onmouseover="this.style.transform='translateY(-8px)'; this.style.boxShadow='0 12px 40px rgba(102, 126, 234, 0.15)'" onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 8px 30px rgba(0,0,0,0.08)'">
            <div style="width: 70px; height: 70px; background: rgba(255,255,255,0.1); backdrop-filter: blur(5px); border-radius: 16px; display: flex; align-items: center; justify-content: center; margin-bottom: 20px;">
                <i class="fas fa-truck-loading" style="color: white; font-size: 2rem;"></i>
            </div>
            <h3 style="font-size: 1.5rem; color: white; margin-bottom: 15px; font-weight: 700;">Machine Rental</h3>
            <p style="color: rgba(255,255,255,0.9); line-height: 1.7;">Short-term and long-term rental of Xerox/RC machines for events and exams.</p>
        </div>

        <!-- Construction Services -->
        <div style="background: white; border-radius: 20px; padding: 35px; box-shadow: 0 8px 30px rgba(0,0,0,0.08); border-top: 4px solid #f59e0b; transition: all 0.3s;" data-aos="fade-up" data-aos-delay="300" onmouseover="this.style.transform='translateY(-8px)'; this.style.boxShadow='0 12px 40px rgba(245, 158, 11, 0.15)'" onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 8px 30px rgba(0,0,0,0.08)'">
            <div style="width: 70px; height: 70px; background: linear-gradient(135deg, #f59e0b, #f97316); border-radius: 16px; display: flex; align-items: center; justify-content: center; margin-bottom: 20px;">
                <i class="fas fa-layer-group" style="color: white; font-size: 2rem;"></i>
            </div>
            <h3 style="font-size: 1.5rem; color: #1a1a2e; margin-bottom: 15px; font-weight: 700;">Total Concrete Flooring</h3>
            <p style="color: #666; line-height: 1.7;">Design, materials, and installation of industrial and commercial concrete floors.</p>
        </div>
        
        <div style="background: white; border-radius: 20px; padding: 35px; box-shadow: 0 8px 30px rgba(0,0,0,0.08); border-top: 4px solid #f59e0b; transition: all 0.3s;" data-aos="fade-up" data-aos-delay="400" onmouseover="this.style.transform='translateY(-8px)'; this.style.boxShadow='0 12px 40px rgba(245, 158, 11, 0.15)'" onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 8px 30px rgba(0,0,0,0.08)'">
            <div style="width: 70px; height: 70px; background: linear-gradient(135deg, #f59e0b, #f97316); border-radius: 16px; display: flex; align-items: center; justify-content: center; margin-bottom: 20px;">
                <i class="fas fa-broadcast-tower" style="color: white; font-size: 2rem;"></i>
            </div>
            <h3 style="font-size: 1.5rem; color: #1a1a2e; margin-bottom: 15px; font-weight: 700;">Structural Health Monitoring</h3>
            <p style="color: #666; line-height: 1.7;">Sensor technology for monitoring performance of structures.</p>
        </div>
        
         <div style="background: white; border-radius: 20px; padding: 35px; box-shadow: 0 8px 30px rgba(0,0,0,0.08); border-top: 4px solid #f59e0b; transition: all 0.3s;" data-aos="fade-up" data-aos-delay="500" onmouseover="this.style.transform='translateY(-8px)'; this.style.boxShadow='0 12px 40px rgba(245, 158, 11, 0.15)'" onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 8px 30px rgba(0,0,0,0.08)'">
            <div style="width: 70px; height: 70px; background: linear-gradient(135deg, #f59e0b, #f97316); border-radius: 16px; display: flex; align-items: center; justify-content: center; margin-bottom: 20px;">
                <i class="fas fa-fire-extinguisher" style="color: white; font-size: 2rem;"></i>
            </div>
            <h3 style="font-size: 1.5rem; color: #1a1a2e; margin-bottom: 15px; font-weight: 700;">Fire Fighting Solutions</h3>
            <p style="color: #666; line-height: 1.7;">Design and installation of fire protection systems.</p>
        </div>
    </div>
    
    <div style="text-align: center; margin-top: 70px; padding: 50px; background: rgba(0, 0, 0, 0.5); backdrop-filter: blur(5px); border: 1px solid rgba(255, 255, 255, 0.3); border-radius: 20px; color: white;" data-aos="fade-up">
        <h3 style="font-size: 2rem; margin-bottom: 15px; color: white; font-weight: 700;">Need a Service?</h3>
        <p style="margin: 20px 0; font-size: 1.1rem; opacity: 0.95;">Contact us today to schedule a visit or request a quote.</p>
        <a href="contact.php" class="btn" style="background: white; color: #1a1a2e; padding: 15px 40px; font-size: 1.1rem; font-weight: 600;">Contact Us</a>
    </div>
</div>

<?php include 'includes/footer.php'; ?>
