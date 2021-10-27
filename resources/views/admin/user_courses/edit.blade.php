@extends('admin.layouts.app')
@section('title')
Edit User Courses
@endsection
@section('header')
<style>
    .ik {
        cursor: pointer;
    }

    #trHover:hover {
        background-color: #e6e6e6;
    }

</style>
@endsection
@section('iconHeader')
<i class="ik ik-menu bg-icon"></i>
@endsection
@section('titleHeader')
User Courses
@endsection
@section('subtitleHeader')
Edit User Courses
@endsection
@section('breadcrumb')
User Courses
@endsection
@section('content-wrapper')
@if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
<!-- Content Wrapper. Contains page content -->
<div class="row">
    <div class="col-sm-12" style="margin-bottom:20%">
        <div class="card">
            <div class="box-body" style="padding-bottom:50px">
                <form class="text-left border border-light p-5" action="{{route('user_courses.update', $data->id)}}" method="POST"
                    enctype="multipart/form-data" style="padding-bottom: 50px;">
                    @csrf
                    @method('PUT')
                    <div class="form-group">
                        <label>Email</label>
                        <div class="input-group">
                            <span class="input-group-prepend">
                                <label class="input-group-text"><i class="ik ik-edit-1"></i></label>
                            </span>
                            <select name="user_id" class="select2 form-control" id="default-select">
                                @foreach ($users as $user)
                                <option value="{{$user->id}}"
                                    @if ($user->id == $data->user_id)
                                    {{'selected'}}
                                    @endif
                                    >{{$user->email}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <label>Courses</label>
                        <div class="input-group">
                            <span class="input-group-prepend">
                                <label class="input-group-text"><i class="ik ik-edit-1"></i></label>
                            </span>
                            <select name="course_id" class="select2 form-control" id="default-select">
                                @foreach ($courses as $course)
                                <option value="{{$course->id}}"
                                    @if ($course->id == $data->course_id)
                                    {{'selected'}}
                                    @endif
                                    >{{$course->english_text}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <label>Answer</label>
                        <div class="input-group">
                            <span class="input-group-prepend">
                                <label class="input-group-text"><i class="ik ik-edit-1"></i></label>
                            </span>
                            <input type="text" class="form-control  " placeholder="Answer"
                                id="answer" name="answer" value="{{$data->answer}}">
                        </div>
                    </div>

                    <div class="form-group">
                        <label>Checked</label>
                        <div class="input-group">
                            <span class="input-group-prepend">
                                <label class="input-group-text"><i class="ik ik-edit-1"></i></label>
                            </span>
                            <select name="checked" class="select2 form-control" id="default-select">
                                <option value="t"
                                @if ($data->checked == 't')
                                {{'selected'}}
                                @endif>True</option>
                                <option value="f"
                                @if ($data->checked == 'f')
                                {{'selected'}}
                                @endif>False</option>
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <label>Is True</label>
                        <div class="input-group">
                            <span class="input-group-prepend">
                                <label class="input-group-text"><i class="ik ik-edit-1"></i></label>
                            </span>
                            <select name="is_true" class="select2 form-control" id="default-select">
                                <option value="t"
                                @if ($data->is_true == 't')
                                {{'selected'}}
                                @endif>True</option>
                                <option value="f"
                                @if ($data->is_true == 'f')
                                {{'selected'}}
                                @endif>False</option>
                            </select>
                        </div>
                    </div>

                    <div class="footer-buttons">
                        <a class="fixedButtonRefresh" href="{{route('user_courses.index')}}">
                            <button data-toggle="tooltip" data-placement="top" title="" type="button"
                                class="btn btn-icon btn-refresh " data-original-title="Back">
                                <i class="ik ik-arrow-left bg-ik"></i>
                            </button>
                        </a>
                        <a class="fixedButtonAdd">
                            <button data-toggle="tooltip" type="submit" data-placement="top" title="" href=""
                                class="btn btn-icon btn-add" data-original-title="Save">
                                <i class="ik ik-save"></i>
                            </button>
                        </a>
                    </div>
                </form>
            </div>
            <!-- /.box-body -->
        </div>
        <!-- /.box -->
    </div>
    <!-- /.col -->
</div>
<!-- /.content-wrapper -->
@endsection
@section('footer')
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.form/4.3.0/jquery.form.min.js"></script>

@endsection
