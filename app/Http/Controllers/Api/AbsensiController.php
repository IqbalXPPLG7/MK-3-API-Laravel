<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Absensi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

class AbsensiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = Absensi::orderBy('id','asc')->get();
        return response()->json([
            'status'=>true,
            'message'=>'Data di Temukan',
            'data'=>$data
        ],200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $dataabsen = new Absensi;

        $rules = [
            'karyawan_id'=> 'required',
            'tanggal' => 'required',
            'status'=> 'required',
        ];

        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Gagal memasukan data',
                'data' => $validator->errors()
            ]);
        }

        // Menyimpan data
        $dataabsen->karyawan_id = $request->karyawan_id;
        $dataabsen->tanggal = $request->tanggal;
        $dataabsen->status = $request->status;

        $dataabsen->save(); // Memanggil method save() untuk menyimpan data

        return response()->json([
            'status' => true,
            'message' => 'Sukses memasukan data'
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        // Mengambil data absensi berdasarkan id
        $data = Absensi::find($id); // Menggunakan find() untuk pencarian berdasarkan 'id'
        
        if ($data) {
            return response()->json([
                'status' => true,
                'message' => 'Data ditemukan',
                'data' => $data
            ], 200);
        } else {
            return response()->json([
                'status' => false,
                'message' => 'Data tidak ditemukan',
            ], 404);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        // Mengambil data absensi berdasarkan id
        $dataabsen = Absensi::find($id); // Menggunakan find() untuk pencarian berdasarkan 'id'
        
        if (!$dataabsen) {
            return response()->json([
                'status' => false,
                'message' => 'Data tidak ditemukan'
            ], 404);
        }
    
        // Validasi input dengan aturan nullable dan sometimes agar tidak wajib jika kosong
        $rules = [
            'karyawan_id' =>'nullable|sometimes|required|integer',
            'tanggal' => 'nullable|sometimes|required|date',
            'status' => 'nullable|sometimes|required|string'
        ];
    
        $validator = Validator::make($request->all(), $rules);
    
        // Jika validasi gagal
        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Gagal melakukan update data',
                'data' => $validator->errors()
            ]);
        }
    
        // Flag untuk mengetahui apakah ada perubahan
        $updated = false;
    
        // Update hanya kolom yang ada di request
        if ($request->has('karyawan_id')) {
            $dataabsen->karyawan_id = $request->karyawan_id;
            $updated = true;  // Menandakan ada perubahan
        }

        if ($request->has('tanggal')) {
            $dataabsen->tanggal = $request->tanggal;
            $updated = true;  // Menandakan ada perubahan
        }
    
        if ($request->has('status')) {
            $dataabsen->status = $request->status;
            $updated = true;  // Menandakan ada perubahan
        }
    
        // Jika ada perubahan, simpan data yang sudah diperbarui
        if ($updated) {
            $dataabsen->save();
            return response()->json([
                'status' => true,
                'message' => 'Sukses melakukan update data'
            ]);
        } else {
            // Jika tidak ada perubahan
            return response()->json([
                'status' => false,
                'message' => 'Tidak ada data yang diubah'
            ]);
        }
    }
    
    /**
     * Remove the specified resource from storage.
     */
    
     public function destroy(string $id)
     {
         $dataabsen = Absensi::find($id); // Menggunakan find() untuk pencarian berdasarkan 'id'
         
         if (!$dataabsen) {
             return response()->json([
                 'status' => false,
                 'message' => 'Data tidak ditemukan'
             ], 404);
         }
         
         // Menghapus data absensi
         $dataabsen->delete();
     
         // Update ID absensi yang lebih besar dari id yang dihapus
         $affectedRows = Absensi::where('id', '>', $id)
                                 ->orderBy('id')
                                 ->get();
     
         foreach ($affectedRows as $row) {
             // Mengubah ID ke satu angka lebih kecil
             $row->id = $row->id - 1;
             $row->save();
         }
     
         // Reset Auto Increment untuk ID berikutnya
         $maxId = DB::table('absensi')->max('id');
         if ($maxId) {
             // Mengatur Auto Increment ke ID yang terakhir
             DB::statement('ALTER TABLE absensi AUTO_INCREMENT = ' . ($maxId + 1));
         } else {
             DB::statement('ALTER TABLE absensi AUTO_INCREMENT = 1');
         }
     
         return response()->json([
             'status' => true,
             'message'=> 'Sukses melakukan delete data dan update ID'
         ]);
     }
     
}

