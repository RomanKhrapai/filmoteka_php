<?php

$maxI = $maxPage < 7 ? $maxPage : 6;

$startPage =  $page > 3 && $maxPage > 10 ? $page - 3 : 1;
$finishPage = $startPage + $maxI < $maxPage ? $startPage + $maxI : $maxPage;

if ($finishPage - $startPage < 7) {
    $startPage = $finishPage - 6;
}


?>

<div class=' pagination'>
    <ul class="pagination_list">

        <?php

        if ($page > 1) {
            $queryPage = $url . "?page=" . $page - 1;
            echo "<li class=' pagination_item'><a class=' pagination_link' href='$queryPage'><</a></li>";
        }

        if ($startPage > 1) {
            $queryPage = $url . "?page=" .  1;
            echo "<li class=' pagination_item'><a class=' pagination_link' href='$queryPage'>1</a></li>";
            echo "<li class=' pagination_item'>...</li>";
        }

        for ($i = $startPage; $i <= $finishPage; $i++) {
            echo ($page == $i ?
                " <li class=' pagination_item pagination_active'>
                <a class=' pagination_link' href='$url?page=$i'>$i</a>
                </li>"
                : " <li class=' pagination_item'>
                <a class=' pagination_link' href='$url?page=$i'>$i </a>
            </li>");
        }

        if ($finishPage < $maxPage) {
            echo "<li class=' pagination_item'>...</li>";
            $queryPage = $url . "?page=" .  $maxPage;
            echo "<li class=' pagination_item'><a class=' pagination_link' href='$queryPage'>$maxPage</a></li>";
        }
        if ($page < $maxPage) {
            $queryPage = $url . "?page=" . $page + 1;
            echo " <li class=' pagination_item'><a class=' pagination_link' href='$queryPage'>></a></li>";
        }
        ?>
    </ul>
</div>