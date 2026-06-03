<?php

namespace App\Imports;

use App\Models\Guest;
use Maatwebsite\Excel\Concerns\SkipsEmptyRows;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;

class GuestImport implements ToModel, WithHeadingRow, WithValidation, SkipsEmptyRows
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */

    protected string $eventId;

    public function __construct(string $eventId)
    {
        $this->eventId = $eventId;
    }

    public function model(array $row): Guest
    {
        return new Guest([
            'event_id' => $this->eventId,
            'nama_utama' => $row['nama_utama'],
        ]);
    }

    public function rules(): array
    {
        return [
            'nama_utama' => 'required|string',
        ];
    }
}