<?php
ob_start();
$error = $this->session->flashdata('error');
if ($error) {
  echo '<div class="alert alert-danger">';
  echo $error;
  echo '</div>'."\n";
}
?>
<div class="panel panel-default login-box">
<div class="panel-heading">Fill username and password to login</div>
<div class="panel-body">
<form action="<?php print site_url('/user/check_login'); ?>" method="post" class="form-horizontal" role="form">
  <div class="form-group">
    <label for="inputEmail1" class="col-lg-2 control-label">Username</label>
    <div class="col-lg-10">
      <input type="username" name="username" class="form-control" id="username" placeholder="Username" />
    </div>
  </div>
  <div class="form-group">
    <label for="inputPassword1" class="col-lg-2 control-label">Password</label>
    <div class="col-lg-10">
      <input type="password" name="password" class="form-control" id="password" placeholder="Password" />
    </div>
  </div>
  <div class="form-group">
    <div class="col-lg-offset-2 col-lg-10">
      <input type="submit" value="Login" class="btn btn-primary" />
    </div>
  </div>
</form>
</div>
</div>
<?php
$main_content = ob_get_clean();
require './assets/themes/default/index.tpl.php';
?>
