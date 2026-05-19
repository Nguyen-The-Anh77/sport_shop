<?php require_once('views/include/header.php'); ?>

<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Thêm Slider Mới</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="?mod=page&act=dashboard">Trang chủ</a></li>
                        <li class="breadcrumb-item"><a href="?mod=slider&act=list">Slider</a></li>
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
                    <h3 class="card-title">Thông tin slider</h3>
                </div>
                <div class="card-body">
                    <form action="?mod=slider&act=store" method="POST" enctype="multipart/form-data" accept-charset="UTF-8">
                        <div class="row">
                            <div class="col-md-8">
                                <div class="form-group">
                                    <label for="title">Tiêu đề</label>
                                    <input type="text" class="form-control" id="title" name="title" placeholder="Nhập tiêu đề slider">
                                </div>

                                <div class="form-group">
                                    <label for="description">Mô tả</label>
                                    <textarea class="form-control" id="description" name="description" rows="3" placeholder="Nhập mô tả ngắn"></textarea>
                                </div>

                                <div class="form-group">
                                    <label for="link">Link</label>
                                    <input type="text" class="form-control" id="link" name="link" placeholder="Link khi click vào slider (ví dụ: ?mod=product&act=list)">
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="image">Hình ảnh <span class="text-danger">*</span></label>
                                    <div class="custom-file">
                                        <input type="file" class="custom-file-input" id="image" name="image" accept="image/*" required>
                                        <label class="custom-file-label" for="image">Chọn file ảnh</label>
                                    </div>
                                    <small class="form-text text-muted">Chấp nhận: JPG, JPEG, PNG, GIF (Tối đa 5MB)</small>
                                    <small class="form-text text-muted">Kích thước khuyến nghị: 1920x600px</small>
                                </div>

                                <div class="form-group">
                                    <div class="custom-control custom-switch">
                                        <input type="checkbox" class="custom-control-input" id="status" name="status" value="1" checked>
                                        <label class="custom-control-label" for="status">Hiển thị</label>
                                    </div>
                                    <small class="form-text text-muted">Bỏ chọn để ẩn slider</small>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save"></i> Lưu slider
                            </button>
                            <a href="?mod=slider&act=list" class="btn btn-secondary">
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
