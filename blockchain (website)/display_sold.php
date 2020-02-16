<!DOCTYPE html>
<html lang="en">

<?php
require_once('db.php');
session_start();

// check login
if (!isset($_SESSION["user"])) {
    header("Location: user_login.html");
}
?>

<head>
    <title>Trusted Dealer Malaysia</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>

    <link rel="stylesheet" type="text/css" href="display_sold_style.css" />
</head>

<body>

    <div class="jumbotron text-center" id="header">
        <h1>Trusted Dealer Malaysia</h1>
        <p>-----Insert some text-----</p>
    </div>

    <nav class="navbar navbar-expand-sm bg-dark navbar-dark">
        <a class="navbar-brand" href="dashboard.php">Menu</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#collapsibleNavbar">
                <span class="navbar-toggler-icon"></span>
            </button>

        <div class="collapse navbar-collapse" id="collapsibleNavbar">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" href="user_logout.php">Logout</a>
                </li>
            </ul>
        </div>
    </nav>

    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h2>For Sale.</h2>
                <h5>Display for sale vehicle.</h5>
            </div>
            <br>
        </div>

        <div class="row">
            <table border="1">
                    <thead>
                        <tr>
                            <th>Vehicle Brand</th>
                            <th>Vehicle Model</th>
                            <th>Vehicle Colour</th>
                            <th>Original Price (MYR)</th>
                            <th>Odometer Reading (Miles)</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $result = $conn->prepare("SELECT * FROM vehicle_details WHERE odometer <> 0 AND status = 'can sale'");
                        $result->execute();
                        for($i=0; $row = $result->fetch(); $i++){
                        ?>
                        <tr>
                            <td><label><?php echo $row['brand']; ?></label></td>
                            <td><label><?php echo $row['model']; ?></label></td>
                            <td><label><?php echo $row['colour']; ?></label></td>
                            <td><label><?php echo $row['price']; ?></label></td>
                            <td><label><a href="second_contract.php?vin=<?php echo $row['vin']; ?>"><?php echo $row['odometer']; ?></a></label></td>
                        </tr>
                        <?php } ?>
                    </tbody>
                </table>
        </div>
    </div>

    <div class="jumbotron text-center" id="footer">
        <p>&copy; 2019 Trusted Dealer Malaysia.com</p>
    </div>

</body>

</html>