<?php
require_once('databaseCallsFunctions.php');
session_start();
if (isset($_POST['databaseCall']) && !empty($_POST['databaseCall'])) {
    $databaseCall = $_POST['databaseCall'];
    switch ($databaseCall) {
        case 'addNode':
            addNode(filter_input(INPUT_POST,'name'), filter_input(INPUT_POST,'parentID'));
            break;
        case 'seedDatabase':
            seedDatabase();
            break;
        case 'getNodes':
            getNodes();
            break;
        case 'moveNode':
            moveNode(filter_input(INPUT_POST,'movedNodeID'), filter_input(INPUT_POST,'newParentID'));
            break;
        case 'deleteNode':
            deleteNode(filter_input(INPUT_POST,'nodeID'));
            break;
        case 'changeNodeName':
            changeNodeName(filter_input(INPUT_POST,'newName'),filter_input(INPUT_POST,'nodeID'));
            break;
    }
}

?>