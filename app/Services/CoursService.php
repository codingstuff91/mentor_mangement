<?php

namespace App\Services;

class CoursService
{
    /**
     * Calcul le nombre d'heures d'un cours
     */
    public function count_lesson_hours($heure_fin, $heure_debut)
    {
        return explode(":",$heure_fin)[0] - explode(":",$heure_debut)[0];
    }
}
