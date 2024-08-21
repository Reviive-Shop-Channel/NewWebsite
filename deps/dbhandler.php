<?php
class DBHandler {
    // DB Handler - Dakotath.
    public $dataBase;

    // Contructer.
    public function __construct($dbHost, $dbUser, $dbPass, $dbName, int $dbPort) {
        $this->dataBase = mysqli_connect("$dbHost", "$dbUser", "$dbPass", "$dbName", $dbPort);
        if (mysqli_connect_error()) {
            die("Brother, It seems like either thom tripped over the ethernet again or mysql is just being a big shitface today.");
        }
        //$this->install();
    }

    // Executer
    public function query($sql) {
        return $this->dataBase->query($sql);
    }

    // 2FA Prep.
    public function prep2FAStatement($stm) {

    }

    // Check if user already exists.
    public function checkUserExists($username) {
        $sql = "SELECT username FROM users WHERE username = \"$username\";";
        $result = $this->query($sql);
        if($result) {
            $rCnt = mysqli_num_rows($result);
            if($rCnt != 0) {
                return true;
            }
        }
        return false;
    }

    // Get user info.
    public function getUserInfo($username) {
        $sql = "SELECT * FROM users WHERE username = \"$username\";";
        $result = $this->query($sql);
        if($result) {
            $rCnt = mysqli_num_rows($result);
            if($rCnt != 0) {
                $rows = $result->fetch_all(MYSQLI_ASSOC);
                foreach($rows as $row) {
                    return $row; // I couldn't be ass'd to run SQL to get 1 row, so here's my method.
                }
            } else {
                $retD = [
                    'username' => '*&ERR_COMPLETELY_FUCKED_UP_DUDE&*',
                ];
                return $retD;
            }
        } else {
            die("SQL Problem 💀");
        }
    }

    public function updateUserInfo($username, $userData) {
        // Check if userData is an array and contains at least one item to update
        if (!is_array($userData) || empty($userData)) {
            throw new InvalidArgumentException('Invalid user data provided.');
        }
    
        // Create an array to hold SQL parts
        $setParts = [];
    
        // Prepare the SET clause
        foreach ($userData as $key => $value) {
            // Avoid SQL injection
            $escapedValue = htmlspecialchars($value);
            $setParts[] = "`$key` = '$escapedValue'";
        }
    
        // Join all SET parts into a single string
        $setClause = implode(', ', $setParts);
    
        // Prepare the SQL UPDATE statement
        $sql = "UPDATE users SET $setClause WHERE username = '$username'";
    
        // Execute the query
        $result = $this->query($sql);
    
        // Check for query success
        if ($result) {
            if (mysqli_affected_rows($this->dataBase) > 0) {
                return true; // Success
            } else {
                return false; // No rows affected (possibly username does not exist or no changes)
            }
        } else {
            die("SQL Problem 💀");
        }
    }

    public function doTelemetry($username, $telephone) {
        // Get user IP.
        $ip = "Unknown";
        if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
            $ip = $_SERVER['HTTP_CLIENT_IP'];
        } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
            $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
        } else {
            $ip = $_SERVER['REMOTE_ADDR'];
        }

        // Local?
        if($ip == "::1") {
            $ip = "localhost";
        }

        // Format.
        $telephone = htmlspecialchars($telephone);

        // Query the database.
        $sql = "INSERT INTO telemetry (
            ip, username, telephone
        ) VALUES (
            \"$ip\", \"$username\", \"$telephone\"
        );";
        $result = $this->query($sql);
        return $result;
    }

    private function install() {
        $installer = file_get_contents("../basedb.sql");
        $sqls = explode(';', $installer); 
        foreach ($sqls as $stmt) { 
            if (strlen($stmt) > 3 && substr(ltrim($stmt), 0, 2) != '/*') { 
                $result = $this->query($stmt); 
                if (!$result) {
                    die('Invalid query: ' . mysqli_error($conn)); 
                }
            } 
        }
    }
}