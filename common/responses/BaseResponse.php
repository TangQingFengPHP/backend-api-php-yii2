<?php

namespace common\responses;

use yii\web\Response;

class BaseResponse extends Response
{
    public string $successCode = '1';
    public string $successMessage = 'Ok';
    public string $resultKey = 'result';

    public function init(): void
    {
        parent::init();

        $this->on(self::EVENT_BEFORE_SEND, [$this, 'normalizeResponseStructure']);
    }

    public function normalizeResponseStructure($event): void
    {
        /** @var Response $response */
        $response = $event->sender;
        $data = $response->data;
        if ($response->getIsOk()) {
            $response->data = [
                'code' => $this->successCode,
                'message' => $this->successMessage,
                $this->resultKey => $data,
            ];
        } else {
            $code = $data['code'] ?? '0';
            $message = $data['message'] ?? 'Error';
            $response->data = [
                'code' => (string) $code,
                'message' => $message,
            ];
            $response->setStatusCode(200);
        }
    }
}