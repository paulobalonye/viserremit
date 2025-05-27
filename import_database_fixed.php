<?php
/**
 * Improved Database Import Script for Digital Ocean MySQL
 * This script handles SQL files with better parsing
 */

// Database connection details
$host = 'db-mysql-nyc3-71993-do-user-22832758-0.k.db.ondigitalocean.com';
$port = 25060;
$database = 'defaultdb';
$username = 'doadmin';
$password = 'AVNS_uifyEPdbfSOU8MqN8cu';

// Path to SQL file
$sqlFile = 'install/database.sql';

echo "Starting improved database import...\n";

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
    
    // Read and clean SQL file
    $sql = file_get_contents($sqlFile);
    if ($sql === false) {
        throw new Exception("Failed to read SQL file");
    }
    
    // Clean the SQL content
    $sql = str_replace(["\r\n", "\r"], "\n", $sql); // Normalize line endings
    $sql = preg_replace('/\/\*.*?\*\//s', '', $sql); // Remove multi-line comments
    $sql = preg_replace('/^--.*$/m', '', $sql); // Remove single-line comments
    $sql = preg_replace('/^\s*$/m', '', $sql); // Remove empty lines
    
    echo "✓ SQL file loaded and cleaned successfully\n";
    
    // Split SQL into statements more carefully
    $statements = [];
    $current_statement = '';
    $in_string = false;
    $string_char = '';
    
    for ($i = 0; $i < strlen($sql); $i++) {
        $char = $sql[$i];
        
        if (!$in_string && ($char === '"' || $char === "'")) {
            $in_string = true;
            $string_char = $char;
        } elseif ($in_string && $char === $string_char && $sql[$i-1] !== '\\') {
            $in_string = false;
        } elseif (!$in_string && $char === ';') {
            $current_statement = trim($current_statement);
            if (!empty($current_statement)) {
                $statements[] = $current_statement;
            }
            $current_statement = '';
            continue;
        }
        
        $current_statement .= $char;
    }
    
    // Add the last statement if it doesn't end with semicolon
    $current_statement = trim($current_statement);
    if (!empty($current_statement)) {
        $statements[] = $current_statement;
    }
    
    // Filter out empty statements
    $statements = array_filter($statements, function($stmt) {
        $stmt = trim($stmt);
        return !empty($stmt) && !preg_match('/^(--|\/\*|\s*$)/', $stmt);
    });
    
    echo "✓ Found " . count($statements) . " SQL statements to execute\n";
    
    // Execute statements one by one
    $executed = 0;
    $skipped = 0;
    
    foreach ($statements as $index => $statement) {
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
                strpos($e->getMessage(), 'Duplicate entry') !== false ||
                strpos($e->getMessage(), 'Table') !== false && strpos($e->getMessage(), 'already exists') !== false) {
                $skipped++;
                if ($skipped <= 5) { // Only show first 5 skipped statements
                    echo "  Skipped: " . substr($statement, 0, 50) . "... (already exists)\n";
                }
                continue;
            }
            
            // For other errors, show more details
            echo "✗ Error in statement " . ($index + 1) . ":\n";
            echo "  Statement: " . substr($statement, 0, 100) . "...\n";
            echo "  Error: " . $e->getMessage() . "\n";
            
            // Ask if we should continue
            echo "Continue with remaining statements? (y/n): ";
            $handle = fopen("php://stdin", "r");
            $line = fgets($handle);
            fclose($handle);
            
            if (trim(strtolower($line)) !== 'y') {
                throw $e;
            }
        }
    }
    
    echo "✓ Successfully executed {$executed} SQL statements\n";
    if ($skipped > 0) {
        echo "✓ Skipped {$skipped} statements (already existed)\n";
    }
    echo "✓ Database import completed successfully!\n\n";
    
    // Verify import by checking some key tables
    echo "Verifying import...\n";
    $tables = ['admins', 'users', 'general_settings', 'frontends'];
    
    foreach ($tables as $table) {
        try {
            $stmt = $pdo->query("SELECT COUNT(*) as count FROM {$table}");
            $count = $stmt->fetch()['count'];
            echo "  {$table}: {$count} records\n";
        } catch (PDOException $e) {
            echo "  {$table}: Table not found or error\n";
        }
    }
    
    echo "\n✓ Database verification completed!\n";
    echo "\nDefault Admin Credentials:\n";
    echo "  URL: https://your-app-url/admin\n";
    echo "  Username: admin\n";
    echo "  Email: admin@site.com\n";
    echo "  Password: You'll need to reset this via 'Forgot Password'\n";
    
} catch (Exception $e) {
    echo "✗ Error: " . $e->getMessage() . "\n";
    exit(1);
}
