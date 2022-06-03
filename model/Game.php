<?php
class Game
{
    // DB Stuff
    private $conn;
    private $table = 'games';

    // Game Properties
    public $id;
    public $genre_id;
    public $genre_name;
    public $user_id;
    public $author;
    public $title;
    public $link;
    public $image;
    public $video_link;
    public $created_at;
    public $page;

    // Constructor with DB
    public function __construct($db)
    {
        $this->conn = $db;
    }

    // Get games
    public function read()
    {
        if (!empty($this->page)) {
            $page = $this->page;
        } else {
            $page = 1;
        }

        $limit = 5;
        $offset = ($page - 1) * $limit;

        // Create query
        $query = 'SELECT 
                    games.id,
                    games.genre_id,
                    genres.name as genre_name,
                    games.title,
                    games.link,
                    games.video_link,
                    users.username,
                    games.created_at
                FROM
                    ' . $this->table  . '
                LEFT JOIN 
                    users ON games.user_id = users.id
                LEFT JOIN
                    genres ON games.genre_id = genres.id
                ORDER BY
                    games.created_at DESC LIMIT ?,? ';

        // Prepare statement
        $stmt = $this->conn->prepare($query);
        $stmt->bindValue(1, $offset, PDO::PARAM_INT);
        $stmt->bindValue(2, $limit, PDO::PARAM_INT);

        // Execute query
        $stmt->execute();

        return $stmt;
    }

    public function pagination()
    {
        if (!empty($this->page)) {
            $page = $this->page;
        } else {
            $page = 1;
        }

        $limit = 5;

        $stmt = $this->conn->prepare("SELECT * FROM $this->table");
        $stmt->execute();
        $total_records = $stmt->fetchAll(PDO::FETCH_ASSOC);

        if ($stmt->rowCount() > 0) {
            $total_page = ceil(count($total_records) / $limit);
            $previous = $page - 1;
            $next = $page + 1;

            $page > 1 ? $previous : $previous = 1;

            $next_ = $total_page > $page ? $next : $next - 1;

            return array("current_page" => $page, "previous_page" => $previous, "next_page" => $next_, "total_page" => $total_page);
        }
    }

    // Get game single
    public function read_single()
    {
        // Create query
        $query = 'SELECT 
                    games.id,
                    games.genre_id,
                    genres.name as genre_name,
                    games.title,
                    games.image,
                    games.link,
                    games.video_link,
                    games.user_id,
                    users.username,
                    games.created_at
                FROM
                    ' . $this->table  . '
                LEFT JOIN 
                    users ON games.user_id = users.id
                LEFT JOIN
                    genres ON games.genre_id = genres.id
                WHERE
                    games.id = ?';

        // Prepare statement
        $stmt = $this->conn->prepare($query);

        // Bind ID
        $stmt->bindParam(1, $this->id);

        // Execute query
        $stmt->execute();

        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        // Set Properties
        $this->title = $row['title'];
        $this->image = $row['image'];
        $this->link = $row['link'];
        $this->video_link = $row['video_link'];
        $this->author = $row['username'];
        $this->user_id = $row['user_id'];
        $this->genre_id = $row['genre_id'];
        $this->genre_name = $row['genre_name'];
        $this->created_at = $row['created_at'];
    }

    // Add new game
    public function create()
    {
        $query = 'INSERT INTO ' .
            $this->table . '
            SET 
                title = :title,
                image = :image,
                link = :link,
                video_link = :video_link,
                genre_id = :genre_id,
                user_id = :user_id';

        // Prepare Statement
        $stmt = $this->conn->prepare($query);

        // Clean Data
        $this->title = htmlspecialchars(strip_tags($this->title));
        $this->image = htmlspecialchars(strip_tags($this->image));
        $this->link = htmlspecialchars(strip_tags($this->link));
        $this->video_link = htmlspecialchars(strip_tags($this->video_link));
        $this->genre_id = htmlspecialchars(strip_tags($this->genre_id));
        $this->user_id = htmlspecialchars(strip_tags($this->user_id));

        // Bind data
        $stmt->bindParam(':title', $this->title);
        $stmt->bindParam(':image', $this->image);
        $stmt->bindParam(':link', $this->link);
        $stmt->bindParam(':video_link', $this->video_link);
        $stmt->bindParam(':genre_id', $this->genre_id);
        $stmt->bindParam(':user_id', $this->user_id);

        // Execute query
        if ($stmt->execute()) {
            return true;
        }

        // Print error if something goes wrong
        printf("Error: %s.\n", $stmt->error);

        return false;
    }


    // Update existed game
    public function update()
    {
        // Create query
        $query = 'UPDATE ' . $this->table . '
                    SET 
                        title = :title,
                        image = :image,
                        link = :link,
                        video_link = :video_link,
                        genre_id = :genre_id,
                        user_id = :user_id
                    WHERE id = :id';

        // Prepare Statement
        $stmt = $this->conn->prepare($query);

        // Clean Data
        $this->id = htmlspecialchars(strip_tags($this->id));
        $this->title = htmlspecialchars(strip_tags($this->title));
        $this->image = htmlspecialchars(strip_tags($this->image));
        $this->link = htmlspecialchars(strip_tags($this->link));
        $this->video_link = htmlspecialchars(strip_tags($this->video_link));
        $this->genre_id = htmlspecialchars(strip_tags($this->genre_id));
        $this->user_id = htmlspecialchars(strip_tags($this->user_id));

        // Bind data
        $stmt->bindParam(':id', $this->id);
        $stmt->bindParam(':title', $this->title);
        $stmt->bindParam(':image', $this->image);
        $stmt->bindParam(':link', $this->link);
        $stmt->bindParam(':video_link', $this->video_link);
        $stmt->bindParam(':genre_id', $this->genre_id);
        $stmt->bindParam(':user_id', $this->user_id);

        // Execute query
        if ($stmt->execute()) {
            return true;
        }

        // Print error if something goes wrong
        printf("Error: %s.\n", $stmt->error);

        return false;
    }

    // Delete selected game
    public function delete()
    {
        $check_image = 'SELECT games.image, games.id FROM ' . $this->table .
            ' WHERE id=:id';


        // Prepare Statement
        $stmt = $this->conn->prepare($check_image);

        // Clean Data
        $this->id = htmlspecialchars(strip_tags($this->id));

        // Bind Data
        $stmt->bindParam(':id', $this->id);

        // Execute query
        if ($stmt->execute()) {
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            if (!empty($row['id']) && !empty($row['image'])) {
                $file_with_path = $_SERVER['DOCUMENT_ROOT'] . '/vanilla/taniver-game/' . $row['image'];
                unlink($file_with_path);
                $query = 'DELETE FROM ' . $this->table . ' WHERE id = :id ';
                $stmt2 = $this->conn->prepare($query);
                $stmt2->bindParam(':id', $this->id);
                $stmt2->execute();
                return true;
            } else if (!empty($row['id'])) {
                $query = 'DELETE FROM ' . $this->table . ' WHERE id = :id ';
                $stmt2 = $this->conn->prepare($query);
                $stmt2->bindParam(':id', $this->id);
                $stmt2->execute();
                return true;
            }
            return false;
        }
    }
}
