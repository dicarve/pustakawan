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
<div class="well">
  <p class="lead"><?php echo $pathfinder->description ?></p>
  <div class="row">
    <div class="col-md-2 bg-primary info">Scope</div><div class="col-md-2"><?php echo $pathfinder->scope ?></div>
    <div class="col-md-2 bg-primary info">Target users</div><div class="col-md-2"><?php echo $pathfinder->target_users ?></div>
    <div class="col-md-2 bg-primary info">Subject</div><div class="col-md-2"><?php echo $pathfinder->subjects ?></div>
  </div>
</div>

<h3>Resources</h3>
<?php
$normalized_names = array();
$types = $this->Taxonomy_model->getData('Type', 1, 30);
?>

<div class="row">
  
<div class="col-md-9">
<?php
foreach ($types as $type) {
  $normalized_names[$type->name] = strtolower(str_ireplace(array(' ', '/', '\\', '-', '@'), '_', $type->name));
?>
<a name="<?php echo $normalized_names[$type->name]; ?>"></a>
<div class="panel panel-primary resource-type">
  <div class="panel-heading">
    <h3 class="panel-title"><?php echo $type->name ?></h3>
  </div>
  <div class="panel-body">
    <p>
      <p class="pull-right"><a href="<?php echo site_url('/resource/add/'.$pathfinder->id.'/'.$type->tid) ?>" class="btn btn-info"><i class="glyphicon glyphicon-plus"></i> Add Resource</a></p>
    </p>
    <p>No data yet</p>
  </div>
</div>
<?php
}
?>
</div>
<div class="col-md-3">
<ul class="nav nav-pills nav-stacked resource-type-links">
<?php
foreach ($types as $type) {
?>
  <li><a href="#<?php echo $normalized_names[$type->name]; ?>"><?php echo $type->name ?></a></li>
<?php
}
?>
</ul>
</div>

</div>

<?php
$main_content = ob_get_clean();
require './assets/themes/default/index.tpl.php';
?>