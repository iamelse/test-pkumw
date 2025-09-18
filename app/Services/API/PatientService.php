<?php

namespace App\Services\API;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Exception;

class PatientService
{
    private string $baseUrl;
    private array $headers;

    public function __construct()
    {
        $this->baseUrl = rtrim(env('API_BASE_URL', ''), '/');
        $this->headers = [
            'X-username' => env('API_USERNAME'),
            'X-password' => env('API_PASSWORD'),
        ];
    }

    public function getAll(array $filters = [])
    {
        try {
            $response = Http::withHeaders($this->headers)
                ->get("{$this->baseUrl}/patient", $filters);

            if ($response->successful()) {
                return $response->json();
            }

            Log::error('Failed to fetch patients', ['status' => $response->status(), 'body' => $response->body()]);
            return [];
        } catch (Exception $e) {
            Log::error('Error fetching patients: ' . $e->getMessage());
            return [];
        }
    }

    public function getById(string $id)
    {
        try {
            $response = Http::withHeaders($this->headers)
                ->get("{$this->baseUrl}/patient/{$id}");

            return $response->successful() ? $response->json() : null;
        } catch (Exception $e) {
            Log::error('Error fetching patient by ID: ' . $e->getMessage());
            return null;
        }
    }

    public function create(array $data)
    {
        try {
            $response = Http::withHeaders($this->headers)
                ->post("{$this->baseUrl}/patient", $data);

            return $response->successful() ? $response->json() : null;
        } catch (Exception $e) {
            Log::error('Error creating patient: ' . $e->getMessage());
            return null;
        }
    }

    public function update(string $id, array $data)
    {
        try {
            $response = Http::withHeaders($this->headers)
                ->put("{$this->baseUrl}/patient/{$id}", $data);

            return $response->successful() ? $response->json() : null;
        } catch (Exception $e) {
            Log::error('Error updating patient: ' . $e->getMessage());
            return null;
        }
    }

    public function delete(string $id)
    {
        try {
            $response = Http::withHeaders($this->headers)
                ->delete("{$this->baseUrl}/patient/{$id}");

            return $response->successful();
        } catch (Exception $e) {
            Log::error('Error deleting patient: ' . $e->getMessage());
            return false;
        }
    }
}