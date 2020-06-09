<?php
function changeNodeName($newName, $nodeID)
{
    try {
        $conn = new PDO(
            "mysql:host=" . $_SESSION['db_host'] .
                ";dbname=" . $_SESSION['db_name'],
            $_SESSION['db_user'],
            $_SESSION['db_password']
        );

        $changeNodeStatement = $conn->prepare("UPDATE " . $_SESSION['table_name'] .
            " SET Name = '$newName' WHERE ID = $nodeID");
        $changeNodeStatement->execute();
        $changeNodeStatement->rowCount() != 0 ? http_response_code(200) : http_response_code(500);
    } catch (PDOException $exception) {
        http_response_code(500);
        echo "Database error: " . $exception->getMessage();
    } catch (Exception $exception) {
        http_response_code(500);
        echo "Unknown error: " . $exception->getMessage();
    }
}

function deleteNode($nodeID)
{
    try {
        $conn = new PDO(
            "mysql:host=" . $_SESSION['db_host'] .
                ";dbname=" . $_SESSION['db_name'],
            $_SESSION['db_user'],
            $_SESSION['db_password']
        );

        $deleteNodeStatement = $conn->prepare("DELETE FROM " . $_SESSION['table_name'] . " WHERE ID= :nodeID");
        $deleteNodeStatement->bindParam(':nodeID', $nodeID);
        $deleteNodeStatement->execute();

        $deleteNodeStatement = $conn->prepare("SELECT ID FROM " . $_SESSION['table_name'] . " WHERE ParentID= :nodeID");
        $deleteNodeStatement->bindParam(':nodeID', $nodeID);
        $deleteNodeStatement->execute();

        $return_array = $deleteNodeStatement->fetchAll(PDO::FETCH_ASSOC);
        foreach ($return_array as $node) {
            deleteNode($node['ID']);
        }
        http_response_code(200);
    } catch (PDOException $exception) {
        http_response_code(500);
        echo "Database error: " . $exception->getMessage();
    } catch (Exception $exception) {
        http_response_code(500);
        echo "Unknown error: " . $exception->getMessage();
    }
}

function addNode($name, $parentID)
{
    try {
        $conn = new PDO(
            "mysql:host=" . $_SESSION['db_host'] . ";dbname=" . $_SESSION['db_name'],
            $_SESSION['db_user'],
            $_SESSION['db_password']
        );

        $insertTableStatement = $conn->prepare(
            "INSERT INTO " . $_SESSION['table_name'] . " (Name,ParentID)
                VALUES ('$name',:parentID);"
        );
        $parentID = empty($parentID) ? null : $parentID;
        $insertTableStatement->bindParam(':parentID', $parentID);
        $insertTableStatement->execute();

        $insertTableStatement->rowCount() != 0 ? http_response_code(200) : http_response_code(500);

        $query = $conn->prepare("SELECT ID,ParentID FROM " . $_SESSION['table_name'] . " WHERE Name=':name'");
        $query->bindParam(':name', $name);
        $query->execute();

        echo json_encode($query->fetch(PDO::FETCH_ASSOC));
    } catch (PDOException $exception) {
        http_response_code(500);
        echo "Database error: " . $exception->getMessage();
    } catch (Exception $exception) {
        http_response_code(500);
        echo "Unknown error: " . $exception->getMessage();
    }
}

function seedDatabase()
{
    try {
        $conn = new PDO("mysql:host=" . $_SESSION['db_host'], "root", "");
        $conn->query("DROP DATABASE " . $_SESSION['db_name']);
        $conn->query("CREATE DATABASE " . $_SESSION['db_name']);

        $conn = new PDO(
            "mysql:host=" . $_SESSION['db_host'] . ";dbname=" . $_SESSION['db_name'],
            $_SESSION['db_user'],
            $_SESSION['db_password']
        );

        $createTableStatement = "CREATE table " . $_SESSION['table_name'] .
            "(ID int AUTO_INCREMENT,
                Name VARCHAR(250) NOT NULL UNIQUE,
                ParentID int,
                PRIMARY KEY(ID));";

        $conn->query($createTableStatement);
        $insertTableStatement = "INSERT INTO " . $_SESSION['table_name'] . " (Name,ParentID)
            VALUES ('directory1',null),
                ('directory2',null),
                ('directory3',null),
                ('directory4',null),
                ('file1',1),
                ('file2',5);";

        $conn->query($insertTableStatement);
        http_response_code(200);
    } catch (PDOException $exception) {
        http_response_code(500);
        echo "Database error: " . $exception->getMessage();
    } catch (Exception $exception) {
        http_response_code(500);
        echo "Unknown error: " . $exception->getMessage();
    }
}

function getNodes()
{
    try {
        $conn = new PDO(
            "mysql:host=" . $_SESSION['db_host'] . ";dbname=" . $_SESSION['db_name'],
            $_SESSION['db_user'],
            $_SESSION['db_password']
        );

        $getNodesStatement = $conn->prepare("SELECT * FROM " . $_SESSION['table_name'] . " ORDER BY ParentID");
        $getNodesStatement->execute();
        $return_array = $getNodesStatement->fetchAll(PDO::FETCH_ASSOC);
        http_response_code(200);
        echo json_encode($return_array);
    } catch (PDOException $exception) {
        http_response_code(500);
        echo "Database error: " . $exception->getMessage();
    } catch (Exception $exception) {
        http_response_code(500);
        echo "Unknown error: " . $exception->getMessage();
    }
}

function moveNode($movedNodeID, $newParentID)
{
    try {
        $newParentID = (empty($newParentID) ? null : $newParentID);
        $conn = new PDO(
            "mysql:host=" . $_SESSION['db_host'] . ";dbname=" . $_SESSION['db_name'],
            $_SESSION['db_user'],
            $_SESSION['db_password']
        );

        $moveNodeStatement = $conn->prepare("UPDATE " . $_SESSION['table_name'] . " SET ParentID = :newParentID WHERE ID = :movedNodeID");
        $moveNodeStatement->bindParam(':movedNodeID', $movedNodeID);
        $moveNodeStatement->bindParam(':newParentID', $newParentID);
        $moveNodeStatement->execute();

        http_response_code(200);
    } catch (PDOException $exception) {
        http_response_code(500);
        echo "Database error: " . $exception->getMessage();
    } catch (Exception $exception) {
        http_response_code(500);
        echo "Unknown error: " . $exception->getMessage();
    }
}
