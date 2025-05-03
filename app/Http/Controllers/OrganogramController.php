<?php

namespace App\Http\Controllers;

use App\Models\Division;
use App\Models\Department;
use App\Models\Section;
use App\Imports\OrganogramImport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Facades\Excel;

class OrganogramController extends Controller
{
    public function index()
    {
        $divisions = Division::with(['departments.sections'])->whereNull('deleted_at')->get();
        Log::info('Organogram index accessed', ['user_id' => auth()->id()]);
        return view('organogram.index', compact('divisions'));
    }

    public function create()
    {
        $divisions = Division::all();
        $departments = Department::all();
        Log::info('Organogram create form accessed', ['user_id' => auth()->id()]);
        return view('organogram.create', compact('divisions', 'departments'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'type' => 'required|in:division,department,section',
            'name' => 'required|string|max:255',
            'division_id' => 'required_if:type,department,section|exists:divisions,id',
            'department_id' => 'required_if:type,section|exists:departments,id',
        ]);

        try {
            DB::beginTransaction();

            if ($validated['type'] === 'division') {
                $entity = Division::create([
                    'name' => $validated['name'],
                    'created_by' => auth()->id(),
                ]);
            } elseif ($validated['type'] === 'department') {
                $entity = Department::create([
                    'division_id' => $validated['division_id'],
                    'name' => $validated['name'],
                    'created_by' => auth()->id(),
                ]);
            } else {
                $entity = Section::create([
                    'department_id' => $validated['department_id'],
                    'name' => $validated['name'],
                    'created_by' => auth()->id(),
                ]);
            }

            Log::info('Organogram entity created', [
                'type' => $validated['type'],
                'entity_id' => $entity->id,
                'created_by' => auth()->id(),
            ]);

            DB::commit();
            return redirect()->route('organogram.index')->with('success', ucfirst($validated['type']) . ' created successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Organogram creation failed', [
                'user_id' => auth()->id(),
                'error' => $e->getMessage(),
            ]);
            return redirect()->back()->with('error', 'Failed to create ' . $validated['type'] . ': ' . $e->getMessage());
        }
    }

    public function edit($type, $id)
    {
        $divisions = Division::all();
        $entity = null;

        if ($type === 'division') {
            $entity = Division::findOrFail($id);
        } elseif ($type === 'department') {
            $entity = Department::findOrFail($id);
        } elseif ($type === 'section') {
            $entity = Section::findOrFail($id);
        } else {
            return redirect()->route('organogram.index')->with('error', 'Invalid type specified.');
        }

        $departments = $type === 'section' ? Department::where('division_id', $entity->department->division_id)->get() : Department::all();
        Log::info('Organogram edit form accessed', [
            'type' => $type,
            'entity_id' => $entity->id,
            'accessed_by' => auth()->id(),
        ]);
        return view('organogram.edit', compact('entity', 'type', 'divisions', 'departments'));
    }

    public function update(Request $request, $type, $id)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'division_id' => 'required_if:type,department,section|exists:divisions,id',
            'department_id' => 'required_if:type,section|exists:departments,id',
        ]);

        try {
            DB::beginTransaction();

            $entity = null;
            $changes = [];

            if ($type === 'division') {
                $entity = Division::findOrFail($id);
                if ($entity->name !== $validated['name']) {
                    $changes[] = [
                        'field_name' => 'name',
                        'old_value' => $entity->name,
                        'new_value' => $validated['name'],
                        'changed_by' => auth()->id(),
                    ];
                }
                $entity->update([
                    'name' => $validated['name'],
                    'updated_by' => auth()->id(),
                ]);
            } elseif ($type === 'department') {
                $entity = Department::findOrFail($id);
                if ($entity->name !== $validated['name']) {
                    $changes[] = [
                        'field_name' => 'name',
                        'old_value' => $entity->name,
                        'new_value' => $validated['name'],
                        'changed_by' => auth()->id(),
                    ];
                }
                if ($entity->division_id !== $validated['division_id']) {
                    $changes[] = [
                        'field_name' => 'division_id',
                        'old_value' => $entity->division_id,
                        'new_value' => $validated['division_id'],
                        'changed_by' => auth()->id(),
                    ];
                }
                $entity->update([
                    'name' => $validated['name'],
                    'division_id' => $validated['division_id'],
                    'updated_by' => auth()->id(),
                ]);
            } elseif ($type === 'section') {
                $entity = Section::findOrFail($id);
                if ($entity->name !== $validated['name']) {
                    $changes[] = [
                        'field_name' => 'name',
                        'old_value' => $entity->name,
                        'new_value' => $validated['name'],
                        'changed_by' => auth()->id(),
                    ];
                }
                if ($entity->department_id !== $validated['department_id']) {
                    $changes[] = [
                        'field_name' => 'department_id',
                        'old_value' => $entity->division_id,
                        'new_value' => $validated['department_id'],
                        'changed_by' => auth()->id(),
                    ];
                }
                $entity->update([
                    'name' => $validated['name'],
                    'department_id' => $validated['department_id'],
                    'updated_by' => auth()->id(),
                ]);
            } else {
                throw new \Exception('Invalid type specified.');
            }

            // Record changes
            foreach ($changes as $change) {
                $entity->changes()->create($change);
            }

            Log::info(ucfirst($type) . ' updated', [
                'type' => $type,
                'entity_id' => $entity->id,
                'updated_by' => auth()->id(),
                'changes' => $changes,
            ]);

            DB::commit();
            return redirect()->route('organogram.index')->with('success', ucfirst($type) . ' updated successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error(ucfirst($type) . ' update failed', [
                'type' => $type,
                'entity_id' => $id,
                'user_id' => auth()->id(),
                'error' => $e->getMessage(),
            ]);
            return redirect()->back()->with('error', 'Failed to update ' . $type . ': ' . $e->getMessage());
        }
    }

    public function show($type, $id)
    {
        $entity = null;
        if ($type === 'division') {
            $entity = Division::findOrFail($id);
        } elseif ($type === 'department') {
            $entity = Department::findOrFail($id);
        } elseif ($type === 'section') {
            $entity = Section::findOrFail($id);
        } else {
            return redirect()->route('organogram.index')->with('error', 'Invalid type specified.');
        }

        $changes = $entity->changes()->with('changer')->get();
        Log::info(ucfirst($type) . ' changes viewed', [
            'type' => $type,
            'entity_id' => $entity->id,
            'accessed_by' => auth()->id(),
        ]);
        return view('organogram.show', compact('entity', 'type', 'changes'));
    }

    public function destroy($type, $id)
    {
        $entity = null;

        if ($type === 'division') {
            $entity = Division::findOrFail($id);
        } elseif ($type === 'department') {
            $entity = Department::findOrFail($id);
        } elseif ($type === 'section') {
            $entity = Section::findOrFail($id);
        } else {
            return redirect()->route('organogram.index')->with('error', 'Invalid type specified.');
        }

        // Update the updated_by field to record who deleted the entity
        $entity->updated_by = auth()->id();
        $entity->save();

        $entity->delete();

        Log::info(ucfirst($type) . ' deleted', [
            'type' => $type,
            'entity_id' => $entity->id,
            'deleted_by' => auth()->id(),
        ]);

        return redirect()->route('organogram.index')->with('success', ucfirst($type) . ' deleted successfully.');
    }

    public function uploadForm()
    {
        Log::info('Organogram import form accessed', ['user_id' => auth()->id()]);
        return view('organogram.upload');
    }

    public function upload(Request $request)
    {
        $request->validate([
            'file' => 'required|file|mimes:xlsx,xls',
        ]);

        try {
            DB::beginTransaction();

            $import = new OrganogramImport();
            Excel::import($import, $request->file('file'));

            // Check if any rows were processed
            $rowsProcessed = $import->getRowCount();
            if ($rowsProcessed === 0) {
                throw new \Exception('No valid data found in the file. Please check the column headers and data format.');
            }

            Log::info('Organogram imported', [
                'user_id' => auth()->id(),
                'rows_processed' => $rowsProcessed,
            ]);

            DB::commit();
            return redirect()->route('organogram.index')->with('success', 'Organogram imported successfully. ' . $rowsProcessed . ' rows processed.');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Organogram import failed', [
                'user_id' => auth()->id(),
                'error' => $e->getMessage(),
            ]);
            return redirect()->back()->with('error', 'Failed to import organogram: ' . $e->getMessage());
        }
    }
}
