<?php
$page_title = 'User';
ob_start();
$info = $this->session->flashdata('info');
if ($info) {
  echo '<div class="alert alert-success">';
  echo $info;
  echo '</div>'."\n";
}

$error = $this->session->flashdata('error');
if ($error) {
  echo '<div class="alert alert-danger">';
  echo $error;
  echo '</div>'."\n";
}
?>
<div class="panel panel-default">
  <div class="panel-body">
    <form class="form-inline pull-left" method="get" action="<?php echo site_url('/user/listusers') ?>">
        <label for="keywords">Search: </label>
        <input type="text" class="form-control form-control-half" name="keywords" id="keywords" placeholder="Search user here" />
        <input type="submit" class="btn btn-primary" name="search" value="Search" />
    </form>
    <div class="pull-right"><a class="btn btn-primary" href="<?php echo site_url('/user/add'); ?>"><i class="glyphicon glyphicon-plus"></i> Add User</a></div>
  </div>
</div>
<table class="table table-bordered table-striped">
  <tr>
    <th class="small-width">No</th>
    <th>User name</th>
    <th>Login name</th>
    <th>Group</th>
    <th class="small-width">Edit</th>
    <th class="small-width">Delete</th>
  </tr>
<?php
$no = 1;
foreach ($userdata as $user) :
?>
  <tr>
    <td><?php echo $no; ?></td>
    <td><?php echo $user['realname']; ?></td>
    <td><?php echo $user['username']; ?></td>
    <td><?php echo $user['groups']; ?></td>
    <td><a class="btn btn-success" href="<?php echo site_url('/user/update/'.$user['id']); ?>"><i class="glyphicon glyphicon-user"></i> Edit</a></td>
    <td><a class="btn btn-danger" href="<?php echo site_url('/user/delete/'.$user['id']); ?>" data-confirm="Are you sure to remove this User?"><i class="glyphicon glyphicon-trash"></i> Delete</a></td>
  </tr>
<?php
$no++;
endforeach;
?>
</table>
<div class="pagination"><?php echo $pagination; ?></div>
<div class="clear"></div>
</fieldset>
<?php
$main_content = ob_get_clean();
require './assets/themes/default/index.tpl.php';
