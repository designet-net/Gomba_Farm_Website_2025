<section id="pagearea" style="background-color:#f3f3f3;">
    <div class="container">
        <div class="full-width-row" style="background-color: #f3f3f3;">
            <div class="content">
                <h1>Sustainable Development Goals (SDGs)</h1>
                    <p>
                        Gomba Farm supports the Sustainable Development Goals by transforming communities through training individuals into skilled farmers, 
                        promoting sustainable agriculture, enhancing food security, reducing poverty, and fostering environmental conservation.
                    </p>
            </div>
        </div>

        <style type="text/css">
            /* Basic container styling */
            .slider-container {
                position: relative;
                width: 100%;
                overflow: hidden; /* Hide anything outside the container */
                margin: auto;
            }

            /* Slider styling */
            .slider {
                display: flex; /* Align items in a row */
                transition: transform 0.5s ease; /* Smooth transition for sliding effect */
            }

            /* Box content styling */
            .box-content1 {
                flex: 0 0 auto; /* Prevent boxes from shrinking */
                width: 300px; /* Set width of each item */
                margin-right: 20px; /* Space between items */
                text-align: center;
                padding: 15px;
                box-sizing: border-box;
                background-color: #fff;
            }

            /* Image styling */
            .box-image {
                width: 100%;
                height: auto;
                border-radius: 8px;
            }

            /* Image title and description styling */
            .image-title {
                font-size: 1.2rem;
                font-weight: bold;
                color: #333;
                margin-top: 15px;
            }

            .image-description {
                font-size: 1rem;
                color: #666;
                margin-top: 10px;
            }

            /* Arrow styling */
            .arrow {
                position: absolute;
                top: 50%;
                font-size: 2rem;
                color: #333;
                cursor: pointer;
                z-index: 10;
                padding: 10px;
                background-color: rgba(255, 255, 255, 0.5);
                border-radius: 50%;
                transition: background-color 0.3s;
            }

            .arrow:hover {
                background-color: rgba(0, 0, 0, 0.2);
            }

            .left-arrow {
                left: 10px;
                transform: translateY(-50%);
            }

            .right-arrow {
                right: 10px;
                transform: translateY(-50%);
            }

            /* Responsive Design */
            @media (max-width: 768px) {
                .box-content1 {
                    width: 100%; /* Make each box take full width on small screens */
                }
            }

        </style>
       <div class="slider-container">
            <div class="arrow left-arrow">&#10094;</div> <!-- Left Arrow -->
            <div class="slider">
                <!-- Box 1 -->
                <div class="box-content1">
                    <img src="images/farm1.jpg" alt="gomba9" class="box-image">
                    <h3 class="image-title">No Poverty</h3>
                    <p class="image-description">Poverty is a barrier to well-being, economic opportunities, and human rights.</p>
                </div>
                <!-- Box 2 -->
                <div class="box-content1">
                    <img src="images/farm2.jpg" alt="gomba25" class="box-image">
                    <h3 class="image-title">Zero Hunger</h3>
                    <p class="image-description">Achieving zero hunger means ensuring that everyone, everywhere has access to sufficient, nutritious food. </p>
                </div>
                <!-- Box 3 -->
                <div class="box-content1">
                    <img src="images/farm3.jpg" alt="next20" class="box-image">
                    <h3 class="image-title">Quality Education</h3>
                    <p class="image-description">Quality education is essential for empowerment and long-term prosperity. </p>
                </div>
                <!-- Box 4 -->
                <div class="box-content1">
                    <img src="images/farm4.jpg" alt="next3" class="box-image">
                    <h3 class="image-title">Gender Equality</h3>
                    <p class="image-description">Gender equality ensures that everyone, regardless of gender, has equal opportunities to thrive. </p>
                </div>
                <!-- Box 6 -->
                <div class="box-content1">
                    <img src="images/farm6.jpg" alt="gomba8" class="box-image">
                    <h3 class="image-title">Industry, Innovation, and Infrastructure</h3>
                    <p class="image-description">This goal focuses on building resilient infrastructure, promoting sustainable industrialization. </p>
                </div>
                <!-- Box 5 -->
                <div class="box-content1">
                    <img src="images/farm7.jpg" alt="gomba17" class="box-image">
                    <h3 class="image-title">Reduced Inequalities</h3>
                    <p class="image-description">Reduced inequalities involve addressing disparities in income, opportunity, and access to resources.</p>
                </div>
                <!-- Box 5 -->
                <div class="box-content1">
                    <img src="images/farm8.jpg" alt="gomba17" class="box-image">
                    <h3 class="image-title">Responsible Consumption and Production</h3>
                    <p class="image-description">We offer affordable training on responsible consumption to help manage resources efficiently and reduce waste.</p>
                </div>
                <!-- Box 5 -->                
                <div class="box-content1">
                    <img src="images/farm9.jpg" alt="gomba17" class="box-image">
                    <h3 class="image-title">Climate Action</h3>
                    <p class="image-description">We combat climate change by increasing carbon units through tree planting and carbon-smart farming.</p>
                </div>              
            </div>
            <div class="arrow right-arrow">&#10095;</div> <!-- Right Arrow -->
        </div>


        <script type="text/javascript">
            // Select all elements
            const leftArrow = document.querySelector('.left-arrow');
            const rightArrow = document.querySelector('.right-arrow');
            const slider = document.querySelector('.slider');
            const boxContents = document.querySelectorAll('.box-content1'); // Get all box content items

            // Initialize a variable to keep track of the current slide position
            let currentPosition = 0;
            const totalSlides = boxContents.length;
            const slideWidth = document.querySelector('.box-content1').offsetWidth + 20; // Width of a box including margin

            // Function to slide left
            leftArrow.addEventListener('click', () => {
                if (currentPosition > 0) {
                    currentPosition--; // Decrease position
                    slider.style.transform = `translateX(-${currentPosition * slideWidth}px)`; // Move slider
                }
            });

            // Function to slide right
            rightArrow.addEventListener('click', () => {
                // Prevent moving past the last item
                if (currentPosition < totalSlides - 1) {
                    currentPosition++; // Increase position
                    slider.style.transform = `translateX(-${currentPosition * slideWidth}px)`; // Move slider
                }
            });

        </script>



        <!-- Additional Rows Can Be Added Below -->

    </div>
</section>
