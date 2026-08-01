<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CourseCategory;
use Illuminate\Http\Request;

class CourseCategoryController extends Controller
{
    public function create()
    {
        return view('admin.course_cat.create');
    }

    public function index()
    {
        $courseCategories = CourseCategory::query()->latest()->get();

        return view('admin.course_cat.index', compact('courseCategories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:course_category,name',
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
        'name' => 'required|string|max:255|unique:course_category,name,' . $courseCategory->id,
    ]);

    $courseCategory->update([
        'name' => $request->name,
    ]);

    return redirect()
        ->route('course-category.index')
        ->with('success', 'Course Category updated successfully.');
}

}
