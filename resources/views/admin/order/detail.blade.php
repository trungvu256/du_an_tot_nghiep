@extends('admin.layout.master')
@section('content')
    <table class="table" id="show">
        @if (session('success'))
            <div class="alert alert-success">
                <ul>
                    <li>{{ session('success') }}</li>
                </ul>
            </div>
        @endif
        <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">Nam Product</th>
                <th scope="col">Image</th>
                <th scope="col">Price</th>
                <th scope="col">Quantity</th>
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
                    <td>{{ $stt }}</td>
                    <td>{{ $item->name }}</td>                
                    <td><img src="cover/{{ $item->img }}" width="50px" alt=""></td>
                    <td>{{ $item->price }}</td>
                    <td>{{ $item->qty }}</td>
                    <td>{{ number_format($item->qty * $item->price) }} VND</td>
                </tr>
          
            @endforeach
               <tr>
                   <td colspan="7">Total Sum: <h4>{{ number_format($total) }}</h4></td>
               </tr>                     
        </tbody>
    </table>
    <div class="container">
        <div class="row">
            <div class="col-md-4">
               <form action="{{ route('admin.update.order',$item->id) }}" method="POST">
                   @csrf
                   <select name="status"  class="form-control">                      
                       <option {{ $item->status == 0 ? "selected" : "" }} value="0">On Proceess</option>
                       <option {{ $item->status == 1 ? "selected" : "" }} value="1">Done</option>              
                   </select>
                   <button type="submit" class="btn btn-success mt-2">Update</button>
               </form>
            </div>
        </div>
    </div>
    

@endsection
