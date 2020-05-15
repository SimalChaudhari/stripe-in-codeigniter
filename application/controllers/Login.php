<?php

/**
 * @author Simal Chaudhari
 */
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends MY_Controller {

    public function __construct() {
        parent::__construct();
    }

    /**
     * Display login page for login
     */
    public function index() {
        $this->form_validation->set_rules('email', 'Email', 'trim|required|callback_login_validation');
        $this->form_validation->set_rules('password', 'Password', 'trim|required');
        if ($this->form_validation->run() == FALSE) {
            $data['error'] = validation_errors();
        } else {
            //-- If redirect is set in URL then redirect user back to that page
            if ($this->input->get('redirect')) {
                redirect(base64_decode($this->input->get('redirect')));
            } else {
                redirect('Home');
            }
        }
        $data['title'] = SITE_NAME. ' | Login';
        $this->load->view('auth/login', $data);
    }

    /**
     * Callback Validate function to check Admin/Staff Login  
     * @return boolean
     */
    public function login_validation() {
        $result = $this->users_model->get_user_detail(['email' => trim($this->input->post('email')), 'is_deleted' => 0]);
        if ($result) {
            if (!password_verify($this->input->post('password'), $result['password'])) {
                $this->form_validation->set_message('login_validation', 'Invalid  Email/Password.');
                return FALSE;
            } else if ($result['is_active'] == 0 || $result['is_deleted'] == 1) {
                $this->form_validation->set_message('login_validation', 'Your Account has been blocked! Please contact system administrator');
                return FALSE;
            } else {
                //-- If input details are valid then store data into session
                $this->session->set_userdata('stripeInCI', $result);
                return TRUE;
            }
        } else {
            $this->form_validation->set_message('login_validation', 'Invalid Email/Password.');
            return FALSE;
        }
    }

    /**
     * Clears the session and log out admin/staff
     */
    public function logout() {
        $this->session->sess_destroy();
        delete_cookie(REMEMBER_ME_COOKIE_NAME);
        redirect('login');
    }

    /**
     * Forgot password page
     */
    public function forgot_password() {
        $this->form_validation->set_rules('email', 'Email', 'trim|required|callback_email_validation');
        if ($this->form_validation->run() == FALSE) {
            $data['error'] = validation_errors();
        } else {
            $user = $this->users_model->get_user_detail(['email' => trim($this->input->post('email')), 'is_delete' => 0, 'is_active' => 1]);
            $verification_code = verification_code();
            $this->users_model->common_insert_update('update', TBL_USERS, array('verification_code' => $verification_code), array('id' => $user['id']));

//            $verification_code = $this->encrypt->encode($verification_code);
            $verification_code = base64_encode($verification_code);
//            $encoded_verification_code = urlencode($verification_code);
            $encoded_verification_code = $verification_code;

            $email_data = [];
            $email_data['url'] = site_url() . 'reset_password?code=' . $encoded_verification_code;
            $email_data['name'] = $user['firstname'] . ' ' . $user['lastname'];
            $email_data['email'] = trim($this->input->post('email'));
            $email_data['subject'] = 'Reset Password - Extra Credit';
            send_email(trim($this->input->post('email')), 'forgot_password', $email_data);
            $this->session->set_flashdata('success', 'Email has been successfully sent to reset password! Please check email');
            redirect('login');
        }

        $data['title'] = 'Extra Credit | Forgot Password';
        $this->load->view('forgot_password', $data);
    }

    /**
     * Reset password page
     */
    public function reset_password() {
        $data['title'] = 'Extra Credit| Reset Password';
        $verification_code = $this->input->get('code');
//        $verification_code = $this->encrypt->decode($verification_code);
        $verification_code = base64_decode($verification_code);
        //--- check varification code is valid or not
        $result = $this->users_model->check_verification_code($verification_code);
        if (!empty($result)) {
            $this->form_validation->set_rules('password', 'Password', 'trim|required');
            $this->form_validation->set_rules('con_password', 'Confirm password', 'trim|required|matches[password]');

            if ($this->form_validation->run() == FALSE) {
                $data['error'] = validation_errors();
            } else {

                //--- if valid then reset password and generate new verification code
                //--- generate verification code
                $new_verification_code = verification_code();
                $id = $result['id'];
                $data = array(
                    'password' => password_hash($this->input->post('password'), PASSWORD_BCRYPT),
                    'verification_code' => $new_verification_code
                );
                $this->users_model->common_insert_update('update', TBL_USERS, $data, ['id' => $id]);
                $this->session->set_flashdata('success', 'Your password changed successfully');
                redirect('login');
            }
            $this->load->view('reset_password', $data);
        } else {
            //--- if invalid verification code
            $this->session->set_flashdata('error', 'Invalid request or already changed password');
            redirect('login');
        }
    }

    /**
     * Check email is valid or not
     */
    public function check_email() {
        $requested_email = trim($this->input->get('email'));
        $user = $this->users_model->get_user_detail(['email' => $requested_email, 'is_deleted' => 0, 'is_active' => 1]);
        if ($user) {
            echo "true";
        } else {
            echo "false";
        }
        exit;
    }

    /**
     * Forgot password email validation
     */
    public function email_validation() {
        $requested_email = trim($this->input->post('email'));
        $user = $this->users_model->get_user_detail(['email' => $requested_email, 'is_deleted' => 0, 'is_active' => 1]);
        if (empty($user)) {
            $this->form_validation->set_message('email_validation', 'Invalid Email Address');
            return FALSE;
        } else {
            return TRUE;
        }
    }

}
