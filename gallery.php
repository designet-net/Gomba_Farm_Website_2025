<?php
   session_start();
   $_SESSION['CURRENT_PAGE'] = 'PORT';
?>
<?php 
   include('templates/headings.php');
   include('conn.php');
?>

<section style="background-color:#f3f3f3;">
   <div class="container">
      <div class="image-wrapper">
         <img src="images/slider10.jpg" alt="Gomba Farm Banner" style="width: 100%; height: auto; border-radius: 8px;" />
         <h6 style="text-align:center;">
            Our curriculum emphasizes innovative techniques, sustainable practices, and entrepreneurial strategies, tailored to meet the diverse needs of individuals passionate about transforming their agricultural ambitions into success. 
         </h6>
      </div>
      <div class="clear"></div>
   </div>
</section>

<section style="background-color:#15B392;" id="section4" class="menu_page">
   <div class="container">
      <div class="content-wrapper">
         <h2 class="section_title">
            Gomba Farm is more than just a farm—it’s a beacon of excellence in Ugandan agriculture. Our dedication to innovation, education, and eco-friendly practices sets us apart as a model for the industry. We strive to inspire others and contribute meaningfully to the growth and prosperity of our nation.
         </h2>
      </div>
      <div class="clear"></div>
   </div>
</section>

<section id="pagearea" style="background-color:#f3f3f3;">
   <div class="container">
      <div class="content">
         <h2>Explore Our Diverse Projects</h2>
         <p>
            Discover the range of projects we’ve undertaken, showcasing our commitment to innovation, sustainability, and agricultural excellence. Browse our gallery to see the impact of our work and the transformative solutions we've implemented in the farming industry.
         </p>
      </div>
   </div>

   <style type="text/css">
      /* Reset and General Styles */
      * {
         margin: 0;
         padding: 0;
         box-sizing: border-box;
      }

      .container {
         width: 100%;
         max-width: 1200px;
         margin: 0 auto;
         padding: 20px;
      }

      /* Gallery Grid */
      .row-wrapper {
         display: grid;
         grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
         gap: 20px;
         padding: 20px 0;
      }

      .box-content {
         background-color: #fff;
         border-radius: 10px;
         overflow: hidden;
         box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
         text-align: center;
         transition: transform 0.3s ease, box-shadow 0.3s ease;
         padding: 15px;
         display: flex;
         flex-direction: column;
         align-items: center;
      }

      .box-image {
         width: 100%;
         height: auto;
         object-fit: cover;
         border-radius: 8px;
         transition: transform 0.3s ease;
      }

      .box-title {
         font-size: 1.2rem;
         font-weight: bold;
         margin: 10px 0;
         color: #333;
         font-family: 'Arial', sans-serif;
      }

      .box-description {
         font-size: 1rem;
         color: #666;
         margin-top: 10px;
         line-height: 1.5;
         font-family: 'Arial', sans-serif;
      }

      .box-content:hover {
         transform: translateY(-5px);
         box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
      }

      .box-content:hover .box-image {
         transform: scale(1.05);
      }

      @media (max-width: 768px) {
         .row-wrapper {
            grid-template-columns: 1fr;
         }
      }
   </style>

   <div class="container">
      <div class="row-wrapper">
         <!-- Gallery Items -->
         <div class="box-content">
            <img src="images/gomba17.jpg" alt="Project Image" class="box-image">
         </div>

         <div class="box-content">
            <img src="images/gomba3.jpg" alt="Project Image" class="box-image">
         </div>

         <div class="box-content">
            <img src="images/next27.jpg" alt="Project Image" class="box-image">
         </div>

         <div class="box-content">
            <img src="images/gomba21.jpg" alt="Project Image" class="box-image">
         </div>

         <div class="box-content">
            <img src="images/old4.jpg" alt="Project Image" class="box-image">
         </div>

         <div class="box-content">
            <img src="images/next25.jpg" alt="Project Image" class="box-image">
         </div>
      </div>
   </div>
</section>

<?php include('templates/foot.php'); ?>
