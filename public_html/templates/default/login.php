

<div class="loginForm">
    <form action="<?=PATH?>login" method="POST" id="loginForm">
        <div class="row mb-3">
            <label for="login" class="col-sm 2 col-form-lable">Логин</label>
            <div class="col-sm-10">
                <input type="text" name="login" class="form-control" id="login">
            </div>
        </div>
        <div class="row mb-3">
            <label for="password" class="col-sm-2 col-form-lable">Пароль</label>
            <div class="col-sm-10">
                <input type="password" name="password" class="form-control" id="password">
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
