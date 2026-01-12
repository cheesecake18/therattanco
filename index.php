<?php
require 'db.php';
session_start();
$categories = $pdo->query("SELECT DISTINCT category FROM inventory ORDER BY category")->fetchAll(PDO::FETCH_COLUMN);
$products = $pdo->query("SELECT * FROM inventory ORDER BY item_id")->fetchAll(PDO::FETCH_ASSOC);
$logged_in = isset($_SESSION['user_id']);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>The Rattan Co. | Handcrafted Rattan Goods</title>
    <!-- Google Fonts: Montserrat -->
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;700&display=swap" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Vina+Sans&display=swap" rel="stylesheet">
    <!-- Font Awesome for Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="styles.css">
</head>
<body>

    <!-- Main Header -->
    <header class="main-header" id="home">
        <div class="logo">
            <!-- Used the uploaded image's contentFetchId for the logo -->
            <img src="images/logo.png" alt="Rattan Co. Logo">
        </div>
        <nav class="primary-nav">
            <ul>
                <li><a href="#home">Home</a></li>
                <li><a href="#products">Products</a></li>
                <li><a href="#about">Our Story</a></li>
                <li><a href="#artisans">Artisans</a></li>
                <li><a href="#community">Community</a></li>
                <li><a href="#faqs">FAQs</a></li>
            </ul>
        </nav>
        <i class="fas fa-shopping-bag cart-icon"></i>
        <div class="user-menu">
            <button class="user-btn" onclick="toggleDropdown()"><i class="fas fa-user"></i></button>
            <div class="dropdown-menu" id="dropdown-menu">
                <?php if ($logged_in): ?>
                    <div class="dropdown-item">Welcome, <?= isset($_SESSION['username']) ? htmlspecialchars($_SESSION['username']) : 'User' ?>!</div>
                    <a href="profile.php" class="dropdown-item">Profile</a>
                    <a href="logout.php" class="dropdown-item">Logout</a>
                <?php else: ?>
                    <a href="login.php" class="dropdown-item">Login</a>
                    <a href="register.php" class="dropdown-item">Register</a>
                <?php endif; ?>
            </div>
        </div>
    </header>

    <!-- Hero Section -->
    <section class="hero-section">
        <div class="hero-image-container">
            <!-- Placeholder for a beautiful, moody rattan image -->
            <img src="images/hero.jpg" alt="Hero Image: Luxury Handwoven Rattan">
            <div class="hero-text-overlay">
                <h1>Woven <br> Heritage</h1>
                <p>Authentic, sustainable crafts for the modern home.</p>
                <button class="cta-button" onclick="window.location.href='catalog.php'">Shop The Collection</button>
            </div>
        </div>
    </section>

    <!-- Tagline/Features Bar -->
    <section class="tagline-bar">
        <div class="tagline-left">
            <h2>Crafted with intention. Designed for life.</h2>
        </div>
        <div class="features">
            <p><i class="fas fa-check-circle"></i> <span>Ethically Sourced</span></p>
            <p><i class="fas fa-check-circle"></i> <span>Handwoven Quality</span></p>
            <p><i class="fas fa-check-circle"></i> <span>Sustainable Materials</span></p>
        </div>
    </section>

    <!-- Products Section -->
    <section class="products-section" id="products">
        <div class="left-divider"></div>
        <div class="right-divider"></div>
        <h2>Best Seller</h2>
        <div class="products-grid">
            <?php foreach ($products as $index => $product): ?>
                <div class="product-card <?= $index >= 4 ? 'hidden' : '' ?>">
                    <img src="<?= htmlspecialchars($product['image']) ?>" alt="<?= htmlspecialchars($product['item']) ?>">
                    <h3><?= htmlspecialchars($product['item']) ?></h3>
                    <p><?= htmlspecialchars($product['description']) ?></p>
                    <span class="price">₱<?= number_format($product['price']) ?></span>
                    <div class="button-group">
                        <button class="product-btn add-to-cart" onclick="addToCart('<?= htmlspecialchars($product['item']) ?>', <?= $product['price'] ?>, '<?= htmlspecialchars($product['image']) ?>')">Add to Cart</button>
                        <button class="product-btn buy-now" onclick="buyNow('<?= htmlspecialchars($product['item']) ?>', <?= $product['price'] ?>, '<?= htmlspecialchars($product['image']) ?>')">Buy Now</button>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
        <button class="more-products-btn" onclick="toggleProducts()">
            More Products <i class="fas fa-chevron-down"></i>
        </button>
    </section>

    <!-- About Section -->
    <section class="about-section" id="about">
        <h2>Our Story & Promise</h2>
        <div class="about-item text-item">
            <h3>Our Roots</h3>
            <p>The Weave House was founded on the principle of preserving traditional weaving techniques while providing fair, sustainable income to local artisan communities. Every piece tells a story of skill, dedication, and heritage.</p>
            <a href="#" class="learn-more-btn" onclick="showFoundersModal()">Meet Our Founders</a>
        </div>
        <div class="about-item image-item">
            <img src="images/image 3.png" alt="Ethical sourcing graphic">
        </div>
        <div class="about-item image-item">
            <img src="images/image 4.png" alt="Handcrafting image">
        </div>
        <div class="about-item text-item">
            <h3>Sustainable Materials</h3>
            <p>We only use ethically harvested, high-quality rattan, ensuring minimal environmental impact. Our commitment is to planet-friendly practices from the forest to your front door.</p>
            <a href="#" class="learn-more-btn" onclick="showManifestoModal()">Read Our Manifesto</a>
        </div>
        <div class="about-item artisans-container" id="artisans">
            <h2>Meet The Artisans</h2>
            <div class="artisans-grid">
                <div class="artisan-card">
                    <img src="images/mariasantos.jpg" alt="Artisan photo">
                    <div class="artisan-overlay">
                        <h4>Maria Santos</h4>
                        <p>Master Weaver, 30 Years Experience</p>
                    </div>
                </div>
                <div class="artisan-card">
                    <img src="images/julioreyes.jpg" alt="Artisan photo">
                    <div class="artisan-overlay">
                        <h4>Julio Reyes</h4>
                        <p>Rattan Carver & Finisher</p>
                    </div>
                </div>
                <div class="artisan-card">
                    <img src="images/sofiacruz.jpg" alt="Artisan photo">
                    <div class="artisan-overlay">
                        <h4>Sofia Cruz</h4>
                        <p>Dye & Material Specialist</p>
                    </div>
                </div>
                <div class="artisan-card">
                    <img src="images/benitodizon.jpg" alt="Artisan photo">
                    <div class="artisan-overlay">
                        <h4>Benito Dizon</h4>
                        <p>Apprentice Weaver</p>
                    </div>
                </div>
            </div>
        </div>
    </section>


    <!-- Weaving Process Section -->
    <section class="weaving-section">
        <h2>The Slow Art of Rattan Weaving</h2>
        <div class="weaving-columns">
            <div class="column">
                <img src="images/Harvesting & Preparation.jpg" alt="Rattan harvesting">
                <h3>Harvesting & Preparation</h3>
                <p>Rattan vines are sustainably harvested, cleaned, and soaked for weeks to ensure maximum flexibility and durability. This vital first step prepares the raw material for transformation.</p>
            </div>
            <div class="column">
                <img src="images/Hand Weaving.jpg" alt="Weaving process">
                <h3>Hand Weaving</h3>
                <p>Each piece is meticulously hand-woven using traditional patterns passed down through generations. This slow, deliberate process ensures the structural integrity and unique beauty of the final product.</p>
            </div>
            <div class="column">
                <img src="images/finishing.jpg" alt="Finishing and delivery">
                <h3>Finishing & Curing</h3>
                <p>After weaving, the items are dried and cured naturally. They are then treated with organic finishes to protect the rattan and enhance its natural color and texture for a lifetime of use.</p>
            </div>
        </div>
    </section>

    <!-- Available Soon Section -->
    <section class="available-soon-section">
        <div class="available-soon-container">
            <img src="images/availablesoon.jpg" alt="Available Soon">
            <div class="available-soon-overlay">
                <h2>Available Soon</h2>
                <p>Exciting new products coming your way. Stay tuned!</p>
            </div>
        </div>
    </section>

    <!-- Rattan Community/Social Gallery Section -->
    <section class="rattan-community-section" id="community">
        <div class="rattan-container">
            <div class="rattan-community-header">
                <h1>#TheRattanCo Community</h1>
            </div>
            <div class="rattan-gallery-container">
                <img class="rattan-img" src="images/image 16.png" alt="Community photo 1">
                <img class="rattan-img" src="images/image 14.png" alt="Community photo 2">
                <img class="rattan-img" src="images/image 18.png" alt="Community photo 3">
                <img class="rattan-img" src="images/image 12.png" alt="Community photo 4">
                <img class="rattan-img" src="images/image 15.png" alt="Community photo 5">
                <img class="rattan-img" src="images/image 17.png" alt="Community photo 6">
                <img class="rattan-img" src="images/image 19.png" alt="Community photo 5">
                <img class="rattan-img" src="images/image 20.png" alt="Community photo 6">
                <img class="rattan-img" src="images/image 11.png" alt="Community photo 5">
                <img class="rattan-img" src="images/image 25.jpg" alt="Community photo 6">
            </div>
            <div class="rattan-community-footer">
                <p>Share your style with us: #TheRattanCo</p>
            </div>
        </div>
    </section>
    <?php include 'footer.php'; ?>

    <!-- Founders Modal -->
    <div id="founders-modal" class="modal">
        <div class="modal-content">
            <span class="close" onclick="closeFoundersModal()">&times;</span>
            <h2>Meet Our Founders</h2>
            <div class="founders-grid">
                <div class="founder-card">
                    <img src="images/mariasantos.jpg" alt="Maria Santos">
                    <h3>Maria Santos</h3>
                    <p>Co-Founder & CEO</p>
                    <p>Maria has over 20 years of experience in sustainable crafts and has dedicated her career to promoting ethical sourcing and traditional craftsmanship in the Philippines.</p>
                </div>
                <div class="founder-card">
                    <img src="images/julioreyes.jpg" alt="Julio Reyes">
                    <h3>Julio Reyes</h3>
                    <p>Co-Founder & Creative Director</p>
                    <p>Julio is passionate about design and sustainability. He leads our design team in creating beautiful, functional pieces that honor traditional Filipino weaving techniques.</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Manifesto Modal -->
    <div id="manifesto-modal" class="modal">
        <div class="modal-content">
            <span class="close" onclick="closeManifestoModal()">&times;</span>
            <h2>Our Manifesto</h2>
            <div class="manifesto-content">
                <p>At The Rattan Co., we believe in the power of sustainable craftsmanship to create a better world. Our manifesto is rooted in the principles of ethical sourcing, environmental stewardship, and cultural preservation.</p>
                <h3>Ethical Sourcing</h3>
                <p>We partner with local communities to ensure fair wages and safe working conditions for all artisans involved in our supply chain.</p>
                <h3>Environmental Responsibility</h3>
                <p>Every piece of rattan we use is sustainably harvested, minimizing our impact on natural ecosystems and promoting biodiversity.</p>
                <h3>Cultural Preservation</h3>
                <p>We honor traditional Filipino weaving techniques, passing down knowledge from generation to generation while innovating for modern needs.</p>
                <h3>Quality & Durability</h3>
                <p>Our products are designed to last, reducing waste and promoting a circular economy in consumer goods.</p>
                <p>Join us in our mission to weave a sustainable future, one strand at a time.</p>
            </div>
        </div>
    </div>

    <!-- Care Modal -->
    <div id="care-modal" class="modal">
        <div class="modal-content">
            <span class="close" onclick="closeCareModal()">&times;</span>
            <h2>How to Care for Rattan Products</h2>
            <div class="care-content">
                <p>Proper care ensures your rattan products remain beautiful and durable for years. Follow these simple guidelines:</p>
                <h3>Cleaning</h3>
                <ul>
                    <li>Dust regularly with a soft cloth or vacuum with a brush attachment.</li>
                    <li>For deeper cleaning, use a mild soap solution and a soft sponge.</li>
                    <li>Avoid harsh chemicals or abrasive cleaners that can damage the natural fibers.</li>
                </ul>
                <h3>Maintenance</h3>
                <ul>
                    <li>Keep away from direct sunlight to prevent fading.</li>
                    <li>Maintain indoor humidity levels to prevent cracking.</li>
                    <li>Rotate items occasionally to ensure even wear.</li>
                </ul>
                <h3>Storage</h3>
                <ul>
                    <li>Store in a cool, dry place when not in use.</li>
                    <li>Avoid stacking heavy items on rattan furniture.</li>
                    <li>Use protective covers if storing for extended periods.</li>
                </ul>
                <p>With proper care, your rattan products will provide lasting beauty and functionality.</p>
            </div>
        </div>
    </div>

    <!-- Shipping Modal -->
    <div id="shipping-modal" class="modal">
        <div class="modal-content">
            <span class="close" onclick="closeShippingModal()">&times;</span>
            <h2>Shipping Information</h2>
            <div class="shipping-content">
                <p>We offer reliable shipping services across the Philippines. Here's what you need to know:</p>
                <h3>Delivery Times</h3>
                <ul>
                    <li>Metro Manila: 2-3 business days</li>
                    <li>Luzon: 3-5 business days</li>
                    <li>Visayas/Mindanao: 5-7 business days</li>
                </ul>
                <h3>Shipping Costs</h3>
                <ul>
                    <li>Free shipping on orders over ₱5,000</li>
                    <li>Standard shipping: ₱150</li>
                    <li>Express shipping: ₱300</li>
                </ul>
                <h3>Tracking</h3>
                <p>You will receive a tracking number via email once your order ships. Track your package on our website or the carrier's site.</p>
                <p>For any shipping inquiries, contact our customer service team.</p>
            </div>
        </div>
    </div>

    <!-- Return Modal -->
    <div id="return-modal" class="modal">
        <div class="modal-content">
            <span class="close" onclick="closeReturnModal()">&times;</span>
            <h2>Return Policy</h2>
            <div class="return-content">
                <p>We want you to be completely satisfied with your purchase. If you're not happy with your rattan product, here's our return policy:</p>
                <h3>Eligibility</h3>
                <ul>
                    <li>Returns accepted within 30 days of delivery</li>
                    <li>Items must be unused and in original packaging</li>
                    <li>Custom or personalized items are not returnable</li>
                </ul>
                <h3>How to Return</h3>
                <ol>
                    <li>Contact our customer service to initiate a return</li>
                    <li>Pack the item securely in its original packaging</li>
                    <li>Ship the item back to us (shipping costs may apply)</li>
                    <li>Once received, we'll process your refund within 5-7 business days</li>
                </ol>
                <h3>Refunds</h3>
                <p>Refunds will be issued to the original payment method. Please allow 5-10 business days for the refund to appear in your account.</p>
            </div>
        </div>
    </div>

    <!-- Contact Modal -->
    <div id="contact-modal" class="modal">
        <div class="modal-content">
            <span class="close" onclick="closeContactModal()">&times;</span>
            <h2>Contact Us</h2>
            <div class="contact-content">
                <p>We're here to help! Get in touch with us through any of the following methods:</p>
                <h3>Customer Service</h3>
                <p>Email: info@therattanco.com<br>
                Phone: +63 123 456 7890<br>
                Hours: Monday-Friday, 9 AM - 6 PM PST</p>
                <h3>Address</h3>
                <p>The Rattan Co.<br>
                123 Artisan Street<br>
                Craft Village, Philippines 1234</p>
                <h3>Follow Us</h3>
                <p>Stay connected on social media for updates and inspiration:<br>
                Facebook | Instagram | Twitter</p>
                <p>We typically respond to inquiries within 24 hours.</p>
            </div>
        </div>
    </div>

    <button class="floating-back-to-top" onclick="window.scrollTo({top: 0, behavior: 'smooth'});">
        <i class="fas fa-arrow-up"></i>
    </button>

    <script>
        function toggleProducts() {
            const allProducts = document.querySelectorAll('.product-card');
            const button = document.querySelector('.more-products-btn');
            const isHidden = allProducts[4] && allProducts[4].classList.contains('hidden');

            if (isHidden) {
                // Show products
                for (let i = 4; i < allProducts.length; i++) {
                    allProducts[i].classList.remove('hidden');
                }
                button.innerHTML = 'Show Less <i class="fas fa-chevron-up"></i>';
            } else {
                // Hide products
                for (let i = 4; i < allProducts.length; i++) {
                    allProducts[i].classList.add('hidden');
                }
                button.innerHTML = 'More Products <i class="fas fa-chevron-down"></i>';
            }
        }

        // Back to top button visibility
        const hero = document.querySelector('.hero-section');
        const backToTop = document.querySelector('.floating-back-to-top');

        window.addEventListener('scroll', () => {
            if (window.scrollY > hero.offsetHeight) {
                backToTop.style.display = 'block';
            } else {
                backToTop.style.display = 'none';
            }
        });

        // Cart functionality
        let cart = JSON.parse(localStorage.getItem('cart')) || [];

        function addToCart(itemName, price, image) {
            const item = cart.find(i => i.name === itemName);
            if (item) {
                item.quantity += 1;
            } else {
                cart.push({ name: itemName, price: price, quantity: 1, image: image });
            }
            localStorage.setItem('cart', JSON.stringify(cart));
            updateCartIcon();
            alert(itemName + ' added to cart!');
        }

        function updateCartIcon() {
            const cartCount = cart.reduce((sum, item) => sum + item.quantity, 0);
            const cartIcon = document.querySelector('.cart-icon');
            cartIcon.setAttribute('data-count', cartCount);
            // Add count display if needed
        }

        function showCart() {
            window.location.href = 'cart.php';
        }

        function buyNow(itemName, price, image) {
            addToCart(itemName, price, image);
            window.location.href = 'checkout.php';
        }

        function checkout() {
            alert('Checkout functionality not implemented yet.');
        }

        // Initialize cart icon
        updateCartIcon();

        // Make cart icon clickable
        document.querySelector('.cart-icon').addEventListener('click', showCart);

        function toggleDropdown() {
            const menu = document.getElementById('dropdown-menu');
            menu.classList.toggle('show');
        }

        // Close dropdown when clicking outside
        window.addEventListener('click', function(e) {
            const menu = document.getElementById('dropdown-menu');
            const btn = document.querySelector('.user-btn');
            if (!btn.contains(e.target) && !menu.contains(e.target)) {
                menu.classList.remove('show');
            }
        });

        function showFoundersModal() {
            document.getElementById('founders-modal').style.display = 'block';
        }

        function closeFoundersModal() {
            document.getElementById('founders-modal').style.display = 'none';
        }

        function showManifestoModal() {
            document.getElementById('manifesto-modal').style.display = 'block';
        }

        function closeManifestoModal() {
            document.getElementById('manifesto-modal').style.display = 'none';
        }

        function showCareModal() {
            document.getElementById('care-modal').style.display = 'block';
        }

        function closeCareModal() {
            document.getElementById('care-modal').style.display = 'none';
        }

        function showShippingModal() {
            document.getElementById('shipping-modal').style.display = 'block';
        }

        function closeShippingModal() {
            document.getElementById('shipping-modal').style.display = 'none';
        }

        function showReturnModal() {
            document.getElementById('return-modal').style.display = 'block';
        }

        function closeReturnModal() {
            document.getElementById('return-modal').style.display = 'none';
        }

        function showContactModal() {
            document.getElementById('contact-modal').style.display = 'block';
        }

        function closeContactModal() {
            document.getElementById('contact-modal').style.display = 'none';
        }

        // Close modals when clicking outside
        window.addEventListener('click', function(e) {
            const foundersModal = document.getElementById('founders-modal');
            const manifestoModal = document.getElementById('manifesto-modal');
            const careModal = document.getElementById('care-modal');
            const shippingModal = document.getElementById('shipping-modal');
            const returnModal = document.getElementById('return-modal');
            const contactModal = document.getElementById('contact-modal');
            if (e.target === foundersModal) {
                foundersModal.style.display = 'none';
            }
            if (e.target === manifestoModal) {
                manifestoModal.style.display = 'none';
            }
            if (e.target === careModal) {
                careModal.style.display = 'none';
            }
            if (e.target === shippingModal) {
                shippingModal.style.display = 'none';
            }
            if (e.target === returnModal) {
                returnModal.style.display = 'none';
            }
            if (e.target === contactModal) {
                contactModal.style.display = 'none';
            }
        });
    </script>

</body>
</html>