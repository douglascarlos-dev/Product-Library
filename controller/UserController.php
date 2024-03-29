<?php

require_once 'model/userModel.php';
require_once 'model/settingsModel.php';

class UserController{

    function isLoggedIn() {
        if (isset($_SESSION['username'])) {
            return true;
        } else {
            #header("Location: ./user");
            #echo " sessao expirada ou não logada. acesse /user para logar";
            $settings = new Settings();
            $settings = $settings->settings_list();
            require_once 'view/user_login.php';
            exit;
            #$this->visualizar();
        }
    }

    public function visualizar() {
        $settings = new Settings();
        $settings = $settings->settings_list();
        require_once 'view/user_login.php';
    }

    /* public function teste2() {
        unset($_SESSION['username']);
        $settings = new Settings();
        $settings = $settings->settings_list();
        require_once 'view/user_login.php';
    } */

    //Load the view (checks for the file)
    public static function view($view, $data = []) {
        $user = new User();
        require_once 'view/user_view.php';
    }

    public function login() {
        $user = new User();
        $data = [
            'title' => 'Login page',
            'username' => '',
            'password' => '',
            'captcha' => '',
            'usernameError' => '',
            'passwordError' => ''
        ];


            if($_SERVER['REQUEST_METHOD'] == 'POST') {
            $data = [
                'username' => trim($_REQUEST['username']),
                'password' => trim($_REQUEST['password']),
                'captcha' => '',
                'usernameError' => '',
                'passwordError' => '',
            ];

            //Validate hcaptcha
            $settings = new Settings();
            $settings = $settings->settings_list();
            $secret = $settings->getHcaptchaSecret();
            if ($settings->getHcaptcha() == 1) {
                $data_captcha = array(
                    'secret' => $secret,
                    'response' => @$_POST['h-captcha-response']
                        );
                $verify = curl_init();
                curl_setopt($verify, CURLOPT_URL, "https://hcaptcha.com/siteverify");
                curl_setopt($verify, CURLOPT_POST, true);
                curl_setopt($verify, CURLOPT_POSTFIELDS, http_build_query($data_captcha));
                curl_setopt($verify, CURLOPT_RETURNTRANSFER, true);
                $response = curl_exec($verify);
                // var_dump($response);
                $responseData = json_decode($response);
                if($responseData->success) {
                    $data['captcha'] = true;
                } 
                else {
                    $data['captcha'] = false;
                }
            } else {
                $data['captcha'] = true;
            }

            //Validate username
            if (empty($data['username'])) {
                $data['usernameError'] = 'Please enter a username.';
            }

            //Validate password
            if (empty($data['password'])) {
                $data['passwordError'] = 'Please enter a password.';
            }

            //Check if all errors are empty
            if (empty($data['usernameError']) && empty($data['passwordError'])) {
                $loggedInUser = $user->login($data['username'], $data['password']);

                if ($loggedInUser && $data['captcha']) {
                    $this->createUserSession($loggedInUser);
                } else {
                    $data['passwordError'] = 'Password or username is incorrect. Please try again.';

                    $settings = new Settings();
                    $settings = $settings->settings_list();
                    require_once 'view/user_login.php';
                }
            } else {
                $settings = new Settings();
                $settings = $settings->settings_list();
                require_once 'view/user_login.php';
            }

        }
    }

    public function createUserSession($user) {
        $_SESSION['username'] = $user["username"];
        require_once 'view/home_view.php';
    }

    public function logout() {
        unset($_SESSION['username']);
        header("Location: ./");
    }
}
?>