<?php
    require 'assets/partials/_functions.php';
    $conn = db_connect();    

    if(!$conn) 
        die("Connection Failed");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bus Ticket Bookings</title>
    <!-- google fonts -->
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@100;200;300;400;500&display=swap" rel="stylesheet">
    <!-- Font-awesome -->
    <script src="https://kit.fontawesome.com/d8cfbe84b9.js" crossorigin="anonymous"></script>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-+0n0xVW2eSR5OomGNYDnhzAbDsOXxcvSN1TPprVMTNDbiYZCxYbOOl7+AMvyTG2x" crossorigin="anonymous">
    <!-- CSS -->
    <?php 
        require 'assets/styles/styles.php'
    ?>
</head>
<body>
    <?php
    
    if(isset($_GET["booking_added"]) && !isset($_POST['pnr-search']))
    {
        if($_GET["booking_added"])
        {
            echo '<div class="my-0 alert alert-success alert-dismissible fade show" role="alert">
                <strong>Successful!</strong> Booking Added, your PNR is <span style="font-weight:bold; color: #272640;">'. $_GET["pnr"] .'</span>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>';
        }
        else{
            // Show error alert
            echo '<div class="my-0 alert alert-danger alert-dismissible fade show" role="alert">
            <strong>Error!</strong> Booking already exists
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>';
        }
    }

    if($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["pnr-search"]))
    {
        $pnr = $_POST["pnr"];

        $sql = "SELECT * FROM bookings WHERE booking_id='$pnr'";
        $result = mysqli_query($conn, $sql);

        $num = mysqli_num_rows($result);

        if($num)
        {
            $row = mysqli_fetch_assoc($result);
            $route_id = $row["route_id"];
            $customer_id = $row["customer_id"];
            
            $customer_name = get_from_table($conn, "customers", "customer_id", $customer_id, "customer_name");

            $customer_phone = get_from_table($conn, "customers", "customer_id", $customer_id, "customer_phone");

            $customer_route = $row["customer_route"];
            $booked_amount = $row["booked_amount"];

            $booked_seat = $row["booked_seat"];
            $booked_timing = $row["booking_created"];

            $dep_date = get_from_table($conn, "routes", "route_id", $route_id, "route_dep_date");

            $dep_time = get_from_table($conn, "routes", "route_id", $route_id, "route_dep_time");

            $bus_no = get_from_table($conn, "routes", "route_id", $route_id, "bus_no");
            ?>

            <div class="alert alert-dark alert-dismissible fade show" role="alert">
            
            <h4 class="alert-heading">Booking Information!</h4>
            <p>
                <button class="btn btn-sm btn-success"><a href="assets/partials/_download.php?pnr=<?php echo $pnr; ?>" class="link-light">Download</a></button>
                <button class="btn btn-danger btn-sm" id="deleteBooking" data-bs-toggle="modal" data-bs-target="#deleteModal" data-pnr="<?php echo $pnr;?>" data-seat="<?php echo $booked_seat;?>" data-bus="<?php echo $bus_no; ?>">
                    Delete
                </button>
            </p>
            <hr>
                <p class="mb-0">
                    <ul class="pnr-details">
                        <li>
                            <strong>PNR : </strong>
                            <?php echo $pnr; ?>
                        </li>
                        <li>
                            <strong>Customer Name : </strong>
                            <?php echo $customer_name; ?>
                        </li>
                        <li>
                            <strong>Customer Phone : </strong>
                            <?php echo $customer_phone; ?>
                        </li>
                        <li>
                            <strong>Route : </strong>
                            <?php echo $customer_route; ?>
                        </li>
                        <li>
                            <strong>Bus Number : </strong>
                            <?php echo $bus_no; ?>
                        </li>
                        <li>
                            <strong>Booked Seat Number : </strong>
                            <?php echo $booked_seat; ?>
                        </li>
                        <li>
                            <strong>Departure Date : </strong>
                            <?php echo $dep_date; ?>
                        </li>
                        <li>
                            <strong>Departure Time : </strong>
                            <?php echo $dep_time; ?>
                        </li>
                        <li>
                            <strong>Booked Timing : </strong>
                            <?php echo $booked_timing; ?>
                        </li>

                </p>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php }
        else{
            echo '<div class="my-0 alert alert-danger alert-dismissible fade show" role="alert">
                <strong>Error!</strong> Record Doesnt Exist
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>';
        }
        
    ?>
        
    <?php }


        // Delete Booking
        if($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["deleteBtn"]))
        {
            $pnr = $_POST["id"];
            $bus_no = $_POST["bus"];
            $booked_seat = $_POST["booked_seat"];

            $deleteSql = "DELETE FROM `bookings` WHERE `bookings`.`booking_id` = '$pnr'";

                $deleteResult = mysqli_query($conn, $deleteSql);
                $rowsAffected = mysqli_affected_rows($conn);
                $messageStatus = "danger";
                $messageInfo = "";
                $messageHeading = "Error!";

                if(!$rowsAffected)
                {
                    $messageInfo = "Record Doesn't Exist";
                }

                elseif($deleteResult)
                {   
                    $messageStatus = "success";
                    $messageInfo = "Booking Details deleted";
                    $messageHeading = "Successfull!";

                    // Update the Seats table
                    $seats = get_from_table($conn, "seats", "bus_no", $bus_no, "seat_booked");

                    // Extract the seat no. that needs to be deleted
                    $booked_seat = $_POST["booked_seat"];

                    $seats = explode(",", $seats);
                    $idx = array_search($booked_seat, $seats);
                    array_splice($seats,$idx,1);
                    $seats = implode(",", $seats);

                    $updateSeatSql = "UPDATE `seats` SET `seat_booked` = '$seats' WHERE `seats`.`bus_no` = '$bus_no';";
                    mysqli_query($conn, $updateSeatSql);
                }
                else{

                    $messageInfo = "Your request could not be processed due to technical Issues from our part. We regret the inconvenience caused";
                }

                // Message
                echo '<div class="my-0 alert alert-'.$messageStatus.' alert-dismissible fade show" role="alert">
                <strong>'.$messageHeading.'</strong> '.$messageInfo.'
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>';
            }
    ?>

    
    <header>
        <nav>
            <div>
                    <a href="#" class="nav-item nav-logo">Daystar University Shuttle</a>
                    <!-- <a href="#" class="nav-item">Gallery</a> -->
            </div>
                
            <ul>
                <li><a href="#" class="nav-item">Home</a></li>
                <li><a href="#about" class="nav-item">About</a></li>
                <li><a href="#contact" class="nav-item">Schedule</a></li>
                
            </ul>
            <div>
                <a href="#" class="login nav-item" data-bs-toggle="modal" data-bs-target="#loginModal"><i class="fas fa-sign-in-alt" style="margin-right: 0.4rem;"></i>Admin</a>
                <a href="#pnr-enquiry" class="pnr nav-item">Enquiry</a>
            </div>
        </nav>
    </header>
    <!-- Login Modal -->
    <?php require 'assets/partials/_loginModal.php'; 
        require 'assets/partials/_getJSON.php';

        $routeData = json_decode($routeJson);
        $busData = json_decode($busJson);
        $customerData = json_decode($customerJson);
    ?>
    

    <section id="home">
        <div id="route-search-form">
            <h1>Learning, Believing, Commuting: One Christian Journey.</h1>

            <p class="text-center">Welcome to the Daystar University Shuttle Management System. Reserve Your Seat Ticket With Us. Or. Simply Scroll Down to Check Your Ticket Status Using Your PNR Number</p>

      

            <br>
            <center>
            <a href="#pnr-enquiry"><button class="btn btn-primary">Scroll Down <i class="fa fa-arrow-down"></i></button></a>
            <a href=book.php><button class="btn btn-primary">Book a Seat <i class="fas fa-bus"></i></button></a>
            </center>
            
        </div>
    </section>
    <div id="block">
        <section id="info-num">
            <figure>
                <img src="assets/img/route.svg" alt="Bus Route Icon" width="100px" height="100px">
                <figcaption>
                    <span class="num counter" data-target="<?php echo count($routeData); ?>">999</span>
                    <span class="icon-name">routes</span>
                </figcaption>
            </figure>
            <figure>
                <img src="assets/img/bus.svg" alt="Bus Icon" width="100px" height="100px">
                <figcaption>
                    <span class="num counter" data-target="<?php echo count($busData); ?>">999</span>
                    <span class="icon-name">bus</span>
                </figcaption>
            </figure>
            <figure>
                <img src="assets/img/customer.svg" alt="Happy Customer Icon" width="100px" height="100px">
                <figcaption>
                    <span class="num counter" data-target="<?php echo count($customerData); ?>">999</span>
                    <span class="icon-name">happy customers</span>
                </figcaption>
            </figure>
            <figure>
                <img src="assets/img/ticket.svg" alt="Instant Ticket Icon" width="100px" height="100px">
                <figcaption>
                    <span class="num"><span class="counter" data-target="20">999</span> SEC</span> 
                    <span class="icon-name">Instant Tickets</span>
                </figcaption>
            </figure>
        </section>
        <section id="pnr-enquiry">
            <div id="pnr-form">
                <h2>PNR ENQUIRY</h2>
                <form action="<?php echo $_SERVER["REQUEST_URI"]; ?>" method="POST">
                    <div>
                        <input type="text" name="pnr" id="pnr" placeholder="Enter PNR">
                    </div>
                    <button type="submit" name="pnr-search">Submit</button>
                </form>
            </div>
        </section>
        <section id="about">
            <div>
                <h1>About Us</h1>
                <br>
                <h4>Wanna know us and What we stand for?</h4>
                <br>
                <p>
                Our objective is to create a seamless and faith-enhancing commuting experience for our students and staff by providing reliable, efficient, and secure transportation services that align with Christian principles and values. With a fleet of over 8 buses, we are committed to ensuring punctuality, safety, and comfort on every ride. We aim to foster a strong sense of community and spiritual growth among all passengers, ensuring that every journey with Daystar University Shuttle System is not merely a mode of transportation but a faith-filled voyage.

                Through our services, we seek to promote a spirit of Christian fellowship, respect, and mutual support, facilitating connections that go beyond the commute and contribute to the holistic development of individuals within our diverse university community. Our commitment to Christian values extends to our operations, where we prioritize integrity, honesty, and service in every aspect of our shuttle system. We are dedicated to being a beacon of Christ's love, guiding our passengers towards a deeper understanding of faith and fellowship as they travel to and from our campuses.
                </p>
            </div>
        </section>
        <section id="contact">
        <style>
    body {
        background-color: #E0F5FF; /* Light blue background for the page */
        font-family: Arial, sans-serif;
        color: #000000; /* Black text color */
    }

    #schedule {
        background-color: #1E8BEF; /* Light blue background for the schedule table */
        border-radius: 10px;
        padding: 20px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.2);
        margin: 20px;
    }

    h1 {
        text-align: center;
        background-color: #0074CC; /* Light blue background color */
        color: #FFFFFF; /* White text color */
        padding: 20px;
        font-size: 40px; /* Font size */
        border-radius: 10px; /* Rounded corners */
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1); /* Subtle shadow */
    }

    table {
        
        width: 100%;
        border-collapse: collapse;
        border: 10px solid "#CCCCCC"; /* Black border around the table */
    }

    th, td {
        padding: 10px;
        text-align: left;
        border: 4px solid #CCCCCC; /* Black border around table cells */
    }

</style>

        <body>
<section id="schedule">
    <h1>BUS SCHEDULE</h1>
    <table>
        <tr>
            <th>Day</th>
            <th>Time</th>
            <th>Route</th>
            <th>Stages</th>
            <th>Driver</th>
            <th>Conductor</th>
        </tr>
        <tr>
            <td rowspan="4">Monday</td>
            <td>05:00 AM</td>
            <td>AthiRiver - Valley Road</td>
            <td>AthiRiver, Devki, Mlolongo, Kabanas</td>
            <td>Mulwa</td>
            <td>Musera</td>
        </tr>
        <tr>
            <td>6:30 AM</td>
            <td>Valley Road - AthiRiver</td>
            <td>Valley Road, CBD, Belle  Vue, Kabanass, Mlolongo</td>
            <td>Mwaura</td>
            <td>Musera</td>
        </tr>
        <tr>
            <td>01:00 PM</td>
            <td>Route 3</td>
            <td>Stage P, Stage Q, Stage R</td>
            <td>-</td>
            <td>-</td>
        </tr>
        <tr>
            <td>03:30 PM</td>
            <td>Route 4</td>
            <td>Stage M, Stage N, Stage O</td>
            <td>-</td>
            <td>-</td>
        </tr>
        <tr>
            <td rowspan="4">Tuesday</td>
            <td>09:00 AM</td>
            <td>Route 5</td>
            <td>Stage D, Stage E, Stage F</td>
            <td>-</td>
            <td>-</td>
        </tr>
        <tr>
            <td>10:30 AM</td>
            <td>Route 6</td>
            <td>Stage G, Stage H, Stage I</td>
            <td>-</td>
            <td>-</td>
        </tr>
        <tr>
            <td>01:00 PM</td>
            <td>Route 7</td>
            <td>Stage J, Stage K, Stage L</td>
            <td>-</td>
            <td>-</td>
        </tr>
        <tr>
            <td>03:30 PM</td>
            <td>Route 8</td>
            <td>Stage N, Stage O, Stage P</td>
            <td>-</td>
            <td>-</td>
        </tr>
        <tr>
            <td rowspan="4">Wednesday</td>
            <td>09:00 AM</td>
            <td>Route 5</td>
            <td>Stage D, Stage E, Stage F</td>
            <td>-</td>
            <td>-</td>
        </tr>
        <tr>
            <td>10:30 AM</td>
            <td>Route 6</td>
            <td>Stage G, Stage H, Stage I</td>
            <td>-</td>
            <td>-</td>
        </tr>
        <tr>
            <td>01:00 PM</td>
            <td>Route 7</td>
            <td>Stage J, Stage K, Stage L</td>
            <td>-</td>
            <td>-</td>
        </tr>
        <tr>
            <td>03:30 PM</td>
            <td>Route 8</td>
            <td>Stage N, Stage O, Stage P</td>
            <td>-</td>
            <td>-</td>
        </tr>
        <tr>
            <td rowspan="4">Thursday</td>
            <td>09:00 AM</td>
            <td>Route 5</td>
            <td>Stage D, Stage E, Stage F</td>
            <td>-</td>
            <td>-</td>
        </tr>
        <tr>
            <td>10:30 AM</td>
            <td>Route 6</td>
            <td>Stage G, Stage H, Stage I</td>
            <td></td>
            <td>-</td>
        </tr>
        <tr>
            <td>01:00 PM</td>
            <td>Route 7</td>
            <td>Stage J, Stage K, Stage L</td>
            <td>-</td>
            <td>-</td>
        </tr>
        <tr>
            <td>03:30 PM</td>
            <td>Route 8</td>
            <td>Stage N, Stage O, Stage P</td>
            <td>-</td>
            <td>-</td>
        </tr>
        <tr>
            <td rowspan="4">Friday</td>
            <td>09:00 AM</td>
            <td>Route 5</td>
            <td>Stage D, Stage E, Stage F</td>
            <td>-</td>
            <td>-</td>
        </tr>
        <tr>
            <td>10:30 AM</td>
            <td>Route 6</td>
            <td>Stage G, Stage H, Stage I</td>
            <td>-</td>
            <td>-</td>
        </tr>
        <tr>
            <td>01:00 PM</td>
            <td>Route 7</td>
            <td>Stage J, Stage K, Stage L</td>
            <td>-</td>
            <td>-</td>
        </tr>
        <tr>
            <td>03:30 PM</td>
            <td>Route 8</td>
            <td>Stage N, Stage O, Stage P</td>
            <td>-</td>
            <td>-</td>
        </tr>
        <tr>
            <td rowspan="4">Saturday</td>
            <td>09:00 AM</td>
            <td>Route 5</td>
            <td>Stage D, Stage E, Stage F</td>
            <td>-</td>
            <td>-</td>
        </tr>
        <tr>
            <td>10:30 AM</td>
            <td>Route 6</td>
            <td>Stage G, Stage H, Stage I</td>
            <td>-</td>
            <td>-</td>
        </tr>
        <tr>
            <td>01:00 PM</td>
            <td>Route 7</td>
            <td>Stage J, Stage K, Stage L</td>
            <td>-</td>
            <td>-</td>
        </tr>
        <tr>
            <td>03:30 PM</td>
            <td>Route 8</td>
            <td>Stage N, Stage O, Stage P</td>
            <td>-</td>
            <td>-</td>
        </tr>
        <tr>
            <td rowspan="4">Sunday</td>
            <td>09:00 AM</td>
            <td>Route 5</td>
            <td>Stage D, Stage E, Stage F</td>
            <td>-</td>
            <td>-</td>
        </tr>
        <tr>
            <td>10:30 AM</td>
            <td>Route 6</td>
            <td>Stage G, Stage H, Stage I</td>
            <td>-</td>
            <td>-</td>
        </tr>
        <tr>
            <td>01:00 PM</td>
            <td>Route 7</td>
            <td>Stage J, Stage K, Stage L</td>
            <td>-</td>
            <td>-</td>
        </tr>
        <tr>
            <td>03:30 PM</td>
            <td>Route 8</td>
            <td>Stage N, Stage O, Stage P</td>
            <td>-</td>
            <td>-</td>
        </tr>
        
    </table>
    

</section>


</body>
        </section>
        
    <br>
    <br>
        <style>
    footer {
        background-color: black; /* Light blue background color */
        color: #FFFFFF; /* White text color */
        text-align: center;
        padding: 10px;
    }
</style>
<br>
<footer>
    <p>
        <i class="far fa-copyright"></i> <?php echo date('Y');?> - Daystar University Shuttle Management System | Made by Jeremie Ndahura.
    </p>
</footer>
    </div>
    
    <!-- Delete Booking Modal -->
    <div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel"><i class="fas fa-exclamation-circle"></i></h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
            <h2 class="text-center pb-4">
                    Are you sure?
            </h2>
            <p>
                Do you really want to delete your booking? <strong>This process cannot be undone.</strong>
            </p>
            <!-- Needed to pass pnr -->
            <form action="<?php echo $_SERVER['PHP_SELF']; ?>" id="delete-form"  method="POST">
                    <input id="delete-id" type="hidden" name="id">
                    <input id="delete-booked-seat" type="hidden" name="booked_seat">
                    <input id="delete-booked-bus" type="hidden" name="bus">
            </form>
      </div>
      <div class="modal-footer">
        <button type="submit" form="delete-form" class="btn btn-primary btn-danger" name="deleteBtn">Delete</button>
      </div>
    </div>
  </div>
</div>
     <!-- Option 1: Bootstrap Bundle with Popper -->
     <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-gtEjrD/SeCtmISkJkNUaaKMoLD0//ElJ19smozuHV6z3Iehds+3Ulb9Bn9Plx0x4" crossorigin="anonymous"></script>
    <!-- External JS -->
    <script src="assets/scripts/main.js"></script>
</body>
</html>