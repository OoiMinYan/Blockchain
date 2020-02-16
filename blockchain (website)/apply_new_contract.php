<?php
require_once('db.php');
session_start();
$firstName = $_POST["fname"];
$lastName = $_POST["lname"];
$nricNumber = $_POST["nric"];
$phoneNumber = $_POST["pnumber"];
$epfNumber = $_POST["epf"];
$annualIncome = $_POST["annual"];
$payslipFile = $_POST["payslip"];
$vehicBrand = $_POST["vbrand"];
$vehicModel = $_POST["vmodel"];
$vehicColour = $_POST["vcolour"];
$vehicPrice = $_POST["vprice"];
$bankType = $_POST["bank"];
$borrowAmount = $_POST["borrowamount"];
$overYear = $_POST["overyear"];
$monthlyInstallment = $_POST["installment"];
$signature = $_POST["signa"];
$dateApply = $_POST["dateapply"];

function generateVin() {
    return rand(10000,99999).rand(10000000,99999999); //generate 13 digits vin
}

$vinValue = generateVin();

if(isset($_POST['apply'])){
    try{
    	// insert owner details
        $statement = $conn->prepare("INSERT INTO owner_details
                                    (nric,
                                    fname,
                                    lname,
                                    pnumber,
                                    epf,
                                    annual,
                                    payslip
                                    )
                            VALUES (:nricValue,
                                :fnameValue,
                                :lnameValue,
                                :pnumberValue,
                                :epfValue,
                                :annualValue,
                                :payslipValue
                                )");

        $statement->bindParam(':nricValue', $nricNumber,PDO::PARAM_STR);
        $statement->bindParam(':fnameValue', $firstName,PDO::PARAM_STR);
        $statement->bindParam(':lnameValue', $lastName,PDO::PARAM_STR);
        $statement->bindParam(':pnumberValue', $phoneNumber,PDO::PARAM_STR);
        $statement->bindParam(':epfValue', $epfNumber,PDO::PARAM_STR);
        $statement->bindParam(':annualValue', $annualIncome,PDO::PARAM_STR);
        $statement->bindParam(':payslipValue', $payslipFile,PDO::PARAM_STR);

        $statement->execute();

        // insert vehicle_details
        $statement_1 = $conn->prepare("INSERT INTO vehicle_details
                                (vin,
                                brand,
                                model,
                                colour,
                                price
                                )
                    VALUES (:vinValue,
                            :brandValue,
                            :modelValue,
                            :colourValue,
                            :priceValue
                            )");

        $statement_1->bindParam(':vinValue', $vinValue, PDO::PARAM_STR);
        $statement_1->bindParam(':brandValue', $vehicBrand,PDO::PARAM_STR);
        $statement_1->bindParam(':modelValue', $vehicModel,PDO::PARAM_STR);
        $statement_1->bindParam(':colourValue', $vehicColour,PDO::PARAM_STR);
        $statement_1->bindParam(':priceValue', $vehicPrice,PDO::PARAM_INT);

        $statement_1->execute();
        // $vinValue = $conn -> lastInsertId();

        // insert contract
        $statement_2 = $conn->prepare("INSERT INTO contracts
                                    (vin,
                                    nric,
                                    dateofreg,
                                    bank,
                                    borrowamount,
                                    overyear,
                                    installment,
                                    vprice,
                                    signa,
                                    dateapply
                                    )
                            VALUES (:vinValue,
                                    :nricValue,
                                    :dateofregValue,
                                    :bankValue,
                                    :borrowamountValue,
                                    :overyearValue,
                                    :installmentValue,
                                    :priceValue,
                                    :signaValue,
                                    :dateapplyValue
                                    )");

        $statement_2->bindParam(':vinValue', $vinValue, PDO::PARAM_STR);
        $statement_2->bindParam(':nricValue', $nricNumber, PDO::PARAM_STR);
        $statement_2->bindParam(':dateofregValue', $dateApply, PDO::PARAM_STR);
        $statement_2->bindParam(':bankValue', $bankType, PDO::PARAM_STR);
        $statement_2->bindParam(':borrowamountValue', $borrowAmount, PDO::PARAM_INT);
        $statement_2->bindParam(':overyearValue', $overYear, PDO::PARAM_INT);
        $statement_2->bindParam(':installmentValue', $monthlyInstallment, PDO::PARAM_INT);
        $statement_2->bindParam(':priceValue', $vehicPrice,PDO::PARAM_INT);
        $statement_2->bindParam(':signaValue', $signature, PDO::PARAM_STR);
        $statement_2->bindParam(':dateapplyValue', $dateApply, PDO::PARAM_STR);

        $statement_2->execute();

        echo "Done";
        $conn = null;
        header('location: dashboard.php');
    }
    catch(PDOException $e){
        echo "Error: " . $e->getMessage();
    }

}



?>