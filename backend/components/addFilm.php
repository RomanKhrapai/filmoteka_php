<?PHP
if (basename(__FILE__) == basename($_SERVER['PHP_SELF'])) {
    header("Location: /");
    exit;
}

use Palmo\Core\service\Db;
use Palmo\Core\service\GenresService;


$db = new Db();
$dbh = $db->getHandler();

$genresService = new GenresService($dbh);

$genres = $genresService->getGenres();
?>

<form enctype="multipart/form-data" action="/addfilm" method="post">
    <div class="addfilm">
        <div>
            <label class="custom-label form__input">Image:
                <div id="fileInputshow">
                    <?php include 'components/uploadImage.php' ?>
                </div>
                <input type="hidden" name="MAX_FILE_SIZE" value="300000" />
                <input id="fileInput" type="file" name="img" accept=" image/jpeg" class=" custom-file-input  <?= (isset($_SESSION['errorsForm']['img'])) ? " error__input" : "" ?>">
            </label>
        </div>
        <div> <label class="custom-label form__input">Title:
                <input type="text" name="title" <?= (isset($_SESSION['formData']['title'])) ? "value = '{$_SESSION['formData']['title']}'" : "" ?> class="form__input custom-input  <?= (isset($_SESSION['errorsForm']['title'])) ? " error__input" : "" ?>">
                <?= (isset($_SESSION['errorsForm']['title'])) ? "<span class='auth-error'>{$_SESSION['errorsForm']['title']}</span>" : '' ?>
            </label>
            <br>

            <label class="custom-label form__input">Relise date:
                <input type="date" name="date" <?= (isset($_SESSION['formData']['date'])) ? "value = '{$_SESSION['formData']['date']}'" : "" ?> class="form__input custom-input  <?= (isset($_SESSION['errorsForm']['date'])) ? " error__input" : "" ?>">
                <?= (isset($_SESSION['errorsForm']['date'])) ? "<span class='auth-error'>{$_SESSION['errorsForm']['date']}</span>" : '' ?>
            </label>
            <br>
            <label class="custom-label form__input">GENRES:
                <select name="genres[]" multiple class="form__input custom-input  <?= (isset($_SESSION['errorsForm']['genres'])) ? " error__input" : "" ?>">
                    <?php
                    $defaultItems = isset($_SESSION['formData']['genres']) ? $_SESSION['formData']['genres'] : [];
                    foreach ($genres as $genre) {
                        $checked =  (in_array($genre['id'], $defaultItems)) ? "selected " : "";
                        echo "<option value='{$genre['id']}' $checked>{$genre['name']}</option>";
                    }
                    ?>
                </select>
                <?= (isset($_SESSION['errorsForm']['genres'])) ? "<span class='auth-error'>{$_SESSION['errorsForm']['genres']}</span>" : '' ?>
            </label>
            <br>
            <label class="custom-label form__input">ABOUT:
                <textarea name="about" rows="4" cols="50" class="form__input custom-input  <?= (isset($_SESSION['errorsForm']['about'])) ? " error__input" : "" ?>"><?= (isset($_SESSION['formData']['about'])) ? "{$_SESSION['formData']['about']}" : "" ?></textarea>
                <?= (isset($_SESSION['errorsForm']['about'])) ? "<span class='auth-error'>{$_SESSION['errorsForm']['about']}</span>" : '' ?>
            </label>
            <br>
        </div>
    </div>

    <input class="form__btn btn" type="submit" value="ADD FILM">
</form>
<?= $_SESSION['success'] ? '<div id="film-message" class="message"> Фільм додано</div>' : '' ?>
<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<script>
    $(document).ready(function() {
        console.log(11111);
        $('#fileInput').change(function() {

            if (this.files.length > 0) {
                const formData = new FormData();
                if (this.files[0].size < 2000000) {
                    formData.append('file', this.files[0]);
                } else {
                    const fileInput = document.getElementById('fileInput');
                    fileInput.value = '';
                    try {
                        fileInput.files = new FileList();
                    } catch (e) {
                        const dataTransfer = new DataTransfer();
                        fileInput.files = dataTransfer.files;
                    }
                    formData.append('size', 2000000);
                }
                $.ajax({
                    url: '/uploadimg',
                    type: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(response) {
                        document.getElementById('fileInputshow').innerHTML = response;
                    },
                    error: function(error) {
                        console.error('Ошибка загрузки файла:', error);
                    }
                });
            }
        });
        <?= $_SESSION['success'] ? "setTimeout(() => {
    const filmMessageElement = document.getElementById('film-message');
    if (filmMessageElement) {
        filmMessageElement.remove();
    }
}, 3000);" : "" ?>
    });
</script>


<?PHP
$_SESSION['success'] = null;
unset($_SESSION['errorsForm']);
unset($_SESSION['formData']);
unset($_SESSION['errorImg']);
?>