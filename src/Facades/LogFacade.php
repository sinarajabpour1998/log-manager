<?php
namespace Sinarajabpour1998\LogManager\Facades;

use Modules\Shop\Facades\BaseFacade;

/**
 * @class \Sinarajabpour1998\LogManager\Facades\LogFacade
 *
 * @method static array getAllLogs()
 * @method static array getLogsWithFilter($request)
 * @method static array getUsers($request)
 * @method static array generateLog($type, $description = null)
 * @method static array generateErrorLog($exception)
 *
 * @see \Sinarajabpour1998\LogManager\Repositories\LogRepository
 */

class LogFacade extends BaseFacade
{

}
