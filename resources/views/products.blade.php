<!DOCTYPE html>
<html>
<body>

<h1> Products</h1>

<table>
    <thead>
    <tr>
        <th>Product id</th>
        <th>Name</th>
        <th>Category</th>
        <th>Price</th>
        <th>Date</th>

    </tr>
    </thead>
    <tbody>
    @foreach($data['products'] as $product)
        <tr>
            <td>{{ $product['product_id'] }}</td>
            <td>{{ $product['product_name'] }}</td>
            <td>{{ $product['category'] }}</td>
            <td>{{ $product['price'] }}</td>
            <td>{{ $product['date_added'] }}</td>
        </tr>
    @endforeach
    </tbody>
</table>
</body>
</html>

<h1> Category data</h1>

<table>
    <thead>
    <tr>
        <th>Total revenue</th>
        <th>Total revenue first half</th>
        <th>Total revenue second half</th>
    </tr>
    </thead>
    <tbody>
    <tr>
        <td>{{ $data['total_revenue'] }}</td>
        <td>{{ $data['first_half_revenue'] }}</td>
        <td>{{ $data['second_half_revenue'] }}</td>
    </tr>
    </tbody>
</table>

<br>

<table>
    <thead>
    <tr>
        <th>Category Name</th>
        <th>Total products</th>
        <th>Average price</th>
    </tr>
    </thead>
    <tbody>
    @foreach($data['categories'] as $categoryName => $categoryData)
        <tr>
            <td>{{ $categoryName }}</td>
            <td>{{ $categoryData['products_count'] }}</td>
            <td>{{ round($categoryData['average'], 2) }}</td>

        </tr>
    @endforeach
    </tbody>
</table>
