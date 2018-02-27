@extends('back.layout')

@section('main')
        <div class="row">
            @each('back/partials/pannel', $pannels, 'pannel')
        </div>
@endsection
