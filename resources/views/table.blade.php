<html lang="">
<head>
    <title>Table</title>
    <style>
        table, td, th {
            border: 1px solid black;
            border-collapse: collapse;
        }
        td,th {
            padding: 12px 8px;
        }
    </style>
</head>
<body>

    <div class="container-fluid">
        <table>
            <tr>
                <th>total_revenue</th>
                <th>first half revenue</th>
                <th>second half revenue</th>
                <th>total products count</th>
            </tr>
            <tr>
                <td>{{$total_revenue}}</td>
                <td>{{$first_half_revenue}}</td>
                <td>{{$second_half_revenue}}</td>
                <td>{{$total_products_count}}</td>
            </tr>
        </table>
        <h1>Revenue by categories</h1>
        <table style="margin-top: 20px">
            <tr>
                <th>category</th>
                <th>revenue</th>
                <th>products count</th>

            </tr>
            @foreach($categories as $name => $category)
                <tr>
                    <td>
                        {{ $name }}
                    </td>
                    <td>
                        {{ $category['revenue'] }}
                    </td>
                    <td>
                        {{ $category['products_count'] }}
                    </td>
                </tr>
            @endforeach
        </table>
    </div>

</body>
</html>
