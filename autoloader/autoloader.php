<?php

declare(strict_types=1);

// taken and decoded data from conductor.json 
if (@file_get_contents('./autoloader/conductor.json')) {
    $configuration = json_decode(
        file_get_contents('./autoloader/conductor.json'),
        true
    );
} else {
    $configuration = json_decode(
        file_get_contents('./../autoloader/conductor.json'),
        true
    );
}

// determines the location of namespaces
$namespaces = $configuration['autoload']['psr-4'];


function fqcnToPath(string $fqcn, string $prefix): string {
    $relativeClass = ltrim($fqcn, $prefix);

    return str_replace('\\', '/', $relativeClass) . '.php';
}

// autoload registration and processing
spl_autoload_register(function (string $class) use ($namespaces) {
    $prefix = strtok($class, '\\') . '\\';

    if (!array_key_exists($prefix, $namespaces)) return;

    $baseDirectory = $namespaces[$prefix];
    $path = fqcnToPath($class, $prefix);

    require __DIR__ . '/../' . $baseDirectory . '/' . $path;
});

?>