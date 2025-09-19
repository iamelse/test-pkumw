import axios from 'axios';

window.patientPage = function() {
    return {
        /*
        |--------------------------------------------------------------------------
        | State / Data
        |--------------------------------------------------------------------------
        |
        | All reactive data and state variables used in AlpineJS
        |
        */
        patient: {},
        mode: 'view',
        modals: {
            filter: false,
            patient: false,
            delete: false,
            connectionError: false
        },
        loadingId: null,
        loadingAction: null,
        deletePatientId: null,
        deletePatientName: '',

        /*
        |--------------------------------------------------------------------------
        | Utilities
        |--------------------------------------------------------------------------
        |
        | Helper functions such as formatLabel and resetPatient
        |
        */
        formatLabel(field) {
            const custom = {
                rm_number: 'RM Number',
                bpjs_number: 'BPJS Number',
                identity_number: 'Identity Number',
            };
            if (custom[field]) return custom[field];

            return field
                .replace(/_/g, ' ')
                .replace(/\b\w/g, l => l.toUpperCase());
        },

        resetPatient() {
            this.patient = {
                rm_number: '',
                identity_number: '',
                bpjs_number: '',
                first_name: '',
                last_name: '',
                gender: '',
                birth_place: '',
                birth_date: '',
                phone_number: '',
                street_address: '',
                city_address: '',
                state_address: '',
                emergency_full_name: '',
                emergency_phone_number: '',
                ethnic: '',
                education: '',
                married_status: '',
                job: '',
                father_name: '',
                mother_name: '',
                blood_type: '',
                communication_barrier: '',
                disability_status: ''
            };
        },

        /*
        |--------------------------------------------------------------------------
        | Modal Handling
        |--------------------------------------------------------------------------
        |
        | All functions to open and close modals
        |
        */
        openModal(name, mode = 'view', data = {}) {
            this.mode = mode;
            this.modals[name] = true;

            if (mode === 'create') {
                this.resetPatient();
            } else {
                this.patient = data;
            }
        },

        closeModal(name) {
            this.modals[name] = false;
            if (name === 'delete') {
                this.deletePatientId = null;
                this.deletePatientName = '';
            }
        },

        openDeleteModal(id, name) {
            this.deletePatientId = id;
            this.deletePatientName = name;
            this.modals.delete = true;
        },

        showConnectionError() {
            this.modals.connectionError = true;
        },

        closeConnectionError() {
            this.modals.connectionError = false;
        },

        /*
        |--------------------------------------------------------------------------
        | API Calls
        |--------------------------------------------------------------------------
        |
        | All functions that call API endpoints via Axios
        |
        */
        showPatientModal(id) {
            this.loadingId = id;
            this.loadingAction = 'view';

            axios.get(window.routes.patientShow.replace(':id', id))
                .then(res => {
                    setTimeout(() => {
                        this.patient = res.data.data; // populate patient data
                        this.mode = 'view';
                        this.modals.patient = true;
                        this.loadingId = null;
                        this.loadingAction = null;
                    }, 300);
                })
                .catch(err => {
                    console.error(err);
                    this.showConnectionError();
                    this.loadingId = null;
                    this.loadingAction = null;
                });
        },

        /*
        |--------------------------------------------------------------------------
        | AlpineJS Initialization
        |--------------------------------------------------------------------------
        |
        | Initialization function when the component is mounted
        |
        */
        init() {
            if (!window.patientDataAvailable) {
                // this.showConnectionError();
            }
        }
    }
}