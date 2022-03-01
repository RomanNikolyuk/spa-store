<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">

            @if(isset($slide))
                Редагування слайду
            @else
                Створення нового слайду
            @endif
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="-my-2 py-2 overflow-x-auto sm:-mx-6 sm:px-6 lg:-mx-8 pr-10 lg:px-8">
                <x-error-messages/>

                <div
                    class=" w-full justify-center align-middle rounded-tl-lg rounded-tr-lg inline-block w-full py-4 overflow-hidden bg-white shadow-lg px-12">

                    <form class="w-full max-w-lg"
                          action="{{ isset($slide) ? route('slider.save_edit', $slide->id) : route('slider.save_new') }}"
                          method="post" enctype="multipart/form-data">
                        @csrf

                        @if(isset($slide))
                            {{ method_field('put') }}
                        @endif
                        <div class="flex flex-wrap -mx-3 mb-6">

                            <div class="w-full mb-8">
                                <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2"
                                       for="grid-first-name">
                                    Заголовок
                                </label>
                                <input value="{{ $slide->big_text ?? old('big_text') }}"
                                       class="appearance-none block w-full bg-gray-200 text-gray-700 border border-gray-200 rounded py-3 px-4 mb-3 leading-tight focus:outline-none focus:bg-white"
                                       id="grid-first-name" name="big_text" type="text" placeholder="">
                            </div>


                            <div class="w-full mb-8">
                                <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2"
                                       for="grid-last-name">
                                    Червоний текст (зверху)
                                </label>
                                <textarea name="small_text_1"
                                          class=" no-resize appearance-none block w-full bg-gray-200 text-gray-700 border border-gray-200 rounded py-3 px-4 mb-3 leading-tight focus:outline-none focus:bg-white focus:border-gray-500 h-48 resize-none"
                                          id="small_desc" value="">{{ $slide->small_text_1 ?? old('small_text_1') }}</textarea>
                            </div>

                            <div class="w-full mb-8">
                                <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2"
                                       for="grid-password">
                                    Чорний текст (під заголовком)
                                </label>

                                <textarea name="small_text_2"
                                       class=" no-resize appearance-none block w-full bg-gray-200 text-gray-700 border border-gray-200 rounded py-3 px-4 mb-3 leading-tight focus:outline-none focus:bg-white focus:border-gray-500 h-48 resize-none"
                                          id="small_desc" value="">{{ $slide->small_text_2 ?? old('small_text_2') }}</textarea>
                            </div>


                            <div class="w-full mb-8">
                                <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2"
                                       for="grid-password">
                                    Текст на кнопці
                                </label>
                                <textarea name="button_text"
                                          class="no-resize appearance-none block w-full bg-gray-200 text-gray-700 border border-gray-200 rounded py-3 px-4 mb-3 leading-tight focus:outline-none focus:bg-white focus:border-gray-500 h-48 resize-none"
                                          id="big_desc">{{ $slide->button_text ?? old('button_text') }}</textarea>
                            </div>

                            <div class="w-full mb-8">
                                <label
                                    class="w-64 flex flex-col items-center px-4 py-6 bg-white text-blue-500 rounded-lg shadow-lg tracking-wide uppercase cursor-pointer hover:bg-blue-500 hover:text-white">
                                    <svg class="w-8 h-8" fill="currentColor" xmlns="http://www.w3.org/2000/svg"
                                         viewBox="0 0 20 20">
                                        <path
                                            d="M16.88 9.1A4 4 0 0 1 16 17H5a5 5 0 0 1-1-9.9V7a3 3 0 0 1 4.52-2.59A4.98 4.98 0 0 1 17 8c0 .38-.04.74-.12 1.1zM11 11h3l-4-4-4 4h3v3h2v-3z"/>
                                    </svg>
                                    <span class="mt-2 text-base leading-normal">Виберіть картинку</span>
                                    <input type='file' class="hidden" name="image">
                                </label>
                            </div>

                            <div class="w-full">
                                <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2"
                                       for="grid-password">
                                    Посилання на кнопці
                                </label>
                                <input name="url" value="{{ $slide->url ?? '' }}"
                                       class="appearance-none block w-full bg-gray-200 text-gray-700 border border-gray-200 rounded py-3 px-4 mb-3 leading-tight focus:outline-none focus:bg-white"
                                       id="grid-first-name" type="text" placeholder="">
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

                    @if(isset($slide))
                        <form action="{{ route('slider.delete', $slide->id) }}" method="post">
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
    <script>
        ClassicEditor.create(document.querySelector('#small_desc'));
        ClassicEditor.create(document.querySelector('#big_desc'));
    </script>
</x-app-layout>
