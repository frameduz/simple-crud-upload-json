<?php 

require_once '../main.php';

if (isset($_GET['act'])) {
    switch ($_GET['act']) {
        case 'list':
            $page = intval($_POST['page']);
            $listProduct = getListProduct($page);
            require_once CRUD . 'list.php';
            break;

        case 'form':
            $id = $_POST['id'];
            $formProduct = getFormProduct($id);
            $category = getJSON('category');
            require_once CRUD . 'form.php';
            break;

        case 'save':
            // print_r($_FILES);die;
            $formProduct = getFormProduct($_POST['productId']);
            $index = $formProduct['index'];
            $form = $formProduct['form'];
            $data = getJSON('product');
            $error_message = '';

            foreach ($form as $key => $value) {
                if(isset($_POST[$key]) && !empty($_POST[$key])) $form[$key] = $_POST[$key];
            }

            // Check upload file
            $fileUpload = uploadImage('productImage');
            if ($fileUpload['status']) {
                $form['productImage'] = $fileUpload['upload'];
            }

            // Simpan/Edit Data
            if ($index === false) {
                //array_push($data, $form);
                array_unshift($data, $form);
                $error_message = '<div class="alert alert-success" role="alert">Sukses, data telah disimpan</div>';
            }
            else {
                $data[$index] = $form;
                $error_message = '<div class="alert alert-success" role="alert">Sukses, data telah diubah</div>';
            }

            setJSON($data, 'product');
            $_SESSION['error_message'] = $error_message;
            header('Location: '.$_SERVER['HTTP_REFERER']);
            break;

        case 'delete':
            $formProduct = getFormProduct($_GET['id']);
            $index = $formProduct['index'];
            $form = $formProduct['form'];
            $data = getJSON('product');
            $error_message = '<div class="alert alert-success" role="alert">Sukses, data telah dihapus</div>';
            
            // Hapus file upload
            echo deleteImage($form['productImage']);
            // Hapus data
            unset($data[$index]);
            setJSON($data, 'product');
            $_SESSION['error_message'] = $error_message;
            header('Location: '.$_SERVER['HTTP_REFERER']);
            break;
        
        default:
            header('Location: ../');
            break;
    }
}
else {
    header('Location: ../');
}

?>
