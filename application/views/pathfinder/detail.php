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
  
<div class="col-md-12">
<?php
foreach ($types as $type) {
  $normalized_names[$type->name] = strtolower(str_ireplace(array(' ', '/', '\\', '-', '@'), '_', $type->name));
  $total_rows = 0;
  $resources = $this->Resource_model->getData(1, 20, sprintf("type='%s'", $type->name), $total_rows, $pathfinder->id);
?>
<a name="<?php echo $normalized_names[$type->name]; ?>"></a>
<div class="panel panel-primary resource-type">
  <div class="panel-heading">
    <h3 class="panel-title"><?php echo $type->name ?></h3>
  </div>
  <div class="panel-body">
    <?php if ($logged_in) : ?>
    <p>
      <div class="btn-group">
        <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
          Resource <span class="caret"></span>
        </button>
        <ul class="dropdown-menu" role="menu">
          <li><a href="<?php echo site_url('/resource/add/'.$pathfinder->id.'/'.$type->tid) ?>">Add from New Resource</a></li>
          <li><a class="add-resource-btn"
            data-title="Add Resource (<?php echo $type->name ?>)"
            href="<?php echo site_url('/pathfinder/add_resource_form/'.$pathfinder->id) ?>?type=<?php echo urlencode($type->name) ?>">Add from Existing Resource</a></li>
        </ul>
      </div>
      
      <a href="<?php echo site_url('/pathfinder/setconfig/visibility/'.$type->tid) ?>" class="btn btn-sm btn-warning"><i class="glyphicon glyphicon-eye-open"></i> Toogle Visibility</a>
    </p>
    <?php endif; ?>
    <?php
    if ($total_rows) {
      foreach ($resources as $doc) {
        echo '<p class="doc">';
        echo '<span class="doc-field doc-title">'.$doc->title.'</span>';
        echo '<span class="doc-field doc-author">Author(s): '.$doc->authors.'</span>';
        echo '<span class="doc-field doc-year">Publish year: '.$doc->publish_year.'</span>';
        echo '<span class="doc-field doc-buttons"><a class="btn btn-sm btn-danger" title="Remove this resource from this pathfinder"
          href="'.site_url('/pathfinder/remove_resource/'.$pathfinder->id.'/'.$doc->id).'"><i class="glyphicon glyphicon-trash"></i></a></span>';
        echo '</p>';
      }
    } else {
      echo 'No data for this type of resource';
    }
    ?>
  </div>
</div>
<?php
}
?>
</div>


</div>

<?php
ob_start();
?>
<h3>Resource Type</h3>
<ul class="resource-type-links">
<?php
foreach ($types as $type) {
?>
  <li><a href="#<?php echo $normalized_names[$type->name]; ?>"><?php echo $type->name ?></a></li>
<?php
}
?>
</ul>
<?php
$sidebar = ob_get_clean();
?>

<?php
$main_content = ob_get_clean();
require './assets/themes/default/index.tpl.php';
?>