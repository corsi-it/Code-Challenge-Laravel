@extends('app')
@section('content')
    <table class="table">
        <thead>
        <tr>
            <th scope="col">Id</th>
            <th scope="col">name</th>
            <th scope="col">category</th>
            <th scope="col">price</th>
            <th scope="col">created at</th>
        </tr>
        </thead>
        <tbody>
        @foreach($rows as $key =>$row)
            @if(!$key)
                @continue
            @endif
            <tr>
                <th scope="row">{{$row[0]}}</th>
                <th scope="row">{{$row[1]}}</th>
                <th scope="row">{{$row[2]}}</th>
                <th scope="row">{{$row[3]}}</th>
                <th scope="row">{{$row[4]}}</th>
            </tr>
        @endforeach


        </tbody>
    </table>
@endsection
