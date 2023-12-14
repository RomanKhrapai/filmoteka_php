<?php
$posterUrl = 'storege/img/temp/' . $_SESSION['user']['id'] . '.jpg';
$imgUrl = 'assets/no-poster.jpg';
if (file_exists($posterUrl)) {
    $imgUrl = $posterUrl;
} ?>

<div class="form__input custom-input form__input_file <?= (isset($_SESSION['errorImg'])) ? " error__input" : "" ?>">
    <div class="film-card__img-box">
        <img loading="lazy" src="<?= $imgUrl ?>" height="320" width="479">
    </div>
    <span class="form__btn btn">
        <?= (isset($_SESSION['errorImg'])) ? "select an image" : "change the image" ?>
    </span>
</div>


<?= (isset($_SESSION['errorImg'])) ? "<span class='auth-error'>{$_SESSION['errorImg']}</span>" : '' ?>