<!DOCTYPE html>
<html class="no-js" lang="">
    <?php 
    require_once('views/include/head.php');
    // Kiểm tra xem $data có tồn tại không, nếu không thì gán mảng rỗng
    if (!isset($data)) {
        $data = [];
    }
    ?>
    <body>
        <!--[if lt IE 8]>
            <p class="browserupgrade">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.</p>
        <![endif]-->

        <!-- header section start -->
		
        <!-- header section end -->
        <!-- quick view start -->
		
		<!-- pages-title-start -->
		<div class="pages-title section-padding">
			<div class="container">
				<div class="row">
					<div class="col-xs-12">
						<div class="pages-title-text text-center">
							<h2>Product Detail</h2>
							<ul class="text-left">
								<li><a href="?mod=page&act=home">Home </a></li>
								<li><span> // </span>Product Detail</li>
							</ul>
						</div>
					</div>
				</div>
			</div>
		</div>
		<!-- pages-title-end -->	
		<div class="row">
			<div class="col-xs-12 col-sm-5 col-md-4">
				<div class="quick-image">
					<div class="single-quick-image text-center">
						<div class="list-img">
							<div class="product-img tab-content">
								<div class="simpleLens-container tab-pane fade in" id="q-sin-1">
									<div class="pro-type">
										<span>new</span>
									</div>
									<a class="simpleLens-image" data-lens-image=<?= isset($data['image']) ? $data['image'] : '' ?> href="#"><img src=<?= isset($data['image']) ? $data['image'] : '' ?> alt="" class="simpleLens-big-image"></a>
								</div>
								<div class="simpleLens-container tab-pane active fade in" id="q-sin-2">
									<?php if(isset($data['sales_percent']) && $data['sales_percent'] > 0): ?>
									<div class="pro-type sell">
										<span>- <?= number_format($data['sales_percent']) ?>%</span>
									</div>
									<?php endif; ?>
									<a class="simpleLens-image" data-lens-image=<?= isset($data['image']) ? $data['image'] : '' ?> href="#"><img src=<?= isset($data['image']) ? $data['image'] : '' ?> alt="" alt="" width="240px" height="500px" class="simpleLens-big-image"></a>
								</div>
							</div>
						</div>
					</div>
					
				</div>						
			</div>
			<div class="col-xs-12 col-sm-7 col-md-8">
				<div class="quick-right">
					<div class="list-text">
						<h3><?= isset($data['productName']) ? $data['productName'] : 'Sản phẩm' ?></h3>
						<span>Sport men’s fashion</span>
						<div class="ratting floatright">
							<p>( <?= isset($data['views']) ? $data['views'] : 0 ?> Views )</p>
							<i class="mdi mdi-star"></i>
							<i class="mdi mdi-star"></i>
							<i class="mdi mdi-star"></i>
							<i class="mdi mdi-star-half"></i>
							<i class="mdi mdi-star-outline"></i>
						</div>
<h5><?php 
$price = isset($data['buyPrice']) ? $data['buyPrice'] : 0;
$salesPercent = isset($data['sales_percent']) ? $data['sales_percent'] : 0;
$discountedPrice = $price * (100 - $salesPercent) / 100;

if($salesPercent > 0) { 
    ?><del><?= number_format($price) ?> VND</del> <?php 
} 
?>
<?= number_format($discountedPrice) ?> VND</h5>
						<p style="font-size: 18px"><?= isset($data['productDescription']) ? $data['productDescription'] : '' ?></p>
						<div class="all-choose">
							<div class="s-shoose">
								<h5>Color</h5>
								<div class="color-select clearfix">
									<span></span>
									<span class="outline"></span>
									<span></span>
									<span></span>
								</div>
							</div>
							<div class="s-shoose">
								<h5>size</h5>
								<div class="size-drop">
									<div class="btn-group">
										<button type="button" class="btn">XL</button>
										<button type="button" class="btn dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
											<span class=""><i class="mdi mdi-chevron-down"></i></span>
										</button>
										<ul class="dropdown-menu">
											<li><a href="#">Xl</a></li>
											<li><a href="#">SL</a></li>
											<li><a href="#">S</a></li>
											<li><a href="#">L</a></li>
										</ul>
									</div>
								</div>
							</div>
							<div>
								<h5>quantity:  <?= isset($data['quantityInStock']) ? $data['quantityInStock'] : 0 ?></h5>
							</div>
						</div>
						<div class="list-btn">
							<a href="?mod=cart&act=add&id=<?= isset($data['productCode']) ? $data['productCode'] : '' ?>">add to cart</a>
						</div>
						<div class="share-tag clearfix">
							<ul class="blog-share floatleft">
								<li><h5>share </h5></li>
								<li><a href="#"><i class="mdi mdi-facebook"></i></a></li>
								<li><a href="#"><i class="mdi mdi-twitter"></i></a></li>
								<li><a href="#"><i class="mdi mdi-linkedin"></i></a></li>
								<li><a href="#"><i class="mdi mdi-vimeo"></i></a></li>
								<li><a href="#"><i class="mdi mdi-dribbble"></i></a></li>
								<li><a href="#"><i class="mdi mdi-instagram"></i></a></li>
							</ul>
						</div>
					</div>
				</div>
			</div>
		</div>

		<!-- quick view end -->
        <!-- footer section start -->
		     
		<!-- footer section end -->
        
		<!-- all js here -->
		<!-- jquery latest version -->
        <?php require_once('views/include/jquery.php') ?>
    </body>
</html>
