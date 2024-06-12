<?php
class Student {
    private $conn;
    private $table_name = "students";

    public function __construct($db) {
        $this->conn = $db;
    }

    public function read($offset, $limit) {
        $query = "SELECT * FROM " . $this->table_name . " LIMIT ?, ?";

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $offset, PDO::PARAM_INT);
        $stmt->bindParam(2, $limit, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt;
    }

    public function count() {
        $query = "SELECT count(*) as total FROM " . $this->table_name;
        $stmt = $this->conn->prepare($query);
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC)["total"];
    }
}
?>
