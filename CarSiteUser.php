<?php
// Start the session
session_start();

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    // If not logged in, redirect to login page
    header("Location: Login.php");
    exit;
}
?>
<!doctype html>
<html class="no-js" lang="en">

<head>
    <!-- meta data -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link href="https://fonts.googleapis.com/css?family=Poppins:100,100i,200,200i,300,300i,400,400i,500,500i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

    <link href="https://fonts.googleapis.com/css?family=Rufina:400,700" rel="stylesheet">

    <!-- title of site -->
    <title>AutoVibe Motors</title>

    <!-- For favicon png -->
    <link rel="shortcut icon" type="image/icon" href="assets/logo/favicon.png" />

    <!--font-awesome.min.css-->
    <link rel="stylesheet" href="assets/css/font-awesome.min.css">

    <!--linear icon css-->
    <link rel="stylesheet" href="assets/css/linearicons.css">

    <!--flaticon.css-->
    <link rel="stylesheet" href="assets/css/flaticon.css">

    <!--animate.css-->
    <link rel="stylesheet" href="assets/css/animate.css">

    <!--owl.carousel.css-->
    <link rel="stylesheet" href="assets/css/owl.carousel.min.css">
    <link rel="stylesheet" href="assets/css/owl.theme.default.min.css">

    <!--bootstrap.min.css-->
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">

    <!-- bootsnav -->
    <link rel="stylesheet" href="assets/css/bootsnav.css">

    <!--style.css-->
    <link rel="stylesheet" href="assets/css/style.css">

    <!--responsive.css-->
    <link rel="stylesheet" href="assets/css/responsive.css">


</head>

<body>
    <?php
    $servername = "sql113.infinityfree.com"; // WAMP default
    $username = "if0_37882240";        // Default username
    $password = "8DSymqAAph6P";            // Default password
    $database = "if0_37882240_website";

    $conn = new mysqli($servername, $username, $password, $database);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    ?>
    <section id="home" class="welcome-hero">

        <div class="top-area">
            <div class="header-area">
                <nav class="navbar navbar-default bootsnav  navbar-sticky navbar-scrollspy" data-minus-value-desktop="70" data-minus-value-mobile="55" data-speed="1000">

                    <div class="container">

                        <div class="navbar-header">
                            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#navbar-menu">
                                <i class="fa fa-bars"></i>
                            </button>
                            <a class="navbar-brand" href="index.html">AutoVibe Motors<span></span></a>

                        </div>
                        <div class="collapse navbar-collapse menu-ui-design" id="navbar-menu">
                            <ul class="nav navbar-nav navbar-right" data-in="fadeInDown" data-out="fadeOutUp">
                                <li class=" scroll active"><a href="#home">home</a></li>
                                <li class="scroll"><a href="#service">service</a></li>
                                <li class="scroll"><a href="#new-cars">Favorites</a></li>
                                <li class="scroll"><a href="#featured-cars">featured cars</a></li>
                                <li class="scroll"><a href="#brand">brands</a></li>
                                <li class="scroll"><a href="#contact">contact</a></li>
                            </ul><!--/.nav -->
                        </div><!-- /.navbar-collapse -->
                    </div><!--/.container-->
                </nav><!--/nav-->
                <!-- End Navigation -->
            </div><!--/.header-area-->
            <div class="clearfix"></div>

        </div><!-- /.top-area-->
        <!-- top-area End -->

        <div class="container">
            <div class="welcome-hero-txt">
                <h2><?php echo "Hello " . htmlspecialchars($_SESSION['fname']) . ",";
                    ?></h2>
                <h2>get your desired car in resonable price</h2>

                <button class="welcome-btn" onclick="window.location.href='logout.php'">Logout</button>
            </div>
        </div>

        <form action="SelectCars.php" method="GET">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="model-search-content">
                        <div class="row">
                            <div class="col-md-offset-1 col-md-2 col-sm-12">
                                <div class="single-model-search">
                                    <h2>select year</h2>
                                    <div class="model-select-icon">
                                        <select name="year" class="form-control">

                                            <option value="default">year</option><!-- /.option-->
                                            <?php
                                            $sql = "SELECT DISTINCT Year 
                                                    FROM car 
                                                    ORDER BY year ASC;
                                                    ";
                                            $result = $conn->query($sql);

                                            if ($result->num_rows > 0) {
                                                while ($row = $result->fetch_assoc()) {
                                                    echo "<option value=" . $row['Year'] . ">" . $row['Year'] . "</option>";
                                                }
                                            }
                                            ?>


                                        </select><!-- /.select-->
                                    </div><!-- /.model-select-icon -->
                                </div>
                                <div class="single-model-search">
                                    <h2>Color</h2>
                                    <div class="model-select-icon">
                                        <select name="color" class="form-control">

                                            <option value="default">color</option><!-- /.option-->

                                            <?php
                                            $sql = "SELECT DISTINCT Color FROM car";
                                            $result = $conn->query($sql);

                                            if ($result->num_rows > 0) {
                                                while ($row = $result->fetch_assoc()) {
                                                    echo "<option value=" . $row['Color'] . ">" . $row['Color'] . "</option>";
                                                }
                                            }
                                            ?>
                                        </select><!-- /.select-->
                                    </div><!-- /.model-select-icon -->
                                </div>
                            </div>
                            <div class="col-md-offset-1 col-md-2 col-sm-12">
                                <div class="single-model-search">
                                    <h2>select make</h2>
                                    <div class="model-select-icon">
                                        <select name="make" class="form-control">

                                            <option value="default">make</option><!-- /.option-->

                                            <?php
                                            $sql = "SELECT DISTINCT Make FROM car";
                                            $result = $conn->query($sql);

                                            if ($result->num_rows > 0) {
                                                while ($row = $result->fetch_assoc()) {
                                                    echo "<option value=" . $row['Make'] . ">" . $row['Make'] . "</option>";
                                                }
                                            }
                                            ?>
                                        </select><!-- /.select-->
                                    </div><!-- /.model-select-icon -->
                                </div>
                                <div class="single-model-search">
                                    <h2>Doors</h2>
                                    <div class="model-select-icon">
                                        <select name="doors" class="form-control">

                                            <option value="default">Door</option><!-- /.option-->

                                            <option value="2">2</option><!-- /.option-->

                                            <option value="4">4</option><!-- /.option-->

                                        </select><!-- /.select-->
                                    </div><!-- /.model-select-icon -->
                                </div>
                            </div>
                            <div class="col-md-offset-1 col-md-2 col-sm-12">
                                <div class="single-model-search">
                                    <h2>select model</h2>
                                    <div class="model-select-icon">
                                        <select name="model" class="form-control">

                                            <option value="default">model</option><!-- /.option-->

                                            <?php
                                            $sql = "SELECT DISTINCT Model FROM car";
                                            $result = $conn->query($sql);

                                            if ($result->num_rows > 0) {
                                                while ($row = $result->fetch_assoc()) {
                                                    echo "<option value=" . $row['Model'] . ">" . $row['Model'] . "</option>";
                                                }
                                            }
                                            ?>

                                        </select><!-- /.select-->
                                    </div><!-- /.model-select-icon -->
                                </div>
                                <div class="single-model-search">
                                    <h2>select price</h2>
                                    <div class="model-select-icon">
                                        <select name="price" class="form-control">

                                            <option value="default">price</option><!-- /.option-->

                                            <option value="10000">
                                                <$10000 </option><!-- /.option-->

                                            <option value="10000-30000">$10,000 < Price < $30,000</option>
                                            <option value="30000-50000">$30,000 < Price < $50,000</option>
                                            <option value="50000">>$50000</option><!-- /.option-->

                                        </select><!-- /.select-->
                                    </div><!-- /.model-select-icon -->
                                </div>
                            </div>
                            <div class="col-md-2 col-sm-12">
                                <div class="single-model-search text-center">
                                    <button type="submit" class="welcome-btn model-search-btn">
                                        search
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        </form>

    </section><!--/.welcome-hero-->
    <!--welcome-hero end -->

    <!--service start -->
    <section id="service" class="service">
        <div class="container">
            <div class="service-content">
                <div class="row">
                    <div class="col-md-4 col-sm-6">
                        <div class="single-service-item">
                            <div class="single-service-icon">
                                <i class="flaticon-car"></i>
                            </div>
                            <h2><a href="#">largest dealership <span> of</span> car</a></h2>
                            <p>
                                As the largest car dealership and rental company, AutoVibe Motors offers an extensive range of vehicles to buy or rent.
                                From top-quality rentals for every journey to premium cars for sale, we redefine convenience and excellence in the automotive world. </p>
                        </div>
                    </div>
                    <div class="col-md-4 col-sm-6">
                        <div class="single-service-item">
                            <div class="single-service-icon">
                                <i class="flaticon-car-repair"></i>
                            </div>
                            <h2><a href="#">unlimited repair warrenty</a></h2>
                            <p>
                                We make sure that you enjoy peace of mind with our Unlimited Repair Warranty, covering all eligible repairs to keep your vehicle in top condition.
                                Drive confidently, knowing we’ve got you covered, no matter the miles. <br><br><br></p>
                        </div>
                    </div>
                    <div class="col-md-4 col-sm-6">
                        <div class="single-service-item">
                            <div class="single-service-icon">
                                <i class="flaticon-car-1"></i>
                            </div>
                            <h2><a href="#">insurence support</a></h2>
                            <p>
                                AutoVibe Motors offers seamless insurance support, guiding you through claims and coverage options to ensure a hassle-free experience.
                                Drive with confidence knowing we’re here to assist every step of the way. <br><br></p>
                        </div>
                    </div>
                </div>
            </div>
        </div><!--/.container-->

    </section><!--/.service-->
    <!--service end-->

    <!--new-cars start -->
    <section id="new-cars" class="new-cars">
        <div class="container">
            <div class="section-header">

                <h2>Your favorite cars</h2>
            </div><!--/.section-header-->
            <div class="new-cars-content">
                <div class="owl-carousel owl-theme" id="new-cars-carousel">
                    <?php
                    $user_id = htmlspecialchars($_SESSION['user_id']);
                    $sql = "SELECT * FROM car WHERE ID IN (SELECT car_id FROM favorites WHERE user_id = ?)";

                    $stmt = $conn->prepare($sql);

                    $stmt->bind_param("i", $user_id);

                    $stmt->execute();
                    $result = $stmt->get_result();
                    $sql2 = "SELECT * FROM images";
                    $result2 = $conn->query($sql2);

                    if ($result->num_rows > 0) {

                        while ($row = $result->fetch_assoc()) {
                            echo "<div class='single-new-cars-item'>";
                            echo "<div class='row'>";
                            echo "<div class='col-md-7 col-sm-12'>";
                            $sql2 = "SELECT * FROM images where car_id=" . $row['ID'] . "";
                            $result2 = $conn->query($sql2);
                            $row2 = $result2->fetch_assoc();
                            $imageData = base64_encode($row2['image']);
                            echo "<div class='new-cars-img'>";
                            echo "<img src='data:image/jpeg;base64, $imageData' alt='img'/>";
                            echo "</div></div>";
                            echo "<div class='col-md-5 col-sm-12'>";
                            echo "<div class='new-cars-txt'>";
                            echo "<h2><a href='Cars.php?id=" . $row['ID'] . "&user_id=" . htmlspecialchars($_SESSION['user_id']) . "&role=" . htmlspecialchars($_SESSION['role']) . "'>" . $row['Make'] . " " . $row['Model'] . "<span> " . $row['Engine'] . "</span></a></h2>";
                            echo "<button class='welcome-btn new-cars-btn' onclick=\"window.location.href='Cars.php?id=" . $row['ID'] . "&user_id=" . htmlspecialchars($_SESSION['user_id']) . "&role=" . htmlspecialchars($_SESSION['role']) . "'\">
                            view details
                                        </button>";
                            echo "</div></div></div></div>";
                        }
                    } else {
                        echo "<p>No favorite cars found.</p>";
                    }

                    ?>

                </div><!--/#new-cars-carousel-->
            </div><!--/.new-cars-content-->
        </div><!--/.container-->

    </section><!--/.new-cars-->
    <!--new-cars end -->

    <!--featured-cars start -->
    <section id="featured-cars" class="featured-cars">
        <div class="container">
            <div class="section-header">
                <p>checkout <span>the</span> featured cars</p>
                <h2>featured cars</h2>
            </div>
            <div class="featured-cars-content">
                <?php
                $sql = "SELECT * FROM car";
                $result = $conn->query($sql);
                $sql2 = "SELECT * FROM images";
                $result2 = $conn->query($sql2);

                if ($result->num_rows > 0) {
                    $row = $result->fetch_assoc();
                    while ($row) {
                        $i = 0;
                        echo "<div class='row'>";
                        while ($row && $i < 4) {
                            $i++;
                            $sql2 = "SELECT * FROM images where car_id=" . $row['ID'] . "";
                            $result2 = $conn->query($sql2);
                            $row2 = $result2->fetch_assoc();
                            $imageData = base64_encode($row2['image']);
                            echo "<div class='col-lg-3 col-md-4 col-sm-6'>";
                            echo "<div class='single-featured-cars'>";
                            echo "<div class='featured-img-box'>";
                            echo "<div class='featured-cars-img'>";
                            echo "<img src='data:image/jpeg;base64, $imageData' alt='img'/>";
                            echo "</div>";
                            echo "<div class='featured-model-info'>";
                            echo "<p>
                                            Year: " . $row['Year'] . "
                                            <span class='featured-mi-span'> " . $row['Mileage'] . " km</span> 
                                            <span class='featured-hp-span'> " . $row['Horsepower'] . "HP</span>
                                            automatic</p></div></div>";
                            echo "<div class='featured-cars-txt'>";
                            echo "<h2><a href='Cars.php?id=" . $row['ID'] . "&user_id=" . htmlspecialchars($_SESSION['user_id']) . "&role=" . htmlspecialchars($_SESSION['role']) . "'>" . $row['Make'] . " " . $row['Model'] . "<span> " . $row['Engine'] . "</span></a></h2>
                                    <h3>$" . $row['Price'] . " or $" . $row['Rent'] . "/day</h3>
                                   </div></div></div>";
                            $row = $result->fetch_assoc();
                        }
                        echo "</div>";
                    }
                }
                ?>
            </div>
        </div><!--/.container-->

    </section><!--/.featured-cars-->
    <!--featured-cars end -->

    <!-- clients-say strat -->
    <section id="clients-say" class="clients-say">
        <div class="container">
            <div class="section-header">
                <h2>what our clients say</h2>
            </div><!--/.section-header-->
            <div class="row">
                <div class="owl-carousel testimonial-carousel">
                    <div class="col-sm-3 col-xs-12">
                        <div class="single-testimonial-box">
                            <div class="testimonial-description">
                                <div class="testimonial-info">
                                    <div class="testimonial-img">
                                        <img src="assets/images/clients/c1.png" alt="image of clients person" />
                                    </div><!--/.testimonial-img-->
                                </div><!--/.testimonial-info-->
                                <div class="testimonial-comment">
                                    <p>
                                        I couldn’t have asked for a better car-buying experience. The team was professional, friendly, and helped me find the perfect car. </p>
                                </div><!--/.testimonial-comment-->
                                <div class="testimonial-person">
                                    <h2><a href="#">Dani Azar</a></h2>
                                    <h4>Kaslik </h4>
                                </div><!--/.testimonial-person-->
                            </div><!--/.testimonial-description-->
                        </div><!--/.single-testimonial-box-->
                    </div><!--/.col-->
                    <div class="col-sm-3 col-xs-12">
                        <div class="single-testimonial-box">
                            <div class="testimonial-description">
                                <div class="testimonial-info">
                                    <div class="testimonial-img">
                                        <img src="assets/images/clients/c2.png" alt="image of clients person" />
                                    </div><!--/.testimonial-img-->
                                </div><!--/.testimonial-info-->
                                <div class="testimonial-comment">
                                    <p>
                                    Amazing customer service and great prices. I’ve rented from many companies before, but AutoVibe Motors stands out.                                    </p>
                                </div><!--/.testimonial-comment-->
                                <div class="testimonial-person">
                                    <h2><a href="#">romi rain</a></h2>
                                    <h4>london</h4>
                                </div><!--/.testimonial-person-->
                            </div><!--/.testimonial-description-->
                        </div><!--/.single-testimonial-box-->
                    </div><!--/.col-->
                    <div class="col-sm-3 col-xs-12">
                        <div class="single-testimonial-box">
                            <div class="testimonial-description">
                                <div class="testimonial-info">
                                    <div class="testimonial-img">
                                        <img src="assets/images/clients/c3.png" alt="image of clients person" />
                                    </div><!--/.testimonial-img-->
                                </div><!--/.testimonial-info-->
                                <div class="testimonial-comment">
                                    <p>
                                    The selection of cars at AutoVibe Motors is incredible. I rented a car for my vacation, and it was spotless and reliable!                                    </p>
                                    </p>
                                </div><!--/.testimonial-comment-->
                                <div class="testimonial-person">
                                    <h2><a href="#">john doe</a></h2>
                                    <h4>washington</h4>
                                </div><!--/.testimonial-person-->
                            </div><!--/.testimonial-description-->
                        </div><!--/.single-testimonial-box-->
                    </div><!--/.col-->
                </div><!--/.testimonial-carousel-->
            </div><!--/.row-->
        </div><!--/.container-->

    </section><!--/.clients-say-->
    <!-- clients-say end -->

    <!--brand strat -->
    <section id="brand" class="brand">
        <div class="container">
            <div class="brand-area">
                <div class="owl-carousel owl-theme brand-item">
                    <div class="item">
                        <a href="#">
                            <img src="assets/images/brand/br1.png" alt="brand-image" />
                        </a>
                    </div><!--/.item-->
                    <div class="item">
                        <a href="#">
                            <img src="assets/images/brand/br2.png" alt="brand-image" />
                        </a>
                    </div><!--/.item-->
                    <div class="item">
                        <a href="#">
                            <img src="assets/images/brand/br3.png" alt="brand-image" />
                        </a>
                    </div><!--/.item-->
                    <div class="item">
                        <a href="#">
                            <img src="assets/images/brand/br4.png" alt="brand-image" />
                        </a>
                    </div><!--/.item-->

                    <div class="item">
                        <a href="#">
                            <img src="assets/images/brand/br5.png" alt="brand-image" />
                        </a>
                    </div><!--/.item-->

                    <div class="item">
                        <a href="#">
                            <img src="assets/images/brand/br6.png" alt="brand-image" />
                        </a>
                    </div><!--/.item-->
                </div><!--/.owl-carousel-->
            </div><!--/.clients-area-->

        </div><!--/.container-->

    </section><!--/brand-->
    <!--brand end -->

    <!--blog start -->
    <section id="blog" class="blog"></section><!--/.blog-->
    <!--blog end -->

    <!--contact start-->
    <footer id="contact" class="contact">
        <div class="container">
            <div class="footer-top">
                <div class="row">
                    <div class="col-md-3 col-sm-6">
                        <div class="single-footer-widget">
                            <div class="footer-logo">
                                <a>AutoVibe Motors</a>
                            </div>
                            <p>
                                At AutoVibe Motors, we offer a seamless experience whether you're buying or renting.
                                From a wide selection of premium cars to flexible rental options, we cater to all your automotive needs with exceptional customer service.
                                Discover your next ride with us and enjoy the confidence of driving a high-quality vehicle at unbeatable prices.
                                Experience the vibe of excellence, every time you hit the road! </p>

                        </div>
                    </div>
                   
                    <div class="col-md-3 col-xs-12">
                        <div class="single-footer-widget">
                            <h2>top brands</h2>
                            <div class="row">
                                <div class="col-md-7 col-xs-6">
                                    <ul>
                                        <li><a href="#">BMW</a></li>
                                        <li><a href="#">lamborghini</a></li>
                                        <li><a href="#">camaro</a></li>
                                        <li><a href="#">audi</a></li>
                                        <li><a href="#">infiniti</a></li>
                                        <li><a href="#">nissan</a></li>
                                    </ul>
                                </div>
                                <div class="col-md-5 col-xs-6">
                                    <ul>
                                        <li><a href="#">ferrari</a></li>
                                        <li><a href="#">porsche</a></li>
                                        <li><a href="#">land rover</a></li>
                                        <li><a href="#">aston martin</a></li>
                                        <li><a href="#">mersedes</a></li>
                                        <li><a href="#">opel</a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-offset-1 col-md-3 col-sm-6">
                        <div class="single-footer-widget">
                            <h2>Contact us</h2>
                            <div class="footer-contact">
                                <p>info@autovibemotors.com</p>
                                <p>+961 79 152073</p>
                            </div>

                        </div>
                    </div>
                </div>
            </div>

        </div><!--/.container-->

        <div id="scroll-Top">
            <div class="return-to-top">
                <i class="fa fa-angle-up " id="scroll-top" data-toggle="tooltip" data-placement="top" title="" data-original-title="Back to Top" aria-hidden="true"></i>
            </div>

        </div><!--/.scroll-Top-->

    </footer><!--/.contact-->
    <!--contact end-->



    <!-- Include all js compiled plugins (below), or include individual files as needed -->

    <script src="assets/js/jquery.js"></script>

    <!--modernizr.min.js-->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/modernizr/2.8.3/modernizr.min.js"></script>

    <!--bootstrap.min.js-->
    <script src="assets/js/bootstrap.min.js"></script>

    <!-- bootsnav js -->
    <script src="assets/js/bootsnav.js"></script>

    <!--owl.carousel.js-->
    <script src="assets/js/owl.carousel.min.js"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-easing/1.4.1/jquery.easing.min.js"></script>

    <!--Custom JS-->
    <script src="assets/js/custom.js"></script>
</body>

</html>