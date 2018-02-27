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
    <a href="{{ route('roles.create') }}" class="btn btn-primary">@lang('New Role')</a>
@endsection
@section('main')
    <div class="row">
        <div class="col-md-12">
            <div class="box">

                <div class="box-body table-responsive">
                    <table id="roles" class="table table-striped table-bordered">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>@lang('Name')<span id="name" class="fa fa-sort pull-right"
                                                   aria-hidden="true"></span></th>
                            <th>@lang('Display Name')<span id="display_name" class="fa fa-sort pull-right"
                                                         aria-hidden="true"></span></th>
                            <th>@lang('Description')<span id="description" class="fa fa-sort pull-right"
                                                         aria-hidden="true"></span></th>
                            <th>@lang('creation')<span id="email" class="fa fa-sort pull-right"
                                                       aria-hidden="true"></span></th>
                            <th></th>
                            <th></th>
                        </tr>
                        </thead>
                        <tfoot>
                        <tr>
                            <th>#</th>
                            <th>@lang('Name')</th>
                            <th>@lang('Display Name')</th>
                            <th>@lang('Description')</th>
                            <th>@lang('creation')</th>
                            <th></th>
                            <th></th>
                        </tr>
                        </tfoot>
                        <tbody id="pannel">
                        @include('back.roles.table', compact('roles'))
                        </tbody>
                    </table>
                </div>
                <!-- /.box-body -->
                <div id="pagination" class="box-footer">
                    {{ $links }}
                </div>
            </div>
            <!-- /.box -->
        </div>
        <!-- /.col -->
    </div>
    <!-- /.row -->

@endsection

@section('js')
    <script src="/adminlte/js/back.js"></script>
    <script>

        var role = (function () {

            var url = '{{ route('roles.index') }}'
            var swalTitle = '@lang('Really destroy Role ?')'
            var confirmButtonText = '@lang('Yes')'
            var cancelButtonText = '@lang('No')'
            var errorAjax = '@lang('Looks like there is a server issue...')'

            var onReady = function () {
                $('#pagination').on('click', 'ul.pagination a', function (event) {
                    back.pagination(event, $(this), errorAjax)
                })
                $('#pannel').on('change', ':checkbox[name="seen"]', function () {
                    back.seen(url, $(this), errorAjax)
                })
                    .on('click', 'td a.btn-danger', function (event) {
                        back.destroy(event, $(this), url, swalTitle, confirmButtonText, cancelButtonText, errorAjax)
                    })
                $('th span').click(function () {
                    back.ordering(url, $(this), errorAjax)
                })
                $('.box-header :radio, .box-header :checkbox').click(function () {
                    back.filters(url, errorAjax)
                })
            }

            return {
                onReady: onReady
            }

        })()

        $(document).ready(role.onReady)

    </script>
@endsection