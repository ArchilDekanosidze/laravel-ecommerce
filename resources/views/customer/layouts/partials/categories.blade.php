@foreach ($categories as $category)

<span class="sidebar-nav-item-title">
    <a  href="{{ route('customer.products', ['category' => $category->id,'search' => request()->search, 'sort' => request()->sort, 'min_price' => request()->min_price, 'max_price' => request()->max_price, 'brands' => request()->brands]) }}"
        class="d-inline px-4">{{ $category->name }}</a>
    @if($category->children->count() > 0)
    <i class="fa fa-angle-right"></i>
    @endif
</span>
@include('customer.layouts.partials.sub-categories', ['categories' => $category->children])

@endforeach
