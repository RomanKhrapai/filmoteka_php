<div class="data-modal-clear">
    <img class="modal__img" src="<?= $film['backdrop_path']; ?>" alt="<?= $film['title']; ?>">

    <div class="film__info">
        <h2 class="modal__title">
            <?= $film['title']; ?>
        </h2>

        <?php if (!empty($_SESSION['user']['id'])) : ?>
            <form id='ratingForm' method="post" action="/setvote/<?= $id ?>">
                <div class="rating">
                    <?php for ($i = 1; $i <= 10; $i++) : ?>
                        <label for="star<?= $i ?>" onclick="document.getElementById('ratingForm').submit()">
                            <?php if ($i <= $vote) : ?>
                                &#9733;
                            <?php else : ?>
                                &#9734;
                            <?php endif; ?>
                            <input type="radio" id="star<?= $i ?>" name="rating" value="<?= $i ?>" <?= $i == 4 ? 'checked' : '' ?> style="display: none;">
                        </label>
                    <?php endfor; ?>
                    <?= $vote ? '' : "rate the movie" ?>
                </div>
            </form>
        <?php endif; ?>

        <div class="film__info-list">
            <span class="film__property vote">Vote average / Votes</span>
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
        <?php !empty($_SESSION['user']['id']) ? include 'components/userControlBtns.php' : ''   ?>
    </div>
</div>
<?php include 'components/reviews.php' ?>

<?php if (!empty($_SESSION['user']['id'])) : ?>
    <div class="main__control">
        <!-- <a class="main__link_icon" href="/addfilm/<?= $id ?>?start">
            <svg class="icon icon-wrench">
                <use xlink:href="#icon-wrench"></use>
                <symbol id="icon-wrench" viewBox="0 0 32 32">
                    <path d="M31.342 25.559l-14.392-12.336c0.67-1.259 1.051-2.696 1.051-4.222 0-4.971-4.029-9-9-9-0.909 0-1.787 0.135-2.614 0.386l5.2 5.2c0.778 0.778 0.778 2.051 0 2.828l-3.172 3.172c-0.778 0.778-2.051 0.778-2.828 0l-5.2-5.2c-0.251 0.827-0.386 1.705-0.386 2.614 0 4.971 4.029 9 9 9 1.526 0 2.963-0.38 4.222-1.051l12.336 14.392c0.716 0.835 1.938 0.882 2.716 0.104l3.172-3.172c0.778-0.778 0.731-2-0.104-2.716z"></path>
                </symbol>
            </svg>
        </a> -->
        <a class="main__link_icon" href="/films/<?= $id ?>/delete">
            <svg class="icon icon-bin">
                <use xlink:href="#icon-bin"></use>
                <symbol id="icon-bin" viewBox="0 0 32 32">
                    <path d="M4 10v20c0 1.1 0.9 2 2 2h18c1.1 0 2-0.9 2-2v-20h-22zM10 28h-2v-14h2v14zM14 28h-2v-14h2v14zM18 28h-2v-14h2v14zM22 28h-2v-14h2v14z"></path>
                    <path d="M26.5 4h-6.5v-2.5c0-0.825-0.675-1.5-1.5-1.5h-7c-0.825 0-1.5 0.675-1.5 1.5v2.5h-6.5c-0.825 0-1.5 0.675-1.5 1.5v2.5h26v-2.5c0-0.825-0.675-1.5-1.5-1.5zM18 4h-6v-1.975h6v1.975z"></path>
                </symbol>
            </svg>
        </a>
    </div>
<?php endif; ?>
<?php if ($isDelete) : ?>
    <form class="deleteForm" method="POST" action="/delete/<?= $id ?>">
        <label class="custom-label form__input">
            Enter your password to confirm deletion film ID = <?= $id ?>:
            <input class="form__input custom-input  <?= (isset($_SESSION['errorsForm']['password'])) ? " error__input" : "" ?>" type="password" name="password" required>
            <?= (isset($_SESSION['errorsForm']['password'])) ? "<span class='auth-error'>{$_SESSION['errorsForm']['password']}</span>" : '' ?>
        </label>
        <div class="deleteForm_control">
            <button class="main__btn" type="submit">Confirm Deletion</button>
            <a class="main__link" href="/films/<?= $id ?>">
                CANCEL
            </a>
        </div>
    </form>
<?php endif; ?>