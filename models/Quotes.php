<?php

include_once '../../config/Database.php';

class Quote
{
    private $conn;
    private $table = 'quotes';
    // properties
    public $id;
    public $category_id;
    public $category_name;
    public $author_id;
    public $author_name;
    public $quote;

    // Constructor with DB
    public function __construct($db)
    {
        $this->conn = $db;
    }

    // Get
    public function read()
    {
        $query = 'SELECT  
            q.id,
            a.author as author_name,
            q.quote,
            c.category as category_name
        FROM ' . $this->table . ' q
        LEFT JOIN
            categories c ON q.category_id = c.id
        LEFT JOIN
            authors a ON q.author_id = a.id';

        // Prepared Statement
        $stmt = $this->conn->prepare($query);

        // Execute query
        $stmt->execute();

        return $stmt;
    }

    // Get Single
    public function read_single()
    {
        $query = 'SELECT  
            q.id,
            q.quote,
            a.author as author_name,
            c.category as category_name
        FROM ' . $this->table . ' q
        LEFT JOIN
            categories c ON q.category_id = c.id
        LEFT JOIN
            authors a ON q.author_id = a.id
        WHERE q.id = ?';

        // Prepared Statement
        $stmt = $this->conn->prepare($query);

        // Bind ID
        $stmt->bindParam(1, $this->id);

        // Execute query
        $stmt->execute();

        // Fetch row
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        // set properties
        $this->id = $row['id'];
        $this->quote = $row['quote'];
        $this->author_name = $row['author_name'];
        $this->category_name = $row['category_name'];
    }

    // Create
    public function create()
    {
    
        // Create query
        $query = 'INSERT INTO ' . $this->table . '
        (id,quote, author_id, category_id)
        VALUES (default,:quote, :author_id, :category_id)';

        // Prepare statement
        $stmt = $this->conn->prepare($query);

        // Clean data
        $this->quote = htmlspecialchars(strip_tags($this->quote));
        $this->author_id = htmlspecialchars(strip_tags($this->author_id));
        $this->category_id = htmlspecialchars(strip_tags($this->category_id));

        // Bind Data
        $stmt->bindParam(':quote', $this->quote);
        $stmt->bindParam(':author_id', $this->author_id);
        $stmt->bindParam(':category_id', $this->category_id);

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
                  SET 
                    quote = :quote,
                    author_id = :author_id,
                    category_id = :category_id
                  WHERE id = :id';

        // Prepare statement
        $stmt = $this->conn->prepare($query);

        // Clean data
        $this->id = htmlspecialchars(strip_tags($this->id));
        $this->quote = htmlspecialchars(strip_tags($this->quote));
        $this->author_id = htmlspecialchars(strip_tags($this->author_id));
        $this->category_id = htmlspecialchars(strip_tags($this->category_id));

        // Bind Data
        $stmt->bindParam(':id', $this->id);
        $stmt->bindParam(':quote', $this->quote);
        $stmt->bindParam(':author_id', $this->author_id);
        $stmt->bindParam(':category_id', $this->category_id);

        // Execute query
        if ($stmt->execute()) {
            return true;
        }

        printf("Error: %s.\n", $stmt->error);

        return false;
    }

    // Delete
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