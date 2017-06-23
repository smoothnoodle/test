<?php
//may be this way doesn't work? I should just try to do it my way. 
//girl problem here. U worry about it before doing it. 
//keep you mind clear and calm and confident

//echo 'Hello World';

require 'Collection.php';

$c = new Collection();

$c->add('foo');
$c->add('bar');

$c->baz = 'qux';

//echo $c->get('baz');

//echo '<pre>' . print_r($c->all(), true);

//echo $c->get('baz');

echo $c->baz;

