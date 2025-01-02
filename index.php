<?php
    session_start();
    $_SESSION['CURRENT_PAGE'] = 'HOME';
?>
<?php 
    include('templates/headings.php');
    include('conn.php');
?>
    <div class="slider-main">
    <div id="slider" class="nivoSlider">
        <img src="images/slider11.jpg" alt="slider11" style="width: 100%; border-radius: 8px;" />
        <img src="images/slider6.jpg" alt="slider6" style="width: 100%; border-radius: 8px;" />
        <img src="images/slider4.jpg" alt="slider4" style="width: 100%; border-radius: 8px;" />
        <img src="images/slider1.jpg" alt="slider1" style="width: 100%; border-radius: 8px;" />
    </div>                 
    
    <!-- Slide 1 -->
    <div id="slidecaption1" class="nivo-html-caption">
        <div class="custominfo" style="background-color:rgba(0,0,0,0.7);padding:20px;">
            <h2>
                <p style="font-size:18px;text-align:justify;">
                    Get involved in bee farming and contribute to sustainable agriculture while building a thriving beekeeping business.
                </p>
            </h2>
        </div><!-- .custominfo -->                   
    </div><!-- #slidecaption1 -->
    
    <!-- Slide 2 -->
    <div id="slidecaption2" class="nivo-html-caption">
        <div class="custominfo" style="background-color:rgba(0,0,0,0.7);padding:20px;">
            <h2>
                <p style="font-size:18px;text-align:justify;">
                    Our training institute is the cornerstone of farm knowledge, offering valuable skills for a sustainable agricultural future.
                </p>
            </h2>
        </div><!-- .custominfo -->                   
    </div><!-- #slidecaption2 -->
    
    <!-- Slide 3 -->
    <div id="slidecaption3" class="nivo-html-caption">
        <div class="custominfo" style="background-color:rgba(0,0,0,0.7);padding:20px;">
            <h2>
                <p style="font-size:18px;text-align:justify;">
                    We offer practical training and workshops for institutions, empowering the next generation of agricultural experts.
                </p>
            </h2>
        </div><!-- .custominfo -->                   
    </div><!-- #slidecaption3 -->
    
    <!-- Slide 4 -->
    <div id="slidecaption4" class="nivo-html-caption">
        <div class="custominfo" style="background-color:rgba(0,0,0,0.7);padding:20px;">
            <h2>
                <p style="font-size:18px;text-align:justify;">
                    We were honored by the visit of the Vice President of Uganda, Hon. Jessica Alupo, who recognized our impactful work in agriculture.
                </p>
            </h2>
        </div><!-- .custominfo -->                   
    </div><!-- #slidecaption4 -->
</div><!-- slider -->
<script type="text/javascript">
    $(window).load(function() {
    $('#slider').nivoSlider();
});

</script>
    <?php include('who_section.php'); ?>
    <?php include('what_section.php'); ?>
        <section style="background-color:#15B392;" id="section4" class="menu_page">
        <div class="container">
            <div class="section_title_container">
                <h2 class="section_title">
                    Recognized as Uganda’s Best Farmer in 2020, Gomba Farm stands as a symbol of excellence in agriculture. This prestigious honor reflects our unwavering commitment to high-quality farming practices, innovation, and sustainable development. Our success serves as an inspiration to farmers nationwide, motivating continuous improvement and a shared vision for a prosperous agricultural future.
                </h2>
            </div>
            <!-- .end section class -->  
            <div class="clear"></div>
        </div>
        <!-- container -->
    </section>
    <?php include('online_shop.php'); ?>
    <?php include('gallery_section.php'); ?>
        <section style="background-color:#15B392;" id="section4" class="menu_page">
        <div class="container">
            <div class="section_title_container">
                <h2 class="section_title">
                Gomba Farm is at the forefront of Uganda’s agricultural transformation, championing eco-friendly practices that protect the environment while boosting productivity. By adopting sustainable techniques and reducing waste, we pave the way for a greener, more resilient future in farming, benefiting both our communities and the planet.
                </h2>
            </div>
            <!-- .end section class -->  
            <div class="clear"></div>
        </div>
        <!-- container -->
    </section>
    <?php include('success_section.php'); ?> 
    <div class="training-institute-row">
    <div class="overlay"></div>
    <div class="container">
        <div class="row">
            <!-- Single Column Content -->
            <div class="col-12">
                <h2 style="text-align:left;">Training Institute</h2>
                <p>Gomba Next Generation Farm Institute</p>

                <h3 style="text-align:left;">Why Choose Us?</h3>
                <ul style="text-align:left;">
                    <li>Hands-On Learning</li>
                    <li>Expert Guidance</li>
                    <li>Modern Methods</li>
                </ul>

                <h3 style="text-align:left;">Our Programmes</h3>
                <ul style="text-align:left;">
                    <li>Professional Agriculture Training</li>
                    <li>Entrepreneurship Development</li>
                    <li>Sustainability Practices</li>
                </ul>

                <h3 style="text-align:left;">Who Can Join?</h3>
                <p>Our programmes are open to individuals of all skill levels – from beginners to experienced farmers.</p>
            </div>
        </div>
    </div>
</div>
<style type="text/css">
    /* Background image for the row */
.training-institute-row {
    background-image: url('images/back.jpg');
    background-size: cover;
    background-position: center;
    padding: 60px 0;
    color: #fff;
    position: relative;
    overflow: hidden; /* Ensures content fits neatly within the container */
    height: auto;
    z-index: 1; /* Ensure text stays on top of background */
}

/* Add a semi-transparent overlay to darken the background */
.overlay {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background-color: rgba(0, 0, 0, 0.5); /* Adjust transparency */
    z-index: 0; /* Make sure overlay is below text */
}

/* Container and row setup */
.container {
    max-width: 1200px;
    margin: 0 auto;
    position: relative;
    z-index: 2; /* Ensure the text stays on top of the overlay */
}

.row {
    display: flex;
    flex-direction: column; /* Stack content in one column */
    justify-content: flex-start;
    align-items: center;
}

/* Single column layout */
.col-12 {
    width: 100%;
    padding: 20px;
    box-sizing: border-box;
    text-align: center;
}

/* Optional styling for headings and text */
h2, h3 {
    font-size: 24px;
    font-weight: bold;
    margin-bottom: 15px;
    text-shadow: 1px 1px 3px rgba(0, 0, 0, 0.8); /* Optional: add shadow for readability */
}

ul {
    list-style: none;
    padding: 0;
}

ul li {
    font-size: 18px;
    margin-bottom: 10px;
}

/* Make sure the content area is scrollable if it's too long */
.training-institute-row {
    overflow-y: auto;
}

/* Responsive layout */
@media (max-width: 768px) {
    .col-12 {
        padding: 10px;
    }
}

@media (max-width: 480px) {
    .col-12 {
        padding: 5px;
    }
}

</style>
    <?php include('goals_section.php'); ?> 
    <section style="background-color:#15B392;" id="section4" class="menu_page">
        <div class="container">
            <div class="section_title_container">
                <h2 class="section_title">
                    At Gomba Farm, we believe in setting new standards in the agricultural sector. By integrating quality, innovation, and sustainability into every aspect of our work, we ensure that our practices not only benefit the present but also safeguard the future. From cutting-edge techniques to community-focused initiatives, Gomba Farm leads the way in transforming Ugandan agriculture.
                </h2>
            </div>
            <!-- .end section class -->  
            <div class="clear"></div>
        </div>
        <!-- container -->
    </section>
    <?php include('why_section.php'); ?>
    <?php include('in_touch_section.php'); ?>
        <section style="background-color:#15B392;" id="section4" class="menu_page">
        <div class="container">
            <div class="section_title_container">
                <h2 class="section_title">
                    Our work at Gomba Farm goes beyond farming—it’s about empowering communities and fostering growth. By creating jobs, supporting local initiatives, and investing in education, we help secure a brighter future for rural Uganda. Together, we cultivate more than crops; we cultivate hope and opportunity.
                </h2>
            </div>
            <!-- .end section class -->  
            <div class="clear"></div>
        </div>
        <!-- container -->
    </section>
    <?php include('statistics_section.php'); ?>
<?php include('templates/foot.php');?>
