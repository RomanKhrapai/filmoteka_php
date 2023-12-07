<li class="film-card">
    <a href="films/<?= $item['id'] ?>">
        <div class="film-card__img-box">
            <img loading="lazy" src="<?= $item['backdrop_path'] ?>" alt="<?= $item['title'] ?>" height="320" width="479">
        </div>
        <div class="film-card__description">
            <h2 class="film-card__name"><?= $item['title'] ?></h3>
                <div class="film-card__info">
                    <span class="film-card__genre"><?= $item['genres'] ?>
                    </span> | <span class="film-card__year"><?= $item['release_date'] ?></span>
                </div>
        </div>
    </a>
</li>