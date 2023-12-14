<?php
    include('../db/connect.php');
?>

<?php //insert module
    if(isset($_POST['thembaiviet'])) {
        $tenbaiviet = $_POST['tenbaiviet'];
        $tomtat = $_POST['tomtat'];
        $noidung = $_POST['noidung'];
        $hinhanh = $_FILES['hinhanh']['name'];
        $danhmuc = $_POST['danhmuc'];

        // handle upload file img
        $path = '../images/';
        $hinhanh_tmp = $_FILES['hinhanh']['tmp_name']; // variable tmp_name
        move_uploaded_file($hinhanh_tmp, $path.$hinhanh);

        $sql_insert_baiviet = mysqli_query($connect,"INSERT INTO tbl_baiviet(tenbaiviet,tomtat,noidung,baiviet_image,danhmuctin_id) VALUES('$tenbaiviet','$tomtat','$noidung','$hinhanh','$danhmuc')");
        echo "<script language=javascript>
            alert('Đã thêm thành công');
        </script>";
    }

?>

<?php //update module
    if(isset($_POST['capnhatbaiviet'])) {
        $id_update = $_POST['id_update'];
        $tenbaiviet = $_POST['tenbaiviet'];
        $tomtat = $_POST['tomtat'];
        $noidung = $_POST['noidung'];
        $hinhanh = $_FILES['hinhanh']['name'];
        $danhmuc = $_POST['danhmuc'];

         // handle upload file img
         $path = '../images/';
         $hinhanh_tmp = $_FILES['hinhanh']['tmp_name']; // variable tmp_name

        //check image or no image
        if($hinhanh=='') {
            $sql_update_image = "UPDATE tbl_baiviet SET tenbaiviet = '$tenbaiviet',tomtat = '$tomtat',noidung = '$noidung',danhmuctin_id = '$danhmuc'WHERE baiviet_id = '$id_update'";

        }else{
            move_uploaded_file($hinhanh_tmp, $path.$hinhanh);
            $sql_update_image = "UPDATE tbl_baiviet SET tenbaiviet = '$tenbaiviet',tomtat = '$tomtat',noidung = '$noidung',baiviet_image = '$hinhanh',danhmuctin_id = '$danhmuc'WHERE baiviet_id = '$id_update'";

        }
        // câu lênh thực hiện database
        mysqli_query($connect,$sql_update_image);

    }


?>

<?php
    if(isset($_GET['xoa'])) {
        $id = $_GET['xoa'];
        $sql_delete_baiviet = mysqli_query($connect,"DELETE FROM tbl_baiviet WHERE baiviet_id = '$id'");
        header('location: xulybaiviet.php');
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

    <!-- body -->
        <div class="row">
            <?php
                if(isset($_GET['quanly']) == 'capnhat') {
                    $id_capnhat = $_GET['capnhat_id'];
                    $sql_capnhat = mysqli_query($connect,"SElECT * FROM tbl_baiviet WHERE baiviet_id = '$id_capnhat'");
                    $row_capnhat = mysqli_fetch_array($sql_capnhat);
                    $id_danhmuctin = $row_capnhat['danhmuctin_id'];

            ?>
                <div class="col-md-4">
                            <h4>Cập nhật chi tiết bài viết</h4><br>
                            <form action="" method="POST" enctype="multipart/form-data">
                                <label>Tên bài viết:</label>
                                <input type="text" name="tenbaiviet" class="form-control" value="<?php echo $row_capnhat['tenbaiviet'] ?>">
                                <input type="hidden" name="id_update" class="form-control" value="<?php echo $row_capnhat['baiviet_id']?>">
                                
                                <br>
                                <label>Mô tả bài viết:</label>
                                <textarea name="tomtat" cols="30" class="form-control"  rows="10"><?php echo $row_capnhat['tomtat'] ?> </textarea>
                                <br>
                                <label>Nội dung bài viết:</label>
                                <textarea name="noidung" cols="30" class="form-control"  rows="10"><?php echo $row_capnhat['noidung'] ?></textarea>
                                <br>
                                <label>Hình ảnh:</label>
                                <img src="../images/<?php echo $row_capnhat['baiviet_image'] ?>" width="100" alt="">
                                <input type="file" name="hinhanh" class="form-control" >
                                <br>
                                <label>Danh mục:</label>
                                <?php
                                    $sql_select_danhmuctin = mysqli_query($connect,"SELECT * FROM tbl_danhmuctin ORDER BY danhmuctin_id ASC");
                                ?>
                                <select name="danhmuc" class="form-control" id="">
                                <?php
                                    while($row_select_danhmuctin = mysqli_fetch_array($sql_select_danhmuctin)) {
                                        if($id_danhmuctin == $row_select_danhmuctin['danhmuctin_id']){
                                ?>
                                    <option selected value="<?php echo $row_select_danhmuctin['danhmuctin_id'] ?>"><?php echo $row_select_danhmuctin['tendanhmuc'] ?></option>
                                <?php
                                }else{
                                ?>
                                    <option value="<?php echo $row_select_danhmuctin['danhmuctin_id'] ?>"><?php echo $row_select_danhmuctin['tendanhmuc'] ?></option>

                                <?php
                                    }
                                }
                                ?>
                                </select>
                                <br>
                                <input type="submit" name="capnhatbaiviet" value="Thêm danh mục" class="btn btn-success">
                            </form>
            </div>  

            <?php
                }else{
            ?>

            <div class="col-md-4">
                            <h4>Thêm chi tiết bài viết</h4><br>
                            <form action="" method="POST" enctype="multipart/form-data">
                                <label>Tên bài viết:</label>
                                <input type="text" name="tenbaiviet" class="form-control" placeholder="Nhập tên bài viết tin tức">
                                <br>
                                <label>Mô tả bài viết:</label>
                                <textarea name="tomtat" cols="30" class="form-control" placeholder="Tóm tắt của bài viết" rows="10"></textarea>
                                <br>
                                <label>Nội dung bài viết:</label>
                                <textarea name="noidung" cols="30" class="form-control" placeholder="Nội dung của bài viết" rows="10"></textarea>
                                <br>
                                <label>Hình ảnh:</label>
                                <input type="file" name="hinhanh" class="form-control" >
                                <br>
                                <label>Danh mục:</label>
                                <?php
                                    $sql_select_danhmuctin = mysqli_query($connect,"SELECT * FROM tbl_danhmuctin ORDER BY danhmuctin_id ASC");
                                ?>
                                <select name="danhmuc" class="form-control" id="">
                                    <option value="0">--Chọn--</option>
                                <?php
                                    while($row_select_danhmuctin = mysqli_fetch_array($sql_select_danhmuctin)) {
                                ?>
                                    <option value="<?php echo $row_select_danhmuctin['danhmuctin_id'] ?>"><?php echo $row_select_danhmuctin['tendanhmuc'] ?></option>
                                <?php
                                }
                                ?>
                                </select>
                                <br>
                                <input type="submit" name="thembaiviet" value="Thêm danh mục" class="btn btn-success">
                            </form>
            </div>  
            <?php
                }
            ?>
            
                <div class="col-md-8">
                        <h4>Danh sách bài viết</h4>
                        <br>
                        <table class="table">
                            <?php
                                $sql_select_baiviet = mysqli_query($connect,"SELECT * FROM tbl_baiviet,tbl_danhmuctin WHERE tbl_danhmuctin.danhmuctin_id = tbl_baiviet.danhmuctin_id ORDER BY tbl_baiviet.baiviet_id DESC");
                            ?>
                            <thead class="thead-dark">
                                <tr>
                                <th scope="col">Thứ tự</th>
                                <th scope="col">Tên bài viết</th>
                                <th scope="col">Tóm tắt</th>
                                <th scope="col">Nội dung</th>
                                <th scope="col">Hình ảnh</th>
                                <th scope="col">Danh mục</th>
                                <th scope="col">Handle</th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php
                                $i = 0;
                                while ($row_select_baiviet = mysqli_fetch_array($sql_select_baiviet)) {
                                    $i++;
                            ?>
                                <tr>
                                <th scope="row"><?php echo $i ?></th>
                                <td><?php echo $row_select_baiviet['tenbaiviet'] ?></td>
                                <td><?php echo $row_select_baiviet['tomtat'] ?></td>
                                <td><?php echo $row_select_baiviet['noidung'] ?></td>
                                <td>
                                    <img src="../images/<?php echo $row_select_baiviet['baiviet_image'] ?>" alt="" width="100">
                                </td>
                                <td><?php echo $row_select_baiviet['danhmuctin_id'] ?></td>
                                <td>
                                <a href="?xoa=<?php echo $row_select_baiviet['baiviet_id'] ?>" class="btn btn-warning" >Xóa</a>
                                <br>
                                <br> 
                                <a href="xulybaiviet.php?quanly=capnhat&capnhat_id=<?php echo $row_select_baiviet['baiviet_id'] ?>" class="btn btn-success">Cập nhật</a>

                                </td>
                                </tr>
                            <?php
                                }
                            ?>
                            </tbody>
                            </table>

                    </table>
                        

                    </div>
                </div>
    

    

    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
</body>
</html>