$("#adminContainer").on("click",".adminTabChange",function() {
    let adminNavId = $(this).attr('id');
    let adminNavHolderId = adminNavId+'_holder';

    $("#"+adminNavId).addClass('adminNavSelect');
    $("#"+adminNavId).siblings().removeClass('adminNavSelect');

    $("#"+adminNavHolderId).show();
    $("#"+adminNavHolderId).siblings().hide();
    // alert( adminNavHolderId );
});


