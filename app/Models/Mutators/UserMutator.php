<?php

namespace App\Models\Mutators;

use Illuminate\Support\Facades\Hash;

/**
 *  Handle all the User Accessor across the application
 */
trait UserMutator
{
    /**
     * Set Accessor for the password Attribute
     *
     * @author Manojkiran.A <manojkiran10031998@gmail.com>
     * @param string|null $password The Password Filed Value
     * @return void
     **/
    public function setPasswordAttribute(string $password = null)
    {
        if (! is_null($password))
        {
            $this->attributes['password'] = Hash::make($password);
        }
    }
}