<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\ListhargaImport;
use App\Listharga;
use Validator;

class ListHargaController extends Controller
{

public function importxl(Request $request){
     $validator = Validator::make($request->all(),
               [
                 'file' => 'required'
               ]);
           $messages = $validator->messages();
           if($validator->fails()){
              $request['code'] = 204;
              $request['message'] = "Kamu belum memilih file untuk melakukan import";
              echo json_encode($request);
           }else{
             if ($request->hasFile('file')) {
                 $file = $request->file('file');
                 $cekproduk = Listharga::count();
                 if ($cekproduk > 0) {
                     $data = Excel::toArray(new ListhargaImport, $file);
                     collect(head($data))->each(function ($row, $key) {
                             $cekkode = Listharga::where('kodeproduk',  $row[0])->count();
                             if ($cekkode > 0) {
                                 Listharga::where('kodeproduk',  $row[0])->update([
                                   'kodeproduk' => $row[0],
                                   'judul' => $row[1],
                                   'kategori' => str_replace("/","",$row[2]),
                                   'harga' => str_replace(".","",$row[3]),
                                   'status' => $row[4],
                                 ]);
                             }else {
                                 Listharga::create([
                                   'kodeproduk' => $row[0],
                                   'judul' => $row[1],
                                   'kategori' => str_replace("/","",$row[2]),
                                   'harga' => str_replace(".","",$row[3]),
                                   'status' => $row[4],
                                 ]);
                             }

                     });
                     $response['code'] = 200;
                     $response['message'] = "Berhasil update data";
                 }else {
                   Excel::import(new ListhargaImport, $file); //IMPORT FILE
                   $response['code'] = 200;
                   $response['message'] = "Berhasil import data";
                 }
                 return response()->json($response);
               }
           }

   }
}
