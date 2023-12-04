<h1 class="visually-hidden">Popular Movies</h1>
<ul class="js-gallery gallery">
    <?php
    // echo '<br>params = "' . json_encode($films) . '"<br>';
    foreach ($films as $item) {
        include 'filmCard.php';
    }
    ?>
</ul>