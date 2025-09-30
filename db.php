<?php
$host = 'localhost';
$dbname = 'smotrodel';
$username = 'ваш_логин_БД';
$password = 'ваш_пароль_БД';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Ошибка подключения к БД: " . $e->getMessage());
}
?>
