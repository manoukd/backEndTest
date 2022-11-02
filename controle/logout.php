<?php
     
             session_unset();
             session_destroy();
             header("Location:".__DIR__."/../index.php");
     
?>