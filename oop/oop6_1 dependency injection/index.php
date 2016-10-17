<?php

require 'chest.php';
require 'lock.php';

$chest = new Chest(new Lock);//wtf?? new lock
$chest->close();
$chest->open();
