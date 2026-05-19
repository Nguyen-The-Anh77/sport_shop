<?php require_once('views/include/header.php'); ?>

<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Chỉnh Sửa Tin Tức</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="?mod=page&act=dashboard">Trang chủ</a></li>
                        <li class="breadcrumb-item"><a href="?mod=news&act=list">Tin tức</a></li>
                        <li class="breadcrumb-item active">Chỉnh sửa</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <section class="content">
        <div class="container-fluid">
            <?php if(isset($_SESSION['error'])): ?>
                <div class="alert alert-danger alert-dismissible">
                    <button type="button" class="close" data-dismiss="alert">&times;</button>
                    <?php 
                        echo $_SESSION['error']; 
                        unset($_SESSION['error']);
                    ?>
                </div>
            <?php endif; ?>

            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Chỉnh sửa thông tin tin tức</h3>
                </div>
                <div class="card-body">
                    <form action="?mod=news&act=update" method="POST" enctype="multipart/form-data" accept-charset="UTF-8">
                        <input type="hidden" name="id" value="<?php echo $news['id']; ?>">
                        
                        <div class="row">
                            <div class="col-md-8">
                                <div class="form-group">
                                    <label for="title">Tiêu đề <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="title" name="title" value="<?php echo $news['title']; ?>" required>
                                </div>

                                <div class="form-group">
                                    <label for="description">Mô tả ngắn</label>
                                    <textarea class="form-control" id="description" name="description" rows="3"><?php echo $news['description']; ?></textarea>
                                </div>

                                <div class="form-group">
                                    <label for="content">Nội dung <span class="text-danger">*</span></label>
                                    <textarea class="form-control" id="content" name="content" rows="10" required><?php echo $news['content']; ?></textarea>
                                </div>

                                <div class="form-group">
                                    <label for="tags">Tags</label>
                                    <input type="text" class="form-control" id="tags" name="tags" value="<?php echo $news['tags']; ?>" placeholder="Các tag cách nhau bằng dấu phẩy">
                                    <small class="form-text text-muted">Ví dụ: thể thao, bóng đá, sức khỏe</small>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="category_id">Danh mục <span class="text-danger">*</span></label>
                                    <select class="form-control" id="category_id" name="category_id" required>
                                        <option value="">-- Chọn danh mục --</option>
                                        <option value="1" <?php echo ($news['category_id'] == 1) ? 'selected' : ''; ?>>Tin thể thao</option>
                                        <option value="2" <?php echo ($news['category_id'] == 2) ? 'selected' : ''; ?>>Mẹo tập luyện</option>
                                        <option value="3" <?php echo ($news['category_id'] == 3) ? 'selected' : ''; ?>>Review sản phẩm</option>
                                        <option value="4" <?php echo ($news['category_id'] == 4) ? 'selected' : ''; ?>>Khuyến mãi</option>
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label for="image">Hình ảnh</label>
                                    <div class="custom-file">
                                        <input type="file" class="custom-file-input" id="image" name="image" accept="image/*">
                                        <label class="custom-file-label" for="image">Chọn file ảnh mới</label>
                                    </div>
                                    <small class="form-text text-muted">Chấp nhận: JPG, JPEG, PNG, GIF (Tối đa 5MB)</small>
                                    
                                    <?php if($news['image']): ?>
                                        <div class="mt-2">
                                            <label>Ảnh hiện tại:</label><br>
                                            <img src="../public/img/news/<?php echo $news['image']; ?>" alt="<?php echo $news['title']; ?>" width="100" height="100">
                                        </div>
                                    <?php endif; ?>
                                </div>

                                <div class="form-group">
                                    <div class="custom-control custom-switch">
                                        <input type="checkbox" class="custom-control-input" id="status" name="status" value="1" <?php echo ($news['status'] == 1) ? 'checked' : ''; ?>>
                                        <label class="custom-control-label" for="status">Đăng bài</label>
                                    </div>
                                    <small class="form-text text-muted">Bỏ chọn để lưu dưới dạng nháp</small>
                                </div>

                                <div class="form-group">
                                    <div class="custom-control custom-switch">
                                        <input type="checkbox" class="custom-control-input" id="featured" name="featured" value="1" <?php echo ($news['featured'] == 1) ? 'checked' : ''; ?>>
                                        <label class="custom-control-label" for="featured">Tin nổi bật</label>
                                    </div>
                                    <small class="form-text text-muted">Tin nổi bật sẽ hiển thị ở vị trí ưu tiên</small>
                                </div>

                                <div class="form-group">
                                    <label>Thông tin</label>
                                    <div class="alert alert-info">
                                        <small>
                                            <strong>Tác giả:</strong> <?php echo $news['author']; ?><br>
                                            <strong>Views:</strong> <?php echo $news['views']; ?><br>
                                            <strong>Ngày tạo:</strong> <?php echo date('d/m/Y H:i', strtotime($news['created_at'])); ?><br>
                                            <strong>Cập nhật:</strong> <?php echo date('d/m/Y H:i', strtotime($news['updated_at'])); ?>
                                        </small>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save"></i> Cập nhật tin tức
                            </button>
                            <a href="?mod=news&act=list" class="btn btn-secondary">
                                <i class="fas fa-times"></i> Hủy
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
</div>

<script>
document.querySelector('.custom-file-input').addEventListener('change', function(e) {
    var fileName = e.target.files[0].name;
    var nextSibling = e.target.nextElementSibling;
    nextSibling.innerText = fileName;
});
</script>

<?php require_once('views/include/footer.php'); ?>
