<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Karyawan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
class KaryawanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = Karyawan::orderBy('id_karyawan','asc')->get();
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
        $datakaryawan = new Karyawan;

        $rules =[
            'nama_karyawan' => 'required',
            'id_jabatan'=> 'required',
            'gaji_pokok'=> 'required',
            'status_karyawan'=>'required',
            'alamat_karyawan'=>'required',
            'no_telepon'=> 'required'
        ];

        $validator = Validator::make($request->all(), $rules);
        if($validator->fails()) {
            return response()->json([
                'status'=>false,
                'message'=> 'gagal memasukan data',
                'data'=> $validator->errors()
            ]);
        }

        $datakaryawan->nama_karyawan = $request->nama_karyawan;
        $datakaryawan->id_jabatan = $request->id_jabatan;
        $datakaryawan->gaji_pokok = $request->gaji_pokok;
        $datakaryawan->status_karyawan = $request->status_karyawan;
        $datakaryawan->alamat_karyawan = $request->alamat_karyawan;
        $datakaryawan->no_telepon = $request->no_telepon;
        

        $post = $datakaryawan->save();

        return response()->json([
            'status'=> true,
            'message'=> 'Sukses memasukan'  
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function update(Request $request, string $id)
    {
        // Mencari data karyawan berdasarkan ID
        $datakaryawan = Karyawan::find($id);
    
        // Cek jika data karyawan tidak ditemukan
        if (!$datakaryawan) {
            return response()->json([
                'status' => false,
                'message' => 'Data tidak ditemukan'
            ], 404);
        }
    
        // Validasi hanya untuk kolom yang ingin diubah
        $rules = [
            'nama_karyawan' =>'nullable|sometimes|required|string',
            'id_jabatan' => 'nullable|sometimes|required',
            'gaji_pokok' => 'nullable|sometimes|required|numeric',
            'status_karyawan' => 'nullable|sometimes|required',
            'alamat_karyawan' => 'nullable|sometimes|required',
            'no_telepon' => 'nullable|sometimes|required',
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
        if ($request->has('nama_karyawan')) {
            $datakaryawan->nama_karyawan= $request->nama_karyawan;
            $updated = true;  // Menandakan ada perubahan
        }
        
        if ($request->has('id_jabatan')) {
            $datakaryawan->id_jabatan = $request->id_jabatan;
            $updated = true;  // Menandakan ada perubahan
        }
    
    
        if ($request->has('gaji_pokok')) {
            $datakaryawan->gaji_pokok = $request->gaji_pokok;
            $updated = true;  // Menandakan ada perubahan
        }
    
        if ($request->has('status_karyawan')) {
            $datakaryawan->status_karyawan = $request->status_karyawan;
            $updated = true;  // Menandakan ada perubahan
        }
    
        if ($request->has('alamat_karyawan')) {
            $datakaryawan->alamat_karyawan = $request->alamat_karyawan;
            $updated = true;  // Menandakan ada perubahan
        }
    
        if ($request->has('no_telepon')) {
            $datakaryawan->no_telepon = $request->no_telepon;
            $updated = true;  // Menandakan ada perubahan
        }
    
        // Jika ada perubahan, simpan data yang sudah diperbarui
        if ($updated) {
            $datakaryawan->save();
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
         // Mencari data karyawan berdasarkan ID
         $datakaryawan = Karyawan::find($id);
     
         // Cek jika data karyawan tidak ditemukan
         if (!$datakaryawan) {
             return response()->json([
                 'status' => false,
                 'message' => 'Data tidak ditemukan'
             ], 404);
         }
     
         // Menghapus data karyawan
         $datakaryawan->delete();
     
         // Update ID dari data yang lebih tinggi
         $higherIds = DB::table('karyawan')
             ->where('id_karyawan', '>', $id)
             ->get();
     
         // Menggeser ID yang lebih tinggi
         foreach ($higherIds as $item) {
             DB::table('karyawan')
                 ->where('id_karyawan', $item->id_karyawan)
                 ->update(['id_karyawan' => $item->id_karyawan - 1]);
         }
     
         // Reset Auto Increment
         $maxId = DB::table('karyawan')->max('id_karyawan');
         if ($maxId) {
             DB::statement('ALTER TABLE karyawan AUTO_INCREMENT = ' . ($maxId + 1));
         } else {
             DB::statement('ALTER TABLE karyawan AUTO_INCREMENT = 1');
         }
     
         return response()->json([
             'status' => true,
             'message' => 'Sukses melakukan Delete Data dan menggeser ID'
         ]);
     }
     

}
