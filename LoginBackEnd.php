<?php

session_start();
require_once('includes/connection.php');

    if(isset($_POST['login']))
    {
        if(empty($_POST['email_user']) || empty($_POST['password']))
        {
            header("location:index.php?empty");
            exit();
        }
        else
        {
            $Email_User = mysqli_real_escape_string($con, $_POST['email_user']);
            $Password = mysqli_real_escape_string($con, $_POST['password']);

            $query = "SELECT * FROM user_data WHERE Email='".$Email_User."' OR UName='".$Email_User."'";
            $result = mysqli_query($con,$query);

            if($row = mysqli_fetch_assoc($result))
            {
                $Hash = password_verify($Password, $row['Password']);
                
                if($Hash==false)
                {
                header("location:index.php?pass_invalid");
                exit();
                }
                elseif($Hash==true)
                {
                    $_SESSION['MemberID']=$row['ID'];
                    $MemberID = $row['ID'];
                    header("location:DetailsFrontEnd.php?success=$MemberID");
                }
            } else {
                header("location:index.php?status");
                exit();
            }   
        }        
    }
    if(isset($_POST['admin']))
    {
        if(empty($_POST['email_user']) || empty($_POST['password']))
        {
            header("location:admin.php?empty");
            exit();
        }
        else
        {
            $Email_User = mysqli_real_escape_string($con, $_POST['email_user']);
            $Password = mysqli_real_escape_string($con, $_POST['password']);

            $query = "SELECT * FROM admin WHERE Email='".$Email_User."' OR UName='".$Email_User."'";
            $result = mysqli_query($con,$query);
          
            if($row = mysqli_fetch_assoc($result))
            {
                $Hash = password_verify($Password, $row['Password']);
                
                if($Hash==false)
                {
                header("location:admin.php?leader_password_invalid");
                exit();
                }
                elseif($Hash==true)
                {
                    $_SESSION['admin']=$row['AdminID'];
                    $admin = $row['AdminID'];
                    header("location:AdminPanelFrontEnd.php?success=$admin");
                }
            }
            else
            {
                header("location:admin.php?status");
                exit();
            }
        }
    }
    // else
    // {
    //     header("location:login.php");
    //     exit();
    // }




?>