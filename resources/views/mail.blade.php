<html>
<body>
<h1>Вітаю! Нове замовлення</h1>


<p><strong>Ім'я та прізвище: </strong> {{ request('first_name') . ' ' . request('last_name')}}</p>
<p><strong>Телефон: </strong> {{ request('telephone') }}</p>
<p><strong>Адреса доставки: </strong> {{ request('delivery_address') }}</p>
<p><strong>Продукти: </strong>
    @var($sum, 0)
    @foreach($products as $product)

        <a href="{{ route('item', $product->id) }}">{{ $product->title }}</a>;
        @var($sum, $sum + $product->price)
    @endforeach
</p>

<p><strong>Сума замовлення: </strong>{{ $sum }} гривень</p>

<p>Ви можете <a href="{{ route('dashboard.view', $order_id) }}">переглянути це замовлення</a> або <a
        href="{{ route('dashboard') }}">переглянути всі замовлення</a> 😉</p>

</body>
</html>


