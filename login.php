<!DOCTYPE html>
<html>

<head>
    <title>Login - Work Activity</title>
    <link rel="stylesheet" href="assets/css/style.css"> <!-- kalau ada -->
</head>

<body>

    <?php if (isset($_GET['error'])): ?>
        <script>
            alert("<?= htmlspecialchars($_GET['error']); ?>");
        </script>
    <?php endif; ?>

    <h1>Work Activity</h1>
    <p>Masukkan Username dan Password</p>
    <form method="POST" action="proses_login.php">
        <input type="text" name="username" placeholder="Username" required><br>
        <input type="password" name="password" placeholder="Password" required><br>
        <button type="submit">Login</button>
    </form>

</body>

</html>