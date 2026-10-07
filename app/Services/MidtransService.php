<?php

namespace App\Services;

use Illuminate\Http\Client\ConnectionException;
use Illuminate\Support\Facades\Http;
use RuntimeException;

class MidtransService
{
    public function createSnapTransaction(string $orderId, int $amount, array $items, array $customer): array
    {
        $serverKey = config('services.midtrans.server_key');
        if (! $serverKey) {
            throw new RuntimeException('Konfigurasi pembayaran Midtrans belum lengkap.');
        }

        $baseUrl = config('services.midtrans.is_production')
            ? 'https://app.midtrans.com'
            : 'https://app.sandbox.midtrans.com';

        try {
            $response = Http::withBasicAuth($serverKey, '')
                ->acceptJson()
                ->connectTimeout(5)
                ->timeout(15)
                ->post($baseUrl . '/snap/v1/transactions', [
                    'transaction_details' => [
                        'order_id' => $orderId,
                        'gross_amount' => $amount,
                    ],
                    'item_details' => $items,
                    'customer_details' => [
                        'first_name' => $customer['name'],
                        'email' => $customer['email'],
                    ],
                ]);
        } catch (ConnectionException $exception) {
            report($exception);

            throw new RuntimeException('Koneksi ke Midtrans gagal. Periksa koneksi internet lalu coba lagi.', 0, $exception);
        }

        if (! $response->successful() || ! $response->json('token') || ! $response->json('redirect_url')) {
            throw new RuntimeException('Midtrans tidak dapat membuat sesi pembayaran. Silakan coba lagi.');
        }

        return $response->json();
    }

    public function hasValidSignature(array $notification): bool
    {
        $serverKey = config('services.midtrans.server_key');
        $signature = $notification['signature_key'] ?? '';

        if (! $serverKey || ! is_string($signature)) {
            return false;
        }

        $expected = hash('sha512', implode('', [
            $notification['order_id'] ?? '',
            $notification['status_code'] ?? '',
            $notification['gross_amount'] ?? '',
            $serverKey,
        ]));

        return hash_equals($expected, $signature);
    }
}