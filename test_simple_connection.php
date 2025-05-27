<?php
/**
 * Simple Database Connection Test
 * Tests basic connectivity with different timeout settings
 */

// Database connection details
$host = 'db-mysql-nyc3-71993-do-user-22832758-0.k.db.ondigitalocean.com';
$port = 25060;
$database = 'defaultdb';
$username = 'doadmin';
$password = 'AVNS_uifyEPdbfSOU8MqN8cu';

echo "=== Simple Database Connection Test ===\n\n";

// Test 1: Basic connectivity with extended timeout
echo "1. Testing basic connectivity with extended timeout...\n";

try {
    $dsn = "mysql:host={$host};port={$port};dbname={$database};charset=utf8mb4";
    $options = [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_TIMEOUT => 30, // 30 second timeout
        PDO::MYSQL_ATTR_SSL_VERIFY_SERVER_CERT => false,
        PDO::MYSQL_ATTR_SSL_CA => null,
    ];
    
    echo "   Attempting connection...\n";
    $pdo = new PDO($dsn, $username, $password, $options);
    echo "   ✅ Connection successful!\n";
    
    // Quick test query
    $stmt = $pdo->query("SELECT 1 as test");
    $result = $stmt->fetch();
    echo "   ✅ Query test successful: " . $result['test'] . "\n";
    
    // Check database
    $stmt = $pdo->query("SELECT DATABASE() as db");
    $db = $stmt->fetch();
    echo "   ✅ Connected to database: " . $db['db'] . "\n";
    
    // Check tables count
    $stmt = $pdo->query("SHOW TABLES");
    $tables = $stmt->fetchAll();
    echo "   ✅ Found " . count($tables) . " tables in database\n";
    
    echo "\n✅ Database connection is working properly!\n\n";
    
} catch (PDOException $e) {
    echo "   ❌ Connection failed: " . $e->getMessage() . "\n";
    
    // Try alternative connection methods
    echo "\n2. Trying alternative connection methods...\n";
    
    // Test without SSL
    try {
        echo "   Testing without SSL requirements...\n";
        $dsn = "mysql:host={$host};port={$port};dbname={$database};charset=utf8mb4";
        $options = [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_TIMEOUT => 15,
        ];
        
        $pdo = new PDO($dsn, $username, $password, $options);
        echo "   ✅ Connection without SSL successful!\n";
        
    } catch (PDOException $e2) {
        echo "   ❌ Alternative connection also failed: " . $e2->getMessage() . "\n";
        
        // Test with mysqli
        echo "\n3. Testing with MySQLi extension...\n";
        try {
            $mysqli = new mysqli($host, $username, $password, $database, $port);
            
            if ($mysqli->connect_error) {
                throw new Exception("MySQLi connection failed: " . $mysqli->connect_error);
            }
            
            echo "   ✅ MySQLi connection successful!\n";
            
            $result = $mysqli->query("SELECT 1 as test");
            if ($result) {
                $row = $result->fetch_assoc();
                echo "   ✅ MySQLi query test successful: " . $row['test'] . "\n";
            }
            
            $mysqli->close();
            
        } catch (Exception $e3) {
            echo "   ❌ MySQLi connection also failed: " . $e3->getMessage() . "\n";
        }
    }
}

// Test 2: Check if this is a network/firewall issue
echo "\n4. Network connectivity test...\n";

// Test if we can reach the host
$connection = @fsockopen($host, $port, $errno, $errstr, 10);
if ($connection) {
    echo "   ✅ Can reach {$host}:{$port} via socket\n";
    fclose($connection);
} else {
    echo "   ❌ Cannot reach {$host}:{$port} - Error: {$errstr} ({$errno})\n";
    echo "   This suggests a network connectivity or firewall issue\n";
}

// Test 3: Check Laravel database configuration
echo "\n5. Testing Laravel database configuration...\n";

if (file_exists('core/config/database.php')) {
    echo "   ✅ Laravel database config file exists\n";
    
    // Test Laravel artisan command for database connection
    echo "   Testing Laravel database connection...\n";
    
    $output = [];
    $returnCode = 0;
    exec('cd core && php artisan migrate:status 2>&1', $output, $returnCode);
    
    if ($returnCode === 0) {
        echo "   ✅ Laravel can connect to database\n";
        foreach ($output as $line) {
            if (!empty(trim($line))) {
                echo "      " . $line . "\n";
            }
        }
    } else {
        echo "   ⚠️  Laravel database connection test:\n";
        foreach ($output as $line) {
            if (!empty(trim($line))) {
                echo "      " . $line . "\n";
            }
        }
    }
} else {
    echo "   ❌ Laravel database config file not found\n";
}

echo "\n=== DIAGNOSIS ===\n";
echo "If the connection is failing, this could be due to:\n";
echo "1. Network connectivity issues from your local machine\n";
echo "2. Digital Ocean database firewall settings\n";
echo "3. SSL/TLS configuration requirements\n";
echo "4. Database server being temporarily unavailable\n\n";

echo "RECOMMENDATIONS:\n";
echo "1. Check Digital Ocean database firewall settings\n";
echo "2. Ensure your IP is whitelisted in Digital Ocean\n";
echo "3. Try connecting from Digital Ocean App Platform (where it will be deployed)\n";
echo "4. The database import was successful earlier, so the credentials are correct\n";
echo "5. This might be a temporary network issue\n";
