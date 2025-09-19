<?php

namespace App\Http\Controllers\Web\Backend;

use App\DTO\PatientData;
use App\Http\Controllers\Controller;
use App\Http\Requests\API\Patient\StorePatientRequest;
use App\Http\Requests\API\Patient\UpdatePatientRequest;
use App\Services\API\PatientService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;

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
            'title' => 'Patients',
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
        return view('pages.backend.patient.create', [
            'title' => 'New Patient',
        ]);
    }

    public function store(StorePatientRequest $request)
    {
        try {
            $validated = $request->validated();

            $validated['ethnic'] = $validated['ethnic'] ? json_encode([$validated['ethnic']]) : null;

            $patient = $this->patientService->create($validated);

            return $patient
                ? redirect()->route('be.patient.index')->with('success', 'Patient created successfully.')
                : back()->withErrors(['error' => 'Failed to create patient. Please try again.']);

        } catch (ValidationException $e) {
            Log::error('Validation failed when creating patient', [
                'errors' => $e->errors(),
                'input'  => $request->all(),
            ]);

            throw $e;
        } catch (\Exception $e) {
            Log::error('Unexpected error when creating patient', [
                'message' => $e->getMessage(),
                'trace'   => $e->getTraceAsString(),
            ]);

            return back()->withErrors(['error' => 'Unexpected error occurred.']);
        }
    }

    public function edit(string $id)
    {
        $patient = $this->patientService->getById($id);

        if (!$patient) {
            return abort(404, 'Patient not found.');
        }

        return view('pages.backend.patient.edit', [
            'title' => 'Edit Patient',
            'patient' => (object) $patient['data']
        ]);
    }

    public function update(UpdatePatientRequest $request, string $id)
    {
        $validated = $request->validated();

        $validated['ethnic'] = $validated['ethnic'] ? json_encode([$validated['ethnic']]) : null;

        $patient = $this->patientService->update($id, $validated);

        return $patient
            ? redirect()->route('be.patient.index')->with('success', 'Patient updated successfully.')
            : back()->withErrors(['error' => 'Failed to update patient. Please try again.']);
    }

    public function destroy(string $id)
    {
        $deleted = $this->patientService->delete($id);

        return $deleted
            ? redirect()->route('be.patient.index')->with('success', 'Patient deleted successfully.')
            : back()->withErrors(['error' => 'Failed to delete patient. Please try again.']);
    }
}
