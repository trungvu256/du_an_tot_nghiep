@extends('web.layouts.master')
@section('content')
<div class="breadcrumbs">
    <div class="container">
        <ol class="breadcrumb breadcrumb1 animated wow slideInLeft" data-wow-delay=".5s">
            <li><a href="/"><span class="glyphicon glyphicon-home" aria-hidden="true"></span>Home</a></li>
            <li class="active">Order Detail Page</li>
        </ol>
    </div>
</div>
<div class="container" >
    <div class="row">
        <div class="col-md-10">
            <table class="table" style="text-align: center">
                <thead class="thead-dark">
                  <tr>
                    <th scope="col">#</th>
                    <th scope="col">Name</th>
                    <th scope="col">image</th>
                    <th scope="col">Quantity</th>
                    <th scope="col">Price</th>
                    <th scope="col">Total</th>
                    
                  </tr>
                </thead>
                <tbody>
                    @php
                        $total = 0;
                        $stt = 0;
                    @endphp
                    @foreach ($products as $item)
                    @php
                    $total += $item->qty * $item->price;
                    $stt++;
                @endphp
                    <tr>
                        <th scope="row">{{ $stt }}</th>
                        <th scope="row">{{ $item->name }}</th>
                        <th scope="row"><img src="cover/{{ $item->img }}" width="60px" alt=""></th>
                        <th scope="row">{{ $item->qty }}</th>
                        <th scope="row">{{ $item->price }}</th>
                        <td scope="row">{{ number_format($item->qty * $item->price) }}</td>
                      </tr>
                    @endforeach
                  
                   <tr>
                       <td colspan="9">Total : {{ number_format($total) }}</td>
                   </tr>
                 
                </tbody>
              </table>
        </div>
    </div>
</div>
@endsection
