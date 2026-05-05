<?php 
    if(isset($_SESSION['cart']))
        $products = $_SESSION['cart'];
    else $products = null;
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
                            <h2>Giỏ Hàng</h2>
                            <ul class="text-left">
                                <li><a href="?mod=page&act=home">Trang chủ</a></li>
                                <li><span> // </span>Giỏ hàng</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- pages-title-end -->
        
        <!-- cart content section start -->
        <section class="pages cart-page section-padding">
            <div class="container">
                <div class="row">
                    <div class="col-xs-12">
                        <div class="table-responsive padding60">
                            <table class="wishlist-table text-center">
                                <thead>
                                    <tr>
                                        <th>Sản phẩm</th>
                                        <th>Đơn giá</th>
                                        <th>Số lượng</th>
                                        <th>Thành tiền</th>
                                        <th>Xóa</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php 
                                        $sum_amount = 0;
                                        if($products != null)
                                        foreach ($products as $product) { 
                                            $sales_percent = isset($product['sales_percent']) ? $product['sales_percent'] : 0;
                                            $sum_amount += (($product['buyPrice']*(100 - $sales_percent)/100)*$product['SoLuong']);
                                    ?>
                                    <tr>
                                        <td class="td-img text-left">
                                            <a href="?mod=product&act=detail&id=<?= $product['productCode'] ?>" >
                                                <img src="<?= $product['image'] ?>" alt="<?= $product['productName'] ?>" />
                                            </a>
                                            <div class="items-dsc">
                                                <h5><a href="?mod=product&act=detail&id=<?= $product['productCode'] ?>"><?= $product['productName'] ?></a></h5>
                                                <p class="itemcolor">Màu sắc: <span>Xanh dương</span></p>
                                                <p class="itemcolor">Kích thước: <span>Vừa</span></p>
                                            </div>
                                        </td>
                                        <td><?= number_format(($product['buyPrice']*(100 - $sales_percent)/100)) ?> VNĐ</td>
                                        <td>
                                            <form action="#" method="POST">
                                                <div class="plus-minus">
                                                    <a href="?mod=cart&act=add&id=<?= $product['productCode'] ?>" class="inc qtybutton">+</a>
                                                    <input type="text" value="<?= $product['SoLuong'] ?>" name="qtybutton" class="plus-minus-box">
                                                    <a href="?mod=cart&act=delete&id=<?= $product['productCode'] ?>" class="dec qtybutton">-</a>
                                                </div>
                                            </form>
                                        </td>
                                        <td>
                                            <strong><?= number_format(($product['buyPrice']*(100 - $sales_percent)/100)*$product['SoLuong']) ?> VNĐ</strong>
                                        </td>
                                        <td>
                                            <a href="?mod=cart&act=delete&del=2&id=<?= $product['productCode'] ?>" 
                                               onclick="return confirm('Bạn chắc chắn muốn xóa sản phẩm này?');">
                                                <i class="mdi mdi-close" title="Xóa sản phẩm"></i>
                                            </a>
                                        </td>
                                    </tr>
                                    <?php } ?>
                                    <?php if(isset($_SESSION['cart'])) { ?>
                                    <tfoot>
                                        <tr>
                                            <td colspan="3" align="left"><h4>Tổng tiền</h4></td>
                                            <td align="center"><h4><?= number_format($sum_amount) ?></h4> VNĐ</td>
                                            <td align="center">
                                                <a href="?mod=cart&act=mail" class="btn btn-success">Đặt hàng</a>
                                            </td>
                                        </tr>
                                    </tfoot>
                                    <?php $_SESSION['sum'] = $sum_amount; } ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="row margin-top">
                    <div class="col-sm-6">
                        <div class="single-cart-form padding60">
                            <div class="log-title">
                                <h3><strong>Mã giảm giá</strong></h3>
                            </div>
                            <div class="cart-form-text custom-input">
                                <p>Nhập mã giảm giá (nếu có)!</p>
                                <form action="mail.php" method="post">
                                    <input type="text" name="coupon_code" placeholder="Nhập mã giảm giá" />
                                    <div class="submit-text coupon">
                                        <button type="submit">Áp dụng</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="single-cart-form padding60">
                            <div class="log-title">
                                <h3><strong>Chi tiết thanh toán</strong></h3>
                            </div>
                            <div class="cart-form-text pay-details table-responsive">
                                <table>
                                    <tbody>
                                        <tr>
                                            <th>Tạm tính</th>
                                            <td><?= number_format($sum_amount) ?> VNĐ</td>
                                        </tr>
                                        <tr>
                                            <th>Phí vận chuyển</th>
                                            <td>30,000 VNĐ</td>
                                        </tr>
                                        <tr>
                                            <th>Thuế VAT (5%)</th>
                                            <td><?= number_format($sum_amount*0.05) ?> VNĐ</td>
                                        </tr>
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <th class="tfoot-padd">Tổng cộng</th>
                                            <td class="tfoot-padd"><?= number_format($sum_amount*1.05 + 30000) ?> VNĐ</td>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- cart content section end -->
        
        <!-- footer section start -->
        <?php require_once('views/include/footer.php') ?>        
        <!-- footer section end -->
        
        <!-- all js here -->
        <?php require_once('views/include/jquery.php') ?>
    </body>
</html>