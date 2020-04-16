<?php
/**
 * @author Leizhishang <info@Leizhishang.com>
 * @copyright ©2016-2100 Leizhishang.com
 * @license http://www.Leizhishang.com
 */
namespace Leizhishang\Lzscms\Helpers\Api;

use Symfony\Component\HttpFoundation\Response as FoundationResponse;
use Response;

trait ApiResponse
{
    /**
     * @var int
     */
    protected $stateCode = FoundationResponse::HTTP_OK;
    protected $header = [
        'Author-name'=>'leizhishang',
        'Author-url'=>'www.leizhishang.com'
    ];

    /**
     * @param $setHeader
     * @return $this
     */
    public function setHeader(array $header)
    {
        $this->header = array_merge($header, $this->header);
        return $this;
    }

    /**
     * @param $stateCode
     * @return $this
     */
    public function setStateCode($stateCode)
    {
        $this->stateCode = $stateCode;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getStateCode()
    {
        return $this->stateCode;
    }

    /**
     * @param $data
     * @param array $header
     * @return mixed
     */
    public function respond($data, $header = [])
    {
        if(!$header) {
            $header = $this->header;
        }
        return Response::json($data, $this->getStateCode(), $header);
    }

    /**
     * @param $state
     * @param array $data
     * @param null $code
     * @return mixed
     */
    public function state($code, array $data, $state = 200)
    {
        if ($state) {
            $this->setStateCode($state);
        }
        $code = [
            'code' => $code,
            'state' => $this->stateCode
        ];
        $data = array_merge($code, $data);
        return $this->respond($data);
    }

    /**
     * @param $message
     * @param int $code
     * @param string $state
     * @return mixed
     */
    public function failed($message, $state = FoundationResponse::HTTP_BAD_REQUEST, $code = '-99'){
        return $this->setStateCode($state)->message($message, $code);
    }

    /**
     * @param string $message
     * @return mixed
     */
    public function internalError($message = "Internal Error!")
    {
        return $this->failed($message, FoundationResponse::HTTP_INTERNAL_SERVER_ERROR);
    }

    /**
     * @param string $message
     * @return mixed
     */
    public function created($message = "created")
    {
        return $this->setStateCode(FoundationResponse::HTTP_CREATED)
            ->message($message, '-99');
    }

    /**
     * @param string $message
     * @return mixed
     */
    public function accepted($message = "accepted")
    {
        return $this->setStateCode(FoundationResponse::HTTP_ACCEPTED)
            ->message($message, '-99');
    }

    /**
     * @param string $message
     * @return mixed
     */
    public function notFond($message = 'Not Fond!')
    {
        return $this->failed($message, Foundationresponse::HTTP_NOT_FOUND);
    }

    /**
     * @param $message
     * @param string $code
     * @return mixed
     */
    public function message($message, $code = 0, $data = [], $state = null)
    {
        if(is_array($code)) {
            $data = $code;
            $code = 0;
        }
        return $this->state($code, [
            'message' => $message,
            'res'=>$data
        ], $state);
    }

    /**
     * @param $data
     * @param string $state
     * @return mixed
     */
    public function toSuccess($msg = '', array $data)
    {
        return $this->state(0, [
            'message' => $message,
            'res'=>$data
        ], 200);
    }

    public function toList($list) 
    {
        $newList = $list->toArray();
        unset($newList['first_page_url'], $newList['last_page_url'],$newList['next_page_url'],$newList['path'],$newList['prev_page_url'], $newList['from'], $newList['to'], $newList['last_page']);
        $newList['total_page'] = ceil($newList['total']/$newList['per_page']);
        return $this->message('success', 0, $newList);
    }
}