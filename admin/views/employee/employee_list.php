<!DOCTYPE html>
<html lang="en">

<?php require_once('public/require/head.php') ?>

<body id="page-top">

  <!-- Page Wrapper -->
  <div id="wrapper">

    <!-- Sidebar -->
    <?php require_once('public/require/sidebar.php') ?>
    <!-- End of Sidebar -->

    <!-- Content Wrapper -->
    <div id="content-wrapper" class="d-flex flex-column">

      <!-- Main Content -->
      <div id="content">

        <!-- Topbar -->
        <?php require_once('public/require/header.php') ?>
        <!-- End of Topbar -->

        <!-- Begin Page Content -->
        <div class="container-fluid">

          <!-- Page Heading -->
          <h2 align="center">Quản lý nhân viên</h2>
          <a href="?mod=employee&act=add" class="btn btn-primary">Add</a><br/>
          <?php if(isset($_COOKIE['msg'])){ ?>
              <div class="alert alert-success">
                <strong><?= $_COOKIE['msg'] ?></strong>
              </div>
            <?php }?> 

          <!-- DataTales Example -->
          <div class="card shadow mb-4">
            <div class="card-header py-3">
              <h6 class="m-0 font-weight-bold text-primary">DataTables Employees</h6>
            </div>
            <div class="card-body">
              <div class="table-responsive">
                <!-- File: admin/public/js/demo/datatables-demo.js -->
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0" style="text-align: center;" >
                  <thead>
                    <tr color="yellow"
      >
                      <th>Name</th>
                      <th>Email</th>
                      <th>Job</th>
                      <th>Age</th>
                      <th>Start date</th>
                      <th>Salary</th>
                      <th>Action</th>
                    </tr>
                  </thead>
                  <tfoot>
                    <tr>
                      <th>Name</th>
                      <th>Email</th>
                      <th>Job</th>
                      <th>Age</th>
                      <th>Start date</th>
                      <th>Salary</th>
                      <th>Action</th>
                    </tr>
                  </tfoot>
                  <tbody>
            <?php foreach ($data as $emp) { ?>              
              <tr>
                    <td><?= $emp['lastName'] ?></td>
                    <td><?= $emp['email'] ?></td>
                    <td><?= $emp['jobTitle'] ?></td>
                    <td><?= $emp['age'] ?></td>
                    <td><?= $emp['startDate'] ?></td>
                    <td><?= number_format($emp['salary']) ?> VND</td>
                    <td><a href="?mod=employee&act=detail&id=<?= $emp['employeeNumber'] ?>" class="btn btn-success">Detail</a> 
                    <a href="?mod=employee&act=update&id=<?= $emp['employeeNumber'] ?>" class="btn btn-warning">Update</a>  
                    <a href="?mod=employee&act=delete&id=<?= $emp['employeeNumber'] ?>" onclick="return confirm('Bạn chắc chắn muốn xóa?');" class="btn btn-danger">Delete</a></td>
                  </tr>
            <?php } ?>
            </tbody>
                </table>
              </div>
            </div>
          </div>

        </div>
        <!-- /.container-fluid -->

      </div>
      <!-- End of Main Content -->

      <!-- Footer -->
      <?php require_once('public/require/footer.php') ?>
      <!-- End of Footer -->

    </div>
    <!-- End of Content Wrapper -->

  </div>
  <!-- End of Page Wrapper -->

  <!-- Scroll to Top Button-->
  <a class="scroll-to-top rounded" href="#page-top">
    <i class="fas fa-angle-up"></i>
  </a>

  <!-- Logout Modal-->
  <?php require_once('public/require/logout_modal.php') ?>;

  <?php require_once('public/require/js.php') ?>;

</body>

</html>
