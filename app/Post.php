<?php

namespace App;

use Carbon\Carbon;
use Cviebrock\EloquentSluggable\Sluggable;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Post extends Model
{
    use Sluggable;


    protected $fillable = ['title', 'content', 'description', 'date', 'slug'];


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
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function category()
    {
        return $this->belongsTo(Category::class);
    }


    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function author()
    {
        return $this->belongsTo(User::class, 'user_id');
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
        $this->removeImage();
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

        $this->removeImage();

        // название картинки
        $filename = str_random(10) . '.' . $image->extension();

        $image->storeAs('uploads/post', $filename);
        $this->image = $filename;
        $this->save();
    }


    /**
     * Удаления картинки
     */
    public function removeImage()
    {
        if ($this->image != null) {
            // Удаление картинки с папки
            Storage::delete('uploads/post/' . $this->image);
        }
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


    /**
     * Метод сеттер форматирования даты (мутаторы)
     * @param $value
     */
    public function setDateAttribute($value)
    {
        // есть "22/03/18"
        // делаем формат 201-09-13

        $date = Carbon::createFromFormat('d/m/y', $value)->format('Y-m-d');
        $this->attributes['date'] = $date;
    }


    /**
     * Метод геттер форматирования даты на вывод
     * @param $value
     * @return string
     */
    public function getDateAttribute($value)
    {
        $date = Carbon::createFromFormat('Y-m-d', $value)->format('d/m/y');
        return $date;
    }


    /**
     * Вывод заголовка категории для поста
     * @return string
     */
    public function getCategoryTitle()
    {
        if ($this->category != null) {
            return $this->category->title;
        }
        return 'Нет категории';
    }

    /**
     * Наличие в поста категории
     * @return null
     */
    public function getCategoryID()
    {
        return $this->category != null ? $this->category->id : null;
    }

    /**
     * Вывод заголовка тегов для поста
     * @return string
     */
    public function getTagsTitles()
    {
        if (!$this->tags->isEmpty()) {
            return implode(', ', $this->tags->pluck('title')->all());
        }
        return 'Нет тегов';
    }


    /**
     * Вывод форматированной даты для поста
     * @return string
     */
    public function getDate()
    {
        //dd($this->date);
        return Carbon::createFromFormat('d/m/y', $this->date)->format('F d, Y');
    }


    /**
     * Возвращает предыдущий пост
     * @return mixed
     */
    public function hasPrevious()
    {
        return self::where('id', '<', $this->id)->max('id');
    }


    public function getPrevious()
    {
        $postID = $this->hasPrevious(); // ID
        return self::find($postID);
    }


    /**
     * Возвращает следующий пост
     * @return mixed
     */
    public function hasNext()
    {
        return self::where('id', '>', $this->id)->min('id');
    }

    public function getNext()
    {
        $postID = $this->hasNext(); // ID
        return self::find($postID);
    }


    /**
     * Выводим все посты кроме текущего
     * @return static
     */
    public function related()
    {
        return self::all()->except($this->id);
    }


}

































