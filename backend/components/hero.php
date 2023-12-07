<?php
$stmt = $dbh->prepare("SELECT * FROM genres");
$stmt->execute();
$genres = $stmt->fetchAll();

?>

<div class="hero">

    <form class="hero__form" method="get" action="/films">
        <div class="hero__heder">
            <div class="hero__search_box">
                <input class=" hero__block_default hero__input" type="search" name="search" id="input" minlength="2" required autocomplete="off" placeholder="search text">
                <button class=" hero__block_default hero__search-button" aria-label="search" type="submit">
                    <svg class="hero__search_icon ">
                        <use xlink:href="#icon-search"></use>
                        <symbol id="icon-search" viewBox="0 0 32 32">
                            <path d="M31.008 27.231l-7.58-6.447c-0.784-0.705-1.622-1.029-2.299-0.998 1.789-2.096 2.87-4.815 2.87-7.787 0-6.627-5.373-12-12-12s-12 5.373-12 12 5.373 12 12 12c2.972 0 5.691-1.081 7.787-2.87-0.031 0.677 0.293 1.515 0.998 2.299l6.447 7.58c1.104 1.226 2.907 1.33 4.007 0.23s0.997-2.903-0.23-4.007zM12 20c-4.418 0-8-3.582-8-8s3.582-8 8-8 8 3.582 8 8-3.582 8-8 8z"></path>
                        </symbol>
                    </svg>

                </button>
            </div>
            <label class="">
                Sort by:
                <select name="sort" class="hero__block_default hero__select" data-role="dropdownlist">
                    <option value="popularity.desc" selected="selected">Popularity &#8659;</option>
                    <option value="popularity.asc">Popularity &#8657;</option>
                    <option value="vote.desc">Rating &#8659;</option>
                    <option value="vote.asc">Rating &#8657;</option>
                    <option value="release_date.desc">Release date &#8659;</option>
                    <option value="release_date.asc">Release date &#8657;</option>
                    <option value="title.asc">Title (AZ)</option>
                    <option value="title.desc">Title (ZA)</option>
                </select></label>

            <label class="more-label hero__button hero__block_default">more...<input id="moreButton" class="input-none" name="more" type="checkbox" aria-label="more filters"></label>
        </div>
        <div class="filter__box" id='moreBox'>
            <div class="filter__genres">
                <?php
                foreach ($genres as $genre) {
                    echo "<input id='{$genre['id']}' class='input-none' name='genre{$genre['id']}' type='checkbox' aria-label='{$genre['name']}'>
<label for='{$genre['id']}' class='hero__block_default filter__genre'>{$genre['name']} </label>";
                }

                ?>
            </div>
            <div id="range-container">
                <label for="range">Виберіть діапазон:</label>
                <input type="range" id="range-from" min="0" max="100" step="1" value="0">
                <input type="range" id="range-to" min="0" max="100" step="1" value="100">
                <div id="range-values">Від: <span id="range-from-value">0</span> До: <span id="range-to-value">100</span></div>
            </div>

            <label for="fruit">Оберіть фрукти:</label>
            <select id="fruit" name="fruit[]" size="5" multiple>
                <option value="apple">Яблуко</option>
                <option value="banana">Банан</option>
                <option value="orange">Апельсин</option>
                <option value="grape">Виноград</option>
                <option value="strawberry">Полуниця</option>
            </select>



    </form>
    <div class="notification-text"></div>
</div>


<script>
    document.addEventListener("DOMContentLoaded", () =>
        document.getElementById("moreButton").addEventListener("click",
            () => document.getElementById("moreBox").classList.toggle("is-more"))
    )
    console.log(document.querySelector("moreBox"));
</script>