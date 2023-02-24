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
    <ul></ul>
</body>

<script>
    fetch('/api/products')
        .then(response => response.json())
        .then(data => {
            document.querySelector('ul').innerHTML += `
                <li>Total revenue: ${data.total_revenue}</li>
                <li>First half revenue: ${data.first_half_revenue} </li>
                <li>Second half revenue: ${data.second_half_revenue} </li>
                <li>Total count: ${data.total_products_count} </li>
                <li>
                    Categories:
                    <ul>
                        ${Object.keys(data.categories).map(categoryName => `<li>${categoryName} = Revenue: ${data.categories[categoryName].revenue} - Count: ${data.categories[categoryName].products_count}</li>`).join('')}
                    </ul>
                </li>
            `;
        });
</script>

</html>
