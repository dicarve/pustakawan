<?php
ob_start();
$save_message = $this->session->flashdata('save message');
if ($save_message) {
  echo '<div class="alert alert-success">';
  echo $save_message;
  echo '</div>'."\n";
}

$delete_message = $this->session->flashdata('delete message');
if ($delete_message) {
  echo '<div class="alert alert-warning">';
  echo $delete_message;
  echo '</div>'."\n";
}

$n = 1;
?>
<div class="panel panel-default">
  <div class="panel-body">
    <form name="taxonomy_search" id="taxonomy_search" class="form-inline" method="get" action="<?php echo site_url('/taxonomy/index/'.$type) ?>">
      <div class="form-group">
        <input type="text" name="keywords" class="form-control" placeholder="Put one or more keyword(s) here" />
      </div>
      <input type="submit" name="save" class="btn btn-primary" value="Search" />
      <div class="pull-right">
        <a class="btn btn-success" href="<?php echo site_url('/taxonomy/add/'.$type) ?>"><i class="glyphicon glyphicon-plus"></i> Add New Term</a>
      </div>
      <input type="hidden" name="type" value="<?php echo $type ?>" />
    </form>
  </div>
</div>

<div class="row">
  <div class="col-md-3">
    <div class="list-group">
      <a href="<?php echo site_url('/taxonomy/index/subject') ?>" class="list-group-item"><i class="glyphicon glyphicon-tags"></i> Subject</a>
      <a href="<?php echo site_url('/taxonomy/index/category') ?>" class="list-group-item"><i class="glyphicon glyphicon-bookmark"></i> Pathfinder Category</a>
      <a href="<?php echo site_url('/taxonomy/index/type') ?>" class="list-group-item"><i class="glyphicon glyphicon-open-file"></i> Resource Type</a>
      <a href="<?php echo site_url('/taxonomy/index/author') ?>" class="list-group-item"><i class="glyphicon glyphicon-user"></i> Authors</a>
      <a href="<?php echo site_url('/taxonomy/index/format') ?>" class="list-group-item"><i class="glyphicon glyphicon-floppy-disk"></i> Resource Format</a>
      <a href="<?php echo site_url('/taxonomy/index/location') ?>" class="list-group-item"><i class="glyphicon glyphicon-map-marker"></i> Resource Location</a>
      <a href="<?php echo site_url('/taxonomy/index/publisher') ?>" class="list-group-item"><i class="glyphicon glyphicon-map-marker"></i> Publisher</a>
    </div>
  </div>
  <div class="col-md-9">
    <?php
    if (!$records) {
      echo '<div class="alert alert-warning">';
      echo 'Sorry, no taxonomy data available yet';
      echo '</div>'."\n";	
    } else {
    ?>

      <table class="table table-bordered table-striped">
      <tr><th style="width: 5%;">No.</th><th>Term Name</th><th style="width: 5%;">Ubah</th><th style="width: 5%;">Hapus</th></tr>
      <?php
      foreach ($records as $data) :
      ?>
      <tr>
        <td><?php echo $n ?></td><td><?php echo $data->name ?></td>
        <td><a class="btn btn-warning" href="<?php echo site_url('/taxonomy/update/'.$data->tid) ?>">Edit</a></td>
        <td><a class="btn btn-danger" href="<?php echo site_url('/taxonomy/delete/'.$data->tid) ?>" data-confirm="Are you sure want to delete this term?">Delete</a></td>
      </tr>
      <?php
      $n++;
      endforeach;
      }?>
      </table>
      <?php echo $pagination; ?>
  </div>
</div>
<?php
$main_content = ob_get_clean();
require './assets/themes/default/index.tpl.php';
?>