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
<div class="panel panel-default">
<div class="panel-body">
<p><button class="btn btn-warning btn-back"> Back to previous page</button>
<?php
if ($logged_in && $group == 'Librarian') {
  echo '<a class="btn btn-sm btn-info" title="Edit this resource from this pathfinder" 
    href="'.site_url('/resource/update/'.$record->id).'"><i class="glyphicon glyphicon-pencil"></i> Edit Resource Data</a> ';
}
?>
</p>
<form class="form-horizontal">
  <div class="form-group">
    <label class="col-sm-2 control-label">Title</label>
    <div class="col-sm-10">
      <p class="form-control-static"><?php echo $record->title ?></p>
    </div>
  </div>
  <div class="form-group">
    <label class="col-sm-2 control-label">Abstract</label>
    <div class="col-sm-10">
      <p class="form-control-static"><?php echo $record->abstract ?></p>
    </div>
  </div>
  <div class="form-group">
    <label class="col-sm-2 control-label">Resource Type</label>
    <div class="col-sm-10">
      <p class="form-control-static"><?php echo $record->type ?></p>
    </div>
  </div>
  <div class="form-group">
    <label class="col-sm-2 control-label">Location</label>
    <div class="col-sm-10">
      <p class="form-control-static"><?php echo $record->location ?></p>
    </div>
  </div>
  <div class="form-group">
    <label class="col-sm-2 control-label">Author(s)</label>
    <div class="col-sm-10">
      <p class="form-control-static"><?php echo $record->authors ?></p>
    </div>
  </div>
  <div class="form-group">
    <label class="col-sm-2 control-label">Series/Journal Title</label>
    <div class="col-sm-10">
      <p class="form-control-static"><?php echo $record->series_title ?></p>
    </div>
  </div>
  <div class="form-group">
    <label class="col-sm-2 control-label">Publish Year</label>
    <div class="col-sm-10">
      <p class="form-control-static"><?php echo $record->publish_year ?></p>
    </div>
  </div>
  <div class="form-group">
    <label class="col-sm-2 control-label">Publisher</label>
    <div class="col-sm-10">
      <p class="form-control-static"><?php echo $record->publisher ?></p>
    </div>
  </div>
  <div class="form-group">
    <label class="col-sm-2 control-label">Publish Place</label>
    <div class="col-sm-10">
      <p class="form-control-static"><?php echo $record->publish_place ?></p>
    </div>
  </div>
  <div class="form-group">
    <label class="col-sm-2 control-label">Format</label>
    <div class="col-sm-10">
      <p class="form-control-static"><?php echo $record->format ?></p>
    </div>
  </div>
  <div class="form-group">
    <label class="col-sm-2 control-label">Language</label>
    <div class="col-sm-10">
      <p class="form-control-static"><?php echo $record->language ?></p>
    </div>
  </div>
  <div class="form-group">
    <label class="col-sm-2 control-label">Collation/Pages</label>
    <div class="col-sm-10">
      <p class="form-control-static"><?php echo $record->collation ?></p>
    </div>
  </div>
  <div class="form-group">
    <label class="col-sm-2 control-label">Classification</label>
    <div class="col-sm-10">
      <p class="form-control-static"><?php echo $record->classification ?></p>
    </div>
  </div>
  <div class="form-group">
    <label class="col-sm-2 control-label">ISBN</label>
    <div class="col-sm-10">
      <p class="form-control-static"><?php echo $record->isbn ?></p>
    </div>
  </div>
  <div class="form-group">
    <label class="col-sm-2 control-label">ISSN</label>
    <div class="col-sm-10">
      <p class="form-control-static"><?php echo $record->issn ?></p>
    </div>
  </div>
  <div class="form-group">
    <label class="col-sm-2 control-label">DOI</label>
    <div class="col-sm-10">
      <p class="form-control-static"><?php echo $record->doi_id ?></p>
    </div>
  </div>
  <div class="form-group">
    <label class="col-sm-2 control-label">Other ID</label>
    <div class="col-sm-10">
      <p class="form-control-static"><?php echo $record->other_id ?></p>
    </div>
  </div>
  <div class="form-group">
    <label class="col-sm-2 control-label">URL/Permalink</label>
    <div class="col-sm-10">
      <p class="form-control-static"><?php echo '<a href="'.$record->url.'" target="_blank">'.$record->url.'</a>' ?></p>
    </div>
  </div>
  <?php if ($record->filename) : ?>
  <div class="form-group">
    <label class="col-sm-2 control-label">Download File</label>
    <div class="col-sm-10">
      <p class="form-control-static"><?php echo '<a href="'.base_url('files/repository/').'/'.$record->filename.'" target="_blank">File Download</a>' ?></p>
    </div>
  </div>
  <?php endif; ?>
</form>

</div>
</div>
<?php
$main_content = ob_get_clean();
require './assets/themes/default/index.tpl.php';
?>