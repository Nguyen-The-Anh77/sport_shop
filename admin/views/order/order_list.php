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
       
          
      <!-- Page Heading -->
      <div class="container-fluid">
        <h2 align="center">List Orders</h2>
          <?php if(isset($_COOKIE['msg'])){ ?>
            <div class="alert alert-success">
              <strong><?= $_COOKIE['msg'] ?></strong>
            </div>
          <?php }?>
        
        <!-- Thông kê -->
        <div class="row">
          <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
              <div class="card-body">
                <div class="row no-gutters align-items-center">
                  <div class="col mr-2">
                    <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Tông Doanh Thu</div>
                    <div class="h5 mb-0 font-weight-bold text-gray-800">
                      <?php 
                      $total_revenue = 0;
                      foreach($data as $order) {
                        $total_revenue += $order['quantityOrdered'] * $order['priceEach'];
                      }
                      echo number_format($total_revenue) . ' VND';
                      ?>
                    </div>
                  </div>
                  <div class="col-auto">
                    <i class="fas fa-dollar-sign fa-2x text-gray-300"></i>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-success shadow h-100 py-2">
              <div class="card-body">
                <div class="row no-gutters align-items-center">
                  <div class="col mr-2">
                    <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Sô Đơn Hàng</div>
                    <div class="h5 mb-0 font-weight-bold text-gray-800">
                      <?php 
                      $order_count = count(array_unique(array_column($data, 'orderNumber')));
                      echo $order_count;
                      ?>
                    </div>
                  </div>
                  <div class="col-auto">
                    <i class="fas fa-shopping-cart fa-2x text-gray-300"></i>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-info shadow h-100 py-2">
              <div class="card-body">
                <div class="row no-gutters align-items-center">
                  <div class="col mr-2">
                    <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Tổng Sản Phẩm</div>
                    <div class="h5 mb-0 font-weight-bold text-gray-800">
                      <?php 
                      $total_products = array_sum(array_column($data, 'quantityOrdered'));
                      echo $total_products;
                      ?>
                    </div>
                  </div>
                  <div class="col-auto">
                    <i class="fas fa-box fa-2x text-gray-300"></i>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-warning shadow h-100 py-2">
              <div class="card-body">
                <div class="row no-gutters align-items-center">
                  <div class="col mr-2">
                    <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">Giá Trị Trung Bình</div>
                    <div class="h5 mb-0 font-weight-bold text-gray-800">
                      <?php 
                      if($order_count > 0) {
                        $avg_order = $total_revenue / $order_count;
                        echo number_format($avg_order) . ' VND';
                      } else {
                        echo '0 VND';
                      }
                      ?>
                    </div>
                  </div>
                  <div class="col-auto">
                    <i class="fas fa-chart-bar fa-2x text-gray-300"></i>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <!-- Kêt thúc thông kê -->
        <div class="card shadow mb-4">
            <div class="card-header py-3">
              <h6 class="m-0 font-weight-bold text-primary">DataTables List Orders</h6>
            </div>
            <div class="card-body">
              <div class="table-responsive">
                <table class="table table-bordered" width="100%" cellspacing="0">
            <thead>
              <tr>
                    <th>Order_Date</th>
                    <th>Order_Number</th>
                    <th>Product_Name</th>
                    <th>Quantity</th>
                    <th>Total_Price (VND)</th>
                    <th>Image</th>
                    <th>Action</th>
                  </tr>
            </thead>
            <tbody>
            <?php 
// Query da co ORDER BY o.orderDate DESC, khong can usort nua
foreach ($data as $order) { ?>              
              <tr>
                    <td><?= !empty($order['orderDate']) ? date('d/m/Y H:i:s', strtotime($order['orderDate'])) : 'N/A' ?></td>
                    <td><?= $order['orderNumber'] ?></td>
                    <td><?= $order['productName'] ?></td>
                    <td><?= $order['quantityOrdered'] ?></td>
                    <td><?= number_format($order['quantityOrdered'] * $order['priceEach']) ?></td>
                    <td><img src="<?= $order['image'] ?>" width="150px" hight="200px"></td>
                    <td>
                    <a href="?mod=order&act=detail&id=<?= $order['orderNumber'] ?>" class="btn btn-success btn-sm">Detail</a> 
                    <a href="?mod=order&act=delete&id=<?= $order['orderNumber'] ?>" onclick="return confirm('Ban có chac chan muon xóa don hàng nay không?');" class="btn btn-danger btn-sm">Xóa</a>
                  </td>
                  </tr>
            <?php } ?>
            </tbody>
          </table>
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
