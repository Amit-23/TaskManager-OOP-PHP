<?php
// conn.php

// CRUD Interface for standard database operations
interface CRUDInterface {
    public function insertData($taskname, $startdate, $enddate, $status);
    public function getData();
    public function updateData($id, $taskname, $startdate, $enddate, $status);
    public function deleteData($id);
}

// Abstract class for common database operations
abstract class BaseDatabase {
    protected $conn;

    // Establish the database connection (abstract method to be implemented by child class)
    abstract protected function connect();

    // Constructor to automatically establish connection
    public function __construct() {
        $this->connect();
    }

    // Close the database connection
    public function closeConnection() {
        $this->conn->close();
    }
}

// Database class implementing CRUD operations
class Database extends BaseDatabase implements CRUDInterface {
    private $username = 'root';
    private $password = '';
    private $server = 'localhost';
    private $db = 'todo';
    
    // Establish the database connection
    protected function connect() {
        $this->conn = new mysqli($this->server, $this->username, $this->password, $this->db, 8111);
        if ($this->conn->connect_error) {
            die("Connection failed: " . $this->conn->connect_error);
        }
    }

    // Insert data into the todo table
    public function insertData($taskname, $startdate, $enddate, $status) {
        $stmt = $this->conn->prepare("INSERT INTO todo (taskname, startdate, enddate, status) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssss", $taskname, $startdate, $enddate, $status);
        $result = $stmt->execute();
        $stmt->close();
        return $result;
    }

    // Get all data from the todo table
    public function getData() {
        $sql = "SELECT * FROM todo";
        $result = $this->conn->query($sql);
        return $result->num_rows > 0 ? $result->fetch_all(MYSQLI_ASSOC) : [];
    }

    // Update data in the todo table
    public function updateData($id, $taskname, $startdate, $enddate, $status) {
        $stmt = $this->conn->prepare("UPDATE todo SET taskname = ?, startdate = ?, enddate = ?, status = ? WHERE id = ?");
        $stmt->bind_param("ssssi", $taskname, $startdate, $enddate, $status, $id);
        $result = $stmt->execute();
        $stmt->close();
        return $result;
    }

    // Delete data from the todo table
    public function deleteData($id) {
        $stmt = $this->conn->prepare("DELETE FROM todo WHERE id = ?");
        $stmt->bind_param("i", $id);
        $result = $stmt->execute();
        $stmt->close();
        return $result;
    }
}
?>
