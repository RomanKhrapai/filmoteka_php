<div class="screen-background">

    <div class="container animation-thumb">

        <header class="header">

            <a href="/index.html" class="header__link">
                <svg class="header__icon" width="24" height="24">
                    <use href="/images/icons.svg#film-icon"></use>
                </svg>
                <span class="header__logo">Filmoteka</span>
            </a>

            <div class="flex-thumb">

                <nav class="site-nav">

                    <ul class="site-nav__list">
                        <li class="site-nav__item"> <a class="site-nav__link is-active">HOME</a></li>
                        <li class="site-nav__item"> <a class="site-nav__link ">FILMS</a></li>
                        <li class="site-nav__item"> <a class="site-nav__link">MY LIBRARY</a></li>
                    </ul>

                </nav>

                <div class="auth">
                    <button class="auth__button"><span class="auth__name">LOG IN</span>
                        <svg width="20" height="20" class="icon">
                            <use href="./images/icons.svg#non-auth-user"></use>
                        </svg>
                    </button>
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