<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Service;
use App\Models\KodeTrace;
use App\Models\Cutting;
use App\Models\Kategori_produk;

class ServiceFilter extends Component
{
    public $kode_traces;
    public $services = [];
    public $kode_trace;
    public $cuttings;
    public $Kategori_produk;

    // Properties for editing
    public $edit_id;
    public $edit_kode_trace;
    public $edit_no_batch_id;
    public $edit_id_ikan;
    public $edit_kg;
    public $edit_pcs;
    public $edit_tgl_service;

    public function mount()
    {
        $this->kode_traces = KodeTrace::all();
        $this->cuttings = Cutting::all();
        $this->Kategori_produk = Kategori_produk::all();
        $this->services = collect();
    }

    public function filterData()
    {
        if ($this->kode_trace) {
            $this->services = Service::where('kode_trace_id', $this->kode_trace)->get();
        } else {
            $this->services = collect();
        }
    }

    public function loadServiceForEdit($id)
    {
        $service = Service::findOrFail($id);
        
        // Load data into the edit properties
        $this->edit_id = $service->id;
        $this->edit_kode_trace = $service->kode_trace_id;
        $this->edit_no_batch_id = $service->no_batch_id;
        $this->edit_id_ikan = $service->id_ikan;
        $this->edit_kg = $service->kg;
        $this->edit_pcs = $service->pcs;
        $this->edit_tgl_service = $service->tgl_service;
    }

    public function updateService()
    {
        // Validate the input
        $this->validate([
            'edit_kode_trace' => 'required|exists:kode_traces,id',
            'edit_no_batch_id' => 'required|exists:no_batches,id',
            'edit_id_ikan' => 'required|exists:kategori_produks,id',
            'edit_kg' => 'required|numeric|min:0',
            'edit_pcs' => 'required|integer|min:0',
            'edit_tgl_service' => 'required|date',
        ]);

        // Update the service record
        $service = Service::findOrFail($this->edit_id);
        $service->update([
            'kode_trace_id' => $this->edit_kode_trace,
            'no_batch_id' => $this->edit_no_batch_id,
            'id_ikan' => $this->edit_id_ikan,
            'kg' => $this->edit_kg,
            'pcs' => $this->edit_pcs,
            'tgl_service' => $this->edit_tgl_service,
        ]);

        // Refresh data after update
        $this->filterData();

        // Flash success message
        session()->flash('message', 'Service updated successfully.');
    }

    public function delete($id)
    {
        Service::destroy($id);
        $this->filterData();
    }

    public function render()
    {
        return view('livewire.service-filter', [
            'services' => $this->services,
            'kode_traces' => $this->kode_traces,
            'cuttings' => $this->cuttings,
            'Kategori_produk' => $this->Kategori_produk,
        ]);
    }
}
