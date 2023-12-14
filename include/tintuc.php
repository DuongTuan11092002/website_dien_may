<?php
    if(isset($_GET['id_tintuc'])) {
        $id_tintuc = $_GET['id_tintuc'];

    }else{
        $id_tintuc = '';
    }

?>

<!-- page -->
<div class="services-breadcrumb">
		<div class="agile_inner_breadcrumb">
			<div class="container">
				<ul class="w3_short">
					<li>
						<a href="index.php">Trang chủ</a>
						<i>|</i>
					</li>
                    <?php
                        $sql_tendanhmuctin = mysqli_query($connect,"SELECT * FROM tbl_danhmuctin WHERE danhmuctin_id = '$id_tintuc'");
                      while  ($row_tendanhmuctin = mysqli_fetch_array($sql_tendanhmuctin)){
                    ?>
					<li><?php echo $row_tendanhmuctin['tendanhmuc'] ?></li>
                    <?php
                      }
                    ?>
				</ul>
			</div>
		</div>
	</div>
	<!-- //page -->

	<!-- about -->
	<div class="welcome py-sm-5 py-4">
		<div class="container py-xl-4 py-lg-2">
			<!-- tittle heading -->
            <?php
                $sql_tendanhmuctin = mysqli_query($connect,"SELECT * FROM tbl_danhmuctin WHERE danhmuctin_id = '$id_tintuc'");
                $row_tendanhmuctin = mysqli_fetch_array($sql_tendanhmuctin)
            ?>
			<h3 class="tittle-w3l text-center mb-lg-5 mb-sm-4 mb-3 text-uppercase"><?php echo $row_tendanhmuctin['tendanhmuc'] ?></h3>
			<!-- //tittle heading -->
            <?php
                    $sql_select_baiviet = mysqli_query($connect,"SELECT * FROM tbl_danhmuctin,tbl_baiviet WHERE tbl_danhmuctin.danhmuctin_id = tbl_baiviet.danhmuctin_id AND tbl_danhmuctin.danhmuctin_id = '$id_tintuc'");
                    while ($row_select_baiviet = mysqli_fetch_array($sql_select_baiviet)) {
                        ?>
                <div class="row">
                    <div class="col-lg-5 welcome-right-top mt-lg-0 mt-sm-5 mt-4">
                        <img src="../images/<?php echo $row_select_baiviet['baiviet_image'] ?>" class="img-fluid" width="100%" alt=" ">
                    </div>
				<div class="col-lg-7 welcome-left">
                    <h5><a href="index.php?quanly=chitiettin&id_chitiettin=<?php echo $row_select_baiviet['baiviet_id'] ?>">Xem chi tiết: <?php echo $row_select_baiviet['tenbaiviet']?></a></h5>
					<p class="my-sm-3 my-2"><?php echo $row_select_baiviet['tomtat']  ?></p>
					
				</div>
                </div>
                <?php
                }
                ?>
			</div>
		</div>
	</div>
	<!-- //about -->