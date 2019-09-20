<?php

namespace dpodium\pipwave\sdk\models;

use \common\models\MerchantServer;

/**
 * ApiForm is the base model for API.
 *
 * @property string $action
 * @property string $api_key
 */
abstract class ApiForm extends \yii\base\Model {

    public $action;
    public $timestamp;
    public $api_key;
    public $version;

    public $merchant_id;
    public $api_secret;

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['api_key', 'timestamp', 'action'], 'required'],
            [['timestamp'], 'integer'],
            [['api_key'], 'string', 'max' => 64],
            [['version'], 'string', 'max' => 255],
            [['api_key'], 'validateApiKey'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return parent::attributeLabels() + [
            'api_key' => 'api_key',
            'timestamp' => 'timestamp',
            'signature' => 'signature',
            'version' => 'version',
        ];
    }

    public function validateSignature($attribute, $params) {
        $sig = $this->generateSignature();
        if ($sig !== $this->$attribute) {
            $this->addError($attribute, 'Invalid signature');
        }
    }

    public function generateSignature($array = []) {
        return static::genSignature(array_merge($array, [
            'action' => $this->action,
            'timestamp' => $this->timestamp,
            'api_key' => $this->api_key,
            'api_secret' => $this->api_secret,
        ]));
    }

    public static function genSignature($array = []) {
        ksort($array);
        $s = "";
        foreach($array as $key => $value) {
            $s .= $key . ':' . $value;
        }
        return sha1($s);
    }


//
//    public function validateApiKey($attribute, $params) {
//        $merchant_server = MerchantServer::getBasicInfoFromKey($this->$attribute);
//        if (!isset($merchant_server)) {
//            $this->addError($attribute, $attribute . ' is invalid.');
//        } else {
//            $this->api_secret = $merchant_server['api_secret'];
//            $this->merchant_id = $merchant_server['merchant_id'];
//        }
//    }


        }
