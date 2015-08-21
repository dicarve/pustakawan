<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 *
 * Copyright (C) 2015  Arie Nugraha (dicarve@gmail.com)
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

class Pathfinder extends CI_Controller {
    
  private $data = array();
  
  public function __construct() {
    parent::__construct();
    $this->data['main_title'] = 'Pathfinder';
    $this->data['main_content'] = '';
    $this->data['logged_in'] = $this->session->userdata('logged_in');
    $this->data['group'] = $this->data['logged_in']['groups'];
    // var_dump($this->session->userdata());
    $this->load->model('Resource_model');
    $this->load->model('Taxonomy_model');
  }
  
  /**
   * Index Page for this controller.
   *
   */
  public function index($page = 1)
  {
    $total_rows = 0;
    $criteria = '';
    if ($category = $this->input->get('category')) {
      $criteria = array('category' => $category);
    }
    if ($keywords = $this->input->get('keywords')) {
      $criteria = sprintf('MATCH(`title`, `subjects`, `description`) AGAINST(\'%s\' IN BOOLEAN MODE)', $keywords);
    }
    $this->data['pathfinder_records'] = $this->Pathfinder_model->getData($page, 50, $criteria, $total_rows);
    $this->load->view('pathfinder/index', $this->data);
  }
  
  /**
   * Open add pathfinder form
   *
   */
  public function add()
  {
    $this->data['hidden_type'] = array();
    $this->data['main_title'] = 'Add New Pathfinder';
    $this->load->view('pathfinder/add', $this->data);
  }
  
  public function edit($pathfinder_id)
  {
    if (!($this->data['logged_in'] && $this->data['group'] == 'Librarian')) {
      redirect('/user');
    }
    $this->data['hidden_type'] = array();
    $this->data['main_title'] = 'Edit Pathfinder';
    $this->data['record'] = $this->Pathfinder_model->getDetail($pathfinder_id);
    $this->data['update_ID'] = $pathfinder_id;
    $hidden_type = $this->Pathfinder_model->getConfig('pathfinder/'.$pathfinder_id.'.hidden_type');
    if (isset($hidden_type['pathfinder/'.$pathfinder_id.'.hidden_type'])) {
      $this->data['hidden_type'] = $hidden_type['pathfinder/'.$pathfinder_id.'.hidden_type'];  
    }
    $this->load->view('pathfinder/add', $this->data);
  }

  public function config($op = '')
  {
    if (!($this->data['logged_in'] && $this->data['group'] == 'Librarian')) {
      redirect('/user');
    }
    if ($op == 'save') {
      // site name
      $site_name = $this->input->post('site_name');
      $this->Pathfinder_model->setConfig('site_name', $site_name);
      // contact info
      $contact = $this->input->post('contact');
      $content_contact['title'] = 'Contact Librarian';
      $content_contact['content'] = $contact;
      $this->Pathfinder_model->setConfig('content.contact', $content_contact);
      // homepage info
      $homepage = $this->input->post('homepage');
      $content_homepage['title'] = 'Homepage Information';
      $content_homepage['content'] = $homepage;
      $this->Pathfinder_model->setConfig('content.homepage', $content_homepage);
    }
    $this->data['main_title'] = 'Pathfinder Configuration';
    $this->load->view('pathfinder/config', $this->data);
  }

  public function content($content_id)
  {
    $content_data = $this->Pathfinder_model->getConfig('content.'.$content_id);
    if (!$content_data) {
      $this->data['content'] = 'No information provided yet';
      $this->data['main_title'] = 'Information';
    } else {
      $this->data['content'] = $content_data['content.'.$content_id]['content'];
      $this->data['main_title'] = $content_data['content.'.$content_id]['title'];      
    }

    $this->load->view('pathfinder/content', $this->data);
  }
  
  public function detail($pathfinder_id)
  {
    $this->data['pathfinder'] = $this->Pathfinder_model->getDetail($pathfinder_id);
    $this->data['main_title'] = $this->data['pathfinder']->title;
    $hidden_type = $this->Pathfinder_model->getConfig('pathfinder/'.$pathfinder_id.'.hidden_type');
    if (isset($hidden_type['pathfinder/'.$pathfinder_id.'.hidden_type'])) {
      $this->data['hidden_type'] = $hidden_type['pathfinder/'.$pathfinder_id.'.hidden_type'];  
    }
    $this->load->view('pathfinder/detail', $this->data);
  }
  
  public function add_resource()
  {
    $pathfinder_id = $this->input->post('pathfinder_ID');
    $resource_id = $this->input->post('resource_ID');
    if (is_array($resource_id)) {
      foreach ($resource_id as $rid) {
        $this->Pathfinder_model->addResource($pathfinder_id, $rid);
      }
    } else {
      $this->Pathfinder_model->addResource($pathfinder_id, $resource_id);  
    }
    
    redirect('/pathfinder/detail/'.$pathfinder_id);
  }
  
  public function remove_resource($pathfinder_id, $resource_id)
  {
    if (!($this->data['logged_in'] && $this->data['group'] == 'Librarian')) {
      redirect('/user');
    }
    $this->Pathfinder_model->removeResource($pathfinder_id, $resource_id);
    redirect('/pathfinder/detail/'.$pathfinder_id);
  }

  public function delete($pathfinder_id)
  {
    if (!($this->data['logged_in'] && $this->data['group'] == 'Librarian')) {
      redirect('/user');
    }
    $this->Pathfinder_model->delete($pathfinder_id);
    redirect('/pathfinder/index');
  }
  
  /**
   * Save data from pathfinder form
   *
   */
  public function save()
  {
    if (!($this->data['logged_in'] && $this->data['group'] == 'Librarian')) {
      redirect('/user');
    }
    $save_data = $this->input->post();
    $update_id = $this->input->post('update_ID');
    $hidden_type = $this->input->post('hidden_type');
    // remove non fields element
    unset($save_data['save']);
    unset($save_data['update_ID']);
    unset($save_data['hidden_type']);

    // change the subject data array
    $temp = $save_data['subjects'];
    $save_data['subjects'] = implode(' ; ', $temp);
    $save_data['subjects_array'] = serialize($temp);
    
    // set the name of Pathfinder creator
    $save_data['authors'] = $this->data['logged_in']['realname'];
    if ($update_id) {
      $this->Pathfinder_model->save($save_data, true, sprintf("id=%d", $update_id));
    } else {
      $update_id = $this->Pathfinder_model->save($save_data);  
    }
    
    if ($hidden_type) {
      $this->Pathfinder_model->setConfig('pathfinder/'.$update_id.'.hidden_type', $hidden_type);
    }
    
    $this->session->set_flashdata('save message', 'Pathfinder data successfully saved');
    redirect('/pathfinder/index');
  }
  
  public function add_resource_form($pathfinder_id)
  {
    if (!($this->data['logged_in'] && $this->data['group'] == 'Librarian')) {
      redirect('/user');
    }
    $this->data['type'] = $this->input->get('type');
    $this->data['pathfinder_ID'] = $pathfinder_id;
    $this->load->view('pathfinder/add_resource_form', $this->data);
  }
  
  public function set_config($config_type, $pathfinder_id, $other_data = '')
  {
    if (!($this->data['logged_in'] && $this->data['group'] == 'Librarian')) {
      redirect('/user');
    }
    if ($config_type == 'visibility') {
      $rt = $this->db->get_where('taxonomy_term', array('tid' => $other_data))->row();
      $resource_type = $rt->name;
      $hidden_type = $this->Pathfinder_model->getConfig('pathfinder/'.$pathfinder_id.'.hidden_type');
      if (isset($hidden_type['pathfinder/'.$pathfinder_id.'.hidden_type'])) {
        if (!in_array($resource_type, $hidden_type['pathfinder/'.$pathfinder_id.'.hidden_type'])) {
          $hidden_type['pathfinder/'.$pathfinder_id.'.hidden_type'][] = $resource_type;
          // var_dump($hidden_type['pathfinder/'.$pathfinder_id.'.hidden_type']);
          // $hidden_type['pathfinder/'.$pathfinder_id.'.hidden_type'] = $resource_type;
          $this->Pathfinder_model->setConfig('pathfinder/'.$pathfinder_id.'.hidden_type', $hidden_type['pathfinder/'.$pathfinder_id.'.hidden_type']);
        }
      }
      redirect('/pathfinder/detail/'.$pathfinder_id);
    }
  }
  
  public function about()
  {
    $this->data['main_title'] = 'About "PUSTAKAWAN"';
    $this->data['content'] = 'PUSTAKAWAN ("Librarian" in english) is a web-based tool to enable any Librarian, mostly Reference Librarian or other Information
      Professional to create a web-based Pathfinder or Subject Guide. PUSTAKAWAN is released as a free open source software
      under GNU GPL version 3. Original Author: <strong>Arie Nugraha - dicarve@gmail.com / arie@ui.ac.id</strong>.';
    $this->load->view('pathfinder/content', $this->data);
  }
}

/* End of file pathfinder.php */