<?php
/**
 * @var \App\Kernel\View\View $view
 * @var \App\Kernel\Session\Session $session
 */
$view->incs('header');
?>
<main class="main">
    <div class="container">
        <h1>Вход</h1>
        <?php if ($session->has('error')) {?>
            <div class="invalid-feedback d-block">
                <?= $session->getFlash('error') ?>
            </div>
        <?php } ?>
        <form action="/login" method="post">
            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="text" class="form-control" id="email" name="email">
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Пароль</label>
                <input type="password" class="form-control" id="password" name="password">
            </div>
            <?php if($session->has('error')) {?>
                <div class="invalid-feedback d-block">
                    <?php foreach ($session->getFlash('error') as $error) {
                        echo $error;
                    }?>
                </div>
            <?php } ?>
            <button type="submit" class="btn btn-primary">Вход</button>
        </form>
    </div>
</main>
<?php
$view->incs('footer');