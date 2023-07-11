<html lang="en">
    <head>
        <title>Report</title>
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    </head>
    <body>
        <div class="container">
            <h1 class="my-5">Total Report</h1>
            <table class="table table-bordered">
                <thead>
                <tr>
                    <th>Total revenue of all products</th>
                    <th>Total revenue in the first half of the month</th>
                    <th>Total revenue in the second half of the month</th>
                    <th>Total number of products in each category</th>
                </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>{{ $reports->total_revenue }}</td>
                        <td>{{ $reports->first_half_revenue  }}</td>
                        <td>{{ $reports->second_half_revenue }}</td>
                        <td>{{ $reports->total_products_count }}</td>
                    </tr>
                </tbody>
            </table>

            <h1 class="my-5">Category Report</h1>
            <table class="table table-bordered">
                <thead>
                <tr>
                    <th>Category</th>
                    <th>Revenue</th>
                    <th>Products count</th>
                </tr>
                </thead>
                <tbody>
                    @foreach($reports->categories as $categoryName => $category)
                        <tr>
                            <td>{{ $categoryName }}</td>
                            <td>{{ $category['revenue']  }}</td>
                            <td>{{ $category['products_count'] }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>


            <h1 class="my-5">Products</h1>
            <table class="table table-bordered">
                <thead>
                <tr>
                    <th>Id</th>
                    <th>Name</th>
                    <th>Category</th>
                    <th>Price</th>
                    <th>Date added</th>
                </tr>
                </thead>
                <tbody>
                @foreach($products as $product)
                    <tr>
                        <td>{{ $product->product_id }}</td>
                        <td>{{ $product->product_name  }}</td>
                        <td>{{ $product->category }}</td>
                        <td>{{ $product->price }}</td>
                        <td>{{ $product->date_added }}</td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </body>
</html>
