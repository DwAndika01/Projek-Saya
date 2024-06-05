<?php

$id = $_GET['id'];
$query = mysqli_query($koneksi, "SELECT*FROM penjualan LEFT JOIN pelanggan on pelanggan.pelanggan_id = penjualan.pelanggan_id WHERE penjualan_id=$id");
$data = mysqli_fetch_array($query);
?>

<div class="container-fluid px-4">
                        <h1 class="mt-4">Pembelian</h1>
                        <ol class="breadcrumb mb-4">
                            <li class="breadcrumb-item active">Pembelian</li>
                        </ol>
                        <a href="?page=pembelian" class="btn btn-danger">Kembali</a>
                        <hr>
                        
                        <form method="post">
                            <table class= "table table-bordered">
                                <tr>
                                    <td width="200">Nama Pelanggan</td>
                                    <td width="1">:</td>
                                    <td>
                                        <?php echo $data['nama_pelanggan']; ?>
                                    </td>
                                </tr>
                                <?php
                                 $pro = mysqli_query($koneksi, "SELECT*FROM detailpenjualan LEFT JOIN produk on produk.produk_id=detailpenjualan.produk_id WHERE penjualan_id=$id");
                                 while($produk = mysqli_fetch_array($pro)) {
                                ?>
                                <tr>
                                    <td><?php echo $produk['nama_produk']; ?></td>
                                    <td>:</td>
                                    <td>
                                        Harga Satuan : <?php echo $produk['harga']; ?><br>
                                        Jumlah : <?php echo $produk['jumlah_produk']; ?><br>
                                        Sub Total : <?php echo $produk['subtotal']; ?>
                                    </td>
                                </tr>
                                <?php
                                 }
                                 ?>
                               
                                <tr>
                                    <td>Total</td>
                                    <td>:</td>
                                    <td><?php echo $data['total_harga']; ?></td>
                                </tr>
                            </table>
                        </form>

                    </div>