<?php
    $favoriteProducts = $favoriteProducts ?? [];
?>
<!doctype html>
<html class="no-js" lang="vi">
    <?php require_once('views/include/head.php') ?>
    <body>
        <?php require_once('views/include/header.php') ?>

        <div class="pages-title section-padding">
            <div class="container">
                <div class="row">
                    <div class="col-xs-12">
                        <div class="pages-title-text text-center">
                            <h2>Yêu Thích</h2>
                            <ul class="text-left">
                                <li><a href="?mod=page&act=home">Trang chủ</a></li>
                                <li><span> // </span>Yêu thích</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <section class="pages wishlist-page section-padding">
            <div class="container">
                <div class="row">
                    <div class="col-xs-12">
                        <?php if (empty($favoriteProducts)): ?>
                            <div class="wishlist-empty text-center">
                                <div class="wishlist-empty-icon">
                                    <i class="mdi mdi-heart-outline"></i>
                                </div>
                                <h3>Bạn chưa có sản phẩm yêu thích nào</h3>
                                <p>Hãy thêm sản phẩm vào danh sách yêu thích để dễ quay lại sau.</p>
                                <div class="wishlist-actions">
                                    <a href="?mod=page&act=home" class="submit-text">Tiếp tục mua sắm</a>
                                </div>
                            </div>
                        <?php else: ?>
                            <div class="table-responsive padding60">
                                <table class="wishlist-table text-center">
                                    <thead>
                                        <tr>
                                            <th>Sản phẩm</th>
                                            <th>Đơn giá</th>
                                            <th>Thêm vào giỏ</th>
                                            <th>Xóa</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($favoriteProducts as $product): ?>
                                            <tr>
                                                <td class="td-img text-left">
                                                    <a href="?mod=product&act=detail&id=<?= htmlspecialchars($product['productCode']) ?>">
                                                        <img src="<?= htmlspecialchars($product['image']) ?>" alt="<?= htmlspecialchars($product['productName']) ?>" />
                                                    </a>
                                                    <div class="items-dsc">
                                                        <h5><a href="?mod=product&act=detail&id=<?= htmlspecialchars($product['productCode']) ?>"><?= htmlspecialchars($product['productName']) ?></a></h5>
                                                        <p class="itemcolor">Mã sản phẩm: <span><?= htmlspecialchars($product['productCode']) ?></span></p>
                                                    </div>
                                                </td>
                                                <td><?= number_format($product['buyPrice']) ?> VNĐ</td>
                                                <td>
                                                    <a href="?mod=cart&act=add&id=<?= htmlspecialchars($product['productCode']) ?>&return=<?= urlencode('?mod=wishlist&act=list') ?>" class="submit-text">Thêm vào giỏ</a>
                                                </td>
                                                <td>
                                                    <a href="?mod=wishlist&act=remove&id=<?= htmlspecialchars($product['productCode']) ?>&return=<?= urlencode('?mod=wishlist&act=list') ?>" onclick="return confirm('Bạn muốn bỏ sản phẩm này khỏi yêu thích?');">
                                                        <i class="mdi mdi-close" title="Bỏ khỏi yêu thích"></i>
                                                    </a>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </section>

        <?php require_once('views/include/footer.php') ?>
        <?php require_once('views/include/jquery.php') ?>
    </body>
</html>
