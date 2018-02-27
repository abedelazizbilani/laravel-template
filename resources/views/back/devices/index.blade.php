@extends('back.layout')

@section('main')
    <div class="card border-top-card">
        <div class="nav-tabs-custom nav-tabs-custom-bottom">
            <ul class="nav nav-tabs">
                <li class="nav-item custom-nav-item">
                    <a class="nav-link active" href="#tab_1" data-toggle="tab">@lang('List')</a>
                </li>
                <li class="nav-item custom-nav-item">
                    <a class="nav-link" href="#tab_2" data-toggle="tab" data-tab="map">@lang('Map')</a>
                </li>
            </ul>
            <div class="tab-content">
                <div class="tab-pane fade active show" id="tab_1" aria-expanded="true">
                    <div class="card-body">
                        <table class="table table-striped table-bordered">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>
                                    @lang('Type')
                                    <span id="name" class="fa fa-sort pull-right" aria-hidden="true"></span>
                                </th>
                                <th>
                                    @lang('Version')
                                    <span id="name" class="fa fa-sort pull-right" aria-hidden="true"></span>
                                </th>
                                <th>
                                    @lang('UUID')
                                    <span id="name" class="fa fa-sort pull-right" aria-hidden="true"></span>
                                </th>
                                <th>
                                    @lang('Status')
                                    <span id="name" class="fa fa-sort pull-right" aria-hidden="true"></span>
                                </th>
                                <th>
                                    @lang('Local')
                                    <span id="name" class="fa fa-sort pull-right" aria-hidden="true"></span>
                                </th>
                                <th>
                                    @lang('Last access')
                                    <span id="name" class="fa fa-sort pull-right" aria-hidden="true"></span>
                                </th>
                                <th>
                                    @lang('Latitude')
                                    <span id="name" class="fa fa-sort pull-right" aria-hidden="true"></span>
                                </th>
                                <th>
                                    @lang('Longitude')
                                    <span id="name" class="fa fa-sort pull-right" aria-hidden="true"></span>
                                </th>
                                <th>
                                    @lang('Creation')
                                    <span id="name" class="fa fa-sort pull-right" aria-hidden="true"></span>
                                </th>
                            </tr>
                            </thead>
                            <tbody>
                            @include('back.devices.table', compact('devices'))
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="tab-pane fade" id="tab_2">
                    <div class="card-body">
                        <div id="map" style="width:100%;height:calc(100vh - 285px);"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection