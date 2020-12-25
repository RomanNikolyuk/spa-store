<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Я впевнений, {{ $order->first_name }} буде задоволений покупкою
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="-my-2 py-2 overflow-x-auto sm:-mx-6 sm:px-6 lg:-mx-8 pr-10 lg:px-8">
                <div
                    class="flex items-center  w-full justify-center align-middle rounded-tl-lg rounded-tr-lg inline-block w-full py-4 overflow-hidden bg-white shadow-lg px-12">

                    <div class="p-2 text-center">
                        <h3 class="text-center text-xl text-gray-900 font-medium leading-8">Перегляд замовлення
                            #{{ $order->id }}</h3>
                        <table class="text-xs my-3">
                            <tbody>
                            <tr>
                                <td class="px-2 py-2 text-purple-500 font-semibold">Ім'я</td>
                                <td class="px-2 py-2">{{ $order->first_name }}</td>
                            </tr>
                            <tr>
                                <td class="px-2 py-2 text-purple-500 font-semibold">Прізвище</td>
                                <td class="px-2 py-2">{{ $order->last_name }}</td>
                            </tr>

                            <tr>
                                <td class="px-2 py-2 text-purple-500 font-semibold">Email</td>
                                <td class="px-2 py-2">{{ $order->email }}</td>
                            </tr>

                            <tr>
                                <td class="px-2 py-2 text-purple-500 font-semibold">Телефон</td>
                                <td class="px-2 py-2">{{ $order->telephone }}</td>
                            </tr>


                            <tr>
                                <td class="px-2 py-2 text-purple-500 font-semibold">Адреса доставки</td>
                                <td class="px-2 py-2">{{ $order->delivery_address }}</td>
                            </tr>

                            <tr>
                                <td class="px-2 py-2 text-purple-500 font-semibold">Продукти</td>
                                <td class="px-2 py-2">
                                    @foreach($order->products as $product)
                                        <a href="#">{{ $product->title }}</a>;<br>
                                    @endforeach
                                </td>
                            </tr>

                            <tr>
                                <td class="px-2 py-2 text-purple-500 font-semibold">Час замовлення</td>
                                <td class="px-2 py-2">{{ $order->created_at->day.'.'.$order->created_at->month.'.'.$order->created_at->year. ' ' . $order->created_at->hour.':'.$order->created_at->minute.':'.$order->created_at->second }}</td>
                            </tr>

                            </tbody>
                        </table>

                        <div class="text-center my-3">
                            <form action="{{ route('dashboard.changeStatus', $order->id) }}" method="post">
                                @csrf

                                <button type="submit"
                                        class="inline-block px-6 py-2 text-xs font-medium leading-6 text-center text-white uppercase transition bg-blue-700 rounded-full shadow ripple hover:shadow-lg hover:bg-blue-800 focus:outline-none">
                                    @if($order->status == 1 || $order->status == 0)
                                        Замовлення оброблено
                                    @else
                                        Відхилити замовлення
                                    @endif


                                </button>

                                @if($order->status == 1)
                                    <a class="block px-2 py-2 text-red-800 font-semibold" href="{{ route('dashboard.changeStatus', $order->id) }}?cancel">Відхилити замовлення</a>
                                @endif
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>


</x-app-layout>
