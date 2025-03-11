@extends('admin.layouts.main')

@section('content')
<div class="container mt-4">
    @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
        @if (session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif
    <div class="card shadow-lg p-4 rounded">
        <h2 class="text-center text-primary">Ví điện tử của bạn</h2>
        <p class="text-center mt-3">
            Số dư hiện tại: <strong class="text-success">{{ number_format($wallet->balance, 2) }} VND</strong>
        </p>
        <!-- Form nạp tiền -->
        <form action="{{ route('wallet.deposit') }}" method="POST" class="mt-3">
            @csrf
            <div class="mb-3">
                <label for="amount" class="form-label">Nhập số tiền cần nạp:</label>
                <input type="number" class="form-control" name="amount" id="amount" min="1000" required>
            </div>
            <button type="submit" class="btn btn-primary">Nạp tiền</button>
        </form>

        <!-- Lịch sử giao dịch -->
        <h4 class="mt-4">Lịch sử giao dịch</h4>
        <div class="table-responsive" style="max-height: 300px; overflow-y: auto;">
            <table class="table table-bordered mt-2">
                <thead>
                    <tr>
                        <th>Thời gian</th>
                        <th>Số tiền</th>
                        <th>Loại giao dịch</th>
                        <th>Mô tả</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($wallet->transactions->sortByDesc('created_at') as $transaction)
                        <tr>
                            <td>{{ $transaction->created_at->format('d/m/Y H:i') }}</td>
                            <td class="{{ $transaction->amount > 0 ? 'text-success' : 'text-danger' }}">
                                {{ number_format($transaction->amount, 2) }} VND
                            </td>
                            <td>
                                @if ($transaction->type == 'deposit')
                                    <span class="badge bg-success">Nạp tiền</span>
                                @elseif ($transaction->type == 'withdraw')
                                    <span class="badge bg-danger">Thanh toán</span>
                                @elseif ($transaction->type == 'refund')
                                    <span class="badge bg-warning">Hoàn tiền</span>
                                @else
                                    <span class="badge bg-secondary">Khác</span>
                                @endif
                            </td>
                            <td>{{ $transaction->description }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

{{-- CSS --}}
<style>
    .card {
        background: #ffffff;
        border-radius: 12px;
        box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);
        padding: 20px;
        max-width: 700px;
        margin: auto;
        text-align: center;
    }

    .text-primary {
        font-size: 24px;
        font-weight: bold;
    }

    .text-success {
        font-size: 20px;
        color: #28a745;
    }

    .text-danger {
        font-size: 20px;
        color: #dc3545;
    }

    .table th, .table td {
        vertical-align: middle;
    }

    .badge {
        font-size: 14px;
        padding: 5px 10px;
    }
</style>
@endsection
