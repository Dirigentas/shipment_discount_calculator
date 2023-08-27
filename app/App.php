<?php

declare(strict_types=1);

namespace ShipmentDiscount;

use ShipmentDiscount\Controllers\ShipmentDiscountController;

/**
 * page control class
 */
class App
{
    /**
     * breaks the URL at each slash
     * @return string redirecting to the static method
     */
    public static function start(): string
    {
        $url = explode('/', $_SERVER['REQUEST_URI']);
        array_shift($url);
        return self::router($url);
    }
    
    /**
     * according to the split URL parts redirects to the necessary cotrollers methods
     * @param array gets an already split URL
     * @return string if the conditions are met, it does a redirect, if not we get information about a path not found
     */
    private static function router(array $url): string
    {
        $method = $_SERVER['REQUEST_METHOD'];

        if ($url[0] == 'vinted_shipment_discount' && $url[1] == 'public' && count($url) === 3 && $method == 'GET') {
            return (new ShipmentDiscountController)->index();
        }
        return '404 NOT FOUND';
    }

    /**
     * 
     * @param string $_name, the name of the View file to be used
     * @param array $data, the data being transferred
     * @return string if the conditions are met, it does a redirect, if not we get information about a path not found
     */
    public static function view(string $__name, array $data): string
    {
        // necessary so that the data does not travel immediately, but only when we collect all the necessary information
        ob_start();
        
        $data;

        require __DIR__ . '/../view/header.php';

        require __DIR__ . '/../view/' . $__name . '.php';
        
        require __DIR__ . '/../view/footer.php';

        // putting accumulated data into a variable and clearing memory
        $out = ob_get_contents();
        ob_end_clean();

        return $out;
    }
}

?>