@extends('layout.app')
@section('content')
    <div class="products_lists" style="margin:0px auto; max-width: 80vw; margin: 3em;">
        <h3>Products</h3>
        <table class="table">
            <thead>
            <tr>
                @foreach($headers as $header=>$field)
                    <th>{{__($header)}}</th>
                @endforeach
            </tr>

            </thead>
            <tbody>
            @foreach($products as $product)
                <tr>
                    @foreach($headers as $header=>$field)
                        <td class="data data-{{$header}}">{{ $product->getData($field) }}</td>
                    @endforeach
                </tr>
            @endforeach
            </tbody>
        </table>
        <hr>
        <h3>Total revenues</h3>
        {{\App\Models\Product::query()->sum("price")}}
        <hr/>
        <h3>Total revenues (time based)</h3>
        @php
            $dateS = \App\Models\Product::query()->min("date_added");
            $dateE = \App\Models\Product::query()->max("date_added");
            $startOfMonth = \Carbon\Carbon::createFromFormat("Y-m-d",$dateS)->startOfMonth();
            $endOfMonth = \Carbon\Carbon::createFromFormat("Y-m-d",$dateE)->endOfMonth();
            $midMonth = floor($endOfMonth->diffInDays($startOfMonth)/2);
        @endphp
        First half of the month {{\App\Models\Product::query()
            ->whereBetween("date_added",[$startOfMonth, $startOfMonth->clone()->addDays($midMonth)])->sum('price')
        }}
        <br/>
        Second half of the month {{\App\Models\Product::query()
            ->whereBetween("date_added",[$endOfMonth->clone()->addDays(-1*$midMonth),$endOfMonth])->sum('price')
        }}
        <hr/>
        <h3>Summary</h3>
        @foreach($categories as $category)
            <div>
                <h4>{{$category->category}}</h4>
                <br/>
                Number of Products: {{$category->products()->count()}}<br/>
                Avg Price: {{number_format($category->products()->avg('price'),2)}}<br/>
                Revenue Price: {{number_format($category->products()->sum('price'),2)}}<br/>
            </div>

        @endforeach


    </div>
@stop

