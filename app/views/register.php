<?
/** @var User $user */
?>
<form action="/?c=main&m=register" method="post">
    <div style="width: 100%">
        <label>Логин<input name="login" type="text" placeholder="Логин" value="<?=$user['login']?>"/></label>
    </div>
    <div style="width: 100%">
        <label>Пароль<input name="password" type="password""/></label>
    </div>
    <div style="width: 100%">
        <label>ФИО<input name="name" type="text" value="<?=$user['name']?>"/></label>
    </div>
    <button type="submit">Зарегистрироваться</button>
</form>