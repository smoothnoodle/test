<?php
$start = microtime(true);
for($i = 0; $i < 100000000; $i++)
    if(5 == 10) {}
$end = microtime(true);
echo "1: ".($end - $start)."<br />\n";
unset($start, $end);

$start = microtime(true);
for($i = 0; $i < 100000000; $i++)
    if('foobar' == 10) {}
$end = microtime(true);
echo "2: ".($end - $start)."<br />\n";
unset($start, $end);

$start = microtime(true);
for($i = 0; $i < 100000000; $i++)
    if(5 === 10) {}
$end = microtime(true);
echo "3: ".($end - $start)."<br />\n";
unset($start, $end);

$start = microtime(true);
for($i = 0; $i < 100000000; $i++)
    if('foobar' === 10) {}
$end = microtime(true);
echo "4: ".($end - $start)."<br />\n";
unset($start, $end);
?>