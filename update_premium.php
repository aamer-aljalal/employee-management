<?php

$dir = new RecursiveDirectoryIterator('resources/views');
$ite = new RecursiveIteratorIterator($dir);
$files = new RegexIterator($ite, '/.*\.blade\.php$/', RegexIterator::GET_MATCH);

foreach ($files as $file) {
    $path = $file[0];
    
    if (strpos($path, 'attendance_pdf.blade.php') !== false) {
        continue;
    }

    $content = file_get_contents($path);
    $originalContent = $content;

    // 1. Replace the old heavy card class and inline styles with .premium-card
    $content = preg_replace('/class="card[^"]*w-100[^"]*" style="[^"]*"/', 'class="premium-card mb-4"', $content);
    
    // 2. Replace table header to just use standard padding and border
    $content = preg_replace('/<div class="card-header[^>]*>/', '<div class="d-flex flex-wrap gap-3 justify-content-between align-items-center mb-3">', $content);
    
    // 3. Remove card-body wrapper classes, just use plain div or nothing.
    // Wait, let's keep a wrapper for table-responsive
    $content = str_replace('<div class="card-body p-0 pb-2">', '', $content);
    $content = str_replace('<div class="card-body p-0 pb-3">', '', $content);
    $content = str_replace('<div class="card-body p-0 pb-4">', '', $content);
    
    // Fix search wrapper HTML
    $oldSearch = '<div class="position-relative">
                    <i class="bi bi-search position-absolute top-50 translate-middle-y text-muted" style="right: 12px;"></i>
                    <input type="text" class="form-control form-control-sm rounded-pill table-search-input pe-4" placeholder="ابحث هنا..." style="width: 250px; background-color: #f8fafc; border-color: #e2e8f0; font-size: 0.85rem;">
                </div>';
    $newSearch = '<div class="search-wrapper">
                    <i class="bi bi-search"></i>
                    <input type="text" class="table-search-input" placeholder="...ابحث هنا">
                </div>';
    
    $content = str_replace($oldSearch, $newSearch, $content);
    
    // Replace old table classes with .premium-table
    $content = preg_replace('/<table class="table table-hover[^"]*">/', '<table class="premium-table">', $content);
    
    // Remove inline styles from <thead> and <tr>
    $content = preg_replace('/<tr style="background-color: #f1f5f9;">/', '<tr>', $content);
    $content = preg_replace('/<th[^>]*style="[^"]*"[^>]*>/', '<th>', $content);
    
    // Remove old py-2, ps-3, text-secondary classes from th
    $content = preg_replace('/<th class="[^"]*">/', '<th>', $content);
    
    // Remove old py-2, ps-3 from td
    $content = preg_replace('/<td class="[^"]*py-2[^"]*">/', '<td>', $content);
    
    if ($content !== $originalContent) {
        file_put_contents($path, $content);
        echo "Updated: $path\n";
    }
}
echo "Done.\n";
