<?php
class DbConnect {
    public string $host;
    public string $user;
    public string $password;
    public string $dbname;

    public function __construct() {
    $this->host = "ec2-52-20-195-51.compute-1.amazonaws.com";
    $this->dbname = "myflixdb";

    $envFile = __DIR__ . '/.env';

    if (file_exists($envFile)) {
        $envVariables = parse_ini_file($envFile, false, INI_SCANNER_RAW);

        if ($envVariables !== false) {
            foreach ($envVariables as $key => $value) {
                putenv("$key=$value");
            }

            $this->user = getenv('DB_USERNAME');
            $this->password = getenv('DB_PASSWORD');
                       
        } else {
            
            error_log('Error reading .env file');
        }
    } else {
       
        error_log('.env file not found');
    }

    }

    public function connect() {
        try {
            $conn = new PDO('mysql:host=' . $this->host . '; dbname=' . $this->dbname, $this->user, $this->password);
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            return $conn;
        } catch(PDOException $e) {
            echo 'Database Error: ' . $e->getMessage();
            return null; 
        }
    }
}
?>