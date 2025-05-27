<?php
/**
 * Final Database Import Script for Digital Ocean MySQL
 * This script handles the sql_require_primary_key setting
 */

// Database connection details
$host = 'db-mysql-nyc3-71993-do-user-22832758-0.k.db.ondigitalocean.com';
$port = 25060;
$database = 'defaultdb';
$username = 'doadmin';
$password = 'AVNS_uifyEPdbfSOU8MqN8cu';

// Path to SQL file
$sqlFile = 'install/database.sql';

echo "Starting final database import...\n";

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
        echo "  Continuing anyway...\n";
    }
    
    // Check if SQL file exists
    if (!file_exists($sqlFile)) {
        throw new Exception("SQL file not found: {$sqlFile}");
    }
    
    // Read and clean SQL file
    $sql = file_get_contents($sqlFile);
    if ($sql === false) {
        throw new Exception("Failed to read SQL file");
    }
    
    echo "✓ SQL file loaded successfully\n";
    
    // Use mysql command line tool for better compatibility
    $tempFile = tempnam(sys_get_temp_dir(), 'db_import_');
    file_put_contents($tempFile, $sql);
    
    // Build mysql command
    $command = sprintf(
        'mysql -h %s -P %d -u %s -p%s %s --ssl-mode=REQUIRED < %s 2>&1',
        escapeshellarg($host),
        $port,
        escapeshellarg($username),
        escapeshellarg($password),
        escapeshellarg($database),
        escapeshellarg($tempFile)
    );
    
    echo "✓ Executing import via mysql command line...\n";
    
    // Execute the command
    $output = [];
    $returnCode = 0;
    exec($command, $output, $returnCode);
    
    // Clean up temp file
    unlink($tempFile);
    
    if ($returnCode === 0) {
        echo "✓ Database import completed successfully!\n";
    } else {
        echo "⚠ Import completed with warnings/errors:\n";
        foreach ($output as $line) {
            if (!empty(trim($line))) {
                echo "  " . $line . "\n";
            }
        }
    }
    
    // Verify import by checking some key tables
    echo "\nVerifying import...\n";
    $tables = ['admins', 'users', 'general_settings', 'frontends', 'gateways'];
    
    foreach ($tables as $table) {
        try {
            $stmt = $pdo->query("SELECT COUNT(*) as count FROM {$table}");
            $count = $stmt->fetch()['count'];
            echo "  ✓ {$table}: {$count} records\n";
        } catch (PDOException $e) {
            echo "  ✗ {$table}: Table not found or error - " . $e->getMessage() . "\n";
        }
    }
    
    // Check if admin user exists
    try {
        $stmt = $pdo->query("SELECT username, email FROM admins LIMIT 1");
        $admin = $stmt->fetch();
        if ($admin) {
            echo "\n✓ Admin user found:\n";
            echo "  Username: " . $admin['username'] . "\n";
            echo "  Email: " . $admin['email'] . "\n";
        }
    } catch (PDOException $e) {
        echo "\n⚠ Could not verify admin user: " . $e->getMessage() . "\n";
    }
    
    echo "\n✅ Database setup completed!\n";
    echo "\nNext Steps:\n";
    echo "1. Deploy your application to Digital Ocean App Platform\n";
    echo "2. Access admin panel at: https://your-app-url/admin\n";
    echo "3. Use the admin credentials from the database\n";
    echo "4. Configure your payment gateways and settings\n";
    
} catch (Exception $e) {
    echo "✗ Error: " . $e->getMessage() . "\n";
    exit(1);
}
