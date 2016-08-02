<?php

class m160731_081812_create_authorization_collection extends \yii\mongodb\Migration
{
    public function up()
    {
        $this->createCollection('authorization');
    }

    public function down()
    {
        $this->dropCollection('authorization');
    }
}
