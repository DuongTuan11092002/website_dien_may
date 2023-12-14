CREATE TABLE `tbl_sanpham` (
  `sanpham_id` int PRIMARY KEY AUTO_INCREMENT,
  `sanpham_name` varchar(255) NOT NULL,
  `sanpham_chitiet` text NOT NULL,
  `sanpham_mota` text NOT NULL,
  `sanpham_gia` varchar(255) NOT NULL,
  `sanpham_giakhuyenmai` varchar(255) NOT NULL,
  `sanpham_active` int NOT NULL,
  `sanpham_hot` int NOT NULL,
  `sanpham_soluong` int NOT NULL,
  `sanpham_hinhanh` varchar(255) NOT NULL,
  `category_id` int NOT NULL
);

CREATE TABLE `tbl_khachhang` (
  `khachhang_id` int PRIMARY KEY AUTO_INCREMENT,
  `khachhang_name` varchar(255) NOT NULL,
  `khachhang_phone` varchar(255) NOT NULL,
  `khachhang_address` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `giaohang` int NOT NULL
);

CREATE TABLE `tbl_category` (
  `category_id` int PRIMARY KEY AUTO_INCREMENT,
  `category_name` varchar(255) NOT NULL
);

CREATE TABLE `tbl_giohang` (
  `giohang_id` int PRIMARY KEY AUTO_INCREMENT,
  `tensanpham` varchar(255) NOT NULL,
  `giasanpham` varchar(255) NOT NULL,
  `hinhanh` varchar(255) NOT NULL,
  `soluong` int NOT NULL,
  `sanpham_id` int NOT NULL
);

CREATE TABLE `tbl_donhang` (
  `donhang_id` int PRIMARY KEY AUTO_INCREMENT,
  `soluong` int NOT NULL,
  `mahang` varchar(255) NOT NULL,
  `ngaythang` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `tinhtrang` int NOT NULL,
  `huydon` int NOT NULL DEFAULT 0,
  `khachhang_id` int NOT NULL,
  `sanpham_id` int NOT NULL
);

CREATE TABLE `tbl_giaodich` (
  `giaodich_id` int PRIMARY KEY AUTO_INCREMENT,
  `soluong` int NOT NULL,
  `magiaodich` varchar(255) NOT NULL,
  `ngaythang` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `tinhtrangdon` int NOT NULL DEFAULT 0,
  `huydon` int NOT NULL DEFAULT 0,
  `sanpham_id` int NOT NULL,
  `khachhang_id` int NOT NULL
);

CREATE TABLE `tbl_admin` (
  `admin_id` int PRIMARY KEY AUTO_INCREMENT,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `admin_name` varchar(255) NOT NULL
);

CREATE TABLE `tbl_slider` (
  `slider_id` int PRIMARY KEY AUTO_INCREMENT,
  `slider_image` varchar(255) NOT NULL,
  `slider_caption` text NOT NULL,
  `slider_active` int NOT NULL DEFAULT 1
);

ALTER TABLE `tbl_giaodich` ADD FOREIGN KEY (`khachhang_id`) REFERENCES `tbl_khachhang` (`khachhang_id`);

ALTER TABLE `tbl_donhang` ADD FOREIGN KEY (`khachhang_id`) REFERENCES `tbl_khachhang` (`khachhang_id`);

ALTER TABLE `tbl_sanpham` ADD FOREIGN KEY (`category_id`) REFERENCES `tbl_category` (`category_id`);

ALTER TABLE `tbl_giohang` ADD FOREIGN KEY (`sanpham_id`) REFERENCES `tbl_sanpham` (`sanpham_id`);

ALTER TABLE `tbl_donhang` ADD FOREIGN KEY (`sanpham_id`) REFERENCES `tbl_sanpham` (`sanpham_id`);

ALTER TABLE `tbl_giaodich` ADD FOREIGN KEY (`sanpham_id`) REFERENCES `tbl_sanpham` (`sanpham_id`);
