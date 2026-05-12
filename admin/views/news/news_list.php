<?php require_once('views/include/header.php'); ?>

<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Quản lý Tin Tức</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="?mod=page&act=dashboard">Trang chủ</a></li>
                        <li class="breadcrumb-item active">Tin tức</li>
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
                    <h3 class="card-title">Danh sách tin tức</h3>
                    <a href="?mod=news&act=add" class="btn btn-primary btn-sm float-right">
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
                                <th>Danh mục</th>
                                <th>Tác giả</th>
                                <th>Trạng thái</th>
                                <th>Nổi bật</th>
                                <th>Views</th>
                                <th>Ngày tạo</th>
                                <th>Thao tác</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if(!empty($data)): ?>
                                <?php foreach($data as $news): ?>
                                    <tr>
                                        <td><?php echo $news['id']; ?></td>
                                        <td>
                                            <?php if($news['image']): ?>
                                                <img src="../public/img/news/<?php echo $news['image']; ?>" alt="<?php echo $news['title']; ?>" width="50" height="50">
                                            <?php else: ?>
                                                <img src="../public/img/blog/1.jpg" alt="<?php echo $news['title']; ?>" width="50" height="50">
                                            <?php endif; ?>
                                        </td>
                                        <td>
                                            <a href="?mod=news&act=detail&id=<?php echo $news['id']; ?>">
                                                <?php echo $news['title']; ?>
                                            </a>
                                        </td>
                                        <td>
                                            <?php 
                                            $categories = array(1 => 'Tin thể thao', 2 => 'Mẹo tập luyện', 3 => 'Review sản phẩm', 4 => 'Khuyến mãi');
                                            echo isset($categories[$news['category_id']]) ? $categories[$news['category_id']] : 'Khác';
                                            ?>
                                        </td>
                                        <td><?php echo $news['author']; ?></td>
                                        <td>
                                            <?php if($news['status'] == 1): ?>
                                                <span class="badge badge-success">Đăng</span>
                                            <?php else: ?>
                                                <span class="badge badge-secondary">Nháp</span>
                                            <?php endif; ?>
                                        </td>
                                        <td>
                                            <?php if($news['featured'] == 1): ?>
                                                <span class="badge badge-warning">Nổi bật</span>
                                            <?php else: ?>
                                                <span class="badge badge-light">Thường</span>
                                            <?php endif; ?>
                                        </td>
                                        <td><?php echo $news['views']; ?></td>
                                        <td><?php echo date('d/m/Y', strtotime($news['created_at'])); ?></td>
                                        <td>
                                            <a href="?mod=news&act=edit&id=<?php echo $news['id']; ?>" class="btn btn-info btn-sm">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <a href="?mod=news&act=detail&id=<?php echo $news['id']; ?>" class="btn btn-primary btn-sm">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <a href="?mod=news&act=delete&id=<?php echo $news['id']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Bạn có chắc chắn muốn xóa tin tức này?')">
                                                <i class="fas fa-trash"></i>
                                            </a>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="10" class="text-center">Không có tin tức nào</td>
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
                                        <a href="?mod=news&act=list&page=<?php echo $page - 1; ?>" class="page-link">Trước</a>
                                    </li>
                                <?php endif; ?>
                                
                                <?php for($i = 1; $i <= $total_pages; $i++): ?>
                                    <li class="paginate_button page-item <?php echo ($i == $page) ? 'active' : ''; ?>">
                                        <a href="?mod=news&act=list&page=<?php echo $i; ?>" class="page-link"><?php echo $i; ?></a>
                                    </li>
                                <?php endfor; ?>
                                
                                <?php if($page < $total_pages): ?>
                                    <li class="paginate_button page-item next">
                                        <a href="?mod=news&act=list&page=<?php echo $page + 1; ?>" class="page-link">Sau</a>
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
