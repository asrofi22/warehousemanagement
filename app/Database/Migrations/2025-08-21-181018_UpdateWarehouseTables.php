<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class UpdateWarehouseTables extends Migration
{
    public function up()
    {
        // Create purchases table if it doesn't exist
        if (!$this->db->tableExists('purchases')) {
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
        }

        // Create purchase_items table if it doesn't exist and products table exists
        if (!$this->db->tableExists('purchase_items') && $this->db->tableExists('products')) {
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
        }

        // Migrate existing incoming_items data
        if ($this->db->tableExists('incoming_items')) {
            // Check if product_id exists and purchase_id doesn't
            $fields = $this->db->getFieldNames('incoming_items');
            if (in_array('product_id', $fields) && !in_array('purchase_id', $fields)) {
                // Add purchase_id column first
                $this->forge->addColumn('incoming_items', [
                    'purchase_id' => [
                        'type' => 'INT',
                        'constraint' => 11,
                        'unsigned' => true,
                        'null' => true, // Allow null temporarily
                        'after' => 'id',
                    ],
                ]);

                // Migrate data
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

                    // Create a purchase_item record if products table exists
                    if ($this->db->tableExists('products')) {
                        $this->db->table('purchase_items')->insert([
                            'purchase_id' => $purchaseId,
                            'product_id' => $item['product_id'],
                            'quantity' => $item['quantity'],
                        ]);
                    }

                    // Update incoming_items with purchase_id
                    $this->db->table('incoming_items')->where('id', $item['id'])->update(['purchase_id' => $purchaseId]);
                }

                // Add foreign key constraint
                $this->forge->addForeignKey('purchase_id', 'purchases', 'id', 'CASCADE', 'CASCADE');

                // Drop product_id column
                $this->forge->dropColumn('incoming_items', 'product_id');
            }
        }
    }

    public function down()
    {
        // Restore product_id to incoming_items if it exists
        if ($this->db->tableExists('incoming_items')) {
            $fields = $this->db->getFieldNames('incoming_items');
            if (in_array('purchase_id', $fields)) {
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
        }

        // Drop purchase_items and purchases tables
        $this->forge->dropTable('purchase_items', true);
        $this->forge->dropTable('purchases', true);
    }
}