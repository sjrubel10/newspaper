<style>
    .tabs {
        display: flex;
        justify-content: space-around;
        background-color: #f2f2f2;
        padding: 10px 0;
    }

    .tab {
        flex: 1;
        text-align: center;
        padding: 10px;
        cursor: pointer;
        border-bottom: 2px solid transparent;
        transition: border-bottom 0.3s ease;
    }

    .tab:hover {
        border-bottom: 2px solid #3498db;
    }

    .tab.active {
        border-bottom: 2px solid #3498db;
    }
</style>
<?php
//ALTER TABLE `news` ADD `post_status` TINYINT(1) NOT NULL DEFAULT '1' AFTER `recorded`;
function make_tab_and_tab_holder_html( $page_title, $page_heading, $nav_names=[], $nav_holder_title_name=[] ){
    $navs = '';
    $nav_holders = '';
    foreach ( $nav_names as $nav => $nav_data ){
        $nav = trim( $nav );
        $nav_holder_id = $nav.'_hilder';
        $navs .= "<div id='$nav' class='tab'>$nav_data</div>";
        $nav_holders .= "<div id='$nav_holder_id' class='tabContentHolder'>$nav_data</div>";
    }
    $tab_and_tab_holder_html = "<div class=''>
        <h1> $page_heading </h1>
        <div class='post-card_holde'>
             <div class='tabs'>
                $navs
            </div>
            <div class='tabsContentHolder'>
                $nav_holders
            </div>
        </div>
    </div>";
    return $tab_and_tab_holder_html;
}
$nav_names = array(
        'nav1'=>'Nav 1',
        'nav2'=>'Nav 2',
        'nav3'=>'Nav 3',
        'nav4'=>'Nav 4',
        'nav5'=>'Nav 5',
        'nav6'=>'Nav 6',
);
echo make_tab_and_tab_holder_html( $page_title='', $page_heading = 'Manage Posts', $nav_names=[], $nav_holder_title_name=[] );
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
