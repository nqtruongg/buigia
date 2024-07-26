 {{-- nếu có thì sẽ thấy được sự khác biệt giữa 2 file blade.php trên --}}
@if($children)
    @foreach($children as $child)
        @if($child)
            @if(isset($selectedCategoryIds) && !empty($selectedCategoryIds))
                <option value="{{ $child->id }}"
                    @if (in_array($child->id, $selectedCategoryIds)) selected @endif>
                    {{ str_repeat('--', $depth) . ' ' . $child->name }}
                </option>
            @else
                <option value="{{ $child->id }}"
                    {{ $child->id == ($categoryCheck ?? '') ? 'selected' : '' }}>
                    {{ str_repeat('-', $depth) }}{{ $child->name }}
                </option>
            @endif

            @if(count($child->childrenRecursive) > 0)
                @include('components.child-category', [
                    'children' => $child->childrenRecursive,
                    'depth' => $depth + 1,
                    'selectedCategoryIds' => $selectedCategoryIds ?? null,
                    'categoryCheck' => $categoryCheck ?? null
                ])
            @endif
        @endif
    @endforeach
@endif
