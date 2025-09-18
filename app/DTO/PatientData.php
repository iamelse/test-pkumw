<?php

namespace App\DTO;

use Carbon\Carbon;
use Illuminate\Support\Str;

class PatientData
{
    protected array $data;

    public function __construct(array $data)
    {
        $this->data = $data;
    }

    public function __get($key)
    {
        // Fallback untuk properti langsung
        return $this->data[$key] ?? null;
    }

    // Full Name
    public function fullName(): string
    {
        return trim($this->data['first_name'] . ' ' . $this->data['last_name']);
    }

    // Avatar
    public function avatar(): string
    {
        return $this->data['avatar'] ?? avatar_placeholder($this->fullName());
    }

    // Gender Label + Styling
    public function genderBadge(): array
    {
        $isMale = Str::lower($this->data['gender']) === 'male' || Str::lower($this->data['gender']) === 'l';
        return [
            'label' => Str::ucfirst($this->data['gender']),
            'class' => $isMale 
                ? 'bg-blue-100 text-blue-700 dark:bg-blue-500/15 dark:text-blue-400'
                : 'bg-pink-100 text-pink-700 dark:bg-pink-500/15 dark:text-pink-400',
        ];
    }

    // Blood Type
    public function bloodType(): string
    {
        return strtoupper($this->data['blood_type'] ?? '-');
    }

    // Birth info
    public function birthInfo(): string
    {
        $date = Carbon::parse($this->data['birth_date'])->translatedFormat('d F Y');
        return "{$this->data['birth_place']}, $date";
    }

    // Full address
    public function address(): string
    {
        return "{$this->data['street_address']}, {$this->data['city_address']}, {$this->data['state_address']}";
    }
}