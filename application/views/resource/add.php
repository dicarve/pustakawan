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
<form role="form" name="resource-form" id="resource-form" method="post" action="<?php echo site_url('/resource/save') ?>">
<?php echo create_bootstrap_input('text', 'title', array(), 'Title', '', '', isset($record->title)?$record->title:'', '', 'Title of this resource', true) ?>
<?php echo create_bootstrap_input('select', 'type', $this->Taxonomy_model->getForSelect('Type', 100, true), 'Resource type', '', '', isset($record->type)?$record->type:$default_resource_type, '', 'Type or media of this resource', true) ?>
<?php echo create_bootstrap_input('select', 'authors[]', $this->Taxonomy_model->getForSelect('Author', 10, true), 'Author(s)', 'select-author chosen-ajax', '', (isset($record->authors_array) && $record->authors_array)?unserialize($record->authors_array):'', 'multiple="multiple" data-ajax-source="'.site_url('/taxonomy/ajax/author').'"',
  'Give one or more name of author(s) for this resource', true) ?>
<?php echo create_bootstrap_input('text', 'series_title', array(), 'Series/Journal Title', '', '', isset($record->series_title)?$record->series_title:'', '',
  'Series or journal title where this resource belong') ?>
<?php echo create_bootstrap_input('select', 'subjects[]', $this->Taxonomy_model->getForSelect('Subject', 10, true), 'Subject(s)', 'chosen-ajax', '', (isset($record->subjects_array) && $record->subjects_array)?unserialize($record->subjects_array):'', 'multiple="multiple" data-ajax-source="'.site_url('/taxonomy/ajax/subject').'"', 'Give one or more subject/topic terms of this resource') ?>
<?php echo create_bootstrap_input('textarea', 'abstract', array(), 'Abstract', '', '', isset($record->abstract)?$record->abstract:'', '', 'Write an abstract in one or two paragraph explaining this resource') ?>
<?php echo create_bootstrap_input('text', 'classification', array(), 'Classification', '', '', isset($record->classification)?$record->classification:'', '', 'Give one or more in comma separated classification code in DDC, UDC or LC format related to this Subject') ?>
<?php echo create_bootstrap_input('select', 'location', $this->Taxonomy_model->getForSelect('location', 100), 'Resource Location', 'chosen', '', isset($record->location)?$record->location:'', '', 'Name of place where this resource located') ?>
<?php echo create_bootstrap_input('text', 'publish_year', array(), 'Publish year', '', '', isset($record->publish_year)?$record->publish_year:'', '', 'Year of publication of this resource') ?>
<?php echo create_bootstrap_input('select', 'publisher', $this->Taxonomy_model->getForSelect('publisher', 100), 'Publisher', 'chosen', '', isset($record->publisher)?$record->publisher:'', '', 'Name of publisher for this resource') ?>
<?php echo create_bootstrap_input('text', 'collation', null, 'Collation/Physical Description', '', '', isset($record->collation)?$record->collation:'', '', 'Physical description of this resource such as page numbers') ?>
<?php echo create_bootstrap_input('text', 'doi_id', null, 'Digital Object Identifier (DOI)', '', '', isset($record->doi_id)?$record->doi_id:'', '', 'DOI identifier of this resource') ?>
<?php echo create_bootstrap_input('text', 'isbn', null, 'ISBN', '', '', isset($record->isbn)?$record->isbn:'', '', 'ISBN number') ?>
<?php echo create_bootstrap_input('text', 'issn', null, 'ISSN', '', '', isset($record->issn)?$record->issn:'', '', 'ISSN number') ?>
<?php echo create_bootstrap_input('text', 'other_id', null, 'Other ID', '', '', isset($record->other_id)?$record->other_id:'', '', 'Other ID/local ID for this resource') ?>
<?php echo create_bootstrap_input('text', 'url', null, 'URL', '', '', isset($record->url)?$record->url:'', '', 'URL for this resource') ?>
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