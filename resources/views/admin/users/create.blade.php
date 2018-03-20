@extends('admin.layout')

@section('content')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>Страница добавление пользователя</h1>
        </section>
        <!-- Main content -->
        <section class="content">
            <!-- Default box -->
            <div class="box">
                {!! Form::open(['route' => 'users.store', 'files' => true]) !!}
                <div class="box-header with-border">
                    <h3 class="box-title">Добавить пользователя</h3>
                    @include('admin.errors')
                </div>
                <div class="box-body">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="name">Имя</label>
                            <input type="text" class="form-control" name="name" id="name"
                                   placeholder="Введите имя пользователя" value="{{old('name')}}">
                        </div>
                        <div class="form-group">
                            <label for="email">E-mail</label>
                            <input type="text" class="form-control" id="email" name="email"
                                   placeholder="Введите email пользователя" value="{{old('email')}}">
                        </div>
                        <div class="form-group">
                            <label for="password">Пароль</label>
                            <input type="password" class="form-control" name="password" id="password"
                                   placeholder="Введите пароль пользователя">
                        </div>
                        <div class="form-group">
                            <label for="avatar">Аватар</label>
                            <input type="file" id="avatar" name="avatar">
                        </div>
                    </div>
                </div>
                <!-- /.box-body -->
                <div class="box-footer">
                    <button class="btn btn-success pull-right">Добавить</button>
                </div>
                <!-- /.box-footer-->
                {!! Form::close() !!}
            </div>
            <!-- /.box -->

        </section>
        <!-- /.content -->
    </div>
@endsection