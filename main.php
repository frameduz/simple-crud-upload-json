<?php 

session_start();

define('ASSET', dirname(__FILE__).'/asset/');
define('CRUD', dirname(__FILE__).'/crud/');

function getJSON($file) {
    $file = ASSET.$file.'.json';
    $result = [];
    if (!file_exists($file)) {
        return $result;
    }

    $json = file_get_contents($file);
    $json = json_decode($json, true);
    $result = ($json != null) ? $json : $result;
    return $result;
}

function setJSON($data, $file) {
    $file = ASSET.$file.'.json';
    $json = json_encode($data, JSON_PRETTY_PRINT);
    file_put_contents($file, $json);
}

function getListProduct($page = 1) {
    $product = getJSON('product');
    $total = count($product);
    $limit = 6;
    $cursor = ($page - 1) * $limit;
    $result = array_slice($product, $cursor, $limit);
    return $result;
}

function getFormProduct($id = '') {
    $product = getJSON('product');
    $index = array_search($id, array_column($product, 'productId'));
    if ($index !== false) {
        return array(
            'title' => 'Edit Product',
            'index' => $index,
            'form' => $product[$index]
        );
    }
    else {
        return array(
            'title' => 'Add Product',
            'index' => false,
            'form' => array(
                'productId' => date('YmdHis'),
                'categoryId' => '',
                'productImage' => 'https://via.placeholder.com/300',
                'productName' => '',
                'productPrice' => 0
            )
        );
    }
}

function uploadImage($file) {
    $result = array(
        'status' => false,
        'message' => '',
        'upload' => ''
    );

    if (isset($_FILES[$file]) && !empty($_FILES[$file]['name'])) {
        $fileUpload = $_FILES[$file];
        $fileExtension = pathinfo($fileUpload['name'], PATHINFO_EXTENSION);
        $fileName = date('YmdHis').'.'.$fileExtension;
        $status = move_uploaded_file($fileUpload['tmp_name'], ASSET.'_image/'.$fileName);
        if ($status) {
            $result['status'] = true;
            $result['message'] = 'File berhasil diupload';
            $result['upload'] = 'asset/_image/'.$fileName;
        }
        else {
            $result['message'] = 'File gagal diupload';
        }
    }

    return $result;
}

function deleteImage($file) {
    $fileName = end(explode('/', $file));
    $fileUpload = ASSET.'_image/'.$fileName;
    if (file_exists($fileUpload)) {
        return unlink($fileUpload);
    }

    return false;
}

?>
