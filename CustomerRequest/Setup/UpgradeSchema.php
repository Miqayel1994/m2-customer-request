<?php

namespace ArmMage\CustomerRequest\Setup;

use Magento\Framework\Setup\UpgradeSchemaInterface;

use Magento\Framework\Setup\ModuleContextInterface;

use Magento\Framework\Setup\SchemaSetupInterface;

class UpgradeSchema implements  UpgradeSchemaInterface

{
public function upgrade(SchemaSetupInterface $setup,ModuleContextInterface $context){
    $setup->startSetup();
    if (version_compare($context->getVersion(), '1.0.1') < 0) {
// Get module table
        $tableName = $setup->getTable('am_customer_request');
// Check if the table already exist
        if ($setup->getConnection()->isTableExists($tableName) == true) {
// Declare data
        $columns = [
                'status' => [
                'type' => \Magento\Framework\DB\Ddl\Table::TYPE_BOOLEAN,
                'nullable' => false,
                'comment' => 'status',
            ],
        ];
            $connection = $setup->getConnection();
            foreach ($columns as $name => $definition) {
                $connection->addColumn($tableName, $name, $definition);
                }   
            }
        }
        if(version_compare($context->getVersion(), '1.0.3', '<')) {
            $setup->getConnection()->addIndex(
                $setup->getTable('am_customer_request'),
                'ARMMAGE_CATALOGREQUEST_ENTITY_EMAIL',
                'email',
                \Magento\Framework\DB\Adapter\AdapterInterface::INDEX_TYPE_UNIQUE
            );
        }
        $setup->endSetup();
    }
}

