<?php
namespace App\Database;

class DatabaseAudit {
    private $db;
    private $config;
    private $tables = [];
    private $issues = [];
    private $recommendations = [];

    public function __construct() {
        $this->config = require dirname(dirname(__DIR__)) . '/config/database.php';
        $this->connectDB();
    }

    private function connectDB() {
        $env = getenv('APP_ENV') ?: 'development';
        $config = $this->config[$env];

        try {
            $dsn = "mysql:host={$config['host']};dbname={$config['dbname']};charset={$config['charset']}";
            $this->db = new \PDO($dsn, $config['username'], $config['password']);
            $this->db->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
        } catch(\PDOException $e) {
            die("Connection failed: " . $e->getMessage());
        }
    }

    /**
     * Run a full database audit
     * @return array Audit results
     */
    public function runAudit() {
        $this->getTables();
        $this->checkIndexes();
        $this->checkTableStructure();
        $this->checkQueryPerformance();
        $this->generateRecommendations();

        return [
            'tables' => $this->tables,
            'issues' => $this->issues,
            'recommendations' => $this->recommendations
        ];
    }

    /**
     * Get all tables in the database
     */
    private function getTables() {
        $stmt = $this->db->query("SHOW TABLES");
        $tableList = $stmt->fetchAll(\PDO::FETCH_COLUMN);
        
        foreach ($tableList as $table) {
            $this->tables[$table] = [
                'name' => $table,
                'columns' => $this->getTableColumns($table),
                'indexes' => $this->getTableIndexes($table),
                'row_count' => $this->getTableRowCount($table)
            ];
        }
    }

    /**
     * Get columns for a table
     * @param string $table Table name
     * @return array Columns
     */
    private function getTableColumns($table) {
        $stmt = $this->db->query("DESCRIBE `$table`");
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    /**
     * Get indexes for a table
     * @param string $table Table name
     * @return array Indexes
     */
    private function getTableIndexes($table) {
        $stmt = $this->db->query("SHOW INDEX FROM `$table`");
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    /**
     * Get row count for a table
     * @param string $table Table name
     * @return int Row count
     */
    private function getTableRowCount($table) {
        $stmt = $this->db->query("SELECT COUNT(*) FROM `$table`");
        return $stmt->fetchColumn();
    }

    /**
     * Check for missing indexes
     */
    private function checkIndexes() {
        foreach ($this->tables as $tableName => $table) {
            $hasIdIndex = false;
            $hasPrimaryKey = false;
            
            foreach ($table['indexes'] as $index) {
                if ($index['Key_name'] === 'PRIMARY') {
                    $hasPrimaryKey = true;
                }
                if ($index['Column_name'] === 'id') {
                    $hasIdIndex = true;
                }
            }
            
            if (!$hasPrimaryKey) {
                $this->issues[] = [
                    'table' => $tableName,
                    'type' => 'missing_primary_key',
                    'description' => "Table '$tableName' is missing a PRIMARY KEY"
                ];
            }
            
            if (!$hasIdIndex && $this->hasColumn($table['columns'], 'id')) {
                $this->issues[] = [
                    'table' => $tableName,
                    'type' => 'missing_id_index',
                    'description' => "Table '$tableName' has an 'id' column but no index on it"
                ];
            }
            
            // Check for foreign key columns that should be indexed
            foreach ($table['columns'] as $column) {
                if (preg_match('/_id$/', $column['Field']) && !$this->hasIndex($table['indexes'], $column['Field'])) {
                    $this->issues[] = [
                        'table' => $tableName,
                        'type' => 'missing_foreign_key_index',
                        'description' => "Table '$tableName' has a potential foreign key column '{$column['Field']}' without an index"
                    ];
                }
            }
        }
    }

    /**
     * Check if a column exists in a table
     * @param array $columns Columns
     * @param string $columnName Column name
     * @return bool
     */
    private function hasColumn($columns, $columnName) {
        foreach ($columns as $column) {
            if ($column['Field'] === $columnName) {
                return true;
            }
        }
        return false;
    }

    /**
     * Check if an index exists for a column
     * @param array $indexes Indexes
     * @param string $columnName Column name
     * @return bool
     */
    private function hasIndex($indexes, $columnName) {
        foreach ($indexes as $index) {
            if ($index['Column_name'] === $columnName) {
                return true;
            }
        }
        return false;
    }

    /**
     * Check table structure for optimization opportunities
     */
    private function checkTableStructure() {
        foreach ($this->tables as $tableName => $table) {
            // Check for redundant columns across tables
            $this->checkRedundantColumns($tableName, $table);
            
            // Check for tables that could be consolidated
            $this->checkTableConsolidation($tableName, $table);
            
            // Check for inefficient column types
            $this->checkColumnTypes($tableName, $table);
        }
    }

    /**
     * Check for redundant columns across tables
     * @param string $tableName Table name
     * @param array $table Table data
     */
    private function checkRedundantColumns($tableName, $table) {
        $commonColumns = ['product_name', 'brand', 'price', 'image_url', 'product_page_url', 'features'];
        $hasAllCommonColumns = true;
        
        foreach ($commonColumns as $column) {
            if (!$this->hasColumn($table['columns'], $column)) {
                $hasAllCommonColumns = false;
                break;
            }
        }
        
        if ($hasAllCommonColumns && $tableName !== 'products') {
            $this->issues[] = [
                'table' => $tableName,
                'type' => 'redundant_columns',
                'description' => "Table '$tableName' has the same structure as the 'products' table and could be consolidated"
            ];
        }
    }

    /**
     * Check for tables that could be consolidated
     * @param string $tableName Table name
     * @param array $table Table data
     */
    private function checkTableConsolidation($tableName, $table) {
        // Check if this is a product-specific table
        if (preg_match('/^(Alarmpakker|Alarmpaneler|Andet|Betjening|Sensorer|Sirener|Videoovervågning)$/', $tableName)) {
            $this->issues[] = [
                'table' => $tableName,
                'type' => 'table_consolidation',
                'description' => "Table '$tableName' could be consolidated into a single 'products' table with a 'category' column"
            ];
        }
    }

    /**
     * Check for inefficient column types
     * @param string $tableName Table name
     * @param array $table Table data
     */
    private function checkColumnTypes($tableName, $table) {
        foreach ($table['columns'] as $column) {
            // Check for TEXT columns that could be VARCHAR
            if (stripos($column['Type'], 'text') !== false) {
                $this->issues[] = [
                    'table' => $tableName,
                    'type' => 'inefficient_column_type',
                    'description' => "Column '{$column['Field']}' in table '$tableName' is using TEXT type which could be VARCHAR if the data is small"
                ];
            }
            
            // Check for INT columns that could be smaller
            if (stripos($column['Type'], 'int(11)') !== false) {
                $stmt = $this->db->query("SELECT MAX({$column['Field']}) FROM `$tableName`");
                $maxValue = $stmt->fetchColumn();
                
                if ($maxValue !== false && $maxValue < 32767) {
                    $this->issues[] = [
                        'table' => $tableName,
                        'type' => 'oversized_int',
                        'description' => "Column '{$column['Field']}' in table '$tableName' is using INT(11) but could be SMALLINT"
                    ];
                }
            }
        }
    }

    /**
     * Check query performance
     */
    private function checkQueryPerformance() {
        // This would typically involve analyzing slow query logs
        // For this implementation, we'll just add some general recommendations
        $this->issues[] = [
            'table' => 'all',
            'type' => 'query_optimization',
            'description' => "Consider implementing query caching for frequently accessed data"
        ];
        
        $this->issues[] = [
            'table' => 'all',
            'type' => 'connection_pooling',
            'description' => "Implement connection pooling to reduce database connection overhead"
        ];
    }

    /**
     * Generate recommendations based on issues
     */
    private function generateRecommendations() {
        foreach ($this->issues as $issue) {
            switch ($issue['type']) {
                case 'missing_primary_key':
                    $this->recommendations[] = "Add a PRIMARY KEY to table '{$issue['table']}'";
                    break;
                    
                case 'missing_id_index':
                    $this->recommendations[] = "Add an index on the 'id' column in table '{$issue['table']}'";
                    break;
                    
                case 'missing_foreign_key_index':
                    $this->recommendations[] = "Add an index on foreign key columns in table '{$issue['table']}'";
                    break;
                    
                case 'redundant_columns':
                case 'table_consolidation':
                    $this->recommendations[] = "Consider consolidating '{$issue['table']}' into the 'products' table with a 'category' column";
                    break;
                    
                case 'inefficient_column_type':
                    $this->recommendations[] = "Optimize column types in table '{$issue['table']}'";
                    break;
                    
                case 'oversized_int':
                    $this->recommendations[] = "Use smaller integer types where appropriate in table '{$issue['table']}'";
                    break;
                    
                case 'query_optimization':
                    $this->recommendations[] = "Implement query caching for frequently accessed data";
                    break;
                    
                case 'connection_pooling':
                    $this->recommendations[] = "Implement connection pooling to reduce database connection overhead";
                    break;
            }
        }
        
        // Remove duplicate recommendations
        $this->recommendations = array_unique($this->recommendations);
    }

    /**
     * Generate SQL to optimize the database
     * @return array SQL statements
     */
    public function generateOptimizationSQL() {
        $sql = [];
        
        foreach ($this->issues as $issue) {
            switch ($issue['type']) {
                case 'missing_primary_key':
                    if ($this->hasColumn($this->tables[$issue['table']]['columns'], 'id')) {
                        $sql[] = "ALTER TABLE `{$issue['table']}` ADD PRIMARY KEY (`id`);";
                    }
                    break;
                    
                case 'missing_id_index':
                    $sql[] = "ALTER TABLE `{$issue['table']}` ADD INDEX (`id`);";
                    break;
                    
                case 'missing_foreign_key_index':
                    // Extract column name from description
                    preg_match("/column '([^']+)'/", $issue['description'], $matches);
                    if (isset($matches[1])) {
                        $sql[] = "ALTER TABLE `{$issue['table']}` ADD INDEX (`{$matches[1]}`);";
                    }
                    break;
                    
                case 'inefficient_column_type':
                    // This would require more analysis to generate specific SQL
                    break;
                    
                case 'oversized_int':
                    // Extract column name from description
                    preg_match("/Column '([^']+)'/", $issue['description'], $matches);
                    if (isset($matches[1])) {
                        $sql[] = "ALTER TABLE `{$issue['table']}` MODIFY `{$matches[1]}` SMALLINT;";
                    }
                    break;
            }
        }
        
        // Add general optimization SQL
        $sql[] = "OPTIMIZE TABLE " . implode(', ', array_keys($this->tables)) . ";";
        
        return $sql;
    }

    /**
     * Save audit results to a file
     * @param string $filename Filename
     * @return bool Success
     */
    public function saveAuditResults($filename = null) {
        if ($filename === null) {
            $filename = dirname(dirname(__DIR__)) . '/logs/database_audit_' . date('Y-m-d_H-i-s') . '.json';
        }
        
        $results = [
            'timestamp' => date('Y-m-d H:i:s'),
            'tables' => $this->tables,
            'issues' => $this->issues,
            'recommendations' => $this->recommendations,
            'optimization_sql' => $this->generateOptimizationSQL()
        ];
        
        return file_put_contents($filename, json_encode($results, JSON_PRETTY_PRINT));
    }
} 