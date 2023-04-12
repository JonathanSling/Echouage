<?php

$typeEspece = array(
        'rorqual' => "les Rorquals sont des espèces de baleines à fanons qui se distinguent par leurs sillons ventraux (ou gulaires) longitudinaux s’étendant de l’avant du rostre à un certain point sur le ventre, parfois loin en arrière des nageoires pectorales.", 

        'baleine' => "C'est un terme générique qui s'applique aux espèces appartenant au sous-ordre des mysticètes, les cétacés à fanons ainsi que, improprement, à certaines espèces appartenant aux odontocètes, les cétacés à dents. Le petit de la baleine s'appelle le baleineau.",

        'cétacés' => 'Desc cétacés',

        'cetacea' => 'Desc cetacea',

        'dauphin' => 'Desc dauphin',

        'delphinides' => 'Desc delphinides',

        'globicéphale' => 'Desc globicéphale',

        'hypéroodon' => 'Desc hypéroodon',

        'lagernorhynque' => 'Desc lagernorhynque',

        'marsouin commun' => 'Desc marsouin commun',

        'mesoplodon' => 'Desc mesoplodon',

        'odontocete' => 'Desc odontocete',

        'phoque' => 'Desc phoque',

        'physeter' => 'Desc physeter'
    );

function getDescription($espece, $typeEspece)
{
    $result = null;
    foreach($typeEspece as $key => $value){
        if(strpos(mb_strtolower($espece, 'UTF-8'), $key) !== false) $result = $value;
    }
    return $result;
}