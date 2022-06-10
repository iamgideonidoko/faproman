<?php

namespace App\Helper;

class View {

    private static $path = __DIR__ . '/../../views/';
    private static $tempPath = __DIR__ . '/../../temp/';

    /**
     * Render a view
     *
     * @param string $view
     * @param array $parameters
     * @param string $pageTitle
     * @return void
     */
    public static function render(string $view, array $parameters = array(), string $pageTitle = 'Faproman') {
        // make page title available
        $pageTitle = $pageTitle;
        // extract the parameters into variables
        extract($parameters, EXTR_SKIP);
        require_once(self::$tempPath . 'header.php');
        require_once(self::$path . $view);
        require_once(self::$tempPath . 'footer.php');
    }
    
}
