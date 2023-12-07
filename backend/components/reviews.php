<div class="reviews_header">
    <h3>Коментарі</h3>

    <span class="tooltiptext tooltiptext-top">Додати коментар</span></button>
</div>
<ul class="reviews_list">
    <?php
    // dd($comments);
    foreach ($comments as $coment) {
        $remove = '';

        if (!empty($_SESSION['user']['id']) && $coment['user_id'] === $_SESSION['user']['id']) {
            $remove = '<button type="button" class="">Змінити</button>
    <button type="button" class="" >Видалити</button>';
        }

        echo ' <li class="reviews_item">
<div class="reviews_foto-box"><img class="reviews_foto" width="60" height="60" src="' . $coment['url_img'] . '" alt="foto">
</div>
<div class="reviews_body">
    <div class="reviews_item-header"><span class="reviews_name">' . $coment['username'] . '' . $remove
            . '
        </span><span class="reviews_time">' . $coment['create_date'] . '</span></div>
    <div>
    ' . $coment['text'] . '
    </div>
</div>
</li>';
    }
    ?>

</ul>