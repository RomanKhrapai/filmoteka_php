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

<h3>edwfgwregwer</h3>

<form enctype="multipart/form-data" action="/addfilm" method="post">
    <label>Title:
        <input type="text" name="title" required>
    </label>
    <br>

    <label>Relise date:
        <input type="date" name="date" required>
    </label>
    <br>

    <label>Image:
        <input type="hidden" name="MAX_FILE_SIZE" value="30000" />
        <input type="file" name="img" accept="image/*">
    </label>
    <br>

    <label>GENRES:
        <select name="genres[]" multiple required>
            <?php
            foreach ($genres as $genre) {
                echo "<option value='{$genre['id']}'>{$genre['name']}</option>";
            }
            ?>
        </select>
    </label>
    <br>
    <label>ABOUT:
        <textarea name="about" rows="4" cols="50"></textarea>
    </label>
    <br>

    <input type="submit" value="ADD FILM">
</form>