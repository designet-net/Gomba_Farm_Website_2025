<section style="background-color:#000;">
    <div class="container1">
        <div class="two-column-row">
            <!-- Column 1 -->
            <div class="column">
                <h3>Award-Winning Excellence in Ugandan Agriculture</h3>
                <!-- Google Map iframe showing Gomba District -->
                <div style="width: 100%; height: 300px; margin-bottom: 20px;">
                    <iframe 
                        width="100%" 
                        height="100%" 
                        src="https://www.google.com/maps/embed/v1/place?key=AIzaSyDwqxCthRVdequ-UQxQFbhfLBcLQbiw3SI&q=Gomba+District+Uganda" 
                        allowfullscreen="" 
                        loading="lazy">
                    </iframe>
                </div>
            </div>

            <!-- Column 2 -->
            <div class="column">
                <div class="header">
                    <h1 style="color:#a65418;">Need Agricultural Supplies! Send Us Message</h1>
                </div>
                <div class="content">
                    <?php if (!empty($successMessage)): ?>
                        <p style="color: green;"><?php echo $successMessage; ?></p>
                    <?php elseif (!empty($errorMessage)): ?>
                        <p style="color: red;"><?php echo $errorMessage; ?></p>
                    <?php endif; ?>
                    
                    <form class="contact-form" action="" method="post" style="display: flex; flex-direction: column; gap: 15px;">
                        <label for="name" style="width: 100%;">Full Name</label>
                        <input type="text" id="name" name="name" required style="width: 100%; padding: 10px; border-radius: 5px; border: 1px solid #ddd;">
        
                        <label for="email" style="width: 100%;">Email Address</label>
                        <input type="email" id="email" name="email" required style="width: 100%; padding: 10px; border-radius: 5px; border: 1px solid #ddd;">
        
                        <label for="message" style="width: 100%;">Additional Message (Optional)</label>
                        <textarea id="message" name="message" rows="4" style="width: 100%; padding: 10px; border-radius: 5px; border: 1px solid #ddd;"></textarea>
        
                        <button type="submit" style="width: 100%; padding: 15px; border: none; border-radius: 5px; background-color: red; color: #fff; font-size: 1.2em; cursor: pointer;">Send Message</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
