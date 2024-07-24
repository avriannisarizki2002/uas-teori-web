<?php 
	session_start();
	$koneksi = new mysqli("localhost", "root", "", "tokobuku");

	$id_pembelian = $_GET['id'];

	$ambil = $koneksi->query("SELECT * FROM pembayaran 
		LEFT JOIN pembelian ON pembayaran.id_pembelian=pembelian.id_pembelian 
		WHERE pembelian.id_pembelian='$id_pembelian'");
	$pecah = $ambil->fetch_assoc();

	// jika belum ada data pembayaran
	if (empty($pecah)) {
		echo "<script>alert('Anda Tidak Dapat Mengakses');</script>";
		echo "<script>location='riwayat.php';</script>";
		exit();
	}

	// jika data pelanggan yang bayar dan login tidak sama
	if ($_SESSION['pelanggan']['id_pelanggan'] !== $pecah['id_pelanggan']) {
		echo "<script>alert('Anda Tidak Dapat Mengakses');</script>";
		echo "<script>location='riwayat.php';</script>";
		exit();
	}
?>

<!DOCTYPE html>
<html>
<head>
	<title>Lihat Pembayaran</title>
	<link rel="stylesheet" type="text/css" href="admin/assets/css/bootstrap.css">
</head>
<body>

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
					<!-- Jika Sudah Login-->
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
					<?php if (!isset($_SESSION["keranjang"])): ?>
						<li><a href="keranjang.php">Keranjang<strong>(0)</strong></a></li>
					<?php else: ?>
						<hide>
							<?php $jml = 0; ?>
							<?php foreach ($_SESSION["keranjang"] as $id_produk => $jumlah): ?>
								<!-- Menampilkan Produk Perulangan Berdasarkan id_produk -->
								<?php $ambildata = $koneksi->query("SELECT * FROM produk WHERE id_produk='$id_produk'"); ?>
								<?php $pecah = $ambildata->fetch_assoc(); ?>
								<tr>
									<td><?php $jumlah ?></td>
								</tr>
								<?php $jml += $jumlah; ?>
							<?php endforeach ?>
						</hide>
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

		<?php 
			$koneksi = new mysqli("localhost", "root", "", "hidupsehat");

			$id_pembelian = $_GET['id'];

			$ambil = $koneksi->query("SELECT * FROM pembayaran 
				LEFT JOIN pembelian ON pembayaran.id_pembelian=pembelian.id_pembelian 
				WHERE pembelian.id_pembelian='$id_pembelian'");
			$pecah = $ambil->fetch_assoc();
		?>

		<div class="container">
			<h3>Lihat Pembayaran</h3>
			<div class="row">
				<div class="col-md-6">
					<div class="form-group">
						<table class="table">
							<tr>
								<th>Nama Penyetor</th>
								<td><?php echo $pecah['nama']; ?></td>
							</tr>
							<tr>
								<th>Bank</th>
								<td><?php echo $pecah['bank']; ?></td>
							</tr>
							<tr>
								<th>Tanggal</th>
								<td><?php echo $pecah['tanggal']; ?></td>
							</tr>
							<tr>
								<th>Jumlah</th>
								<td>Rp. <?php echo number_format($pecah['jumlah']); ?></td>
							</tr>
						</table>
					</div>
				</div>
				<div class="col-md-6">
					<img src="bukti_pembayaran/<?php echo $pecah['bukti']; ?>" class="img-responsive">
				</div>
			</div>
		</div>
	</div>

</body>
</html>
