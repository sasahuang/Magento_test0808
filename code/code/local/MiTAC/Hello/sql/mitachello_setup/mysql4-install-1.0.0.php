<?php
$installer = $this;
$installer->startSetup();

if ($installer->getConnection()->isTableExists($installer->getTable('mitachello/message')) !=true) {
	$table = $installer->getConnection()
	->newTable($installer->getTable('mitachello/message'))
	->addColumn('id', Varien_Db_Ddl_Table::TYPE_SMALLINT, null, array(
		'identity' => true,
		'nullable' => false,
		'primary' => true,
		), 'Message ID')
	->addColumn('name', Varien_Db_Ddl_Table::TYPE_TEXT, 255, array(
		'nullable' => true,
		), 'Custoemr Name')
	->addColumn('content', Varien_Db_Ddl_Table::TYPE_TEXT, 255, array(
		'nullable' => true,
		), 'Message Content')
	->addColumn('status', Varien_Db_Ddl_Table::TYPE_SMALLINT, null, array(
		'nullable' => true,
		'default' => '1',
		), 'Message Status')
	->addColumn('created_time', Varien_Db_Ddl_Table::TYPE_TIMESTAMP, null, array(
		'default' => Varien_Db_Ddl_Table::TIMESTAMP_INIT
		), 'Message Created time')
	->setComment('MiTAC Message table');
	$installer->getConnection()->createTable($table);
}
$installer->endSetup();
