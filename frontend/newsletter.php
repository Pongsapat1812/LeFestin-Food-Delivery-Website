<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LeFestin - Newsletter</title>
    <!-- css -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <!-- stylesheet -->
    <link rel="stylesheet" href="index.css">
    <link rel="stylesheet" href="newsletter.css">
    <!-- font -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Poppins&display=swap">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Princess+Sofia&display=swap">
    <!-- icons -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
</head>
<body>
    <div id="newsletter">
        <header class="header">
            <a href="../index.php" class="logo">LeFestin</a>
            <nav class="navbar">
                <a href="../index.php">Home</a>
                <a href="../index.php#category">Category</a>
                <a href="../index.php#menu">Menu</a>
                <a href="about.php">About</a>
                <a href="#">Newsletter</a>
                <?php
                session_start();
                if (isset($_SESSION['user_id'])) {
                    echo '<a href="user_information.php">Account</a>';
                }
                ?>
            </nav>
        </header>
        <div class="container">
            <div class="article" id="ar1">
                <hr>
                <h1>Crafting Culinary Delights</h1>
                <hr>
                <img src="../ar/ar1.png">
                <p class="date">20 September 2020 | 05:55 AM</p>
                <hr>
                <h2>Unlocking Gastronomic Pleasures</h2>
                <hr>
                <p>
                    the synergy between alcohol and food enriches culinary encounters, amplifying taste profiles for heightened gastronomic pleasures and sensory contentment.
                </p>
                <button class="read-more" @click="toggleContent('ar1')" v-if="!showContent['ar1']">read more</button>
                <div id="moreContent_ar1" v-show="showContent['ar1']">
                    <p>
                        within the realm of epicurean delights, alcohol orchestrates a symphony of flavors.
                        a well-paired wine or cocktail transcends mere sustenance, unlocking a realm where each sip and bite harmonize, creating an unforgettable cookery journey of sublime indulgence.
                    </p>
                    <button class="read-less" @click="toggleContent('ar1')" v-if="showContent['ar1']">read less</button>
                </div>
            </div>
            <div class="article" id="ar2">
                <hr>
                <h1>Homemade Heart</h1>
                <hr>
                <img src="../ar/ar2.png">
                <p class="date">20 October 2020 | 05:55 AM</p>
                <hr>
                <h2>Symphony of the Senses</h2>
                <hr>
                <p>
                    Homemade cooking embodies tradition and craftsmanship, elevating meals with a personal touch that resonates with authenticity, evoking cherished familial bonds.
                </p>
                <button class="read-more" @click="toggleContent('ar2')" v-if="!showContent['ar2']">read more</button>
                <div id="moreContent_ar2" v-show="showContent['ar2']">
                    <p>
                        in the realm of homemade cuisine, culinary workmanship intertwines with cherished family traditions, transmuting humble ingredients into gastronomic masterpieces.
                        from the gentle simmer of sauces to the meticulous layering of flavors, each dish embodies a labor of love and unwavering commitment to culinary mastery.
                        it is a symphony of taste, tradition, meticulously crafted with fervent passion and unparalleled precision.
                    </p>
                    <button class="read-less" @click="toggleContent('ar2')" v-if="showContent['ar2']">read less</button>
                </div>
            </div>
            <div class="article" id="ar3">
                <hr>
                <h1>Exploring Cultural Cuisine</h1>
                <hr>
                <img src="../ar/ar3.png">
                <p class="date">20 November 2020 | 05:55 AM</p>
                <hr>
                <h2>Flavors of Heritage</h2>
                <hr>
                <p>
                    cultural cuisine serves as a vibrant tapestry, intricately weaving history, values, and identity, offering an enriching and profound culinary journey.
                </p>
                <button class="read-more" @click="toggleContent('ar3')" v-if="!showContent['ar3']">read more</button>
                <div id="moreContent_ar3" v-show="showContent['ar3']">
                    <p>
                        cultural food is a mosaic of traditions, flavors, and techniques, a testament to the rich tapestry of human heritage.
                        from the fiery depths of Mexican mole to the delicate intricacies of French pastries, each dish encapsulates centuries of culinary evolution, inviting exploration and appreciation of the world's diverse gastronomic wonders and culinary legacies.
                    </p>
                    <button class="read-less" @click="toggleContent('ar3')" v-if="showContent['ar3']">read less</button>
                </div>
            </div>
        </div>
    </div>
    <!-- maps -->
    <script src="https://maps.googleapis.com/maps/api/js?v=3.exp&sensor=false"></script>
    <!-- javascript -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <!-- framework (vue.js) -->
    <script src="https://cdn.jsdelivr.net/npm/vue@3.4.25/dist/vue.global.min.js"></script>
    <!-- cookies -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/js-cookie/3.0.1/js.cookie.min.js"></script>
    <!-- import javascript file -->
    <script src="../index.js"></script>
    <script src="newsletter.js"></script>
    <!-- jquery -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <!-- import javascript file -->
    <script src="../map.js"></script>
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