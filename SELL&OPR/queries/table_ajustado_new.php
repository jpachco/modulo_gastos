<?php include "connsqlsrv.php";
global $conexion;

error_reporting(E_ERROR);


//variables de asignacion por el metodo post desde html


if(empty($_POST['marca'])or $_POST['marca']=='' ){
    $marca='';
}
else{
    if(strpos($_POST['marca'], "%") !== 1){

        $marca="in (".$_POST['marca'].")";
    }
    else{
        $marca="like  '%' ";
    }
}

if(empty($_POST['familia'])or $_POST['familia']=='' ){
    $familia='';
}
else{
    if(strpos($_POST['familia'], "%") !== 1){

        $familia="in (".$_POST['familia'].")";
    }
    else{
        $familia="like  '%' ";
    }
}

if(empty($_POST['year'])or $_POST['year']=='' ){
    $year='';
}
else{
    $year= $_POST['year'];
}



if(empty($_POST['temp'])or $_POST['temp']=='' ){
    $tempo='';
}
else{
    if($_POST['temp'] !== "%"){

        $tempo="in (".$_POST['temp'].")";
        
        
        //IF($tempo=="in('BASICO')"){
            $modelo="in(".$_POST['modelos'].")";
            $color="in(".$_POST['colores'].")";
      //  }
        
    }
    else{
        $tempo="like  '%' ";
    }

}

/*

$familia="like  '%' " ;
    $marca="like '%'";
    $year='2023';
    $tempo="like '%'";
*/



//variables*************************************************************************************************************
$historico=[];
$vtajustado=[];
$vta=[];
$compra=[];
$cmpr=[];
$compra_ly=[];
$comprareal= [];
$nmes=[];
$exisfinal=[];
$namecolumn1='';
$namecolumn1='';
$lastm="";
$nxyear=$year+1;
$beforeyear=$year-1;
$beforeyearly=$beforeyear-1;
$importe_act_2019=[];
$importe_act=[];
$costo_act=[];
$util_act=[];
$pedidosly=[];
$pedidosay=[];
$resultpxaño=[];
$comprapxaño=[];
$comprapxaño_ly=[];
$inventario='';
$inventario_upd='';
$inventario_costo='';
$inv=[];
$inv_upd=[];
$inv_costo=[];
$invinicial_costo=[];
$invfinal_costo=[];
$inv2=[];
$inv2_upd=[];
$invinicial=[];
$invinicial_upd=[];
$invly=[];
$residuo=[];
$residuo_upd=[];
$resta=[];
$cont=0;
$resinv=[];
$resinv_upd=[];
$mesesinv=[];
$mesesinv_upd=[];
$mesesinvs= [];
$mesesinvs_upd= [];
$estructura_cmp_actual="";
$estructura_cmp_ppto="";
$compraj="";
$comprajly="";
$compra_act=[];
$invi="";
$invi_upd="";
$invf="";
$invf_upd="";
$mesin="";
$mesin_upd="";
$grafica="";
$vtacombinacion="";
$actualizacion="";
$estructurainvly="";
$estructura_compra_importe="";
$estructura_vta_importe_2019="";
$total1="";
$total2=0;
$total3=0;
$total4=0;
$total5=0;
$total6=0;
$total_imp=0;
$total_imp_2019=0;
$total_cost=0;
$total_cost_inv=0;
$total_cost_inv_fn=0;
$total_util=0;
$total_comp=0;
$pivotinvf=[];
$actuallyear=date("Y");
$nombremeses=[];
$nombremeses1=[];

if($year<$actuallyear){
    $lastm=12;
}
else{$lastm=date("n");}
//funciones(executan los queries y se acumulan en arreglos)*************************************************************
function execonsultasqlsrv($query,$conect,$res){
    $i=0;
    if(!$result =sqlsrv_query($conect, $query)) {
        die();
        //echo "Error al registrarse";

    }


//Resultado de consulta
    while($row = sqlsrv_fetch_array($result))

    {





        $res[$i]=$row;

        $i++;



    }



    return $res;
}
function execonsultamysql($query,$conect,$res){
    $i=0;

    if(!$resultv =mysqli_query( $conect , $query)) {
        die();
        echo "Error al registrarse";

    }
//Resultado de consulta



    while($rowv = mysqli_fetch_array($resultv))
    {
        $res[$i] = $rowv ;

        $i++;

    }


    return $res;
}
function grafica($largo,$input1,$input2,$input3,$pivotinvf,$output) {


    for($i=0 ;$i<$largo;$i++){
        $pivotinvf[$i][0]=$input1[$i];
        $pivotinvf[$i][1]=$input2[$i];
        $pivotinvf[$i][2]=$input3[$i];

    }

    for($i=0;$i<$largo;$i++){


        $output.="[";

        for($j=0;$j<3;$j++){

            if($j==2)
            {


                if(is_nan( $pivotinvf[$i][$j]) or  is_null($pivotinvf[$i][$j])  or  $pivotinvf[$i][$j]==""){

                    $output=$output . 0 ."],";

                }
                else {


                    $output=$output. $pivotinvf[$i][$j]."],";

                }


            }
            else{


                if(is_nan( $pivotinvf[$i][$j]) or  is_null($pivotinvf[$i][$j])  or  $pivotinvf[$i][$j]==""){

                    $output=$output . 0 .",";

                }
                else {


                    $output=$output.$pivotinvf[$i][$j].",";

                }


            }





        }






    }
    return $output;
}
//queries***************************************************************************************************************
IF( $temp!="in ('BASICO')"){
    
    $sql_update=utf8_decode("
    select anio,
           mes,
           sum( [VTA AJUSTADO]) [VTA AJUSTADO],
           sum([Venta$])[Venta$],
           sum([Costo Vta$])[Costo Vta$],
           sum([Venta$]-[Costo Vta$])[Utilidad],
          -- sum([Venta$[-Costo Vta$[)/sum([Venta$])*100 [MG[,
           sum([COMPRA AJUSTADO])[COMPRA AJUSTADO],
           sum([Compra$])[Compra$]
           
           
           from (
           
           
    select  anio,
            mes,
            familia,
            marca,
            sum( [VTA AJUSTADO]) [VTA AJUSTADO],
            sum([VTA AJUSTADO] * [PRECIO VTA])'Venta$',
            sum([VTA AJUSTADO] * [COSTO COMPRA])'Costo Vta$',        
            sum( [COMPRA AJUSTADO])[COMPRA AJUSTADO],
            sum([COMPRA AJUSTADO]*[COSTO COMPRA])'Compra$'
         
        
    from presupuesto_ro
     WHERE categoria $tempo
    group by anio,mes,familia,marca
            
            
            ) as bd
        
            where familia $familia and marca $marca and anio='$year'
          
            
    
            
          group by anio,mes  
          
          
          ");
    $sqlvtareal=utf8_decode( "
           SELECT
         ISNULL(sum(case when mes =1 then [Venta]  END ),0) ENERO,
          ISNULL(sum(case when mes =2 then [Venta] END ),0) FEBRERO,
          ISNULL(sum(case when mes =3 then [Venta] END ),0) MARZO,
          ISNULL(sum(case when mes =4 then [Venta] END ),0) ABRIL,
          ISNULL(sum(case when mes =5 then [Venta] END ),0) MAYO,
          ISNULL(sum(case when mes =6 then [Venta] END ),0) JUNIO,
          ISNULL(sum(case when mes =7 then [Venta] END ),0) JULIO,
         ISNULL( sum(case when mes =8 then [Venta] END ),0) AGOSTO,
          ISNULL(sum(case when mes =9 then [Venta] END ),0) SEPTIEMBRE,
          ISNULL(sum(case when mes =10 then [Venta] END ),0) OCTUBRE,
          ISNULL(sum(case when mes =11 then [Venta] END ),0) NOVIEMBRE,
          ISNULL(sum(case when mes =12 then [Venta] END ),0) DICIEMBRE  
      FROM [dbRoberts].[dbo].[VtaFamMesSOP]
      where familia $familia and [Colección] $marca and año ='$year' and CATEGORIA $tempo
      
       ");
    $sqlvtareal_importe=utf8_decode( "
           SELECT
    
    
         ISNULL(sum(case when mes =1 then [Importe]  END ),0) ENERO,
          ISNULL(sum(case when mes =2 then [Importe] END ),0) FEBRERO,
          ISNULL(sum(case when mes =3 then [Importe] END ),0) MARZO,
          ISNULL(sum(case when mes =4 then [Importe] END ),0) ABRIL,
          ISNULL(sum(case when mes =5 then [Importe] END ),0) MAYO,
          ISNULL(sum(case when mes =6 then [Importe] END ),0) JUNIO,
          ISNULL(sum(case when mes =7 then [Importe] END ),0) JULIO,
         ISNULL( sum(case when mes =8 then [Importe] END ),0) AGOSTO,
          ISNULL(sum(case when mes =9 then [Importe] END ),0) SEPTIEMBRE,
          ISNULL(sum(case when mes =10 then [Importe] END ),0) OCTUBRE,
          ISNULL(sum(case when mes =11 then [Importe] END ),0) NOVIEMBRE,
          ISNULL(sum(case when mes =12 then [Importe] END ),0) DICIEMBRE
      FROM [dbRoberts].[dbo].[VtaFamMesSOP]
      where familia $familia and [Colección] $marca and año ='$year' and categoria $tempo
      
       ");
    $sqlvtareal_2019_importe=utf8_decode( "
           SELECT
    
    
         ISNULL(sum(case when mes =1 then [Importe]  END ),0) ENERO,
          ISNULL(sum(case when mes =2 then [Importe] END ),0) FEBRERO,
          ISNULL(sum(case when mes =3 then [Importe] END ),0) MARZO,
          ISNULL(sum(case when mes =4 then [Importe] END ),0) ABRIL,
          ISNULL(sum(case when mes =5 then [Importe] END ),0) MAYO,
          ISNULL(sum(case when mes =6 then [Importe] END ),0) JUNIO,
          ISNULL(sum(case when mes =7 then [Importe] END ),0) JULIO,
         ISNULL( sum(case when mes =8 then [Importe] END ),0) AGOSTO,
          ISNULL(sum(case when mes =9 then [Importe] END ),0) SEPTIEMBRE,
          ISNULL(sum(case when mes =10 then [Importe] END ),0) OCTUBRE,
          ISNULL(sum(case when mes =11 then [Importe] END ),0) NOVIEMBRE,
          ISNULL(sum(case when mes =12 then [Importe] END ),0) DICIEMBRE
      FROM [dbRoberts].[dbo].[VtaFamMesSOP]
      where familia $familia and [Colección] $marca and año ='2019' and categoria $tempo
      
       ");
    $sqlvtareal_costo=utf8_decode( "
           SELECT
    
    
         ISNULL(sum(case when mes =1 then [Costo]  END ),0) ENERO,
          ISNULL(sum(case when mes =2 then [Costo] END ),0) FEBRERO,
          ISNULL(sum(case when mes =3 then [Costo] END ),0) MARZO,
          ISNULL(sum(case when mes =4 then [Costo] END ),0) ABRIL,
          ISNULL(sum(case when mes =5 then [Costo] END ),0) MAYO,
          ISNULL(sum(case when mes =6 then [Costo] END ),0) JUNIO,
          ISNULL(sum(case when mes =7 then [Costo] END ),0) JULIO,
         ISNULL( sum(case when mes =8 then [Costo] END ),0) AGOSTO,
          ISNULL(sum(case when mes =9 then [Costo] END ),0) SEPTIEMBRE,
          ISNULL(sum(case when mes =10 then [Costo] END ),0) OCTUBRE,
          ISNULL(sum(case when mes =11 then [Costo] END ),0) NOVIEMBRE,
          ISNULL(sum(case when mes =12 then [Costo] END ),0) DICIEMBRE
      FROM [dbRoberts].[dbo].[VtaFamMesSOP]
      where familia $familia and [Colección] $marca and año ='$year' and categoria $tempo
      
       ");
    $sqlvtareal_util=utf8_decode( "
           SELECT
    
    
             ISNULL(sum(case when mes =1 then [Util]  END ),0) ENERO,
          ISNULL(sum(case when mes =2 then [Util] END ),0) FEBRERO,
          ISNULL(sum(case when mes =3 then [Util] END ),0) MARZO,
          ISNULL(sum(case when mes =4 then [Util] END ),0) ABRIL,
          ISNULL(sum(case when mes =5 then [Util] END ),0) MAYO,
          ISNULL(sum(case when mes =6 then [Util] END ),0) JUNIO,
          ISNULL(sum(case when mes =7 then [Util] END ),0) JULIO,
         ISNULL( sum(case when mes =8 then [Util] END ),0) AGOSTO,
          ISNULL(sum(case when mes =9 then [Util] END ),0) SEPTIEMBRE,
          ISNULL(sum(case when mes =10 then [Util] END ),0) OCTUBRE,
          ISNULL(sum(case when mes =11 then [Util] END ),0) NOVIEMBRE,
          ISNULL(sum(case when mes =12 then [Util] END ),0) DICIEMBRE
      FROM [dbRoberts].[dbo].[VtaFamMesSOP]
      where familia $familia and [Colección] $marca and año ='$year' and categoria $tempo
      
       ");
    /*$sqlvtareally=utf8_decode( "
            SELECT
            ISNULL(sum(case when mes =1 then [Venta]  END ),0) ENERO,
          ISNULL(sum(case when mes =2 then [Venta] END ),0) FEBRERO,
          ISNULL(sum(case when mes =3 then [Venta] END ),0) MARZO,
          ISNULL(sum(case when mes =4 then [Venta] END ),0) ABRIL,
          ISNULL(sum(case when mes =5 then [Venta] END ),0) MAYO,
          ISNULL(sum(case when mes =6 then [Venta] END ),0) JUNIO,
          ISNULL(sum(case when mes =7 then [Venta] END ),0) JULIO,
         ISNULL( sum(case when mes =8 then [Venta] END ),0) AGOSTO,
          ISNULL(sum(case when mes =9 then [Venta] END ),0) SEPTIEMBRE,
          ISNULL(sum(case when mes =10 then [Venta] END ),0) OCTUBRE,
          ISNULL(sum(case when mes =11 then [Venta] END ),0) NOVIEMBRE,
          ISNULL(sum(case when mes =12 then [Venta] END ),0) DICIEMBRE
            FROM [VtaFamMesSOP]
            where familia $familia and [Colección]  $marca and año ='$beforeyear'
            GROUP BY AÑO
            ORDER BY  AÑO");*/
    $sqlvta= utf8_decode( " 
    SELECT
    
     sum(case when mes =1 then [VTA AJUSTADO] END ) ENERO,
          sum(case when mes =2 then [VTA AJUSTADO] END ) FEBRERO,
          sum(case when mes =3 then [VTA AJUSTADO] END ) MARZO,
          sum(case when mes =4 then [VTA AJUSTADO] END ) ABRIL,
          sum(case when mes =5 then [VTA AJUSTADO] END ) MAYO,
          sum(case when mes =6 then [VTA AJUSTADO] END ) JUNIO,
          sum(case when mes =7 then [VTA AJUSTADO] END ) JULIO,
          sum(case when mes =8 then [VTA AJUSTADO] END ) AGOSTO,
          sum(case when mes =9 then [VTA AJUSTADO] END ) SEPTIEMBRE,
          sum(case when mes =10 then [VTA AJUSTADO] END ) OCTUBRE,
          sum(case when mes =11 then [VTA AJUSTADO] END ) NOVIEMBRE,
          sum(case when mes =12 then [VTA AJUSTADO] END ) DICIEMBRE
    FROM
    presupuesto_ro
    WHERE
      ANIO='$year' AND familia $familia and Marca $marca and categoria $tempo
     GROUP BY ANIO
    
       ORDER BY  ANIO");
    $sqlcompra= utf8_decode( "
     SELECT
    sum(case when mes =1 then [COMPRA AJUSTADO] END ) ENERO,
          sum(case when mes =2 then [COMPRA AJUSTADO] END ) FEBRERO,
          sum(case when mes =3 then [COMPRA AJUSTADO] END ) MARZO,
          sum(case when mes =4 then [COMPRA AJUSTADO] END ) ABRIL,
          sum(case when mes =5 then [COMPRA AJUSTADO] END ) MAYO,
          sum(case when mes =6 then [COMPRA AJUSTADO] END ) JUNIO,
          sum(case when mes =7 then [COMPRA AJUSTADO] END ) JULIO,
          sum(case when mes =8 then [COMPRA AJUSTADO] END ) AGOSTO,
          sum(case when mes =9 then [COMPRA AJUSTADO] END ) SEPTIEMBRE,
          sum(case when mes =10 then [COMPRA AJUSTADO] END ) OCTUBRE,
          sum(case when mes =11 then [COMPRA AJUSTADO] END ) NOVIEMBRE,
          sum(case when mes =12 then [COMPRA AJUSTADO] END ) DICIEMBRE
    FROM
     presupuesto_ro
    WHERE
      ANIO='$year' AND familia $familia and Marca $marca and categoria $tempo
    GROUP BY
      ANIO;
    
    
      ");
    $sqlcomprareal= utf8_decode( "  
     SELECT SUM(case when mes=1 then compra end) Enero,
    SUM(case when mes=2 then compra end) Febrero,
    SUM(case when mes=3 then compra end) Marzo,
    SUM(case when mes=4 then compra end) Abril,
    SUM(case when mes=5 then compra end) Mayo,
    SUM(case when mes=6 then compra end) Junio,
    SUM(case when mes=7 then compra end) Julio,
    SUM(case when mes=8 then compra end) Agosto,
    SUM(case when mes=9 then compra end) Septiembre,
    SUM(case when mes=10 then compra end) Octubre,
    SUM(case when mes=11 then compra end) Noviembre,
    SUM(case when mes=12 then compra end) Diciembre
    
    
      FROM [ExisFamMes]
      where familia $familia and Colección $marca and año=$year and categoria $tempo
    
    
      " );
    $sqlcomprareal_importe= utf8_decode( "   
    select
    
    convert(int,Sum(case when MONTH([Fecha Registro]) =1 then H.Importe END)) 'ENERO',
    convert(int,Sum(case when MONTH([Fecha Registro]) =2 then H.Importe END)) 'FEBRERO',
    convert(int,Sum(case when MONTH([Fecha Registro]) =3 then H.Importe END)) 'MARZO',
    convert(int,Sum(case    when MONTH([Fecha Registro]) =4 then H.Importe END))'ABRIL',
    convert(int,Sum(case    when MONTH([Fecha Registro]) =5 then H.Importe END)) 'MAYO',
    convert(int,Sum(case    when MONTH([Fecha Registro]) =6 then H.Importe END)) 'JUNIO',
    convert(int,Sum(case    when MONTH([Fecha Registro]) =7 then H.Importe END)) 'JULIO',
    convert(int,Sum(case    when MONTH([Fecha Registro]) =8 then H.Importe END)) 'AGOSTO',
    convert(int,Sum(case    when MONTH([Fecha Registro]) =9 then H.Importe END)) 'SEPTIEMBRE',
    convert(int,Sum(case    when MONTH([Fecha Registro]) =10 then H.Importe END)) 'OCTUBRE',
    convert(int,Sum(case    when MONTH([Fecha Registro]) =11 then H.Importe END)) 'NOVIEMBRE',
    convert(int,Sum(case    when MONTH([Fecha Registro]) =12 then H.Importe END)) 'DICIEMBRE'
    
    
    
    
    from [Historico factura compra] H LEFT join PRODUCTO_LOGISTICA Pr on H.[Nº referencia cruzada] collate Latin1_General_100_CI_AS =Pr.Nº
    
    
    
                      where year([Fecha Registro])='$year'
                      and familia $familia
                      and Familia NOT IN ('', 'ACCESORIOS', 'BERMUDA', 'BLAZER D', 'BLUSA', 'BOLSA', 'BORDADO', 'CAMISA', 'CHALECOD', 'CINTA', 'CONJUNTO', 'COOR/PANTS', 'CORB&MAN', 'CORBATERO', 'EMPAQUE', 'EQUIPAJE', 
                             'FAJA&MONO', 'FALDA', 'FALDA DAMA', 'GORRA', 'HABILITACION', 'KITSMOKREN', 'MAQUILA', 'PANTALON', 'PANTALON D', 'PANTALON DAMA', 'PANTALOND', 'PAQUETE', 'PIJAMA', 'ROPA INT', 'SACO', 'SACO DAMA', 'SLACK', 
                             'SUDADERA', 'TELA', 'TELAS', 'VARIOS')
                      AND Pr.Colección $marca
    and pr.TIPO $tempo
    and H.Temporada not in ('SM','212','PV25P')
    AND H.[Cód. almacén] NOT IN('R098','','R053')
    
    
    
    
    
      " );
    $sqlcomprareally= utf8_decode( "  select
    
    convert(int,Sum(case when MONTH([Fecha Registro]) =1 then H.Cantidad END)) 'ENERO',
    convert(int,Sum(case when MONTH([Fecha Registro]) =2 then H.Cantidad END)) 'FEBRERO',
    convert(int,Sum(case when MONTH([Fecha Registro]) =3 then H.Cantidad END)) 'MARZO',
    convert(int,Sum(case    when MONTH([Fecha Registro]) =4 then H.Cantidad END))'ABRIL',
    convert(int,Sum(case    when MONTH([Fecha Registro]) =5 then H.Cantidad END)) 'MAYO',
    convert(int,Sum(case    when MONTH([Fecha Registro]) =6 then H.Cantidad END)) 'JUNIO',
    convert(int,Sum(case    when MONTH([Fecha Registro]) =7 then H.Cantidad END)) 'JULIO',
    convert(int,Sum(case    when MONTH([Fecha Registro]) =8 then H.Cantidad END)) 'AGOSTO',
    convert(int,Sum(case    when MONTH([Fecha Registro]) =9 then H.Cantidad END)) 'SEPTIEMBRE',
    convert(int,Sum(case    when MONTH([Fecha Registro]) =10 then H.Cantidad END)) 'OCTUBRE',
    convert(int,Sum(case    when MONTH([Fecha Registro]) =11 then H.Cantidad END)) 'NOVIEMBRE',
    convert(int,Sum(case    when MONTH([Fecha Registro]) =12 then H.Cantidad END)) 'DICIEMBRE'
    
    
    
    
    from [Historico factura compra] H left join [PRODUCTO_LOGISTICA] Pr on H.[Nº referencia cruzada] collate Latin1_General_100_CI_AS =Pr.Nº
    
    
                      where year([Fecha Registro])='2022'
                      and familia $familia
                      and  Familia NOT IN ('', 'ACCESORIOS', 'BERMUDA', 'BLAZER D', 'BLUSA', 'BOLSA', 'BORDADO', 'CAMISA', 'CHALECOD', 'CINTA', 'CONJUNTO', 'COOR/PANTS', 'CORB&MAN', 'CORBATERO', 'EMPAQUE', 'EQUIPAJE', 
                             'FAJA&MONO', 'FALDA', 'FALDA DAMA', 'GORRA', 'HABILITACION', 'KITSMOKREN', 'MAQUILA', 'PANTALON', 'PANTALON D', 'PANTALON DAMA', 'PANTALOND', 'PAQUETE', 'PIJAMA', 'ROPA INT', 'SACO', 'SACO DAMA', 'SLACK', 
                             'SUDADERA', 'TELA', 'TELAS', 'VARIOS')
                      And Pr.Colección  $marca
                      and pr.TIPO $tempo
                      and H.Temporada not in ('SM','212','PV25P')
                      AND H.[Cód. almacén] NOT IN('R098','','R053')
    
      ");
    $sqlinvinicial= utf8_decode( "
    
    declare @mes int;
    set @mes='$lastm'
    
    if  @mes > 1
    
    
    select SUM(EXISTENCIA)EXISTENCIA,AÑO,MES FROM [ExisFamMes]
    
      where  familia $familia and Colección $marca and categoria $tempo and AÑO ='$beforeyear' and MES =12  GROUP BY AÑO,MES
    
      union
    
      SELECT  SUM(EXISTENCIA)EXISTENCIA,AÑO,MES FROM [ExisFamMes]
    
      where familia $familia and Colección $marca and categoria $tempo and AÑO ='$year' and mes <@mes GROUP BY AÑO,MES 
      
      
      order by año,mes
    
      else
    
      select SUM(EXISTENCIA)EXISTENCIA,AÑO,MES FROM [ExisFamMes]
    
      where  familia $familia and Colección $marca and categoria $tempo and AÑO ='$beforeyear' and MES =12  GROUP BY AÑO,MES
      
      
      order by año,mes
    
    
    
      ");
    $sqlinvinicial_costo= utf8_decode( "
    
    declare @mes int;
    set @mes='$lastm'
    
    if  @mes > 1
    
    
    select SUM(CostoInv)EXISTENCIA,AÑO,MES FROM [ExisFamMes]
    
      where  familia $familia and Colección  $marca and categoria $tempo and AÑO ='$beforeyear' and MES =12  GROUP BY AÑO,MES
    
      union
    
      SELECT  SUM(CostoInv)EXISTENCIA,AÑO,MES FROM [ExisFamMes]
    
      where familia $familia and Colección  $marca and categoria $tempo and AÑO ='$year' and mes <@mes GROUP BY AÑO,MES 
      
      
      order by año,mes
    
      else
    
      select SUM(CostoInv)EXISTENCIA,AÑO,MES FROM [ExisFamMes]
    
      where  familia $familia and Colección  $marca and categoria $tempo and AÑO ='$beforeyear' and MES =12  GROUP BY AÑO,MES
      
      
      order by año,mes
    
    
    
      ");
    $sqlinvinicially= utf8_decode( "
    
    select ISNULL (SUM(EXISTENCIA),0)EXISTENCIA,AÑO,MES FROM [ExisFamMes]
    
      where  familia $familia and Colección   $marca and categoria $tempo and AÑO ='2018' and MES =12  GROUP BY AÑO,MES
    
      union
    
      SELECT  ISNULL (SUM(EXISTENCIA),0)EXISTENCIA,AÑO,MES FROM [ExisFamMes]
    
       where  familia $familia and Colección  $marca and categoria $tempo and AÑO = '2019' AND MES <=11  GROUP BY AÑO,MES
       ORDER BY AÑO,MES
    
    
      ");
    $sqlvtanxtyear2= utf8_decode(" SELECT
    
     sum(case when mes =1 then [VTA AJUSTADO] END ) ENERO,
          sum(case when mes =2 then [VTA AJUSTADO] END ) FEBRERO,
          sum(case when mes =3 then [VTA AJUSTADO] END ) MARZO,
          sum(case when mes =4 then [VTA AJUSTADO] END ) ABRIL,
          sum(case when mes =5 then [VTA AJUSTADO] END ) MAYO,
          sum(case when mes =6 then [VTA AJUSTADO] END ) JUNIO,
          sum(case when mes =7 then [VTA AJUSTADO] END ) JULIO,
          sum(case when mes =8 then [VTA AJUSTADO] END ) AGOSTO,
          sum(case when mes =9 then [VTA AJUSTADO] END ) SEPTIEMBRE,
          sum(case when mes =10 then [VTA AJUSTADO] END ) OCTUBRE,
          sum(case when mes =11 then [VTA AJUSTADO] END ) NOVIEMBRE,
          sum(case when mes =12 then [VTA AJUSTADO] END ) DICIEMBRE
    FROM
    presupuesto_ro
    WHERE
      ANIO='".($nxyear+1) ."' AND Familia $familia and Marca  $marca    and categoria $tempo
     GROUP BY ANIO
    
    
    
       ORDER BY  ANIO
       
       ");
    $sqlcompnxtyear2= utf8_decode( " SELECT
    
      sum(case when mes =1 then [COMPRA AJUSTADO] END ) ENERO,
          sum(case when mes =2 then [COMPRA AJUSTADO] END ) FEBRERO,
          sum(case when mes =3 then [COMPRA AJUSTADO] END ) MARZO,
          sum(case when mes =4 then [COMPRA AJUSTADO] END ) ABRIL,
          sum(case when mes =5 then [COMPRA AJUSTADO] END ) MAYO,
          sum(case when mes =6 then [COMPRA AJUSTADO] END ) JUNIO,
          sum(case when mes =7 then [COMPRA AJUSTADO] END ) JULIO,
          sum(case when mes =8 then [COMPRA AJUSTADO] END ) AGOSTO,
          sum(case when mes =9 then [COMPRA AJUSTADO] END ) SEPTIEMBRE,
          sum(case when mes =10 then [COMPRA AJUSTADO] END ) OCTUBRE,
          sum(case when mes =11 then [COMPRA AJUSTADO] END ) NOVIEMBRE,
          sum(case when mes =12 then [COMPRA AJUSTADO] END ) DICIEMBRE
    FROM
    presupuesto_ro
    WHERE
      ANIO='".($nxyear+1) ."' AND Familia $familia and Marca  $marca   and categoria $tempo
    GROUP BY
      ANIO;
    
    
      ");
    $sqlvtanxtyear= utf8_decode(" SELECT
    
       sum(case when mes =1 then [VTA AJUSTADO] END ) ENERO,
          sum(case when mes =2 then [VTA AJUSTADO] END ) FEBRERO,
          sum(case when mes =3 then [VTA AJUSTADO] END ) MARZO,
          sum(case when mes =4 then [VTA AJUSTADO] END ) ABRIL,
          sum(case when mes =5 then [VTA AJUSTADO] END ) MAYO,
          sum(case when mes =6 then [VTA AJUSTADO] END ) JUNIO,
          sum(case when mes =7 then [VTA AJUSTADO] END ) JULIO,
          sum(case when mes =8 then [VTA AJUSTADO] END ) AGOSTO,
          sum(case when mes =9 then [VTA AJUSTADO] END ) SEPTIEMBRE,
          sum(case when mes =10 then [VTA AJUSTADO] END ) OCTUBRE,
          sum(case when mes =11 then [VTA AJUSTADO] END ) NOVIEMBRE,
          sum(case when mes =12 then [VTA AJUSTADO] END ) DICIEMBRE
    FROM
    presupuesto_ro
    WHERE
      ANIO='$nxyear' AND familia $familia and Marca  $marca and categoria $tempo
     GROUP BY ANIO
    
    
    
       ORDER BY  ANIO");
    $sqlcompnxtyear= utf8_decode( " SELECT
    
       sum(case when mes =1 then [COMPRA AJUSTADO] END ) ENERO,
          sum(case when mes =2 then [COMPRA AJUSTADO] END ) FEBRERO,
          sum(case when mes =3 then [COMPRA AJUSTADO] END ) MARZO,
          sum(case when mes =4 then [COMPRA AJUSTADO] END ) ABRIL,
          sum(case when mes =5 then [COMPRA AJUSTADO] END ) MAYO,
          sum(case when mes =6 then [COMPRA AJUSTADO] END ) JUNIO,
          sum(case when mes =7 then [COMPRA AJUSTADO] END ) JULIO,
          sum(case when mes =8 then [COMPRA AJUSTADO] END ) AGOSTO,
          sum(case when mes =9 then [COMPRA AJUSTADO] END ) SEPTIEMBRE,
          sum(case when mes =10 then [COMPRA AJUSTADO] END ) OCTUBRE,
          sum(case when mes =11 then [COMPRA AJUSTADO] END ) NOVIEMBRE,
          sum(case when mes =12 then [COMPRA AJUSTADO] END ) DICIEMBRE
    FROM
    presupuesto_ro
    WHERE
      ANIO='$nxyear' AND familia $familia and Marca  $marca and categoria $tempo
    GROUP BY
      ANIO;
    
    
      ");
    $sql_pedidosay=utf8_decode( "
    
    SELECT Año,SUM(CASE WHEN MES=1 THEN CANTIDAD END)ENERO,
            SUM(CASE WHEN MES=2 THEN CANTIDAD END)FEBRERO,
            SUM(CASE WHEN MES=3 THEN CANTIDAD END)MARZO,
            SUM(CASE WHEN MES=4 THEN CANTIDAD END)ABRIL,
            SUM(CASE WHEN MES=5 THEN CANTIDAD END)MAYO,
            SUM(CASE WHEN MES=6 THEN CANTIDAD END)JUNIO,
            SUM(CASE WHEN MES=7 THEN CANTIDAD END)JULIO,
            SUM(CASE WHEN MES=8 THEN CANTIDAD END)AGOSTO,
            SUM(CASE WHEN MES=9 THEN CANTIDAD END)SEPTIEMBRE,
            SUM(CASE WHEN MES=10 THEN CANTIDAD END)OCTUBRE,
            SUM(CASE WHEN MES=11 THEN CANTIDAD END)NOVIEMBRE,
            SUM(CASE WHEN MES=12 THEN CANTIDAD END)DICIEMBRE
    
    
    
     from ped_compr 
    
    
    
    
    WHERE Año >='$year' AND familia $familia AND Marca   $marca AND Familia NOT IN ('', 'ACCESORIOS', 'BERMUDA', 'BLAZER D', 'BLUSA', 'BOLSA', 'BORDADO', 'CAMISA', 'CHALECOD', 'CINTA', 'CONJUNTO', 'COOR/PANTS', 'CORB&MAN', 'CORBATERO', 'EMPAQUE', 'EQUIPAJE', 
                             'FAJA&MONO', 'FALDA', 'FALDA DAMA', 'GORRA', 'HABILITACION', 'KITSMOKREN', 'MAQUILA', 'PANTALON', 'PANTALON D', 'PANTALON DAMA', 'PANTALOND', 'PAQUETE', 'PIJAMA', 'ROPA INT', 'SACO', 'SACO DAMA', 'SLACK', 
                             'SUDADERA', 'TELA', 'TELAS', 'VARIOS') and almacen not in('R098')
    and categoria $tempo
    and Temporada not in ('SM','212','PV25P') 
    and Almacen not in ('R053','','R098')
    GROUP BY Año
    ORDER BY AÑO
    
    ");
    $sql_pedidosly=utf8_decode( "
    
    SELECT SUM(CASE WHEN MES=1 THEN CANTIDAD END)ENERO,
            SUM(CASE WHEN MES=2 THEN CANTIDAD END)FEBRERO,
            SUM(CASE WHEN MES=3 THEN CANTIDAD END)MARZO,
            SUM(CASE WHEN MES=4 THEN CANTIDAD END)ABRIL,
            SUM(CASE WHEN MES=5 THEN CANTIDAD END)MAYO,
            SUM(CASE WHEN MES=6 THEN CANTIDAD END)JUNIO,
            SUM(CASE WHEN MES=7 THEN CANTIDAD END)JULIO,
            SUM(CASE WHEN MES=8 THEN CANTIDAD END)AGOSTO,
            SUM(CASE WHEN MES=9 THEN CANTIDAD END)SEPTIEMBRE,
            SUM(CASE WHEN MES=10 THEN CANTIDAD END)OCTUBRE,
            SUM(CASE WHEN MES=11 THEN CANTIDAD END)NOVIEMBRE,
            SUM(CASE WHEN MES=12 THEN CANTIDAD END)DICIEMBRE
    
    
    
     from ped_compr
    
    
    
    
    WHERE Año ='$beforeyear' AND familia $familia AND Marca   $marca AND Familia NOT IN ('', 'ACCESORIOS', 'BERMUDA', 'BLAZER D', 'BLUSA', 'BOLSA', 'BORDADO', 'CAMISA', 'CHALECOD', 'CINTA', 'CONJUNTO', 'COOR/PANTS', 'CORB&MAN', 'CORBATERO', 'EMPAQUE', 'EQUIPAJE', 
                             'FAJA&MONO', 'FALDA', 'FALDA DAMA', 'GORRA', 'HABILITACION', 'KITSMOKREN', 'MAQUILA', 'PANTALON', 'PANTALON D', 'PANTALON DAMA', 'PANTALOND', 'PAQUETE', 'PIJAMA', 'ROPA INT', 'SACO', 'SACO DAMA', 'SLACK', 
                             'SUDADERA', 'TELA', 'TELAS', 'VARIOS')
    and categoria $tempo
    and Temporada not in ('SM','212','PV25P') 
    and Almacen not in ('R053','','R098')
    
    ");
    
}
//queries***************************************************************************************************************
else{
    
    
    $sql_update=utf8_decode("select anio,
       mes,
       sum( [VTA AJUSTADO]) [VTA AJUSTADO],
       sum([Venta$])[Venta$],
       sum([Costo Vta$])[Costo Vta$],
       sum([Venta$]-[Costo Vta$])[Utilidad],
      -- sum([Venta$[-Costo Vta$[)/sum([Venta$])*100 [MG[,
       sum([COMPRA AJUSTADO])[COMPRA AJUSTADO],
       sum([Compra$])[Compra$]
       
       from (
       
       
select  año as anio,
        mes,
        familia,
        marca,
        sum( venta) [VTA AJUSTADO],
        0'Venta$',
        0'Costo Vta$',        
        sum( compra)[COMPRA AJUSTADO],
        sum(0)'Compra$'
     
    
from sop_bas
where  modelo $modelo and color $color
group by año,mes,familia,marca
        
        
        ) as bd
    
        where familia $familia and marca   $marca  and anio='$year' 
      
        

        
      group by anio,mes  
        
      ");
    $sqlvtareal=utf8_decode( "
       SELECT
     ISNULL(sum(case when mes =1 then [Venta]  END ),0) ENERO,
      ISNULL(sum(case when mes =2 then [Venta] END ),0) FEBRERO,
      ISNULL(sum(case when mes =3 then [Venta] END ),0) MARZO,
      ISNULL(sum(case when mes =4 then [Venta] END ),0) ABRIL,
      ISNULL(sum(case when mes =5 then [Venta] END ),0) MAYO,
      ISNULL(sum(case when mes =6 then [Venta] END ),0) JUNIO,
      ISNULL(sum(case when mes =7 then [Venta] END ),0) JULIO,
     ISNULL( sum(case when mes =8 then [Venta] END ),0) AGOSTO,
      ISNULL(sum(case when mes =9 then [Venta] END ),0) SEPTIEMBRE,
      ISNULL(sum(case when mes =10 then [Venta] END ),0) OCTUBRE,
      ISNULL(sum(case when mes =11 then [Venta] END ),0) NOVIEMBRE,
      ISNULL(sum(case when mes =12 then [Venta] END ),0) DICIEMBRE
  FROM [VtaFamMesTdaSOPMod]
where Familia $familia and [Colección]   $marca  and año ='$year' 
        
  and categoria $tempo and ([No Modelo Habers] $modelo or [Cód. producto proveedor] $modelo) and color $color
        
   ");
    $sqlvtareal_importe=utf8_decode( "
       SELECT
        
        
     ISNULL(sum(case when mes =1 then [Importe]  END ),0) ENERO,
      ISNULL(sum(case when mes =2 then [Importe] END ),0) FEBRERO,
      ISNULL(sum(case when mes =3 then [Importe] END ),0) MARZO,
      ISNULL(sum(case when mes =4 then [Importe] END ),0) ABRIL,
      ISNULL(sum(case when mes =5 then [Importe] END ),0) MAYO,
      ISNULL(sum(case when mes =6 then [Importe] END ),0) JUNIO,
      ISNULL(sum(case when mes =7 then [Importe] END ),0) JULIO,
     ISNULL( sum(case when mes =8 then [Importe] END ),0) AGOSTO,
      ISNULL(sum(case when mes =9 then [Importe] END ),0) SEPTIEMBRE,
      ISNULL(sum(case when mes =10 then [Importe] END ),0) OCTUBRE,
      ISNULL(sum(case when mes =11 then [Importe] END ),0) NOVIEMBRE,
      ISNULL(sum(case when mes =12 then [Importe] END ),0) DICIEMBRE
  FROM [VtaFamMesTdaSOPMod]
where Familia $familia and [Colección]   $marca  and año ='$year'
        
  and categoria $tempo and ([No Modelo Habers] $modelo or [Cód. producto proveedor] $modelo) and color $color
        
   ");
    $sqlvtareal_2019_importe=utf8_decode( "
       SELECT
        
        
     ISNULL(sum(case when mes =1 then [Importe]  END ),0) ENERO,
      ISNULL(sum(case when mes =2 then [Importe] END ),0) FEBRERO,
      ISNULL(sum(case when mes =3 then [Importe] END ),0) MARZO,
      ISNULL(sum(case when mes =4 then [Importe] END ),0) ABRIL,
      ISNULL(sum(case when mes =5 then [Importe] END ),0) MAYO,
      ISNULL(sum(case when mes =6 then [Importe] END ),0) JUNIO,
      ISNULL(sum(case when mes =7 then [Importe] END ),0) JULIO,
     ISNULL( sum(case when mes =8 then [Importe] END ),0) AGOSTO,
      ISNULL(sum(case when mes =9 then [Importe] END ),0) SEPTIEMBRE,
      ISNULL(sum(case when mes =10 then [Importe] END ),0) OCTUBRE,
      ISNULL(sum(case when mes =11 then [Importe] END ),0) NOVIEMBRE,
      ISNULL(sum(case when mes =12 then [Importe] END ),0) DICIEMBRE
  FROM [VtaFamMesTdaSOPMod]
where Familia $familia and [Colección]   $marca  and año ='$beforeyear'
        
  and categoria $tempo and ([No Modelo Habers] $modelo or [Cód. producto proveedor] $modelo) and color $color
        
   ");
    $sqlvtareal_costo=utf8_decode( "
       SELECT
      ISNULL(sum(case when mes =1 then [Costo]  END ),0) ENERO,
      ISNULL(sum(case when mes =2 then [Costo] END ),0) FEBRERO,
      ISNULL(sum(case when mes =3 then [Costo] END ),0) MARZO,
      ISNULL(sum(case when mes =4 then [Costo] END ),0) ABRIL,
      ISNULL(sum(case when mes =5 then [Costo] END ),0) MAYO,
      ISNULL(sum(case when mes =6 then [Costo] END ),0) JUNIO,
      ISNULL(sum(case when mes =7 then [Costo] END ),0) JULIO,
     ISNULL( sum(case when mes =8 then [Costo] END ),0) AGOSTO,
      ISNULL(sum(case when mes =9 then [Costo] END ),0) SEPTIEMBRE,
      ISNULL(sum(case when mes =10 then [Costo] END ),0) OCTUBRE,
      ISNULL(sum(case when mes =11 then [Costo] END ),0) NOVIEMBRE,
      ISNULL(sum(case when mes =12 then [Costo] END ),0) DICIEMBRE
  FROM [VtaFamMesTdaSOPMod]
where Familia $familia and [Colección]   $marca  and año ='$year'
        
  and categoria $tempo and ([No Modelo Habers] $modelo or [Cód. producto proveedor] $modelo) and color $color
        
   ");
    $sqlvtareal_util=utf8_decode( "
       SELECT
        
        
         ISNULL(sum(case when mes =1 then [Util]  END ),0) ENERO,
      ISNULL(sum(case when mes =2 then [Util] END ),0) FEBRERO,
      ISNULL(sum(case when mes =3 then [Util] END ),0) MARZO,
      ISNULL(sum(case when mes =4 then [Util] END ),0) ABRIL,
      ISNULL(sum(case when mes =5 then [Util] END ),0) MAYO,
      ISNULL(sum(case when mes =6 then [Util] END ),0) JUNIO,
      ISNULL(sum(case when mes =7 then [Util] END ),0) JULIO,
     ISNULL( sum(case when mes =8 then [Util] END ),0) AGOSTO,
      ISNULL(sum(case when mes =9 then [Util] END ),0) SEPTIEMBRE,
      ISNULL(sum(case when mes =10 then [Util] END ),0) OCTUBRE,
      ISNULL(sum(case when mes =11 then [Util] END ),0) NOVIEMBRE,
      ISNULL(sum(case when mes =12 then [Util] END ),0) DICIEMBRE
   FROM [VtaFamMesTdaSOPMod]
where Familia $familia and [Colección]   $marca  and año ='$year'
        
  and categoria $tempo and ([No Modelo Habers] $modelo or [Cód. producto proveedor] $modelo) and color $color
        
   ");
    $sqlvtareally=utf8_decode( "
        SELECT
        ISNULL(sum(case when mes =1 then [Venta]  END ),0) ENERO,
      ISNULL(sum(case when mes =2 then [Venta] END ),0) FEBRERO,
      ISNULL(sum(case when mes =3 then [Venta] END ),0) MARZO,
      ISNULL(sum(case when mes =4 then [Venta] END ),0) ABRIL,
      ISNULL(sum(case when mes =5 then [Venta] END ),0) MAYO,
      ISNULL(sum(case when mes =6 then [Venta] END ),0) JUNIO,
      ISNULL(sum(case when mes =7 then [Venta] END ),0) JULIO,
     ISNULL( sum(case when mes =8 then [Venta] END ),0) AGOSTO,
      ISNULL(sum(case when mes =9 then [Venta] END ),0) SEPTIEMBRE,
      ISNULL(sum(case when mes =10 then [Venta] END ),0) OCTUBRE,
      ISNULL(sum(case when mes =11 then [Venta] END ),0) NOVIEMBRE,
      ISNULL(sum(case when mes =12 then [Venta] END ),0) DICIEMBRE
         FROM [VtaFamMesTdaSOPMod]
where Familia $familia and [Colección]   $marca  and año ='$beforeyear'
        
  and categoria $tempo and ([No Modelo Habers] $modelo or [Cód. producto proveedor] $modelo) and color $color
        GROUP BY AÑO
        ORDER BY  AÑO
");
    $sqlvta= utf8_decode( " SELECT
        
   sum(case when mes =1 then venta END ) ENERO,
      sum(case when mes =2 then venta END ) FEBRERO,
      sum(case when mes =3 then venta END ) MARZO,
      sum(case when mes =4 then venta END ) ABRIL,
      sum(case when mes =5 then [venta] END ) MAYO,
      sum(case when mes =6 then [venta] END ) JUNIO,
      sum(case when mes =7 then [venta] END ) JULIO,
      sum(case when mes =8 then [venta] END ) AGOSTO,
      sum(case when mes =9 then [venta] END ) SEPTIEMBRE,
      sum(case when mes =10 then [venta] END ) OCTUBRE,
      sum(case when mes =11 then [venta] END ) NOVIEMBRE,
      sum(case when mes =12 then [venta] END ) DICIEMBRE
FROM
sop_bas
WHERE
  año='$year' AND Familia $familia and Marca   $marca  and modelo $modelo and color $color
 GROUP BY año
        
   ORDER BY  año
");
    $sqlcompra= utf8_decode( " SELECT
        
sum(case when mes =1 then [compra] END ) ENERO,
      sum(case when mes =2 then [compra] END ) FEBRERO,
      sum(case when mes =3 then [compra] END ) MARZO,
      sum(case when mes =4 then [compra] END ) ABRIL,
      sum(case when mes =5 then [compra] END ) MAYO,
      sum(case when mes =6 then [compra] END ) JUNIO,
      sum(case when mes =7 then [compra] END ) JULIO,
      sum(case when mes =8 then [compra] END ) AGOSTO,
      sum(case when mes =9 then [compra] END ) SEPTIEMBRE,
      sum(case when mes =10 then [compra] END ) OCTUBRE,
      sum(case when mes =11 then [compra] END ) NOVIEMBRE,
      sum(case when mes =12 then [compra] END ) DICIEMBRE
FROM
 sop_bas
WHERE
  año='$year' AND Familia $familia and Marca   $marca  and modelo $modelo and color $color
GROUP BY
  año;
        
        
  ");
    $sqlcomprareal= utf8_decode( "  SELECT SUM(case when mes=1 then compra end) Enero,
SUM(case when mes=2 then compra end) Febrero,
SUM(case when mes=3 then compra end) Marzo,
SUM(case when mes=4 then compra end) Abril,
SUM(case when mes=5 then compra end) Mayo,
SUM(case when mes=6 then compra end) Junio,
SUM(case when mes=7 then compra end) Julio,
SUM(case when mes=8 then compra end) Agosto,
SUM(case when mes=9 then compra end) Septiembre,
SUM(case when mes=10 then compra end) Octubre,
SUM(case when mes=11 then compra end) Noviembre,
SUM(case when mes=12 then compra end) Diciembre
        
        
  FROM [ExisFamMesTdaMod]
  where familia $familia and Colección   $marca  and año=$year AND Familia not in( 'BOLECOACC')
  and categoria $tempo and (modelo_haber $modelo OR Modelo $modelo) and color $color
        
        
  " );
    $sqlcomprareal_importe= utf8_decode( "
        
select
        
convert(int,Sum(case when MONTH([Fecha Registro]) =1 then [Importe base IVA]  END)) 'ENERO',
convert(int,Sum(case when MONTH([Fecha Registro]) =2 then [Importe base IVA]  END)) 'FEBRERO',
convert(int,Sum(case when MONTH([Fecha Registro]) =3 then [Importe base IVA]  END)) 'MARZO',
convert(int,Sum(case    when MONTH([Fecha Registro]) =4 then [Importe base IVA]  END))'ABRIL',
convert(int,Sum(case    when MONTH([Fecha Registro]) =5 then [Importe base IVA]  END)) 'MAYO',
convert(int,Sum(case    when MONTH([Fecha Registro]) =6 then [Importe base IVA]  END)) 'JUNIO',
convert(int,Sum(case    when MONTH([Fecha Registro]) =7 then [Importe base IVA] END)) 'JULIO',
convert(int,Sum(case    when MONTH([Fecha Registro]) =8 then [Importe base IVA]  END)) 'AGOSTO',
convert(int,Sum(case    when MONTH([Fecha Registro]) =9 then [Importe base IVA]  END)) 'SEPTIEMBRE',
convert(int,Sum(case    when MONTH([Fecha Registro]) =10 then [Importe base IVA] END)) 'OCTUBRE',
convert(int,Sum(case    when MONTH([Fecha Registro]) =11 then  [Importe base IVA]    END)) 'NOVIEMBRE',
convert(int,Sum(case    when MONTH([Fecha Registro]) =12 then  [Importe base IVA]    END)) 'DICIEMBRE'
        
        
        
        
from [Recepciones de Compra] H join PRODUCTO_LOGISTICA Pr on H.[Nº referencia cruzada] collate Latin1_General_100_CI_AS =Pr.Nº
        
 where Pr.familia $familia and Pr.Colección   $marca  and  year([Fecha Registro]) =$year AND Pr.familia not in( 'BOLECOACC')
        
and categoria $tempo and (pr.[No Modelo Habers] $modelo or pr.[Cód. producto proveedor] $modelo) and pr.color $color
and H.[Cód. almacén] not in ('SM','212','PV25P') 
and H.Temporada not in     ('R053','','R098')   
        
        
  " );
    $sqlcomprareally= utf8_decode( "
select
        
convert(int,Sum(case when MONTH([Fecha Registro]) =1 then CASE WHEN [Cantidad facturada]IS NULL OR [Cantidad facturada]=0 THEN [Cantidad recibida no facturada]  ELSE [Cantidad facturada] END  END)) 'ENERO',
convert(int,Sum(case when MONTH([Fecha Registro]) =2 then CASE WHEN [Cantidad facturada]IS NULL OR [Cantidad facturada]=0 THEN [Cantidad recibida no facturada]  ELSE [Cantidad facturada] END  END)) 'FEBRERO',
convert(int,Sum(case when MONTH([Fecha Registro]) =3 then CASE WHEN [Cantidad facturada]IS NULL OR [Cantidad facturada]=0 THEN [Cantidad recibida no facturada]  ELSE [Cantidad facturada] END  END)) 'MARZO',
convert(int,Sum(case    when MONTH([Fecha Registro]) =4 then CASE WHEN [Cantidad facturada]IS NULL OR [Cantidad facturada]=0 THEN [Cantidad recibida no facturada]  ELSE [Cantidad facturada] END  END))'ABRIL',
convert(int,Sum(case    when MONTH([Fecha Registro]) =5 then CASE WHEN [Cantidad facturada]IS NULL OR [Cantidad facturada]=0 THEN [Cantidad recibida no facturada]  ELSE [Cantidad facturada] END  END)) 'MAYO',
convert(int,Sum(case    when MONTH([Fecha Registro]) =6 then CASE WHEN [Cantidad facturada]IS NULL OR [Cantidad facturada]=0 THEN [Cantidad recibida no facturada]  ELSE [Cantidad facturada] END  END)) 'JUNIO',
convert(int,Sum(case    when MONTH([Fecha Registro]) =7 then CASE WHEN [Cantidad facturada]IS NULL OR [Cantidad facturada]=0 THEN [Cantidad recibida no facturada]  ELSE [Cantidad facturada] END  END)) 'JULIO',
convert(int,Sum(case    when MONTH([Fecha Registro]) =8 then CASE WHEN [Cantidad facturada]IS NULL OR [Cantidad facturada]=0 THEN [Cantidad recibida no facturada]  ELSE [Cantidad facturada] END  END)) 'AGOSTO',
convert(int,Sum(case    when MONTH([Fecha Registro]) =9 then CASE WHEN [Cantidad facturada]IS NULL OR [Cantidad facturada]=0 THEN [Cantidad recibida no facturada]  ELSE [Cantidad facturada] END  END)) 'SEPTIEMBRE',
convert(int,Sum(case    when MONTH([Fecha Registro]) =10 then CASE WHEN [Cantidad facturada]IS NULL OR [Cantidad facturada]=0 THEN [Cantidad recibida no facturada]  ELSE [Cantidad facturada] END END)) 'OCTUBRE',
convert(int,Sum(case    when MONTH([Fecha Registro]) =11 then CASE WHEN [Cantidad facturada]IS NULL OR [Cantidad facturada]=0 THEN [Cantidad recibida no facturada]  ELSE [Cantidad facturada] END  END)) 'NOVIEMBRE',
convert(int,Sum(case    when MONTH(CASE WHEN [Cantidad facturada]IS NULL OR [Cantidad facturada]=0 THEN [Cantidad recibida no facturada]  ELSE [Cantidad facturada] END ) =12 then [Cantidad facturada] END)) 'DICIEMBRE'
        
        
        
        
from [Recepciones de Compra] H join PRODUCTO_LOGISTICA Pr on H.[Nº referencia cruzada] collate Latin1_General_100_CI_AS =Pr.Nº
        
 where Pr.familia $familia and Pr.Colección   $marca  and  year([Fecha Registro]) =$beforeyear AND Pr.familia not in( 'BOLECOACC')
and categoria $tempo and (pr.[No Modelo Habers] $modelo or pr.[Cód. producto proveedor] $modelo) and pr.color $color
and H.[Cód. almacén] not in ('SM','212','PV25P') 
and H.Temporada not in      ('R053','','R098')  
        
  ");
    $sqlinvinicial= utf8_decode( "
        
declare @mes int;
set @mes='$lastm'
        
if  @mes > 1
        
        
select SUM(EXISTENCIA)EXISTENCIA,AÑO,MES FROM [ExisFamMesTdaMod]
        
  where  Familia $familia and Colección   $marca  and AÑO ='$beforeyear' and MES =12
    and categoria $tempo and (modelo_haber $modelo OR Modelo $modelo) and color $color
  GROUP BY AÑO,MES
        
  union
        
  SELECT  SUM(EXISTENCIA)EXISTENCIA,AÑO,MES FROM [ExisFamMesTdaMod]
        
  where Familia $familia and Colección   $marca  and AÑO ='$year' and mes <@mes
    and categoria $tempo and (modelo_haber $modelo OR Modelo $modelo) and color $color
  GROUP BY AÑO,MES
        
        
  order by año,mes
        
        
        
  else
        
        
        
  select SUM(EXISTENCIA)EXISTENCIA,AÑO,MES FROM [ExisFamMesTdaMod]
        
  where  Familia $familia and Colección   $marca  and AÑO ='$beforeyear' and MES =12
  and categoria $tempo and (modelo_haber $modelo OR Modelo $modelo) and color $color
  GROUP BY AÑO,MES
        
        
  order by año,mes
        
        
        
  ");
    $sqlinvinicial_costo= utf8_decode( "
        
declare @mes int;
set @mes='$lastm'
        
if  @mes > 1
        
        
select SUM(CostoInv)EXISTENCIA,AÑO,MES FROM [ExisFamMesTdaMod]
        
  where  Familia $familia and Colección   $marca  and AÑO ='$beforeyear' and MES =12
   and categoria $tempo and (modelo_haber $modelo OR Modelo $modelo) and color $color
   GROUP BY AÑO,MES
        
  union
        
  SELECT  SUM(CostoInv)EXISTENCIA,AÑO,MES FROM [ExisFamMesTdaMod]
        
  where Familia $familia and Colección   $marca  and AÑO ='$year' and mes <@mes
  and categoria $tempo and (modelo_haber $modelo OR Modelo $modelo) and color $color
  GROUP BY AÑO,MES
        
        
  order by año,mes
        
  else
        
  select SUM(CostoInv)EXISTENCIA,AÑO,MES FROM [ExisFamMesTdaMod]
        
  where  Familia $familia  and Colección   $marca  and AÑO ='$beforeyear' and MES =12
    and categoria $tempo and (modelo_haber $modelo OR Modelo $modelo) and color $color
  GROUP BY AÑO,MES
        
        
  order by año,mes
        
        
        
  ");
    $sqlinvinicially= utf8_decode( "
        
select ISNULL (SUM(EXISTENCIA),0)EXISTENCIA,AÑO,MES FROM [ExisFamMesTdaMod]
        
  where  Familia $familia and Colección   $marca  and AÑO ='$beforeyearly' and MES =12
  and categoria $tempo and (modelo_haber $modelo OR Modelo $modelo) and color $color
GROUP BY AÑO,MES
        
  union
        
  SELECT  ISNULL (SUM(EXISTENCIA),0)EXISTENCIA,AÑO,MES FROM [ExisFamMesTdaMod]
        
   where  Familia $familia and Colección   $marca  and AÑO = '$beforeyear' AND MES <=11
    and categoria $tempo and (modelo_haber $modelo OR Modelo $modelo) and color $color
  GROUP BY AÑO,MES
   ORDER BY AÑO,MES
        
        
  ");
    $sqlvtanxtyear= utf8_decode(" SELECT
        
  sum(case when mes =1 then [venta] END ) ENERO,
	  sum(case when mes =2 then [venta] END ) FEBRERO,
	  sum(case when mes =3 then [venta] END ) MARZO,
	  sum(case when mes =4 then [venta] END ) ABRIL,
	  sum(case when mes =5 then [venta] END ) MAYO,
	  sum(case when mes =6 then [venta] END ) JUNIO,
	  sum(case when mes =7 then [venta] END ) JULIO,
	  sum(case when mes =8 then [venta] END ) AGOSTO,
	  sum(case when mes =9 then [venta] END ) SEPTIEMBRE,
	  sum(case when mes =10 then [venta] END ) OCTUBRE,
	  sum(case when mes =11 then [venta] END ) NOVIEMBRE,
	  sum(case when mes =12 then [venta] END ) DICIEMBRE
FROM
sop_bas
WHERE
  año='$nxyear' AND Familia $familia and Marca   $marca  and modelo $modelo and color $color
 GROUP BY año
        
        
        
   ORDER BY  año
        
   ");
    $sqlcompnxtyear= utf8_decode( " SELECT
        
   sum(case when mes =1 then [COMPRA] END ) ENERO,
	  sum(case when mes =2 then [COMPRA] END ) FEBRERO,
	  sum(case when mes =3 then [COMPRA] END ) MARZO,
	  sum(case when mes =4 then [COMPRA] END ) ABRIL,
	  sum(case when mes =5 then [COMPRA] END ) MAYO,
	  sum(case when mes =6 then [COMPRA] END ) JUNIO,
	  sum(case when mes =7 then [COMPRA] END ) JULIO,
	  sum(case when mes =8 then [COMPRA] END ) AGOSTO,
	  sum(case when mes =9 then [COMPRA] END ) SEPTIEMBRE,
	  sum(case when mes =10 then [COMPRA] END ) OCTUBRE,
	  sum(case when mes =11 then [COMPRA] END ) NOVIEMBRE,
	  sum(case when mes =12 then [COMPRA] END ) DICIEMBRE
FROM
sop_bas
WHERE
  año='$nxyear' AND Familia $familia and Marca   $marca  and modelo $modelo and color $color
GROUP BY
  AÑO;
        
        
  ");
    $sqlvtanxtyear2= utf8_decode(" SELECT
        
   sum(case when mes =1 then [venta] END ) ENERO,
	  sum(case when mes =2 then [venta] END ) FEBRERO,
	  sum(case when mes =3 then [venta] END ) MARZO,
	  sum(case when mes =4 then [venta] END ) ABRIL,
	  sum(case when mes =5 then [venta] END ) MAYO,
	  sum(case when mes =6 then [venta] END ) JUNIO,
	  sum(case when mes =7 then [venta] END ) JULIO,
	  sum(case when mes =8 then [venta] END ) AGOSTO,
	  sum(case when mes =9 then [venta] END ) SEPTIEMBRE,
	  sum(case when mes =10 then [venta] END ) OCTUBRE,
	  sum(case when mes =11 then [venta] END ) NOVIEMBRE,
	  sum(case when mes =12 then [venta] END ) DICIEMBRE
FROM
sop_bas
WHERE
  AÑO='".($nxyear+1) ."' AND Familia $familia and Marca   $marca and modelo $modelo and color $color
 GROUP BY AÑO     
   ORDER BY  AÑO
        
   ");
    $sqlcompnxtyear2= utf8_decode( " SELECT
        
    sum(case when mes =1 then [COMPRA] END ) ENERO,
	  sum(case when mes =2 then [COMPRA] END ) FEBRERO,
	  sum(case when mes =3 then [COMPRA] END ) MARZO,
	  sum(case when mes =4 then [COMPRA] END ) ABRIL,
	  sum(case when mes =5 then [COMPRA] END ) MAYO,
	  sum(case when mes =6 then [COMPRA] END ) JUNIO,
	  sum(case when mes =7 then [COMPRA] END ) JULIO,
	  sum(case when mes =8 then [COMPRA] END ) AGOSTO,
	  sum(case when mes =9 then [COMPRA] END ) SEPTIEMBRE,
	  sum(case when mes =10 then [COMPRA] END ) OCTUBRE,
	  sum(case when mes =11 then [COMPRA] END ) NOVIEMBRE,
	  sum(case when mes =12 then [COMPRA] END ) DICIEMBRE
FROM
sop_bas
WHERE
  año='".($nxyear+1) ."' AND Familia $familia and Marca   $marca and modelo $modelo and color $color
GROUP BY
  AÑO;
        
        
  ");
    $sql_pedidosay=utf8_decode( "
        
SELECT año, SUM(CASE WHEN MES=1 THEN CANTIDAD END)ENERO,
        SUM(CASE WHEN MES=2 THEN CANTIDAD END)FEBRERO,
        SUM(CASE WHEN MES=3 THEN CANTIDAD END)MARZO,
        SUM(CASE WHEN MES=4 THEN CANTIDAD END)ABRIL,
        SUM(CASE WHEN MES=5 THEN CANTIDAD END)MAYO,
        SUM(CASE WHEN MES=6 THEN CANTIDAD END)JUNIO,
        SUM(CASE WHEN MES=7 THEN CANTIDAD END)JULIO,
        SUM(CASE WHEN MES=8 THEN CANTIDAD END)AGOSTO,
        SUM(CASE WHEN MES=9 THEN CANTIDAD END)SEPTIEMBRE,
        SUM(CASE WHEN MES=10 THEN CANTIDAD END)OCTUBRE,
        SUM(CASE WHEN MES=11 THEN CANTIDAD END)NOVIEMBRE,
        SUM(CASE WHEN MES=12 THEN CANTIDAD END)DICIEMBRE
        
        
        
 from ped_compr
        
        
        
        
WHERE Año >='$year' AND Familia $familia AND Marca $marca AND familia not in( 'BOLECOACC')
and categoria $tempo and ([No Modelo Habers] $modelo or [Cód. producto proveedor] $modelo) and color $color
    and Temporada not in ('SM','212','PV25P') 
    and Almacen not in   ('R053','','R098')
        
 GROUP BY Año
        
        
                         ORDER BY AÑO
        
        
        
");
    $sql_pedidosly=utf8_decode( "
SELECT SUM(CASE WHEN MES=1 THEN CANTIDAD END)ENERO,
        SUM(CASE WHEN MES=2 THEN CANTIDAD END)FEBRERO,
        SUM(CASE WHEN MES=3 THEN CANTIDAD END)MARZO,
        SUM(CASE WHEN MES=4 THEN CANTIDAD END)ABRIL,
        SUM(CASE WHEN MES=5 THEN CANTIDAD END)MAYO,
        SUM(CASE WHEN MES=6 THEN CANTIDAD END)JUNIO,
        SUM(CASE WHEN MES=7 THEN CANTIDAD END)JULIO,
        SUM(CASE WHEN MES=8 THEN CANTIDAD END)AGOSTO,
        SUM(CASE WHEN MES=9 THEN CANTIDAD END)SEPTIEMBRE,
        SUM(CASE WHEN MES=10 THEN CANTIDAD END)OCTUBRE,
        SUM(CASE WHEN MES=11 THEN CANTIDAD END)NOVIEMBRE,
        SUM(CASE WHEN MES=12 THEN CANTIDAD END)DICIEMBRE
        
        
        
 from ped_compr
        
        
        
        
WHERE Año ='$beforeyear' AND Familia $familia AND Marca $marca AND familia not in( 'BOLECOACC')
and categoria $tempo and ([No Modelo Habers] $modelo or [Cód. producto proveedor] $modelo) and color $color
and Temporada not in ('SM','212','PV25P') 
    and Almacen not in ('R053','','R098')
        
        
");
}



//ejecucion y obtencion de resultados postqueries***********************************************************************
$historico=execonsultasqlsrv($sqlvtareal,$conexion,$historico);

$vta_importe_act=execonsultasqlsrv($sqlvtareal_importe,$conexion,$vta_importe_act);

$vta_importe_2019_act=execonsultasqlsrv($sqlvtareal_2019_importe,$conexion,$vta_importe_2019_act);

$vta_costo_act=execonsultasqlsrv($sqlvtareal_costo,$conexion,$vta_costo_act);

$vta_util_act=execonsultasqlsrv($sqlvtareal_util,$conexion,$vta_util_act);

$vtajustado=execonsultasqlsrv($sqlvta,$conexion,$vtajustado);



$comprareal=execonsultasqlsrv($sqlcomprareal,$conexion,$comprareal);

$comprareal_importe=execonsultasqlsrv($sqlcomprareal_importe,$conexion,$comprareal_importe);
$comprareally=execonsultasqlsrv($sqlcomprareally,$conexion,$comprareally);
$inly=execonsultasqlsrv($sqlinvinicially,$conexion,$inly);
$compra=execonsultasqlsrv($sqlcompra,$conexion,$compra);


$update_sop=execonsultasqlsrv($sql_update,$conexion,$update_sop);

$exisfinal=execonsultasqlsrv($sqlinvinicial,$conexion,$exisfinal);

$exisfinal_costo=execonsultasqlsrv($sqlinvinicial_costo,$conexion,$exisfinal_costo);
$rawpedidosay=execonsultasqlsrv($sql_pedidosay,$conexion,$rawpedidosay);
$rawpedidosly=execonsultasqlsrv($sql_pedidosly,$conexion,$rawpedidosly);




$resultpx2 = sqlsrv_query($conexion,$sqlvtanxtyear2);
$comprapx2 = sqlsrv_query($conexion,$sqlcompnxtyear2);
$res2 = count($resultpx2);
$resc2 = count($comprapx2);
$resultpx = sqlsrv_query($conexion,$sqlvtanxtyear);
$comprapx = sqlsrv_query($conexion,$sqlcompnxtyear);
$res = count($resultpx);
$resc = count($comprapx);

//asignacion de filas y columnas****************************************************************************************
$excolumnas = count($exisfinal[0])/2;///2;
$exfilas = count($exisfinal);
$importe_plan=[];
$compra_plan=[];
$costo_plan=[];
$utilidad_plan=[];
$vta_actual=[];
$cmp_actual=[];
$cmp_ppto=[];
for($i=0;$i<count($update_sop);$i++){



    $importe_plan[]=$update_sop[$i]['Venta$'];
    $compra_plan[]=$update_sop[$i]['Compra$'];
    $costo_plan[]=$update_sop[$i]['Costo Vta$'];
    $utilidad_plan[]=$update_sop[$i]['Utilidad'];



}
$nombremeses= array(
    "'ENERO'",
    "'FEBRERO'",
    "'MARZO'",
    "'ABRIL'",
    "'MAYO'",
    "'JUNIO'",
    "'JULIO'",
    "'AGOSTO'",
    "'SEPTIEMBRE'",
    " 'OCTUBRE'",
    " 'NOVIEMBRE'",
    "'DICIEMBRE'"
);
$columnas = count($nombremeses);///2;
$filas = count($historico);
$namecolumn1.="'ENERO','FEBRERO','MARZO','ABRIL','MAYO','JUNIO','JULIO','AGOSTO','SEPTIEMBRE','OCTUBRE','NOVIEMBRE','DICIEMBRE',";

$columnname24="["."' '".",".$namecolumn1."'TOTAL".$year."',".$namecolumn1."'TOTAL".$nxyear."','TOTAL' ],";
$columnname12="["."' '".",".$namecolumn1."'TOTAL'],";
//se unifica la cantidad de meses existentes, despues esta variable se ocupara en el ciclo correspondiente si la consulta de planeacion presupuestos tiene datos existentes en el año proximo al actual
$nmes=array_values(array_merge ($nombremeses,$nombremeses));
//el mes actual es distinto del mes primero
switch ($year){
    case $year<$actuallyear :
        for ($i=0;$i<$filas;$i++) {
            for ($j = 0; $j < $columnas; $j++) {
                array_push($cmpr, intval( $comprareal[$i][$j]));//compra
                array_push($compra_ly, intval( $comprareally[$i][$j]));
                array_push($vta, intval($historico[$i][$j]));//venta
                array_push($importe_act,  intval($vta_importe_act[0][$j]) );
                array_push($importe_act_2019,  intval($vta_importe_2019_act[0][$j]) );
                array_push($costo_act,  intval($vta_costo_act[0][$j]) );
                array_push($util_act,  intval($vta_util_act[0][$j]) );
                array_push( $compra_act,  intval($comprareal_importe  [0][$j]) );
            }
        }
        break;
    case $year>=$actuallyear :
        switch($lastm){
            case $lastm>1   :
                $beforemonth=$lastm-1;//entonces el mes anterior no inicializara en 0
                for ($i=0;$i<$filas;$i++) {

                    for ($j = 0; $j < $columnas; $j++) {

                        if ($j < $beforemonth) {//se recorren los meses ingresando datos a un arreglo que acumula las compras reales hasta el mes anterior al actual y terminando el bucle con la compra de el plan ajustado

                            array_push($cmpr, intval( $comprareal[$i][$j]));//compra
                            //array_push($cmpr, intval( $compra[$i][$j]));//compra

                            array_push($compra_ly, intval( $comprareally[$i][$j]));
                            array_push($vta, intval($historico[$i][$j]));//venta
                            array_push($importe_act,  intval($vta_importe_act[0][$j]) );
                            array_push($costo_act,  intval($vta_costo_act[0][$j]) );
                            array_push($util_act,  intval($vta_util_act[0][$j]) );
                            array_push( $compra_act,  intval($comprareal_importe  [0][$j]) );
                            array_push($importe_act_2019,  intval($vta_importe_2019_act[0][$j]) );

                        }
                        /*elseif($j == $beforemonth) {


                            if( intval( $comprareal[$i][$j])>0){
                                array_push($cmpr, intval( $comprareal[$i][$j]));
                            }
                            else{

                                switch($compra[$i][$j]) {
                                    case $compra[$i][$j]=="" or  is_null($compra [$i][$j]):
                                        array_push($cmpr, 0 );
                                        break;
                                    default :
                                        array_push($cmpr, intval( $compra[$i][$j]) );
                                }
                            }



                            switch($comprareally[$i][$j]) {
                                case $comprareally[$i][$j]=="" or  is_null($comprareally[$i][$j]):
                                    array_push($compra_ly,0);
                                    break;
                                default :
                                    array_push($compra_ly, intval( $comprareally[$i][$j]));
                            }
                            switch($vtajustado[$i][$j]) {
                                case $vtajustado[$i][$j]=="" or  is_null($vtajustado[$i][$j]):
                                    array_push($vta, 0);
                                    break;
                                default :
                                    array_push($vta, intval( $vtajustado[$i][$j]) );
                            }

                            array_push($importe_act_2019,  intval($vta_importe_2019_act[0][$j]) );
                            array_push($importe_act,intval($importe_plan [$j]) );
                            array_push($costo_act,intval( $costo_plan[$j]) );
                            array_push($util_act,intval($utilidad_plan[$j]) );
                            array_push( $compra_act,  intval($compra_plan[$j]) );

                        }*/
                        else {

                            switch($compra[$i][$j]) {
                                case $compra[$i][$j]=="" or  is_null($compra [$i][$j]):
                                    array_push($cmpr, 0 );

                                    break;
                                default :
                                    array_push($cmpr, intval( $compra[$i][$j]) );


                            }
                            switch($comprareally[$i][$j]) {
                                case $comprareally[$i][$j]=="" or  is_null($comprareally[$i][$j]):

                                    array_push($compra_ly,0);
                                    break;
                                default :

                                    array_push($compra_ly, intval( $comprareally[$i][$j]));

                            }
                            switch($vtajustado[$i][$j]) {
                                case $vtajustado[$i][$j]=="" or  is_null($vtajustado[$i][$j]):
                                    array_push($vta, 0);

                                    break;
                                default :
                                    array_push($vta, intval( $vtajustado[$i][$j]) );

                            }

                            array_push($importe_act_2019,  intval($vta_importe_2019_act[0][$j]) );
                            array_push($importe_act,intval($importe_plan [$j]) );
                            array_push($costo_act,intval( $costo_plan[$j]) );
                            array_push($util_act,intval($utilidad_plan[$j]) );
                            array_push( $compra_act,  intval($compra_plan[$j]) );

                        }

                        switch($comprareal[$i][$j]) {
                            case $comprareal[$i][$j]=="" or  is_null($comprareal [$i][$j]):
                                array_push($cmp_actual, 0 );

                                break;
                            default :
                                array_push($cmp_actual, intval( $comprareal[$i][$j]) );


                        }
                        switch($compra[$i][$j]) {
                            case $compra[$i][$j]=="" or  is_null($compra [$i][$j]):
                                array_push($cmp_ppto, 0 );

                                break;
                            default :
                                array_push($cmp_ppto, intval( $compra[$i][$j]) );


                        }

                    }

                }
                break;
            case 1:

                //se asigna al mes anterior es decir el mes primero ,con esto inicia la venta del año y se ingresa a el arreglo prueba los datos de el plan ajustado
                for ($i=0;$i<$filas;$i++) {

                    for ($j = 0; $j < 12; $j++) {

                        switch($comprareal[$i][$j]) {
                            case $comprareal[$i][$j]=="" or  is_null($comprareal [$i][$j]):
                                array_push($cmp_actual, 0 );

                                break;
                            default :
                                array_push($cmp_actual, intval( $comprareal[$i][$j]) );


                        }
                        switch($compra[$i][$j]) {
                            case $compra[$i][$j]=="" or  is_null($compra [$i][$j]):
                                array_push($cmpr, 0 );

                                break;
                            default :
                                array_push($cmpr, intval( $compra[$i][$j]) );


                        }

                        switch($compra[$i][$j]) {
                            case $compra[$i][$j]=="" or  is_null($compra [$i][$j]):
                                array_push($cmp_ppto, 0 );

                                break;
                            default :
                                array_push($cmp_ppto, intval( $compra[$i][$j]) );


                        }
                        switch($comprareally[$i][$j]) {
                            case $comprareally[$i][$j]=="" or  is_null($comprareally[$i][$j]):

                                array_push($compra_ly,0);
                                break;
                            default :

                                array_push($compra_ly, intval( $comprareally[$i][$j]));

                        }
                        switch($vtajustado[$i][$j]) {
                            case $vtajustado[$i][$j]=="" or  is_null($vtajustado[$i][$j]):
                                array_push($vta, 0);

                                break;
                            default :
                                array_push($vta, intval( $vtajustado[$i][$j]) );

                        }
                        array_push($importe_act_2019,  intval($vta_importe_2019_act[0][$j]) );
                        array_push($importe_act,intval($importe_plan [$j]) );
                        array_push($costo_act,intval( $costo_plan[$j]) );
                        array_push($util_act,intval($utilidad_plan[$j]) );
                        array_push( $compra_act,  intval($compra_plan[$j]) );


                    }

                }
                break;
        }
        break;
}
//si el resultado de la venta ajustada ,la compra ajustada es mayor a 0 para verificar que existan datos y el proximo año es mayor al año actual
if ($res != 0 and $resc != 0 and $nxyear>$actuallyear ) {
    $columnname=$columnname24;//si existe resultado del año proximo se asignan 24 meses como columnas para generar las tablas finales
    $i=0;//importante todos los bucles while deben inicializarze antes con un ilterador en 0 , en caso omiso este bucle no se ejecutara
    //se acumulan los registros arrojados de la consulta venta ajustada del año proximo en una nueva variable $añoresult
    while ($row1 = sqlsrv_fetch_array($resultpx)) {

        $añoresult[]  = $row1;

        $i++;


    }
    $i=0;
    //se acumulan los registros arrojados de la consulta compra ajustada del año proximo en una nueva variable $compraresult
    while($row = sqlsrv_fetch_array($comprapx))
    {
        $compraresult[] = $row ;
        $i++;

    }
    $i=0;
    //se acumulan los registros arrojados de la consulta compra ajustada del año proximo en una nueva variable $compraresult
    if($res2 != 0 and $resc2 != 0){
    $i=0;//importante todos los bucles while deben inicializarze antes con un ilterador en 0 , en caso omiso este bucle no se ejecutara
    //se acumulan los registros arrojados de la consulta venta ajustada del año proximo en una nueva variable $añoresult
    while ($row1 = sqlsrv_fetch_array($resultpx2)) {

        $añoresult[]  = $row1;

        $i++;


    }
    $i=0;
    //se acumulan los registros arrojados de la consulta compra ajustada del año proximo en una nueva variable $compraresult
    while($row = sqlsrv_fetch_array($comprapx2))
    {
        $compraresult[] = $row ;
        $i++;

    }

}
    //asignacion de filas y columnas
    $rscolumnas = count($añoresult[0])/2;///2;
    $rsfilas = count($añoresult);
    $crcolumnas = count($compraresult[0])/2;///2;
    $crfilas = count($compraresult);
    //en el siguiente bucle se acumula a las variables $resultpxaño(venta) ,$comprapxaño(compra), la venta y la compra del año actual ya junto con el acumulado del plan ajustado si este fuese el caso
    for ($i=0;$i<count($vta);$i++)
    {
        array_push( $resultpxaño,$vta[$i]);
        array_push( $comprapxaño,$cmpr[$i]);
        array_push( $comprapxaño_ly,$compra_ly[$i]  );
    }
    //en el siguiente bucle se acumula a las variables $resultpxaño(venta) ,$comprapxaño(compra), la venta y la compra del año proximo del plan ajustado
    for($i=0;$i<$rsfilas;$i++){
        for ($j=0;$j<$rscolumnas;$j++){
            array_push($resultpxaño,$añoresult[$i][$j]);
            array_push($comprapxaño,$compraresult[$i][$j]);
            array_push( $comprapxaño_ly,$cmpr[$j]);
            array_push($cmp_ppto,$compraresult[$i][$j]);
        }
    }
    $cmp_ppto= array_values($cmp_ppto);
    //se asigna el rango del nuestro ilterador para recorrer todos los bucles donde se realizaran nuestros calculos(24 meses)
    $large =count($resultpxaño);
    //aqui recibimos el resultado de nuestra consulta del año anterior desde el mes de diciembre hasta el mes actual para obtener el inventario inicial y empezar a calcular el resto de los meses.
    for($i=0;$i</*$exfilas*/13;$i++){
        for ($j=0;$j<1;$j++){

            if($i==0){
                array_push($invinicial, $exisfinal[$i][$j]);
                array_push($invinicial_upd, $exisfinal[$i][$j]);

            }
            else{
                array_push($invinicial, 0);
                array_push($invinicial_upd, $exisfinal[$i][$j]);

            }

            array_push($invinicial_costo, $exisfinal_costo [$i][$j]);
        }
    }
// en el siguiente bucle calculamos el inventario inicial e inventario final
//recordar que aqui el ilterador se recorre en 23 pocisiones desde 0
    for($i=0;$i<$large/*23*/;$i++){
        IF($i</*$lastm*/1 )//si el ilterador es menor al mes actual
        {
            array_push($inv,$invinicial[$i]); //acumula en un arreglo el inventario real ,con lo que termino el mes anterior al actual
            array_push($inv_costo,$invinicial_costo [$i]);
            //$inventario=(($invinicial[$i]+$comprapxaño[$i])-$resultpxaño[$i] ); //sumamos el inventario inicial por mes a la compra -la venta esto da como resultado el inventario final
            $inventario=(($invinicial[$i]+$cmp_ppto[$i])-$resultpxaño[$i] );
            $inventario_costo=($invinicial_costo[$i]+$compra_act[$i])-$costo_act[$i];
            array_push($inv2,$inventario);
            array_push($invfinal_costo,$inventario_costo);
        }
        else if($i==/*$lastm*/1) {


            array_push($inv_costo,$inventario_costo);
            array_push($inv,$inventario);// si el ilterador se encuenta en la posicion de el mes actual acumula el inventario calculado de la condicion del if de arriba y lo asigna como inventario inicial del mes actual
            $inventario=(($inventario+$cmp_ppto[$i])-$resultpxaño[$i]);//ahora el inventario final del mes actual se esta calculando con la informacion encontrada en los presupuestos(compra y venta)
            $inventario_costo=($inventario_costo+$compra_act[$i])-$costo_act[$i];
            array_push($inv2,$inventario);
            array_push($invfinal_costo,$inventario_costo);


            //  array_push($inv_costo,$invinicial_costo [$i]);



        }
        else    {
            //apartir de el mes actual en adelante se estara calculando la informacion de inventario final e inventario inicial con los datos del presupuesto
            array_push($inv,$inventario);
            array_push($inv_costo,$inventario_costo);
            $inventario=(($inventario+$cmp_ppto[$i])-$resultpxaño[$i]);
            $inventario_costo=($inventario_costo+$compra_act[$i])-$costo_act[$i];
            switch($inventario){
                case $inventario<=0:
                    array_push($inv2,0);

                    break;

                default :
                    array_push($inv2,$inventario);

                    break;

            }
            array_push($invfinal_costo,$inventario_costo);


        }
    }
    for($i=0;$i<$large;$i++){
        IF($i<$lastm )//si el ilterador es menor al mes actual
        {
            array_push($inv_upd,$invinicial_upd[$i]); //acumula en un arreglo el inventario real ,con lo que termino el mes anterior al actual
            //$inventario=(($invinicial[$i]+$comprapxaño[$i])-$resultpxaño[$i] ); //sumamos el inventario inicial por mes a la compra -la venta esto da como resultado el inventario final
            $inventario_upd=(($invinicial_upd[$i]+$comprapxaño[$i])-$resultpxaño[$i] );
            array_push($inv2_upd,$inventario_upd);

        }
        else if($i==$lastm) {



            array_push($inv_upd,$inventario_upd);// si el ilterador se encuenta en la posicion de el mes actual acumula el inventario calculado de la condicion del if de arriba y lo asigna como inventario inicial del mes actual
            $inventario_upd=(($inventario_upd+$comprapxaño[$i])-$resultpxaño[$i]);//ahora el inventario final del mes actual se esta calculando con la informacion encontrada en los presupuestos(compra y venta)

            array_push($inv2_upd,$inventario_upd);



            //  array_push($inv_costo,$invinicial_costo [$i]);



        }
        else    {
            //apartir de el mes actual en adelante se estara calculando la informacion de inventario final e inventario inicial con los datos del presupuesto
            array_push($inv_upd,$inventario_upd);

            $inventario_upd=(($inventario_upd+$cmp_ppto[$i])-$resultpxaño[$i]);

            switch($inventario_upd){
                case $inventario_upd<=0:
                    array_push($inv2_upd,0);

                    break;

                default :
                    array_push($inv2_upd,$inventario_upd);

                    break;

            }



        }
    }

    for($i=0;$i<count($inv);$i++ ){
        if($i<=11){
            array_push($invly,$inly[$i][0]);
        }
        else{
            array_push($invly,$inv[$i-12]);
        }
    }
    //modificacion se extiende la venta añadiendo la venta del año proximo
    $resultpxañom=[];
    for($i=0;$i<$large;$i++){
        array_push ($resultpxañom,$resultpxaño[$i]);
    }
    $exlarge=36;//count($resultpxañom);
    //en el siguiente bucle calcularemos el cubrimiento de inventario final
    for($i=0;$i<$exlarge;$i++)
    {
        //creamos un ilterador j que nos ayudara a recorrer las pocisiones para avanzar un mes delante de el inventario final
        $j=$i+1;
        //asignamos el valor de nuestro inventario final a la variable resta para comenzar a restar los meses que cubre
        $resta=$inv2_upd[$i];
        //importante que cada vez que nuestro ciclo comienze retornemos la variable cont a 0 para que no guarde valores anteriores
        $cont=0;
        //si resta es meno o igual a 0 esto para no calcular valores negativos y evitarlos en la tabla es decir es posible que a el inventario final en 0 le reste la venta ajustada de el presupuesto
        IF($resta<=0){
            array_push($mesesinvs_upd,0);
            array_push($residuo_upd,0);
        }
        else {
            //mientras la resta sea mayor a la venta y el ilterador j sea menor a lacantidad de registros que tiene venta
            while ( $resta>0 and $resta >= $resultpxañom[$j] and $j <= $exlarge) {
                $resta = $resta - $resultpxañom[$j];//ejecuta la resta de el inventario final - venta guardando en su variable el residuo
                //el contador va sumando las posiciones que avanza la resta dentro de la venta para determinar el cubrimiento
                $cont += 1;
                //importante recordar que tambien el ilterador j debe avanzar para recorrer asi tambien las posiciones de venta
                $j += 1;
            }
            //al final el contador escapa en una variable($mesesinv) y tambien el residuo de la resta
            switch (($resta/$resultpxañom[$j])){
                case is_infinite(($resta/$resultpxañom[$j])) or is_null(($resta/$resultpxañom[$j])) or ($resta/$resultpxañom[$j])==0 or $crb ="" :
                    array_push($mesesinvs_upd, $cont);
                    break;

                default:
                    array_push($mesesinvs_upd, ($cont+round(($resta/$resultpxañom[$j]),2,PHP_ROUND_HALF_DOWN)));
                    break;
            }
            array_push($residuo_upd, $resta);
        }
    }
    //en el siguiente bucle calcularemos el cubrimiento de inventario final
    for($i=0;$i<$exlarge;$i++)
    {
        //creamos un ilterador j que nos ayudara a recorrer las pocisiones para avanzar un mes delante de el inventario final
        $j=$i+1;
        //asignamos el valor de nuestro inventario final a la variable resta para comenzar a restar los meses que cubre
        $resta=$inv2[$i];
        //importante que cada vez que nuestro ciclo comienze retornemos la variable cont a 0 para que no guarde valores anteriores
        $cont=0;
        //si resta es meno o igual a 0 esto para no calcular valores negativos y evitarlos en la tabla es decir es posible que a el inventario final en 0 le reste la venta ajustada de el presupuesto
        IF($resta<=0){
            array_push($mesesinvs,0);
            array_push($residuo,0);
        }
        else {
            //mientras la resta sea mayor a la venta y el ilterador j sea menor a lacantidad de registros que tiene venta
            while ( $resta>0 and $resta >= $resultpxañom[$j] and $j <= $exlarge) {
                $resta = $resta - $resultpxañom[$j];//ejecuta la resta de el inventario final - venta guardando en su variable el residuo
                //el contador va sumando las posiciones que avanza la resta dentro de la venta para determinar el cubrimiento
                $cont += 1;
                //importante recordar que tambien el ilterador j debe avanzar para recorrer asi tambien las posiciones de venta
                $j += 1;
            }
            //al final el contador escapa en una variable($mesesinv) y tambien el residuo de la resta
            switch (($resta/$resultpxañom[$j])){
                case is_infinite(($resta/$resultpxañom[$j])) or is_null(($resta/$resultpxañom[$j])) or ($resta/$resultpxañom[$j])==0 or $crb ="" :
                    array_push($mesesinvs, $cont);
                    break;

                default:
                    array_push($mesesinvs, ($cont+round(($resta/$resultpxañom[$j]),2,PHP_ROUND_HALF_DOWN)));
                    break;
            }
            array_push($residuo, $resta);
        }
    }
    $large=24;
    for($i=0;$i<$large;$i++)
    {
                array_push($mesesinv,$mesesinvs[$i]);

    }
    for($i=0;$i<$large;$i++)
    {
        array_push($mesesinv_upd,$mesesinvs_upd[$i]);

    }
    for($i=0;$i<$large;$i++)
    {
        array_push($resinv,$residuo[$i]);
    }

    for($i=0;$i<$large;$i++)
    {
        array_push($resinv_upd,$residuo_upd[$i]);
    }
    $plargo =$large;// count($resultpxaño);
    for ($i=0;$i<$plargo;$i++)
    {
        if($i==0){
            $total_cmr_actV2+=$cmp_actual[$i];
            $total_cmr_pptoV2+=$cmp_ppto[$i];
            $totalV2+=$comprapxaño[$i];
            $totalyV2+=$comprapxaño_ly[$i];//suma las compras mes a mes
            $totalinvlyV2+=$invly[$i];//suma las compras mes a mes
            $total5V2+=$resultpxaño[$i];//suma las ventas mes a mes
            $total_impV2+=$importe_act[$i];//suma los importes mes a mes
            $total_costV2+=$costo_act[$i];//suma los importes mes a mes
            $total_utilV2+=$util_act[$i];//suma los importes mes a mes
            $total_cost_invV2+=$inv_costo[$i];
            $total_cost_inv_fnV2+=$invfinal_costo[$i];
            $total_compV2+=$compra_act[$i];
            $total_imp_2019V2+=$importe_act_2019[$i];
        }
        elseif ($i<=11){
            $totalV2+=$comprapxaño[$i];
            $total_cmr_actV2+=$cmp_actual[$i];
            $total_cmr_pptoV2+=$cmp_ppto[$i];
            $totalyV2+=$comprapxaño_ly[$i];//suma las compras mes a mes
            $totalinvlyV2+=$invly[$i];//suma las compras mes a mes
            $total5V2+=$resultpxaño[$i];//suma las ventas mes a mes
            $total_impV2+=$importe_act[$i];//suma los importes mes a mes
            $total_costV2+=$costo_act[$i];//suma los importes mes a mes
            $total_utilV2+=$util_act[$i];//suma los importes mes a mes
            $total_cost_invV2+=$inv_costo[$i];
            $total_cost_inv_fnV2+=$invfinal_costo[$i];
            $total_compV2+=$compra_act[$i];
            $total_imp_2019V2+=$importe_act_2019[$i];

        }
        elseif ($i>11){
            $totalV3+=$comprapxaño[$i];
            $total_cmr_actV3+=$cmp_actual[$i];
            $total_cmr_pptoV3+=$cmp_ppto[$i];
            $totalyV3+=$comprapxaño_ly[$i];//suma las compras mes a mes
            $totalinvlyV3+=$invly[$i];//suma las compras mes a mes
            $total5V3+=$resultpxaño[$i];//suma las ventas mes a mes
            $total_impV3+=$importe_act[$i];//suma los importes mes a mes
            $total_costV3+=$costo_act[$i];//suma los importes mes a mes
            $total_utilV3+=$util_act[$i];//suma los importes mes a mes
            $total_cost_invV3+=$inv_costo[$i];
            $total_cost_inv_fnV3+=$invfinal_costo[$i];
            $total_compV3+=$compra_act[$i];
            $total_imp_2019V3+=$importe_act_2019[$i];
        }
    }
    for ($i=0;$i<$plargo;$i++)
    {
        if($i==$plargo-1)//si es la ultima columna
        {


             $total1+=$comprapxaño[$i];//suma las compras mes a mes
            $total_cmr_act+=$cmp_actual[$i];
            $total_cmr_ppto+=$cmp_ppto[$i];
            $totaly+=$comprapxaño_ly[$i];//suma las compras mes a mes
            $totalinvly+=$invly[$i];//suma las compras mes a mes
            $total5+=$resultpxaño[$i];//suma las ventas mes a mes
            $total_imp+=$importe_act[$i];//suma los importes mes a mes
            $total_cost+=$costo_act[$i];//suma los importes mes a mes
            $total_util+=$util_act[$i];//suma los importes mes a mes
            $total_cost_inv+=$inv_costo[$i];
            $total_cost_inv_fn+=$invfinal_costo[$i];
            $total_comp+=$compra_act[$i];
            $total_imp_2019+=$importe_act_2019[$i];
            //se forma la estructura de la tabla google charts
            $estructura_vta_importe.=$importe_act[$i].",".$total_impV3.",".$total_imp;
            $estructura_vta_importe_2019.=$importe_act_2019[$i].",".$total_imp_2019V3.",".$total_imp_2019;
            $estructura_vta_costo.=$costo_act[$i].",".$total_costV3.",".$total_cost;
            $estructura_vta_util.=$util_act[$i].",".$total_utilV3.",".$total_util;
            $estructura_compra_importe.=$compra_act[$i].",".$total_compV3.",".$total_comp;
            $estructurainvly.=$invly[$i].",".$totalinvlyV3.",".$totalinvly;
            $estructura_inv_costo.=round( $inv_costo[$i],0,PHP_ROUND_HALF_UP).",".$total_cost_invV3.",".$total_cost_inv;
            $estructura_inv_costo_fn.=round( $invfinal_costo [$i],0,PHP_ROUND_HALF_UP).",".$total_cost_inv_fnV3.",".$total_cost_inv_fn;
            $estructura_cmp_ppto.=round($cmp_ppto[$i],0,PHP_ROUND_HALF_UP).",".$total_cmr_pptoV3.",".$total_cmr_ppto;
            $estructura_cmp_actual.=round($cmp_actual[$i],0,PHP_ROUND_HALF_UP).",".$total_cmr_actV3.",".$total_cmr_act;
            $compraj=$compraj.$comprapxaño[$i].",".$totalV3.",".$total1;//concatena la compra y la suma total de la compra
            $comprajly=$comprajly.$comprapxaño_ly[$i].",".$totalyV3.",".$totaly;//concatena la compra y la suma total de la compra
            $invi=$invi.$inv[$i].",".$total2.",".$total2;//concatena el inventario inicial ,en el inventario inicial  no se realiza una suma por lo tanto solo se concatena la variable en 0
            $invi_upd=$invi_upd.$inv_upd[$i].",0,0" ;//concatena el inventario inicial ,en el inventario inicial  no se realiza una suma por lo tanto solo se concatena la variable en 0
            $invf=$invf.$inv2[$i].",".$total3.",".$total3;//concatena el inventario final ,en el inventario final no se realiza una suma por lo tanto solo se concatena la variable en 0
            $invf_upd=$invf_upd.$inv2_upd[$i].",0,0";//concatena el inventario final ,en el inventario final no se realiza una suma por lo tanto solo se concatena la variable en 0
            $mesin=$mesin.$mesesinv[$i].",".$total4.",".$total4;//concatena el cubrimiento , el cubrimiento no se realiza una suma por lo tanto solo se concatena la variable en 0
            $mesin_upd=$mesin_upd.$mesesinv_upd[$i].",".$total4.",".$total4;//concatena el cubrimiento , el cubrimiento no se realiza una suma por lo tanto solo se concatena la variable en 0
            $vtacombinacion=$vtacombinacion.$resultpxaño[$i].",".$total5V3.",".$total5;//concatena la venta real y ajustado ,y la suma total

            //en este paso se calcula la division de entre el inventario inicial y la venta

            /*if(is_null($resultpxaño[$i]) or $resultpxaño[$i]==0 or  $importe_act[$i]==0 )
            {
                $actualiza2=$actualiza2. 0 .",". ($total_imp / $total5).",". ($total_impV2 / $total5V2).",". ($total_impV3 / $total5V3);
            }
            else {*/
                $actualiza2=$actualiza2.round( ($importe_act[$i]/$resultpxaño[$i]),2,PHP_ROUND_HALF_UP ).",".round(($total_impV3 / $total5V3),2,PHP_ROUND_HALF_UP).",".round(($total_imp / $total5),2,PHP_ROUND_HALF_UP);
            //}
            if(is_null($resultpxaño[$i]) or $resultpxaño[$i]==0 or  $inv[$i]==0)
            {

                $actualizacion=$actualizacion. 0 . "," . $total6. "," . $total6;
            }
            else {
                $actualizacion = $actualizacion . ($inv[$i] / $resultpxaño[$i]) . "," . $total6 . "," . $total6 ;
            }

        }
        else if($i==11)//si es la ultima columna
        {

             $total1+=$comprapxaño[$i];//suma las compras mes a mes
            $total_cmr_act+=$cmp_actual[$i];
            $total_cmr_ppto+=$cmp_ppto[$i];
            $totaly+=$comprapxaño_ly[$i];//suma las compras mes a mes
            $totalinvly+=$invly[$i];//suma las compras mes a mes
            $total5+=$resultpxaño[$i];//suma las ventas mes a mes
            $total_imp+=$importe_act[$i];//suma los importes mes a mes
            $total_cost+=$costo_act[$i];//suma los importes mes a mes
            $total_util+=$util_act[$i];//suma los importes mes a mes
            $total_cost_inv+=$inv_costo[$i];
            $total_cost_inv_fn+=$invfinal_costo[$i];
            $total_comp+=$compra_act[$i];
            $total_imp_2019+=$importe_act_2019[$i];
            //se forma la estructura de la tabla google charts
            $estructura_vta_importe.=$importe_act[$i].",".$total_impV2.",";
            $estructura_vta_importe_2019.=$importe_act_2019[$i].",".$total_imp_2019V2.",";
            $estructura_vta_costo.=$costo_act[$i].",".$total_costV2.",";
            $estructura_vta_util.=$util_act[$i].",".$total_utilV2.",";
            $estructura_compra_importe.=$compra_act[$i].",".$total_compV2.",";
            $estructurainvly.=$invly[$i].",".$totalinvlyV2.",";
            $estructura_inv_costo.=round( $inv_costo[$i],0,PHP_ROUND_HALF_UP).",".$total_cost_invV2.",";
            $estructura_inv_costo_fn.=round( $invfinal_costo [$i],0,PHP_ROUND_HALF_UP).",".$total_cost_inv_fnV2.",";
            $estructura_cmp_ppto.=round($cmp_ppto[$i],0,PHP_ROUND_HALF_UP).",".$total_cmr_pptoV2.",";
            $estructura_cmp_actual.=round($cmp_actual[$i],0,PHP_ROUND_HALF_UP).",".$total_cmr_actV2.",";
            $compraj=$compraj.$comprapxaño[$i].",".$totalV2.",";//concatena la compra y la suma total de la compra
            $comprajly=$comprajly.$comprapxaño_ly[$i].",".$totalyV2.",";//concatena la compra y la suma total de la compra
            $invi=$invi.$inv[$i].",".$total2.",";//concatena el inventario inicial ,en el inventario inicial  no se realiza una suma por lo tanto solo se concatena la variable en 0
            $invi_upd=$invi_upd.$inv_upd[$i].",".$total2.",";//concatena el inventario inicial ,en el inventario inicial  no se realiza una suma por lo tanto solo se concatena la variable en 0
            $invf=$invf.$inv2[$i].",".$total3.",";//concatena el inventario final ,en el inventario final no se realiza una suma por lo tanto solo se concatena la variable en 0
            $invf_upd=$invf_upd.$inv2_upd[$i].",".$total3.",";//concatena el inventario final ,en el inventario final no se realiza una suma por lo tanto solo se concatena la variable en 0
            $mesin=$mesin.$mesesinv[$i].",".$total4.",";//concatena el cubrimiento , el cubrimiento no se realiza una suma por lo tanto solo se concatena la variable en 0
            $mesin_upd=$mesin_upd.$mesesinv_upd[$i].",".$total4.",";//concatena el cubrimiento , el cubrimiento no se realiza una suma por lo tanto solo se concatena la variable en 0
            $vtacombinacion=$vtacombinacion.$resultpxaño[$i].",".$total5V2.",";//concatena la venta real y ajustado ,y la suma total

            //en este paso se calcula la division de entre el inventario inicial y la venta

            /*if(is_null($resultpxaño[$i]) or $resultpxaño[$i]==0 or  $importe_act[$i]==0 )
            {
                $actualiza2=$actualiza2. 0 .",". ($total_imp / $total5).",". ($total_impV2 / $total5V2).",". ($total_impV3 / $total5V3);
            }
            else {*/
            $actualiza2=$actualiza2.round( ($importe_act[$i]/$resultpxaño[$i]),2,PHP_ROUND_HALF_UP ).",".round(($total_impV2 / $total5V2),2,PHP_ROUND_HALF_UP).",";
            //}
            if(is_null($resultpxaño[$i]) or $resultpxaño[$i]==0 or  $inv[$i]==0)
            {

                $actualizacion=$actualizacion. 0 . "," . $total6. "," ;
            }
            else {
                $actualizacion = $actualizacion . ($inv[$i] / $resultpxaño[$i]) . "," . $total6."," ;
            }

        }
        else{

            $total1+=$comprapxaño[$i];//suma las compras mes a mes
            $total_cmr_act+=$cmp_actual[$i];
            $total_cmr_ppto+=$cmp_ppto[$i];
            $totaly+=$comprapxaño_ly[$i];//suma las compras mes a mes
            $total5+=$resultpxaño[$i];//suma las ventas mes a mes
            $total_imp+=$importe_act[$i];//suma los importes mes a mes
            $total_cost+=$costo_act[$i];//suma los importes mes a mes
            $total_util+=$util_act[$i];//suma los importes mes a mes
            $totalinvly+=$invly[$i];//suma las compras mes a mes
            $total_cost_inv+=$inv_costo[$i];
            $total_cost_inv_fn +=$invfinal_costo[$i];
            $total_comp+=$compra_act[$i];
            $total_imp_2019+=$importe_act_2019[$i];
            //se forma la estructura de la tabla google charts
            $estructura_vta_importe.=$importe_act[$i].",";
            $estructura_vta_importe_2019.=$importe_act_2019[$i].",";


            $estructura_vta_costo.=$costo_act[$i].",";
            $estructura_vta_util.=$util_act[$i].",";
            $estructura_compra_importe.=$compra_act[$i].",";
            $estructurainvly.=$invly[$i].",";
            $estructura_inv_costo.= round( $inv_costo[$i],0,PHP_ROUND_HALF_UP).",";
            $estructura_inv_costo_fn.=round($invfinal_costo [$i],0,PHP_ROUND_HALF_UP).",";
            $estructura_cmp_ppto.=round($cmp_ppto[$i],0,PHP_ROUND_HALF_UP).",";
            $estructura_cmp_actual.=round($cmp_actual[$i],0,PHP_ROUND_HALF_UP).",";
            $compraj=$compraj.$comprapxaño[$i].",";//concatena la compra y la suma total de la compra
            $comprajly=$comprajly.$comprapxaño_ly[$i].",";//concatena la compra y la suma total de la compra
            $invi=$invi.$inv[$i].",";//concatena el inventario inicial ,en el inventario inicial  no se realiza una suma por lo tanto solo se concatena la variable en 0
            $invi_upd=$invi_upd.$inv_upd[$i].",";//concatena el inventario inicial ,en el inventario inicial  no se realiza una suma por lo tanto solo se concatena la variable en 0
            $invf=$invf.$inv2[$i].",";//concatena el inventario final ,en el inventario final no se realiza una suma por lo tanto solo se concatena la variable en 0
            $invf_upd=$invf_upd.$inv2_upd[$i].",";//concatena el inventario final ,en el inventario final no se realiza una suma por lo tanto solo se concatena la variable en 0
            $mesin=$mesin.$mesesinv[$i].",";//concatena el cubrimiento , el cubrimiento no se realiza una suma por lo tanto solo se concatena la variable en 0
            $mesin_upd=$mesin_upd.$mesesinv_upd[$i].",";//concatena el cubrimiento , el cubrimiento no se realiza una suma por lo tanto solo se concatena la variable en 0
            $vtacombinacion=$vtacombinacion.$resultpxaño[$i].",";//concatena la venta real y ajustado ,y la suma total

            //en este paso se calcula la division de entre el inventario inicial y la venta
             if(is_null($resultpxaño[$i]) or $resultpxaño[$i]==0 and  $importe_act[$i]==0  )
            {

                $actualiza2=$actualiza2. 0 .",";
            }

            else {
                $actualiza2=$actualiza2.round( ($importe_act[$i]/$resultpxaño[$i]),2,PHP_ROUND_HALF_UP).",";
            }



            if(is_null($resultpxaño[$i]) or $resultpxaño[$i]==0 and  $inv[$i]==0 )
            {

                $actualizacion=$actualizacion. 0 . "," ;
            }

            else {
                $actualizacion = $actualizacion . ($inv[$i] / $resultpxaño[$i]) . "," ;
         }





        }
    }
    $grafica=grafica($plargo,$nmes,$inv2,$mesesinv,$pivotinvf,$grafica);
    $grafica=substr($grafica,0,strlen($grafica)-1 );
    $columnas = count($nombremeses);///2;
    $filas = $filas=count($rawpedidosay[0]);



 for($i=0;$i<count($rawpedidosay);$i++){
     if($rawpedidosay[0][0]>$actuallyear){

             $z=0;
         for($j=1;$j<count($rawpedidosay[0])/2;$j++){

             $pedidosay[]=0;
             $z+=1;
        }
         for($j=1;$j<count($rawpedidosay[0])/2;$j++){


             $pedidosay[]=$rawpedidosay[$i][$j];
             $z+=1;
         }
     }
     else{
         for($j=1;$j<count($rawpedidosay[0])/2;$j++){
             $pedidosay[]=$rawpedidosay[$i][$j];
         }
     }
 }
    $process_columnas=24;

    for ($i=0;$i<$process_columnas;$i++){
        if($i==0){
            $totalayV2+=$pedidosay[$i];
        }
        elseif ($i<=11){
            $totalayV2+=$pedidosay[$i];

        }
        elseif ($i>11){
            $totalayV3+=$pedidosay[$i];
        }



    }
    for ($i=0;$i<$process_columnas;$i++){


         if($i==11){
            if( is_null($pedidosay[$i]) or $pedidosay[$i]=="" or empty($pedidosay[$i])){
                $matrizpedidoay.= 0 .",".$totalayV2.",";
                $totalay+=0;
            }
            else{
                $matrizpedidoay.=$pedidosay[$i].",".$totalayV2.",";
                $totalay+=$pedidosay[$i];
            }

        }
        else{
            if( is_null($pedidosay[$i]) or $pedidosay[$i]=="" or empty($pedidosay[$i])){
                $matrizpedidoay.= 0 .",";
                $totalay+=0;
            }
            else{
                $matrizpedidoay.=$pedidosay[$i].",";
                $totalay+=$pedidosay[$i];
            }
        }



    }


    $matrizpedidoay=substr($matrizpedidoay,0,strlen($matrizpedidoay)-1).",".$totalayV3.",".$totalay;



}
//si el resultado de la venta ajustada ,la compra ajustada es igual a 0 indica que no tiene presupuesto año proximo pero se calcula solo la informacion de el año actual a 12 meses
else if ($res == 0 and $resc == 0 and $year==$actuallyear ) {
    $columnname=$columnname12;//si existe resultado del año proximo se asignan 24 meses como columnas para generar las tablas finales
    $i=0;//importante todos los bucles while deben inicializarze antes con un ilterador en 0 , en caso omiso este bucle no se ejecutara
    //se acumulan los registros arrojados de la consulta venta ajustada del año proximo en una nueva variable $añoresult
    while ($row1 = sqlsrv_fetch_array($resultpx)) {
        $añoresult[$i]  = $row1;
        $i++;
    }
    $i=0;
    //se acumulan los registros arrojados de la consulta compra ajustada del año proximo en una nueva variable $compraresult
    while($row = sqlsrv_fetch_array($comprapx))
    {
        $compraresult[$i] = $row ;

        $i++;

    }
    $i=0;
    //se acumulan los registros arrojados de la consulta compra ajustada del año proximo en una nueva variable $compraresult
    //asignacion de filas y columnas
    $rscolumnas = count($añoresult[0])/2;///2;
    $rsfilas = count($añoresult);
    $crcolumnas = count($compraresult[0])/2;///2;
    $crfilas = count($compraresult);
    //en el siguiente bucle se acumula a las variables $resultpxaño(venta) ,$comprapxaño(compra), la venta y la compra del año actual ya junto con el acumulado del plan ajustado si este fuese el caso
    for ($i=0;$i<count($vta);$i++)
    {
        array_push( $resultpxaño,$vta[$i]);
        array_push( $comprapxaño,$cmpr[$i]);
        array_push( $comprapxaño_ly,$compra_ly[$i]);
    }
    //se asigna el rango del nuestro ilterador para recorrer todos los bucles donde se realizaran nuestros calculos(24 meses)
    $large =count($resultpxaño);
    //aqui recibimos el resultado de nuestra consulta del año anterior desde el mes de diciembre hasta el mes actual para obtener el inventario inicial y empezar a calcular el resto de los meses.
    for($i=0;$i<$exfilas;$i++){
        for ($j=0;$j<1;$j++){
            array_push($invinicial, $exisfinal[$i][$j]);
            array_push($invinicial_costo, $exisfinal_costo [$i][$j]);
        }
    }
// en el siguiente bucle calculamos el inventario inicial e inventario final
//recordar que aqui el ilterador se recorre en 12 pocisiones desde 0
    for($i=0;$i<$large;$i++){
        IF($i<$lastm )//si el ilterador es menor al mes actual
        {
            array_push($inv,$invinicial[$i]); //acumula en un arreglo el inventario real ,con lo que termino el mes anterior al actual
            array_push($inv_costo,$invinicial_costo [$i]);
            $inventario=(($invinicial[$i]+$comprapxaño[$i])-$resultpxaño[$i] ); //sumamos el inventario inicial por mes a la compra -la venta esto da como resultado el inventario final
            $inventario_costo=($invinicial_costo[$i]+$compra_act[$i])-$costo_act[$i];
            array_push($inv2,$inventario);
            array_push($invfinal_costo,$inventario_costo);
        }
        else if($i==$lastm) {

            array_push($inv_costo,$inventario_costo);
            array_push($inv,$inventario);// si el ilterador se encuenta en la posicion de el mes actual acumula el inventario calculado de la condicion del if de arriba y lo asigna como inventario inicial del mes actual
            $inventario=(($inventario+$comprapxaño[$i])-$resultpxaño[$i]);//ahora el inventario final del mes actual se esta calculando con la informacion encontrada en los presupuestos(compra y venta)
            $inventario_costo=($inventario_costo+$compra_act[$i])-$costo_act[$i];
            array_push($inv2,$inventario);
            array_push($invfinal_costo,$inventario_costo);
            //  array_push($inv_costo,$invinicial_costo [$i]);
        }
        else    {
            //apartir de el mes actual en adelante se estara calculando la informacion de inventario final e inventario inicial con los datos del presupuesto
            array_push($inv,$inventario);
            array_push($inv_costo,$inventario_costo);
            $inventario=(($inventario+$comprapxaño[$i])-$resultpxaño[$i]);
            $inventario_costo=($inventario_costo+$compra_act[$i])-$costo_act[$i];
            array_push($inv2,$inventario);
            array_push($invfinal_costo,$inventario_costo);
        }
    }
    for($i=0;$i<count($inv);$i++ ){
        if($i<=11){

            array_push($invly,$inly[$i][0]);



        }
        else{
            array_push($invly,$inv[$i-12]);
        }
    }
    //modificacion se extiende la venta añadiendo la venta del año proximo
    $resultpxañom=[];
    for($i=0;$i<($large/*+$large-1*/);$i++){

        array_push ($resultpxañom,$resultpxaño[$i]);


    }

    $exlarge=count($resultpxañom)-1;

    //en el siguiente bucle calcularemos el cubrimiento de inventario final

    for($i=0;$i<$exlarge;$i++)

    {
        //creamos un ilterador j que nos ayudara a recorrer las pocisiones para avanzar un mes delante de el inventario final
        $j=$i+1;
        //asignamos el valor de nuestro inventario final a la variable resta para comenzar a restar los meses que cubre
        $resta=$inv2[$i];

        //importante que cada vez que nuestro ciclo comienze retornemos la variable cont a 0 para que no guarde valores anteriores
        $cont=0;

        //si resta es meno o igual a 0 esto para no calcular valores negativos y evitarlos en la tabla es decir es posible que a el inventario final en 0 le reste la venta ajustada de el presupuesto
        IF($resta<=0){
            array_push($mesesinvs,0);
            array_push($residuo,0);
        }

        else {

            //mientras la resta sea mayor a la venta y el ilterador j sea menor a lacantidad de registros que tiene venta
            while ($resta>0 and $resta >= $resultpxañom[$j] and $j <= $exlarge) {
                $resta = $resta - $resultpxañom[$j];//ejecuta la resta de el inventario final - venta guardando en su variable el residuo
                //el contador va sumando las posiciones que avanza la resta dentro de la venta para determinar el cubrimiento
                $cont += 1;
                //importante recordar que tambien el ilterador j debe avanzar para recorrer asi tambien las posiciones de venta
                $j += 1;
            }
            //al final el contador escapa en una variable($mesesinv) y tambien el residuo de la resta
            switch (round(($resta/$resultpxañom[$j]),2,PHP_ROUND_HALF_DOWN)){
                case is_infinite(round(($resta/$resultpxañom[$j]),2,PHP_ROUND_HALF_DOWN)) or is_null(round(($resta/$resultpxañom[$j]),2,PHP_ROUND_HALF_DOWN)) or round(($resta/$resultpxañom[$j]),2,PHP_ROUND_HALF_DOWN)==0 or $crb ="" :
                    array_push($mesesinvs, $cont);
                    break;
                default:
                    array_push($mesesinvs, ($cont+round(($resta/$resultpxañom[$j]),2,PHP_ROUND_HALF_DOWN)));
                    break;
            }
            array_push($residuo, $resta);
        }










    }
    for($i=0;$i<$large;$i++)
    {

        array_push($mesesinv,$mesesinvs[$i]);


    }
    for($i=0;$i<$large;$i++)
    {

        array_push($resinv,$residuo[$i]);


    }

    $plargo =count($resultpxaño);
    $actualiza2="";



    for ($i=0;$i<$plargo;$i++)
    {

        if($i==$plargo-1)//si es la ultima columna
        {

             $total1+=$comprapxaño[$i];//suma las compras mes a mes
            $total_cmr_act+=$cmp_actual[$i];
            $total_cmr_ppto+=$cmp_ppto[$i];
            $totaly+=$comprapxaño_ly[$i];//suma las compras mes a mes
            $totalinvly+=$invly[$i];//suma las compras mes a mes
            $total5+=$resultpxaño[$i];//suma las ventas mes a mes
            $total_imp+=$importe_act[$i];//suma los importes mes a mes
            $total_cost+=$costo_act[$i];//suma los importes mes a mes
            $total_util+=$util_act[$i];//suma los importes mes a mes
            $total_cost_inv+=$inv_costo[$i];
            $total_cost_inv_fn+=$invfinal_costo[$i];
            $total_comp+=$compra_act[$i];
            $total_imp_2019+=$importe_act_2019[$i];
            //se forma la estructura de la tabla google charts
            $estructura_vta_importe.=$importe_act[$i].",".$total_imp;
            $estructura_vta_importe_2019.=$importe_act_2019[$i].",".$total_imp_2019;
            $estructura_vta_costo.=$costo_act[$i].",".$total_cost;
            $estructura_vta_util.=$util_act[$i].",".$total_util;
            $estructura_compra_importe.=$compra_act[$i].",".$total_comp;
            $estructurainvly.=$invly[$i].",".$totalinvly;
            $estructura_inv_costo.=round( $inv_costo[$i],0,PHP_ROUND_HALF_UP).",".$total_cost_inv;
            $estructura_inv_costo_fn.=round( $invfinal_costo [$i],0,PHP_ROUND_HALF_UP).",".$total_cost_inv_fn;
            $estructura_cmp_ppto.=round($cmp_ppto[$i],0,PHP_ROUND_HALF_UP).",".$total_cmr_ppto;
            $estructura_cmp_actual.=round($cmp_actual[$i],0,PHP_ROUND_HALF_UP).",".$total_cmr_act;
            $compraj=$compraj.$comprapxaño[$i].",".$total1;//concatena la compra y la suma total de la compra
            $comprajly=$comprajly.$comprapxaño_ly[$i].",".$totaly;//concatena la compra y la suma total de la compra
            $invi=$invi.$inv[$i].",".$total2;//concatena el inventario inicial ,en el inventario inicial  no se realiza una suma por lo tanto solo se concatena la variable en 0
            $invf=$invf.$inv2[$i].",".$total3;//concatena el inventario final ,en el inventario final no se realiza una suma por lo tanto solo se concatena la variable en 0
            $mesin=$mesin.$mesesinv[$i].",".$total4;//concatena el cubrimiento , el cubrimiento no se realiza una suma por lo tanto solo se concatena la variable en 0
            $vtacombinacion=$vtacombinacion.$resultpxaño[$i].",".$total5;//concatena la venta real y ajustado ,y la suma total

            //en este paso se calcula la division de entre el inventario inicial y la venta

            if(is_null($resultpxaño[$i]) or $resultpxaño[$i]==0 or  $importe_act[$i]==0 )
            {

                $actualiza2=$actualiza2. 0 .",". ($total_imp / $total5);
            }

            else {
                $actualiza2=$actualiza2.round( ($importe_act[$i]/$resultpxaño[$i]),2,PHP_ROUND_HALF_UP ).",".round(($total_imp / $total5),2,PHP_ROUND_HALF_UP);
            }


            if(is_null($resultpxaño[$i]) or $resultpxaño[$i]==0 or  $inv[$i]==0)
            {

                $actualizacion=$actualizacion. 0 . "," . $total6;
            }

            else {
                $actualizacion = $actualizacion . ($inv[$i] / $resultpxaño[$i]) . "," . $total6;
            }





        }

        else{

             $total1+=$comprapxaño[$i];//suma las compras mes a mes
            $total_cmr_act+=$cmp_actual[$i];
            $total_cmr_ppto+=$cmp_ppto[$i];
            $totaly+=$comprapxaño_ly[$i];//suma las compras mes a mes
            $total5+=$resultpxaño[$i];//suma las ventas mes a mes
            $total_imp+=$importe_act[$i];//suma los importes mes a mes
            $total_cost+=$costo_act[$i];//suma los importes mes a mes
            $total_util+=$util_act[$i];//suma los importes mes a mes
            $totalinvly+=$invly[$i];//suma las compras mes a mes
            $total_cost_inv+=$inv_costo[$i];
            $total_cost_inv_fn +=$invfinal_costo[$i];
            $total_comp+=$compra_act[$i];
            $total_imp_2019+=$importe_act_2019[$i];
            //se forma la estructura de la tabla google charts
            $estructura_vta_importe.=$importe_act[$i].",";
            $estructura_vta_importe_2019.=$importe_act_2019[$i].",";


            $estructura_vta_costo.=$costo_act[$i].",";
            $estructura_vta_util.=$util_act[$i].",";
            $estructura_compra_importe.=$compra_act[$i].",";
            $estructurainvly.=$invly[$i].",";
            $estructura_inv_costo.= round( $inv_costo[$i],0,PHP_ROUND_HALF_UP).",";
            $estructura_inv_costo_fn.=round($invfinal_costo [$i],0,PHP_ROUND_HALF_UP).",";
            $estructura_cmp_ppto.=round($cmp_ppto[$i],0,PHP_ROUND_HALF_UP).",";
            $estructura_cmp_actual.=round($cmp_actual[$i],0,PHP_ROUND_HALF_UP).",";
            $compraj=$compraj.$comprapxaño[$i].",";//concatena la compra y la suma total de la compra
            $comprajly=$comprajly.$comprapxaño_ly[$i].",";//concatena la compra y la suma total de la compra
            $invi=$invi.$inv[$i].",";//concatena el inventario inicial ,en el inventario inicial  no se realiza una suma por lo tanto solo se concatena la variable en 0
            $invf=$invf.$inv2[$i].",";//concatena el inventario final ,en el inventario final no se realiza una suma por lo tanto solo se concatena la variable en 0
            $mesin=$mesin.$mesesinv[$i].",";//concatena el cubrimiento , el cubrimiento no se realiza una suma por lo tanto solo se concatena la variable en 0
            $vtacombinacion=$vtacombinacion.$resultpxaño[$i].",";//concatena la venta real y ajustado ,y la suma total



            //en este paso se calcula la division de entre el inventario inicial y la venta
            if(is_null($resultpxaño[$i]) or $resultpxaño[$i]==0 or  $importe_act[$i]==0 )
            {

                $actualiza2=$actualiza2. 0 .",";
            }

            else {
                $actualiza2=$actualiza2.round( ($importe_act[$i]/$resultpxaño[$i]),2,PHP_ROUND_HALF_UP).",";
            }


            if(is_null($resultpxaño[$i]) or $resultpxaño[$i]==0 or  $inv[$i]==0 )
            {

                $actualizacion=$actualizacion. 0 . "," ;
            }

            else {
                $actualizacion = $actualizacion . ($inv[$i] / $resultpxaño[$i]) . "," ;
            }





        }





    }
    $grafica=grafica($plargo,$nmes,$inv2,$mesesinv,$pivotinvf,$grafica);
    $grafica=substr($grafica,0,strlen($grafica)-1 );
    $columnas = count($nombremeses);///2;
    $filas = $filas=count($rawpedidosay[0]);;
    for($i=0;$i<count($rawpedidosay);$i++){
        for($j=1;$j<count($rawpedidosay[0])/2;$j++){

            $pedidosay[]=$rawpedidosay[$i][$j];

        }
    }

    $process_columnas=count($pedidosay);


    for ($i=0;$i<$process_columnas;$i++){
        if( is_null($pedidosay[$i]) or $pedidosay[$i]=="" or empty($pedidosay[$i])){
            $matrizpedidoay.= 0 .",";
            $totalay+=0;
        }
        else{
            $matrizpedidoay.=$pedidosay[$i].",";
            $totalay+=$pedidosay[$i];
        }
    }


    $matrizpedidoay=substr($matrizpedidoay,0,strlen($matrizpedidoay)-1).",".$totalay;


}
else if ($year<$actuallyear) {
    $columnname=$columnname12;//si existe resultado del año proximo se asignan 24 meses como columnas para generar las tablas finales
    //en el siguiente bucle se acumula a las variables $resultpxaño(venta) ,$comprapxaño(compra), la venta y la compra del año actual ya junto con el acumulado del plan ajustado si este fuese el caso
    $i=0;//importante todos los bucles while deben inicializarze antes con un ilterador en 0 , en caso omiso este bucle no se ejecutara
    //se acumulan los registros arrojados de la consulta venta ajustada del año proximo en una nueva variable $añoresult
    while ($row1 = sqlsrv_fetch_array($resultpx)) {

        $añoresult[$i]  = $row1;

        $i++;


    }
    //asignacion de filas y columnas
    $rscolumnas = count($añoresult[0])/2;///2;
    $rsfilas = count($añoresult);
    for ($i=0;$i<count($vta);$i++)
    {
        array_push( $resultpxaño,$vta[$i]);
        array_push( $comprapxaño,$cmpr[$i]);
        array_push( $comprapxaño_ly,$compra_ly[$i]);
    }
    //se asigna el rango del nuestro ilterador para recorrer todos los bucles donde se realizaran nuestros calculos(24 meses)
    $large =count($resultpxaño);
    //aqui recibimos el resultado de nuestra consulta del año anterior desde el mes de diciembre hasta el mes actual para obtener el inventario inicial y empezar a calcular el resto de los meses.
    for($i=0;$i<$exfilas;$i++){
        for ($j=0;$j<1;$j++){
            array_push($invinicial, $exisfinal[$i][$j]);
        }
    }
    // en el siguiente bucle calculamos el inventario inicial e inventario final
    //recordar que aqui el ilterador se recorre en 12 pocisiones desde 0
    for($i=0;$i<$large;$i++){
        IF($i<$lastm )//si el ilterador es menor al mes actual
        {
            array_push($inv,$invinicial[$i]); //acumula en un arreglo el inventario real ,con lo que termino el mes anterior al actual
            $inventario=(($invinicial[$i]+$comprapxaño[$i])-$resultpxaño[$i] ); //sumamos el inventario inicial por mes a la compra -la venta esto da como resultado el inventario final
            array_push($inv2,$inventario);
        }

        else if($i==$lastm) {


            array_push($inv,$inventario);// si el ilterador se encuenta en la posicion de el mes actual acumula el inventario calculado de la condicion del if de arriba y lo asigna como inventario inicial del mes actual


            $inventario=(($inventario+$comprapxaño[$i])-$resultpxaño[$i]);//ahora el inventario final del mes actual se esta calculando con la informacion encontrada en los presupuestos(compra y venta)

            array_push($inv2,$inventario);



        }
        else    {


            //apartir de el mes actual en adelante se estara calculando la informacion de inventario final e inventario inicial con los datos del presupuesto
            array_push($inv,$inventario);


            $inventario=(($inventario+$comprapxaño[$i])-$resultpxaño[$i]);

            array_push($inv2,$inventario);

        }






    }
    for($i=0;$i<count($inv);$i++ ){
        if($i<=11){

            array_push($invly,$inly[$i][0]);



        }
        else{
            array_push($invly,$inv[$i-12]);
        }
    }
    //modificacion se extiende la venta añadiendo la venta del año proximo
    $resultpxañom=[];
    for($i=0;$i<($large);$i++){
        array_push ($resultpxañom,$resultpxaño[$i]);
    }
    for($i=0;$i<$rsfilas;$i++){

        for ($j=0;$j<$rscolumnas;$j++){


            array_push ($resultpxañom,$añoresult[$i][$j]);






        }


    }
    $exlarge=count($resultpxañom);
    //en el siguiente bucle calcularemos el cubrimiento de inventario final
    for($i=0;$i<$exlarge;$i++)

    {
        //creamos un ilterador j que nos ayudara a recorrer las pocisiones para avanzar un mes delante de el inventario final
        $j=$i+1;
        //asignamos el valor de nuestro inventario final a la variable resta para comenzar a restar los meses que cubre
        $resta=$inv2[$i];

        //importante que cada vez que nuestro ciclo comienze retornemos la variable cont a 0 para que no guarde valores anteriores
        $cont=0;

        //si resta es meno o igual a 0 esto para no calcular valores negativos y evitarlos en la tabla es decir es posible que a el inventario final en 0 le reste la venta ajustada de el presupuesto
        IF($resta<=0){
            array_push($mesesinvs,0);
            array_push($residuo,0);
        }

        else {

            //mientras la resta sea mayor a la venta y el ilterador j sea menor a lacantidad de registros que tiene venta
            while ( $resta>0 and $resta >= $resultpxañom[$j] and $j <= $exlarge) {


                $resta = $resta - $resultpxañom[$j];//ejecuta la resta de el inventario final - venta guardando en su variable el residuo

                //el contador va sumando las posiciones que avanza la resta dentro de la venta para determinar el cubrimiento
                $cont += 1;
                //importante recordar que tambien el ilterador j debe avanzar para recorrer asi tambien las posiciones de venta
                $j += 1;


            }

            //al final el contador escapa en una variable($mesesinv) y tambien el residuo de la resta
            switch (round(($resta/$resultpxañom[$j]),2,PHP_ROUND_HALF_DOWN)){
                case is_infinite(round(($resta/$resultpxañom[$j]),2,PHP_ROUND_HALF_DOWN)) or is_null(round(($resta/$resultpxañom[$j]),2,PHP_ROUND_HALF_DOWN)) or round(($resta/$resultpxañom[$j]),2,PHP_ROUND_HALF_DOWN)==0 or $crb ="" :
                    array_push($mesesinvs, $cont);
                    break;

                default:
                    array_push($mesesinvs, ($cont+round(($resta/$resultpxañom[$j]),2,PHP_ROUND_HALF_DOWN)));
                    break;
            }
            array_push($residuo, $resta);
        }





    }
    for($i=0;$i<$large;$i++)
    {

        array_push($mesesinv,$mesesinvs[$i]);


    }
    for($i=0;$i<$large;$i++)
    {

        array_push($resinv,$residuo[$i]);


    }
    $plargo =count($resultpxaño);
    for ($i=0;$i<$plargo;$i++)
    {
        if($i==$plargo-1)//si es la ultima columna
        {
            $total1+=$comprapxaño[$i];//suma las compras mes a mes
            $totaly+=$comprapxaño_ly[$i];//suma las compras mes a mes
            $totalinvly+=$invly[$i];//suma las compras mes a mes
            $total5+=$resultpxaño[$i];//suma las ventas mes a mes
            //se forma la estructura de la tabla google charts
            $estructurainvly.=$invly[$i].",".$totalinvly;
            $compraj=$compraj.$comprapxaño[$i].",".$total1;//concatena la compra y la suma total de la compra
            $comprajly=$comprajly.$comprapxaño_ly[$i].",".$totaly;//concatena la compra y la suma total de la compra
            $invi=$invi.$inv[$i].",".$total2;//concatena el inventario inicial ,en el inventario inicial  no se realiza una suma por lo tanto solo se concatena la variable en 0
            $invf=$invf.$inv2[$i].",".$total3;//concatena el inventario final ,en el inventario final no se realiza una suma por lo tanto solo se concatena la variable en 0
            $mesin=$mesin.$mesesinv[$i].",".$total4;//concatena el cubrimiento , el cubrimiento no se realiza una suma por lo tanto solo se concatena la variable en 0
            $vtacombinacion=$vtacombinacion.$resultpxaño[$i].",".$total5;//concatena la venta real y ajustado ,y la suma total
            //en este paso se calcula la division de entre el inventario inicial y la venta
            if(is_null($resultpxaño[$i]) or $resultpxaño[$i]==0 or  $inv[$i]==0)
            {
                $actualizacion=$actualizacion. 0 . "," . $total6;
            }
            else {
                $actualizacion = $actualizacion . ($inv[$i] / $resultpxaño[$i]) . "," . $total6;
            }
        }
        else{
            $total1+=$comprapxaño[$i];//suma las compras mes a mes
            $totaly+=$comprapxaño_ly[$i];//suma las compras mes a mes
            $total5+=$resultpxaño[$i];//suma las ventas mes a mes
            $totalinvly+=$invly[$i];//suma las compras mes a mes
            //se forma la estructura de la tabla google charts
            $estructurainvly.=$invly[$i].",";
            $compraj=$compraj.$comprapxaño[$i].",";//concatena la compra y la suma total de la compra
            $comprajly=$comprajly.$comprapxaño_ly[$i].",";//concatena la compra y la suma total de la compra
            $invi=$invi.$inv[$i].",";//concatena el inventario inicial ,en el inventario inicial  no se realiza una suma por lo tanto solo se concatena la variable en 0
            $invf=$invf.$inv2[$i].",";//concatena el inventario final ,en el inventario final no se realiza una suma por lo tanto solo se concatena la variable en 0
            $mesin=$mesin.$mesesinv[$i].",";//concatena el cubrimiento , el cubrimiento no se realiza una suma por lo tanto solo se concatena la variable en 0
            $vtacombinacion=$vtacombinacion.$resultpxaño[$i].",";//concatena la venta real y ajustado ,y la suma total

            //en este paso se calcula la division de entre el inventario inicial y la venta
            if(is_null($resultpxaño[$i]) or $resultpxaño[$i]==0 or  $inv[$i]==0 )
            {
                $actualizacion=$actualizacion. 0 . "," ;
            }
            else {
                $actualizacion = $actualizacion . ($inv[$i] / $resultpxaño[$i]) . "," ;
            }
        }
    }
    $grafica=grafica($plargo,$nmes,$inv2,$mesesinv,$pivotinvf,$grafica);
    $grafica=substr($grafica,0,strlen($grafica)-1 );
}
?>

<script type="text/javascript">
    google.charts.load('current', {'packages':['table']});
    google.charts.setOnLoadCallback(drawCharts);
    function drawCharts() {
        drawCharts2();
       drawCharts3();
    }
    /* función que carga cada uno de los gráficos */
    function drawCharts2() {
        var dataTable = google.visualization.arrayToDataTable([<?PHP  if($year<$actuallyear){
            echo $union=$columnname
                ."["."'Venta'".",".$vtacombinacion."]" .","
                ."["."'Inv.Inicial'".",".$invi."]".","
                ."["."'Compra Presupuesto'".",".$compraj."]".","
                ."["."'Inv.Final'".",".$invf."]".","
                ."["."'Pedidos Navision'"."," .$matrizpedidoay."]".","
                ."["."'Cubrimiento'".",".$mesin."]";
        }
        else{

            echo $union=$columnname.
                "["."'Venta'".",".$vtacombinacion."]".","
                ."["."'Inv.Inicial'".",".$invi."]".","
                ."["."'Inv.Final'".",".$invf."]".","
                ."["."'Compra Presupuesto'".",".$estructura_cmp_ppto."]".","
                ."["."'Pedidos Navision'".",".$matrizpedidoay."]".","
                ."["."'Cubrimiento'".",".$mesin."]";

        } ?>]);

        // Create a formatter.
// This example uses object literal notation to define the options.
        /*   var formatter = new google.visualization.NumberFormat({pattern:'#,###%'});
           var formatter1 = new google.visualization.NumberFormat({prefix: '$'});*/

// Reformat our data.
        /*    formatter.format(dataTable, 4);
            formatter1.format(dataTable, 3);*/


        var cssClassNames = {
            'headerRow': 'cssHeaderRow',
            'tableRow': 'cssTableRow',
            'oddTableRow': 'cssOddTableRow',
            'selectedTableRow': 'cssSelectedTableRow',
            'hoverTableRow': 'cssHoverTableRow',
            'headerCell': 'cssHeaderCell',
            'tableCell': 'cssTableCell',
            'rowNumberCell': 'cssRowNumberCell'
        };

        var options = {

            cssClassNames: cssClassNames
        };


        var chart   = new google.visualization.Table(document.getElementById('table-ajustado'));





        // Apply formatter to second c

        chart.draw(dataTable,options,{allowHtml: true});
        google.visualization.events.addListener(chart, 'sort',
            function(event) {

                /*dataTable.sort([{column: event.column, desc: !event.ascending}]);*/
                chart.draw(dataTable,options,{allowHtml: true});

            }
        );


    }



    function drawCharts3() {

        var dataTable = google.visualization.arrayToDataTable([<?PHP  if($year<$actuallyear){
            echo $union=$columnname
                ."["."'Venta'".",".$vtacombinacion."]" .","
                ."["."'Inv.Inicial'".",".$invi_upd."]".","
                ."["."'Compra Presupuesto'".",".$compraj."]".","
                ."["."'Inv.Final'".",".$invf_upd."]";
        }
        else{

            echo $union=$columnname
                /*  ."["."'Cubrimiento'".",".$mesin."]".
               ","."["."'Meses Inv'".",".$actualizacion."]".
               ","."["."'Cubrimiento2'".",".$mesin_upd."]"*/
                ."["."'Venta'".",".$vtacombinacion."]".","
                ."["."'$ Venta'".",".$estructura_vta_importe."]".","
                ."["."'Precio Promedio'".",".$actualiza2."]".","
                ."["."'$ Venta 19'".",".$estructura_vta_importe_2019."]".","
                ."["."'$ Costo Venta'".",".$estructura_vta_costo."]".","
                ."["."'$ Utilidad'".",".$estructura_vta_util."]".","
                ."["."'Inv.Inicial'".",".$invi_upd."]".","
                ."["."'$ Inv.Inicial Costo'".",".$estructura_inv_costo."]".","
                ."["."'Inv.Final'".",".$invf_upd."]".","
                ."["."'$ Inv.Final Costo'".",".$estructura_inv_costo_fn ."]".","
                ."["."'Recepción Alm.'".",".$estructura_cmp_actual."]".","
                ."["."'Pedidos Navision'".",".$matrizpedidoay."]".","
                ."["."'$ Compra'".",".$estructura_compra_importe ."]".","
                ."["."'Compra 2019'".",".$comprajly."]".","
                // ."["."'Meses Inv'".",".$actualizacion."]".","
                . "["."'Cubrimiento'".",".$mesin_upd."]";
        } ?>]);

        var dataTable = google.visualization.arrayToDataTable([<?PHP
            echo $union=$columnname
          /*  ."["."'Cubrimiento'".",".$mesin."]".
         ","."["."'Meses Inv'".",".$actualizacion."]".
         ","."["."'Cubrimiento2'".",".$mesin_upd."]"*/
            ."["."'Venta'".",".$vtacombinacion."]".","
            ."["."'$ Venta'".",".$estructura_vta_importe."]".","
            ."["."'Precio Promedio'".",".$actualiza2."]".","
            ."["."'$ Venta 19'".",".$estructura_vta_importe_2019."]".","
            ."["."'$ Costo Venta'".",".$estructura_vta_costo."]".","
            ."["."'$ Utilidad'".",".$estructura_vta_util."]".","
            ."["."'Inv.Inicial'".",".$invi_upd."]".","
            ."["."'$ Inv.Inicial Costo'".",".$estructura_inv_costo."]".","
            ."["."'Inv.Final'".",".$invf_upd."]".","
            ."["."'$ Inv.Final Costo'".",".$estructura_inv_costo_fn ."]".","
            ."["."'Recepción Alm.'".",".$estructura_cmp_actual."]".","
            ."["."'Pedidos Navision'".",".$matrizpedidoay."]".","
            ."["."'$ Compra'".",".$estructura_compra_importe ."]".","
            ."["."'Compra 2019'".",".$comprajly."]".","
           // ."["."'Meses Inv'".",".$actualizacion."]".","
            . "["."'Cubrimiento'".",".$mesin_upd."]";

            ?>]);

        // Create a formatter.
// This example uses object literal notation to define the options.
        /*   var formatter = new google.visualization.NumberFormat({pattern:'#,###%'});
           var formatter1 = new google.visualization.NumberFormat({prefix: '$'});*/

// Reformat our data.
        /*    formatter.format(dataTable, 4);
            formatter1.format(dataTable, 3);*/


        var cssClassNames = {
            'headerRow': 'cssHeaderRow',
            'tableRow': 'cssTableRow',
            'oddTableRow': 'cssOddTableRow',
            'selectedTableRow': 'cssSelectedTableRow',
            'hoverTableRow': 'cssHoverTableRow',
            'headerCell': 'cssHeaderCell',
            'tableCell': 'cssTableCell',
            'rowNumberCell': 'cssRowNumberCell'
        };

        var options = {

            cssClassNames: cssClassNames
        };


        var chart   = new google.visualization.Table(document.getElementById('table-ajustado1'));





        // Apply formatter to second c

        chart.draw(dataTable,options,{allowHtml: true});
        google.visualization.events.addListener(chart, 'sort',
            function(event) {

                /*dataTable.sort([{column: event.column, desc: !event.ascending}]);*/
                chart.draw(dataTable,options,{allowHtml: true});

            }
        );


    }

</script>
<script type="text/javascript">
    google.charts.load('current', {'packages':['corechart']});
    google.charts.setOnLoadCallback(drawVisualization);

    function drawVisualization() {
        // Some raw data (not necessarily accurate)
        var data = google.visualization.arrayToDataTable([
            <?PHP  echo "['Mes','Inventario Final','Cubrimiento']".",".$grafica ?>
        ]);

        var options = {

            title:'CUBRIMIENTO',

            titleTextStyle: {


                fontSize: 20
            },
            fontSize:10,
            width:'50%',
            legend: { position: 'top', maxLines: 1 },


            seriesType:'bars',
            series:{  0:{targetAxisIndex:0 },
                1:{targetAxisIndex:1,type:'line'}}





        };

        var chart = new google.visualization.ComboChart(document.getElementById('item1'));
        chart.draw(data, options);
        google.visualization.events.addListener(chart, 'sort',
            function(event) {

                /*dataTable.sort([{column: event.column, desc: !event.ascending}]);*/
                chart.draw(data,options,{allowHtml: true});

            }
        );
    }

    $(window).resize(function(){
        drawVisualization();
    });


</script>
