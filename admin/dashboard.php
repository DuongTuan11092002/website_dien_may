<?php
    session_start();
    include "../db/connect.php";
    if(!isset($_SESSION['dangnhap'])) {
        echo "<script language=javascript>
            alert('Vui lòng đăng nhập ');
            window.location= 'index.php';
        </script>";
    }


    // logout function
    if(isset($_GET['login'])){
        $login = $_GET['login'];
    }else{
        $login = '';
    }

    // if dang xuat == dang xuat is out page
    if($login == 'logout'){
        session_destroy();
        echo "<script language=javascript>
            alert('Xin chào tạm biệt');
            window.location = '../index.php';

        </script>";
    }

?>




<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DASHBOARD ADMIN</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/morris.js/0.5.1/morris.css">
    <link rel="stylesheet" href="../css/fontawesome-all.css">
    <style>
      body {
            background-image: url(../images/TECHSHOP.png);
            background-repeat: no-repeat;
            background-size: conver;
            background-position: center;
            
        }
    </style>

</head>
<body>
    
    <h5>Xin chào : <?php echo $_SESSION['dangnhap'] ?> <a href="?login=logout">Đăng xuất</a></h5>

        <nav class="navbar navbar-expand-lg navbar-light bg-light">
            <a class="navbar-brand" href="#">K&T</a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav">
                 <li class="nav-item ">
                     <a class="nav-link" href="xulydonhang.php">Đơn hàng</a>
                 </li>
                <li class="nav-item">
                    <a class="nav-link" href="xulydanhmuc.php">Danh mục</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="xulysanpham.php">Sản phẩm</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link disabled" href="xulydanhmucbaiviet.php">Danh mục tin tức</a>
            </li>
            <li class="nav-item">
                    <a class="nav-link disabled" href="xulybaiviet.php">Bài viết tin tức</a>
            </li>
                <li class="nav-item">
                    <a class="nav-link disabled" href="xulykhachhang.php">Khách hàng</a>
                </li>
                </ul>
            </div>
        </nav>


    <!-- body -->
    <h1 class="text-center text-uppercase mt-4">Thông kê cửa hàng</h1>

    <div class="m-3 ">
        <div class="row mt-5">
            <?php //module đơn hàng
                //Lấy đơn hàng hiện tại
                $currentMonth = date('m');

                //truy vấn sql
                $sql_tong_donhang = "SELECT COUNT(*) AS tong_donhang FROM tbl_donhang WHERE MONTH(ngaythang) = '$currentMonth'";

                $result = $connect->query($sql_tong_donhang);

                if($result -> num_rows > 0) {
                    $row_tong_donhang = $result->fetch_assoc();
                    $tongdonhang = $row_tong_donhang['tong_donhang'];

            ?>
            <div class="col-sm border border-success rounded bg-success m-3">
            
               <h3 class="text-white p-4">Tổng đơn hàng trong tháng: <?php  echo $tongdonhang ?> <span class="" style="font-style: italic; font-size: 1.6rem;">đơn hàng</span></h3>
            
            </div>
            <?php 
                }
            ?>
             

            <div class="col-sm border border-success m-3 bg-success rounded">
                 <h3 class="text-white p-4"> Tổng đơn hàng trong tháng: 0 </h3> 
            </div>
            
            <?php
                $sql_tong_khachhang = "SELECT COUNT(khachhang_id) as tong_khachhang FROM tbl_khachhang";
                $result_tong_khachhang = $connect -> query($sql_tong_khachhang);

                if($result_tong_khachhang -> num_rows > 0){
                    $row_tong_khachhang = $result_tong_khachhang -> fetch_assoc();
                    $tongkhachhang = $row_tong_khachhang['tong_khachhang'];
                
            ?>
            <div class="col-sm border border-success m-3 bg-success rounded">
            <h3 class="text-light p-4"> Tổng số Khách hàng: <?php echo $tongkhachhang ?> <span class="" style="font-style: italic; font-size: 1.6rem;">khách hàng</span> </h3> 
            </div>
            
            <?php
                }
            ?>

            
        </div>
    </div>

    <div class="m-3 ">
        <div class="row mt-5">
            <div class="col-md-4">
            <?php //module đơn hàng đã xử lý
                //Lấy đơn hàng hiện tại
                $currentMonth = date('m');

                //truy vấn sql
                $sql_tong_donhang_da_xuly = "SELECT COUNT(*) AS tong_donhang_da_xuly FROM tbl_donhang WHERE MONTH(ngaythang) = '$currentMonth' AND tinhtrang = 1";

                $result = $connect->query($sql_tong_donhang_da_xuly);

                if($result -> num_rows > 0) {
                    $row_tong_donhang_da_xuly = $result->fetch_assoc();
                    $tongdonhangdaxuly = $row_tong_donhang_da_xuly['tong_donhang_da_xuly'];

            ?>
                <div class="col-sm border border-success rounded bg-primary ">
                   <h4 class="text-white p-4">Tổng đơn hàng <span class="text-dark">đã xử lý</span>: <?php  echo $tongdonhangdaxuly ?> <span class="" style="font-style: italic; font-size: 1.6rem;">đơn hàng</span></h4>
                
                </div>
            <?php
                }
            ?>
            
            </div>
            
            <div class="col-md-4">

                <!-- <div class="col-sm border border-success  bg-success rounded">
                    <h3 class="text-white p-4"> Tổng đơn hàng trong tháng: 0 </h3> 
                </div> -->
            </div>

            <div class="col-md-4">
                <?php
                     $currentMonth = date('m');
                     $sql_khachhang_mua = "SELECT COUNT(*) AS tong_khachhang_mua FROM tbl_giaodich WHERE MONTH(ngaythang) = '$currentMonth'  GROUP BY khachhang_id,magiaodich ";
                     $result = $connect->query($sql_khachhang_mua);

                     if($result -> num_rows > 0) {
                        $row_khachhang_mua= $result->fetch_assoc();
                        $khachhangmua = $row_khachhang_mua['tong_khachhang_mua'];
     
                ?>
                <div class="col-sm border border-success  bg-success rounded">
                    <h4 class="text-white p-4"> Tổng khách hàng mua trong tháng: <?php echo $khachhangmua ?> </h4> 
                </div>

                <?php
                     }
                ?>
            </div>

            
                
            

            
        </div>
    </div>
    
    
    <div class="m-3 ">
        <div class="row mt-5">
           <div class="col-md-4">
            <?php //module đơn hàng chưa xử lý
                //Lấy đơn hàng hiện tại
                $currentMonth = date('m');

                //truy vấn sql
                $sql_tong_donhang_chua_xuly = "SELECT COUNT(*) AS tong_donhang_chua_xuly FROM tbl_donhang WHERE MONTH(ngaythang) = '$currentMonth' AND tinhtrang = 0";

                $result = $connect->query($sql_tong_donhang_chua_xuly);

                if($result -> num_rows > 0) {
                    $row_tong_donhang_chua_xuly = $result->fetch_assoc();
                    $tongdonhangchuaxuly = $row_tong_donhang_chua_xuly['tong_donhang_chua_xuly'];

            ?>
               <div class="col-sm border border-success rounded bg-warning ">
                  <h4 class="text-white p-4">Số đơn hàng <span class="text-danger">chưa xử lý</span>: <?php  echo $tongdonhangchuaxuly ?> <span class="" style="font-style: italic; font-size: 1.6rem;">đơn hàng</span></h4>
               </div>
            <?php
                }
            ?>

           </div>

           <div class="col-md-4">
                <div class="col-sm border border-success  bg-success rounded">
                 <h3 class="text-white p-4"> Tổng đơn hàng trong tháng: 0 </h3> 
                </div>
           </div>
          
          
            
            

            
        </div>
    </div>
        

    <!-- end-body -->

    <script src="//cdnjs.cloudflare.com/ajax/libs/raphael/2.1.0/raphael-min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/morris.js/0.5.1/morris.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
</body>
</html>