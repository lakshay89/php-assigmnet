<?php
/**
 * Database Configuration & Connection Handler
 * EdTech Innovate - Online Course Website
 * 
 * Provides a robust PDO connection with error handling and prepared statements.
 */

// Prevent direct script execution if accessed outside root index/controllers
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Database Credentials & Settings
define('DB_HOST', getenv('DB_HOST') ?: '127.0.0.1');
define('DB_PORT', getenv('DB_PORT') ?: '3306');
define('DB_NAME', getenv('DB_NAME') ?: 'edtech_db');
define('DB_USER', getenv('DB_USER') ?: 'root');
define('DB_PASS', getenv('DB_PASS') !== false ? getenv('DB_PASS') : '');
define('DB_CHARSET', 'utf8mb4');

// Site Information & URL Settings
define('SITE_NAME', 'EdTech Innovate');
define('SITE_TAGLINE', 'Empowering Tomorrow\'s Tech Leaders Today');
define('CURRENCY_SYMBOL', '$');

// Set to true if running under Apache with mod_rewrite enabled (.htaccess)
// Set to false if running on basic servers without URL rewriting
define('ENABLE_CLEAN_URLS', true);

/**
 * Returns a PDO connection instance (Singleton pattern)
 * 
 * @return PDO
 * @throws PDOException
 */
function get_db_connection(): PDO {
    static $pdo = null;

    if ($pdo === null) {
        $dsn = sprintf(
            'mysql:host=%s;port=%s;dbname=%s;charset=%s',
            DB_HOST,
            DB_PORT,
            DB_NAME,
            DB_CHARSET
        );

        $options = [
            PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES   => false,
            PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES " . DB_CHARSET . " COLLATE utf8mb4_unicode_ci"
        ];

        try {
            $pdo = new PDO($dsn, DB_USER, DB_PASS, $options);
        } catch (PDOException $e) {
            // Log error internally; never reveal raw database credentials to the end user
            error_log('Database Connection Failure: ' . $e->getMessage());

            // Render a friendly maintenance/error display
            http_response_code(500);
            ?>
            <!DOCTYPE html>
            <html lang="en">
            <head>
                <meta charset="UTF-8">
                <meta name="viewport" content="width=device-width, initial-scale=1.0">
                <title>Database Connection Issue - <?php echo htmlspecialchars(SITE_NAME); ?></title>
                <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
            </head>
            <body class="bg-light d-flex align-items-center min-vh-100">
                <div class="container py-5">
                    <div class="row justify-content-center">
                        <div class="col-md-7 col-lg-6">
                            <div class="card shadow-sm border-0 rounded-4 p-4 text-center">
                                <div class="mb-3 text-warning">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="64" height="64" fill="currentColor" class="bi bi-database-exclamation" viewBox="0 0 16 16">
                                        <path d="M8 1c-1.573 0-3.022.289-4.096.777C2.823 2.26 2 2.978 2 3.82V5.5c0 .248.069.48.196.69A3.2 3.2 0 0 0 2 6.5v2.82c0 .248.069.48.196.69A3.2 3.2 0 0 0 2 10.5v1.68c0 .842.823 1.56 1.904 2.043C4.978 14.711 6.427 15 8 15c.571 0 1.126-.038 1.644-.11a1 1 0 0 1-.144-.89H8c-1.573 0-3.022-.289-4.096-.777C2.823 12.74 2 12.022 2 11.18v-1.1c.54.439 1.407.777 2.478 1.002C5.545 11.3 6.745 11.4 8 11.4c.36 0 .713-.008 1.057-.025a1 1 0 0 1 .443-.975V9.404c-.485.064-1 .096-1.5.096-1.573 0-3.022-.289-4.096-.777C2.823 8.24 2 7.522 2 6.68v-1.1c.54.439 1.407.777 2.478 1.002C5.545 6.8 6.745 6.9 8 6.9c.742 0 1.46-.035 2.13-.102a1 1 0 0 1 .87-.898V4.82c0-.842-.823-1.56-1.904-2.043C7.978 2.289 6.527 2 5 2c-.36 0-.713.008-1.057.025a1 1 0 0 1-.443.975V4.596c.485-.064 1-.096 1.5-.096 1.573 0 3.022.289 4.096.777.904.412 1.404 1.004 1.404 1.683v.1a1 1 0 0 1 1 1v-.1c0-.842-.823-1.56-1.904-2.043C11.022 1.289 9.573 1 8 1"/>
                                        <path d="M16 12.5a3.5 3.5 0 1 1-7 0 3.5 3.5 0 0 1 7 0m-3.5-2a.5.5 0 0 0-.5.5v1.5a.5.5 0 0 0 1 0V11a.5.5 0 0 0-.5-.5m0 4a.5.5 0 1 0 0-1 .5.5 0 0 0 0 1"/>
                                    </svg>
                                </div>
                                <h3 class="fw-bold mb-2">Database Connection Required</h3>
                                <p class="text-secondary small mb-4">
                                    The application could not connect to MySQL database <code><?php echo htmlspecialchars(DB_NAME); ?></code>.
                                </p>
                                <div class="bg-light-subtle text-start p-3 rounded-3 border small mb-4 font-monospace">
                                    <strong>Troubleshooting Checklist:</strong>
                                    <ul class="mb-0 mt-2 ps-3">
                                        <li>Ensure MySQL service is started in XAMPP or terminal.</li>
                                        <li>Import <code>database.sql</code> using phpMyAdmin or MySQL CLI.</li>
                                        <li>Check host: <code><?php echo htmlspecialchars(DB_HOST); ?></code>, port: <code><?php echo htmlspecialchars(DB_PORT); ?></code>.</li>
                                    </ul>
                                </div>
                                <a href="javascript:location.reload()" class="btn btn-primary rounded-pill px-4">Retry Connection</a>
                            </div>
                        </div>
                    </div>
                </div>
            </body>
            </html>
            <?php
            exit;
        }
    }

    return $pdo;
}
