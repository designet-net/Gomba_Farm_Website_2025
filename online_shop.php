<section id="pagearea" style="background-color:#fff">   
    <div class="container">
        <div class="full-width-row" style="background-color: #fff;">
            <div class="content">
                <h1 style="color:green;">Online Shop</h1>
                <p>At Gomba Next Generation Farm, we grow more than just crops – we grow connections. Enjoy the same farm-fresh quality you love, now available online!</p>
                <p>Whether it’s our organic produce, farm-raised goods, or handmade treats, you can shop conveniently from the comfort of your home. We deliver the taste of the countryside right to your doorstep, ensuring freshness and quality in every order.</p>
                <p>Browse our selection and experience the best of the farm – anytime, anywhere.</p>
            </div>
        </div>

        <style type="text/css">
            * {
                margin: 0;
                padding: 0;
                box-sizing: border-box;
            }

            .product-row {
                display: grid;
                grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
                gap: 20px;
                padding: 20px;
                max-width: 1200px;
                margin: 0 auto;
            }

            .product-item {
                position: relative;
                background-color: #fff;
                border-radius: 12px;
                overflow: hidden;
                box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
                text-align: center;
                padding: 20px;
                transition: transform 0.3s ease, box-shadow 0.3s ease;
                display: flex;
                flex-direction: column;
                justify-content: space-between;
            }

            .product-image {
                width: 100%;
                height: auto;
                object-fit: cover;
                border-radius: 8px;
                transition: transform 0.3s ease;
            }

            .product-title {
                font-size: 1.2rem;
                font-weight: bold;
                margin-top: 15px;
                font-family: 'Arial', sans-serif;
                color: #333;
            }

            .product-description {
                font-size: 1rem;
                color: #666;
                margin-top: 10px;
                line-height: 1.5;
                font-family: 'Arial', sans-serif;
            }

            .add-to-cart-btn {
                background-color: #28a745;
                color: #fff;
                padding: 10px 20px;
                border: none;
                border-radius: 5px;
                cursor: pointer;
                font-weight: bold;
                margin-top: 15px;
                transition: background-color 0.3s ease;
            }

            .add-to-cart-btn:hover {
                background-color: #218838;
            }

            .product-item:hover {
                transform: translateY(-5px);
                box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
            }

            .product-item:hover .product-image {
                transform: scale(1.05);
            }

            @media (max-width: 768px) {
                .product-row {
                    grid-template-columns: 1fr;
                }
            }
        </style>

        <div class="product-row">
            <div class="product-item">
                <img src="images/gomba4.jpg" alt="gomba6" class="product-image">
                <h3 class="product-title">Organic Food - Chickens</h3>
                <p class="product-description">UGX 17,000</p>
                <button class="add-to-cart-btn" onclick="addToCart('Chickens', 17000)">Add to Cart</button>
            </div>
            <div class="product-item">
                <img src="images/gomba7.jpg" alt="gomba22" class="product-image">
                <h3 class="product-title">Organic Food - Cattle</h3>
                <p class="product-description">UGX 1,000,000</p>
                <button class="add-to-cart-btn" onclick="addToCart('Cattle', 1000000)">Add to Cart</button>
            </div>            
            <div class="product-item">
                <img src="images/gomba3.jpg" alt="gomba3" class="product-image">
                <h3 class="product-title">Health - Pigs</h3>
                <p class="product-description">UGX 200,000</p>
                <button class="add-to-cart-btn" onclick="addToCart('Pigs', 200000)">Add to Cart</button>
            </div>
            <div class="product-item">
                <img src="images/gomba5.jpg" alt="gomba19" class="product-image">
                <h3 class="product-title">Fresh Organic - Milk</h3>
                <p class="product-description">UGX 2,000</p>
                <button class="add-to-cart-btn" onclick="addToCart('Milk', 2000)">Add to Cart</button>
            </div>            
        </div>

        <div style="text-align: center; margin-top: 20px;">
            <button class="add-to-cart-btn" onclick="checkout()">Checkout on WhatsApp</button>
        </div>

        <script>
            let cart = [];

            function addToCart(product, price) {
                cart.push({ product, price });
                alert(product + ' has been added to your cart!');
            }

            function checkout() {
                if (cart.length === 0) {
                    alert('Your cart is empty!');
                    return;
                }

                let message = 'Hello, I would like to place an order:\n\n';
                let total = 0;
                cart.forEach(item => {
                    message += `- ${item.product}: UGX ${item.price}\n`;
                    total += item.price;
                });

                message += `\nTotal: UGX ${total}`;
                
                const whatsappNumber = '+256752411559'; // Replace with your WhatsApp number
                const whatsappURL = `https://wa.me/${whatsappNumber}?text=${encodeURIComponent(message)}`;
                window.open(whatsappURL, '_blank');
            }
        </script>

    </div>
</section>
