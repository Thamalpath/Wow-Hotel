<?php

namespace App\Http\Controllers\Other;

use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Staff;
use App\Models\Category;

class StaffController extends Controller
{
    public function index()
    {
        $staff = Staff::all();
        $departments = Category::where('cat_code', 'DEP')->pluck('cat_name');
            
        return view('dashboard.staff', compact('staff', 'departments'));
    }

    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'known_name' => 'required|string|max:255',
                'full_name' => 'required|string|max:255',
                'contact_no' => 'required|string|max:50',
                'address' => 'required|string',
                'department' => 'required|string|max:100',
                'id_no' => 'required|string|max:50',
                'religion' => 'required|string|max:50',
                'blood_group' => 'required|string|max:50',
                'em_contact_no' => 'required|string|max:50',
                'account_no' => 'required|string|max:50',
                'account_name' => 'required|string|max:100',
                'bank' => 'required|string|max:100',
                'branch' => 'required|string|max:100',
                'special_skills' => 'nullable|string',
                'pre_worked' => 'nullable|string',
                'joined_date' => 'required|date',
                'currently_employed' => 'required|in:Yes,No',
                'resign_date' => 'nullable|date',
                'reason' => 'nullable|string',
                'comments' => 'nullable|string'
            ]);

            Staff::create($validated);

            return redirect()->back()->with('toastr', [
                'type' => 'success',
                'message' => 'Staff member added successfully!'
            ]);
        } catch (\Exception $e) {
            return redirect()->back()->with('toastr', [
                'type' => 'error',
                'message' => 'Error adding staff member: ' . $e->getMessage()
            ])->withInput();
        }
    }

    public function edit(Staff $staff)
    {
        return response()->json($staff);
    }

    public function update(Request $request, Staff $staff)
    {
        try {
            $validated = $request->validate([
                'known_name' => 'required|string|max:255',
                'full_name' => 'required|string|max:255',
                'contact_no' => 'required|string|max:50',
                'address' => 'required|string',
                'department' => 'required|string|max:100',
                'id_no' => 'required|string|max:50',
                'religion' => 'required|string|max:50',
                'blood_group' => 'required|string|max:50',
                'em_contact_no' => 'required|string|max:50',
                'account_no' => 'required|string|max:50',
                'account_name' => 'required|string|max:100',
                'bank' => 'required|string|max:100',
                'branch' => 'required|string|max:100',
                'special_skills' => 'nullable|string',
                'pre_worked' => 'nullable|string',
                'joined_date' => 'required|date',
                'currently_employed' => 'required|in:Yes,No',
                'resign_date' => 'nullable|date',
                'reason' => 'nullable|string',
                'comments' => 'nullable|string'
            ]);

            $staff->update($validated);

            return redirect()->back()->with('toastr', [
                'type' => 'success',
                'message' => 'Staff member updated successfully!'
            ]);
        } catch (\Exception $e) {
            return redirect()->back()->with('toastr', [
                'type' => 'error',
                'message' => 'Error updating staff member: ' . $e->getMessage()
            ])->withInput();
        }
    }

    public function destroy($id)
    {
        try {
            $staff = Staff::findOrFail($id);
            
            if ($staff->image) {
                Storage::delete('public/staff/' . $staff->image);
            }
            
            $staff->delete();

            return redirect()->back()->with('toastr', [
                'type' => 'success',
                'message' => 'Staff member deleted successfully!'
            ]);
        } catch (\Exception $e) {
            return redirect()->back()->with('toastr', [
                'type' => 'error',
                'message' => 'Error deleting staff member: ' . $e->getMessage()
            ]);
        }
    }

    public function uploadImage(Request $request, Staff $staff)
    {
        try {
            $request->validate([
                'image' => 'required|image|max:2048'
            ]);

            if ($staff->image) {
                Storage::delete('public/staff/' . $staff->image);
            }

            $imageName = time() . '.' . $request->image->extension();
            $request->image->storeAs('public/staff', $imageName);

            $staff->update(['image' => $imageName]);

            return response()->json([
                'type' => 'success',
                'message' => 'Image uploaded successfully!'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'type' => 'error',
                'message' => 'Error uploading image: ' . $e->getMessage()
            ]);
        }
    }
}