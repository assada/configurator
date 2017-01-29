<?php

namespace Assada\Dumper;


/**
 * Class IniDumper
 *
 * @package Assada\Dumper
 *
 * @author  Aleksey Ilyenko <assada.ua@gmail.com>
 */
class IniDumper implements DumperInterface
{

    /**
     * @inheritdoc
     */
    public function dump(array $data): string
    {
        $flatData = $this->flatData($data);

        $file = '';
        foreach ($flatData as $key => $value) {
            $file .= sprintf('%s = %s', $key, $value);
        }

        return $file;
    }

    /**
     * @param array  $arr
     * @param array  $nestedArray
     * @param string $nestedKey
     *
     * @return array
     */
    private function flatData(array $arr, array $nestedArray = [], string $nestedKey = ''): array
    {
        foreach ($arr as $key => $value) {
            if (is_array($value)) {
                $nestedArray = array_merge($nestedArray, $this->flatData($value, $nestedArray, $nestedKey . $key . '.'));
            } else {
                $nestedArray[$nestedKey . $key] = $value;
            }
        }

        return $nestedArray;
    }
}