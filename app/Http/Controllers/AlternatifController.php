<?php

namespace App\Http\Controllers;

use Validator;
use App\Models\Kriteria;
use App\Models\Alternatif;
use Illuminate\Http\Request;
use App\Models\Bobot_Alternatif;

class AlternatifController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
      return view('template.data_alternatif',['data_alternatif'=>Alternatif::all()]);
    }
        // return Kriteria::all();
        // foreach (Kriteria::orderBy('id')->get() as $key => $value) {
        //   echo $value->id."<br>";
        // }
        //
        // foreach (Bobot_Alternatif::orderBy('alternatif_id')->orderBy('kriteria_id')->get() as $key => $v) {
        //   $hasil[$v->alternatif_id][$v->kriteria_id] = ['id'=>$v->id,'nilai'=>$v->nilai];
        // }
        //
        // foreach ($hasil as $k => $v) {
        //   foreach ($v as $i => $u) {
        //     echo $u['nilai']."<br>";
        //   }
        // }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return redirect('/data_kriteria')->with('Gagal', 'Data Bobot Alternatif Masih Kosong');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
      $validator = Validator::make($request->all(), [
            'nama' => 'required|unique:alternatifs|max:255',
        ]);

        if ($validator->fails()) {
            return redirect('/data_alternatif')->with('Gagal', 'Data Alternatif Gagal Ditambahkan.');
        }

        if(Alternatif::insert(['nama'=>$request->nama])){
          $alternatif = Alternatif::where(['nama'=>$request->nama])->first();
          foreach (Kriteria::all() as $k => $v) {
            Bobot_Alternatif::insert(['alternatif_id'=>$alternatif->id,'kriteria_id'=>$v->id,'nilai'=>0]);
          }
          return redirect('/data_alternatif')->with('Berhasil', 'Data Alternatif Berhasil Ditambahkan.');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return redirect('/data_kriteria')->with('Gagal', 'Data Bobot Alternatif Masih Kosong');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        return redirect('/data_kriteria')->with('Gagal', 'Data Bobot Alternatif Masih Kosong');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $r, $id)
    {
      $validator = Validator::make($r->all(), [
            'nama' => 'required|max:255',
                                              ]);

        if ($validator->fails()) {
          return redirect('/data_alternatif')->with('Gagal', 'Data Kriteria Gagal DiEdit.');
        }

      if(Alternatif::where(['id'=>$id])->update(['nama'=>$r->nama,])){
        return redirect('/data_alternatif')->with('Berhasil', 'Data Alternatif Berhasil DiEdit.');
      }

      return redirect('/data_alternatif')->with('Gagal', 'Data Alternatif Gagal DiEdit.');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
      Alternatif::find($id)->Bobot_Alternatif()->delete();

      if(Alternatif::where(['id'=>$id])->delete()){
        return redirect('/data_alternatif')->with('Berhasil', 'Data Alternatif Berhasil Dihapus.');
      }

      return redirect('/data_alternatif')->with('Gagal', 'Data Alternatif Gagal Dihapus.');
    }
}
