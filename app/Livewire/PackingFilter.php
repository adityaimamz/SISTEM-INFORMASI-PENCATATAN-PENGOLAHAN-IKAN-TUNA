<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Packing;
use App\Models\Service;
use App\Models\StokCS;
use Illuminate\Support\Carbon;

class PackingFilter extends Component
{
    public $services;
    public $data;
    public $selectedDate;

    // Properties for editing
    public $edit_id;
    public $edit_no_box;
    public $edit_kode_trace_id;
    public $edit_buyer;
    public $edit_pcs;
    public $edit_berat;
    public $edit_tgl_packing;

    public function mount()
    {
        $this->services = Service::all();
        $this->data = Packing::all();
    }

    public function filterData()
    {
        $this->data = Packing::query()
            ->when($this->selectedDate, function($query) {
                $date = Carbon::parse($this->selectedDate)->format('Y-m-d');
                $query->whereDate('tgl_packing', $date);
            })
            ->get();
    }

    public function loadPackingForEdit($id)
    {
        // Load the selected packing record for editing
        $packing = Packing::findOrFail($id);

        $this->edit_id = $packing->id;
        $this->edit_no_box = $packing->no_box;
        $this->edit_kode_trace_id = $packing->kode_trace_id;
        $this->edit_buyer = $packing->buyer;
        $this->edit_pcs = $packing->pcs;
        $this->edit_berat = $packing->berat;
        $this->edit_tgl_packing = $packing->tgl_packing;
    }

    public function updatePacking()
    {
        // Validate the input fields
        $this->validate([
            'edit_no_box' => 'required|string',
            'edit_kode_trace_id' => 'required|exists:services,id',
            'edit_buyer' => 'required|string',
            'edit_pcs' => 'required|integer|min:1',
            'edit_tgl_packing' => 'required|date',
        ]);

        // Update the packing record in the database
        $packing = Packing::findOrFail($this->edit_id);
        $packing->update([
            'no_box' => $this->edit_no_box,
            'kode_trace_id' => $this->edit_kode_trace_id,
            'buyer' => $this->edit_buyer,
            'pcs' => $this->edit_pcs,
            'berat' => 10,
            'tgl_packing' => $this->edit_tgl_packing,
        ]);

        // Update the corresponding StokCS record
        $stokCS = StokCS::where('id', $this->edit_id)->first();

        if ($stokCS) {
            // Update the StokCS record with the new 'pcs' value
            $stokCS->update([
                'pcs' => $this->edit_pcs,
                'tipe_stok' => 'Stok Masuk',
            ]);
        } else {
            // Create a new StokCS record if it doesn't exist
            StokCS::create([
                'kode_trace_id' => $this->edit_kode_trace_id,
                'pcs' => $this->edit_pcs,
                'tipe_stok' => 'Stok Masuk',
            ]);
        }

        // Refresh data after update
        $this->filterData();

        // Flash success message
        session()->flash('message', 'Packing dan stok berhasil diperbarui.');
    }

    public function delete($id)
    {
        // Delete packing record
        Packing::destroy($id);
        $this->filterData();
    }

    public function render()
    {
        return view('livewire.packing-filter', [
            'data' => $this->data,
            'services' => $this->services,
        ]);
    }
}
