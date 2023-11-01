$("#adminContainer").on("click",".adminTabChange",function() {
    let adminNavId = $(this).attr('id');
    let adminNavHolderId = adminNavId+'_holder';

    $("#"+adminNavId).addClass('adminNavSelect');
    $("#"+adminNavId).siblings().removeClass('adminNavSelect');

    $("#"+adminNavHolderId).show();
    $("#"+adminNavHolderId).siblings().hide();
    // alert( adminNavHolderId );
});


$( "#adminContainer" ).on( "click", ".managepost", function() {
    let clickedID = $(this).attr('id').trim();
    let splitResult = clickedID.split('_');
    let action = splitResult[0];
    let postKey = splitResult[1];

    $.post(
        "../main/jsvalidation/jsmanagecontent.php",
        {
            action: action,
            postKey: postKey
        },
        function(data) {
            // json_decode
            let result_data = JSON.parse( data );
            console.log( result_data );
            if ( result_data['success'] ) {
                alert( result_data['message']);
                $("#"+postKey).hide();
            } else {
                alert("Non");
            }
        });
});


