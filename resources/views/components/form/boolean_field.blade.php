<div class="form-group  {{ $errors->has($name) ? 'has-error' : '' }}">
    <?php
    if (old($name, 0) == 1 || ($checked && empty($errors))) {
        $attributes = array_merge(['checked' => 'checked'], $attributes ?: []);
    }
    ?>
    {{ Form::checkbox($name,$value,null, $attributes) }}
    {!! $errors->first($name, '<small class="help-block">:message</small>') !!}
    {{ Form::label($name, null, ['class' => 'control-label']) }}
</div>