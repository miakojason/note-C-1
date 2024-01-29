<?php
date_default_timezone_set("Asia/Taipei");
session_start();
class DB
{
    protected $dsn = "mysql:host=localhost;charset=utf8;dbname=c1";
    protected $pdo;
    protected $table;
    public function __construct($table)
    {
        $this->table = $table;
        $this->pdo = new PDO($this->dsn, 'root', '');
    }
    function q($sql)
    {
        return $this->pdo->query($sql)->fetchAll(PDO::FETCH_ASSOC);
    }
    private function a2s($array)
    {
        foreach ($array as $col => $value) {
            $tmp[] = "`$col`='$value'";
        }
        return $tmp;
    }
    function save($array)
    {
        if (isset($array['id'])) {
            if (!empty($array)) {
                $sql = "update `$this->table` set ";
                $tmp = $this->a2s($array);
                $sql .= join(",", $tmp);
                $sql .= " where `id`='{$array['id']}'";
            } else {
                echo "空的";
            }
        } else {
            $sql = "insert into `$this->table`";
            $cols = "(`" . join("`,`", array_keys($array)) . "`)";
            $vals = "('" . join("','", $array) . "')";
            $sql .= $cols . "values" . $vals;
        }
        return $this->pdo->exec($sql);
    }
    function find($id)
    {
        $sql = "select * from `$this->table`";
        if (is_array($id)) {
            $tmp = $this->a2s($id);
            $sql .= " where " . join(" && ", $tmp);
        } else if (is_numeric($id)) {
            $sql .= " where  `id` = '$id'";
        } else {
            echo "錯誤:參數的資料型態必須是數字或陣列";
        }
        $row = $this->pdo->query($sql)->fetch(PDO::FETCH_ASSOC);
        return $row;
    }
    function del($id)
    {
        $sql = "delete from `$this->table` where ";
        if (is_array($id)) {
            $tmp = $this->a2s($id);
            $sql .= join(" && ", $tmp);
        } else if (is_numeric($id)) {
            $sql .= "`id`='$id'";
        } else {
            echo "錯誤:參數資料型態必須是數字或陣列";
        }
        return $this->pdo->exec($sql);
    }
    private function sql_all($sql, $array, $other)
    {
        if (isset($this->table) && !empty($this->table)) {
            if (is_array($array)) {
                if (!empty($array)) {
                    $tmp = $this->a2s($array);
                    $sql .= " where " . join(" && ", $tmp);
                }
            } else {
                $sql .= " $array";
            }
            return $sql .= $other;
        } else {
            echo "錯誤:沒有指定的資料表名稱";
        }
    }
    function all($where = '', $other = '')
    {
        $sql = "select * from `$this->table`";
        $sql = $this->sql_all($sql, $where, $other);
        return $this->pdo->query($sql)->fetchAll(PDO::FETCH_ASSOC);
    }
    function count($where = '', $other = '')
    {
        $sql = "select count(*) from `$this->table`";
        $sql = $this->sql_all($sql, $where, $other);
        return $this->pdo->query($sql)->fetchColumn();
    }
    private function math($math, $col, $array = '', $other = '')
    {
        $sql = "select $math(`$col`) from `$this->table`";
        $sql = $this->sql_all($sql, $array, $other);
        return $this->pdo->query($sql)->fetchColumn();
    }
    function sum($col = '', $where = '', $other = '')
    {
        return $this->math('sum', $col, $where, $other);
    }
    function max($col = '', $where = '', $other = '')
    {
        return $this->math('max', $col, $where, $other);
    }
    function min($col = '', $where = '', $other = '')
    {
        return $this->math('min', $col, $where, $other);
    }
}

$Title = new DB('titles');
$Ad = new DB('ad');
$Mvim = new DB('mvim');
$Image = new DB('image');
$News = new DB('news');
$Total = new DB('total');
$Bottom = new DB('bottom');
$Admin = new DB('admin');
$Menu = new DB('menu');

function dd($array)
{
    echo "<pre>";
    print_r($array);
    echo "</pre>";
}
function to($url)
{
    header("location:$url");
}
if (isset($_GET['do'])) {
    if (isset(${ucfirst($_GET['do'])})) {
        $DB = ${ucfirst($_GET['do'])};
    }
} else {
    $DB = $Title;
}
if (!isset($_SESSION['visited'])) {
    $Total->q("update `total` set `total` = `total`+1 where `id`=1");
    $_SESSION['visted'] = 1;
}
