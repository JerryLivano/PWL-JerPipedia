<?php
$editedIsbn = filter_input(INPUT_GET, 'isbn');
if (isset($editedIsbn)) {
    $book = fetchOneBook($editedIsbn);
    $genreName = fetchOneGenreName($editedIsbn);
}

$updatePressed = filter_input(INPUT_POST, 'btnUpdate');
if (isset($updatePressed)) {
    $isbn = filter_input(INPUT_POST, 'isbn');
    $title = filter_input(INPUT_POST, 'judul');
    $author = filter_input(INPUT_POST, 'author');
    $pub = filter_input(INPUT_POST, 'publisher');
    $pubyear = filter_input(INPUT_POST, 'publish_year');
    $desc = filter_input(INPUT_POST, 'desc');
    $id = filter_input(INPUT_POST, 'genre_id');
    if ($_FILES['txtFile']["error"] != 4) {
        $targetDirectory = 'uploads/';
        $fileExtension = pathinfo($_FILES['txtFile']['name'], PATHINFO_EXTENSION);
        $cover = $book['isbn'] . '.' . $fileExtension;
        $fileUploadPath = $targetDirectory . $cover;
    }
    if (trim($title) == ' ') {
        echo '<div class="d-flex justify-content-center">Please fill updated title name</div>';
    } else if (trim($author) == ' ') {
        echo '<div class="d-flex justify-content-center">Please fill updated author name</div>';
    } else if (trim($pub) == ' ') {
        echo '<div class="d-flex justify-content-center">Please fill updated publisher name</div>';
    } else if (trim($pubyear) == ' ') {
        echo '<div class="d-flex justify-content-center">Please fill updated publisher year date</div>';
    } else if (trim($desc) == ' ') {
        echo '<div class="d-flex justify-content-center">Please fill updated description name</div>';
    } else if (trim($cover) == ' ') {
        echo '<div class="d-flex justify-content-center">Please fill updated cover name</div>';
    } else if (trim($id) == ' ') {
        echo '<div class="d-flex justify-content-center">Please fill updated genre name</div>';
    } else {
        if ($_FILES['txtFile']['error'] != 4) {
            if ($_FILES['txtFile']['size'] > 1024 * 2048) {
                echo '<div>Uploaded file exceed 2MB</div>';
            } else {
                $result_cover = uploadCover($book['isbn'], $cover);
                $results = updateBookToDb($book['isbn'], $title, $author, $pub, $pubyear, $desc, $id);
            }
        } else {
            $results = updateBookToDb($book['isbn'], $title, $author, $pub, $pubyear, $desc, $id);
        }
        if ($results) {
            if ($result_cover == 1) {
                unlink($fileUploadPath); 
                move_uploaded_file($_FILES['txtFile']['tmp_name'], $fileUploadPath); #Parameter : nama file temporary, tempat diuploadnya 
            }
            header('location:index.php?menu=book');
        } else {
            echo '<div class="d-flex justify-content-center">Failed to update data</div>';
        }
    }
}
?>

<div class="container ps-5 pe-5">
    <form method="post" enctype="multipart/form-data">
        <div class="form-row d-flex justify-content-center mb-3">
            <div class="form-group col-md-6 pe-2">
                <label for="isbn">ISBN</label>
                <input type="text" class="form-control" name="isbn" id="isbn" value="<?php echo $book['isbn']; ?>" disabled>
            </div>
            <div class="form-group col-md-6 ps-2">
                <label for="judul">Title</label>
                <input type="text" class="form-control" name="judul" id="judul" value="<?php echo $book['title']; ?>">
            </div>
        </div>
        <div class="form-group mb-3">
            <label for="author">Author</label>
            <input type="text" class="form-control" name="author" id="author" value="<?php echo $book['author']; ?>">
        </div>
        <div class="form-row d-flex justify-content-center mb-3">
            <div class="form-group col-md-8 pe-2">
                <label for="publisher">Publisher</label>
                <input type="text" class="form-control" name="publisher" id="publisher" value="<?php echo $book['publisher']; ?>">
            </div>
            <div class="form-group col-md-4 ps-2">
                <label for="publish_year">Publish Year</label>
                <input type="number" class="form-control" name="publish_year" id="publish_year" value="<?php echo $book['publish_year']; ?>">
            </div>
        </div>
        <div class="form-group mb-3">
            <label for="desc">Description</label>
            <textarea class="form-control" rows="5" name="desc" id="desc">
                <?php echo $book['short_description']; ?>
            </textarea>
        </div>
        <div class="form-group mb-3">
            <label for="cover">Cover</label><br>
            <img src="uploads/<?php echo $book['cover']; ?>" alt=" " width="100px">
            <input type="file" class="form-control my-3" name="txtFile" accept="image/*">
        </div>
        <div class="form-group mb-3">
            <label for="genre_id">Genre</label>
            <select class="form-select" aria-label="Default select example" name="genre_id" id="genre_id">
                <option value="<?php echo $book['genre_id']; ?>" selected><?php echo $genreName['name']; ?></option>
                <?php
                $results = fetchGenreFromDb();
                foreach ($results as $genre) {
                    if ($genre['id'] != $book['genre_id']) {
                        echo '<option value="' . $genre['id'] . '">' . $genre['name'] . '</option>';
                    }
                }
                ?>
            </select>
        </div>
        <!-- <div class="form-row">
            <div class="form-group col-md-6">
            <label for="inputCity">City</label>
            <input type="text" class="form-control" id="inputCity">
            </div>
            <div class="form-group col-md-4">
            <label for="inputState">State</label>
            <select id="inputState" class="form-control">
                <option selected>Choose...</option>
                <option>...</option>
            </select>
            </div>
            <div class="form-group col-md-2">
            <label for="inputZip">Zip</label>
            <input type="text" class="form-control" id="inputZip">
            </div>
        </div>
        <div class="form-group">
            <div class="form-check">
            <input class="form-check-input" type="checkbox" id="gridCheck">
            <label class="form-check-label" for="gridCheck">
                Check me out
            </label>
            </div>
        </div> -->
        <input type="submit" class="btn btn-dark mt-1" value="Update Data" name="btnUpdate"></input>
    </form>
