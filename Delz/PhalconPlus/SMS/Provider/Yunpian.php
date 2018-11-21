<?php

declare(strict_types=1);

namespace Delz\PhalconPlus\SMS\Provider;

use Delz\PhalconPlus\SMS\Contract\IMessage;
use GuzzleHttp\Exception\ConnectException;
use Delz\PhalconPlus\SMS\Exception\InvalidOptionsException;
use Delz\PhalconPlus\SMS\Provider;
use Delz\PhalconPlus\Util\Http;
use Delz\PhalconPlus\SMS\Result;
use Delz\PhalconPlus\SMS\Report;

/**
 * 云片网短信供应商
 *
 * @package Delz\PhalconPlus\SMS\Provider
 */
class Yunpian extends Provider
{
    /**
     * 单条发送网关地址
     */
    const SINGLE_SEND_API_URL = 'https://sms.yunpian.com/v2/sms/single_send.json';
    /**
     * 获取状态报告
     *
     * 开通此接口功能后，我们将为您独立再保存一份新生产的状态报告数据，保存时间为72小时。
     * 您可以通过此接口获取新产生的状态报告。注意，已成功获取的数据将会删除，请妥善处理接口返回的数据。
     * 该接口为高级接口，默认不开放，可以在云片用户后台开启
     */
    const PULL_STATUS_API_URL = 'https://sms.yunpian.com/v2/sms/pull_status.json';

    /**
     * {@inheritdoc}
     */
    public function __construct(array $options)
    {
        parent::__construct($options);
        if (!isset($options['apiKey'])) {
            throw new InvalidOptionsException();
        }
    }

    /**
     * {@inheritdoc}
     */
    public function send(IMessage $message)
    {
        $params = [
            'apikey' => $this->options['apikey'],
            'mobile' => $message->getTo(),
            'text' => $message->getContent()
        ];
        try {
            $response = Http::post(self::SINGLE_SEND_API_URL, ['form_params' => $params, 'timeout' => 10]);
            $responseArr = json_decode($response->getBody(), true);
            $message->setSentAt(new \DateTime());
            if ($responseArr['code'] === 0) {
                $message->setState(IMessage::STATE_SENT);
                $message->setId($responseArr['sid']);
            } else {
                $message->setState(IMessage::STATE_FAIL);
                $message->setFailReason($responseArr['msg']);
            }
            return new Result($message);
        } catch (ConnectException $e) {
            $message->setSentAt(new \DateTime());
            $message->setState(IMessage::STATE_FAIL);
            $message->setFailReason($e->getMessage());
            return new Result($message);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function report()
    {
        $params = [
            'apikey' => $this->options['apiKey'],
            'page_size' => 20
        ];
        $response = Http::post(self::PULL_STATUS_API_URL, ['query' => $params, 'timeout' => 10]);
        $responseArr = json_decode($response->getBody(), true);
        $result = [];
        foreach ($responseArr as $res) {
            $success = ($res['report_status'] == 'SUCCESS') ? true : false;
            $deliveredAt = new \DateTime($res['user_receive_time'], new \DateTimeZone('Asia/Shanghai'));
            $errorMessage = $success ? '' : $res['error_msg'];
            $report = new Report();
            $report->setSuccess($success);
            $report->setProviderName($this->getName());
            $report->setErrorMessage($errorMessage);
            $report->setDeliveredAt($deliveredAt);
            $report->setId($res['sid']);
            $result[] = $report;
        }
        return $result;
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'yunpian';
    }


}