<?php

class m160801_050552_add_all_indexs extends \yii\mongodb\Migration
{
    public function up()
    {
        $this->createIndexes('authorization', [
            'access_token' => 'idx_access_token',
            'refresh_token' => 'idx_refresh_token'
        ]);
        $this->createIndexes('comments', [
            'title' => 'idx_title',
            'status' => 'idx_status'
        ]);
    }

    public function down()
    {
        $this->dropAllIndexes('authorization');
        $this->dropAllIndexes('comments');
    }
}
