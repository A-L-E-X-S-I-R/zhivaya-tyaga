<?php

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $name = htmlspecialchars($_POST["name"] ?? '');
    $phone = htmlspecialchars($_POST["phone"] ?? '');
    $email = htmlspecialchars($_POST["email"] ?? '');
    $formats = $_POST["format"] ?? [];
    $message = htmlspecialchars($_POST["message"] ?? '');

    $date = date("d.m.Y H:i");

    // Формат участия массив → строка
    $formatsString = implode(", ", $formats);

    // Дополнительные колонки
    $company = ""; // пустая
    $status = "Непрочитано";

    $file = "applications.csv";

    $newFile = !file_exists($file);

    $handle = fopen($file, "a");

    if ($newFile) {
        fputcsv($handle, [
            "Дата",
            "ФИО",
            "Телефон",
            "Email",
            "Формат участия",
            "Комментарий",
            "Компания",
            "Статус"
        ], ";");
    }

    fputcsv($handle, [
        $date,
        $name,
        $phone,
        $email,
        $formatsString,
        $message,
        $company,
        $status
    ], ";");

    fclose($handle);

    echo json_encode(["success" => true]);
    exit;
}
