<?php
function fetchBookFromDb(): bool|array
{
    $link = createMySQLConnection();
    $query = 'SELECT book.isbn, book.title, book.author, book.publisher, book.publish_year, book.short_description, book.cover, genre.name 
                FROM genre INNER JOIN book ON genre.id = book.genre_id';
    $stmt = $link -> prepare($query);
    $stmt->execute();
    $results = $stmt->fetchAll();
    $link = null;
    return $results;
}

function addNewBook($newIsbn, $newTitle, $newAuthor, $newPub, $newPubyear, $newDesc, $genreId, $newCover)
{
    $results = 0;
    $link = createMySQLConnection();
    $link -> beginTransaction();
    $query = 'INSERT INTO book(isbn, title, author, publisher, publish_year, short_description, genre_id, cover) VALUES (?, ?, ?, ?, ?, ?, ?, ?)';
    $stmt = $link -> prepare($query);
    $stmt -> bindParam(1, $newIsbn);
    $stmt -> bindParam(2, $newTitle);
    $stmt -> bindParam(3, $newAuthor);
    $stmt -> bindParam(4, $newPub);
    $stmt -> bindParam(5, $newPubyear);
    $stmt -> bindParam(6, $newDesc);
    $stmt -> bindParam(7, $genreId);
    $stmt -> bindParam(8, $newCover);
    if ($stmt -> execute()) {
      $link -> commit();
      $results = 1;
    } else {
      $link -> rollBack();
    }
    $link = null;
    return $results;
}

function fetchOneBook($isbn) 
{
    $link = createMySQLConnection();
    $query = 'SELECT * FROM book WHERE isbn = ?';
    $stmt = $link -> prepare($query);
    $stmt -> bindParam(1, $isbn);
    $stmt->execute();
    $results = $stmt->fetch();
    $link = null;
    return $results;
}

function fetchOneGenreName($isbn)
{
    $link = createMySQLConnection();
    $query = 'SELECT genre.name FROM book INNER JOIN genre ON book.genre_id = genre.id
                WHERE isbn = ?';
    $stmt = $link -> prepare($query);
    $stmt -> bindParam(1, $isbn);
    $stmt->execute();
    $results = $stmt->fetch();
    $link = null;
    return $results;
}

function updateBookToDb($newIsbn, $newTitle, $newAuthor, $newPub, $newPubyear, $newDesc, $genreId) 
{
    $result = 0;
    $link = createMySQLConnection();
    $query = 'UPDATE book SET title = ?, author = ?, publisher = ?, publish_year = ?, short_description = ?, genre_id = ? WHERE isbn = ?';
    $stmt = $link -> prepare($query);
    $stmt -> bindParam(1, $newTitle, PDO::PARAM_STR);
    $stmt -> bindParam(2, $newAuthor, PDO::PARAM_STR);
    $stmt -> bindParam(3, $newPub, PDO::PARAM_STR);
    $stmt -> bindParam(4, $newPubyear, PDO::PARAM_STR);
    $stmt -> bindParam(5, $newDesc, PDO::PARAM_STR);
    $stmt -> bindParam(6, $genreId, PDO::PARAM_STR);
    $stmt -> bindParam(7, $newIsbn, PDO::PARAM_STR);
    if ($stmt -> execute()) {
      $link -> commit();
      $result = 1;
    } else {
      $link -> rollBack();
    }
    $link = null;
    return $result;
}

function deleteBookFromDb($isbn) 
{
    $result = 0;
    $link = createMySQLConnection();
    $link -> beginTransaction();
    $query = 'DELETE FROM book WHERE isbn = ?';
    $stmt = $link -> prepare($query);
    $stmt -> bindParam(1, $isbn);
    if ($stmt -> execute()) {
      $link -> commit();
      $result = 1;
    } else {
      $link -> rollBack();
    }
    $link = null;
    return $result;
}

function uploadCover($isbn, $fileName)
{
    $result = 0;
    $link = createMySQLConnection();
    $query = 'UPDATE book SET cover = ? WHERE isbn = ?';
    $stmt = $link -> prepare($query);
    $stmt -> bindParam(1, $fileName, PDO::PARAM_STR);
    $stmt -> bindParam(2, $isbn, PDO::PARAM_STR);
    if ($stmt -> execute()) {
      $link -> commit();
      $result = 1;
    } else {
      $link -> rollBack();
    }
    $link = null;
    return $result;
}