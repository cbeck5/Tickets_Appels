<?php

namespace App\Imports;

use App\Models\Consumption;
use App\Models\Trace;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithStartRow;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Maatwebsite\Excel\Concerns\WithCustomStartCell;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Concerns\SkipsFailures;
use Maatwebsite\Excel\Concerns\SkipsOnFailure;
use Maatwebsite\Excel\Concerns\WithCustomCsvSettings;
use Illuminate\Support\Collection;
use DateTime;
use DB;

class ConsumptionStatementImport implements ToModel, WithStartRow, WithChunkReading, WithCustomStartCell, WithBatchInserts, WithValidation,SkipsOnFailure, WithCustomCsvSettings
{
	use SkipsFailures;

     /**
     * @return int
     * Start load file at row x
     */
    public function startRow(): int
    {
        return 4;
    }

    //Read the spreadsheet in chunks
    public function chunkSize(): int
    {
        return 100000;
    }

    //Specifying a batch size (query)
    public function batchSize(): int
    {
        return 1000;
    }

    // Start load file at column x
    public function startCell(): string
    {
        return 'C4';
    }

    //Choose encoding
    public function getCsvSettings(): array
    {
        return [
            'input_encoding' => 'ISO-8859-1'
        ];
    }

    //Validation of data
    public function rules(): array
    {
        return [
             '0' => 'required|integer',
        ];
    }


    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    * Import data, and controls of each column
    */
    public function model(array $row)
    {
        if($row[2] != "" && $row[3] != "" && $row[4] != "" && $row[7] != "" && is_int($row[2]))
        {
            if(DateTime::createFromFormat('H:i:s', $row[4]) && $row[4] >= "00:00:00" &&  $row[4] <= "23:59:59")
            {
                if(gettype($row[5]) == gettype($row[6]))
                {
                    return new Consumption([
                        'abonne_id' => $row[2],
                        'date_consumption' => date('Y-m-d', strtotime(str_replace('/', '-', $row[3]))),
                        'time_consumption' => $row[4],
                        'duration_real_consumption' => $row[5],
                        'duration_invoiced_consumption' => $row[6],
                        'type_consumption' => $row[7],
                    ]);
                }
                else
                {
                    $data = ['message' => $row[2] . ';' . $row[3] . ';' . $row[4] . ';' . $row[5] . ';' . $row[6] . ';' . $row[7]  , 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')];
                }
            }
            else
            {
                $data = ['message' => $row[2] . ';' . $row[3] . ';' . $row[4] . ';' . $row[5] . ';' . $row[6] . ';' . $row[7] , 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')];
            }
        }
        else
        {
            $data = ['message' => $row[2] . ';' . $row[3] . ';' . $row[4] . ';' . $row[5] . ';' . $row[6] . ';' . $row[7] , 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')];
        }

        //Insert error in table Trace
        Trace::insert($data);
    }
}
