<?php

namespace App\Imports;

use App\Models\Course;
use App\Models\CourseCategory;
use App\Models\Voucher;
use App\Models\VoucherVendor;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use PhpOffice\PhpSpreadsheet\Shared\Date;

class VoucherImport implements ToModel, WithHeadingRow
{
    public static array $duplicates = [];

    public static array $vendors = [];

    public static array $courses = [];

    public function model(array $row)
    {
        // Duplicate voucher code
        $code = strtoupper(trim($row['voucher_code']));
        $hash = hash('sha256', $code);

        if (Voucher::query()->where('voucher_code_hash', $hash)->exists()) {
            self::$duplicates[] = $code;

            return null;
        }

        // Vendor check
        $vendor = VoucherVendor::query()->where('vendor_name', trim($row['vendor_name']))->first();

        if (! $vendor) {
            self::$vendors[] = $row['vendor_name'];

            return null;
        }
        $category = CourseCategory::query()->where('name', trim($row['course_category']))->first();

        if (! $category) {

            self::$courses[] =
                trim($row['course_category']).' -> '.
                trim($row['course']);

            return null;
        }

        $course = Course::query()->where('course_name', trim($row['course']))
            ->where('course_category_id', $category->id)
            ->first();

        if (! $course) {

            self::$courses[] =
                trim($row['course_category']).' -> '.
                trim($row['course']);

            return null;
        }

        return new Voucher([
            'voucher_code' => trim($row['voucher_code']),
            'vendor_id' => $vendor->id,
            'course_category_id' => $category->id,
            'course_id' => $course->id,
            'purchase_date' => $this->formatDate($row['purchase_date']),
            'expiry_date' => $this->formatDate($row['expiry_date']),
            'purchase_price' => $row['purchase_price'],
            'cost' => $row['cost'],
            'created_by' => Auth::id(),
        ]);

    }

    private function formatDate($value)
    {
        if (is_numeric($value)) {
            return Date::excelToDateTimeObject($value);
        }

        return Carbon::createFromFormat('d-m-Y', trim($value));
    }
}
