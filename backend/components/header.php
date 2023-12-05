<div class="screen-background">

    <div class="container animation-thumb">

        <header class="header">

            <a href="/" class="header__link">
                <svg class="header__icon" width="24" height="24">
                    <use href="/images/icons.svg#film-icon"></use>
                </svg>
                <span class="header__logo">Filmoteka</span>
            </a>

            <div class="flex-thumb">

                <nav class="site-nav">

                    <ul class="site-nav__list">
                        <li class="site-nav__item"> <a class="site-nav__link is-active" href="/">HOME</a></li>
                        <li class="site-nav__item"> <a class="site-nav__link " href="/films">FILMS</a></li>
                        <li class="site-nav__item"> <a class="site-nav__link" href="/library">LIBRARY</a></li>
                    </ul>

                </nav>

                <div class="auth">
                    <?php
                    if (empty($user)) {
                        echo '<div class="auth__item"> <a class="auth__link" href="/auth/login">LOG IN</a></div>
                    <div class="auth__item"> <a class="auth__link" href="/auth/singup">SING UP</a></div>';
                    } else {
                        echo  '<div class="auth__item"> <a class="auth__link" href="/user">000</a></div>
                    <div class="auth__item"> <a class="auth__link" href="/auth/logout">LOG OUT</a></div>';
                    }

                    ?>
                </div>

            </div>

        </header>

        <div class="hero">

            <form class="hero__form">
                <input class="hero__input" type="text" name="movies" id="input" minlength="2" required autocomplete="off" placeholder="Поиск фильмов">
                <button class="hero__search-button" aria-label="search" type="submit">
                    <svg class="hero__search-icon" width="12" height="12">
                        <use href="/images/icons.svg#icon-search-icon"></use>
                    </svg>
                </button>

            </form>

            <div class="notification-text"></div>

        </div>

    </div>
</div>