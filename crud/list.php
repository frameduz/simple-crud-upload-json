<?php 
foreach ($listProduct as $key => $value) {
    echo '<div class="col-md-4">
            <div class="card mb-4 shadow-sm">
                <img src="'.$value['productImage'].'" height="300px" alt="">
                <div class="card-body">
                    <p class="card-text">'.$value['productName'].'</p>
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="btn-group">
                            <a href="#" class="btn btn-sm btn-outline-secondary btn-form" id="'.$value['productId'].'" data-toggle="modal" data-target="#formModal">Edit</a>
                            <a href="crud/index.php?act=delete&id='.$value['productId'].'" onclick="return confirm(\'Yakin data ini akan dihapus ?\') ? true : false;" class="btn btn-sm btn-outline-secondary btn-delete">Hapus</a>
                        </div>
                        <small class="text-muted">Rp. '.number_format($value['productPrice'], 0, ',', '.').'</small>
                    </div>
                </div>
            </div>
        </div>';
}
?>