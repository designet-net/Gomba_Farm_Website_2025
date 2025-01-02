<section id="pagearea" style="background-color:#f3f3f3;">
    <div class="container1">
        <div class="full-width-row">
            <div class="content">
                <h1 style="color:green">Featured Products</h1>
                <p>
                    Premium Agricultural Products: <br>Our farm offers a rich array of premium agricultural products, grown and managed to meet the highest quality and sustainability standards. Our crop production features robust staples like maize grain, along with organic bananas, coffee, and cocoa, ensuring a diverse supply for local and export markets. In livestock, we provide top-quality beef, dairy, and improved breeds of cattle, goats, and sheep. Our poultry sector delivers high-quality poultry products and improved breeds, while our aquaculture operations yield fresh, sustainably farmed fish. We also produce essential animal feeds, including hay and silage, supporting resilient agricultural practices across Uganda.
                </p>
                <h4 style="text-align:left;">Products include:</h4>
                <ul style="text-align:left;">
                    <li>Fresh bananas</li>
                    <li>Eggs</li>
                    <li>Fresh maize</li>
                    <li>Milk and dairy products</li>
                    <li>Vegetables</li>
                    <li>Live pigs for breeding</li>
                </ul>

            </div>
        </div>

        <style type="text/css">
            /* Basic Reset */
            * {
                margin: 0;
                padding: 0;
                box-sizing: border-box;
            }

            /* Container styles */
            .shop-cart {
                display: grid;
                grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
                gap: 20px;
                padding: 20px;
                max-width: 1200px;
                margin: 0 auto;
            }

            /* Box Content Styling */
            .box-content {
                position: relative; /* To position the text above the image */
                background-color: #fff;
                border-radius: 12px;
                overflow: hidden;
                box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
                text-align: center;
                padding: 20px;
                transition: transform 0.3s ease, box-shadow 0.3s ease;
            }

            /* Image Styling */
            .box-content img {
                width: 100%;
                height: auto;
                object-fit: cover;
                transition: transform 0.3s ease; /* Smooth transition on hover */
            }

            /* Text Overlay */
            .text-overlay {
                position: absolute;
                top: 40%;
                left: 50%;
                transform: translateX(-50%);
                width: 100%;
                text-align: center;
                color: #fff;
                padding: 10px;
                z-index: 10; /* Keep text on top */
            }

            /* Title Styling */
            .image-title {
                font-size: 1.5rem;
                font-weight: bold;
                color: #fff;
                margin-bottom: 10px;
                font-family: 'Arial', sans-serif;
                text-align:center;
                background-color: #fff;
                width:100%;
            }

            /* Description Styling */
            .image-description {
                font-size: 1rem;
                color: #fff;
                margin-bottom: 15px;
                line-height: 1.6;
                font-family: 'Arial', sans-serif;
            }

            /* Button Styling */
            .green-button {
                display: inline-block;
                padding: 10px 20px;
                background-color: #28a745;
                color: #fff;
                text-decoration: none;
                border-radius: 5px;
                font-weight: bold;
                transition: background-color 0.3s ease;
            }

            /* Button Hover Effect */
            .green-button:hover {
                background-color: #218838;
            }

            /* Box Hover Effect */
            .box-content:hover {
                transform: translateY(-5px);
                box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
            }

            /* Image Hover Effect: Move image slightly on hover */
            .box-content:hover img {
                transform: scale(1.05); /* Slightly zoom in the image */
            }

            /* Responsive Design for smaller screens */
            @media (max-width: 768px) {
                .shop-cart {
                    grid-template-columns: 1fr; /* All items span the full width of the row */
                }
            }

            @media (max-width: 480px) {
                .shop-cart {
                    grid-template-columns: 1fr; /* All items span the full width of the row */
                }
            }


        </style>



        <!-- Additional Rows Can Be Added Below -->

    </div>
</section>
