<?php

namespace App\Imports;

use App\Models\Guest;
use Maatwebsite\Excel\Concerns\SkipsEmptyRows;
use Maatwebsite\Excel\Concerns\SkipsOnFailure;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithCustomCsvSettings;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Validators\Failure;

class GuestImport implements ToModel, WithHeadingRow, WithValidation, SkipsEmptyRows, SkipsOnFailure, WithCustomCsvSettings
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */

    protected string $eventId;
    protected array $failures = [];

    public function __construct(string $eventId)
    {
        $this->eventId = $eventId;
    }

    public function model(array $row): Guest
    {
        return new Guest([
            'event_id' => $this->eventId,
            'nomor_undangan' => $row['nomor_undangan'],
            'nama_utama' => $row['nama_utama'],
            'jumlah_tamu' => !empty($row['jumlah_tamu']) ? (int) $row['jumlah_tamu'] : 1,
        ]);
    }

    public function rules(): array
    {
        return [
            'nama_utama' => 'required|string',
            'jumlah_tamu' => 'nullable|integer|min:1',
        ];
    }

    public function customValidationMessages(): array
    {
        return [
            'nama_utama.required' => 'Kolom nama_utama tidak boleh kosong.',
            'jumlah_tamu.integer' => 'Kolom jumlah_tamu harus berupa angka.',
            'jumlah_tamu.min' => 'Kolom jumlah_tamu minimal 1.',
        ];
    }

    public function onFailure(Failure ...$failure): void
    {
        $this->failures = array_merge($this->failures, $failure);
    }

    public function getFailures(): array
    {
        return $this->failures;
    }

    public function getCsvSettings(): array
    {
        return [
            'delimiter' => ';',
        ];
    }
}