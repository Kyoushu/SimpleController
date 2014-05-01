<?php

namespace Kyoushu\SimpleController;

// Custom logic goes here

echo renderView('base', array(
    'meta_title' => 'Example Controller Page',
    'title' => 'Example Controller Page',
    'body' => '<p><a href="/">Return to Homepage</a></p>'
));
