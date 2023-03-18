<?php
$isbnCover = filter_input(INPUT_GET, 'isbn');
if (isset($isbnCover)) {
    $bookIsbn = fetchOneBook($isbnCover);
}

$uploadPressed = filter_input(INPUT_POST, 'btnUpload');
if (isset($uploadPressed)) {
    $fileName = filter_input(INPUT_POST, 'txtFileName');
    $targetDirectory = 'uploads/';
    if ($_FILES['txtFile']['error'] != 4){
        $fileExtension = pathinfo($_FILES['txtFile']['name'], PATHINFO_EXTENSION);
        $newFileName = $fileName . '.' . $fileExtension;
        $fileUploadPath = $targetDirectory . $newFileName;
    } else {
        $newFileName = "default.jpg";
        unlink($targetDirectory."/".$bookIsbn['cover']);
        header('location:index.php?menu=book');
    }
    if ($_FILES['txtFile']['size'] > 1024 * 2048) {
        echo '<div>Uploaded file exceed 2MB</div>';
    } else {
        $result = uploadCover($fileName, $newFileName);
        if ($result == 1) {
            unlink($fileUploadPath); 
            move_uploaded_file($_FILES['txtFile']['tmp_name'], $fileUploadPath); #Parameter : nama file temporary, tempat diuploadnya 
            header('location:index.php?menu=book');
        } else {
            echo '<div>Uploaded file error</div>';
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>JeriPedia</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous" />
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Montserrat&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.3/css/dataTables.bootstrap5.min.css">
    <link
        rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/all.min.css"
        integrity="sha512-SzlrxWUlpfuzQ+pcUCosxcglQRNAq/DZjVsC0lE40xsADsfeQoEypE+enwcOiGjk/bSuGGKHEyjSoQ1zVisanQ=="
        crossorigin="anonymous"
        referrerpolicy="no-referrer"
    />
    <link rel="stylesheet" href="css/style.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>
<body>
    <div class="container pt-3">
        <div class="d-flex justify-content-center">
            <form method="post" enctype="multipart/form-data">
                <fieldset>
                    <legend class="mb-4" style="text-align: center; font-weight: bold;">Upload Image Here</legend>
                    <input type="number" class="form-control my-3" name="txtFileName" value="<?php echo $bookIsbn['isbn']; ?>" hidden>
                    <input type="file" class="form-control my-3" name="txtFile" accept="image/*">
                    <div>
                        <input type="submit" class="btn btn-dark mt-3" style="width: 100%;" name="btnUpload" value="Upload File">
                    </div>
                </fieldset>
            </form>
        </div>
    </div>
    <main>

    </main>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
    <script src="https://cdn.datatables.net/1.13.3/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.3/js/dataTables.bootstrap5.min.js"></script>
</body>
</html>
