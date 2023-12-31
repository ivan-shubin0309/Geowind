<?php

namespace AppBundle\Model;

/**
 * @author Stéphane Ear <stephaneear@gmail.com>
 */
class ExportOption
{
    /**
     * @var array
     */
    private $selectedOptions;
    
    public function getSelectedOptions()
    {
        return $this->selectedOptions;
    }

    public function setSelectedOptions($selectedOptions)
    {
        $this->selectedOptions = $selectedOptions;
        return $this;
    }
    
    public function isSelected($key)
    {
        return in_array($key, $this->selectedOptions);
    }
    
    public function getOptionList()
    {
        return [
            'id' => 'ID',
            'date_creation' => 'Date de création',
            'date_maj' => 'Date de mise à jour',
            'type_projet' => 'Type de projet',
            'denomination' => 'Dénomination',
            'origine' => 'Source',
            'charge_foncier' => 'Chargé du foncier',
            'partenaire' => 'Partenaire',
            'chef_projet' => 'Chef de projet',
            'region' => 'Région',
            'departement' => 'Département',
            'commune' => 'Commune(s)',
            // 'carte' => 'Carte',
            'latitude' => 'Latitude',
            'longitude' => 'Longitude',
            'type_site' => 'Type de bien',
            'environnement' => 'Type de milieu',
            'potentiel' => 'Potentiel (MW)',
            // 'raccord' => 'Raccord (km)',
            // 'materiel' => 'Matériel',
            // 'servitudes' => 'Servitudes',
            'avis_mairie' => 'Avis Mairie',
            'foncier' => 'Parcelles',
            'progression' => 'Progression',
            // 'date_t0' => 'Date T0',
            // 'date_t1' => 'Date T1',
            'engage' => 'Engagé (€HT)',
            'paye' => 'Payé (€HT)',
            'commentaires' => 'Commentaires',
        ];
    }
}
