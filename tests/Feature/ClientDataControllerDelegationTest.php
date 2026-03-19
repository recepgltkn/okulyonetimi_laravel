<?php

namespace Tests\Feature;

use App\Services\Client\ClientAuthService;
use App\Services\Client\ClientCallableService;
use App\Services\Client\ClientDocumentService;
use Illuminate\Http\JsonResponse;
use Mockery;
use Tests\TestCase;

class ClientDataControllerDelegationTest extends TestCase
{
    protected function tearDown(): void
    {
        Mockery::close();
        parent::tearDown();
    }

    public function test_login_endpoint_delegates_to_auth_service(): void
    {
        $this->withoutMiddleware();

        $expected = response()->json(['user' => ['uid' => '1']], 200);
        $mock = Mockery::mock(ClientAuthService::class);
        $mock->shouldReceive('login')
            ->once()
            ->andReturn($expected);
        $this->app->instance(ClientAuthService::class, $mock);

        $response = $this->postJson('/api/client/auth/login', [
            'identifier' => 'test@example.com',
            'password' => 'secret',
        ]);

        $response->assertStatus(200)
            ->assertJson(['user' => ['uid' => '1']]);
    }

    public function test_set_doc_endpoint_delegates_to_document_service(): void
    {
        $this->withoutMiddleware();

        $expected = response()->json(['doc' => ['id' => 'abc']], 200);
        $mock = Mockery::mock(ClientDocumentService::class);
        $mock->shouldReceive('setDoc')
            ->once()
            ->andReturn($expected);
        $this->app->instance(ClientDocumentService::class, $mock);

        $response = $this->postJson('/api/client/docs/set', [
            'path' => 'users/1',
            'data' => ['xp' => 10],
        ]);

        $response->assertStatus(200)
            ->assertJson(['doc' => ['id' => 'abc']]);
    }

    public function test_delete_doc_endpoint_passes_auth_service_to_document_service(): void
    {
        $this->withoutMiddleware();

        $authMock = Mockery::mock(ClientAuthService::class);
        $this->app->instance(ClientAuthService::class, $authMock);

        $expected = response()->json(['ok' => true], 200);
        $docMock = Mockery::mock(ClientDocumentService::class);
        $docMock->shouldReceive('deleteDoc')
            ->once()
            ->withArgs(function ($request, $authService) use ($authMock) {
                return $request->input('path') === 'users/2' && $authService === $authMock;
            })
            ->andReturn($expected);
        $this->app->instance(ClientDocumentService::class, $docMock);

        $response = $this->postJson('/api/client/docs/delete', [
            'path' => 'users/2',
        ]);

        $response->assertOk()
            ->assertJson(['ok' => true]);
    }

    public function test_callable_endpoint_delegates_to_callable_service(): void
    {
        $this->withoutMiddleware();

        $expected = response()->json(['data' => ['ok' => true]], 200);
        $mock = Mockery::mock(ClientCallableService::class);
        $mock->shouldReceive('handle')
            ->once()
            ->withArgs(function ($request, $name) {
                return $name === 'getMyStats' && is_array($request->input('data'));
            })
            ->andReturn($expected);
        $this->app->instance(ClientCallableService::class, $mock);

        $response = $this->postJson('/api/client/callable/getMyStats', [
            'data' => [],
        ]);

        $response->assertOk()
            ->assertJson(['data' => ['ok' => true]]);
    }
}
