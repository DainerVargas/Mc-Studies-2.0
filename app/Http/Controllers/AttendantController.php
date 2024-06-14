<?php

namespace App\Http\Controllers;

use App\Http\Requests\RegistroRequest;
use App\Models\Apprentice;
use App\Models\Attendant;
use App\Models\Group;
use App\Models\History;
use App\Models\Informe;
use App\Models\Modality;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Livewire\WithFileUploads;

class AttendantController extends Controller
{
  use WithFileUploads;

  public function viewUpdate(Apprentice $aprendiz)
  {
    $user = Auth::user();
    return view('layouts.update', compact('user', 'aprendiz'));
  }

  public function update(RegistroRequest $request, Apprentice $aprendiz)
  {

    if (isset($request->imagen)) {
      $path = $request->imagen->store('/');
      $foto = basename($path);
    } else {
      $foto = $aprendiz->imagen;
    }

    $grupoID = $aprendiz->group_id;

    if ($request->modality_id != $aprendiz->modality_id) {

      $informe = Informe::where('apprentice_id', $aprendiz->id)->first();
      $informe->update([
        'abono' => 0,
        'fecha' => null
      ]);
    }

    $acudiente = Attendant::where('id', $aprendiz->attendant_id)->first();

    $acudiente->update([
      'name' => $request->nameAcudiente,
      'apellido' => $request->apellidoAcudiente,
      'email' => $request->email,
      'telefono' => $request->telefono,
    ]);

    $grupo = Group::find($request->group_id);
    $aprendiz->update([
      'name' => $request->name,
      'apellido' => $request->apellido,
      'edad' => $request->edad,
      'imagen' => $foto,
      'comprobante' => $aprendiz->comprobante,
      'fecha_nacimiento' => $request->fecha_nacimiento,
      'modality_id' => $request->modality_id,
      'group_id' => $request->group_id,
    ]);

    if (isset($request->group_id) && $grupoID == null) {
      if (isset($grupo->name)) {

        $year = Carbon::now()->format('y');
        /* $year = 25; */
        $mes = Carbon::now()->format('m');
        /* $mes = 8; */
        $history = History::where('name', $grupo->name)
          ->where('year', $year)
          ->first();
        $contador = History::where('name', $grupo->name)->count();

        if ($history) {
          if ($mes <= 6) {

            $history->cantidad += 1;
            $history->save();
          } else {

            $search = History::where('name', $grupo->name)->get();
            if ($contador > 1) {

              $updateHistory = $search[1];
              $updateHistory->cantidad += 1;
              $updateHistory->save();
            } else {

              $historial = new History();
              $historial->name = $grupo->name;
              $historial->year = $year;
              $historial->mes = $mes;
              $historial->cantidad = 1;
              $historial->total = $history->cantidad;
              $historial->save();
            }
          }
        }
      }
    }

    return back()->withErrors([
      'message' => 'Se actualizaron los datos correctamente',
    ]);
  }
}
