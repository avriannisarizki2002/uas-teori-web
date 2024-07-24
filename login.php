<?php 
	session_start();
	$koneksi = new mysqli("localhost", "root", "", "tokobuku");
?>

<!DOCTYPE html>
<html>
<head>
	<title>Halaman Login</title>
	<link rel="stylesheet" type="text/css" href="admin/assets/css/bootstrap.css">
	<link rel="stylesheet" type="text/css" href="css/login.css">

	<!-- Bootstrap -->
	<link href="assets/bootstrap/css/bootstrap.min.css" rel="stylesheet">
	<!-- Custom CSS -->
	<link href="assets/style.css" rel="stylesheet">

	<style>
		#header .headerBackground {
			width: 1520px;
			height: 250px;
			background: url(img/background.jpg);
			background-size: cover; 
		}

		#header {
			background: blue;
			width: 940px;
			height: 240px;
		}

		h1 {
			padding-top: 0px;
		}

		article {
			background-color: white;
		}
	</style>
</head>
<body>
	<div id="container">
		<div id="header">
			<div class="headerBackground">
				<h1><font color="#f8192e"><br><br><b>&nbsp;&nbsp;Nisabook</font><font color="#ffffff"> Store</font></b></h1>
			</div>
		</div>

		<!-- navbar -->
		<nav class="navbar navbar-default" style="background: black;">
			<div class="container" style="background: black;">
				<ul class="nav navbar-nav">
					<!-- Jika Sudah Login -->
					<?php if (isset($_SESSION['pelanggan'])): ?>
						<li><a href="logout.php" onclick="return confirm('Apakah Anda Yakin ?')">Logout</a></li>
						<li><a href="riwayat.php">Riwayat</a></li>
					<!-- Jika Belum Login -->
					<?php else: ?>
						<li><a href="login.php">Login</a></li>
						<li><a href="daftar.php">Daftar</a></li>
					<?php endif ?>				
					<li><a href="index.php">Belanja</a></li>
					<li><a href="rekomendasi.php">Rekomendasi</a></li>
					<?php if (!isset($_SESSION["keranjang"])) : ?>
						<li><a href="keranjang.php">Keranjang<strong>(0)</strong></a></li>
					<?php else : ?>
						<?php $jml = 0; ?>
						<?php foreach ($_SESSION["keranjang"] as $id_produk => $jumlah): ?>
							<?php $ambildata = $koneksi->query("SELECT * FROM produk WHERE id_produk='$id_produk'"); ?>
							<?php $pecah = $ambildata->fetch_assoc(); ?>
							<?php $jml += $jumlah; ?>
						<?php endforeach ?>
						<li><a href="keranjang.php">Keranjang<strong>(<?php echo $jml ?>)</strong></a></li>
					<?php endif ?>
					<li><a href="bayar.php">Pembayaran</a></li>
				</ul>

				<form action="pencarian.php" method="get" class="navbar-form navbar-right">
					<input type="text" name="keyword" class="form-control" placeholder="Pencarian">
					<button class="btn btn-primary">Cari</button>
				</form>
			</div>
		</nav>

		<div class="container" style="background: #BE5C5C;">
			<div class="row">
				<div class="col-md-6">
					<div class="panel panel-default">
						<div class="panel-heading" style="background: #BE5C5C;">
							<h2 class="panel-title">Login</h2>
						</div>
						<div class="panel-body">
							<form method="post">
								<div class="form-group">
									<label>Email</label>
									<input type="email" name="gmail" class="form-control">
								</div>
								<div class="form-group">
									<label>Password</label>
									<input type="password" name="password" class="form-control">
								</div>
								<button class="btn btn-primary" name="login">Login</button>
								<a href="daftar.php"><button class="btn btn-warning" name="daftar">Daftar</button></a>
							</form>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>

	<?php
		if (isset($_POST["login"])) {
			$ambil = $koneksi->query("SELECT * FROM pelanggan WHERE gmail_pelanggan='$_POST[gmail]' AND password_pelanggan='$_POST[password]'");
			$akunyangcocok = $ambil->num_rows;
			if ($akunyangcocok == 1) {
				$_SESSION['pelanggan'] = $ambil->fetch_assoc();
				echo "<script> alert('Login Berhasil'); </script>";
				echo "<script> location='index.php'; </script>";
			} else {
				echo "<script> alert('Login Gagal, Tekan Ok Untuk Coba Lagi'); </script>";
				echo "<script> location='login.php'; </script>";
			}
		}
	?>
</body>
</html>
