<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Products</title>
</head>

<body>
    <h1>Products</h1>
    <div></div>
</body>

<script>
    fetch('/api/products')
        .then(response => response.json())
        .then(data => {
            document.querySelector('div').innerHTML += `
            Total revenue: ${data.total_revenue} <br>
            First half revenue: ${data.first_half_revenue} <br>
            Second half revenue: ${data.second_half_revenue} <br>
            Total count: ${data.total_products_count} <br>
            Categories: ${JSON.stringify(data.categories)}
            `;
        });
</script>

</html>
