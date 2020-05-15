<?php

/**
 * Home Controller for Seller dashboard
 * @author SC 
 */
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends MY_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('Users_model');
    }

    /**
     * Display dashboard page
     */
    public function index() {
        $data['title'] = SITE_NAME.' | Dashboard';
        $data['heading'] = 'Add User';
        $data['plans'] =  $this->Users_model->getPlans();
        $this->template->load('default', 'container/dashboard/index', $data);
    }

}
