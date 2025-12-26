<?php
// about.php
$pageTitle = 'About Us';
include 'includes/header.php';
?>

<div class="hero about-hero" style="height: 110vh;">
    <div class="hero-content" style="max-width: 800px;">
        <h1 style="color: white; font-size: 3.5rem; margin-bottom: 20px;">About DD Solutions</h1>
        <p style="color: rgba(255,255,255,0.95); font-size: 1.5rem; margin-bottom: 30px; font-weight: 300;">Right Choice To Good Service</p>
        <div style="background: rgba(0, 0, 0, 0.5); backdrop-filter: blur(5px); padding: 30px; border-radius: 15px; border: 1px solid rgba(255, 255, 255, 0.3); margin-bottom: 40px; text-align: left;">
            <p style="color: rgba(255,255,255,0.95); font-size: 1.1rem; line-height: 1.8; margin: 0; text-shadow: none;">
                We are a premier provider of office automation and specialized construction materials, dedicated to empowering businesses with efficiency and durability. 
                With over 10 years of industry leadership, we bring you world-class technology from global brands and innovative solutions tailored to your unique needs.
            </p>
        </div>
        <a href="#our-story" class="btn" style="background: white; color: var(--primary);">Discover Our Journey</a>
    </div>
</div>

<div class="container section-padding" style="max-width: 1200px;">
    <!-- Our Story Section -->
    <div id="our-story" style="background: white; border-radius: 20px; padding: 50px; box-shadow: 0 8px 30px rgba(0,0,0,0.08); margin-bottom: 40px;" data-aos="fade-up">
        <h2 style="font-size: 2.5rem; color: #1a1a2e; margin-bottom: 25px; font-weight: 800; text-align: center;">Our Story</h2>
        <p style="color: #666; line-height: 1.8; font-size: 1.05rem; margin-bottom: 20px;">
            DD Solutions operates in two major verticals: <strong style="color: #667eea;">Office Automation</strong> and <strong style="color: #f59e0b;">Specialized Construction Materials</strong>.
            With over 10 years of experience, we have established ourselves as a trusted partner for businesses requiring reliable printing solutions and modern construction technologies.
        </p>
        <p style="color: #666; line-height: 1.8; font-size: 1.05rem;">
            As India's No. 1 Copier Distributor partner, we deal in major brands like Konica Minolta, Canon, Kyocera, Sharp, Xerox, HP, Lexmark, and Epson. 
            Our commitment to "Good service in short time" separates us from the competition.
        </p>
    </div>

    <!-- Mission, Vision, Values Grid -->
    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(350px, 1fr)); gap: 30px; margin-bottom: 40px;">
        
        <!-- Mission Card -->
        <div style="background: white; border-radius: 20px; padding: 40px; box-shadow: 0 8px 30px rgba(0,0,0,0.08); border-top: 4px solid #667eea; transition: all 0.3s;" data-aos="fade-up" onmouseover="this.style.transform='translateY(-8px)'; this.style.boxShadow='0 12px 40px rgba(102, 126, 234, 0.15)'" onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 8px 30px rgba(0,0,0,0.08)'">
            <div style="width: 70px; height: 70px; background: linear-gradient(135deg, #667eea, #764ba2); border-radius: 16px; display: flex; align-items: center; justify-content: center; margin-bottom: 20px;">
                <i class="fas fa-bullseye" style="color: white; font-size: 2rem;"></i>
            </div>
            <h3 style="font-size: 1.8rem; color: #1a1a2e; margin-bottom: 15px; font-weight: 700;">Our Mission</h3>
            <p style="color: #666; line-height: 1.7; font-size: 1.05rem;">Provide complete solutions that are reliable, cost effective, with quality work and timely delivery to projects.</p>
        </div>

        <!-- Vision Card -->
        <div style="background: white; border-radius: 20px; padding: 40px; box-shadow: 0 8px 30px rgba(0,0,0,0.08); border-top: 4px solid #f59e0b; transition: all 0.3s;" data-aos="fade-up" data-aos-delay="100" onmouseover="this.style.transform='translateY(-8px)'; this.style.boxShadow='0 12px 40px rgba(245, 158, 11, 0.15)'" onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 8px 30px rgba(0,0,0,0.08)'">
            <div style="width: 70px; height: 70px; background: linear-gradient(135deg, #f59e0b, #f97316); border-radius: 16px; display: flex; align-items: center; justify-content: center; margin-bottom: 20px;">
                <i class="fas fa-eye" style="color: white; font-size: 2rem;"></i>
            </div>
            <h3 style="font-size: 1.8rem; color: #1a1a2e; margin-bottom: 15px; font-weight: 700;">Our Vision</h3>
            <p style="color: #666; line-height: 1.7; font-size: 1.05rem;">To be the most trusted and innovative provider of office automation and construction solutions across India.</p>
        </div>

        <!-- Values Card -->
        <div style="background: white; border-radius: 20px; padding: 40px; box-shadow: 0 8px 30px rgba(0,0,0,0.08); border-top: 4px solid #10b981; transition: all 0.3s;" data-aos="fade-up" data-aos-delay="200" onmouseover="this.style.transform='translateY(-8px)'; this.style.boxShadow='0 12px 40px rgba(16, 185, 129, 0.15)'" onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 8px 30px rgba(0,0,0,0.08)'">
            <div style="width: 70px; height: 70px; background: linear-gradient(135deg, #10b981, #059669); border-radius: 16px; display: flex; align-items: center; justify-content: center; margin-bottom: 20px;">
                <i class="fas fa-heart" style="color: white; font-size: 2rem;"></i>
            </div>
            <h3 style="font-size: 1.8rem; color: #1a1a2e; margin-bottom: 15px; font-weight: 700;">Our Values</h3>
            <ul style="list-style: none; padding: 0; color: #666; line-height: 2; font-size: 1.05rem;">
                <li><i class="fas fa-check-circle" style="color: #10b981; margin-right: 10px;"></i>Customer First</li>
                <li><i class="fas fa-check-circle" style="color: #10b981; margin-right: 10px;"></i>Quality Excellence</li>
                <li><i class="fas fa-check-circle" style="color: #10b981; margin-right: 10px;"></i>Innovation</li>
                <li><i class="fas fa-check-circle" style="color: #10b981; margin-right: 10px;"></i>Integrity</li>
            </ul>
        </div>
    </div>
</div>

<?php include 'includes/footer.php'; ?>
