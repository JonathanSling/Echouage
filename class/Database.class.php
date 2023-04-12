<?php

class Database{
    private $db_name;
    private $db_user;
    private $db_pass;
    private $db_host;
    private $pdo;
    private $limit;

    public function __construct($limit = 10, $db_name = "echouage", $db_user = "echouage", $db_pass = "A4ySVdjdNl2LUsUr", $db_host = "localhost")
    {
        $this->db_name = $db_name;
        $this->db_user = $db_user;
        $this->db_pass = $db_pass;
        $this->db_host = $db_host;
        $this->limit = $limit;
    }
    
    private function getPDO()
    {
        if ($this->pdo === NULL) {
            $pdo = new PDO("mysql:host=" . $this->db_host . ";dbname=" . $this->db_name . ";charset=UTF8;", $this->db_user, $this->db_pass);
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->pdo = $pdo;
        }
        return $this->pdo;
    }

    public function query($command, $class_name)
    {
        $result = $this->getPDO()->prepare($command);
        $result->execute();
        return $result->fetchAll(PDO::FETCH_CLASS, $class_name);
    }

    public function modifyById($list)
    {
        $sql = "UPDATE echouage SET date = ?, espece = ?, zone = ?, nombre = ? WHERE id = ?";
        $request = $this->getPDO()->prepare($sql);
        $request->execute([$list['date'], $list['espece'], $list['zone'], $list['nb'], $list['id']]);
        return 1;
    }

    public function getZones()
    {
        $result = $this->query("SELECT DISTINCT zone FROM echouage ORDER BY zone", "Echouage");
        return $result;
    }

    public function getEspeces()
    {
        $result = $this->query("SELECT DISTINCT espece FROM echouage ORDER BY espece", "Echouage");
        return $result;
    }

    public function getDates()
    {
        $result = $this->query("SELECT DISTINCT date FROM echouage ORDER BY date desc", "Echouage");
        return $result;
    }

    public function getEchouages($filters = null)
    {
        $whereArgs = [];
        $offset = isset($_GET['page']) ? ($_GET['page']-1)*$this->limit : 0;

        $sql = "SELECT * FROM echouage ";

        if($filters != null){
            foreach($filters as $key => $value){
                if ($value != "") $whereArgs[] = $key." = :".$key;
            }
        }

        if (!empty($whereArgs)) $sql .= "WHERE ".implode(" AND ", $whereArgs);
        $sql .= " LIMIT :limit OFFSET :offset";

        $sth = $this->getPDO()->prepare($sql);

        if($filters != null){
            if($filters["date"] != "") $sth->bindParam("date", $filters["date"]);
            if($filters["espece"] != "") $sth->bindParam("espece", $filters["espece"]);
            if($filters["zone"] != "") $sth->bindParam("zone", $filters["zone"]);
        }

        $sth->bindParam("limit", $this->limit, PDO::PARAM_INT);
        $sth->bindParam("offset", $offset, PDO::PARAM_INT);

        $sth->execute();

        return $sth->FetchAll(PDO::FETCH_CLASS, "Echouage");
    }

    public function getCountEchouages($filters = null)
    {
        $whereArgs = [];
        $sql = "SELECT COUNT(*) FROM echouage ";

        if($filters != null){
            foreach($filters as $key => $value){
                if ($value != "") $whereArgs[] = $key." = :".$key;
            }
        }

        if (!empty($whereArgs)) $sql .= "WHERE ".implode(" AND ", $whereArgs);

        $sth = $this->getPDO()->prepare($sql);

        if($filters != null){
            if($filters["date"] != "") $sth->bindParam("date", $filters["date"]);
            if(isset($filters["espece"]) && $filters["espece"] != "") $sth->bindParam("espece", $filters["espece"]);
            if(isset($filters["zone"]) && $filters["zone"] != "") $sth->bindParam("zone", $filters["zone"]);
        }

        $sth->execute();

        $result = floor($sth->fetch()[0]/$this->limit);

        return $result;
    }

    public function getId($id = null)
    {
        $whereArgs = [];
        $sql = "SELECT * FROM echouage WHERE id = :id";

        $sth = $this->getPDO()->prepare($sql);
        
        $sth->bindParam("id", $id, PDO::PARAM_INT);
        
        $sth->execute();

        return $sth->fetchObject("Echouage");
    }

    public function getStatistiques($filters = null)
    {
        $sql1 = "SELECT espece AS valeur, SUM(nombre) AS total FROM echouage";
        $sql2 = "SELECT zone AS valeur, SUM(nombre) AS total FROM echouage";

        if($filters != "null" && isset($filters["date"])){
            $sql1 .= " WHERE date = ".$filters["date"];
            $sql2 .= " WHERE date = ".$filters["date"];
        }

        $sql1 .= " GROUP BY valeur ORDER BY total DESC LIMIT 1;";
        $sql2 .= " GROUP BY valeur ORDER BY total DESC LIMIT 1;";
        
        $result = [];
        $result["espece"] = $this->query($sql1, "Statistiques");    
        $result["zone"] = $this->query($sql2, "Statistiques");
        
        return $result;
    }

    public function setLimit($newLimit)
    {
        $this->limit = $newLimit;
    }
}