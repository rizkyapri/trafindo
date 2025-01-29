<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\AndonNo;
use Illuminate\Http\Request;

class AndonController extends Controller
{
    public function index()
    {
        $andon = AndonNo::all();

        return response()->json([
            'success' => true,
            'message' => 'Daftar data produk',
            'dataAndon' => $andon,
        ], 200);
    }
    public function sortByWorkcenter($workcenter)
    {
        // $workcenter = $request->input('workcenter'); // Mendapatkan nilai 'workcenter' dari permintaan

        $andon = AndonNo::join('tblAndonCat', 'tblAndonNo.CodeAndon', '=', 'tblAndonCat.CodeAndon')
            ->where('tblAndonNo.Workcenter', $workcenter)
            ->select('tblAndonNo.*', 'tblAndonCat.*')
            ->orderBy('tblAndonNo.Workcenter') // Mengurutkan berdasarkan kolom 'Workcenter'
            ->orderByRaw("CASE WHEN tblAndonNo.Andon_Color = 'Yellow' THEN 0 ELSE 1 END")
            ->orderBy('tblAndonNo.Andon_Color') // Mengurutkan berdasarkan kolom 'Andon_Color'
            ->get();


        if ($andon->count() > 0) {

            return response()->json([
                'success' => true,
                'message' => 'Detail data Andon',
                'dataAndon' => $andon,
            ], 200);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Data tidak ditemukan',
                'data' => null
            ], 404);
        }
    }
}
