<?php

namespace App\Http\Controllers;

use App\Helpers\ApiFormatter;
use App\Models\Checklist;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ChecklistController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $checklist = Checklist::all();

            if ($checklist->isEmpty()) {
                return ApiFormatter::createAPI(404, 'No Leads Found');
            } else {
                return ApiFormatter::createAPI(200, 'Success', $checklist);
            }
        } catch (Exception $e) {
            return ApiFormatter::createAPI(500, 'Internal Server Error');
        }

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try{
            $request->validate([
                'title' => "required|title",
                'description' => "nullable|description",
                'user_id' => "user_id",
            ]);


            $checklist = Checklist::create([
                'title' => $request->title,
                'description' => $request->description,
                'user_id' => $request->user_id
            ]);


            $TambahData = Checklist::where('id', $checklist->id)->first();
                if ($TambahData) {
                    return ApiFormatter::createAPI(200,'success',$checklist);
                } else {
                    return ApiFormatter::createAPI(400, 'Failed');
                }
            } catch (Exception $error) {
                return ApiFormatter::createAPI(500, 'Internal Server Error', $error->getMessage());
            }
    }

    /**
     * Display the specified resource.
     */
    public function show(Checklist $checklist)
    {

    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Checklist $checklist)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request,$id)
    {
        try{
            $request->validate([
                'title' => "required|title",
                'description' => "nullable|description",
                'user_id' => "user_id",
            ]);


            $checklist = Checklist::findorFail($id);

            $checklist->update([
                'title' => $request->title,
                'description' => $request->description,
                'user_id' => $request->user_id
            ]);


            $UpdateChecklist = Checklist::where('id', $checklist->id)->first();
                if ($UpdateChecklist) {
                    return ApiFormatter::createAPI(200,'success',$UpdateChecklist);
                } else {
                    return ApiFormatter::createAPI(400, 'Failed');
                }
            } catch (Exception $error) {
                return ApiFormatter::createAPI(500, 'Internal Server Error', $error->getMessage());
            }
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try {
            $checklist = Checklist::findOrFail($id);
            $proses = $checklist->delete();

            if ($proses) {
                return ApiFormatter::createAPI(200, 'success delete data!');
            } else {
                return ApiFormatter::createAPI(400, 'Failed');
            }
        } catch (Exception $error) {
            return ApiFormatter::createAPI(400, 'Failed', $error->getMessage());
        }
    }
}
