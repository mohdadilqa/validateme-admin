$(document).ready(function(){
    window._token = $('meta[name="csrf-token"]').attr('content');
    var base_url = window.location.origin;
    //Code for dynamic add input
    /*var i=1;  
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
    })*/
    //end
    //Select RDT Key if not then new one created
    $("#RDT_key").autocomplete({
        source: function(request, response) {
            $.ajax({
                headers: {'x-csrf-token': _token},
                url:base_url+"/admin/refdata/refDatakey",
                type: "POST",
                data: {
                    term: request.term
                },
                dataType: "json",
                success: function (res) {
                    response($.map(res.data, function(item) {
                        return {
                            value: item
                        }
                    }))
                }
            });
        }
    });
    //Code generation for REFDATA

    function regex (str){
        return str.replace(/(~|`| |!|@|#|$|%|^|&|\*|\(|\)|{|}|\[|\]|;|:|\"|'|<|,|\.|>|\?|\/|\\|\||-|_|\+|=)/g,"")
    }
    $("#title").keyup(function(){
        let title=$(this).val();
        let code=regex(title).toLowerCase();
        $("#code").val(code);
    });

    //Only Selectable RDT Key
    $("#select_RDT_key").autocomplete({
        source: function(request, response) {
            $.ajax({
                headers: {'x-csrf-token': _token},
                url:base_url+"/admin/refdatafield/refDatakey",
                type: "POST",
                data: {
                    term: request.term
                },
                dataType: "json",
                success: function (res) {
                    console.log(res);
                    response($.map(res.data, function(item) {
                        return {
                            value: item
                        }
                    }))
                }
            });
        },
        change: function(event, ui) {
            if (ui.item == null) {
              event.currentTarget.value = ''; 
              event.currentTarget.focus();
            }
        }
    });


    //Ajax Code for Reference Data Field
    $("#ref_data_field").select2({
        multiple:true,
        ajax: { 
            headers: {'x-csrf-token': _token},
            url: base_url+"/admin/doctype/referenceDataField",
            type: "POST",
            dataType: 'json',
            data: function (params) {
                return {
                    q: params.term, // search term
                };
            },
            processResults: function (response) {
                return {
                    results: $.map(response.data, function (obj) {
                        return {
                            id: obj._id,
                            text: obj.title,
                        };
                    })
                };
            },
            placeholder: "Please Select"  
        }
    });

    //End Reference Data Field
    

    //Name Rule

    $( function(){
        $("#sortable1, #sortable2" ).sortable({
          connectWith: ".connectedSortable"
        }).disableSelection();
      });

      //Selecting title using select2
    $("#ref_data_field").on("select2:select",function(e){ 
        let data = e.params.data;
        let title=data.text;
        let code=data.id;
        $("#sortable1").append("<li id ="+code+" value="+code+" class='ui-state-default'>"+title+"<input type='hidden' class="+code+" name='name_rule[]' value="+code+"></li>")
    });

    $("#ref_data_field").on("select2:unselect",function(e){ 
        let code=e.params.data.id;
        $("#"+code).remove();
    });

    $('#sortable1').on('DOMSubtreeModified', function(event){
        let name_rule="";
        $("#sortable1 li").each(function(index,element){
            $("."+$(this).attr('id')).prop("disabled", false);
            name_rule =name_rule + "{"+$( this ).text()+"}_";
        });
        $("#name_rule_text").text(name_rule.slice(0,-1));
    });
    //disable all input fileds
    $('#sortable2').on('DOMSubtreeModified',function(event){
       
        $("#sortable2 li").each(function(index,element){
            $("."+$(this).attr('id')).prop("disabled", "disabled");
        });
    });

    $("#doctypeAdd").submit(function(e){
        if($("#sortable1 li").length===0){
            $("#name_rule_error").text("Name rule can not be empty.");
            e.preventDefault();
        }
    });
});














// var availableTags = [
//     "ActionScript",
//     "AppleScript",
//     "Asp",
//     "BASIC",
//     "C",
//     "C++",
//     "Clojure",
//     "COBOL",
//     "ColdFusion",
//     "Erlang",
//     "Fortran",
//     "Groovy",
//     "Haskell",
//     "Java",
//     "JavaScript",
//     "Lisp",
//     "Perl",
//     "PHP",
//     "Python",
//     "Ruby",
//     "Scala",
//     "Scheme"
//   ];
//   $("#RDT_key").autocomplete({
//     source: availableTags
//   });