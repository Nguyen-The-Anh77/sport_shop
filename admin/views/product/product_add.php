<?php

require_once ('models/Connection.php');
// Load menu bài viết
$conn_obj = new Connection();
// Cau lenh truy van
$query_prodlines = "SELECT
  *
FROM
  productlines";

// Thuc thi cau lenh
$result_prodlines = $conn_obj -> conn -> query($query_prodlines);

// Tao 1 mang de chua du lieu
$prodlines = array();

while ($row = $result_prodlines->fetch_assoc()) {
  $prodlines[] = $row;
}  

?>

<!DOCTYPE html>
<html>
<?php require_once('public/require/head.php') ?>

<body id="page-top">

  <!-- Page Wrapper -->
  <div id="wrapper">

    <!-- Sidebar -->
    <?php require_once('public/require/sidebar.php') ?>
    <!-- End of Sidebar -->

    <!-- Content Wrapper -->
    <div id="content-wrapper" class="d-flex flex-column">

      <!-- Main Content -->
      <div id="content">

        <!-- Topbar -->
        <?php require_once('public/require/header.php') ?>
        <!-- End of Topbar -->

        <!-- Begin Page Content -->
       
          
      <!-- Page Heading -->
      <div class="container-fluid">
        <h2 align="center">Add Product</h2>
        <hr>
        <?php if(isset($_COOKIE['msg'])){ ?>
        <div class="alert alert-warning">
          <strong><?= $_COOKIE['msg'] ?></strong>
        </div>
    <?php }?>
        <form action="?mod=product&act=store" method="POST" role="form" enctype="multipart/form-data">
            <div class="form-group">
                <label for="">ID</label>
                <input type="text" class="form-control" id="" placeholder="" name="id">
            </div>
            <div class="form-group">
                <label for="">Product Name</label>
                <input type="text" class="form-control" id="" placeholder="" name="productName">
            </div>
            <div class="form-group">
                <label for="">Price Each (VND)</label>
                <input type="text" class="form-control" id="" placeholder="" name="price">
            </div>
            <div class="form-group">
                <label for="">Description</label>
                <textarea rows = "8" class="form-control" id="contents" placeholder="" name="productDescription"></textarea>
            </div>
            <div class="form-group">
                <label for="">ProductLine</label>
                <select name="productLineCode" class="form-control">
                <?php foreach ($prodlines as $prls) {?>  
                  <option value="<?= $prls['productLineCode'] ?>"><?= $prls['textDescription'] ?></option>
                <?php } ?>
                </select>
            </div>
            <div class="form-group">
                <label for="">Quantity In Stock</label>
                <input  type="number" class="form-control" id="" placeholder="" name="quantityInStock">
            </div>
            <div class="form-group">
                <label for="">Sale Percent</label>
                <input type="number" class="form-control" id="" placeholder="" name="sale">
            </div>
            <div class="form-group">
                <label for="">Image</label>
                <input type="text" class="form-control" id="" placeholder="" name="thumbnail">
            </div>
            <button type="submit" class="btn btn-primary">Create</button>
            <a href="?mod=product" type="button" class="btn btn-primary">Back</a>
        </form>
        <br/>
    </div>
    <script>
    $(document).ready(function() {
        $('#contents').summernote({
          height: 300,                 // set editor height
          minHeight: null,             // set minimum height of editor
          maxHeight: null,             // set maximum height of editor
          focus: true                  // set focus to editable area after initializing summernote
        });
    });
    </script>
</body>
</html>