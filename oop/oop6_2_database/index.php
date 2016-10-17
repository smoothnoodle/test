<?php

require 'Database.php';
require 'User.php';

//echo "start";

$user = new User(new Database);//that's what learn this lesson

$user->create(['username' => 'Terry']);