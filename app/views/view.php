<?
/** @var User $user */
?>
<div style="width: 100%">Логин: <?=$user['login']?></div>

<div style="width: 100%">
    <form action="/?c=main&m=changeName" method="post">
        <label>ФИО<input name="name" type="text" value="<?=$user['name']?>"/></label>
        <button type="submit">Изменить</button>
    </form>
</div>

<div style="width: 100%">
    <form action="/?c=main&m=changePassword" method="post">
        <label>Пароль<input name="password" type="password" value="<?=$user['password']?>"/></label>
        <button type="submit">Изменить</button>
    </form>
</div>

<a href="/?c=main&m=logout">Выход</a>