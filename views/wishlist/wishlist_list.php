<?php 
    if(isset($_SESSION['wishlist']))
        $products = $_SESSION['wishlist'];
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
                            <h2>Sản Phẩm Yêu Thích</h2>
                            <ul class="text-left">
                                <li><a href="?mod=page&act=home">Trang chủ</a></li>
                                <li><span> // </span>Sản phẩm yêu thích</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- pages-title-end -->
        
        <!-- wishlist content section start -->
        <section class="pages cart-page section-padding">
            <div class="container">
                <div class="row">
                    <div class="col-xs-12">
                        <div class="table-responsive padding60">
                            <?php if($products != null && count($products) > 0): ?>
                            <table class="wishlist-table text-center">
                                <thead>
                                    <tr>
                                        <th>Sản phẩm</th>
                                        <th>Đơn giá</th>
                                        <th>Khuyến mãi</th>
                                        <th>Giá sau giảm</th>
                                        <th>Thêm vào giỏ</th>
                                        <th>Xóa</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php 
                                        foreach ($products as $product) { 
                                            $sales_percent = isset($product['sales_percent']) ? $product['sales_percent'] : 0;
                                            $final_price = $product['buyPrice'] * (100 - $sales_percent) / 100;
                                    ?>
                                    <tr>
                                        <td class="td-img text-left">
                                            <a href="?mod=product&act=detail&id=<?= $product['productCode'] ?>" >
                                                <img src="<?= $product['image'] ?>" alt="<?= $product['productName'] ?>" />
                                            </a>
                                            <div class="items-dsc">
                                                <h5><a href="?mod=product&act=detail&id=<?= $product['productCode'] ?>"><?= $product['productName'] ?></a></h5>
                                            </div>
                                        </td>
                                        <td><?= number_format($product['buyPrice']) ?> VNĐ</td>
                                        <td>
                                            <?php if($sales_percent > 0): ?>
                                                <span class="badge badge-danger">-<?= $sales_percent ?>%</span>
                                            <?php else: ?>
                                                <span class="text-muted">Không</span>
                                            <?php endif; ?>
                                        </td>
                                        <td>
                                            <strong><?= number_format($final_price) ?> VNĐ</strong>
                                        </td>
                                        <td>
                                            <a href="?mod=cart&act=add&id=<?= $product['productCode'] ?>" 
                                               class="btn btn-success btn-sm">
                                                <i class="mdi mdi-cart"></i> Thêm
                                            </a>
                                        </td>
                                        <td>
                                            <a href="?mod=wishlist&act=delete&id=<?= $product['productCode'] ?>" 
                                               onclick="return confirm('Bạn chắc chắn muốn xóa sản phẩm này khỏi danh sách yêu thích?');">
                                                <i class="mdi mdi-close" title="Xóa sản phẩm"></i>
                                            </a>
                                        </td>
                                    </tr>
                                    <?php } ?>
                                </tbody>
                            </table>
                            <?php else: ?>
                            <div class="text-center padding60">
                                <h3>Danh sách yêu thích của bạn đang trống</h3>
                                <p>Hãy thêm sản phẩm bạn thích vào danh sách!</p>
                                <a href="?mod=page&act=home" class="btn btn-primary">Tiếp tục mua sắm</a>
                            </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
                <?php if($products != null && count($products) > 0): ?>
                <div class="row margin-top">
                    <div class="col-xs-12 text-center">
                        <a href="?mod=wishlist&act=delete&del=1" 
                           onclick="return confirm('Bạn chắc chắn muốn xóa tất cả sản phẩm yêu thích?');"
                           class="btn btn-danger">
                            <i class="mdi mdi-delete"></i> Xóa tất cả
                        </a>
                    </div>
                </div>
                <?php endif; ?>
            </div>
        </section>
        <!-- wishlist content section end -->
        
        <!-- footer section start -->
        <?php require_once('views/include/footer.php') ?>        
        <!-- footer section end -->
        
        <!-- all js here -->
        <?php require_once('views/include/jquery.php') ?>
    </body>
</html>
