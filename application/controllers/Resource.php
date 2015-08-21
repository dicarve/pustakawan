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

class Resource extends CI_Controller {
    
  private $data = array();
  
  public function __construct() {
    parent::__construct();
    $this->data['main_title'] = 'Information Resources';
    $this->data['main_content'] = '';
    $this->data['logged_in'] = $this->session->userdata('logged_in');
    $this->data['group'] = $this->data['logged_in']['groups'];
    $this->load->model('Resource_model');
    $this->load->model('Taxonomy_model');
  }
  
  /**
   * Index Page for this controller.
   *
   */
  public function index($page = 1)
  {
    if (!($this->data['logged_in']  && $this->data['group'] == 'Librarian')) {
      redirect('/user/login');
    }
    $total_rows = 0;
    $criteria = '';
    $per_page = 20;
    $this->data['main_title'] = 'Resource Library';
    if ($keywords = $this->input->get('keywords')) {
      $criteria = sprintf("MATCH(`title`, `series_title`, `subjects`, `authors`, `abstract`) AGAINST('%s' IN BOOLEAN MODE)", $keywords);
    }
    $this->load->library('pagination');
    
    //pagination settings
    $config['per_page'] = 10;
    $config['base_url'] = site_url('/resource/index');
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
    
    
    $this->data['records'] = $this->Resource_model->getData($page, $per_page, $criteria, $total_rows);
    
    $config['total_rows'] = $total_rows;
    $this->pagination->initialize($config);
    $this->data['pagination'] = $this->pagination->create_links();
    
    $this->load->view('resource/index', $this->data);
  }
  
  public function ajax()
  {
    $total_rows = 0;
    $criteria = '';
    $type = $this->input->get('type');
    $keywords = $this->input->get('keywords');
    if ($keywords) {
      $criteria .= sprintf(" AND MATCH(`title`, `series_title`, `subjects`, `authors`, `abstract`) AGAINST('%s' IN BOOLEAN MODE)", $keywords);
    }
    if ($type) {
      $criteria .= sprintf(" AND type='%s'", $type);
    }
    $criteria = preg_replace('@^\s+AND@i', '', $criteria);
    $config['per_page'] = 10;
    $this->data['records'] = $this->Resource_model->getData(1, $config['per_page'], $criteria, $total_rows);
    $json_array = array();
    foreach ($this->data['records'] as $rec) {
      $json_array[] = array('value' => $rec->id, 'text' => $rec->title);
    }
    header('Content-type: application/json');
    exit(json_encode($json_array));
  }
  
  /**
   * Add resource
   *
   */
  public function add($pathfinder_id = 0, $resource_type_id = 0)
  {
    $this->data['default_resource_type'] = '';
    if ($resource_type_id > 0) {
      $rt = $this->db->get_where('taxonomy_term', array('tid' => $resource_type_id))->row();
      $this->data['default_resource_type'] = $rt->name;
    }
    if ($pathfinder_id > 0) {
      $this->data['pathfinder_ID'] = $pathfinder_id;
    }
    $this->data['main_title'] = 'Add New Resources';
    $this->load->view('resource/add', $this->data);
  }

  public function update($resource_id = 0)
  {
    $this->data['record'] = $this->Resource_model->getDetail($resource_id);
    $this->data['main_title'] = $this->data['record']->title;
    $this->data['update_ID'] = $this->data['record']->id;
    $this->load->view('resource/add', $this->data);
  }
  
  public function detail($resource_id = 0)
  {
    $this->data['record'] = $this->Resource_model->getDetail($resource_id);
    $this->data['main_title'] = $this->data['record']->title;
    $this->load->view('resource/detail', $this->data);
  }
  
  public function save()
  {
    $save_data = $this->input->post();
    $pathfinder_id = $this->input->post('pathfinder_ID');
    $update_id = $this->input->post('update_ID');
    // remove non fields element
    unset($save_data['save']);
    unset($save_data['pathfinder_ID']);
    unset($save_data['update_ID']);

    // change the subject data array
    $temp = $save_data['subjects'];
    $save_data['subjects'] = implode(' ; ', $temp);
    $save_data['subjects_array'] = serialize($temp);

    // change the authors data array
    $temp = $save_data['authors'];
    $save_data['authors'] = implode(' ; ', $temp);
    $save_data['authors_array'] = serialize($temp);
    
    $date = new DateTime();
    $save_data['created'] = serialize($temp);
    $save_data['updated'] = $date->format('Y-m-d');
    if ($update_id) {
      $this->Resource_model->save($save_data, true, sprintf('id=%d', $update_id));
      $resource_id = $update_id;
    } else {
      $resource_id = $this->Resource_model->save($save_data);
    }
    
    $this->session->set_flashdata('save message', 'Resource added');
    // add relation if pathfinder ID is set
    if ($pathfinder_id) {
      $this->Pathfinder_model->addResource($pathfinder_id, $resource_id);
      redirect('/pathfinder/detail/'.$pathfinder_id);
    } else {
      redirect('/resource/index');
    }
  }
}

/* End of file resource.php */