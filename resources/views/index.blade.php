<html>
<body>
<h1>Total Revenue {{number_format($data['total_revenue'], 2)}}</h1>
<h3>Total Revenue {{$data['total_products_count']}}</h3>
<h3>Total Revenue {{number_format($data['first_half_revenue'], 2)}}</h3>
<h3>Total Revenue {{ number_format($data['second_half_revenue'], 2)}}</h3>


@foreach($data['categories'] as $categoryName => $category)
    <h1>{{ $categoryName }}</h1>
    count: {{ $category['products_count'] }}
    cost: {{ number_format($category['revenue'], 2) }}
@endforeach
</body>
</html>
