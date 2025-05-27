<?php
/**
 * Database Import Script for Digital Ocean MySQL
 * This script will import the database.sql file into your Digital Ocean database
 */

// Database connection details
$host = 'db-mysql-nyc3-71993-do-user-22832758-0.k.db.ondigitalocean.com';
$port = 25060;
$database = 'defaultdb';
$username = 'doadmin';
$password = 'AVNS_uifyEPdbfSOU8MqN8cu';

// Path to SQL file
$sqlFile = 'install/database.sql';

echo "Starting database import...\n";

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
    
    // Check if SQL file exists
    if (!file_exists($sqlFile)) {
        throw new Exception("SQL file not found: {$sqlFile}");
    }
    
    // Read SQL file
    $sql = file_get_contents($sqlFile);
    if ($sql === false) {
        throw new Exception("Failed to read SQL file");
    }
    
    echo "✓ SQL file loaded successfully\n";
    
    // Split SQL into individual statements
    $statements = array_filter(
        array_map('trim', explode(';', $sql)),
        function($stmt) {
            return !empty($stmt) && !preg_match('/^(--|\/\*|\s*$)/', $stmt);
        }
    );
    
    echo "✓ Found " . count($statements) . " SQL statements to execute\n";
    
    // Begin transaction
    $pdo->beginTransaction();
    
    $executed = 0;
    foreach ($statements as $statement) {
        try {
            $pdo->exec($statement);
            $executed++;
            
            // Show progress every 50 statements
            if ($executed % 50 == 0) {
                echo "  Executed {$executed} statements...\n";
            }
        } catch (PDOException $e) {
            // Skip certain errors that are expected
            if (strpos($e->getMessage(), 'already exists') !== false ||
                strpos($e->getMessage(), 'Duplicate entry') !== false) {
                echo "  Skipped: " . substr($statement, 0, 50) . "... (already exists)\n";
                continue;
            }
            throw $e;
        }
    }
    
    // Commit transaction
    $pdo->commit();
    
    echo "✓ Successfully executed {$executed} SQL statements\n";
    echo "✓ Database import completed successfully!\n\n";
    
    // Verify import by checking some key tables
    echo "Verifying import...\n";
    $tables = ['admins', 'users', 'general_settings', 'frontends'];
    
    foreach ($tables as $table) {
        $stmt = $pdo->query("SELECT COUNT(*) as count FROM {$table}");
        $count = $stmt->fetch()['count'];
        echo "  {$table}: {$count} records\n";
    }
    
    echo "\n✓ Database verification completed!\n";
    echo "\nDefault Admin Credentials:\n";
    echo "  URL: https://your-app-url/admin\n";
    echo "  Username: admin\n";
    echo "  Email: admin@site.com\n";
    echo "  Password: You'll need to reset this via 'Forgot Password'\n";
    
} catch (Exception $e) {
    if (isset($pdo) && $pdo->inTransaction()) {
        $pdo->rollBack();
    }
    echo "✗ Error: " . $e->getMessage() . "\n";
    exit(1);
}
