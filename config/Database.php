<?php
class Database
{
    // db params
    private $host;
    private $db_name;
    private $username;
    private $port;
    private $password;
    private $conn;

    public function __construct(){
        $this->username = getenv('USERNAME');
        $this->password = getenv('PASSWORD');
        $this->port = getenv('PORT');
        $this->db_name = getenv('DB_NAME');
        $this->host = getenv('HOST');
    }

// postgres://azulatech:kfQbXSZSmcZDfojslzinCNzHmSM7Gi8J@dpg-cgcacq5269v4icvgcqp0-a.ohio-postgres.render.com/quotesdb_pw4f

    public function connect()
    {
        $this->conn = null;

        $dsn = "pgsql:host={$this->host};dbname={$this->db_name};";

        try {
            // $this->conn = new PDO('pgsql:host=' . $this->host . ';dbname=' . $this->db_name, $this->username, $this->password);
            $this->conn = new PDO($dsn, $this->username, $this->password);
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