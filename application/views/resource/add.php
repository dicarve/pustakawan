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
<form role="form" name="resource-form" id="resource-form" method="post" enctype="multipart/form-data" action="<?php echo site_url('/resource/save') ?>">
<?php echo create_bootstrap_input('text', 'title', array(), 'Title', '', '', isset($record->title)?$record->title:'', '', 'Title of this resource', true) ?>
<?php echo create_bootstrap_input('select', 'type', $this->Taxonomy_model->getForSelect('Type', 100, true), 'Resource type', '', '', isset($record->type)?$record->type:$default_resource_type, '', 'Type or media of this resource', true) ?>
<?php
   $author_options = array();
   if (isset($record->authors_array) && $record->authors_array) {
     $authors = unserialize($record->authors_array);
     foreach ($authors as $author) {
        $author_options[$author] = $author;
     }
   }
   echo create_bootstrap_input('select', 'authors[]', $author_options, 'Author(s)', 'select-author chosen-ajax', '', (isset($record->authors_array) && $record->authors_array)?unserialize($record->authors_array):'', 'multiple="multiple" data-ajax-source="'.site_url('/taxonomy/ajax/author').'"',
  'Give one or more name of author(s) for this resource', true) ?>
<?php echo create_bootstrap_input('text', 'series_title', null, 'Series/Journal Title', '', '', isset($record->series_title)?$record->series_title:'', '',
  'Series or journal title where this resource belong') ?>
<?php
   $subject_options = array();
   if (isset($record->subjects_array) && $record->subjects_array) {
     $subjects = unserialize($record->subjects_array);
     foreach ($subjects as $subject) {
        $subject_options[$subject] = $subject;
     }
   }
   echo create_bootstrap_input('select', 'subjects[]', $subject_options, 'Subject(s)', 'chosen-ajax', '', (isset($record->subjects_array) && $record->subjects_array)?unserialize($record->subjects_array):'', 'multiple="multiple" data-ajax-source="'.site_url('/taxonomy/ajax/subject').'"', 'Give one or more subject/topic terms of this resource') ?>
<?php echo create_bootstrap_input('textarea', 'abstract', null, 'Abstract', '', '', isset($record->abstract)?$record->abstract:'', '', 'Write an abstract in one or two paragraph explaining this resource') ?>
<?php echo create_bootstrap_input('text', 'classification', null, 'Classification', '', '', isset($record->classification)?$record->classification:'', '', 'Give one or more in comma separated classification code in DDC, UDC or LC format related to this Subject') ?>
<?php echo create_bootstrap_input('select', 'location', $this->Taxonomy_model->getForSelect('location', 100, true), 'Resource Location', 'chosen-ajax', '', isset($record->location)?$record->location:'', 'data-ajax-source="'.site_url('/taxonomy/ajax/location').'"', 'Name of place where this resource located') ?>
<?php echo create_bootstrap_input('text', 'publish_year', null, 'Publish year', '', '', isset($record->publish_year)?$record->publish_year:'', '', 'Year of publication of this resource') ?>
<?php
   // echo create_bootstrap_input('select', 'publisher', $this->Taxonomy_model->getForSelect('publisher', 100, true), 'Publisher', 'chosen-ajax', '', isset($record->publisher)?$record->publisher:'', 'data-ajax-source="'.site_url('/taxonomy/ajax/publisher').'"', 'Name of publisher for this resource')
   $publisher_options = array();
   if (isset($record->publisher) && $record->publisher) {
      $publisher_options[$record->publisher] = $record->publisher;
   } else {
      $publisher_options[''] = 'Select Publisher';
   }
   echo create_bootstrap_input('select', 'publisher', $publisher_options, 'Publisher', 'chosen-ajax', '', isset($record->publisher)?$record->publisher:'', 'data-ajax-source="'.site_url('/taxonomy/ajax/publisher').'"', 'Name of publisher for this resource');
?>
<?php
   // echo create_bootstrap_input('select', 'publish_place', $this->Taxonomy_model->getForSelect('place', 100, true), 'Publish Place', 'chosen-ajax', '', isset($record->publish_place)?$record->publish_place:'', 'data-ajax-source="'.site_url('/taxonomy/ajax/place').'"', 'Name of publisher for this resource');
   $publish_place_options = array();
   if (isset($record->publish_place) && $record->publish_place) {
      $publish_place_options[$record->publish_place] = $record->publish_place;
   } else {
      $publish_place_options[''] = 'Select Publish Place';
   }
   echo create_bootstrap_input('select', 'publish_place', $publish_place_options, 'Publish Place', 'chosen-ajax', '', isset($record->publish_place)?$record->publish_place:'', 'data-ajax-source="'.site_url('/taxonomy/ajax/place').'"', 'Name of publisher for this resource');
   ?>
<?php echo create_bootstrap_input('select', 'format', $this->Taxonomy_model->getForSelect('format', 100, true), 'Format', '', '', isset($record->format)?$record->format:'', '', 'Format of this resource') ?>
<?php echo create_bootstrap_input('select', 'language', $this->Taxonomy_model->getForSelect('language', 100, true), 'Language', '', '', isset($record->language)?$record->language:'', '', 'Language of this resource content') ?>
<?php echo create_bootstrap_input('text', 'collation', null, 'Collation/Physical Description', '', '', isset($record->collation)?$record->collation:'', '', 'Physical description of this resource such as page numbers') ?>
<?php echo create_bootstrap_input('text', 'doi_id', null, 'Digital Object Identifier (DOI)', '', '', isset($record->doi_id)?$record->doi_id:'', '', 'DOI identifier of this resource') ?>
<?php echo create_bootstrap_input('text', 'isbn', null, 'ISBN', '', '', isset($record->isbn)?$record->isbn:'', '', 'ISBN number') ?>
<?php echo create_bootstrap_input('text', 'issn', null, 'ISSN', '', '', isset($record->issn)?$record->issn:'', '', 'ISSN number') ?>
<?php echo create_bootstrap_input('text', 'other_id', null, 'Other ID', '', '', isset($record->other_id)?$record->other_id:'', '', 'Other ID/local ID for this resource') ?>
<?php echo create_bootstrap_input('text', 'url', null, 'URL', '', '', isset($record->url)?$record->url:'', '', 'URL for this resource') ?>
<?php echo create_bootstrap_input('file', 'filename', array(), 'File', '', '', '', '', 'Digital file of this resource. DON\'T UPLOAD copyrighted material unless you have license to it') ?>
<?php
  if (isset($pathfinder_ID)) {
    echo text_input('hidden', 'pathfinder_ID', '', '', $pathfinder_ID);
  }
  if (isset($update_ID)) {
    echo text_input('hidden', 'update_ID', '', '', $update_ID);
  }
?>
<?php echo text_input('submit', 'save', 'btn btn-primary', '', 'Save Resource') ?>
</form>
<?php
$main_content = ob_get_clean();
require './assets/themes/default/index.tpl.php';
?>