<?php
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

ob_start();
?>
<form role="form" method="post" name="pathfinder-form" id="pathfinder-form" action="<?php echo site_url('/pathfinder/save') ?>">
<?php echo create_bootstrap_input('text', 'title', array(), 'Title', '', '', isset($record->title)?$record->title:'', '', 'Give unique name such as: "Pathfinder for library researchers"', true) ?>
<?php echo create_bootstrap_input('textarea', 'description', array(), 'Description', '', '', isset($record->description)?$record->description:'', '', 'Describe in one or two paragraph explaining this pathfinder', true) ?>
<?php
  $categories = $this->Taxonomy_model->getForSelect('category', 100);
  $category_options = array();
  foreach ($categories as $category) {
    $category_options[$category] = $category;
  }
  echo create_bootstrap_input('select', 'category', $category_options, 'Category', 'chosen', '', isset($record->category)?$record->category:'', '', 'Choose category for this pathfinder', true)
?>
<?php echo create_bootstrap_input('text', 'scope', array(), 'Scope', '', '', isset($record->scope)?$record->scope:'', '', 'Scope of this pathfinder') ?>
<?php echo create_bootstrap_input('text', 'target_users', array(), 'Target users', '', '', isset($record->target_users)?$record->target_users:'', '', 'Intended user type for this pathfinder') ?>
<?php
  $subjects = $this->Taxonomy_model->getForSelect('subject', 100);
  $subject_options = array();
  foreach ($subjects as $subject) {
    $subject_options[$subject] = $subject;
  }
  echo create_bootstrap_input('select', 'subjects[]', $subject_options, 'Subject(s)', 'chosen-ajax', '', isset($record->subjects_array)?unserialize($record->subjects_array):'', 'multiple="multiple" data-ajax-source="'.site_url('/taxonomy/ajax/subject').'"', 'Give one or more subject/topic terms of this pathfinder')
?>
<?php echo create_bootstrap_input('file', 'image_filename', array(), 'Image', '', '', '', '', 'Optional image representing this pathfinder') ?>
<?php
  if (isset($update_ID)) {
    echo text_input('hidden', 'update_ID', '', '', $update_ID);
    echo text_input('hidden', 'update_ID', '', '', $update_ID);
    echo ' ';
  }
?>
<?php echo text_input('submit', 'save', 'btn btn-primary', '', 'Save Pathfinder') ?>
</form>
<?php
$main_content = ob_get_clean();
require './assets/themes/default/index.tpl.php';
?>