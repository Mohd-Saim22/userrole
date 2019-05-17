<?php

namespace App\Models\Comman\Html\Buttons;

/*
 * This file is part of Table Action Buttons.
 *
 * (c) Manojkiran.A <manojkiran10031998@gmail.com>
 *
 */

trait MissingRouteCatcher
{
    /**
     * Catches all the missing route guesser exception
     *
     * @param string $routeName Name of the Route
     * @throws Exception
     **/
    public function catchMissingRoute(string $routeName)
    {
        try {
            route($routeName);
        } catch (\Exception $exception) {

            $preparedMessage = 'Route [' . $routeName . '] not defined.';
            $exceptionMessage = $exception->getMessage();

            if ($preparedMessage  === $exceptionMessage) {
                throw new \Exception('Unable Guess the Route Name.Try Setting   deleteRoute  property in ' . class_basename($this). '', 1);
            }
        }

    }
}
