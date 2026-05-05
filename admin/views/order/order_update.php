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
          <h2 align="center">Update Order</h2>
          <hr>
          
          <?php if (!empty($orders) && is_array($orders)): ?>
            <?php 
            // Lây thông tin chung don hàng
            $firstOrder = $orders[0];
            $orderNumber = isset($firstOrder['orderNumber']) ? $firstOrder['orderNumber'] : 'N/A';
            $orderDate = isset($firstOrder['orderDate']) ? date('d/m/Y H:i:s', strtotime($firstOrder['orderDate'])) : 'N/A';
            $customerName = isset($firstOrder['customerName']) ? $firstOrder['customerName'] : 'N/A';
            $status = isset($firstOrder['status']) ? $firstOrder['status'] : 'Pending';
            $comments = isset($firstOrder['comments']) ? $firstOrder['comments'] : '';
            ?>
            
            <form method="POST" action="?mod=order&act=edit">
              <input type="hidden" name="id" value="<?= $orderNumber ?>">
              
              <div class="row">
                <div class="col-md-6">
                  <div class="card">
                    <div class="card-header">
                      <h5 class="card-title mb-0">Order Information</h5>
                    </div>
                    <div class="card-body">
                      <div class="form-group">
                        <label><strong>Order Number:</strong></label>
                        <input type="text" class="form-control" value="<?= htmlspecialchars($orderNumber) ?>" readonly>
                      </div>
                      
                      <div class="form-group">
                        <label><strong>Order Date:</strong></label>
                        <input type="text" class="form-control" value="<?= $orderDate ?>" readonly>
                      </div>
                      
                      <div class="form-group">
                        <label><strong>Customer:</strong></label>
                        <input type="text" class="form-control" value="<?= htmlspecialchars($customerName) ?>" readonly>
                      </div>
                      
                      <div class="form-group">
                        <label for="status"><strong>Status:</strong></label>
                        <select name="status" id="status" class="form-control" required>
                          <option value="Pending" <?= $status == 'Pending' ? 'selected' : '' ?>>Pending</option>
                          <option value="Processing" <?= $status == 'Processing' ? 'selected' : '' ?>>Processing</option>
                          <option value="Shipped" <?= $status == 'Shipped' ? 'selected' : '' ?>>Shipped</option>
                          <option value="Completed" <?= $status == 'Completed' ? 'selected' : '' ?>>Completed</option>
                          <option value="Cancelled" <?= $status == 'Cancelled' ? 'selected' : '' ?>>Cancelled</option>
                        </select>
                      </div>
                      
                      <div class="form-group">
                        <label for="comments"><strong>Comments:</strong></label>
                        <textarea name="comments" id="comments" class="form-control" rows="3"><?= htmlspecialchars($comments) ?></textarea>
                      </div>
                    </div>
                  </div>
                </div>
                
                <div class="col-md-6">
                  <div class="card">
                    <div class="card-header">
                      <h5 class="card-title mb-0">Products</h5>
                    </div>
                    <div class="card-body">
                      <div class="table-responsive">
                        <table class="table table-bordered">
                          <thead class="thead-light">
                            <tr>
                              <th>Product Name</th>
                              <th>Quantity</th>
                              <th>Unit Price</th>
                              <th>Total</th>
                            </tr>
                          </thead>
                          <tbody>
                            <?php foreach($orders as $order): 
                              $productName = isset($order['productName']) ? $order['productName'] : 'N/A';
                              $quantity = isset($order['quantityOrdered']) ? $order['quantityOrdered'] : 0;
                              $priceEach = isset($order['priceEach']) ? $order['priceEach'] : 0;
                              $lineTotal = $quantity * $priceEach;
                            ?>
                            <tr>
                              <td><?= htmlspecialchars($productName) ?></td>
                              <td>
                                <input type="number" name="quantity_<?= $order['productCode'] ?>" 
                                       value="<?= (int)$quantity ?>" min="1" class="form-control form-control-sm">
                              </td>
                              <td>
                                <input type="number" name="price_<?= $order['productCode'] ?>" 
                                       value="<?= number_format($priceEach, 0, '.', '') ?>" 
                                       min="0" step="0.01" class="form-control form-control-sm">
                              </td>
                              <td class="text-right font-weight-bold"><?= number_format($lineTotal) ?> VND</td>
                            </tr>
                            <?php endforeach; ?>
                          </tbody>
                        </table>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              
              <div class="mt-4">
                <button type="submit" class="btn btn-success">
                  <i class="fas fa-save"></i> Save Changes
                </button>
                <a href="?mod=order&act=detail&id=<?= $orderNumber ?>" class="btn btn-secondary">
                  <i class="fas fa-times"></i> Cancel
                </a>
                <a href="?mod=order&act=list" class="btn btn-primary">
                  <i class="fas fa-arrow-left"></i> Back to Orders
                </a>
              </div>
            </form>
            
          <?php else: ?>
            <div class="alert alert-warning">
              <h4 class="alert-heading">Order Not Found</h4>
              <p>Không tìm thây thông tin don hàng hoac có lôi xãy ra.</p>
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
