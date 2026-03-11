<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20260311083219 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE orders (id INT AUTO_INCREMENT NOT NULL, hash VARCHAR(32) NOT NULL, user_id INT DEFAULT NULL, token VARCHAR(64) NOT NULL, number VARCHAR(10) DEFAULT NULL, status INT NOT NULL, email VARCHAR(180) DEFAULT NULL, vat_type INT NOT NULL, vat_number VARCHAR(100) DEFAULT NULL, tax_number VARCHAR(50) DEFAULT NULL, discount INT DEFAULT NULL, delivery DOUBLE PRECISION DEFAULT NULL, delivery_type INT DEFAULT NULL, delivery_time_min DATE DEFAULT NULL, delivery_time_max DATE DEFAULT NULL, delivery_time_confirm_min DATE DEFAULT NULL, delivery_time_confirm_max DATE DEFAULT NULL, delivery_time_fast_pay_min DATE DEFAULT NULL, delivery_time_fast_pay_max DATE DEFAULT NULL, delivery_old_time_min DATE DEFAULT NULL, delivery_old_time_max DATE DEFAULT NULL, delivery_index VARCHAR(20) DEFAULT NULL, delivery_country INT DEFAULT NULL, delivery_region VARCHAR(50) DEFAULT NULL, delivery_city VARCHAR(200) DEFAULT NULL, delivery_address VARCHAR(300) DEFAULT NULL, delivery_building VARCHAR(200) DEFAULT NULL, delivery_phone_code VARCHAR(20) DEFAULT NULL, delivery_phone VARCHAR(20) DEFAULT NULL, sex INT DEFAULT NULL, client_name VARCHAR(255) DEFAULT NULL, client_surname VARCHAR(255) DEFAULT NULL, company_name VARCHAR(255) DEFAULT NULL, pay_type INT NOT NULL, pay_date_execution DATETIME DEFAULT NULL, offset_date DATETIME DEFAULT NULL, offset_reason INT DEFAULT NULL, proposed_date DATETIME DEFAULT NULL, ship_date DATETIME DEFAULT NULL, tracking_number VARCHAR(50) DEFAULT NULL, manager_name VARCHAR(20) DEFAULT NULL, manager_email VARCHAR(30) DEFAULT NULL, manager_phone VARCHAR(20) DEFAULT NULL, carrier_name VARCHAR(50) DEFAULT NULL, carrier_contact_data VARCHAR(255) DEFAULT NULL, locale VARCHAR(5) NOT NULL, cur_rate DOUBLE PRECISION DEFAULT \'1\', currency VARCHAR(3) DEFAULT \'EUR\' NOT NULL, measure VARCHAR(3) DEFAULT \'m\' NOT NULL, name VARCHAR(200) NOT NULL, description VARCHAR(1000) DEFAULT NULL, create_date DATETIME NOT NULL, update_date DATETIME DEFAULT NULL, warehouse_data JSON DEFAULT NULL, step INT DEFAULT 1 NOT NULL, address_equal TINYINT(1) DEFAULT 1, bank_transfer_requested TINYINT(1) DEFAULT NULL, accept_pay TINYINT(1) DEFAULT NULL, cancel_date DATETIME DEFAULT NULL, weight_gross DOUBLE PRECISION DEFAULT NULL, product_review TINYINT(1) DEFAULT NULL, mirror INT DEFAULT NULL, process TINYINT(1) DEFAULT NULL, fact_date DATETIME DEFAULT NULL, entrance_review INT DEFAULT NULL, payment_euro TINYINT(1) DEFAULT 0, spec_price TINYINT(1) DEFAULT NULL, show_msg TINYINT(1) DEFAULT NULL, delivery_price_euro DOUBLE PRECISION DEFAULT NULL, address_payer INT DEFAULT NULL, sending_date DATETIME DEFAULT NULL, delivery_calculate_type INT DEFAULT 0, full_payment_date DATE DEFAULT NULL, bank_details JSON DEFAULT NULL, delivery_apartment_office VARCHAR(30) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE orders_article (id INT AUTO_INCREMENT NOT NULL, orders_id INT NOT NULL, article_id INT DEFAULT NULL, amount DOUBLE PRECISION NOT NULL, price DOUBLE PRECISION NOT NULL, price_eur DOUBLE PRECISION DEFAULT NULL, currency VARCHAR(3) DEFAULT NULL, measure VARCHAR(2) DEFAULT NULL, delivery_time_min DATE DEFAULT NULL, delivery_time_max DATE DEFAULT NULL, weight DOUBLE PRECISION NOT NULL, multiple_pallet INT DEFAULT NULL, packaging_count DOUBLE PRECISION NOT NULL, pallet DOUBLE PRECISION NOT NULL, packaging DOUBLE PRECISION NOT NULL, swimming_pool TINYINT(1) DEFAULT 0 NOT NULL, INDEX IDX_F34F7C1DCFFE9AD6 (orders_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE orders_article ADD CONSTRAINT FK_F34F7C1DCFFE9AD6 FOREIGN KEY (orders_id) REFERENCES orders (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE orders_article DROP FOREIGN KEY FK_F34F7C1DCFFE9AD6');
        $this->addSql('DROP TABLE orders');
        $this->addSql('DROP TABLE orders_article');
    }
}
