<?php
namespace App\Database;

class DatabaseOptimizer {
    private static $instance = null;
    private $queryCache = [];
    private $connectionPool = [];
    private $maxConnections = 10;
    private $config;
    private $queryLog = [];
    private $slowQueryThreshold = 1.0; // in seconds

    private function __construct() {
        $this->config = require dirname(dirname(__DIR__)) . '/config/database.php';
    }

    public static function getInstance() {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    /**
     * Get a database connection from the pool or create a new one
     * @param string $env Environment (development/production)
     * @return \PDO Database connection
     */
    public function getConnection($env = 'development') {
        // If connection exists in pool, return it
        if (isset($this->connectionPool[$env]) && count($this->connectionPool[$env]) > 0) {
            return array_pop($this->connectionPool[$env]);
        }

        // Create new connection
        $config = $this->config[$env];
        try {
            $dsn = "mysql:host={$config['host']};dbname={$config['dbname']};charset={$config['charset']}";
            $pdo = new \PDO($dsn, $config['username'], $config['password']);
            $pdo->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
            
            // Set additional performance optimizations
            $pdo->setAttribute(\PDO::ATTR_EMULATE_PREPARES, false); // Use native prepared statements
            $pdo->setAttribute(\PDO::ATTR_DEFAULT_FETCH_MODE, \PDO::FETCH_ASSOC); // Default fetch mode
            
            return $pdo;
        } catch(\PDOException $e) {
            throw new \Exception("Database connection failed: " . $e->getMessage());
        }
    }

    /**
     * Return a connection to the pool
     * @param \PDO $connection Database connection
     * @param string $env Environment (development/production)
     */
    public function releaseConnection($connection, $env = 'development') {
        if (!isset($this->connectionPool[$env])) {
            $this->connectionPool[$env] = [];
        }

        // Only add to pool if we haven't reached max connections
        if (count($this->connectionPool[$env]) < $this->maxConnections) {
            $this->connectionPool[$env][] = $connection;
        }
    }

    /**
     * Execute a cached query
     * @param \PDO $db Database connection
     * @param string $query SQL query
     * @param array $params Query parameters
     * @param int $ttl Cache time-to-live in seconds
     * @return array Query results
     */
    public function executeQuery($db, $query, $params = [], $ttl = 300) {
        $cacheKey = $this->generateCacheKey($query, $params);
        
        // Check if query is in cache and not expired
        if (isset($this->queryCache[$cacheKey]) && 
            (time() - $this->queryCache[$cacheKey]['time'] < $ttl)) {
            return $this->queryCache[$cacheKey]['data'];
        }
        
        // Execute query and time it
        $startTime = microtime(true);
        $stmt = $db->prepare($query);
        $stmt->execute($params);
        $result = $stmt->fetchAll();
        $endTime = microtime(true);
        
        $executionTime = $endTime - $startTime;
        
        // Log slow queries
        if ($executionTime > $this->slowQueryThreshold) {
            $this->logSlowQuery($query, $params, $executionTime);
        }
        
        // Cache the result
        $this->queryCache[$cacheKey] = [
            'data' => $result,
            'time' => time()
        ];
        
        return $result;
    }

    /**
     * Generate a cache key for a query
     * @param string $query SQL query
     * @param array $params Query parameters
     * @return string Cache key
     */
    private function generateCacheKey($query, $params) {
        return md5($query . serialize($params));
    }

    /**
     * Clear the query cache
     * @param string $cacheKey Specific cache key to clear (optional)
     */
    public function clearCache($cacheKey = null) {
        if ($cacheKey !== null) {
            unset($this->queryCache[$cacheKey]);
        } else {
            $this->queryCache = [];
        }
    }

    /**
     * Log a slow query
     * @param string $query SQL query
     * @param array $params Query parameters
     * @param float $executionTime Query execution time
     */
    private function logSlowQuery($query, $params, $executionTime) {
        $this->queryLog[] = [
            'query' => $query,
            'params' => $params,
            'execution_time' => $executionTime,
            'timestamp' => date('Y-m-d H:i:s')
        ];
        
        // Optionally write to a log file
        $logMessage = date('Y-m-d H:i:s') . " - Slow query ({$executionTime}s): {$query} - Params: " . json_encode($params) . PHP_EOL;
        file_put_contents(
            dirname(dirname(__DIR__)) . '/logs/slow_queries.log',
            $logMessage,
            FILE_APPEND
        );
    }

    /**
     * Get the slow query log
     * @return array Slow query log
     */
    public function getQueryLog() {
        return $this->queryLog;
    }

    /**
     * Set the slow query threshold
     * @param float $threshold Threshold in seconds
     */
    public function setSlowQueryThreshold($threshold) {
        $this->slowQueryThreshold = $threshold;
    }

    /**
     * Optimize a SELECT query by analyzing it
     * @param string $query SQL query
     * @return string Optimized query
     */
    public function optimizeQuery($query) {
        // Simple optimizations
        $optimizedQuery = $query;
        
        // Replace SELECT * with specific columns when possible
        if (stripos($optimizedQuery, 'SELECT *') !== false) {
            // This is a placeholder - in a real implementation, 
            // we would analyze the table structure and only select needed columns
        }
        
        // Add LIMIT if not present for large result sets
        if (stripos($optimizedQuery, 'LIMIT') === false && 
            stripos($optimizedQuery, 'SELECT') !== false) {
            // Only add LIMIT for queries that might return large result sets
            // This is a simplified example
        }
        
        return $optimizedQuery;
    }
} 