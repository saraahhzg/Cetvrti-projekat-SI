<?php
include "config.php";

$id = $_GET['id'];

if($_SERVER["REQUEST_METHOD"] == "POST") {

    $ime = $_POST['ime'];
    $prezime = $_POST['prezime'];
    $email = $_POST['email'];

    $stmt = $conn->prepare("UPDATE users SET ime=?, prezime=?, email=? WHERE id=?");
    $stmt->bind_param("sssi", $ime, $prezime, $email, $id);
    $stmt->execute();

    header("Location: index.php");
}

$result = $conn->query("SELECT * FROM users WHERE id=$id");
$row = $result->fetch_assoc();
?>

<!DOCTYPE html>
<html>
<head>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="container mt-5">

<h2>Edit User</h2>

<form method="POST">
    <input type="text" name="ime" value="<?= $row['ime'] ?>" class="form-control mb-2" required>
    <input type="text" name="prezime" value="<?= $row['prezime'] ?>" class="form-control mb-2" required>
    <input type="email" name="email" value="<?= $row['email'] ?>" class="form-control mb-2" required>
    <button class="btn btn-success">Update</button>
</form>

</body>
</html>