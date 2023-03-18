<?php
function login($email, $password)
{
    $link = createMySQLConnection();
    $query = 'SELECT id, name, email FROM user WHERE email = ? AND password = MD5(?)';
    $stmt = $link->prepare($query);
    $stmt -> bindParam(1, $email);
    $stmt -> bindParam(2, $password);
    $stmt -> execute(); 
    $user = $stmt->fetch();
    $link = null;
    return $user;
}

function addNewUser($newName, $newEmail, $newPassword)
{
    $result = 0;
    $link = createMySQLConnection();
    $link -> beginTransaction();
    $query = 'INSERT INTO user(name, email, password) VALUES (?, ?, MD5(?))';
    $stmt = $link -> prepare($query);
    $stmt -> bindParam(1, $newName);
    $stmt -> bindParam(2, $newEmail);
    $stmt -> bindParam(3, $newPassword);
    if ($stmt -> execute()) {
      $link -> commit();
      $result = 1;
    } else {
      $link -> rollBack();
    }
    $link = null;
    return $result;
}
