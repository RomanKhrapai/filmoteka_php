<div class="data-modal-clear">
    <img class="modal__img" src="<?= $film['backdrop_path']; ?>" alt="<?= $film['title']; ?>">

    <div class="film__info">
        <h2 class="modal__title">
            <?= $film['title']; ?>
        </h2>
        <div class="film__info-list">
            <span class="film__property vote">Vote / Votes</span>
            <div class="film__stat">
                <span class="film__stat-vote"><?= round($film['vote'], 1); ?></span>/ <span class="film__stat-vote film__stat-votes"><?= $film['votes']; ?></span>
            </div>
        </div>

        <div class="film__info-list">
            <span class="film__property popularity">Popularity</span>
            <span class="film__stat"><?= round($film['popularity']); ?></span>
        </div>


        <div class="film__info-list">
            <span class="film__property genre">Genre</span>
            <span class="film__stat">
                <?php echo $film['genres']; ?>
            </span>
        </div>

        <div class="about">
            <h3 class="about-title">
                ABOUT
            </h3>
            <p class="about-text">
                <?php echo $film['overview']; ?>

            </p>
        </div>
        <div class="main__btn-modal">

            <button type="button" id="btn__watched" class="main__btn " data-action="add">
                ADD TO WATCHED
            </button>
            <button type="button" id="btn__queue" class="main__btn" data-action="add">

                ADD TO QUEUE
            </button>
            <button type="button" id="btn__trailer" class="main__btn main__btn-margin" disabled="true">
                OPEN TRAILER
            </button>
        </div>
    </div>
</div>
<?php include 'components/reviews.php' ?>