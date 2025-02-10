<?php

namespace App\Enum;

enum EnumRole: string
{
    case ADMIN = 'ROLE_ADMIN';
    case CLIENT = 'ROLE_CLIENT';
    case AGRICULTEUR = 'ROLE_AGRICULTEUR';
    case VETERINAIRE = 'ROLE_VETERINAIRE';
    case FORMATEUR = 'ROLE_FORMATEUR';
    case USER = 'ROLE_USER'; // Rôle par défaut

    public static function getChoices(): array
    {
        return [
            'Administrateur' => self::ADMIN->value,
            'Client' => self::CLIENT->value,
            'Agriculteur' => self::AGRICULTEUR->value,
            'Vétérinaire' => self::VETERINAIRE->value,
            'Formateur' => self::FORMATEUR->value,
            'Utilisateur' => self::USER->value,
        ];
    }
}
