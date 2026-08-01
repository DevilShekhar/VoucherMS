<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CourseCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CourseCategoryController extends Controller
{
    public function create()
    {
        return view('admin.course_cat.create');
    }

    public function index()
    {
        $courseCategories = CourseCategory::with(['creator', 'updater'])->latest()->paginate(10);

        return view('admin.course_cat.index', compact('courseCategories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:course_category,name',
            'created_by' => Auth::id(),
        ]);

        CourseCategory::create([
            'name' => $request->name,
        ]);

        return redirect()
            ->route('course-category.index')
            ->with('success', 'Course Category created successfully.');
    }
    public function edit(CourseCategory $courseCategory)
    {
        return view('admin.course_cat.edit', compact('courseCategory'));
    }

    public function update(Request $request, CourseCategory $courseCategory)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:course_category,name,'.$courseCategory->id,
        ]);

        $courseCategory->update([
            'name' => $request->name,
            'updated_by' => Auth::id(),
        ]);

        return redirect()
            ->route('course-category.index')
            ->with('success', 'Course Category updated successfully.');
    }
}
