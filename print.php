<?php 
	@ob_start();
	session_start();
	if(!empty($_SESSION['admin'])){ }else{
		echo '<script>window.location="login.php";</script>';
        exit;
	}
	require 'config.php';
	include $view;
	$lihat = new view($config);
	$toko = $lihat -> toko();
	$hsl = $lihat -> penjualan();
?>
<html>
	<head>
		<title>Struk Penjualan</title>
		<link rel="stylesheet" href="assets/css/bootstrap.css">
		<style>
			body {
				font-family: 'Arial', sans-serif;
				font-size: 12px;
				padding: 10px;
				margin: 0;
				background-color: #f8f9fa;
			}
			.receipt-container {
				max-width: 300px;
				margin: 0 auto;
				background-color: #fff;
				box-shadow: 0 0 10px rgba(0,0,0,0.1);
				padding: 15px;
				border-radius: 5px;
			}
			.store-header {
				text-align: center;
				padding-bottom: 10px;
				border-bottom: 1px dashed #ddd;
				margin-bottom: 10px;
			}
			.store-name {
				font-size: 18px;
				font-weight: bold;
				margin: 5px 0;
			}
			.store-address {
				margin: 5px 0;
			}
			.receipt-info {
				margin: 10px 0;
				font-size: 11px;
			}
			.receipt-table {
				width: 100%;
				border-collapse: collapse;
				margin: 15px 0;
			}
			.receipt-table th, .receipt-table td {
				padding: 6px 4px;
				text-align: left;
				border-bottom: 1px solid #eee;
			}
			.receipt-table th {
				font-weight: bold;
			}
			.receipt-total {
				margin-top: 10px;
				text-align: right;
				border-top: 1px dashed #ddd;
				padding-top: 10px;
			}
			.total-value {
				font-weight: bold;
			}
			.receipt-footer {
				text-align: center;
				margin-top: 15px;
				padding-top: 10px;
				border-top: 1px dashed #ddd;
				font-style: italic;
			}
			.logo {
				text-align: center;
				margin-bottom: 10px;
			}
			.receipt-title {
				text-align: center;
				font-weight: bold;
				margin: 10px 0;
				font-size: 14px;
			}
		</style>
	</head>
	<body>
		<script>window.print();</script>
		<div class="receipt-container">
			<div class="store-header">
				<p class="store-name"><?php echo $toko['nama_toko'];?></p>
				<p class="store-address"><?php echo $toko['alamat_toko'];?></p>
			</div>
			
			<div class="receipt-title">STRUK PENJUALAN</div>
			
			<div class="receipt-info">
				<table style="width: 100%;">
					<tr>
						<td>Tanggal</td>
						<td>: <?php echo date("j F Y, G:i");?></td>
					</tr>
					<tr>
						<td>Kasir</td>
						<td>: <?php echo htmlentities($_GET['nm_member']);?></td>
					</tr>
				</table>
			</div>
			
			<table class="receipt-table">
				<thead>
					<tr>
						<th style="width: 10%;">No</th>
						<th style="width: 40%;">Barang</th>
						<th style="width: 20%;">Qty</th>
						<th style="width: 30%; text-align: right;">Total</th>
					</tr>
				</thead>
				<tbody>
					<?php $no=1; foreach($hsl as $isi){?>
					<tr>
						<td><?php echo $no;?></td>
						<td><?php echo $isi['nama_barang'];?></td>
						<td><?php echo $isi['jumlah'];?></td>
						<td style="text-align: right;">Rp<?php echo number_format($isi['total']);?></td>
					</tr>
					<?php $no++; }?>
				</tbody>
			</table>
			
			<div class="receipt-total">
				<?php $hasil = $lihat -> jumlah(); ?>
				<table style="width: 100%;">
					<tr>
						<td style="text-align: right;">Total</td>
						<td style="text-align: right; width: 50%;" class="total-value">Rp<?php echo number_format($hasil['bayar']);?>,-</td>
					</tr>
					<tr>
						<td style="text-align: right;">Bayar</td>
						<td style="text-align: right;">Rp<?php echo number_format(htmlentities($_GET['bayar']));?>,-</td>
					</tr>
					<tr>
						<td style="text-align: right;">Kembali</td>
						<td style="text-align: right;">Rp<?php echo number_format(htmlentities($_GET['kembali']));?>,-</td>
					</tr>
				</table>
			</div>
			
			<div class="receipt-footer">
				<p>Terima Kasih Telah Berbelanja di Toko Kami!</p>
				<p>Barang yang sudah dibeli tidak dapat ditukar kembali</p>
			</div>
		</div>
	</body>
</html>