<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%track}}`.
 */
class m250613_062520_createTrackTable extends Migration
{
    public function safeUp()
    {
        $this->createTable('{{%track}}', [
            'id' => $this->primaryKey(),
            'track_number' => $this->string(50)->notNull()->unique(),
            'status' => $this->string(20)->notNull(),
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->notNull(),
        ]);

        $this->createIndex('idx-track-status', '{{%track}}', 'status');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%track}}');
    }
}
