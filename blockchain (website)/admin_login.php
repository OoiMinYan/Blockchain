<?php
require_once('db.php');
session_start();

if(isset($_POST['admin_name']))//this will tell us what to do if some data has been post through form with button.
{
    $admin_name=$_POST['admin_name'];
    $admin_pass=password_hash($_POST['admin_pass'], PASSWORD_BCRYPT);
    echo $admin_pass;

    $admin_query = "select * from admin where admin_name='$admin_name'";
    //echo $admin_query;

    $run_query = $conn->query($admin_query);

    //echo $run_query->rowCount();

    if($run_query->rowCount() > 0)
    {
        $user_result = $run_query->fetch(PDO::FETCH_ASSOC);
        if(password_verify($_POST['admin_pass'], $user_result["admin_pass"])){
            $_SESSION["user"] = $admin_name;
            echo "<script>window.open('vehicle_dashboard.php','_self')</script>";
        }
    }
    else {echo"<script>alert('Admin Details are incorrect..!')</script>";}

}

?>