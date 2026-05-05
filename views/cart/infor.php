<?php 
    if(isset($_SESSION['cart']))
        $products = $_SESSION['cart'];
    else $products = null;

    // Tính tổng tiền
    $total_amount = 0;
    $total_items = 0;
    if (!empty($products)) {
        foreach ($products as $product) {
            $price = isset($product['buyPrice']) ? $product['buyPrice'] : 0;
            $quantity = isset($product['SoLuong']) ? $product['SoLuong'] : 1;
            $discount = isset($product['sales_percent']) ? $product['sales_percent'] : 0;
            
            $discounted_price = $price * (100 - $discount) / 100;
            $total_amount += $discounted_price * $quantity;
            $total_items += $quantity;
        }
    }

    // Lấy thông tin khách hàng
    $customer_info = $_SESSION['customer'] ?? [];
?>
<!doctype html>
<html class="no-js" lang="vi">
    <?php require_once('views/include/head.php') ?>
    <body>
        <!--[if lt IE 8]>
            <p class="browserupgrade">Bạn đang sử dụng trình duyệt <strong>lỗi thời</strong>. Vui lòng <a href="http://browsehappy.com/">nâng cấp trình duyệt</a> để có trải nghiệm tốt hơn.</p>
        <![endif]-->

        <!-- header section start -->
        <?php require_once('views/include/header.php') ?>
        <!-- header section end -->
        
        <!-- pages-title-start -->
        <div class="pages-title section-padding">
            <div class="container">
                <div class="row">
                    <div class="col-xs-12">
                        <div class="pages-title-text text-center">
                            <h2>Thông tin đặt hàng</h2>
                            <ul class="text-left">
                                <li><a href="?mod=page&act=home">Trang chủ</a></li>
                                <li><span> // </span>Thông tin đặt hàng</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- pages-title-end -->
        
        <!-- Begin Page Content -->
        <div class="container" style="margin: 3% auto;">
            <div class="row">
                <!-- Thông tin đơn hàng -->
                <div class="col-lg-8 mb-4">
                    <div class="card shadow">
                        <div class="card-header bg-primary text-white">
                            <h5 class="mb-0"><i class="fas fa-shopping-cart me-2"></i>Thông tin giao hàng</h5>
                        </div>
                        <div class="card-body p-4">
                            <?php if (empty($customer_info)): ?>
                                <!-- Form thông tin cho khách chưa đăng nhập -->
                                <form action="?mod=cart&act=order" method="POST" id="orderForm">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group mb-3">
                                                <label for="firstName" class="form-label">Tên <span class="text-danger">*</span></label>
                                                <input type="text" class="form-control" required id="firstName" 
                                                       name="firstName" placeholder="Nhập tên của bạn">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group mb-3">
                                                <label for="lastName" class="form-label">Họ <span class="text-danger">*</span></label>
                                                <input type="text" class="form-control" required id="lastName" 
                                                       name="lastName" placeholder="Nhập họ của bạn">
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="form-group mb-3">
                                        <label for="email" class="form-label">Địa chỉ email <span class="text-danger">*</span></label>
                                        <input type="email" class="form-control" required id="email" 
                                               name="email" placeholder="example@email.com">
                                        <div class="form-text">Chúng tôi sẽ gửi xác nhận đơn hàng qua email này.</div>
                                    </div>
                                    
                                    <div class="form-group mb-3">
                                        <label for="phone" class="form-label">Số điện thoại <span class="text-danger">*</span></label>
                                        <input type="tel" class="form-control" required id="phone" 
                                               name="phone" placeholder="Nhập số điện thoại của bạn"
                                               pattern="[0-9]{10,11}" title="Số điện thoại phải có 10-11 chữ số">
                                    </div>

                                    <div class="form-group mb-3">
                                        <label for="address" class="form-label">Địa chỉ giao hàng <span class="text-danger">*</span></label>
                                        <textarea class="form-control" required id="address" name="address" rows="2" 
                                                  placeholder="Số nhà, tên đường, phường/xã, quận/huyện, tỉnh/thành phố"></textarea>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group mb-3">
                                                <label for="city" class="form-label">Thành phố/Tỉnh <span class="text-danger">*</span></label>
                                                <input type="text" class="form-control" required id="city" 
                                                       name="city" placeholder="Nhập thành phố/tỉnh">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group mb-3">
                                                <label for="country" class="form-label">Quốc gia</label>
                                                <input type="text" class="form-control" id="country" 
                                                       name="country" value="Vietnam" readonly>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group mb-3">
                                        <label for="note" class="form-label">Ghi chú đơn hàng</label>
                                        <textarea class="form-control" id="note" name="note" rows="3" 
                                                  placeholder="Ghi chú thêm về đơn hàng (thời gian giao hàng, yêu cầu đặc biệt...)"></textarea>
                                    </div>

                                    <!-- Phương thức thanh toán -->
                                    <div class="form-group mb-3">
                                        <label class="form-label">Phương thức thanh toán <span class="text-danger">*</span></label>
                                        <div class="payment-methods">
                                            <div class="form-check mb-2">
                                                <input class="form-check-input" type="radio" name="payment_method" 
                                                       id="payment_cod" value="cod" checked>
                                                <label class="form-check-label d-flex align-items-center" for="payment_cod">
                                                    <i class="fas fa-money-bill-wave me-2 text-success"></i>
                                                    <div>
                                                        <strong>Thanh toán khi nhận hàng (COD)</strong>
                                                        <small class="d-block text-muted">Thanh toán bằng tiền mặt khi nhận sản phẩm</small>
                                                    </div>
                                                </label>
                                            </div>
                                            
                                            <div class="form-check mb-2">
                                                <input class="form-check-input" type="radio" name="payment_method" 
                                                       id="payment_bank" value="bank_transfer">
                                                <label class="form-check-label d-flex align-items-center" for="payment_bank">
                                                    <i class="fas fa-university me-2 text-primary"></i>
                                                    <div>
                                                        <strong>Chuyển khoản ngân hàng</strong>
                                                        <small class="d-block text-muted">Chuyển khoản qua Internet Banking hoặc quầy giao dịch</small>
                                                    </div>
                                                </label>
                                            </div>

                                            <div class="form-check mb-2">
                                                <input class="form-check-input" type="radio" name="payment_method" 
                                                       id="payment_vnpay" value="vnpay">
                                                <label class="form-check-label d-flex align-items-center" for="payment_vnpay">
                                                    <i class="fas fa-wallet me-2 text-danger"></i>
                                                    <div>
                                                        <strong>Ví điện tử VNPAY</strong>
                                                        <small class="d-block text-muted">Thanh toán nhanh qua ví điện tử VNPAY</small>
                                                    </div>
                                                </label>
                                            </div>

                                            <div class="form-check mb-2">
                                                <input class="form-check-input" type="radio" name="payment_method" 
                                                       id="payment_momo" value="momo">
                                                <label class="form-check-label d-flex align-items-center" for="payment_momo">
                                                    <i class="fas fa-mobile-alt me-2 text-info"></i>
                                                    <div>
                                                        <strong>Ví MoMo</strong>
                                                        <small class="d-block text-muted">Thanh toán qua ví điện tử MoMo</small>
                                                    </div>
                                                </label>
                                            </div>

                                            <div class="form-check mb-2">
                                                <input class="form-check-input" type="radio" name="payment_method" 
                                                       id="payment_zalopay" value="zalopay">
                                                <label class="form-check-label d-flex align-items-center" for="payment_zalopay">
                                                    <i class="fas fa-mobile-alt me-2 text-primary"></i>
                                                    <div>
                                                        <strong>ZaloPay</strong>
                                                        <small class="d-block text-muted">Thanh toán qua ví điện tử ZaloPay</small>
                                                    </div>
                                                </label>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Thông tin chuyển khoản (ẩn mặc định) -->
                                    <div id="bankTransferInfo" class="alert alert-info mb-3" style="display: none;">
                                        <h6><i class="fas fa-info-circle me-2"></i>Thông tin chuyển khoản:</h6>
                                        <p class="mb-1"><strong>Ngân hàng:</strong> Vietcombank</p>
                                        <p class="mb-1"><strong>Số tài khoản:</strong> 1234567890</p>
                                        <p class="mb-1"><strong>Chủ tài khoản:</strong> CÔNG TY TNHH SPORT SHOP</p>
                                        <p class="mb-0"><strong>Nội dung:</strong> DH + Mã đơn hàng (sẽ được hiển thị sau khi đặt hàng)</p>
                                    </div>

                                    <div class="form-check mb-3">
                                        <input class="form-check-input" type="checkbox" id="createAccount" name="createAccount">
                                        <label class="form-check-label" for="createAccount">
                                            Tạo tài khoản để mua hàng dễ dàng hơn
                                        </label>
                                    </div>

                                    <div id="passwordField" class="form-group mb-3" style="display: none;">
                                        <label for="password" class="form-label">Mật khẩu tài khoản</label>
                                        <input type="password" class="form-control" id="password" name="password" 
                                               placeholder="Nhập mật khẩu (ít nhất 6 ký tự)">
                                    </div>
                                </form>
                            <?php else: ?>
                                <!-- Form thông tin cho khách đã đăng nhập -->
                                <form action="?mod=cart&act=order" method="POST" id="orderForm">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group mb-3">
                                                <label for="firstName" class="form-label">Tên <span class="text-danger">*</span></label>
                                                <input type="text" class="form-control" required id="firstName" 
                                                       name="firstName" value="<?= htmlspecialchars($customer_info['contactFirstName'] ?? '') ?>">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group mb-3">
                                                <label for="lastName" class="form-label">Họ <span class="text-danger">*</span></label>
                                                <input type="text" class="form-control" required id="lastName" 
                                                       name="lastName" value="<?= htmlspecialchars($customer_info['contactLastName'] ?? '') ?>">
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="form-group mb-3">
                                        <label for="email" class="form-label">Địa chỉ email <span class="text-danger">*</span></label>
                                        <input type="email" class="form-control" required id="email" 
                                               name="email" value="<?= htmlspecialchars($customer_info['email'] ?? '') ?>" readonly>
                                    </div>
                                    
                                    <div class="form-group mb-3">
                                        <label for="phone" class="form-label">Số điện thoại <span class="text-danger">*</span></label>
                                        <input type="tel" class="form-control" required id="phone" 
                                               name="phone" value="<?= htmlspecialchars($customer_info['phone'] ?? '') ?>">
                                    </div>

                                    <div class="form-group mb-3">
                                        <label for="address" class="form-label">Địa chỉ giao hàng <span class="text-danger">*</span></label>
                                        <textarea class="form-control" required id="address" name="address" rows="2"><?= 
                                            htmlspecialchars($customer_info['addressLine1'] ?? '') ?></textarea>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group mb-3">
                                                <label for="city" class="form-label">Thành phố/Tỉnh <span class="text-danger">*</span></label>
                                                <input type="text" class="form-control" required id="city" 
                                                       name="city" value="<?= htmlspecialchars($customer_info['city'] ?? '') ?>">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group mb-3">
                                                <label for="country" class="form-label">Quốc gia</label>
                                                <input type="text" class="form-control" id="country" 
                                                       name="country" value="<?= htmlspecialchars($customer_info['country'] ?? 'Vietnam') ?>">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group mb-3">
                                        <label for="note" class="form-label">Ghi chú đơn hàng</label>
                                        <textarea class="form-control" id="note" name="note" rows="3" 
                                                  placeholder="Ghi chú thêm về đơn hàng (thời gian giao hàng, yêu cầu đặc biệt...)"></textarea>
                                    </div>

                                    <!-- Phương thức thanh toán -->
                                    <div class="form-group mb-3">
                                        <label class="form-label">Phương thức thanh toán <span class="text-danger">*</span></label>
                                        <div class="payment-methods">
                                            <div class="form-check mb-2">
                                                <input class="form-check-input" type="radio" name="payment_method" 
                                                       id="payment_cod_logged" value="cod" checked>
                                                <label class="form-check-label d-flex align-items-center" for="payment_cod_logged">
                                                    <i class="fas fa-money-bill-wave me-2 text-success"></i>
                                                    <div>
                                                        <strong>Thanh toán khi nhận hàng (COD)</strong>
                                                        <small class="d-block text-muted">Thanh toán bằng tiền mặt khi nhận sản phẩm</small>
                                                    </div>
                                                </label>
                                            </div>
                                            
                                            <div class="form-check mb-2">
                                                <input class="form-check-input" type="radio" name="payment_method" 
                                                       id="payment_bank_logged" value="bank_transfer">
                                                <label class="form-check-label d-flex align-items-center" for="payment_bank_logged">
                                                    <i class="fas fa-university me-2 text-primary"></i>
                                                    <div>
                                                        <strong>Chuyển khoản ngân hàng</strong>
                                                        <small class="d-block text-muted">Chuyển khoản qua Internet Banking hoặc quầy giao dịch</small>
                                                    </div>
                                                </label>
                                            </div>

                                            <div class="form-check mb-2">
                                                <input class="form-check-input" type="radio" name="payment_method" 
                                                       id="payment_vnpay_logged" value="vnpay">
                                                <label class="form-check-label d-flex align-items-center" for="payment_vnpay_logged">
                                                    <i class="fas fa-wallet me-2 text-danger"></i>
                                                    <div>
                                                        <strong>Ví điện tử VNPAY</strong>
                                                        <small class="d-block text-muted">Thanh toán nhanh qua ví điện tử VNPAY</small>
                                                    </div>
                                                </label>
                                            </div>

                                            <div class="form-check mb-2">
                                                <input class="form-check-input" type="radio" name="payment_method" 
                                                       id="payment_momo_logged" value="momo">
                                                <label class="form-check-label d-flex align-items-center" for="payment_momo_logged">
                                                    <i class="fas fa-mobile-alt me-2 text-info"></i>
                                                    <div>
                                                        <strong>Ví MoMo</strong>
                                                        <small class="d-block text-muted">Thanh toán qua ví điện tử MoMo</small>
                                                    </div>
                                                </label>
                                            </div>

                                            <div class="form-check mb-2">
                                                <input class="form-check-input" type="radio" name="payment_method" 
                                                       id="payment_zalopay_logged" value="zalopay">
                                                <label class="form-check-label d-flex align-items-center" for="payment_zalopay_logged">
                                                    <i class="fas fa-mobile-alt me-2 text-primary"></i>
                                                    <div>
                                                        <strong>ZaloPay</strong>
                                                        <small class="d-block text-muted">Thanh toán qua ví điện tử ZaloPay</small>
                                                    </div>
                                                </label>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Thông tin chuyển khoản (ẩn mặc định) -->
                                    <div id="bankTransferInfoLogged" class="alert alert-info mb-3" style="display: none;">
                                        <h6><i class="fas fa-info-circle me-2"></i>Thông tin chuyển khoản:</h6>
                                        <p class="mb-1"><strong>Ngân hàng:</strong> Vietcombank</p>
                                        <p class="mb-1"><strong>Số tài khoản:</strong> 1234567890</p>
                                        <p class="mb-1"><strong>Chủ tài khoản:</strong> CÔNG TY TNHH SPORT SHOP</p>
                                        <p class="mb-0"><strong>Nội dung:</strong> DH + Mã đơn hàng (sẽ được hiển thị sau khi đặt hàng)</p>
                                    </div>
                                </form>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>

                <!-- Tóm tắt đơn hàng -->
                <div class="col-lg-4">
                    <div class="card shadow sticky-top" style="top: 20px;">
                        <div class="card-header bg-success text-white">
                            <h5 class="mb-0"><i class="fas fa-receipt me-2"></i>Tóm tắt đơn hàng</h5>
                        </div>
                        <div class="card-body">
                            <?php if (!empty($products)): ?>
                                <div class="order-summary mb-3">
                                    <?php foreach ($products as $product): ?>
                                        <div class="d-flex align-items-center mb-3 pb-3 border-bottom">
                                            <div class="product-image me-3">
                                                <img src="<?= htmlspecialchars($product['image'] ?? 'public/img/default-product.jpg') ?>" 
                                                     alt="<?= htmlspecialchars($product['productName'] ?? '') ?>"
                                                     style="width: 60px; height: 60px; object-fit: cover; border-radius: 8px; border: 1px solid #e9ecef;"
                                                     onerror="console.log('Image error for: ' + this.src); this.src='public/img/default-product.jpg'">
                                            </div>
                                            <div class="product-details flex-grow-1">
                                                <h6 class="mb-1"><?= htmlspecialchars($product['productName'] ?? '') ?></h6>
                                                <small class="text-muted d-block mb-1">
                                                    Số lượng: <?= $product['SoLuong'] ?> x 
                                                    <?php 
                                                        $price = $product['buyPrice'] ?? 0;
                                                        $discount = $product['sales_percent'] ?? 0;
                                                        $final_price = $price * (100 - $discount) / 100;
                                                        echo number_format($final_price, 0, ',', '.') . 'đ';
                                                    ?>
                                                    <?php if ($discount > 0): ?>
                                                        <span class="badge bg-danger ms-1">-<?= $discount ?>%</span>
                                                    <?php endif; ?>
                                                </small>
                                                <?php if ($discount > 0): ?>
                                                    <small class="text-decoration-line-through text-muted">
                                                        <?= number_format($price, 0, ',', '.') ?>đ
                                                    </small>
                                                <?php endif; ?>
                                            </div>
                                            <div class="product-total text-end">
                                                <strong class="text-success">
                                                    <?php 
                                                        $item_total = $final_price * $product['SoLuong'];
                                                        echo number_format($item_total, 0, ',', '.') . 'đ';
                                                    ?>
                                                </strong>
                                            </div>
                                        </div>
                                    <?php endforeach; ?>
                                </div>

                                <div class="summary-details">
                                    <div class="d-flex justify-content-between mb-2">
                                        <span>Tạm tính:</span>
                                        <span><?= number_format($total_amount, 0, ',', '.') ?>đ</span>
                                    </div>
                                    <div class="d-flex justify-content-between mb-2">
                                        <span>Phí vận chuyển:</span>
                                        <span class="text-success">Miễn phí</span>
                                    </div>
                                    <div class="d-flex justify-content-between mb-2">
                                        <span>Giảm giá:</span>
                                        <span class="text-danger">0đ</span>
                                    </div>
                                    <hr>
                                    <div class="d-flex justify-content-between mb-3">
                                        <h5>Tổng cộng:</h5>
                                        <h5 class="text-success"><?= number_format($total_amount, 0, ',', '.') ?>đ</h5>
                                    </div>
                                </div>

                                <div class="alert alert-info mb-3">
                                    <i class="fas fa-truck me-2"></i>
                                    <small>Giao hàng dự kiến trong 3-5 ngày làm việc</small>
                                </div>

                                <div class="d-grid gap-2">
                                    <button type="submit" form="orderForm" class="btn btn-success btn-lg">
                                        <i class="fas fa-check me-2"></i>Xác nhận đặt hàng
                                    </button>
                                    <a href="?mod=cart&act=list" class="btn btn-outline-secondary">
                                        <i class="fas fa-arrow-left me-2"></i>Quay lại giỏ hàng
                                    </a>
                                </div>
                            <?php else: ?>
                                <div class="alert alert-warning">
                                    <i class="fas fa-exclamation-triangle me-2"></i>
                                    Giỏ hàng của bạn đang trống!
                                </div>
                                <div class="d-grid">
                                    <a href="?mod=page&act=home" class="btn btn-primary">
                                        <i class="fas fa-shopping-bag me-2"></i>Mua sắm ngay
                                    </a>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- /.container -->

        <!-- footer section start -->
        <?php require_once('views/include/footer.php') ?>        
        <!-- footer section end -->
        
        <!-- all js here -->
        <?php require_once('views/include/jquery.php') ?>
        
        <script>
        $(document).ready(function() {
            // Hiển/ẩn trường mật khẩu khi chọn tạo tài khoản
            $('#createAccount').change(function() {
                if ($(this).is(':checked')) {
                    $('#passwordField').slideDown();
                    $('#password').prop('required', true);
                } else {
                    $('#passwordField').slideUp();
                    $('#password').prop('required', false);
                }
            });

            // Xử lý hiển thị thông tin chuyển khoản cho khách chưa đăng nhập
            $('input[name="payment_method"]').change(function() {
                var paymentMethod = $(this).val();
                
                // Ẩn tất cả thông tin chuyển khoản
                $('#bankTransferInfo').hide();
                $('#bankTransferInfoLogged').hide();
                
                // Hiển thị thông tin chuyển khoản nếu chọn bank_transfer
                if (paymentMethod === 'bank_transfer') {
                    // Kiểm tra xem form nào đang được hiển thị
                    if ($('#bankTransferInfo').length > 0) {
                        $('#bankTransferInfo').slideDown();
                    } else if ($('#bankTransferInfoLogged').length > 0) {
                        $('#bankTransferInfoLogged').slideDown();
                    }
                }
            });

            // Xác thực form trước khi submit
            $('#orderForm').on('submit', function(e) {
                var phone = $('#phone').val();
                var phoneRegex = /^[0-9]{10,11}$/;
                
                if (!phoneRegex.test(phone)) {
                    e.preventDefault();
                    alert('Số điện thoại không hợp lệ! Vui lòng nhập số điện thoại có 10-11 chữ số.');
                    $('#phone').focus();
                    return false;
                }

                var password = $('#password').val();
                if ($('#createAccount').is(':checked') && password.length < 6) {
                    e.preventDefault();
                    alert('Mật khẩu phải có ít nhất 6 ký tự!');
                    $('#password').focus();
                    return false;
                }

                // Kiểm tra đã chọn phương thức thanh toán chưa
                var paymentMethod = $('input[name="payment_method"]:checked').val();
                if (!paymentMethod) {
                    e.preventDefault();
                    alert('Vui lòng chọn phương thức thanh toán!');
                    return false;
                }

                // Nếu chọn thanh toán online, hiển thị thông báo
                if (paymentMethod === 'vnpay' || paymentMethod === 'momo' || paymentMethod === 'zalopay') {
                    if (!confirm('Bạn sẽ được chuyển đến cổng thanh toán để hoàn tất đơn hàng. Tiếp tục?')) {
                        e.preventDefault();
                        return false;
                    }
                }
            });

            // Format số điện thoại khi nhập
            $('#phone').on('input', function() {
                $(this).val($(this).val().replace(/[^0-9]/g, ''));
            });

            // Hiệu ứng hover cho các phương thức thanh toán
            $('.payment-methods .form-check').hover(
                function() {
                    $(this).addClass('bg-light');
                },
                function() {
                    $(this).removeClass('bg-light');
                }
            );

            // Thêm CSS cho payment methods
            $('<style>')
                .prop('type', 'text/css')
                .html(`
                    /* General styling */
                    .pages-title {
                        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
                        color: white;
                        padding: 60px 0;
                        margin-bottom: 40px;
                    }
                    
                    /* Container spacing */
                    .container {
                        padding: 0 20px;
                        max-width: 1200px;
                    }
                    
                    /* Row spacing */
                    .row {
                        margin: 0 -15px;
                    }
                    
                    .row > div {
                        padding: 0 15px;
                        margin-bottom: 30px;
                    }
                    
                    .pages-title h2 {
                        font-weight: 700;
                        margin-bottom: 20px;
                        text-transform: uppercase;
                        letter-spacing: 2px;
                    }
                    
                    .pages-title ul {
                        background: rgba(255,255,255,0.1);
                        border-radius: 30px;
                        padding: 10px 20px;
                        display: inline-block;
                    }
                    
                    .pages-title ul li {
                        display: inline-block;
                        color: rgba(255,255,255,0.8);
                    }
                    
                    .pages-title ul li a {
                        color: white;
                        text-decoration: none;
                        transition: all 0.3s ease;
                    }
                    
                    .pages-title ul li a:hover {
                        color: #ffd700;
                    }
                    
                    /* Card styling */
                    .card {
                        border: none;
                        border-radius: 15px;
                        box-shadow: 0 10px 30px rgba(0,0,0,0.1);
                        transition: all 0.3s ease;
                        margin-bottom: 30px;
                        overflow: hidden;
                    }
                    
                    .card:hover {
                        transform: translateY(-5px);
                        box-shadow: 0 15px 40px rgba(0,0,0,0.15);
                    }
                    
                    .card-header {
                        border-radius: 15px 15px 0 0 !important;
                        border: none;
                        padding: 25px 20px;
                        font-weight: 600;
                        text-transform: uppercase;
                        letter-spacing: 1px;
                    }
                    
                    .card-body {
                        padding: 30px;
                    }
                    
                    /* Form styling */
                    .form-control {
                        border: 2px solid #e9ecef;
                        border-radius: 10px;
                        padding: 15px;
                        font-size: 14px;
                        transition: all 0.3s ease;
                        margin-bottom: 5px;
                    }
                    
                    .form-control:focus {
                        border-color: #667eea;
                        box-shadow: 0 0 0 0.2rem rgba(102, 126, 234, 0.25);
                        outline: none;
                    }
                    
                    .form-label {
                        font-weight: 600;
                        color: #495057;
                        margin-bottom: 12px;
                        text-transform: uppercase;
                        font-size: 12px;
                        letter-spacing: 0.5px;
                        display: block;
                    }
                    
                    .form-group {
                        margin-bottom: 25px;
                    }
                    
                    .form-text {
                        font-size: 11px;
                        color: #6c757d;
                        margin-top: 5px;
                        font-style: italic;
                    }
                    
                    /* Payment methods styling */
                    .payment-methods .form-check {
                        border: 2px solid #e9ecef;
                        border-radius: 12px;
                        padding: 15px;
                        margin-bottom: 12px;
                        transition: all 0.3s ease;
                        cursor: pointer;
                        background: white;
                        position: relative;
                        overflow: hidden;
                    }
                    
                    .payment-methods .form-check::before {
                        content: '';
                        position: absolute;
                        top: 0;
                        left: -100%;
                        width: 100%;
                        height: 100%;
                        background: linear-gradient(90deg, transparent, rgba(102, 126, 234, 0.1), transparent);
                        transition: left 0.5s ease;
                    }
                    
                    .payment-methods .form-check:hover::before {
                        left: 100%;
                    }
                    
                    .payment-methods .form-check:hover {
                        border-color: #667eea;
                        box-shadow: 0 5px 20px rgba(102, 126, 234, 0.2);
                        transform: translateY(-2px);
                    }
                    
                    .payment-methods .form-check-input:checked + .form-check-label {
                        color: #667eea;
                    }
                    
                    .payment-methods .form-check-input:checked ~ .form-check-label::before {
                        border-color: #667eea;
                        background-color: #667eea;
                    }
                    
                    .payment-methods .form-check-label {
                        cursor: pointer;
                        margin-left: 25px;
                    }
                    
                    .payment-methods .form-check-label i {
                        font-size: 20px;
                        width: 30px;
                        text-align: center;
                    }
                    
                    .payment-methods .form-check-label strong {
                        font-size: 14px;
                        font-weight: 600;
                    }
                    
                    .payment-methods .form-check-label small {
                        font-size: 11px;
                        line-height: 1.4;
                    }
                    
                    /* Bank transfer info styling */
                    #bankTransferInfo, #bankTransferInfoLogged {
                        border: 2px solid #667eea;
                        border-radius: 12px;
                        background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
                        animation: slideIn 0.5s ease;
                    }
                    
                    @keyframes slideIn {
                        from {
                            opacity: 0;
                            transform: translateY(-20px);
                        }
                        to {
                            opacity: 1;
                            transform: translateY(0);
                        }
                    }
                    
                    #bankTransferInfo h6, #bankTransferInfoLogged h6 {
                        color: #667eea;
                        font-weight: 700;
                        margin-bottom: 15px;
                    }
                    
                    #bankTransferInfo p, #bankTransferInfoLogged p {
                        margin-bottom: 8px;
                        color: #495057;
                    }
                    
                    /* Order summary styling */
                    .order-summary {
                        max-height: 400px;
                        overflow-y: auto;
                        padding-right: 10px;
                    }
                    
                    .order-summary::-webkit-scrollbar {
                        width: 6px;
                    }
                    
                    .order-summary::-webkit-scrollbar-track {
                        background: #f1f1f1;
                        border-radius: 10px;
                    }
                    
                    .order-summary::-webkit-scrollbar-thumb {
                        background: #667eea;
                        border-radius: 10px;
                    }
                    
                    .order-summary .border-bottom {
                        border-bottom: 1px solid #e9ecef !important;
                        padding-bottom: 15px !important;
                        margin-bottom: 15px !important;
                    }
                    
                    .order-summary h6 {
                        font-size: 13px;
                        font-weight: 600;
                        color: #495057;
                        margin-bottom: 5px;
                        line-height: 1.3;
                    }
                    
                    .order-summary small {
                        font-size: 11px;
                        line-height: 1.4;
                    }
                    
                    /* Product image styling */
                    .product-image img {
                        transition: all 0.3s ease;
                        cursor: pointer;
                        background: #f8f9fa;
                        display: block;
                        -webkit-font-smoothing: antialiased;
                        image-rendering: -webkit-optimize-contrast;
                        image-rendering: crisp-edges;
                    }
                    
                    .product-image img:hover {
                        transform: scale(1.05);
                        box-shadow: 0 5px 15px rgba(0,0,0,0.2);
                    }
                    
                    .product-image {
                        position: relative;
                        overflow: hidden;
                    }
                    
                    .product-image::before {
                        content: '';
                        position: absolute;
                        top: 0;
                        left: 0;
                        width: 100%;
                        height: 100%;
                        background: linear-gradient(45deg, #f0f0f0 25%, transparent 25%, transparent 50%, #f0f0f0 50%, #f0f0f0 75%, transparent 75%, transparent);
                        background-size: 10px 10px;
                        z-index: 1;
                    }
                    
                    .product-image img {
                        position: relative;
                        z-index: 2;
                    }
                    
                    .product-details {
                        min-width: 0; /* Prevent flex item from shrinking */
                    }
                    
                    .product-total strong {
                        font-size: 14px;
                        font-weight: 700;
                    }
                    
                    .text-decoration-line-through {
                        text-decoration: line-through;
                        opacity: 0.7;
                    }
                    
                    .badge {
                        font-size: 10px;
                        padding: 3px 8px;
                        border-radius: 6px;
                    }
                    
                    /* Summary details styling */
                    .summary-details {
                        background: #f8f9fa;
                        border-radius: 10px;
                        padding: 15px;
                        margin-bottom: 15px;
                    }
                    
                    .summary-details .d-flex {
                        font-size: 13px;
                        margin-bottom: 8px;
                    }
                    
                    .summary-details h5 {
                        font-size: 16px;
                        font-weight: 700;
                    }
                    
                    /* Button styling */
                    .btn {
                        border-radius: 10px;
                        padding: 15px 30px;
                        font-weight: 600;
                        text-transform: uppercase;
                        letter-spacing: 0.5px;
                        transition: all 0.3s ease;
                        border: none;
                        margin: 5px;
                    }
                    
                    .btn-success {
                        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
                        box-shadow: 0 5px 15px rgba(102, 126, 234, 0.3);
                    }
                    
                    .btn-success:hover {
                        transform: translateY(-2px);
                        box-shadow: 0 8px 25px rgba(102, 126, 234, 0.4);
                    }
                    
                    .btn-outline-secondary {
                        border: 2px solid #6c757d;
                        color: #6c757d;
                    }
                    
                    .btn-outline-secondary:hover {
                        background: #6c757d;
                        color: white;
                        transform: translateY(-2px);
                    }
                    
                    .btn-primary {
                        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
                        border: none;
                    }
                    
                    .btn-primary:hover {
                        transform: translateY(-2px);
                        box-shadow: 0 5px 15px rgba(102, 126, 234, 0.3);
                    }
                    
                    /* Alert styling */
                    .alert {
                        border: none;
                        border-radius: 10px;
                        padding: 20px;
                        margin-bottom: 20px;
                    }
                    
                    .alert-info {
                        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
                        color: white;
                    }
                    
                    .alert-warning {
                        background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
                        color: white;
                    }
                    
                    /* D-grid spacing */
                    .d-grid {
                        display: grid;
                        gap: 15px;
                    }
                    
                    /* Section spacing */
                    .mb-4 {
                        margin-bottom: 30px !important;
                    }
                    
                    .mb-3 {
                        margin-bottom: 25px !important;
                    }
                    
                    .mb-2 {
                        margin-bottom: 20px !important;
                    }
                    
                    .mb-1 {
                        margin-bottom: 15px !important;
                    }
                    
                    /* Main content spacing */
                    .container {
                        margin-top: 40px;
                        margin-bottom: 60px;
                    }
                    
                    /* Footer spacing */
                    footer {
                        margin-top: 80px;
                        padding-top: 40px;
                    }
                    
                    /* Sticky sidebar */
                    .sticky-top {
                        z-index: 100;
                    }
                    
                    /* Responsive adjustments */
                    @media (max-width: 768px) {
                        .pages-title {
                            padding: 40px 0;
                        }
                        
                        .card {
                            margin-bottom: 20px;
                        }
                        
                        .payment-methods .form-check {
                            padding: 12px;
                        }
                        
                        .payment-methods .form-check-label i {
                            font-size: 18px;
                        }
                        
                        .btn {
                            padding: 10px 20px;
                            font-size: 14px;
                        }
                    }
                    
                    /* Loading animation */
                    @keyframes pulse {
                        0% {
                            box-shadow: 0 0 0 0 rgba(102, 126, 234, 0.7);
                        }
                        70% {
                            box-shadow: 0 0 0 10px rgba(102, 126, 234, 0);
                        }
                        100% {
                            box-shadow: 0 0 0 0 rgba(102, 126, 234, 0);
                        }
                    }
                    
                    .btn-success:active {
                        animation: pulse 1s infinite;
                    }
                `)
                .appendTo('head');
        });
        </script>
    </body>
</html>