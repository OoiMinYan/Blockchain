<?php
require_once('db.php');
session_start();
$firstName = $_POST["buyer_fname"];
$lastName = $_POST["buyer_lname"];
$nricNumber = $_POST["buyer_nric"];
$phoneNumber = $_POST["buyer_pnumber"];
$epfNumber = $_POST["epf"];
$annualIncome = $_POST["annual"];
$payslipFile = $_POST["payslip"];
$vehicIN = $_POST["vin"];
$dateOfRegisteration = $_POST["dateRegis"];
$odoReading = $_POST["odometer"];
$vehicBrand = $_POST["brand"];
$vehicModel = $_POST["model"];
$vehicColour = $_POST["colour"];
$vehicPrice = $_POST["price"];
$bankType = $_POST["bank"];
$borrowAmount = $_POST["borrowamount"];
$overYear = $_POST["overyear"];
$monthlyInstallment = $_POST["installment"];
$signature = $_POST["signa"];
$dateApply = $_POST["dateapply"];
$sellerNric = $_POST["seller_nric"];

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

        // insert contract
        $statement_1 = $conn->prepare("INSERT INTO contracts
                                    (vin,
                                    seller_nric,
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
                                    :sellerNricValue,
                                    :nricValue,
                                    :dateofregValue,
                                    :bankValue,
                                    :borrowamountValue,
                                    :overyearValue,
                                    :installmentValue,
                                    :vehicPriceValue,
                                    :signaValue,
                                    :dateapplyValue
                                    )");

        $statement_1->bindParam(':vinValue', $vehicIN, PDO::PARAM_STR);
        $statement_1->bindParam(':sellerNricValue', $sellerNric, PDO::PARAM_STR);
        $statement_1->bindParam(':nricValue', $nricNumber, PDO::PARAM_STR);
        $statement_1->bindParam(':dateofregValue', $dateOfRegisteration, PDO::PARAM_STR);
        $statement_1->bindParam(':bankValue', $bankType, PDO::PARAM_STR);
        $statement_1->bindParam(':borrowamountValue', $borrowAmount, PDO::PARAM_INT);
        $statement_1->bindParam(':overyearValue', $overYear, PDO::PARAM_INT);
        $statement_1->bindParam(':installmentValue', $monthlyInstallment, PDO::PARAM_INT);
        $statement_1->bindParam(':vehicPriceValue', $vehicPrice, PDO::PARAM_INT);
        $statement_1->bindParam(':signaValue', $signature, PDO::PARAM_STR);
        $statement_1->bindParam(':dateapplyValue', $dateApply, PDO::PARAM_STR);

        $statement_1->execute();

        //update vehicle status to cannot sale
        $statement_2 = $conn->prepare("UPDATE vehicle_details SET status = 'cannot sale' WHERE vin = :vinValue");

        $statement_2->bindParam(':vinValue', $vehicIN, PDO::PARAM_STR);

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