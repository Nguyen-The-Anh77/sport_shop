<!-- quick view start -->
		<div class="product-details quick-view modal animated zoomInUp" id="quick-view">
			<div class="container">
				<div class="row">
					<div class="col-xs-12">
						<div class="d-table">
							<div class="d-tablecell">
								<div class="modal-dialog">
									<div class="main-view modal-content">
										<div class="modal-footer" data-dismiss="modal">
											<span>x</span>
										</div>
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
																	<a class="simpleLens-image" data-lens-image="admin/public/img/<?= $data['thumbnail']?>" href="#"><img src="admin/public/img/<?= $data['thumbnail']?>" alt="" class="simpleLens-big-image"></a>
																</div>
																<div class="simpleLens-container tab-pane active fade in" id="q-sin-2">
																	<div class="pro-type sell">
																		<span>sell</span>
																	</div>
																	<a class="simpleLens-image" data-lens-image="admin/public/img/<?= $data['thumbnail']?>" href="#"><img src="admin/public/img/<?= $data['thumbnail']?>" alt="" width="370px" height="440px" class="simpleLens-big-image"></a>
																</div>
																<div class="simpleLens-container tab-pane fade in" id="q-sin-3">
																	<div class="pro-type">
																		<span>-<?= number_format($value['sales_percent']) ?>%</span>
																	</div>
																	<a class="simpleLens-image" data-lens-image="admin/public/img/<?= $data['thumbnail']?>" href="#"><img src="admin/public/img/<?= $data['thumbnail']?>" alt="" class="simpleLens-big-image"></a>
																</div>
																<div class="simpleLens-container tab-pane fade in" id="q-sin-4">
																	<div class="pro-type">
																		<span>new</span>
																	</div>
																	<a class="simpleLens-image" data-lens-image="admin/public/img/<?= $data['thumbnail']?>" href="#"><img src="admin/public/img/<?= $data['thumbnail']?>" alt="" class="simpleLens-big-image"></a>
																</div>
															</div>
														</div>
													</div>
													<div class="quick-thumb">
														<ul class="product-slider">
															<li><a data-toggle="tab" href="#q-sin-1"> <img src="admin/public/img/<?= $data['thumbnail']?>" alt="quick view" /> </a></li>
															<li class="active"><a data-toggle="tab" href="#q-sin-2"> <img src="admin/public/img/<?= $data['thumbnail']?>" alt="small image" /> </a></li>
															<li><a data-toggle="tab" href="#q-sin-3"> <img src="admin/public/img/<?= $data['thumbnail']?>" alt="small image" /> </a></li>
															<li><a data-toggle="tab" href="#q-sin-4"> <img src="admin/public/img/<?= $data['thumbnail']?>" alt="small image" /> </a></li>
														</ul>
													</div>
												</div>						
											</div>
											<div class="col-xs-12 col-sm-7 col-md-8">
												<div class="quick-right">
													<div class="list-text">
														<h3><?= $data['productName'] ?></h3>
														<span>Sports men’s fashion</span>
														<div class="ratting floatright">
															<p>( 27 Rating )</p>
															<i class="mdi mdi-star"></i>
															<i class="mdi mdi-star"></i>
															<i class="mdi mdi-star"></i>
															<i class="mdi mdi-star-half"></i>
															<i class="mdi mdi-star-outline"></i>
														</div>
														<h5><del><?= number_format($data['buyPrice']) ?> VND</del> <?= number_format($data['buyPrice']*(100 - $data['sales_percent'])/100)?> VND</h5>
														<p><?= $data['productDescription'] ?></p>
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
																<h5>quantity:<?= $data['quantityInStock']?></h5>
															</div>
														</div>
														<div class="list-btn">
															<a href="#">add to cart</a>
															<a href="#">wishlist</a>
															<a href="#" data-toggle="modal" data-target="#quick-view">zoom</a>
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
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<!-- quick view end -->