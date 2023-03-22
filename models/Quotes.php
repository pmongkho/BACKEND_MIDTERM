<?php

include_once '../../config/Database.php';

class Quote
{
    private $conn;
    private $table = 'quotes';
    // properties
    public $id;
    public $category_id;
    public $category;
    public $author_id;
    public $author;
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
            a.author,
            q.quote,
            c.category
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
            a.author,
            c.category
        FROM ' . $this->table . ' q
        LEFT JOIN
            categories c ON q.category_id = c.id
        LEFT JOIN
            authors a ON q.author_id = a.id
        WHERE q.id = :id
        OR q.author_id = :author_id
        OR q.category_id = :category_id';

        // Prepared Statement
        $stmt = $this->conn->prepare($query);

        // Bind ID
        $stmt->bindParam(':id', $this->id);
        $stmt->bindParam(':author_id', $this->author_id);
        $stmt->bindParam(':category_id', $this->category_id);

        // Execute query
        $stmt->execute();

        return $stmt;
    }

    public function find_quote(){

        $query = 'SELECT * from quotes WHERE quote=:quote';

        // Prepared Statement
        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(':quote', $this->quote);

        // Execute query
        $stmt->execute();

        // Fetch row
        $row = $stmt->fetch(PDO::FETCH_ASSOC);


        // set properties
        $this->id = $row['id'] ?? null;
        $this->quote = $row['quote'] ?? null;
        $this->author_id= $row['author_id'] ?? null;
        $this->category_id = $row['category_id'] ?? null;

    }
    public function find_quote_id(){

        $query = 'SELECT * from quotes WHERE id=:id';

        // Prepared Statement
        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(':id', $this->id);

        // Execute query
        $stmt->execute();

        // Fetch row
        $row = $stmt->fetch(PDO::FETCH_ASSOC);


        // set properties
        $this->id = $row['id'] ?? null;
        $this->quote = $row['quote'] ?? null;
        $this->author_id = $row['author_id'] ?? null;
        $this->category_id = $row['category_id'] ?? null;
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