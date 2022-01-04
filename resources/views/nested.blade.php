<script src="https://cdnjs.cloudflare.com/ajax/libs/nestable2/1.6.0/jquery.nestable.min.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/nestable2/1.6.0/jquery.nestable.css"/>

<div class="dd" id="nestable-json"></div>

<script>
    let json = {!! $json  !!};

    let options = {
        'json': json,
        contentCallback: function(item) {
           return item.name + '<span class="span-right" style="float: right"><a id="edit-button" ">Edit |</a><a id="del-button">Delete</a></span>';
        }
    }
    $(`#nestable-json`).nestable(options)

        .mousedown(function(e, data) {
           // alert( "Handler for .click() called." );
        console.log(e.target.id);
        e.stopPropagation();
    });

    $('#nestable-json').on("changed.nestable", '#edit-button', function (e, data) {
        return console.log(data.selected);
    });

    $(document).on("click","#del-button",function() {
        var x = confirm('Delete this menu?');
        var id = $(this).attr('id');
        if(x){
            $("#load").show();
            $.ajax({
                type: "POST",
                url: "delete.php",
                data: { id : id },
                cache : false,
                success: function(data){
                    $("#load").hide();
                    $("li[data-id='" + id +"']").remove();
                } ,error: function(xhr, status, error) {
                    alert(error);
                },
            });
        }
    });


</script>

