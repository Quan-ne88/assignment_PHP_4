<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <base href="http://localhost/assignment_PHP_4/admin/">
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge" />
    <title>Trang quản trị </title>
    <link rel="icon" href="assets/img/shopping-bag.png" type="image/gif" sizes="16x16" />
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="assets/fonts/fontawesome-free-6.2.1-web/css/all.css" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous" />
    <link rel="stylesheet" href="css/main.css" />
    <script src="assets/js/main.js" async></script>
</head>

<body>
    <!--Main Navigation-->
    <header> <!-- Navbar -->
        <nav id="main-navbar" class="navbar navbar-expand-lg navbar-light bg-black fixed-top mb-3 "> <!-- Container wrapper -->
            <div class="container-fluid">
                <a href="?mod=users&act=account">
                    <h2 style="color: #fff;"><?php
                                                if (!empty($_SESSION['admin_login'])) echo 'Xin chào ' . $_SESSION['admin_login'];
                                                else echo 'Dashboard' ?></h2>
                </a> <!-- Avatar -->
                <a href="?mod=users&act=logout" style="color: #fff;" class="nav-item dropdown">Đăng xuất</a>
            </div> <!-- Container wrapper -->
        </nav> <!-- Navbar -->
    </header> <!--Main Navigation-->