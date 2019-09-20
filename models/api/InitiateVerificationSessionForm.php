<?php

namespace dpodium\pipwave\sdk\models\api;

/**
 * InitiateVerificationSessionForm is the model behind the initiate-verification-session API.
 */
class InitiateVerificationSessionForm extends \dpodium\pipwave\sdk\models\ApiForm
{

    const ACTION_CODE = 'initiate-verification-session',
            MODE_KEYWORD_LIVEFEED = 'livefeed',
            MODE_KEYWORD_UPLOAD = 'upload';

    public $types_of_verification; //JSON
    public $user_id;
    public $extra_param1;
    public $extra_param2;
    public $extra_param3;
    public $notification_url;
    public $allowed_mode; //Comma-delimited
    public $signature;

    /**
     * @inheritdoc
     */
    public function rules() {
        return array_merge(parent::rules(), [
            [ [ 'user_id', 'signature' ], 'required' ],
            [ [ 'extra_param1', 'extra_param2', 'extra_param3', 'types_of_verification', 'notification_url', 'allowed_mode' ], 'string', 'max' => 255 ],
            [ [ 'user_id' ], 'string', 'max' => 32 ],
            [ [ 'signature' ], 'validateSignature' ],
            [ [ 'types_of_verification' ], 'validateTypesOfVerification' ],
            [ [ 'allowed_mode' ], 'validateAllowedSource' ],
        ]);
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return array_merge(parent::attributeLabels(), [
            'types_of_verification' => 'types_of_verification',
            'user_id'               => 'user_id',
            'extra_param1'          => 'extra_param1',
            'extra_param2'          => 'extra_param2',
            'extra_param3'          => 'extra_param3',
            'notification_url'      => 'notification_url',
            'allowed_mode'          => 'allowed_mode',
            'signature'             => 'signature',
        ]);
    }

    public function generateSignature($array = []) {
        if ( !empty($this->user_id) ) {
            $array['user_id'] = $this->user_id;
        }
        if ( !empty($this->extra_param1) ) {
            $array['extra_param1'] = $this->extra_param1;
        }
        if ( !empty($this->extra_param2) ) {
            $array['extra_param2'] = $this->extra_param2;
        }
        if ( !empty($this->extra_param3) ) {
            $array['extra_param3'] = $this->extra_param3;
        }
        if ( !empty($this->notification_url) ) {
            $array['notification_url'] = $this->notification_url;
        }
        return parent::generateSignature($array);
    }

}
