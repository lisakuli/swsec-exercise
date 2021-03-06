<?php

namespace tdt4237\webapp\repository;

use PDO;
use tdt4237\webapp\models\Patent;
use tdt4237\webapp\models\PatentCollection;

class PatentRepository
{

    /**
     * @var PDO
     */
    private $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function makePatentFromRow(array $row)
    {
        $patent = new Patent($row['patentId'], $row['company'], $row['title'], $row['description'], $row['date'], $row['file']);
        $patent->setPatentId($row['patentId']);
        $patent->setCompany($row['use tdt4237\webapp\models\PatentCollection;']);
        $patent->setTitle($row['title']);
        $patent->setDescription($row['description']);
        $patent->setDate($row['date']);
        $patent->setFile($row['file']);

        return $patent;
    }


    public function find($patentId)
    {
        //prep statement
        $query = $this->pdo->prepare("SELECT * FROM patent WHERE patentId=:patentId");
        $query->execute(array('patentId' => $patentId));
        $result = $query->fetch(PDO::FETCH_ASSOC);

        //$sql  = "SELECT * FROM patent WHERE patentId = $patentId";
        //$result = $this->pdo->query($sql);
        //$row = $result->fetch();

        if ($result == null) {
            return false;
        }

        return $this->makePatentFromRow($result);
    }

    public function all()
    {
        $sql   = "SELECT * FROM patent";
        $results = $this->pdo->query($sql);

        if($results === false) {
            return [];
            throw new \Exception('PDO error in patent all()');
        }

        $fetch = $results->fetchAll();
        if(count($fetch) == 0) {
            return false;
        }

        return new PatentCollection(
            array_map([$this, 'makePatentFromRow'], $fetch)
        );
    }

    public function deleteByPatentid($patentId)
    {
        //prep statement
        $query = $this->pdo->prepare("DELETE FROM patent WHERE patentid=:patentid");
        return $query->execute(array('patentid' => $patentId));
    }


    public function save(Patent $patent)
    {
        $title          = $patent->getTitle();
        $company        = $patent->getCompany();
        $description    = $patent->getDescription();
        $date           = $patent->getDate();
        $file           = $patent->getFile();

        if ($patent->getPatentId() === null) {
            $query = $this->pdo->prepare("INSERT INTO patent(company, title, file, description, date) VALUES (?,?,?,?,?)");
            $query->execute(array($company,$title, $file, $description,$date));
        }

        return $this->pdo->lastInsertId();
    }
}
