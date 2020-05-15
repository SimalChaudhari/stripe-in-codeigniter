<?php

/**
 * For default operation
 * @author Simal Chaudhari
 * */
defined('BASEPATH') OR exit('No direct script access allowed');

class MY_Controller extends CI_Controller {

    public $is_loggedin = false;

    public function __construct() {
        parent::__construct();
        $session = $this->session->userdata('stripeInCI');
        if (!empty($session['id']) && !empty($session['email']))
            $this->is_loggedin = true;
        else {
            $email = get_cookie(REMEMBER_ME_COOKIE_NAME);
            if (!empty($email)) {
                $user = $this->users_model->get_user_detail(['email' => $email]);
                if (!empty($user)) {
                    $this->session->set_userdata('stripeInCI', $user);
                    $this->is_loggedin = true;
                }
            }
        }
        
        $this->controller = $this->router->fetch_class();
        $this->action = $this->router->fetch_method();
        //-- If not logged in and try to access inner pages then redirect user to login page
        if (!$this->is_loggedin) {
            if (strtolower($this->controller) != 'login') {
                $redirect = site_url(uri_string());
                redirect('login?redirect=' . base64_encode($redirect));
            }
        } else { //-- If logged in and access login page the redirect user to home page
            if (strtolower($this->controller) == 'login' && strtolower($this->action) != 'logout') {
                redirect('Home');
            }
        }
    }
}
