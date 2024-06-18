<?php
include('../includes/session.php');
include('../includes/db.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'];
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $password = !empty($_POST['password']) ? password_hash($_POST['password'], PASSWORD_BCRYPT) : null;
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $role = $_POST['role'];
    $country = $_POST['country'];
    $ip_address = $_POST['ip_address'];
    $profile_pic = $_POST['existing_profile_pic'];

    if (isset($_FILES['profile_pic']) && $_FILES['profile_pic']['error'] == 0) {
        $target_dir = "../assets/images/";
        $profile_pic = basename($_FILES["profile_pic"]["name"]);
        move_uploaded_file($_FILES["profile_pic"]["tmp_name"], $target_dir . $profile_pic);
    }

    if ($password) {
        $sql = "UPDATE users SET first_name=?, last_name=?, password=?, email=?, phone=?, profile_pic=?, role=?, country=?, ip_address=? WHERE id=?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sssssssssi", $first_name, $last_name, $password, $email, $phone, $profile_pic, $role, $country, $ip_address, $id);
    } else {
        $sql = "UPDATE users SET first_name=?, last_name=?, email=?, phone=?, profile_pic=?, role=?, country=?, ip_address=? WHERE id=?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssssssssi", $first_name, $last_name, $email, $phone, $profile_pic, $role, $country, $ip_address, $id);
    }
    $stmt->execute();

    header('Location: manage_users.php');
}

$id = $_GET['id'];
$result = $conn->query("SELECT * FROM users WHERE id=$id");
$user = $result->fetch_assoc();

include('includes/sidebar.php');
?>

<div class="container mt-4">
    <div class="card">
        <div class="card-header">
            <h2><i class="fas fa-edit"></i> Edit User</h2>
        </div>
        <div class="card-body">
            <form action="edit_user.php?id=<?php echo $id; ?>" method="POST" enctype="multipart/form-data">
                <input type="hidden" name="id" value="<?php echo $user['id']; ?>">
                <input type="hidden" name="existing_profile_pic" value="<?php echo $user['profile_pic']; ?>">
                <div class="form-group">
                    <label for="first_name"><i class="fas fa-user"></i> First Name</label>
                    <input type="text" name="first_name" class="form-control" value="<?php echo $user['first_name']; ?>" required>
                </div>
                <div class="form-group">
                    <label for="last_name"><i class="fas fa-user"></i> Last Name</label>
                    <input type="text" name="last_name" class="form-control" value="<?php echo $user['last_name']; ?>" required>
                </div>
                <div class="form-group">
                    <label for="password"><i class="fas fa-lock"></i> Password (leave blank to keep current)</label>
                    <input type="password" name="password" class="form-control">
                </div>
                <div class="form-group">
                    <label for="email"><i class="fas fa-envelope"></i> Email</label>
                    <input type="email" name="email" class="form-control" value="<?php echo $user['email']; ?>" required>
                </div>
                <div class="form-group">
                    <label for="phone"><i class="fas fa-phone"></i> Phone</label>
                    <input type="text" name="phone" class="form-control" value="<?php echo $user['phone']; ?>">
                </div>
                <div class="form-group">
                    <label for="profile_pic"><i class="fas fa-image"></i> Profile Picture</label>
                    <input type="file" name="profile_pic" class="form-control-file">
                    <?php if ($user['profile_pic']): ?>
                        <img src="../assets/images/<?php echo $user['profile_pic']; ?>" alt="Profile Picture" width="100">
                    <?php endif; ?>
                </div>
                <div class="form-group">
                    <label for="role"><i class="fas fa-user-tag"></i> Role</label>
                    <select name="role" class="form-control" required>
                        <option value="user" <?php echo $user['role'] == 'user' ? 'selected' : ''; ?>>User</option>
                        <option value="admin" <?php echo $user['role'] == 'admin' ? 'selected' : ''; ?>>Admin</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="country"><i class="fas fa-globe"></i> Country</label>
                    <input type="text" name="country" class="form-control" value="<?php echo $user['country']; ?>">
                </div>
                <div class="form-group">
                    <label for="ip_address"><i class="fas fa-globe"></i> IP Address</label>
                    <input type="text" name="ip_address" class="form-control" value="<?php echo $user['ip_address']; ?>" readonly>
                </div>
                <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Save Changes</button>
            </form>
        </div>
    </div>
</div>

<?php include('includes/footer.php'); ?>
