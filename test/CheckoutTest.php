<?php
// TAMBAHKAN BARIS INI UNTUK MEMANGGIL FILE ASLINYA
require_once __DIR__ . '/../src/Checkout.php';

use PHPUnit\Framework\TestCase;
use App\Checkout;

class CheckoutTest extends TestCase{
    private $seedFile = __DIR__ . '/../data/products_seed.json';
    private $testFile = __DIR__ . '/../data/products_test.json';
    private $orderFile = __DIR__ . '/../data/orders_test.json';
    private $checkout;

    // CT Stage: Menyiapkan data segar SEBELUM tiap tes
    protected function setUp(): void{
        copy($this->seedFile, $this->testFile);
        file_put_contents($this->orderFile, json_encode([]));
        $this->checkout = new Checkout($this->testFile, $this->orderFile);
    }

    // CT Stage: Integration Test
    public function testCheckoutReducesStock(){
        // 1. Membeli PRD-005 (Celana Jeans) sebanyak 1 buah
        $keranjang = ['PRD-005' => 1];
        $this->checkout->prosesCheckout('test@mail.com', 'Jl. Sudirman', $keranjang);

        // 2. Mengambil data produk setelah checkout
        $products = json_decode(file_get_contents($this->testFile), true);
        
        // 3. Stok awal 12 dikurangi 1 harus sama dengan 11 (Ubah angka 4 menjadi 11, dan PRD-002 menjadi PRD-005)
        $this->assertEquals(11, $products['PRD-005']['stok']);
    }

    // CT Stage: Menghapus data sampah SETELAH tiap tes
    protected function tearDown(): void{
        if (file_exists($this->testFile)) unlink($this->testFile);
        if (file_exists($this->orderFile)) unlink($this->orderFile);
    }
}