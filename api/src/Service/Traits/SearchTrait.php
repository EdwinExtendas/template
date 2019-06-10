<?php

namespace App\Service\Traits;

/**
 * Trait SearchTrait.
 */
trait SearchTrait
{
    /**
     * @param $array
     * @param $index
     * @param $value
     *
     * @return object|null
     */
    public function entityArraySearch($array, $index, $value)
    {
        foreach ($array as $array_inf)
        {
            if ($array_inf->$index() == $value)
            {
                return $array_inf;
            }
        }

        return null;
    }

    /**
     * @param $array
     * @param $index
     * @param $value
     *
     * @return object|null
     */
    public function objArraySearch($array, $index, $value)
    {
        foreach ($array as $array_inf)
        {
            if ($array_inf->{$index} == $value)
            {
                return $array_inf;
            }
        }

        return null;
    }
}
