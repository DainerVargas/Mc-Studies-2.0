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
      $path = $request->imagen->store('', 'public');
      $foto = basename($path);
    } else {
      $foto = $aprendiz->imagen;
    }

    $groupId = $aprendiz->group_id;

    $acudiente = Attendant::where('id', $aprendiz->attendant_id)->first();

    $acudiente->update([
      'name' => $request->nameAcudiente,
      'apellido' => $request->apellidoAcudiente,
      'email' => $request->email,
      'telefono' => $request->telefono,
      'documento' => $request->documentoAcudiente,
    ]);

    $aprendiz->update([
      'name' => $request->name,
      'apellido' => $request->apellido,
      'edad' => $request->edad,
      'email' => $request->emailStudent,
      'documento' => $request->documento,
      'telefono' => $request->telefonoStudent,
      'direccion' => $request->direccion,
      'level_id' => $request->nivel_id,
      'becado_id' => $request->becado_id,
      'imagen' => $foto,
      'comprobante' => $aprendiz->comprobante,
      'fecha_nacimiento' => $request->fecha_nacimiento,
      'modality_id' => $request->modality_id,
      'group_id' => $request->group_id,
    ]);

    $grupo = Group::find($request->group_id);

    if (isset($request->group_id) && $groupId == null) {
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

            $search = History::where('name', $grupo->name)
              ->where('year', $year)
              ->get();

            if ($contador > 1) {
              $updateHistory = $search[1];
              $updateHistory->cantidad += 1;
              $updateHistory->save();
            } else {
              History::create([
                'name' => $grupo->name,
                'year' => $year,
                'mes' => $mes,
                'cantidad' => 1,
                'total' => $history->cantidad
              ]);
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
