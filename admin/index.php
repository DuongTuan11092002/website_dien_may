<?php
    session_start();
    include ("../db/connect.php");

?>
<?php
    if(isset($_POST['dangnhap'])) {
        $taikhoan = $_POST['taikhoan'];
        $matkhau = md5($_POST['matkhau']);

        if($taikhoan == '' || $matkhau == ''){
            echo "<script language=javascript>
                    alert('Vui lòng nhập đủ tài khoản và mật khẩu');
            </script>";
        }else{
            // truy vấn bảng admin
            $sql_select_admin = mysqli_query($connect,"SELECT * FROM tbl_admin WHERE email = '$taikhoan' AND password = '$matkhau' LIMIT 1");
            $count = mysqli_num_rows($sql_select_admin);
            $row_dangnhap = mysqli_fetch_array($sql_select_admin);
            if($count>0){
                $_SESSION['dangnhap'] = $row_dangnhap['admin_name'];
                $_SESSION['admin_id'] = $row_dangnhap['admin_id'];
                echo "<script language=javascript>
                    alert('Chào mùng người quản trị quay trở lại');
                    window.location= 'dashboard.php';

                </script>";

            }else{
                echo "<script language=javascript>
                    alert('Thông tin tài khoản hoặc mặt khẩu sai');
                
                </script>";
            }
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đăng nhập ADMIN</title>
    <!-- boostrap 4 -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
</head>
<body>
    <div class="container">
        <br>
        <br>
        <h1 class="text-center">Đăng nhập</h1>
            <form action="" method="POST">
                <div class="form-group">
                    <label for="exampleInputEmail1">Tài khoản</label>
                    <input type="email" name="taikhoan" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Đăng nhập tài khoản">
                </div>
                <br>    
                <div class="form-group">
                    <label for="exampleInputPassword1">Mật khẩu</label>
                    <input type="password" name="matkhau" class="form-control" id="exampleInputPassword1" placeholder="Password">
                </div>
                
                <input type="submit" name="dangnhap" class="btn btn-primary" value="Đăng nhập">
            </form>
    </div>

    <!-- Script -->
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
</body>
</html>