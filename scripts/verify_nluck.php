<?php

$root = dirname(__DIR__);
$fail = [];

foreach (new RecursiveIteratorIterator(new RecursiveDirectoryIterator($root.'/app')) as $file) {
    if ($file->getExtension() !== 'php') continue;
    exec('php -l '.escapeshellarg($file->getPathname()), $out, $code);
    if ($code !== 0) $fail[] = $file->getPathname();
}

$required = [
    'public/assets/nluck-wordmark.png',
    'public/studio/admin.html',
    'public/studio/index.html',
    'resources/views/admin/dashboard.blade.php',
    'routes/web.php',
];
foreach ($required as $path) if (!is_file($root.'/'.$path)) $fail[] = $root.'/'.$path;

if ($fail) {
    echo "NLUCK verification FAILED\n";
    foreach ($fail as $item) echo "- {$item}\n";
    exit(1);
}

echo "NLUCK verification OK\n";
