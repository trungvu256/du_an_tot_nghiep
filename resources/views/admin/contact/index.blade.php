@extends('admin.layout.master')
@section('content')
    <table class="table">
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
                <th scope="col">Name</th>
                <th scope="col">Address</th>
                <th scope="col">Phone</th>
                <th scope="col">Subject</th>
                <th scope="col">Messages</th>
                <th scope="col">Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($contacts as $contact)
            <tr>
                <th scope="row">{{ $contact->id }}</th>
                <td>{{ $contact->name }}</td>
                <td>{{ $contact->address }}</td>
                <td>{{ $contact->phone }}</td>
                <td>{{ $contact->subject }}</td>
                <td>{{ $contact->messages }}</td>
                <td>           
                    <a href="{{ route('admin.delete.contact',$contact->id) }}" class="btn btn-danger">Delete</a>
                </td>
            </tr>
            @endforeach
           
        </tbody>
    </table>
@endsection

