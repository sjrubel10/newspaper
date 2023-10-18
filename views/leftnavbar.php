<?php ?>
<div class="left-nav">
    <h2>Category</h2>
        <?php
        $categorys = news_category();
            foreach ($categorys as $key => $category) {
                $key = str_replace(' ', '', strtolower($category));
                $categoryKeyValueArray[$key] = $category;
                $id = $key; // Generating unique ID for each category
                $class = 'left-nav-item'; // Class for styling
                echo '<a class="leftnavlinktext" href="index.php?category='.$key.'"><div id="' . $id . '" class="' . $class . '">' . $category . '</div></a>';
            }
        ?>
    </div>