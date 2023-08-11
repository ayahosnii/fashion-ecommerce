<?php

namespace Tests\Unit;

use App\Cart\Cart;
use App\Exceptions\QuantityExceededException;
use App\Models\Admin\Product;
use App\Support\Storage\Contracts\StorageInterface;
use PHPUnit\Framework\TestCase;

class CartTest extends TestCase
{
    /**
     * Instance of Cart.
     *
     * @var Cart
     */
    protected $cart;

    /**
     * Set up the test environment.
     */
    protected function setUp(): void
    {
        parent::setUp();

        // Create a mock implementation of the StorageInterface for the Cart
        $storageMock = $this->createMock(StorageInterface::class);
        // Create a mock instance of Product (if needed) or use real instances
        $productMock = $this->createMock(Product::class);

        $this->cart = new Cart($storageMock, $productMock);
    }

    /**
     * A basic unit test example.
     */
    public function testUpdateWithValidQuantity()
    {
        $product = new Product([
            'id' => 1,
            'name' => 'Sample Product',
            'price' => 100,
            'stock' => 10,
        ]);

        // Set the initial quantity for the product in the cart
        $initialQuantity = 2;
        $this->cart->update($product, $initialQuantity);

        // Assert that the cart has the correct initial quantity for the product
        $this->assertEquals($initialQuantity, $this->cart->getQuantity($product));

        // Update the cart with a new quantity
        $newQuantity = 5;
        $this->cart->update($product, $newQuantity);

        // Assert that the cart now has the updated quantity for the product
        $this->assertEquals($newQuantity, $this->cart->getQuantity($product));
    }

    /**
     * Test updating the cart with a quantity that exceeds the available stock.
     */
    public function testUpdateWithExceededStock()
    {
        $product = new Product([
            'id' => 2,
            'name' => 'Limited Stock Product',
            'price' => 50,
            'stock' => 3,
        ]);

        // Set the initial quantity for the product in the cart
        $initialQuantity = 2;
        $this->cart->update($product, $initialQuantity);

        // Attempt to update the cart with a quantity that exceeds the available stock
        $exceededQuantity = 5;

        // Expect an exception of type QuantityExceededException
        $this->expectException(QuantityExceededException::class);

        // Perform the update that should throw an exception
        $this->cart->update($product, $exceededQuantity);
    }

    /**
     * Test removing a product from the cart.
     */
    public function testRemoveProductFromCart()
    {
        $product = new Product([
            'id' => 3,
            'name' => 'Product to be removed',
            'price' => 75,
            'stock' => 20,
        ]);

        // Add the product to the cart
        $quantity = 3;
        $this->cart->update($product, $quantity);

        // Remove the product from the cart
        $this->cart->remove($product);

        // Assert that the product is no longer in the cart
        $this->assertFalse($this->cart->has($product));
    }

    // Add more test methods for other scenarios...
}
