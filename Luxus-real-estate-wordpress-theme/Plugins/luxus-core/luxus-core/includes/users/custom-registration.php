<?php if ( ! defined( 'ABSPATH' )  ) { die; } // Cannot access directly.

// Registration Form
function luxus_registration_form( $username, $email, $first_name, $last_name, $password, $password_conf, $role ) {
    global $username, $email, $first_name, $last_name, $password, $password_conf, $role;

   echo '
    <form class="custom-registration" action="' . $_SERVER['REQUEST_URI'] . '" method="post">
        <div class="row gx-3">
            <div class="form-group col-lg-12">
                <h5 class="heading">'. __('User Registration', 'luxus-core') .'</h5>
            </div>
            <div class="col-lg-6">
                <div class="form-floating">
                    <input type="text" name="username" value="' . ( isset( $_POST['username'] ) ? $username : null ) . '" class="form-control" id="username" placeholder="'. __('johndoe', 'luxus-core') .'">
                    <label for="username">'. __('Username*', 'luxus-core') .'</label>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="form-floating">
                    <input type="email" name="email" value="' . ( isset( $_POST['email']) ? $email : null ) . '" class="form-control" id="email" placeholder="'. __('john@abc.com', 'luxus-core') .'">
                    <label for="email">'. __('Email', 'luxus-core') .'</label>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="form-floating">
                    <input type="text" name="first_name" value="' . ( isset( $_POST['first_name']) ? $first_name : null ) . '" class="form-control" id="first_name" placeholder="'. __('John', 'luxus-core') .'">
                    <label for="first_name">'. __('First Name*', 'luxus-core') .'</label>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="form-floating">
                    <input type="text" name="last_name" value="' . ( isset( $_POST['last_name']) ? $last_name : null ) . '" class="form-control" id="last_name" placeholder="'. __('Doe', 'luxus-core') .'">
                    <label for="last_name">'. __('Last Name*', 'luxus-core') .'</label>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="form-floating">
                    <input type="password" name="password" value="' . ( isset( $_POST['password']) ? $password : null ) . '" class="form-control" id="password" placeholder="'. __('Enter your password', 'luxus-core') .'">
                    <label for="password">'. __('Password*', 'luxus-core') .'</label>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="form-floating">
                    <input type="password" name="password_conf" value="' . ( isset( $_POST['password_conf']) ? $password_conf : null ) . '" class="form-control" id="password_conf" placeholder="'. __('Confirm your password', 'luxus-core') .'">
                    <label for="password_conf">'. __('Confirm Password*', 'luxus-core') .'</label>
                </div>
            </div>
            <div class="col-lg-12">
                <div class="form-floating">
                    <select name="role" class="form-select" id="role" aria-label="'. __('Select Account type', 'luxus-core') .'">
                        <option value="" selected >Please Select Role</option>
                        <option value="agent" '. ( $role == 'agent' ? 'selected' : null ) .'>'. __('Agent', 'luxus-core') .'</option>
                        <option value="agency" '. ( $role == 'agency' ? 'selected' : null ) .'>'. __('Agency', 'luxus-core') .'</option>
                        <option value="subscriber" '. ( $role == 'subscriber' ? 'selected' : null ) .'>'. __('Subscriber', 'luxus-core') .'</option>
                    </select>
                    <label for="role">'. __('Select Account Type*', 'luxus-core') .'</label>
                </div>
            </div>
            <div class="col-lg-12">
            ' . wp_nonce_field( "sl_registration_form_action", "sl_registration_form_nonce" ) . '
                <input type="submit" name="submit" value="'. __('Register', 'luxus-core') .'" id="register-user-submit" />
            </div>
        </div>
    </form>
    ';
}

// Form Validation
function luxus_registration_form_validation( $username, $email, $first_name, $last_name, $password, $password_conf, $role )  {

    $users_can_register = get_option('users_can_register');

    if ( $users_can_register ) {

        global $luxus_error;
        $luxus_error = new WP_Error;

        if ( empty( $username ) || empty( $email ) || empty( $first_name ) || empty( $last_name ) || empty( $password ) || empty( $password_conf ) ) {
            $luxus_error->add( 'field', __('Please fill all Required fields.', 'luxus-core') );
        }

        if ( ! empty( $username ) && 6 > strlen( $username ) ) {
            $luxus_error->add( 'username_length', __('Username too short. At least 6 characters is required', 'luxus-core') );
        }
        if ( strpos( $username, ' ' ) !== FALSE ) {
            $luxus_error->add( 'username_space', __('Username has Space', 'luxus-core') );
        }
        if ( username_exists( $username ) ) {
            $luxus_error->add( 'username_exist', __('User already Exist', 'luxus-core') );
        }

        if( ! empty( $email ) && !filter_var( $email, FILTER_VALIDATE_EMAIL ) ) {
            $luxus_error->add( 'email_invalid', __('Invalid email address', 'luxus-core') );
        }
        if ( email_exists( $email ) ) {
            $luxus_error->add( 'email_exist', __('Email already exists', 'luxus-core') );
        }

        if ( ! empty( $password ) && 6 > strlen( $password ) ) {
            $luxus_error->add( 'pass_length', __('Password length must be greater than 6!', 'luxus-core') );
        }
        if ( strcmp( $password, $password_conf ) !== 0 ) {
            $luxus_error->add( 'pass_match', __('Password didn\'t match', 'luxus-core') );
        }
        if ( empty( $role ) ) {
            $luxus_error->add( 'role_select', __('Please Select Role', 'luxus-core') );
        }

        // Print Errors
        if ( count( $luxus_error->get_error_messages() ) > 0 ) {

            echo '<div class="sl-box one">';
                foreach ( $luxus_error->get_error_messages() as $error ) {
                    echo '<strong class="text-danger">Error: </strong>' . $error . '<br/>';
                }
            echo '</div>';
        }

    }
}

// Insert User to Database
function luxus_register_user() {

    $users_can_register = get_option('users_can_register');
 
    if ( $users_can_register ) :

        global $luxus_error, $username, $email, $first_name, $last_name, $password, $role;

        if ( 1 > count( $luxus_error->get_error_messages() ) ) {

            if ( $role == 'agent' || $role == 'agency' || $role == 'subscriber'  ) {
                $user_data = array(
                    'user_login'    =>   $username,
                    'user_email'    =>   $email,
                    'first_name'    =>   $first_name,
                    'last_name'     =>   $last_name,
                    'user_pass'     =>   $password,
                    'role'          =>   $role,
                );

                // Insert user into the database
                $user = wp_insert_user( $user_data );
                echo '<div class="sl-box two">';
                echo '<strong class="text-success">'. __('Complete Registration.', 'luxus-core') .'</strong> <a href="'. esc_url(get_site_url()) .'/wp-login.php">'. __('Goto login page', 'luxus-core') .'</a>.';
                echo '</div>';
            }
            
        } else {

            echo '<div class="sl-box three">';
            echo '<strong class="text-danger">'. __('Registration Failed. Please fill in all required fields.', 'luxus-core') .'</strong>';
            echo '</div>';

        }

    else:

        echo '<div class="sl-box three">';
         echo '<strong class="text-danger">'. __('Registration Failed. User registration is currently not allowed.', 'luxus-core') .'</strong>';
        echo '</div>';

    endif;

}

// Function to Call Registration Form
function luxus_registration_form_function() {
    global $username, $email, $first_name, $last_name, $password, $password_conf, $role;
    if ( isset($_POST['submit'] ) ) {

        if ( ! wp_verify_nonce( $_POST['sl_registration_form_nonce'], 'sl_registration_form_action' ) ) {

            echo '<div class="sl-box four">';
            echo '<strong class="text-danger">Error </strong>'. __('Something is wrong, Please try again.', 'luxus-core');
            echo '</div>';

        } else {

            // Form Validation
            luxus_registration_form_validation(
                $_POST['username'],
                $_POST['email'],
                $_POST['first_name'],
                $_POST['last_name'],
                $_POST['password'],
                $_POST['password_conf'],
                $_POST['role']
            );
            
            // Form Sanitization
            $username = sanitize_user( $_POST['username'] );
            $email = sanitize_email( $_POST['email'] );
            $first_name = sanitize_text_field( $_POST['first_name'] );
            $last_name = sanitize_text_field( $_POST['last_name'] );
            $password = esc_attr( $_POST['password'] );
            $password_conf = esc_attr( $_POST['password_conf'] );
            $role = esc_attr( $_POST['role'] );

            luxus_register_user(
                $username,
                $email,
                $first_name,
                $last_name,
                $password,
                $role
            );

        }
    }

    // Registration Form
    luxus_registration_form(
        $username,
        $email,
        $first_name,
        $last_name,
        $password,
        $password_conf,
        $role
    );
}

// Registration Form Shortcode
add_shortcode( 'luxus_signup_form', 'luxus_registration' );
function luxus_registration() {
    ob_start();
    if( !is_user_logged_in() ){

        luxus_registration_form_function();

    } else{
        echo '<div class="sl-box logged-in">'. __('You are already Logged in,', 'luxus-core') .'<a href="'. esc_url( wp_logout_url( home_url() ) ).'">'. __('Logout', 'luxus-core') .'</a></div>';
    }
    
    return ob_get_clean();
}