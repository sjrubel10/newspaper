function get_post_according_to_action( action, newskey ){
    var allType;
    if( action === 'unpublish'){
        allType = '<span class="action-btn managepost" id="publish_'+newskey+'"><i class="fas fa-trash-alt"></i> Publish</span>\
                    <span class="action-btn managepost" id="delete_'+newskey+'"><i class="fas fa-trash-alt"></i> Delete</span>\
                    <span class="action-btn managepost" id="private_'+newskey+'"><i class="fas fa-lock"></i> Make Private</span>'
    }else if( action === 'delete' ){
        allType = '<span class="action-btn managepost" id="publish_'+newskey+'"><i class="fas fa-trash-alt"></i> Publish</span>\
                    <span class="action-btn managepost" id="unpublish_'+newskey+'"><i class="fas fa-trash-alt"></i> Unpublish</span>\
                    <span class="action-btn managepost" id="private_'+newskey+'"><i class="fas fa-lock"></i> Make Private</span>'
    }else if( action === 'publish' ){
        allType = '<span class="action-btn managepost" id="delete_'+newskey+'"><i class="fas fa-trash-alt"></i> Delete</span>\
                    <span class="action-btn managepost" id="unpublish_'+newskey+'"><i class="fas fa-trash-alt"></i> Unpublish</span>\
                    <span class="action-btn managepost" id="private_'+newskey+'"><i class="fas fa-lock"></i> Make Private</span>'
    }else if(action === 'private'){
        allType = '<span class="action-btn managepost" id="publish_'+newskey+'"><i class="fas fa-trash-alt"></i> Publish</span>\
                    <span class="action-btn managepost" id="unpublish_'+newskey+'"><i class="fas fa-trash-alt"></i> Unpublish</span>\
                    <span class="action-btn managepost" id="delete_'+newskey+'"><i class="fas fa-lock"></i> Delete</span>'
    }else{
        allType = '';
    }
    return allType;
}
function dislay_posts_for_manages( news, action ){
    let newskey = news['newskey'];
    let allType = get_post_according_to_action( action, newskey );
    return '<li id="'+news['newskey']+'" class="managepostsulli">\
                                <h2>'+news['title']+'</h2>\
                                <p class="managePostDescription">'+news['description']+'</p>\
                                <div class="actions" id="">\
                                    <span class="action-btn managepost" id="edit"><i class="fas fa-edit"></i> \
                                        <a class="leftnavlinktext" href="/newspaper/managesite/editnews.php?key='+news['newskey']+'">Edit</a>\
                                    </span>\
                                    '+allType+'\
                                </div>\
                            </li>';
    // return manageposts;
}

function navigate_tabs( clickClassHolderIdName, clickClassName, addSelectedClass, display_type, display_limit ){
    $("#"+clickClassHolderIdName).on("click","."+clickClassName+"",function() {
        let adminNavId = $(this).attr('id');
        let adminNavHolderId = adminNavId+'_holder';
        //Navigate tab and tab content
        $("#"+adminNavId).addClass(addSelectedClass);
        $("#"+adminNavId).siblings().removeClass(addSelectedClass);
        $("#"+adminNavHolderId).show();
        $("#"+adminNavHolderId).siblings().hide();
        //End
        let loadedIds ="";
        let end_point = "../main/jsvalidation/postsLoadForManage.php";
        let body_data = {
            action: adminNavId,
            limit: display_limit,
            loadedIds : loadedIds
        };
        get_data_from_api( end_point, body_data, adminNavHolderId, display_type );

    });
}

function get_data_from_api( end_point, body_data, appendedId, display_type ){
    if( end_point ) {
        $.post(
            end_point,
            body_data,
            function (data) {
                try {
                    let result_data = JSON.parse(data);
                    if (result_data['success']) {
                        if (display_type === 'display_news_control') {
                            let finalData = result_data.data;
                            $("#" + appendedId).empty();
                            if (finalData.length > 0) {
                                for (let i = 0; i < finalData.length; i++) {
                                    let display_data = dislay_posts_for_manages(finalData[i], body_data.action);
                                    $("#" + appendedId).append(display_data);
                                }
                            } else {
                                $("#" + appendedId).append('<span class="emptyData">No News Found</span>');
                            }
                        } else if (display_type === 'make_admin') {
                            let finalData = result_data.data;
                            alert(result_data.message);
                        } else {
                            alert("Something Went Wrong");
                        }

                    } else {
                        console.log(result_data['error_code']);
                        console.log(result_data['data']);
                    }
                } catch (error) {
                    console.log(error);
                }
            });
    }else{
        alert("Please Provide Valid Api End Point");
    }
}



