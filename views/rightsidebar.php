<?php ?>
<div class="right-panel">
    <?php
    // Sample data for the card
    $cardData = array( [
            'image' => 'path/to/your/image.jpg',
            'title' => 'Card Title 1',
            'author' => 'Author Name',
            'date' => 'Created Date'
        ],
        [
            'image' => 'path/to/your/image.jpg',
            'title' => 'Card Title 2',
            'author' => 'Author Name',
            'date' => 'Created Date'
        ],
        [
            'image' => 'path/to/your/image.jpg',
            'title' => 'Card Title 3',
            'author' => 'Author Name',
            'date' => 'Created Date'
        ],
        [
            'image' => 'path/to/your/image.jpg',
            'title' => 'Card Title 4',
            'author' => 'Author Name',
            'date' => 'Created Date'
        ],

    );
    echo right_side_news_display( $news, "Popular News" );
    echo right_side_news_display( $cardData, "Latest News" );
    ?>






