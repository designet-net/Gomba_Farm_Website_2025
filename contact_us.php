<?php
    session_start();
    $_SESSION['CURRENT_PAGE'] = 'CONT';
?>
<?php 
    include('templates/headings.php');
    include('conn.php');
?>

<style>
    .hero-section img {
        width: 100%;
        border-radius: 8px;
    }
    .highlight-section {
        background-color: #15B392;
        color: #fff;
        padding: 20px;
        border-radius: 8px;
        text-align: center;
        margin: 20px 0;
    }
    .highlight-section h2 {
        margin: 0;
        font-size: 24px;
    }
    .contact-info {
        display: flex;
        justify-content: space-between;
        flex-wrap: wrap;
        margin: 20px 0;
    }
    .contact-card {
        width: 30%;
        background-color: #fff;
        padding: 20px;
        border-radius: 8px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        text-align: center;
        margin-bottom: 20px;
    }
    .contact-card i {
        font-size: 40px;
        color: #15B392;
        margin-bottom: 10px;
    }
    .contact-card h3 {
        font-size: 18px;
        color: #15B392;
        margin-bottom: 10px;
    }
    .contact-card p {
        font-size: 14px;
        line-height: 1.5;
        color: #333;
    }
    .contact-card a {
        color: #15B392;
        text-decoration: none;
        font-weight: bold;
    }
    .contact-form {
        background-color: #fff;
        padding: 20px;
        border-radius: 8px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        margin-top: 20px;
    }
    .contact-form h2 {
        color: #15B392;
        margin-bottom: 20px;
    }
    .contact-form label {
        font-weight: bold;
        display: block;
        margin-bottom: 5px;
    }
    .contact-form input, .contact-form textarea {
        width: 100%;
        padding: 10px;
        margin-bottom: 15px;
        border: 1px solid #ddd;
        border-radius: 6px;
        font-size: 16px;
    }
    .contact-form button {
        display: block;
        width: 100%;
        padding: 12px;
        background-color: #15B392;
        border: none;
        border-radius: 6px;
        color: #fff;
        font-size: 18px;
        cursor: pointer;
        transition: background-color 0.3s ease;
    }
    .contact-form button:hover {
        background-color: #13967e;
    }
</style>

<section class="hero-section">
    <div class="container">
        <img src="images/slider8.jpg" alt="Gomba Farm" />
        <h6 style="text-align:center;color: #fff;">embraces modern methods of farming to revolutionize agriculture and enhance productivity. By integrating technology, precision farming, and sustainable practices, we ensure efficient use of resources while maximizing yields. </h6>
    </div>
</section>

<section style="background-color:#15B392;" id="section4" class="menu_page">
    <div class="container">
        <h2 style="color:#fff;">Our farm services are designed to meet diverse agricultural needs with a commitment to quality and sustainability. We specialize in maize milling, organic banana cultivation, and advanced livestock breeding using cutting-edge techniques.</h2>
    </div>
</section>

<section class="contact-section">
    <div class="container">
        <h1 style="text-align: center;">Get In Touch</h1>
        <h2 style="color: green; text-align: center;">We’re Ready to Help You! Need Any Foods or Consultations</h2>

        <div class="contact-info">
            <div class="contact-card">
                <i class="fas fa-map-marker-alt"></i>
                <h3>Location</h3>
                <p>Kigumba Village, Kigezi Parish, Gomba District</p>
            </div>

            <div class="contact-card">
                <i class="fas fa-envelope"></i>
                <h3>Email Address</h3>
                <p><a href="mailto:info@gomba-nextgenerationfarm.com">info@gomba-nextgenerationfarm.com</a></p>
            </div>

            <div class="contact-card">
                <i class="fas fa-phone-alt"></i>
                <h3>Phone Number</h3>
                <p>+256 704 814569</p>
                <p>+256 772 628113</p>
            </div>
        </div>

        <div class="contact-form">
            <h2>Need Agricultural Products? Send Us a Message</h2>

            <?php if (!empty($successMessage)): ?>
                <p style="color: green;"><?php echo $successMessage; ?></p>
            <?php elseif (!empty($errorMessage)): ?>
                <p style="color: red;"><?php echo $errorMessage; ?></p>
            <?php endif; ?>

            <form action="" method="post">
                <label for="name">Name:</label>
                <input type="text" id="name" name="name" required>

                <label for="email">Email:</label>
                <input type="email" id="email" name="email" required>

                <label for="message">Message:</label>
                <textarea id="message" name="message" rows="6" required></textarea>

                <button type="submit">Send Message</button>
            </form>
        </div>
    </div>
</section>

<?php include('templates/foot.php'); ?>
