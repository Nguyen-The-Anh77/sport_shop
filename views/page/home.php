<!DOCTYPE html>
<html class="no-js" lang="">
    <?php require_once('views/include/head.php') ?>
    <body onload="return <?php if(isset($_COOKIE['msg'])){ ?>
			            alert('<?= $_COOKIE['msg'] ?>')
			          <?php }?>">

        <!-- header section start -->
		<?php require_once('views/include/header.php') ?>
        <!-- header section end -->
        
        <!-- slider-section-start -->
		<?php if(!empty($data_slider)): ?>
		<div id="mainSlider" class="slider-container">
			<div class="slider-wrapper">
				<?php foreach($data_slider as $slider): ?>
				<div class="slider-item">
					<?php if($slider['link']): ?>
					<a href="<?php echo $slider['link']; ?>">
					<?php endif; ?>
					<img src="<?php echo $slider['image']; ?>" alt="<?php echo $slider['title']; ?>">
					<div class="slider-caption">
						<h2><?php echo $slider['title']; ?></h2>
						<?php if($slider['description']): ?>
						<p><?php echo $slider['description']; ?></p>
						<?php endif; ?>
					</div>
					<?php if($slider['link']): ?>
					</a>
					<?php endif; ?>
				</div>
				<?php endforeach; ?>
			</div>
			<div class="slider-dots">
				<?php foreach($data_slider as $key => $slider): ?>
				<span class="dot <?php echo $key == 0 ? 'active' : ''; ?>" data-index="<?php echo $key; ?>"></span>
				<?php endforeach; ?>
			</div>
			<button class="slider-prev">&#10094;</button>
			<button class="slider-next">&#10095;</button>
		</div>
		<?php endif; ?>
		<!-- slider section end -->
        <!-- featured-products section start -->
		<section class="pages products-page section-padding text-center extra-padding-bottom">
			<div class="container">
				<div class="row">
					<div class="col-xs-12">
						<div class="section-title text-center">
							<h2>Sản phẩm nổi bật</h2>
						</div>
					</div>
				</div>
				<div class="wrapper">
					<ul class="load-list load-list-one">
						<li>
							<div class="row text-center">
								<div class="grid-content">
								<?php foreach ($data_hot as $value) { ?>
									<div class="col-xs-12 col-sm-6 col-md-3">
										<div class="single-product">
											<div class="product-img">
												<div class="pro-type">
													 
												</div>
												<a href="#"><img src=<?= $value['image'] ?> alt="Product Title" width="270px" height="340px"/></a>
												<div class="actions-btn">
													<a href="javascript:void(0)" onclick="addToCart('<?= $value['productCode'] ?>', this)" class="add-to-cart-btn"><i class="mdi mdi-cart"></i></a>
													<a href="?mod=product&act=detail&id=<?= $value['productCode'] ?>&views=<?= $value['views'] ?>" data-toggle="modal" data-target="#quick-view"><i class="mdi mdi-eye"></i></a>
													<a href="javascript:void(0)" onclick="addToWishlist('<?= $value['productCode'] ?>', this)" class="add-to-wishlist-btn"><i class="mdi mdi-heart"></i></a>
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
							<!-- <div class="row text-center">
								<div class="col-xs-12">
									<div class="section-title text-center">
										<h2>Sản phẩm khuyến mãi</h2>
									</div>
								</div>
							</div> -->
							<!-- <div class="row text-center">
								<div class="grid-content">
								<?php foreach ($data_hots as $value) { ?>
									<div class="col-xs-12 col-sm-6 col-md-3">
										<div class="single-product">
											<div class="product-img">
												<div class="pro-type">
													<span>-<?= number_format($value['sales_percent']) ?>%</span>
												</div>
                                                <a href="#"><img src=<?= $value['image'] ?> alt="Product Title" width="270px" height="340px"/></a>
												<div class="actions-btn">
													<a href="javascript:void(0)" onclick="addToCart('<?= $value['productCode'] ?>', this)" class="add-to-cart-btn"><i class="mdi mdi-cart"></i></a>
													<a href="?mod=product&act=detail&id=<?= $value['productCode'] ?>&views=<?= $value['views'] ?>" data-toggle="modal" data-target="#quick-view"><i class="mdi mdi-eye"></i></a>
													<a href="javascript:void(0)" onclick="addToWishlist('<?= $value['productCode'] ?>', this)" class="add-to-wishlist-btn"><i class="mdi mdi-heart"></i></a>
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
								 
							</div> -->
						</li>
					</ul>
					<button id="load-more-one">Load More</button>
				</div>
			</div>
		</section>
		<!-- featured-products section end -->
        <!-- tab-products section start -->
		<div class="tab-products pages products-page section-padding extra-padding-top text-center">
			<div class="container">
				<div class="row">
					<div class="col-xs-12">
						<div class="section-title text-center">
							<div class="product-tab nav nav-tabs">
								<ul>
									<li class="active"><a href="?mod=product&line=1&type=Soccer">Soccer<span>/</span></a></li>
									<li><a href="?mod=product&line=2&type=Basketball">Basketball<span>/</span></a></li>
									<li><a href="?mod=product&line=3&type=Badminton">Badminton<span>/</span></a></li>
									<li><a href="?mod=product&line=4&type=Volleyball">Volleyball</a></li>
								</ul>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<!-- tab-products section end -->
        <!-- service section start -->
		<section class="service-area section-padding">
			<div class="container">
				<div class="row">
					<div class="col-xs-12">
						<div class="section-title text-center">
							<h2>Our Service</h2>
						</div>
					</div>
				</div>
				<div class="row text-center">
					<div class="col-sm-4">
						<div class="service-text">
							<i class="mdi mdi-truck"></i>
							<h4>home delivery</h4>
							<p>We ship your orders to your home<br /> in three days.</p>
						</div>
					</div>
					<div class="col-sm-4">
						<div class="service-text">
							<i class="mdi mdi-lock"></i>
							<h4>PAYMENT SECURED</h4>
							<p>All of your payments is secured<br /> You can feel free to use.</p>
						</div>
					</div>
					<div class="col-sm-4">
						<div class="service-text">
                            <i class="mdi mdi-rotate-left"></i>
							<h4>30 days money back</h4>
							<p>Youn can be received your money back<br /> if products is not available to you</p>
						</div>
					</div>
				</div>
			</div>
		</section>
		<!-- service section end -->
        <?php require_once('views/include/quick_view.php') ?> 
        <!-- footer section start -->
		<?php require_once('views/include/footer.php') ?>
        <!-- footer section end -->
        
		<!-- all js here -->
		<!-- jquery latest version -->
        <?php require_once('views/include/jquery.php') ?>
    </body>
</html>