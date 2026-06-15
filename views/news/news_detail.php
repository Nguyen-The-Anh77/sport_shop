<?php 
require_once('views/include/head.php'); 
?>
<link rel="stylesheet" href="public/news-styles.css">
<?php require_once('views/include/header.php'); ?>

<!-- Breadcrumb -->
<div class="breadcrumb-area pt-205 pb-210" style="background-image: url('public/img/breadcrumb/breadcrumb.jpg');">
    <div class="container">
        <div class="breadcrumb-content text-center">
            <h2>Chi Tiết Tin Tức</h2>
            <ul>
                <li><a href="?mod=page&act=home">Trang chủ</a></li>
                <li><a href="?mod=news&act=list">Tin tức</a></li>
                <li><?php echo $news['title']; ?></li>
            </ul>
        </div>
    </div>
</div>

<!-- Blog Details Area -->
<div class="blog-details-area pt-90 pb-90">
    <div class="container">
        <div class="row">
            <!-- Main Content -->
            <div class="col-lg-8">
                <div class="blog-details-wrapper">
                    <div class="blog-details-top">
                        <div class="blog-details-img">
                            <?php if($news['image']): ?>
                                <img src="public/img/news/<?php echo $news['image']; ?>" alt="<?php echo $news['title']; ?>">
                            <?php else: ?>
                                <img src="public/img/blog/1.jpg" alt="<?php echo $news['title']; ?>">
                            <?php endif; ?>
                        </div>
                        <div class="blog-details-content">
                            <div class="blog-details-header">
                                <h3><?php echo htmlspecialchars($news['title']); ?></h3>
                            </div>
                            <div class="blog-meta">
                                <ul>
                                    <li><i class="mdi mdi-account"></i> Admin</li>
                                    <li><i class="mdi mdi-calendar"></i> <?php echo date('d/m/Y', strtotime($news['created_at'])); ?></li>
                                    <li><i class="mdi mdi-eye"></i> <?php echo $news['views']; ?> views</li>
                                </ul>
                            </div>
                            <div class="blog-content-text">
                                <?php echo $news['content']; ?>
                            </div>
                            
                            <!-- Tags -->
                            <?php if($news['tags']): ?>
                                <div class="blog-tags">
                                    <h4>Tags:</h4>
                                    <ul>
                                        <?php 
                                        $tags = explode(',', $news['tags']);
                                        foreach($tags as $tag): 
                                        ?>
                                            <li><a href="#"><?php echo trim($tag); ?></a></li>
                                        <?php endforeach; ?>
                                        
                                    </ul>
                                    
                                </div>
                            <?php endif; ?>
                            
                            <!-- Share -->
                            <div class="blog-share">
                                <h4>Chia sẻ:</h4>
                                <ul>
                                    <li><a href="#" onclick="window.open('https://www.facebook.com/sharer/sharer.php?u='+encodeURIComponent(window.location.href), 'facebook-share-dialog', 'width=626,height=436'); return false;"><i class="mdi mdi-facebook"></i></a></li>
                                    <li><a href="#" onclick="window.open('https://twitter.com/intent/tweet?text='+encodeURIComponent(document.title)+'&url='+encodeURIComponent(window.location.href), 'twitter-share-dialog', 'width=626,height=436'); return false;"><i class="mdi mdi-twitter"></i></a></li>
                                    <li><a href="#" onclick="window.open('https://plus.google.com/share?url='+encodeURIComponent(window.location.href), 'google-plus-share-dialog', 'width=626,height=436'); return false;"><i class="mdi mdi-google-plus"></i></a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Related News -->
                    <?php if(!empty($related_news)): ?>
                        <div class="related-post mt-50">
                            <h3>Tin tức liên quan</h3>
                            <div class="row">
                                <?php foreach($related_news as $related): ?>
                                    <div class="col-md-4">
                                        <div class="single-blog mb-30">
                                            <div class="blog-img">
                                                <a href="?mod=news&act=detail&id=<?php echo $related['id']; ?>">
                                                    <?php if($related['image']): ?>
                                                        <img src="public/img/news/<?php echo $related['image']; ?>" alt="<?php echo $related['title']; ?>">
                                                    <?php else: ?>
                                                    <img src="public/img/blog/1.jpg" alt="<?php echo $related['title']; ?>">
                                                    <?php endif; ?>
                                                </a>
                                            </div>
                                            <div class="blog-content">
                                                <h4><a href="?mod=news&act=detail&id=<?php echo $related['id']; ?>"><?php echo $related['title']; ?></a></h4>
                                                <div class="blog-meta">
                                                    <ul>
                                                        <li><i class="mdi mdi-calendar"></i> <?php echo date('d/m/Y', strtotime($related['created_at'])); ?></li>
                                                        <li><i class="mdi mdi-eye"></i> <?php echo $related['views']; ?></li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
            
            <!-- Sidebar -->
            <div class="col-lg-4">
                <!-- Latest News Widget -->
                <div class="sidebar-widget mb-30">
                    <h3 class="sidebar-title">Tin tức mới nhất</h3>
                    <div class="sidebar-content">
                        <?php 
                        $news_model = new News();
                        $latest_news = $news_model->getLatest(3);
                        foreach($latest_news as $latest): 
                        ?>
                            <div class="recent-post mb-20">
                                <div class="recent-post-img">
                                    <a href="?mod=news&act=detail&id=<?php echo $latest['id']; ?>">
                                        <?php if($latest['image']): ?>
                                            <img src="public/img/news/<?php echo $latest['image']; ?>" alt="<?php echo $latest['title']; ?>">
                                        <?php else: ?>
                                            <img src="public/img/blog/1.jpg" alt="<?php echo $related['title']; ?>">
                                        <?php endif; ?>
                                    </a>
                                </div>
                                <div class="recent-post-content">
                                    <h4><a href="?mod=news&act=detail&id=<?php echo $latest['id']; ?>"><?php echo $latest['title']; ?></a></h4>
                                    <span><?php echo date('d/m/Y', strtotime($latest['created_at'])); ?></span>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
                
                <!-- Categories Widget -->
                <div class="sidebar-widget mb-30">
                    <h3 class="sidebar-title">Danh mục</h3>
                    <div class="sidebar-content">
                        <ul>
                            <li><a href="?mod=news&act=list&category=1">Tin thể thao</a></li>
                            <li><a href="?mod=news&act=list&category=2">Mẹo tập luyện</a></li>
                            <li><a href="?mod=news&act=list&category=3">Review sản phẩm</a></li>
                            <li><a href="?mod=news&act=list&category=4">Khuyến mãi</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php require_once('views/include/footer.php'); ?>
