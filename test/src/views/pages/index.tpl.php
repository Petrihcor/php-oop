<?php
/**
 * @var \App\Kernel\View\View $view
 * @var array<\App\Models\User> $users
 * @var array<\App\Models\User> $roles
 * @var \App\Kernel\Auth\Auth $auth
 */

//dd($users);

$view->incs('header');
//session_destroy();

?>
<main class="main">
    <div class="container">
        <h1>Пользователи</h1>
        <?php if($auth->isAdmin()){ ?>
            <a href="/user/create" class="btn btn-primary">Добавить пользователя</a>
        <?php }?>
    <?php foreach ($users as $user) {?>
        <div class="card mt-4">
            <div class="card-header">
                Featured
            </div>
            <div class="card-body">
                <a href="/user?id=<?=$user->id() ?>"><h5 class="card-title"><?= $user->name() ?></h5></a>
                <p class="card-text">Роль: <?= $user->roleName ?></p> <!-- Вывод названия роли -->
                <p class="card-text"><?= $user->email() ?></p>
                <div class="d-grid gap-2 d-sm-flex">
                    <?php if($auth->isAdmin() || $_SESSION["user_id"] == $user->id()){ ?>
                        <a href="/user/edit?id=<?= $user->id() ?>" class="btn btn-primary">Редактировать</a>
                    <?php }
                    if($auth->isAdmin()){
                    ?>
                        <form action="/user/destroy" method="post">
                            <input type="hidden" name="id" value="<?php echo $user->id() ?>">
                            <button class="btn btn-danger">Удалить</button>
                        </form>
                    <?php } ?>
                </div>
            </div>
        </div>
        <?php
    } ?>
    </div>
</main>
<?php
$view->incs('footer');