<?php

namespace Domain\Facture\Enum;

enum StatutFacture: string
{
    case EN_ATTENTE = 'en_attente';
    case PAYEE = 'payee';
    case ANNULEE = 'annulee';
}
