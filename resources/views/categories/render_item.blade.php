@foreach($categories as $category)

    @if($category->parent_id === 0 || !empty($tab))
    <tr>
        <td class="px-6 py-4 whitespace-no-wrap border-b border-gray-500">
            <div class="flex items-center">
                <div>
                    <div class="text-sm leading-5 text-gray-800">
                        #{{ $category->id }}</div>
                </div>
            </div>
        </td>

        <td class="px-6 py-4 whitespace-no-wrap border-b border-gray-500">
            <div class="text-sm leading-5 text-blue-900">{{ $tab.$category->title }}</div>
        </td>

        <td class="px-6 py-4 whitespace-no-wrap text-right border-b border-gray-500 text-sm leading-5">
            <a href="{{ route('categories.edit', $category->id) }}"
               class="px-5 py-2 border-blue-500 border text-blue-500 rounded transition duration-300 hover:bg-blue-700 hover:text-white focus:outline-none">
                Змінити ✍
            </a>
        </td>
    </tr>
    @endif

    @if(! $category->children->isEmpty())
        @include('categories.render_item', ['categories' => $category->children, 'tab' => $tab.'--'])
    @endif

@endforeach
