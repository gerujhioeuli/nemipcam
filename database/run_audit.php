<?php
require_once dirname(__DIR__) . '/vendor/autoload.php';

use App\Database\DatabaseAudit;

// Run the audit
$audit = new DatabaseAudit();
$results = $audit->runAudit();

// Save the results to a file
$filename = dirname(__DIR__) . '/logs/database_audit_' . date('Y-m-d_H-i-s') . '.json';
$audit->saveAuditResults($filename);

// Display the results
echo "Database Audit Results\n";
echo "=====================\n\n";

echo "Issues Found: " . count($results['issues']) . "\n";
echo "Recommendations: " . count($results['recommendations']) . "\n\n";

echo "Issues:\n";
echo "-------\n";
foreach ($results['issues'] as $index => $issue) {
    echo ($index + 1) . ". {$issue['description']}\n";
}

echo "\nRecommendations:\n";
echo "---------------\n";
foreach ($results['recommendations'] as $index => $recommendation) {
    echo ($index + 1) . ". $recommendation\n";
}

echo "\nOptimization SQL:\n";
echo "----------------\n";
foreach ($audit->generateOptimizationSQL() as $sql) {
    echo "$sql\n";
}

echo "\nDetailed results saved to: $filename\n"; 