<?php

declare(strict_types=1);

namespace ShipmentDiscount;

class FileReader
{
    /**
     * Gaunami pasirinkto failo duomenys bei apdorojami pagal priklausomai nuofailo plėtinio
     * @param string gaunamas pasirinkto failo pavadinimas
     * @return array tiek sėkmės, tiek nesėkmės atveju gaunamas masyvas
     */
    public static function getFileData(string $fileName)
    {
        $data = file_get_contents('./../public/' . $fileName);
        $data = explode("\n", $data);

        //priklausomai nuo pasirinkto failo yra pasirenkamas failo apdorojimo būdas
        // $data = match (substr($fileName, -4)) {
        //     '.xml' => json_decode(json_encode(simplexml_load_string($data)), true),
        //     '.csv' => csv($data),
        //     'json' => json_decode($data, true),
        //     default => ['Failo formatas netinkamas, prašome pakoreguoti failo plėtinį'],
        // };
        return $data;
    }
}

?>