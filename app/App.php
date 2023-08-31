<?php

declare(strict_types=1);

namespace ShipmentDiscount;

use ShipmentDiscount\Controllers\ShipmentDiscountController;

/**
 * Webpage control class
 */
class App
{
    /**
     * Splits the URL at each slash and gives that array to router method.
     * 
     * @return string Returns router method.
     */
    public static function start(): string
    {
        $url = explode('/', $_SERVER['REQUEST_URI']);
        array_shift($url);
        return self::router($url);
    }
    
     /**
     * Routes the request to the appropriate controller based on the URL and request method.
     *
     * @param array $url The URL split into an array of segments.
     * @return string The response from the controller or a 404 error message.
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
     * Renders and returns a 'view' file.
     *
     * @param string $__name The name of the view file to render.
     * @param array $data An associative array of data to pass to the 'view'.
     * @return string The rendered 'view' output.
     */
    public static function view(string $__name, array $data): string
    {
        // necessary so that the data does not travel immediately, but only when we collect all the necessary information
        ob_start();

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