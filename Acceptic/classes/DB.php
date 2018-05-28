<?php


class DB{
    protected $db_host = 'localhost:3307';
    protected $db_name = 'login_form';
    protected $db_user = 'root';
    protected $db_pass = '';
    
    public function connect() {
        $connect = mysqli_connect($this->db_host, $this->db_user, $this->db_pass,$this->db_name);
        if (mysqli_connect_error()) {
            die('Ошибка подключения (' . mysqli_connect_errno() . ') '
                . mysqli_connect_error());
        }else {
            return $connect;
        }
    }
    //select row from table
    public function select($table, $where) {
        $sql = "SELECT * FROM $table WHERE $where";
        $link = mysqli_connect($this->db_host, $this->db_user, $this->db_pass,$this->db_name);
        $result = mysqli_query($link, $sql);
//        var_dump($link);
        return mysqli_fetch_array($result, MYSQLI_ASSOC);
    }

    //update information in DB
    public function update($data, $table, $where) {
        $link = mysqli_connect($this->db_host, $this->db_user, $this->db_pass,$this->db_name);
        foreach ($data as $column => $value) {
            $sql = "UPDATE $table SET $column = $value WHERE $where";
            mysqli_query($link, $sql) or die(mysqli_error($link));
        }
        return true;
    }

    //insert new values to the DB
    public function insert($data, $table) {
        $link = mysqli_connect($this->db_host, $this->db_user, $this->db_pass,$this->db_name);
        $columns = "";
        $values = "";
        foreach ($data as $column => $value) {
            $columns .= ($columns == "") ? "" : ", ";
            $columns .= $column;
            $values .= ($values == "") ? "" : ", ";
            $values .= $value;
        }
        $sql = "INSERT INTO $table ($columns) values ($values)";
        mysqli_query($link,$sql) or die(mysqli_error($link));

        return mysqli_insert_id($link);
    }

} 