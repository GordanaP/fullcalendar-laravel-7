<?php

namespace App\Services\Utilities;

use App\Services\Utilities\CustomRadio;

class PatientTypeRadio extends CustomRadio
{
    /**
     * { @inheritDocs }
     */
    public $name = 'patient_type';

    public $inputs = [
        'existing' => [
            'id' => 'existingPatient',
            'label' => 'Existing Patient',
        ],
        'new' => [
            'id' => 'newPatient',
            'label' => 'New Patient',
        ],
    ];

    public $checked = 'existing';
}