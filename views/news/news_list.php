<?php require_once('views/include/head.php'); ?>
<link rel="stylesheet" href="public/news-styles.css">
<?php require_once('views/include/header.php'); ?>

<!-- Breadcrumb -->
<div class="breadcrumb-area pt-205 pb-210" style="background-image: url('public/img/breadcrumb/breadcrumb.jpg');">
    <div class="container">
        <div class="breadcrumb-content text-center">
            <h2>Tin Tức Thể Thao</h2>
            <ul>
                <li><a href="?mod=page&act=home">Trang chủ</a></li>
                <li>Tin tức</li>
            </ul>
        </div>
    </div>
</div>

<!-- News List Area -->
<div class="blog-area pt-90 pb-90">
    <div class="container">
        <div class="row">
            <!-- Main Content -->
            <div class="col-lg-8">
                <div class="row">
                    <?php if(!empty($data)): ?>
                        <?php foreach($data as $news): ?>
                            <div class="col-md-6">
                                <div class="single-blog mb-30">
                                    <div class="blog-img">
                                        <a href="?mod=news&act=detail&id=<?php echo $news['id']; ?>">
                                            <?php if($news['image']): ?>
                                                <img src="public/img/news/<?php echo $news['image']; ?>" alt="<?php echo htmlspecialchars($news['title']); ?>" style="width: 100%; height: 200px; object-fit: cover;">
                                            <?php else: ?>
                                                <img src="public/img/blog/1.jpg" alt="<?php echo htmlspecialchars($news['title']); ?>" style="width: 100%; height: 200px; object-fit: cover;">
                                            <?php endif; ?>
                                        </a>
                                        <div class="blog-date">
                                            <h3><?php echo date('d', strtotime($news['created_at'])); ?></h3>
                                            <span><?php echo date('M', strtotime($news['created_at'])); ?></span>
                                        </div>
                                    </div>
                                    <div class="blog-content">
                                        <div class="blog-meta">
                                            <ul>
                                                <li><i class="mdi mdi-account"></i> <?php echo htmlspecialchars($news['author']); ?></li>
                                                <li><i class="mdi mdi-eye"></i> <?php echo number_format($news['views']); ?> lượt xem</li>
                                                <li><i class="mdi mdi-calendar"></i> <?php echo date('d/m/Y', strtotime($news['created_at'])); ?></li>
                                            </ul>
                                        </div>
                                        <h4><a href="?mod=news&act=detail&id=<?php echo $news['id']; ?>"><?php echo htmlspecialchars($news['title']); ?></a></h4>
                                        <?php 
                                        $categories = array(1 => 'Tin thể thao', 2 => 'Mẹo tập luyện', 3 => 'Review sản phẩm', 4 => 'Khuyến mãi');
                                        $category_name = isset($categories[$news['category_id']]) ? $categories[$news['category_id']] : 'Khác';
                                        ?>
                                        <div class="blog-category">
                                            <span class="badge badge-info"><?php echo $category_name; ?></span>
                                            <?php if($news['featured'] == 1): ?>
                                                <span class="badge badge-warning ml-1">Nổi bật</span>
                                            <?php endif; ?>
                                        </div>
                                        <p><?php echo substr(strip_tags($news['content']), 0, 150) . '...'; ?></p>
                                        <a class="read-more" href="?mod=news&act=detail&id=<?php echo $news['id']; ?>">Đọc thêm <i class="mdi mdi-arrow-right"></i></a>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <div class="col-12">
                            <div class="alert alert-info text-center">
                                <p><i class="mdi mdi-information"></i> Chưa có tin tức nào được đăng tải.</p>
                            </div>
                        </div>
                    <?php endif; ?>
                </div>
                
                <!-- Pagination -->
                <?php if(isset($total_pages) && $total_pages > 1): ?>
                    <div class="pagination-area mt-50">
                        <ul class="pagination">
                            <?php if($page > 1): ?>
                                <li><a href="?mod=news&act=list&page=<?php echo $page - 1; ?>"><i class="mdi mdi-chevron-left"></i></a></li>
                            <?php endif; ?>
                            
                            <?php for($i = 1; $i <= $total_pages; $i++): ?>
                                <li class="<?php echo ($i == $page) ? 'active' : ''; ?>">
                                    <a href="?mod=news&act=list&page=<?php echo $i; ?>"><?php echo $i; ?></a>
                                </li>
                            <?php endfor; ?>
                            
                            <?php if($page < $total_pages): ?>
                                <li><a href="?mod=news&act=list&page=<?php echo $page + 1; ?>"><i class="mdi mdi-chevron-right"></i></a></li>
                            <?php endif; ?>
                        </ul>
                    </div>
                <?php endif; ?>
            </div>
            
            <!-- Sidebar -->
            <div class="col-lg-4">
                <!-- Latest News Widget -->
                <div class="sidebar-widget mb-30">
                    <h3 class="sidebar-title">Tin tức mới nhất</h3>
                    <div class="sidebar-content">
                        <?php 
                        $latest_news = array_slice($data, 0, 3);
                        foreach($latest_news as $latest): 
                        ?>
                            <div class="recent-post mb-20">
                                <div class="recent-post-img">
                                    <a href="?mod=news&act=detail&id=<?php echo $latest['id']; ?>">
                                        <?php if($latest['image']): ?>
                                            <img src="public/img/news/<?php echo $latest['image']; ?>" alt="<?php echo $latest['title']; ?>">
                                        <?php else: ?>
                                            <img src="public/img/blog/1.jpg" alt="<?php echo $latest['title']; ?>">
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
