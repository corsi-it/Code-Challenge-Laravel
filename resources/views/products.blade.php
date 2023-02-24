<table>
    <thead>
    <tr>
        @foreach($header as $item)
            <th>{{$item}}</th>
        @endforeach
    </tr>
    </thead>
    <tbody>
    @foreach ($products as $product)
        <tr>
            @foreach($header as $item)
                <td>{{$product[$item]}}</td>
            @endforeach
        </tr>
    @endforeach
    </tbody>
</table>
