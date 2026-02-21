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
	public $active = 1, $viewDescuento = 0, $descuent, $totalDescuento, $totalPendiente = 0, $totalModulos, $observaciones = [], $viewplataforma = 0, $fechaPlataforma, $modulo, $metodo, $totalAbono = 0;
	public $filtro = '';
	public $aprendices, $aprendizArray, $securityInforme;
	public $vista = 0;
	public $year, $module, $month, $nameApprentice = '', $yearCopia, $sede_id = '';
	public $viewObservacion = 0, $currentObservacionId, $currentObservacionText = '';

	public function mount()
	{
		$this->observaciones = Apprentice::pluck('observacion', 'id')->toArray();
		$this->year = Date::now()->year;
		$this->yearCopia = Date::now()->year;
		$this->informes = Informe::whereYear('fechaRegistro', $this->year)->get();
		$this->aprendices = Apprentice::where('estado', true)->get();
		$this->securityInforme = SecurityInforme::get();

		$this->active = session()->get('active');
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
		session()->put('active', $value);
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

	public function donwload()
	{
		session()->put('copiaseguridad', $this->securityInforme);

		return redirect()->route('copiaseguridad');
	}

	public function openObservacion($id)
	{
		$this->viewObservacion = 1;
		$this->resetViews(['viewObservacion']);
		$this->currentObservacionId = $id;
		$this->currentObservacionText = $this->observaciones[$id] ?? '';

		$aprendiz = Apprentice::find($id);
		if ($aprendiz) {
			$this->name = $aprendiz->name . ' ' . $aprendiz->apellido;
		}
	}

	public function saveObservacion()
	{
		$this->validate([
			"currentObservacionText" => 'required'
		], [
			'required' => 'La observación es requerida'
		]);

		$aprendiz = Apprentice::find($this->currentObservacionId);
		if ($aprendiz) {
			$aprendiz->update([
				'observacion' => $this->currentObservacionText
			]);
			$this->observaciones[$this->currentObservacionId] = $this->currentObservacionText;
		}

		$this->viewObservacion = 0;
		$this->currentObservacionText = '';
	}

	public function save(Apprentice $aprendiz)
	{
		$this->validate([
			'abono' => 'required|numeric',
			'metodo' => 'required',
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
						'metodo' => $this->metodo,
						'fecha' => Date::now(),
						'fechaRegistro' => Date::now()->year,
					]);
				} else {
					$informeExistente->update([
						'abono' => $this->abono,
						'metodo' => $this->metodo,
						'fecha' => Date::now(),
					]);
				}

				$this->view = 0;
				$this->abono = '';
				$this->metodo = '';
				$this->message = '';
			} else {
				$this->message = "El abono sobre pasa el valor del modulo";
			}
		} else {
			$this->message = "El abono debe ser mayor a 0";
		}
	}

	/* public function update(Apprentice $aprendiz){

		$this->validate([
			'abono' => 'required|numeric',
		], [
			'required' => 'Este campo es requerido.',
			'numeric' => 'Escribe el valor sin puntos o coma.'
		]);

		$aprendiz->update([
			'abono'=> $this->abono,
		]);

		$this->view = 0;
		$this->abono = '';
		$this->message = '';
	} */

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

		$this->securityInforme = SecurityInforme::get();
		$this->aprendices = Apprentice::where('estado', true)->get();
	}

	public function render()
	{
		$query = Apprentice::query()
			->where('estado', 1)
			->with(['attendant', 'modality', 'becado', 'informe' => function ($q) {
				$q->where('fechaRegistro', $this->year);
				if (!empty($this->mes) && $this->mes != '00') {
					$q->whereMonth('fecha', intval($this->mes));
				}
			}]);

		// Filter: Sede
		if (!empty($this->sede_id)) {
			$query->where('sede_id', $this->sede_id);
		}

		// Filter: Modulo
		if (!empty($this->modulo)) {
			$query->whereHas('informe', function ($q) { // Check this logic. Was based on apprentice start date?
				// Previous code:
				// if ($this->modulo == '1') { $subQuery->where(function ($query) { $query->whereMonth('fecha_inicio', '<=', 6); }); }
				// Ah, the previous code filtered APPRENTICE based on 'fecha_inicio'.
				// Replicating:
			});
			// Re-implementing correct logic from previous code:
			if ($this->modulo == '1') {
				$query->whereMonth('fecha_inicio', '<=', 6);
			} elseif ($this->modulo == '2') {
				$query->whereMonth('fecha_inicio', '>=', 7);
			}
		}

		// Filter: Search (Filtro)
		if (!empty($this->filtro)) {
			$words = preg_split('/\s+/', strtolower(trim($this->filtro)));

			$query->where(function ($q) use ($words) {
				foreach ($words as $word) {

					if (strlen($word) <= 3) {
						continue;
					}

					$term = '%' . $word . '%';

					$q->orWhere(function ($subQ) use ($term) {
						$subQ->where('name', 'LIKE', $term)
							->orWhere('apellido', 'LIKE', $term);
					});
				}
			});
		}

		// Get Apprentices
		$apprentices = $query->get();

		// Process each apprentice to add calculated fields
		$apprentices->each(function ($apprentice) {
			$apprentice->total_abonos = $apprentice->informe->sum('abono');
			// Latest informe for Edit button and Date display
			$latest = $apprentice->informe->sortByDesc('fecha')->first();
			$apprentice->latest_informe_id = $latest ? $latest->id : null;
			$apprentice->latest_fecha = $latest ? $latest->fecha : null;
		});

		// Filter: Estado (Pagado vs Pendiente)
		if ($this->estado == '1') {
			// PAGADOS
			$apprentices = $apprentices->filter(function ($apprentice) {
				if ($apprentice->becado_id == 1) return true;
				$valor = optional($apprentice->modality)->valor ?? $apprentice->valor ?? 0;
				$descuento = $apprentice->descuento ?? 0;
				$pendiente = $valor - $descuento - $apprentice->total_abonos;
				return $pendiente <= 0;
			});
		} elseif ($this->estado == '2') {
			// PENDIENTES
			$apprentices = $apprentices->filter(function ($apprentice) {
				if ($apprentice->becado_id == 1) return false;
				$valor = optional($apprentice->modality)->valor ?? $apprentice->valor ?? 0;
				$descuento = $apprentice->descuento ?? 0;
				$pendiente = $valor - $descuento - $apprentice->total_abonos;
				return $pendiente > 0;
			});
		}

		// Totals Calculation based on the LIST
		$this->totalModulos = $apprentices->sum(function ($apprentice) {
			if ($apprentice->becado_id == 1) return 0;
			return optional($apprentice->modality)->valor ?? $apprentice->valor ?? 0;
		});

		$this->totalDescuento = $apprentices->sum(function ($apprentice) {
			if ($apprentice->becado_id == 1) return 0;
			return $apprentice->descuento ?? 0;
		});

		$this->totalAbono = $apprentices->sum('total_abonos');

		$this->totalPendiente = $apprentices->sum(function ($apprentice) {
			if ($apprentice->becado_id == 1) return 0;
			$valor = optional($apprentice->modality)->valor ?? $apprentice->valor ?? 0;
			$descuento = $apprentice->descuento ?? 0;
			$abono = $apprentice->total_abonos;
			$p = $valor - $descuento - $abono;
			return $p > 0 ? $p : 0;
		});

		$this->securityInformes();

		return view('livewire.informe-estudiante', [
			'estudiantes' => $apprentices
		]);
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
		$views = ['view', 'vista', 'viewDescuento', 'viewplataforma', 'viewObservacion'];
		foreach ($views as $view) {
			if (!in_array($view, $exceptions)) {
				$this->$view = 0;
			}
		}
	}
}
