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
function make_display_tab_and_tab_holder_html( $clcikedClass, $page_heading, $nav_names, $selected_class ){
    $navs = '';
    $nav_holders = '';
    $i = 0;
    if( count( $nav_names )< 1 ){
        return "";
    }
    foreach ( $nav_names as $nav => $nav_data ){

        if( $i === 0 ){
            $display = 'block';
            $is_selected_class = $selected_class;
        }else {
            $display = 'none';
            $is_selected_class = '';
        }
        $nav = trim( $nav );
        $nav_holder_id = $nav.'_holder';
        $navs .= "<div id='$nav' class='tab $is_selected_class $clcikedClass'>$nav_data</div>";
        $nav_holders .= "<div id='$nav_holder_id' class='tabContentHolder' style='display: $display'>$nav_data</div>";
        $i++;
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
        'publish'=>'Published',
        'unpublish'=>'Unpublished',
        'private'=>'Private',
        'delete'=>'Deleted'
);
$clcikedClass = 'controlPost';
$selected_class = 'adminNavSelect';

?>
<div class="post-card_holde">
    <?php echo make_display_tab_and_tab_holder_html( $clcikedClass, 'Manage Posts', $nav_names, $selected_class );?>
</div>

<script>
    $(document).ready(function(){
        let addSelectedClass = <?php echo json_encode( $selected_class )?>;
        let clickClassName = <?php echo json_encode( $clcikedClass )?>;
        let clickClassHolderIdName = 'adminContainer';
        let display_limit = 20;
        const display_type = 'display_news_control';
        navigate_tabs( clickClassHolderIdName, clickClassName, addSelectedClass, display_type, display_limit );

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
                    let result_data = JSON.parse( data );
                    if ( result_data['success'] ) {
                        $("#"+postKey).hide();
                    } else {
                        console.log("Non");
                    }
                });
        });

    });
</script>
