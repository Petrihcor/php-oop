<?php
/**
 * @var \App\Kernel\View\View $view
 * @var \App\Kernel\Session\Session $session
 */


$view->incs('header');
?>
    <main class="main">
        <div class="container">
            <h1>Новая роль</h1>
            <form action="/role/create" method="post" enctype="multipart/form-data">
                <div class="mb-3">
                    <label for="title" class="form-label">Название</label>
                    <input type="text" class="form-control" id="title" name="title">
                </div>
                <?php if($session->has('title')) {?>
                    <div class="invalid-feedback d-block">
                        <?php foreach ($session->getFlash('title') as $error) {
                            echo $error;
                        }?>
                    </div>
                <?php } ?>
                <div class="mb-3 form-check">
                    <input type="radio" class="form-check-input" id="isAdmin" name="is_Admin" value="1">
                    <label class="form-check-label" for="isAdmin">Администратор</label>
                </div>
                <div class="mb-3 form-check">
                    <input type="radio" class="form-check-input" id="isUser" name="is_Admin" value="0" checked>
                    <label class="form-check-label" for="isUser">Пользователь</label>
                </div>
                <div class="mb-3 form">
                    <label for="description" class="form-label" >Описание</label>
                    <textarea class="form-control" rows="5" id="description" name="description"></textarea>
                </div>
                <button type="submit" class="btn btn-primary">Submit</button>
            </form>
        </div>
    </main>
<?php
$view->incs('footer');