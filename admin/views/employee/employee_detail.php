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
        <h3 align="center">Detail Employee</h3>
        <hr>
        <table class="table">
            <th>Profile</th>
            <th>Employee</th>
            <tr><h2><td><em>Name:</em></td><td><?php echo $emp["lastName"] ?></td></h2></tr>
            <tr><h2><td><em>Email:</em> </td><td><?php echo $emp["email"] ?></td></h2></tr>
            <tr><h2><td><em>Position:</em></td><td> <?php echo $emp["jobTitle"] ?></td></h2></tr>
            <tr><h2><td><em>Age:</em></td><td> <?php echo $emp["age"] ?></td></h2></tr>
            <tr><h2><td><em>Start_Date:</em></td><td><?= $emp['startDate'] ?></td></h2></tr>
            <tr><h2><td><em>Salary:</em></td><td><?= number_format($emp['salary']) ?></td></h2></tr>
        </table>
            <a href="?mod=employee&act=list" type="button" class="btn btn-primary">Back</a>
        </div>
    </div>
</div>
</body>
</html>