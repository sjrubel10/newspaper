function navigate_tabs( clickClassHolderIdName, clickClassName, addSelectedClass ){
    $("#"+clickClassHolderIdName).on("click","."+clickClassName+"",function() {
        let adminNavId = $(this).attr('id');
        let adminNavHolderId = adminNavId+'_holder';

        //Navigate tab and tab content
        $("#"+adminNavId).addClass(addSelectedClass);
        $("#"+adminNavId).siblings().removeClass(addSelectedClass);
        $("#"+adminNavHolderId).show();
        $("#"+adminNavHolderId).siblings().hide();
        //End

        let loadedIds =[{}];
        let end_point = "../main/jsvalidation/postsLoadForManage.php";
        let body_data = {
            action: adminNavId,
            limit: 4,
            loadedIds : loadedIds
        };
        get_data_from_api( action, end_point, body_data );

    });
}


function get_data_from_api( action, end_point, body_data ){
    $.post(
        end_point,
        body_data,
        function( data ) {
                try {
                    let result_data = JSON.parse(data);
                    if (result_data['success']) {
                        console.log(result_data);
                        // $("#"+postKey).hide();
                    } else {
                        alert("Non");
                    }
                }catch (error) {
                    console.log(error);
                }
        });
}

function get_data_from_api_test( end_point, body_data ){
    $.post(
        end_point,
        body_data
    ).done( function (output) {
        // if (!has_error(output)) {
        try {
            var parsed_output = JSON.parse(output);
            console.log( parsed_output );
            if (parsed_output['success'] === true) {
                var length=parsed_output['data'].length;
                var toal_loaded_content=length;
                if (length>0) {
                    var managercontentdata = parsed_output['data'];
                    // loaded_contents = [...loaded_contents,...managercontentdata];
                    console.log(managercontentdata);
                } else {
                    console.log( "No data Found" );
                }
            } else {
                console.log(parsed_output['error_code']);
                console.log(parsed_output['data']);
            }
        } catch (error) {
            console.log(error);
        }
        // }
    });
}