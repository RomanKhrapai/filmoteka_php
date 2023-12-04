<li class="film-card">
    <a href="film/<?php echo $item['id'] ?>">
        <div class="film-card__img-box">
            <img loading="lazy" src="<?php echo $item['backdrop_path'] ?>" alt="<?php echo $item['title'] ?>">
        </div>
        <div class="film-card__description">
            <h2 class="film-card__name"><?php echo $item['title'] ?></h3>
                <div class="film-card__info">
                    <span class="film-card__genre"><?php echo $item['genres'] ?>
                    </span> | <span class="film-card__year"><?php echo $item['release_date'] ?></span>
                </div>
        </div>
    </a>
</li>