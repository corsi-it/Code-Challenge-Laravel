@extends('app')

@section('content')
    <ul>
        <li>Total revenue of all products : <b>{{ $totalRevenue }}</b></li>
        <li>Total revenue in the first half of the month : <b>{{ $firstHalfRevenue }}</b></li>
        <li>Total revenue in the second half of the month : <b>{{ $secondHalfRevenue }}</b></li>
        <li>Total number of products in each category :
            <ul>
                @foreach($numberOfProductsInCategories as $key => $item)
                    <li>{{  $key . ' : '}} <b>{{ $item }}</b></li>
                @endforeach
            </ul>
        </li>
        <li>Average price of products in each category :
            <ul>
                @foreach($averagePriceByCategory as $key => $item)
                    <li>{{  $key . ' : '}} <b>{{ $item }}</b></li>
                @endforeach
            </ul>
        </li>
    </ul>
@endsection
