<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Test;
use Exception;
use Yajra\Datatables\Datatables;

class TestController extends Controller
{
    // index
    public function template()
    {
        return view('test');
    }

    public function getAll(Request $request)
    {
        try {
            if ($request->ajax()) {
                $data = Test::get();

                return Datatables::of($data)
                    ->addIndexColumn()
                    ->make(true);
            }
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
    
    public function getFirst(Request $request)
    {
        try {
            if ($request->ajax()) {
                $data = Test::findOrFail($request->id);

                return response()->json(['data' => $data]);
            }
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function store(Request $request, $id)
    {
        try {
            Test::findOrFail($id)->insert($request->fields);

            return response()->json(['success' => true, 'message' => 'Record added successfully!']);

        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function update(Request $request, $id)
    {
        try {
            Test::findOrFail($id)->update($request->fields);

            return response()->json(['success' => true, 'message' => 'Record updated successfully!']);

        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function destroy($id)
    {
        try {
            Test::findOrFail($id)->delete();

            return response()->json(['success' => true, 'message' => 'Record deleted successfully!']);

        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}
