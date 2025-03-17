@foreach($categories as $category)
    <option value="{{ $category->id }}">{{ $prefix }}{{ $category->name }}</option>
    @if($category->children->isNotEmpty())
        @include('admin.catalogues.category_options', ['category' => $category->children, 'prefix' => $prefix . '--- '])
    @endif
@endforeach
<!--file hiển thị ds cate theo dạng phân cấp-->
