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
                <li class="nav-item">
                    <a href="" class="nav-link ml-3">Главная</a>
                </li>
                <li class="nav-item">
                    <a href="" class="nav-link">Каталог</a>
                </li>
                <li class="nav-item">
                    <a href="" class="nav-link">Контакты</a>
                </li>
            </ul>
            <div class="d-flex">
                <button class="btn btn-outline-danger" data-toggle="modal" data-target="#exampleModal">Войти</button>
            </div>
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

