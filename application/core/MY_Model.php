<?php

/**
 * MY_Model for common model function
 * @author Simal Chaudhari
 * */
defined('BASEPATH') OR exit('No direct script access allowed');

class MY_Model extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    /**
     * This function used to add or update records in particular table based on condition. 
     * @param String $mode (insert/update)
     * @param String $table
     * @param Array $dataArr        	
     * @param Array $condition
     * @return Integer $affected_row
     * */
    public function common_insert_update($mode = '', $table = '', $dataArr = '', $condition = '') {
        if ($mode == 'insert') {
            $this->db->insert($table, $dataArr);
            $affected_row = $this->db->insert_id(); // fetch last inserted id in table
        } else if ($mode == 'update') {
            $this->db->where($condition);
            $this->db->update($table, $dataArr);
            $affected_row = $this->db->affected_rows();
        }
        return $affected_row;
    }

    /**
     * This function returns the table contents based on data. 
     * @param String $table
     * @param Array $condition        	
     * @param Array $sortArr
     * @return Array
     * @author pav
     * */
    public function get_all_details($table = '', $condition = '', $sortArr = '', $limitArr = '') {
        if ($sortArr != '' && is_array($sortArr)) {
            foreach ($sortArr as $sortRow) {
                if (is_array($sortRow)) {
                    $this->db->order_by($sortRow ['field'], $sortRow ['type']);
                }
            }
        }
        if ($limitArr != '') {
            return $this->db->get_where($table, $condition, $limitArr['l1'], $limitArr['l2']);
        } else {
            return $this->db->get_where($table, $condition);
        }
    }

    /**
     * Master function to select required data from DB
     * @param string $table - name of the table
     * @param string $select - select statement e.g user.id or MAX(user.id)
     * @param type $where - mixed optional where condition ex : ['where_in'=> ['users.id' => 5]]
     * @param type $options
     * @return type
     */
    public function sql_select($table, $select = null, $where = null, $options = null) {

        if (!empty($select)) {
            $this->db->select($select);
        }

        $this->db->from($table);

        /* Check wheather where conditions is required or not. */
        if (!empty($where)) {
            if (is_array($where)) {
                $check_where = array(
                    'where',
                    'or_where',
                    'where_in',
                    'or_where_in',
                    'where_not_in',
                    'or_where_not_in',
                    'like', 'or_like',
                    'not_like',
                    'or_not_like'
                );

                foreach ($where as $key => $value) {
                    if (in_array($key, $check_where)) {
                        foreach ($value as $k => $v) {
                            if (in_array($key, array('like', 'or_like', 'not_like', 'or_not_like'))) {
                                $check = 'both';
                                if ($v[0] == '%') {
                                    $check = 'before';
                                    $v = ltrim($v, '%');
                                } else if ($v[strlen($v) - 1] == '%') {
                                    $check = 'after';
                                    $v = rtrim($v, '%');
                                }
                                $this->db->$key($k, $v, $check);
                            } else {
                                $this->db->$key($k, $v);
                            }
                        }
                    }
                }
            } else {
                $this->db->where($where);
            }
        }

        /* Check fourth parameter is passed and process 4th param. */
        if (!empty($options) && is_array($options)) {
            $check_key = array('group_by', 'order_by');
            foreach ($options as $key => $value) {
                if (in_array($key, $check_key)) {
                    if (is_array($value)) {
                        foreach ($value as $k => $v) {
                            $this->db->$key($v);
                        }
                    } else {
                        $this->db->$key($value);
                    }
                }
            }
        }

        /* Check query needs to limit or not.  */
        if (isset($options['limit']) && !empty($options['limit']) && isset($options['offset']) && !empty($options['offset'])) {
            $this->db->limit($options['limit'], $options['offset']);
        } else if (isset($options['limit'])) {
            $this->db->limit($options['limit']);
        }

        /* Check tables need to join or not */
        if (isset($options['join']) && !empty($options['join'])) {
            foreach ($options['join'] as $join) {
                if (!isset($join['join']))
                    $join['join'] = 'left';
                $this->db->join($join['table'], $join['condition'], $join['join']);
            }
        }


        $method = 'result_array';
        /* Check wheather return only single row or not. */
        if (isset($options) && ((!is_array($options) && $options == true) || (isset($options['single']) && $options['single'] == true ))) {
            $method = 'row_array';
        }

        /* Check to return only count or full data */
        if (isset($options['count']) && $options['count'] == true) {
            return $this->db->count_all_results();
        } else {
            return $this->db->get()->$method();
        }
    }   
}