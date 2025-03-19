<!DOCTYPE html>
<html lang="en">
<head><title>Complete Your Profile</title></head>
<body>
    <h2>Complete Your Profile (Teacher)</h2>
    <form method="POST">
        Firstname: <input type="text" name="firstname" value="<?= htmlspecialchars($user['firstname'] ?? '') ?>" required><br>
        Lastname: <input type="text" name="lastname" value="<?= htmlspecialchars($user['lastname'] ?? '') ?>" required><br>
        Email: <input type="email" name="email" value="<?= htmlspecialchars($user['email'] ?? '') ?>" required><br>
        <button type="submit">Save Profile</button>
    </form>
</body>
</html>
