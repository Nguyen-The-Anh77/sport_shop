<?php require_once('views/include/header.php'); ?>

<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Chi Tiết Tin Tức</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="?mod=page&act=dashboard">Trang chủ</a></li>
                        <li class="breadcrumb-item"><a href="?mod=news&act=list">Tin tức</a></li>
                        <li class="breadcrumb-item active">Chi tiết</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <section class="content">
        <div class="container-fluid">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title"><?php echo $news['title']; ?></h3>
                    <div class="card-tools">
                        <a href="?mod=news&act=edit&id=<?php echo $news['id']; ?>" class="btn btn-warning btn-sm">
                            <i class="fas fa-edit"></i> Chỉnh sửa
                        </a>
                        <a href="?mod=news&act=list" class="btn btn-secondary btn-sm">
                            <i class="fas fa-list"></i> Danh sách
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-8">
                            <div class="news-content">
                                <?php if($news['image']): ?>
                                    <div class="text-center mb-3">
                                        <img src="../public/img/news/<?php echo $news['image']; ?>" alt="<?php echo $news['title']; ?>" class="img-fluid">
                                    </div>
                                <?php endif; ?>

                                <div class="news-meta mb-3">
                                    <span class="badge badge-info"><?php echo date('d/m/Y H:i', strtotime($news['created_at'])); ?></span>
                                    <span class="badge badge-primary ml-2">Views: <?php echo $news['views']; ?></span>
                                    <?php if($news['featured'] == 1): ?>
                                        <span class="badge badge-warning ml-2">Nổi bật</span>
                                    <?php endif; ?>
                                </div>

                                <div class="news-description">
                                    <h5>Mô tả ngắn:</h5>
                                    <p><?php echo $news['description'] ? $news['description'] : 'Không có mô tả'; ?></p>
                                </div>

                                <div class="news-content mt-4">
                                    <h5>Nội dung:</h5>
                                    <div class="content-text">
                                        <?php echo $news['content']; ?>
                                    </div>
                                </div>

                                <?php if($news['tags']): ?>
                                    <div class="news-tags mt-4">
                                        <h5>Tags:</h5>
                                        <?php 
                                        $tags = explode(',', $news['tags']);
                                        foreach($tags as $tag): 
                                        ?>
                                            <span class="badge badge-secondary mr-1"><?php echo trim($tag); ?></span>
                                        <?php endforeach; ?>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="news-info">
                                <h5>Thông tin tin tức</h5>
                                <table class="table table-bordered">
                                    <tr>
                                        <th width="30%">ID:</th>
                                        <td><?php echo $news['id']; ?></td>
                                    </tr>
                                    <tr>
                                        <th>Slug:</th>
                                        <td><?php echo $news['slug']; ?></td>
                                    </tr>
                                    <tr>
                                        <th>Danh mục:</th>
                                        <td>
                                            <?php 
                                            $categories = array(1 => 'Tin thể thao', 2 => 'Mẹo tập luyện', 3 => 'Review sản phẩm', 4 => 'Khuyến mãi');
                                            echo isset($categories[$news['category_id']]) ? $categories[$news['category_id']] : 'Khác';
                                            ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Tác giả:</th>
                                        <td><?php echo $news['author']; ?></td>
                                    </tr>
                                    <tr>
                                        <th>Trạng thái:</th>
                                        <td>
                                            <?php if($news['status'] == 1): ?>
                                                <span class="badge badge-success">Đã đăng</span>
                                            <?php else: ?>
                                                <span class="badge badge-secondary">Nháp</span>
                                            <?php endif; ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Nổi bật:</th>
                                        <td>
                                            <?php if($news['featured'] == 1): ?>
                                                <span class="badge badge-warning">Có</span>
                                            <?php else: ?>
                                                <span class="badge badge-light">Không</span>
                                            <?php endif; ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Lượt xem:</th>
                                        <td><?php echo $news['views']; ?></td>
                                    </tr>
                                    <tr>
                                        <th>Ngày tạo:</th>
                                        <td><?php echo date('d/m/Y H:i:s', strtotime($news['created_at'])); ?></td>
                                    </tr>
                                    <tr>
                                        <th>Cập nhật:</th>
                                        <td><?php echo date('d/m/Y H:i:s', strtotime($news['updated_at'])); ?></td>
                                    </tr>
                                </table>
                            </div>

                            <div class="news-actions mt-3">
                                <h5>Thao tác</h5>
                                <div class="btn-group-vertical" style="width: 100%;">
                                    <a href="?mod=news&act=edit&id=<?php echo $news['id']; ?>" class="btn btn-warning">
                                        <i class="fas fa-edit"></i> Chỉnh sửa
                                    </a>
                                    <a href="?mod=news&act=delete&id=<?php echo $news['id']; ?>" class="btn btn-danger" onclick="return confirm('Bạn có chắc chắn muốn xóa tin tức này?')">
                                        <i class="fas fa-trash"></i> Xóa tin tức
                                    </a>
                                    <a href="?mod=news&act=list" class="btn btn-secondary">
                                        <i class="fas fa-arrow-left"></i> Quay lại danh sách
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

<style>
.content-text {
    line-height: 1.6;
}
.content-text h1, .content-text h2, .content-text h3, .content-text h4, .content-text h5, .content-text h6 {
    margin-top: 20px;
    margin-bottom: 10px;
}
.content-text p {
    margin-bottom: 15px;
}
.content-text ul, .content-text ol {
    margin-bottom: 15px;
    padding-left: 30px;
}
</style>

<?php require_once('views/include/footer.php'); ?>
