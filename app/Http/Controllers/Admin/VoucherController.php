<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Imports\VoucherImport;
use App\Models\Course;
use App\Models\CourseCategory;
use App\Models\Voucher;
use App\Models\VoucherVendor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;
use Throwable;

class VoucherController extends Controller
{
    public function index()
    {
        $vouchers = Voucher::with(['vendor', 'course', 'creator', 'updater'])->latest()->paginate(30);

        return view('admin.vouchers.index', compact('vouchers'));
    }

    public function status($status)
    {
        $vouchers = Voucher::query()->where('status', ucfirst($status))->paginate(10);

        return view('admin.vouchers.index', compact('vouchers'));
    }

    public function create()
    {
        $vendors = VoucherVendor::orderBy('vendor_name')->get();
        $categories = CourseCategory::get();

        return view('admin.vouchers.create', compact('vendors', 'categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'voucher_code' => 'required',
            'vendor_id' => 'required',
            'course_category_id' => 'required|exists:course_category,id',
            'course_id' => 'required|exists:courses,id',
            'purchase_date' => 'required',
            'expiry_date' => 'required',
            'purchase_price' => 'required',
            'cost' => 'required',
        ]);

        $hash = hash('sha256', strtoupper(trim($request->voucher_code)));
        if (Voucher::query()->where('voucher_code_hash', $hash)->exists()) {
            return back()
                ->withInput()
                ->withErrors([
                    'voucher_code' => 'This voucher code already exists.',
                ]);
        }
        $data = $request->all();
        $data['created_by'] = Auth::id();
        Voucher::create($data);

        return redirect()
            ->route('vouchers.index')
            ->with('success', 'Voucher created successfully.');
    }

    public function edit(Voucher $voucher)
    {
        $vendors = VoucherVendor::orderBy('vendor_name')->get();
        $categories = CourseCategory::orderBy('name')->get();

        $courses = Course::where('course_category_id', $voucher->course_category_id)

            ->orderBy('course_name')
            ->get();

        return view('admin.vouchers.edit', compact(
            'voucher',
            'vendors',
            'categories',
            'courses'
        ));
    }

    public function update(Request $request, Voucher $voucher)
    {
        $request->validate([
            'voucher_code' => 'required',
            'vendor_id' => 'required',
            'course_category_id' => 'required|exists:course_category,id',
            'course_id' => 'required|exists:courses,id',
            'purchase_date' => 'required',
            'expiry_date' => 'required',
            'purchase_price' => 'required',
            'cost' => 'required',
        ]);

        $data = $request->all();
        $data['updated_by'] = Auth::id();

        $voucher->update($data);

        return redirect()
            ->route('vouchers.index')
            ->with('success', 'Voucher updated successfully.');
    }

    public function destroy(Voucher $voucher)
    {
        $voucher->delete();

        return redirect()
            ->route('vouchers.index')
            ->with('success', 'Voucher deleted successfully.');
    }

    public function dashboard()
    {
        $vouchers = Voucher::with('vendor')
            ->latest()
            ->paginate(20);

        return view('dashboard', compact('vouchers'));
    }

    public function bulkUpload(Request $request)
    {
        $rows = Excel::toArray([], $request->file('file'));

        if (empty($rows) || empty($rows[0])) {
            return redirect()->route('vouchers.index')
                ->with('error', 'The uploaded Excel file is empty.');
        }

        $headers = array_map(function ($header) {
            return strtolower(trim($header));
        }, $rows[0][0]);

        $requiredHeaders = [
            'voucher_code',
            'vendor_name',
            'course_category',
            'course_name',
            'purchase_date',
            'expiry_date',
            'purchase_price',
            'cost',
        ];

        $missing = array_diff($requiredHeaders, $headers);

        if (! empty($missing)) {

            return redirect()->route('vouchers.index')
                ->with(
                    'error',
                    'Invalid Excel format. Missing or incorrect column(s): <strong>'
                    .implode(', ', $missing)
                    .'</strong>. Please use the provided sample template.'
                );
        }
        $request->validate([
            'file' => 'required|mimes:xlsx,xls,csv',
        ]);

        VoucherImport::$duplicates = [];
        VoucherImport::$vendors = [];

        try {

            Excel::import(new VoucherImport, $request->file('file'));

            $message = '<strong>✅ Vouchers uploaded successfully.</strong>';

            if (! empty(VoucherImport::$duplicates)) {

                $message .= '
            <div class="mt-2">
                <span class="text-danger fw-bold">Duplicate Voucher Codes (Skipped):</span>
                <ul class="mb-0 text-danger">';

                foreach (VoucherImport::$duplicates as $code) {
                    $message .= "<li>{$code}</li>";
                }

                $message .= '</ul></div>';
            }

            if (! empty(VoucherImport::$vendors)) {

                $vendors = array_filter(array_unique(VoucherImport::$vendors));

                if (count($vendors)) {

                    $message .= '
                <div class="mt-2">
                    <span class="text-danger fw-bold">Vendor Not Found:</span>
                    <ul class="mb-0 text-danger">';

                    foreach ($vendors as $vendor) {
                        $message .= "<li>{$vendor}</li>";
                    }

                    $message .= '</ul></div>';
                }
            }

            return redirect()
                ->route('vouchers.index')
                ->with('success', $message);

        } catch (Throwable $e) {

            // Missing Excel column
            if (str_contains($e->getMessage(), 'Undefined array key')) {

                preg_match('/"([^"]+)"/', $e->getMessage(), $matches);

                $column = $matches[1] ?? '';

                return redirect()
                    ->route('vouchers.index')
                    ->with('error', "Invalid Excel file. Required column '{$column}' is missing or the column name is incorrect.");
            }

            return redirect()
                ->route('vouchers.index')
                ->with('error', 'Failed to import Excel file. Please make sure you are using the correct template.');
        }
    }

    public function getCourses($category)
    {
        $courses = Course::where('course_category_id', $category)
            ->where('status', 1)
            ->orderBy('course_name')
            ->get(['id', 'course_name']);

        return response()->json($courses);
    }
}
