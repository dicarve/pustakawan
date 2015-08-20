<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="shortcut icon" href="../../assets/ico/favicon.ico">

    <title>Pustakawan: Online Pathfinder</title>

    <!-- Bootstrap core CSS -->
    <link href="<?php echo base_url('assets/themes/default') ?>/css/bootstrap.min.css" rel="stylesheet">
    <link href="<?php echo base_url('assets/themes/default') ?>/css/dashboard.css" rel="stylesheet">
    <!-- Chosen core CSS -->
    <link href="<?php echo base_url('assets/chosen') ?>/chosen.min.css" rel="stylesheet">
    <link href="<?php echo base_url('assets/themes/default') ?>/css/app.css" rel="stylesheet">
  </head>

  <body>

    <nav class="navbar navbar-default navbar-fixed-top" role="navigation">
      <div class="container-fluid">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" href="<?php echo site_url() ?>">PUSTAKAWAN: Online Pathfinder</a>
        </div>
        <div class="navbar-collapse collapse">
          <ul class="nav navbar-nav navbar-right">
            <li><a href="<?php echo site_url() ?>">Home</a></li>
            <li><a href="<?php echo site_url('/pathfinder/content/contact') ?>">Contact Librarian</a></li>
            <?php if ($logged_in && $group == 'Librarian') : ?>
            <li class="dropdown">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Admin <span class="caret"></span></a>
              <ul class="dropdown-menu">
                <li><a href="<?php echo site_url('/pathfinder/add') ?>">Add New Pathfinder</a></li>
                <li><a href="<?php echo site_url('/resource/index') ?>">Resource Library</a></li>
                <li><a href="<?php echo site_url('/taxonomy/') ?>">Taxonomy</a></li>
                <li><a href="<?php echo site_url('/pathfinder/config') ?>">Configuration</a></li>
                <li><a href="<?php echo site_url('/user/listusers') ?>">User Management</a></li>
                <li><a href="<?php echo site_url('/user/logout') ?>"><i class="glyphicon glyphicon-log-out"></i> Logout</a></li>
                <li><a href="<?php echo site_url('/pathfinder/about') ?>">About this Software</a></li>
              </ul>
            </li>
            <?php else :
            ?>
            <li><a href="<?php echo site_url('/user') ?>">Login</a></li>
            <?php endif; ?>
          </ul>
          <form class="navbar-form navbar-right" method="get" action="<?php echo site_url('/pathfinder/index') ?>">
            <input type="text" name="keywords" class="form-control" placeholder="Search pathfinder">
          </form>
        </div>
      </div>
    </nav>

    <div class="container-fluid">
      <div class="row">
        <?php if (isset($sidebar) && $sidebar) : ?>
        <div class="col-sm-3 col-md-2 sidebar">
          <?php echo $sidebar ?>
        </div>
        <?php endif; ?>
        
        <div class="<?php echo (isset($sidebar) && $sidebar)?'col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2':'col-md-12' ?> main">
        <h1 class="page-header"><?php echo $main_title ?></h1>
        <?php echo $main_content ?>
        </div>
      </div>
    </div>

    <script src="<?php echo base_url('assets/js') ?>/jquery-2.1.4.min.js"></script>
    <script src="<?php echo base_url('assets/chosen') ?>/chosen.jquery.min.js"></script>
    <script src="<?php echo base_url('assets/chosen') ?>/ajax-chosen.min.js"></script>
    <script src="<?php echo base_url('assets/themes/default/js') ?>/bootstrap.min.js"></script>
    <script src="<?php echo base_url('assets/js') ?>/app.js"></script>
  
    <div class="modal fade" id="modalDialog">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title">Modal title</h4>
          </div>
          <div class="modal-body">
            <p>&nbsp;</p>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
          </div>
        </div><!-- /.modal-content -->
      </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->

</body>
</html>
