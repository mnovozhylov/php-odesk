<?php
/**
 * oDesk auth library for using with public API by OAuth
 * Time Reporting
 *
 * @final
 * @package     oDeskAPI
 * @since       05/02/2014
 * @copyright   Copyright 2014(c) oDesk.com
 * @author      Maksym Novozhylov <mnovozhilov@odesk.com>
 * @license     oDesk's API Terms of Use {@link https://developers.odesk.com/api-tos.html}
 */

namespace oDesk\API\Routers\Reports;

use oDesk\API\Debug as ApiDebug;
use oDesk\API\Client as ApiClient;

/**
 * Financial Reporting
 *
 * @link http://developers.odesk.com/Time-Reports-API
 */
final class Time extends ApiClient
{
    const ENTRY_POINT = ODESK_GDS_EP_NAME;

    /**
     * @var Client instance
     */
    private $_client;

    /**
     * Constructor
     *
     * @param   ApiClient $client Client object
     */
    public function __construct(ApiClient $client)
    {
        ApiDebug::p('init ' . __CLASS__ . ' router');
        $this->_client = $client;
        parent::$_epoint = self::ENTRY_POINT;
    }

    /**
     * Generate Time Reports for a Specific Team/Comapny/Agency
     *
     * @param   string $company Company ID
     * @param   string $team (Optional) Team ID
     * @param   string $agency (Optional) Agency ID
     * @param   array $params (Optional) Parameters
     * @param   boolean $hideFinDetails (Optional) Hides all financial details
     * @return  object
     */
    private function _getByType($company, $team = null, $agency = null, $params = array(), $hideFinDetails = false)
    {
        ApiDebug::p(__FUNCTION__);

        $_url = '';
        if ($team) {
            $_url = '/teams/' . $team;
            if ($hideFinDetails) {
                $_url .= '/hours';
            }
        } elseif ($agency) {
            $_url = '/agencies/' . $agency;
        }

        $report = $this->_client->get('/timereports/v1/companies/' . $company . $_url, $params);
        ApiDebug::p('found report info', $report);

        return $report;
    }

    /**
     * Generate Time Reports for a Specific Team (with financial info)
     *
     * @param   string $company Company ID
     * @param   string $team Team ID
     * @param   array $params Parameters
     * @return  object
     */
    public function getByTeamFull($company, $team, $params)
    {
        ApiDebug::p(__FUNCTION__);

        return $this->_getByType($company, $team, null, $params, false);
    }

    /**
     * Generate Time Reports for a Specific Team (hide financial info)
     *
     * @param   string $company Company ID
     * @param   string $team Team ID
     * @param   array $params Parameters
     * @return  object
     */
    public function getByTeamLimited($company, $team, $params)
    {
        ApiDebug::p(__FUNCTION__);

        return $this->_getByType($company, $team, null, $params, true);
    }

    /**
     * Generating Agency Specific Reports
     *
     * @param   string $company Company ID
     * @param   string $agency Agency ID
     * @param   array $params Parameters
     * @return  object
     */
    public function getByAgency($company, $agency, $params)
    {
        ApiDebug::p(__FUNCTION__);

        return $this->_getByType($company, null, $agency, $params);
    }

    /**
     * Generating Company Wide Reports
     *
     * @param   string $company Company ID
     * @param   array $params Parameters
     * @return  object
     */
    public function getByCompany($company, $params)
    {
        ApiDebug::p(__FUNCTION__);

        return $this->_getByType($company, null, null, $params);
    }

    /**
     * Generating Freelancer Specific Reports (hide financial info)
     *
     * @param   string $freelancerId Freelancer ID
     * @param   array $params Parameters
     * @return  object
     */
    public function getByFreelancerLimited($freelancerId, $params)
    {
        ApiDebug::p(__FUNCTION__);

        $report = $this->_client->get('/timereports/v1/providers/' . $freelancerId . '/hours', $params);
        ApiDebug::p('found report info', $report);

        return $report;
    }

    /**
     * Generating Freelancer Specific Reports (with financial info)
     *
     * @param   string $freelancerId Freelancer ID
     * @param   array $params Parameters
     * @return  object
     */
    public function getByFreelancerFull($freelancerId, $params)
    {
        ApiDebug::p(__FUNCTION__);

        $report = $this->_client->get('/timereports/v1/providers/' . $freelancerId, $params);
        ApiDebug::p('found report info', $report);

        return $report;
    }
}
