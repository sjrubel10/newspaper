<?php
?>
<h1> Manage Posts </h1>
<div class="post-card_holde">
    <ul id="" class="managepostsul">
        <?php if( count( $news )> 0 ){
            foreach ( $news as $key => $new ){
            ?>
        <li id="" class="managepostsulli">
            <h2><?php echo $new['title']?></h2>
            <p class="managePostDescription"><?php echo $new['description']?></p>
            <div class="actions" id="<?php echo $new['newskey']?>">
                <span class="action-btn managepost" id="edit"><i class="fas fa-edit"></i> <a class="leftnavlinktext" href="/newspaper/managesite/editnews.php?key=<?php echo $new['newskey']?>">Edit</a></span>
                <span class="action-btn managepost" id="delete"><i class="fas fa-trash-alt actionControl"></i> Delete</span>
<!--                <span class="action-btn managepost" id="modify"><i class="fas fa-wrench"></i> Modify</span>-->
<!--                <span class="action-btn managepost" id="publish"><i class="fas fa-upload"></i> Publish</span>-->
                <span class="action-btn managepost" id="private"><i class="fas fa-lock actionControl"></i> Make Private</span>
            </div>
        </li>
        <?php } }?>
    </ul>
</div>
