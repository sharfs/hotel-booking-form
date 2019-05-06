<?php
session_start();
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="style.css" rel="stylesheet">
    <title>Hotel Booking Form</title>
</head>
<body>
    <?php

        $sql = "CREATE TABLE bookings (
        id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        firstname VARCHAR(50),
        surname VARCHAR(50),
        hotelname VARCHAR(50),
        indate VARCHAR(30),
        outdate VARCHAR(30)
        )";

    require_once 'connect.php';
    $conn->query($sql);
    echo $conn->error;

?>
    <form class="form-inline" role="form" action=<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?> method="post">
            <label for="firstname">First Name:</label>
            <input type="text" id="firstname" name="firstname" required><br><br>
            <label for="surname">Last Name:</label>
            <input type="text" id="surname" name="surname" required><br><br>
            <label for="start">Check-In Date:</label>
            <input type="date" id="start" name="indate" min="2019-05-06" max="2019-12-31" required><br><br>
            <label for="end">Check-Out Date:</label>
            <input type="date" id="end" name="outdate" min="2019-05-08" max="2020-01-31"required><br><br>
            <select name="hotelname" required>
                <option value="Goudini Spa">Goudini Spa</option>
                <option value="Caledon Spa">Caledon Spa</option>
                <option value="One & Only Hotel">One & Only Hotel</option>
                <option value="Arabella Resort">Arabella Resort</option>
                <option value="Montague Springs">Montague Springs</option>
            </select>
            <br><br>
            <button type="submit" name="submit">Check Availability</button>
    </form>
   
<?php

    if(isset($_POST['submit'])){
        $_SESSION['firstname'] = $_POST['firstname'];
        $_SESSION['surname'] = $_POST['surname'];
        $_SESSION['indate'] = $_POST['indate'];
        $_SESSION['outdate'] = $_POST['outdate'];
        $_SESSION['hotelname'] = $_POST['hotelname'];

        $datetime1 = new DateTime($_SESSION['indate']);
        $datetime2 = new DateTime($_SESSION['outdate']);
        $interval = $datetime1->diff($datetime2);
        //number of days booked
        $daysBooked = $interval->format('%R%a');
        //place holder for booking cost
        $value;

        //switch to adjust cost for different hotel rates
        switch($_POST['hotelname']){
            case "Goudini Spa" :
                $value = $daysBooked * 1100;
                break;
            case "Caledon Spa" :
                $value = $daysBooked * 1300;
                break;
            case "One & Only Hotel" :
                $value = $daysBooked * 4300;
                break;
            case "Arabella Resort" :
                $value = $daysBooked * 2200;
                break;
            case "Montague Springs" :
                $value = $daysBooked * 900;
                break;
            default :
                echo "Invalid booking.";
        }

        //display booking info for user
        echo "<br> First Name : " . $_SESSION['firstname'] . "<br>" . "Last Name : " . $_SESSION['surname'] . "<br>" . "Hotel Name : " . $_SESSION['hotelname'] . "<br>" . "Check-In Date : " . $_SESSION['indate'] . "<br>" . "Check-Out Date : " . $_SESSION['outdate'] . "<br>" . $interval->format("%R%a days") . "<br>" . "Total : " . $value . "<br>";
       

        echo "<input type='submit' name='confirm'>";
        // <form class='form-inline' role='form' action='htmlspecialchars($_SERVER["PHP_SELF"])' method='post'></form>

        if(isset($_POST['confirm'])){

            $stmt = $conn->prepare("INSERT INTO bookings (firstname, surname, hotelname, indate, outdate)
            VALUES(?, ?, ?, ?, ?)");
            $stmt->bind_param("sssss", $firstname, $surname, $hotelname, $indate, $outdate);

            $firstname = $_SESSION['firstname'];
            $surname = $_SESSION['surname'];
            $hotelname = $_SESSION['hotelname'];
            $indate = $_SESSION['indate'];
            $outdate = $_SESSION['outdate'];
            $stmt->execute();
            echo "Booking Confirmed.";
        }
    }


    ?>
</body>
</html>
