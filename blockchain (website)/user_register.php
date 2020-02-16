<?php
require_once('db.php');
session_start();
$userName = $_POST["u_name"];
$userPass = $_POST["u_pass"];

$passwordHash = password_hash($userPass, PASSWORD_BCRYPT);

if(isset($_POST['register'])){
    try{
    	// insert owner details
        $statement = $conn->prepare("INSERT INTO user
                                    (u_name,
                                    u_pass
                                    )
                            VALUES (:usernameValue,
                                :userpassValue
                                )");

        $statement->bindParam(':usernameValue', $userName,PDO::PARAM_STR);
        $statement->bindParam(':userpassValue', $passwordHash,PDO::PARAM_STR);

        $statement->execute();

        echo "Done";
        $conn = null;
        header('location: user_login.html');
    }
    catch(PDOException $e){
        echo "Error: " . $e->getMessage();
    }

}



?>