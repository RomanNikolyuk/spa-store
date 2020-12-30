<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Менеджер категорій
        </h2>
    </x-slot>


    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="-my-2 py-2 overflow-x-auto sm:-mx-6 sm:px-6 lg:-mx-8 pr-10 lg:px-8">
                <div
                    class="align-middle rounded-tl-lg rounded-tr-lg inline-block w-full py-4 overflow-hidden bg-white shadow-lg px-12">
                    <div class="flex justify-between">

                        <div class="flex flex-wrap items-stretch w-full h-full mb-6 relative">
                            <div class="flex">
                                <a href="{{ route('categories.new') }}"
                                   class="mt-5 inline-block px-6 py-2 text-xs font-medium leading-6 text-center text-white uppercase transition bg-blue-700 rounded-full shadow ripple hover:shadow-lg hover:bg-blue-800 focus:outline-none">
                                    Новий пукнт меню
                                </a>
                            </div>
                        </div>

                    </div>
                </div>


                @if($categories->count() > 0)
                    <div
                        class="align-middle inline-block min-w-full shadow overflow-hidden bg-white shadow-dashboard px-8 pt-3 rounded-bl-lg rounded-br-lg">
                        <table class="min-w-full">
                            <thead>
                            <tr>
                                <th class="px-6 py-3 border-b-2 border-gray-300 text-left leading-4 text-blue-500 tracking-wider">
                                    ID
                                </th>
                                <th class="px-6 py-3 border-b-2 border-gray-300 text-left text-sm leading-4 text-blue-500 tracking-wider">
                                    Ім'я
                                </th>

                                <th class="px-6 py-3 border-b-2 border-gray-300"></th>
                            </tr>
                            </thead>

                            <tbody class="bg-white">



                                @include('categories.render_item', ['categories' => $categories, 'tab' => ''])



                            </tbody>
                        </table>


                    </div>
                @endif


            </div>
        </div>
    </div>


</x-app-layout>
