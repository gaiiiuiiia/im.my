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
        <a href="<?=PATH?>" class="navbar-brand">ASTRA</a>
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

<div class="modal fade" id="loginModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <ul class="nav nav-tabs" id="myTab" role="tablist">
                <li class="nav-item">
                    <a class="nav-link active" id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home" aria-selected="true">Войти</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="regist-tab" data-toggle="tab" href="#regist" role="tab" aria-cons="regist" aria-selected="false">Регистрация</a>
                </li>

            </ul>
            <div class="tab-content" id="myTabContent">
                <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
                    <!-- Вкладка "Вход"-->
                    <div class="modal-body " >
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
                    <div class="form-check d-flex ml-5">
                        <input type="checkbox" class="form-check-input" id="dropdownCheck">
                        <label class="form-check-label ml-2" for="dropdownCheck">
                            Запомнить меня
                        </label>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Закрыть</button>
                        <button type="submit" form="loginModalForm" class="btn btn-primary">Войти</button>
                    </div>
                </div>

                <div class="tab-pane fade" id="regist" role="tabpanel" aria-labelledby="regist-tab">
                    <!-- Вкладка "Регистрация"-->
                    <div class="modal-body" >
                        <form action="<?=PATH?>login" method="post" id="loginModalForm">
                            <div class="row mb-3">
                                <label for="inputName" class="col-sm-2 col-form-lable">Имя</label>
                                <div class="col-sm-10">
                                    <input type="text" name='name' class="form-control" id="inputName">
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label for="inputEmail" class="col-sm-2 col-form-lable">Email</label>
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
                    <div class="form-check d-flex ml-5">
                        <input type="checkbox" class="form-check-input" id="dropdownCheck">
                        <label class="form-check-label ml-2" for="dropdownCheck">
                            <small class="text-muted">Хочу получать информацию о новинках и распродажах.</small>
                        </label>
                    </div>

                    <div class="text-center mx-auto my-1 my-sm-1 my-lg-2 p-1">
                        <button type="submit" form="loginModalForm" class="btn btn-primary">Зарегистрироваться</button>
                    </div>
                    <div  class="text-center ml-2 ">
                        <p>
                            <small class="text-muted">
                            Продолжая регистрацию, я соглашаюсь с&nbsp;
                            <a  href="#">
                                Правилами пользования сайтом и обработки персональных данных</a>
                            </small>
                        </p>
                    </div>
                </div>
            </div>

<!---->

            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Вход</h5>
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
                <button type="submit" name="loginButton" form="loginModalForm" class="btn btn-primary">Войти</button>
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
                <form action="<?=PATH?>login" method="post" id="logoutModalForm">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Нен</button>
                        <button type="submit" name="logoutButton" form="logoutModalForm" class="btn btn-primary">Да, давай</button>
                </form>
            </div>
        </div>
    </div>
</div>

