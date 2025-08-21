<?php
namespace App\Database\Migrations;
use CodeIgniter\Database\Migration;

class CreateWarehouseTables extends Migration
{
    public function up()
    {
        // Categories Table
        $this->forge->addField([
            'id' => [
                'type' => 'INT',
                'unsigned' => true,
                'auto_increment' => true,
            ],
            'name' => [
                'type' => 'VARCHAR',
                'constraint' => '100',
                'null' => false,
            ],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('categories', false, ['ENGINE' => 'InnoDB']);

        // Products Table
        $this->forge->addField([
            'id' => [
                'type' => 'INT',
                'unsigned' => true,
                'auto_increment' => true,
            ],
            'category_id' => [
                'type' => 'INT',
                'unsigned' => true,
            ],
            'name' => [
                'type' => 'VARCHAR',
                'constraint' => '100',
                'null' => false,
            ],
            'code' => [
                'type' => 'VARCHAR',
                'constraint' => '50',
                'null' => false,
            ],
            'unit' => [
                'type' => 'VARCHAR',
                'constraint' => '50',
                'null' => false,
            ],
            'stock' => [
                'type' => 'FLOAT',
                'null' => false,
                'default' => 0.0,
            ],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addUniqueKey('code');
        $this->forge->addKey('category_id');
        $this->forge->addForeignKey('category_id', 'categories', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('products', false, ['ENGINE' => 'InnoDB']);

        // Incoming Items Table
        $this->forge->addField([
            'id' => [
                'type' => 'INT',
                'unsigned' => true,
                'auto_increment' => true,
            ],
            'product_id' => [
                'type' => 'INT',
                'unsigned' => true,
            ],
            'date' => [
                'type' => 'DATETIME',
                'null' => false,
            ],
            'quantity' => [
                'type' => 'FLOAT',
                'null' => false,
            ],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addKey('product_id');
        $this->forge->addForeignKey('product_id', 'products', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('incoming_items', false, ['ENGINE' => 'InnoDB']);

        // Outgoing Items Table
        $this->forge->addField([
            'id' => [
                'type' => 'INT',
                'unsigned' => true,
                'auto_increment' => true,
            ],
            'product_id' => [
                'type' => 'INT',
                'unsigned' => true,
            ],
            'date' => [
                'type' => 'DATETIME',
                'null' => false,
            ],
            'quantity' => [
                'type' => 'FLOAT',
                'null' => false,
            ],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addKey('product_id');
        $this->forge->addForeignKey('product_id', 'products', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('outgoing_items', false, ['ENGINE' => 'InnoDB']);
    }

    public function down()
    {
        $this->forge->dropTable('outgoing_items', true);
        $this->forge->dropTable('incoming_items', true);
        $this->forge->dropTable('products', true);
        $this->forge->dropTable('categories', true);
    }
}