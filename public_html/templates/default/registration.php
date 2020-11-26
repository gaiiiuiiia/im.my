
<div class="registration-wrapper">

    <form action="<?=PATH?>registration" method="POST" id="registrationForm_">
        <div class="input-fields">
            <div class="input-row">
                <label for="name">Имя</label>
                <input type="text" class="input-field" name="name">
            </div>
            <div class="input-row">
                <label for="login">Логин</label>
                <input type="text" class="input-field" name="login">
            </div>
            <div class="input-row">
                <label for="email">email</label>
                <input type="email" class="input-field" name="email">
            </div>
            <div class="input-row">
                <label for="password">Пароль</label>
                <input type="password" class="input-field" name="password">
            </div>
            <div class="input-row">
                <label for="confirm-password">Повторите пароль</label>
                <input type="password" class="input-field" name="confirm-password">
            </div>
        </div>
        <div class="registration-buttons">
            <button type="button" class="btn btn-secondary">На главную</button>
            <button type="submit" class="btn btn-primary" name="registrationButton" form="registrationForm_">Зарегистрироваться</button>
        </div>
    </form>

    <div class="side-panel">
        <p>Дополнительная информация</p>
        <div class="side-tabs">
            <ul>
                <li>О себе</li>
            </ul>

        </div>
    </div>

</div>