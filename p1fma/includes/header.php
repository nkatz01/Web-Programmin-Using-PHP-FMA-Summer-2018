<?php
session_start();


$login_form_is_submitted = false;

include_once 'process.php';
 


//user hasn't signed in yet 
If ((!isset($_SESSION['session_active'])) && (!isset($_COOKIE['user_name']))) {
    
    $self = htmlentities($_SERVER['PHP_SELF']);
    generate_form_head($self, 'Sign into the Site');
    concat_username_field();
    concat_pass_field('pass', 'password:');
    generate_form_tale('log_in', 'Login');
    generate_err_msg();  
    
    
}


if (isset($_POST['log_in'])) {
    
    //WILL HAPPEN ONCE ATTEMPT TO SUBMIT HAS BEEN MADE
    $login_form_is_submitted = true;
    
    
    
    
    
    
    
    
    if ($login_form_is_submitted === true && $errors_detected === false) {
        
        wipe_output_clean();
        $_SESSION['session_active'] = 'You\'re logged in successfully';
        session_regenerate_id();
	
    }
    
}




if ((isset($_SESSION['session_active'])) || (isset($_COOKIE['user_name']))) { //SHOW LOGOUT BUTTON IF  
    
    
    $self   = htmlentities($_SERVER['PHP_SELF']);
    $output = '<form action="' . $self . '" method="post">
				<fieldset>
<div>
<input type="submit" name="log_out" value="Log out" /> </div>
</fieldset>
			</form><p>' . $output . '</p>';
    
    
}


if (isset($title_to_header)) { //CHANGE HEADER IF INCOMING FILES ARE FROM DATA
    include 'headerdata.php';
} else {
?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
    <title>DCS Department</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	
</head>
<body>
	<div id="page">
	
	  <?php
}
echo $output;
 	
		 
		//header("Location:  http://titan.dcs.bbk.ac.uk/~nkatz01/p1fma/index.php");
		
		
if (isset($_POST['log_in'])) {
    
    if ($login_form_is_submitted === true && $errors_detected === false) {
        
        echo $_SESSION['session_active'];
        echo '<META HTTP-EQUIV="Refresh" Content="3; URL=' . $_SERVER['REQUEST_URI'] . '">';
    }
}





if (isset($_COOKIE['user_name'])) {
    $h1 = '<h1>Welcome to DCS: ' . $_COOKIE['user_name'] . '</h1>';
    
} else if (isset($_SESSION['session_active']) and isset($_SESSION['user_name'])) {
	
    
    $h1 = '<h1>Welcome to DCS: ' . $_SESSION['user_name'] . '</h1>';
} else {
    $h1 = "<h1>Welcome to DCS</h1>";
    
}
echo $h1;
 
  
 
if (isset($_POST['log_out'])) {
    //DESTROY SESSION IF USER LOGS OUT
    $_SESSION = array();
    if (ini_get('session.use_cookies')) {
        $back_date   = time() - (2 * 24 * 60 * 60);
        $parameteres = session_get_cookie_params();
        setcookie(session_name(), '', $back_date, $parameteres['path'], $parameteres['domain'], $parameteres['secure'], $parameteres['httponly']);
        setcookie('user_name', '', $back_date, '/');
        setcookie('is_admin', '', $back_date, '/');
        
    }
    session_destroy();
    header("Location:  http://titan.dcs.bbk.ac.uk/~nkatz01/p1fma/index.php");
    
}


?>
		