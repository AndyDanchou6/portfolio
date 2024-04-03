<?php

namespace App\Http\Controllers;

use App\Models\PeopleModel;
use App\Models\ProjectsModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PeopleController extends Controller
{
    public function index()
    {

        $projects = PeopleModel::where('role', 0)->get();

        return response()->json($projects);
    }

    public function indexMessage()
    {

        $person = PeopleModel::where('role', 1)->get();

        return response()->json($person);
    }

    public function show(PeopleModel $id)
    {

        $project = PeopleModel::find($id);

        return response()->json($project);
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'fullname' => 'string|max:255|required',
            'job' => 'string|max:255|required',
            'email' => 'required||email',
            'message' => 'string|max:5000|required',
            'profilePic' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        try {
            if ($request->hasFile('profilePic')) {
                $pictureFile = $request->file('profilePic')->store('images', 'images');

                //dd($validatedData['picture']);
                $validatedData['profilePic'] = $pictureFile;
            }

            $testimonial = PeopleModel::create($validatedData);

            return redirect()->back()->with('success', 'Testimonial added successfully!');
        } catch (\Exception $e) {

            return redirect()->back()->with('error', 'Error: ' . $e->getMessage());
        }
    }

    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'fullname' => 'string|max:255',
            'job' => 'string|max:255',
            'email' => 'email',
            'message' => 'string|max:5000',
            'profilePic' => 'image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        $testimonial = PeopleModel::findOrFail($id);

        if ($request->hasFile('profilePic')) {

            Storage::delete('public/' . $testimonial->profilePic);

            $picturePath = $request->file('profilePic')->store('images', 'images');

            $validatedData['profilePic'] = $picturePath;
        } else {

            $validatedData['profilePic'] = $testimonial->profilePic;
        }

        $testimonial->update([
            'fullname' => $validatedData['fullname'] ?? $testimonial->fullname,
            'job' => $validatedData['job'] ?? $testimonial->job,
            'email' => $validatedData['email'] ?? $testimonial->email,
            'message' => $validatedData['message'] ?? $testimonial->message,
            'profilePic' => $validatedData['profilePic'] ?? $testimonial->profilePic,
        ]);

        return redirect()->back()->with('success', 'Testimony updated successfully.');
    }

    public function delete($id)
    {

        $delete = PeopleModel::findOrFail($id);

        $picturePath = $delete->profilePic;

        if ($picturePath) {

            Storage::delete('public/' . $picturePath);
        }

        $delete->delete();

        //dd($profilePicturePath);
        return redirect()->back()->with('success', 'Testimony deleted successfully.');
    }

    public function deleteAll()
    {

        $itemsToDelete = PeopleModel::where('role', 1)->get();
        
        // Delete each item
        foreach ($itemsToDelete as $item) {
            $item->delete();
        }
        return response()->json([
            'success' => 'All status updated'
        ]);
    }

    public function updateAll()
    {
        $rowsToUpdate = PeopleModel::where('status', 0)->get();

        foreach ($rowsToUpdate as $row) {
            $row->update(['status' => 1]);
        }

        return response()->json([
            'success' => 'All status updated'
        ]);
    }

    public function feedbackStore(Request $request) {
        $validatedData = $request->validate([
            'fullname' => 'string|max:255|required',
            'email' => 'required||email',
            'message' => 'string|max:5000|required',
            'subject' => 'string|max:255|required',
        ]);

        $validatedData['role'] = 1;

        $store = PeopleModel::create($validatedData);

        return redirect()->back()->with('success', 'Message sent successfully.');
    }
}
