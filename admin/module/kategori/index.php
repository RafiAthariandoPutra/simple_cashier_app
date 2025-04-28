<?php
// Simpan sebagai index.php (menggantikan yang lama)
?>
<h4>Kategori</h4>
<br />
<?php if(isset($_GET['success'])){?>
<div class="alert alert-success">
    <p>Tambah Data Berhasil !</p>
</div>
<?php }?>
<?php if(isset($_GET['success-edit'])){?>
<div class="alert alert-success">
    <p>Update Data Berhasil !</p>
</div>
<?php }?>
<?php if(isset($_GET['remove'])){?>
<div class="alert alert-danger">
    <p>Hapus Data Berhasil !</p>
</div>
<?php }?>

<!-- Form Tambah Kategori -->
<form method="POST" action="fungsi/tambah/tambah.php?kategori=tambah">
    <table>
        <tr>
            <td style="width:25pc;"><input type="text" class="form-control" required name="kategori"
                    placeholder="Masukan Kategori Barang Baru"></td>
            <td style="padding-left:10px;"><button id="tombol-simpan" class="btn btn-primary"><i class="fa fa-plus"></i>
                    Insert Data</button></td>
        </tr>
    </table>
</form>

<br />
<div class="card card-body">
    <div class="table-responsive">
        <table class="table table-bordered table-striped table-sm" id="example1">
            <thead>
                <tr style="background:#DFF0D8;color:#333;">
                    <th>No.</th>
                    <th>Kategori</th>
                    <th>Tanggal Input</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                $hasil = $lihat -> kategori();
                $no=1;
                foreach($hasil as $isi){
                ?>
                <tr>
                    <td><?php echo $no;?></td>
                    <td><?php echo $isi['nama_kategori'];?></td>
                    <td><?php echo $isi['tgl_input'];?></td>
                    <td>
                        <button class="btn btn-warning edit-kategori" 
                            data-id="<?php echo $isi['id_kategori'];?>" 
                            data-nama="<?php echo $isi['nama_kategori'];?>">
                            Edit
                        </button>
                        <a href="fungsi/hapus/hapus.php?kategori=hapus&id=<?php echo $isi['id_kategori'];?>"
                            onclick="javascript:return confirm('Hapus Data Kategori ?');"><button
                                class="btn btn-danger">Hapus</button></a>
                    </td>
                </tr>
                <?php $no++; }?>
            </tbody>
        </table>
    </div>
</div>

<!-- Modal Edit Kategori -->
<div class="modal fade" id="editKategoriModal" tabindex="-1" role="dialog" aria-labelledby="editKategoriModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editKategoriModalLabel">Edit Kategori</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="formEditKategori">
                <div class="modal-body">
                    <div class="form-group">
                        <label for="edit_kategori">Nama Kategori</label>
                        <input type="text" class="form-control" id="edit_kategori" name="kategori" required>
                        <input type="hidden" id="edit_id" name="id">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- JavaScript untuk Modal dan AJAX -->
<script>
    $(document).ready(function() {
        // Event ketika tombol edit diklik
        $('.edit-kategori').click(function() {
            var id = $(this).data('id');
            var nama = $(this).data('nama');
            
            // Mengisi form edit dengan data yang ada
            $('#edit_id').val(id);
            $('#edit_kategori').val(nama);
            
            // Menampilkan modal
            $('#editKategoriModal').modal('show');
        });
        
        // Menangani submit form edit
        $('#formEditKategori').submit(function(e) {
            e.preventDefault();
            
            $.ajax({
                url: 'fungsi/edit/edit.php?kategori=edit',
                type: 'POST',
                data: $(this).serialize(),
                success: function(response) {
                    // Menutup modal
                    $('#editKategoriModal').modal('hide');
                    
                    // Menampilkan pesan sukses
                    alert('Kategori berhasil diupdate!');
                    
                    // Refresh halaman untuk menampilkan data terbaru
                    location.reload();
                },
                error: function(xhr, status, error) {
                    alert('Terjadi kesalahan: ' + error);
                }
            });
        });
    });
</script>