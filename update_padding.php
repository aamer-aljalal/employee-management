<?php

$dir = new RecursiveDirectoryIterator('resources/views');
$ite = new RecursiveIteratorIterator($dir);
$files = new RegexIterator($ite, '/.*\.blade\.php$/', RegexIterator::GET_MATCH);

$replacements = [
    'rounded-4' => 'rounded-3',
    'rounded-pill' => 'rounded-3',
    'px-4 pb-4' => 'px-3 pb-3',
    'px-4 py-3' => 'px-3 py-2',
    'py-3 px-4' => 'py-2 px-3',
    'p-4' => 'p-3',
    'px-4' => 'px-3',
    'py-3' => 'py-2',
    'ps-4' => 'ps-3',
    'pe-4' => 'pe-3',
];

foreach ($files as $file) {
    $path = $file[0];
    
    // Skip PDF template because we already optimized it manually for PDF
    if (strpos($path, 'attendance_pdf.blade.php') !== false) {
        continue;
    }
    // Skip attendance.blade.php because we already made detailed modifications there
    // Actually, maybe we can run it on attendance.blade.php if we missed any px-4, but let's be careful.
    
    $content = file_get_contents($path);
    $newContent = str_replace(array_keys($replacements), array_values($replacements), $content);
    
    if ($content !== $newContent) {
        file_put_contents($path, $newContent);
        echo "Updated: $path\n";
    }
}
echo "Done.\n";
