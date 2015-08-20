<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Arie Nugraha
 * Copyright 2013
 *
 */

class User extends CI_Controller {
  public $content = array();
  private $max_list = 20;
  private $privs = array();

  public function __construct() {
    parent::__construct();
    $this->data['logged_in'] = $this->session->userdata('logged_in');
    $this->data['group'] = $this->data['logged_in']['groups'];
    // content default
    $this->data['session_data'] = $this->session->all_userdata();
  }
  
  /**
   * Show login page if not already logged in
   */
  public function index($status = '') {
    $this->data['status'] = $status;
    if ($this->session->userdata('logged_in')) {
      redirect('/pathfinder');
    } else {
      $this->data['main_title'] = 'User Login';
      $this->load->view('/user/login', $this->data);  
    }
  }

  /**
   * Logout
   */  
  public function logout() {
    $this->session->sess_destroy();
    redirect('/pathfinder', 'refresh');
  }

  /**
   * Login validation process
   */
  public function check_login() {
    $username = $this->input->post('username');
    $passw = $this->input->post('password');
  
    //query the database
    $result = $this->db_check_login($username, $passw);
    // var_dump($result); die();
    if ($result) {
      $sess_array = array(
        'id' => $result->id, 'username' => $result->username, 
        'realname' => $result->realname, 'groups' => $result->groups
      );
      $this->session->set_userdata('logged_in', $sess_array);
      if ($result->id == 1) {
        $this->session->set_userdata('administrator', true);  
      }

      redirect('/pathfinder', 'refresh');
      return true;
    } else {
      redirect('/user/login/failed', 'refresh');
      return false;
    }
  }
  
  /**
   * validation query to database
   */
  private function db_check_login($username, $password)
  {
    $this->db->select('id, username, realname, groups');
    $this->db->from('users');
    $this->db->where(sprintf('username=\'%s\' AND passwd=\'%s\'', $username, hash('sha256', $password)), null, false);
    $this->db->limit(1);
    $query = $this->db->get();
  
    if($query->num_rows() == 1) {
      return $query->row();
    } else {
      return false;
    }
  }

  public function listusers($page = 1) {
    $total_rows = 0;
    $offset = ($this->max_list*$page)-$this->max_list;
    $criteria = '';
    $this->data['main_title'] = 'Users Management';
    
    $this->db->limit($this->max_list, $offset);
    $query = $this->db->get('users');
    $total_rows = $query->num_rows();
    $userdata = array();
    foreach ($query->result_array() as $row) {
      $userdata[] = $row;
    }
    
    $this->data['userdata'] = $userdata;
    
    // paging
    $this->load->library('pagination');
    $config['base_url'] = site_url('/user/index');
    $config['total_rows'] = $total_rows;
    $config['per_page'] = $this->max_list;
    $this->pagination->initialize($config);
    
    $this->data['pagination'] = $this->pagination->create_links();
    $this->data['total_rows'] = $total_rows;
    
    $this->load->view('/user/index', $this->data);
  }
	
  public function update($user_id = 0) {
    $this->db->where('id', $user_id);
    $this->db->limit(1);
    $query = $this->db->get('users');
    
    $detail = $query->row_array();
    
    $this->data['detail_user'] = $detail;
    $this->load->view('/user/index', $this->data);
  }
  
  public function save($tipe = 'detail') {
    $updateID = $this->input->post('updateID');
    $passwd1 = $this->input->post('passwd1');
    $passwd2 = $this->input->post('passwd2');
    if ($passwd1 !== $passwd2) {
      redirect('/user/update/password-failed', 'refresh');
      return false;
    }
  	
    $tgl_update = date('Y-m-d H:i:s');
    $this->db->set('username', $this->input->post('userName'));
    $this->db->set('realname', $this->input->post('realName'));
    $this->db->set('groups', $this->input->post('groups'));
    $this->db->set('updated', $tgl_update);
  
    if ($updateID) {
      if ($passwd1 && $passwd2) {
        $this->db->set('passwd', hash('sha256', $passwd2), false);
      }
      $this->db->where('id', $updateID);
      $this->db->update('users');		
    } else {
      if ($passwd2) {
        $this->db->set('passwd', hash('sha256', $passwd2), false);
      }
      $this->db->insert('users');
    }
  
    redirect('/user/listusers');
  }
}
