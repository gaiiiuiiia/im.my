<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title><?=$this->title?></title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/5.0.0-alpha2/css/bootstrap.min.css">

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.6/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/js/bootstrap.min.js"></script>
</head>
<body>

<nav class="navbar navbar-expand-sm navar-light bg-light">
    <div class="container">
        <a href="<?=PATH?>" class="navbar-brand"><?=$this->title?></a>
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

            <?php if (!$_SESSION['login']):?>
                <div class="d-flex">
                    <button class="btn btn-outline-danger" data-toggle="modal" data-target="#enterModal">Войти</button>
                </div>
            <?php else:?>
                <div>
                    <h1><?=$this->login?></h1>
                </div>
                <div class="d-flex">
                    <button class="btn btn-outline-danger" data-toggle="modal" data-target="#logoutModal">Выйти</button>
                </div>
            <?php endif;?>
        </div>
    </div>
</nav>

<div class="modal fade" id="enterModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <ul class="nav nav-tabs" id="myTab" role="tablist">
                <li class="nav-item">
                    <a class="nav-link active" id="login-tab" data-toggle="tab" href="#login" role="tab" aria-controls="login" aria-selected="true">Авторизоваться</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="registration-tab" data-toggle="tab" href="#registration" role="tab" aria-controls="registration" aria-selected="false">Зарегистрироваться</a>
                </li>

            </ul>
            <div class="tab-content" id="myTabContent">

                <div class="tab-pane fade show active" id="login" role="tabpanel" aria-labelledby="login-tab">
                    <div class="modal-body" >
                        <form action="<?=PATH?>login" method="post" id="loginForm">
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
                            <div class="form-check d-flex ml-5">
                                <input type="checkbox" name="rememberMe" class="form-check-input" id="dropdownCheck">
                                <label class="form-check-label ml-2" for="dropdownCheck">
                                    Запомнить меня
                                </label>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Закрыть</button>
                        <button type="submit" name="loginButton" form="loginForm" class="btn btn-primary">Авторизоваться</button>
                    </div>
                </div>

                <div class="tab-pane fade" id="registration" role="tabpanel" aria-labelledby="registration-tab">
                    <div class="modal-body">
                        <form action="<?=PATH?>registration" method="post" id="registrationForm">
                            <div class="row mb-3">
                                <label for="inputName" class="col-sm-2 col-form-lable">Имя</label>
                                <div class="col-sm-10">
                                    <input type="text" name='name' class="form-control" id="inputName">
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label for="inputLogin" class="col-sm-2 col-form-lable">Логин</label>
                                <div class="col-sm-10">
                                    <input type="text" name='login' class="form-control" id="inputLogin">
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label for="inputEmail" class="col-sm-2 col-form-lable">Email</label>
                                <div class="col-sm-10">
                                    <input type="email" name='email' class="form-control" id="inputEmail">
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label for="inputPass" class="col-sm-2 col-form-lable">Пароль</label>
                                <div class="col-sm-10">
                                    <input type="password" name="password" class="form-control" id="inputPass">
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label for="inputConfirmPass" class="col-sm-2 col-form-lable">Подтверждение пароля</label>
                                <div class="col-sm-10">
                                    <input type="password" name="confirm-password" class="form-control" id="inputConfirmPass">
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="form-check d-flex ml-5">
                        <input type="checkbox" class="form-check-input" id="dropdownCheck">
                        <label class="form-check-label ml-2" for="dropdownCheck">
                            <small class="text-muted">Хочу получать информацию о новинках и распродажах</small>
                        </label>
                    </div>

                    <div class="text-center mx-auto my-1 my-sm-1 my-lg-2 p-1">
                        <button type="submit" name="registrationButton" form="registrationForm" class="btn btn-primary">Зарегистрироваться</button>
                    </div>
                    <div  class="text-center ml-2 ">
                        <p>
                            <small class="text-muted">
                            Продолжая регистрацию, я соглашаюсь с <br>
                            <a  href="#">
                                Правилами пользования сайтом и обработки персональных данных</a>
                            </small>
                        </p>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Разлогиниваемся?</h5>
            </div>
            <div class="modal-footer">
                <form action="<?=PATH?>login" method="post" id="logoutForm">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Нен</button>
                        <button type="submit" name="logoutButton" form="logoutForm" class="btn btn-primary">Да, давай</button>
                </form>
            </div>
        </div>
    </div>
</div>

