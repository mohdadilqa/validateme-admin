$(document).ready(function(){
    let default_selected_role=$("#roles option:selected").text().toLowerCase();
    console.log(default_selected_role);
    if(default_selected_role=="company admin"){
        $(".password").css("display","none");
        $(".password").css("disabled","disabled");
    }else{
        $(".password").css("display","block");
        $(".password").css("disabled",false);
        $(".organization").css("display","none");
        $(".organization_domain").css("display","none");
        $('#organization_name').prop('disabled', 'disabled');
        $('#organization_domain').prop('disabled', 'disabled');
        $('#organization_email').prop('disabled', 'disabled');
    }
    //Manage User create form for Comapany Admin and support staff
  
    $("#roles").on("select2:select", function (e) { 
        var data = $('#roles').select2('data');
        let role=data[0].text.toLowerCase();
        if(role!=="company admin"){
            $(".organization").css("display","none");
            $(".organization_domain").css("display","none");
            $('#organization').prop('disabled', 'disabled');
            $('#organization_name').prop('disabled', 'disabled');
            $('#organization_domain').prop('disabled', 'disabled');
            $('#organization_email').prop('disabled', 'disabled');
            $(".password").css("display","block");
            $(".password").css("disabled",false);
        }else{
            $(".password").css("display","none");
            $(".password").css("disabled","disabled");
            $(".organization").css("display","block");
            $(".organization_domain").css("display","block");
            $('#organization').prop('disabled',false);
            $('#organization_name').prop('disabled', false);
            $('#organization_domain').prop('disabled', false);
            $('#organization_domain').prop('disabled', false);
        }
    });

    $("#roles").select2({
        placeholder: "Please select"
    });
});