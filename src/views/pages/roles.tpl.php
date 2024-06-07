<?php
/**
 * @var \App\Kernel\View\View $view
 * @var array<\App\Models\Role> $roles
 * @var \App\Kernel\Auth\Auth $auth
 */


$view->incs('header');
?>
    <main class="main">
        <div class="container">
            <h1>Категории</h1>
            <?php if($auth->isAdmin()){ ?>
                <a href="/role/create" class="btn btn-primary">Добавить роль</a>
            <?php }?>
            <?php foreach ($roles as $role) {
                ?>
                <div class="card mt-4">
                    <div class="card-header">
                        Featured
                    </div>
                    <div class="card-body">
                        <h5 class="card-title"><?= $role->title() ?></h5>
                        <p class="card-text"><?= $role->description() ?></p>
                        <div class="d-grid gap-2 d-sm-flex">
                            <?php if($auth->isAdmin()){ ?>
                            <a href="/role/edit?id=<?= $role->id() ?>" class="btn btn-primary">Редактировать</a>
                                <form action="/role/destroy" method="post">
                                    <input type="hidden" name="id" value="<?php echo $role->id() ?>">
                                    <button class="btn btn-danger">Удалить</button>
                                </form>
                            <?php }?>
                        </div>
                    </div>
                </div>
                <?php
            } ?>
        </div>
    </main>
<?php
$view->incs('footer');