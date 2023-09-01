<?php

$test = ['Labas', 'vakaras', 1, true];

$stdout = fopen('php://stdout', 'w');

$test = implode(' ', $test);

fwrite($stdout, $test);
// fwrite($stdout, "Hello world\n");
fclose($stdout);

?>