<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Laravel</title>

    <style>
        body {
            font-family: 'Nunito', sans-serif;
        }
    </style>
</head>
<body>
<div>
    <h1>Results ({{ $products->count() }})</h1>
    <table>
        <tr>
            <th>Product ID</th>
            <th>Product Name</th>
            <th>Price</th>
            <th>Category</th>
            <th>Date added</th>
        </tr>
        @foreach ($products as $product)
            <tr>
                <td>{{ $product->product_id }}</td>
                <td>{{ $product->product_name }}</td>
                <td>{{ $product->category }}</td>
                <td>{{ $product->price }}</td>
                <td>{{ $product->date_added }}</td>
            </tr>
        @endforeach
        <tfoot>
            <tr><th colspan="5">Stats</th></tr>
            <tr><td colspan="4">Total revenues</td><td><strong>{{ $total }}</strong></td></tr>
            <tr><td colspan="4">Total first half of month</td><td><strong>{{ $totalFirstHalf }}</td></tr>
            <tr><td colspan="4">Total second half of month</td><td><strong>{{ $totalSecondHalf }}</td></tr>
            @foreach ($statsPerCategory as $stats)
                <tr>
                    <td>Category: <strong>{{ $stats->category_name }}</strong></td>
                    <td>Number of products: <strong>{{ $stats->product_count }}</strong></td>
                    <td>Average price: <strong>{{ $stats->average_price }}</strong></td>
                </tr>
            @endforeach
        </tfoot>
    </table>
</div>
<div>API</div>
<button onclick="loadData()">Load data from API</button>
<div id="api-results">
    push the button...
</div>
<script>


    function loadData () {

        let div = document.getElementById('api-results')

        fetch('/api/products')
            .then(results => results.json())
            .then(data => {

                div.innerHTML = '<pre>' + JSON.stringify(data) + '</pre>'

            })
            .catch(e => {
                div.innerHTML = '<p>api error</p><pre>'+e.toString()+'</pre>'
            })

    }

</script>
</body>
</html>
