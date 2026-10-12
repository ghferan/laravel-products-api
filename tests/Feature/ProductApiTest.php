<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

use App\Models\User;
use Laravel\Sanctum\Sanctum;
use App\Models\Category;
use App\Models\Prodect;

class ProductApiTest extends TestCase
{
   
    use RefreshDatabase;

    public function test_example(): void
    {
         $response = $this->getJson('/api/products');

        $response->assertStatus(200);
    }

    public function test_guest_cannot_create_product(): void
    {
        $response = $this->postJson('/api/products', [
            'name' => 'Test Laptop',
            'price' => 1000,
            'description' => 'Test product',
            'category_id' => 1,
        ]);

        $response->assertStatus(401);
    }

   public function test_normal_user_cannot_create_product(): void
    {
        $user = User::factory()->create([
            'role' => 'user',
        ]);

        $category = Category::create([
        'name' => 'Test Category',
          ]);

        Sanctum::actingAs($user);

        $response = $this->postJson('/api/products', [
            'name' => 'Test product',
            'price' => 100,
            'description' => 'Test product',
            'category_id' => $category->id,
        ]);

        $response->assertStatus(403);
    }

    public function test_admin_can_create_product(): void
    {
        $user = User::factory()->create([
            'role' => 'admin',
        ]);

        Sanctum::actingAs($user);
        $category = Category::create([
        'name' => 'Test Category',
          ]);
        $response = $this->postJson('/api/products', [
            'name' => 'Test Laptop',
            'price' => 1000,
            'description' => 'Test product',
             'category_id' => $category->id,
        ]);

        $response->assertStatus(201);
        $this->assertDatabaseHas('prodects', [
    'name' => 'Test Laptop',
    'price' => 1000,
    ]);
    }

    public function test_normal_user_cannot_update_product(): void
    {
        $user = User::factory()->create([
            'role' => 'user',
        ]);

        Sanctum::actingAs($user);

        $category = Category::create([
        'name' => 'Test Category',
          ]);

          $product = Prodect::create([
            'name' => 'Test Laptop',
            'price' => 1000,
            'description' => 'Test product',
             'category_id' => $category->id,
          ]);
        // $product = \App\Models\Prodect::factory()->create();

        $response = $this->putJson('/api/products/' . $product->id, [
            'name' => 'Updated Laptop',
            'price' => 1500,
            'description' => 'Updated description',
        ]);

        $response->assertStatus(403);
    }

    public function test_admin_can_update_product(): void
    {
        $user = User::factory()->create([
            'role' => 'admin',
        ]);

        Sanctum::actingAs($user);
    
        $category = Category::create([
        'name' => 'Test Category',
          ]);

          $product = Prodect::create([
            'name' => 'Test Laptop',
            'price' => 1000,
            'description' => 'Test product',
             'category_id' => $category->id,
          ]);

        $response = $this->putJson('/api/products/' . $product->id, [
            'name' => 'Updated Laptop',
            'price' => 1500,
            'description' => 'Updated description',
        ]);

        $response->assertStatus(200);

        $this->assertDatabaseHas('prodects', [
            'id' => $product->id,
            'name' => 'Updated Laptop',
            'price' => 1500,
        ]);
    }

    public function test_normal_user_cannot_delete_product(): void
    {
        $user = User::factory()->create([
            'role' => 'user',
        ]);

        Sanctum::actingAs($user);

          $category = Category::create([
        'name' => 'Test Category',
          ]);

          $product = Prodect::create([
            'name' => 'Test Laptop',
            'price' => 1000,
            'description' => 'Test product',
             'category_id' => $category->id,
          ]);

        $response = $this->deleteJson('/api/products/' . $product->id);

        $response->assertStatus(403);
    }


    public function test_admin_can_delete_product(): void
    {
        $user = User::factory()->create([
            'role' => 'admin',
        ]);

        Sanctum::actingAs($user);

          $category = Category::create([
        'name' => 'Test Category',
          ]);

          $product = Prodect::create([
            'name' => 'Test Laptop',
            'price' => 1000,
            'description' => 'Test product',
             'category_id' => $category->id,
          ]);

        $response = $this->deleteJson('/api/products/' . $product->id);

        $response->assertStatus(200);

        $this->assertDatabaseMissing('prodects', [
            'id' => $product->id,
        ]);
    }

    
    public function test_product_cannot_be_created_without_required_fields(): void
    {
        $admin = \App\Models\User::factory()->create([
            'role' => 'admin',
        ]);

        $token = $admin->createToken('test-token')->plainTextToken;

        $response = $this->withHeader(
            'Authorization',
            'Bearer ' . $token
        )->postJson('/api/products', [
            'description' => 'Product without name and price',
        ]);

        $response->assertUnprocessable()
            ->assertJsonValidationErrors(['name', 'price']);
    }

}
