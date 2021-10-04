
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
  <!-- Data Tables -->
  <link rel="stylesheet" href="DataTables/datatables.css">
  <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/buttons/2.0.0/css/buttons.dataTables.min.css">

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
    <a href="index3.html" class="brand-link">
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
          <?php if($_SESSION['user_role']==1){?>
          <li class="nav-item">
            <a href="<?= base_url('refer-a-friend');?>" class="nav-link">
              <i class="nav-icon fas fa-user-friends"></i>
              <p>
                Refer A Friend
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
        <div class="row">
          <?php if(session()->getFlashdata('message')):?>
                            <div class="alert alert-success"><?= session()->getFlashdata('message') ?></div>
                        <?php endif;?>
        </div>
        <div class="row">
          <?php if(session()->getFlashdata('failure')):?>
                            <div class="alert alert-danger"><?= session()->getFlashdata('failure') ?></div>
                        <?php endif;?>
        </div>
        <div class="row mb-2">
          <div class="col-sm-12" style="margin-bottom:20px;">
            <h1 class="m-0 text-dark">Referrals Data</h1>
          </div><!-- /.col -->
          
          <div class="row" style="margin:0 auto;">
            <table id="example" class="display" style="width:100%">
                    <thead>
                        <tr>
                            <th>S.N</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Phone</th>
                            <?php if($_SESSION['user_role'] == 0){?>
                            <th>Referred By</th>
                            <?php }?>
                            <th>Referral Code</th>
                            <th>Referral Status</th>
                            <th>Discount Code</th>
                            <th>Discount Status</th>
                            <th>Referred At</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                        $i=1;
                        if($_SESSION['user_role'] == 0){
                          foreach($result as $rs){
                           echo "<tr><td>" . $i. "</td><td>" . $rs->name . "</td><td>"
                                . $rs->email. "</td><td>".$rs->phone. "</td><td>". $rs->referred_by. "</td><td>".$rs->referral_code. "</td><td>".(($rs->referral_status == 0)? 'UNUSED':'USED')."</td><td>".$rs->discount_code. "</td><td>".(($rs->referral_status == 0)? 'UNUSED':'USED')."</td><td>".$rs->created_at
                                ."</td></tr>";
                                $i++;
                          // echo $rs->name;exit;
                          }
                          echo "</table>"; 
                        }
                        else{
                          foreach($result as $rs){
                           echo "<tr><td>" . $i. "</td><td>" . $rs->name . "</td><td>"
                                . $rs->email. "</td><td>".$rs->phone. "</td><td>".$rs->referral_code. "</td><td>".(($rs->referral_status == 0)? 'UNUSED':'USED')."</td><td>".$rs->discount_code. "</td><td>".(($rs->referral_status == 0)? 'UNUSED':'USED')."</td><td>".$rs->created_at
                                ."</td></tr>";
                                $i++;
                          }
                          echo "</table>";
                        }
                        ?>
                    </tbody>
                </table>
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
<script type="text/javascript" charset="utf8" src="DataTables/datatables.js"></script>
 <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/buttons/2.0.0/js/dataTables.buttons.min.js"></script>

    <script type="text/javascript" charset="utf8" src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>

    <script type="text/javascript" charset="utf8" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>

    <script type="text/javascript" charset="utf8" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>

    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/buttons/2.0.0/js/buttons.html5.min.js"></script>

    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/buttons/2.0.0/js/buttons.print.min.js"></script>
<script>
  $(document).ready(function() {
    $('#example').DataTable({
      dom: 'Bfrtip',
      buttons: [
          'copy', 'csv', 'excel', 'pdf', 'print'
      ],
      "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]]
    });
} );
</script>
</body>
</html>

