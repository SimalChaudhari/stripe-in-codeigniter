<?php

/**
 * @author Simal Chaudhari
 */
defined('BASEPATH') OR exit('No direct script access allowed');

class Signup extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('Users_model');
    }

    /**
     * Display signup page
     */
    public function index($id = NULL) {  
        $this->form_validation->set_rules('username', 'Name', 'trim|required');
        $this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email|callback_is_uniquemail');
        $this->form_validation->set_rules('password', 'Password', 'trim|required');
        $this->form_validation->set_rules('plan', 'Password', 'trim|required');
        
        $data['title'] = SITE_NAME. ' | Signup';
        $data['heading'] = 'Add User';
        $data['plans'] =  $this->Users_model->getPlans();

        if ($this->form_validation->run() == FALSE) {
            $data['error'] = validation_errors();
        } else {
            $dataArr = array(
                'name' => trim($this->input->post('username')),
                'zipcode' => trim($this->input->post('zipcode')),
                'phone' => trim($this->input->post('phone')),
                'plan' => trim($this->input->post('plan')),
                'is_active' => 1,
            );

            $password = randomPassword();
            $dataArr['email'] = trim($this->input->post('email'));
            $dataArr['password'] = password_hash($password, PASSWORD_BCRYPT);
            $dataArr['created_date'] = date('Y-m-d H:i:s');
            
            if(!empty($_POST['stripeToken']))
		    {
                //include Stripe PHP library
                require_once APPPATH."third_party/stripe/init.php";
                \Stripe\Stripe::setApiKey(SECRET_KEY);

                $customer = \Stripe\Customer::create(array(
                    'email' => trim($this->input->post('email')),
                    'source' => $this->input->post('stripeToken')
                ));

                // Get selected plan id 
                $selected_plan = null;
                $plans = \Stripe\Plan::all();
                foreach ($plans->data as $p) {
                    if($p['nickname'] == strtolower(trim($this->input->post('plan')))) {
                        $selected_plan = $p;
                    break;
                    }
                }

                $subscription = \Stripe\Subscription::create(array(
                    'customer' => $customer->id,
                    "items" => array(
                        array(
                            "plan" => $selected_plan['id'],
                        ),
                    ),
                    'trial_period_days' => 14,
                ));
                
                if (isset($subscription)) {
                    $dataArr['payment_status'] = 1;
                    $dataArr['subscription_status'] = 1;
                    $dataArr['stripe_customer_id'] = $customer->id;
                    $dataArr['subscription_id'] = $subscription->id;
                }

                $inserted_id = $this->users_model->common_insert_update('insert', TBL_USERS, $dataArr);
                $result = $this->users_model->get_user_detail(['id' => $inserted_id]);
                $this->session->set_userdata('stripeInCI', $result);
                $this->session->set_flashdata('success', 'User has been created successfully!');
                redirect('home');
            }else{
                if(strtolower(trim($this->input->post('plan'))) == 'free'){
                    $inserted_id = $this->users_model->common_insert_update('insert', TBL_USERS, $dataArr);
                    $result = $this->users_model->get_user_detail(['id' => $inserted_id]);
                    $this->session->set_userdata('stripeInCI', $result);
                    $this->session->set_flashdata('success', 'User has been created successfully!');
                    redirect('home');
                }else{
                    $this->session->set_flashdata('error', 'Invalid Token. Please try again!');
                    redirect('signup/');
                }
            }
            
        }
        $this->load->view('auth/signup', $data);
    }

    /**
     * Callback function to check email validation - Email is unique or not
     * @param string $str
     * @return boolean
     */
    public function is_uniquemail() {
        $email = trim($this->input->post('email'));
        $user = $this->users_model->check_unique_email($email);
        if ($user) {
            $this->form_validation->set_message('is_uniquemail', 'Email address is already in use!');
            return FALSE;
        } else {
            return TRUE;
        }
    }

    /**
    * This function used to check Unique email at the time of signup
    * */
    public function checkUniqueEmail()
    {
        $email = trim($this->input->post('email'));
        $restaurant = $this->users_model->check_unique_email($email);
        if ($restaurant) {
            echo "false";
        } else {
            echo "true";
        }
        exit;
    }

}
