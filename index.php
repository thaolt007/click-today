<!DOCTYPE html5>
<head>
    <title>My list</title>
    <link rel="stylesheet" type="text/css" href="bootstrap/css/bootstrap.min.css" />
    <link rel="stylesheet" type="text/css" href="bootstrap/css/bootstrap-theme.min.css" />
    <link rel="stylesheet" type="text/css" href="bootstrap/css/style.css" />
    <script type="text/javascript" src="bootstrap/js/jquery-3.1.1.min.js"></script>
    <script type="text/javascript" src="bootstrap/js/bootstrap.min.js"></script>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
</head>
<?php
require 'process.php';
?>
<body>
    <div class="container">
        <div class="row success col-md-12">
            <div class="col-md-4"></div>
            <button type="button" class="btn btn-success btn-lg submit-but col-md-4">Ghi danh</button>
            <div class="col-md-4"></div>
        </div>
        <!-- End .success -->
        <div class="row content col-md-12">
            <?php printdata($data) ?>
        </div>
    </div>
    <!--End .container-->
    <script>
        $('.submit-but').click(function (e) {
            e.preventDefault(); //loai bo cac hanh dong mac dinh
            
            $.ajax({
                type: 'POST', // method
                url: './process.php', // action
                dataType: 'JSON', // kieu du lieu nhan ve
                data: {// data gui cung request
                    text: ''
                },
                success: function (data) {// thanh cong status http = 200
                    // xu ly du lieu tra ve
                    // in ket qua sang tab console
                    // console.log(data);
                    if (data.code == 1) {
                        console.log(data);
                        $('.content').prepend(
                            '<button type="button" class="btn btn-info col-md-4">' +
                                '<p>' +data.day+ '</p>' +
                            '</button>'
                        );
                        $('.data:first').slideDown();
                    }
                    else {
                        console.log(data.error);
                    }

                }
            });
        });
    </script>
</body>

</html>