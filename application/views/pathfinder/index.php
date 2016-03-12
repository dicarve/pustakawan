<?php
ob_start();

// sidebar to show category list
ob_start();
$site_logo = $this->Pathfinder_model->getConfig('site_logo');
if ($site_logo) {
  echo '<div class="site-logo text-center"><img src="'.base_url('files/pathfinder/images').'/'.$site_logo.'" class="img-responsive" /></div>';  
} else {
  echo '<div class="site-logo text-center"><img src="'.base_url('files/pathfinder/images').'/logo.png" class="img-responsive" /></div>';  
}
?>
<h3 class="sidebar-header">Category</h3>
<ul class="nav nav-sidebar">
  <li>
    <ul>
    <?php
    $taxonomy = $this->Taxonomy_model->getData('Category', 1, 30);
    foreach ($taxonomy as $data) {
      echo '<li><a href="'.site_url('/pathfinder/index').'?category='.urlencode($data->name).'">'.$data->name.'</a></li>';
    }
    ?>
    </ul>
  </li>
</ul>
<?php
$sidebar = ob_get_clean();

$save_message = $this->session->flashdata('save message');
if ($save_message) {
  echo '<div class="alert alert-success">';
  echo $save_message;
  echo '</div>'."\n";
}

$error = $this->session->flashdata('error');
if ($error) {
  echo '<div class="alert alert-danger">';
  echo $error;
  echo '</div>'."\n";
}

if (!$pathfinder_records) {
  echo '<div class="alert alert-warning">';
  echo 'Sorry, no pathfinder found/available yet';
  if ($logged_in && $group == 'Librarian') {
    echo '<p>';
    echo create_button('anchor', site_url('pathfinder/add'), 'add-pathfinder', 'Add New Pathfinder', 'btn-success', '', $icon = 'plus-sign');
    echo '</p>';
  }
  echo '</div>'."\n";	
} else {

if ($logged_in && $group == 'Librarian') {
  echo '<div class="panel panel-default">';
  echo '<div class="panel-body">';
  echo create_button('anchor', site_url('pathfinder/add'), 'add-pathfinder', 'Add New Pathfinder', 'btn-success', '', $icon = 'plus-sign');
  echo '</div>';
  echo '</div>';
}

$n = 1;
foreach ($pathfinder_records as $pf) :
?>
<div class="panel panel-default pathfinder-panel">
  <div class="panel-heading"><h3 class="panel-title"><?php echo $pf->title ?></h3></div>
  <div class="panel-body">
    <?php
    if ($pf->image_filename) {
      echo '<div class="pathfinder-image"><a href="'.site_url('/pathfinder/detail/'.$pf->id).'"><img src="'.base_url('files/pathfinder/images').'/'.$pf->image_filename.'" class="img-responsive img-thumbnail" /></a></div>';  
    }
    ?>
    <p class="lead pathfinder-description"><?php echo $pf->description ?></p>
    <p class="pathfinder-category">Category: <?php echo $pf->category ?></p>
    <p class="pathfinder-subjects">Subjects: <?php echo $pf->subjects ?></p>
    <p class="pathfinder-actions">
      <a href="<?php echo site_url('/pathfinder/detail/'.$pf->id) ?>" class="btn btn-info"><i class="glyphicon glyphicon-search"></i> Detail</a>
      <?php if ($logged_in && $group == 'Librarian') : ?>
      <a href="<?php echo site_url('/pathfinder/edit/'.$pf->id) ?>" class="btn btn-warning"><i class="glyphicon glyphicon-pencil"></i> Edit</a>
      <a href="<?php echo site_url('/pathfinder/delete/'.$pf->id) ?>" class="btn btn-danger" data-confirm="Are you sure want to remove this Pathfinder?"><i class="glyphicon glyphicon-trash"></i> Delete</a>
      <?php endif; ?>
    </p>
  </div>
</div>
<?php
$n++;
endforeach; ?>

<?php
}
$main_content = ob_get_clean();
require './assets/themes/default/index.tpl.php';
?>