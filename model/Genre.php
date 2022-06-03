<?php
class Genre
{
    // DB Stuff
    private $conn;
    private $table = 'genres';

    // Categories Properties
    public $id;
    public $name;
    public $created_at;

    // Constructor with DB
    public function __construct($db)
    {
        $this->conn = $db;
    }

    // Get genres
    public function read()
    {
        // Create Query
        $query = 'SELECT  genres.*, COUNT(games.genre_id) AS count FROM ' . $this->table . ' 
        LEFT JOIN games ON games.genre_id = genres.id 
        GROUP BY genres.id ORDER BY name ASC';

        // Prepare statement
        $stmt = $this->conn->prepare($query);

        // Execute Query
        $stmt->execute();

        return $stmt;
    }

    // Add genre
    public function create()
    {
        // Create Query
        $query = 'INSERT INTO ' .
            $this->table . ' 
            SET name = :name';

        // Prepare Statement
        $stmt = $this->conn->prepare($query);

        // Clean Data
        $this->name = htmlspecialchars(strip_tags($this->name));

        // Bind data
        $stmt->bindParam(':name', $this->name);

        // Execute Query
        if ($stmt->execute()) {
            return true;
        }

        // Print error if something goes wrong
        printf("Error: %s.\n", $stmt->error);

        return false;
    }

    // Delete selected genre
    public function delete()
    {
        //Create Query
        $query = 'DELETE FROM ' . $this->table . ' WHERE id = :id';

        // Prepare Statement
        $stmt = $this->conn->prepare($query);

        // Bind data
        $stmt->bindParam(':id', $this->id);

        // Execute Query
        if ($stmt->execute()) {
            return true;
        }

        // Print error if something goes wrong
        printf("Error: %s.\n", $stmt->error);

        return false;
    }
}
