<?php
include "config.php";

if($_SERVER["REQUEST_METHOD"] == "POST") {

    $ime = $_POST['ime'];
    $prezime = $_POST['prezime'];
    $email = $_POST['email'];

    $stmt = $conn->prepare("INSERT INTO users (ime, prezime, email) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $ime, $prezime, $email);

    if($stmt->execute()) {
        header("Location: index.php");
    } else {
        echo "Greška: " . $stmt->error;
    }

    $stmt->close();
}
?>