<?php
include_once 'includes/header.php';

if ((!(isset($_COOKIE['user_name']) || isset($_SESSION['session_active']))) || (check_if_admin() == false)) {
    include 'includes/menu.php';
    
    echo 'You must be an admin in to see this page';
     echo '<META HTTP-EQUIV="Refresh" Content="3; URL=' . ' http://titan.dcs.bbk.ac.uk/~nkatz01/p1fma/index.php' . '">';
    
}

else {
    
    $title_to_menu = 'admin.php';
    
    include 'includes/menu.php';
    
    
    
    
    
    
?>
		<div>
		
        <h2>Administration</h2>
        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor 
        incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud 
        exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure 
        dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. 
        Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt 
        mollit anim id est laborum.</p>
        
		


		</div>

	
<?php
    include_once 'includes/form.php';
}
include 'includes/footer.php';



?>