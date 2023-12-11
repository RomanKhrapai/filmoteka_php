<?php

$maxI = $maxPage < 7 ? $maxPage : 6;

$startPage =  $page > 3 && $maxPage > 10 ? $page - 3 : 1;
$finishPage = $startPage + $maxI < $maxPage ? $startPage + $maxI : $maxPage;

if ($finishPage - $startPage < 7) {
    $startPage = $finishPage - 6;
}
if ($startPage < 1) {
    $startPage = 1;
}

$queryString = $_SERVER['QUERY_STRING'];

parse_str($queryString, $queryParams);
?>

<div class=' pagination'>
    <ul class="pagination_list">

        <?php
        if ($page > 1) {
            $queryParams['page'] = $page - 1;
            $queryPage = $url . "?" . http_build_query($queryParams);
            echo "<li class=' pagination_item'><a class=' pagination_link' href='$queryPage'><</a></li>";
        }

        if ($startPage > 1) {
            $queryParams['page'] = 1;
            $queryPage = $url . "?" . http_build_query($queryParams);
            echo "<li class=' pagination_item'><a class=' pagination_link' href='$queryPage'>1</a></li>";
            echo "<li class=' pagination_item'>...</li>";
        }

        for ($i = $startPage; $i <= $finishPage; $i++) {
            if ($finishPage == 1) {
                break;
            }
            $queryParams['page'] = $i;
            $queryPage = $url . "?" . http_build_query($queryParams);
            echo ($page == $i ?
                " <li class=' pagination_item pagination_active'>
                <a class=' pagination_link' href='$queryPage'>$i</a>
                </li>"
                : " <li class=' pagination_item'>
                <a class=' pagination_link' href='$queryPage'>$i </a>
            </li>");
        }

        if ($finishPage < $maxPage) {
            $queryParams['page'] = $maxPage;
            $queryPage = $url . "?" . http_build_query($queryParams);
            echo "<li class=' pagination_item'>...</li><li class=' pagination_item'><a class=' pagination_link' href='$queryPage'>$maxPage</a></li>";
        }
        if ($page < $maxPage) {
            $queryParams['page'] = $page + 1;
            $queryPage = $url . "?" . http_build_query($queryParams);
            echo " <li class=' pagination_item'><a class=' pagination_link' href='$queryPage'>></a></li>";
        }
        ?>
    </ul>
</div>