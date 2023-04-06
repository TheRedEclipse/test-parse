<?php

namespace App\Services;

use App\Imports\RowImport;
use App\Models\Row;
use Maatwebsite\Excel\Facades\Excel;

class RowService {

    protected $row;

    public function __construct(Row $row)
    {
        $this->row = $row;
    }
    /**
     * Display a listing of the resource.
     * 
     * @return object
     */
    public function index() : object
    {
        return $this->row->get()->groupBy('date');
    }

    /**
     * Store a newly created resource in storage.
     * 
     * @param object
     * @return void
     */
    public function store(object $request) : void
    {
        Excel::import(new RowImport, $request->file('file')->store(), 'local', \Maatwebsite\Excel\Excel::XLSX);
    }
}



