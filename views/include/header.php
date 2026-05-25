<header class="modern-header">
			<div class="container-fluid">
				<div class="modern-header-inner">
					<div class="modern-brand">
						<a href="?mod=page&act=home">
							<img src="public/img/logo.jpg" alt="Sport Shop" />
							<div class="modern-brand-text">
								<span class="modern-brand-title">Sport Shop</span>
								<span class="modern-brand-subtitle">Gear up for every match</span>
							</div>
						</a>
					</div>

					<div class="modern-search">
						<form action="?mod=page&act=search" method="POST">
							<input type="text" placeholder="Tìm kiếm sản phẩm..." name="data" />
							<button type="submit" aria-label="Search">
								<i class="mdi mdi-magnify"></i>
							</button>
						</form>
					</div>

					<nav class="modern-nav">
						<a class="modern-nav-link is-active" href="?mod=page&act=home">Home</a>
						<a class="modern-nav-link" href="?mod=page&act=about">About</a>
						<a class="modern-nav-link" href="?mod=product&line=1&type=Soccer">Soccer</a>
						<a class="modern-nav-link" href="?mod=product&line=2&type=Basketball">Basketball</a>
						<a class="modern-nav-link" href="?mod=product&line=3&type=Badminton">Badminton</a>
						<a class="modern-nav-link" href="?mod=news&act=list">Tin Tức</a>
					</nav>

					<div class="modern-actions">
						<a class="modern-action-card" href="?mod=wishlist&act=list">
							<div class="modern-action-icon">
								<i class="mdi mdi-heart"></i>
							</div>
							<div class="modern-action-label">
								<strong>Yêu thích</strong>
								<span><?php echo count($_SESSION['wishlist'] ?? []); ?> sản phẩm</span>
							</div>
						</a>

						<a class="modern-action-card" href="?mod=cart&act=list">
							<div class="modern-action-icon">
								<i class="mdi mdi-cart"></i>
							</div>
							<div class="modern-action-label">
								<strong>
									<?php if(isset($_SESSION['cart'])) echo count($_SESSION['cart']); else echo '0';?> items
								</strong>
								<span><?php if(isset($_SESSION['sum'])) echo number_format($_SESSION['sum']); else echo '0';?> VND</span>
							</div>
						</a>

						<?php if(isset($_SESSION['customer']) or isset($_SESSION['admin'])) { ?>
						<div class="modern-user-menu">
							<a href="#" class="modern-action-card modern-user-pill">
								<div class="modern-action-icon">
									<i class="mdi mdi-account"></i>
								</div>
								<div class="modern-action-label">
									<strong>Xin chào</strong>
									<span class="modern-user-name">
										<?php if(isset($_SESSION['customer']['contactLastName'])) echo $_SESSION['customer']['contactLastName']; else if(isset($_SESSION['admin']['lastName'])) echo $_SESSION['admin']['lastName']; ?>
									</span>
								</div>
							</a>
							<div class="modern-user-dropdown">
								<a href="?mod=page&act=account">My account</a>
								<a href="?mod=cart&act=list">My cart</a>
								<?php if(isset($_SESSION['admin']['lastName'])) { ?>
								<a href="admin/?mod=page&act=dashboard">Admin</a>
								<?php } ?>
								<a href="?mod=login&act=logout">Logout</a>
							</div>
						</div>
						<?php } else { ?>
						<a class="modern-action-card" href="?mod=login&act=login">
							<div class="modern-action-icon">
								<i class="mdi mdi-login"></i>
							</div>
							<div class="modern-action-label">
								<strong>Đăng nhập</strong>
								<span>Truy cập tài khoản</span>
							</div>
						</a>
						<?php } ?>
					</div>
				</div>
			</div>
		</header>