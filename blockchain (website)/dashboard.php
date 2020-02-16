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

    <link rel="stylesheet" type="text/css" href="dashboard_style.css" />
</head>

<body>

    <div class="jumbotron text-center">
        <h1>Trusted Dealer Malaysia</h1>
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
                    <a class="nav-link" href="user_logout.php">Logout</a>
                </li>
            </ul>
        </div>
    </nav>

    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h2>Contract</h2>
                <h5>Create own contract.</h5>
            </div>
            <br>
        </div>

        <div class="row">
            <div class="col-md-6">
                <div class="card">
                    <img class="card-img-top" src="image\image.jpg" alt="Card image">
                    <div class="card-body">
                        <h4 class="card-title">New Car Contract</h4>
                        <p class="card-text">Click here for create own contract about buy new car.</p>
                        <a href="new_contract.php" class="btn btn-danger">Buy new car</a>
                    </div>
                </div>
                <br/>
            </div>

            <div class="col-md-6">
                <div class="card">
                    <img class="card-img-top" src="image\image.jpg" alt="Card image">
                    <div class="card-body">
                        <h4 class="card-title">Second-hand Car Contract</h4>
                        <p class="card-text">Click here for create own contract about buy second-hand car.</p>
                        <a href="display_sold.php" class="btn btn-danger">Buy second-hand car</a>
                    </div>
                </div>
                <br/>
            </div>

            <!-- <div class="col-lg-4">
                <div class="card" style="width:320px; height:500px">
                    <img class="card-img-top" src="image\image.jpg" alt="Card image" style="width:100%; height:250px">
                    <div class="card-body">
                        <h4 class="card-title">Sell Car Contract</h4>
                        <p class="card-text">Click here for create own contract about sell car.</p>
                        <a href="sellContract.html" class="btn btn-danger">Sell car</a>
                    </div>
                </div>
                <br/>
            </div> -->

        </div>
    </div>

    <div class="jumbotron text-center" style="margin-bottom:0">
        <p>&copy; 2019 Trusted Dealer Malaysia.com</p>
    </div>

</body>

</html>