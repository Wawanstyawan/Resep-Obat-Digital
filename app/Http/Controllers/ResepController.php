<?php

namespace App\Http\Controllers;

use App\Models\Obat;
use App\Models\Resep;
use App\Models\ResepDetail;
use App\Models\Signa;
use Barryvdh\DomPDF\PDF;
use Dompdf\Dompdf;
use Dompdf\Options;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ResepController extends Controller
{
    public function create()
    {
        $obats = Obat::all();
        $signas = Signa::all();
        return view('reseps.create', compact('obats', 'signas'));
    }

    public function store(Request $request)
    {
        try {
            DB::beginTransaction();
    
            $resep = Resep::create([
                'user_id' => auth()->id(),
                'nama_racikan' => $request->input('nama_racikan')
            ]);
    
            foreach ($request->input('details') as $detail) {
                foreach ($detail['obat_id'] as $index => $obat_id) {
                    $qty = $detail['qty'][$index];
                    $obat = Obat::find($obat_id);
    
                    if ($obat->stok < $qty) {
                        throw new \Exception('Stok tidak mencukupi untuk obat ' . $obat->obatalkes_nama);
                    }
    
                    ResepDetail::create([
                        'resep_id' => $resep->id,
                        'obatalkes_id' => $obat_id,
                        'signa_id' => $detail['signa_id'],
                        'qty' => $qty
                    ]);
    
                    // Update stok obat
                    $obat->stok -= $qty;
                    $obat->save();
                }
            }
    
            DB::commit();
    
            return redirect()->route('reseps.index')->with('success', 'Resep berhasil disimpan.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withErrors(['msg' => $e->getMessage()]);
        }
    }

    public function index()
    {
        $reseps = Resep::with('details.obat', 'details.signa')->get();
        return view('reseps.index', compact('reseps'));
    }

    public function cetak(Resep $resep)
    {
        $dompdf = new Dompdf();

        $html = view('reseps.cetak', compact('resep'))->render();

        $dompdf->loadHtml($html);

        $options = new Options();
        $options->set('isRemoteEnabled', true); 
        $dompdf->setOptions($options);

        $dompdf->render();

        return $dompdf->stream("resep-{$resep->id}.pdf");
    }
}
