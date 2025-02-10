<?php

namespace App\Enum;

enum StatutReclamation: string
{
    case EN_ATTENTE = 'En attente';
    case EN_COURS = 'En cours';
    case RESOLU = 'Résolu';

    public static function getChoices(): array
    {
        return [
            'En attente' => self::EN_ATTENTE->value,
            'En cours' => self::EN_COURS->value,
            'Résolu' => self::RESOLU->value,
        ];
    }
}
