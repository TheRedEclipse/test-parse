<?php

namespace App\Imports;

use App\Models\Row;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\RemembersRowNumber;
use Maatwebsite\Excel\Concerns\SkipsEmptyRows;

class RowImport implements ToModel, WithHeadingRow, WithChunkReading, ShouldQueue, SkipsEmptyRows
{
    use RemembersRowNumber;
    use Importable;
    
    public function rules() : array
    {
        return [
            'name' => [
                'required',
                'string',
            ],
        ];
    }

    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        Redis::set(Str::random(8), $this->getRowNumber());

        return new Row([
            'name'     => $row['name'],
            'date'    => \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row['date'])->format('Y-m-d')
        ]);
    }

    public function chunkSize(): int
    {
        return 1000;
    }
}
