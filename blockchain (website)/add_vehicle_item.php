<?php
require_once('db.php');
session_start();

$vehicleBrand = $_POST["vbrand"];
$vehicleModel = $_POST["vmodel"];
$vehicleColour = $_POST["vcolour"];
$vehiclePrice = $_POST["vprice"];

if(isset($_POST['add'])){
    try{
        $statement = $conn->prepare("INSERT INTO vehicle_items
                                (vbrand,
                                vmodel,
                                vcolour,
                                vprice
                                )
                    VALUES (:vbrandValue,
                            :vmodelValue,
                            :vcolourValue,
                            :vpriceValue
                            )");

        $statement->bindParam(':vbrandValue', $vehicleBrand,PDO::PARAM_STR);
        $statement->bindParam(':vmodelValue', $vehicleModel,PDO::PARAM_STR);
        $statement->bindParam(':vcolourValue', $vehicleColour,PDO::PARAM_STR);
        $statement->bindParam(':vpriceValue', $vehiclePrice,PDO::PARAM_INT);

        $statement->execute();
    }
    catch(PDOException $e){
        echo "Error: " . $e->getMessage();
    }

    $conn = null;
    header('location: vehicle_dashboard.php');
}



?>