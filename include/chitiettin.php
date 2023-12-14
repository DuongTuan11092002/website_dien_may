
<?php
    if(isset($_GET['id_chitiettin'])) {
        $id_chitiettin = $_GET['id_chitiettin'];

    }else{
        $id_chitiettin = '';
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
                        $sql_tenchitiettin = mysqli_query($connect,"SELECT * FROM tbl_baiviet WHERE baiviet_id = '$id_chitiettin'");
                        while($row_tenchitiettin = mysqli_fetch_array($sql_tenchitiettin)){
                    ?>
					<li><?php echo $row_tenchitiettin['tenbaiviet'] ?></li>
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
                        $sql_tenchitiettin = mysqli_query($connect,"SELECT * FROM tbl_baiviet WHERE baiviet_id = '$id_chitiettin'");
                        $row_tenchitiettin = mysqli_fetch_array($sql_tenchitiettin)
            ?>
			<h3 class="tittle-w3l text-center mb-lg-5 mb-sm-4 mb-3 text-uppercase"><?php echo $row_tenchitiettin['tenbaiviet'] ?></h3>
			<!-- //tittle heading -->
            <?php
                    $sql_select_baiviet = mysqli_query($connect,"SELECT * FROM tbl_baiviet WHERE tbl_baiviet.danhmuctin_id = '$id_chitiettin'");
                    while ($row_select_baiviet = mysqli_fetch_array($sql_select_baiviet)) {
                        ?>
                <div class="row">
                    <div class="col-lg-12 welcome-right-top mt-lg-0 mt-sm-5 mt-4">
                        <img src="../images/<?php echo $row_select_baiviet['baiviet_image'] ?>" class="img-fluid" width="100%"  alt=" ">
                    </div>
				<div class="col-lg-12 welcome-left">
                    <h3><?php echo $row_select_baiviet['tenbaiviet']?></h3>
					<h5 class="my-sm-3 my-2 text-justify"><?php echo $row_select_baiviet['tomtat'] ?></h5>
					<h5 class="my-sm-3 my-2 text-justify"><?php echo $row_select_baiviet['noidung'] ?></h5>
					
				</div>
                </div>
                <?php
                }
                ?>
			</div>
		</div>
	</div>
	<!-- //about -->