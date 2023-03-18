<?php

class Category
{
    private $conn;
    private $table = 'categories';
    public $id;
    public $category;

    // Constructor with DB
    public function __construct($db)
    {
        $this->conn = $db;
    }

    // Get
    public function read()
    {
        $query = 'SELECT * from ' . $this->table . '';

        // Prepared Statement
        $stmt = $this->conn->prepare($query);

        // Execture query
        $stmt->execute();

        return $stmt;
    }

    // Get Single
    public function read_single()
    {
        $query = 'SELECT * 
        FROM ' . $this->table . '
        WHERE id = ?';

        // Prepared Statement
        $stmt = $this->conn->prepare($query);

        // Bind ID
        $stmt->bindParam(1, $this->id);

        // Execture query
        $stmt->execute();

        // Fetch row
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        // set properties
        $this->id = $row['id'];
        $this->category = $row['category'];

    }

    // POST
    public function create()
    {
        // Create query
        $query = 'INSERT INTO ' . $this->table . ' (category)
                    VALUES (:category)';

        // Prepare statement
        $stmt = $this->conn->prepare($query);

        // Clean data
        $this->category = htmlspecialchars(strip_tags($this->category));

        // Bind Data
        $stmt->bindParam(':category', $this->category);

        // Execute query
        if ($stmt->execute()) {
            return true;
        }

        printf("Error: %s.\n", $stmt->error);

        return false;
    }

    // Update
    public function update()
    {
        // Create query
        $query = 'UPDATE ' . $this->table . ' 
                  SET category = :category
                  WHERE id = :id;';

        // Prepare statement
        $stmt = $this->conn->prepare($query);

        // Clean data
        $this->id = htmlspecialchars(strip_tags($this->id));
        $this->category = htmlspecialchars(strip_tags($this->category));

        // Bind Data
        $stmt->bindParam(':id', $this->id);
        $stmt->bindParam(':category', $this->category);

        // Execute query
        if ($stmt->execute()) {
            return true;
        }

        printf("Error: %s.\n", $stmt->error);

        return false;
    }

    // Delete Post
    public function delete()
    {
        // Create query
        $query = 'DELETE FROM ' . $this->table . ' WHERE id = :id';

        // Prepare statement
        $stmt = $this->conn->prepare($query);

        // Clean data
        $this->id = htmlspecialchars(strip_tags($this->id));

        // Bind data
        $stmt->bindParam(':id', $this->id);

        // Execute query
        if ($stmt->execute()) {
            return true;
        }

        printf("Error: %s.\n", $stmt->error);

        return false;

    }


}

?>