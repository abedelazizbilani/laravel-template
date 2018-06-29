<div class="form-group  {{ $errors->has($name) ? 'has-error' : '' }}">
    <?php
    if (old($name, 0) == 1 || ($checked && empty($errors))) {
        $checked = true;
    }
    ?>
    {{ Form::checkbox($name,$value,$checked, $attributes?:[]) }}
    {!! $errors->first($name, '<small class="help-block">:message</small>') !!}
    {{ Form::label($label?:$name, null, ['class' => 'control-label']) }}
</div>