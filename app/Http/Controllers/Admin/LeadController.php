<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Lead;
use App\Models\LeadItem;
use App\Models\LeadFile;
use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class LeadController extends Controller
{
    /**
     * Display a listing of leads.
     */
    public function index()
    {
        $leads = Lead::orderBy('id', 'desc')->get();
        $customers = Customer::orderBy('name')->get();

        return view('admin.leads.index', compact('leads', 'customers'));
    }

    public function create()
    {
        $customers = Customer::orderBy('name')->get();

        return view('admin.leads.create', compact('customers'));
    }

    /**
     * Store a newly created lead.
     */
    public function store(Request $request)
    {
        $request->validate([
            'customer_id' => 'required|exists:customers,id',
            'title'       => 'nullable|string|max:255',
            'description' => 'nullable|string',

            // Validasi item
            'items.*.item_name' => 'required|string|max:255',
            'items.*.qty'       => 'required|integer|min:1',
            'items.*.notes'     => 'nullable|string',

            // Validasi file
            'files.*' => 'nullable|file|max:20480', // 20MB
        ]);

        // Generate CODE Lead, misal: LD-20250101-0001
        $code = 'LD-' . now()->format('Ymd') . '-' . (Lead::count() + 1);

        // Buat lead
        $lead = Lead::create([
            'code'        => $code,
            'customer_id' => $request->customer_id,
            'title'       => $request->title,
            'description' => $request->description,
        ]);

        /**
         * INSERT ITEMS
         */
        if ($request->items) {
            foreach ($request->items as $item) {
                LeadItem::create([
                    'lead_id'   => $lead->id,
                    'item_name' => $item['item_name'],
                    'qty'       => $item['qty'],
                    'notes'     => $item['notes'] ?? null,
                    'status'    => 'waiting', // default
                ]);
            }
        }

        /**
         * INSERT FILES
         */
        if ($request->hasFile('files')) {
            foreach ($request->file('files') as $file) {

                // Simpan ke storage private (disk local)
                $path = $file->store('leads', 'local');

                LeadFile::create([
                    'lead_id'       => $lead->id,
                    'original_name' => $file->getClientOriginalName(),
                    'filename'      => basename($path),
                    'path'          => $path,
                    'disk'          => 'local',
                    'mime_type'     => $file->getClientMimeType(),
                    'size'          => $file->getSize(),
                    'type'          => str_contains($file->getMimeType(), 'image')
                                        ? 'image'
                                        : 'document',
                ]);
            }
        }

        return redirect()->back()->with('success', 'Lead created successfully!');
    }

    public function show($id)
    {
        $lead = Lead::with(['customer', 'items', 'files'])->findOrFail($id);

        return view('admin.leads.show', compact('lead'));
    }

    public function edit($id)
    {
        $lead = Lead::with(['customer', 'items', 'files'])->findOrFail($id);
        $customers = Customer::orderBy('name')->get();

        return view('admin.leads.edit', compact('lead', 'customers'));
    }
    /**
     * Update an existing lead.
     */
    public function update(Request $request, $id)
    {
        $lead = Lead::findOrFail($id);

        $request->validate([
            'customer_id' => 'required|exists:customers,id',
            'title'       => 'nullable|string|max:255',
            'description' => 'nullable|string',

            'items.*.id'        => 'nullable|exists:lead_items,id',
            'items.*.item_name' => 'required|string|max:255',
            'items.*.qty'       => 'required|integer|min:1',
            'items.*.notes'     => 'nullable|string',

            'files.*' => 'nullable|file|max:20480',
        ]);

        // Update lead utama
        $lead->update([
            'customer_id' => $request->customer_id,
            'title'       => $request->title,
            'description' => $request->description,
        ]);

        /**
         * UPDATE OR CREATE ITEMS
         */
        if ($request->items) {
            foreach ($request->items as $item) {

                if (isset($item['id'])) {
                    // update item
                    LeadItem::where('id', $item['id'])->update([
                        'item_name' => $item['item_name'],
                        'qty'       => $item['qty'],
                        'notes'     => $item['notes'] ?? null,
                    ]);

                } else {
                    // create new item
                    LeadItem::create([
                        'lead_id'   => $lead->id,
                        'item_name' => $item['item_name'],
                        'qty'       => $item['qty'],
                        'notes'     => $item['notes'] ?? null,
                        'status'    => 'waiting',
                    ]);
                }
            }
        }

        /**
         * NEW FILE UPLOADS
         */
        if ($request->hasFile('files')) {
            foreach ($request->file('files') as $file) {
                $path = $file->store('leads', 'local');

                LeadFile::create([
                    'lead_id'       => $lead->id,
                    'original_name' => $file->getClientOriginalName(),
                    'filename'      => basename($path),
                    'path'          => $path,
                    'disk'          => 'local',
                    'mime_type'     => $file->getClientMimeType(),
                    'size'          => $file->getSize(),
                    'type'          => str_contains($file->getMimeType(), 'image')
                                        ? 'image'
                                        : 'document',
                ]);
            }
        }

        return redirect()->back()->with('success', 'Lead updated successfully!');
    }

    /**
     * Remove the specified lead.
     */
    public function destroy($id)
    {
        $lead = Lead::findOrFail($id);

        // Hapus semua filenya dari storage
        foreach ($lead->files as $file) {
            Storage::disk($file->disk)->delete($file->path);
            $file->delete();
        }

        // Soft delete lead (file tetap ke-delete di atas)
        $lead->delete();

        return redirect()->back()->with('success', 'Lead deleted successfully!');
    }
}
