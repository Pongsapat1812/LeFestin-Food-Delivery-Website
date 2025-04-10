<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LeFestin - About</title>
    <!-- css -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <!-- stylesheet -->
    <link rel="stylesheet" href="index.css">
    <link rel="stylesheet" href="about.css">
    <!-- font -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Poppins&display=swap">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Princess+Sofia&display=swap">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Montserrat&display=swap">
    <!-- icons -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
</head>
<body>
    <header class="header">
        <a href="../index.php" class="logo">LeFestin</a>
        <nav class="navbar">
                <a href="../index.php">Home</a>
                <a href="../index.php#category">Category</a>
                <a href="../index.php#menu">Menu</a>
                <a href="#">About</a>
                <a href="newsletter.php">Newsletter</a>
            <?php
            session_start();
            if (isset($_SESSION['user_id'])) {
                echo '<a href="user_information.php">Account</a>';
            }
            ?>
        </nav>
    </header>
    <div class="container">
        <div class="member">
            <img src="../about/207.png" alt="207">
            <h1>Napat Phusapanich</h2>
            <h2>65102010207</h2>
        </div>
        <div class="member">
            <img src="../about/212.png" alt="212">
            <h1>Aschariyanee Jindasri</h1>
            <h2>65102010212</h2>
        </div>
        <div class="member">
            <img src="../about/690.png" alt="690">
            <h1>Pongsapat Kongsereeparp</h1>
            <h2>65102010690</h2>
        </div>
    </div>
    <!-- maps -->
    <script src="https://maps.googleapis.com/maps/api/js?v=3.exp&sensor=false"></script>
    <!-- javascript -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <!-- framework (vue.js) -->
    <script src="https://cdn.jsdelivr.net/npm/vue@3.4.25/dist/vue.global.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/vue@next"></script>
    <!-- cookies -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/js-cookie/3.0.1/js.cookie.min.js"></script>
    <!-- import javascript file -->
    <script src="../index.js"></script>
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