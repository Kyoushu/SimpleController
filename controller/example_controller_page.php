<?php

// Custom logic goes here

echo $views->create('base')->render(array(
    'meta_title' => 'Example Controller Page',
    'title' => 'Example Controller Page',
    'body' => '<p><a href="/">Return to Homepage</a></p>'
));
