<header class="navbar navbar-expand-md navbar-dark bg-dark">
    <a class="navbar-brand" href="/">Тестовое приложение</a>
    <? if (\Lib\App::userIsLogged()): ?>
        <div class="mr-auto"></div>
        <div class="dropdown">
            <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <?= \Lib\App::$user->name ?>
            </button>
            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                <a class="dropdown-item" href="/web/?c=main&m=logout">Выход</a>
            </div>
        </div>
    <? else: ?>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarCollapse"
                aria-controls="navbarCollapse" aria-expanded="true" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="navbar-collapse collapse" id="navbarCollapse" style="">
            <div class="mr-auto"></div>
            <form class="form-inline" action="/web/" method="get">
                <input type="hidden" name="c" value="main">
                <input type="text" id="inputName" class="form-control m-1" placeholder="Логин" required="" autofocus=""
                       name="login">
                <input type="password" id="inputPassword" class="form-control m-1" placeholder="Пароль" required=""
                       name="password">
                <button class="form-control btn btn-primary m-1" type="submit" name="m" value="login">Войти</button>
                <button class="form-control btn btn-success m-1" type="button" name="m" value="register">Регистрация
                </button>
            </form>
        </div>
    <? endif; ?>
</header>