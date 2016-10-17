<?php

require 'Database.php';
require 'User.php';

echo "start L6_2";
echo "<br>";
echo "<br>";

$user = new User(new Database);//that's what learn this lesson

$user->create(['username' => 'Terry']);//why? 