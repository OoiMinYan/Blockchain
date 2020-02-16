<!DOCTYPE html>
<html lang="en">

<?php
require_once('db.php');
session_start();

// check login
if (!isset($_SESSION["user"])) {
    header("Location: admin_login.html");
}
?>

    <head>
        <title>Vehicle Malaysia</title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>

        <link rel="stylesheet" type="text/css" href="vehicle_style.css" />
    </head>

    <body>

        <div class="jumbotron text-center" style="margin-bottom:0">
            <h1>Vehicle Malaysia</h1>
            <p>-----Insert some text-----</p>
        </div>



        <nav class="navbar navbar-expand-sm bg-dark navbar-dark">
            <a class="navbar-brand" href="#">Menu</a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#collapsibleNavbar">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="collapsibleNavbar">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link" href="admin_logout.php">Logout</a>
                    </li>
                </ul>
            </div>
        </nav>

        <div class="container" style="margin-top:30px">
            <div class="row">
                <div class="col-xl-12">
                    <h2>New Vehicle</h2>
                    <h5>Insert new vehicle.</h5>

                    <form id="msform" method="post" action="add_vehicle_item.php">
                        <!-- fieldsets -->
                        <fieldset>
                            <h2>Vehicle Items</h2>
                            <!--vehicle id-->
                            Vehicle ID
                            <input type="text" id="vid" name="vid" disabled/>

                            <!--vehicle brand-->
                            Vehicle Brand
                            <!-- <input type="text" id="vbrand" name="vbrand" oninput="calculateCarID()" /> -->
                            <input type="text" id="vbrand" name="vbrand" pattern="^[a-zA-Z]+$" title="Only Characters" required/>

                            <!--vehicle model-->
                            Vehicle Model
                            <input type="text" id="vmodel" name="vmodel" pattern="^[a-zA-Z]+$" title="Only Characters" required/>

                            <!--vehicle colour-->
                            Vehicle Colour
                            <input type="text" id="vcolour" name="vcolour" pattern="^[a-zA-Z]+$" title="Only Characters" required/>

                            <!--vehicle price-->
                            Vehicle Price
                            <input type="text" id="vprice" name="vprice" pattern="^[0-9]+$" title="Only Numbers" required/>

                            <button type="submit" name="add" class="add action-button" value="Add">Add</button>
                        </fieldset>
                    </form>
                    <br/>
                </div>

            </div>
        </div>

        <div class="jumbotron text-center" style="margin-bottom:0">
            <p>&copy; 2019 Vehicle Malaysia.com</p>
        </div>

    </body>

</html>