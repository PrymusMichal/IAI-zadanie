var data = [];

$(function () {
    $('#tree1').tree({
        data: data,
        dragAndDrop: true,
        usecontextmenu: true
    });
});

$(function () {
    $('#tree1').on(
        'tree.move',
        function (event) {
            event.preventDefault();
            event.move_info.do_move();
            changeParent(event.move_info.moved_node.id, event.move_info.target_node.id, event.move_info.position);
        }
    );
});

$(function () {
    $('#tree1').jqTreeContextMenu($('#myMenu'), {
        "edit": function (node) {
            var name = window.prompt("Enter new name", "default");
            if (name==null || name.length == 0) {
                alert("Name must be longer than 0 characters");
                return;
            }
            changeNodeName(node, name);
        },
        "delete": function (node) {
            deleteNode(node);
        },
        "add": function (node) {
            var name = window.prompt("Enter new node name", "default");
            if (name==null || name.length == 0) {
                alert("Name must be longer than 0 characters");
                return;
            }
            addNode(name, node.id);
        }
    });
});