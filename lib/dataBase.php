<?php
//database class

class Database
{
  private $hostdb = "localhost";
  private $userdb = "root";
  private $passdb = "";
  private $namedb = "db_student";
  private $pdo;
  public function __construct()
  {
    if (!isset($this->pdo)) {
      try {
        $link = new PDO("mysql:host=" . $this->hostdb . ";dbname=" . $this->namedb, $this->userdb, $this->passdb,);
        $link->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $link->exec("SET CHARACTER SET utf8");
        $this->pdo = $link;
      } catch (PDOException $e) {
        die("Failed To Connect With DataBase" . $e->getMessage());
      }
    }
  }

  //read data
  public function select($table, $data = array())
  {
    $sql = 'SELECT ';
    $sql .= array_key_exists("select", $data) ? $data['select'] : '*';

    $sql .= ' FROM ' . $table;

    if (array_key_exists("where", $data)) {
      $sql .= ' WHERE ';

      $i = 0;
      foreach ($data['where'] as $key => $value) {
        $add = ($i > 0) ? ' AND ' : '';
        $sql .= "$add" . "$key = :$key";
        $i++;
      }
    }

    if (array_key_exists("order_by", $data)) {
      $sql .= ' ORDER BY ' . $data['order_by'];
    }

    if (array_key_exists("start", $data) &&  array_key_exists("limit", $data)) {
      $sql .= ' LIMIT ' . $data['start'] . ',' . $data['limit'];
    } elseif (!array_key_exists("start", $data) &&  array_key_exists("limit", $data)) {
      $sql .= ' LIMIT ' . $data['limit'];
    }

    $query = $this->pdo->prepare($sql);

    if (array_key_exists("where", $data)) {
      foreach ($data['where'] as $key => $value) {
        $query->bindValue(":$key", $value);
      }
    }

    $query->execute();

    if (array_key_exists("return_type", $data)) {
      switch ($data['return_type']) {
        case 'count':
          $value = $query->rowCount();
          break;

        case 'single':
          $value = $query->fetch(PDO::FETCH_ASSOC);
          break;

        default:
          $value = "";
          break;
      }
    } else {
      if ($query->rowCount() > 0) {
        $value = $query->fetchAll();
      }
    }

    return !empty($value) ? $value : false;
  }

  //insert data
  public function insert($table, $data)
  {
    if (!empty($data) && is_array($data)) {
      $keys = '';
      $values = '';
      $i = 0;
      $keys = implode(',', array_keys($data));
      $values = ":" . implode(', :', array_keys($data));
      $sql = "INSERT INTO " . $table . " (" . $keys . ") VALUES (" . $values . ")";
      print_r($sql);
      $query = $this->pdo->prepare($sql);
      foreach ($data as $key => $val) {
        $query->bindValue(":$key", $val);
      }
      $insertdata = $query->execute();
    };
    if ($insertdata) {
      $lastId = $this->pdo->lastInsertId();
      return $lastId;
    } else {
      return false;
    }
  }

  // update data
  public function update($table, $data, $cond)
  {
    if (!empty($data) && is_array($data)) {
      $keyValue = '';
      $whereCond = '';
      $i = 0;

      foreach ($data as $key => $val) {
        $add = ($i > 0) ? ' , ' : '';
        $keyValue .= "$add" . "$key = :$key";
        $i++;
      }
      if (!empty($cond) && is_array($cond)) {
        $whereCond .= " WHERE ";
        $i = 0;

        foreach ($cond as $key => $val) {
          $add = ($i > 0) ? ' AND ' : '';
          $whereCond .= "$add" . "$key = :$key";
          $i++;
        }
      }

      $sql = "UPDATE " . $table . " SET " . $keyValue . $whereCond;

      $query = $this->pdo->prepare($sql);

      foreach ($data as $key => $val) {
        $query->bindValue(":$key", $val);
      }

      foreach ($cond as $key => $val) {
        $query->bindValue(":$key", $val);
      }
      $update = $query->execute();

      return $update ? $query->rowCount() : false;
    } else {
      return false;
    }
  }

  //delete data
  public function delete($table,  $data)
  {
    $whereCond = '';
    if (!empty($data) && is_array($data)) {
      $whereCond .= " WHERE ";
      $i = 0;

      foreach ($data as $key => $val) {
        $add = ($i > 0) ? ' AND ' : '';
        $whereCond .= "$add" . "$key = :$key";
        $i++;
      }
    }
    $sql = "DELETE FROM " . $table . $whereCond;

    $query = $this->pdo->prepare($sql);

    foreach ($data as $key => $val) {
      $query->bindValue(":$key", $val);
    }
    $delete = $query->execute();
    return $delete ? true  : false;
  }
}
