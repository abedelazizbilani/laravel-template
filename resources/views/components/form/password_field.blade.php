<div class="form-group  {{ $errors->has($name) ? 'has-error' : '' }}">
    {{ Form::label($name, null, ['class' => 'control-label']) }}
    {{ Form::password($name, array_merge(['class' => 'form-control'], $attributes?:[])) }}
    {!! $errors->first($name, '<small class="help-block">:message</small>') !!}
</div>