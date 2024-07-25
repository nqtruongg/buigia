@if($children)
    @foreach($children as $child)
        @if($child)
            <option value="{{ $child->id }}" {{ $child->id == ($categoryCheck ?? '') ? 'selected' : '' }}>{{ str_repeat('-', $depth) }}{{ $child->name }}</option>
            @if(count($child->childrenRecursive) > 0)
                @include('components.child-category', [
                    'children' => $child->childrenRecursive,
                    'depth' => $depth + 1
                ])
            @endif
        @endif
    @endforeach
@endif
