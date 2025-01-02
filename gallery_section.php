<section id="pagearea" style="background-color:#f3f3f3;">
    <div class="container1">
        <div class="full-width-row">
            <div class="content">
                <h2>Explore Our Diverse Projects</h2>
                    <p>
                        
                        Discover the range of projects we’ve undertaken, showcasing our commitment to innovation, sustainability, and agricultural excellence. Browse our gallery to see the impact of our work and the transformative solutions we've implemented in the farming industry.
                    </p>
            </div>
        </div>
        <style type="text/css">
            /* Basic Reset and General Styles */
            * {
                margin: 0;
                padding: 0;
                box-sizing: border-box;
            }

            .container1 {
                width: 100%;
                max-width: 1200px;
                margin: 0 auto;
                padding: 20px;
            }

            /* Gallery Grid Setup */
            .row-wrapper {
                display: grid;
                grid-template-columns: repeat(auto-fill, minmax(280px, 1fr)); /* Responsive grid */
                gap: 20px;
                padding: 20px;
            }

            /* Individual Box Styling */
            .box-content {
                background-color: #fff;
                border-radius: 10px;
                overflow: hidden;
                box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
                text-align: center;
                transition: transform 0.3s ease, box-shadow 0.3s ease;
                display: flex;
                flex-direction: column;
                align-items: center;
                justify-content: space-between;
                padding: 15px;
            }

            /* Image Styling */
            .box-image {
                width: 100%;
                height: auto;
                object-fit: cover;
                border-radius: 8px;
                transition: transform 0.3s ease;
            }

            /* Title Styling */
            .box-title {
                font-size: 1.2rem;
                font-weight: bold;
                margin-top: 10px;
                color: #333;
                font-family: 'Arial', sans-serif;
            }

            /* Description Styling */
            .box-description {
                font-size: 1rem;
                color: #666;
                margin-top: 10px;
                line-height: 1.5;
                font-family: 'Arial', sans-serif;
            }

            /* Hover Effects */
            .box-content:hover {
                transform: translateY(-5px); /* Lift the box slightly */
                box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1); /* Shadow effect */
            }

            /* Image Hover Effect */
            .box-content:hover .box-image {
                transform: scale(1.05); /* Zoom the image slightly */
            }

            /* Responsive Design */
            @media (max-width: 768px) {
                .row-wrapper {
                    grid-template-columns: 1fr; /* Stack boxes in a single column for small screens */
                }
            }

        </style>
        <!-- Second Row with Four Columns -->
       <div class="container1">
            <div class="row-wrapper">
            <!-- Box 1 -->
            <div class="box-content">
                <img src="images/gomba9.jpg" alt="next1" class="box-image">
                <h3 class="box-title">Fresh meat and eggs</h3>
            </div>

            <!-- Box 2 -->
            <div class="box-content">
                <img src="images/gomba8.jpg" alt="next2" class="box-image">
                <h3 class="box-title">Bee Keeping</h3>
                <p class="box-description">Farm Surplies</p>
            </div>

            <!-- Box 3 -->
            <div class="box-content">
                <img src="images/gomba6.jpg" alt="next4" class="box-image">
                <h3 class="box-title">Digital Campaigns</h3>
                <p class="box-description">Farm Surplies, Livestock</p>
            </div>

            <!-- Box 4 -->
            <div class="box-content">
                <img src="images/farm12.jpg" alt="next6" class="box-image">
                <h3 class="box-title">Organic Hay</h3>
                <p class="box-description">Animal Feeds, Farm Surplies</p>
            </div>

            <!-- Box 5 -->
            <div class="box-content">
                <img src="images/gomba10.jpg" alt="gomba22" class="box-image">
                <h3 class="box-title">Abundant Land</h3>
                <p class="box-description">Farm Surplies</p>
            </div>            
            </div>
        </div>


        <!-- Additional Rows Can Be Added Below -->

    </div>
</section>
