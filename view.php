<?php
session_start();
include("config.php");

//mendapatkan id barang dari url//
$id_barang = $_GET["id"];

//query ambil data
 $getData = $conn-> query("SELECT * FROM barang WHERE id = '$id_barang'");
 $view = $getData->fetch_assoc();

 $id_kategori = $view['id_kategori'];
 $sql_kategori = "SELECT nama FROM kategori WHERE id = '$id_kategori'";
 $query_kategori = $conn->query($sql_kategori);

 if ($query_kategori) {
    $kategori = $query_kategori->fetch_assoc()['nama'];
 }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View</title>

	<script src="https://kit.fontawesome.com/yourcode.js" crossorigin="anonymous"></script>

	<!-- Favicon -->
	<link rel="icon" type="image/png" href="images/favicon.png">
	<!-- Web Font -->
	<link href="https://fonts.googleapis.com/css?family=Poppins:200i,300,300i,400,400i,500,500i,600,600i,700,700i,800,800i,900,900i&display=swap" rel="stylesheet">
	
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
	
    <link rel="stylesheet" href="css/reset.css">
	<link rel="stylesheet" href="style_view.css">
    <link rel="stylesheet" href="css/responsive.css">
	
	
</head>
<body>
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
							</a>
						</div>
						<!--/ End Logo -->
						<div class="mobile-nav"></div>
					</div>
					<div class="col-lg-8 col-md-7 col-12">
					</div>
					<div class="col-lg-2 col-md-3 col-12">
						<nav class="navbar navbar-expand-lg">
							<div class="navbar-collapse">	
								<div class="nav-inner">	
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

	<!--mulai tampil info barang-->
	<section class="sproduct my-5 pt-5">
		<div class="vproduct col-12">
			<img class="image" src="file/<?php echo $view["nama_file"];?>" alt="gambar1">
		</div>
		<div class="col-12 pt-5">
			<div class="name col-md-9">
				<div class="name">
				
					<p style="font-size: 30px;"><?php echo $view["nama"]?></p>
					<p><?php echo $kategori?></p>
				</div>
				<div class="pt-4">
					<h3>Rp<?php echo number_format($view["harga"])?></h3>
				</div>
				<div class="terms">
					<div class="kondisi">
						<div class="ikon">
							<img src="img/Holding Box.svg" alt="">
						</div>
						<div class="ket">
							<p><?php echo $view["kondisi"]?></p>
						</div>
					</div>
					<div class="kondisi">
						<div class="ikon">
							<img src="img/Meeting.svg" alt="">
						</div>
						<div class="ket">
							<p><?php echo $view["metode"]?></p>
						</div>
					</div>
				</div>
				<hr>
				<div>
					<p><?php echo $view["deskripsi"]?> </p>
				</div>
			</div>

			<!--card penawaran-->
			<div class="col-md-3"
				<?php
					if(!isset($_SESSION['username']) || $_SESSION['username'] == $view["username"]){
						echo "style = 'display: none'";
					} else {
						echo "style = 'display: block'";
					}
				?>>
				<div>
					<a href="chat.php">Chat</a>
				</div>
				<div class="pt-3"></div>
				<form method="get" action="proses_ajukan.php">
					<div class="box-1">
						<h5>Ajukan Penawaran!</h5>
						<select name="pilih-barang" id="pilih-barang">
							<option selected disabled value="default">Pilih Barangmu</option>
							<?php
								$username = $_SESSION['username'];
								$sql= "SELECT * FROM barang WHERE username = '$username'";
								$query = mysqli_query($conn,$sql);
								if (mysqli_num_rows($query)>0){
									while ($row = mysqli_fetch_assoc($query)) {
										echo '<option value="' . $row['id'] . '" data-image-src="file/' . $row['nama_file'] . '" data-placeholder="' . number_format($view['harga'] - $row ['harga']) . '">' . $row['nama'] . '</option>';
									}
								}
							?>
						</select>
						<div class="box-1-1">
							<center><img id="selected-image" src="" width="75px" height="75px"></center>
						</div>
						<div class="harga">
							<label>Harga</label>
						</div>
						<div class="harga">
							<input id="placeholder-input" type="text" value="" name="tambah_harga">
						</div>
						<input type="text" name="id_barang1" value="<?= $id_barang ?>" hidden>
        				<input type="submit" class="ajukan" value="Ajukan">
					</div>
				</form>
			</div>
		</div>
	</section>
	
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
	<script>
		const selectElement = document.getElementById('pilih-barang');
		const imageElement = document.getElementById('selected-image');
		const placeholderInput = document.getElementById('placeholder-input');

		selectElement.addEventListener('change', function() {
			const selectedOption = selectElement.options[selectElement.selectedIndex];
			const selectedImageSrc = selectedOption.getAttribute('data-image-src');
			const selectedPlaceholder = parseFloat(selectedOption.getAttribute('data-placeholder'));

			imageElement.src = selectedImageSrc;
			if(selectedPlaceholder <= 0.00){
				placeholderInput.value = 0.00;
			} else {
				placeholderInput.value = selectedPlaceholder;
			}
		});
	</script>
	
</body>
</html>