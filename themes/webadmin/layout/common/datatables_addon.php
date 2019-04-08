<script>
    
    $("body").on("click", " .btn-table-edit", function(){
        var id = $(this).attr('data-id');
        window.location.href="{URL_FORM_EDIT}/"+id;
    })
    
    $("body").on("click", " .btn-table-delete", function(){
        var id = $(this).attr('data-id');
        $.ajax({
            url:"{URL_FORM_DELETE}",
            dataType:"JSON",
            type:"POST",
            data:"{id:id}",
            success:function(rst){
                if (rst.status){
                    
                } else {
                    
                }
            }
        })
        alert(id);
    })
    

</script>    