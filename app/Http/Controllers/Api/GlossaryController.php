<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\GlossaryResource;
use App\Models\Glossary;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class GlossaryController extends Controller
{
    public function search(Request $request)
    {
        try {

            $searchByMetric = $request->input('metric');
            $searchByTopic = $request->input('topic');
            $searchBySubtopic = $request->input('subtopic');
            $searchByContent = $request->input('content');

            $sortBy = $request->input('sort_by'); // campo para ordenação
            $sortOrder = $request->input('sort_order', 'asc'); // ordem de classificação (padrão: ascendente)

            $query = Glossary::query();

            if (!empty($searchByMetric)) {
                $query->where('metric', '=', $searchByMetric);
            }

            if (!empty($searchByTopic)) {
                $query->where('topic', 'LIKE', "%$searchByTopic%");
            }

            if (!empty($searchBySubtopic)) {
                $query->where('subtopic', '=', "$searchBySubtopic");
            }

            if (!empty($searchByContent)) {
                $query->where('content', 'LIKE', "%$searchByContent%");
            }

            if (!empty($sortBy)) {
                $query->orderBy($sortBy, $sortOrder);
            }
            // dd($query->toSql());
            $results = $query->get();

            return response()->json([
                'message' => 'Search results',
                'data' => GlossaryResource::collection($results),
            ], 200);

        } catch (ModelNotFoundException $e) {
            return response()->json([
                'message' => $e->getMessage(),
                'data' => false,
            ], 404);
        }
    }
}
