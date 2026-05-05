<!DOCTYPE html>
<html>
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
        <h3 align="center">Update Employee</h3>
        <hr>
            <form action="?mod=employee&act=edit" method="POST" role="form" enctype="multipart/form-data">
                <input type="hidden" name="id" value="<?= $emp['employeeNumber'] ?>">
                <div class="form-group">
                    <label for="">Last Name</label>
                    <input type="text" class="form-control" required id="" placeholder="Họ" name="lastName" value="<?php echo $emp['lastName'] ?>">
                </div>
                <div class="form-group">
                    <label for="">First Name</label>
                    <input type="text" class="form-control" required id="" placeholder="Tên" name="firstName" value="<?php echo $emp['firstName'] ?>">
                </div>
                <div class="form-group">
                    <label for="">Email</label>
                    <input type="text" class="form-control" required id="" placeholder="" name="email" value="<?php echo $emp['email'] ?>">
                </div>
                <div class="form-group">
                    <label for="">Password</label>
                    <input type="password" class="form-control" id="" placeholder="*****" name="password" value="">
                </div>
                <div class="form-group">
                    <label for="">Position</label>
                    <input type="text" class="form-control" required id="" placeholder="" name="position" value="<?php echo $emp['jobTitle'] ?>">
                </div>
                <div class="form-group">
                    <label for="">Start_Date</label>
                    <input type="text" class="form-control" required id="" placeholder="" name="startDate" value="<?php echo $emp['startDate'] ?>">
                </div>
                <div class="form-group">
                    <label for="">Age</label>
                    <input type="text" class="form-control" id="" placeholder="" name="age" value="<?php echo $emp['age'] ?>">
                </div>
                <div class="form-group">
                    <label for="">Salary</label>
                    <input type="number" class="form-control" required id="" placeholder="" name="salary" value="<?php echo $emp['salary'] ?>">
                </div>
                <div align="center">
                    <button type="submit" class="btn btn-primary">Update</button>
                    <a href="?mod=employee" type="button" class="btn btn-primary">Back</a>
                </div>
            </form>
        </div>
    </div>
    <br/>
     
</div>
</body>
</html>