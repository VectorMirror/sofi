<?php
    #Se crea la lista de posibles errores 
    function listaErrores($errores){
        if(count($errores) >0){
            echo"<div id='error' class='alert alert alert-danger'><span class='closebtn' onclick=\"this.parentElement.style.display='none';\"> [X]</span>
            <ul>";
            foreach ($errores as $error){
                echo "<li>". $error. "</li>";
            }
            echo "</ul>";
            echo "</div>";
        }
    }


    #function para que el campo de nuevo destinario y remitente no este vacio
    function checarRemDes($remDes){
        if(strlen(trim($remDes)) <5){
          return true;            
        }
        else {
              return false;
        }
      }

    #Se comprueba que el remitente ingresado no exista en la base de datos
    function remitenteExiste($remitente){
        global $DB_conection;
        $consulta = $DB_conection -> prepare ('SELECT rem_id FROM remitentes WHERE rem_remitente = ? LIMIT 1');
        $consulta->bind_param("s", $remitente);
        $consulta->execute();
        $consulta->store_result();
        $fila = $consulta->num_rows;
        $consulta ->close();

        if($fila >0){
            return true;
        }
        else{
            return false;
        }
    }

     #Se guarda el nuevo remitentente a la DB
     function addRem($remitente){
        global $DB_conection;
        $consulta = $DB_conection->prepare("INSERT INTO remitentes(rem_remitente) VALUES (?)");
        $consulta->bind_param('s', $remitente);
        if($consulta->execute()){
            return $DB_conection->insert_id;
        }
        else{
            return 0;
        }       
    }


    #Se guarda el nuevo destinatario a la DB
    function addDest($destinatario){
        global $DB_conection;
        $consulta = $DB_conection->prepare("INSERT INTO destinatarios(dest_destinatario) VALUES (?)");
        $consulta->bind_param('s', $destinatario);
        if($consulta->execute()){
            return $DB_conection->insert_id;
        }
        else{
            return 0;
        }       
    }

      #Se comprueba que el remitente  ingresado no exista en la base de datos
    function destinatarioExiste($destinatario){
        global $DB_conection;
        $consulta = $DB_conection -> prepare ('SELECT dest_id FROM destinatarios WHERE dest_destinatario = ? LIMIT 1');
        $consulta->bind_param("s", $destinatario);
        $consulta->execute();
        $consulta->store_result();
        $fila = $consulta->num_rows;
        $consulta ->close();

        if($fila >0){
            return true;
        }
        else{
            return false;
        }
        
    }


    #Se comprueba que el nombre de empresa ingresado no exista en la base de datos
    function empresaExiste($empresa){
        global $DB_conection;
        $consulta = $DB_conection -> prepare ('SELECT emp_id FROM empresas WHERE emp_empresa = ? LIMIT 1');
        $consulta->bind_param("s", $empresa);
        $consulta->execute();
        $consulta->store_result();
        $fila = $consulta->num_rows;
        $consulta ->close();

        if($fila >0){
            return true;
        }
        else{
            return false;
        }
    }

     #Se guarda la nueva empresa a la DB
     function addEmpresa($empresa){
        global $DB_conection;
        $consulta = $DB_conection->prepare("INSERT INTO empresas (emp_empresa) VALUES (?)");
        $consulta->bind_param('s', $empresa);
        if($consulta->execute()){
            return $DB_conection->insert_id;
        }
        else{
            return 0;
        }       
    }
    #APARTADO DE LAS FUNCIONES PARA SUBIR LA INFORMACION A DB DE LOS OFICIOS SUBIDOS
    #REvisamos que los datos de los formulario de oficios internos de entrada esten completos
    function checarFormInterno($destinatario, $remitente, $cargo, $unidad, $oficioRef, $numOficio, $asunto, $descripcion, $fechaElab, $fechaSICT){
        if(strlen(trim($destinatario)) <1 || strlen(trim($remitente)) <1 ||  strlen(trim($cargo)) <1 || strlen(trim($unidad)) <1 ||  strlen(trim($oficioRef)) <1 ||  strlen(trim($numOficio)) <1 ||  strlen(trim($asunto)) <1 ||  strlen(trim($descripcion)) <1 ||  strlen(trim($fechaElab)) <1 ||  strlen(trim($fechaSICT)) <1){
            return true;            
        }
        else {
            return false;
        }
    }
    //funcion de oficios internos de entrada
    function uploadOficioIE($idUser, $caracter, $destinatario, $remitente, $cargo, $unidad, $oficioRef, $numOficio, $respuesta, $asunto, $descripcion, $urlDoc, $fechaElab, $fechaResp, $fechaSICT){
        global $DB_conection;
        $consulta = $DB_conection->prepare("INSERT INTO oficios(ofi_subidoPor, ofi_caracter, ofi_destinatario, ofi_remitente, ofi_cargo, ofi_unidad, ofi_referencia, ofi_numero, ofi_respuesta, ofi_asunto, ofi_descripcion, ofi_url, ofi_fechaE, ofi_fechaResp, ofi_fechaSICT) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)");
        $consulta->bind_param('isiiiisssssssss', $idUser, $caracter, $destinatario, $remitente, $cargo, $unidad, $oficioRef, $numOficio, $respuesta, $asunto, $descripcion, $urlDoc, $fechaElab, $fechaResp, $fechaSICT);
        if($consulta->execute()){
            return $DB_conection->insert_id;
        }
        else{
            return 0;
        }       
    }

    #REvisamos que los datos de los formulario de oficios internos de salida esten completos
    function checarFormInternoSalida($destinatario, $remitente, $cargo, $unidad, $oficioRef, $numOficio, $asunto, $descripcion, $fechaElab){
        if(strlen(trim($destinatario)) <1 || strlen(trim($remitente)) <1 ||  strlen(trim($cargo)) <1 || strlen(trim($unidad)) <1 ||  strlen(trim($oficioRef)) <1 ||  strlen(trim($numOficio)) <1 ||  strlen(trim($asunto)) <1 ||  strlen(trim($descripcion)) <1 ||  strlen(trim($fechaElab)) <1){
            return true;            
        }
        else {
            return false;
        }
    }

    //funcion de oficios internos de salida
    function uploadOficioIS($idUser, $caracter, $destinatario, $remitente, $cargo, $unidad, $oficioRef, $numOficio, $asunto, $descripcion, $urlDB, $fechaElab){
        global $DB_conection;
        $consulta = $DB_conection->prepare("INSERT INTO oficios (ofi_subidoPor, ofi_caracter, ofi_destinatario, ofi_remitente, ofi_cargo, ofi_unidad, ofi_referencia, ofi_numero, ofi_asunto, ofi_descripcion, ofi_url, ofi_fechaE) VALUES (?,?,?,?,?,?,?,?,?,?,?,?)");
        $consulta->bind_param('isiiiissssss', $idUser, $caracter, $destinatario, $remitente, $cargo, $unidad, $oficioRef, $numOficio, $asunto, $descripcion, $urlDB, $fechaElab);
        if($consulta->execute()){
            return $DB_conection->insert_id;
        }
        else{
            return 0;
        }       
    }
    #REvisamos que los datos de los formulario de oficios externos de entrada esten completos
    function checarFormExterno($destinatario, $remitente, $empresa, $oficioRef, $numOficio, $asunto, $descripcion, $fechaElab){
        if(strlen(trim($destinatario)) <1 || strlen(trim($remitente)) <1 ||  strlen(trim($empresa)) <1 || strlen(trim($oficioRef)) <1 ||  strlen(trim($numOficio)) <1 ||  strlen(trim($asunto)) <1 ||  strlen(trim($descripcion)) <1 ||  strlen(trim($fechaElab)) <1){
            return true;            
        }
        else {
            return false;
        }
    }
    //funcion de oficios externos de entrada
    function uploadOficioEx($idUser, $caracter, $destinatario, $remitente, $empresa, $numOficio, $oficioRef, $fechaElab, $asunto, $respuesta, $fechaResp, $descripcion, $urlDB){
        global $DB_conection;
        $consulta = $DB_conection->prepare("INSERT INTO oficios (ofi_subidoPor, ofi_caracter, ofi_destinatario, ofi_remitente, ofi_empresa, ofi_numero, ofi_referencia, ofi_fechaE, ofi_asunto, ofi_respuesta, ofi_fechaResp, ofi_descripcion, ofi_url) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?)");
        $consulta->bind_param('isiiissssssss', $idUser, $caracter, $destinatario, $remitente, $empresa, $numOficio, $oficioRef, $fechaElab, $asunto, $respuesta, $fechaResp, $descripcion, $urlDB);
        if($consulta->execute()){
            return $DB_conection->insert_id;
        }
        else{
            return 0;
        }       
    }

    #REvisamos que los datos de los formulario de oficios externos de salida esten completos
    function checarFormInternoSalidaEx($destinatario, $remitente, $empresa, $oficioRef, $numOficio, $asunto, $descripcion, $fechaElab){
        if(strlen(trim($destinatario)) <1 || strlen(trim($remitente)) <1 ||  strlen(trim($empresa)) <1 ||  strlen(trim($oficioRef)) <1 ||  strlen(trim($numOficio)) <1 ||  strlen(trim($asunto)) <1 ||  strlen(trim($descripcion)) <1 ||  strlen(trim($fechaElab)) <1){
            return true;            
        }
        else {
            return false;
        }
    }

    ///funcion de oficios externos de salida
    function uploadOficioISEx($idUser, $caracter, $destinatario, $remitente, $oficioRef, $numOficio, $empresa, $asunto, $descripcion, $urlDB, $fechaElab){
        global $DB_conection;
        $consulta = $DB_conection->prepare("INSERT INTO oficios (ofi_subidoPor, ofi_caracter, ofi_destinatario, ofi_remitente, ofi_referencia, ofi_numero, ofi_empresa, ofi_asunto, ofi_descripcion, ofi_url, ofi_fechaE) VALUES (?,?,?,?,?,?,?,?,?,?,?)");
        $consulta->bind_param('isiississss', $idUser, $caracter, $destinatario, $remitente, $oficioRef, $numOficio, $empresa, $asunto, $descripcion, $urlDB, $fechaElab);
        if($consulta->execute()){
            return $DB_conection->insert_id;
        }
        else{
            return 0;
        }
    }

?>