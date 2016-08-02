<?php

class m160731_083828_create_comments_collection extends \yii\mongodb\Migration
{
    public function up()
    {
        $this->createCollection('comment');
    }

    public function down()
    {
        $this->dropCollection('comment');
    }
}
