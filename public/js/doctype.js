$(document).ready(function(){
    var i=1;  
    window._token = $('meta[name="csrf-token"]').attr('content');
    $("#add").on('click',function(){
        let div_data=$('#dynamic_div div:last-child').attr("div_data");
        let input_val=$("#input"+div_data).val();
        if(div_data!=='' && input_val!==''){
            i++;
            $("#dynamic_div").append('<div class="form-group" id="div'+i+'" div_data="'+i+'"><input type="text" id="input'+i+'" placeholder="Enter field option" name="field_option[]" class="custom-form-control" style="margin-left: 101px;" required><button  type="button" name="remove" id="'+i+'" class="btn btn-danger btn_remove" style="float: right;margin-right: 60px;">X</button></div>')
        }else{
            alert("Please enter option value.");
            return false;
        }
    });
    $(document).on('click','.btn_remove',function(){
        let id=$(this).attr('id');
        $('#div'+id).remove();
    })
})