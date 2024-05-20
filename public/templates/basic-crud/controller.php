<?php

namespace App\Http\Controllers;

use App\Models\@@@modelname@@@;
use Exception;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class @@@controller@@@ extends Controller
{
    public function index()
    {
        $data = @@@modelname@@@::get();

        return view('@@@folderviewname@@@.index', compact('data'));
    }

    public function create()
    {
        return view('@@@folderviewname@@@.create');
    }

    public function edit($id)
    {
        $@@@variable@@@ = @@@modelname@@@::findOrFail($id);

        return view('@@@folderviewname@@@.edit', compact('@@@variable@@@'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate(
            [
                @@@validationrules@@@
            ],
            [
                // custom message
            ]
        );

        @@@modelname@@@::create($validated);

        return to_route('@@@folderviewname@@@.index')->with('success', 'Rekod Berjaya Disimpan!');
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate(
            [
                @@@validationrules@@@
            ],
            [
                // custom message
            ]
        );

        @@@modelname@@@::findOrFail($id)->update($validated);

        return to_route('@@@folderviewname@@@.index')->with('success', 'Rekod Berjaya Dikemaskini!');
    }

    public function destroy($id)
    {
        @@@modelname@@@::findOrFail($id)->delete();

        return to_route('@@@folderviewname@@@.index')->with('success', 'Rekod Berjaya Dipadam!');
    }

    public function getAll()
    {
        try {
            $data = @@@modelname@@@::get();

            return DataTables::of($data)
                ->addIndexColumn()
                ->make(true);
                
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}
