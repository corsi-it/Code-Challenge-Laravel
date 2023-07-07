@extends('app')

@section('content')
    <h1>Products table</h1>

    <table id="customers">
        <tr>
            <th>Product Id</th>
            <th>Product Name</th>
            <th>Category</th>
            <th>Price</th>
            <th>Date Added</th>
        </tr>

        @foreach($products as $product)
            <tr>
                <td>{{ $product['product_id'] }}</td>
                <td>{{ $product['product_name'] }}</td>
                <td>{{ $product['category'] }}</td>
                <td>{{ $product['price'] }}</td>
                <td>{{ $product['date_added'] }}</td>
            </tr>
        @endforeach
    </table>
@endsection
