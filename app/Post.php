<?php

namespace App;

use Cviebrock\EloquentSluggable\Sluggable;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Post extends Model
{
    use Sluggable;


    protected $fillable = ['title', 'content', 'description'];


    /**
     * Return the sluggable configuration array for this model.
     *
     * @return array
     */
    public function sluggable()
    {
        return [
            'slug' => [
                'source' => 'title'
            ]
        ];
    }


    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function category()
    {
        return $this->hasOne(Category::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function author()
    {
        return $this->hasOne(User::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function tags()
    {
        return $this->belongsToMany(
            Tag::class,
            'post_tags',
            'post_id',
            'tag_id');
    }


    /**
     * Создание поста
     * @param $fields
     * @return static
     */
    public static function add($fields)
    {
        $post = new static();
        $post->fill($fields);
        $post->user_id = 1;
        $post->save();

        return $post;
    }

    /**
     * Изменение поста
     * @param $fields
     */
    public function edit($fields)
    {
        $this->fill($fields);
        $this->save();
    }


    /**
     * Удаление поста
     * @throws \Exception
     */
    public function remove()
    {
        // Удаление картинки с папки
        Storage::delete('uploads/post/' . $this->image);

        // Удалить картинку поста
        $this->delete();
    }

    /**
     * Загрузка картинки для поста
     * @param $image
     */
    public function uploadImage($image)
    {

        if ($image == null) {
            return;
        }

        // Удаление картинки с папки
        Storage::delete('uploads/post/' . $this->image);

        // название картинки
        $filename = str_random(10) . '.' . $image->extension();

        $image->savaAs('uploads/post', $filename);
        $this->image = $filename;
        $this->save();
    }


    /**
     * Выводим картинку поста
     * @return string
     */
    public function getImage()
    {
        if ($this->image == null) {
            return '/img/no-image.png';
        } else {
            return '/uploads/post/' . $this->image;
        }

    }


    /**
     * сохранение категории (привязка категории)
     * @param $id
     */
    public function setCategory($id)
    {
        if ($id == null) {
            return;
        }

        $this->category_id = $id;
        $this->save();
    }


    /**
     * сохранение тегов (привязка тегов)
     * @param $ids
     */
    public function setTags($ids)
    {
        if ($ids == null) {
            return;
        }
        $this->tags()->sync($ids);
    }


    /**
     * Статус поста - черновик
     */
    public function setDraft()
    {
        $this->status = 0;
        $this->save();
    }

    /**
     * Статус поста - публичный
     */
    public function setPublic()
    {
        $this->status = 1;
        $this->save();
    }

    /**
     * Переключатель статуса
     * @param $value
     */
    public function toggleStatus($value)
    {
        if ($value == null) {
            return $this->setDraft();
        }
        return $this->setPublic();
    }


    /**
     * Статус поста - Рекомендованый пост
     */
    public function setFeatured()
    {
        $this->is_featured = 1;
        $this->save();
    }

    /**
     * Статус поста - обычный пост
     */
    public function setStandart()
    {
        $this->is_featured = 0;
        $this->save();
    }

    /**
     * Переключатель статуса
     * @param $value
     */
    public function toggleFeatured($value)
    {
        if ($value == null) {
            return $this->setStandart();
        }
        return $this->setFeatured();
    }


}

































