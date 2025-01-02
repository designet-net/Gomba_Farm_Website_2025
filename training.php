<?php
    session_start();
    $_SESSION['CURRENT_PAGE'] = 'TRIA';
?>
<?php 
    include('templates/headings.php');
    include('conn.php');
?>
<section id="pagearea">
    <!-- Hero Section -->
    <section style="background-color:#f3f3f3;">
       <div class="container">
          <div>
             <img src="images/slider3.jpg" alt="slider3" style="width: 100%; border-radius: 8px;" />
             <h6 style="text-align:center;">
                 Through hands-on training, mentorship, and exposure to advanced farming methods, we empower the next generation to lead the agricultural sector with confidence and expertise.
             </h6>
          </div>
       </div>
    </section>

    <!-- About Section -->
    <section style="background-color:#15B392;" id="section4" class="menu_page">
        <div class="container">
            <div>
                <h1 style="color: #fff; text-align: center;">Shaping Tomorrow's Agricultural Professionals</h1>
                <h2 class="section_title" style="color: #e8e8e8; text-align: center;">At Gomba Next Generation Farm Institute, we are committed to nurturing the next generation of skilled agricultural professionals and entrepreneurs.</h2>
            </div>
        </div>
    </section>

    <!-- Content Section -->
    <div class="container">
        <div class="two-column-row">
            <!-- Box 1 -->
            <div class="column box-content">
                <img src="images/farm14.jpg" alt="next12" style="width: 100%; border-radius: 8px;" />
            </div>

            <!-- Box 2 -->
            <div class="column box-content">
                <h3 style="text-align:left;">Modern Institution Based on Training with Production</h3>
                <p>
                    At Gomba Model Farm, we believe that the best way to learn is through practical, hands-on experience. Our farm operates as both a training ground and a working farm, offering students an opportunity to work with modern farming equipment, livestock, and cutting-edge farming technologies. By applying what they learn in the classroom to real-world situations, students gain valuable insights and experience to prepare them for successful careers in agriculture.
                </p>
            </div>

            <!-- Box 3 -->            
            <div class="column box-content">
                <h3 style="text-align:left;">Shaping Tomorrow's Agricultural Professionals</h3>
                <p>
                    Located in the heart of Gomba District, our institute provides youth with hands-on experience, knowledge, and practical skills necessary for success in modern agriculture and animal production. Our goal is to make agriculture a rewarding and sustainable career choice for youth, promoting long-term income-generation and empowering communities.
                </p>
            </div>
        </div>
    </div>

    <!-- Courses Section -->
    <section style="background-color:#f9f9f9; padding: 30px 0;">
        <div class="container">
            <div class="column box-content">
                <h2 style="color:green;">Courses Offered</h2>
                <p>
                    We offer a range of training courses designed to equip youth with technical and vocational skills for a successful career in agriculture. Tailored to local conditions, our courses include National Diploma Courses (NDC), National Certificate Programmes (NCP), Community Polytechnic Certificate (CPC), and DIT Courses, covering digital and technical skills to drive innovation in agriculture.
                </p>
            </div>
        </div>
    </section>

    <!-- Registration Section -->
    <section style="background-color:#15B392; padding: 30px 0;">
        <div class="container">
            <div>
                <h2 style="color: #fff; text-align: center;">Student Registration</h2>
                <p style="color: #e8e8e8; text-align: center;">Join us to begin your journey toward a rewarding career in agriculture. Fill in the form below to register for our training programs.</p>
                <form action="register.php" method="post" style="max-width: 600px; margin: 0 auto; background: #fff; padding: 20px; border-radius: 8px;">
                    <div style="margin-bottom: 15px;">
                        <label for="name" style="font-weight: bold;">Full Name</label>
                        <input type="text" id="name" name="name" required style="width: 100%; padding: 10px; border-radius: 4px; border: 1px solid #ccc;">
                    </div>
                    <div style="margin-bottom: 15px;">
                        <label for="email" style="font-weight: bold;">Email Address</label>
                        <input type="email" id="email" name="email" required style="width: 100%; padding: 10px; border-radius: 4px; border: 1px solid #ccc;">
                    </div>
                    <div style="margin-bottom: 15px;">
                        <label for="phone" style="font-weight: bold;">Phone Number</label>
                        <input type="text" id="phone" name="phone" required style="width: 100%; padding: 10px; border-radius: 4px; border: 1px solid #ccc;">
                    </div>
                    <div style="margin-bottom: 15px;">
                        <label for="course" style="font-weight: bold;">Select Course</label>
                        <select id="course" name="course" required style="width: 100%; padding: 10px; border-radius: 4px; border: 1px solid #ccc;">
                            <option value="">-- Select a Course --</option>
                            <option value="NDC">National Diploma Course</option>
                            <option value="NCP">National Certificate Programme</option>
                            <option value="CPC">Community Polytechnic Certificate</option>
                            <option value="DIT">DIT Course</option>
                        </select>
                    </div>
                    <div style="text-align: center;">
                        <button type="submit" style="background-color: #15B392; color: #fff; padding: 10px 20px; border: none; border-radius: 4px; cursor: pointer;">Register Now</button>
                    </div>
                </form>
            </div>
        </div>
    </section>
</section>

<?php include('templates/foot.php'); ?>
