<?php


namespace app\controllers;

use yii;

class GlobalFunction 
{
    public function ConversiNamaBulan($bulan){
        // 02 hasil Feb
        $nama='';
        if($bulan=='01'){ $nama='Jan'; }
        else if($bulan=='02'){ $nama='Feb'; }
        else if($bulan=='03'){ $nama='Mar'; }
        else if($bulan=='04'){ $nama='Apr'; }
        else if($bulan=='05'){ $nama='Mei'; }
        else if($bulan=='06'){ $nama='Jun'; }
        else if($bulan=='07'){ $nama='Jul'; }
        else if($bulan=='08'){ $nama='Ags'; }
        else if($bulan=='09'){ $nama='Sep'; }
        else if($bulan=='10'){ $nama='Okt'; }
        else if($bulan=='11'){ $nama='Nov'; }
        else if($bulan=='12'){ $nama='Des'; }
        else {$nama='xxx';}
        
        return $nama;
    }
    
    public function PeriodeToNamaBulan($periode){
        // 201509 hasil Sep
        $nama='';
        if(substr($periode,4,2)=='01'){ $nama='Jan'; }
        else if(substr($periode,4,2)=='02'){ $nama='Feb'; }
        else if(substr($periode,4,2)=='03'){ $nama='Mar'; }
        else if(substr($periode,4,2)=='04'){ $nama='Apr'; }
        else if(substr($periode,4,2)=='05'){ $nama='Mei'; }
        else if(substr($periode,4,2)=='06'){ $nama='Jun'; }
        else if(substr($periode,4,2)=='07'){ $nama='Jul'; }
        else if(substr($periode,4,2)=='08'){ $nama='Ags'; }
        else if(substr($periode,4,2)=='09'){ $nama='Sep'; }
        else if(substr($periode,4,2)=='10'){ $nama='Okt'; }
        else if(substr($periode,4,2)=='11'){ $nama='Nov'; }
        else if(substr($periode,4,2)=='12'){ $nama='Des'; }
        
        return $nama;
    }
    
    public function PeriodeToPeriodeString($periode){
        // 201509 Hasil  "Sep - 2015"
        $nama='';
        if(substr($periode,4,2)=='01'){ $nama='Jan'; }
        else if(substr($periode,4,2)=='02'){ $nama='Feb'; }
        else if(substr($periode,4,2)=='03'){ $nama='Mar'; }
        else if(substr($periode,4,2)=='04'){ $nama='Apr'; }
        else if(substr($periode,4,2)=='05'){ $nama='Mei'; }
        else if(substr($periode,4,2)=='06'){ $nama='Jun'; }
        else if(substr($periode,4,2)=='07'){ $nama='Jul'; }
        else if(substr($periode,4,2)=='08'){ $nama='Ags'; }
        else if(substr($periode,4,2)=='09'){ $nama='Sep'; }
        else if(substr($periode,4,2)=='10'){ $nama='Okt'; }
        else if(substr($periode,4,2)=='11'){ $nama='Nov'; }
        else if(substr($periode,4,2)=='12'){ $nama='Des'; }
        
        return $nama . ' - ' . substr($periode,0,4);
    }
    
    public function DayToHari($tgl){
        // 2015-09-31 Hasil  "Senin"
        $day= Yii::$app->formatter->asDatetime($tgl , 'php:l');        
        if($day =='Sunday'){            $nama='Minggu'; }
        else if($day =='Monday'){       $nama='Senin'; }
        else if($day =='Tuesday'){      $nama='Selasa'; }
        else if($day =='Wednesday'){    $nama='Rabu'; }
        else if($day =='Thursday'){     $nama='Kamis'; }
        else if($day =='Friday'){       $nama='Jumat'; }
        else if($day =='Saturday'){     $nama='Sabtu'; }
        else { $nama=$day ; }
        
        return $nama ;
    }

    public function IndoHari($day){
        // Konversi hari ke B.Indo
        if($day =='Sunday'){            $nama='Minggu'; }
        else if($day =='Monday'){       $nama='Senin'; }
        else if($day =='Tuesday'){      $nama='Selasa'; }
        else if($day =='Wednesday'){    $nama='Rabu'; }
        else if($day =='Thursday'){     $nama='Kamis'; }
        else if($day =='Friday'){       $nama='Jumat'; }
        else if($day =='Saturday'){     $nama='Sabtu'; }
        else { $nama=$day ; }
        
        return $nama ;
    }

    public function PeriodeToFullString($periode){
        // 201509 Hasil  "September - 2015"
        $nama='';
        if(substr($periode,4,2)=='01'){ $nama='Januari'; }
        else if(substr($periode,4,2)=='02'){ $nama='Februari'; }
        else if(substr($periode,4,2)=='03'){ $nama='Maret'; }
        else if(substr($periode,4,2)=='04'){ $nama='April'; }
        else if(substr($periode,4,2)=='05'){ $nama='Mei'; }
        else if(substr($periode,4,2)=='06'){ $nama='Juni'; }
        else if(substr($periode,4,2)=='07'){ $nama='Juli'; }
        else if(substr($periode,4,2)=='08'){ $nama='Agustus'; }
        else if(substr($periode,4,2)=='09'){ $nama='September'; }
        else if(substr($periode,4,2)=='10'){ $nama='Oktober'; }
        else if(substr($periode,4,2)=='11'){ $nama='November'; }
        else if(substr($periode,4,2)=='12'){ $nama='Desember'; }
        
        return $nama . ' ' . substr($periode,0,4);
    }
}
