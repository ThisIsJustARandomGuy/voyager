<div id="{{ $row->field }}" @isset($options->autocomplete) data-autocomplete="true" @endisset data-theme="{{ @$options->theme }}" data-language="{{ @$options->language }}" class="ace_editor min_height_200" name="{{ $row->field }}">
    {{ $dataTypeContent->{$row->field} ?? old($row->field) ?? $options->default ?? '' }}
</div>
<textarea name="{{ $row->field }}" id="{{ $row->field }}_textarea" class="hidden">{{ $dataTypeContent->{$row->field} ?? old($row->field) ?? $options->default ?? '' }}</textarea>