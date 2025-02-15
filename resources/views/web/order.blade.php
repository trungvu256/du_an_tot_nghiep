@extends('web.layouts.master')
@section('content')
<div class="breadcrumbs">
    <div class="container">
        <ol class="breadcrumb breadcrumb1 animated wow slideInLeft" data-wow-delay=".5s">
            <li><a href="/"><span class="glyphicon glyphicon-home" aria-hidden="true"></span>Home</a></li>
            <li class="active">Order Page</li>
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
                    <th scope="col">Address</th>
                    <th scope="col">Phone</th>
                    <th scope="col">Status</th>
                    <th scope="col">Date order</th>
                    <th scope="col">View</th>
                  </tr>
                </thead>
                <tbody>
                    @foreach ($orders as $item)
                    <tr>
                        <th scope="row">{{ $item->id }}</th>
                        <td>{{ $item->name }}</td>
                        <td>{{ $item->address }}</td>
                        <td>{{ $item->phone }}</td>
                        <td>{{ $item->status == 0  ? "Pending" : "Done" }}</td>
                        <td>{{ $item->created_at }}</td>
                        <td>
                            <a href="{{ route('web.order.detail',$item->id) }}" class="btn btn-primary">View</a>
                        </td>
                      </tr>
                    @endforeach
                  
                  
                 
                </tbody>
              </table>
        </div>
    </div>
</div>
@endsection
