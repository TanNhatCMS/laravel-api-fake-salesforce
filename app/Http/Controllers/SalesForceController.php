<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Services\JWTService;
use Illuminate\Support\Facades\Validator;

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

    /**
     * Operation bookings
     *
     * Tạo đặt chỗ mới.
     *
     *
     * @return JsonResponse response
     */
    public function bookings(Request $request)
    {
        $data = $request->all();
        $validator = Validator::make($data, [
            'FacilityNumber' => 'required|string|max:80',
            'PersonLastName' => 'required|string|max:255',
            'PersonFirstName' => 'required|string|max:255',
            'ChildBirthday1' => 'required|date',
            'ChildBirthday2' => 'nullable|date',
            'PersonContactPhone' => 'required|string|max:15',
            'PersonContactMail' => 'nullable|email|max:255',
            'DesiredReservationDateTime' => 'required|date_format:Y-m-d\TH:i:s',
            'DesiredAdmissionDate' => 'required|date',
            'PersonAddress' => 'required|string|max:255',
            'PersonNumber' => 'required|integer|min:1',
            'ChildNumber' => 'required|integer|min:1',
            'MessageToChildcareFacility' => 'nullable|string|max:2000',
        ]);
        // If validation fails, return an error response
        if ($validator->fails()) {
            return response()->json([
                'error' => 'Invalid data',
                'messages' => $validator->errors()
            ], 400);
        }
        $randomNumber = 'BK-' . str_pad(rand(0, 99999999), 8, '0', STR_PAD_LEFT);
        return response()->json([
            'ReservationRequiryNumber' => $randomNumber,
            'ReservationRequiryStatus' => '仮予約',
            'payload' => $data
        ], 200);
    }
}
