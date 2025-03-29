@extends('web2.layout.master')

@section('content')
<div class="container mt-4">
    <h2 class="mb-3">Lịch sử giao dịch</h2>
    <p><strong>Số dư ví:</strong> {{ number_format($wallet->balance, 2) }} VND</p>

    @if ($transactions->isNotEmpty())
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Số tiền</th>
                    <th>Ngân hàng</th>
                    <th>Trạng thái</th>
                    <th>Thời gian</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($transactions as $transaction)
                    <tr>
                        <td>{{ number_format($transaction->amount, 2) }} VND</td>
                        <td>{{ $transaction->bank_code ?? 'Không rõ' }}</td>
                        <td>
                            @if ($transaction->status == 'success')
                                <span class="badge bg-success">Thành công</span>
                            @else
                                <span class="badge bg-danger">Thất bại</span>
                            @endif
                        </td>
                        <td>{{ $transaction->created_at->format('d/m/Y H:i:s') }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <p>Chưa có giao dịch nào.</p>
    @endif

    <a href="{{ route('wallet.index') }}" class="btn btn-secondary">Quay lại Ví</a>
</div>
@endsection
