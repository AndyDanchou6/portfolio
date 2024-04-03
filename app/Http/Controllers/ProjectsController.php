<?php

namespace App\Http\Controllers;

use App\Models\ProjectsModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProjectsController extends Controller
{
    public function index() {

        $projects = ProjectsModel::all();

        return response()->json($projects);
    }

    public function show(ProjectsModel $id) {

        $project = ProjectsModel::find($id);

        return response()->json($project);
    }

    public function store(Request $request) {
        
        $validatedData = $request->validate([
            'projectName' => 'string|max:255|required',
            'category' => 'string|max:255|required',
            'client' => 'string|max:255|required',
            'startDate' => 'required|date',
            'description' => 'string|max:5000|required',
            'url' => 'nullable|url',
            'completion' => 'required|integer|min:0|max:100',
            'completionDate' => 'nullable|date',
            'picture' => 'image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);
        
        //dd($validatedData);

        try {
            if ($request->hasFile('picture')) {
                $pictureFile = $request->file('picture')->store('images', 'images');

                //dd($validatedData['picture']);
                $validatedData['picture'] = $pictureFile;
            }
    
            $project = ProjectsModel::create($validatedData);
    
            return redirect()->back()->with('success', 'Project added successfully!');
        } catch (\Exception $e) {

            return redirect()->back()->with('error', 'Error: ' . $e->getMessage());
        }   
    }

    public function update(Request $request, $id) {
        $validatedData = $request->validate([
            'projectName' => 'string|max:255',
            'category' => 'string|max:255',
            'client' => 'string|max:255',
            'startDate' => 'date',
            'description' => 'string|max:5000',
            'url' => 'url',
            'completion' => 'integer|min:0|max:100',
            'completionDate' => 'date',
            'picture' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);
    
        $project = ProjectsModel::findOrFail($id);
    
        if ($request->hasFile('picture')) {

            Storage::delete('public/' . $project->picture);
           
            $picturePath = $request->file('picture')->store('images', 'images');
            
            $validatedData['picture'] = $picturePath;
        } else {
            
            $validatedData['picture'] = $project->picture;
        }
    
        $project->update([
            'projectName' => $validatedData['projectName'] ?? $project->projectName,
            'category' => $validatedData['category'] ?? $project->category,
            'client' => $validatedData['client'] ?? $project->client,
            'startDate' => $validatedData['startDate'] ?? $project->startDate,
            'description' => $validatedData['description'] ?? $project->description,
            'url' => $validatedData['url'] ?? $project->url,
            'completion' => $validatedData['completion'] ?? $project->completion,
            'completionDate' => $validatedData['completionDate'] ?? $project->completionDate,
            'picture' => $validatedData['picture'] ?? $project->picture,
        ]);
        
    
        return redirect()->back()->with('success', 'Project updated successfully.');
    }

    public function delete($id) {

        $delete = ProjectsModel::findOrFail($id);

        $profilePicturePath = $delete->picture;

        if ($profilePicturePath) {
            
            Storage::delete('public/' . $profilePicturePath);
        }

        $delete->delete();

        //dd($profilePicturePath);
        return redirect()->back()->with('success', 'Project deleted successfully.');
    }

    public function contents($id) {
        $content = ProjectsModel::find($id);

        return view('contents', compact('content'));
    }
    
}
