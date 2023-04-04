@foreach($childs as $child)
    <option value="{{ $child->id }}">{{ str_repeat('-', $level)}}{{ $child->category_name }}</option>
        @if(count($child->childrens))
            @php $level += 1 @endphp
            @include('pages/transactions/category-child-option', [ 'childs' => $child->childrens, 'level' => $level ])
        @endif
@endforeach