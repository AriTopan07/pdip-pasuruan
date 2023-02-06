<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Repository\DetailSalesRepository;
use App\Models\DetailSale;
use Illuminate\Http\Request;

class DetailSalesController extends Controller
{
    protected $detailSalesRepository;

    public function __construct(DetailSalesRepository $ds) {
        $this->detailSalesRepository = $ds;
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            if($id){
                $this->detailSalesRepository->delete($id);
            }
            return response()->json([
                'message' => 'success deleted',
            ]);

        } catch (\Throwable $th) {
            return response()->json([
                'message' => $th->getMessage(),
                "data" => []
            ], 400);
        }
    }
    
}
