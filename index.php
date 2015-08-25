<?php

if ($_GET['slug'] == '') $slug = 'home';
else $slug = $_GET['slug'];

include('cache/'.$slug.'.html');

?>