<?php
namespace SEDE\Core;

if ( !defined( 'ABSPATH' ) ) {
    exit;
}

class Init
{
    public function __construct() {

        new \SEDE\Core\Options();
        new \SEDE\Core\Controller();
        new \SEDE\Core\Logging();
        new \SEDE\Core\Validations\Init();
        
    }
}