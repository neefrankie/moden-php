<?php
/**
 * Connect to database
 */
require './settings.php';

try {
    $pdo = new PDO(
        sprintf(
            'mysql:host=%s;dbname=%s;port=%s;charset=%s',
            $settings['host'],
            $settings['name'],
            $settings['port'],
            $settings['charset']
        ),
        $settings['username'],
        $settings['password']
    );
    $sql = 'SELECT user_id AS userId FROM cmstmp01.userinfo WHERE email = :email';
    $stmt = $pdo->prepare($sql);
    $email = filter_input(INPUT_GET, 'email');
    $stmt->bindValue(':email', $email);
    $stmt->execute();

    while (($result = $stmt->fetch(PDO::FETCH_ASSOC)) !== false) {
        print_r($result);
    }
} catch (PDOException $e) {
    echo "Database connection failed";
    exit;
}