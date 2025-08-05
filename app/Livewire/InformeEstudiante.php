<?php

namespace App\Livewire;

use App\Models\Apprentice;
use App\Models\Informe;
use App\Models\SecurityInforme;
use Carbon\Carbon;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class InformeEstudiante extends Component
{
	public $informes, $info, $view, $name, $idEstudiante, $abono, $message, $message2, $total, $nameF, $fecha, $mes = '00', $estado = 0;
	public $active = 1, $viewDescuento = 0, $descuent, $totalDescuento, $totalPendiente = 0, $totalModulos, $observaciones = [], $viewplataforma = 0, $fechaPlataforma, $modulo;
	public $filtro = '';
	public $aprendices, $aprendizArray, $securityInforme;
	public $vista = 0;
	public $year, $module, $month, $nameApprentice = '', $yearCopia;

	public function mount()
	{
		$this->observaciones = Apprentice::pluck('observacion', 'id')->toArray();
		$this->year = Date::now()->year;
		$this->yearCopia = Date::now()->year;
		$this->informes = Informe::whereYear('fechaRegistro', $this->year)->get();
		$this->aprendices = Apprentice::where('estado', true)->get();
		$this->securityInforme = SecurityInforme::get();
	}

	public function next()
	{
		$this->year += 1;
		$this->yearCopia += 1;
		$this->informes = Informe::whereYear('fechaRegistro', $this->year)->get();
	}
	public function previous()
	{
		$this->year -= 1;
		$this->yearCopia -= 1;
		$this->informes = Informe::whereYear('fechaRegistro', $this->year)->get();
	}

	public function activePlataforma(Apprentice $aprendiz)
	{
		$this->viewplataforma = 1;
		$this->resetViews();
		$this->name = $aprendiz->name . ' ' . $aprendiz->apellido;
		$this->idEstudiante = $aprendiz->id;
		$this->fechaPlataforma = $aprendiz->fechaPlataforma;
	}

	public function savePlataforma(Apprentice $aprendiz)
	{
		if ($this->fechaPlataforma == '') {
			$this->message = 'La fecha es requerida';
			return;
		}

		$aprendiz->fechaPlataforma = $this->fechaPlataforma;
		$aprendiz->save();
		$this->viewplataforma = 0;
	}

	public function activar($value)
	{
		$this->active = $value;
	}

	public function abonar(Apprentice $aprendiz)
	{
		$this->view = 1;
		$this->resetViews(['view']);
		$this->name = $aprendiz->name . ' ' . $aprendiz->apellido;
		$this->idEstudiante = $aprendiz->id;
	}

	public function descuento(Apprentice $aprendiz)
	{
		$this->viewDescuento = 1;
		$this->resetViews(['viewDescuento']);
		$this->aprendizArray = $aprendiz;
		$this->nameF = $this->aprendizArray->name;
		$this->descuent = $this->aprendizArray->descuento;
	}

	public function saveDescuento(Apprentice $aprendiz)
	{
		$this->validate([
			'descuent' => 'required|numeric',
		], [
			'required' => 'Este campo es requerido.',
			'numeric' => 'Escribe el valor sin puntos o coma.'
		]);

		$totalAbono = $aprendiz->informe->sum('abono');
		$valueAprendiz = ($aprendiz->modality_id != 4) ? $aprendiz->modality->valor : $aprendiz->valor;
		$total = $valueAprendiz - $aprendiz->descuento;
		$pendiente = $valueAprendiz - $totalAbono - $this->descuent;

		if ($total != $totalAbono) {
			if ($pendiente < 0) {
				$this->message = "El descuento sobre pasa el valor del modulo";
			} else {
				$aprendiz->descuento = $this->descuent;
				$aprendiz->save();
				$this->viewDescuento = 0;
				$this->message = "";
			}
		} else {
			$this->message = "El estudiante ya ha completado el pago";
		}
	}

	public function ocultar()
	{
		$this->resetViews();
		$this->abono = '';
		$this->message = '';
	}

	public function aumentar(Informe $informe)
	{
		$this->resetViews(['vista']);
		$this->nameF = $informe->apprentice->name;
		$this->fecha = $informe->fecha;
		$this->idEstudiante = $informe->id;
	}

	public function guardar(Informe $informe)
	{
		if ($this->fecha == '') {
			$this->message = 'La fecha es requerida';
			return;
		}

		$informe->fecha = $this->fecha;
		$informe->save();
		$this->vista = 0;
	}

	public function donwload(){
		session()->put('copiaseguridad', $this->securityInforme);

		return redirect()->route('copiaseguridad');
	}

	public function saveObservacion($id)
	{
		$this->validate([
			"observaciones.$id" => 'required'
		]);

		$aprendiz = Apprentice::find($id);
		if ($aprendiz) {
			$aprendiz->update([
				'observacion' => $this->observaciones[$id]
			]);
		}
	}

	public function save(Apprentice $aprendiz)
	{
		$this->validate([
			'abono' => 'required|numeric',
		], [
			'required' => 'Este campo es requerido.',
			'numeric' => 'Escribe el valor sin puntos o coma.'
		]);

		$abonoT = $aprendiz->informe->sum('abono');
		$this->total = $abonoT + $this->abono;

		$totalModulo = ($aprendiz->modality->id == 4) ? $aprendiz->valor : $aprendiz->modality->valor;

		if ($this->abono != 0) {
			if ($this->total <= $totalModulo - $aprendiz->descuento) {
				$informeExistente = $aprendiz->informe->first();

				if ($informeExistente && $informeExistente->abono != 0) {
					Informe::create([
						'apprentice_id' => $aprendiz->id,
						'abono' => $this->abono,
						'fecha' => Date::now(),
						'fechaRegistro' => Date::now()->year,
					]);
				} else {
					$informeExistente->update([
						'abono' => $this->abono,
						'fecha' => Date::now(),
					]);
				}

				$this->view = 0;
				$this->abono = '';
				$this->message = '';
			} else {
				$this->message = "El abono sobre pasa el valor del modulo";
			}
		} else {
			$this->message = "El abono debe ser mayor a 0";
		}
	}

	public function plataforma(Apprentice $aprendiz)
	{
		$aprendiz->plataforma = 140000;
		$aprendiz->save();
		$this->informes = Informe::all();
		$this->aprendices = Apprentice::where('estado', true)->get();
	}

	public function saveInforme()
	{
		$informes = Informe::all();

		foreach ($informes as $informe) {

			if ($informe->apprentice->modality_id != 4) {
				$valorModulo = $informe->apprentice->modality->valor;
			} else {
				$valorModulo = $informe->apprentice->valor;
			}

			SecurityInforme::create([
				'acudiente' => $informe->apprentice->attendant->name,
				'estudiante' => $informe->apprentice->name . ' ' . $informe->apprentice->apellido,
				'becado' => $informe->apprentice->becado->name,
				'valor' => $valorModulo - $informe->apprentice->descuento,
				'descuento' => $informe->apprentice->descuento ?? 0,
				'abono' => $informe->abono ?? 0,
				'pendiente' => $valorModulo - $informe->abono ?? 0 - $informe->apprentice->descuento,
				'plataforma' => $informe->apprentice->plataforma ?? 0,
				'fecha' => $informe->fecha ?? null,
				'comprobante' => $informe->urlImage,
				'observacion' => $informe->apprentice->observacion ?? 'Sin observación',
			]);
		}

		/* $idsToKeep = DB::table('informes')
			->select(DB::raw('MIN(id) as id'))
			->groupBy('apprentice_id')
			->pluck('id');

		DB::table('informes')
			->whereNotIn('id', $idsToKeep)
			->delete();

		DB::table('informes')
			->whereIn('id', $idsToKeep)
			->update([
				'abono' => 0,
				'urlImage' => null,
				'fecha' => null,
				'fechaRegistro' => Date::now()->year,
			]);

		Apprentice::query()->update([
			'observacion' => null,
		]); */

		$this->securityInforme = SecurityInforme::get();
		$this->aprendices = Apprentice::where('estado', true)->get();
	}


	public function render()
	{
		$query = Informe::query()->with('apprentice.attendant', 'apprentice.modality');

		if (!empty($this->modulo)) {
			$query->whereHas('apprentice', function ($subQuery) {
				if ($this->modulo == '1') {
					$subQuery->where(function ($query) {
						$query->whereMonth('fecha_inicio', '<=', 6);
					});
				} elseif ($this->modulo == '2') {
					$subQuery->where(function ($query) {
						$query->whereMonth('fecha_inicio', '>=', 7);
					});
				}
			});
		}

		if (!empty($this->mes) && $this->mes != '00') {
			$query->whereNotNull('fecha')
				->whereMonth('fecha', intval($this->mes));
		}

		$query->where('fechaRegistro', $this->year);

		if (!empty($this->filtro)) {
			$filtro = strtolower($this->filtro);

			$query->whereHas('apprentice', function ($subQuery) use ($filtro) {
				$subQuery->where(function ($query) use ($filtro) {
					$query->whereRaw('LOWER(name) LIKE ?', ['%' . $filtro . '%'])
						->orWhereRaw('LOWER(apellido) LIKE ?', ['%' . $filtro . '%'])
						->orWhereHas('attendant', function ($attendantQuery) use ($filtro) {
							$attendantQuery->whereRaw('LOWER(name) LIKE ?', ['%' . $filtro . '%']);
						});
				});
			});
		}

		$query->whereHas('apprentice', function ($subQuery) {
			$subQuery->where('estado', 1);
		});

		$informesAgrupados = (clone $query)
			->selectRaw('apprentice_id, SUM(abono) as total_abonos')
			->groupBy('apprentice_id')
			->get();

		$this->informes = (clone $query)
			->selectRaw('MIN(id) as id, apprentice_id, MIN(fecha) as fecha')
			->groupBy('apprentice_id')
			->get();

		foreach ($this->informes as $informe) {
			$informe->total_abonos = $informesAgrupados->firstWhere('apprentice_id', $informe->apprentice_id)->total_abonos ?? 0;
		}

		if ($this->estado == '1') {
			$this->informes = $this->informes->filter(function ($informe) {
				$valor = optional($informe->apprentice)->valor ?? 0;
				$descuento = optional($informe->apprentice)->descuento ?? 0;
				$pendiente = $valor - $descuento - $informe->total_abonos;
				return $pendiente <= 0;
			});
		} elseif ($this->estado == '2') {
			$this->informes = $this->informes->filter(function ($informe) {
				$valor = optional($informe->apprentice)->valor ?? 0;
				$descuento = optional($informe->apprentice)->descuento ?? 0;
				$pendiente = $valor - $descuento - $informe->total_abonos;
				return $pendiente > 0;
			});
		}

		$this->totalModulos = $this->informes->sum(function ($informe) {
			$apprentice = optional($informe->apprentice);

			if ($apprentice->becado_id != 1 && $apprentice->estado == 1) {
				return optional($apprentice->modality)->valor ?? $apprentice->valor ?? 0;
			}
			return 0;
		});

		$this->totalDescuento = $this->informes->sum(function ($informe) {
			return optional($informe->apprentice)->becado_id != 1 && optional($informe->apprentice)->estado == 1
				? optional($informe->apprentice)->descuento ?? 0
				: 0;
		});

		$this->totalPendiente = $this->informes->sum(function ($informe) {
			$apprentice = optional($informe->apprentice);

			if ($apprentice->becado_id != 1 && $apprentice->estado == 1) {
				$valor = optional($apprentice->modality)->valor ?? $apprentice->valor ?? 0;
				$descuento = $apprentice->descuento ?? 0;

				return $valor - $descuento - $informe->total_abonos;
			}

			return 0;
		});


		$this->securityInformes();

		return view('livewire.informe-estudiante');
	}


	public function securityInformes()
	{
		$query = SecurityInforme::query();

		if (!empty($this->module)) {

			if ($this->module == '1') {
				$query->whereMonth('fecha', '<=', 6);
			} elseif ($this->module == '2') {
				$query->whereMonth('fecha', '>=', 7);
			}
		}

		if (!empty($this->mes) && $this->mes != '00') {
			$query->whereNotNull('fecha')
				->whereMonth('fecha', intval($this->mes));
		}

		$query->whereYear('fecha', $this->yearCopia);

		if (!empty($this->nameApprentice)) {

			$query->where('estudiante', 'LIKE', '%' . $this->nameApprentice . '%')
				->orwhere('acudiente', 'LIKE', '%' . $this->nameApprentice . '%')
				->orwhere('fecha', 'LIKE', '%' . $this->nameApprentice . '%');
		}

		$this->securityInforme = $query->get();
	}


	private function resetViews($exceptions = [])
	{
		$views = ['view', 'vista', 'viewDescuento', 'viewplataforma'];
		foreach ($views as $view) {
			if (!in_array($view, $exceptions)) {
				$this->$view = 0;
			}
		}
	}
}
