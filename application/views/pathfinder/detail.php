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
  <?php if ($logged_in && $group == 'Librarian') : ?>
  <p><a href="<?php echo site_url('/pathfinder/edit/'.$pathfinder->id) ?>" class="btn btn-info"><i class="glyphicon glyphicon-pencil"></i> Edit this pathfinder</a></p>
  <?php endif; ?>
</div>

<h3>Resources</h3>
<?php
$normalized_names = array();
$hidden_type_str = '';
if (isset($hidden_type) && $hidden_type) {
  // var_dump($hidden_type);
  foreach($hidden_type as $tp) {
    $hidden_type_str .= "'$tp',";
  }
  // remove last comma
  $hidden_type_str = substr_replace($hidden_type_str, '', -1);
  $types = $this->Taxonomy_model->getData('Type', 1, 30, "name NOT IN ($hidden_type_str)");  
} else {
  $types = $this->Taxonomy_model->getData('Type', 1, 30);  
}

?>

<div class="row">
  
<div class="col-md-12 pathfinder-resources-list">
<?php
// load bibliography list style if exists
$biblio_tpl = './assets/themes/default/templates/biblio.style.php';
if (file_exists($biblio_tpl)) {
  include_once $biblio_tpl;
} else {
  include_once './assets/themes/default/templates/biblio-default.style.php';
}
foreach ($types as $type) {
  $normalized_names[$type->name] = strtolower(str_ireplace(array(' ', '/', '\\', '-', '@'), '_', $type->name));
  $total_rows = 0;
  $resources = $this->Resource_model->getData(1, 20, sprintf("type='%s'", $type->name), $total_rows, $pathfinder->id);
?>
<a name="<?php echo $normalized_names[$type->name]; ?>" id="<?php echo $normalized_names[$type->name]; ?>"></a>
<div class="panel panel-primary resource-type">
  <div class="panel-heading">
    <h3 class="panel-title"><?php echo $type->name ?>
    <?php if ($logged_in && $group == 'Librarian') : ?>
    <div>
      <div class="btn-group">
        <a type="button" class="btn btn-warning btn-xs dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
          Manage <span class="caret"></span>
        </a>
        <ul class="dropdown-menu" role="menu">
          <li><a class="add-resource-btn"
            data-title="Add Resource (<?php echo $type->name ?>)"
            href="<?php echo site_url('/pathfinder/add_resource_form/'.$pathfinder->id) ?>?type=<?php echo urlencode($type->name) ?>">Add resource from existing records</a></li>
          <li><a href="<?php echo site_url('/resource/add/'.$pathfinder->id.'/'.$type->tid) ?>">Add new resource</a></li>
          <li><a href="<?php echo site_url('/pathfinder/set_config/visibility/'.$pathfinder->id.'/'.$type->tid) ?>" data-confirm="Are you sure want to hide this resource type?"><i class="glyphicon glyphicon-eye-close"></i> Hide this resource type</a></li>
        </ul>
      </div>
    </div>
    <?php endif; ?>
    </h3>
  </div>
  <div class="panel-body">
    <?php
    if ($total_rows) {
      biblio_style_header($pathfinder, $logged_in, $group);
      foreach ($resources as $doc) {
        biblio_style($pathfinder, $doc, $logged_in, $group);
      }
      biblio_style_footer($pathfinder, $logged_in, $group);
    } else {
      echo 'No data yet for this type of resource';
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
if ($pathfinder->image_filename) {
  echo '<div class="pathfinder-image-detail"><img src="'.base_url('files/pathfinder/images').'/'.$pathfinder->image_filename.'" class="img-responsive img-thumbnail" /></div>';  
}
?>
<h3>Resource Type</h3>
<nav id="sidebar-nav">
<ul class="nav nav-pills nav-stacked resource-type-links">
<?php
foreach ($types as $type) {
?>
  <li><a href="#<?php echo $normalized_names[$type->name]; ?>"><?php echo $type->name ?></a></li>
<?php
}
?>
</ul>
</nav>
<?php
$sidebar = ob_get_clean();
?>

<?php
$main_content = ob_get_clean();
require './assets/themes/default/index.tpl.php';
?>