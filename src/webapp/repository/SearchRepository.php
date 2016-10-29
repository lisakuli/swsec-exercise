<?php
namespace tdt4237\webapp\repository;

use tdt4237\webapp\models\Patent;
use tdt4237\webapp\models\PatentCollection;
use PDO;

class searchRepository
{
	/**
     * @var PDO
     */
    private $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function searchForCompany($company)
    {
    	//trenger kanskje noe som kan være wildcard
    	$query = $this->pdo->prepare("SELECT * FROM patent WHERE company=:company");
        $query->execute(array('company' => $company));
        $result = $query->fetch(PDO::FETCH_ASSOC);

        if ($result == null) {
            return false;
        }

        return $this->makePatentFromRow($result);

    }

    public function searchForTitle($title)
    {
    	//trenger kanskje noe som kan være wildcard
    	$query = $this->pdo->prepare("SELECT * FROM patent WHERE title=:title");
        $query->execute(array('title' => $title));
        $result = $query->fetch(PDO::FETCH_ASSOC);

        if ($result == null) {
            return false;
        }

        return $this->makePatentFromRow($result);
        
    }

}