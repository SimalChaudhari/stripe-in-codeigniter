<?php

/**
 * Manage users table related database operation
 * @author Simal Chaudhari
 */
class Users_model extends MY_Model {

    function __construct() {
        parent::__construct();
    }

    /**
     * Return user detail
     * @param string/array $where
     * @param string/array $select
     * @return array
     */
    public function get_user_detail($where, $select = '*') {
        $this->db->select($select);
        $this->db->where($where);
        return $this->db->get(TBL_USERS)->row_array();
    }

    /**
     * Set cookie with passed email id
     * @param string $email
     * @return boolean
     */
    public function activate_remember_me($email) {
        $encoded_email = $this->encrypt->encode($email);
        set_cookie(REMEMBER_ME_COOKIE_NAME, $encoded_email, time() + (3600 * 24 * 360));
        return true;
    }

    /**
     * Check verification code exists or not in users table
     * @param string $verification_code
     * @return array
     */
    public function check_verification_code($verification_code) {
        $this->db->where('verification_code', $verification_code);
        $query = $this->db->get(TBL_USERS);
        return $query->row_array();
    }

    /**
     * Check email exist or not for unique email
     * @param string $email
     * @return array
     */
    public function check_unique_email($email) {
        $this->db->where('email', $email);
        $this->db->where('is_deleted', 0);
        $query = $this->db->get(TBL_USERS);
        return $query->row_array();
    }

    /**
     * Get all plans
     */
    public function getPlans(){
        $this->db->select('*');
		$this->db->from(TBL_PLANS); 
        $this->db->where('is_deleted', '0');
        $this->db->order_by('price', 'asc');
	    $query = $this->db->get();
	    return $query->result();
    }
}
