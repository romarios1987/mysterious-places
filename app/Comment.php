<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function author()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function post()
    {
        return $this->belongsTo(Post::class);
    }


    /**
     * Разрешить комментарии
     */
    public function allow()
    {
        $this->status = 1;
        $this->save();
    }

    /**
     * Запретить комментарии
     */
    public function disallow()
    {
        $this->status = 0;
        $this->save();
    }

    /**
     * Переключатель статуса комментариев
     */
    public function toggleStatus()
    {
        if ($this->status == 0) {
            return $this->allow();
        }
        return $this->disallow();
    }


    /**
     * Удаление комметария
     * @throws \Exception
     */
    public function remove()
    {
        $this->delete();
    }


}
