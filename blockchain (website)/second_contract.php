<!DOCTYPE html>
<html lang="en">

<?php
require_once('db.php');
session_start();

if (!isset($_SESSION["user"])) {
    header("Location: user_login.html");
}

if (isset($_GET['vin'])) {
    // get seller details
    $seller_query = "SELECT * FROM contracts JOIN owner_details ON contracts.nric = owner_details.nric WHERE contracts.vin = " . $_GET['vin'] . " ORDER BY contractid DESC";
    $run_query = $conn->prepare($seller_query);
    $run_query->execute();
    $seller_result = $run_query->fetch(PDO::FETCH_ASSOC);
    //var_dump($seller_result); // debug

    // get vehicle details
    $vehicle_query = "SELECT * FROM vehicle_details WHERE vin = " . $_GET['vin'];
    $run_query = $conn->prepare($vehicle_query);
    $run_query->execute();
    $vehicle_result = $run_query->fetch(PDO::FETCH_ASSOC);
    //var_dump($vehicle_result); // debug
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

    <link rel="stylesheet" type="text/css" href="contract_style.css" />
    <script type="text/javascript" src="calculate_installment.js"></script>
</head>

<body>

    <div class="jumbotron text-center" style="margin-bottom:0">
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

    <div class="container" style="margin-top:30px">
        <div class="row">
            <div class="col-md-12">
                <h2>Create own contract.</h2>
                <h5>Buy second-hand vehicle contract.</h5>

                <form id="msform" method="post" action="apply_sec_contract.php">
                    <!-- fieldsets -->
                    <fieldset>
                        <h2 class="fs-title">Personal Details</h2>

                        <!--first name-->
                        First Name
                        <input type="text" name="buyer_fname" pattern="^[a-zA-Z]+$" title="Only Characters" required/>

                        <!--last name-->
                        Last Name
                        <input type="text" name="buyer_lname" pattern="^[a-zA-Z]+$" title="Only Characters" required/>

                        <!--NRIC / P.P number-->
                        NRIC / P.P Number
                        <input type="text" name="buyer_nric" pattern="[0-9]{12}" title="Only allow 12 digits" required/>

                        <!--phone number-->
                        Phone Number
                        <input type="text" name="buyer_pnumber" pattern="^[0-9]+$" title="Only Numbers" required/>

                        <!--EPF number-->
                        EPF Number
                        <input type="text" name="epf" pattern="[0-9]{7}" title="Only allow 7 digits" required/>

                        <!--annual-->
                        Annual Income
                        <select id="annual" name="annual" required>
                            <option value="Below RM 24,000">Below RM 24,000</option>
                            <option value="RM 24,000 ~ RM 48,000">RM 24,000 ~ RM 48,000</option>
                            <option value="RM 48,000 ~ RM 72,000">RM 48,000 ~ RM 72,000</option>
                            <option value="RM 72,000 ~ RM 96,000">RM 72,000 ~ RM 96,000</option>
                            <option value="Above RM 96,000">Above RM 96,000</option>
                        </select>

                        <!--payslip-->
                        Payslip
                        <input type="file" name="payslip" accept="image/*|file_extension" required/>

                        <h2 class="fs-title">Seller Details</h2>

                        <!--first name-->
                        First Name
                        <?php
                        if (isset($seller_result)) {
                            echo '<input type="text" name="seller_fname" value="' . $seller_result['fname'] . '" readonly/>';
                        } else {
                            // no need else, just for debug purpose
                            echo '<input type="text" name="fname" />';
                        }
                        ?>

                        <!--last name-->
                        Last Name
                        <?php
                        if (isset($seller_result)) {
                            echo '<input type="text" name="seller_lname" value="' . $seller_result['lname'] . '" readonly/>';
                        }
                        ?>

                        <!--NRIC / P.P number-->
                        NRIC / P.P Number
                        <!-- <input type="text" name="nric" /> -->
                        <?php
                        if (isset($seller_result)) {
                            echo '<input type="text" name="seller_nric" value="' . $seller_result['nric'] . '" readonly/>';
                        }
                        ?>

                        <!--phone number-->
                        Phone Number
                        <!-- <input type="text" name="pnumber" /> -->
                        <?php
                        if (isset($seller_result)) {
                            echo '<input type="text" name="seller_pnumber" value="' . $seller_result['pnumber'] . '" readonly/>';
                        }
                        ?>

                        <h2 class="fs-title">Vehicle Details</h2>
                        <!-- vehicle identification number -->
                        Vehicle Identification Number (VIN)
                        <!-- <input type="text" name="vin" /> -->
                        <?php
                        if (isset($vehicle_result)) {
                            echo '<input type="text" name="vin" value="' . $vehicle_result['vin'] . '" readonly/>';
                        }
                        ?>

                        <!-- Year/Date of registeration -->
                        Date of Registeration
                        <!-- <input type="text" name="dateRegis" /> -->
                        <?php
                        if (isset($seller_result)) {
                            echo '<input type="text" name="dateRegis" value="' . $seller_result['dateofreg'] . '" readonly/>';
                        }
                        ?>

                        <!-- odometer -->
                        Odometer Reading
                        <!-- <input type="text" name="odometer" /> -->
                        <?php
                        if (isset($vehicle_result)) {
                            echo '<input type="text" name="odometer" value="' . $vehicle_result['odometer'] . '" readonly/>';
                        }
                        ?>

                        <!-- vehicle brand -->
                        Vehicle Brand
                        <?php
                        if (isset($vehicle_result)) {
                            echo '<input type="text" name="brand" value="' . $vehicle_result['brand'] . '" readonly/>';
                        }
                        ?>

                        <!--vehicle model-->
                        Vehicle Model
                        <?php
                        if (isset($vehicle_result)) {
                            echo '<input type="text" name="model" value="' . $vehicle_result['model'] . '" readonly/>';
                        }
                        ?>

                        <!--vehicle color-->
                        Vehicle Colour
                        <?php
                        if (isset($vehicle_result)) {
                            echo '<input type="text" name="colour" value="' . $vehicle_result['colour'] . '" readonly/>';
                        }
                        ?>

                        <!--vehicle price as agreed-->
                        Vehicle Price as Agreed
                        <input type="text" id="price" name="price" pattern="^[0-9]+$" title="Only Numbers" required>

                        <h2 class="fs-title">Bank Details</h2>

                        <!--bank-->
                        Bank
                        <select id="bank" name="bank" required>
                            <option value="Public Bank">Public Bank</option>
                            <option value="CIMB Bank">CIMB Bank</option>
                        </select>

                        <!--borrow amount-->
                        Borrow Amount
                        <select id="borrowamount" name="borrowamount" onchange="calculateInstallment()" required>
                            <option value="0">0</option>
                            <option value="50000">50000</option>
                            <option value="60000">60000</option>
                            <option value="70000">70000</option>
                            <option value="80000">80000</option>
                            <option value="90000">90000</option>
                            <option value="100000">100000</option>
                        </select>

                        <!--over year-->
                        Over Year
                        <select id="overyear" name="overyear" onchange="calculateInstallment()" required>
                            <option value="5">5</option>
                            <option value="6">6</option>
                            <option value="7">7</option>
                            <option value="8">8</option>
                            <option value="9">9</option>
                            <option value="10">10</option>
                        </select>

                        <!--monthly installment-->
                        Monthly Installment
                        <input readonly="true" type="text" id="installment" name="installment" />

                        <h2 class="fs-title">Signature Details</h2>

                        <!--signature-->
                        Signature
                        <textarea name="signa" placeholder="Signature" required></textarea>

                        <!--date-->
                        Date
                        <input type="date" name="dateapply" required>
                        <input type="submit" name="apply" class="apply action-button" value="Apply" />
                    </fieldset>
                </form>

            </div>
            <br>



        </div>
    </div>

    <div class="jumbotron text-center" style="margin-bottom:0">
        <p>&copy; 2019 Trusted Dealer Malaysia.com</p>
    </div>

</body>

</html>