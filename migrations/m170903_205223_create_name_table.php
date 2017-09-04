<?php

use yii\db\Migration;

/**
 * Handles the creation of table `name`.
 */
class m170903_205223_create_name_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            // http://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%name}}', [
            'id' => $this->primaryKey(),
            'created_date' => $this->timestamp()->notNull(),// дата создания
            'updated_date' => $this->timestamp()->notNull(),// дата изменния
            'name'=>$this->string()->notNull(),// имя пользователя
            'title' => $this->string()->notNull(), // название расчета
            'body' => $this->text()->notNull(),// тело расчета

        ], $tableOptions);

        $this->createTable('{{%code}}', [
            'id' => $this->primaryKey(),
            'name_id'=>$this->integer()->unsigned()->notNull(),// Родительская запись
            'code'=>$this->string()->notNull(),// код


        ], $tableOptions);

        $this->createIndex('name_id','{{%code}}','name_id');
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('{{%name}}');
    }
}
