@extends('back.layout')

@section('css')
    <link rel="stylesheet" href="//cdn.jsdelivr.net/sweetalert2/6.3.8/sweetalert2.min.css">
    <style>
        input, th span {
            cursor: pointer;
        }
    </style>
@endsection

@section('button')
    <a href="{{ route('posts.create') }}" class="btn btn-primary">@lang('New post')</a>
@endsection
<form method="GET" action="{{ url('/dashboard/posts') }}" accept-charset="UTF-8" class="navbar-form navbar-right" role="search">
    <div class="input-group">
        <input type="text" class="form-control" name="search" placeholder="Search..." value="{{ request('search') }}">
        <span class="input-group-btn">
            <button class="btn btn-default" type="submit">
                <i class="fa fa-search"></i>
            </button>
        </span>
    </div>
</form>
@section('main')
    <div class="row">
        <div class="col-md-12">
            <div class="box">
                <div class="box-body table-responsive">
                    <table id="dashboard/" class="table table-striped table-bordered">
                        <thead>
                            <tr>
                            <tfoot>
                                <th>#</th><th>Title</th><th>Body</th><th>Actions</th>
                            </tr>
                            </tfoot>
                        </thead>
                        <tbody id="pannel">
                             @include('back.posts.table', compact('posts'))
                        </tbody>
                    </table>
                </div>
                <!-- /.box-body -->
                <div id="pagination" class="box-footer">
{{--                    {{ $links }}--}}
                </div>
            </div>
            <!-- /.box -->
        </div>
        <!-- /.col -->
    </div>
    <!-- /.row -->
@endsection
