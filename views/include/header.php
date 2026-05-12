<header class="header-one">
			<div class="container-fluid text-center">
				<div class="row">
					<div class="col-sm-2">
						<div class="logo">
							<a href="?mod=page&act=home"><img src="public/img/logo.jpg" alt="Sellshop" /></a>
						</div>
					</div>
					<div class="col-sm-8">
						<div class="header-middel">
							<div class="middel-top clearfix">
								<div class="left floatleft">
									<p><i class="mdi mdi-clock"></i> Mon-Fri : 09:00-19:00</p>
								</div>
								<div class="center floatleft">
									<form action="?mod=page&act=search" method="POST">
										<button type="submit"><i class="mdi mdi-magnify"></i></button>
										<input type="text" placeholder="Search within these results..." name = "data"/>
									</form>
								</div>
								<div class="right floatleft">
									<ul class="clearfix">
										<li><a href="?mod=page&act=home"><i class="mdi mdi-account"></i></a>
											<h5><?php if(isset($_SESSION['customer']['contactLastName'])) echo $_SESSION['customer']['contactLastName']; 
											else if(isset($_SESSION['admin']['lastName'])) echo $_SESSION['admin']['lastName'];?></h5>
											<ul> 
												<?php if(isset($_SESSION['customer']) or isset($_SESSION['admin'])) { ?>												
												<li><a href="?mod=login&act=logout">Logout</a></li>
												<li><a href="?mod=page&act=account">My account</a></li>
											    <?php }else{ ?>
												<li><a href="?mod=login&act=login">Login</a></li>
											    <?php } ?>	
											    <li><?php if(isset($_SESSION['admin']['lastName'])){ ?>
												        <a href="admin/?mod=page&act=dashboard">Admin</a>
												      </a>
												<?php } ?>
												</li>
											</ul>
										</li>
										<li><a href="#"><i class="mdi mdi-settings"></i></a>
										<?php if(isset($_SESSION['customer']) or isset($_SESSION['admin'])) { ?>
											<ul>
												<li><a href="?mod=page&act=account">My account</a></li>
												<li><a href="?mod=cart&act=list">My cart</a></li>
											</ul>
										<?php } ?>	
										</li>
									</ul>
								</div>
							</div>
							<div class="mainmenu">
								<nav>
									<ul>
										<li><a href="?mod=page&act=home">Home</a></li>
										<li><a href="?mod=page&act=about">About</a></li>
										<li><a href="?mod=product&line=1&type=Soccer">Soccer</a></li>
										<li><a href="?mod=product&line=2&type=Basketball">Basketball</a></li>
										<li><a href="?mod=product&line=3&type=Badminton">Badminton</a></li>
										<!-- <li><a href="?mod=product&line=4&type=Volleyball">Volleyball</a></li> -->
										<li><a href="?mod=news&act=list">Tin Tức</a></li>
									</ul>
								</nav>
							</div>
						</div>
					</div>
					<div class="col-sm-2">
						<div class="cart-itmes">
							<a class="cart-itme-a" href="?mod=cart&act=list">
								<i class="mdi mdi-cart"></i>
								<?php if(isset($_SESSION['cart'])) echo count($_SESSION['cart']); else echo '0';?> items :  <strong><?php if(isset($_SESSION['sum'])) echo number_format($_SESSION['sum']); else echo '0';?> VND</strong>
							</a>
							<?php if(isset($_SESSION['customer']) or isset($_SESSION['admin'])) { ?>
							<div class="cartdrop">
								<a class="out-menu" href="?mod=cart&act=list">go to cart</a>
								<!-- <a class="out-menu" href="views/page/checkout.php">Check out</a> -->
							</div>
						    <?php }?>
						</div>
					</div>
				</div>
			</div>
		</header>