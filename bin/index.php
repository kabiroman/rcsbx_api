<?
/**
 * This file is part of the ERDC/API module package.
 *
 * (c) Ruslan Kabirov <kabirovruslan@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

define("NO_KEEP_STATISTIC", true);
define("NO_AGENT_STATISTIC", true);
define("NOT_CHECK_PERMISSIONS", true);

require_once($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");

@set_time_limit(0);
@ignore_user_abort(true);

try {
    // ToDo include your API module here

    $request = Bitrix\Main\Application::getInstance()->getContext()->getRequest();

    $arRequestUri = explode('?',$request->getRequestUri());
    $arRequestUri = explode('/',$arRequestUri[0]);

    if (!isset($arRequestUri[2]))
        throw new \Rcsbx\Api\Exception\NotFoundException();

    $arr_substr_class = explode('_', $arRequestUri[2]);

    foreach ($arr_substr_class as $substr){
        $substr_class .= ucfirst($substr);
    }
    $class_name = 'Rcsbx\\Api\\Controller\\'.$substr_class.'Controller';

    if (!isset($arRequestUri[3]) || !class_exists($class_name)) {
        throw new \Rcsbx\Api\Exception\NotFoundException();
    }
    $controller = new $class_name($request);
    $method_name = ($arRequestUri[3]=="") ? 'indexAction' : $arRequestUri[3] . 'Action';

    if( ! method_exists ($controller, $method_name)) {
        throw new \Rcsbx\Api\Exception\NotFoundException();
    }
    /** @var \Rcsbx\Api\Controller\Response $response */
    $response = $controller->$method_name();

    if( ! is_a( $response, \Rcsbx\Api\Controller\Response::class)){
        throw new \Rcsbx\Api\Exception\InternalServerException("Invalid response type (expected \Rcsbx\Api\Controller\Response)!");
    }
    CHTTP::SetStatus($response->getCode());

    header("Content-type: " . $response->getContentType());

    if ( preg_match("/(application\/json)/i", $response->getContentType())) {
        echo Bitrix\Main\Web\Json::encode([
            'code' => $response->getCode(),
            'message' => $response->getMessage(),
            'data' => $response->getData(),
        ]);
    } else {
        echo $response->getView()->getContent();
    }
}
catch (Exception $e) {
    CHTTP::SetStatus($e->getCode());
    @define("ERROR_".$e->getCode(),"Y");

    echo json_encode([
        'code' => $e->getCode(),
        'message' => $e->getMessage(),
    ]);
    if($e->getCode() == 500) {
        // ToDo your logger || notice

    }
}
catch (Error $e) {
    CHTTP::SetStatus("500");
    @define("ERROR_500","Y");

    echo json_encode([
        'code' => 500,
        'message' => $e->getMessage(),
    ]);
}
die();

