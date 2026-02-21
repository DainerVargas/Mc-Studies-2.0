<?php
require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Support\Facades\Schema;

$table = 'qualifications';
$columns = Schema::getColumnListing($table);
$results = [];
foreach ($columns as $column) {
    try {
        $type = Schema::getColumnType($table, $column);
        $results[] = "$column: $type";
    } catch (\Exception $e) {
        $results[] = "$column: error";
    }
}
file_put_contents('column_types.txt', implode("\n", $results));
echo "Done\n";
