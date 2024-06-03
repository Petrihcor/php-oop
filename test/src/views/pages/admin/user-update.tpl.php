<?php
/**
 * @var \App\Kernel\View\View $view
 * @var \App\Kernel\Session\Session $session
 * @var \App\Models\User $user
 * @var array<\App\Models\Role> $roles
 */

$view->incs('header');

?>
    <main class="main">
        <div class="container">
            <h1>Редактировать пользователя </h1>

            <form action="/user/edit" method="post" enctype="multipart/form-data">
                <input type="hidden" name="id" value="<?= $user->id() ?>">
                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input type="text" value="<?= $user->email() ?>" class="form-control" id="email" name="email">
                </div>
                <?php if($session->has('email')) {?>
                    <div class="invalid-feedback d-block">
                        <?php foreach ($session->getFlash('email') as $error) {
                            echo $error;
                        }?>
                    </div>
                <?php } ?>
                <div class="mb-3">
                    <label for="name" class="form-label">Имя</label>
                    <input type="text" value="<?= $user->name() ?>" class="form-control" id="name" name="name">
                </div>
                <?php if($session->has('name')) {?>
                    <div class="invalid-feedback d-block">
                        <?php foreach ($session->getFlash('name') as $error) {
                            echo $error;
                        }?>
                    </div>
                <?php } ?>
                <div class="mb-3">
                    <label for="password" class="form-label">Новый пароль</label>
                    <input type="password" class="form-control" id="password" name="password">
                </div>
                <?php if($session->has('password')) {?>
                    <div class="invalid-feedback d-block">
                        <?php foreach ($session->getFlash('password') as $error) {
                            echo $error;
                        }?>
                    </div>
                <?php } ?>
                <div class="mb-3">
                    <label for="password_confirmation">Подтверждение</label>
                    <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" placeholder="*********">
                </div>
                <?php if ($session->has('is_admin')) { ?>
                <select name="role_id[]" id="role" multiple class="form-select" aria-label="Default select example">
                <?php foreach ($roles as $role) {?>
                    <option value="<?= $role->id() ?>"
                    <?php
                        echo in_array($role->id(), $user->roleId()) ? "selected" : "";
                    ?>><?= $role->title()?></option>
                <?php } ?>
                </select>
                <?php } ?>
                <?php if($session->has('role_id')) {?>
                    <div class="invalid-feedback d-block">
                        <?php foreach ($session->getFlash('role_id') as $error) {
                            echo $error;
                        }?>
                    </div>
                <?php } ?>
                <div class="mb-3">
                    <label for="image" class="form-label">Аватар</label>
                    <input type="file" class="form-control" id="image" name="image">
                </div>
                <button type="submit" class="btn btn-primary">Сохранить</button>
            </form>
        </div>
    </main>
<?php
$view->incs('footer');