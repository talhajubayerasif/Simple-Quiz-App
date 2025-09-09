<?php
class Database
{
    private $host = 'localhost';
    private $username = 'root';
    private $password = '';
    private $database = 'quizapp';
    private $connection;

    public function __construct()
    {
        $this->connect();
    }

    private function connect()
    {
        $this->connection = new mysqli(
            $this->host,
            $this->username,
            $this->password,
            $this->database
        );

        if ($this->connection->connect_error) {
            throw new Exception("Connection failed: " . $this->connection->connect_error);
        }

        // Set charset
        $this->connection->set_charset("utf8mb4");
    }

    public function getConnection()
    {
        return $this->connection;
    }

    public function close()
    {
        if ($this->connection) {
            $this->connection->close();
        }
    }
}
