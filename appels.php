<?php

    require_once '../vendor/autoload.php';

    use App\Page;
    
    $page = new Page();

    

    echo $page->render('appels.html.twig', []);