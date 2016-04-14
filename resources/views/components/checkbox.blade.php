<div class="checkbox">
    <label>
        <input type="checkbox" name="{{ $name }}" id="{{ $id }}" @if($checked)checked
               @endif value="{{ $value }}"> {{ $label }}
    </label>
</div>