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
    if ($this->data['logged_in']) {
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
      $this->session->set_flashdata('error', 'Wrong username or password inserted, make sure you use right lowercase/uppercase combination');
      redirect('/user', 'refresh');
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
  
  public function add() {
    if (!($this->data['logged_in'] && $this->data['group'] == 'Librarian')) {
      redirect('/user');
    }
    $this->data['main_title'] = 'Add New User';
    $this->load->view('/user/add', $this->data);
  }
  
  public function listusers($page = 1) {
    if (!($this->data['logged_in'] && $this->data['group'] == 'Librarian')) {
      redirect('/user');
    }
    $total_rows = 0;
    $offset = 0;
    if ($page > 1) {
      $offset = ($this->max_list*$page)-$this->max_list;  
    }
    
    $criteria = '';
    $this->data['main_title'] = 'Users Management';
    
    if ($keywords = $this->input->get('keywords')) {
      $this->db->where(sprintf('realname LIKE \'%%%s%%\' OR username LIKE \'%%%s%%\'', $keywords, $keywords), null, false);
    }

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
    if (!($this->data['logged_in'] && $this->data['group'] == 'Librarian')) {
      redirect('/user');
    }
    $this->data['main_title'] = 'Update User';
    $this->db->where('id', $user_id);
    $this->db->limit(1);
    $query = $this->db->get('users');
    
    $detail = $query->row();
    
    $this->data['record'] = $detail;
    $this->data['update_ID'] = $user_id;
    $this->load->view('/user/add', $this->data);
  }

  public function delete($user_id = 0) {
    // only admin can delete user
    if (!($this->data['logged_in'] && $this->data['logged_in']['id'] == 1)) {
      redirect('/user');
    }
    if ($user_id == 1) {
      $this->session->set_flashdata('error', 'Admin user can\'t be deleted');
      redirect('/user/listusers');      
    }
    $this->db->where('id', $user_id);
    $this->db->limit(1);
    $this->db->delete('users');
    $this->session->set_flashdata('info', 'User deleted');
    redirect('/user/listusers');
  }
  
  public function save($tipe = 'detail') {
    if (!($this->data['logged_in'] && $this->data['group'] == 'Librarian')) {
      redirect('/user');
    }
    $updateID = $this->input->post('update_ID');
    $passwd1 = $this->input->post('passwd');
    $passwd2 = $this->input->post('passwd2');
    if ($passwd1 !== $passwd2) {
      $this->session->set_flashdata('error', 'Wrong password inserted, please check your data again');
      if ($updateID) {
        redirect('/user/update/'.$updateID, 'refresh');  
      } else {
        redirect('/user/add', 'refresh');
      }
      
      return false;
    }
  	
    $tgl_update = date('Y-m-d H:i:s');
    $data['username'] = $this->input->post('username');
    $data['realname'] = $this->input->post('realname');
    $data['email'] = $this->input->post('email');
    $data['groups'] = $this->input->post('groups');
    $data['updated'] = $tgl_update;
  
    if ($updateID) {
      if ($passwd1 && $passwd2) {
        $data['passwd'] = (string)hash('sha256', $passwd2);
      }
      $this->db->where('id', $updateID);
      $this->db->update('users', $data);
      $this->session->set_flashdata('info', 'User '.$data['realname'].' data updated');
    } else {
      if ($passwd2) {
        $data['passwd'] = (string)hash('sha256', $passwd2);
      }
      $this->db->insert('users', $data);
      $this->session->set_flashdata('info', 'New user added');
    }
  
    redirect('/user/listusers');
  }
}
