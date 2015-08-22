<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 *
 * Copyright (C) 2014  Arie Nugraha (dicarve@gmail.com)
 *
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program; if not, write to the Free Software
 * Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA  02110-1301  USA
 *
 */

class Taxonomy extends CI_Controller {
    
  private $data = array();
  
  public function __construct() {
    parent::__construct();
    $this->data['logged_in'] = $this->session->userdata('logged_in');
    $this->data['group'] = $this->data['logged_in']['groups'];
    $this->data['main_title'] = 'Taxonomy';
    $this->data['main_content'] = '';
    $this->load->model('Taxonomy_model');
  }
  
  /**
   * Index Page for this controller.
   *
   */
  public function index($type = 'subject', $page = 1)
  {
    if (!($this->data['logged_in'] && $this->data['group'] == 'Librarian')) {
      redirect('/user');
    }
    $total_rows = 0;
    $criteria = '';
    if ($keywords = $this->input->get('keywords')) {
      $criteria = sprintf('name LIKE \'%%%s%%\' AND vocabulary LIKE \'%s\'', $keywords, ucwords($type));
    }
    $this->load->library('pagination');
    
    //pagination settings
    $config['per_page'] = 10;
    $config['base_url'] = site_url('/taxonomy/index/'.$type);
    $config['use_page_numbers'] = TRUE;
    $config['num_links'] = 10;
    $config['uri_segment'] = 4;
    $config['full_tag_open'] = '<ul class="pagination">';
    $config['full_tag_close'] = '</ul>';
    $config['num_tag_open'] = '<li>';
    $config['num_tag_close'] = '</li>';
    $config['cur_tag_open'] = '<li class="active"><a>';
    $config['cur_tag_close'] = '</a></li>';
    $config['next_link'] = 'Next';
    $config['next_tag_open'] = '<li>';
    $config['next_tag_close'] = '</li>';
    $config['prev_link'] = 'Prev';
    $config['prev_tag_open'] = '<li>';
    $config['prev_tag_close'] = '</li>';
    $config['last_link'] = 'Last';
    $config['last_tag_open'] = '<li>';
    $config['last_tag_close'] = '</li>';
    $config['first_link'] = 'First';
    $config['first_tag_open'] = '<li>';
    $config['first_tag_close'] = '</li>';
    
    $this->data['type'] = $type;
    $this->data['main_title'] = ucwords($type).' Taxonomy';
    $this->data['records'] = $this->Taxonomy_model->getData($type, $page, $config['per_page'], $criteria, $total_rows);
    
    $config['total_rows'] = $total_rows;
    
    $this->pagination->initialize($config);
    $this->data['pagination'] = $this->pagination->create_links();
    $this->data['page'] = $page;
    $this->data['per_page'] = $config['per_page'];
    $this->load->view('taxonomy/index', $this->data);
  }
  
  public function ajax($type = 'subject')
  {
    if (!($this->data['logged_in'] && $this->data['group'] == 'Librarian')) {
      redirect('/user');
    }
    $total_rows = 0;
    $criteria = '';
    $keywords = $this->input->get('keywords');
    if ($keywords) {
      $criteria = sprintf("name LIKE '%%%s%%'", $keywords);
    }
    $config['per_page'] = 10;
    $this->data['records'] = $this->Taxonomy_model->getData($type, 1, $config['per_page'], $criteria, $total_rows);
    // var_dump($this->data['records']);
    $json_array = array();
    foreach ($this->data['records'] as $rec) {
      $json_array[] = array('value' => $rec->name, 'text' => $rec->name);
    }
    header('Content-type: application/json');
    exit(json_encode($json_array));
  }
  
  /**
   * Open add taxonomy form
   *
   */
  public function add($type = 'subject')
  {
    if (!($this->data['logged_in'] && $this->data['group'] == 'Librarian')) {
      redirect('/user');
    }
    $this->data['type'] = $type;
    $this->data['main_title'] = 'Add Term/Name for '.ucwords($type);
    $this->load->view('taxonomy/add', $this->data);
  }

  public function delete($tid)
  {
    if (!($this->data['logged_in'] && $this->data['group'] == 'Librarian')) {
      redirect('/user');
    }
    $this->db->where('tid', $tid);
    $term_data = $this->db->get('taxonomy_term')->row();
    $this->session->set_flashdata('delete message', sprintf('Term <em>%s</em> removed', $term_data->name));
    $this->Taxonomy_model->delete($tid);
    redirect('/taxonomy/index');
  }
  
  public function update($tid)
  {
    if (!($this->data['logged_in'] && $this->data['group'] == 'Librarian')) {
      redirect('/user');
    }
    $this->db->where('tid', $tid);
    $this->data['update_ID'] = $tid;
    $this->data['record'] = $this->db->get('taxonomy_term')->row();
    $this->data['type'] = strtolower($this->data['record']->vocabulary);
    $this->data['main_title'] = 'Edit Term/Name for '.ucwords($this->data['record']->vocabulary);    
    $this->load->view('taxonomy/add', $this->data);
  }
  
  /**
   * Save data from taxonomy form
   *
   */
  public function save($type)
  {
    if (!($this->data['logged_in'] && $this->data['group'] == 'Librarian')) {
      redirect('/user');
    }
    $data['name'] = $this->input->post('name');
    $data['vocabulary'] = ucwords(strtolower($type));
    if (empty($data['name'])) {
      $this->session->set_flashdata('error', 'Term data can\'t be empty');
      redirect('/taxonomy/add/'.$data['vocabulary']);
    }
    $data['description'] = $this->input->post('description');
    $data['weight'] = $this->input->post('weight');
    $update_ID = $this->input->post('update_ID');
    $this->Taxonomy_model->save($data, $update_ID, sprintf('tid=%d',$update_ID));
    $this->session->set_flashdata('save message', sprintf('Term <em>%s</em> saved', $data['name']));
    redirect('/taxonomy/index/'.$type);
  }
}

/* End of file pathfinder.php */