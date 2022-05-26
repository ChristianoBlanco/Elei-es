<?php

include("resources/php/func_hashSalt.php");

echo md5("123456");
echo "<br>";
md5("teste");

echo password_hash("123456", PASSWORD_BCRYPT);
echo "<br>";

$unique_salt = unique_salt();
$password = '123456';

$hash = sha1($password);
echo $hash;

$hash = '$2y$10$kLyhLOdYOcb2IzZriP1z7eFawTD4xJw0ACV7I5YUc6lAP.ztqsZQu';

if (password_verify('123456', $hash)) {
    echo 'Password is valid!';
} else {
    echo 'Invalid password.';
}
?>