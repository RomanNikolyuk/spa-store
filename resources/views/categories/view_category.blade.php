<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">

            @if(isset($category))
                Редагування "{{ $category->title }}"
            @else
                Створення нового пункту меню
            @endif
        </h2>
    </x-slot>


    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="-my-2 py-2 overflow-x-auto sm:-mx-6 sm:px-6 lg:-mx-8 pr-10 lg:px-8">
                <div
                    class="w-full justify-center align-middle rounded-tl-lg rounded-tr-lg inline-block w-full py-4 overflow-hidden bg-white shadow-lg px-12">

                    <form class="w-full max-w-lg"
                          action="{{ isset($category) ? route('categories.save_edit', $category->id) : route('categories.save_new') }}"
                          method="post">

                        @csrf

                        @if(isset($category))
                            {{ method_field('put') }}
                        @endif
                        <div class="flex flex-wrap -mx-3 mb-6">

                            <div class="w-full mb-8">
                                <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2"
                                       for="grid-first-name">
                                    Ім'я
                                </label>
                                <input value="{{ $category->title ?? '' }}"
                                       class="appearance-none block w-full bg-gray-200 text-gray-700 border border-gray-200 rounded py-3 px-4 mb-3 leading-tight focus:outline-none focus:bg-white"
                                       id="grid-first-name" name="title" type="text" placeholder="Вироби з металу">
                            </div>


                            <div class="w-full mb-8">
                                <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2"
                                       for="grid-password">
                                    Батьківський пункт меню
                                </label>
                                {!! Form::select('parent_id', $categories, $category->category->id ?? '', ['class' => 'border border-gray-200']) !!}
                            </div>


                        </div>

                        <div class="md:flex md:items-center">
                            <div class="md:w-1/3">
                                <button type="submit"
                                        class="inline-block px-6 py-2 text-xs font-medium leading-6 text-center text-white uppercase transition bg-blue-700 rounded-full shadow ripple hover:shadow-lg hover:bg-blue-800 focus:outline-none">
                                    Зберегти
                                </button>
                            </div>
                            <div class="md:w-2/3"></div>
                        </div>
                    </form>

                    @if(isset($category))
                        <form action="{{ route('categories.delete', $category->id) }}" method="post">
                            @csrf
                            @method('delete')

                            <button type="submit"
                                    class="mt-5 inline-block px-6 py-2 text-xs font-medium leading-6 text-center text-white uppercase transition bg-red-700 rounded-full shadow ripple hover:shadow-lg hover:bg-red-900 focus:outline-none">
                                Видалити
                            </button>


                        </form>
                    @endif

                </div>
            </div>
        </div>
    </div>





</x-app-layout>
