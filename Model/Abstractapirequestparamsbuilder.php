<?php
/**
 * @author     Sebastian Ruchlewicz <contact@codeapp.pl>
 * @copyright  Copyright (c) 2024 (https://codeapp.pl)
 */

abstract class CodeApp_Klar_Model_Abstracatpirequestparamsbuilder
{
    /**
     * Convert snake case to camel case.
     *
     * @param array $data
     *
     * @return array
     */
    protected function snakeToCamel(array $data)
    {
        $result = [];

        foreach ($data as $key => $value) {
            $newKey = lcfirst(str_replace('_', '', ucwords($key, '_')));
            $result[$newKey] = $value;
        }

        return $result;
    }

    /**
     * Get timestamp from date time string.
     *
     * @param string $dateTime
     *
     * @return int
     */
    protected function getTimestamp(string $dateTime): int
    {
        if ($dateTime === '' | !$dateTime) {
            return $this->dateTimeFactory->create()->getTimestamp();
        }

        return $this->dateTimeFactory->create($dateTime)->getTimestamp();
    }
}