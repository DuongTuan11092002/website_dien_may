<?php // session đăng nhập
    if(isset($_POST['dangnhap_home'])) {
        $taikhoan = $_POST['Email_login'];
        $matkhau = md5($_POST['Password_login']);

        if($taikhoan == '' || $matkhau == ''){
            echo "<script language=javascript>
                    alert('Vui lòng Không để trống');
            </script>";
        }else{
            // truy vấn bảng khách hàng
            $sql_select_user = mysqli_query($connect,"SELECT * FROM tbl_khachhang WHERE email = '$taikhoan' AND password = '$matkhau' LIMIT 1");
            $count = mysqli_num_rows($sql_select_user);
            $row_dangnhap = mysqli_fetch_array($sql_select_user);
            if($count>0){
                $_SESSION['dangnhap_home'] = $row_dangnhap['khachhang_name'];
                $_SESSION['khachhang_id'] = $row_dangnhap['khachhang_id'];
                $_SESSION['khachhang_name'] = $row_dangnhap['khachhang_name'];
				header('location: index.php?quanly=giohang');
            }else{
                echo "<script>
                    alert('Thông tin tài khoản hoặc mặt khẩu sai');
                
                </script>";
            }
        }
    }
?>

<!-- top-header -->
<div class="agile-main-top">
		<div class="container-fluid">
			<div class="row main-top-w3l py-2">
				<div class="col-lg-4 header-most-top">
					<p class="text-white text-lg-left text-center">Những khuyến mãi giành cho bạn
						<i class="fas fa-shopping-cart ml-1"></i>
					</p>
				</div>
				<div class="col-lg-8 header-right mt-lg-0 mt-2">
					<!-- header lists -->
					<ul>
						<?php
							if(isset($_SESSION['dangnhap_home'])) {
						?>
						<li class="text-center border-right text-white">
							<a href="index.php?quanly=xemdonhang&khachhang=<?php echo $_SESSION['khachhang_id'] ?>"  data-target="#exampleModal" class="text-white">
							<i class="fas fa-truck mr-2"></i>Xem đơn hàng: </a>
						</li>
						<?php
							}else{

						?>
							<a href="#" data-toggle="modal" data-target="#exampleModal" class="text-white">
						<?php		
							}
						?>
						<li class="text-center border-right text-white">
							<i class="fas fa-phone mr-2"></i> 0911096648
						</li>
						<li class="text-center border-right text-white">
							<a href="#" data-toggle="modal" data-target="#exampleModal" class="text-white">
								<i class="fas fa-sign-in-alt mr-2"></i> Đăng nhập  </a>
						</li>
						<li class="text-center text-white">
							<a href="#" data-toggle="modal" data-target="#exampleModal2" class="text-white">
								<i class="fas fa-sign-out-alt mr-2"></i>Đăng ký </a>
						</li>
						
						<li class="text-center text-white">
							<a href="admin/index.php"  class="text-white">
								<i class="fas fa-sign-out-alt mr-2"></i></a>
						</li>
					</ul>
					<!-- //header lists -->
				</div>
			</div>
		</div>
	</div>


<!-- modals -->
	<!-- log in -->
	<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-hidden="true">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title text-center">Đăng nhập</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">
					<form action="#" method="post">
						<div class="form-group">
							<label class="col-form-label">Tài khoản</label>
							<input type="text" class="form-control" placeholder=" " name="Email_login" required="">
						</div>
						<div class="form-group">
							<label class="col-form-label">Mật khẩu</label>
							<input type="password" class="form-control" placeholder=" " name="Password_login" required="">
						</div>
						<div class="right-w3l">
							<input type="submit" class="form-control" name="dangnhap_home" value="Đăng nhập">
						</div>
						
						<p class="text-center dont-do mt-3">Chưa có tài khoản?
							<a href="#" data-toggle="modal" data-target="#exampleModal2">
								Đăng ký ngay</a>
						</p>
					</form>
				</div>
			</div>
		</div>
	</div>
    <!-- register -----------------------------------------------------======================================================= -->
	<?php //module đăng ký
		if (isset($_POST['dangky'])) {
			$name = $_POST['Name'];
			$email = $_POST['Email'];
			$password = md5($_POST['Password']);
			$phone = $_POST['Phone'];
			$address = $_POST['Address'];
			$giaohang = $_POST['giaohang'];

			//insert when user is registered
			$sql_dangky = mysqli_query($connect,"INSERT INTO tbl_khachhang(khachhang_name,khachhang_phone,khachhang_address,email,password,giaohang) VALUES('$name','$phone','$address','$email','$password','$giaohang')");

			//create session
			$sql_select_khachhang = mysqli_query($connect,"SELECT * FROM tbl_khachhang ORDER BY khachhang_ID DESC LIMIT 1");
			$row_select_khachhang = mysqli_fetch_array($sql_select_khachhang);
			$_SESSION['dangnhap_home'] = $name;
			$_SESSION['khachhang_id'] = $row_select_khachhang['khachhang_id'];
			$_SESSION['khachhang_name'] = $row_select_khachhang['khachhang_name'];


		}
	?>

	<div class="modal fade" id="exampleModal2" tabindex="-1" role="dialog" aria-hidden="true">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title">Đăng ký tài khoản</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">
					<form action="" method="post">
						<div class="form-group">
							<label class="col-form-label">Tên của bạn</label>
							<input type="text" class="form-control" placeholder=" " name="Name" required="">
						</div>
						<div class="form-group">
							<label class="col-form-label">Email</label>
							<input type="email" class="form-control" placeholder=" " name="Email" required="">
						</div>
						<div class="form-group">
							<label class="col-form-label">Mật khẩu</label>
							<input type="password" class="form-control" placeholder=" " name="Password" id="password1" required="">
							<input type="hidden" class="form-control" placeholder=" " value="0" name="giaohang" id="password1" required="">

						</div>
						<div class="form-group">
							<label class="col-form-label">Số điện thoại</label>
							<input type="text" class="form-control" placeholder=" " name="Phone" required="">
						</div>
						<div class="form-group">
							<label class="col-form-label">Địa chỉ</label>
							<input type="text" class="form-control" placeholder=" " name="Address" required="">
						</div>
						<div class="right-w3l">
							<input type="submit" class="form-control" value="Đăng ký" name="dangky">
						</div>
						
					</form>
				</div>
			</div>
		</div>
	</div>
	<!-- //modal -->
	<!-- //top-header -->
    <!-- header-bottom-->
	<div class="header-bot">
		<div class="container">
			<div class="row header-bot_inner_wthreeinfo_header_mid">
				<!-- logo -->
				<div class="col-md-3 logo_agile">
						<a href="index.php" class="font-weight-bold font-italic">
							<img src="images/logoshop.png" alt="" width="80%"  class="img-fluid">
						</a>
				</div>
				<!-- //logo -->
				<!-- header-bot -->
				<div class="col-md-9 header mt-5  ">
					<div class="row">
						<!-- search -->
						<div class="col-12 agileits_search ">
							<form class="form-inline" action="index.php?quanly=timkiem" method="post">
								<input class="form-control mr-sm-2" type="search" name="search_sanpham" placeholder="Tìm kiếm" aria-label="Search" required>
								<button class="btn my-2 my-sm-0" type="submit" name="search">Tìm kiếm</button>
							</form>
						</div>
						<!-- //search -->
					
					</div>
				</div>
			</div>
		</div>
	</div>
	<!-- shop locator (popup) -->
	<!-- //header-bottom -->