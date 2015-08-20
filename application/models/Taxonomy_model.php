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
 
class Taxonomy_model extends CI_Model {

    public function __construct()
    {
      parent::__construct();
    }
    
    public function getData($taxonomy_type, $page = 1, $limit = 20, $criteria = '', &$total_rows = 0)
    {
      $offset = 0;
      if ($page > 1) {
        $offset = ($page*$limit)-$limit;
      }
      // real query
      $this->db->select('tid, name, vocabulary');
      $this->db->from('taxonomy_term');
      $this->db->where('vocabulary', $taxonomy_type);
      if ($criteria) {
        $this->db->where($criteria, null, false);  
      }
      $this->db->limit($limit, $offset);
      $this->db->order_by('weight');
      // echo $this->db->get_compiled_select();
      $result = $this->db->get();
      
      // paging
      $this->db->where('vocabulary', $taxonomy_type);
      if ($criteria) {
        $this->db->where($criteria, null, false);
      }
      $this->db->select('COUNT(*) as `total`', false);
      $query = $this->db->get('taxonomy_term');
      $data = $query->row();
      $total_rows = $data->total;

      return $result->result();
    }
    
    public function getForSelect($taxonomy_type, $limit = 20, $id_same_with_text = false) {
      $data = array();
      $options = $this->getData($taxonomy_type, 1, $limit);
      foreach ($options as $d) {
        if ($id_same_with_text) {
          $data[$d->name] = $d->name;  
        } else {
          $data[$d->tid] = $d->name;
        }
      }
      return $data;
    }
    
    /**
     * Save taxonomy term
     *
     */
    public function save($data, $is_update = false, $criteria = null)
    {
      if ($is_update) {
        if (is_string($criteria)) {
          $this->db->where($criteria, null, false);    
        } else if (is_array($criteria)) {
          $this->db->where($criteria);
        }
        $this->db->update('taxonomy_term', $data);
      } else {
        $this->db->insert('taxonomy_term', $data);
      }
    }

    /**
     * Delete term data
     *
     */    
    public function delete($term_id)
    {
      $this->db->where(array('tid' => $term_id));
      $this->db->delete('taxonomy_term');
    }
}