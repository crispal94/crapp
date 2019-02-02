<?php

use App\Proyectos;
use App\Avances;
use App\Actividades;
use App\Bouncer;
use Illuminate\Support\Facades\Auth;



function getRole(){
  $user = Auth::user();
  $role = $user->getRoles()->first();
  return $role;
}

function getRoleProyectoQuery(){
  $user = Auth::user();
  $role = $user->getRoles()->first();

  switch ($role) {
    case 'admin':
      $proyecto = Proyectos::all();
      break;

    case 'super':
      $proyecto = Proyectos::where('id_responsable',$user->id)->get();
      break;

    case 'recur':
      $proyecto = Proyectos::select('cab_actividad.*')->join('det_actividad', 'cab_actividad.id', '=', 'det_actividad.id_cabecera')
      ->where('det_actividad.id_responsable',$user->id)->groupBy('cab_actividad.id')->get();
     break;
  }

  return $proyecto;
}


function getAvanceProyecto($id){
  $actividades = Proyectos::find($id)->actividades;
  $acu = 0;
  foreach ($actividades as $actividad) {
    $avance = (int) trim($actividad->ultavance,'%');
    $acu+=$avance;
  }

  if(count($actividades)!=0){
  $promedio = $acu / count($actividades);
  return $promedio.'%';
  }else{
   return '0%';
  }
}

function getEstadoProyecto($id){
  date_default_timezone_set('America/Bogota');
  $fechahoy = date("Y-m-d H:i:s", strtotime('now'));
  $actividades = Proyectos::find($id)->actividades; //Actividades::find(39);
  $colorproyecto = 'Gris';
  $arreglocolores = [];
foreach ($actividades as $actividad) {
   $tipo = $actividad->tiempo->valor;
   $duracion = $actividad->duracion;

   if($duracion==1){
   switch ($tipo) {
     case 'Hora':
       $vp = 100 / 60;
       $duracion = 60;
       break;

     case 'Día':
       $vp = 100 / 24;
       $duracion = 24;
       break;

     case 'Semana':
       $vp = 100 / 30;
       $duracion = 30;
       break;

     case 'Mes':
       $vp = 100 / 4;
       $duracion = 4;
       break;

     case 'Año':
       $vp = 100 / 12;
       $duracion = 12;
       break;
   }
   $fespecial = true;
   }else{
   $vp = 100 / $duracion;
   $fespecial = false;
   }


   switch ($tipo) {
     case 'Hora':
     $arreglofechas = [];
     $fechainicio = date("Y-m-d H:i:s", strtotime($actividad->fechainicio));
     $fechault = date("Y-m-d H:i:s",strtotime($actividad->fecha_ultavance));
     $color = 'gris';
     if($fespecial){
     $acu = $vp;
     for ($i=0; $i < $duracion ; $i++) {
       $tmp = [];
       $fechafin = date("Y-m-d H:i:s",strtotime($fechainicio."+ 1 minute"));
       if(($fechahoy>=$fechainicio)&&($fechahoy<=$fechafin)){
        if($actividad->ultavance>=$acu){
          $color = 'azul';
        }else if((($acu-20)<=$actividad->ultavance)&&($acu>=$actividad->ultavance)){
          $color = 'anaranjado';
        }else{
          $color = 'rojo';
        }
        break;
       }else{
       $fechainicio = $fechafin;
       $acu+=$vp;
       }
     }
     }else{
     $acu = $vp;
     for ($i=0; $i < $duracion ; $i++) {
       $tmp = [];
       $fechafin = date("Y-m-d H:i:s",strtotime($fechainicio."+ 1 hour"));
       if(($fechahoy>=$fechainicio)&&($fechahoy<=$fechafin)){
         if($actividad->ultavance>=$acu){
           $color = 'azul';
         }else if((($acu-20)<=$actividad->ultavance)&&($acu>=$actividad->ultavance)){
           $color = 'anaranjado';
         }else{
           $color = 'rojo';
         }
        break;
       }else{
       $fechainicio = $fechafin;
       $acu+=$vp;
       }
      }
     }
       break;

     case 'Día':
     $arreglofechas = [];
     $fechainicio = date("Y-m-d H:i:s", strtotime($actividad->fechainicio));
     $fechault = date("Y-m-d H:i:s",strtotime($actividad->fecha_ultavance));
     $color = 'gris';
     if($fespecial){
     $acu = $vp;
     for ($i=0; $i < $duracion ; $i++) {
       $tmp = [];
       $fechafin = date("Y-m-d H:i:s",strtotime($fechainicio."+ 1 hour"));
       if(($fechahoy>=$fechainicio)&&($fechahoy<=$fechafin)){
         //dd($acu);
        if($actividad->ultavance>=$acu){
          $color = 'azul';
        }else if((($acu-20)<=$actividad->ultavance)&&($acu>=$actividad->ultavance)){
          $color = 'anaranjado';
        }else{
          $color = 'rojo';
        }
        break;
       }else{
       $fechainicio = $fechafin;
       $acu+=$vp;
       }
     }
     }else{
     $acu = $vp;
     for ($i=0; $i < $duracion ; $i++) {
       $tmp = [];
       $fechafin = date("Y-m-d H:i:s",strtotime($fechainicio."+ 1 day"));
       if(($fechahoy>=$fechainicio)&&($fechahoy<=$fechafin)){
         if($actividad->ultavance>=$acu){
           $color = 'azul';
         }else if((($acu-20)<=$actividad->ultavance)&&($acu>=$actividad->ultavance)){
           $color = 'anaranjado';
         }else{
           $color = 'rojo';
         }
        break;
       }else{
       $fechainicio = $fechafin;
       $acu+=$vp;
       }
      }
     }
     break;

     case 'Semana':
     $arreglofechas = [];
     $fechainicio = date("Y-m-d H:i:s", strtotime($actividad->fechainicio));
     $fechault = date("Y-m-d H:i:s",strtotime($actividad->fecha_ultavance));
     $color = 'gris';
     if($fespecial){
     $acu = $vp;
     for ($i=0; $i < $duracion ; $i++) {
       $tmp = [];
       $fechafin = date("Y-m-d H:i:s",strtotime($fechainicio."+ 1 day"));
       if(($fechahoy>=$fechainicio)&&($fechahoy<=$fechafin)){
         //dd($acu);
        if($actividad->ultavance>=$acu){
          $color = 'azul';
        }else if((($acu-20)<=$actividad->ultavance)&&($acu>=$actividad->ultavance)){
          $color = 'anaranjado';
        }else{
          $color = 'rojo';
        }
        break;
       }else{
       $fechainicio = $fechafin;
       $acu+=$vp;
       }
     }
     }else{
     $acu = $vp;
     for ($i=0; $i < $duracion ; $i++) {
       $tmp = [];
       $fechafin = date("Y-m-d H:i:s",strtotime($fechainicio."+ 1 week"));
       if(($fechahoy>=$fechainicio)&&($fechahoy<=$fechafin)){
         if($actividad->ultavance>=$acu){
           $color = 'azul';
         }else if((($acu-20)<=$actividad->ultavance)&&($acu>=$actividad->ultavance)){
           $color = 'anaranjado';
         }else{
           $color = 'rojo';
         }
        break;
       }else{
       $fechainicio = $fechafin;
       $acu+=$vp;
       }
      }
     }
     break;

     case 'Mes':
     $arreglofechas = [];
     $fechainicio = date("Y-m-d H:i:s", strtotime($actividad->fechainicio));
     $fechault = date("Y-m-d H:i:s",strtotime($actividad->fecha_ultavance));
     $color = 'gris';
     if($fespecial){
     $acu = $vp;
     for ($i=0; $i < $duracion ; $i++) {
       $tmp = [];
       $fechafin = date("Y-m-d H:i:s",strtotime($fechainicio."+ 1 week"));
       if(($fechahoy>=$fechainicio)&&($fechahoy<=$fechafin)){
         //dd($acu);
        if($actividad->ultavance>=$acu){
          $color = 'azul';
        }else if((($acu-20)<=$actividad->ultavance)&&($acu>=$actividad->ultavance)){
          $color = 'anaranjado';
        }else{
          $color = 'rojo';
        }
        break;
       }else{
       $fechainicio = $fechafin;
       $acu+=$vp;
       }
     }
     }else{
     $acu = $vp;
     for ($i=0; $i < $duracion ; $i++) {
       $tmp = [];
       $fechafin = date("Y-m-d H:i:s",strtotime($fechainicio."+ 1 month"));
       if(($fechahoy>=$fechainicio)&&($fechahoy<=$fechafin)){
         if($actividad->ultavance>=$acu){
           $color = 'azul';
         }else if((($acu-20)<=$actividad->ultavance)&&($acu>=$actividad->ultavance)){
           $color = 'anaranjado';
         }else{
           $color = 'rojo';
         }
        break;
       }else{
       $fechainicio = $fechafin;
       $acu+=$vp;
       }
      }
     }
     break;

     case 'Año':
     $arreglofechas = [];
     $fechainicio = date("Y-m-d H:i:s", strtotime($actividad->fechainicio));
     $fechault = date("Y-m-d H:i:s",strtotime($actividad->fecha_ultavance));
     $color = 'gris';
     if($fespecial){
     $acu = $vp;
     for ($i=0; $i < $duracion ; $i++) {
       $tmp = [];
       $fechafin = date("Y-m-d H:i:s",strtotime($fechainicio."+ 1 month"));
       if(($fechahoy>=$fechainicio)&&($fechahoy<=$fechafin)){
         //dd($acu);
        if($actividad->ultavance>=$acu){
          $color = 'azul';
        }else if((($acu-20)<=$actividad->ultavance)&&($acu>=$actividad->ultavance)){
          $color = 'anaranjado';
        }else{
          $color = 'rojo';
        }
        break;
       }else{
       $fechainicio = $fechafin;
       $acu+=$vp;
       }
     }
     }else{
     $acu = $vp;
     for ($i=0; $i < $duracion ; $i++) {
       $tmp = [];
       $fechafin = date("Y-m-d H:i:s",strtotime($fechainicio."+ 1 year"));
       if(($fechahoy>=$fechainicio)&&($fechahoy<=$fechafin)){
         if($actividad->ultavance>=$acu){
           $color = 'azul';
         }else if((($acu-20)<=$actividad->ultavance)&&($acu>=$actividad->ultavance)){
           $color = 'anaranjado';
         }else{
           $color = 'rojo';
         }
        break;
       }else{
       $fechainicio = $fechafin;
       $acu+=$vp;
       }
      }
     }
     break;
   }
   array_push($arreglocolores,$color);
 }
 //dd($arreglocolores);
 $ponderamiento = 0;

 for ($i=0; $i < count($arreglocolores) ; $i++) {
   switch ($arreglocolores[$i]) {
     case 'azul':
       $ponderamiento+=5;
       break;

     case 'anaranjado':
       $ponderamiento+=3;
       break;

     case 'rojo':
       $ponderamiento+=1;
       break;

   }
 }

if(count($arreglocolores)!=0)
{
 $promedio = $ponderamiento / count($arreglocolores);
}else{
  $promedio = 0;
}
 if($promedio == 0){
   $colorproyecto = 'gris';
 }else if($promedio >= 0 && $promedio <= 2.5) {
   $colorproyecto = 'rojo';
   //$colorproyecto = '<h3><span class="badge badge-danger">Peligro</span></h3>';
 }else if($promedio > 2.5 && $promedio <=3.5){
   $colorproyecto = 'anaranjado';
   //$colorproyecto = '<h3><span class="badge badge-warning">Alerta</span></h3>';
 }else if($promedio > 3.5){
   $colorproyecto = 'azul';
   //$colorproyecto = '<h3><span class="badge badge-primary">Estable</span></h3>';
 }

 return $colorproyecto;
}

function getEstadoActividad($id){
  date_default_timezone_set('America/Bogota');
  $fechahoy = date("Y-m-d H:i:s", strtotime('now'));
  $actividad  = Actividades::find($id);
   $tipo = $actividad->tiempo->valor;
   $duracion = $actividad->duracion;

   if($actividad->ultavance==null){
     $color = 'gris';
     $break;
   }else{
   if($duracion==1){
   switch ($tipo) {
     case 'Hora':
       $vp = 100 / 60;
       $duracion = 60;
       break;

     case 'Día':
       $vp = 100 / 24;
       $duracion = 24;
       break;

     case 'Semana':
       $vp = 100 / 30;
       $duracion = 30;
       break;

     case 'Mes':
       $vp = 100 / 4;
       $duracion = 4;
       break;

     case 'Año':
       $vp = 100 / 12;
       $duracion = 12;
       break;
   }
   $fespecial = true;
   }else{
   $vp = 100 / $duracion;
   $fespecial = false;
   }


   switch ($tipo) {
     case 'Hora':
     $arreglofechas = [];
     $fechainicio = date("Y-m-d H:i:s", strtotime($actividad->fechainicio));
     $fechault = date("Y-m-d H:i:s",strtotime($actividad->fecha_ultavance));
     $color = 'gris';
     if($fespecial){
     $acu = $vp;
     for ($i=0; $i < $duracion ; $i++) {
       $tmp = [];
       $fechafin = date("Y-m-d H:i:s",strtotime($fechainicio."+ 1 minute"));
       if(($fechahoy>=$fechainicio)&&($fechahoy<=$fechafin)){
        if($actividad->ultavance>=$acu){
          $color = 'azul';
        }else if((($acu-20)<=$actividad->ultavance)&&($acu>=$actividad->ultavance)){
          $color = 'anaranjado';
        }else{
          $color = 'rojo';
        }
        break;
       }else{
       $fechainicio = $fechafin;
       $acu+=$vp;
       }
     }
     }else{
     $acu = $vp;
     for ($i=0; $i < $duracion ; $i++) {
       $tmp = [];
       $fechafin = date("Y-m-d H:i:s",strtotime($fechainicio."+ 1 hour"));
       if(($fechahoy>=$fechainicio)&&($fechahoy<=$fechafin)){
         if($actividad->ultavance>=$acu){
           $color = 'azul';
         }else if((($acu-20)<=$actividad->ultavance)&&($acu>=$actividad->ultavance)){
           $color = 'anaranjado';
         }else{
           $color = 'rojo';
         }
        break;
       }else{
       $fechainicio = $fechafin;
       $acu+=$vp;
       }
      }
     }
       break;

     case 'Día':

     $arreglofechas = [];
     $fechainicio = date("Y-m-d H:i:s", strtotime($actividad->fechainicio));
     $fechault = date("Y-m-d H:i:s",strtotime($actividad->fecha_ultavance));
     $color = 'gris';
     if($fespecial){
     $acu = $vp;
     for ($i=0; $i < $duracion ; $i++) {
       $tmp = [];
       $fechafin = date("Y-m-d H:i:s",strtotime($fechainicio."+ 1 hour"));
       if(($fechahoy>=$fechainicio)&&($fechahoy<=$fechafin)){
         //dd($acu);
        if($actividad->ultavance>=$acu){
          $color = 'azul';
        }else if((($acu-20)<=$actividad->ultavance)&&($acu>=$actividad->ultavance)){
          $color = 'anaranjado';
        }else{
          $color = 'rojo';
        }
        break;
       }else{
       $fechainicio = $fechafin;
       $acu+=$vp;
       }
     }
     }else{
     $acu = $vp;
     for ($i=0; $i < $duracion ; $i++) {
       $tmp = [];
       $fechafin = date("Y-m-d H:i:s",strtotime($fechainicio."+ 1 day"));
       if(($fechahoy>=$fechainicio)&&($fechahoy<=$fechafin)){
         if($actividad->ultavance>=$acu){
           $color = 'azul';
         }else if((($acu-20)<=$actividad->ultavance)&&($acu>=$actividad->ultavance)){
           $color = 'anaranjado';
         }else{
           $color = 'rojo';
         }
        break;
       }else{
       $fechainicio = $fechafin;
       $acu+=$vp;
       }
      }
     }
     break;

     case 'Semana':
     $arreglofechas = [];
     $fechainicio = date("Y-m-d H:i:s", strtotime($actividad->fechainicio));
     $fechault = date("Y-m-d H:i:s",strtotime($actividad->fecha_ultavance));
     $color = 'gris';
     if($fespecial){
     $acu = $vp;
     for ($i=0; $i < $duracion ; $i++) {
       $tmp = [];
       $fechafin = date("Y-m-d H:i:s",strtotime($fechainicio."+ 1 day"));
       if(($fechahoy>=$fechainicio)&&($fechahoy<=$fechafin)){
         //dd($acu);
        if($actividad->ultavance>=$acu){
          $color = 'azul';
        }else if((($acu-20)<=$actividad->ultavance)&&($acu>=$actividad->ultavance)){
          $color = 'anaranjado';
        }else{
          $color = 'rojo';
        }
        break;
       }else{
       $fechainicio = $fechafin;
       $acu+=$vp;
       }
     }
     }else{
     $acu = $vp;
     for ($i=0; $i < $duracion ; $i++) {
       $tmp = [];
       $fechafin = date("Y-m-d H:i:s",strtotime($fechainicio."+ 1 week"));
       if(($fechahoy>=$fechainicio)&&($fechahoy<=$fechafin)){
         if($actividad->ultavance>=$acu){
           $color = 'azul';
         }else if((($acu-20)<=$actividad->ultavance)&&($acu>=$actividad->ultavance)){
           $color = 'anaranjado';
         }else{
           $color = 'rojo';
         }
        break;
       }else{
       $fechainicio = $fechafin;
       $acu+=$vp;
       }
      }
     }
     break;

     case 'Mes':
     $arreglofechas = [];
     $fechainicio = date("Y-m-d H:i:s", strtotime($actividad->fechainicio));
     $fechault = date("Y-m-d H:i:s",strtotime($actividad->fecha_ultavance));
     $color = 'gris';
     if($fespecial){
     $acu = $vp;
     for ($i=0; $i < $duracion ; $i++) {
       $tmp = [];
       $fechafin = date("Y-m-d H:i:s",strtotime($fechainicio."+ 1 week"));
       if(($fechahoy>=$fechainicio)&&($fechahoy<=$fechafin)){
         //dd($acu);
        if($actividad->ultavance>=$acu){
          $color = 'azul';
        }else if((($acu-20)<=$actividad->ultavance)&&($acu>=$actividad->ultavance)){
          $color = 'anaranjado';
        }else{
          $color = 'rojo';
        }
        break;
       }else{
       $fechainicio = $fechafin;
       $acu+=$vp;
       }
     }
     }else{
     $acu = $vp;
     for ($i=0; $i < $duracion ; $i++) {
       $tmp = [];
       $fechafin = date("Y-m-d H:i:s",strtotime($fechainicio."+ 1 month"));
       if(($fechahoy>=$fechainicio)&&($fechahoy<=$fechafin)){
         if($actividad->ultavance>=$acu){
           $color = 'azul';
         }else if((($acu-20)<=$actividad->ultavance)&&($acu>=$actividad->ultavance)){
           $color = 'anaranjado';
         }else{
           $color = 'rojo';
         }
        break;
       }else{
       $fechainicio = $fechafin;
       $acu+=$vp;
       }
      }
     }
     break;

     case 'Año':
     $arreglofechas = [];
     $fechainicio = date("Y-m-d H:i:s", strtotime($actividad->fechainicio));
     $fechault = date("Y-m-d H:i:s",strtotime($actividad->fecha_ultavance));
     $color = 'gris';
     if($fespecial){
     $acu = $vp;
     for ($i=0; $i < $duracion ; $i++) {
       $tmp = [];
       $fechafin = date("Y-m-d H:i:s",strtotime($fechainicio."+ 1 month"));
       if(($fechahoy>=$fechainicio)&&($fechahoy<=$fechafin)){
         //dd($acu);
        if($actividad->ultavance>=$acu){
          $color = 'azul';
        }else if((($acu-20)<=$actividad->ultavance)&&($acu>=$actividad->ultavance)){
          $color = 'anaranjado';
        }else{
          $color = 'rojo';
        }
        break;
       }else{
       $fechainicio = $fechafin;
       $acu+=$vp;
       }
     }
     }else{
     $acu = $vp;
     for ($i=0; $i < $duracion ; $i++) {
       $tmp = [];
       $fechafin = date("Y-m-d H:i:s",strtotime($fechainicio."+ 1 year"));
       if(($fechahoy>=$fechainicio)&&($fechahoy<=$fechafin)){
         if($actividad->ultavance>=$acu){
           $color = 'azul';
         }else if((($acu-20)<=$actividad->ultavance)&&($acu>=$actividad->ultavance)){
           $color = 'anaranjado';
         }else{
           $color = 'rojo';
         }
        break;
       }else{
       $fechainicio = $fechafin;
       $acu+=$vp;
       }
      }
     }
     break;
   }
 }
   return $color;
}


?>
