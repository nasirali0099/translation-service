<?php

namespace App\Swagger;

/**
 * @OA\Info(
 *     title="Translation Service API",
 *     version="1.0.0",
 *     description="Complete API documentation for Translation Service"
 * )
 *
 * @OA\Server(
 *     url="http://127.0.0.1:8000",
 *     description="Local Server"
 * )
 *
 * @OA\SecurityScheme(
 *     securityScheme="bearerAuth",
 *     type="http",
 *     scheme="bearer",
 *     bearerFormat="JWT"
 * )
 */
class OpenApi {}