<?php

namespace App\Model;


require_once '../../Core/db.php';

use Core\SQLConnection;
use Core\DBConnInterface;
use PDO;

class Model
{
    protected $dbConnInterface;

    public function __construct(DBConnInterface $dbConnInterface)
    {
        $this->dbConnInterface = $dbConnInterface;
    }

    public function returnMeals(array $params)
    {
        if (isset($params['per_page'])) {
            $sql = "SELECT * FROM " . $params["table"] . " WHERE id <= " . $params["per_page"];
        } else {
            $sql = "SELECT * FROM " . $params["table"];
        }
        $pdo = $this->dbConnInterface->connect();
        $stmt = $pdo->prepare($sql);
        $stmt->execute();

        $row = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $row;
        echo json_encode($row, JSON_PRETTY_PRINT);
    }


    public function returnCTI(array $params)
    {
        //Replace string category -> $params["cti"];
        $sql = "SELECT  meals_" . $params["lang"] . ".title, " . $params["cti"] . "_" . $params["lang"] . ".id, " . $params["cti"] . "_" . $params["lang"] . ".title, " . $params["cti"] . "_" . $params["lang"] . ".slug
FROM ((" .  $params["table"] . " INNER JOIN jela_svijeta.meals_" . $params["cti"] . " ON meals_" . $params["lang"] . ".id = meals_" . $params["cti"] . ".meals_id)
INNER JOIN jela_svijeta." . $params["cti"] . "_" . $params["lang"] . "
ON meals_" . $params["cti"] . "." . $params["cti"] . "_id = " . $params["cti"] . "_" . $params["lang"] . ".id)
 WHERE meals_" . $params["lang"] . ".id = " . $params['id'] . "+1"; // !!! +1 is here because there is and offset by one in GET WITH PARAMS !!!

        # echo $sql;
        #" WHERE ID=1";
        $pdo = $this->dbConnInterface->connect();
        $stmt = $pdo->prepare($sql);
        $stmt->execute();

        $row = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $row;
        echo json_encode($row, JSON_PRETTY_PRINT);
    }



    public function returnCategory(array $params)
    {
        //Replace string category -> $params["cti"];
        $sql = "SELECT  meals_" . $params["lang"] . ".title, category_" . $params["lang"] . ".id, category_" . $params["lang"] . ".title, category_" . $params["lang"] . ".slug
FROM ((" .  $params["table"] . " INNER JOIN jela_svijeta.meals_" . $params["cti"] . " ON meals_" . $params["lang"] . ".id = meals_" . $params["cti"] . ".meals_id)
INNER JOIN jela_svijeta." . $params["cti"] . "_" . $params["lang"] . "
ON meals_" . $params["cti"] . "." . $params["cti"] . "_id = " . $params["cti"] . "_" . $params["lang"] . ".id)
 WHERE meals_" . $params["lang"] . ".id = " . $params['id'] . "+1"; // !!! +1 is here because there is and offset by one in GET WITH PARAMS !!!

        # echo $sql;
        #" WHERE ID=1";
        $pdo = $this->dbConnInterface->connect();
        $stmt = $pdo->prepare($sql);
        $stmt->execute();

        $row = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $row;
        echo json_encode($row, JSON_PRETTY_PRINT);
    }





    public function mealsRowCount()
    {
        $sql = "SELECT title FROM jela_svijeta.meals_hr";

        $pdo = $this->dbConnInterface->connect();
        $stmt = $pdo->prepare($sql);

        $stmt->execute();
        $row = $stmt->rowCount();
        return $row;
    }
}
