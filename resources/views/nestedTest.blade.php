<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jstree/3.2.1/themes/default/style.min.css" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/1.12.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jstree/3.2.1/jstree.min.js"></script>



<div id="jstree_demo_div"></div>
<script>
    let json = {!! $json  !!};

    $('#jstree_demo_div').jstree({ 'core' : {
            'data' : json

        // 'data' : [
        //         { "id" : "ajson1", "parent" : "#", "text" : "Simple root node" },
        //         { "id" : "ajson2", "parent" : "#", "text" : "Root node 2" },
        //         { "id" : "ajson3", "parent" : "ajson2", "text" : "Child 1" },
        //         { "id" : "ajson4", "parent" : "ajson2", "text" : "Child 2" },
        //     ]

        } });
    $('#jstree_demo_div').on("changed.jstree", function (e, data) {
        console.log(data.selected);


    });
    // $('button').on('click', function () {
    //     $('#jstree').jstree(true).select_node('child_node_1');
    //     $('#jstree').jstree('select_node', 'child_node_1');
    //     $.jstree.reference('#jstree').select_node('child_node_1');
    // });



</script>

