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
							<h2>Tài khoản của tôi</h2>
							<ul class="text-left">
								<li><a href="?mod=page&act=home">Trang chủ </a></li>
								<li><span> // </span>Tài khoản của tôi</li>
							</ul>
						</div>
					</div>
				</div>
			</div>
		</div>
		<!-- pages-title-end -->
		<!-- My account content section start -->
		<section class="pages my-account-page section-padding">
			<div class="container">
				<div class="row">
				    <div class="col-xs-12 col-sm-2"></div>
					<div class="col-xs-12 col-sm-8">
						<div class="padding60">
							<div class="log-title" align="center">
								<h3><strong>Thông tin tài khoản</strong></h3>
							</div>
							<div class="prament-area main-input">
								<ul class="panel-group" id="accordion">
									<li class="panel">
										<div id="collapse1" class="panel-collapse collapse in">
											<div class="single-log-info">
												<div class="custom-input">
													<form action="?mod=login&act=edit" method="post" style="color: black">
														<div class="row">
															<div class="col-md-6" >
																<label>Tên:</label>
																<input style="color: black" type="text" name="firstName" value="<?php if(isset($_SESSION['customer']['contactFirstName'])) echo $_SESSION['customer']['contactFirstName']; 
											else if(isset($_SESSION['admin']['name'])) echo $_SESSION['admin']['firstName'];?>" />
															</div>
															<div class="col-md-6">
															<label>Họ:</label>
																<input style="color: black" type="text" name="lastName" value="<?php if(isset($_SESSION['customer']['contactLastName'])) echo $_SESSION['customer']['contactLastName']; 
											else if(isset($_SESSION['admin']['name'])) echo $_SESSION['admin']['lastName'];?>" />
															</div>
														</div>
															<label>Email:</label>
															<input style="color: black" type="email" name="email" value="<?php if(isset($_SESSION['customer']['email'])) echo $_SESSION['customer']['email']; ?>"/>
													<label>Điện thoại:</label>
															<input style="color: black" type="text" name="phone" value="<?php if(isset($_SESSION['customer']['phone'])) echo $_SESSION['customer']['phone']; ?>"/>
													<label>Địa chỉ:</label>
															<input style="color: black" type="text" name="address" value="<?php if(isset($_SESSION['customer']['addressLine1'])) echo $_SESSION['customer']['addressLine1'] ?> "/>
													<label>Thành phố:</label>
															<input style="color: black" type="text" name="city" value="<?php if(isset($_SESSION['customer']['city'])) echo $_SESSION['customer']['city'] ?> "/>
													<label>Quốc gia:</label>
															<input style="color: black" type="text" name="country" value="<?php if(isset($_SESSION['customer']['country'])) echo $_SESSION['customer']['country'] ?> "/>
														<button type="submit" class="btn btn-primary">Lưu</button>
													</form>
												</div>
											</div>
										</div>
									</li>
								</ul>
							</div>
						</div>
					</div>
				</div>
			</div>
		</section>
		<!-- my account content section end -->
        <!-- footer section start -->
		<?php require_once('views/include/footer.php') ?>        
		<!-- footer section end -->
        
		<!-- all js here -->
		<!-- jquery latest version -->
        <?php require_once('views/include/jquery.php') ?>    
    </body>
</html>
