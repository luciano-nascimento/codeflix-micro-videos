<?php

namespace Tests\Feature\Models;

use App\Models\Genre;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use \Ramsey\Uuid\Uuid as RamseyUuid;

class GenreTest extends TestCase
{

    use DatabaseMigrations;
    
    public function testList()
    {
        factory(Genre::class, 1)->create();
        $genre = Genre::all();    
        $this->assertCount(1, $genre);
        $genreKey = array_keys($genre->first()->getAttributes());
        $this->assertEqualsCanonicalizing(
            [
                'id', 
                'name', 
                'is_active',
                'deleted_at', 
                'created_at', 
                'updated_at',   
            ],
            $genreKey
        );
    }

    public function testCreate()
    {
        $genre = Genre::create([
            'name' => 'test1'
        ]);
        //to get is_active status created by db
        $genre->refresh();
        $this->assertEquals('test1', $genre->name);
        $this->assertNull($genre->description);
        $this->assertTrue((bool)$genre->is_active);
        $this->assertTrue(RamseyUuid::isValid($genre->id));
        
        $genre = Genre::create([
            'name' => 'test1',
            'is_active' => false
        ]);
        $this->assertFalse($genre->is_active);

        $genre = Genre::create([
            'name' => 'test1',
            'is_active' => true
        ]);
        $this->assertTrue($genre->is_active);
    }

    public function testUpdate()
    {
        $genre = factory(Genre::class)->create([
            'name' => 'terror'
        ])->first();

        $data = [
            'name' => 'comedy',
            'is_active' => true
        ];

        $genre->update($data);
        foreach($data as $key => $value){
            $this->assertEquals($value, $genre->{$key});
        }
    }

    public function testDelete() 
    {
        $genre = factory(Genre::class)->create([
            'name' => 'terror'
        ])->first();
        Genre::destroy($genre->id);
        $this->assertEquals(count(Genre::all()), 0);
    }
}
