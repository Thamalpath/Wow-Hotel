<?php

namespace App\Http\Controllers\Other;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Room;

class RoomController extends Controller
{
    public function index()
    {
        $rooms = Room::all();
        $categories = Category::where('cat_code', 'RT')->get();
        return view('dashboard.room', compact('rooms', 'categories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'room_no' => 'required|unique:rooms,room_no,' . $request->id,
            'room_type' => 'required'
        ]);

        if ($request->filled('id')) {
            $room = Room::findOrFail($request->id);
            $room->update($validated);
            $message = 'Room updated successfully!';
        } else {
            $validated['status'] = 'Available';
            Room::create($validated);
            $message = 'Room added successfully!';
        }

        return redirect()->route('rooms.index')->with('toastr', [
            'type' => 'success',
            'message' => $message
        ]);
    }

    public function destroy($id)
    {
        $room = Room::findOrFail($id);
        $room->delete();
        return redirect()->route('rooms.index')->with('toastr', [
            'type' => 'success',
            'message' => 'Room deleted successfully!'
        ]);
    }
}
