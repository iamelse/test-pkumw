<?php

namespace App\Http\Controllers\Web\Backend;

use App\DTO\PatientData;
use App\Http\Controllers\Controller;
use App\Services\API\PatientService;
use Illuminate\Http\Request;

class PatientController extends Controller
{
    protected PatientService $patientService;

    public function __construct(PatientService $patientService)
    {
        $this->patientService = $patientService;
    }

    public function index(Request $request)
    {
        $filters = $request->only([
            'page',        // int
            'per_page',    // int
            'search',      // string
            'gender',      // string
            'ethnic',      // string
            'education',   // string
            'married_status', // string
            'job',         // string
            'blood_type'   // string
        ]);

        // Default page & per_page
        $filters['page'] = $filters['page'] ?? 1;
        $filters['per_page'] = $filters['per_page'] ?? 10;

        $patients = $this->patientService->getAll($filters);
        $patientsRaw = $patients['data']['data'] ?? [];
        $patientsDTO = array_map(fn($p) => new PatientData($p), $patientsRaw);

        return view('pages.backend.patient.index', [
            'title' => 'Patient List',
            'patients' => $patients,
            'patientsDTO' => $patientsDTO,
            'filters' => $filters,
        ]);
    }

    public function show(string $id)
    {
        $patient = $this->patientService->getById($id);

        if (!$patient) {
            return response()->json(['error' => 'Patient not found.'], 404);
        }

        return response()->json($patient);
    }

    public function create()
    {
        return view('patients.create');
    }

    public function store(StorePatientRequest $request)
    {
        $patient = $this->patientService->create($request->validated());

        return $patient
            ? redirect()->route('patients.index')->with('success', 'Patient created successfully.')
            : back()->withErrors(['error' => 'Failed to create patient. Please try again.']);
    }

    public function edit(string $id)
    {
        $patient = $this->patientService->find($id);

        if (!$patient) {
            return redirect()->route('patients.index')->withErrors(['error' => 'Patient not found.']);
        }

        return view('patients.edit', compact('patient'));
    }

    public function update(UpdatePatientRequest $request, string $id)
    {
        $patient = $this->patientService->update($id, $request->validated());

        return $patient
            ? redirect()->route('patients.index')->with('success', 'Patient updated successfully.')
            : back()->withErrors(['error' => 'Failed to update patient. Please try again.']);
    }

    public function destroy(string $id)
    {
        $deleted = $this->patientService->delete($id);

        return $deleted
            ? redirect()->route('patients.index')->with('success', 'Patient deleted successfully.')
            : back()->withErrors(['error' => 'Failed to delete patient. Please try again.']);
    }
}
