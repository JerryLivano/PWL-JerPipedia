<?php
    $deleteCommand = filter_input(INPUT_GET, 'cmd');
    if (isset($deleteCommand) && $deleteCommand == 'del') {
        $genreId = filter_input(INPUT_GET, 'gid');
        $result = deleteGenreFromDb($genreId);
        if ($result) {
            echo '<div class="d-flex justify-content-center">Data succesfully removed</div>';
        } else {
            echo '<div class="d-flex justify-content-center">Failed to remove data</div>';
        }
    }

    // Input Data
    $submitPressed = filter_input(INPUT_POST, 'btnSave');
    if (isset($submitPressed)) {
        $name = filter_input(INPUT_POST, 'txtName');
        if (trim($name) == ' '){
            echo '<div class="d-flex justify-content-center">alert("Please provide with a valid name</div>';
        } else {
            $results = addNewGenre($name);
            if ($results) {
                echo '<div class="d-flex justify-content-center">Data Succesfully Loaded</div>';
            } else {
                echo '<div class="d-flex justify-content-center">Failed to add data</div>';
            }
        }
    }
?>
<div class="container pt-4">
    <div class="d-flex justify-content-center">
        <form method="post" action="">
            <label for="txtName">Add Genre</label>
            <input type="text" maxlength="45" name="txtName" id="txtName" placeholder="Genre Name" required autofocus>
            <input type="submit" value="Save Data" name="btnSave">
        </form>
    </div>

    <div class="d-flex justify-content-center mt-4">
        <table class="table table-striped" style="width: 70%; text-align: center;">
            <thead class="thead-dark">
                <tr style="border-bottom: 1px;">
                <th scope="col">ID</th>
                <th scope="col">Name</th>
                <th scope="col">Action</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $results = fetchGenreFromDb();
                foreach ($results as $genre) {
                    echo '<tr>';
                    echo '<th scope = "row">' . $genre['id'] . '</th>';
                    echo '<td>' . $genre['name'] . '</td>';
                    echo '<td>
                        <button class="btn btn-warning" onclick="editGenre(' . $genre['id'] . ')">Update</button>
                        <button class="btn btn-danger" onclick="deleteGenre(' . $genre['id'] . ')">Delete</button>
                    </td>';
                    echo '</tr>';
                }
                ?>
            </tbody>
        </table>
    </div>
</div>

<script src="js/genre_index.js"></script>
<script>
  $(document).ready(function () {
    $('#myTable').DataTable();
  });
</script>