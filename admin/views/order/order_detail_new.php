<?php
// Hàm chuyển đổi trạng thái
function getStatusText($status) {
  $statusMap = [
    'Shipped' => 'Đã giao hàng',
    'Cancelled' => 'Đã hủy',
    'On Hold' => 'Tạm giữ',
    'Disputed' => 'Tranh chấp',
    'In Process' => 'Đang xử lý',
    'Pending' => 'Chờ xử lý'
  ];
  return $statusMap[$status] ?? $status;
}

// Hàm lấy class CSS cho trạng thái
function getStatusBadgeClass($status) {
  $classMap = [
    'Shipped' => 'success',
    'Cancelled' => 'danger',
    'On Hold' => 'warning',
    'Disputed' => 'danger',
    'In Process' => 'info',
    'Pending' => 'secondary'
  ];
  return $classMap[$status] ?? 'secondary';
}
?>
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
          <div class="card shadow mb-4">
            <div class="card-header py-3">
              <h4 class="m-0 font-weight-bold text-primary">
                <i class="fas fa-shopping-cart"></i> Thông tin đơn hàng
              </h4>
            </div>
            <div class="card-body">
              <?php if (!empty($orders) && is_array($orders)): 
                $order = $orders[0]; // Lấy thông tin chung từ sản phẩm đầu tiên
              ?>
                <div class="row mb-4">
                  <div class="col-md-6">
                    <h5>Mã đơn hàng: <strong>#<?= htmlspecialchars($order['orderNumber'] ?? '') ?></strong></h5>
                    <p class="mb-1">Ngày đặt: <?= !empty($order['orderDate']) ? date('d/m/Y', strtotime($order['orderDate'])) : 'N/A' ?></p>
                    <p class="mb-1">Trạng thái: 
                      <span class="badge badge-<?= getStatusBadgeClass($order['status'] ?? '') ?>">
                        <?= getStatusText($order['status'] ?? '') ?>
                      </span>
                    </p>
                  </div>
                  <div class="col-md-6 text-md-right">
                    <h5>Tổng cộng: <span class="text-danger">
                      <?php 
                        $total = 0;
                        foreach($orders as $item) {
                          $total += ($item['quantityOrdered'] ?? 0) * ($item['priceEach'] ?? 0);
                        }
                        echo number_format($total) . ' VND';
                      ?>
                    </span></h5>
                  </div>
                </div>

                <div class="table-responsive">
                  <table class="table table-bordered" width="100%" cellspacing="0">
                    <thead class="thead-light">
                      <tr>
                        <th>STT</th>
                        <th>Sản phẩm</th>
                        <th class="text-center">Số lượng</th>
                        <th class="text-right">Đơn giá</th>
                        <th class="text-right">Thành tiền</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php $i = 1; foreach($orders as $item): 
                        $subtotal = ($item['quantityOrdered'] ?? 0) * ($item['priceEach'] ?? 0);
                      ?>
                        <tr>
                          <td><?= $i++ ?></td>
                          <td>
                            <div class="d-flex align-items-center">
                              <?php if (!empty($item['image'])): ?>
                                <img src="<?= htmlspecialchars($item['image']) ?>" 
                                     class="img-thumbnail mr-3" 
                                     style="width: 60px; height: 60px; object-fit: cover;"
                                     alt="<?= htmlspecialchars($item['productName'] ?? '') ?>">
                              <?php endif; ?>
                              <div>
                                <h6 class="mb-0"><?= htmlspecialchars($item['productName'] ?? 'N/A') ?></h6>
                                <small class="text-muted">Mã SP: <?= htmlspecialchars($item['productCode'] ?? '') ?></small>
                              </div>
                            </div>
                          </td>
                          <td class="text-center"><?= $item['quantityOrdered'] ?? 0 ?></td>
                          <td class="text-right"><?= number_format($item['priceEach'] ?? 0) ?> VND</td>
                          <td class="text-right"><?= number_format($subtotal) ?> VND</td>
                        </tr>
                      <?php endforeach; ?>
                      <tr>
                        <td colspan="4" class="text-right"><strong>Tổng cộng:</strong></td>
                        <td class="text-right"><strong><?= number_format($total) ?> VND</strong></td>
                      </tr>
                    </tbody>
                  </table>
                </div>

                <div class="row mt-4">
                  <div class="col-md-6">
                    <div class="card border-left-primary shadow h-100 py-2">
                      <div class="card-body">
                        <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                          Thông tin khách hàng
                        </div>
                        <div class="mb-0">
                          <p class="mb-1">Mã KH: <?= htmlspecialchars($order['customerNumber'] ?? 'N/A') ?></p>
                          <p class="mb-1">Ngày giao dự kiến: <?= !empty($order['requiredDate']) ? date('d/m/Y', strtotime($order['requiredDate'])) : 'N/A' ?></p>
                          <p class="mb-1">Ngày giao hàng: <?= !empty($order['shippedDate']) ? date('d/m/Y', strtotime($order['shippedDate'])) : 'Chưa giao' ?></p>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="card border-left-info shadow h-100 py-2">
                      <div class="card-body">
                        <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                          Ghi chú đơn hàng
                        </div>
                        <div class="mb-0">
                          <?= !empty($order['comments']) ? nl2br(htmlspecialchars($order['comments'])) : 'Không có ghi chú' ?>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>

                <div class="mt-4">
                  <a href="?mod=order&act=list" class="btn btn-secondary">
                    <i class="fas fa-arrow-left"></i> Quay lại danh sách
                  </a>
                  <button type="button" class="btn btn-primary ml-2" onclick="window.print()">
                    <i class="fas fa-print"></i> In đơn hàng
                  </button>
                </div>

              <?php else: ?>
                <div class="alert alert-warning mb-0">
                  <i class="fas fa-exclamation-triangle"></i> Không tìm thấy thông tin đơn hàng hoặc có lỗi xảy ra.
                </div>
                <div class="mt-3">
                  <a href="?mod=order&act=list" class="btn btn-secondary">
                    <i class="fas fa-arrow-left"></i> Quay lại danh sách
                  </a>
                </div>
              <?php endif; ?>
            </div>
          </div>
        </div>
        <!-- /.container-fluid -->
      </div>
      <!-- End of Main Content -->
    </div>
    <!-- End of Content Wrapper -->
  </div>
  <!-- End of Page Wrapper -->

  <!-- Scroll to Top Button-->
  <a class="scroll-to-top rounded" href="#page-top">
    <i class="fas fa-angle-up"></i>
  </a>

  <!-- Bootstrap core JavaScript-->
  <script src="vendor/jquery/jquery.min.js"></script>
  <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <!-- Core plugin JavaScript-->
  <script src="vendor/jquery-easing/jquery.easing.min.js"></script>
  <!-- Custom scripts for all pages-->
  <script src="js/sb-admin-2.min.js"></script>
</body>
</html>
