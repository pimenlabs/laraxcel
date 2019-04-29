<?php

namespace App\Imports;

use App\Listharga;
use Maatwebsite\Excel\Concerns\ToModel;

class ListhargaImport implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new Listharga([
          'kodeproduk' => $row[0],
          'judul' => $row[1],
          'kategori' => str_replace("/","",$row[2]),
          'harga' => str_replace(".","",$row[3]),
          'status' => $row[4],
        ]);
    }
}
