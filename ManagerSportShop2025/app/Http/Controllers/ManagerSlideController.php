<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\slide;

class ManagerSlideController extends Controller {
    public function listSlide() {
        $slides = slide::paginate(5);
        return view('page.manager_slides', compact('slides'));
    }

    public function create() {
        return view('page.manager_slide_create');
    }

    public function store(Request $request) {
        $request->validate([
            'image' => 'required|string|max:100',
            'link' => 'nullable|url',
        ]);

        slide::create([
            'image' => $request->image,
            'link' => $request->link,
        ]);

        return redirect()->route('manager_slides')->with('success', 'Thêm slide thành công!');
    }

    public function edit($id) {
        $slide = slide::findOrFail($id);
        return view('page.manager_slide_edit', compact('slide'));
    }

    public function update(Request $request, $id) {
        $request->validate([
            'image' => 'required|string|max:100',
            'link' => 'nullable|url',
        ]);

        $slide = slide::findOrFail($id);
        $slide->update([
            'image' => $request->image,
            'link' => $request->link,
        ]);

        return redirect()->route('manager_slides')->with('success', 'Cập nhật slide thành công!');
    }

    public function destroy($id) {
        $slide = slide::findOrFail($id);
        $slide->delete();

        return redirect()->route('manager_slides')->with('success', 'Xóa slide thành công!');
    }
}
