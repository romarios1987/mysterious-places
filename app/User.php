<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\Storage;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email'
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
        $this->save();
    }

    /**
     * Обновление пароля
     * @param $password
     */
    public function generatePassword($password){
        if($password != null){
            $this->password = bcrypt($password);
            $this->save();
        }
    }


    /**
     * Удаление пользователя
     * @throws \Exception
     */
    public function remove()
    {
        $this->removeAvatar();
        $this->delete();
    }

    /**
     * Загрузка аватара для пользователя
     * @param $image
     */
    public function uploadAvatar($image)
    {
        if ($image == null) {
            return;
        }
        $this->removeAvatar();
        // название картинки
        $filename = str_random(10) . '.' . $image->extension();

        $image->storeAs('uploads/user', $filename);
        $this->avatar = $filename;
        $this->save();
    }

    public function removeAvatar(){
        if($this->avatar != null){
            // Удаление картинки с папки
            Storage::delete('uploads/user/' . $this->avatar);
        }
    }




    /**
     * Выводим аватарку пользователя
     * @return string
     */
    public function getAvatar()
    {
        if ($this->avatar == null) {
            return '/img/noavatar.png';
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
