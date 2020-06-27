<?php
if ((!isset($_COOKIE['user_name'])) && (!isset($_SESSION['session_active']))) {
    include 'includes/header.php';
    include 'includes/menu.php';
    
    echo '<p>You must be signed in to see this page</p>';
    
}

else {
    $title_to_menu = 'intranet.php';
    
    include 'includes/header.php';
    include 'includes/menu.php';
    
    
    
?>
		</div>
	 
        <h2>Intranet</h2>
        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor 
        incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud 
        exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure 
        dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. 
        Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt 
        mollit anim id est laborum.</p>
        



	 


<?php
    
}
include 'includes/footer.php';

?>