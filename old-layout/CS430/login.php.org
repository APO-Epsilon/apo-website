<?php
$pdo = new PDO('mysql:dbname=mydb', 'myuser', 'mypass');

$userService = new UserService($pdo, $_POST['username'], $_POST['password']);
if ($user_id = $userService->login()) {
    echo 'Logged in as user id: '.$user_id;
    $userData = $userService->getUser();
    // do stuff
} else {
    echo 'Invalid login';
}
?>