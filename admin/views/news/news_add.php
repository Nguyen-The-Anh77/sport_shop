<?php require_once('views/include/header.php'); ?>

<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Thêm Tin Tức Mới</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="?mod=page&act=dashboard">Trang chủ</a></li>
                        <li class="breadcrumb-item"><a href="?mod=news&act=list">Tin tức</a></li>
                        <li class="breadcrumb-item active">Thêm mới</li>
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
                    <h3 class="card-title">Thông tin tin tức</h3>
                </div>
                <div class="card-body">
                    <form action="?mod=news&act=store" method="POST" enctype="multipart/form-data" accept-charset="UTF-8">
                        <div class="row">
                            <div class="col-md-8">
                                <div class="form-group">
                                    <label for="title">Tiêu đề <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="title" name="title" required>
                                </div>

                                <div class="form-group">
                                    <label for="description">Mô tả ngắn</label>
                                    <textarea class="form-control" id="description" name="description" rows="3"></textarea>
                                </div>

                                <div class="form-group">
                                    <label for="content">Nội dung <span class="text-danger">*</span></label>
                                    <textarea class="form-control" id="content" name="content" rows="10" required></textarea>
                                </div>

                                <div class="form-group">
                                    <label for="tags">Tags</label>
                                    <input type="text" class="form-control" id="tags" name="tags" placeholder="Các tag cách nhau bằng dấu phẩy">
                                    <small class="form-text text-muted">Ví dụ: thể thao, bóng đá, sức khỏe</small>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="category_id">Danh mục <span class="text-danger">*</span></label>
                                    <select class="form-control" id="category_id" name="category_id" required>
                                        <option value="">-- Chọn danh mục --</option>
                                        <option value="1">Tin thể thao</option>
                                        <option value="2">Mẹo tập luyện</option>
                                        <option value="3">Review sản phẩm</option>
                                        <option value="4">Khuyến mãi</option>
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label for="image">Hình ảnh</label>
                                    <div class="custom-file">
                                        <input type="file" class="custom-file-input" id="image" name="image" accept="image/*">
                                        <label class="custom-file-label" for="image">Chọn file ảnh</label>
                                    </div>
                                    <small class="form-text text-muted">Chấp nhận: JPG, JPEG, PNG, GIF (Tối đa 5MB)</small>
                                </div>

                                <div class="form-group">
                                    <div class="custom-control custom-switch">
                                        <input type="checkbox" class="custom-control-input" id="status" name="status" value="1" checked>
                                        <label class="custom-control-label" for="status">Đăng bài</label>
                                    </div>
                                    <small class="form-text text-muted">Bỏ chọn để lưu dưới dạng nháp</small>
                                </div>

                                <div class="form-group">
                                    <div class="custom-control custom-switch">
                                        <input type="checkbox" class="custom-control-input" id="featured" name="featured" value="1">
                                        <label class="custom-control-label" for="featured">Tin nổi bật</label>
                                    </div>
                                    <small class="form-text text-muted">Tin nổi bật sẽ hiển thị ở vị trí ưu tiên</small>
                                </div>

                                <div class="form-group">
                                    <label>Thông tin tác giả</label>
                                    <div class="alert alert-info">
                                        <i class="fas fa-info-circle"></i> 
                                        Tác giả sẽ được tự động điền là: 
                                        <strong><?php echo $_SESSION['admin']['firstName'] . ' ' . $_SESSION['admin']['lastName']; ?></strong>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save"></i> Lưu tin tức
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
// Custom file input
document.querySelector('.custom-file-input').addEventListener('change', function(e) {
    var fileName = e.target.files[0].name;
    var nextSibling = e.target.nextElementSibling;
    nextSibling.innerText = fileName;
});
</script>

<?php require_once('views/include/footer.php'); ?>
