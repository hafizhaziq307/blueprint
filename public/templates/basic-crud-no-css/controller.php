<?php

namespace App\Http\Controllers;

use App\Models\@@@model@@@;
use Exception;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class @@@controller@@@ extends Controller
{
    public function index()
    {
        $data = @@@model@@@::get();

        return view('@@@view@@@.index', compact('data'));
    }

    public function create()
    {
        return view('@@@view@@@.create');
    }

    public function edit($id)
    {
        $@@@variable@@@ = @@@model@@@::findOrFail($id);

        return view('@@@view@@@.edit', compact('@@@variable@@@'));
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

        @@@model@@@::create($validated);

        return to_route('@@@view@@@.index')->with('success', 'Rekod Berjaya Disimpan!');
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

        @@@model@@@::findOrFail($id)->update($validated);

        return to_route('@@@view@@@.index')->with('success', 'Rekod Berjaya Dikemaskini!');
    }

    public function destroy($id)
    {
        @@@model@@@::findOrFail($id)->delete();

        return to_route('@@@view@@@.index')->with('success', 'Rekod Berjaya Dipadam!');
    }

    public function getAll()
    {
        try {
            $data = @@@model@@@::get();

            return DataTables::of($data)
                ->addIndexColumn()
                ->make(true);
                
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}
