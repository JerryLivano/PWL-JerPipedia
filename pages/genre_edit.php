<?php
$editedId = filter_input(INPUT_GET, 'gid');
if (isset($editedId)) {
    $genre = fetchOneGenre($editedId);
}

$updatePressed = filter_input(INPUT_POST, 'btnUpdate');
if (isset($updatePressed)) {
    $name = filter_input(INPUT_POST, 'txtName');
    if (trim($name) == ' ') {
        echo '<div>Please fill updated genre name</div>';
    } else {
        $results = updateGenreToDb($genre['id'], $name);
        if ($results) {
            header('location:index.php?menu=genre');
        } else {
            echo '<div>Failed to update data</div>';
        }
    }
}
?>
<div class="container pt-4 ps-5 pe-5">
    <form method="post">
        <div class="form-row d-flex justify-content-center">
            <div class="form-group col-md-6 pe-2">
                <label for="txtId">Genre ID</label>
                <input type="text" class="form-control" name="txtId" id="txtId" value="<?php echo $genre['id']; ?>" disabled>
            </div>
            <div class="form-group col-md-6 ps-2">
                <label for="txtName">Genre Name</label>
                <input type="text" class="form-control" name="txtName" id="txtName" value="<?php echo $genre['name']; ?>">
            </div>
        </div>
        <input type="submit" class="btn btn-dark mt-3" value="Update" name="btnUpdate"></input>
    </form>
