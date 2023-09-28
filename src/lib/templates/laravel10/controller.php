<?php

namespace App\Http\Controllers;

use App\Models\Template;
use Exception;
use Illuminate\Http\Request;
use Yajra\Datatables\Datatables;

class TemplateController extends Controller
{
    public function template()
    {
        return view('template');
    }

    public function getAll(Request $request)
    {
        try {
            if ($request->ajax()) {
                $data = Template::get();

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
                $data = Template::findOrFail($request->id);

                return response()->json(['data' => $data]);
            }
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function store(Request $request, $id)
    {
        try {
            Template::findOrFail($id)->insert($request->fields);

            return response()->json(['success' => true, 'message' => 'Record added successfully!']);

        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function update(Request $request, $id)
    {
        try {
            Template::findOrFail($id)->update($request->fields);

            return response()->json(['success' => true, 'message' => 'Record updated successfully!']);

        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function destroy($id)
    {
        try {
            Template::findOrFail($id)->delete();

            return response()->json(['success' => true, 'message' => 'Record deleted successfully!']);

        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}
