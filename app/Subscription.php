<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Subscription extends Model
{
    public static function add($email)
    {
        $sub = new static;
        $sub->email = $email;
        $sub->save();

        return $sub;
    }

    public function generateToken()
    {
        $this->token = bin2hex(random_bytes(50));
        $this->save();
    }

    public function remove()
    {
        $this->delete();
    }
}
