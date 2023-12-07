<?php

namespace App\Imports;

use App\Models\User;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithStartRow;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Concerns\SkipsEmptyRows;

class UsersImport implements ToModel, WithStartRow, SkipsEmptyRows
{
    //use Importable, SkipsFailures;
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public $missedRows = [];
    public function startRow(): int
    {
        return 2;
    }
    public function model(array $row)
    {
        $exists = User::where(function ($q) use ($row) {
            $q->where('mobile', $row[1])
                ->orWhere('email', $row[3]);
        })->first();

        if($row[0]=='' || $row[1]=='' || $row[3]==''){
            $row['error'] = 'Name / Email Id / Mobile no is missing..';
            $this->missedRows[] = $row;
            return null;
        }

        if ($exists) {
            $row['error'] = 'Mobile No. / Email Id already exists..';
            $this->missedRows[] = $row;
            //LOGIC HERE TO UPDATE
            return null;
        }


        $user= User::create([
            'name'     => $row[0],
            'mobile'    => $row[1],
            'dob'    => $this->convertExcelDate($row[2]),
            'email'    => $row[3],
            'password' => Hash::make($row[1]),
           //'password' => $request->password,
        ]);
        $userCount=str_pad($user->id,5,"0",STR_PAD_LEFT);
        $userCount="GD".date('Y').$userCount;
        $user->user_id=$userCount;
        $user->save();
        return $user;
    }
    function convertExcelDate($excel_date)
    {
        $excel_date = (int) $excel_date;
        $unix_date = ($excel_date - 25569) * 86400;
        $excel_date = 25569 + ($unix_date / 86400);
        $unix_date = ($excel_date - 25569) * 86400;
        return gmdate("Y-m-d", $unix_date);
    }
}
