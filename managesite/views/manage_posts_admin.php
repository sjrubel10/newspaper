<?php
//ALTER TABLE `news` ADD `post_status` TINYINT(1) NOT NULL DEFAULT '1' AFTER `recorded`;
?>
<h1> Manage Posts </h1>
<div class="post-card_holde">
    <ul id="" class="managepostsul">
        <h3> Published Posts </h3>
        <?php if( count( $news )> 0 ){
            foreach ( $news as $key => $new ){
            ?>
        <li id="<?php echo $new['newskey']?>" class="managepostsulli">
            <h2><?php echo $new['title']?></h2>
            <p class="managePostDescription"><?php echo $new['description']?></p>
            <div class="actions" id="">
                <span class="action-btn managepost" id="edit"><i class="fas fa-edit"></i> <a class="leftnavlinktext" href="/newspaper/managesite/editnews.php?key=<?php echo $new['newskey']?>">Edit</a></span>
                <span class="action-btn managepost" id="unpublish_<?php echo $new['newskey']?>"><i class="fas fa-trash-alt"></i> Unpublish</span>
                <span class="action-btn managepost" id="delete_<?php echo $new['newskey']?>"><i class="fas fa-trash-alt"></i> Delete</span>
                <span class="action-btn managepost" id="private_<?php echo $new['newskey']?>"><i class="fas fa-lock"></i> Make Private</span>
            </div>
        </li>
        <?php }
        } ?>
    </ul>
</div>

<script>
    let news;

    function get_post_according_to_action( action, newskey ){
        if( action === 'Unpublish'){
            allType = '<span class="action-btn managepost" id="publish_'+newskey+'"><i class="fas fa-trash-alt"></i> Publish</span>\
                    <span class="action-btn managepost" id="delete_'+newskey+'"><i class="fas fa-trash-alt"></i> Delete</span>\
                    <span class="action-btn managepost" id="private_'+newskey+'"><i class="fas fa-lock"></i> Make Private</span>\'
        }else if( action === 'Delete' ){
            allType = '<span class="action-btn managepost" id="publish_'+newskey+'"><i class="fas fa-trash-alt"></i> Publish</span>\
                    <span class="action-btn managepost" id="unpublish_'+newskey+'"><i class="fas fa-trash-alt"></i> Unpublish</span>\
                    <span class="action-btn managepost" id="private_'+newskey+'"><i class="fas fa-lock"></i> Make Private</span>\'
        }else if(action === 'Private'){
            allType = '<span class="action-btn managepost" id="publish_'+newskey+'"><i class="fas fa-trash-alt"></i> Publish</span>\
                    <span class="action-btn managepost" id="unpublish_'+newskey+'"><i class="fas fa-trash-alt"></i> Unpublish</span>\
                    <span class="action-btn managepost" id="delete_'+newskey+'"><i class="fas fa-lock"></i> Delete</span>\'
        }else{
            allType = '';
        }
        return allType;
    }


    function dislay_posts_for_manages( news, action ){
        let newskey = news['newskey'];
        let allType = get_post_according_to_action( action, newskey );
        let manageposts = '<li id=" '+news['newskey']+'" class="managepostsulli">\
                                <h2>'+news['title']+'</h2>\
                                <p class="managePostDescription">'+news['description']+'</p>\
                                <div class="actions" id="">\
                                    <span class="action-btn managepost" id="edit"><i class="fas fa-edit"></i> \
                                        <a class="leftnavlinktext" href="/newspaper/managesite/editnews.php?key='+news['newskey']+'">Edit</a>\
                                    </span>\
                                    '+allType+'\
                                </div>\
                            </li>';
        return manageposts;
    }

    let manageNewsLists = dislay_posts_for_manages( news, action );

</script>
