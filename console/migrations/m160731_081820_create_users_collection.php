<?php

class m160731_081820_create_users_collection extends \yii\mongodb\Migration
{
    public function up()
    {
        $this->createCollection('users');
    }

    public function down()
    {
        $this->dropCollection('users');
    }
}
