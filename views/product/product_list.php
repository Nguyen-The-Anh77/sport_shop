<!doctype html>
<html class="no-js" lang="">
    <?php require_once('views/include/head.php') ?>
    <body>
        <!-- header section start -->
        <?php require_once('views/include/header.php') ?>
        <!-- header section end -->
        <!-- pages-title-start -->
        <div class="pages-title section-padding">
            <div class="container">
                <div class="row">
                    <div class="col-xs-12">
                        <div class="pages-title-text text-center">
                            <h2><?= htmlspecialchars($_GET['type'] ?? 'Sản phẩm') ?></h2>
                            <ul class="text-left">
                                <li><a href="?mod=page&act=home">Trang chủ</a></li>
                                <li><span> // </span><?= htmlspecialchars($_GET['type'] ?? 'Sản phẩm') ?></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- pages-title-end -->
        <!-- shop content section start -->
        <div class="pages products-page section-padding text-center">
            <div class="container">
                <div class="row">
                    <div class="col-xs-12">
                        <div class="right-products">
                            <div class="row">
                                <div class="col-xs-12">
                                    <div class="section-title clearfix">
                                        <ul>
                                            <li>
                                                <ul class="nav-view">
                                                    <li><a href="#"><i class="mdi mdi-view-module"></i></a></li>
                                                    <li><a href="#"><i class="mdi mdi-view-list"></i></a></li>
                                                </ul>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="grid-content">
                                    <?php
                                        $wishlist = $_SESSION['wishlist'] ?? [];
                                        foreach ($data as $product):
                                            $isFavorite = isset($wishlist[$product['productCode']]);
                                    ?>
                                    <div class="col-xs-12 col-sm-6 col-md-3">
                                        <div class="single-product">
                                            <div class="product-img">
                                                <!-- <?php if(isset($product['sales_percent']) && $product['sales_percent'] > 0): ?> -->
                                                <div class="pro-type">
                                                    <!-- <span>-<?= number_format($product['sales_percent']) ?>%</span> -->
                                                </div>
                                                <?php endif; ?>
                                                <a href="?mod=product&act=detail&id=<?= $product['productCode'] ?>">
                                                    <img src="<?= $product['image'] ?>" 
                                                         alt="<?= htmlspecialchars($product['productName']) ?>" 
                                                         class="img-responsive"
                                                         style="width: 100%; height: 340px; object-fit: cover;">
                                                </a>
                                                <div class="actions-btn">
                                                    <a href="?mod=cart&act=add&id=<?= $product['productCode'] ?>">
                                                        <i class="mdi mdi-cart"></i>
                                                    </a>
                                                    <a href="?mod=product&act=detail&id=<?= $product['productCode'] ?>">
                                                        <i class="mdi mdi-eye"></i>
                                                    </a>
                                                    <?php if ($isFavorite): ?>
                                                        <a href="?mod=wishlist&act=remove&id=<?= $product['productCode'] ?>&return=<?= urlencode($_SERVER['REQUEST_URI']) ?>" class="favorite-link is-favorite" title="Bỏ khỏi yêu thích">
                                                            <i class="mdi mdi-heart"></i>
                                                        </a>
                                                    <?php else: ?>
                                                        <a href="?mod=wishlist&act=add&id=<?= $product['productCode'] ?>&return=<?= urlencode($_SERVER['REQUEST_URI']) ?>" class="favorite-link" title="Thêm vào yêu thích">
                                                            <i class="mdi mdi-heart-outline"></i>
                                                        </a>
                                                    <?php endif; ?>
                                                </div>
                                            </div>
                                            <div class="product-dsc">
                                                <p>
                                                    <a href="?mod=product&act=detail&id=<?= $product['productCode'] ?>">
                                                        <?= htmlspecialchars($product['productName']) ?>
                                                    </a>
                                                </p>
                                                <div class="ratting">
                                                    <i class="mdi mdi-star"></i>
                                                    <i class="mdi mdi-star"></i>
                                                    <i class="mdi mdi-star"></i>
                                                    <i class="mdi mdi-star-half"></i>
                                                    <i class="mdi mdi-star-outline"></i>
                                                </div>
                                                <span class="price">
                                                    <!-- <?php if(isset($product['sales_percent']) && $product['sales_percent'] > 0): ?>
                                                        <span class="old-price"><?= number_format($product['buyPrice']) ?> VNĐ</span>
                                                        <span class="sale-price"><?= number_format($product['buyPrice'] * (100 - $product['sales_percent']) / 100) ?> VNĐ</span>
                                                    <?php else: ?>
                                                        <span class="regular-price"><?= number_format($product['buyPrice']) ?> VNĐ</span>
                                                    <?php endif; ?> -->
                                                       <span class="regular-price"><?= number_format($product['buyPrice']) ?> VNĐ</span>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                    <?php endforeach; ?>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="pagnation-ul">
                                        <ul class="pagination">
                                            <li><a href="#"><i class="mdi mdi-menu-left"></i></a></li>
                                            <li class="active"><a href="#">1</a></li>
                                            <li><a href="#">2</a></li>
                                            <li><a href="#">3</a></li>
                                            <li><a href="#">4</a></li>
                                            <li><a href="#">5</a></li>
                                            <li><a href="#">...</a></li>
                                            <li><a href="#">10</a></li>
                                            <li><a href="#"><i class="mdi mdi-menu-right"></i></a></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- shop content section end -->
        <?php require_once('views/include/quick_view.php') ?>     
        <!-- footer section start -->
        <?php require_once('views/include/footer.php') ?>        
        <!-- footer section end -->
        
        <!-- all js here -->
        <?php require_once('views/include/jquery.php') ?>
    </body>
</html>