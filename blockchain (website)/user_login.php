<?php
require_once('db.php');
session_start();

if(isset($_POST['u_name']))//this will tell us what to do if some data has been post through form with button.
{
    $u_name=$_POST['u_name'];

    $user_query = "select * from user where u_name='$u_name'";
    //echo $admin_query;

    $run_query = $conn->query($user_query);

    //echo $run_query->rowCount();

    if($run_query->rowCount() > 0)
    {
        $user_result = $run_query->fetch(PDO::FETCH_ASSOC);
        if(password_verify($_POST['u_pass'], $user_result["u_pass"])){
            $_SESSION["user"] = $u_name;
            echo "<script>window.open('dashboard.php','_self')</script>";
        }
    }
    else {echo"<script>alert('User Details are incorrect..!')</script>";}

}

?>