<?php require_once 'main.php'; ?>
<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css"
        integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">

    <title>Simple Crud + Upload</title>
</head>

<body>

    <div class="d-flex flex-column flex-md-row align-items-center p-3 px-md-4 mb-3 bg-white border-bottom shadow-sm">
        <h5 class="my-0 mr-md-auto font-weight-normal">List Product</h5>
        <a class="btn btn-outline-primary btn-form" id="" data-toggle="modal" data-target="#formModal" href="#">Add
            Product</a>
    </div>

    <main role="main">

        <div class="album py-5 bg-light">
            <div class="container">

                <?php 
                if (isset($_SESSION['error_message'])) {
                    echo $_SESSION['error_message'];
                    unset($_SESSION['error_message']);
                }
                ?>

                <?php 
                    $activePage = 1;
                    $listProduct = getListProduct($activePage);
                    if (!empty($listProduct)) {
                        echo '<div class="list-product row">';
                        require_once CRUD . 'list.php';
                        echo '</div>';

                        echo '<div class="more-product text-center">
                                <button class="btn btn-block btn-primary">
                                    <span class="spinner-border spinner-border-sm d-none" role="status"
                                        aria-hidden="true"></span>
                                    Load More ...
                                </button>
                            </div>';
                    }
                    else {
                        echo '<div class="empty-product text-center">
                                <div class="container">
                                    <img src="https://www.denmakers.in/img/no-results.png" alt="">
                                    <h1 class="display-4">No Results Founds</h1>
                                </div>
                            </div>';
                    }
                ?>

            </div>
        </div>

    </main>

    <!-- Modal -->
    <div class="modal fade" id="formModal" tabindex="-1" aria-labelledby="formModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="formModalLabel">Add Product</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="form-product" class="form-product" action="crud/index.php?act=save" method="post" enctype="multipart/form-data"></form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary" form="form-product" value="submit">Save</button>
                </div>
            </div>
        </div>
    </div>


    <!-- Optional JavaScript; choose one of the two! -->

    <!-- Option 1: jQuery and Bootstrap Bundle (includes Popper) -->
    <script src="https://code.jquery.com/jquery-3.5.1.min.js" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-ho+j7jyWK8fNQe+A12Hb8AhRq26LrZ/JpcUGGOn+Y7RsweNrtN/tE3MoK7ZeZDyx" crossorigin="anonymous">
    </script>

    <script>
    const actionUrl = "crud/index.php?act=";
    const listProduct = $(".list-product");
    const formProduct = $(".form-product");

    let activePage = <?= $activePage; ?>;

    $(".more-product button").on("click", function(event) {
        event.preventDefault();
        let more = $(this);
        let loader = more.find(".spinner-border");

        activePage++;
        more.prop("disabled", true);
        loader.removeClass("d-none");
        setTimeout(() => {
            $.ajax({
                url: actionUrl + "list",
                data: {
                    page: activePage
                },
                type: "post",
                success: function(data) {
                    more.attr("disabled", false);
                    loader.addClass("d-none");
                    listProduct.append(data);

                    if (data == "") {
                        more.hide();
                    }
                }
            });
        }, 1000);
    });

    $(".btn-form").on("click", function(event) {
        event.preventDefault();
        let productId = this.id;
        $.ajax({
            url: actionUrl + "form",
            data: {
                id: productId
            },
            type: "post",
            success: function(data) {
                formProduct.html(data);
            }
        });
    });

    </script>
</body>

</html>