<?php
    include ('../db/connect.php'); //connect to database
?>

<?php //module xử lý or chưa xử lý
    if(isset($_POST['capnhatdonhang'])) {
        $xuly = $_POST['xuly'];
        $mahang = $_POST['mahang_xuly'];
        $sql_update_mahang = mysqli_query($connect,"UPDATE tbl_donhang SET tinhtrang = '$xuly' WHERE mahang = '$mahang'"); //update tinh trang đơn hàng
        $sql_update_giaodich = mysqli_query($connect,"UPDATE tbl_giaodich SET tinhtrangdon = '$xuly' WHERE magiaodich = '$mahang'"); //update tinh trang đơn giao dịch

    }
?>

<?php //module xóa đơn hàng
    if(isset($_GET['xoadonhang'])) {
        $mahang = $_GET['xoadonhang'];
        $sql_delete_mahang = mysqli_query($connect,"DELETE FROM tbl_donhang WHERE mahang = '$mahang'");
        echo "<script language=javascript>
        alert('Xoá đơn hàng thành công');
        </script>";
        header('localhost:xulydonhang.php');
    }
?>

<?php //module xác nhận đơn hủy
     if(isset($_GET['xacnhanhuy'])&& isset($_GET['mahang'])){
        $huydon = $_GET['xacnhanhuy'];
        $magiaodich = $_GET['mahang'];
    }else{
        $huydon = '';
        $magiaodich = '';
    }
    $sql_update_huydonhang = mysqli_query($connect,"UPDATE tbl_donhang SET huydon = '$huydon' WHERE mahang = '$magiaodich'"); //update huỷ   đơn hàng
    $sql_update_huydon_giaodich = mysqli_query($connect,"UPDATE tbl_giaodich SET huydon = '$huydon' WHERE magiaodich = '$magiaodich'"); //update huỷ đơn  giao dịch


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
   
        
          <div class="row">

                <?php //module handle watch đơn hàng
                if(isset($_GET['quanly']) == 'xemdonhang'){
                    $mahang = $_GET['mahang'];
                    $sql_chitietdonhang = mysqli_query($connect,"SELECT * FROM tbl_donhang, tbl_sanpham WHERE tbl_donhang.sanpham_id = tbl_sanpham.sanpham_id AND tbl_donhang.mahang ='$mahang'");
                
                ?>
                <div class="col-md-6">
                    <h4 class="text-center text-uppercase">Xem chi tiết đơn hàng</h4>
                    <form action="" method="post">
                    <table class="table table-striped">
                    <thead>
                        <tr>
                        <th scope="col">Thứ tự</th>
                        <th scope="col">Mã hàng</th>
                        <th scope="col">Tên sản phẩm</th>
                        <th scope="col">Số lượng</th>
                        <th scope="col">Giá</th>
                        <th scope="col">Giá khuyến mãi</th>
                        <th scope="col">Tổng tiền</th>  
                        <th scope="col">Ngày đặt</th>


                        </tr>
                    </thead>
                    <tbody>
                    <?php
                        $i = 0;
                        while($row_chitietdonhang = mysqli_fetch_array($sql_chitietdonhang)){

                            $i++;
                    ?>
                        <tr>
                        <th scope="row"><?php echo $i ?></th>
                        <td><?php echo $row_chitietdonhang['mahang'] ?></td>
                        <td><?php echo $row_chitietdonhang['sanpham_name'] ?></td>
                        <td><?php echo $row_chitietdonhang['soluong'] ?></td>
                        <td><?php echo number_format($row_chitietdonhang['sanpham_gia']).' vnđ' ?></td>
                        <td><?php echo number_format($row_chitietdonhang['sanpham_giakhuyenmai']).' vnđ' ?></td>
                        <td><?php echo number_format( $row_chitietdonhang['soluong'] * $row_chitietdonhang['sanpham_giakhuyenmai']).' vnđ' ?></td>

                        <td><?php echo $row_chitietdonhang['ngaythang'] ?></td>
                        <input type="hidden" name="mahang_xuly" value="<?php echo $row_chitietdonhang['mahang']?>">

    
                        </tr>
                <?php
                            }                
                        
                ?>
                  
                    </tbody>
                </table>
                        <select name="xuly" id="" class="form-control">
                            <option value="1">Đã xử lý || Đang giao hàng</option>
                            <option value="0">Chưa xử lý</option>

                        </select><br>
                        <input type="submit" value="Cập nhật đơn hàng" name="capnhatdonhang" class="btn btn-success">

                </form>
                </div>

                <?php
                    }   
                ?>


                <!-- danh sách đơn hàng -->
                <div class="col-md-6">
                    <h4 class="text-center text-uppercase">Danh sách đơn hàng</h4>
                    <?php
                        //câu lệnh group by để nhóm mã hàng
                        $sql_select_donhang = mysqli_query($connect,"SELECT * FROM tbl_sanpham,tbl_khachhang,tbl_donhang WHERE tbl_donhang.sanpham_id = tbl_sanpham.sanpham_id AND tbl_donhang.khachhang_id = tbl_khachhang.khachhang_id 
                        GROUP BY tbl_donhang.mahang ORDER BY tbl_donhang.donhang_id  DESC");
                    ?>
                    <table class="table table-striped">
                        <thead>
                            <tr>
                            <th scope="col">Thứ tự</th>
                            <th scope="col">Mã hàng</th>
                            <th scope="col">Tên khách hàng</th>
                            <th scope="col">Ngày đặt</th>
                            <th scope="col">Tình trạng đơn hàng</th>
                            <th scope="col">Huỷ đơn</th>
                            <th scope="col">Quản lý</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php
                            $i = 0;
                            while ($row_select_donhang = mysqli_fetch_array($sql_select_donhang)) {
                                $i++;
                        ?>
                            <tr>
                            <th scope="row"><?php echo $i ?></th>
                            <td><?php echo $row_select_donhang['mahang'] ?></td>
                            <td><?php echo $row_select_donhang['khachhang_name'] ?></td>
                            <td><?php echo $row_select_donhang['ngaythang'] ?></td>
                            <td><?php
                                    if($row_select_donhang['tinhtrang'] == 0){
                                        echo "Chưa xử lý";
                                    }else{
                                        echo "Đã xử lý";
                                    }
                            ?></td>
                            <td><?php if($row_select_donhang['huydon'] == 0){

                            }elseif($row_select_donhang['huydon'] == 1){
                                echo '<a href="xulydonhang.php?quanly=xemdonhang&mahang='.$row_select_donhang['mahang'].'&xacnhanhuy=2">Yêu cầu hủy đơn</a>';
                            }else{
                                echo '<p>Đã hủy</p>';
                            }
                            ?></td>
                            
                            <td><a href="?xoadonhang=<?php echo $row_select_donhang['mahang'] ?>" >Xóa</a>   ||   <a href="?quanly=xemdonhang&mahang=<?php echo $row_select_donhang['mahang'] ?>">Xem đơn hàng</a></td>

                            </tr>
                            
                        <?php
                            }
                        ?>
                        </tbody>
                </table>
                </div>
               
                 
        </div>
  




    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
</body>
</html>