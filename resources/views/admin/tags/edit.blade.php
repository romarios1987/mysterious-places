@extends('admin.layout')

@section('content')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>Страница изменение тега</h1>
        </section>
        <!-- Main content -->
        <section class="content">
            <!-- Default box -->
            <div class="box">
                {{Form::open(['route' => ['tags.update', $tag->id], 'method' => 'PUT'])}}
                <div class="box-header with-border">
                    <h3 class="box-title">Изменить тег</h3>
                    @include('admin.errors')
                </div>
                <div class="box-body">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="title">Название</label>
                            <input type="text" class="form-control" name="title" id="title" value="{{$tag->title}}">
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
