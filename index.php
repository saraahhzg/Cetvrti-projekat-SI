<?php include "config.php"; ?>

<?php
$limit = 5;
$page = isset($_GET['page']) ? $_GET['page'] : 1;
$start = ($page - 1) * $limit;

$search = "";
if(isset($_GET['search'])){
    $search = $_GET['search'];
    $sql = "SELECT * FROM users 
            WHERE ime LIKE '%$search%' 
            OR prezime LIKE '%$search%' 
            OR email LIKE '%$search%'
            LIMIT $start, $limit";
    $resultTotal = $conn->query("SELECT COUNT(*) as total FROM users 
            WHERE ime LIKE '%$search%' 
            OR prezime LIKE '%$search%' 
            OR email LIKE '%$search%'");
} else {
    $sql = "SELECT * FROM users LIMIT $start, $limit";
    $resultTotal = $conn->query("SELECT COUNT(*) as total FROM users");
}

$result = $conn->query($sql);
$total = $resultTotal->fetch_assoc()['total'];
$pages = ceil($total / $limit);
?>

<!DOCTYPE html>
<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Admin Dashboard</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="assests/style.css">
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

</head>
<body>

<div class="wrapper">

<div class="sidebar">
    <h4 class="text-center mt-3 mb-4">Admin Panel</h4>
    <ul class="nav flex-column">
        <li class="nav-item">
            <a class="nav-link active">Dashboard</a>
        </li>
        <li class="nav-item">
            <a class="nav-link">Users</a>
        </li>
    </ul>
</div>

<div class="main">

<div class="topbar d-flex justify-content-between align-items-center px-4">
    <h5>User Management</h5>
    <div>Admin</div>
</div>

<div class="container-fluid mt-4">
<div class="card shadow mb-4">
<div class="card-body">

<form method="GET" class="row">
    <div class="col-md-10">
        <input type="text" name="search" class="form-control" placeholder="Search..." value="<?= $search ?>">
    </div>
    <div class="col-md-2">
        <button class="btn btn-dark w-100">Search</button>
    </div>
</form>

<hr>

<form action="create.php" method="POST" class="row g-3">
    <div class="col-md-4">
        <input type="text" name="ime" class="form-control" placeholder="Ime" required>
    </div>
    <div class="col-md-4">
        <input type="text" name="prezime" class="form-control" placeholder="Prezime" required>
    </div>
    <div class="col-md-4">
        <input type="email" name="email" class="form-control" placeholder="Email" required>
    </div>
    <div class="col-12 text-end">
        <button class="btn btn-primary">Add User</button>
    </div>
</form>

</div>
</div>
<div class="card shadow">
<div class="card-body p-0">

<div class="table-responsive">
<table class="table table-hover align-middle text-center">
<thead class="table-dark">
<tr>
<th>ID</th>
<th>Ime</th>
<th>Prezime</th>
<th>Email</th>
<th>Akcije</th>
</tr>
</thead>
<tbody>

<?php
if($result->num_rows > 0){
    while($row = $result->fetch_assoc()){
        echo "<tr>
            <td>{$row['id']}</td>
            <td>{$row['ime']}</td>
            <td>{$row['prezime']}</td>
            <td>{$row['email']}</td>
            <td>
                <a href='update.php?id={$row['id']}' class='btn btn-warning btn-sm'>Edit</a>
                <button onclick='confirmDelete({$row['id']})' class='btn btn-danger btn-sm'>Delete</button>
            </td>
        </tr>";
    }
} else {
    echo "<tr><td colspan='5'>No users found</td></tr>";
}
?>

</tbody>
</table>
</div>

</div>
</div>
<nav class="mt-4">
<ul class="pagination justify-content-center">
<?php for($i=1; $i<=$pages; $i++): ?>
<li class="page-item <?= ($i==$page)? 'active':'' ?>">
<a class="page-link" href="?page=<?= $i ?>&search=<?= $search ?>"><?= $i ?></a>
</li>
<?php endfor; ?>
</ul>
</nav>

</div>
</div>
</div>

<script>
function confirmDelete(id){
Swal.fire({
title: 'Are you sure?',
icon: 'warning',
showCancelButton: true,
confirmButtonColor: '#d33',
cancelButtonColor: '#3085d6',
confirmButtonText: 'Yes, delete it!'
}).then((result) => {
if(result.isConfirmed){
window.location = "delete.php?id=" + id;
}
});
}
</script>

</body>
</html>