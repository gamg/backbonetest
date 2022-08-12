<?php

namespace App\Traits;

use Illuminate\Support\Str;

trait ZipCodeData
{
    public bool $firstMatch = false;
    public int $count = 0;
    public int $status = 200;

    public array $result = [
        'zip_code' => '',
        'locality' => '',
        'federal_entity' => [
            'key' => '',
            'name' => '',
            'code' => null
        ],
        'settlements' => [],
        'municipality' => [
            'key' => '',
            'name' => '',
        ],
    ];

    /**
     * Fill data from Zip Code
     *
     * @param  string  $zipCode
     */
    public function fillData(string $zipCode)
    {
        $file = fopen(public_path("data.txt"), 'r');

        while(!feof($file)) {
            $line = trim(fgets($file));
            $data = explode('|', $this->cleanString($line));

            if ($data[0] == $zipCode) {
                // set main data just once
                if (!$this->firstMatch) {
                    $this->result['zip_code'] = $data[0];
                    $this->result['locality'] = Str::upper($data[5]);
                    $this->result['federal_entity']['key'] = (int)$data[7];
                    $this->result['federal_entity']['name'] = Str::upper($data[4]);
                    $this->result['municipality']['key'] = (int)$data[11];
                    $this->result['municipality']['name'] = Str::upper($data[3]);
                    $this->firstMatch = true;
                }
                // set the settlements while zipCode repeats
                $this->result['settlements'][$this->count]['key'] = (int)$data[12];
                $this->result['settlements'][$this->count]['name'] = Str::upper($data[1]);
                $this->result['settlements'][$this->count]['zone_type'] = Str::upper($data[13]);
                $this->result['settlements'][$this->count]['settlement_type']['name'] = $data[2];
                $this->count++;
            } else if ($this->firstMatch) {
                break;
            }
        }

        fclose($file);

        if (!$this->firstMatch) {
            $this->result = ['message' => "No hay resultados para el código {$zipCode}"];
            $this->status = 404;
        }
    }

    /**
     * Replace characters with accents with characters without accents
     *
     * @param  string  $string
     * @return string
     */
    private function cleanString(string $string) {
        $old = 'ÁÉÍÓÚáéíóú';
        $new = 'AEIOUaeiou';
        return strtr($string, utf8_decode($old), $new);
    }

    /**
     * Find data from Cache or add it
     *
     * @param  $callback
     * @param  string  $zipCode
     */
    public function cache($callback, string $zipCode)
    {
        if (cache()->has($zipCode)) {
            $this->result = cache()->get($zipCode);
        } else {
            $callback($zipCode);
            cache()->put($zipCode, $this->result);
        }
    }
}
