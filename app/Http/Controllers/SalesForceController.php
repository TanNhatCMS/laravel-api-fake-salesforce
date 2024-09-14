<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Services\JWTService;

class SalesForceController extends Controller
{
    protected JWTService $jwtService;
    public function __construct(JWTService $jwtService)
    {
        $this->jwtService = $jwtService;
    }
    /**
     * Operation getToken
     *
     * Lấy JWT access_token và instance_url test.salesforce.com.
     *
     *
     * @return JsonResponse response
     */
    public function getToken(Request $request)
    {
        $grant_type = $request->input('grant_type');
        $assertion = $request->input('assertion');
        if (!$grant_type || !$assertion) {
            return response()->json(['error' => 'Thiếu tham số hoặc tham số không hợp lệ'], 400);
        }
        $payload = [
            'assertion' => $assertion,
            'grant_type' => $grant_type,
            'iss' => "your-domain.com",
            'sub' => "user-id",
            'aud' => "https://test.salesforce.com",
            'exp' => time() + 3600
        ];
        $jwt = $this->jwtService->createToken($payload);
        $response = [
            'access_token' => $jwt,
            'instance_url' => 'https://test.salesforce.com',
            'payload' => $payload
        ];
        return response()->json($response, 200);
    }
}
