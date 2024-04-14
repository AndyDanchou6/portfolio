<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\AboutModel;

class AboutController extends Controller
{
    public function index()
    {
        $details = AboutModel::all();

        return response()->json($details);
    }

    public function update(Request $request)
    {
        $data = $request->validate([
            'name' => 'nullable|string|max:255',
            'birthdate' => 'nullable|string|max:255',
            'address' => 'nullable|string|max:255',
            'age' => 'nullable|integer|min:0',
            'civilStatus' => 'nullable|string|max:255',
            'citizenship' => 'nullable|string|max:255',
            'contactNo' => 'nullable|string|max:255',
            'email' => 'nullable|email'
        ]);
        $id = 1;
        $update = AboutModel::findOrFail($id);
        // $update->update($data);

        $update->update([
            'name' => $data['name'] ?? $update->name,
            'birthdate' => $data['dirthdate'] ?? $update->birthdate,
            'address' => $data['address'] ?? $update->address,
            'age' => $data['age'] ?? $update->age,
            'civilStatus' => $data['civilStatus'] ?? $update->civilStatus,
            'citizenship' => $data['citizenship'] ?? $update->citizenship,
            'contactNo' => $data['contactNo'] ?? $update->contactNo,
            'email' => $data['email'] ?? $update->email,
        ]);

        return redirect()->back()->with('success', 'Profile updated successfully.');
        // dd($update->name);
    }
}
