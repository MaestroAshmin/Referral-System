
<!DOCTYPE html>
<!--
This is a starter template page. Use this page to start your new project from
scratch. This page gets rid of all links and provides the needed markup only.
-->
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Referral System</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome Icons -->
  <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="dist/css/adminlte.min.css">

</head>
<body class="hold-transition sidebar-mini">
<div class="wrapper">

  <!-- Navbar -->
  <nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
      </li>
    </ul>

    <ul class="navbar-nav ml-auto">
     
      <li class="nav-item">
        <a class="nav-link"  href="<?= base_url('logout');?>" role="button">Log Out</a>
      </li>
    </ul>
  </nav>
  <!-- /.navbar -->

  <!-- Main Sidebar Container -->
  <aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="<?php echo base_url('dashboard');?>" class="brand-link">
      <img src="images/logo.jpg" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
      <span class="brand-text font-weight-light">Referral System</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user panel (optional) -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
          <img src="images/user.png" class="img-circle elevation-2" alt="User Image">
        </div>
        <div class="info">
          <a href="#" class="d-block"><?= $_SESSION['user_name'];?></a>
        </div>
      </div>

      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
          <?php if($_SESSION['user_role']==0){?>
          <li class="nav-item">
            <a href="<?= base_url('refer-a-friend');?>" class="nav-link">
              <i class="nav-icon fas fa-user-friends"></i>
              <p>
                Send Referral link
                <!-- <span class="right badge badge-danger">New</span> -->
              </p>
            </a>
          </li>
          <?php } ?>
           <?php if($_SESSION['user_role']==0){?>
          <li class="nav-item">
            <a href="<?= base_url('use-referral-code');?>" class="nav-link">
              <i class="nav-icon fas fa-user-friends"></i>
              <p>
                Use Referral Code
                <!-- <span class="right badge badge-danger">New</span> -->
              </p>
            </a>
          </li>
          <?php } ?>
          <?php if($_SESSION['user_role']==0){?>
          <li class="nav-item">
            <a href="<?= base_url('use-discount-code');?>" class="nav-link">
              <i class="nav-icon fas fa-user-friends"></i>
              <p>
                Use Discount Code
                <!-- <span class="right badge badge-danger">New</span> -->
              </p>
            </a>
          </li>
          <?php } ?>
        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-12" style="margin-bottom:20px;">
            <h1 class="m-0 text-dark">Send Referral Link</h1>
          </div><!-- /.col -->
          
          <div class="row" style="margin:0 auto;">
            <!-- <div class="form-container d-block justify-content-center align-items-center"> -->
                    <?php $validation = \Config\Services::validation(); ?>
                    <?php $session = \Config\Services::session();?>
                <form action="ReferAFriend/sendReferralLink" method="post" enctype="multipart/form-data">
                <?= csrf_field() ?>
                            <?php if(session()->getFlashdata('msg')):?>
                                <div class="alert alert-danger"><?= session()->getFlashdata('msg') ?></div>
                            <?php endif;?>
                
                    <div class="mb-3">
                        <label for="name" class="form-label">Name</label>
                        <input type="text" class="form-control" id="name" name="name" aria-describedby="emailHelp">
                        <?php if($validation->getError('name')) {?>
                            <div class='alert alert-danger mt-2'>
                            <?= $error = $validation->getError('name'); ?>
                            </div>
                        <?php }?>
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">Email address</label>
                        <input type="email" class="form-control" id="email" name="email" aria-describedby="emailHelp">
                        <?php if($validation->getError('email')) {?>
                            <div class='alert alert-danger mt-2'>
                            <?= $error = $validation->getError('email'); ?>
                            </div>
                        <?php }?>
                    </div>
                    <div class="mb-3">
                        <label for="phone" class="form-label">Phone Number</label>
                        <input type="text" class="form-control" id="phone" name="phone" aria-describedby="emailHelp">
                        <?php if($validation->getError('phone')) {?>
                            <div class='alert alert-danger mt-2'>
                            <?= $error = $validation->getError('phone'); ?>
                            </div>
                        <?php }?>
                    </div>
                    <button type="submit" class="btn btn-primary">Submit</button>
                </form>
            <!-- </div> -->
          </div>
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <div class="content">
      <div class="container-fluid">
        
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

  <!-- Main Footer -->
  <footer class="main-footer">
    <!-- To the right -->
    <div class="float-right d-none d-sm-inline">
    </div>
    <!-- Default to the left -->
    <strong>Copyright &copy; 2021 <a href="<?= base_url();?>">Referral System</a>.</strong> All rights reserved.
  </footer>
</div>
<!-- ./wrapper -->

<!-- REQUIRED SCRIPTS -->

<!-- jQuery -->
<script src="plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE App -->
<script src="dist/js/adminlte.min.js"></script>
<!-- Datatable -->

</body>
</html>



