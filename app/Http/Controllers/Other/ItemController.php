<?php

namespace App\Http\Controllers\Other;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Item;

class ItemController extends Controller
{
    public function index()
    {
        $items = Item::all();
        return view('dashboard.item', compact('items'));
    }

    public function store(Request $request)
    {
        $rules = [
            'item_code' => 'required|unique:items,item_code,' . $request->id,
            'item_name' => 'required',
            'item_cat' => 'required|in:R,O'
        ];

        // Add price validation only if category is Restaurant
        if ($request->item_cat === 'R') {
            $rules['price'] = 'required|numeric|min:0';
        }

        try {
            $request->validate($rules);

            $item = Item::updateOrCreate(
                ['id' => $request->id],
                [
                    'item_code' => $request->item_code,
                    'item_name' => $request->item_name,
                    'price' => $request->item_cat === 'R' ? $request->price : null,
                    'item_cat' => $request->item_cat
                ]
            );

            return redirect()->route('items.index')
                ->with('toastr', [
                    'type' => 'success',
                    'message' => $request->id ? 'Item updated successfully!' : 'Item added successfully!'
                ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return redirect()->back()
                ->withErrors($e->validator)
                ->withInput()
                ->with('toastr', [
                    'type' => 'error',
                    'message' => 'Item code already exists.'
                ]);
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error('Item save error: ' . $e->getMessage());
            return redirect()->back()
                ->withInput()
                ->with('toastr', [
                    'type' => 'error',
                    'message' => 'An error occurred while saving the item.'
                ]);
        }
    }

    public function destroy($id)
    {
        $item = Item::findOrFail($id);
        $item->delete();
        return redirect()->route('items.index')->with('toastr', [
            'type' => 'success',
            'message' => 'Item deleted successfully!'
        ]);
    }
}
