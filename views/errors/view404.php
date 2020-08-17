<?php
    // Load routing controller
    require_once("app/Routes.php");
    use app\Routes;
    $routes = new Routes;

    $asset = "assets/";
    $idPage = "page404";
    ob_start();
?>

<div class="container-fluid h-100 w-100">
    <div class="wrapper">
        <img src="https://zupimages.net/up/20/29/syti.png" width="40%" height="auto"><br>
        <a href="<?= $routes->url(DEFAULT_PAGE); ?>" role="button" class="btn btn-light">Home</a>
    </div>
</div>

<?php $content = ob_get_clean(); ?>