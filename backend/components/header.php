<div class="screen-background">

    <div class="container animation-thumb">

        <header class="header">

            <a href="/" class="header__link">
                <svg class="header__icon" width="24" height="24">
                    <use href="/images/icons.svg#film-icon"></use>
                </svg>
                <span class="header__logo">Filmoteka</span>
            </a>

            <nav class="site-nav">

                <ul class="site-nav__list">
                    <li class="site-nav__item"> <a class="site-nav__link <?= $params['url'] === '/' ? 'is-active' : ''; ?>" href="/">HOME</a></li>
                    <li class="site-nav__item"> <a class="site-nav__link <?= explode('/$',  $params['url'])[0] === '/films' ? 'is-active' : ''; ?>" href="/films">FILMS</a></li>
                    <?= isset($_SESSION['user']) ?
                        ' <li class="site-nav__item  ' . ($params["url"] === "/library" ? "is-active" : "") . '"> <a class="site-nav__link" href="/library">LIBRARY</a></li>' : '';
                    ?>
                </ul>

            </nav>

            <div class="auth">
                <?= !isset($_SESSION['user']) ? '
                        <div class="auth__item"> 
                            <a class="auth__link ' . ($params["url"] === "/auth/login" ? "is-active" : "") . '" href="/auth/login">
                                LOG IN  
                            </a>
                        </div>
                        <div class="auth__item">
                             <a class="auth__link  ' . ($params["url"] === "/auth/signup" ? "is-active" : "") . '"  href="/auth/signup">
                                SIGN UP
                             </a>
                        </div>
                    ' : '<div class="auth__item">
                            <a class=" " href="/user">
                                <div class="auth__user">
                                    <img src="' . $_SESSION['user']["url_img"] . '" class="auth__img" height="38"  width="38"  >
                                    <span class="auth__text" > ' . $_SESSION['user']["username"] . '  </span>
                                </div>
                            </a>
                         </div>
                    <div class="auth__item"> <a class="auth__link" href="/auth/logout">LOG OUT</a></div>';
                ?>
            </div>

        </header>

    </div>
</div>