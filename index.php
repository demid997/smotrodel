<?php
require_once 'db.php';

// Получаем услуги и врачей
$services = $pdo->query("SELECT * FROM services ORDER BY name")->fetchAll();
$doctors = $pdo->query("SELECT * FROM doctors ORDER BY name")->fetchAll();

// Обработка формы записи
if ($_POST) {
    $name = trim($_POST['name']);
    $phone = trim($_POST['phone']);
    $service = trim($_POST['service']);
    $date = $_POST['date'];

    if ($name && $phone && $service && $date) {
        $stmt = $pdo->prepare("INSERT INTO appointments (patient_name, phone, service, appointment_date) VALUES (?, ?, ?, ?)");
        $stmt->execute([$name, $phone, $service, $date]);
        $success = "Ваша заявка отправлена! Мы свяжемся с вами в ближайшее время.";
    } else {
        $error = "Заполните все поля.";
    }
}
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Частная поликлиника «Смотродел» — Здоровье в 2025</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <style>
        .service-card { transition: transform 0.3s; }
        .service-card:hover { transform: translateY(-5px); }
        .doctor-card img { width: 100%; height: 250px; object-fit: cover; }
        footer { background: #0d4a9e; color: white; padding: 30px 0; }
    </style>
</head>
<body>

<!-- Шапка -->
<nav class="navbar navbar-expand-lg navbar-dark bg-primary">
    <div class="container">
        <a class="navbar-brand fw-bold" href="#">
            Смотро<span class="text-warning">дел</span>
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item"><a class="nav-link" href="#services">Услуги</a></li>
                <li class="nav-item"><a class="nav-link" href="#doctors">Врачи</a></li>
                <li class="nav-item"><a class="nav-link" href="#appointment">Запись</a></li>
                <li class="nav-item"><a class="nav-link" href="#contact">Контакты</a></li>
                <li class="nav-item"><a class="nav-link btn btn-warning btn-sm text-primary fw-bold ms-2" href="admin/">Админка</a></li>
            </ul>
        </div>
    </div>
</nav>

<!-- Герой -->
<section class="bg-light py-5 text-center">
    <div class="container">
        <h1 class="display-4 fw-bold text-primary">Частная поликлиника «Смотродел»</h1>
        <p class="lead">Полный спектр медицинских услуг в 2025 году — быстро, комфортно, с заботой о вашем здоровье.</p>
    </div>
</section>

<!-- Услуги -->
<section id="services" class="py-5">
    <div class="container">
        <h2 class="text-center mb-5 text-primary">Наши услуги и цены</h2>
        <div class="row">
            <?php foreach ($services as $s): ?>
            <div class="col-md-6 col-lg-4 mb-4">
                <div class="card service-card h-100 shadow-sm">
                    <div class="card-body d-flex justify-content-between align-items-center">
                        <h5 class="card-title mb-0"><?= htmlspecialchars($s['name']) ?></h5>
                        <span class="badge bg-success fs-5"><?= number_format($s['price'], 0, '', ' ') ?> ₽</span>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<!-- Врачи -->
<section id="doctors" class="py-5 bg-light">
    <div class="container">
        <h2 class="text-center mb-5 text-primary">Наши врачи</h2>
        <div class="row">
            <?php foreach ($doctors as $d): ?>
            <div class="col-md-6 col-lg-4 mb-4">
                <div class="card doctor-card h-100 shadow-sm">
                    <img src="assets/img/default.jpg" alt="<?= htmlspecialchars($d['name']) ?>">
                    <div class="card-body">
                        <h5 class="card-title"><?= htmlspecialchars($d['name']) ?></h5>
                        <p class="text-muted"><?= htmlspecialchars($d['specialty']) ?></p>
                        <p><small><i class="fas fa-clock me-2"></i><?= htmlspecialchars($d['schedule']) ?></small></p>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<!-- Запись -->
<section id="appointment" class="py-5">
    <div class="container">
        <h2 class="text-center mb-4 text-primary">Записаться на приём</h2>
        <?php if (!empty($success)): ?>
            <div class="alert alert-success text-center"><?= $success ?></div>
        <?php elseif (!empty($error)): ?>
            <div class="alert alert-danger text-center"><?= $error ?></div>
        <?php endif; ?>
        <div class="row justify-content-center">
            <div class="col-md-8">
                <form method="POST" class="p-4 border rounded shadow-sm bg-white">
                    <div class="mb-3">
                        <label class="form-label">Ваше имя</label>
                        <input type="text" name="name" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Телефон</label>
                        <input type="tel" name="phone" class="form-control" placeholder="+7 (___) ___-__-__" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Услуга</label>
                        <select name="service" class="form-select" required>
                            <option value="">Выберите...</option>
                            <?php foreach ($services as $s): ?>
                                <option value="<?= htmlspecialchars($s['name']) ?>"><?= htmlspecialchars($s['name']) ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Желаемая дата</label>
                        <input type="date" name="date" class="form-control" min="<?= date('Y-m-d') ?>" required>
                    </div>
                    <button type="submit" class="btn btn-primary w-100">Отправить заявку</button>
                </form>
            </div>
        </div>
    </div>
</section>

<!-- Контакты -->
<section id="contact" class="py-5 bg-light">
    <div class="container text-center">
        <h2 class="text-primary mb-4">Контакты</h2>
        <p><strong>Адрес:</strong> г. Москва, ул. Здоровья, д. 15</p>
        <p><strong>Телефон:</strong> +7 (991) 656-51-83</p>
        <p><strong>Режим работы:</strong> Пн–Пт: 8:00–20:00, Сб: 9:00–18:00, Вс: выходной</p>
        <iframe src="https://www.google.com/maps/embed?pb=..." width="100%" height="300" style="border:0; margin-top:20px;" allowfullscreen></iframe>
    </div>
</section>

<!-- Подвал -->
<footer>
    <div class="container text-center">
        <p>© 2025 Частная поликлиника «Смотродел». Все права защищены.</p>
        <p>Лицензия № ЛО-77-01-023456 от 10.01.2023</p>
    </div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
