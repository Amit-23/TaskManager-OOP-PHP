<?php

class Database {
    private $username;
    private $server;
    private $password;
    private $db;
    private $conn;
    
    public function __construct() {
        $this->connect(); // Call connect method when the object is created
    }

    // Establish a database connection
    public function connect() {
        $this->username = 'root';
        $this->password = '';
        $this->server = 'localhost';
        $this->db = 'todo';

        // Connect to the database and assign to $conn property
        $this->conn = new mysqli($this->server, $this->username, $this->password, $this->db, 8111);

        // Check if the connection was successful
        if ($this->conn->connect_error) {
            die("Connection failed: " . $this->conn->connect_error);
        } 

        return $this->conn;
    }

    // Data insertion
    public function insertData($taskname, $startdate, $enddate, $status) {
        $stmt = $this->conn->prepare("INSERT INTO todo (taskname, startdate, enddate, status) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssss", $taskname, $startdate, $enddate, $status);
        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }
        $stmt->close();
    }

    // Retrieve the data from the database
    public function getData() {
        $sql = "SELECT * FROM todo";
        $result = $this->conn->query($sql);

        if ($result->num_rows > 0) {
            return $result->fetch_all(MYSQLI_ASSOC);
        } else {
            return [];
        }
    }

    // Update the data in the database
    public function updateData($id, $taskname, $startdate, $enddate, $status) {
        $stmt = $this->conn->prepare("UPDATE todo SET taskname = ?, startdate = ?, enddate = ?, status = ? WHERE id = ?");
        $stmt->bind_param("ssssi", $taskname, $startdate, $enddate, $status, $id);
        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }
        $stmt->close();
    }

    // Delete data from the database
    public function deleteData($id) {
        $stmt = $this->conn->prepare("DELETE FROM todo WHERE id = ?");
        $stmt->bind_param("i", $id);
        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }
        $stmt->close();
    }
}

// Usage example
$obj = new Database(); // The constructor will automatically connect to the database
?>
