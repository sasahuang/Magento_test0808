<?php
$installer = $this;
$installer->startSetup();

$table = $installer->getConnection()
    ->newTable($installer->getTable('slider/slide'))
    ->addColumn('slide_id', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array(
        'identity'  => true,
        'primary'   => true,
        'unsigned'  => true,
        'nullable'  => false,
    ), 'Slide Id')
    ->addColumn('title', Varien_Db_Ddl_Table::TYPE_VARCHAR, 255, array(
        'nullable'  => false,
        'default'   => '',
    ), 'Title')
    ->addColumn('img_src', Varien_Db_Ddl_Table::TYPE_VARCHAR, 255, array(
        'nullable'  => false,
        'default'   => '',
    ), 'Image Src')
    ->addColumn('img_alt', Varien_Db_Ddl_Table::TYPE_VARCHAR, 255, array(
        'nullable'  => false,
        'default'   => '',
    ), 'Image Alt')
    ->addColumn('sort_order', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array(
        'unsigned'  => true,
        'nullable'  => false,
        'default'   => 0,
    ), 'Sort Order')
    ->addColumn('status', Varien_Db_Ddl_Table::TYPE_SMALLINT, null, array(
        'unsigned'  => true,
        'nullable'  => false,
        'default'   => 0,
    ), 'Status')
    ->addColumn('url', Varien_Db_Ddl_Table::TYPE_VARCHAR, 255, array(
        'nullable'  => false,
        'default'   => '',
    ), 'URL')
    ->setComment('Slide Table');
$installer->getConnection()->createTable($table);

$installer->run("
    DROP TABLE IF EXISTS {$installer->getTable('slider/slide_store')};
    CREATE TABLE {$installer->getTable('slider/slide_store')} (
        `slide_id` int(11) unsigned NOT NULL,
        `store_id` int(11) unsigned NOT NULL,
        PRIMARY KEY (`slide_id`, `store_id`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8;
");

$installer->endSetup();
