<h1 class="visually-hidden">Popular Movies</h1>
<ul class="js-gallery gallery">
    <?php
    foreach ($films as $item) {
        include 'filmCard.php';
    }
    ?>
</ul>