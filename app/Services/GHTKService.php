<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class GHTKService
{
    protected $baseUrl;
    protected $token;


    public function __construct()
    {
        $this->baseUrl = env('GHTK_BASE_URL');
        $this->token = env('GHTK_TOKEN');
    }

    public function calculateShippingFee($order)
    {
        if (config('app.env') === 'local') {
            $mockData = json_decode(file_get_contents(storage_path('app/mock/ghtk_mock.json')), true);
            return $mockData;
        }

        $response = Http::withHeaders([
            'Token' => $this->token
        ])->get("{$this->baseUrl}/services/shipment/fee", [
            'pick_province' => 'Hà Nội',
            'pick_district' => 'Cầu Giấy',
            'province' => $order['province'],
            'district' => $order['district'],
            'address' => $order['address'],
            'weight' => $order['weight'],
            'value' => $order['value'],
            'transport' => 'road'
        ]);

        return $response->json();
    }
}
