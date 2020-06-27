<?php

$pages = array();


if (isset($title_to_menu) && $title_to_menu == 'intranet.php') {
    
    
    $pages = array(
        'index.php' => 'Home',
        'admin.php' => 'Administration',
        'emptyLine' => '',
        'data/DTresults.php' => 'Introduction to Database Technology - DT Results',
        'data/P1results.php' => 'Web Programming using PHP - P1 Results',
        'data/PfPresults.php' => 'Problem Solving for Programming'
    );
    
    
}

else {
    
    
    
    $pages = array(
        'index.php' => 'Home',
        'intranet.php' => 'intranet',
        'admin.php' => 'Administration'
    );
    
    
    
    
}


$menu = '<ul>' . PHP_EOL;
foreach ($pages as $url => $title) {
    $menu .= '<li><a href="' . $url . '">' . $title . '</a></li>' . PHP_EOL;
}
$menu .= '</ul>' . PHP_EOL;
?>

 <div class="nav">
 <?php
// Echo the completed HTML menu
echo $menu;

























?>