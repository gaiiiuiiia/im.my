<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>ASTRA</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/5.0.0-alpha2/css/bootstrap.min.css">

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.6/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/js/bootstrap.min.js"></script>
</head>
<body>

<nav class="navbar navbar-expand-sm navar-light bg-light">
    <div class="container">
        <a href="" class="navbar-brand">ASTRA</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarContent"
                aria-controls="navbarContent" aria-expanded="false">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarContent">
            <ul class="navbar-nav mr-auto mb-2">
                <li class="nav-item ">
                    <a href="" class="nav-link ml-5">Акции</a>
                </li>
                <li class="nav-item dropdown">
                    <a href="" class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLinkWoman" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Женщины</a>
                    <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLinkWoman">
                        <a class="dropdown-item" href="#">Платья</a>
                        <a class="dropdown-item" href="#">Блузки</a>
                        <a class="dropdown-item" href="#">Хуйнюшки</a>
                    </div>
                <li class="nav-item dropdown">
                    <a href="" class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLinkMan" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Мужчины</a>
                    <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLinkMan">
                        <a class="dropdown-item" href="#">-</a>
                        <a class="dropdown-item" href="#">-</a>
                        <a class="dropdown-item" href="#">-</a>
                    </div>
                </li>
                <li class="nav-item dropdown">
                    <a href="" class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLinkChild" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Дети</a>
                    <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLinkChild">
                        <a class="dropdown-item" href="#">-</a>
                        <a class="dropdown-item" href="#">-</a>
                        <a class="dropdown-item" href="#">-</a>
                    </div>
                </li>
            </ul>

            <form class="d-flex mb-0" action="">
                <input class="form-control mr-sm-2" type="search" placeholder="Поиск">
                <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Найти</button>
            </form>

            <?php if (!$this->checkCookie()):?>
                <div class="d-flex">
                    <button class="btn btn-outline-danger" data-toggle="modal" data-target="#loginModal">Войти</button>
                </div>
            <?php else:?>
                <div class="d-flex">
                    <button class="btn btn-outline-danger" data-toggle="modal" data-target="#logoutModal">Выйти</button>
                </div>
            <?php endif;?>
        </div>
    </div>
</nav>

<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Вход</h5>
                <button class="btn-close" data-dismiss="modal" aria-label="close"></button>
            </div>
            <div class="modal-body">
                <form action="<?=PATH?>login" method="post" id="loginModalForm">
                    <div class="row mb-3">
                        <label for="inputEmail" class="col-sm-2 col-form-lable">Логин</label>
                        <div class="col-sm-10">
                            <input type="text" name='login' class="form-control" id="inputEmail">
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label for="inputPass" class="col-sm-2 col-form-lable">Пароль</label>
                        <div class="col-sm-10">
                            <input type="password" name="password" class="form-control" id="inputPass">
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Закрыть</button>
                <button type="submit" form="loginModalForm" class="btn btn-primary">Войти</button>
            </div>
        </div>
    </div>
</div>

