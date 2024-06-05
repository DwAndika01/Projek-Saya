<?php
if(isset($_POST['pelanggan_id'])){
    $pelanggan_id = $_POST['pelanggan_id'];
    $produk = $_POST['produk'];
    $total = 0;
    $tanggal = date('y/m/d');



    $query = mysqli_query($koneksi, "INSERT INTO penjualan(tanggal_penjualan, pelanggan_id) VALUES('$tanggal', '$pelanggan_id')");

    $idTerakhir = mysqli_fetch_array(mysqli_query($koneksi, "SELECT*FROM penjualan ORDER BY penjualan_id DESC"));
    $penjualan_id = $idTerakhir['penjualan_id'];

    foreach($produk as $key=>$val){
        $pr = mysqli_fetch_array(mysqli_query($koneksi, "SELECT*FROM produk WHERE produk_id=$key"));

        if($val > 0){
        $sub = $val * $pr['harga'];
        $total += $sub;
        $query = mysqli_query($koneksi, "INSERT INTO detailpenjualan(penjualan_id, produk_id, jumlah_produk, subtotal) VALUES('$penjualan_id', '$key', '$val', '$sub')");

        $updateProduk = mysqli_query($koneksi, "UPDATE produk set stok=stok-$val WHERE produk_id=$key");
        }
    }

    $query = mysqli_query($koneksi, "UPDATE penjualan SET total_harga=$total WHERE penjualan_id=$penjualan_id");




    if($query){
        echo '<script>alert("Tambah Data Berhasil")</script>';
    }
    else{
        echo '<script>alert("Tambah Data Gagal")</script>';
    }
}

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
                                        <select class="form-control form-select" name="pelanggan_id">
                                        <?php
                                        $p = mysqli_query($koneksi, "SELECT*FROM pelanggan");
                                        while($pel = mysqli_fetch_array($p)) {
                                            ?>
                                            <option value="<?php echo $pel['pelanggan_id']; ?>"><?php echo $pel['nama_pelanggan']; ?></option>
                                            <?php
                                        }

                                        ?>
                                        </select>
                                    </td>
                                </tr>
                                <?php
                                 $pro = mysqli_query($koneksi, "SELECT*FROM produk");
                                 while($produk = mysqli_fetch_array($pro)) {
                                ?>
                                <tr>
                                    <td><?php echo $produk['nama_produk'] . ' (stok : '.$produk['stok'].')'; ?></td>
                                    <td>:</td>
                                    <td><input class="form-control" type="number"
                                        step="0" value="0" max="<?php echo $produk['stok']; ?>" name="produk[<?php echo $produk['produk_id']; ?>]">
                                    </td>
                                </tr>
                                <?php
                                 }
                                 ?>
                               
                                <tr>
                                    <td></td>
                                    <td></td>
                                    <td>
                                        <button type="submit" class="btn btn-primary">Simpan</button>
                                        <button type="reset" class="btn btn-danger">Reset</button>
                                    </td>
                                </tr>
                            </table>
                        </form>

                    </div>