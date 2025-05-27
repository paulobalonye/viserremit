<?php
/**
 * Complete Database Import Script for Digital Ocean MySQL
 * This script modifies SQL statements to handle primary key requirements
 */

// Database connection details
$host = 'db-mysql-nyc3-71993-do-user-22832758-0.k.db.ondigitalocean.com';
$port = 25060;
$database = 'defaultdb';
$username = 'doadmin';
$password = 'AVNS_uifyEPdbfSOU8MqN8cu';

// Path to SQL file
$sqlFile = 'install/database.sql';

echo "Starting complete database import...\n";

try {
    // Create PDO connection with SSL
    $dsn = "mysql:host={$host};port={$port};dbname={$database};charset=utf8mb4";
    $options = [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::MYSQL_ATTR_SSL_VERIFY_SERVER_CERT => false,
        PDO::MYSQL_ATTR_SSL_CA => null,
    ];
    
    $pdo = new PDO($dsn, $username, $password, $options);
    echo "✓ Connected to Digital Ocean database successfully\n";
    
    // Try to disable sql_require_primary_key
    try {
        $pdo->exec("SET SESSION sql_require_primary_key = 0");
        echo "✓ Disabled sql_require_primary_key for this session\n";
    } catch (PDOException $e) {
        echo "⚠ Warning: Could not disable sql_require_primary_key: " . $e->getMessage() . "\n";
    }
    
    // Check if SQL file exists
    if (!file_exists($sqlFile)) {
        throw new Exception("SQL file not found: {$sqlFile}");
    }
    
    // Read and process SQL file
    $sql = file_get_contents($sqlFile);
    if ($sql === false) {
        throw new Exception("Failed to read SQL file");
    }
    
    echo "✓ SQL file loaded successfully\n";
    
    // Clean and fix the SQL content
    $sql = str_replace(["\r\n", "\r"], "\n", $sql);
    $sql = preg_replace('/\/\*.*?\*\//s', '', $sql);
    $sql = preg_replace('/^--.*$/m', '', $sql);
    
    // Fix CREATE TABLE statements to ensure they have PRIMARY KEY
    $sql = preg_replace_callback(
        '/CREATE TABLE `([^`]+)` \((.*?)\) ENGINE=/s',
        function($matches) {
            $tableName = $matches[1];
            $tableContent = $matches[2];
            
            // Check if PRIMARY KEY is already defined
            if (strpos($tableContent, 'PRIMARY KEY') === false && strpos($tableContent, 'AUTO_INCREMENT') !== false) {
                // Find the AUTO_INCREMENT column and make it primary key
                $tableContent = preg_replace(
                    '/(`id`[^,]+AUTO_INCREMENT)/i',
                    '$1 PRIMARY KEY',
                    $tableContent
                );
            }
            
            return "CREATE TABLE `{$tableName}` ({$tableContent}) ENGINE=";
        },
        $sql
    );
    
    // Split into statements
    $statements = array_filter(
        array_map('trim', preg_split('/;\s*\n/', $sql)),
        function($stmt) {
            return !empty($stmt) && !preg_match('/^(--|\/\*|\s*$)/', $stmt);
        }
    );
    
    echo "✓ Found " . count($statements) . " SQL statements to execute\n";
    echo "✓ Processing statements...\n";
    
    $executed = 0;
    $skipped = 0;
    $errors = 0;
    
    foreach ($statements as $index => $statement) {
        // Skip empty statements
        if (empty(trim($statement))) {
            continue;
        }
        
        try {
            $pdo->exec($statement);
            $executed++;
            
            if ($executed % 25 == 0) {
                echo "  Executed {$executed} statements...\n";
            }
        } catch (PDOException $e) {
            $errorMsg = $e->getMessage();
            
            // Skip expected errors
            if (strpos($errorMsg, 'already exists') !== false ||
                strpos($errorMsg, 'Duplicate entry') !== false) {
                $skipped++;
                continue;
            }
            
            // Handle primary key errors by trying to fix the statement
            if (strpos($errorMsg, 'sql_require_primary_key') !== false) {
                echo "  Attempting to fix primary key issue for statement " . ($index + 1) . "...\n";
                
                // Try to add PRIMARY KEY to the statement
                if (preg_match('/CREATE TABLE `([^`]+)`/i', $statement, $matches)) {
                    $fixedStatement = preg_replace(
                        '/(`id`[^,]+AUTO_INCREMENT)/i',
                        '$1 PRIMARY KEY',
                        $statement
                    );
                    
                    try {
                        $pdo->exec($fixedStatement);
                        $executed++;
                        echo "  ✓ Fixed and executed statement " . ($index + 1) . "\n";
                        continue;
                    } catch (PDOException $e2) {
                        echo "  ✗ Still failed after fix: " . $e2->getMessage() . "\n";
                    }
                }
            }
            
            $errors++;
            if ($errors <= 5) {
                echo "  ✗ Error in statement " . ($index + 1) . ": " . substr($errorMsg, 0, 100) . "...\n";
            }
        }
    }
    
    echo "\n✓ Import process completed!\n";
    echo "  Executed: {$executed} statements\n";
    echo "  Skipped: {$skipped} statements (already existed)\n";
    echo "  Errors: {$errors} statements\n";
    
    // Verify import
    echo "\nVerifying import...\n";
    $tables = ['admins', 'users', 'general_settings', 'frontends', 'gateways', 'currencies'];
    $successfulTables = 0;
    
    foreach ($tables as $table) {
        try {
            $stmt = $pdo->query("SELECT COUNT(*) as count FROM {$table}");
            $count = $stmt->fetch()['count'];
            echo "  ✓ {$table}: {$count} records\n";
            $successfulTables++;
        } catch (PDOException $e) {
            echo "  ✗ {$table}: Not found\n";
        }
    }
    
    if ($successfulTables > 0) {
        echo "\n✅ Database import partially successful! ({$successfulTables}/{count($tables)} tables found)\n";
        
        // Try to get admin credentials
        try {
            $stmt = $pdo->query("SELECT username, email FROM admins LIMIT 1");
            $admin = $stmt->fetch();
            if ($admin) {
                echo "\n✓ Admin user found:\n";
                echo "  Username: " . $admin['username'] . "\n";
                echo "  Email: " . $admin['email'] . "\n";
            }
        } catch (PDOException $e) {
            echo "\n⚠ Admin table exists but could not read admin user\n";
        }
    } else {
        echo "\n⚠ No tables were successfully created. Manual import may be required.\n";
    }
    
    echo "\nNext Steps:\n";
    echo "1. If tables were created successfully, deploy to Digital Ocean App Platform\n";
    echo "2. If not, you may need to manually import via Digital Ocean's database console\n";
    echo "3. Access admin panel at: https://your-app-url/admin\n";
    echo "4. Default admin username is usually 'admin'\n";
    
} catch (Exception $e) {
    echo "✗ Fatal Error: " . $e->getMessage() . "\n";
    exit(1);
}
