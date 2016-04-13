<div class="form-group">
    <label for="{{ $name }}">{{ $label }}</label>
    <select required class="form-control" name="{{ $name }}" id="{{ $name }}">
        @if(isset($default))
            <option selected disabled>{{ $default }}</option>
        @endif

        @foreach($items as $title => $key)
            {{ $key }} {{ $title }}
            <option @if(isset($selected) && ($selected === $key)) selected
                    @endif value="{{ $key }}">{{ $title }}</option>
        @endforeach
    </select>
</div>