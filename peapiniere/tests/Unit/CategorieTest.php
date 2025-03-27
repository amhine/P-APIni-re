<?php

namespace Tests\Unit;

use Mockery;
use Tests\TestCase;
use App\Http\Controllers\Api\CategorieController;
use App\Repository\Interface\CategorieInterface;
use Illuminate\Http\Request;
use App\Http\Requests\categoriestore;

class CategorieTest extends TestCase
{
    protected CategorieInterface $categorieRepository; 
    protected CategorieController $controller;

    protected function setUp(): void
    {
        parent::setUp();

        $this->categorieRepository = Mockery::mock(CategorieInterface::class);
        $this->controller = new CategorieController($this->categorieRepository);
    }

    /** @test */
    public function store_method_creates_a_category()
    {
        $request = Mockery::mock(categoriestore::class);
        $request->shouldReceive('validated')->andReturn(['name' => 'Nouvelle Catégorie']);
        $request->name = 'Nouvelle Catégorie';

        // Simuler la réponse du repository
        $createdCategory = ['id' => 1, 'name' => 'Nouvelle Catégorie'];

        $this->categorieRepository->shouldReceive('create')
            ->once()
            ->with(['name' => 'Nouvelle Catégorie'])
            ->andReturn($createdCategory);

        // Exécuter la méthode store
        $response = $this->controller->store($request);
        $responseData = $response->getData(true);

        // Vérifier les résultats
        $this->assertTrue($responseData['success']);
        $this->assertEquals($createdCategory, $responseData['data']);
    }

    /** @test */
    public function update_method_updates_a_category()
    {
        $categoryId = 1;
        $request = new Request(['name' => 'Catégorie Modifiée']);
        $existingCategory = ['id' => $categoryId, 'name' => 'Ancienne Catégorie'];
        $updatedCategory = ['id' => $categoryId, 'name' => 'Catégorie Modifiée'];

        $this->categorieRepository->shouldReceive('find')->once()->with($categoryId)->andReturn($existingCategory);
        $this->categorieRepository->shouldReceive('update')->once()->with($categoryId, ['name' => 'Catégorie Modifiée'])->andReturn($updatedCategory);

        $response = $this->controller->update($request, $categoryId);
        $responseData = $response->getData(true);

        $this->assertTrue($responseData['success']);
        $this->assertEquals($updatedCategory, $responseData['data']);
    }

    /** @test */
    public function destroy_method_deletes_a_category()
    {
        $categoryId = 1;
        $existingCategory = ['id' => $categoryId, 'name' => 'Catégorie à supprimer'];

        $this->categorieRepository->shouldReceive('find')->once()->with($categoryId)->andReturn($existingCategory);
        $this->categorieRepository->shouldReceive('delete')->once()->with($categoryId)->andReturn(true);

        $response = $this->controller->destroy($categoryId);
        $responseData = $response->getData(true);

        $this->assertTrue($responseData['success']);
        $this->assertEquals('Catégorie supprimée', $responseData['message']);
    }

    protected function tearDown(): void
    {
        Mockery::close();
        parent::tearDown();
    }
}
