<?php
date_default_timezone_set("America/Tegucigalpa");
setlocale(LC_TIME, 'es_HN');

$environment = 'inspApiDesa';
//$environment = 'XploreDeliveryAPI';

if (isset($_GET['function'])) {
    $func = $_GET['function'];
    if ($func == 'getCategories') {
        $handle = curl_init();
        $url = "http://190.4.56.14/".$environment."/api/shared/categories/showAll";

        // Set the url
        curl_setopt($handle, CURLOPT_URL, $url);

        $output = curl_exec($handle);

        curl_close($handle);
    } else if ($func == 'getTarifas') {
        $handle = curl_init();

        $url = "http://190.4.56.14/".$environment."/api/shared/rates/get";

        // Set the url
        curl_setopt($handle, CURLOPT_URL, $url);

        $output = curl_exec($handle);

        curl_close($handle);
    } 
} else if (file_get_contents('php://input')) {
    $rest_json = file_get_contents("php://input");
    $_POST = json_decode($rest_json, true);
    if ($_POST['function'] == 'login') {
        $post = file_get_contents('php://input');
        $array = json_decode($post);

        $handle = curl_init();

        $url = "http://190.4.56.14/".$environment."/api/auth/login";

        // Set the url
        curl_setopt($handle, CURLOPT_URL, $url);
        curl_setopt($handle, CURLOPT_POST, TRUE);
        curl_setopt($handle, CURLOPT_POSTFIELDS, $post);
        /* set the content type json */
        curl_setopt($handle, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));

        /* set return type json */
        //curl_setopt($handle, CURLOPT_RETURNTRANSFER, true);

        $output = curl_exec($handle);

        curl_close($handle);
    }else if ($_POST['function']  == 'logout') {
        $post = file_get_contents('php://input');
        $array = json_decode($post);
        $handle = curl_init();

        $url = "http://190.4.56.14/".$environment."/api/auth/logout";
        $authorization = 'Authorization: Bearer ' . $_POST['tkn'];

        /* set the content type json */

        // Set the url
        curl_setopt($handle, CURLOPT_URL, $url);
        curl_setopt($handle, CURLOPT_POST, TRUE);
        curl_setopt($handle, CURLOPT_POSTFIELDS, $post);
        curl_setopt($handle, CURLOPT_HTTPHEADER, array('Content-Type:application/json', 'Accept:application/json', $authorization));
        $output = curl_exec($handle);
        curl_close($handle);
    }else if ($_POST['function']  == 'getAgencias') {
        $post = file_get_contents('php://input');
        $array = json_decode($post);
        $handle = curl_init();

        $url = "http://190.4.56.14/".$environment."/api/agencias/listar";
        $authorization = 'Authorization: Bearer ' . $_POST['tkn'];

        /* set the content type json */

        // Set the url
        curl_setopt($handle, CURLOPT_URL, $url);
        curl_setopt($handle, CURLOPT_POST, TRUE);
        curl_setopt($handle, CURLOPT_POSTFIELDS, $post);
        curl_setopt($handle, CURLOPT_HTTPHEADER, array('Content-Type:application/json', 'Accept:application/json', $authorization));
        $output = curl_exec($handle);
        curl_close($handle);
    }else if ($_POST['function']  == 'aggInspeccion') {
        $post = file_get_contents('php://input');
        $array = json_decode($post);
        $handle = curl_init();

        $url = "http://190.4.56.14/".$environment."/api/inspecciones/agregar";
        $authorization = 'Authorization: Bearer ' . $_POST['tkn'];

        /* set the content type json */

        // Set the url
        curl_setopt($handle, CURLOPT_URL, $url);
        curl_setopt($handle, CURLOPT_POST, TRUE);
        curl_setopt($handle, CURLOPT_POSTFIELDS, $post);
        curl_setopt($handle, CURLOPT_HTTPHEADER, array('Content-Type:application/json', 'Accept:application/json', $authorization));
        $output = curl_exec($handle);
        curl_close($handle);
    }else if ($_POST['function']  == 'getInspecciones') {
        $post = file_get_contents('php://input');
        $array = json_decode($post);
        $handle = curl_init();

        $url = "http://190.4.56.14/".$environment."/api/inspecciones/listar";
        $authorization = 'Authorization: Bearer ' . $_POST['tkn'];

        /* set the content type json */

        // Set the url
        curl_setopt($handle, CURLOPT_URL, $url);
        curl_setopt($handle, CURLOPT_POST, TRUE);
        curl_setopt($handle, CURLOPT_POSTFIELDS, $post);
        curl_setopt($handle, CURLOPT_HTTPHEADER, array('Content-Type:application/json', 'Accept:application/json', $authorization));
        $output = curl_exec($handle);
        curl_close($handle);
    }else if ($_POST['function']  == 'getInspeccionById') {
        $post = file_get_contents('php://input');
        $array = json_decode($post);
        $handle = curl_init();

        $url = "http://190.4.56.14/".$environment."/api/inspecciones/getById";
        $authorization = 'Authorization: Bearer ' . $_POST['tkn'];

        /* set the content type json */

        // Set the url
        curl_setopt($handle, CURLOPT_URL, $url);
        curl_setopt($handle, CURLOPT_POST, TRUE);
        curl_setopt($handle, CURLOPT_POSTFIELDS, $post);
        curl_setopt($handle, CURLOPT_HTTPHEADER, array('Content-Type:application/json', 'Accept:application/json', $authorization));
        $output = curl_exec($handle);
        curl_close($handle);
    }else if ($_POST['function']  == 'getUsuarios') {
        $post = file_get_contents('php://input');
        $array = json_decode($post);
        $handle = curl_init();

        $url = "http://190.4.56.14/".$environment."/api/usuarios/list";
        $authorization = 'Authorization: Bearer ' . $_POST['tkn'];

        /* set the content type json */

        // Set the url
        curl_setopt($handle, CURLOPT_URL, $url);
        curl_setopt($handle, CURLOPT_POST, TRUE);
        curl_setopt($handle, CURLOPT_POSTFIELDS, $post);
        curl_setopt($handle, CURLOPT_HTTPHEADER, array('Content-Type:application/json', 'Accept:application/json', $authorization));
        $output = curl_exec($handle);
        curl_close($handle);
    }else if ($_POST['function']  == 'buscarVehiculo') {
        $post = file_get_contents('php://input');
        $array = json_decode($post);
        $handle = curl_init();

        $url = "http://190.4.56.14/".$environment."/api/vehiculos/buscar";
        $authorization = 'Authorization: Bearer ' . $_POST['tkn'];

        /* set the content type json */

        // Set the url
        curl_setopt($handle, CURLOPT_URL, $url);
        curl_setopt($handle, CURLOPT_POST, TRUE);
        curl_setopt($handle, CURLOPT_POSTFIELDS, $post);
        curl_setopt($handle, CURLOPT_HTTPHEADER, array('Content-Type:application/json', 'Accept:application/json', $authorization));
        $output = curl_exec($handle);
        curl_close($handle);
    }else if ($_POST['function']  == 'getDetalleVehiculo') {
        $post = file_get_contents('php://input');
        $array = json_decode($post);
        $handle = curl_init();

        $url = "http://190.4.56.14/".$environment."/api/vehiculos/getDetalle";
        $authorization = 'Authorization: Bearer ' . $_POST['tkn'];

        /* set the content type json */

        // Set the url
        curl_setopt($handle, CURLOPT_URL, $url);
        curl_setopt($handle, CURLOPT_POST, TRUE);
        curl_setopt($handle, CURLOPT_POSTFIELDS, $post);
        curl_setopt($handle, CURLOPT_HTTPHEADER, array('Content-Type:application/json', 'Accept:application/json', $authorization));
        $output = curl_exec($handle);
        curl_close($handle);
    }else if ($_POST['function']  == 'getTiposVehiculo') {
        $post = file_get_contents('php://input');
        $array = json_decode($post);
        $handle = curl_init();

        $url = "http://190.4.56.14/".$environment."/api/vehiculos/getTipos";
        $authorization = 'Authorization: Bearer ' . $_POST['tkn'];

        /* set the content type json */

        // Set the url
        curl_setopt($handle, CURLOPT_URL, $url);
        curl_setopt($handle, CURLOPT_POST, TRUE);
        curl_setopt($handle, CURLOPT_POSTFIELDS, $post);
        curl_setopt($handle, CURLOPT_HTTPHEADER, array('Content-Type:application/json', 'Accept:application/json', $authorization));
        $output = curl_exec($handle);
        curl_close($handle);
    }else if ($_POST['function']  == 'getTanques') {
        $post = file_get_contents('php://input');
        $array = json_decode($post);
        $handle = curl_init();

        $url = "http://190.4.56.14/".$environment."/api/vehiculos/getTanques";
        $authorization = 'Authorization: Bearer ' . $_POST['tkn'];

        /* set the content type json */

        // Set the url
        curl_setopt($handle, CURLOPT_URL, $url);
        curl_setopt($handle, CURLOPT_POST, TRUE);
        curl_setopt($handle, CURLOPT_POSTFIELDS, $post);
        curl_setopt($handle, CURLOPT_HTTPHEADER, array('Content-Type:application/json', 'Accept:application/json', $authorization));
        $output = curl_exec($handle);
        curl_close($handle);
    }else if ($_POST['function']  == 'getAccesorios') {
        $post = file_get_contents('php://input');
        $array = json_decode($post);
        $handle = curl_init();

        $url = "http://190.4.56.14/".$environment."/api/accesorios/listar";
        $authorization = 'Authorization: Bearer ' . $_POST['tkn'];

        /* set the content type json */

        // Set the url
        curl_setopt($handle, CURLOPT_URL, $url);
        curl_setopt($handle, CURLOPT_POST, TRUE);
        curl_setopt($handle, CURLOPT_POSTFIELDS, $post);
        curl_setopt($handle, CURLOPT_HTTPHEADER, array('Content-Type:application/json', 'Accept:application/json', $authorization));
        $output = curl_exec($handle);
        curl_close($handle);
    }
	else if ($_POST['function'] == 'searchPlace') {
        $post = file_get_contents('php://input');
        $array = json_decode($post);

        $handle = curl_init();

        $url = "https://calculadoradelivery.xplorerentacar.com/mod.ajax/places.php";



        // Set the url
        curl_setopt($handle, CURLOPT_URL, $url);
        curl_setopt($handle, CURLOPT_POST, TRUE);
        curl_setopt($handle, CURLOPT_POSTFIELDS, $array);
        /* set the content type json */
        curl_setopt($handle, CURLOPT_HTTPHEADER, array('Content-Type:multipart/form-data'));

        /* set return type json */
        //curl_setopt($handle, CURLOPT_RETURNTRANSFER, true);

        $output = curl_exec($handle);

        curl_close($handle);

        return json_encode($output);
    } else if ($_POST['function'] == 'deleteLabel') {
        $post = file_get_contents('php://input');
        $array = json_decode($post);

        $handle = curl_init();

        $url = "http://localhost/inspApi/api/customers/labels/delete";

        $authorization = 'Authorization: Bearer ' . $_POST['tkn'];

        // Set the url
        curl_setopt($handle, CURLOPT_URL, $url);

        curl_setopt($handle, CURLOPT_POST, TRUE);
        curl_setopt($handle, CURLOPT_POSTFIELDS, $post);
        curl_setopt($handle, CURLOPT_HTTPHEADER, array('Content-Type:application/json', 'Accept:application/json', $authorization));
        /* set return type json */

        $output = curl_exec($handle);
        curl_close($handle);
    }
}

