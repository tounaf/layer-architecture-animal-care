<?php

namespace Domain\Care\Enum;

enum TypeEntree: string
{
    case VACCINATION = 'vaccination';
    case VERMIFUGE = 'vermifuge';
    case TRAITEMENT = 'traitement';
    case EXAMEN = 'examen';
    case CHIRURGIE = 'chirurgie';
    case CONSULTATION = 'consultation';
    case PRESCRIPTION = 'prescription';
}
