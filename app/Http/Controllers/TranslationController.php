<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\TranslationRepository;
use App\Models\Translation;

class TranslationController extends Controller
{
    public function __construct(
        private TranslationRepository $repository
    ) {}

    /**
     * GET /translations
     */

    /**
     * @OA\Get(
     *     path="/api/translations",
     *     tags={"Translations"},
     *     summary="Get all translations with search",
     *     security={{"bearerAuth":{}}},
     *
     *     @OA\Parameter(
     *         name="key",
     *         in="query",
     *         required=false,
     *         @OA\Schema(type="string"),
     *         description="Search by translation key"
     *     ),
     *
     *     @OA\Parameter(
     *         name="tag",
     *         in="query",
     *         required=false,
     *         @OA\Schema(type="string"),
     *         description="Search by tag name"
     *     ),
     *
     *     @OA\Parameter(
     *         name="content",
     *         in="query",
     *         required=false,
     *         @OA\Schema(type="string"),
     *         description="Search by translation value"
     *     ),
     *
     *     @OA\Response(
     *         response=200,
     *         description="List of translations",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(
     *                 @OA\Property(property="id", type="integer"),
     *                 @OA\Property(property="key", type="string")
     *             )
     *         )
     *     ),
     *
     *     @OA\Response(response=401, description="Unauthorized")
     * )
     */
    public function index(Request $request)
    {
        return response()->json(
            $this->repository->search($request->all())
        );
    }

    /**
     * POST /translations
     */

    /**
     * @OA\Post(
     *     path="/api/translations",
     *     tags={"Translations"},
     *     summary="Create translation",
     *     security={{"bearerAuth":{}}},
     *
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"key","values"},
     *
     *             @OA\Property(property="key", type="string", example="welcome_message"),
     *
     *             @OA\Property(
     *                 property="values",
     *                 type="array",
     *                 @OA\Items(
     *                     @OA\Property(property="locale", type="string", example="en"),
     *                     @OA\Property(property="value", type="string", example="Welcome")
     *                 )
     *             )
     *         )
     *     ),
     *
     *     @OA\Response(response=201, description="Created successfully"),
     *     @OA\Response(response=422, description="Validation error")
     * )
     */
    public function store(Request $request)
    {
        $request->validate([
            'key' => 'required|unique:translations',
            'values' => 'required|array',
            'values.*.locale' => 'required',
            'values.*.value' => 'required',
            'tags' => 'array'
        ]);

        return response()->json(
            $this->repository->create($request->all())
        );
    }

    /**
     * PUT /translations/{id}
     */

    /**
     * @OA\Put(
     *     path="/api/translations/{id}",
     *     tags={"Translations"},
     *     summary="Update translation",
     *     security={{"bearerAuth":{}}},
     *
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer"),
     *         description="Translation ID"
     *     ),
     *
     *     @OA\RequestBody(
     *         required=false,
     *         @OA\JsonContent(
     *             @OA\Property(property="key", type="string"),
     *             @OA\Property(
     *                 property="values",
     *                 type="array",
     *                 @OA\Items(
     *                     @OA\Property(property="locale", type="string"),
     *                     @OA\Property(property="value", type="string")
     *                 )
     *             )
     *         )
     *     ),
     *
     *     @OA\Response(response=200, description="Updated successfully"),
     *     @OA\Response(response=404, description="Not found")
     * )
     */
    public function update(Request $request, $id)
    {
        $translation = Translation::find($id);
        if (!$translation) {
            return response()->json([
                'success' => false,
                'message' => 'Translation not found.'
            ], 404);
        }
        return response()->json(
            $this->repository->update($translation, $request->all())
        );
    }
}
