<option value="{{ $category->id }}" {{ !is_null($selected) && $selected == $category->id ? 'selected' : '' }}>
    {{ str_repeat('-', $level) }} {{ $category->name }}
</option>
@if($category->children->isNotEmpty())
    @foreach($category->children as $child)
        @include('admin.categories.partials.option', ['category' => $child, 'level' => $level + 1, 'selected' => $selected])
    @endforeach
@endif
