<?php
session_start();

if (!isset($_SESSION["user"]) && !isset($_SESSION["adm"])) { // if the session user and the session adm have no value
    header("Location: ../login.php"); // redirect the user to the home page
    exit();
}

if (isset($_SESSION["user"])) { // if a session "user" is exist and have a value
    header("Location: ../home.php"); // redirect the user to the user page
    exit();
}

class CRUD
{
    private $hostName = "localhost";
    private $userName = "root";
    private $password = "";
    private $dbName = "login_system";
    private $conn = null;

    private function connect()
    {
        $this->conn = new mysqli($this->hostName, $this->userName, $this->password, $this->dbName);
    }

    public function __destruct()
    {
        if ($this->conn != null) { # if the connection property is not empty (close the connection and set it up to null)
            $this->conn->close();
            $this->conn = null;
        }
    }

    # SELECT * or columns FROM tableName JOIN? WHERE? group by? order by? sub? count? 
    public function read($tableName, $columns = "*", $join = "", $where = "", $groupBy = "", $orderBy = "", $limit = "")
    {
        if (is_array($columns)) {
            $columns = implode(", ", $columns); # join(", ")
        }

        $sql = "SELECT $columns FROM $tableName $join $where $groupBy $orderBy $limit";
        $this->connect();
        $result = $this->conn->query($sql);  #  mysqli_query($conn, $sql)  $conn->query($sql)
        if ($result->num_rows == 0) { # mysqli_num_rows($result)
            return false;
        } else {
            $rows = $result->fetch_all(MYSQLI_ASSOC); # mysqli_fetch_all($result, MYSQLI_ASSOC)
            return $rows;
        }
    }

    # DELETE FROM TABLENAME WHERE 0
    public function delete($tableName, $where)
    {
        $this->connect();

        if ($this->read($tableName, "*", "", "WHERE $where")) {
            $sql = "DELETE FROM $tableName WHERE $where";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute();

            $stmt->close();
            return true;
        } else {
            return false;
        }
    }


    # Update FROM TABLENAME WHERE 0
    public function update($tableName, $where)
    {
        $this->connect();

        if ($this->read($tableName, "*", "", "WHERE $where")) {
            $sql = "UPDATE $tableName SET WHERE $where";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute();

            $stmt->close();
            return true;
        } else {
            return false;
        }
    }

    # DELETE FROM TABLENAME WHERE 0
    public function insert($tableName, $where)
    {
        $this->connect();

        if ($this->read($tableName, "*", "", "WHERE $where")) {
            $sql = "INSERT INTO $tableName SET WHERE $where";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute();

            $stmt->close();
            return true;
        } else {
            return false;
        }
    }
}
# ["id", "name", "price"]   "id, name, price"

$obj = new CRUD();

// ($obj->delete("products", "id = 20"));
