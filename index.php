<?php
require_once("config.php");

/*----- Call the information by id -------
$user = new User();
$user->loadById(4);
echo $user; --- */

/*------Call all information from table ---------
$list = User::getList();
echo json_encode($list); ------ */

/* ---------- Search for something
$all = User::search("d");
echo json_encode($all);----*/

$login = new User();

$login->login("root","root@!#");

echo $login;

?>