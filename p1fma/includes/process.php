<?php

$correctly_entered_data = array(
    'title' => '',
    'firstname' => '',
    'surname' => '',
    'email' => '',
    'user_name' => '',
	'newuser_name' => ''
);

$output = '';
$clean  = array();
$errors = array();

$errors_detected = false;

$is_admin = false;

function redisplay_data_in_field($field_name) {
    global $clean;
    global $correctly_entered_data;
    if (isset($_POST["$field_name"])) {
        switch ($field_name) {
            case ($field_name == 'user_name'): {
                process_username();
                break;
            }
			case ($field_name == 'newuser_name'): {
                process_newusername($field_name);
                break;
            }
            case ($field_name == 'pass'): {
                process_pass();
                check_if_admin();
                break;
            }
            case ($field_name == 'new_pass'): {
                process_new_pass($field_name);
                break;
            }
            case ($field_name == 'confirm_pass'): {
                process_confirm_pass($field_name); //confirmpass branch in processnewpass func
                break;
            }
            
            case ($field_name == 'title'): {
                process_title();
                break;
            }
            case ($field_name == 'firstname'): {
                process_textfield($field_name);
                break;
            }
            case ($field_name == 'surname'): {
                process_textfield($field_name);
                break;
            }
            case ($field_name == 'email'): {
                process_email();
                break;
            }
        }
        if (isset($clean["$field_name"])) {
            $correctly_entered_data["$field_name"] = htmlentities($clean["$field_name"]);
        }
        
        
        else {
            $correctly_entered_data["$field_name"] = '';
        }
    }
    
    return;
}

function process_username() {
    global $clean;
    global $errors;
    global $errors_detected;
    
    if (isset($_POST['user_name'])) {
        $trimmed = trim($_POST['user_name']);
        $length  = strlen($trimmed);
        if ($length >= 1) {
            $clean['user_name'] = $trimmed;
        } else {
            $errors_detected = true;
            $errors[]        = 'User name is required';
        }
    } else {
        $errors_detected = true;
        $errors[]        = 'User name not submitted';
    }
    return;
    
}

function process_newusername($field_name) {
    global $clean;
    global $errors;
    global $errors_detected;
    
    if (isset($_POST["$field_name"])) {
        $trimmed = trim($_POST["$field_name"]);
        $length  = strlen($trimmed);
        if ($length >= 1) {
			$handle_to_directory = opendir('../../settings');
			$handle_to_file      = fopen('../../settings/passwords.txt', 'r');
			if (find_and_compare_username($trimmed, $handle_to_file) == false) {
            $clean['newuser_name'] = $trimmed;}
			else{
				$errors_detected = true;
				$errors[]        = 'Sorry, this user name already exists';
			}
			fclose($handle_to_file);
			closedir($handle_to_directory);
        } else {
            $errors_detected = true;
            $errors[]        = 'User name is required';
        }
    } else {
        $errors_detected = true;
        $errors[]        = 'User name not submitted';
    }
    return;
    
}

function process_pass() {
    global $clean;
    global $errors;
    global $errors_detected;
    
    global $is_admin;
    if (isset($_POST['pass'])) {
        $trimmed = trim($_POST['pass']);
        if (ctype_alnum($trimmed) && (strlen(trim($trimmed)) > 0)) {
			$handle_to_directory = opendir('../../settings'); 
                $handle_to_file      = fopen('../../settings/admin.txt', 'r');
                $str                 = fgets($handle_to_file, 1024);
                if (trim($str) == ($trimmed)) {
                    $_SESSION['is_admin'] = true;
                    setcookie('is_admin', true, 0, '/');
                    fclose($handle_to_file);
					closedir($handle_to_directory);
					setCookies('user_name');
					return;
                }
				else {
					fclose($handle_to_file);
					closedir($handle_to_directory);
					$trimmed.=$clean['user_name'];
					
					$handle_to_directory = opendir('../../settings');
					$handle_to_file      = fopen('../../settings/passwords.txt', 'r');
				
				if (find_and_compare_pass($trimmed, $handle_to_file) == true) {
					$clean['pass'] = $trimmed;
					fclose($handle_to_file);
					closedir($handle_to_directory);
					
					setCookies('user_name');  
					
				}
				else {
					$errors_detected = true;
					$errors[]        = 'Password not recognised';
					
				}
				
			}
					

				
            
            
     }   
	 else {
            $errors_detected = true;
            $errors[]        = 'Password is invalid - Please enter your password';
            
        }
    
	
	
	}
    else {
        $errors_detected = true;
        $errors[]        = 'Password not submitted';
    }
    
    return;
    
}

function process_new_pass($field_name) {
    global $clean;
    global $errors;
    global $errors_detected;
     if (isset($_POST["$field_name"])) {
        $trimmed = trim($_POST["$field_name"]);
        if (ctype_alnum($trimmed) && (strlen(trim($trimmed)) > 0)) {
            
            $handle_to_directory = opendir('../../settings');
            $handle_to_file      = fopen('../../settings/passwords.txt', 'a+');
             
            
            if (find_and_compare_pass($trimmed, $handle_to_file) == false && isset($clean['newuser_name'])) {
                fwrite($handle_to_file, "$trimmed" . ','.$clean['newuser_name']. PHP_EOL);
                $clean['new_pass'] = $trimmed;
            }
            
            elseif (isset($clean['newuser_name'])) {
                $errors_detected = true;
                $errors[]        = 'password already exists';
               
            }
             fclose($handle_to_file);
             closedir($handle_to_directory);
            
            
        } else {
            $errors_detected = true;
            $errors[]        = 'Please enter a password - Only use alphanumeric characters';
        }
        
    } else {
        
        $errors_detected = true;
        $errors[]        = 'Password not submitted';
    }
    
    
    
    return;
    
    
}

function process_confirm_pass($field_name) {
    global $clean;
    global $errors;
    global $errors_detected;
    if (isset($_POST["$field_name"])) {
        $trimmed = trim($_POST["$field_name"]);
        if (ctype_alnum($trimmed) && (strlen(trim($trimmed)) > 0)) {
            if (isset($clean['new_pass'])) {
                if ($trimmed == $clean['new_pass']) {
                    $clean['confirm_pass'] = $trimmed;
                }
                
                else {
                    $errors_detected = true;
                    $errors[]        = 'Password confirmation doesn\'t match';
                }
            } else { {
                    $errors_detected = true;
                    $errors[]        = 'Passwords confirmation has to match with what has been entered before - please enter your password again';
                }
            }
            
        } else {
            $errors_detected = true;
            $errors[]        = 'Please confirm your password - Password confirmation invalid';
        }
        
        
    } else {
        $errors_detected = true;
        $errors[]        = 'Password not confirmed';
    }
    return;
}
function find_and_compare_pass($value, $handle) {
    $found = false;
    
    while (!feof($handle)) {
        $val = explode(',', fgets($handle, 1024));
		if (isset($val[1])){
			$valPlusVal= $val[0].$val[1];
		}
		else {
			$valPlusVal= $val[0];
		}
		
        if (trim($valPlusVal) == $value) {
            $found = true;
            break 1;
        }
        
    }
    
    if ($found == true) {
        return true;
    } else {
        return false;
    }
      
}

function find_and_compare_username($value, $handle) {
    $found = false;
    
    while (!feof($handle)) {
        $val = explode(',', fgets($handle, 1024));
		if (isset($val[1])){
			$valPlusVal=  $val[1];
		}
		else {
			$valPlusVal= $val[0];
		}
        if (trim($valPlusVal) == $value) {
            $found = true;
            break 1;
        }
        
    }
    
    if ($found == true) {
        return true;
    } else {
        return false;
    }
      
}

function process_title() {
    global $clean;
    global $errors;
    global $errors_detected;
    
    if (isset($_POST['title']) && (($_POST['title']) != '')) {
        $clean['title'] = trim(($_POST['title']));
    }
    
    else {
        $errors_detected = true;
        $errors[]        = 'You have to select title';
    }
    
    return;
}

function process_textfield($field_name) {
    global $clean;
    global $errors;
    global $errors_detected;
    
    if (isset($_POST["$field_name"])) {
        $trimmed = trim($_POST["$field_name"]);
        $length  = strlen($trimmed);
        if ($length >= 1) {
            $clean["$field_name"] = $trimmed;
        } else {
            $errors_detected = true;
            $errors[]        = "$field_name is required";
        }
    } else {
        $errors_detected = true;
        $errors[]        = "$field_name not submitted";
    }
    return;
    
    
}


function process_email() {
    global $clean;
    global $errors;
    global $errors_detected;
    
    if (isset($_POST['email']) and ($_POST['email']) != '') {
        $trimmed = trim($_POST['email']);
        if ((filter_var($trimmed, FILTER_VALIDATE_EMAIL)) == true) {
            $clean['email'] = $trimmed;
        } else {
            $errors_detected = true;
            $errors[]        = 'invalid email';
        }
    }
    
    else {
        $errors_detected = true;
        $errors[]        = 'Email not submitted';
        
    }
    
    return;
    
}





function check_if_admin() {
    
    if (isset($_COOKIE['is_admin'])) {
        
        
        if ($_COOKIE['is_admin'] == true) {
            return true;
        } else {
            
            return false;
            
        }
    }
    
    else if (isset($_SESSION['is_admin'])) {
        if ($_SESSION['is_admin'] == true) {
            return true;
        } else {
            
            return false;
            
        }
    }
    
    
    else {
        
        return false;
        
    }
}

function generate_form_head($action_address, $legend) {
    global $output;
    $output .= '<form action="' . $action_address . '" method="post">
				<fieldset>
					<legend>' . $legend . '</legend>';
    
}




function concat_username_field() {
    global $correctly_entered_data;
    global $output;
    redisplay_data_in_field('user_name');
    
    $output .= '<div>
				<label for="username">User Name:</label>
                    <input type="text" name="user_name" id="username"  value="' . $correctly_entered_data['user_name'] . '" />
				</div>';
    return;
}

function concat_newusername_field() {
    global $correctly_entered_data;
    global $output;
    redisplay_data_in_field('newuser_name');
    
    $output .= '<div>
				<label for="newusername">User Name:</label>
                    <input type="text" name="newuser_name" id="newusername"  value="' . $correctly_entered_data['newuser_name'] . '" />
				</div>';
    return;
}

function concat_title_field() {
    global $correctly_entered_data;
    global $output;
    redisplay_data_in_field('title');
    $output .= '<div  >
			<label for="title">Title</label>
			<select  name="title" id="title">
				<option selected value="' . $correctly_entered_data['title'] . '">' . $correctly_entered_data['title'] . '</option>
				<option value="Mrs">Mrs</option>
				<option value="Miss">Miss</option>
				<option value="Ms">Ms</option>
				<option value="Mr">Mr</option>

			</select>
		</div>';
    return;
}


function concat_fname_field() {
    global $correctly_entered_data;
    global $output;
    redisplay_data_in_field('firstname');
    
    $output .= '<div  >
			<label for="fname">First name</label>
			<input  type="text" name="firstname" id="fname" value="' . $correctly_entered_data['firstname'] . '" />
		</div>
				';
    
    return;
}

function concat_sname_field() {
    global $correctly_entered_data;
    redisplay_data_in_field('surname');
    global $output;
    
    $output .= '<div >
			<label for="sname">Surname</label>
			<input  type="text" name="surname" id="sname" value="' . $correctly_entered_data['surname'] . '" />
		</div>';
    return;
}

function concat_email_field() {
    global $correctly_entered_data;
    global $output;
    redisplay_data_in_field('email');
    
    
    $output .= '<div>
			 <label for="mail"> Your email address</label>
			 <input    type="text" name="email" id="mail" value="' . $correctly_entered_data['email'] . '" placeholder="Your full email address"/>
		</div>';
    return;
}



function concat_pass_field($name, $label) {
    global $correctly_entered_data;
    global $output;
    redisplay_data_in_field($name);
    $output .= '<div>
					 <label  for="pwd">' . $label . ' </label>
						<input  type="password" name="' . $name . '" id="pwd"/>
					</div>';
    return;
}



function generate_form_tale($name, $value) {
    global $output;
    $output .= '<input type="submit" name="' . $name . '" value="' . $value . '" />

				</fieldset>
			</form>';
    
    return;
    
}













function authorErrorMsg() {
    global $output;
    global $errors;
    $output .= '<p>Oh oh: You\'ve done something wrong:</p>';
    $output .= '<ul>';
    foreach ($errors as $reason) {
        
        $output .= '<li>' . htmlentities($reason) . '</li>';
    }
    $output .= '</ul>';
    
    
    
    
    return;
    
}


function generate_err_msg()  
    {
    
    global $errors_detected;
    
    if ($errors_detected === true) { //FORM HAS BEEN SUBMITTED BUT ERRORS DETEC
        authorErrorMsg();
    }
    
    //SHOW THE FORM AGAIN BUT WITH CORRECT DATA PREFILED
    
    
    
}



function setCookies($field_name) {
    global $output;
    global $clean;
    if (isset($clean["$field_name"])) {
        $_SESSION["$field_name"] = htmlentities($clean["$field_name"]);
        setcookie("$field_name", htmlentities($clean["$field_name"]), 0, '/');
        
    }
    return;
    
}

function wipe_output_clean() {
    global $output;
    $output = '';
    
    return;
}



















?>