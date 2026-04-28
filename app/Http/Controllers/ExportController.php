<?php

namespace App\Http\Controllers;

use App\Actions\ExportTranslations;

class ExportController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/export",
     *     tags={"Translations"},
     *     summary="Export translations for frontend (Vue.js)",
     *     description="Returns key => locale => value structure",
     *     security={{"bearerAuth":{}}},
     *
     *     @OA\Response(
     *         response=200,
     *         description="Exported translations",
     *         @OA\JsonContent(
     *             type="object",
     *             example={
     *                 "add_to_cart": {
     *                     "en": "Add to Cart",
     *                     "fr": "Ajouter au panier"
     *                 }
     *             }
     *         )
     *     )
     * )
     */
    public function __invoke(ExportTranslations $export)
    {
        return response()->json(
            $export->handle()
        );
    }
}
