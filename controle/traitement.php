<?php
      global $user;
      global $logger;
     
      $id;
      $uname="";
      $mail="";
      $pwd="";
      $c_pwd=""; 
      $utype="";
      $type="";
  

 if(isset($_POST['ins']))
 {
    $uname=$_POST['uname'];
    $mail=$_POST['mail'];
    $pwd=$_POST['pwd'];
    $c_pwd=$_POST['c_pwd'];
    $utype=$_POST['utype'];
    $ins=$user->add_user($uname,$mail,$pwd,$utype,$c_pwd);
    if($ins)
    {

        echo"<script>alert('Congratulation Inscription Complete')</script>";
    }
    else
    {
        var_dump("echec des echecs");
    }
 }
 if(isset($_POST['con']))
 {
    var_dump($logger);
    $mail=$_POST['mail'];
    $pwd=$_POST['pwd'];
    $uname=$_POST['uname'];
    if (empty($_POST["remember_me"])) 
    {
        $remember_me=false;
    }
    else
    {
        $remember_me=true;
    }
    $con=$logger->connect_user($uname,$mail,$pwd,$remember_me);
    if($con)
    {
      
        echo"<script>alert('Congratulation connexion Complete')</script>";
      
        if($_SESSION['utype']=="Admin-1")
        {
       
            
            echo "<script>window.location.href='admin_dashboard/admin1_only.php';</script>";
            exit;       
        }
        elseif($_SESSION['utype']=="Admin-2")
        {
            echo "<script>window.location.href='admin_dashboard/admin2.php';</script>";

         
        }
        elseif($_SESSION['utype']=="classic")
        {
          
            echo "<script>window.location.href='admin_dashboard/user_board.php';</script>";

           
        }
        else
        {
           

            echo"<script>alert('you are in our database but you....')</script>";
        }

    }
 }

 if(isset($_POST['update']))
 {
    if(isset($_POST['uname'])&& !empty($_POST['uname']) )
    {
        $uname=$_POST['uname'];
        
    }
    if(isset($_POST['pwd'])&& !empty($_POST['pwd']) )
    {
        $pwd=$_POST['pwd'];
        
    }
    if(isset($_POST['mail'])&& !empty($_POST['mail']) )
    {
        $mail=$_POST['mail'];
        
    }
    if(isset($_POST['utype'])&& !empty($_POST['utype']) )
    {
        $utype=$_POST['utype'];
        
    }
    $update=$user->update_user($uname,$mail,$pword,$utype);
    if ($update) 
    {
        echo"<script>alert('You have deleted')</script>";

    }
 }
 if(isset($_POST['delete']))
 {

    
     if ($_POST['del']) 
     {
        if(isset($_POST["id"])&& !empty($_POST["id"]))
        {
            $id=$_POST["id"];
        }
        $delete=$user->delete_user($id);
     }

 }

?>