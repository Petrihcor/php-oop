<?php
/**
 * @var \App\Kernel\View\View $view
 * @var \App\Kernel\Session\Session $session
 */
$view->incs('header');
?>
<main class="main">
    <div class="container">
        <h1>Регистрация</h1>

        <form action="/register" method="post">
            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="text" class="form-control" id="email" name="email">
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
                <input type="text" class="form-control" id="name" name="name">
            </div>
            <?php if($session->has('name')) {?>
                <div class="invalid-feedback d-block">
                    <?php foreach ($session->getFlash('name') as $error) {
                        echo $error;
                    }?>
                </div>
            <?php } ?>
            <div class="mb-3">
                <label for="password" class="form-label">Пароль</label>
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
            <div class="mb-3">
                <label for="image" class="form-label">Аватар</label>
                <input type="file" class="form-control" id="image" name="image">
            </div>
            <button type="submit" class="btn btn-primary">Регистрация</button>
        </form>
    </div>
</main>
<?php
$view->incs('footer');