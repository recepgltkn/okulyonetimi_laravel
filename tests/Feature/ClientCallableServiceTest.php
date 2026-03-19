<?php

namespace Tests\Feature;

use App\Services\Client\ClientAuthService;
use App\Services\Client\ClientCallableService;
use App\Services\Client\ClientStatsService;
use Illuminate\Http\Request;
use Mockery;
use Tests\TestCase;

class ClientCallableServiceTest extends TestCase
{
    protected function tearDown(): void
    {
        Mockery::close();
        parent::tearDown();
    }

    public function test_it_returns_unknown_for_unhandled_callable(): void
    {
        $service = new ClientCallableService(
            Mockery::mock(ClientAuthService::class),
            Mockery::mock(ClientStatsService::class),
        );

        $response = $service->handle(Request::create('/api/client/callable/unknown', 'POST', ['data' => []]), 'unknownAction');

        $this->assertSame(404, $response->getStatusCode());
        $this->assertSame('Unknown callable: unknownAction', $response->getData(true)['data']['message']);
    }

    public function test_it_returns_ai_placeholder_for_student_ai_assistant(): void
    {
        $service = new ClientCallableService(
            Mockery::mock(ClientAuthService::class),
            Mockery::mock(ClientStatsService::class),
        );

        $response = $service->handle(Request::create('/api/client/callable/studentAiAssistant', 'POST', ['data' => []]), 'studentAiAssistant');

        $this->assertSame(200, $response->getStatusCode());
        $this->assertSame('AI assistant is not configured on Laravel API yet.', $response->getData(true)['data']['reply']);
    }

    public function test_get_my_stats_requires_authentication(): void
    {
        $statsMock = Mockery::mock(ClientStatsService::class);
        $statsMock->shouldNotReceive('buildMyStatsSummary');

        $service = new ClientCallableService(
            Mockery::mock(ClientAuthService::class),
            $statsMock,
        );

        $request = Request::create('/api/client/callable/getMyStats', 'POST', ['data' => []]);

        $response = $service->handle($request, 'getMyStats');

        $this->assertSame(401, $response->getStatusCode());
        $this->assertSame('unauthenticated', $response->getData(true)['data']['message']);
    }

    public function test_get_my_stats_delegates_to_stats_service(): void
    {
        $summary = ['ok' => true, 'totalTasks' => 7];

        $statsMock = Mockery::mock(ClientStatsService::class);
        $statsMock->shouldReceive('buildMyStatsSummary')
            ->once()
            ->with('42')
            ->andReturn($summary);

        $service = new ClientCallableService(
            Mockery::mock(ClientAuthService::class),
            $statsMock,
        );

        $request = Request::create('/api/client/callable/getMyStats', 'POST', ['data' => []]);
        $request->attributes->set('client_uid', '42');

        $response = $service->handle($request, 'getMyStats');

        $this->assertSame(200, $response->getStatusCode());
        $this->assertSame($summary, $response->getData(true)['data']);
    }
}
