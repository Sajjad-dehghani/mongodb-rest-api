<?php

namespace common\models;

use common\models\ar\Comments;
use Yii;
use yii\web\IdentityInterface;

/**
 * This is the model class for collection "authorization".
 *
 * @property \MongoDB\BSON\ObjectID|string $_id
 * @property mixed $email
 * @property mixed $access_token
 * @property mixed $refresh_token
 * @property mixed $expire_at
 * @property mixed $create_at
 * @property mixed $update_at
 */
class Authorization extends \yii\mongodb\ActiveRecord implements IdentityInterface
{
    /**
     * @inheritdoc
     */
    public static function collectionName()
    {
        return 'authorization';
    }

    /**
     * @inheritdoc
     */
    public function attributes()
    {
        return [
            '_id',
            'email',
            'access_token',
            'refresh_token',
            'expire_at',
            'create_at',
            'update_at',
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['email', 'required'],
            ['email', 'email'],
            [['email', 'access_token', 'refresh_token', 'expire_at', 'create_at', 'update_at'], 'safe']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            '_id' => 'ID',
            'email' => 'Email',
            'access_token' => 'Access Token',
            'refresh_token' => 'Refresh Token',
            'expire_at' => 'Expire At',
            'create_at' => 'Create At',
            'update_at' => 'Update At',
        ];
    }

    /**
     * @param bool $insert
     * @return bool
     */
    public function beforeSave($insert)
    {
        $time = date('Y-m-d H:i:s', time());
        if (parent::beforeSave($insert)) {
            $this->access_token = Yii::$app->security->generateRandomString();
            $this->refresh_token = Yii::$app->security->generateRandomString();
            $this->expire_at = date('Y-m-d H:i:s', time() + Yii::$app->params['token.expireTime']);
            $this->create_at = $time;
            $this->update_at = $time;
            return true;
        } else {
            return false;
        }
    }

    /**
     * @return array
     */
    public function fields()
    {
        return [
            '_id',
            'access_token',
            'refresh_token',
            'expire_at'
        ];
    }

    /**
     * Finds an identity by the given ID.
     * @param string|integer $id the ID to be looked for
     * @return IdentityInterface the identity object that matches the given ID.
     * Null should be returned if such an identity cannot be found
     * or the identity is not in an active state (disabled, deleted, etc.)
     */
    public static function findIdentity($id)
    {
        return self::findOne(['_id' => $id]);
    }

    /**
     * Finds an identity by the given token.
     * @param mixed $token the token to be looked for
     * @param mixed $type the type of the token. The value of this parameter depends on the implementation.
     * For example, [[\yii\filters\auth\HttpBearerAuth]] will set this parameter to be `yii\filters\auth\HttpBearerAuth`.
     * @return IdentityInterface the identity object that matches the given token.
     * Null should be returned if such an identity cannot be found
     * or the identity is not in an active state (disabled, deleted, etc.)
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        return self::findOne(['access_token' => $token]);
    }

    /**
     * Returns an ID that can uniquely identify a user identity.
     * @return string|integer an ID that uniquely identifies a user identity.
     */
    public function getId()
    {
        return $this->_id;
    }

    /**
     * Returns a key that can be used to check the validity of a given identity ID.
     *
     * The key should be unique for each individual user, and should be persistent
     * so that it can be used to check the validity of the user identity.
     *
     * The space of such keys should be big enough to defeat potential identity attacks.
     *
     * This is required if [[User::enableAutoLogin]] is enabled.
     * @return string a key that is used to check the validity of a given identity ID.
     * @see validateAuthKey()
     */
    public function getAuthKey()
    {
        return $this->access_token;
    }

    /**
     * Validates the given auth key.
     *
     * This is required if [[User::enableAutoLogin]] is enabled.
     * @param string $authKey the given auth key
     * @return boolean whether the given auth key is valid.
     * @see getAuthKey()
     */
    public function validateAuthKey($authKey)
    {
        return self::findOne(['access_token' => $authKey]);
    }

    /**
     * @return \yii\db\ActiveQueryInterface
     */
    public function getComments()
    {
        return $this->hasOne(Comments::className(), ['_id' => 'user_id']);
    }
}
