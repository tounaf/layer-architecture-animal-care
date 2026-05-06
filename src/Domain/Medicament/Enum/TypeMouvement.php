<?php

namespace Domain\Medicament\Enum;

enum TypeMouvement: string
{
    case ENTREE = 'entree'; // Approvisionnement
    case SORTIE = 'sortie'; // Prescription
}
