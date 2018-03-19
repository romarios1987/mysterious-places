<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];


    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function posts()
    {
        return $this->hasMany(Post::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    /**
     * Создание пользователя
     * @param $fields
     * @return static
     */
    public static function add($fields)
    {
        $user = new static();
        $user->fill($fields);
        $user->password = bcrypt($fields['password']);
        $user->save();
        return $user;
    }


    /**
     * Изменение пользователя
     * @param $fields
     */
    public function edit($fields)
    {
        $this->fill($fields);
        $this->password = bcrypt($fields['password']);
        $this->save();
    }

    /**
     * Удаление пользователя
     * @throws \Exception
     */
    public function remove()
    {
        $this->delete();
    }

    /**
     * Загрузка аватара для пользователя
     * @param $image
     */
    public function uploadAvatar($avatar)
    {

        if ($avatar == null) {
            return;
        }
        // Удаление картинки с папки
        Storage::delete('uploads/user/' . $this->avatar);
        // название картинки
        $filename = str_random(10) . '.' . $avatar->extension();

        $avatar->savaAs('uploads/user', $filename);
        $this->avatar = $filename;
        $this->save();
    }

    /**
     * Выводим аватарку пользователя
     * @return string
     */
    public function getAvatar()
    {
        if ($this->avatar == null) {
            return '/img/no-avatar.png';
        } else {
            return '/uploads/user/' . $this->avatar;
        }
    }


    /**
     * Статус пользователя - Администратор
     */
    public function makeAdmin()
    {
        $this->is_admin = 1;
        $this->save();
    }

    /**
     * Статус пользователя - обычный пользователь
     */
    public function makeNormal()
    {
        $this->is_admin = 0;
        $this->save();
    }

    /**
     * Переключатель статуса пользователя
     * @param $value
     */
    public function toggleAdmin($value)
    {
        if ($value == null) {
            return $this->makeNormal();
        }
        return $this->makeAdmin();
    }


    /**
     * Пользователь забанен
     */
    public function ban()
    {
        $this->status = 1;
        $this->save();
    }

    /**
     * Пользователь разбанен
     */
    public function unban()
    {
        $this->status = 0;
        $this->save();
    }

    /**
     * Переключатель бана пользователя
     * @param $value
     */
    public function toggleBan($value)
    {
        if ($value == null) {
            return $this->unban();
        }
        return $this->ban();
    }


}
