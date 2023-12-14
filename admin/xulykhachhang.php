<?php
    include '../db/connect.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Khách hàng</title>
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

        <h1 class="text-center text-uppercase">Danh sách Khách hàng</h1>
        <div class="row">
            <?php 
                $sql_select_khachhang = mysqli_query($connect,"SELECT * FROM tbl_khachhang,tbl_giaodich WHERE tbl_khachhang.khachhang_id = tbl_giaodich.khachhang_id GROUP BY tbl_giaodich.magiaodich ORDER BY tbl_khachhang.khachhang_id DESC");
            ?>
            <div class="col-md-12">
    
                <table class="table table-striped">
                    <thead>
                        <tr>
                        <th scope="col">Thứ tự</th>
                        <th scope="col">Họ và tên</th>
                        <th scope="col">Số điện thoại</th>
                        <th scope="col">Địa chỉ</th>
                        <th scope="col">Email</th>
                        <th scope="col">Ngày đặt</th>
                        <th scope="col">Quản lý</th>

                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $i = 0;
                            while ($row_khachhang = mysqli_fetch_array($sql_select_khachhang)) {
                                    $i++;
                        ?>
                        <tr>
                        <th scope="row"><?php echo $i ?></th>
                        <td><?php echo $row_khachhang['khachhang_name'] ?></td>
                        <td><?php echo $row_khachhang['khachhang_phone'] ?></td>
                        <td><?php echo $row_khachhang['khachhang_address'] ?></td>
                        <td><?php echo $row_khachhang['email'] ?></td>
                        <td><?php echo $row_khachhang['ngaythang'] ?></td>
                        <td><a href="xulykhachhang.php?quanly=xemgiaodich&khachhang=<?php echo $row_khachhang['magiaodich'] ?>">Xem giao dịch</a></td>
                        </tr>
                        <?php
                            }
                        ?>
                    </tbody>
                </table>
            </div>

            <!-- Liệt kê lịch sử -->
            <div class="col-md-12">
                    <h4 class="text-center text-uppercase">Danh sách lịch sử đơn hàng</h4>
                    <?php //module xem lịch sử giao dịch
                        if(isset($_GET['khachhang'])){
                            $magiaodich = $_GET['khachhang'];
                        }else{
                            $magiaodich = '';
                        }
                        $sql_select_giaodich = mysqli_query($connect,"SELECT * FROM tbl_giaodich,tbl_khachhang,tbl_sanpham WHERE tbl_giaodich.sanpham_id = tbl_sanpham.sanpham_id AND tbl_khachhang.khachhang_id = tbl_giaodich.khachhang_id AND tbl_giaodich.magiaodich = '$magiaodich'
                        ORDER BY tbl_giaodich.giaodich_id DESC");
                    ?>
                    <table class="table table-striped">
                        <thead>
                            <tr>
                            <th scope="col">Thứ tự</th>
                            <th scope="col">Mã giao dịch</th>
                            <th scope="col">Tên sản phẩm</th>
                            <th scope="col">Ngày đặt</th>
                            <th scope="col">Quản lý</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php
                            $i = 0;
                            while ($row_select_giaodich = mysqli_fetch_array($sql_select_giaodich)) {   
                                $i++;
                        ?>
                            <tr>
                            <th scope="row"><?php echo $i ?></th>
                            <td><?php echo $row_select_giaodich['magiaodich'] ?></td>
                            <td><?php echo $row_select_giaodich['sanpham_name'] ?></td>
                            <td><?php echo $row_select_giaodich['ngaythang'] ?></td>
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