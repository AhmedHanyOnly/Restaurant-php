<?php

class DB
{
  protected $dataType;
  protected $server;
  protected $dbName;
  protected $dbEmail;
  protected $dbPassword;
  protected $connect;

  function __construct($dataType, $ser, $dbName, $dbEmail, $dbPassword)
  {
    $this->dataType = $dataType;
    $this->server = $ser;
    $this->dbName = $dbName;
    $this->dbEmail = $dbEmail;
    $this->dbPassword = $dbPassword;

    $this->connect = new PDO("$this->dataType:host=$this->server;dbname=$this->dbName", $this->dbEmail, $this->dbPassword);
  }
  function getConnection()
  {
    return $this->connect;
  }

  function table($tName)
  {
    $query = "select * from $tName";
    $sqlQuery = $this->connect->query($query);
    return $sqlQuery->fetchAll(pdo::FETCH_ASSOC);
  }
  function getId($table, $id)
  {
    $query = "select * from $table where id=$id";
    $sqlQuery = $this->connect->query($query);
    return $sqlQuery->fetch(pdo::FETCH_ASSOC);
  }
  function deleteId($table, $id)
  {
    $query = "delete from $table where id=$id";
    $sqlQuery = $this->connect->prepare($query);
    $sqlQuery->execute();
  }
  function countTable($table)
  {
    $query = "select count('id') as Counter from $table";
    $sqlQuery = $this->connect->query($query);
    return $sqlQuery->fetch(PDO::FETCH_ASSOC);
  }
  function countOrdersNew($table)
  {
    $query = "select count('id') as Counter from $table where status='pending'";
    $sqlQuery = $this->connect->query($query);
    return $sqlQuery->fetch(PDO::FETCH_ASSOC);
  }
  function ordersTable()
  {
    $query = "select orders.id , users.name as userName, products.name as productName, products.image as productImage, products.desc as productDesc, products.price as productPrice, orders.status from orders inner join users on orders.user_id = users.id inner join products on orders.product_id = products.id";
    $sqlQuery = $this->connect->query($query);
    return $sqlQuery->fetchAll(PDO::FETCH_ASSOC);
  }
}
$connect = new DB('mysql', 'localhost', 'restaurant', 'root', '');
session_start();
