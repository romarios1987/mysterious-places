<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Subscription extends Model
{
    /**
     * Добавление подписчика
     * @param $email
     * @return static
     */
    public static function add($email)
    {
        $sub = new static();
        $sub->email = $email;
        $sub->token = str_random(100);
        $sub->save();
        return $sub;
    }

    /**
     * Удаление подписчика
     * @throws \Exception
     */
    public function remove()
    {
        $this->delete();
    }
}
