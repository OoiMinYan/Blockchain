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

    <link rel="stylesheet" type="text/css" href="contract_style.css" />
    <script type="text/javascript" src="calculate_installment.js"></script>
    <script type="text/javascript" src="vehicle_item.js"></script>
    <!-- <script type="text/javascript" src="electronicSignature.js"></script> -->
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
                <h5>Buy new vehicle contract.</h5>

                <form id="msform" method="post" action="apply_new_contract.php">
                    <!-- fieldsets -->
                    <fieldset>
                        <h2 class="fs-title">Personal Details</h2>

                        <!--first name-->
                        First Name
                        <input type="text" name="fname" pattern="^[a-zA-Z]+$" title="Only Characters" required/>

                        <!--last name-->
                        Last Name
                        <input type="text" name="lname" pattern="^[a-zA-Z]+$" title="Only Characters" required/>

                        <!--NRIC / P.P number-->
                        NRIC / P.P Number
                        <input type="text" name="nric" pattern="[0-9]{12}" title="Only allow 12 digits" required/>

                        <!--phone number-->
                        Phone Number
                        <input type="text" name="pnumber" pattern="^[0-9]+$" title="Only Numbers" required/>

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

                        <h2 class="fs-title">Vehicle Details</h2>

                        <!-- vehicle brand -->
                        Vehicle Brand
                        <?php
                        $sql_brand = "SELECT DISTINCT vbrand FROM vehicle_items";

						echo '<select id="vbrand" name="vbrand" oninput="updateVehicleModel();">';

						foreach($conn->query($sql_brand) as $row){
                            //var_dump($row);
                            echo '<option value = "' . $row["vbrand"] . '" >' . $row["vbrand"] . "</option>";
						}

						echo '</select>';
						?>

                        <!--vehicle model-->
                        Vehicle Model
                        <select id="vmodel" name="vmodel" onchange="updateVehicleColour()"></select>
                        <script type="text/javascript">
                            updateVehicleModel();
                        </script>

                        <!--vehicle color-->
                        Vehicle Colour
                        <select id="vcolour" name="vcolour"></select>

                        <!--vehicle price as agreed-->
                        Vehicle Price as Agreed
                        <input readonly="true" type="text" id="vprice" name="vprice"></input>

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