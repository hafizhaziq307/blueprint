<?php

namespace App\Http\Controllers;

use App\Models\@@@modelname@@@;
use Exception;
use Illuminate\Http\Request;
use Yajra\Datatables\Datatables;

class @@@modelname@@@Controller extends Controller
{
    public function index()
    {
        return view('@@@folderviewname@@@.index');
    }

    public function getAll(Request $request)
    {
        try {
            if ($request->ajax()) {
                $data = @@@modelname@@@::get();

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
                $data = @@@modelname@@@::findOrFail($request->id);

                return response()->json($data);
            }
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate(
            [
                @@@validationrules@@@
            ],
            [
                // custom message
            ]
        );

        try {
            @@@modelname@@@::create($validatedData);

            return response()->json(['message' => 'Record added successfully!']);
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function update(Request $request, $id)
    {
        $validatedData = $request->validate(
            [
                @@@validationrules@@@
            ],
            [
                // custom message
            ]
        );

        try {
            @@@modelname@@@::findOrFail($id)->update($validatedData);

            return response()->json(['message' => 'Record updated successfully!']);
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function destroy($id)
    {
        try {
            @@@modelname@@@::findOrFail($id)->delete();

            return response()->json(['message' => 'Record deleted successfully!']);
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}
