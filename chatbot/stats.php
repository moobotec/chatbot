<?php
declare(strict_types=1);

header('Content-Type: application/json; charset=utf-8');
header('X-Content-Type-Options: nosniff');

$config = require __DIR__ . '/config.php';
$dirsByLang = $config['aiml_dirs_by_lang'] ?? [];
if (!is_array($dirsByLang)) {
    echo json_encode(['error' => 'Configuration AIML invalide.'], JSON_UNESCAPED_UNICODE);
    exit;
}

function listAimlFiles(array $dirs): array {
    $files = [];
    foreach ($dirs as $dir) {
        $dir = (string)$dir;
        if (!is_dir($dir)) {
            continue;
        }
        $iterator = new RecursiveIteratorIterator(
            new RecursiveDirectoryIterator($dir, FilesystemIterator::SKIP_DOTS)
        );
        foreach ($iterator as $file) {
            /** @var SplFileInfo $file */
            if (strtolower($file->getExtension()) === 'aiml') {
                $files[] = $file->getPathname();
            }
        }
    }
    return $files;
}

function countCategories(array $files): int {
    $count = 0;
    foreach ($files as $path) {
        $content = @file_get_contents($path);
        if ($content === false) {
            continue;
        }
        $lower = strtolower($content);
        $count += substr_count($lower, '<category');
    }
    return $count;
}

$response = [
    'total' => [
        'files' => 0,
        'categories' => 0,
    ],
    'langs' => [],
];

foreach ($dirsByLang as $lang => $dirs) {
    $files = listAimlFiles((array)$dirs);
    $categories = countCategories($files);
    $response['langs'][$lang] = [
        'files' => count($files),
        'categories' => $categories,
    ];
    $response['total']['files'] += count($files);
    $response['total']['categories'] += $categories;
}

echo json_encode($response, JSON_UNESCAPED_UNICODE);
