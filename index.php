<?php
// index.php
$pageTitle = 'Home';
include 'includes/header.php';

// Fetch featured products (latest 4)
$stmt = $pdo->query("SELECT * FROM products ORDER BY created_at DESC LIMIT 4");
$featured_products = $stmt->fetchAll();
?>

<!-- Hero Section -->
<section class="hero" style="position: relative; overflow: visible;">
    <div class="hero-content" style="display: grid; grid-template-columns: 1fr 1fr; gap: 80px; align-items: center; max-width: 1400px; margin: 0 auto;">
        
        <!-- Left: Banner Content -->
        <div>
            <!-- Main Headline -->
            <h1 data-aos="fade-up" style="font-size: 3.5rem; margin-bottom: 15px; line-height: 1.2; text-align: left;">
                India's <span style="background: linear-gradient(90deg, #ff0844, #ff6b35); -webkit-background-clip: text; -webkit-text-fill-color: transparent; background-clip: text;">No.1</span><br>
                Copier Distributor
            </h1>
            
            <!-- Tagline -->
            <!-- Tagline -->
            <p data-aos="fade-up" data-aos-delay="100" style="font-size: 1.1rem; color: #fff; margin-bottom: 30px; line-height: 1.6;">
                Your trusted partner for Copiers, Printers, and Total Concrete Solutions.
            </p>

            <!-- Owner Section with Trust Badge -->
            <div data-aos="fade-up" data-aos-delay="200" style="display: flex; align-items: center; gap: 20px; margin-bottom: 40px;">
                <!-- Circular Owner Photo -->
                <div style="width: 100px; height: 100px; border-radius: 50%; overflow: hidden; position: relative; animation: pulse 3s ease-in-out infinite;">
                    <img src="assets/images/owner.png" alt="Founder & CEO" style="width: 100%; height: 100%; object-fit: cover;">
                </div>
                
                <!-- Owner Info -->
                <div style="animation: pulse 3s ease-in-out infinite;">
                    <h3 style="font-size: 1.3rem; font-weight: 700; margin-bottom: 5px; color: #fff;">Founder & CEO</h3>
                    <p style="font-size: 1rem; color: #fff; margin: 0;">Trusted Leadership</p>
                </div>
                
                <!-- Trust Badge -->
                <div style="margin-left: 20px; animation: pulse 3s ease-in-out infinite;">
                    <img src="assets/images/trust-badge.png" alt="100% Trusted Company" style="width: 100px; height: 100px;">
                </div>
            </div>

<style>
@keyframes pulse {
    0%, 100% {
        transform: scale(1);
    }
    50% {
        transform: scale(1.05);
    }
}

@keyframes rotate {
    from {
        transform: rotate(0deg);
    }
    to {
        transform: rotate(360deg);
    }
}
</style>

            <!-- CTA Buttons -->
            <div style="display: flex; gap: 15px;">
                <a href="products.php" class="btn">Shop Now</a>
                <a href="services.php" class="btn btn-outline">Our Services</a>
            </div>
        </div>

        <!-- Right: Looping Video -->
        <div data-aos="fade-left" style="display: flex; justify-content: center; align-items: center;">
            <video autoplay loop muted playsinline style="width: 100%; height: 100%; min-height: 400px; max-width: 550px; border-radius: 20px; box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3); object-fit: cover;">
                <source src="assets/videos/Printer.mp4" type="video/mp4">
                Your browser does not support the video tag.
            </video>
        </div>
    </div>
</section>

<!-- Live Performance Counter -->
<section class="section-padding" style="background: var(--dark); color: white;">
    <div class="container">
        <h2 class="text-center" style="margin-bottom: 50px; color: white;">Our Track Record</h2>
        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 40px; text-align: center;">
            
            <div class="stat-item" data-aos="fade-up">
                <div class="stat-icon"><i class="fas fa-users"></i></div>
                <div class="stat-number" data-target="10000">0</div>
                <div class="stat-label">Happy Customers</div>
            </div>

            <div class="stat-item" data-aos="fade-up" data-aos-delay="100">
                <div class="stat-icon"><i class="fas fa-handshake"></i></div>
                <div class="stat-number" data-target="8">0</div>
                <div class="stat-label">Brand Partners</div>
            </div>

            <div class="stat-item" data-aos="fade-up" data-aos-delay="200">
                <div class="stat-icon"><i class="fas fa-calendar-alt"></i></div>
                <div class="stat-number" data-target="10">0</div>
                <div class="stat-label">Years of Excellence</div>
            </div>

            <div class="stat-item" data-aos="fade-up" data-aos-delay="300">
                <div class="stat-icon"><i class="fas fa-project-diagram"></i></div>
                <div class="stat-number" data-target="500">0</div>
                <div class="stat-label">Projects Completed</div>
            </div>

        </div>
    </div>
</section>

<!-- Our Products -->
<section class="section-padding" style="background: #f8f9fa;">
    <div class="container">
        <h2 class="text-center" style="margin-bottom: 50px; font-weight: 800; color: #1a1a2e;">What We Provide</h2>
        <div class="category-grid">
            
            <!-- Brand New Machines -->
            <a href="products.php?category=new-machines" class="category-card" data-aos="fade-up">
                <img src="assets/images/categories/new-machines.png" alt="Brand New Machines">
                <div class="category-overlay">
                    <h3>Brand New Machines</h3>
                    <p>Latest Technology Copiers & Printers</p>
                    <div class="cat-btn"><i class="fas fa-arrow-right"></i></div>
                </div>
            </a>

            <!-- RC Machines -->
            <a href="products.php?category=rc-machines" class="category-card" data-aos="fade-up" data-aos-delay="100">
                <img src="assets/images/categories/rc-machines.png" alt="RC Machines">
                <div class="category-overlay">
                    <h3>RC Machines</h3>
                    <p>Refurbished & Reliable</p>
                    <div class="cat-btn"><i class="fas fa-arrow-right"></i></div>
                </div>
            </a>

            <!-- Laser Printers -->
            <a href="products.php?category=laser-printers" class="category-card" data-aos="fade-up" data-aos-delay="200">
                <img src="assets/images/categories/laser-printers.png" alt="Laser Printers">
                <div class="category-overlay">
                    <h3>Laser Printers</h3>
                    <p>High Speed & Efficiency</p>
                    <div class="cat-btn"><i class="fas fa-arrow-right"></i></div>
                </div>
            </a>

            <!-- Inkjet Printers -->
             <a href="products.php?category=inkjet-printers" class="category-card" data-aos="fade-up" data-aos-delay="300">
                <img src="assets/images/categories/inkjet-printers.png" alt="Inkjet Printers">
                <div class="category-overlay">
                    <h3>Inkjet Printers</h3>
                    <p>Color Precision Printing</p>
                    <div class="cat-btn"><i class="fas fa-arrow-right"></i></div>
                </div>
            </a>

            <!-- Spares -->
             <a href="products.php?category=spares" class="category-card" data-aos="fade-up" data-aos-delay="400">
                <img src="assets/images/categories/spares.png" alt="Spares">
                <div class="category-overlay">
                    <h3>Spares</h3>
                    <p>Genuine Parts</p>
                    <div class="cat-btn"><i class="fas fa-arrow-right"></i></div>
                </div>
            </a>

            <!-- Consumables -->
             <a href="products.php?category=spares" class="category-card" data-aos="fade-up" data-aos-delay="500">
                <img src="assets/images/categories/consumables.png" alt="Consumables">
                <div class="category-overlay">
                    <h3>Consumables</h3>
                    <p>High Quality Supplies</p>
                    <div class="cat-btn"><i class="fas fa-arrow-right"></i></div>
                </div>
            </a>
        </div>
    </div>
</section>

<!-- Office Solutions Showcase -->
<section class="section-padding">
    <div class="container">
        <div style="display: grid; grid-template-columns: 1fr 1.2fr; gap: 50px; align-items: center;">
            
            <div data-aos="fade-right">
                <div style="background: linear-gradient(rgba(0,0,0,0.6), rgba(0,0,0,0.6)), url('assets/images/equip-office.png') no-repeat right center/cover; border-radius: 20px; padding: 40px; text-align: center; box-shadow: 0 10px 30px rgba(0,0,0,0.15);">
                    <div style="font-size: 6rem; color: white; margin-bottom: 20px;">
                        <i class="fas fa-print"></i>
                    </div>
                    <h2 style="color: white; font-size: 2.5rem; margin-bottom: 15px; font-weight: 800;">Equip My Office</h2>
                    <p style="color: rgba(255,255,255,0.9); font-size: 1.2rem;">Complete Office Automation Solutions</p>
                    <div style="margin-top: 30px; padding: 20px; background: rgba(255,255,255,0.1); backdrop-filter: blur(5px); border-radius: 12px; border: 1px solid rgba(255,255,255,0.2);">
                        <div style="font-size: 3rem; font-weight: 800; color: #4ade80; margin-bottom: 5px;">8+</div>
                        <div style="color: white; font-size: 1rem; opacity: 0.9;">Premium Brands</div>
                    </div>
                </div>
            </div>

            <!-- Right: Content Section -->
            <div data-aos="fade-left">
                <div style="background: white; border-radius: 20px; padding: 40px; box-shadow: 0 20px 60px rgba(0,0,0,0.3);">
                    <h3 style="font-size: 1.8rem; color: #1a1a2e; margin-bottom: 20px; font-weight: 700;">Transform Your Workplace</h3>
                    <p style="color: #666; font-size: 1.05rem; line-height: 1.8; margin-bottom: 30px;">
                        Cutting-edge printing technology from world-leading brands. We provide complete solutions tailored to your business needs.
                    </p>

                    <div style="display: grid; gap: 20px; margin-bottom: 30px;">
                        <div style="display: flex; gap: 15px; align-items: start;">
                            <div style="width: 50px; height: 50px; background: linear-gradient(135deg, #667eea, #764ba2); border-radius: 12px; display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
                                <i class="fas fa-award" style="color: white; font-size: 1.3rem;"></i>
                            </div>
                            <div>
                                <h4 style="color: #1a1a2e; font-size: 1.1rem; margin-bottom: 5px; font-weight: 600;">Multi-Brand Support</h4>
                                <p style="color: #666; font-size: 0.95rem; line-height: 1.6;">Authorized partners for Konica Minolta, Canon, Kyocera, Sharp, Xerox, HP, Epson, and more.</p>
                            </div>
                        </div>

                        <div style="display: flex; gap: 15px; align-items: start;">
                            <div style="width: 50px; height: 50px; background: linear-gradient(135deg, #667eea, #764ba2); border-radius: 12px; display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
                                <i class="fas fa-shopping-cart" style="color: white; font-size: 1.3rem;"></i>
                            </div>
                            <div>
                                <h4 style="color: #1a1a2e; font-size: 1.1rem; margin-bottom: 5px; font-weight: 600;">Sales & Rentals</h4>
                                <p style="color: #666; font-size: 0.95rem; line-height: 1.6;">Flexible ownership options including outright purchase, lease, and short/long-term rental plans.</p>
                            </div>
                        </div>

                        <div style="display: flex; gap: 15px; align-items: start;">
                            <div style="width: 50px; height: 50px; background: linear-gradient(135deg, #667eea, #764ba2); border-radius: 12px; display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
                                <i class="fas fa-tools" style="color: white; font-size: 1.3rem;"></i>
                            </div>
                            <div>
                                <h4 style="color: #1a1a2e; font-size: 1.1rem; margin-bottom: 5px; font-weight: 600;">AMC Services</h4>
                                <p style="color: #666; font-size: 0.95rem; line-height: 1.6;">Comprehensive Annual Maintenance Contracts with guaranteed uptime and rapid response times.</p>
                            </div>
                        </div>
                    </div>

                    <a href="products.php" class="btn" style="width: 100%; text-align: center; font-size: 1.1rem; padding: 15px; background: linear-gradient(135deg, #667eea, #764ba2);">
                        Explore Products <i class="fas fa-arrow-right" style="margin-left: 10px;"></i>
                    </a>
                </div>
            </div>

        </div>
    </div>
</section>

<!-- About Preview -->
<section class="section-padding">
    <div class="container about-section">
        <div class="about-img" data-aos="fade-right">
            <img src="assets/images/about-cover.png" alt="About DD Solutions">
        </div>
        <div class="about-content" data-aos="fade-left">
            <h2 class="section-title">Who We Are</h2>
            <p style="margin: 20px 0;">
                DD Solutions has a vast experience of over 10 years in fibre reinforced concrete technology and other allied services; deals in niche construction materials and total concrete floor solutions. 
                We are also India’s No. One Copier distributor partners for major brands.
            </p>
            <p style="margin-bottom: 20px;">
                Our approach combines technical expertise with a customer-first philosophy. 
                Whether you need high-performance copiers or durability in construction flooring, we deliver solutions that stand the test of time.
            </p>
            <a href="about.php" class="btn">Learn More</a>
        </div>
    </div>
</section>

<!-- Brand Scroll -->
<section class="section-padding" style="background: #fff; overflow: hidden; padding: 40px 0;">
    <div class="container">
        <h2 class="text-center" style="margin-bottom: 30px;">Our Trusted Partners</h2>
        <div class="brand-carousel">
            <div class="brand-track">
                <!-- 5 Uploaded Brands -->
                <div class="brand-item"><img src="assets/images/brands/brand1.png" alt="Konica Minolta"></div>
                <div class="brand-item"><img src="assets/images/brands/brand2.png" alt="Riso"></div>
                <div class="brand-item"><img src="assets/images/brands/brand3.png" alt="Epson"></div>
                <div class="brand-item"><img src="assets/images/brands/brand4.png" alt="Kyocera"></div>
                <div class="brand-item"><img src="assets/images/brands/brand5.png" alt="Fujifilm"></div>
                <!-- 2 Requested Brands (Uploaded) -->
                <div class="brand-item"><img src="assets/images/brands/brand6.png" alt="Xerox"></div>
                <div class="brand-item"><img src="assets/images/brands/brand7.png" alt="HP"></div>
                
                <!-- Duplicate for Infinite Scroll -->
                <div class="brand-item"><img src="assets/images/brands/brand1.png" alt="Konica Minolta"></div>
                <div class="brand-item"><img src="assets/images/brands/brand2.png" alt="Riso"></div>
                <div class="brand-item"><img src="assets/images/brands/brand3.png" alt="Epson"></div>
                <div class="brand-item"><img src="assets/images/brands/brand4.png" alt="Kyocera"></div>
                <div class="brand-item"><img src="assets/images/brands/brand5.png" alt="Fujifilm"></div>
                <div class="brand-item"><img src="assets/images/brands/brand6.png" alt="Xerox"></div>
                <div class="brand-item"><img src="assets/images/brands/brand7.png" alt="HP"></div>
            </div>
        </div>
    </div>
</section>

<!-- Features -->
<section class="section-padding" style="background: #eef2f3;">
    <div class="container">
        <h2 class="text-center" style="margin-bottom: 50px;">Why Partner With Us</h2>
        <div class="product-grid">
            
            <div class="feature-card" data-aos="zoom-in">
                <div class="feature-icon"><i class="fas fa-handshake"></i></div>
                <h3>100% Post-Sales Commitment</h3>
                <p>Our relationship doesn't end at the sale. We are dedicated to providing ongoing support, maintenance, and expert guidance to ensure your equipment and projects run smoothly for years to come.</p>
            </div>

            <div class="feature-card" data-aos="zoom-in" data-aos-delay="200">
                <div class="feature-icon"><i class="fas fa-shipping-fast"></i></div>
                <h3>On-Time Delivery</h3>
                <p>We understand the value of your time. Whether it's office supplies or construction materials, we guarantee prompt and reliable delivery schedules to keep your business operations uninterrupted.</p>
            </div>
            
            <div class="feature-card" data-aos="zoom-in" data-aos-delay="400">
                <div class="feature-icon"><i class="fas fa-stopwatch-20"></i></div>
                <h3>1-Hour Service Response</h3>
                <p>Emergencies can't wait. Our rapid response team is on standby to address your service queries and breakdown calls within 60 minutes, minimizing downtime and maximizing productivity.</p>
            </div>
            
        </div>
    </div>
</section>

<!-- Featured Products -->
<section class="section-padding">
    <div class="container">
        <h2 class="text-center" style="margin-bottom: 50px;">Featured Products</h2>
        <div class="product-grid">
            <?php foreach ($featured_products as $prod): 
                $imgs = json_decode($prod['images_json']);
                $thumb = !empty($imgs) ? "uploads/" . $imgs[0] : "assets/images/logo.png";
            ?>
            <div class="product-card" data-aos="fade-up">
                <div class="product-img">
                    <img src="<?php echo $thumb; ?>" alt="<?php echo $prod['title']; ?>">
                </div>
                <div class="product-info">
                    <span class="product-cat">Product</span>
                    <h3 class="product-title"><?php echo $prod['title']; ?></h3>
                    <span class="product-price"><?php echo formatPrice($prod['price']); ?></span>
                    <a href="product_details.php?id=<?php echo $prod['id']; ?>" class="btn" style="width: 100%; text-align: center;">View Details</a>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
        <div class="text-center" style="margin-top: 40px;">
            <a href="products.php" class="btn">View All Products</a>
        </div>
    </div>
</section>

<?php include 'includes/footer.php'; ?>
