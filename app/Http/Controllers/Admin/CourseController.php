<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\CourseCategory;
use Illuminate\Http\Request;

class CourseController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $courses = Course::with('category')->latest()->get();

        return view('admin.courses.index', compact('courses'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = CourseCategory::query()->orderBy('name')->get();

        return view('admin.courses.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->merge([
            'status' => $request->input('status', 1),
        ]);

        $validated = $request->validate([
            'course_code' => 'required|string|max:50|unique:courses,course_code',
            'course_category_id' => 'required|exists:course_category,id',
            'course_name' => 'required|string|max:255|unique:courses,course_name',
            'description' => 'nullable|string',
            'status' => 'required|boolean',
        ]);

        Course::create($validated);

        return redirect()
            ->route('courses.index')
            ->with('success', 'Course created successfully.');
    }

    public function edit(Course $course)
    {
        $categories = CourseCategory::query()->orderBy('name')->get();
        return view('admin.courses.edit', compact('course', 'categories'));
    }

    public function update(Request $request, Course $course)
    {
        $validated = $request->validate([
            'course_category_id' => 'required|exists:course_category,id',
            'course_code' => 'required|',
            'course_name' => 'required',
            'description' => 'nullable|string',
            'status' => 'required|boolean',
        ]);

        $course->update($validated);

        return redirect()
            ->route('courses.index')
            ->with('success', 'Course Updated successfully.');
    }

    public function destroy(Course $course)
    {
        $course->update([
            'status' => 0,
        ]);

        return redirect()
            ->route('courses.index')
            ->with('success', 'Course deactivated successfully.');
    }
}
