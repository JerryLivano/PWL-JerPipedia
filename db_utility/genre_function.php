<?php
function fetchGenreFromDb(): bool|array
{
    $link = createMySQLConnection();
    $query = 'SELECT id, name FROM genre';
    $stmt = $link -> prepare($query);
    $stmt->execute();
    $results = $stmt->fetchAll();
    $link = null;
    return $results;
}

function addNewGenre($newName)
{
    $result = 0;
    $link = createMySQLConnection();
    $link -> beginTransaction();
    $query = 'INSERT INTO genre(name) VALUES (?)';
    $stmt = $link -> prepare($query);
    $stmt -> bindParam(1, $newName);
    if ($stmt -> execute()) {
      $link -> commit();
      $result = 1;
    } else {
      $link -> rollBack();
    }
    $link = null;
    return $result;
}

function fetchOneGenre($id) 
{
    $link = createMySQLConnection();
    $query = 'SELECT id, name FROM genre WHERE id = ?';
    $stmt = $link -> prepare($query);
    $stmt -> bindParam(1, $id);
    $stmt->execute();
    $results = $stmt->fetch();
    $link = null;
    return $results;
} 

function updateGenreToDb($id, $newName) 
{
    $result = 0;
    $link = createMySQLConnection();
    $link -> beginTransaction();
    $query = 'UPDATE genre SET name = ? WHERE id = ?';
    $stmt = $link -> prepare($query);
    $stmt -> bindParam(1, $newName);
    $stmt -> bindParam(2, $id);
    if ($stmt -> execute()) {
      $link -> commit();
      $result = 1;
    } else {
      $link -> rollBack();
    }
    $link = null;
    return $result;
}

function deleteGenreFromDb($id) 
{
    $result = 0;
    $link = createMySQLConnection();
    $link -> beginTransaction();
    $query = 'DELETE FROM genre WHERE id = ?';
    $stmt = $link -> prepare($query);
    $stmt -> bindParam(1, $id);
    if ($stmt -> execute()) {
      $link -> commit();
      $result = 1;
    } else {
      $link -> rollBack();
    }
    $link = null;
    return $result;
}