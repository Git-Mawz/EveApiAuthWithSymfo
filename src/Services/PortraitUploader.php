<?php

namespace App\Services;

class PortraitUploader
{

    public function saveFile($characterId)
    {
        $avatarUrl = 'https://images.evetech.net/Character/' . $characterId . '_128.jpg';
        $file = file_get_contents($avatarUrl);
        if ($file == null) {
            return null;
        }
        // On déplace le fichier
        $fileName = $file->move('public/avatar', $characterId . '.jpg');
        
        return $fileName;
    }
}