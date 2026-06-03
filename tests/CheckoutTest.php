<?php

require_once __DIR__ . '/../vendor/autoload.php';

use PHPUnit\Framework\TestCase;
use App\Checkout;

class CheckoutTest extends TestCase
{
    private Checkout $checkout;

    protected function setUp(): void
    {
        $this->checkout = new Checkout(
            'data/products.json',
            'data/orders.json'
        );
    }

    // TC-WHT-01
    public function testCheckoutNormal()
    {
        $keranjang = [
            'PRD-001' => 3
        ];

        $result = $this->checkout->prosesCheckout(
            'user@test.com',
            'Madiun',
            $keranjang
        );

        $this->assertArrayHasKey('total_bayar', $result);
    }

    // TC-WHT-02
    public function testCheckoutGratisOngkir()
    {
        $keranjang = [
            'PRD-003' => 4
        ];

        $result = $this->checkout->prosesCheckout(
            'user@test.com',
            'Madiun',
            $keranjang
        );

        $this->assertArrayHasKey('total_bayar', $result);
    }

    // TC-WHT-03
    public function testCheckoutDiskon()
    {
        $keranjang = [
            'PRD-005' => 5
        ];

        $result = $this->checkout->prosesCheckout(
            'user@test.com',
            'Madiun',
            $keranjang
        );

        $this->assertArrayHasKey('total_bayar', $result);
    }
}