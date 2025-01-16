<?php

namespace App\Http\Controllers\Other;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = [
            'MP' => Category::where('cat_code', 'MP')->get(),
            'RT' => Category::where('cat_code', 'RT')->get(),
            'RC' => Category::where('cat_code', 'RC')->get(),
            'GF' => Category::where('cat_code', 'GF')->get(),
            'EX' => Category::where('cat_code', 'EX')->get(),
            'DEP' => Category::where('cat_code', 'DEP')->get(),
        ];

        return view('dashboard.category', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'input_name' => 'required|string|max:255',
            'cat_code' => 'required|string|in:MP,RT,RC,GF,EX,DEP'
        ]);

        $exists = Category::where('cat_name', $request->input_name)
            ->where('cat_code', $request->cat_code)
            ->exists();

        if ($exists) {
            return redirect()->back()->with('toastr', [
                'type' => 'error',
                'message' => 'Category name already exists in this department!'
            ]);
        }

        Category::create([
            'cat_name' => strtoupper($request->input_name),
            'cat_code' => $request->cat_code
        ]);

        return redirect()->back()->with('toastr', [
            'type' => 'success',
            'message' => 'Category added successfully!'
        ]);
    }

    public function destroy($id)
    {
        $category = Category::findOrFail($id);
        $category->delete();
        
        return redirect()->back()->with('toastr', [
            'type' => 'success',
            'message' => 'Category deleted successfully'
        ]);
    }
}
