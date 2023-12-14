
<!-- top Products -->
<div class="ads-grid py-sm-5 py-4">
		<div class="container py-xl-4 py-lg-2">
			<!-- tittle heading -->
			<h3 class="tittle-w3l text-center mb-lg-5 mb-sm-4 mb-3">
                Xem đơn hàng
                </h3>
			<!-- //tittle heading -->
			<div class="row">
				<!-- product left -->
				<div class="agileinfo-ads-display col-lg-9">
					<div class="wrapper">
						<!-- first section -->
							<div class="row">
                                    <?php
                                        if(isset($_SESSION['dangnhap_home'])){
                                            echo "<h3>Đơn hàng của: ". $_SESSION['dangnhap_home']."</h3>";
                                        }
                                    ?>



                    <!-- section đơn hàng -->
                                <div class="col-md-12">
                                    <br>
                                        <?php //module xem lịch sử giao dịch
                                            if(isset($_GET['khachhang'])){
                                                $id_khachhang = $_GET['khachhang'];
                                            }else{
                                                $id_khachhang = '';
                                            }
                                            $sql_select_giaodich = mysqli_query($connect,"SELECT * FROM tbl_giaodich WHERE tbl_giaodich.khachhang_id = '$id_khachhang'
                                            GROUP BY tbl_giaodich.magiaodich ");
                                        ?>
                                        <table class="table table-striped">
                                            <thead>
                                                <tr>
                                                <th scope="col">Thứ tự</th>
                                                <th scope="col">Mã giao dịch</th>
                                                <th scope="col">Ngày đặt</th>
                                                <th scope="col">Tình trạng</th>
                                                <th scope="col">Quản lý</th>
                                                <th scope="col">Yêu cầu</th>
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
                                                <td><?php echo $row_select_giaodich['ngaythang'] ?></td>
                                                <td><?php if($row_select_giaodich['tinhtrangdon'] == 0){
                                                    echo "Đã đặt hàng";
                                                }else{
                                                    echo "Đã xử lý || Đang giao hàng";
                                                } ?></td>
                                                <td><a class="btn btn-success" href="index.php?quanly=xemdonhang&khachhang=<?php echo $_SESSION['khachhang_id'] ?>&magiaodich=<?php echo $row_select_giaodich['magiaodich'] ?>">Xem chi tiết</a></td>
                                                <td>
                                                    <?php if($row_select_giaodich['huydon'] == 0){ ?>
                                                    <a href="index.php?quanly=xemdonhang&khachhang=<?php echo $_SESSION['khachhang_id'] ?>&magiaodich=<?php echo $row_select_giaodich['magiaodich'] ?>&huydon=1" class="btn btn-warning">Hủy đơn</a></td>
                                                    <?php
                                                    }elseif($row_select_giaodich['huydon'] == 1) {
                                                    ?>
                                                    <p>Chờ xác nhận</p>
                                                    <?php    
                                                    }else{
                                                    ?>
                                                    <span>Đã hủy đơn hàng</span>
                                                    <?php    
                                                    }
                                                    ?>
                                                
                                                <?php // module hủy đơn
                                                    if(isset($_GET['huydon'])&& isset($_GET['magiaodich'])){
                                                        $huydon = $_GET['huydon'];
                                                        $magiaodich = $_GET['magiaodich'];
                                                    }else{
                                                        $huydon = '';
                                                        $magiaodich = '';
                                                    }
                                                    $sql_update_huydonhang = mysqli_query($connect,"UPDATE tbl_donhang SET huydon = '$huydon' WHERE mahang = '$magiaodich'"); //update huỷ   đơn hàng
                                                    $sql_update_huydon_giaodich = mysqli_query($connect,"UPDATE tbl_giaodich SET huydon = '$huydon' WHERE magiaodich = '$magiaodich'"); //update huỷ đơn  giao dịch
                                                ?>
                                                </tr>
                                                
                                            <?php
                                                }
                                            ?>
                                            </tbody>
                                    </table>
                                    </div>
                    <!-- section chi tiết đơn hàng -->
                                    <div class="col-md-12">
                                        <h6 class="text-center text-uppercase">Chi tiết đơn hàng</h6>
                                        <?php //module xem lịch sử giao dịch
                                            if(isset($_GET['magiaodich'])){
                                                $magiaodich = $_GET['magiaodich'];
                                            }else{
                                                $magiaodich = '';
                                            }
                                            $sql_chitietdonhang = mysqli_query($connect,"SELECT * FROM tbl_giaodich,tbl_khachhang,tbl_sanpham WHERE tbl_giaodich.sanpham_id = tbl_sanpham.sanpham_id AND tbl_khachhang.khachhang_id = tbl_giaodich.khachhang_id AND tbl_giaodich.magiaodich = '$magiaodich'
                                            ORDER BY tbl_giaodich.giaodich_id DESC");
                                        ?>
                                        <table class="table table-striped">
                                            <thead>
                                                <tr>
                                                <th scope="col">Thứ tự</th>
                                                <th scope="col">Mã giao dịch</th>
                                                <th scope="col">Tên sản phẩm</th>
                                                <th scope="col">Số lượng</th>
                                                <th scope="col">Ngày đặt</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                            <?php
                                                $i = 0;
                                                while ($row_xemchitietdonhang = mysqli_fetch_array($sql_chitietdonhang)) {   
                                                    $i++;
                                            ?>
                                                <tr>
                                                <th scope="row"><?php echo $i ?></th>
                                                <td><?php echo $row_xemchitietdonhang['magiaodich'] ?></td>
                                                <td><?php echo $row_xemchitietdonhang['sanpham_name'] ?></td>
                                                <td><?php echo $row_xemchitietdonhang['soluong'] ?></td>
                                                <td><?php echo $row_xemchitietdonhang['ngaythang'] ?></td>
                                                </tr>
                                                
                                            <?php
                                                }
                                            ?>
                                            </tbody>
                                        </table>
                                    </div>
                            </div>  
                            </div>  
						</div>
                            
						<!-- //first section -->
					</div>
				</div>
				<!-- //product left -->
			</div>
		</div>
	</div>
	<!-- //top products -->
