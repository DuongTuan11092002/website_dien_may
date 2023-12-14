
<!-- /* -------------------- xử lý về thông tin giỏ hàng post -------------------- */ -->
<?php //module thêm giỏ hàng
	if(isset($_POST['themgiohang'])){
		$tensanpham = $_POST['tensanpham'];
		$sanphamID = $_POST['sanpham_id'];
		$giasanpham = $_POST['giasanpham'];
		$hinhanh = $_POST['hinhanh'];
		$soluong = $_POST['soluong'];
		// phần tăng số lượng sản phẩm
		$sql_select_giohang = mysqli_query($connect,"SELECT * FROM tbl_giohang WHERE sanpham_id = '$sanphamID'");
		$count = mysqli_num_rows($sql_select_giohang);
		if($count > 0) {
			// số lượng tăng
			$row_sanpham = mysqli_fetch_array($sql_select_giohang);
			$soluong = $row_sanpham['soluong'] + 1;
			
			$sql_giohang ="UPDATE tbl_giohang SET soluong = '$soluong' WHERE sanpham_id = '$sanphamID'";
		}else {
			// sô lượng không thay đổi
			$soluong = $soluong;
			$sql_giohang ="INSERT INTO tbl_giohang(tensanpham,giasanpham,hinhanh,soluong,sanpham_id) VALUES('$tensanpham','$giasanpham','$hinhanh','$soluong','$sanphamID')";
		}
		$insert_row = mysqli_query($connect,$sql_giohang);

		if($insert_row == 0) {
            header('location:index.php?quanly=chitietsp&id='.$sanphamID);

		} //update giỏ hàng
			}elseif(isset($_POST['capnhatgiohang'])){

				for($i = 0; $i < count($_POST['product_id']); $i++){
					$sanphamID = $_POST['product_id'][$i];
					$soluong = $_POST['soluong'][$i];

					if($soluong <= 0) {
						$sql_delete = mysqli_query($connect, "DELETE FROM tbl_giohang WHERE sanpham_id = $sanphamID");
					}else{

						$sql_update = mysqli_query($connect, "UPDATE tbl_giohang SET soluong = '$soluong' WHERE sanpham_id = '$sanphamID'");
					}
				}
			}elseif(isset($_GET['xoa'])){ //module xóa sản phẩm trong giỏ hàng
				$id = $_GET['xoa'];
				$sql_delete = mysqli_query($connect, "DELETE FROM tbl_giohang WHERE giohang_id = $id");
			}

?>

<?php
//thêm thông tin khách hàng
	if(isset($_POST['thanhtoan'])){
		$name = $_POST['name'];
		$phone = $_POST['number'];
		$address = $_POST['address'];
		$email = $_POST['email'];
		$password = md5($_POST['password']);
		$giaohang = $_POST['giaohang'];
		$sql_khachhang =mysqli_query($connect,"INSERT INTO tbl_khachhang(khachhang_name,khachhang_phone,khachhang_address,email,password,giaohang) VALUES('$name','$phone','$address','$email','$password','$giaohang')");
		// tạo hóa đơn
		if($sql_khachhang){
			$sql_select_khachhang = mysqli_query($connect,"SELECT * FROM tbl_khachhang ORDER BY khachhang_id DESC LIMIT 1");
			$mahang = rand(0,99999);  //mã hóa đơn random
			$row_khachhang = mysqli_fetch_array($sql_select_khachhang);
			$khachhang_id = $row_khachhang['khachhang_id'];
			$_SESSION['dangnhap_home'] = $row_khachhang['khachhang_name']; // insert khách hàng account
			// cho vòng lặp chạy đơn hàng theo mã sản phẩm
			for($i = 0; $i < count($_POST['thanhtoan_product_id']); $i++){
				$sanphamID = $_POST['thanhtoan_product_id'][$i];
				$soluong = $_POST['thanhtoan_soluong'][$i];	
				$sql_donhang =mysqli_query($connect,"INSERT INTO tbl_donhang(soluong,mahang,khachhang_id,sanpham_id) VALUES('$soluong','$mahang','$khachhang_id','$sanphamID')"); // đơn hàng
				$sql_giaodich = mysqli_query($connect,"INSERT INTO tbl_giaodich(sanpham_id,soluong,magiaodich,khachhang_id) Values ('$sanphamID','$soluong','$mahang','$khachhang_id')");
				// auto xóa sản phẩm
				$sql_delete_thanhtoan = mysqli_query($connect, "DELETE FROM tbl_giohang WHERE sanpham_id = '$sanphamID'");
				
			}
		}
	}

?>

<?php
	if(isset($_POST['thanhtoangiohang'])) {
	 // module thanh toán
		$khachhang_id  = $_SESSION['khachhang_id'];
	 // tạo hóa đơn
		$mahang = rand(0,99999);  //mã hóa đơn random
		// cho vòng lặp chạy đơn hàng theo mã sản phẩm
		for($i = 0; $i < count($_POST['thanhtoan_product_id']); $i++){
			$sanphamID = $_POST['thanhtoan_product_id'][$i];
			$soluong = $_POST['thanhtoan_soluong'][$i];	
			$sql_donhang =mysqli_query($connect,"INSERT INTO tbl_donhang(soluong,mahang,khachhang_id,sanpham_id) VALUES('$soluong','$mahang','$khachhang_id','$sanphamID')");
			$sql_giaodich = mysqli_query($connect,"INSERT INTO tbl_giaodich(sanpham_id,soluong,magiaodich,khachhang_id) Values ('$sanphamID','$soluong','$mahang','$khachhang_id')");
			// auto xóa sản phẩm
			$sql_delete_thanhtoan = mysqli_query($connect, "DELETE FROM tbl_giohang WHERE sanpham_id = '$sanphamID'");
			
		}
}


?>



<?php //module log out accounts
		if(isset($_GET['dangxuat'])){
			$id = $_GET['dangxuat'];
			if($id == 1){

				unset($_SESSION['dangnhap_home']);
			}
		}
?>


    <!-- checkout page -->
	<div class="privacy py-sm-5 py-4">
		<div class="container py-xl-4 py-lg-2">
			<!-- tittle heading -->
			<h3 class="tittle-w3l text-center mb-lg-5 mb-sm-4 mb-3">
				<span>G</span>iỏ hàng của bạn
			</h3>
			<?php
                    $sql_lay_giohang = mysqli_query($connect,"SELECT * FROM tbl_giohang ORDER BY giohang_id ASC");

                ?>
				<!-- phần hiện session -->
				<?php
					if(isset($_SESSION['dangnhap_home'])){
						echo '<h5> Xin chào: '.$_SESSION['dangnhap_home']. '<a href="index.php?quanly=giohang&dangxuat=1"> Đăng xuất</a></h5>';
					}else{
						echo '';
					}
				?>
			<!-- /bảng giỏ hàng -->
			<div class="checkout-right">
				
				</h4>
				<div class="table-responsive">
					<form action="" method="POST">
					<table class="timetable_sub">
						<thead>
							<tr>
								<th>Thứ tự.</th>
								<th>Sản phẩm</th>
								<th>Số lượng</th>
								<th>Tên sản phẩm</th>

								<th>Giá</th>
								<th>Giá tổng</th>
								<th>Remove</th>
							</tr>
						</thead>
						<tbody>
                <?php
                    $i = 0; // cho i = 0
					$total = 0;
                    while ($row_lay_giohang = mysqli_fetch_array($sql_lay_giohang)) {
						$subtotal = $row_lay_giohang['soluong'] * $row_lay_giohang['giasanpham']; //tính giá sản phẩm số lượng * giá
						$total += $subtotal; //tổng tiền
                        $i++; // cho i tăng dần khi có sản phẩm
                ?>
							<tr class="rem1">
								<td class="invert"><?php echo $i ?></td> <!-- in ra i thêm số thứ tự sản phẩm= -->
								<td class="invert-image">
									<a href="single.html">
										<img src="images/<?php echo $row_lay_giohang['hinhanh'] ?>" height="100px" alt=" " class="img-responsive">
									</a>
								</td>
								<td class="invert">
									<input type="hidden" name="product_id[]" id="" value="<?php echo $row_lay_giohang['sanpham_id'] ?>">
									<input type="number" min="1" name="soluong[]" id="" value="<?php echo $row_lay_giohang['soluong'] ?>">

								</td>
								<td class="invert"><?php echo $row_lay_giohang['tensanpham']  ?></td>
								<td class="invert"><?php echo number_format($row_lay_giohang['giasanpham']).'vnđ' ?></td>
								<td class="invert"><?php echo number_format($subtotal).'vnđ' ?></td>

								<td class="invert">
									<div class="rem">
										<a href="?quanly=giohang&xoa=<?php echo $row_lay_giohang['giohang_id'] ?>" class="">Xóa</a>
									</div>
								</td>
							</tr>
				<?php
                    }
                ?>

					<tr>
						<td colspan="7">Tổng tiền: <?php echo number_format($total).'vnđ' ?> </td>
					</tr>
					<tr>
						<td colspan="7"><input type="submit" class="btn btn-primary" name="capnhatgiohang" value="Cập nhật giỏ hàng">
						<?php
						$sql_giohang_select = mysqli_query($connect,"SELECT * FROM tbl_giohang");
						$count_giohang_select = mysqli_num_rows($sql_giohang_select);
						if(isset($_SESSION['dangnhap_home']) && $count_giohang_select>0	){ // nếu tồn tại đăng nhập thanh toán
							while ($row_giohang_select = mysqli_fetch_array($sql_giohang_select)){
						?>
							<input type="hidden" name="thanhtoan_product_id[]" id="" value="<?php echo $row_giohang_select['sanpham_id'] ?>">
							<input type="hidden"  name="thanhtoan_soluong[]" id="" value="<?php echo $row_giohang_select['soluong'] ?>">
						<?php
							}
						?>
						<input type="submit" class="btn btn-success" name="thanhtoangiohang" value="Thanh toán giỏ hàng">
						<?php
						}
						?>

						</td>
					</tr>
						</tbody>
					</table>
					</form>
				</div>
			</div>
			<?php
				if(!isset($_SESSION['dangnhap_home'])){ // ẩn mấy form còn không có đăng nhập để để cho người dùng tự nhập
			?>
			<div class="checkout-left">
				<div class="address_form_agile mt-sm-5 mt-4">
					<h4 class="mb-sm-4 mb-3 text-uppercase">Thêm địa chỉ giao hàng</h4>
					<form action="" method="post" class="creditly-card-form agileinfo_form">
						<div class="creditly-wrapper wthree, w3_agileits_wrapper">
							<div class="information-wrapper">
								<div class="first-row">
									<div class="controls form-group">
										<input class="billing-address-name form-control" type="text" name="name" placeholder="Họ và tên" required="">
									</div>
									<div class="w3_agileits_card_number_grids">
										<div class="w3_agileits_card_number_grid_left form-group">
											<div class="controls">
												<input type="text" class="form-control" placeholder="Số điện thoại" name="number" required="">
											</div>
										</div>
										<div class="w3_agileits_card_number_grid_right form-group">
											<div class="controls">
												<input type="text" class="form-control" placeholder="Địa chỉ " name="address" required="">
											</div>
										</div>
									</div>
									<div class="controls form-group">
										<input type="email" class="form-control" placeholder="Email" name="email" required="">
									</div>
									<div class="controls form-group">
										<input type="password" class="form-control" placeholder="Nhập mật khẩu" name="password" required="">
									</div>
									<div class="controls form-group">
										<textarea  style="resize:none;" class="form-control" placeholder="Ghi chú" name="note" id=""></textarea>
									
									</div>
									<div class="controls form-group">
										<select class="option-w3ls" name="giaohang">
											<option>Chọn hình thức giao hàng</option>
											<option value="1">Thanh toán ATM</option>
											<option value="0">Trả tiền mặt khi nhận hàng</option>

										</select>
									</div>
								</div>
								<?php 
									$sql_get_giohang = mysqli_query($connect,"SELECT * FROM tbl_giohang ORDER BY giohang_id DESC");
									while($row_thanhtoan = mysqli_fetch_array($sql_get_giohang)) {
								?>
										<input type="hidden" name="thanhtoan_product_id[]" id="" value="<?php echo $row_thanhtoan['sanpham_id'] ?>">
										<input type="hidden"  name="thanhtoan_soluong[]" id="" value="<?php echo $row_thanhtoan['soluong'] ?>">


								<?php 
									}
								?>
								<input type="submit" name="thanhtoan" class="btn btn-success" style="width:20%;" value="Gửi" ></input>

								
							</div>
						</div>
					</form>
					
				</div>
			</div>
			<?php
				}
			?>
		</div>
	</div>
	<!-- //checkout page -->