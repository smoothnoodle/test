<?php

require 'Collection.php';

$c = new Collection();

$c->add('foo');
$c->add('bar');
$c->add('dick');

//echo $c->toJson();
echo json_encode($c);
//echo count($c);

