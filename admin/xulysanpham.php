<?php
    include('../db/connect.php');
?>

<?php //insert module
    if(isset($_POST['themsanpham'])) {
        $tensanpham = $_POST['tensanpham'];
        $hinhanh = $_FILES['hinhanh']['name'];
        $giasanpham = $_POST['giasanpham'];
        $giakhuyenmai = $_POST['giakhuyenmai'];
        $soluong = $_POST['soluong'];
        $mota = $_POST['mota'];
        $chitiet = $_POST['chitiet'];
        $danhmuc = $_POST['danhmuc'];
        
        //handle file upload
        $path = '../images/';
        $hinhanh_tmp = $_FILES['hinhanh']['tmp_name']; // variable tmp_name
        move_uploaded_file($hinhanh_tmp, $path.$hinhanh);

        $sql_insert_sanpham = mysqli_query($connect,"INSERT INTO tbl_sanpham(sanpham_name,sanpham_chitiet,sanpham_mota,sanpham_gia,sanpham_giakhuyenmai,sanpham_soluong,sanpham_hinhanh,category_id
        ) values ('$tensanpham','$chitiet','$mota','$giasanpham','$giakhuyenmai','$soluong','$hinhanh','$danhmuc')");
        // thông báo khi thêm thành công
        echo "<script language=JavaScript>
            alert('Thêm sản phẩm thành công');
        </script>";
    }

?>

<?php // Module Update
    if(isset($_POST['capnhatsanpham'])) {
        $id_update = $_POST['id_update'];

        $tensanpham = $_POST['tensanpham'];
        $hinhanh = $_FILES['hinhanh']['name'];
        $giasanpham = $_POST['giasanpham'];
        $giakhuyenmai = $_POST['giakhuyenmai'];
        $soluong = $_POST['soluong'];
        $mota = $_POST['mota'];
        $chitiet = $_POST['chitiet'];
        $danhmuc = $_POST['danhmuc'];
        
        //handle file upload
        $path = '../images/';
        $hinhanh_tmp = $_FILES['hinhanh']['tmp_name']; // variable tmp_name

        // Trường hợp có hình ảnh
        if($hinhanh=='') {
            $sql_upadte_image = "UPDATE tbl_sanpham SET sanpham_name = '$tensanpham',sanpham_chitiet = '$chitiet',sanpham_mota = '$mota',sanpham_gia = '$giasanpham',sanpham_giakhuyenmai = '$giakhuyenmai',sanpham_soluong = '$soluong',category_id = '$danhmuc' WHERE sanpham_id = '$id_update'";

        }else{
            move_uploaded_file($hinhanh_tmp, $path.$hinhanh);
            $sql_upadte_image = "UPDATE tbl_sanpham SET sanpham_name = '$tensanpham',sanpham_chitiet = '$chitiet',sanpham_mota = '$mota',sanpham_gia = '$giasanpham',sanpham_giakhuyenmai = '$giakhuyenmai',sanpham_soluong = '$soluong',sanpham_hinhanh= '$hinhanh',category_id = '$danhmuc' WHERE sanpham_id = '$id_update'";
        }
        // câu lênh thực hiện database
        mysqli_query($connect,$sql_upadte_image);
    }
?>


<?php //delete module
    if(isset($_GET['xoa'])) {
        $id = $_GET['xoa'];
        $sql_delete_sanpham = mysqli_query($connect,"DELETE FROM tbl_sanpham WHERE sanpham_id = '$id'");
        
    }

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quản lý sản phẩm</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
 
      
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <a class="navbar-brand" href="#">K&T</a>
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


    
            <div class="row">
                
                <?php //form update
                    if(isset($_GET['quanly']) == 'capnhat'){
                        $id_capnhat = $_GET['capnhat_id'];
                        $sql_capnhat = mysqli_query($connect,"SElECT * FROM tbl_sanpham WHERE sanpham_id = '$id_capnhat'");
                        $row_capnhat = mysqli_fetch_array($sql_capnhat);
                        $id_category_1 = $row_capnhat['category_id'];
                        ?>
                        <div class="col-md-4">
                        <h4>Cập nhật sản phẩm</h4>
                        <form action="" method="POST" enctype="multipart/form-data">
                            <label>Tên sản phẩm:</label>
                            <input type="text" name="tensanpham" class="form-control" value="<?php echo $row_capnhat['sanpham_name']?>"><br>
                            <!-- use type=hidden update -->
                            <input type="hidden" name="id_update" class="form-control" value="<?php echo $row_capnhat['sanpham_id']?>">
                            <label for="">Hình ảnh:</label>
                            <input type="file" name="hinhanh" id="" class="form-control">
                            <img src="../images/<?php echo $row_capnhat['sanpham_hinhanh'] ?>" alt=""  width="250" height="250"><br>
                            <label>Giá sản phẩm:</label>
                            <input type="text" name="giasanpham" class="form-control" value="<?php echo $row_capnhat['sanpham_gia']?>">
                            <label>Giá khuyến mãi:</label>
                            <input type="text" name="giakhuyenmai" class="form-control" value="<?php echo $row_capnhat['sanpham_giakhuyenmai']?>">
                            <label>Số lượng:</label>
                            <input type="text" name="soluong" class="form-control" value="<?php echo $row_capnhat['sanpham_soluong']?>">
                            <label>Mô tả:</label>
                            <textarea name="mota" id="" cols="30" rows="5" class="form-control" ><?php echo $row_capnhat['sanpham_mota']?></textarea>
                            <label>Chi tiết:</label>
                            <textarea name="chitiet" id="" cols="30" rows="5" class="form-control"><?php echo $row_capnhat['sanpham_chitiet']?>"</textarea>                        
                            <label>Danh mục sản phẩm:</label>
                            <?php
                                $sql_danhmuc = mysqli_query($connect,"SELECT * FROM tbl_category ORDER BY category_id DESC");
                            ?>
                            <select name="danhmuc" class="form-control">
                                <option value="0">----Chọn danh mục-----</option>
                                <?php
                                while ($row_danhmuc = mysqli_fetch_array($sql_danhmuc)) {
                                    if($id_category_1 == $row_danhmuc['category_id']) {
                                ?>
                                <option selected value="<?php echo $row_danhmuc['category_id']?>" ><?php echo $row_danhmuc['category_name'] ?></option>

                                <?php
                                } else {

                                ?>
                                <option value="<?php echo $row_danhmuc['category_id']?>" ><?php echo $row_danhmuc['category_name'] ?></option>

                                <?php
                                }
                            }
                                ?>
                            </select><br>

                            <input type="submit" name="capnhatsanpham" value="Cập nhật sản phẩm" class="btn btn-success">
                        </form>
                    
                </div>  

                <?php 
                    }else {
                ?>
                    <div class="col-md-4">
                            <h4>Thêm sản phẩm</h4>
                    <form action="" method="POST" enctype="multipart/form-data">
                        <label>Tên sản phẩm:</label>
                        <input type="text" name="tensanpham" class="form-control" placeholder="Nhập tên sản phẩm">
                        <label for="">Hình ảnh:</label>
                        <input type="file" name="hinhanh" id="" class="form-control">
                        <label>Giá sản phẩm:</label>
                        <input type="text" name="giasanpham" class="form-control" placeholder="Nhập giá">
                        <label>Giá khuyến mãi:</label>
                        <input type="text" name="giakhuyenmai" class="form-control" placeholder="Nhập giá khuyến mãi">
                        <label>Số lượng:</label>
                        <input type="text" name="soluong" class="form-control" placeholder="Nhập số lượng">
                        <label>Mô tả:</label>
                        <textarea name="mota" id="" cols="30" rows="5" class="form-control"></textarea>
                        <label>Chi tiết:</label>
                        <textarea name="chitiet" id="" cols="30" rows="5" class="form-control"></textarea>                        
                        <label>Danh mục sản phẩm:</label>
                        <?php
                            $sql_danhmuc = mysqli_query($connect,"SELECT * FROM tbl_category ORDER BY category_id DESC");
                        ?>
                        <select name="danhmuc" class="form-control">
                            <option value="0" selected>----Chọn danh mục-----</option>
                            <?php
                            while ($row_danhmuc = mysqli_fetch_array($sql_danhmuc)) {
                            ?>
                            <option value="<?php echo $row_danhmuc['category_id']?>" ><?php echo $row_danhmuc['category_name'] ?></option>

                            <?php
                            }
                            ?>
                        </select>

                        <input type="submit" name="themsanpham" value="Thêm sản phẩm" class="btn btn-success">
                    </form>
                    
                </div>  
            <?php 
                    }
            ?>


                <div class="col-md-8">
                    <h4>Danh sách sản phẩm</h4> 
                    <?php
                        
                        $sql_select_sanpham = mysqli_query($connect,"SELECT * FROM tbl_sanpham,tbl_category WHERE tbl_sanpham.category_id = tbl_category.category_id ORDER BY tbl_sanpham.sanpham_id DESC");
                        
                    ?>
                    <table class="table table-striped">
                    <thead>
                        <tr>
                            <th scope="col">Thứ tự</th>
                            <th scope="col">Tên sản phẩm</th>
                            <th scope="col">Hình ảnh</th>
                            <th scope="col">Số lượng</th>
                            <th scope="col">Danh mục sản phẩm</th>
                            <th scope="col">Giá sản phẩm</th>
                            <th scope="col">Giá khuyến mãi</th>
                            <th scope="col">Quản lý</th>
                        </tr>
                    </thead>
                    <?php
                            $i = 0;
                            while ($row_sanpham = mysqli_fetch_array($sql_select_sanpham)) {
                                $i++;
                                ?>
                    <tbody>
                            <t>
                            <th scope="row"><?php echo $i ?></th>
                            <td><?php echo $row_sanpham['sanpham_name'] ?></td>
                            <td><img src="../images/<?php echo $row_sanpham['sanpham_hinhanh'] ?>" alt="" width="100" height="100"></td>
                            <td><?php echo $row_sanpham['sanpham_soluong'] ?></td>
                            <td><?php echo $row_sanpham['category_name'] ?></td>
                            <td><?php echo number_format($row_sanpham['sanpham_gia']).'vnđ' ?></td>
                            <td><?php echo number_format($row_sanpham['sanpham_giakhuyenmai']).'vnđ' ?></td>
                            <td><a href="?xoa=<?php echo $row_sanpham['sanpham_id'] ?>" >Xóa</a><br> <a href="xulysanpham.php?quanly=capnhat&capnhat_id=<?php echo $row_sanpham['sanpham_id'] ?>">Cập nhật</a></td>

                            </t>
                    </tbody>
                        <?php
                            }
                        ?>
                    </table>

                </div>

            </div>
    







    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
</body>
</html>