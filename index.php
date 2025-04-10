<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LeFestin - Home</title>
    <!-- css -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <!-- stylesheet -->
    <link rel="stylesheet" href="frontend/index.css">
    <!-- font -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Poppins&display=swap">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Princess+Sofia&display=swap">
    <!-- icons -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
</head>
<body>
    <div id="index">
        <!--header-->
        <header class="header">
            <a href="#" class="logo">LeFestin</a>
            <nav class="navbar">
                <a href="#">Home</a>
                <a href="#category">Category</a>
                <a href="#menu">Menu</a>
                <a href="frontend/about.php">About</a>
                <a href="frontend/newsletter.php">Newsletter</a>
                <?php
                session_start();
                if (isset($_SESSION['user_id'])) {
                    echo '<a href="frontend/user_information.php">Account</a>';
                }
                ?>
            </nav>
            <div class="icons">
                <div class="menu-btn" id="menu-btn"><span class="material-symbols-outlined">menu</span></div>
                <?php
                if (isset($_SESSION['user_id'])) {
                    echo '<a @click="fav"><div class="favorite-btn" id="favorite-btn"><span class="material-symbols-outlined">favorite</span></div></a>';
                    echo '<a @click="logout($event)"><div class="out-btn"><span class="material-symbols-outlined">sensor_door</span></div></a>';
                    echo '<div class="cart-btn" id="cart-btn" @click="cart"><span class="material-symbols-outlined">local_mall</span></div>';
                } else {
                    echo '<a @click="log"><div class="account-btn" id="account-btn"><span class="material-symbols-outlined">account_circle</span></a>';
                }
                ?>
                
            </div>
            <!--fav-->
            <div class="fav" :class="{ active: favActive }">
                <hr>
                <h1 class="my-fav">My Favorite</h1>
                <hr>
                <h1 class="to-cart" v-if="favItems.length > 0">do you want to add those to shopping cart?</h1>
                <hr v-if="favItems.length > 0">
                <div class="fav-items">
                    <p class="fav-message" v-if="favItems.length === 0">n o n e</p>
                    <div class="box" v-for="(item, index) in favItems" :key="index">
                        <span class="material-symbols-outlined" @click="removeFavItem(index)">close</span>
                        <span class="material-symbols-outlined" @click="addToCartFromFav(item, index)">done</span>
                        <img :src="'img/' + item.image + '.png'" :alt="item.name">
                        <div class="content">
                            <h1>{{ item.name }}</h1>
                        </div>
                    </div>
                </div>
            </div>
            <!--Login-->
            <form action="backend/log_sys.php" method="POST" class="log-form" :class="{ active: logActive }">
                <h1>Login</h1>
                <hr>
                <input type="email" name="email" class="log-box" id="loginEmail" name="email" placeholder="email" required>
                <input type="password" name="password" class="log-box" id="loginPassword" name="password" placeholder="password" required>
                <hr>
                <p>don't have an account? <a class="log" @click="reg">create here</a></p>
                <hr>
                <input type="submit" name="submit" class="btn" value="login now">
                <div id="errorMessage" class="error-message mt-3 text-center">
                    <?php
                        if(isset($_GET['error'])) {
                            if($_GET['error'] == 'notfound') {
                                echo '<p style="color:#AA0000;">- account is not found -</p>';
                            } elseif($_GET['error'] == 'incorrect') {
                                echo '<p style="color:#AA0000;">- incorrect password -</p>';
                            }
                        }
                    ?>
                </div>
            </form>
            <!--Register-->
            <form action="backend/reg_sys.php" method="POST" class="reg-form" :class="{ active: regActive }">
                <h1>Register</h1>
                <hr>
                <div class="name-field">
                    <input type="text" name="firstname" id="firstname" class="reg-box" placeholder="firstname" required>
                    <input type="text" name="lastname" id="lastname" class="reg-box" placeholder="lastname" required>
                </div>
                <div class="info-field">
                    <input type="date" name="dob" class="reg-box" required>
                    <input type="tel" name="phone" class="reg-box" placeholder="phone" required>
                </div>
                <input type="email" name="email" class="reg-box" placeholder="email" required>
                <input type="password" name="password" class="reg-box" placeholder="password" required>
                <hr>
                <p>have an account? <a class="reg" @click="log">login here</a></p>
                <hr>
                <input type="submit" name="submit" class="btn" value="signup now">
            </form>
            <!--Cart-->
            <div class="cart" :class="{ active: cartActive }">
                <hr>
                <h1 class="my-cart">My Cart</h1>
                <hr>
                <div class="cart-items">
                    <p class="cart-message" v-if="cartItems.length === 0">n o n e</p>
                    <div class="box" v-for="(item, index) in cartItems" :key="index">
                        <span class="material-symbols-outlined" @click="removeCartItem(index)">close</span>
                        <img :src="'img/' + item.image + '.png'" :alt="item.name">
                        <div class="content">
                            <h1>{{ item.name }}</h1>
                            <div class="wrapper">
                                <span class="price">{{ item.price }} ฿</span>
                                <div class="btn" @click="decreCartItem(index)"><span class="material-symbols-outlined">remove</span></div>
                                <span class="quantity">{{ item.quantity }}</span>
                                <div class="btn" @click="increCartItem(index)"><span class="material-symbols-outlined">add</span></div>
                            </div>
                        </div>
                    </div>
                </div>
                <hr>
                <div class="total">Total: {{ getTotalPrice }} ฿</div>
                <?php
                if (isset($_SESSION['user_id'])) {
                    echo '<a class="btn" @click="checkout">checkout</a>';
                } else {
                    echo '<a class="btn" @click="log">checkout</a>';
                }
                ?>
            </div>
            <!--Check Out-->
            <div class="overlay" v-if="checkoutActive" @click="closeCheckout"></div>
            <div class="checkout" :class="{ active: checkoutActive && !checkoutCompleted }">
                <span class="material-symbols-outlined close-btn" @click="closeCheckoutPopup">close</span>
                <hr>
                <h1 class="my-checkout">My Cart ({{ totalItemCount }} items)</h1>
                <hr>
                <div class="checkout-items">
                    <div class="box" v-for="(item, index) in cartItems" :key="index">
                        <span class="material-symbols-outlined" @click="removeCartItemFromCheckout(index)">close</span>
                        <img :src="'img/' + item.image + '.png'" :alt="item.name">
                        <div class="content">
                            <h1>{{ item.name }}</h1>
                            <div class="wrapper">
                                <span class="price">{{ item.price }} ฿</span>
                                <div class="btn" @click="decreCartItemFromCheckout(index)"><span class="material-symbols-outlined">remove</span></div>
                                <span class="quantity">{{ item.quantity }}</span>
                                <div class="btn" @click.stop="increCartItemFromCheckout(index)"><span class="material-symbols-outlined">add</span></div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Special Request Section -->
                <div class="special-request-section">
                    <h2>special request</h2>
                    <textarea class="special-request-textarea" placeholder="please provide any food allergies, dietary restrictions, or specific instructions you have"></textarea>
                </div>
                <hr>
                <div class="total">Total: {{ getTotalPrice }} ฿</div>
                <button class="checkout-btn" @click="openPaymentForm">confirm checkout</button>
            </div>
            <!-- Payment Form Popup -->
            <div class="overlay" v-if="paymentFormActive" @click="closePaymentForm"></div>
            <div class="payment-form" :class="{ active: paymentFormActive && !checkoutCompleted }">
                <span class="material-symbols-outlined close-btn" @click="closePaymentFormPopup">close</span>
                <form @submit.prevent="processPaymentAndAddress">
                    <span class="material-symbols-outlined back-btn" @click="backToCheckout">west</span>
                    <hr>
                    <h1>Payment</h1>
                    <hr>
                    <div class="form-row">
                        <div class="input-wrapper">
                            <input type="text" v-model="paymentDetails.cardholderName" placeholder="NAME" required>
                        </div>
                        <div class="input-wrapper card-number-wrapper">
                            <input type="text" v-model="paymentDetails.cardNumber" placeholder="CARD NUMBER" required>
                            <img src="img/mastercard_logo.png" alt="Mastercard Logo" v-if="isMastercard(paymentDetails.cardNumber)" class="card-logo">
                            <img src="img/visa_logo.png" alt="Visa Logo" v-if="isVisa(paymentDetails.cardNumber)" class="card-logo">
                        </div>
                    </div>
                    <div class="form-row">
                        <input type="text" v-model="expiryDate" placeholder="EXPIRY DATE (MM/YY)" required @input="autoFormatExpiryDate">
                        <input type="text" v-model="paymentDetails.cvv" placeholder="CVV" required @input="autoFormatCVV">
                    </div>
                    <hr>
                    <h1>Location</h1>
                    <hr>
                    <div id="map" style="height: 230px; width: 100%;"></div><br>
                    <button class="checkout-btn">confirm payment</button>
                </form>
            </div>
        </header>
        <section class="home" id="home">
            <div class="content">
                <h1>what are you craving?</h1>
                <p>discover mouthwatering homecooked meals delivered fresh to frontdoor<br>bringing comfort and satisfaction into every mouthful</p>
                <a href="#category" class="btn">order now</a>
            </div>
        </section>
        <!-- Category -->
        <section class="category" id="category">
            <nav class="navbar">
                <div class="nav-item">
                    <a href="#" @click="selectCategory('entree')">
                        <img src="img/ent/ent01.png" alt="entree" class="nav-img">
                        <span>Entree</span>
                    </a>
                </div>
                <div class="nav-item">
                    <a href="#" @click="selectCategory('pastry')">
                        <img src="img/pas/pas14.png" alt="pastry" class="nav-img">
                        <span>Pastry</span>
                    </a>
                </div>
                <div class="nav-item">
                    <a href="#" @click="selectCategory('dessert')">
                        <img src="img/des/des06.png" alt="dessert" class="nav-img">
                        <span>Dessert</span>
                    </a>
                </div>
            </nav>
        </section>
        <!-- Menu -->
        <section class="menu" id="menu">
        <div class="box" v-for="(menuitem, index) in filteredMenuItems" :key="index">
                <img :src="'img/' + menuitem.image + '.png'" :alt="menuitem.name">
                <div class="wrapper">
                    <h1>{{ menuitem.name }}</h1>
                    <div class="price">{{ menuitem.price }} ฿</div>
                </div>
                <div class="favorite-btn" @click="addToFav(menuitem)"><span class="material-symbols-outlined">favorite</span></div>
                <?php
                if (isset($_SESSION['user_id'])) {
                    echo '<button class="btn" @click="addToCart(menuitem)">add to cart</button>';
                } else {
                    echo '<a class="btn" @click="log">add to cart</a>';
                }
                ?>
            </div>
            </div>
        </section>
        <!--Footer-->
        <footer class="footer">
            <div class="footer-content">
                <div class="footer-section links">
                    <h1>QUICK LINKS</h1>
                    <ul>
                        <li><a href="#">Home</a></li>
                        <li><a href="#category">Category</a></li>
                        <li><a href="#menu">Menu</a></li>
                        <li><a href="frontend/about.php">About</a></li>
                        <li><a href="frontend/newsletter.php">Newsletter</a></li>
                    </ul>
                </div>
                <div class="footer-section about">
                    <h1>ABOUT</h1>
                    <p class="slogan">Warm meals, happy feels</p>
                    <hr>
                    <p class="story">Fed up of greasy takeout and ramen nights, three programmer pals with more coding mastery than cookery cred launched this website where you can get granny-worthy meals delivered by passionate and kinda nervous home cooks, because who needs fancy algorithms when you have got friendship and a love for good food?</p>
                    
                    <div class="contact">
                        <h1>CONTACT</h1>
                        <hr>
                        <p class="addr">
                        Srinakharinwirot University<br>
                        Department of Computer Science, Faculty of Science<br>
                        Building 19, 18th floor<br>
                        114 Sukhumvit 23, Wattana<br>
                        Bangkok 10110<br>
                            Thailand<br><br>
                            (251) 207-212-690<br>
                            contact@dogdog.com
                        </p>
 
                    </div>
                </div>
                <div class="footer-section faqs">
                    <h1>FAQs</h1>
                    <hr>
                <p class="quest">
                    1. Who are we?<br>
                    We are 3 Data Engineering students with a passion<br><br>
                    2. What cuisine are you offering?<br>
                    Comfort classics to global flavors<br><br>
                    3. How do you maintain food quality during delivery?<br>
                    Specialized packaging ensures freshness<br><br>
                    4. What payment methods do you accept?<br>
                    We accept secure payments through visa or mastercard<br><br>
                    5. Is there a loyalty program?<br>
                    We are searching for ways to reward our customers, stay tuned for updates
                </p>
                </div>
            </div>
            <div class="footer-bottom">
                - copyright &copy; 2024 le festin, inc. all rights reserved. -
            </div>
        </footer>
    </div>
    <!-- maps -->
    <script src="https://maps.googleapis.com/maps/api/js?v=3.exp&sensor=false"></script>
    <!-- javascript -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <!-- framework (vue.js) -->
    <script src="https://cdn.jsdelivr.net/npm/vue@3.4.25/dist/vue.global.min.js"></script>
    <!-- import javascript file -->
    <script src="index.js"></script>
    <!-- jquery -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <!-- import javascript file -->
    <script src="map.js"></script>
    <script>
        $(document).ready(function () {
            var urlParams = new URLSearchParams(window.location.search);
            var error = urlParams.get('error');
            if (error == 'notfound' || error == 'incorrect') {
                alert("please try again, incorrect email or password");
            }
        });
    </script>
</body>
</html>