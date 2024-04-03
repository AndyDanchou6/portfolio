<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\BackgroundsModel;
use Illuminate\Console\Events\ScheduledBackgroundTaskFinished;

class BackgroundsController extends Controller
{
    public function index() {

        $projects = BackgroundsModel::all();

        return response()->json($projects);
    }

    public function show(BackgroundsModel $id) {

        $project = BackgroundsModel::find($id);

        return response()->json($project);
    }

    public function store(Request $request) {
        $validatedData = $request->validate([
            'name' => 'string|max:255|required',
            'place' => 'string|max:255|required',
            'year' => 'string|max:255|required',
            'address' => 'string|max:255|required',
            'description' => 'string|max:5000|required',
            'bgType' => 'required'
        ]);

        $bg = BackgroundsModel::create($validatedData);

        if ($bg) {
            return redirect()->back()->with('success', 'Background added sucessfully');
        }
        return redirect()->back()->with('error', 'Adding Background Failed');

        //dd($request);
    }

    public function update(Request $request, $id) {
        $validatedData = $request->validate([
            'name' => 'string|max:255',
            'place' => 'string|max:255',
            'year' => 'string|max:255',
            'address' => 'string|max:255',
            'description' => 'nullable|string|max:5000',
            'bgType' => 'required'
        ]);

        $bg = BackgroundsModel::findOrFail($id);
        $bg->update([
            'name' => $validatedData['name'] ?? $bg->name,
            'place' => $validatedData['place'] ?? $bg->place,
            'year' => $validatedData['year'] ?? $bg->year,
            'address' => $validatedData['address'] ?? $bg->address,
            'description' => $validatedData['description'] ?? $bg->description,
            'bgType' => $validatedData['bgType'] ?? $bg->bgType,
        ]);

        return redirect()->back()->with('success', 'Background Successfully Updated');
    }

    public function delete($id) {

        $bg = BackgroundsModel::findOrFail($id);
        $bg->delete();

        return redirect()->back()->with('success', 'Background Successfully Deleted');
    }

}
