<?php 
    use App\Database\UserDAO;
    use App\Models\User;

    $userDao = new UserDAO();
    $user = $userDao->get($id);

    $email = $user->getEmail();
    $password = $user->getPassword();
    $name = $user->getName();
    $balance = $user->getBalance();

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $email = $_POST['email'];
        $password = $_POST['password'];
        $name = $_POST['name'];

        $user = $userDao->update(new User($id, $email, $password, $name, null, $balance));
        header("Location: /users");
    }
?>

<h2>Edit user</h2>
<a href="/users" >Back to List</a><br><br>

<form method="POST">
    <label for="email">Email:</label><br>
    <input type="email" id="email" name="email" value="<?= $email ?>"><br><br>

    <label for="password">Password:</label><br>
    <input type="password" id="password" name="password" value="<?= $password ?>"><br><br>

    <label for="name">Name:</label><br>
    <input type="text" id="name" name="name" value="<?= $name ?>"><br><br>

    <label for="balance">Balance:</label><br>
    <input type="number" id="balance" name="balance" value="<?= $balance ?>" readonly><br><br>

    <button type="submit">Save</button>
</form>
