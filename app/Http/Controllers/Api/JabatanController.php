<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Jabatan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

class JabatanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = Jabatan::orderBy('nama_jabatan', 'asc')->get();
        return response()->json([
            'status' => true,
            'message' => 'Data ditemukan',
            'data' => $data
        ], 200);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $data = Jabatan::where('id', $id)->first();
        
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
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $datajabatan = new Jabatan;

        $rules =[
            'nama_jabatan' => 'required',
            'tunjangan'=> 'required',
            'gaji'=> 'required'
        ];
        $validator = Validator::make($request->all(), $rules);
        if($validator->fails()) {
            return response()->json([
                'status'=>false,
                'message'=> 'gagal memasukan data',
                'data'=> $validator->errors()
            ]);
        }

        $datajabatan->nama_jabatan = $request->nama_jabatan;
        $datajabatan->tunjangan = $request->tunjangan;
        $datajabatan->gaji = $request->gaji;

        $post = $datajabatan->save();

        return response()->json([
            'status'=> true,
            'message'=> 'Sukses memasukan'  
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    
     public function update(Request $request, string $id)
{
    // Menggunakan 'id' di sini, bukan 'id_jabatan'
    $datajabatan = Jabatan::where('id', $id)->first();

    if (!$datajabatan) {
        return response()->json([
            'status' => false,
            'message' => 'Data tidak ditemukan'
        ], 404);
    }

    // Validasi input (gunakan 'sometimes' untuk setiap kolom agar tidak wajib diisi semua)
    $rules = [
        'nama_jabatan' => 'sometimes|required|string',
        'tunjangan' => 'sometimes|required|numeric',
        'gaji' => 'sometimes|required|numeric',
    ];
    $validator = Validator::make($request->all(), $rules);

    if ($validator->fails()) {
        return response()->json([
            'status' => false,
            'message' => 'Gagal melakukan update data',
            'data' => $validator->errors()
        ]);
    }

    // Flag untuk menandakan apakah ada perubahan data
    $updated = false;

    // Update data jabatan hanya jika kolom ada di request
    if ($request->has('nama_jabatan')) {
        $datajabatan->nama_jabatan = $request->nama_jabatan;
        $updated = true; // Menandakan ada perubahan
    }

    if ($request->has('tunjangan')) {
        $datajabatan->tunjangan = $request->tunjangan;
        $updated = true; // Menandakan ada perubahan
    }

    if ($request->has('gaji')) {
        $datajabatan->gaji = $request->gaji;
        $updated = true; // Menandakan ada perubahan
    }

    // Jika ada perubahan, simpan perubahan
    if ($updated) {
        $datajabatan->save();
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
         // Mencari data jabatan berdasarkan id
         $datajabatan = Jabatan::where('id', $id)->first();
     
         if (!$datajabatan) {
             return response()->json([
                 'status' => false,
                 'message' => 'Data tidak ditemukan'
             ], 404);
         }
     
         // Menghapus data jabatan
         $datajabatan->delete();
     
         // Update ID jabatan yang lebih besar dari id yang dihapus
         $affectedRows = Jabatan::where('id', '>', $id)
                                 ->orderBy('id')
                                 ->get();
     
         foreach ($affectedRows as $row) {
             // Mengubah ID ke satu angka lebih kecil
             $row->id = $row->id - 1;
             $row->save();
         }
     
         // Reset Auto Increment untuk ID berikutnya
         $maxId = DB::table('jabatan')->max('id');
         if ($maxId) {
             // Mengatur Auto Increment ke ID yang terakhir
             DB::statement('ALTER TABLE jabatan AUTO_INCREMENT = ' . ($maxId + 1));
         } else {
             DB::statement('ALTER TABLE jabatan AUTO_INCREMENT = 1');
         }
     
         return response()->json([
             'status' => true,
             'message' => 'Sukses melakukan Delete Data dan update ID'
         ]);
     }
     
     

}
