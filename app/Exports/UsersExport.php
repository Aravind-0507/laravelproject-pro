<?php

namespace App\Exports;

use App\Models\Employee;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class UsersExport implements FromCollection, WithHeadings
{
    /**
     * Return a collection of users.
     *
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        return Employee::all(['id', 'name', 'email', 'joining_date', 'is_active', 'phone']); // Adjust fields as necessary
    }

    /**
     * Define the headings for the Excel file.
     *
     * @return array
     */
    public function headings(): array
    {
        return ['ID', 'Name', 'Email', 'Date of Birth', 'Status', 'phone'];
    }
}