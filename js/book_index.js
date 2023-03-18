function editBook(isbn) {
    window.location = "index.php?menu=book_update&isbn=" + isbn;
}

function deleteBook(isbn) {
    const confirmation = window.confirm('Are you sure you want to delete this data?');
    if (confirmation) {
        window.location = "index.php?menu=book&cmd=del&isbn=" + isbn;
    }
}

function uploadImageBook(isbn) {
    window.location = "index.php?menu=image&isbn=" + isbn;
}