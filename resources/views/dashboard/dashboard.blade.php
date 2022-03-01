<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Привіт!
            @if($orders->newCount > 0)
                Здається, з'явилися нові замовлення 😉
            @else
                Нових замовлень немає, проте я обов'язково Вас сповіщу, як тільки щось з'явиться 😁
            @endif
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="-my-2 py-2 overflow-x-auto sm:-mx-6 sm:px-6 lg:-mx-8 pr-10 lg:px-8">

                <x-success-message/>

                @if($orders->count() > 0)
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
                                <th class="px-6 py-3 border-b-2 border-gray-300 text-left text-sm leading-4 text-blue-500 tracking-wider">
                                    Прізвище
                                </th>

                                <th class="px-6 py-3 border-b-2 border-gray-300 text-left text-sm leading-4 text-blue-500 tracking-wider">
                                    Статус
                                </th>

                                <th class="px-6 py-3 border-b-2 border-gray-300 text-left text-sm leading-4 text-blue-500 tracking-wider">
                                    Продукти
                                </th>

                                <th class="px-6 py-3 border-b-2 border-gray-300 text-left text-sm leading-4 text-blue-500 tracking-wider">
                                    Час замовлення
                                </th>
                                <th class="px-6 py-3 border-b-2 border-gray-300"></th>
                            </tr>
                            </thead>
                            <tbody class="bg-white">

                            @foreach($orders as $count => $order)
                                <tr>
                                    <td class="px-6 py-4 whitespace-no-wrap border-b border-gray-500">
                                        <div class="flex items-center">
                                            <div>
                                                <div class="text-sm leading-5 text-gray-800">#{{ $order->id }}</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-no-wrap border-b border-gray-500">
                                        <div class="text-sm leading-5 text-blue-900">{{ $order->first_name }}</div>
                                    </td>

                                    <td class="px-6 py-4 whitespace-no-wrap border-b border-gray-500">
                                        <div class="text-sm leading-5 text-blue-900">{{ $order->last_name }}</div>
                                    </td>


                                    <td class="px-6 py-4 whitespace-no-wrap border-b text-blue-900 border-gray-500 text-sm leading-5">
                                        <span
                                                class="relative inline-block px-3 py-1 font-semibold text-green-900 leading-tight">
                                        <span aria-hidden
                                              class="absolute inset-0 bg-{{ $order->statusColor }}-200 opacity-50 rounded-full"></span>
                                        <span class="relative text-xs">
                                            @if($order->status === 2)
                                                Оброблене
                                            @elseif($order->status === 1)
                                                Очікує
                                            @else
                                                Відхилене
                                            @endif
                                        </span>
                                    </span>
                                    </td>

                                    @var($sum, 0)
                                    <td class="px-6 py-4 whitespace-no-wrap border-b border-gray-500 text-blue-900 text-sm leading-5">
                                        @foreach($order->products as $product)
                                            {{ $product->title }}; <br>
                                            @var($sum, $sum+$product->price)
                                        @endforeach
                                        Сума замовлення: <strong>{{ $sum }}</strong> грн
                                    </td>


                                    <td class="px-6 py-4 whitespace-no-wrap border-b border-gray-500 text-blue-900 text-sm leading-5">
                                        {{ mb_convert_case($order->created_at->locale('uk')->monthName, MB_CASE_TITLE) . ', ' . $order->created_at->day }}
                                    </td>


                                    <td class="px-6 py-4 whitespace-no-wrap text-right border-b border-gray-500 text-sm leading-5">
                                        <a href="{{ route('dashboard.view', $order->id) }}"
                                           class="px-5 py-2 border-blue-500 border text-blue-500 rounded transition duration-300 hover:bg-blue-700 hover:text-white focus:outline-none">
                                            Переглянути 👁
                                        </a>
                                    </td>
                                </tr>
                            @endforeach

                            </tbody>
                        </table>

                        <div class="sm:flex-1 sm:flex sm:items-center sm:justify-between mt-4 work-sans">
                            <div>
                                <p class="text-sm leading-5 text-blue-700">
                                    Показуємо від
                                    <span class="font-medium">{{ $orders->last()->id }}</span>
                                    до
                                    <span class="font-medium">{{ $count+1 }}</span>
                                    із
                                    <span class="font-medium">{{ $orders->count() }}</span>
                                    замовлень
                                </p>
                            </div>
                            <div>
                                <nav class="relative z-0 inline-flex shadow-sm">
                                    @if($orders->currentPage() > 1)
                                        <div v-if="$orders.current_page > 1">
                                            <a href="{{ route('dashboard').'?page='.($orders->currentPage()-1) }}"
                                               class="relative inline-flex items-center px-2 py-2 rounded-l-md border border-gray-300 bg-white text-sm leading-5 font-medium text-gray-500 hover:text-gray-400 focus:z-10 focus:outline-none focus:border-blue-300 focus:shadow-outline-blue active:bg-gray-100 active:text-gray-500 transition ease-in-out duration-150"
                                               aria-label="Previous"
                                               v-on:click.prevent="changePage(pagination.current_page - 1)">
                                                <svg class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                                    <path fill-rule="evenodd"
                                                          d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z"
                                                          clip-rule="evenodd"/>
                                                </svg>
                                            </a>
                                        </div>
                                    @endif
                                    <div>
                                        @if($orders->lastPage() > 1)
                                            @for($i = 1; $i <= $orders->lastPage(); $i++)
                                                <a href="{{ route('dashboard').'?page='.$i }}"
                                                   class="-ml-px relative inline-flex items-center px-4 py-2 border border-gray-300 bg-white text-sm leading-5 font-medium text-blue-700 focus:z-10 focus:outline-none focus:border-blue-300 focus:shadow-outline-blue active:bg-tertiary active:text-gray-700 transition ease-in-out duration-150 hover:bg-tertiary">
                                                    {{ $i }}
                                                </a>
                                            @endfor
                                        @endif
                                    </div>
                                    @if($orders->currentPage() < $orders->lastPage())
                                        <div v-if="$orders.current_page < $orders.last_page">
                                            <a href="{{ route('dashboard').'?page='.($orders->currentPage()+1) }}"
                                               class="-ml-px relative inline-flex items-center px-2 py-2 rounded-r-md border border-gray-300 bg-white text-sm leading-5 font-medium text-gray-500 hover:text-gray-400 focus:z-10 focus:outline-none focus:border-blue-300 focus:shadow-outline-blue active:bg-gray-100 active:text-gray-500 transition ease-in-out duration-150"
                                               aria-label="Next">
                                                <svg class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                                    <path fill-rule="evenodd"
                                                          d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"
                                                          clip-rule="evenodd"/>
                                                </svg>
                                            </a>
                                        </div>
                                    @endif
                                </nav>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
