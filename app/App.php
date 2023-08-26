<?php

declare(strict_types=1);

namespace ShipmentDiscount;

use ShipmentDiscount\Controllers\ShipmentDiscountController;

//puslapio valdymo klasė
class App
{
    /**
     * suskaldo URL ties kiekvienu slash'u
     * 
     * @return string nukreipimas į statini metodą
     */
    public static function start(): string
    {
        $url = explode('/', $_SERVER['REQUEST_URI']);
        array_shift($url);
        return self::router($url);
    }
    
    /**
     * pagal suskaldytas URL dalis atlieka nukreipimus į reikiamas klases
     * @param array gauna jau suskaldytą URL
     * @return string jei tenkinamos sąlygos, padaro nukreipimą, jei ne gauname informaciją apie nerastą kelią
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
     * pagal suskaldytas URL dalis atlieka nukreipimus į reikiamas klases
     * @param string reikalingo naudotiti View failo pavadinimas
     * @param array/string failo duomenys arba failo pavadinimas
     * @param string/null vienas iš nukrepimų paduoda pasirinkto failo pavadinimą
     * @return string jei tenkinamos sąlygos, padaro nukreipimą, jei ne gauname informaciją apir nerastą kelią
     */
    public static function view(string $__name, $data, string $name = 'null'): string
    {
        //reikalinga tam, kad nekeliautų iš karto duomenys, o tik tuomet kai surenkame visą reikalingą info
        ob_start();
        
        //perduodami duomenys View failams
        $data;
        // $name;

        // require __DIR__ . '/../view/header.php';

        require __DIR__ . '/../view/' . $__name . '.php';
        
        // require __DIR__ . '/../view/footer.php';

        //sukaptų duomenų įdėjimas į kintamąjį ir atminties išvalymas
        $out = ob_get_contents();
        ob_end_clean();

        return $out;
    }
}

?>