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
							<h2>Search Results</h2>
							<ul class="text-left">
								<li><a href="index.php">Home </a></li>
								<li><span> // </span>Search Results</li>
							</ul>
						</div>
					</div>
				</div>
			</div>
		</div>
		<!-- pages-title-end -->
		<section class="pages products-page section-padding text-center extra-padding-bottom">
			<div class="container">
				<div class="row">
					<div class="col-xs-12">
						<div class="section-title text-center">
							<h2>Products</h2>
						</div>
					</div>
				</div>
				<div class="wrapper">
					<ul class="load-list load-list-one">
						<li>
							<div class="row text-center">
								<div class="grid-content">
								<?php
						$wishlist = $_SESSION['wishlist'] ?? [];
						foreach ($data_search as $value) {
							$isFavorite = isset($wishlist[$value['productCode']]);
						?>
									<div class="col-xs-12 col-sm-6 col-md-3">
										<div class="single-product">
											<div class="product-img">
												<div class="pro-type">
													 
												</div>
												<a href="#"><img src=<?= $value['image'] ?> alt="Product Title" width="270px" height="340px"/></a>
												<div class="actions-btn">
													<a href="?mod=cart&act=add&id=<?= $value['productCode'] ?>"><i class="mdi mdi-cart"></i></a>
													<a href="?mod=product&act=detail&id=<?= $value['productCode'] ?>" data-toggle="modal" data-target="#quick-view"><i class="mdi mdi-eye"></i></a>
													<?php if ($isFavorite): ?>
<a href="?mod=wishlist&act=remove&id=<?= $value['productCode'] ?>&return=<?= urlencode($_SERVER['REQUEST_URI']) ?>" class="favorite-link is-favorite" title="B? kh?i y?u th?ch">
<i class="mdi mdi-heart"></i>
</a>
<?php else: ?>
<a href="?mod=wishlist&act=add&id=<?= $value['productCode'] ?>&return=<?= urlencode($_SERVER['REQUEST_URI']) ?>" class="favorite-link" title="Th?m v?o y?u th?ch">
<i class="mdi mdi-heart-outline"></i>
</a>
<?php endif; ?>
												</div>
											</div>
											<div class="product-dsc">
												<p><a href="?mod=product&act=detail&id=<?= $value['productCode'] ?>"><?= $value['productName'] ?></a></p>
												<div class="ratting">
													<i class="mdi mdi-star"></i>
													<i class="mdi mdi-star"></i>
													<i class="mdi mdi-star"></i>
													<i class="mdi mdi-star-half"></i>
													<i class="mdi mdi-star-outline"></i>
												</div>
												<span><?= number_format($value['buyPrice']*(100 - $value['sales_percent'])/100)?> VND</span>
											</div>
										</div>
									</div>
								    <?php } ?>
									<!-- single product end -->
							</div>
						</li>
						<li>
							<div class="row text-center">
								<div class="grid-content">
								<?php
						$wishlist = $_SESSION['wishlist'] ?? [];
						foreach ($data_searchs as $value) {
							$isFavorite = isset($wishlist[$value['productCode']]);
						?>
									<div class="col-xs-12 col-sm-6 col-md-3">
										<div class="single-product">
											<div class="product-img">
												<div class="pro-type">
													<span>-<?= number_format($value['sales_percent']) ?>%</span>
												</div>
												<a href="#"><img src=<?= $value['image'] ?> alt="Product Title" width="270px" height="340px"/></a>
												<div class="actions-btn">
													<a href="?mod=cart&act=add&id=<?= $value['productCode'] ?>"><i class="mdi mdi-cart"></i></a>
													<a href="?mod=product&act=detail&id=<?= $value['productCode'] ?>" data-toggle="modal" data-target="#quick-view"><i class="mdi mdi-eye"></i></a>
													<?php if ($isFavorite): ?>
<a href="?mod=wishlist&act=remove&id=<?= $value['productCode'] ?>&return=<?= urlencode($_SERVER['REQUEST_URI']) ?>" class="favorite-link is-favorite" title="B? kh?i y?u th?ch">
<i class="mdi mdi-heart"></i>
</a>
<?php else: ?>
<a href="?mod=wishlist&act=add&id=<?= $value['productCode'] ?>&return=<?= urlencode($_SERVER['REQUEST_URI']) ?>" class="favorite-link" title="Th?m v?o y?u th?ch">
<i class="mdi mdi-heart-outline"></i>
</a>
<?php endif; ?>
												</div>
											</div>
											<div class="product-dsc">
												<p><a href="?mod=product&act=detail&id=<?= $value['productCode'] ?>"><?= $value['productName'] ?></a></p>
												<div class="ratting">
													<i class="mdi mdi-star"></i>
													<i class="mdi mdi-star"></i>
													<i class="mdi mdi-star"></i>
													<i class="mdi mdi-star-half"></i>
													<i class="mdi mdi-star-outline"></i>
												</div>
												<span><?= number_format($value['buyPrice']*(100 - $value['sales_percent'])/100)?> VND</span>
											</div>
										</div>
									</div>
									<?php } ?>
								</div>
								<!-- single product end -->
							</div>
						</li>
					</ul>
					<button id="load-more-one">Load More</button>
				</div>
			</div>
		</section>
		<!-- featured-products section end -->
        
        <?php require_once('views/include/quick_view.php') ?> 
        <!-- footer section start -->
		<?php require_once('views/include/footer.php') ?>
        <!-- footer section end -->
        
		<!-- all js here -->
		<!-- jquery latest version -->
        <?php require_once('views/include/jquery.php') ?>
    </body>
</html>
