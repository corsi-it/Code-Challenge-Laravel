<!DOCTYPE html>
<html>
<head>
    <style>
        #customers {
            font-family: Arial, Helvetica, sans-serif;
            border-collapse: collapse;
            width: 100%;
        }

        #customers td, #customers th {
            border: 1px solid #ddd;
            padding: 8px;
        }

        #customers tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        #customers tr:hover {
            background-color: #ddd;
        }

        #customers th {
            padding-top: 12px;
            padding-bottom: 12px;
            text-align: left;
            background-color: #04AA6D;
            color: white;
        }
    </style>
</head>
<body>

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

</body>
</html>


