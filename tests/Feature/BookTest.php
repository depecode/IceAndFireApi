<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class BookTest extends TestCase
{
    public function testsArticlesAreCreatedCorrectly()
    {
        $payload = [
            'title' => 'Lorem',
            'body' => 'Ipsum',
        ];

        $this->json('POST', '/api/articles', $payload)
            ->assertStatus(200)
            ->assertJson(['id' => 1, 'title' => 'Lorem', 'body' => 'Ipsum']);
    }

    public function testsArticlesAreUpdatedCorrectly()
    {
        $book = factory(Book::class)->create([
            'title' => 'First Book',
            'body' => 'First Body',
        ]);

        $payload = [
            'title' => 'Lorem',
            'body' => 'Ipsum',
        ];

        $response = $this->json('PUT', '/api/articles/' . $book->id, $payload)
            ->assertStatus(200)
            ->assertJson([ 
                'id' => 1, 
                'title' => 'Lorem', 
                'body' => 'Ipsum' 
            ]);
    }

    public function testsArtilcesAreDeletedCorrectly()
    {
        $book = factory(Book::class)->create([
            'title' => 'First Book',
            'body' => 'First Body',
        ]);

        $this->json('DELETE', '/api/articles/' . $book->id, [])
            ->assertStatus(204);
    }

    public function testArticlesAreListedCorrectly()
    {
        factory(Book::class)->create([
            'title' => 'First Book',
            'body' => 'First Body'
        ]);

        factory(Book::class)->create([
            'title' => 'Second Book',
            'body' => 'Second Body'
        ]);

        $user = factory(User::class)->create();
      
        $response = $this->json('GET', '/api/articles', [])
            ->assertStatus(200)
            ->assertJson([
                [ 'title' => 'First Book', 'body' => 'First Body' ],
                [ 'title' => 'Second Book', 'body' => 'Second Body' ]
            ])
            ->assertJsonStructure([
                '*' => ['id', 'body', 'title', 'created_at', 'updated_at'],
            ]);
    }
}
