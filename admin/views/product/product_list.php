<!DOCTYPE html>
<html lang="en">
<?php require_once('public/require/head.php') ?>
<body id="page-top">
  <div id="wrapper">
    <?php require_once('public/require/sidebar.php') ?>
    <div id="content-wrapper" class="d-flex flex-column">
      <div id="content">
        <?php require_once('public/require/header.php') ?>
        <div class="container-fluid">
          <h2 class="text-center my-4">Danh sách sản phẩm</h2>
          <a href="?mod=product&act=add" class="btn btn-primary mb-3">Thêm sản phẩm</a>
          
          <?php if(isset($_COOKIE['msg'])): ?>
            <div class="alert alert-success"><?= htmlspecialchars($_COOKIE['msg']) ?></div>
          <?php endif; ?>

          <div class="card shadow">
            <div class="card-body">
              <div class="table-responsive">
                <table class="table table-bordered" id="dataTable">
                  <thead class="bg-light">
                    <tr>
                      <th>Danh mục</th>
                      <th>Tên SP</th>
                      <th>Giá</th>
                      <th>Số lượng</th>
                      <th>Hình ảnh</th>
                      <th>Thao tác</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php if(!empty($products)): ?>
                      <?php foreach($products as $p): ?>
                        <tr>
                          <td><?= $p['productLine'] ?? 'N/A' ?></td>
                          <td><?= htmlspecialchars($p['productName'] ?? '') ?></td>
                          <td><?= isset($p['buyPrice']) ? number_format($p['buyPrice']).' VND' : 'N/A' ?></td>
                          <td><?= $p['quantityInStock'] ?? 0 ?></td>
                          <td>
                            <img src="<?= htmlspecialchars($p['image'] ?? '') ?>" 
                                 width="80" height="80" 
                                 style="object-fit: cover;" 
                                 onerror="this.src='path/to/default-image.jpg'">
                          </td>
                          <td>
                            <a href="../?mod=product&act=detail&id=<?= $p['productCode'] ?>" 
                               class="btn btn-sm btn-success">Xem</a>
                            <a href="?mod=product&act=update&id=<?= $p['productCode'] ?>" 
                               class="btn btn-sm btn-warning">Sửa</a>
                            <a href="?mod=product&act=delete&id=<?= $p['productCode'] ?>" 
                               onclick="return confirm('Xác nhận xóa?')" 
                               class="btn btn-sm btn-danger">Xóa</a>
                          </td>
                        </tr>
                      <?php endforeach; ?>
                    <?php else: ?>
                      <tr><td colspan="6" class="text-center">Không có sản phẩm nào</td></tr>
                    <?php endif; ?>
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>
      </div>
      <?php require_once('public/require/footer.php') ?>
    </div>
  </div>
  <?php require_once('public/require/logout_modal.php') ?>
  <?php require_once('public/require/js.php') ?>
</body>
</html>