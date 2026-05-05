<?php 
$title = '404 - Trang không tồn tại';
require_once(__DIR__ . '/../include/head.php');
require_once(__DIR__ . '/../include/header.php'); 
?>

<!-- Begin Page Content -->
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="error-template text-center">
                <h1>Rất tiếc!</h1>
                <h2>404 Không tìm thấy trang</h2>
                <div class="error-details">
                    Trang bạn đang tìm kiếm có thể đã bị xóa hoặc tạm thời không khả dụng.
                </div>
                <div class="error-actions mt-4">
                    <a href="?mod=page&act=home" class="btn btn-primary btn-lg">
                        <i class="fa fa-home"></i> Về trang chủ
                    </a>
                    <a href="javascript:history.back()" class="btn btn-default btn-lg">
                        <i class="fa fa-arrow-left"></i> Quay lại
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<?php 
require_once(__DIR__ . '/../include/footer.php');
require_once(__DIR__ . '/../include/jquery.php');
?>