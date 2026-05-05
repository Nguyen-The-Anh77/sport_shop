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
          <h2 align="center">Order Details</h2>
          <hr>
          
          <?php if (!empty($orders) && is_array($orders)): ?>
            <?php 
            //isset(): Kiểm tra key có tồn tại trong mảng không
            //Chuẩn bị dữ liệu để hiển thị trong view
            // Lấy thông tin chung từ đơn hàng đầu tiên
            $firstOrder = $orders[0];
            $orderNumber = isset($firstOrder['orderNumber']) ? $firstOrder['orderNumber'] : 'N/A';
            $orderDate = isset($firstOrder['orderDate']) ? date('d/m/Y H:i:s', strtotime($firstOrder['orderDate'])) : 'N/A';
            $customerName = isset($firstOrder['customerName']) ? $firstOrder['customerName'] : 'N/A';
            $customerPhone = isset($firstOrder['phone']) ? $firstOrder['phone'] : 'N/A';
            $customerAddress = isset($firstOrder['addressLine1']) ? $firstOrder['addressLine1'] : 'N/A';
            $customerCity = isset($firstOrder['city']) ? $firstOrder['city'] : 'N/A';
            $customerCountry = isset($firstOrder['country']) ? $firstOrder['country'] : 'N/A';
            $fullAddress = $customerAddress . ', ' . $customerCity . ', ' . $customerCountry;
            $status = isset($firstOrder['status']) ? $firstOrder['status'] : 'Pending';
            
            // Tính tổng tiền
            $totalAmount = 0;
            foreach($orders as $order) {
                $quantity = isset($order['quantityOrdered']) ? $order['quantityOrdered'] : 0;
                $priceEach = isset($order['priceEach']) ? $order['priceEach'] : 0;
                $totalAmount += $quantity * $priceEach;
            }
            ?>
            
            <!-- Thông tin đơn hàng -->
            <div class="row mb-4">
              <div class="col-md-6">
                <div class="card">
                  <div class="card-header">
                    <h5 class="card-title mb-0">Order Information</h5>
                  </div>
                  <div class="card-body">
                    <p><strong>Order Number:</strong> <?= htmlspecialchars($orderNumber) ?></p>
                    <p><strong>Order Date:</strong> <?= $orderDate ?></p>
                    <p><strong>Status:</strong> 
                      <span class="badge badge-<?= $status == 'Completed' ? 'success' : ($status == 'Processing' ? 'warning' : 'info') ?>">
                        <?= htmlspecialchars($status) ?>
                      </span>
                    </p>
                    <p><strong>Total Amount:</strong> <span class="text-danger font-weight-bold"><?= number_format($totalAmount) ?> VND</span></p>
                  </div>
                </div>
              </div>
              
              <!-- Thông tin khách hàng -->
              <div class="col-md-6">
                <div class="card">
                  <div class="card-header">
                    <h5 class="card-title mb-0">Customer Information</h5>
                  </div>
                  <div class="card-body">
                    <p><strong>Name:</strong> <?= htmlspecialchars($customerName) ?></p>
                    <p><strong>Phone:</strong> <?= htmlspecialchars($customerPhone) ?></p>
                    <p><strong>Address:</strong> <?= htmlspecialchars($fullAddress) ?></p>
                  </div>
                </div>
              </div>
            </div>
            
            <!-- Danh sách sản phẩm -->
            <div class="card">
              <div class="card-header">
                <h5 class="card-title mb-0">Products</h5>
              </div>
              <div class="card-body">
                <div class="table-responsive">
                  <table class="table table-bordered">
                    <thead class="thead-light">
                      <tr>
                        <th>Image</th>
                        <th>Product Name</th>
                        <th>Quantity</th>
                        <th>Unit Price</th>
                        <th>Total Price</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php foreach($orders as $order): 
                        $productName = isset($order['productName']) ? $order['productName'] : 'N/A';
                        $quantity = isset($order['quantityOrdered']) ? $order['quantityOrdered'] : 0;
                        $priceEach = isset($order['priceEach']) ? $order['priceEach'] : 0;
                        $image = isset($order['image']) ? $order['image'] : 'path/to/default/image.jpg';
                        $lineTotal = $quantity * $priceEach;
                      ?>
                      <tr>
                        <td>
                          <img src="<?= htmlspecialchars($image) ?>" 
                               alt="<?= htmlspecialchars($productName) ?>" 
                               width="80" 
                               style="height: 80px; object-fit: cover; border-radius: 5px;">
                        </td>
                        <td><?= htmlspecialchars($productName) ?></td>
                        <td class="text-center"><?= (int)$quantity ?></td>
                        <td class="text-right"><?= number_format($priceEach) ?> VND</td>
                        <td class="text-right font-weight-bold"><?= number_format($lineTotal) ?> VND</td>
                      </tr>
                      <?php endforeach; ?>
                    </tbody>
                    <tfoot>
                      <tr class="table-active">
                        <td colspan="4" class="text-right font-weight-bold">Total:</td>
                        <td class="text-right font-weight-bold text-danger"><?= number_format($totalAmount) ?> VND</td>
                      </tr>
                    </tfoot>
                  </table>
                </div>
              </div>
            </div>
            
            <div class="mt-4">
              <a href="?mod=order&act=list" class="btn btn-primary">
                <i class="fas fa-arrow-left"></i> Back to Orders
              </a>
                            <a href="?mod=order&act=delete&id=<?= $orderNumber ?>" onclick="return confirm('Ban có chac chan muon xoa don hàng nay không?');" class="btn btn-danger ml-2">
                <i class="fas fa-trash"></i> Xóa Don Hàng
              </a>
            </div>
            
          <?php else: ?>
            <div class="alert alert-warning">
              <h4 class="alert-heading">Order Not Found</h4>
              <p>Không tìm thấy thông tin đơn hàng hoặc có lỗi xảy ra.</p>
              <hr>
              <a href="?mod=order&act=list" class="btn btn-primary">Back to Orders List</a>
            </div>
          <?php endif; ?>
          
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