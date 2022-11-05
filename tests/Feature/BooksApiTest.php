<?php

namespace Tests\Feature;

use App\Models\Book;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class BooksApiTest extends TestCase
{

    use RefreshDatabase;
    /** @test */
    public function can_get_all_books()
    {
        $books = Book::factory(4)->create();

        $this->getJson(route('books.index'))
        ->assertJsonFragment([
            'title' => $books[0]->title
        ])->assertJsonFragment([
            'title' => $books[1]->title
        ]);


    }

     /** @test */
     public function can_get_one_book()
     {
        $book = Book::factory()->create();

        $this->getJson(route('books.show',$book))
        ->assertJsonFragment([
            'title' => $book->title
        ]);
     }

      /** @test */
      public function can_create_books()
      {
        // para generar el error por enviar titulo vacio

        $this->postJson(route('books.store'),[])
        ->assertJsonValidationErrorFor('title');


        $this->postJson(route('books.store'),[
            'title' => 'My New Book'
        ])->assertJsonFragment([
            'title' => 'My New Book'
        ]);

        $this->assertDatabaseHas('books',[
            'title' => 'My New Book'
        ]);

      }


       /** @test */
       public function can_update_books()
       {
        $book = Book::factory()->create();

         // para generar el error por enviar titulo vacio
         $this->patchJson(route('books.update', $book ), [])
         ->assertJsonValidationErrorFor('title');

        $this->patchJson(route('books.update', $book ), [
            'title' => 'Edited Book'
        ])->assertJsonFragment([
            'title' => 'Edited Book'
        ]);

        //verificando en la BD
        $this->assertDatabaseHas('books',[
            'title' => 'Edited Book'
        ]);

       }


        /** @test */
        public function can_delete_book()
        {
            $book = Book::factory()->create();

            $this->deleteJson(route('books.destroy', $book))
            ->assertNoContent();

            $this->assertDatabaseCount('books',0);
            // cada test comienza con una bd en blanco
        }







}
