<?php

namespace App\Http\Controllers;

/**
 * @OA\Info(
 *     version="1.0.0",
 *     title="Soccer RESTful API Documentation",
 *     description="Dokumentasi API untuk Soccer RESTful API (Laravel) menggunakan L5 Swagger.",
 * )
 *
 * @OA\Server(
 *     url=L5_SWAGGER_CONST_HOST,
 *     description="API Server"
 * )
 *
 * @OA\SecurityScheme(
 *     securityScheme="sanctum",
 *     type="http",
 *     scheme="bearer",
 *     bearerFormat="JWT",
 *     in="header",
 *     name="Authorization",
 *     description="Masukkan token dengan format: Bearer {token}"
 * )
 *
 * @OA\Consumes("application/json")
 * @OA\Produces("application/json")
 */
class SwaggerController extends Controller
{
    // File ini hanya untuk anotasi dokumentasi, tidak perlu method apapun.
}
