<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Product;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class OrderingFlowTest extends TestCase
{
    use RefreshDatabase;

    public function test_customer_can_add_a_product_and_checkout(): void
    {
        $user = User::factory()->create();
        $category = Category::create(['name' => 'Kopi', 'slug' => 'kopi']);
        $product = Product::create([
            'category_id' => $category->id,
            'name' => 'Iced Latte',
            'slug' => 'iced-latte',
            'description' => 'Creamy coffee',
            'price' => 28000,
            'image_url' => 'https://placehold.co/400x300',
            'is_available' => true,
        ]);

        $this->actingAs($user)
            ->post(route('cart.add', $product->id), ['quantity' => 2])
            ->assertRedirect();

        $this->assertEquals(2, session('cart.'.$product->id.'.quantity'));

        $this->post(route('checkout'), ['payment_method' => 'qris'])
            ->assertRedirect(route('customer.orders'));

        $this->assertDatabaseHas('orders', [
            'user_id' => $user->id,
            'total_price' => 56000,
            'payment_method' => 'qris',
            'status' => 'pending',
        ]);
    }

    public function test_admin_dashboard_cannot_be_accessed_by_customer(): void
    {
        $user = User::factory()->create(['role' => 'user']);

        $this->actingAs($user)
            ->get(route('admin.dashboard'))
            ->assertRedirect(route('home'));
    }
}
