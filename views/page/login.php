<!doctype html>
<html class="no-js" lang="vi">
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
							<h2>Đăng nhập hoặc Đăng ký</h2>
							<ul class="text-left">
								<li><a href="?mod=page&act=home">Trang chủ</a></li>
								<li><span> // </span>Đăng ký</li>
							</ul>
						</div>
					</div>
				</div>
			</div>
		</div>
		<!-- pages-title-end -->
		<!-- login content section start -->
		<section class="pages login-page section-padding"> 
			<div class="container">
				<div class="row">
					<div class="col-sm-6">
						<div class="main-input padding60">
							<div class="log-title">
								<h3><strong>khách hàng đã đăng ký</strong></h3>
							</div>
							<div class="login-text">
								<?php 
								// Chỉ hiển thị thông báo lỗi login, không hiển thị lỗi đăng ký
								if(isset($_COOKIE['msg']) && strpos($_COOKIE['msg'], 'Email đã được đăng ký') === false && strpos($_COOKIE['msg'], 'Số điện thoại đã được đăng ký') === false && strpos($_COOKIE['msg'], 'Vui lòng kiểm tra lại thông tin') === false && strpos($_COOKIE['msg'], 'Vui lòng nhập') === false && strpos($_COOKIE['msg'], 'Email không hợp lệ') === false && strpos($_COOKIE['msg'], 'Mật khẩu phải có ít nhất') === false && strpos($_COOKIE['msg'], 'Số điện thoại phải là số') === false && strpos($_COOKIE['msg'], 'Email và số điện thoại không được trùng nhau') === false) { ?>
					                <div class="alert alert-danger">
					                    <strong>Thất bại! </strong><?= $_COOKIE['msg'] ?>
					                </div>
					            <?php }?>
								<div class="custom-input">
									<p>Nếu bạn đã có tài khoản, vui lòng đăng nhập!</p>
									<form action="?mod=login&act=login_action" method="POST">
										<input type="email" required name="email" placeholder="Email" />
										<input type="password" required name="password" placeholder="Mật khẩu" />
										<a class="forget" href="#">Quên mật khẩu?</a>
										<div>
										    <button type="submit" class="submit-text btn btn-primary">ĐĂNG NHẬP</button>
									    </div>
									</form>
								</div>
								<div class="submit-text coupon">
							<a href="admin/?mod=login&act=login">Đăng nhập quản trị</a>
						</div>
							</div>
						</div>
					</div>
					<div class="col-sm-6">
						<div class="main-input padding60 new-customer">
							<div class="log-title">
								<h3><strong>khách hàng mới</strong></h3>
							</div>
							<div class="custom-input">
								<?php 
								// Chỉ hiển thị thông báo lỗi đăng ký
								if(isset($_COOKIE['msg']) && (strpos($_COOKIE['msg'], 'Email đã được đăng ký') !== false || strpos($_COOKIE['msg'], 'Số điện thoại đã được đăng ký') !== false || strpos($_COOKIE['msg'], 'Vui lòng kiểm tra lại thông tin') !== false || strpos($_COOKIE['msg'], 'Vui lòng nhập') !== false || strpos($_COOKIE['msg'], 'Email không hợp lệ') !== false || strpos($_COOKIE['msg'], 'Mật khẩu phải có ít nhất') !== false || strpos($_COOKIE['msg'], 'Số điện thoại phải là số') !== false)) { ?>
					                <div class="alert alert-danger">
					                    <strong>Thất bại! </strong><?= $_COOKIE['msg'] ?>
					                </div>
					            <?php }?>
								<form action="?mod=login&act=register" method="post" id="registerForm">
									<input type="text" name="firstName" placeholder="Tên.." />
									<input type="text" name="lastName" placeholder="Họ.." />
									<input type="text" required name="email" placeholder="Ðia chá email.." />
									<input type="text" name="phone" placeholder="Số điện thoai.." />
									<input type="password" required name="password" placeholder="Mát kháu" />
									<input type="text" name="addressLine1" placeholder="Ðia chỉ" />
									<input type="text" name="city" placeholder="Thành phố" />
									<input type="text" name="country" placeholder="Quốc gia" />
									<div>
										<button type="button" class="submit-text btn btn-primary" onclick="checkAndSubmit()">ÐĂNG KÝ</button>
									</div>
								</form>
							</div>
						</div>
					</div>
				</div>
			</div>
		</section>
		<!-- login content section end -->
        <!-- footer section start -->
		<?php require_once('views/include/footer.php') ?>
        <!-- footer section end -->
        
		<!-- all js here -->
		<!-- jquery latest version -->
        <?php require_once('views/include/jquery.php') ?>
        <script>
        function checkAndSubmit() {
            var email = document.querySelector('input[name="email"]').value;
            var phone = document.querySelector('input[name="phone"]').value;
            
            console.log('Email:', email);
            console.log('Phone:', phone);
            console.log('Email === Phone:', email === phone);
            
            // Kiểm tra email và phone có trùng nhau không
            if (email && phone && email === phone) {
                console.log('Phát hiện lỗi trùng nhau!');
                alert('Email và số điện thoại không được trùng nhau! Vui lòng nhập thông tin khác nhau.');
                return false;
            }
            
            console.log('Không có lỗi, cho submit');
            document.getElementById('registerForm').submit();
            return true;
        }
        </script>
    </body>
</html>