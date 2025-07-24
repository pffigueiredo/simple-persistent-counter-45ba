<?php

namespace Tests\Feature;

use App\Models\Counter;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Inertia\Testing\AssertableInertia as Assert;
use Tests\TestCase;

class CounterTest extends TestCase
{
    use RefreshDatabase;

    public function test_counter_page_displays_initial_count(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
        $response->assertInertia(fn (Assert $page) => 
            $page->component('Counter')
                ->has('count')
                ->where('count', 0)
        );
    }

    public function test_counter_increments_correctly(): void
    {
        $response = $this->post('/counter', ['action' => 'increment']);

        $response->assertStatus(200);
        $response->assertInertia(fn (Assert $page) => 
            $page->component('Counter')
                ->where('count', 1)
        );

        $this->assertDatabaseHas('counters', [
            'count' => 1
        ]);
    }

    public function test_counter_decrements_correctly(): void
    {
        // Create a counter with initial value
        Counter::create(['count' => 5]);

        $response = $this->post('/counter', ['action' => 'decrement']);

        $response->assertStatus(200);
        $response->assertInertia(fn (Assert $page) => 
            $page->component('Counter')
                ->where('count', 4)
        );

        $this->assertDatabaseHas('counters', [
            'count' => 4
        ]);
    }

    public function test_counter_persists_across_requests(): void
    {
        // Increment counter
        $this->post('/counter', ['action' => 'increment']);
        $this->post('/counter', ['action' => 'increment']);
        $this->post('/counter', ['action' => 'increment']);

        // Check that value persists when accessing home page
        $response = $this->get('/');

        $response->assertStatus(200);
        $response->assertInertia(fn (Assert $page) => 
            $page->component('Counter')
                ->where('count', 3)
        );
    }

    public function test_multiple_increments_and_decrements(): void
    {
        // Start with some increments
        $this->post('/counter', ['action' => 'increment']);
        $this->post('/counter', ['action' => 'increment']);
        $this->post('/counter', ['action' => 'increment']);

        // Then some decrements
        $this->post('/counter', ['action' => 'decrement']);

        $response = $this->get('/');

        $response->assertStatus(200);
        $response->assertInertia(fn (Assert $page) => 
            $page->component('Counter')
                ->where('count', 2)
        );
    }
}