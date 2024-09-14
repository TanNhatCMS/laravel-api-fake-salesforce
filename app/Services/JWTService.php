<?php

namespace App\Services;

use Firebase\JWT\JWT;
use Firebase\JWT\Key;

class JWTService
{
    protected mixed $secretKey;

    public function __construct()
    {
        // Lấy secret key từ file .env
        $this->secretKey = config('jwt.secret');
    }

    /**
     * Tạo JWT từ payload
     *
     * @param array $payload
     * @return string
     */
    public function createToken(array $payload): string
    {
        // Thêm thời gian phát hành và hết hạn vào payload
        $payload['iat'] = time();
        $payload['exp'] = time() + 3600; // Token có thời hạn 1 giờ

        // Tạo JWT từ payload
        return JWT::encode($payload, $this->secretKey, 'HS256');
    }

    /**
     * Giải mã JWT
     *
     * @param string $token
     * @return object|null
     */
    public function decodeToken(string $token): ?object
    {
        try {
            return JWT::decode($token, new Key($this->secretKey, 'HS256'));
        } catch (\Exception $e) {
            return null;
        }
    }
}
