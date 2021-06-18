<?php

namespace Teamapt\Monnify\Setup;

use Magento\Framework\Setup\InstallSchemaInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\SchemaSetupInterface;
use Magento\Framework\DB\Ddl\Table;

class InstallSchema implements InstallSchemaInterface
{
    /**
     * {@inheritdoc}
     */
    public function install(SchemaSetupInterface $setup, ModuleContextInterface $context)
    {
        $setup->startSetup();

        $table = $setup->getConnection()->newTable(
            $setup->getTable('reserved_account_config')
                )->addColumn(
                    'id',
                    Table::TYPE_INTEGER,
                    null,
                    ['identity' => true, 'nullable' => false, 'primary' => true],
                    'Reserved Account ID'
                )->addColumn(
                    'api_key',
                    Table::TYPE_TEXT,
                    255,
                    ['nullable' => false],
                    'Api Key'
                )->addColumn(
                    'api_secret',
                    Table::TYPE_TEXT,
                    255,
                    ['nullable' => false],
                    'Api Secret'
                )->addColumn(
                    'contract_code',
                    Table::TYPE_TEXT,
                    255,
                    ['nullable' => false],
                    'Contract Code'
                )->addColumn(
                    'account_reference_suffix',
                    Table::TYPE_TEXT,
                    255,
                    ['nullable' => false],
                    'Account Reference Suffix'
                )->addColumn(
                    'is_active',
                    Table::TYPE_BOOLEAN,
                    null,
                    ['nullable' => false],
                    'Contract Code'
                )->addIndex(
                    $setup->getIdxName('reserved_account_config', ['api_secret']),
                    ['api_key']
            )->setComment(
                'Reserved Account Configuration'
            );
        $setup->getConnection()->createTable($table);
        $setup->endSetup();
    }
}
