<?php

use inblank\team\migrations\Migration;
use yii\db\Schema;

class m160202_123350_team_init extends Migration
{
    const TAB_ROLE = 'role';
    const TAB_SPECIALITY = 'speciality';
    const TAB_MEMBER = 'member';
    const TAB_TEAM = 'team';
    const TAB_TEAM_MEMBER = 'team_member';
    const TAB_MEMBER_ROLE = 'member_role';
    const TAB_HISTORY = 'history';

    public function up()
    {
        $userTableName = $this->userObject->tableName();
        $userTablePrimaryKey = $this->userObject->primaryKey();

        // Member roles
        $tab = $this->tn(self::TAB_ROLE);
        $this->createTable($tab, [
            'id' => Schema::TYPE_PK,
            'name' => Schema::TYPE_STRING . "(255) NOT NULL DEFAULT ''",
        ], $this->tableOptions);

        // Member specialities
        $tab = $this->tn(self::TAB_SPECIALITY);
        $this->createTable($tab, [
            'id' => Schema::TYPE_PK,
            'name' => Schema::TYPE_STRING . "(255) NOT NULL DEFAULT ''",
        ], $this->tableOptions);

        // Members
        $tab = $this->tn(self::TAB_MEMBER);
        $this->createTable($tab, [
            'id' => Schema::TYPE_PK,
            'user_id' => Schema::TYPE_INTEGER . ' NOT NULL',
            'speciality_id' => Schema::TYPE_INTEGER . ' DEFAULT NULL',
        ], $this->tableOptions);
        $this->addForeignKey(
            $this->fk(self::TAB_MEMBER, 'user'),
            $tab, 'user_id',
            $userTableName, $userTablePrimaryKey,
            'CASCADE', 'RESTRICT'
        );
        $this->addForeignKey(
            $this->fk(self::TAB_MEMBER, self::TAB_SPECIALITY),
            $tab, 'speciality_id',
            $this->tn(self::TAB_SPECIALITY), 'id',
            'CASCADE', 'RESTRICT'
        );

        // Teams
        $tab = $this->tn(self::TAB_TEAM);
        $this->createTable($tab, [
            'id' => Schema::TYPE_PK,
            'creator_id' => Schema::TYPE_INTEGER . ' DEFAULT NULL',
            'owner_id' => Schema::TYPE_INTEGER . ' DEFAULT NULL',
            'slug' => Schema::TYPE_STRING . '(255) NOT NULL',
            'emblem' => Schema::TYPE_STRING . '(255) DEFAULT NULL',
            'name' => Schema::TYPE_STRING . '(255) NOT NULL',
            'founded_at' => Schema::TYPE_DATE . ' DEFAULT NULL',
            'description' => Schema::TYPE_TEXT . ' NOT NULL',
            'created_at' => Schema::TYPE_DATETIME . ' DEFAULT NULL',
            'disbanded_at' => Schema::TYPE_DATETIME . ' DEFAULT NULL',
        ], $this->tableOptions);
        $this->createIndex('unique_slug', $tab, 'slug', true);
        $this->addForeignKey(
            $this->fk(self::TAB_TEAM, 'creator'),
            $tab, 'creator_id',
            $userTableName, $userTablePrimaryKey,
            'CASCADE', 'RESTRICT'
        );
        $this->addForeignKey(
            $this->fk(self::TAB_TEAM, 'owner'),
            $tab, 'owner_id',
            $userTableName, $userTablePrimaryKey,
            'CASCADE', 'RESTRICT'
        );

        // Members
        $tab = $this->tn(self::TAB_TEAM_MEMBER);
        $this->createTable($tab, [
            'team_id' => Schema::TYPE_INTEGER . ' NOT NULL',
            'member_id' => Schema::TYPE_INTEGER . ' NOT NULL',
            'number' => Schema::TYPE_INTEGER . ' DEFAULT NULL',
            'speciality_id' => Schema::TYPE_INTEGER . ' DEFAULT NULL',
            'joined_at' => Schema::TYPE_DATETIME . ' DEFAULT NULL',
        ], $this->tableOptions);
        $this->addPrimaryKey(
            $this->pk(self::TAB_TEAM_MEMBER),
            $tab,
            ['team_id', 'member_id']
        );
        $this->addForeignKey(
            $this->fk(self::TAB_TEAM_MEMBER, self::TAB_TEAM),
            $tab, 'team_id',
            $this->tn(self::TAB_TEAM), 'id',
            'CASCADE', 'RESTRICT'
        );
        $this->addForeignKey(
            $this->fk(self::TAB_TEAM_MEMBER, self::TAB_MEMBER),
            $tab, 'member_id',
            $this->tn(self::TAB_MEMBER), 'id',
            'CASCADE', 'RESTRICT'
        );
        $this->addForeignKey(
            $this->fk(self::TAB_TEAM_MEMBER, self::TAB_SPECIALITY),
            $tab, 'speciality_id',
            $this->tn(self::TAB_SPECIALITY), 'id',
            'CASCADE', 'RESTRICT'
        );

        // Members roles link
        $tab = $this->tn(self::TAB_MEMBER_ROLE);
        $this->createTable($tab, [
            'team_id' => Schema::TYPE_INTEGER . ' DEFAULT NULL',
            'member_id' => Schema::TYPE_INTEGER . ' DEFAULT NULL',
            'role_id' => Schema::TYPE_INTEGER . " DEFAULT NULL",
            'date' => Schema::TYPE_DATETIME . ' DEFAULT NULL',
        ], $this->tableOptions);
        $this->addPrimaryKey(
            $this->pk(self::TAB_MEMBER_ROLE),
            $tab,
            ['team_id', 'member_id', 'role_id']
        );
        $this->addForeignKey(
            $this->fk(self::TAB_MEMBER_ROLE, self::TAB_TEAM),
            $tab, 'team_id',
            $this->tn(self::TAB_TEAM), 'id',
            'CASCADE', 'RESTRICT'
        );
        $this->addForeignKey(
            $this->fk(self::TAB_MEMBER_ROLE, self::TAB_MEMBER),
            $tab, 'member_id',
            $this->tn(self::TAB_MEMBER), 'id',
            'CASCADE', 'RESTRICT'
        );
        $this->addForeignKey(
            $this->fk(self::TAB_MEMBER_ROLE, self::TAB_ROLE),
            $tab, 'role_id',
            $this->tn(self::TAB_ROLE), 'id',
            'CASCADE', 'RESTRICT'
        );

        // Members history
        $tab = $this->tn(self::TAB_HISTORY);
        $this->createTable($tab, [
            'id' => Schema::TYPE_PK,
            'team_id' => Schema::TYPE_INTEGER . ' NOT NULL',
            'member_id' => Schema::TYPE_INTEGER . ' NOT NULL',
            'role_id' => Schema::TYPE_INTEGER . ' DEFAULT NULL',
            'speciality_id' => Schema::TYPE_INTEGER . ' DEFAULT NULL',
            'action' => Schema::TYPE_INTEGER . ' NOT NULL DEFAULT 0',
            'date' => Schema::TYPE_DATETIME . ' DEFAULT NULL',
        ], $this->tableOptions);
        $this->addForeignKey(
            $this->fk(self::TAB_HISTORY, self::TAB_TEAM),
            $tab, 'team_id',
            $this->tn(self::TAB_TEAM), 'id',
            'CASCADE', 'RESTRICT'
        );
        $this->addForeignKey(
            $this->fk(self::TAB_HISTORY, self::TAB_MEMBER),
            $tab, 'member_id',
            $this->tn(self::TAB_MEMBER), 'id',
            'CASCADE', 'RESTRICT'
        );
        $this->addForeignKey(
            $this->fk(self::TAB_HISTORY, self::TAB_ROLE),
            $tab, 'role_id',
            $this->tn(self::TAB_ROLE), 'id',
            'CASCADE', 'RESTRICT'
        );
        $this->addForeignKey(
            $this->fk(self::TAB_HISTORY, self::TAB_SPECIALITY),
            $tab, 'speciality_id',
            $this->tn(self::TAB_SPECIALITY), 'id',
            'CASCADE', 'RESTRICT'
        );
    }

    public function down()
    {
        $tables = [
            self::TAB_HISTORY,
            self::TAB_MEMBER_ROLE,
            self::TAB_TEAM_MEMBER,
            self::TAB_TEAM,
            self::TAB_MEMBER,
            self::TAB_SPECIALITY,
            self::TAB_ROLE,
        ];
        foreach ($tables as $table) {
            $this->dropTable($this->tn($table));
        }
        return true;
    }

    /*
    // Use safeUp/safeDown to run migration code within a transaction
    public function safeUp()
    {
    }

    public function safeDown()
    {
    }
    */
}
