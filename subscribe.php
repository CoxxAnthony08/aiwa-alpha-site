<?php
require 'config.php';

        $name = $_POST['name'];
        $number = $_POST['countryCode'] . $_POST['contactNum'];
        $email = $_POST['email'];
        $birthDay = $_POST['birthDay'];
        $gender = $_POST['gender'];
        $sub_month;
        $sub_year = date('Y');
        $sub_month = date('F');

try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $checkemail = $conn->prepare('SELECT email FROM subscribers WHERE email = :email');
    $checkemail->bindParam(':email', $email);
    $checkemail->execute();

    $checkcontact = $conn->prepare('SELECT number FROM subscribers WHERE number = :number');
    $checkcontact->bindParam(':number', $number);
    $checkcontact->execute();

    if ($checkemail->rowCount() > 0) {
        header('Location: index.html');
    } elseif ($checkcontact->rowCount() > 0) {
        header('Location: index.html');
    } else {
        $subscribe = $conn->prepare('INSERT INTO subscribers (name, number, email, birthday, gender, subscribed_month, subscribed_year) 
    VALUES (:name, :number, :email, :birthday, :gender,:subscribed_month,:subscribed_year)');
        $subscribe->bindParam(':name', $name);
        $subscribe->bindParam(':number', $number);
        $subscribe->bindParam(':email', $email);
        $subscribe->bindParam(':birthday', $birthDay);
        $subscribe->bindParam(':gender', $gender);
        $subscribe->bindParam(':subscribed_month', $sub_month);
        $subscribe->bindParam(':subscribed_year', $sub_year);

        //execute
        $subscribe->execute();

        header('Location: redirect.html');
    }
} catch (PDOException $e) {
    echo 'Error: ' . $e->getMessage();
}
$conn = null;
