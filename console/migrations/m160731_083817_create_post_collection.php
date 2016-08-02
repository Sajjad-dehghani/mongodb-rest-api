<?php

class m160731_083817_create_post_collection extends \yii\mongodb\Migration
{
    public function up()
    {
        $this->createCollection('post');
    }

    public function down()
    {
        $this->dropCollection('post');
    }
}
