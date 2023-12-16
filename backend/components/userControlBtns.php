<div class="main__btn_box">
    <form method="get" action="/set/<?= $id  ?>/PANDING">
        <button type="submit" id="btn__watched" class="main__btn " data-action="add">
            <?= !$isPending ? 'ADD TO PANDING' : "IS PANDING" ?>
        </button>
    </form>
    <form method="get" action="/set/<?= $id  ?>/FAVIRITE">
        <button type="submit" id="btn__queue" class="main__btn" data-action="add">
            <?= !$isFavirite ? 'ADD TO FAVIRITE' : "IS FAVIRITE" ?>
        </button>
    </form>
</div>