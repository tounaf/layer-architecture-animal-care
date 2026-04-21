<?php

namespace Domain\RendezVous\Enum;

enum StatutRendezVous: string
{
    case EN_ATTENTE = 'en_attente';
    case CONFIRME = 'confirme';
    case ANNULE = 'annule';
    case TERMINE = 'termine';
}
