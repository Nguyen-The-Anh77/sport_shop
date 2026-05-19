<?php require_once('views/include/header.php'); ?>

<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Quản lý Slider</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="?mod=page&act=dashboard">Trang chủ</a></li>
                        <li class="breadcrumb-item active">Slider</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <section class="content">
        <div class="container-fluid">
            <?php if(isset($_SESSION['success'])): ?>
                <div class="alert alert-success alert-dismissible">
                    <button type="button" class="close" data-dismiss="alert">&times;</button>
                    <?php 
                        echo $_SESSION['success']; 
                        unset($_SESSION['success']);
                    ?>
                </div>
            <?php endif; ?>

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
                    <h3 class="card-title">Danh sách slider</h3>
                    <a href="?mod=slider&act=add" class="btn btn-primary btn-sm float-right">
                        <i class="fas fa-plus"></i> Thêm mới
                    </a>
                </div>
                <div class="card-body">
                    <table class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Hình ảnh</th>
                                <th>Tiêu đề</th>
                                <th>Mô tả</th>
                                <th>Link</th>
                                <th>Trạng thái</th>
                                <th>Ngày tạo</th>
                                <th>Thao tác</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if(!empty($data)): ?>
                                <?php foreach($data as $slider): ?>
                                    <tr>
                                        <td><?php echo $slider['id']; ?></td>
                                        <td>
                                            <?php if($slider['image']): ?>
                                                <img src="../<?php echo $slider['image']; ?>" alt="<?php echo $slider['title']; ?>" width="100" height="60">
                                            <?php else: ?>
                                                <span class="text-muted">Không có ảnh</span>
                                            <?php endif; ?>
                                        </td>
                                        <td><?php echo $slider['title']; ?></td>
                                        <td><?php echo substr($slider['description'], 0, 50) . '...'; ?></td>
                                        <td><?php echo $slider['link'] ? '<a href="'.$slider['link'].'" target="_blank">'.$slider['link'].'</a>' : '-'; ?></td>
                                        <td>
                                            <?php if($slider['status'] == 1): ?>
                                                <span class="badge badge-success">Hiển thị</span>
                                            <?php else: ?>
                                                <span class="badge badge-secondary">Ẩn</span>
                                            <?php endif; ?>
                                        </td>
                                        <td><?php echo date('d/m/Y H:i', strtotime($slider['created_at'])); ?></td>
                                        <td>
                                            <a href="?mod=slider&act=edit&id=<?php echo $slider['id']; ?>" class="btn btn-info btn-sm">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <a href="?mod=slider&act=delete&id=<?php echo $slider['id']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Bạn có chắc chắn muốn xóa slider này?')">
                                                <i class="fas fa-trash"></i>
                                            </a>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="8" class="text-center">Không có slider nào</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Pagination -->
            <?php if(isset($total_pages) && $total_pages > 1): ?>
                <div class="row">
                    <div class="col-sm-12">
                        <div class="dataTables_paginate paging_simple_numbers">
                            <ul class="pagination">
                                <?php if($page > 1): ?>
                                    <li class="paginate_button page-item previous">
                                        <a href="?mod=slider&act=list&page=<?php echo $page - 1; ?>" class="page-link">Trước</a>
                                    </li>
                                <?php endif; ?>
                                
                                <?php for($i = 1; $i <= $total_pages; $i++): ?>
                                    <li class="paginate_button page-item <?php echo ($i == $page) ? 'active' : ''; ?>">
                                        <a href="?mod=slider&act=list&page=<?php echo $i; ?>" class="page-link"><?php echo $i; ?></a>
                                    </li>
                                <?php endfor; ?>
                                
                                <?php if($page < $total_pages): ?>
                                    <li class="paginate_button page-item next">
                                        <a href="?mod=slider&act=list&page=<?php echo $page + 1; ?>" class="page-link">Sau</a>
                                    </li>
                                <?php endif; ?>
                            </ul>
                        </div>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </section>
</div>

<?php require_once('views/include/footer.php'); ?>
