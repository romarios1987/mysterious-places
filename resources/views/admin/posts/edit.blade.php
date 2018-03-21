@extends('admin.layout')

@section('content')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>Страница изменение статьи</h1>
        </section>

        <!-- Main content -->
        <section class="content">
            <!-- Default box -->
            <div class="box">
                {{Form::open(['route' => ['posts.update', $post->id], 'method' => 'PUT', 'files' => true])}}
                <div class="box-header with-border">
                    <h3 class="box-title">Изменить статью</h3>
                    @include('admin.errors')
                </div>
                <div class="box-body">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="title">Название</label>
                            <input type="text" class="form-control" id="title" name="title" value="{{$post->title}}">
                        </div>

                        <div class="form-group">
                            <img src="{{$post->getImage()}}" alt="{{$post->title}}" class="img-responsive" width="200">
                            <label for="image">Лицевая картинка</label>
                            <input type="file" id="image" name="image">
                        </div>

                        <div class="form-group">
                            <label>Категория</label>
                            {{Form::select('category_id',$categories, $post->getCategoryID(),['class' => 'form-control select2','placeholder' => 'Выбор категории'])}}
                        </div>
                        <div class="form-group">
                            <label>Теги</label>
                            {{Form::select('tags[]',$tags,$selectedTags,['class' => 'form-control select2', 'multiple' => 'multiple', 'data-placeholder' => 'Выберите теги'])}}
                        </div>
                        <!-- Date -->
                        <div class="form-group">
                            <label>Дата:</label>

                            <div class="input-group date">
                                <div class="input-group-addon">
                                    <i class="fa fa-calendar"></i>
                                </div>
                                <input type="text" class="form-control pull-right" name="date" id="datepicker"
                                       value="{{$post->date}}">
                            </div>
                            <!-- /.input group -->
                        </div>

                        <!-- checkbox -->
                        <div class="form-group">
                            <label>
                                {{Form::checkbox('is_featured', '1', $post->is_featured, ['class' => 'minimal'])}}
                            </label>
                            <label>
                                Рекомендовать
                            </label>
                        </div>
                        <!-- checkbox -->
                        <div class="form-group">
                            <label>
                                {{Form::checkbox('status', '1', $post->status, ['class' => 'minimal'])}}
                            </label>
                            <label>
                                Черновик
                            </label>
                        </div>
                    </div>

                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="description">Краткое описание</label>
                            <textarea name="description" id="description" cols="30" rows="10"
                                      class="form-control">{{$post->content}}</textarea>
                        </div>
                    </div>

                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="content">Полный текст</label>
                            <textarea name="content" id="content" cols="30" rows="10"
                                      class="form-control">{{$post->content}}</textarea>
                        </div>
                    </div>
                </div>
                <!-- /.box-body -->
                <div class="box-footer">
                    <button class="btn btn-warning pull-right">Изменить</button>
                </div>
                <!-- /.box-footer-->
                {{Form::close()}}
            </div>
            <!-- /.box -->

        </section>
        <!-- /.content -->
    </div>
@endsection