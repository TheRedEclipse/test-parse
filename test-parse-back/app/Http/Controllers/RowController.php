<?php

namespace App\Http\Controllers;

use App\Http\Requests\RowStoreRequest;
use App\Services\RowService;
use Illuminate\Http\Request;

class RowController extends Controller
{
    protected $rowService;

    public function __construct(RowService $rowService)
    {
        $this->rowService = $rowService;
        $this->middleware('auth:api')->only(['index', 'store']);
    }
    /**
     * Display a listing of the Row model.
     * 
     * @return object
     */
    public function index() : object
    {
        return response()->json([
            'success' => true,
            'rows' => $this->rowService->index()
        ]);
    }

    /**
     * Store a newly created records in Row model.
     * 
     * @param $request object
     * @return object
     */
    public function store(RowStoreRequest $request) : object
    {
        $this->rowService->store($request);

        return response()->json([
            'success' => true
        ]);
    }
}
