<?php
session_start();
if (!isset($_SESSION['admin_id'])) {
    header('Location: login.php');
    exit;
}
require_once '../db.php';
$services_count = $pdo->query("SELECT COUNT(*) FROM services")->fetchColumn();
$doctors_count = $pdo->query("SELECT COUNT(*) FROM doctors")->fetchColumn();
$appointments_count = $pdo->query("SELECT COUNT(*) FROM appointments")->fetchColumn();
$new_appointments = $pdo->query("SELECT COUNT(*) FROM appointments WHERE status = 'Новая'")->fetchColumn();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Админка — Смотродел</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container-fluid">
    <nav class="navbar navbar-dark bg-primary mb-4">
        <div class="container">
            <a class="navbar-brand" href="#">Админка «Смотродел»</a>
            <a href="logout.php" class="btn btn-outline-light">Выйти</a>
        </div>
    </nav>

    <div class="row">
        <div class="col-md-3">
            <div class="list-group">
                <a href="dashboard.php" class="list-group-item list-group-item-action active">Главная</a>
                <a href="services.php" class="list-group-item list-group-item-action">Услуги и цены</a>
                <a href="doctors.php" class="list-group-item list-group-item-action">Врачи</a>
                <a href="appointments.php" class="list-group-item list-group-item-action">Записи пациентов</a>
            </div>
        </div>
        <div class="col-md-9">
            <h3>Статистика</h3>
            <div class="row">
                <div class="col-md-3"><div class="card bg-primary text-white"><div class="card-body">Услуг: <?= $services_count ?></div></div></div>
                <div class="col-md-3"><div class="card bg-success text-white"><div class="card-body">Врачей: <?= $doctors_count ?></div></div></div>
                <div class="col-md-3"><div class="card bg-warning text-dark"><div class="card-body">Всего записей: <?= $appointments_count ?></div></div></div>
                <div class="col-md-3"><div class="card bg-danger text-white"><div class="card-body">Новых: <?= $new_appointments ?></div></div></div>
            </div>
        </div>
    </div>
</div>
</body>
</html>
