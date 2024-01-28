<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;
use Doctrine\DBAL\Types\Types;

/**
 * Creates the "orders" table.
 */
final class Version20240127051058 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Creates the orders table.';
    }

    public function up(Schema $schema): void
    {
        $this->addSql("CREATE TYPE status_enum AS ENUM ('Processing', 'Completed');");

        $table = $schema->createTable('orders');
        $table->addColumn('id', Types::INTEGER, ['autoincrement' => true, 'notnull' => true]);
        $table->addColumn('product_id', Types::GUID, ['notnull' => false]);
        $table->addColumn('customer_name', Types::STRING, ['length' => 255, 'notnull' => true]);
        $table->addColumn('quantity', Types::INTEGER, ['notnull' => true]);
        $table->addColumn('status', 'status_enum', ['notnull' => true, 'default' => 'Processing']);
        $table->addIndex(['product_id'], 'orders_product_id_idx');
        $table->addForeignKeyConstraint('products', ['product_id'], ['id'], ['onDelete' => 'RESTRICT'], 'orders_product_id_fk');
        $table->setPrimaryKey(['id']);
    }

    public function down(Schema $schema): void
    {
        $schema->dropTable('orders');
        $this->addSql('DROP TYPE status_enum;');
    }
}
