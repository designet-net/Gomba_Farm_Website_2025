<?php
   session_start();
   $_SESSION['CURRENT_PAGE'] = 'SERV';
?>
<?php 
   include('templates/headings.php');
   include('conn.php');
?>
<section id="pagearea">
   <section style="background-color: #f3f3f3;">
       <div class="container">
          <div class="image-container">
            <img src="images/slider5.jpg" alt="slider5" class="responsive-img" style="border-radius: 8px;" />
            <h6 style="text-align:center;">
               We host workshops that bring together diverse groups, including schools, farmers, and agricultural enthusiasts, to learn and share knowledge.
            </h6>
          </div>
       </div>
    </section>
   <section style="background-color: #15B392;" id="section4" class="menu_page">
      <div class="container">
         <div class="content-section">
            <h2 class="section-title">
               Our farm services are designed to meet diverse agricultural needs with a commitment to quality and sustainability. We specialize in maize milling, organic banana cultivation, and advanced livestock breeding using cutting-edge techniques.
            </h2>
         </div>
      </div>
   </section>
   <div class="container">
      <div class="row" style="margin-top: 20px;">
         <!-- Box 2 -->
         <div class="column box-content">
            <h1 style="color: #008000;">What We Provide For Your Better Health</h1>
            <p>
               At Gomba Next Generation Farm, we provide a wide range of agricultural services to support sustainable growth and quality production. From high-grade maize and banana crop cultivation to livestock breeding and feed production, we deliver reliable, premium agricultural solutions. Our offerings also include guided farm tours and educational programs for hands-on learning experiences.
            </p>
         </div>
      </div>
   </div>
   <div class="container">
      <div class="two-column-row">
         <div class="column box-content">
            <h3 style="color: #a65418;">Fresh Banana</h3>
            <img src="images/next28.jpg" alt="gomba16" class="responsive-img" style="border-radius: 8px;" />
         </div>
         <div class="column box-content">
            <h3 style="color: #a65418;">Piggery Farming</h3>
            <img src="images/gomba13.jpg" alt="gomba13" class="responsive-img" style="border-radius: 8px;" />
         </div>
         <div class="column box-content">
            <h3 style="color: #a65418;">Livestock Cattle</h3>
            <img src="images/gomba19.jpg" alt="gomba19" class="responsive-img" style="border-radius: 8px;" />
         </div>
         <div class="column box-content">
            <h3 style="color: #a65418;">Maize Products</h3>
            <img src="images/gomba21.jpg" alt="gomba21" class="responsive-img" style="border-radius: 8px;" />
         </div>
         <div class="column box-content">
            <h3 style="color: #a65418;">Poultry Feeds Products</h3>
            <img src="images/gomba20.jpg" alt="gomba20" class="responsive-img" style="border-radius: 8px;" />
         </div>
         <div class="column box-content">
            <h3 style="color: #a65418;">Fresh Organic Vegetables</h3>
            <img src="images/next10.jpg" alt="next" class="responsive-img" style="border-radius: 8px;" />
         </div>
      </div>
   </div>
   <div class="container">
      <div class="row" style="margin-top: 20px;">
         <div class="column box-content">
            <h1>Trusted Organic Food Providing Company</h1>
            <p>
               At Gomba Next Generation Farm, we provide a wide range of agricultural services to support sustainable growth and quality production. From high-grade maize and banana crop cultivation to livestock breeding and feed production, we deliver reliable, premium agricultural solutions. Our offerings also include guided farm tours and educational programs for hands-on learning experiences.
            </p>
         </div>
      </div>
   </div>
</section>
<?php include('templates/foot.php'); ?>
