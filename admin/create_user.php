<?php
include('../includes/db.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT);
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $role = $_POST['role'];
    $country = $_POST['country'];
    $ip_address = $_SERVER['REMOTE_ADDR'];
    $profile_pic = '';

    if (isset($_FILES['profile_pic']) && $_FILES['profile_pic']['error'] == 0) {
        $target_dir = "../assets/images/";
        $profile_pic = basename($_FILES["profile_pic"]["name"]);
        move_uploaded_file($_FILES["profile_pic"]["tmp_name"], $target_dir . $profile_pic);
    }

    $sql = "INSERT INTO users (first_name, last_name, password, email, phone, profile_pic, role, country, ip_address) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssssssss", $first_name, $last_name, $password, $email, $phone, $profile_pic, $role, $country, $ip_address);
    $stmt->execute();

    header('Location: manage_users.php');
}

include('includes/sidebar.php');
?>

<div class="container mt-4">
    <div class="card">
        <div class="card-header">
            <h2><i class="fas fa-plus"></i> Add New User</h2>
        </div>
        <div class="card-body">
            <form action="create_user.php" method="POST" enctype="multipart/form-data">
                <div class="form-group">
                    <label for="first_name"><i class="fas fa-user"></i> First Name</label>
                    <input type="text" name="first_name" class="form-control" required>
                </div>
                <div class="form-group">
                    <label for="last_name"><i class="fas fa-user"></i> Last Name</label>
                    <input type="text" name="last_name" class="form-control" required>
                </div>
                <div class="form-group">
                    <label for="password"><i class="fas fa-lock"></i> Password</label>
                    <input type="password" name="password" class="form-control" required>
                </div>
                <div class="form-group">
                    <label for="email"><i class="fas fa-envelope"></i> Email</label>
                    <input type="email" name="email" class="form-control" required>
                </div>
                <div class="form-group">
                    <label for="phone"><i class="fas fa-phone"></i> Phone</label>
                    <input type="text" name="phone" class="form-control">
                </div>
                <div class="form-group">
                    <label for="profile_pic"><i class="fas fa-image"></i> Profile Picture</label>
                    <input type="file" name="profile_pic" class="form-control-file">
                </div>
                <div class="form-group">
                    <label for="role"><i class="fas fa-user-tag"></i> Role</label>
                    <select name="role" class="form-control" required>
                        <option value="user">User</option>
                        <option value="admin">Admin</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="country"><i class="fas fa-globe"></i> Country</label>
                    <input type="text" name="country" class="form-control">
                </div>
                <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Add User</button>
            </form>
        </div>
    </div>
</div>

<?php include('includes/footer.php'); ?>
