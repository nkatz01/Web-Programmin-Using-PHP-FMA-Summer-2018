	<?php
 $form_is_submitted = false;

if (!$form_is_submitted) {
    wipe_output_clean();
    $self = htmlentities($_SERVER['PHP_SELF']);
    generate_form_head($self, 'Create new member of staff');
    concat_title_field();
    concat_fname_field();
    concat_sname_field();
    concat_email_field();
    concat_newusername_field();
    concat_pass_field('new_pass', 'password:');
    concat_pass_field('confirm_pass', 'confirm password:');
    generate_form_tale('create', 'Create');
    generate_err_msg();
    
    
    
    
    
}

if (isset($_POST['create'])) {
    $form_is_submitted = true;
    
    if (($form_is_submitted = true) && ($errors_detected === false)) {
        $output = 'New Staff Member created';
         echo '<META HTTP-EQUIV="Refresh" Content="3; URL=' . $_SERVER['REQUEST_URI'] . '">';
        
    }
}




echo $output;




?>
  
	
 