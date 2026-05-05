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

          <!-- Page Heading -->
            <h3 align="center">Customer Detail</h3>
            <hr>
            <table class="table">
                <th>Profile</th>
                <th>Information</th>
                <tr><h2><td><em>Customer Name:</em></td><td><?php echo $cus["customerName"] ?></td></h2></tr>
                <tr><h2><td><em>Email:</em> </td><td><?php echo $cus["email"] ?></td></h2></tr>
                <tr><h2><td><em>Phone Number:</em></td><td><?php echo $cus["phone"] ?></td></h2></tr>
                <tr><h2><td><em>Address:</em></td><td><?php echo $cus["addressLine1"] ?>, <?php echo $cus["city"] ?>, <?php echo $cus["country"] ?></td></h2></tr>
            </table>
            <a href="?mod=customer&act=list" type="button" class="btn btn-primary">Back</a>
        </div>
        </div>
    </div>
</body>
</html>