<?php

namespace common\models\ar;

use common\models\Authorization;
use Yii;

/**
 * This is the model class for collection "comments".
 *
 * @property \MongoDB\BSON\ObjectID|string $_id
 * @property mixed $title
 * @property mixed $content
 * @property mixed $status
 * @property mixed $user_id
 * @property mixed $created_at
 * @property mixed $updated_at
 */
class Comments extends \yii\mongodb\ActiveRecord
{
    const UNAPPROVED = 0;
    const  APPROVED = 1;

    /**
     * @inheritdoc
     */
    public static function collectionName()
    {
        return 'comments';
    }

    /**
     * @inheritdoc
     */
    public function attributes()
    {
        return [
            '_id',
            'title',
            'content',
            'status',
            'user_id',
            'created_at',
            'updated_at',
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['title', 'required'],
            ['title', 'unique', 'targetClass' => self::className()],
            ['title', 'string', 'max' => 30],
            ['content', 'string', 'max' => 300],
            [['title', 'content', 'status', 'user_id', 'created_at', 'updated_at'], 'safe']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            '_id' => 'ID',
            'title' => 'Title',
            'content' => 'Content',
            'status' => 'Status',
            'user_id' => 'User ID',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
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
            $this->status = self::UNAPPROVED;
            $this->created_at = $time;
            $this->updated_at = $time;
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
            'title',
            'content',
            'status' => function () {
                return $this->status == self::UNAPPROVED ? 'Waiting for approval by admin' : 'Approved';
            },
            'created_at'
        ];
    }

    /**
     * @return \yii\db\ActiveQueryInterface
     */
    public function getComments()
    {
        return $this->hasMany(Authorization::className(), ['_id' => 'user_id']);
    }
}
