-- Создание таблиц
CREATE TABLE services (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    price INT NOT NULL
);

CREATE TABLE doctors (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    specialty VARCHAR(255) NOT NULL,
    schedule TEXT,
    photo VARCHAR(255) DEFAULT 'default.jpg'
);

CREATE TABLE appointments (
    id INT AUTO_INCREMENT PRIMARY KEY,
    patient_name VARCHAR(255) NOT NULL,
    phone VARCHAR(20) NOT NULL,
    service VARCHAR(255) NOT NULL,
    appointment_date DATE NOT NULL,
    status ENUM('Новая', 'Подтверждена', 'Отменена') DEFAULT 'Новая',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE admin_users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL
);

-- Добавление администратора (пароль: 12345)
INSERT INTO admin_users (username, password) VALUES ('admin', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi');

-- Пример данных
INSERT INTO services (name, price) VALUES
('Приём терапевта', 2500),
('Кардиолог', 3200),
('УЗИ брюшной полости', 2800),
('Гинеколог', 3300),
('Анализы (общий)', 1200);

INSERT INTO doctors (name, specialty, schedule) VALUES
('Иванова Елена Алексеевна', 'Терапевт, Кардиолог', 'Пн–Пт: 9:00–18:00'),
('Петров Сергей Викторович', 'Гастроэнтеролог', 'Вт, Чт: 10:00–19:00'),
('Сидорова Мария Константиновна', 'Гинеколог-эндокринолог', 'Пн, Ср, Пт: 8:00–16:00');
