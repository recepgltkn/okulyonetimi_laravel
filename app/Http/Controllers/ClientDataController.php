<?php

namespace App\Http\Controllers;

use App\Services\Client\ClientAuthService;
use App\Services\Client\ClientCallableService;
use App\Services\Client\ClientDocumentService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ClientDataController extends Controller
{
    public function __construct(
        private readonly ClientAuthService $authService,
        private readonly ClientDocumentService $documentService,
        private readonly ClientCallableService $callableService,
    ) {
    }

    public function login(Request $request): JsonResponse
    {
        return $this->authService->login($request);
    }

    public function register(Request $request): JsonResponse
    {
        return $this->authService->register($request);
    }

    public function updatePassword(Request $request): JsonResponse
    {
        return $this->authService->updatePassword($request);
    }

    public function deleteUser(Request $request): JsonResponse
    {
        return $this->authService->deleteUser($request);
    }

    public function logout(Request $request): JsonResponse
    {
        return $this->authService->logout($request);
    }

    public function setDoc(Request $request): JsonResponse
    {
        return $this->documentService->setDoc($request);
    }

    public function updateDoc(Request $request): JsonResponse
    {
        return $this->documentService->updateDoc($request);
    }

    public function getDoc(Request $request): JsonResponse
    {
        return $this->documentService->getDoc($request);
    }

    public function deleteDoc(Request $request): JsonResponse
    {
        return $this->documentService->deleteDoc($request, $this->authService);
    }

    public function addDoc(Request $request): JsonResponse
    {
        return $this->documentService->addDoc($request);
    }

    public function queryDocs(Request $request): JsonResponse
    {
        return $this->documentService->queryDocs($request);
    }

    public function batch(Request $request): JsonResponse
    {
        return $this->documentService->batch($request);
    }

    public function callable(Request $request, string $name): JsonResponse
    {
        return $this->callableService->handle($request, $name);
    }
}
