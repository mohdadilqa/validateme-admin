$(document).ready(function(){
    window._token = $('meta[name="csrf-token"]').attr('content');
    var base_url = window.location.origin;
    //Uplaod Refrerence Json Data
    $('.referenceDataUplaod').on('click',function(){
        //upload JSON form
        let title="Reference data upload";
        let html='<form method="post" action=#'+
                    '<div class="form-group">'+
                        '<label for="input"><b>Json Data:</b></label>'+
                        '<textarea class="form-control" id="refJsonData" name="refJsonData" required></textarea>'+
                    '</div><div style="display:none;" id="refDataUploadError"></div>'+
                    '<button type="button" class="btn btn-default float-right primary-button-class" onclick="uploadRefData()">Upload</button>'+
                '</form>';
        //Load html to POPUP
        $("#myModal .modal-title").html(title);
        $('.modal-body').html(html);
        $('#myModal').modal('show');//Model show
    });

    //Uplaod Refrerence Json Data
    $('.filedDataUpload').on('click',function(){
        //upload JSON form
        let title="Filed data upload";
        let html='<form method="post" action=#'+
                    '<div class="form-group">'+
                        '<label for="input"><b>Uplaod Data:</b></label>'+
                        '<textarea class="form-control" id="fieldData" name="fieldData" required></textarea>'+
                    '</div><div style="display:none;" id="fieldDataError"></div>'+
                    '<button type="button" class="btn btn-default float-right primary-button-class" onclick="uploadFieldData()">Upload</button>'+
                '</form>';
        //Load html to POPUP
        $("#myModal .modal-title").html(title);
        $('.modal-body').html(html);
        $('#myModal').modal('show');//Model show
    });
});