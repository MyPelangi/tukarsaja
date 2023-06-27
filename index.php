<?php
    // session dimulai
    session_start();
    include("config.php");

	$sql_kategori = "SELECT * FROM kategori ORDER BY nama ASC";
	$query_kategori = mysqli_query($conn, $sql_kategori);
	if (!$query_kategori) {
		die('Could not get data: ' . mysqli_error($conn));
	}

	if (isset($_GET["id_kategori"])){
		$id_kategori = $_GET["id_kategori"];
		$sql = "SELECT * FROM barang WHERE id_kategori='$id_kategori' ORDER BY id DESC";
	} else {
		$sql = "SELECT * FROM barang ORDER BY id DESC";
	}
	$query = mysqli_query($conn, $sql);

	if (isset($_POST["cari"])){
		$cat_search = $_POST['cat-search'];
		$search = $_POST['search'];
		header("location: index.php?cat-search=$cat_search&search=$search");
	}

	if (isset($_GET['cat-search']) && isset($_GET['search'])){
		$catsearchQuery = $_GET['cat-search'];
		$searchQuery = $_GET['search'];
		if ($catsearchQuery == "Semua") {
			$sql = "SELECT * FROM barang WHERE nama LIKE '%$searchQuery%' ORDER BY id DESC";
		} else {
			$sql = "SELECT * FROM barang WHERE nama LIKE '%$searchQuery%' AND id_kategori = '$catsearchQuery' ORDER BY id DESC";
		}
		$query = mysqli_query($conn, $sql);
	}
?>
<!DOCTYPE html>
<html lang="zxx">
<head>
	<!-- Meta Tag -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name='copyright' content=''>
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<!-- Title Tag  -->
    <title>TukarSaja - E-Commerce Tukar Menukar Barang</title>
	<!-- Favicon -->
	<link rel="icon" type="image/png" href="images/favicon.png">
	<!-- Web Font -->
	<link href="https://fonts.googleapis.com/css?family=Poppins:200i,300,300i,400,400i,500,500i,600,600i,700,700i,800,800i,900,900i&display=swap" rel="stylesheet">
	
	<!-- StyleSheet -->
	
	<!-- Bootstrap -->
	<link rel="stylesheet" href="css/bootstrap.css">
	<!-- Magnific Popup -->
    <link rel="stylesheet" href="css/magnific-popup.min.css">
	<!-- Font Awesome -->
    <link rel="stylesheet" href="css/font-awesome.css">
	<!-- Fancybox -->
	<link rel="stylesheet" href="css/jquery.fancybox.min.css">
	<!-- Themify Icons -->
    <link rel="stylesheet" href="css/themify-icons.css">
	<!-- Nice Select CSS -->
    <link rel="stylesheet" href="css/niceselect.css">
	<!-- Animate CSS -->
    <link rel="stylesheet" href="css/animate.css">
	<!-- Flex Slider CSS -->
    <link rel="stylesheet" href="css/flex-slider.min.css">
	<!-- Owl Carousel -->
    <link rel="stylesheet" href="css/owl-carousel.css">
	<!-- Slicknav -->
    <link rel="stylesheet" href="css/slicknav.min.css">
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
	
	<!-- Eshop StyleSheet -->
	<link rel="stylesheet" href="css/reset.css">
	<link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="css/responsive.css">

	
	
</head>
<body class="js">
	<!-- Header -->
	<header class="header shop">
		<!-- Header Inner -->
		<div class="header-inner">
				<div class="container">
				<div class="row">
					<div class="col-lg-2 col-md-2 col-12">
						<!-- Logo -->
						<div class="logo">
							<a href="index.php">
								<img src="images/logo2.png" class="logo-normal">
								<img src="images/logo.png" class="logo-sticky">
							</a>
						</div>
						<!-- End Logo -->
						<div class="mobile-nav"></div>
					</div>
					<div class="col-lg-8 col-md-7 col-12">
						<div class="search-bar-top">
							<div class="search-bar">
								<form method="POST" style="display: flex; align-items: center;">
									<select name="cat-search">
										<option selected="selected">Semua</option>
										<?php
											while ($row = mysqli_fetch_assoc($query_kategori)) {
												echo '<option value="' . $row['id'] . '">' . $row['nama'] . '</option>';
											}
										?>
									</select>
									<input name="search" placeholder="Cari Produk di sini..." type="text">
									<button class="btnn" name="cari"><i class="ti-search"></i></button>
								</form>
							</div>
						</div>
					</div>
					<div class="col-lg-2 col-md-3 col-12">
						<nav class="navbar navbar-expand-lg">
							<div class="navbar-collapse">	
								<div class="nav-inner"
								<?php
									if(isset($_SESSION['username'])){
										echo "style = 'display: none'";
									} else {
										echo "style = 'display: block'";
									}
								?>>	
									<ul class="nav main-menu menu navbar-nav">
										<li class="active"><a href="register.php">Daftar</a></li>
										<li><a href="login.php">Masuk</a></li>
									</ul>
								</div>
								<div class="nav-inner"
								<?php
									if(isset($_SESSION['username'])){
										echo "style = 'display: block'";
									} else {
										echo "style = 'display: none'";
									}
								?>>	
									<ul class="nav main-menu menu navbar-nav">
										<li class="active">
											<a href="upload.php">
												<img class="colored-icon" src="https://cdn-icons-png.flaticon.com/512/860/860826.png">
											</a>
										</li>
										<li>
											<a href="#">
												<img class="colored-icon" src="https://cdn-icons-png.flaticon.com/512/1077/1077035.png">
											</a>
										</li>
										<li>
											<a href="logout.php">
												<img class="colored-icon" src="https://cdn.icon-icons.com/icons2/2941/PNG/512/logout_icon_183821.png">
											</a>
										</li>
									</ul>
								</div>
							</div>
						</nav>
					</div>
				</div>
				</div>
			</div>
			<!--/ End Header Inner -->
	</header>
	<!--/ End Header -->
	
	<!-- Carousel -->
	<div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
		<ol class="carousel-indicators">
			<li data-target="#carouselExampleIndicators" data-slide-to="0" class="active"></li>
			<li data-target="#carouselExampleIndicators" data-slide-to="1"></li>
			<li data-target="#carouselExampleIndicators" data-slide-to="2"></li>
		</ol>
		<div class="carousel-inner">
			<div class="carousel-item active">
			<img class="d-block w-100" src="images/caroussel-1.png" alt="First slide">
			</div>
			<div class="carousel-item">
			<img class="d-block w-100" src="images/caroussel-2.png" alt="Second slide">
			</div>
			<div class="carousel-item">
			<img class="d-block w-100" src="images/caroussel-3.png" alt="Third slide">
			</div>
		</div>
		<a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
			<span class="carousel-control-prev-icon" aria-hidden="true"></span>
			<span class="sr-only">Previous</span>
		</a>
		<a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
			<span class="carousel-control-next-icon" aria-hidden="true"></span>
			<span class="sr-only">Next</span>
		</a>
	</div>
	<!--/ End Carousel -->

	<!-- Product Style -->
	<section class="product-area shop-sidebar shop section" id="products">
			<div class="container">
				<div class="row">
					<div class="col-lg-3 col-md-4 col-12">
						<div class="shop-sidebar">
							<!-- Single Widget -->
							<div class="single-widget category">
								<h3 class="title">Kategori</h3>
								<ul class="categor-list">
									<?php
										mysqli_data_seek($query_kategori, 0);
										while ($row = mysqli_fetch_assoc($query_kategori)) {
											echo '<li><a href="index.php?id_kategori=' . $row['id'] . '">' . $row['nama'] . '</a></li>';
										}
									?>
								</ul>
							</div>
							<!--/ End Single Widget -->
							<!-- Single Widget -->
							<div class="single-widget recent-post">
								<h3 class="title">Terbaru</h3>
								<!-- Single Post -->
								<?php
									if (mysqli_num_rows($query) > 0) {
										$counter = 0;
										while ($row = mysqli_fetch_assoc($query)) {
											$id_barang = $row['id'];
											$nama = $row['nama'];
											$harga = $row['harga'];
											$foto = $row['foto'];
											$nama_file = $row['nama_file'];
											$ketersediaan = $row['ketersediaan'];
											if ($ketersediaan > 0){
												echo '<div class="single-post first">
														<div class="image">
															<img src="file/'. $nama_file .'">
														</div>
														<div class="content">
															<h5><a href="view.php?id='. $id_barang .'">'. $nama .'</a></h5>
															<p class="price">Rp'. number_format($harga) .'</p>
														</div>
													</div>';
											}
											$counter++;
											if($counter>=3){
												break;
											}
										}
									} else {
										echo "Belum ada barang yang ditawarkan";
									}
								?>
								<!-- End Single Post -->
						</div>
						<!--/ End Single Widget -->
					</div>
				</div>
				<div class="col-lg-9 col-md-8 col-12">
					<div class="row">
						<?php
							if (mysqli_num_rows($query) > 0) {
								mysqli_data_seek($query, 0);
								while ($row = mysqli_fetch_assoc($query)) {
									$id_barang = $row['id'];
									$nama = $row['nama'];
									$harga = $row['harga'];
									$foto = $row['foto'];
									$nama_file = $row['nama_file'];
									$ketersediaan = $row['ketersediaan'];
									if ($ketersediaan > 0){
										echo '<div class="col-lg-4 col-md-6 col-12">
												<div class="single-product">
													<div class="product-img">
														<a href="view.php?id='. $id_barang .'">
															<img class="default-img" src="file/'. $nama_file .'">
															<img class="hover-img" src="file/'. $nama_file .'">
														</a>
														<div class="button-head">
															<div class="product-action">
																<a title="Wishlist" href="#"><i class=" ti-heart "></i><span>Add to Wishlist</span></a>
															</div>
														</div>
													</div>
													<div class="product-content">
														<h3><a href="view.php?id='. $id_barang .'">'. $nama .'</a></h3>
														<div class="product-price">
															<span>Rp'. number_format($harga) .'</span>
														</div>
													</div>
												</div>
											</div>';
									}
								}
							} else {
								echo "Belum ada barang yang ditawarkan";
							}
						?>
					</div>
				</div>
			</div>
		</div>
	</section>
	<!--/ End Product Style 1  -->

	<!-- Start Shop Services Area -->
	<section class="shop-services section home">
		<div class="container">
			<div class="row">
				<div class="col-lg-3 col-md-6 col-12">
					<!-- Start Single Service -->
					<div class="single-service">
						<i class="ti-rocket"></i>
						<h4>Free shipping</h4>
						<p>For Your First Order</p>
					</div>
					<!-- End Single Service -->
				</div>
				<div class="col-lg-3 col-md-6 col-12">
					<!-- Start Single Service -->
					<div class="single-service">
						<i class="ti-reload"></i>
						<h4>Free Return</h4>
						<p>Within 30 days returns</p>
					</div>
					<!-- End Single Service -->
				</div>
				<div class="col-lg-3 col-md-6 col-12">
					<!-- Start Single Service -->
					<div class="single-service">
						<i class="ti-lock"></i>
						<h4>Secure Payment</h4>
						<p>100% secure payment</p>
					</div>
					<!-- End Single Service -->
				</div>
				<div class="col-lg-3 col-md-6 col-12">
					<!-- Start Single Service -->
					<div class="single-service">
						<i class="ti-tag"></i>
						<h4>Best Price</h4>
						<p>Guaranteed price</p>
					</div>
					<!-- End Single Service -->
				</div>
			</div>
		</div>
	</section>
	<!-- End Shop Services Area -->

	<!-- Start Footer Area -->
	<footer class="footer">
		<!-- Footer Top -->
		<div class="footer-top section">
			<div class="container">
				<div class="row">
					<div class="col-lg-5 col-md-6 col-12">
						<!-- Single Widget -->
						<div class="single-footer about">
							<div class="logo">
								<a href="index.html"><img src="images/logo2.png" alt="#"></a>
							</div>
							<p class="text">TukarSaja merupakan sebuah aplikasi E-commerce yang dirancang khusus untuk memfasilitasi proses tukar-menukar barang.</p>
							<p class="call">Got Question? Call us 24/7<span><a href="tel:123456789">087885522787</a></span></p>
						</div>
						<!-- End Single Widget -->
					</div>
					<div class="col-lg-2 col-md-6 col-12">
						<!-- Single Widget -->
						<div class="single-footer links">
							<h4>Kelompok 8</h4>
							<ul>
								<li><a href="https://www.linkedin.com/in/isabelrose/" target="_blank">2110512012</a></li>
								<li><a href="#">2110512020</a></li>
								<li><a href="#">2110512028</a></li>
								<li><a href="#">2110512035</a></li>
								<li><a href="https://www.linkedin.com/in/gracia-hotmauli/" target="_blank">2110512039</a></li>
							</ul>
						</div>
						<!-- End Single Widget -->
					</div>
					<div class="col-lg-2 col-md-6 col-12">
						<!-- Single Widget -->
						<div class="single-footer links">
							<h4>Anggota</h4>
							<ul>
								<li><a href="https://www.linkedin.com/in/isabelrose/" target="_blank">Isabel Rose</a></li>
								<li><a href="#" target="_blank">Khaliza Fania</a></li>
								<li><a href="#" target="_blank">Pelangi Dwi Mawarni</a></li>
								<li><a href="#" target="_blank">Amalia Balqis Qonitah</a></li>
								<li><a href="https://www.linkedin.com/in/gracia-hotmauli/" target="_blank">Gracia Hotmauli</a></li>
							</ul>
						</div>
						<!-- End Single Widget -->
					</div>
					<div class="col-lg-3 col-md-6 col-12">
						<!-- Single Widget -->
						<div class="single-footer social">
							<h4>Informasi Lebih Lanjut</h4>
							<!-- Single Widget -->
							<div class="contact">
								<ul>
									<li>Universitas Pembangunan Veteran Jakarta</li>
									<li>JL. R.S Fatmawati, Pondok Labu</li>
									<li>kosanbalqis12@tukarsaja.com</li>
									<li>087885522787</li>
								</ul>
							</div>
							<!-- End Single Widget -->
							<ul>
								<li><a href="#"><i class="ti-facebook"></i></a></li>
								<li><a href="#"><i class="ti-twitter"></i></a></li>
								<li><a href="#"><i class="ti-flickr"></i></a></li>
								<li><a href="#"><i class="ti-instagram"></i></a></li>
							</ul>
						</div>
						<!-- End Single Widget -->
					</div>
				</div>
			</div>
		</div>
		<!-- End Footer Top -->
		<div class="copyright">
			<div class="container">
				<div class="inner">
					<div class="row">
						<div class="col-lg-6 col-12">
							<div class="left">
								<p>Copyright © 2020 <a href="http://www.wpthemesgrid.com" target="_blank">Wpthemesgrid</a>  -  All Rights Reserved.</p>
							</div>
						</div>
						<div class="col-lg-6 col-12">
							<div class="right">
								<img src="images/payments.png" alt="#">
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</footer>
	<!-- /End Footer Area -->
 
	<!-- Jquery -->
    <script src="js/jquery.min.js"></script>
    <script src="js/jquery-migrate-3.0.0.js"></script>
	<script src="js/jquery-ui.min.js"></script>
	<!-- Popper JS -->
	<script src="js/popper.min.js"></script>
	<!-- Bootstrap JS -->
	<script src="js/bootstrap.min.js"></script>
	<!-- Color JS -->
	<script src="js/colors.js"></script>
	<!-- Slicknav JS -->
	<script src="js/slicknav.min.js"></script>
	<!-- Owl Carousel JS -->
	<script src="js/owl-carousel.js"></script>
	<!-- Magnific Popup JS -->
	<script src="js/magnific-popup.js"></script>
	<!-- Waypoints JS -->
	<script src="js/waypoints.min.js"></script>
	<!-- Countdown JS -->
	<script src="js/finalcountdown.min.js"></script>
	<!-- Nice Select JS -->
	<script src="js/nicesellect.js"></script>
	<!-- Flex Slider JS -->
	<script src="js/flex-slider.js"></script>
	<!-- ScrollUp JS -->
	<script src="js/scrollup.js"></script>
	<!-- Onepage Nav JS -->
	<script src="js/onepage-nav.min.js"></script>
	<!-- Easing JS -->
	<script src="js/easing.js"></script>
	<!-- Active JS -->
	<script src="js/active.js"></script>
	<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
	<script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
</body>
</html>