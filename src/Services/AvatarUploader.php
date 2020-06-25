<?php

namespace App\Services;

class AvatarUploader
{

    public function saveFile($characterId)
    {
        $esiBaseUrl = 'https://esi.evetech.net/latest/';
        $characterPortraits = $esiBaseUrl . 'characters/' .$characterId. '/portrait/';
            
        $characterPortraits = json_decode(file_get_contents($characterPortraits));
        dd($characterPortraits);

        $file = '';

        if ($file == null) {
            return null;
        }
        // On obitient un nouveau nom
        $newFileName = $this->createFileName($file->getClientOriginalExtension());

        // On déplace le fichier
        $file->move('public/avatar', $newFileName);
        
        return $newFileName;
    }
    
    /**
     * @param string $extension Une extension de fichier
     * 
     * @return string Un nom de fichier aléatoire avec l'extension précisée
     */
    public function createFileName(string $extension)
    {
        // On choisit un nouveau pour le fichier
        $newFileName = preg_replace('/[+=\/]/', random_int(0, 9), base64_encode(random_bytes(6)));
        // On retourne le nom avce une extension
        return $newFileName . '.' . $extension;;
    }


}