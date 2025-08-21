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

        // Purchases Table
        $this->forge->addField([
            'id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'auto_increment' => true,
            ],
            'vendor_name' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
            ],
            'vendor_address' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'purchase_date' => [
                'type' => 'DATETIME',
            ],
            'buyer_name' => [
                'type' => 'VARCHAR',
                'constraint' => 100,
            ],
            'created_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'updated_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'deleted_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('purchases', false, ['ENGINE' => 'InnoDB']);

        // Purchase Items Table
        $this->forge->addField([
            'id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'auto_increment' => true,
            ],
            'purchase_id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
            ],
            'product_id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
            ],
            'quantity' => [
                'type' => 'FLOAT',
            ],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('purchase_id', 'purchases', 'id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('product_id', 'products', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('purchase_items', false, ['ENGINE' => 'InnoDB']);

        // Migrate existing incoming_items data
        if ($this->db->tableExists('incoming_items')) {
            $incomingItems = $this->db->table('incoming_items')->get()->getResultArray();
            foreach ($incomingItems as $item) {
                // Create a purchase record
                $purchaseData = [
                    'vendor_name' => 'Legacy Vendor',
                    'vendor_address' => null,
                    'purchase_date' => $item['date'],
                    'buyer_name' => 'System',
                    'created_at' => date('Y-m-d H:i:s'),
                ];
                $this->db->table('purchases')->insert($purchaseData);
                $purchaseId = $this->db->insertID();

                // Create a purchase_item record
                $this->db->table('purchase_items')->insert([
                    'purchase_id' => $purchaseId,
                    'product_id' => $item['product_id'],
                    'quantity' => $item['quantity'],
                ]);

                // Update incoming_items with purchase_id
                $this->db->table('incoming_items')->where('id', $item['id'])->update(['purchase_id' => $purchaseId]);
            }

            // Modify incoming_items table
            $this->forge->addColumn('incoming_items', [
                'purchase_id' => [
                    'type' => 'INT',
                    'constraint' => 11,
                    'unsigned' => true,
                    'null' => true, // Allow null temporarily
                    'after' => 'id',
                ],
            ]);
            $this->forge->addForeignKey('purchase_id', 'purchases', 'id', 'CASCADE', 'CASCADE');
            $this->forge->dropColumn('incoming_items', 'product_id');
        } else {
            // Create incoming_items table (if it doesn't exist)
            $this->forge->addField([
                'id' => [
                    'type' => 'INT',
                    'unsigned' => true,
                    'auto_increment' => true,
                ],
                'purchase_id' => [
                    'type' => 'INT',
                    'constraint' => 11,
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
            $this->forge->addForeignKey('purchase_id', 'purchases', 'id', 'CASCADE', 'CASCADE');
            $this->forge->createTable('incoming_items', false, ['ENGINE' => 'InnoDB']);
        }

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
        if ($this->db->tableExists('incoming_items')) {
            // Restore product_id to incoming_items
            $this->forge->addColumn('incoming_items', [
                'product_id' => [
                    'type' => 'INT',
                    'constraint' => 10,
                    'unsigned' => true,
                    'after' => 'id',
                ],
            ]);
            $this->forge->addForeignKey('product_id', 'products', 'id', 'CASCADE', 'CASCADE');
            $this->forge->dropColumn('incoming_items', 'purchase_id');
        }
        $this->forge->dropTable('purchase_items', true);
        $this->forge->dropTable('purchases', true);
        $this->forge->dropTable('products', true);
        $this->forge->dropTable('categories', true);
    }
}