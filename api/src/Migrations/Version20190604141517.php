<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190604141517 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf('mysql' !== $this->connection->getDatabasePlatform()->getName(), 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE fuel_transaction (id INT AUTO_INCREMENT NOT NULL, user_id INT DEFAULT NULL, point_of_service_id INT DEFAULT NULL, fuel_pump_id INT DEFAULT NULL, fuel_product_id INT DEFAULT NULL, guid CHAR(36) NOT NULL COMMENT \'(DC2Type:guid)\', external_id CHAR(36) NOT NULL COMMENT \'(DC2Type:guid)\', created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, INDEX IDX_78D838B0A76ED395 (user_id), INDEX IDX_78D838B04E2142CB (point_of_service_id), INDEX IDX_78D838B0164AEEC3 (fuel_pump_id), INDEX IDX_78D838B0AA1720D4 (fuel_product_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE local_card (id INT AUTO_INCREMENT NOT NULL, user_id INT DEFAULT NULL, external_id CHAR(36) DEFAULT NULL COMMENT \'(DC2Type:guid)\', card_number VARCHAR(255) NOT NULL, pan VARCHAR(255) NOT NULL, state INT NOT NULL, status VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, INDEX IDX_2A0BF200A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE organization (id INT AUTO_INCREMENT NOT NULL, fo_api_code VARCHAR(255) NOT NULL, name VARCHAR(255) NOT NULL, client_id VARCHAR(255) NOT NULL, user_client_id VARCHAR(255) NOT NULL, grant_type VARCHAR(255) NOT NULL, client_secret VARCHAR(255) NOT NULL, payment_type VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, UNIQUE INDEX UNIQ_C1EE637C6D21A5CF (fo_api_code), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE organization_domain (organization_id INT NOT NULL, domain_id INT NOT NULL, INDEX IDX_A227CEFE32C8A3DE (organization_id), INDEX IDX_A227CEFE115F0EE5 (domain_id), PRIMARY KEY(organization_id, domain_id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE portal_user (id INT AUTO_INCREMENT NOT NULL, organization_id INT DEFAULT NULL, username VARCHAR(180) NOT NULL, roles LONGTEXT NOT NULL COMMENT \'(DC2Type:array)\', password VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, UNIQUE INDEX UNIQ_76511E4F85E0677 (username), INDEX IDX_76511E432C8A3DE (organization_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE domain (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE domain_organization (domain_id INT NOT NULL, organization_id INT NOT NULL, INDEX IDX_58E115F1115F0EE5 (domain_id), INDEX IDX_58E115F132C8A3DE (organization_id), PRIMARY KEY(domain_id, organization_id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE fuel_pump (id INT AUTO_INCREMENT NOT NULL, point_of_service_id INT DEFAULT NULL, pump_number INT NOT NULL, available TINYINT(1) NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, INDEX IDX_8868E9FC4E2142CB (point_of_service_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE fuel_product (id INT AUTO_INCREMENT NOT NULL, fuel_pump_id INT DEFAULT NULL, product_type VARCHAR(255) NOT NULL, product_code VARCHAR(255) NOT NULL, description VARCHAR(255) NOT NULL, last_known_unit_price DOUBLE PRECISION NOT NULL, last_known_unit_price_update DATETIME DEFAULT NULL, available TINYINT(1) NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, INDEX IDX_7C76760B164AEEC3 (fuel_pump_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE fuel_transaction_receipt (id INT AUTO_INCREMENT NOT NULL, fuel_transaction_id INT DEFAULT NULL, external_id CHAR(36) NOT NULL COMMENT \'(DC2Type:guid)\', payment_type VARCHAR(255) NOT NULL, product_type VARCHAR(255) NOT NULL, product_code INT NOT NULL, product_description VARCHAR(255) NOT NULL, amount NUMERIC(10, 2) NOT NULL, vat_amount NUMERIC(10, 2) NOT NULL, tax_percentage INT NOT NULL, currency VARCHAR(255) NOT NULL, quantity INT NOT NULL, unit_price NUMERIC(10, 3) NOT NULL, unit_of_measure VARCHAR(255) NOT NULL, receipt_text_lines LONGTEXT NOT NULL COMMENT \'(DC2Type:array)\', created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, INDEX IDX_5D645FE63C88DD45 (fuel_transaction_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE address (id INT AUTO_INCREMENT NOT NULL, address_line1 VARCHAR(255) NOT NULL, address_line2 VARCHAR(255) DEFAULT NULL, zip_code VARCHAR(255) NOT NULL, city VARCHAR(255) NOT NULL, latitude NUMERIC(10, 8) NOT NULL, longitude NUMERIC(11, 8) NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE app_user (id INT AUTO_INCREMENT NOT NULL, organization_id INT NOT NULL, email VARCHAR(180) NOT NULL, roles LONGTEXT NOT NULL COMMENT \'(DC2Type:array)\', password VARCHAR(255) NOT NULL, phone_number VARCHAR(255) DEFAULT NULL, external_id CHAR(36) DEFAULT NULL COMMENT \'(DC2Type:guid)\', client_id VARCHAR(255) DEFAULT NULL, refresh_token VARCHAR(255) DEFAULT NULL, state INT NOT NULL, activated TINYINT(1) NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, UNIQUE INDEX UNIQ_88BDF3E9E7927C74 (email), UNIQUE INDEX UNIQ_88BDF3E96B01BC5B (phone_number), UNIQUE INDEX UNIQ_88BDF3E99F75D7B0 (external_id), INDEX IDX_88BDF3E932C8A3DE (organization_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE point_of_service (id INT AUTO_INCREMENT NOT NULL, organization_id INT NOT NULL, address_id INT DEFAULT NULL, external_id INT NOT NULL, detail_id INT NOT NULL, name VARCHAR(255) NOT NULL, distance INT NOT NULL, type VARCHAR(255) NOT NULL, online DATETIME DEFAULT NULL, offline DATETIME DEFAULT NULL, available TINYINT(1) NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, INDEX IDX_C09D48C932C8A3DE (organization_id), UNIQUE INDEX UNIQ_C09D48C9F5B7AF75 (address_id), UNIQUE INDEX point_of_service_idx (external_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE refresh_tokens (id INT AUTO_INCREMENT NOT NULL, refresh_token VARCHAR(128) NOT NULL, username VARCHAR(255) NOT NULL, valid DATETIME NOT NULL, UNIQUE INDEX UNIQ_9BACE7E1C74F2195 (refresh_token), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE jms_cron_jobs (id INT UNSIGNED AUTO_INCREMENT NOT NULL, command VARCHAR(200) NOT NULL, lastRunAt DATETIME NOT NULL, UNIQUE INDEX UNIQ_55F5ED428ECAEAD4 (command), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE jms_jobs (id BIGINT UNSIGNED AUTO_INCREMENT NOT NULL, state VARCHAR(15) NOT NULL, queue VARCHAR(50) NOT NULL, priority SMALLINT NOT NULL, createdAt DATETIME NOT NULL, startedAt DATETIME DEFAULT NULL, checkedAt DATETIME DEFAULT NULL, workerName VARCHAR(50) DEFAULT NULL, executeAfter DATETIME DEFAULT NULL, closedAt DATETIME DEFAULT NULL, command VARCHAR(255) NOT NULL, args LONGTEXT NOT NULL COMMENT \'(DC2Type:json_array)\', output LONGTEXT DEFAULT NULL, errorOutput LONGTEXT DEFAULT NULL, exitCode SMALLINT UNSIGNED DEFAULT NULL, maxRuntime SMALLINT UNSIGNED NOT NULL, maxRetries SMALLINT UNSIGNED NOT NULL, stackTrace LONGBLOB DEFAULT NULL COMMENT \'(DC2Type:jms_job_safe_object)\', runtime SMALLINT UNSIGNED DEFAULT NULL, memoryUsage INT UNSIGNED DEFAULT NULL, memoryUsageReal INT UNSIGNED DEFAULT NULL, originalJob_id BIGINT UNSIGNED DEFAULT NULL, INDEX IDX_704ADB9349C447F1 (originalJob_id), INDEX cmd_search_index (command), INDEX sorting_index (state, priority, id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE jms_job_dependencies (source_job_id BIGINT UNSIGNED NOT NULL, dest_job_id BIGINT UNSIGNED NOT NULL, INDEX IDX_8DCFE92CBD1F6B4F (source_job_id), INDEX IDX_8DCFE92C32CF8D4C (dest_job_id), PRIMARY KEY(source_job_id, dest_job_id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE jms_job_related_entities (job_id BIGINT UNSIGNED NOT NULL, related_class VARCHAR(150) NOT NULL, related_id VARCHAR(100) NOT NULL, INDEX IDX_E956F4E2BE04EA9 (job_id), PRIMARY KEY(job_id, related_class, related_id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE jms_job_statistics (job_id BIGINT UNSIGNED NOT NULL, characteristic VARCHAR(30) NOT NULL, createdAt DATETIME NOT NULL, charValue DOUBLE PRECISION NOT NULL, PRIMARY KEY(job_id, characteristic, createdAt)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE fuel_transaction ADD CONSTRAINT FK_78D838B0A76ED395 FOREIGN KEY (user_id) REFERENCES app_user (id)');
        $this->addSql('ALTER TABLE fuel_transaction ADD CONSTRAINT FK_78D838B04E2142CB FOREIGN KEY (point_of_service_id) REFERENCES point_of_service (id)');
        $this->addSql('ALTER TABLE fuel_transaction ADD CONSTRAINT FK_78D838B0164AEEC3 FOREIGN KEY (fuel_pump_id) REFERENCES fuel_pump (id)');
        $this->addSql('ALTER TABLE fuel_transaction ADD CONSTRAINT FK_78D838B0AA1720D4 FOREIGN KEY (fuel_product_id) REFERENCES fuel_product (id)');
        $this->addSql('ALTER TABLE local_card ADD CONSTRAINT FK_2A0BF200A76ED395 FOREIGN KEY (user_id) REFERENCES app_user (id)');
        $this->addSql('ALTER TABLE organization_domain ADD CONSTRAINT FK_A227CEFE32C8A3DE FOREIGN KEY (organization_id) REFERENCES organization (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE organization_domain ADD CONSTRAINT FK_A227CEFE115F0EE5 FOREIGN KEY (domain_id) REFERENCES domain (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE portal_user ADD CONSTRAINT FK_76511E432C8A3DE FOREIGN KEY (organization_id) REFERENCES organization (id)');
        $this->addSql('ALTER TABLE domain_organization ADD CONSTRAINT FK_58E115F1115F0EE5 FOREIGN KEY (domain_id) REFERENCES domain (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE domain_organization ADD CONSTRAINT FK_58E115F132C8A3DE FOREIGN KEY (organization_id) REFERENCES organization (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE fuel_pump ADD CONSTRAINT FK_8868E9FC4E2142CB FOREIGN KEY (point_of_service_id) REFERENCES point_of_service (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE fuel_product ADD CONSTRAINT FK_7C76760B164AEEC3 FOREIGN KEY (fuel_pump_id) REFERENCES fuel_pump (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE fuel_transaction_receipt ADD CONSTRAINT FK_5D645FE63C88DD45 FOREIGN KEY (fuel_transaction_id) REFERENCES fuel_transaction (id)');
        $this->addSql('ALTER TABLE app_user ADD CONSTRAINT FK_88BDF3E932C8A3DE FOREIGN KEY (organization_id) REFERENCES organization (id)');
        $this->addSql('ALTER TABLE point_of_service ADD CONSTRAINT FK_C09D48C932C8A3DE FOREIGN KEY (organization_id) REFERENCES organization (id)');
        $this->addSql('ALTER TABLE point_of_service ADD CONSTRAINT FK_C09D48C9F5B7AF75 FOREIGN KEY (address_id) REFERENCES address (id)');
        $this->addSql('ALTER TABLE jms_jobs ADD CONSTRAINT FK_704ADB9349C447F1 FOREIGN KEY (originalJob_id) REFERENCES jms_jobs (id)');
        $this->addSql('ALTER TABLE jms_job_dependencies ADD CONSTRAINT FK_8DCFE92CBD1F6B4F FOREIGN KEY (source_job_id) REFERENCES jms_jobs (id)');
        $this->addSql('ALTER TABLE jms_job_dependencies ADD CONSTRAINT FK_8DCFE92C32CF8D4C FOREIGN KEY (dest_job_id) REFERENCES jms_jobs (id)');
        $this->addSql('ALTER TABLE jms_job_related_entities ADD CONSTRAINT FK_E956F4E2BE04EA9 FOREIGN KEY (job_id) REFERENCES jms_jobs (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf('mysql' !== $this->connection->getDatabasePlatform()->getName(), 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE fuel_transaction_receipt DROP FOREIGN KEY FK_5D645FE63C88DD45');
        $this->addSql('ALTER TABLE organization_domain DROP FOREIGN KEY FK_A227CEFE32C8A3DE');
        $this->addSql('ALTER TABLE portal_user DROP FOREIGN KEY FK_76511E432C8A3DE');
        $this->addSql('ALTER TABLE domain_organization DROP FOREIGN KEY FK_58E115F132C8A3DE');
        $this->addSql('ALTER TABLE app_user DROP FOREIGN KEY FK_88BDF3E932C8A3DE');
        $this->addSql('ALTER TABLE point_of_service DROP FOREIGN KEY FK_C09D48C932C8A3DE');
        $this->addSql('ALTER TABLE organization_domain DROP FOREIGN KEY FK_A227CEFE115F0EE5');
        $this->addSql('ALTER TABLE domain_organization DROP FOREIGN KEY FK_58E115F1115F0EE5');
        $this->addSql('ALTER TABLE fuel_transaction DROP FOREIGN KEY FK_78D838B0164AEEC3');
        $this->addSql('ALTER TABLE fuel_product DROP FOREIGN KEY FK_7C76760B164AEEC3');
        $this->addSql('ALTER TABLE fuel_transaction DROP FOREIGN KEY FK_78D838B0AA1720D4');
        $this->addSql('ALTER TABLE point_of_service DROP FOREIGN KEY FK_C09D48C9F5B7AF75');
        $this->addSql('ALTER TABLE fuel_transaction DROP FOREIGN KEY FK_78D838B0A76ED395');
        $this->addSql('ALTER TABLE local_card DROP FOREIGN KEY FK_2A0BF200A76ED395');
        $this->addSql('ALTER TABLE fuel_transaction DROP FOREIGN KEY FK_78D838B04E2142CB');
        $this->addSql('ALTER TABLE fuel_pump DROP FOREIGN KEY FK_8868E9FC4E2142CB');
        $this->addSql('ALTER TABLE jms_jobs DROP FOREIGN KEY FK_704ADB9349C447F1');
        $this->addSql('ALTER TABLE jms_job_dependencies DROP FOREIGN KEY FK_8DCFE92CBD1F6B4F');
        $this->addSql('ALTER TABLE jms_job_dependencies DROP FOREIGN KEY FK_8DCFE92C32CF8D4C');
        $this->addSql('ALTER TABLE jms_job_related_entities DROP FOREIGN KEY FK_E956F4E2BE04EA9');
        $this->addSql('DROP TABLE fuel_transaction');
        $this->addSql('DROP TABLE local_card');
        $this->addSql('DROP TABLE organization');
        $this->addSql('DROP TABLE organization_domain');
        $this->addSql('DROP TABLE portal_user');
        $this->addSql('DROP TABLE domain');
        $this->addSql('DROP TABLE domain_organization');
        $this->addSql('DROP TABLE fuel_pump');
        $this->addSql('DROP TABLE fuel_product');
        $this->addSql('DROP TABLE fuel_transaction_receipt');
        $this->addSql('DROP TABLE address');
        $this->addSql('DROP TABLE app_user');
        $this->addSql('DROP TABLE point_of_service');
        $this->addSql('DROP TABLE refresh_tokens');
        $this->addSql('DROP TABLE jms_cron_jobs');
        $this->addSql('DROP TABLE jms_jobs');
        $this->addSql('DROP TABLE jms_job_dependencies');
        $this->addSql('DROP TABLE jms_job_related_entities');
        $this->addSql('DROP TABLE jms_job_statistics');
    }
}
