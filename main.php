<?php

// Constants
// returnDatabaseExplorerTokenizedQuery
define('DATABASE_EXPLORER_TOKENIZED_STRING', 'SELECT TABLE_SCHEMA as `Database`, TABLE_NAME as `Table`, ROUND((DATA_LENGTH + INDEX_LENGTH) / 1024 / 1024, 2) AS `Size in MB`FROM information_schema.TABLES WHERE TABLE_SCHEMA = \'{$database_name}\'ORDER BY (DATA_LENGTH + INDEX_LENGTH) DESC;');
/**
 * MySQL Explorer
 *
 * A utility for dynamically exploring MySQL and MariaDB databases,
 * enabling the construction and management of database queries.
 * 
 * PHP version: 8.2+
 *
 * @author Tristan McGowan (tristan@ispy.net)
 */

/**
 * Main entry point of the application.
 * It checks and sanitizes GET variables before passing them to the init method.
 */
function main($args) {
    if(empty($args))
    {
        $args = [];
    }
    
    // List of expected GET variables. Add more as needed.
    $expected_vars = ['query_id', 'database_name', 'table_name'];

    foreach ($expected_vars as $var) {
        if (isset($_GET[$var])) {
            // Basic sanitization. Consider more specific sanitization based on the expected content.
            $args[$var] = filter_input(INPUT_GET, $var, FILTER_SANITIZE_STRING);
        }
    }

    // Additional security measures could be implemented here.

    // Initialize and pass sanitized arguments.
    $result = init($args);

    // Output or further process $result as needed.
    echo "<pre>";
    print_r($result);
    echo "</pre>";

    return ["body" => $result];
}

/**
 * Handles the main functionality based on provided arguments.
 * 
 * @param array $args Associative array of sanitized arguments.
 * @return array Result of the operation including status and data.
 */
function init(array $args): array {
    // Implementation of the previous main function goes here.
    // Extracting and validating variables...
    // Building and handling the query...
    // Returning the result...

    $query_id = $args['query_id'] ?? null;
    $database_name = $args['database_name'] ?? '';
    $table_name = $args['table_name'] ?? '';

    // Validate required parameters
    if (is_null($query_id)) {
        return ["status" => "error", "message" => "Query ID is required"];
    }

    // Build and handle the query based on the sanitized arguments.
    $result = buildQuery($query_id, $database_name, $table_name);

    // Return the processed result.
    return $result;
}

/**
 * Builds a database query based on a given query ID and parameters.
 *
 * @param int $query_id The identifier for the type of query to build.
 * @param string $database_name The name of the database to target.
 * @param string $table_name The name of the table to target.
 * @return array An associative array containing the status and the built query or an error message.
 */
function buildQuery(int $query_id, string $database_name = '', string $table_name = ''): array {
    // Initialize status and query.
    $status = 'success';
    $query = '';

    // Select the query based on the provided query ID.
    switch ($query_id) {
        case 1:
            $query = returnDatabaseExplorerTokenizedQuery($database_name);
            break;
        case 2:
            $query = returnTableColumnsQuery($database_name, $table_name);
            break;
        case 3:
            $query = returnTableIndexesQuery($database_name, $table_name);
            break;
        case 4:
            $query = returnTableRowCountQuery($database_name, $table_name);
            break;
        default:
            $status = 'error';
            $query = "Query ID not found!";
            break;
    }

    // Return the constructed query along with the status.
    return ['status' => $status, 'query' => $query];
}

/**
 * Returns a SQL query string for exploring database tables and their sizes.
 * 
 * @param string $database_name The name of the database to explore.
 * @return string A SQL query string.
 */
function returnDatabaseExplorerTokenizedQuery(string $database_name): string {
    // The SQL query for exploring database tables and sizes, with a placeholder for the database name.
    return "SELECT 
                TABLE_SCHEMA as `Database`, 
                TABLE_NAME as `Table`, 
                ROUND((DATA_LENGTH + INDEX_LENGTH) / 1024 / 1024, 2) AS `Size in MB`
            FROM 
                information_schema.TABLES 
            WHERE 
                TABLE_SCHEMA = '{$database_name}'
            ORDER BY 
                (DATA_LENGTH + INDEX_LENGTH) DESC;";
}

/**
 * Returns a SQL query string for listing columns in a specific table.
 * 
 * @param string $database_name The name of the database containing the table.
 * @param string $table_name The name of the table to explore.
 * @return string A SQL query string.
 */
function returnTableColumnsQuery(string $database_name, string $table_name): string {
    return "SELECT 
                TABLE_NAME as `Table`, 
                COLUMN_NAME as `Column`, 
                DATA_TYPE as `Data Type`, 
                IS_NULLABLE as `Is Nullable`
            FROM 
                information_schema.COLUMNS 
            WHERE 
                TABLE_SCHEMA = '{$database_name}' AND 
                TABLE_NAME = '{$table_name}'
            ORDER BY 
                ORDINAL_POSITION;";
}

/**
 * Returns a SQL query string for showing indexes for a specific table.
 * 
 * @param string $database_name The name of the database containing the table.
 * @param string $table_name The name of the table to explore.
 * @return string A SQL query string.
 */
function returnTableIndexesQuery(string $database_name, string $table_name): string {
    return "SELECT 
                TABLE_NAME as `Table`, 
                INDEX_NAME as `Index`, 
                COLUMN_NAME as `Column`, 
                INDEX_TYPE as `Type`
            FROM 
                information_schema.STATISTICS 
            WHERE 
                TABLE_SCHEMA = '{$database_name}' AND 
                TABLE_NAME = '{$table_name}'
            ORDER BY 
                INDEX_NAME, SEQ_IN_INDEX;";
}

/**
 * Returns a SQL query string for approximating the row count of a specific table.
 * 
 * @param string $database_name The name of the database containing the table.
 * @param string $table_name The name of the table to explore.
 * @return string A SQL query string.
 */
function returnTableRowCountQuery(string $database_name, string $table_name): string {
    return "SELECT 
                TABLE_NAME as `Table`, 
                TABLE_ROWS as `Approximate Row Count`
            FROM 
                information_schema.TABLES 
            WHERE 
                TABLE_SCHEMA = '{$database_name}' AND 
                TABLE_NAME = '{$table_name}';";
}

?>
