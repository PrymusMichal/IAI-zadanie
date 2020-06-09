function changeNodeName(node, newName) {
    $(document).ready(function () {
        $.ajax({
            type: "POST",
            url: "php/databaseCalls.php",
            data: {
                databaseCall: 'changeNodeName',
                newName: newName,
                nodeID: node.id
            },
            success: function () {
                $('#tree1').tree('updateNode', node, newName);
            },
            error: function (output) {
                console.log(output);
            }

        })
    });
}

function deleteNode(node) {
    $(document).ready(function () {
        $.ajax({
            type: "POST",
            url: "php/databaseCalls.php",
            data: {
                databaseCall: 'deleteNode',
                nodeID: node.id
            },
            success: function () {
                $('#tree1').tree('removeNode', node);
            },
            error: function (output) {
                console.log(output);
            }

        })
    });
}

function changeParent(movedNodeID, newParentID, position) {
    $(document).ready(function () {
        $.ajax({
            type: "POST",
            url: "php/databaseCalls.php",
            data: {
                databaseCall: 'moveNode',
                movedNodeID: movedNodeID,
                newParentID: (position == "after" ? null : newParentID)
            },
            success: function () {

            },
            error: function (output) {
                console.log(output);
            }

        })
    });
}

function seedDatabase() {
    $(document).ready(function () {
        $.ajax({
            type: "POST",
            url: "php/databaseCalls.php",
            data: {
                databaseCall: 'seedDatabase'
            },
            success: function () {
                location.reload();
            },
            error: function (output) {
                console.log(output);
                alert("Błąd połączenia z bazą danych! Sprawdź plik config.ini")
            }

        })
    });
}

function addNode(name, parentID) {
    $(document).ready(function () {
        $.ajax({
            type: "POST",
            url: "php/databaseCalls.php",
            data: {
                databaseCall: 'addNode',
                name: name,
                parentID: parentID
            },
            success: function (output) {
                output = JSON.parse(output);
                $('#tree1').tree(
                    'appendNode', {
                    name: name,
                    id: output.ID
                },
                    $('#tree1').tree('getNodeById', parentID)
                );
            },
            error: function (output) {
                console.log(output);
            }

        })
    });
}

function getNodes() {
    parentID = null;
    $(document).ready(function () {
        $.ajax({
            type: "POST",
            url: "php/databaseCalls.php",
            data: {
                databaseCall: 'getNodes',
                parentID: parentID
            },
            success: function (output) {
                var deserializedJson = JSON.parse(output);
                var elementsInBadOrder = [];
                deserializedJson.forEach(
                    function (row) {
                        var parent_node = $('#tree1').tree('getNodeById', row.ParentID);
                        if (parent_node == undefined && row.ParentID != null)
                            elementsInBadOrder.push(row);
                        else {
                            $('#tree1').tree(
                                'appendNode', {
                                name: row.Name,
                                id: row.ID
                            },
                                parent_node
                            );
                        }
                    }

                )
                if (elementsInBadOrder.length != 0)
                    appendNodesToTree(elementsInBadOrder);
            },
            error: function (output) {
                console.log(output);
                alert("Błąd połączenia z bazą danych! Sprawdź plik config.ini");
            }
        })
    });
}

function appendNodesToTree(deserializedJson) {
    var elementsInBadOrder = [];
    console.log(deserializedJson);
    deserializedJson.forEach(
        function (row) {
            var parent_node = $('#tree1').tree('getNodeById', row.ParentID);
            if (parent_node == undefined && row.ParentID != null)
                elementsInBadOrder.push(row);
            else {
                $('#tree1').tree(
                    'appendNode', {
                    name: row.Name,
                    id: row.ID
                },
                    parent_node
                );
            }
        }

    )
    if (elementsInBadOrder.length != 0)
        appendNodesToTree(elementsInBadOrder);
}
