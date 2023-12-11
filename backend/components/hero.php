<?php
$stmt = $dbh->prepare("SELECT * FROM genres");
$stmt->execute();
$genres = $stmt->fetchAll();

?>

<div class="hero">

    <div class="hero__form">
        <div class="hero__heder">
            <form class="hero__search_form" method="get" action="/films">
                <input class=" hero__block_default hero__input" value="<?= $search  ?>" type="search" name="search" id="input" minlength="2" required autocomplete="off" placeholder="search text">
                <button class=" hero__block_default hero__search-button" aria-label="search" type="submit">
                    <svg class="hero__search_icon ">
                        <use xlink:href="#icon-search"></use>
                        <symbol id="icon-search" viewBox="0 0 32 32">
                            <path d="M31.008 27.231l-7.58-6.447c-0.784-0.705-1.622-1.029-2.299-0.998 1.789-2.096 2.87-4.815 2.87-7.787 0-6.627-5.373-12-12-12s-12 5.373-12 12 5.373 12 12 12c2.972 0 5.691-1.081 7.787-2.87-0.031 0.677 0.293 1.515 0.998 2.299l6.447 7.58c1.104 1.226 2.907 1.33 4.007 0.23s0.997-2.903-0.23-4.007zM12 20c-4.418 0-8-3.582-8-8s3.582-8 8-8 8 3.582 8 8-3.582 8-8 8z"></path>
                        </symbol>
                    </svg>

                </button>
            </form>

            <label class="">
                Sort by:
                <select id="selectOptions" onchange="makeRequestSort()" name="sort" class="hero__block_default hero__select" data-role="dropdownlist">
                    <option value="popularity.desc" <?= $switchSort === 'popularity desc' ? 'selected="selected"' : '' ?>>Popularity &#8659;</option>
                    <option value="popularity.asc" <?= $switchSort === 'popularity asc' ? 'selected="selected"' : '' ?>>Popularity &#8657;</option>
                    <option value="vote.desc" <?= $switchSort === 'vote desc' ? 'selected="selected"' : '' ?>>Rating &#8659;</option>
                    <option value="vote.asc" <?= $switchSort === 'vote asc' ? 'selected="selected"' : '' ?>>Rating &#8657;</option>
                    <option value="release_date.desc" <?= $switchSort === 'release_date desc' ? 'selected="selected"' : '' ?>>Release date &#8659;</option>
                    <option value="release_date.asc" <?= $switchSort === 'release_date asc' ? 'selected="selected"' : '' ?>>Release date &#8657;</option>
                    <option value="title.asc" <?= $switchSort === 'title asc' ? 'selected="selected"' : '' ?>>Title (AZ)</option>
                    <option value="title.desc" <?= $switchSort === 'title desc' ? 'selected="selected"' : '' ?>>Title (ZA)</option>
                </select></label>


            <label class="more-label hero__button hero__block_default">more...<input id="moreButton" class="input-none" name="more" type="checkbox" aria-label="more filters"></label>
        </div>
        <form class="filter__box <?= $isMore ? ' is-more' : '' ?>" id='filterForm'>
            <div class="filter__genres">
                <?php
                foreach ($genres as $genre) {
                    $isChecked = in_array($genre['id'], $genresArr) ? 'checked' : '';
                    echo "
                    <input data-genre='" . $genre['id'] . "' id='{$genre['id']}' class='input-none' 
                        name='genre{$genre['id']}' type='checkbox' aria-label='{$genre['name']}' $isChecked>
                    <label for='{$genre['id']}' class='hero__block_default filter__genre'>
                        {$genre['name']} 
                    </label>";
                } ?>
            </div>
            <!-- <div id="range-container">
                <label for="range">Виберіть діапазон:</label>
                <input type="range" id="range-from" min="0" max="100" step="1" value="0">
                <input type="range" id="range-to" min="0" max="100" step="1" value="100">
                <div id="range-values">Від: <span id="range-from-value">0</span> До: <span id="range-to-value">100</span></div>
            </div> -->
            <!-- <label for="cars">Choose a car:</label>

            <select name="cars[]" id="cars" multiple>
                <option value="volvo">Volvo</option>
                <option value="saab">Saab</option>
                <option value="opel">Opel</option>
                <option value="audi">Audi</option>
            </select> -->

            <div class="hero__box_center"><button class=" hero__block_default  hero__btn_filter" aria-label="search" type="submit">
                    apply filters
                </button></div>


        </form>
        <div class="notification-text"></div>
    </div>


    <script>
        document.addEventListener("DOMContentLoaded", () =>
            document.getElementById("moreButton").addEventListener("click",
                () => {
                    document.getElementById("filterForm").classList.toggle("is-more")
                    const currentUrl = new URL(window.location.href);

                    if (currentUrl.searchParams.has('more')) {
                        currentUrl.searchParams.delete('more');
                    } else {
                        currentUrl.searchParams.set('more', '1');
                    }

                    window.history.replaceState({}, '', currentUrl);
                })
        )

        function makeRequestSort() {
            const selectedOption = document.getElementById("selectOptions").value;

            const currentUrl = new URL(window.location.href);
            const queryParams = currentUrl.searchParams;

            if (queryParams.has('page')) {
                queryParams.delete('page');
            }

            if (queryParams.has('sort')) {
                queryParams.set('sort', selectedOption);
            } else {
                queryParams.append('sort', selectedOption);
            }
            window.location.href = currentUrl.href;
        }

        document.getElementById("filterForm").addEventListener("submit", updateCheckboxValues);

        function updateCheckboxValues(event) {
            event.preventDefault();
            const checkboxes = document.querySelectorAll("[data-genre]:checked")
            const genres = [...checkboxes].map((elem) => elem.getAttribute("data-genre"));

            const urlParams = new URLSearchParams(window.location.search);

            if (urlParams.has('page')) {
                urlParams.delete('page');
            }

            if (urlParams.has('genres[]')) {
                urlParams.delete('genres[]');
            }
            genres.forEach((genre) => urlParams.append('genres[]', genre));

            const newGenresQueryString = urlParams.toString();
            if (newGenresQueryString !== "") {
                window.location.href = window.location.protocol + "//" + window.location.host + window.location.pathname + '?' + newGenresQueryString;

            }

        }
    </script>