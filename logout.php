<?php
    include_once 'autoload.php';
    
    Session::delete('email');
  
    URL::redirect("login.php");
    
?>