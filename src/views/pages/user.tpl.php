<?php
/**
 * @var \App\Kernel\View\View $view
 * @var \App\Kernel\Session\Session $session
 * @var \App\Models\User $user
 * @var \App\Models\Role $roles
 * @var \App\Kernel\Auth\Auth $auth
 */
$view->incs('header');
?>
    <main class="main">
        <div class="container mt-4">
            <div class="row g-0">
                <div class="col-md-4">
                    <img src="<?= $user->avatar() ? "/public/storage/images/avatars/{$user->avatar()}" : "https://img.wattpad.com/f5e009807865d427befcc66ce83b88789834806e/68747470733a2f2f73332e616d617a6f6e6177732e636f6d2f776174747061642d6d656469612d736572766963652f53746f7279496d6167652f383067704530566c6e65554736413d3d2d313137373339343231322e313664396262636266326135396435393236353234393739353635312e6a7067?s=fit&w=720&h=720"?>" class="img-fluid rounded-start" alt="...">
                </div>
                <div class="col-md-8">
                    <div class="card-body mb-4">
                        <ul class="list-group">
                            <li class="list-group-item">Имя: <?= $user->name() ?></li>

                            <li class="list-group-item">Почта: <?= $user->email() ?></li>
                            <li class="list-group-item">Роли:
                                <?php foreach ($roles as $role) {
                                    echo $role->title() . " ";
                                }?>
                            </li>

                        </ul>

                    </div>
                    <div class="d-grid gap-2 d-sm-flex">
                        <?php if($auth->isAdmin() || ((array_key_exists('user_id', $_SESSION)) && $_SESSION['user_id'] == $user->id()) ){ ?>
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
        </div>
    </main>
<?php
$view->incs('footer');