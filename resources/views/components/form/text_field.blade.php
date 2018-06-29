<div class="form-group  {{ $errors->has($name) ? 'has-error' : '' }}">
    {{ Form::label($label?:$name, null, ['class' => 'control-label']) }}
    @if(isset($attributes) && in_array('required', $attributes))
        <small class="text-danger required-star"><i class="fa fa-star"></i></small>
    @endif
    {{ Form::text($name, $value, array_merge(['class' => 'form-control'], $attributes?:[])) }}
    {!! $errors->first($name, '<small class="help-block">:message</small>') !!}
</div>