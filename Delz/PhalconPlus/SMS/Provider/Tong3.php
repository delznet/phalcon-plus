<?php

declare(strict_types=1);

namespace Delz\PhalconPlus\SMS\Provider;

use Delz\PhalconPlus\SMS\Contract\IMessage;
use Delz\PhalconPlus\SMS\Result;
use Delz\PhalconPlus\SMS\Exception\InvalidOptionsException;
use Delz\PhalconPlus\SMS\Provider;
use Delz\PhalconPlus\Util\Http;
use GuzzleHttp\Exception\ConnectException;
use Delz\PhalconPlus\SMS\Report;

/**
 * 大汉三通短信提供商
 *
 * @package Delz\PhalconPlus\SMS\Provider
 */
class Tong3 extends Provider
{
    /**
     * 短信下行网关地址
     */
    const API_SUBMIT_URL = 'http://wt.3tong.net/json/sms/Submit';

    /**
     * 短信发送报告
     *
     * 每次最多取200条状态报告。
     */
    const API_REPORT = 'http://wt.3tong.net/json/sms/Report';

    /**
     * {@inheritdoc}
     */
    public function __construct(array $options)
    {
        parent::__construct($options);
        if (!isset($options['account'])
            || !isset($options['password'])
            || !isset($options['sign'])
            || !isset($options['subCode'])) {
            throw new InvalidOptionsException();
        }
    }

    /**
     * {@inheritdoc}
     */
    public function send(IMessage $message)
    {
        $params = [
            'account' => $this->options['account'],
            'password' => md5($this->options['password']),
            'msgid' => $this->buildMessageId(),//该批短信编号(32位UUID)，需保证唯一，必填
            'phones' => $message->getTo(),//接收手机号码，多个手机号码用英文逗号分隔，最多500个
            'content' => $message->getContent(),//短信内容，最多350个汉字
            'sign' => $this->options['sign'],
            'subcode' => $this->options['subCode'],
            'sendtime' => '' //定时发送时间，格式yyyyMMddHHmm，为空或早于当前时间则立即发送；
        ];
        try {
            $response = Http::post(self::API_SUBMIT_URL, ['json' => $params, 'timeout' => 10]);
            $responseArr = json_decode($response->getBody(), true);
            $message->setSentAt(new \DateTime());
            if ($responseArr['result'] === '0') {
                $message->setState(IMessage::STATE_SENT);
                $message->setId($params['msgid']);
            } else {
                $message->setState(IMessage::STATE_FAIL);
                $message->setFailReason($responseArr['desc']);
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
            'account' => $this->options['account'],
            'password' => md5($this->options['password'])
        ];
        $result = [];
        $response = Http::post(self::API_REPORT, ['json' => $params, 'timeout' => 10]);
        $responseArr = json_decode($response->getBody(), true);

        if ($responseArr['result'] === '0') {
            foreach ($responseArr['reports'] as $res) {
                $success = $res['status'] === '0' ? true : false;
                $deliveredAt = new \DateTime($res['time'], new \DateTimeZone('Asia/Shanghai'));
                $report = new Report();
                $report->setId($res['msgid']);
                $report->setDeliveredAt($deliveredAt);
                $report->setErrorMessage($res['desc']);
                $report->setProviderName($this->getName());
                $report->setSuccess($success);
                $result[] = $report;
            }
        }

        return $result;
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'tong3';
    }

    /**
     * 生成messageId
     *
     * @return string
     */
    private function buildMessageId()
    {
        return md5(date('ymd') . substr(time(), -5) . str_pad(rand(0, 999999), 6, "0", STR_PAD_LEFT));
    }

}