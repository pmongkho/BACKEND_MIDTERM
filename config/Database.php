<?php
class Database
{
    // db params
    private $host;
    private $db_name;
    private $username;
    private $password;
    private $conn;

    public function __construct(){
        $this->username = getenv('USERNAME');
        $this->password = getenv('PASSWORD');
        $this->db_name = getenv('DB_NAME');
        $this->host = getenv('HOST');
    }



    public function connect()
    {
        $this->conn = null;

        try {
            $this->conn = new PDO('pgsql:host=' . $this->host . ';dbname=' . $this->db_name, $this->username, $this->password);
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            // print 'Success';

        } catch (PDOException $e) {
            print 'Connection Error: ' . $e->getMessage();
        }

        return $this->conn;

    }

}

// $db = new Database;
// $db->connect();

?>