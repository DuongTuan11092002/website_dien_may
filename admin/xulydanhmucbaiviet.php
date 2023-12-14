<?php
    include ('../db/connect.php'); //connect to database
?>

<?php  //insert module danh muc tin
    if(isset($_POST['themdanhmuctin'])){
        $tendanhmuc = $_POST['danhmuctin'];
        $sql_insert_danhmuctin = mysqli_query($connect,"INSERT INTO tbl_danhmuctin(tendanhmuc) values('$tendanhmuc')");
        echo "<script language=javascript>
            alert('$tendanhmuc đã thêm thành công');      
        </script>";
    }  
?>

<?php //update module
    if (isset($_POST['capnhatdanhmuctin'])) {
        $id_post = $_POST['id_danhmuctin'];
        $tendanhmuc = $_POST['danhmuctin'];
        $sql_update_danhmuctin = mysqli_query($connect,"UPDATE tbl_danhmuctin SET tendanhmuc ='$tendanhmuc' WHERE danhmuctin_id ='$id_post'");
        // when update finished return page 
        header("Location: xulydanhmucbaiviet.php");
    }
?>

<?php //delete module 
if(isset($_GET['xoa'])){   
    $id = $_GET['xoa'];
    $sql_delete_danhmuctin = mysqli_query($connect,"DELETE FROM tbl_danhmuctin WHERE danhmuctin_id = $id");  
}
?>

<!-- html -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DANH MỤC</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">

</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <a class="navbar-brand" href="dashboard.php">K&T</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav">
            <li class="nav-item active">
                <a class="nav-link" href="xulydonhang.php">Đơn hàng<span class="sr-only">(current)</span></a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="xulydanhmuc.php">Danh mục</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="xulysanpham.php">Sản phẩm</a>
            </li>
            <li class="nav-item">
                <a class="nav-link disabled" href="xulykhachhang.php">Khách hàng</a>
            </li>
            <li class="nav-item">
                    <a class="nav-link disabled" href="xulydanhmucbaiviet.php">Danh mục tin tức</a>
            </li>
            <li class="nav-item">
                    <a class="nav-link disabled" href="xulybaiviet.php">Bài viết tin tức</a>
            </li>
            </ul>
        </div>
    </nav>
    <br>
    <br>
    <div class="container">
        <h1 class="text-center">Quản lý danh mục tin tức</h1>
        <br>
        <div class="row">
            
            <?php
                if(isset($_GET['quanly']) == 'capnhat'){
                    ?>
                        <div class="col-md-4">
                            <h4>Cập nhật danh mục tin tức</h4>
                            <?php //update danh mục tin tức
                                if(isset($_GET['quanly']) == 'capnhat'){
                                    $id_capnhat = $_GET['id'];
                                    $sql_capnhat = mysqli_query($connect,"SElECT * FROM tbl_danhmuctin WHERE danhmuctin_id = '$id_capnhat'");
                                    $row_capnhat = mysqli_fetch_array($sql_capnhat);
    
                            ?>
                            <form action="" method="POST">
                                <label>Tên danh mục:</label>
                                <input type="text" name="danhmuctin" class="form-control" value="<?php echo $row_capnhat['tendanhmuc'] ?>">
                                <br>
                                <input type="hidden" name="id_danhmuctin" class="form-control" value="<?php echo $row_capnhat['danhmuctin_id'] ?>"> <!-- type hidden để lấy in danh mục tin -->
                                <br>    
                                <input type="submit" name="capnhatdanhmuctin" value="Cập nhật danh mục" class="btn btn-success">
                            </form>
                        </div>
                            <?php
                                }
                            ?>
    
                <?php
                    }else{
                ?>
                        <div class="col-md-4">
                            <h4>Thêm danh mục</h4>
                            <form action="" method="POST">
                                <label>Tên danh mục:</label>
                                <input type="text" name="danhmuctin" class="form-control" placeholder="Nhập tên danh mục tin tức">
                                <br>
                                <input type="submit" name="themdanhmuctin" value="Thêm danh mục" class="btn btn-success">
                            </form>
                        </div>  
    
    
                <?php
                }
                ?>
    
                <div class="col-md-8">
                    <h4>Danh sách danh mục tin tức</h4>
                    <?php //take sql
                        
                        $sql_danhmuctin = mysqli_query($connect,"SELECT * FROM tbl_danhmuctin ORDER BY danhmuctin_id DESC");
                    ?>
                    
                    <table class="table table-striped">
                    <thead>
                        <tr>
                        <th scope="col">Thứ tự</th>
                        <th scope="col">Tên danh mục</th>
                        <th scope="col">Quản lý</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php // show category datebase
                        $i = 0;
                        while ($row_danhmuctin = mysqli_fetch_array($sql_danhmuctin)) {
                        $i++;
                    ?>
                        <tr>
                        <th scope="row"><?php echo $i?></th>
                        <td><?php echo $row_danhmuctin['tendanhmuc'] ?></td>
                        <td><a href="?xoa=<?php echo $row_danhmuctin['danhmuctin_id'] ?>" >Xóa</a>   ||   <a href="?quanly=capnhat&id=<?php echo $row_danhmuctin['danhmuctin_id'] ?>">Cập nhật</a></td>
                        </tr>
                    <?php
                        }
                    ?>
                      
                    </tbody>
                    </table>
    
                </div>
        </div>
        
    </div>




    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
</body>
</html>