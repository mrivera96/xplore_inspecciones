<?php
date_default_timezone_set("America/Tegucigalpa");
setlocale(LC_TIME, 'es_HN');

$environment = 'inspApiDesa';
//$environment = 'XploreDeliveryAPI';

if (isset($_GET['function'])) {
    $func = $_GET['function'];
    if ($func == 'getCategories') {
        $handle = curl_init();

        //$url = "http://190.4.56.14/".$environment."/api/categories/list";
        $url = "http://190.4.56.14/" . $environment . "/api/shared/categories/showAll";

        // Set the url
        curl_setopt($handle, CURLOPT_URL, $url);

        $output = curl_exec($handle);

        curl_close($handle);
    } else if ($func == 'getTarifas') {
        $handle = curl_init();

        //$url = "http://190.4.56.14/".$environment."/api/deliveries/getTarifas";
        $url = "http://190.4.56.14/" . $environment . "/api/shared/rates/get";

        // Set the url
        curl_setopt($handle, CURLOPT_URL, $url);

        $output = curl_exec($handle);

        curl_close($handle);
    }
} else if (file_get_contents('php://input')) {
    $rest_json = file_get_contents("php://input");
    $_POST = json_decode($rest_json, true);
    if ($_POST['function'] == 'insertDelivery') {
        $post = file_get_contents('php://input');
        $array = json_decode($post);

        $handle = curl_init();

        //$url = "http://190.4.56.14/".$environment."/api/deliveries/new";
        $url = "http://190.4.56.14/" . $environment . "/api/deliveries/new";

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
    } else if ($_POST['function'] == 'searchPlace') {
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
    } else if ($_POST['function'] == 'calculateDistance') {
        $post = file_get_contents('php://input');
        $array = json_decode($post);

        $handle = curl_init();

        $url = "https://calculadoradelivery.xplorerentacar.com/mod.ajax/distance.php";
        //$url = "http://190.4.56.14:8069/".$environment."/public/api/deliveries/new";


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
    } else if ($_POST['function'] == 'login') {
        $post = file_get_contents('php://input');
        $array = json_decode($post);

        $handle = curl_init();

        //$url = "http://190.4.56.14/".$environment."/api/auth/login";
        $url = "http://190.4.56.14/" . $environment . "/api/auth/login";

        // Set the url
        curl_setopt($handle, CURLOPT_URL, $url);
        curl_setopt($handle, CURLOPT_POST, TRUE);
        curl_setopt($handle, CURLOPT_POSTFIELDS, $post);
        /* set the content type json */
        curl_setopt($handle, CURLOPT_HTTPHEADER, array('Content-Type:application/json', 'Accept:application/json'));

        /* set return type json */
        //curl_setopt($handle, CURLOPT_RETURNTRANSFER, true);

        $output = curl_exec($handle);

        curl_close($handle);
    } else if ($_POST['function'] == 'assignDelivery') {
        $post = file_get_contents('php://input');
        $array = json_decode($post);

        $handle = curl_init();

        //$url = "http://190.4.56.14/".$environment."/api/auth/login";
        $url = "http://190.4.56.14/" . $environment . "/api/admins/deliveries/assign";

        // Set the url
        curl_setopt($handle, CURLOPT_URL, $url);
        curl_setopt($handle, CURLOPT_POST, TRUE);
        curl_setopt($handle, CURLOPT_POSTFIELDS, $post);
        $authorization = 'Authorization: Bearer ' . $_POST['tkn'];
        /* set the content type json */
        curl_setopt($handle, CURLOPT_HTTPHEADER, array('Content-Type:application/json', 'Accept:application/json', $authorization));

        /* set return type json */
        //curl_setopt($handle, CURLOPT_RETURNTRANSFER, true);

        $output = curl_exec($handle);
        curl_close($handle);
    } else if ($_POST['function'] == 'finishDelivery') {
        $post = file_get_contents('php://input');
        $array = json_decode($post);

        $handle = curl_init();
        $authorization = 'Authorization: Bearer ' . $_POST['tkn'];

        //$url = "http://190.4.56.14/".$environment."/api/auth/login";
        $url = "http://190.4.56.14/" . $environment . "/api/admins/deliveries/finish";

        // Set the url
        curl_setopt($handle, CURLOPT_URL, $url);
        curl_setopt($handle, CURLOPT_POST, TRUE);
        curl_setopt($handle, CURLOPT_POSTFIELDS, $post);
        /* set the content type json */
        curl_setopt($handle, CURLOPT_HTTPHEADER, array('Content-Type:application/json', 'Accept:application/json', $authorization));

        /* set return type json */
        //curl_setopt($handle, CURLOPT_RETURNTRANSFER, true);

        $output = curl_exec($handle);

        curl_close($handle);
    } else if ($_POST['function'] == 'changeState') {
        $post = file_get_contents('php://input');
        $array = json_decode($post);

        $handle = curl_init();
        $authorization = 'Authorization: Bearer ' . $_POST['tkn'];

        //$url = "http://190.4.56.14/".$environment."/api/auth/login";
        $url = "http://190.4.56.14/" . $environment . "/api/admins/deliveries/changeState";
        /* set the content type json */
        curl_setopt($handle, CURLOPT_HTTPHEADER, array('Content-Type:application/json', 'Accept:application/json', $authorization));
        // Set the url
        curl_setopt($handle, CURLOPT_URL, $url);
        curl_setopt($handle, CURLOPT_POST, TRUE);
        curl_setopt($handle, CURLOPT_POSTFIELDS, $post);


        /* set return type json */
        //curl_setopt($handle, CURLOPT_RETURNTRANSFER, true);

        $output = curl_exec($handle);

        curl_close($handle);
    } else if ($_POST['function']  == 'logout') {
        $post = file_get_contents('php://input');
        $array = json_decode($post);
        $handle = curl_init();

        //$url = "http://190.4.56.14/".$environment."/api/deliveries/list";
        $url = "http://190.4.56.14/" . $environment . "/api/auth/logout";
        $authorization = 'Authorization: Bearer ' . $_POST['tkn'];


        /* set the content type json */

        // Set the url
        curl_setopt($handle, CURLOPT_URL, $url);
        curl_setopt($handle, CURLOPT_POST, TRUE);
        curl_setopt($handle, CURLOPT_POSTFIELDS, $post);
        curl_setopt($handle, CURLOPT_HTTPHEADER, array('Content-Type:application/json', 'Accept:application/json', $authorization));
        $output = curl_exec($handle);
        curl_close($handle);
    } else if ($_POST['function'] == 'getTodayCustomerDeliveries') {
        $post = file_get_contents('php://input');
        $array = json_decode($post);
        $handle = curl_init();

        //$url = "http://190.4.56.14/".$environment."/api/deliveries/list";
        $url = "http://190.4.56.14/" . $environment . "/api/customers/deliveries/getToday";
        $authorization = 'Authorization: Bearer ' . $_POST['tkn'];

        /* set the content type json */

        // Set the url
        curl_setopt($handle, CURLOPT_URL, $url);
        curl_setopt($handle, CURLOPT_POST, TRUE);
        curl_setopt($handle, CURLOPT_POSTFIELDS, $post);
        curl_setopt($handle, CURLOPT_HTTPHEADER, array('Content-Type:application/json', 'Accept:application/json', $authorization));
        $output = curl_exec($handle);
        curl_close($handle);
    } else if ($_POST['function'] == 'getAllCustomerDeliveries') {
        $post = file_get_contents('php://input');
        $array = json_decode($post);
        $handle = curl_init();

        //$url = "http://190.4.56.14/".$environment."/api/deliveries/list";
        $url = "http://190.4.56.14/" . $environment . "/api/customers/deliveries/getAll";
        $authorization = 'Authorization: Bearer ' . $_POST['tkn'];

        /* set the content type json */

        // Set the url
        curl_setopt($handle, CURLOPT_URL, $url);
        curl_setopt($handle, CURLOPT_POST, TRUE);
        curl_setopt($handle, CURLOPT_POSTFIELDS, $post);
        curl_setopt($handle, CURLOPT_HTTPHEADER, array('Content-Type:application/json', 'Accept:application/json', $authorization));
        $output = curl_exec($handle);
        curl_close($handle);
    } else if ($_POST['function'] == 'getCustomerBranchOffices') {
        $post = file_get_contents('php://input');
        $array = json_decode($post);
        $handle = curl_init();

        //$url = "http://190.4.56.14/".$environment."/api/deliveries/list";
        $url = "http://190.4.56.14/" . $environment . "/api/customers/address/get";
        $authorization = 'Authorization: Bearer ' . $_POST['tkn'];

        /* set the content type json */

        // Set the url
        curl_setopt($handle, CURLOPT_URL, $url);
        curl_setopt($handle, CURLOPT_POST, TRUE);
        curl_setopt($handle, CURLOPT_POSTFIELDS, $post);
        curl_setopt($handle, CURLOPT_HTTPHEADER, array('Content-Type:application/json', 'Accept:application/json', $authorization));
        $output = curl_exec($handle);
        curl_close($handle);
    } else if ($_POST['function'] == 'insertCustomerDelivery') {
        $post = file_get_contents('php://input');
        $array = json_decode($post);
        $handle = curl_init();

        //$url = "http://190.4.56.14/".$environment."/api/deliveries/list";
        $url = "http://190.4.56.14/" . $environment . "/api/customers/deliveries/new";
        $authorization = 'Authorization: Bearer ' . $_POST['tkn'];

        /* set the content type json */

        // Set the url
        curl_setopt($handle, CURLOPT_URL, $url);
        curl_setopt($handle, CURLOPT_POST, TRUE);
        curl_setopt($handle, CURLOPT_POSTFIELDS, $post);
        curl_setopt($handle, CURLOPT_HTTPHEADER, array('Content-Type:application/json', 'Accept:application/json', $authorization));
        $output = curl_exec($handle);
        curl_close($handle);
    } else if ($_POST['function'] == 'getTodayDeliveries') {
        $post = file_get_contents('php://input');
        $array = json_decode($post);

        $handle = curl_init();

        //$url = "http://190.4.56.14/".$environment."/api/deliveries/list";
        $url = "http://190.4.56.14/" . $environment . "/api/admins/deliveries/getToday";
        $authorization = 'Authorization: Bearer ' . $_POST['tkn'];

        // Set the url
        curl_setopt($handle, CURLOPT_URL, $url);

        curl_setopt($handle, CURLOPT_POST, TRUE);
        curl_setopt($handle, CURLOPT_POSTFIELDS, $post);
        curl_setopt($handle, CURLOPT_HTTPHEADER, array('Content-Type:application/json', 'Accept:application/json', $authorization));
        $output = curl_exec($handle);
        curl_close($handle);
    } else if ($_POST['function'] == 'getTomorrowDeliveries') {
        $post = file_get_contents('php://input');
        $array = json_decode($post);

        $handle = curl_init();

        //$url = "http://190.4.56.14/".$environment."/api/deliveries/list";
        $url = "http://190.4.56.14/" . $environment . "/api/admins/deliveries/getTomorrow";
        $authorization = 'Authorization: Bearer ' . $_POST['tkn'];

        // Set the url
        curl_setopt($handle, CURLOPT_URL, $url);

        curl_setopt($handle, CURLOPT_POST, TRUE);
        curl_setopt($handle, CURLOPT_POSTFIELDS, $post);
        curl_setopt($handle, CURLOPT_HTTPHEADER, array('Content-Type:application/json', 'Accept:application/json', $authorization));
        $output = curl_exec($handle);
        curl_close($handle);
    } else if ($_POST['function'] == 'getAllDeliveries') {
        $post = file_get_contents('php://input');
        $array = json_decode($post);

        $handle = curl_init();

        //$url = "http://190.4.56.14/".$environment."/api/deliveries/list";
        $url = "http://190.4.56.14/" . $environment . "/api/admins/deliveries/getAll";
        $authorization = 'Authorization: Bearer ' . $_POST['tkn'];

        // Set the url
        curl_setopt($handle, CURLOPT_URL, $url);

        curl_setopt($handle, CURLOPT_POST, TRUE);
        curl_setopt($handle, CURLOPT_POSTFIELDS, $post);
        curl_setopt($handle, CURLOPT_HTTPHEADER, array('Content-Type:application/json', 'Accept:application/json', $authorization));
        $output = curl_exec($handle);
        curl_close($handle);
    } else if ($_POST['function'] == 'getDeliveryById') {
        $post = file_get_contents('php://input');
        $array = json_decode($post);

        $handle = curl_init();

        //$url = "http://190.4.56.14/".$environment."/api/deliveries/list";
        $url = "http://190.4.56.14/" . $environment . "/api/shared/deliveries/getById";
        $authorization = 'Authorization: Bearer ' . $_POST['tkn'];


        // Set the url
        curl_setopt($handle, CURLOPT_URL, $url);

        curl_setopt($handle, CURLOPT_POST, TRUE);
        curl_setopt($handle, CURLOPT_POSTFIELDS, $post);
        curl_setopt($handle, CURLOPT_HTTPHEADER, array('Content-Type:application/json', 'Accept:application/json', $authorization));
        $output = curl_exec($handle);
        curl_close($handle);
    } else if ($_POST['function'] == 'showAllCategories') {
        $post = file_get_contents('php://input');
        $array = json_decode($post);

        $handle = curl_init();

        //$url = "http://190.4.56.14/".$environment."/api/categories/showAll";
        $url = "http://190.4.56.14/" . $environment . "/api/shared/categories/showAll";
        $authorization = 'Authorization: Bearer ' . $_POST['tkn'];

        // Set the url
        curl_setopt($handle, CURLOPT_URL, $url);

        curl_setopt($handle, CURLOPT_POST, TRUE);
        curl_setopt($handle, CURLOPT_POSTFIELDS, $post);
        curl_setopt($handle, CURLOPT_HTTPHEADER, array('Content-Type:application/json', 'Accept:application/json', $authorization));
        /* set return type json */

        $output = curl_exec($handle);
        curl_close($handle);
    } else if ($_POST['function'] == 'editCategory') {
        $post = file_get_contents('php://input');
        $array = json_decode($post);

        $handle = curl_init();

        //$url = "http://190.4.56.14/".$environment."/api/categories/update";
        $url = "http://190.4.56.14/" . $environment . "/api/admins/categories/update";
        $authorization = 'Authorization: Bearer ' . $_POST['tkn'];

        // Set the url
        curl_setopt($handle, CURLOPT_URL, $url);

        curl_setopt($handle, CURLOPT_POST, TRUE);
        curl_setopt($handle, CURLOPT_POSTFIELDS, $post);
        curl_setopt($handle, CURLOPT_HTTPHEADER, array('Content-Type:application/json', 'Accept:application/json', $authorization));
        /* set return type json */

        $output = curl_exec($handle);
        curl_close($handle);
    } else if ($_POST['function'] == 'editRate') {
        $post = file_get_contents('php://input');
        $array = json_decode($post);

        $handle = curl_init();

        //$url = "http://190.4.56.14/".$environment."/api/rates/update";
        $url = "http://190.4.56.14/" . $environment . "/api/admins/rates/update";
        $authorization = 'Authorization: Bearer ' . $_POST['tkn'];

        // Set the url
        curl_setopt($handle, CURLOPT_URL, $url);

        curl_setopt($handle, CURLOPT_POST, TRUE);
        curl_setopt($handle, CURLOPT_POSTFIELDS, $post);
        curl_setopt($handle, CURLOPT_HTTPHEADER, array('Content-Type:application/json', 'Accept:application/json', $authorization));
        /* set return type json */

        $output = curl_exec($handle);
        curl_close($handle);
    } else if ($_POST['function'] == 'getTodayCustomerOrders') {
        $post = file_get_contents('php://input');
        $array = json_decode($post);

        $handle = curl_init();

        //$url = "http://190.4.56.14/".$environment."/api/customers/getCustomerOrders";
        $url = "http://190.4.56.14/" . $environment . "/api/customers/orders/getToday";
        $authorization = 'Authorization: Bearer ' . $_POST['tkn'];

        // Set the url
        curl_setopt($handle, CURLOPT_URL, $url);

        curl_setopt($handle, CURLOPT_POST, TRUE);
        curl_setopt($handle, CURLOPT_POSTFIELDS, $post);
        curl_setopt($handle, CURLOPT_HTTPHEADER, array('Content-Type:application/json', 'Accept:application/json', $authorization));
        /* set return type json */

        $output = curl_exec($handle);
        curl_close($handle);
    } else if ($_POST['function'] == 'getAllCustomerOrders') {
        $post = file_get_contents('php://input');
        $array = json_decode($post);

        $handle = curl_init();

        //$url = "http://190.4.56.14/".$environment."/api/customers/getCustomerOrders";
        $url = "http://190.4.56.14/" . $environment . "/api/customers/orders/getAll";
        $authorization = 'Authorization: Bearer ' . $_POST['tkn'];

        // Set the url
        curl_setopt($handle, CURLOPT_URL, $url);

        curl_setopt($handle, CURLOPT_POST, TRUE);
        curl_setopt($handle, CURLOPT_POSTFIELDS, $post);
        curl_setopt($handle, CURLOPT_HTTPHEADER, array('Content-Type:application/json', 'Accept:application/json', $authorization));
        /* set return type json */

        $output = curl_exec($handle);
        curl_close($handle);
    } else if ($_POST['function'] == 'getCustomers') {
        $post = file_get_contents('php://input');
        $array = json_decode($post);

        $handle = curl_init();

        //$url = "http://190.4.56.14/".$environment."/api/customers/getCustomerOrders";
        $url = "http://190.4.56.14/" . $environment . "/api/admins/customers/get";
        $authorization = 'Authorization: Bearer ' . $_POST['tkn'];

        // Set the url
        curl_setopt($handle, CURLOPT_URL, $url);

        curl_setopt($handle, CURLOPT_POST, TRUE);
        curl_setopt($handle, CURLOPT_POSTFIELDS, $post);
        curl_setopt($handle, CURLOPT_HTTPHEADER, array('Content-Type:application/json', 'Accept:application/json', $authorization));
        /* set return type json */

        $output = curl_exec($handle);
        curl_close($handle);
    } else if ($_POST['function'] == 'newCustomer') {
        $post = file_get_contents('php://input');
        $array = json_decode($post);

        $handle = curl_init();

        //$url = "http://190.4.56.14/".$environment."/api/customers/getCustomerOrders";
        $url = "http://190.4.56.14/" . $environment . "/api/admins/customers/new";
        $authorization = 'Authorization: Bearer ' . $_POST['tkn'];

        // Set the url
        curl_setopt($handle, CURLOPT_URL, $url);

        curl_setopt($handle, CURLOPT_POST, TRUE);
        curl_setopt($handle, CURLOPT_POSTFIELDS, $post);
        curl_setopt($handle, CURLOPT_HTTPHEADER, array('Content-Type:application/json', 'Accept:application/json', $authorization));
        /* set return type json */

        $output = curl_exec($handle);
        curl_close($handle);
    } else if ($_POST['function'] == 'newBranch') {
        $post = file_get_contents('php://input');
        $array = json_decode($post);

        $handle = curl_init();

        //$url = "http://190.4.56.14/".$environment."/api/customers/getCustomerOrders";
        $url = "http://190.4.56.14/" . $environment . "/api/customers/address/new";
        $authorization = 'Authorization: Bearer ' . $_POST['tkn'];

        // Set the url
        curl_setopt($handle, CURLOPT_URL, $url);

        curl_setopt($handle, CURLOPT_POST, TRUE);
        curl_setopt($handle, CURLOPT_POSTFIELDS, $post);
        curl_setopt($handle, CURLOPT_HTTPHEADER, array('Content-Type:application/json', 'Accept:application/json', $authorization));
        /* set return type json */

        $output = curl_exec($handle);
        curl_close($handle);
    } else if ($_POST['function'] == 'changeCustomerPassword') {
        $post = file_get_contents('php://input');
        $array = json_decode($post);

        $handle = curl_init();

        //$url = "http://190.4.56.14/".$environment."/api/customers/changePassword";
        $url = "http://190.4.56.14/" . $environment . "/api/admins/customers/changePassword";
        $authorization = 'Authorization: Bearer ' . $_POST['tkn'];

        // Set the url
        curl_setopt($handle, CURLOPT_URL, $url);

        curl_setopt($handle, CURLOPT_POST, TRUE);
        curl_setopt($handle, CURLOPT_POSTFIELDS, $post);
        curl_setopt($handle, CURLOPT_HTTPHEADER, array('Content-Type:application/json', 'Accept:application/json', $authorization));
        /* set return type json */

        $output = curl_exec($handle);
        curl_close($handle);
    } else if ($_POST['function'] == 'updateBranch') {
        $post = file_get_contents('php://input');
        $array = json_decode($post);

        $handle = curl_init();

        //$url = "http://190.4.56.14/".$environment."/api/customers/changePassword";
        $url = "http://190.4.56.14/" . $environment . "/api/customers/address/update";
        $authorization = 'Authorization: Bearer ' . $_POST['tkn'];

        // Set the url
        curl_setopt($handle, CURLOPT_URL, $url);

        curl_setopt($handle, CURLOPT_POST, TRUE);
        curl_setopt($handle, CURLOPT_POSTFIELDS, $post);
        curl_setopt($handle, CURLOPT_HTTPHEADER, array('Content-Type:application/json', 'Accept:application/json', $authorization));
        /* set return type json */

        $output = curl_exec($handle);
        curl_close($handle);
    } else if ($_POST['function'] == 'deleteBranch') {
        $post = file_get_contents('php://input');
        $array = json_decode($post);

        $handle = curl_init();

        //$url = "http://190.4.56.14/".$environment."/api/customers/changePassword";
        $url = "http://190.4.56.14/" . $environment . "/api/customers/address/delete";
        $authorization = 'Authorization: Bearer ' . $_POST['tkn'];

        // Set the url
        curl_setopt($handle, CURLOPT_URL, $url);

        curl_setopt($handle, CURLOPT_POST, TRUE);
        curl_setopt($handle, CURLOPT_POSTFIELDS, $post);
        curl_setopt($handle, CURLOPT_HTTPHEADER, array('Content-Type:application/json', 'Accept:application/json', $authorization));
        /* set return type json */

        $output = curl_exec($handle);
        curl_close($handle);
    } else if ($_POST['function'] == 'getTodayOrders') {
        $post = file_get_contents('php://input');
        $array = json_decode($post);

        $handle = curl_init();

        //$url = "http://190.4.56.14/".$environment."/api/customers/changePassword";
        $url = "http://190.4.56.14/" . $environment . "/api/admins/orders/getToday";
        $authorization = 'Authorization: Bearer ' . $_POST['tkn'];

        // Set the url
        curl_setopt($handle, CURLOPT_URL, $url);

        curl_setopt($handle, CURLOPT_POST, TRUE);
        curl_setopt($handle, CURLOPT_POSTFIELDS, $post);
        curl_setopt($handle, CURLOPT_HTTPHEADER, array('Content-Type:application/json', 'Accept:application/json', $authorization));
        /* set return type json */

        $output = curl_exec($handle);
        curl_close($handle);
    } else if ($_POST['function'] == 'getAllOrders') {
        $post = file_get_contents('php://input');
        $array = json_decode($post);

        $handle = curl_init();

        //$url = "http://190.4.56.14/".$environment."/api/customers/changePassword";
        $url = "http://190.4.56.14/" . $environment . "/api/admins/orders/getAll";
        $authorization = 'Authorization: Bearer ' . $_POST['tkn'];

        // Set the url
        curl_setopt($handle, CURLOPT_URL, $url);

        curl_setopt($handle, CURLOPT_POST, TRUE);
        curl_setopt($handle, CURLOPT_POSTFIELDS, $post);
        curl_setopt($handle, CURLOPT_HTTPHEADER, array('Content-Type:application/json', 'Accept:application/json', $authorization));
        /* set return type json */

        $output = curl_exec($handle);
        curl_close($handle);
    } else if ($_POST['function'] == 'createCategory') {
        $post = file_get_contents('php://input');
        $array = json_decode($post);

        $handle = curl_init();

        //$url = "http://190.4.56.14/".$environment."/api/categories/create";
        $url = "http://190.4.56.14/" . $environment . "/api/admins/categories/create";
        $authorization = 'Authorization: Bearer ' . $_POST['tkn'];

        // Set the url
        curl_setopt($handle, CURLOPT_URL, $url);

        curl_setopt($handle, CURLOPT_POST, TRUE);
        curl_setopt($handle, CURLOPT_POSTFIELDS, $post);
        curl_setopt($handle, CURLOPT_HTTPHEADER, array('Content-Type:application/json', 'Accept:application/json', $authorization));
        /* set return type json */

        $output = curl_exec($handle);
        curl_close($handle);
    } else if ($_POST['function'] == 'createRate') {
        $post = file_get_contents('php://input');
        $array = json_decode($post);

        $handle = curl_init();

        //$url = "http://190.4.56.14/".$environment."/api/rates/create";
        $url = "http://190.4.56.14/" . $environment . "/api/admins/rates/create";
        $authorization = 'Authorization: Bearer ' . $_POST['tkn'];

        // Set the url
        curl_setopt($handle, CURLOPT_URL, $url);

        curl_setopt($handle, CURLOPT_POST, TRUE);
        curl_setopt($handle, CURLOPT_POSTFIELDS, $post);
        curl_setopt($handle, CURLOPT_HTTPHEADER, array('Content-Type:application/json', 'Accept:application/json', $authorization));
        /* set return type json */

        $output = curl_exec($handle);
        curl_close($handle);
    } else if ($_POST['function'] == 'getMyRates') {
        $post = file_get_contents('php://input');
        $array = json_decode($post);

        $handle = curl_init();

        $url = "http://190.4.56.14/" . $environment . "/api/customers/rates/get";

        $authorization = 'Authorization: Bearer ' . $_POST['tkn'];

        // Set the url
        curl_setopt($handle, CURLOPT_URL, $url);

        curl_setopt($handle, CURLOPT_POST, TRUE);
        curl_setopt($handle, CURLOPT_POSTFIELDS, $post);
        curl_setopt($handle, CURLOPT_HTTPHEADER, array('Content-Type:application/json', 'Accept:application/json', $authorization));
        /* set return type json */

        $output = curl_exec($handle);
        curl_close($handle);
    } else if ($_POST['function'] == 'getMySurcharges') {
        $post = file_get_contents('php://input');
        $array = json_decode($post);

        $handle = curl_init();

        $url = "http://190.4.56.14/" . $environment . "/api/customers/surcharges/get";

        $authorization = 'Authorization: Bearer ' . $_POST['tkn'];

        // Set the url
        curl_setopt($handle, CURLOPT_URL, $url);

        curl_setopt($handle, CURLOPT_POST, TRUE);
        curl_setopt($handle, CURLOPT_POSTFIELDS, $post);
        curl_setopt($handle, CURLOPT_HTTPHEADER, array('Content-Type:application/json', 'Accept:application/json', $authorization));
        /* set return type json */

        $output = curl_exec($handle);
        curl_close($handle);
    } else if ($_POST['function'] == 'createSurcharge') {
        $post = file_get_contents('php://input');
        $array = json_decode($post);

        $handle = curl_init();

        //$url = "http://190.4.56.14/".$environment."/api/rates/create";
        $url = "http://190.4.56.14/" . $environment . "/api/admins/surcharges/create";
        $authorization = 'Authorization: Bearer ' . $_POST['tkn'];

        // Set the url
        curl_setopt($handle, CURLOPT_URL, $url);

        curl_setopt($handle, CURLOPT_POST, TRUE);
        curl_setopt($handle, CURLOPT_POSTFIELDS, $post);
        curl_setopt($handle, CURLOPT_HTTPHEADER, array('Content-Type:application/json', 'Accept:application/json', $authorization));
        /* set return type json */

        $output = curl_exec($handle);
        curl_close($handle);
    } else if ($_POST['function'] == 'editSurcharge') {
        $post = file_get_contents('php://input');
        $array = json_decode($post);

        $handle = curl_init();

        //$url = "http://190.4.56.14/".$environment."/api/rates/create";
        $url = "http://190.4.56.14/" . $environment . "/api/admins/surcharges/update";
        $authorization = 'Authorization: Bearer ' . $_POST['tkn'];

        // Set the url
        curl_setopt($handle, CURLOPT_URL, $url);

        curl_setopt($handle, CURLOPT_POST, TRUE);
        curl_setopt($handle, CURLOPT_POSTFIELDS, $post);
        curl_setopt($handle, CURLOPT_HTTPHEADER, array('Content-Type:application/json', 'Accept:application/json', $authorization));
        /* set return type json */

        $output = curl_exec($handle);
        curl_close($handle);
    } else if ($_POST['function'] == 'getMyCategories') {
        $post = file_get_contents('php://input');
        $array = json_decode($post);

        $handle = curl_init();

        $url = "http://190.4.56.14/" . $environment . "/api/customers/categories/get";

        $authorization = 'Authorization: Bearer ' . $_POST['tkn'];

        // Set the url
        curl_setopt($handle, CURLOPT_URL, $url);

        curl_setopt($handle, CURLOPT_POST, TRUE);
        curl_setopt($handle, CURLOPT_POSTFIELDS, $post);
        curl_setopt($handle, CURLOPT_HTTPHEADER, array('Content-Type:application/json', 'Accept:application/json', $authorization));
        /* set return type json */

        $output = curl_exec($handle);
        curl_close($handle);
    } else if ($_POST['function'] == 'getDrivers') {
        $post = file_get_contents('php://input');
        $array = json_decode($post);

        $handle = curl_init();

        $url = "http://190.4.56.14/" . $environment . "/api/admins/drivers/get";

        $authorization = 'Authorization: Bearer ' . $_POST['tkn'];

        // Set the url
        curl_setopt($handle, CURLOPT_URL, $url);

        curl_setopt($handle, CURLOPT_POST, TRUE);
        curl_setopt($handle, CURLOPT_POSTFIELDS, $post);
        curl_setopt($handle, CURLOPT_HTTPHEADER, array('Content-Type:application/json', 'Accept:application/json', $authorization));
        /* set return type json */

        $output = curl_exec($handle);
        curl_close($handle);
    } else if ($_POST['function'] == 'createDriver') {
        $post = file_get_contents('php://input');
        $array = json_decode($post);

        $handle = curl_init();

        $url = "http://190.4.56.14/" . $environment . "/api/admins/drivers/create";

        $authorization = 'Authorization: Bearer ' . $_POST['tkn'];

        // Set the url
        curl_setopt($handle, CURLOPT_URL, $url);

        curl_setopt($handle, CURLOPT_POST, TRUE);
        curl_setopt($handle, CURLOPT_POSTFIELDS, $post);
        curl_setopt($handle, CURLOPT_HTTPHEADER, array('Content-Type:application/json', 'Accept:application/json', $authorization));
        /* set return type json */

        $output = curl_exec($handle);
        curl_close($handle);
    } else if ($_POST['function'] == 'editDriver') {
        $post = file_get_contents('php://input');
        $array = json_decode($post);

        $handle = curl_init();

        $url = "http://190.4.56.14/" . $environment . "/api/admins/drivers/update";

        $authorization = 'Authorization: Bearer ' . $_POST['tkn'];

        // Set the url
        curl_setopt($handle, CURLOPT_URL, $url);

        curl_setopt($handle, CURLOPT_POST, TRUE);
        curl_setopt($handle, CURLOPT_POSTFIELDS, $post);
        curl_setopt($handle, CURLOPT_HTTPHEADER, array('Content-Type:application/json', 'Accept:application/json', $authorization));
        /* set return type json */

        $output = curl_exec($handle);
        curl_close($handle);
    } else if ($_POST['function'] == 'editCustomer') {
        $post = file_get_contents('php://input');
        $array = json_decode($post);

        $handle = curl_init();

        $url = "http://190.4.56.14/" . $environment . "/api/admins/customers/update";

        $authorization = 'Authorization: Bearer ' . $_POST['tkn'];

        // Set the url
        curl_setopt($handle, CURLOPT_URL, $url);

        curl_setopt($handle, CURLOPT_POST, TRUE);
        curl_setopt($handle, CURLOPT_POSTFIELDS, $post);
        curl_setopt($handle, CURLOPT_HTTPHEADER, array('Content-Type:application/json', 'Accept:application/json', $authorization));
        /* set return type json */

        $output = curl_exec($handle);
        curl_close($handle);
    } else if ($_POST['function'] == 'getPendingDeliveries') {
        $post = file_get_contents('php://input');
        $array = json_decode($post);

        $handle = curl_init();

        $url = "http://190.4.56.14/" . $environment . "/api/admins/deliveries/getPending";

        $authorization = 'Authorization: Bearer ' . $_POST['tkn'];

        // Set the url
        curl_setopt($handle, CURLOPT_URL, $url);

        curl_setopt($handle, CURLOPT_POST, TRUE);
        curl_setopt($handle, CURLOPT_POSTFIELDS, $post);
        curl_setopt($handle, CURLOPT_HTTPHEADER, array('Content-Type:application/json', 'Accept:application/json', $authorization));
        /* set return type json */

        $output = curl_exec($handle);
        curl_close($handle);
    } else if ($_POST['function'] == 'getCities') {
        $post = file_get_contents('php://input');
        $array = json_decode($post);

        $handle = curl_init();

        $url = "http://190.4.56.14/" . $environment . "/api/admins/cities/get";

        $authorization = 'Authorization: Bearer ' . $_POST['tkn'];

        // Set the url
        curl_setopt($handle, CURLOPT_URL, $url);

        curl_setopt($handle, CURLOPT_POST, TRUE);
        curl_setopt($handle, CURLOPT_POSTFIELDS, $post);
        curl_setopt($handle, CURLOPT_HTTPHEADER, array('Content-Type:application/json', 'Accept:application/json', $authorization));
        /* set return type json */

        $output = curl_exec($handle);
        curl_close($handle);
    } else if ($_POST['function'] == 'getAgencies') {
        $post = file_get_contents('php://input');
        $array = json_decode($post);

        $handle = curl_init();

        $url = "http://190.4.56.14/" . $environment . "/api/admins/agencies/list";

        $authorization = 'Authorization: Bearer ' . $_POST['tkn'];

        // Set the url
        curl_setopt($handle, CURLOPT_URL, $url);

        curl_setopt($handle, CURLOPT_POST, TRUE);
        curl_setopt($handle, CURLOPT_POSTFIELDS, $post);
        curl_setopt($handle, CURLOPT_HTTPHEADER, array('Content-Type:application/json', 'Accept:application/json', $authorization));
        /* set return type json */

        $output = curl_exec($handle);
        curl_close($handle);
    } else if ($_POST['function'] == 'changeHour') {
        $post = file_get_contents('php://input');
        $array = json_decode($post);

        $handle = curl_init();

        $url = "http://190.4.56.14/" . $environment . "/api/customers/deliveries/changeHour";

        $authorization = 'Authorization: Bearer ' . $_POST['tkn'];

        // Set the url
        curl_setopt($handle, CURLOPT_URL, $url);

        curl_setopt($handle, CURLOPT_POST, TRUE);
        curl_setopt($handle, CURLOPT_POSTFIELDS, $post);
        curl_setopt($handle, CURLOPT_HTTPHEADER, array('Content-Type:application/json', 'Accept:application/json', $authorization));
        /* set return type json */

        $output = curl_exec($handle);
        curl_close($handle);
    } else if ($_POST['function'] == 'reportOrdersByDriver') {
        $post = file_get_contents('php://input');
        $array = json_decode($post);

        $handle = curl_init();

        $url = "http://190.4.56.14/" . $environment . "/api/admins/reports/ordersByDriver";

        $authorization = 'Authorization: Bearer ' . $_POST['tkn'];

        // Set the url
        curl_setopt($handle, CURLOPT_URL, $url);

        curl_setopt($handle, CURLOPT_POST, TRUE);
        curl_setopt($handle, CURLOPT_POSTFIELDS, $post);
        curl_setopt($handle, CURLOPT_HTTPHEADER, array('Content-Type:application/json', 'Accept:application/json', $authorization));
        /* set return type json */

        $output = curl_exec($handle);
        curl_close($handle);
    } else if ($_POST['function'] == 'createPayment') {
        $post = file_get_contents('php://input');
        $array = json_decode($post);

        $handle = curl_init();

        $url = "http://190.4.56.14/" . $environment . "/api/admins/payments/create";

        $authorization = 'Authorization: Bearer ' . $_POST['tkn'];

        // Set the url
        curl_setopt($handle, CURLOPT_URL, $url);

        curl_setopt($handle, CURLOPT_POST, TRUE);
        curl_setopt($handle, CURLOPT_POSTFIELDS, $post);
        curl_setopt($handle, CURLOPT_HTTPHEADER, array('Content-Type:application/json', 'Accept:application/json', $authorization));
        /* set return type json */

        $output = curl_exec($handle);
        curl_close($handle);
    } else if ($_POST['function'] == 'getPayments') {
        $post = file_get_contents('php://input');
        $array = json_decode($post);

        $handle = curl_init();

        $url = "http://190.4.56.14/" . $environment . "/api/shared/payments/list";

        $authorization = 'Authorization: Bearer ' . $_POST['tkn'];

        // Set the url
        curl_setopt($handle, CURLOPT_URL, $url);

        curl_setopt($handle, CURLOPT_POST, TRUE);
        curl_setopt($handle, CURLOPT_POSTFIELDS, $post);
        curl_setopt($handle, CURLOPT_HTTPHEADER, array('Content-Type:application/json', 'Accept:application/json', $authorization));
        /* set return type json */

        $output = curl_exec($handle);
        curl_close($handle);
    } else if ($_POST['function'] == 'getPaymentTypes') {
        $post = file_get_contents('php://input');
        $array = json_decode($post);

        $handle = curl_init();

        $url = "http://190.4.56.14/" . $environment . "/api/admins/payments/listTypes";

        $authorization = 'Authorization: Bearer ' . $_POST['tkn'];

        // Set the url
        curl_setopt($handle, CURLOPT_URL, $url);

        curl_setopt($handle, CURLOPT_POST, TRUE);
        curl_setopt($handle, CURLOPT_POSTFIELDS, $post);
        curl_setopt($handle, CURLOPT_HTTPHEADER, array('Content-Type:application/json', 'Accept:application/json', $authorization));
        /* set return type json */

        $output = curl_exec($handle);
        curl_close($handle);
    } else if ($_POST['function'] == 'removeCustomerFromRate') {
        $post = file_get_contents('php://input');
        $array = json_decode($post);

        $handle = curl_init();

        $url = "http://190.4.56.14/" . $environment . "/api/admins/rates/removeCustomer";

        $authorization = 'Authorization: Bearer ' . $_POST['tkn'];

        // Set the url
        curl_setopt($handle, CURLOPT_URL, $url);

        curl_setopt($handle, CURLOPT_POST, TRUE);
        curl_setopt($handle, CURLOPT_POSTFIELDS, $post);
        curl_setopt($handle, CURLOPT_HTTPHEADER, array('Content-Type:application/json', 'Accept:application/json', $authorization));
        /* set return type json */

        $output = curl_exec($handle);
        curl_close($handle);
    } else if ($_POST['function'] == 'getRateCustomers') {
        $post = file_get_contents('php://input');
        $array = json_decode($post);

        $handle = curl_init();

        $url = "http://190.4.56.14/" . $environment . "/api/admins/rates/getCustomers";

        $authorization = 'Authorization: Bearer ' . $_POST['tkn'];

        // Set the url
        curl_setopt($handle, CURLOPT_URL, $url);

        curl_setopt($handle, CURLOPT_POST, TRUE);
        curl_setopt($handle, CURLOPT_POSTFIELDS, $post);
        curl_setopt($handle, CURLOPT_HTTPHEADER, array('Content-Type:application/json', 'Accept:application/json', $authorization));
        /* set return type json */

        $output = curl_exec($handle);
        curl_close($handle);
    } else if ($_POST['function'] == 'addCustomerToRate') {
        $post = file_get_contents('php://input');
        $array = json_decode($post);

        $handle = curl_init();

        $url = "http://190.4.56.14/" . $environment . "/api/admins/rates/addCustomer";

        $authorization = 'Authorization: Bearer ' . $_POST['tkn'];

        // Set the url
        curl_setopt($handle, CURLOPT_URL, $url);

        curl_setopt($handle, CURLOPT_POST, TRUE);
        curl_setopt($handle, CURLOPT_POSTFIELDS, $post);
        curl_setopt($handle, CURLOPT_HTTPHEADER, array('Content-Type:application/json', 'Accept:application/json', $authorization));
        /* set return type json */

        $output = curl_exec($handle);
        curl_close($handle);
    } else if ($_POST['function'] == 'changeOrderState') {
        $post = file_get_contents('php://input');
        $array = json_decode($post);

        $handle = curl_init();

        $url = "http://190.4.56.14/" . $environment . "/api/admins/orders/changeState";

        $authorization = 'Authorization: Bearer ' . $_POST['tkn'];

        // Set the url
        curl_setopt($handle, CURLOPT_URL, $url);

        curl_setopt($handle, CURLOPT_POST, TRUE);
        curl_setopt($handle, CURLOPT_POSTFIELDS, $post);
        curl_setopt($handle, CURLOPT_HTTPHEADER, array('Content-Type:application/json', 'Accept:application/json', $authorization));
        /* set return type json */

        $output = curl_exec($handle);
        curl_close($handle);
    } else if ($_POST['function'] == 'editSchedule') {
        $post = file_get_contents('php://input');
        $array = json_decode($post);

        $handle = curl_init();

        $url = "http://190.4.56.14/" . $environment . "/api/admins/schedule/update";

        $authorization = 'Authorization: Bearer ' . $_POST['tkn'];

        // Set the url
        curl_setopt($handle, CURLOPT_URL, $url);

        curl_setopt($handle, CURLOPT_POST, TRUE);
        curl_setopt($handle, CURLOPT_POSTFIELDS, $post);
        curl_setopt($handle, CURLOPT_HTTPHEADER, array('Content-Type:application/json', 'Accept:application/json', $authorization));
        /* set return type json */

        $output = curl_exec($handle);
        curl_close($handle);
    } else if ($_POST['function'] == 'reportOrdersByCustomer') {
        $post = file_get_contents('php://input');
        $array = json_decode($post);

        $handle = curl_init();

        $url = "http://190.4.56.14/" . $environment . "/api/admins/reports/ordersByCustomer";

        $authorization = 'Authorization: Bearer ' . $_POST['tkn'];

        // Set the url
        curl_setopt($handle, CURLOPT_URL, $url);

        curl_setopt($handle, CURLOPT_POST, TRUE);
        curl_setopt($handle, CURLOPT_POSTFIELDS, $post);
        curl_setopt($handle, CURLOPT_HTTPHEADER, array('Content-Type:application/json', 'Accept:application/json', $authorization));
        /* set return type json */

        $output = curl_exec($handle);
        curl_close($handle);
    } else if ($_POST['function'] == 'getCustomerOrdersFAdmin') {
        $post = file_get_contents('php://input');
        $array = json_decode($post);

        $handle = curl_init();

        $url = "http://190.4.56.14/" . $environment . "/api/admins/orders/getOrdersByCustomer";

        $authorization = 'Authorization: Bearer ' . $_POST['tkn'];

        // Set the url
        curl_setopt($handle, CURLOPT_URL, $url);

        curl_setopt($handle, CURLOPT_POST, TRUE);
        curl_setopt($handle, CURLOPT_POSTFIELDS, $post);
        curl_setopt($handle, CURLOPT_HTTPHEADER, array('Content-Type:application/json', 'Accept:application/json', $authorization));
        /* set return type json */

        $output = curl_exec($handle);
        curl_close($handle);
    } else if ($_POST['function'] == 'getExtraCharges') {
        $post = file_get_contents('php://input');
        $array = json_decode($post);

        $handle = curl_init();

        $url = "http://190.4.56.14/" . $environment . "/api/admins/extraCharges/get";

        $authorization = 'Authorization: Bearer ' . $_POST['tkn'];

        // Set the url
        curl_setopt($handle, CURLOPT_URL, $url);

        curl_setopt($handle, CURLOPT_POST, TRUE);
        curl_setopt($handle, CURLOPT_POSTFIELDS, $post);
        curl_setopt($handle, CURLOPT_HTTPHEADER, array('Content-Type:application/json', 'Accept:application/json', $authorization));
        /* set return type json */

        $output = curl_exec($handle);
        curl_close($handle);
    } else if ($_POST['function'] == 'createExtraCharge') {
        $post = file_get_contents('php://input');
        $array = json_decode($post);

        $handle = curl_init();

        $url = "http://190.4.56.14/" . $environment . "/api/admins/extraCharges/create";

        $authorization = 'Authorization: Bearer ' . $_POST['tkn'];

        // Set the url
        curl_setopt($handle, CURLOPT_URL, $url);

        curl_setopt($handle, CURLOPT_POST, TRUE);
        curl_setopt($handle, CURLOPT_POSTFIELDS, $post);
        curl_setopt($handle, CURLOPT_HTTPHEADER, array('Content-Type:application/json', 'Accept:application/json', $authorization));
        /* set return type json */

        $output = curl_exec($handle);
        curl_close($handle);
    } else if ($_POST['function'] == 'updateExtraCharge') {
        $post = file_get_contents('php://input');
        $array = json_decode($post);

        $handle = curl_init();

        $url = "http://190.4.56.14/" . $environment . "/api/admins/extraCharges/update";

        $authorization = 'Authorization: Bearer ' . $_POST['tkn'];

        // Set the url
        curl_setopt($handle, CURLOPT_URL, $url);

        curl_setopt($handle, CURLOPT_POST, TRUE);
        curl_setopt($handle, CURLOPT_POSTFIELDS, $post);
        curl_setopt($handle, CURLOPT_HTTPHEADER, array('Content-Type:application/json', 'Accept:application/json', $authorization));
        /* set return type json */

        $output = curl_exec($handle);
        curl_close($handle);
    } else if ($_POST['function'] == 'passwordRecovery') {
        $post = file_get_contents('php://input');
        $array = json_decode($post);

        $handle = curl_init();

        $url = "http://190.4.56.14/" . $environment . "/api/auth/passwordRecovery";


        // Set the url
        curl_setopt($handle, CURLOPT_URL, $url);

        curl_setopt($handle, CURLOPT_POST, TRUE);
        curl_setopt($handle, CURLOPT_POSTFIELDS, $post);
        curl_setopt($handle, CURLOPT_HTTPHEADER, array('Content-Type:application/json', 'Accept:application/json'));
        /* set return type json */

        $output = curl_exec($handle);
        curl_close($handle);
    } else if ($_POST['function'] == 'getExtraChargeCategories') {
        $post = file_get_contents('php://input');
        $array = json_decode($post);

        $handle = curl_init();

        $url = "http://190.4.56.14/" . $environment . "/api/admins/extraCharges/getCategories";

        $authorization = 'Authorization: Bearer ' . $_POST['tkn'];

        // Set the url
        curl_setopt($handle, CURLOPT_URL, $url);

        curl_setopt($handle, CURLOPT_POST, TRUE);
        curl_setopt($handle, CURLOPT_POSTFIELDS, $post);
        curl_setopt($handle, CURLOPT_HTTPHEADER, array('Content-Type:application/json', 'Accept:application/json', $authorization));
        /* set return type json */

        $output = curl_exec($handle);
        curl_close($handle);
    } else if ($_POST['function'] == 'removeCategoryFromExtraCharge') {
        $post = file_get_contents('php://input');
        $array = json_decode($post);

        $handle = curl_init();

        $url = "http://190.4.56.14/" . $environment . "/api/admins/extraCharges/removeCategory";

        $authorization = 'Authorization: Bearer ' . $_POST['tkn'];

        // Set the url
        curl_setopt($handle, CURLOPT_URL, $url);

        curl_setopt($handle, CURLOPT_POST, TRUE);
        curl_setopt($handle, CURLOPT_POSTFIELDS, $post);
        curl_setopt($handle, CURLOPT_HTTPHEADER, array('Content-Type:application/json', 'Accept:application/json', $authorization));
        /* set return type json */

        $output = curl_exec($handle);
        curl_close($handle);
    } else if ($_POST['function'] == 'addCategoryToExtraCharge') {
        $post = file_get_contents('php://input');
        $array = json_decode($post);

        $handle = curl_init();

        $url = "http://190.4.56.14/" . $environment . "/api/admins/extraCharges/addCategory";

        $authorization = 'Authorization: Bearer ' . $_POST['tkn'];

        // Set the url
        curl_setopt($handle, CURLOPT_URL, $url);

        curl_setopt($handle, CURLOPT_POST, TRUE);
        curl_setopt($handle, CURLOPT_POSTFIELDS, $post);
        curl_setopt($handle, CURLOPT_HTTPHEADER, array('Content-Type:application/json', 'Accept:application/json', $authorization));
        /* set return type json */

        $output = curl_exec($handle);
        curl_close($handle);
    } else if ($_POST['function'] == 'getCoords') {
        $handle = curl_init();
        $post = file_get_contents('php://input');
        $array = json_decode($post);

        $url = "http://190.4.56.14/GoogleApi/geocode.php";

        // Set the url
        curl_setopt($handle, CURLOPT_URL, $url);
        curl_setopt($handle, CURLOPT_POST, TRUE);

        curl_setopt($handle, CURLOPT_POSTFIELDS, $array);

        //curl_setopt($handle, CURLOPT_HTTPHEADER, array('Content-Type:application/json', 'Accept:application/json'));
        /* set return type json */

        $output = curl_exec($handle);
        curl_close($handle);
    } else if ($_POST['function'] == 'getExtraChargeOptions') {
        $post = file_get_contents('php://input');
        $array = json_decode($post);

        $handle = curl_init();

        $url = "http://190.4.56.14/" . $environment . "/api/admins/extraCharges/getOptions";

        $authorization = 'Authorization: Bearer ' . $_POST['tkn'];

        // Set the url
        curl_setopt($handle, CURLOPT_URL, $url);

        curl_setopt($handle, CURLOPT_POST, TRUE);
        curl_setopt($handle, CURLOPT_POSTFIELDS, $post);
        curl_setopt($handle, CURLOPT_HTTPHEADER, array('Content-Type:application/json', 'Accept:application/json', $authorization));
        /* set return type json */

        $output = curl_exec($handle);
        curl_close($handle);
    } else if ($_POST['function'] == 'removeOptionFromExtraCharge') {
        $post = file_get_contents('php://input');
        $array = json_decode($post);

        $handle = curl_init();

        $url = "http://190.4.56.14/" . $environment . "/api/admins/extraCharges/removeOption";

        $authorization = 'Authorization: Bearer ' . $_POST['tkn'];

        // Set the url
        curl_setopt($handle, CURLOPT_URL, $url);

        curl_setopt($handle, CURLOPT_POST, TRUE);
        curl_setopt($handle, CURLOPT_POSTFIELDS, $post);
        curl_setopt($handle, CURLOPT_HTTPHEADER, array('Content-Type:application/json', 'Accept:application/json', $authorization));
        /* set return type json */

        $output = curl_exec($handle);
        curl_close($handle);
    } else if ($_POST['function'] == 'addOptionToExtraCharge') {
        $post = file_get_contents('php://input');
        $array = json_decode($post);

        $handle = curl_init();

        $url = "http://190.4.56.14/" . $environment . "/api/admins/extraCharges/addOption";

        $authorization = 'Authorization: Bearer ' . $_POST['tkn'];

        // Set the url
        curl_setopt($handle, CURLOPT_URL, $url);

        curl_setopt($handle, CURLOPT_POST, TRUE);
        curl_setopt($handle, CURLOPT_POSTFIELDS, $post);
        curl_setopt($handle, CURLOPT_HTTPHEADER, array('Content-Type:application/json', 'Accept:application/json', $authorization));
        /* set return type json */

        $output = curl_exec($handle);
        curl_close($handle);
    } else if ($_POST['function'] == 'getCustomerDashboardData') {
        $post = file_get_contents('php://input');
        $array = json_decode($post);

        $handle = curl_init();

        $url = "http://190.4.56.14/" . $environment . "/api/customers/myDashboard";

        $authorization = 'Authorization: Bearer ' . $_POST['tkn'];

        // Set the url
        curl_setopt($handle, CURLOPT_URL, $url);

        curl_setopt($handle, CURLOPT_POST, TRUE);
        curl_setopt($handle, CURLOPT_POSTFIELDS, $post);
        curl_setopt($handle, CURLOPT_HTTPHEADER, array('Content-Type:application/json', 'Accept:application/json', $authorization));
        /* set return type json */

        $output = curl_exec($handle);
        curl_close($handle);
    } else if ($_POST['function'] == 'getCustomerBalance') {
        $post = file_get_contents('php://input');
        $array = json_decode($post);

        $handle = curl_init();

        $url = "http://190.4.56.14/" . $environment . "/api/customers/balance";

        $authorization = 'Authorization: Bearer ' . $_POST['tkn'];

        // Set the url
        curl_setopt($handle, CURLOPT_URL, $url);

        curl_setopt($handle, CURLOPT_POST, TRUE);
        curl_setopt($handle, CURLOPT_POSTFIELDS, $post);
        curl_setopt($handle, CURLOPT_HTTPHEADER, array('Content-Type:application/json', 'Accept:application/json', $authorization));
        /* set return type json */

        $output = curl_exec($handle);
        curl_close($handle);
    } else if ($_POST['function'] == 'getRateTypes') {
        $post = file_get_contents('php://input');
        $array = json_decode($post);

        $handle = curl_init();

        $url = "http://190.4.56.14/" . $environment . "/api/admins/ratesType/get";

        $authorization = 'Authorization: Bearer ' . $_POST['tkn'];

        // Set the url
        curl_setopt($handle, CURLOPT_URL, $url);

        curl_setopt($handle, CURLOPT_POST, TRUE);
        curl_setopt($handle, CURLOPT_POSTFIELDS, $post);
        curl_setopt($handle, CURLOPT_HTTPHEADER, array('Content-Type:application/json', 'Accept:application/json', $authorization));
        /* set return type json */

        $output = curl_exec($handle);
        curl_close($handle);
    } else if ($_POST['function'] == 'updateConsolidatedRateDetail') {
        $post = file_get_contents('php://input');
        $array = json_decode($post);

        $handle = curl_init();

        $url = "http://190.4.56.14/" . $environment . "/api/admins/rates/updateDetail";

        $authorization = 'Authorization: Bearer ' . $_POST['tkn'];

        // Set the url
        curl_setopt($handle, CURLOPT_URL, $url);

        curl_setopt($handle, CURLOPT_POST, TRUE);
        curl_setopt($handle, CURLOPT_POSTFIELDS, $post);
        curl_setopt($handle, CURLOPT_HTTPHEADER, array('Content-Type:application/json', 'Accept:application/json', $authorization));
        /* set return type json */

        $output = curl_exec($handle);
        curl_close($handle);
    } else if ($_POST['function'] == 'getRateSchedules') {
        $post = file_get_contents('php://input');
        $array = json_decode($post);

        $handle = curl_init();

        $url = "http://190.4.56.14/" . $environment . "/api/admins/rates/getRateSchedules";

        $authorization = 'Authorization: Bearer ' . $_POST['tkn'];

        // Set the url
        curl_setopt($handle, CURLOPT_URL, $url);

        curl_setopt($handle, CURLOPT_POST, TRUE);
        curl_setopt($handle, CURLOPT_POSTFIELDS, $post);
        curl_setopt($handle, CURLOPT_HTTPHEADER, array('Content-Type:application/json', 'Accept:application/json', $authorization));
        /* set return type json */

        $output = curl_exec($handle);
        curl_close($handle);
    } else if ($_POST['function'] == 'removeScheduleFromRate') {
        $post = file_get_contents('php://input');
        $array = json_decode($post);

        $handle = curl_init();

        $url = "http://190.4.56.14/" . $environment . "/api/admins/rates/removeSchedule";

        $authorization = 'Authorization: Bearer ' . $_POST['tkn'];

        // Set the url
        curl_setopt($handle, CURLOPT_URL, $url);

        curl_setopt($handle, CURLOPT_POST, TRUE);
        curl_setopt($handle, CURLOPT_POSTFIELDS, $post);
        curl_setopt($handle, CURLOPT_HTTPHEADER, array('Content-Type:application/json', 'Accept:application/json', $authorization));
        /* set return type json */

        $output = curl_exec($handle);
        curl_close($handle);
    } else if ($_POST['function'] == 'assignOrder') {
        $post = file_get_contents('php://input');
        $array = json_decode($post);

        $handle = curl_init();

        $url = "http://190.4.56.14/" . $environment . "/api/admins/orders/assign";

        $authorization = 'Authorization: Bearer ' . $_POST['tkn'];

        // Set the url
        curl_setopt($handle, CURLOPT_URL, $url);

        curl_setopt($handle, CURLOPT_POST, TRUE);
        curl_setopt($handle, CURLOPT_POSTFIELDS, $post);
        curl_setopt($handle, CURLOPT_HTTPHEADER, array('Content-Type:application/json', 'Accept:application/json', $authorization));
        /* set return type json */

        $output = curl_exec($handle);
        curl_close($handle);
    } else if ($_POST['function'] == 'addExtraChargeToOrder') {
        $post = file_get_contents('php://input');
        $array = json_decode($post);

        $handle = curl_init();

        $url = "http://190.4.56.14/" . $environment . "/api/admins/orders/addExtracharge";

        $authorization = 'Authorization: Bearer ' . $_POST['tkn'];

        // Set the url
        curl_setopt($handle, CURLOPT_URL, $url);

        curl_setopt($handle, CURLOPT_POST, TRUE);
        curl_setopt($handle, CURLOPT_POSTFIELDS, $post);
        curl_setopt($handle, CURLOPT_HTTPHEADER, array('Content-Type:application/json', 'Accept:application/json', $authorization));
        /* set return type json */

        $output = curl_exec($handle);
        curl_close($handle);
    } else if ($_POST['function'] == 'removeExtraChargeFromOrder') {
        $post = file_get_contents('php://input');
        $array = json_decode($post);

        $handle = curl_init();

        $url = "http://190.4.56.14/" . $environment . "/api/admins/orders/removeExtracharge";

        $authorization = 'Authorization: Bearer ' . $_POST['tkn'];

        // Set the url
        curl_setopt($handle, CURLOPT_URL, $url);

        curl_setopt($handle, CURLOPT_POST, TRUE);
        curl_setopt($handle, CURLOPT_POSTFIELDS, $post);
        curl_setopt($handle, CURLOPT_HTTPHEADER, array('Content-Type:application/json', 'Accept:application/json', $authorization));
        /* set return type json */

        $output = curl_exec($handle);
        curl_close($handle);
    } else if ($_POST['function'] == 'getFilteredOrders') {
        $post = file_get_contents('php://input');
        $array = json_decode($post);

        $handle = curl_init();

        $url = "http://190.4.56.14/" . $environment . "/api/admins/orders/filter";

        $authorization = 'Authorization: Bearer ' . $_POST['tkn'];

        // Set the url
        curl_setopt($handle, CURLOPT_URL, $url);

        curl_setopt($handle, CURLOPT_POST, TRUE);
        curl_setopt($handle, CURLOPT_POSTFIELDS, $post);
        curl_setopt($handle, CURLOPT_HTTPHEADER, array('Content-Type:application/json', 'Accept:application/json', $authorization));
        /* set return type json */

        $output = curl_exec($handle);
        curl_close($handle);
    } else if ($_POST['function'] == 'deliveriesReport') {
        $post = file_get_contents('php://input');
        $array = json_decode($post);

        $handle = curl_init();

        $url = "http://190.4.56.14/" . $environment . "/api/admins/reports/deliveriesReport";

        $authorization = 'Authorization: Bearer ' . $_POST['tkn'];

        // Set the url
        curl_setopt($handle, CURLOPT_URL, $url);

        curl_setopt($handle, CURLOPT_POST, TRUE);
        curl_setopt($handle, CURLOPT_POSTFIELDS, $post);
        curl_setopt($handle, CURLOPT_HTTPHEADER, array('Content-Type:application/json', 'Accept:application/json', $authorization));
        /* set return type json */

        $output = curl_exec($handle);
        curl_close($handle);
    } else if ($_POST['function'] == 'paymentsReport') {
        $post = file_get_contents('php://input');
        $array = json_decode($post);

        $handle = curl_init();

        $url = "http://190.4.56.14/" . $environment . "/api/admins/reports/paymentsReport";

        $authorization = 'Authorization: Bearer ' . $_POST['tkn'];

        // Set the url
        curl_setopt($handle, CURLOPT_URL, $url);

        curl_setopt($handle, CURLOPT_POST, TRUE);
        curl_setopt($handle, CURLOPT_POSTFIELDS, $post);
        curl_setopt($handle, CURLOPT_HTTPHEADER, array('Content-Type:application/json', 'Accept:application/json', $authorization));
        /* set return type json */

        $output = curl_exec($handle);
        curl_close($handle);
    } else if ($_POST['function'] == 'customersBalanceReport') {
        $post = file_get_contents('php://input');
        $array = json_decode($post);

        $handle = curl_init();

        $url = "http://190.4.56.14/" . $environment . "/api/admins/reports/customersBalanceReport";

        $authorization = 'Authorization: Bearer ' . $_POST['tkn'];

        // Set the url
        curl_setopt($handle, CURLOPT_URL, $url);

        curl_setopt($handle, CURLOPT_POST, TRUE);
        curl_setopt($handle, CURLOPT_POSTFIELDS, $post);
        curl_setopt($handle, CURLOPT_HTTPHEADER, array('Content-Type:application/json', 'Accept:application/json', $authorization));
        /* set return type json */

        $output = curl_exec($handle);
        curl_close($handle);
    } else if ($_POST['function'] == 'customersTrackingReport') {
        $post = file_get_contents('php://input');
        $array = json_decode($post);

        $handle = curl_init();

        $url = "http://190.4.56.14/" . $environment . "/api/admins/reports/customersTrackingReport";

        $authorization = 'Authorization: Bearer ' . $_POST['tkn'];

        // Set the url
        curl_setopt($handle, CURLOPT_URL, $url);

        curl_setopt($handle, CURLOPT_POST, TRUE);
        curl_setopt($handle, CURLOPT_POSTFIELDS, $post);
        curl_setopt($handle, CURLOPT_HTTPHEADER, array('Content-Type:application/json', 'Accept:application/json', $authorization));
        /* set return type json */

        $output = curl_exec($handle);
        curl_close($handle);
    } else if ($_POST['function'] == 'createWorkLine') {
        $post = file_get_contents('php://input');
        $array = json_decode($post);

        $handle = curl_init();

        $url = "http://190.4.56.14/" . $environment . "/api/admins/worklines/create";

        $authorization = 'Authorization: Bearer ' . $_POST['tkn'];

        // Set the url
        curl_setopt($handle, CURLOPT_URL, $url);

        curl_setopt($handle, CURLOPT_POST, TRUE);
        curl_setopt($handle, CURLOPT_POSTFIELDS, $post);
        curl_setopt($handle, CURLOPT_HTTPHEADER, array('Content-Type:application/json', 'Accept:application/json', $authorization));
        /* set return type json */

        $output = curl_exec($handle);
        curl_close($handle);
    } else if ($_POST['function'] == 'updateWorkLine') {
        $post = file_get_contents('php://input');
        $array = json_decode($post);

        $handle = curl_init();

        $url = "http://190.4.56.14/" . $environment . "/api/admins/worklines/update";

        $authorization = 'Authorization: Bearer ' . $_POST['tkn'];

        // Set the url
        curl_setopt($handle, CURLOPT_URL, $url);

        curl_setopt($handle, CURLOPT_POST, TRUE);
        curl_setopt($handle, CURLOPT_POSTFIELDS, $post);
        curl_setopt($handle, CURLOPT_HTTPHEADER, array('Content-Type:application/json', 'Accept:application/json', $authorization));
        /* set return type json */

        $output = curl_exec($handle);
        curl_close($handle);
    } else if ($_POST['function'] == 'createWorkLine') {
        $post = file_get_contents('php://input');
        $array = json_decode($post);

        $handle = curl_init();

        $url = "http://190.4.56.14/" . $environment . "/api/admins/workLines/create";

        $authorization = 'Authorization: Bearer ' . $_POST['tkn'];

        // Set the url
        curl_setopt($handle, CURLOPT_URL, $url);

        curl_setopt($handle, CURLOPT_POST, TRUE);
        curl_setopt($handle, CURLOPT_POSTFIELDS, $post);
        curl_setopt($handle, CURLOPT_HTTPHEADER, array('Content-Type:application/json', 'Accept:application/json', $authorization));
        /* set return type json */

        $output = curl_exec($handle);
        curl_close($handle);
    } else if ($_POST['function'] == 'editWorkLine') {
        $post = file_get_contents('php://input');
        $array = json_decode($post);

        $handle = curl_init();

        $url = "http://190.4.56.14/" . $environment . "/api/admins/workLines/update";

        $authorization = 'Authorization: Bearer ' . $_POST['tkn'];

        // Set the url
        curl_setopt($handle, CURLOPT_URL, $url);

        curl_setopt($handle, CURLOPT_POST, TRUE);
        curl_setopt($handle, CURLOPT_POSTFIELDS, $post);
        curl_setopt($handle, CURLOPT_HTTPHEADER, array('Content-Type:application/json', 'Accept:application/json', $authorization));
        /* set return type json */

        $output = curl_exec($handle);
        curl_close($handle);
    } else if ($_POST['function'] == 'customerWorkLines') {
        $post = file_get_contents('php://input');
        $array = json_decode($post);

        $handle = curl_init();

        $url = "http://190.4.56.14/" . $environment . "/api/admins/customers/workLines";

        $authorization = 'Authorization: Bearer ' . $_POST['tkn'];

        // Set the url
        curl_setopt($handle, CURLOPT_URL, $url);

        curl_setopt($handle, CURLOPT_POST, TRUE);
        curl_setopt($handle, CURLOPT_POSTFIELDS, $post);
        curl_setopt($handle, CURLOPT_HTTPHEADER, array('Content-Type:application/json', 'Accept:application/json', $authorization));
        /* set return type json */

        $output = curl_exec($handle);
        curl_close($handle);
    } else if ($_POST['function'] == 'getWorkLines') {
        $post = file_get_contents('php://input');
        $array = json_decode($post);

        $handle = curl_init();

        $url = "http://190.4.56.14/" . $environment . "/api/admins/workLines/get";

        $authorization = 'Authorization: Bearer ' . $_POST['tkn'];

        // Set the url
        curl_setopt($handle, CURLOPT_URL, $url);

        curl_setopt($handle, CURLOPT_POST, TRUE);
        curl_setopt($handle, CURLOPT_POSTFIELDS, $post);
        curl_setopt($handle, CURLOPT_HTTPHEADER, array('Content-Type:application/json', 'Accept:application/json', $authorization));
        /* set return type json */

        $output = curl_exec($handle);
        curl_close($handle);
    } else if ($_POST['function'] == 'getAllWorkLines') {
        $post = file_get_contents('php://input');
        $array = json_decode($post);

        $handle = curl_init();

        $url = "http://190.4.56.14/" . $environment . "/api/admins/workLines/getAll";

        $authorization = 'Authorization: Bearer ' . $_POST['tkn'];

        // Set the url
        curl_setopt($handle, CURLOPT_URL, $url);

        curl_setopt($handle, CURLOPT_POST, TRUE);
        curl_setopt($handle, CURLOPT_POSTFIELDS, $post);
        curl_setopt($handle, CURLOPT_HTTPHEADER, array('Content-Type:application/json', 'Accept:application/json', $authorization));
        /* set return type json */

        $output = curl_exec($handle);
        curl_close($handle);
    } else if ($_POST['function'] == 'addCustomerToWorkLine') {
        $post = file_get_contents('php://input');
        $array = json_decode($post);

        $handle = curl_init();

        $url = "http://190.4.56.14/" . $environment . "/api/admins/workLines/addCustomer";

        $authorization = 'Authorization: Bearer ' . $_POST['tkn'];

        // Set the url
        curl_setopt($handle, CURLOPT_URL, $url);

        curl_setopt($handle, CURLOPT_POST, TRUE);
        curl_setopt($handle, CURLOPT_POSTFIELDS, $post);
        curl_setopt($handle, CURLOPT_HTTPHEADER, array('Content-Type:application/json', 'Accept:application/json', $authorization));
        /* set return type json */

        $output = curl_exec($handle);
        curl_close($handle);
    } else if ($_POST['function'] == 'removeCustomerFromWorkLine') {
        $post = file_get_contents('php://input');
        $array = json_decode($post);

        $handle = curl_init();

        $url = "http://190.4.56.14/" . $environment . "/api/admins/workLines/removeCustomer";

        $authorization = 'Authorization: Bearer ' . $_POST['tkn'];

        // Set the url
        curl_setopt($handle, CURLOPT_URL, $url);

        curl_setopt($handle, CURLOPT_POST, TRUE);
        curl_setopt($handle, CURLOPT_POSTFIELDS, $post);
        curl_setopt($handle, CURLOPT_HTTPHEADER, array('Content-Type:application/json', 'Accept:application/json', $authorization));
        /* set return type json */

        $output = curl_exec($handle);
        curl_close($handle);
    } else if ($_POST['function'] == 'getSurchargeCustomers') {
        $post = file_get_contents('php://input');
        $array = json_decode($post);

        $handle = curl_init();

        $url = "http://190.4.56.14/" . $environment . "/api/admins/surcharges/getCustomers";

        $authorization = 'Authorization: Bearer ' . $_POST['tkn'];

        // Set the url
        curl_setopt($handle, CURLOPT_URL, $url);

        curl_setopt($handle, CURLOPT_POST, TRUE);
        curl_setopt($handle, CURLOPT_POSTFIELDS, $post);
        curl_setopt($handle, CURLOPT_HTTPHEADER, array('Content-Type:application/json', 'Accept:application/json', $authorization));
        /* set return type json */

        $output = curl_exec($handle);
        curl_close($handle);
    } else if ($_POST['function'] == 'removeCustomerFromSurcharge') {
        $post = file_get_contents('php://input');
        $array = json_decode($post);

        $handle = curl_init();

        $url = "http://190.4.56.14/" . $environment . "/api/admins/surcharges/removeCustomer";

        $authorization = 'Authorization: Bearer ' . $_POST['tkn'];

        // Set the url
        curl_setopt($handle, CURLOPT_URL, $url);

        curl_setopt($handle, CURLOPT_POST, TRUE);
        curl_setopt($handle, CURLOPT_POSTFIELDS, $post);
        curl_setopt($handle, CURLOPT_HTTPHEADER, array('Content-Type:application/json', 'Accept:application/json', $authorization));
        /* set return type json */

        $output = curl_exec($handle);
        curl_close($handle);
    } else if ($_POST['function'] == 'addCustomerToSurcharge') {
        $post = file_get_contents('php://input');
        $array = json_decode($post);

        $handle = curl_init();

        $url = "http://190.4.56.14/" . $environment . "/api/admins/surcharges/addCustomer";

        $authorization = 'Authorization: Bearer ' . $_POST['tkn'];

        // Set the url
        curl_setopt($handle, CURLOPT_URL, $url);

        curl_setopt($handle, CURLOPT_POST, TRUE);
        curl_setopt($handle, CURLOPT_POSTFIELDS, $post);
        curl_setopt($handle, CURLOPT_HTTPHEADER, array('Content-Type:application/json', 'Accept:application/json', $authorization));
        /* set return type json */

        $output = curl_exec($handle);
        curl_close($handle);
    } else if ($_POST['function'] == 'assignOrderAuxiliar') {
        $post = file_get_contents('php://input');
        $array = json_decode($post);

        $handle = curl_init();

        $url = "http://190.4.56.14/" . $environment . "/api/admins/orders/assignAuxiliar";

        $authorization = 'Authorization: Bearer ' . $_POST['tkn'];

        // Set the url
        curl_setopt($handle, CURLOPT_URL, $url);

        curl_setopt($handle, CURLOPT_POST, TRUE);
        curl_setopt($handle, CURLOPT_POSTFIELDS, $post);
        curl_setopt($handle, CURLOPT_HTTPHEADER, array('Content-Type:application/json', 'Accept:application/json', $authorization));
        /* set return type json */

        $output = curl_exec($handle);
        curl_close($handle);
    }else if ($_POST['function'] == 'getReportRequests') {
        $post = file_get_contents('php://input');
        $array = json_decode($post);

        $handle = curl_init();

        $url = "http://190.4.56.14/" . $environment . "/api/admins/reports/getReportRequests";

        $authorization = 'Authorization: Bearer ' . $_POST['tkn'];

        // Set the url
        curl_setopt($handle, CURLOPT_URL, $url);

        curl_setopt($handle, CURLOPT_POST, TRUE);
        curl_setopt($handle, CURLOPT_POSTFIELDS, $post);
        curl_setopt($handle, CURLOPT_HTTPHEADER, array('Content-Type:application/json', 'Accept:application/json', $authorization));
        /* set return type json */

        $output = curl_exec($handle);
        curl_close($handle);
    }else if ($_POST['function'] == 'createReportRequest') {
        $post = file_get_contents('php://input');
        $array = json_decode($post);

        $handle = curl_init();

        $url = "http://190.4.56.14/" . $environment . "/api/admins/reports/createReportRequest";

        $authorization = 'Authorization: Bearer ' . $_POST['tkn'];

        // Set the url
        curl_setopt($handle, CURLOPT_URL, $url);

        curl_setopt($handle, CURLOPT_POST, TRUE);
        curl_setopt($handle, CURLOPT_POSTFIELDS, $post);
        curl_setopt($handle, CURLOPT_HTTPHEADER, array('Content-Type:application/json', 'Accept:application/json', $authorization));
        /* set return type json */

        $output = curl_exec($handle);
        curl_close($handle);
    } else if ($_POST['function'] == 'editExtraChargeOption') {
        $post = file_get_contents('php://input');
        $array = json_decode($post);

        $handle = curl_init();

        $url = "http://190.4.56.14/" . $environment . "/api/admins/extraCharges/editOption";

        $authorization = 'Authorization: Bearer ' . $_POST['tkn'];

        // Set the url
        curl_setopt($handle, CURLOPT_URL, $url);

        curl_setopt($handle, CURLOPT_POST, TRUE);
        curl_setopt($handle, CURLOPT_POSTFIELDS, $post);
        curl_setopt($handle, CURLOPT_HTTPHEADER, array('Content-Type:application/json', 'Accept:application/json', $authorization));
        /* set return type json */

        $output = curl_exec($handle);
        curl_close($handle);
    }else if ($_POST['function'] == 'checkAvalability') {
        $post = file_get_contents('php://input');
        $array = json_decode($post);

        $handle = curl_init();

        $url = "http://190.4.56.14/" . $environment . "/api/customers/check";

        $authorization = 'Authorization: Bearer ' . $_POST['tkn'];

        // Set the url
        curl_setopt($handle, CURLOPT_URL, $url);

        curl_setopt($handle, CURLOPT_POST, TRUE);
        curl_setopt($handle, CURLOPT_POSTFIELDS, $post);
        curl_setopt($handle, CURLOPT_HTTPHEADER, array('Content-Type:application/json', 'Accept:application/json', $authorization));
        /* set return type json */

        $output = curl_exec($handle);
        curl_close($handle);
    }else if ($_POST['function'] == 'checkCustomerDelTypes') {
        $post = file_get_contents('php://input');
        $array = json_decode($post);

        $handle = curl_init();

        $url = "http://190.4.56.14/" . $environment . "/api/customers/checkDelTypes";

        $authorization = 'Authorization: Bearer ' . $_POST['tkn'];

        // Set the url
        curl_setopt($handle, CURLOPT_URL, $url);

        curl_setopt($handle, CURLOPT_POST, TRUE);
        curl_setopt($handle, CURLOPT_POSTFIELDS, $post);
        curl_setopt($handle, CURLOPT_HTTPHEADER, array('Content-Type:application/json', 'Accept:application/json', $authorization));
        /* set return type json */

        $output = curl_exec($handle);
        curl_close($handle);
    }else if ($_POST['function'] == 'getCategoryExtraCharges') {
        $post = file_get_contents('php://input');
        $array = json_decode($post);

        $handle = curl_init();

        $url = "http://190.4.56.14/" . $environment . "/api/admins/extraCharges/getCategoryExtracharges";

        $authorization = 'Authorization: Bearer ' . $_POST['tkn'];

        // Set the url
        curl_setopt($handle, CURLOPT_URL, $url);

        curl_setopt($handle, CURLOPT_POST, TRUE);
        curl_setopt($handle, CURLOPT_POSTFIELDS, $post);
        curl_setopt($handle, CURLOPT_HTTPHEADER, array('Content-Type:application/json', 'Accept:application/json', $authorization));
        /* set return type json */

        $output = curl_exec($handle);
        curl_close($handle);
    }else if ($_POST['function'] == 'cancelDelivery') {
        $post = file_get_contents('php://input');
        $array = json_decode($post);

        $handle = curl_init();

        $url = "http://190.4.56.14/" . $environment . "/api/customers/deliveries/cancel";

        $authorization = 'Authorization: Bearer ' . $_POST['tkn'];

        // Set the url
        curl_setopt($handle, CURLOPT_URL, $url);

        curl_setopt($handle, CURLOPT_POST, TRUE);
        curl_setopt($handle, CURLOPT_POSTFIELDS, $post);
        curl_setopt($handle, CURLOPT_HTTPHEADER, array('Content-Type:application/json', 'Accept:application/json', $authorization));
        /* set return type json */

        $output = curl_exec($handle);
        curl_close($handle);
    }else if ($_POST['function'] == 'getDriverCategories') {
        $post = file_get_contents('php://input');
        $array = json_decode($post);

        $handle = curl_init();

        $url = "http://190.4.56.14/" . $environment . "/api/admins/drivers/getCategories";

        $authorization = 'Authorization: Bearer ' . $_POST['tkn'];

        // Set the url
        curl_setopt($handle, CURLOPT_URL, $url);

        curl_setopt($handle, CURLOPT_POST, TRUE);
        curl_setopt($handle, CURLOPT_POSTFIELDS, $post);
        curl_setopt($handle, CURLOPT_HTTPHEADER, array('Content-Type:application/json', 'Accept:application/json', $authorization));
        /* set return type json */

        $output = curl_exec($handle);
        curl_close($handle);
    }else if ($_POST['function'] == 'assignDriverCategory') {
        $post = file_get_contents('php://input');
        $array = json_decode($post);

        $handle = curl_init();

        $url = "http://190.4.56.14/" . $environment . "/api/admins/drivers/assignCategory";

        $authorization = 'Authorization: Bearer ' . $_POST['tkn'];

        // Set the url
        curl_setopt($handle, CURLOPT_URL, $url);

        curl_setopt($handle, CURLOPT_POST, TRUE);
        curl_setopt($handle, CURLOPT_POSTFIELDS, $post);
        curl_setopt($handle, CURLOPT_HTTPHEADER, array('Content-Type:application/json', 'Accept:application/json', $authorization));
        /* set return type json */

        $output = curl_exec($handle);
        curl_close($handle);
    }else if ($_POST['function'] == 'removeDriverCategory') {
        $post = file_get_contents('php://input');
        $array = json_decode($post);

        $handle = curl_init();

        $url = "http://190.4.56.14/" . $environment . "/api/admins/drivers/removeCategory";

        $authorization = 'Authorization: Bearer ' . $_POST['tkn'];

        // Set the url
        curl_setopt($handle, CURLOPT_URL, $url);

        curl_setopt($handle, CURLOPT_POST, TRUE);
        curl_setopt($handle, CURLOPT_POSTFIELDS, $post);
        curl_setopt($handle, CURLOPT_HTTPHEADER, array('Content-Type:application/json', 'Accept:application/json', $authorization));
        /* set return type json */

        $output = curl_exec($handle);
        curl_close($handle);
    }else if ($_POST['function'] == 'getMyLabels') {
        $post = file_get_contents('php://input');
        $array = json_decode($post);

        $handle = curl_init();

        $url = "http://190.4.56.14/" . $environment . "/api/customers/labels/get";

        $authorization = 'Authorization: Bearer ' . $_POST['tkn'];

        // Set the url
        curl_setopt($handle, CURLOPT_URL, $url);

        curl_setopt($handle, CURLOPT_POST, TRUE);
        curl_setopt($handle, CURLOPT_POSTFIELDS, $post);
        curl_setopt($handle, CURLOPT_HTTPHEADER, array('Content-Type:application/json', 'Accept:application/json', $authorization));
        /* set return type json */

        $output = curl_exec($handle);
        curl_close($handle);
    }else if ($_POST['function'] == 'createLabel') {
        $post = file_get_contents('php://input');
        $array = json_decode($post);

        $handle = curl_init();

        $url = "http://190.4.56.14/" . $environment . "/api/customers/labels/create";

        $authorization = 'Authorization: Bearer ' . $_POST['tkn'];

        // Set the url
        curl_setopt($handle, CURLOPT_URL, $url);

        curl_setopt($handle, CURLOPT_POST, TRUE);
        curl_setopt($handle, CURLOPT_POSTFIELDS, $post);
        curl_setopt($handle, CURLOPT_HTTPHEADER, array('Content-Type:application/json', 'Accept:application/json', $authorization));
        /* set return type json */

        $output = curl_exec($handle);
        curl_close($handle);
    }else if ($_POST['function'] == 'updateLabel') {
        $post = file_get_contents('php://input');
        $array = json_decode($post);

        $handle = curl_init();

        $url = "http://190.4.56.14/" . $environment . "/api/customers/labels/update";

        $authorization = 'Authorization: Bearer ' . $_POST['tkn'];

        // Set the url
        curl_setopt($handle, CURLOPT_URL, $url);

        curl_setopt($handle, CURLOPT_POST, TRUE);
        curl_setopt($handle, CURLOPT_POSTFIELDS, $post);
        curl_setopt($handle, CURLOPT_HTTPHEADER, array('Content-Type:application/json', 'Accept:application/json', $authorization));
        /* set return type json */

        $output = curl_exec($handle);
        curl_close($handle);
    }else if ($_POST['function'] == 'deleteLabel') {
        $post = file_get_contents('php://input');
        $array = json_decode($post);

        $handle = curl_init();

        $url = "http://190.4.56.14/" . $environment . "/api/customers/labels/delete";

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
