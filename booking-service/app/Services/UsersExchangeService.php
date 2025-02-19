<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Http\Client\RequestException;

class UsersExchangeService
{
    public function users(int $id, string $bearerToken)
    {
        $method = 'get';
        $endpoint = '/users/' . $id;
        $baseUrl = env('APP_USERS_SERVICE_URL');

        return $this->makeRequest(
            baseUrl: $baseUrl,
            endpoint: $endpoint,
            method: $method,
            bearerToken: $bearerToken
        );
    }

    /**
     * @param string $baseUrl
     * @param string $endpoint
     * @param string $method
     * @param mixed|null $params может быть array или string.
     * @param array|null $headers дополнительные заголовки к запросу.
     * @return mixed
     */
    public function makeRequest($baseUrl, $endpoint, $method, mixed $params = null, string $bearerToken = null, array $headers = null): mixed
    {
        $url = $baseUrl . $endpoint;
        try {
            $request = Http::withOptions(['verify' => config('app.http')]);

            if ($bearerToken) {
                $request = $request->withHeaders([
                    'Authorization' => 'Bearer ' . $bearerToken
                ]);
            }

            $response = $request->$method($url, $params);

            if ($response->successful()) {
                return $response->json();
            } else {
                return ['message' => __('messages.error') . ': ' . $response->status() . ' - ' . $response->body()];
            }
        } catch (RequestException $e) {
            return ['message' => __('messages.no_response_from_service') . ': ' . $e->getMessage()];
        } catch (\Exception $e) {
            return ['message' => __('messages.there_was_an_unforeseen_error') . ': ' . $e->getMessage()];
        }
    }
}
