

<section id="pagearea" style="background-color:#fff;">
    <div class="container1">
            <div class="two-column-row">
                <!-- Column 1 -->
                <div class="column">
                    <div class="box-content">
                        <img src="images/farm13.jpg" alt="gomba5" style="width: 100%;height:auto; border-radius: 8px;" />
                    </div>
                </div>


                <!-- Column 2 -->
                <div class="column">
                    <h2 style="color:green">Why choose us</h2>
                    <h1>Why Gomba Next Generation Model Farm is the Preferred Choice</h1>
                
                <!-- Accordion -->
                <div class="accordion">
                    <!-- Accordion Item 1 -->
                    <div class="accordion-item">
                        <button class="accordion-title">Best Organic Food Provider Since 2003</button>
                        <div class="accordion-content">
                            <p>Since 2003, we have been dedicated to providing the highest quality organic foods, grown sustainably and harvested with care. Our commitment to health, sustainability, and fresh produce has made us a trusted provider of organic food for over two decades.</p>
                        </div>
                    </div>
                    <!-- Accordion Item 2 -->
                    <div class="accordion-item">
                        <button class="accordion-title">Why Choose Our Products ?</button>
                        <div class="accordion-content">
                            <p>Our products stand out for their commitment to quality, sustainability, and innovation. We prioritize using modern farming practices to deliver fresh, healthy, and organic food that supports both local communities and the environment. Choose our products for their excellence, taste, and sustainable impact.</p>
                        </div>
                    </div>
                    <!-- Accordion Item 3 -->
                    <div class="accordion-item">
                        <button class="accordion-title">Organic Food and Biology Safe ?</button>
                        <div class="accordion-content">
                            <p>Our organic food products are grown using natural methods, free from harmful chemicals and pesticides. By focusing on sustainable farming practices, we ensure that our food is safe for both consumers and the environment, promoting biological safety and healthy ecosystems</p>
                        </div>
                    </div>
                    <!-- Accordion Item 4 -->
                    <div class="accordion-item">
                        <button class="accordion-title">How Much Sweet & Testy Our Foods ?</button>
                        <div class="accordion-content">
                            <p>Our foods are grown with care and attention to detail, ensuring natural sweetness and exceptional flavor in every bite. From our ripe bananas to fresh produce, each item is cultivated to deliver the finest taste, making every meal a delight.</p>
                        </div>
                    </div>
                </div>
                </div>
            </div>
    </div>
</section>

<style type="text/css">
    /* Basic Styles for Accordion */
    .accordion {
        margin-top: 20px;
    }

    /* Style for each accordion item */
    .accordion-item {
        margin-bottom: 10px;
    }

    /* Style for the accordion button (title) */
    .accordion-title {
        background-color: #f4f4f4;
        color: #333;
        padding: 15px;
        width: 100%;
        border: none;
        text-align: left;
        cursor: pointer;
        font-size: 1.2rem;
        font-weight: bold;
        border-radius: 8px;
        transition: background-color 0.3s ease;
    }

    /* Style when accordion button is hovered */
    .accordion-title:hover {
        background-color: #ddd;
    }

    /* Style for accordion content (hidden by default) */
    .accordion-content {
        padding: 15px;
        background-color: #f9f9f9;
        border: 1px solid #ddd;
        display: none; /* Initially hidden */
        border-radius: 8px;
    }

    /* Active state for opened accordion item */
    .accordion-title.active + .accordion-content {
        display: block;
    }
</style>
<script type="text/javascript">
    // Select all the accordion titles
    const accordionTitles = document.querySelectorAll('.accordion-title');

    // Loop through each accordion title to add event listeners
    accordionTitles.forEach(title => {
        title.addEventListener('click', function() {
            // Toggle the 'active' class for the clicked title
            this.classList.toggle('active');
            
            // Get the next element (accordion content)
            const content = this.nextElementSibling;
            
            // Toggle the display of the accordion content
            if (content.style.display === 'block') {
                content.style.display = 'none'; // Hide if already open
            } else {
                content.style.display = 'block'; // Show the content if clicked
            }
        });
    });
</script>