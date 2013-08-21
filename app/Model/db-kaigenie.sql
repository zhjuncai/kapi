SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='TRADITIONAL,ALLOW_INVALID_DATES';

DROP SCHEMA IF EXISTS `kaigenie` ;
CREATE SCHEMA IF NOT EXISTS `kaigenie` DEFAULT CHARACTER SET utf8 ;
USE `kaigenie` ;

-- -----------------------------------------------------
-- Table `kaigenie`.`accounts`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `kaigenie`.`accounts` ;

CREATE  TABLE IF NOT EXISTS `kaigenie`.`accounts` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `name` VARCHAR(200) NULL COMMENT 'Business Name' ,
  `description` VARCHAR(4000) NULL ,
  `level` INT NOT NULL COMMENT 'identify account as basic or premium?' ,
  `openTo` TIME NULL ,
  `level_name` VARCHAR(50) NULL ,
  `type` INT NOT NULL ,
  `type_name` VARCHAR(50) NULL ,
  `country` VARCHAR(50) NULL ,
  `state` VARCHAR(45) NULL ,
  `city` VARCHAR(100) NULL ,
  `suburb` VARCHAR(100) NULL ,
  `zipcode` VARCHAR(10) NULL ,
  `street` VARCHAR(200) NULL COMMENT 'Address' ,
  `telephone` VARCHAR(20) NULL ,
  `mobile_num` VARCHAR(20) NULL ,
  `mobile_num2` VARCHAR(20) NULL ,
  `fax` VARCHAR(20) NULL ,
  `email` VARCHAR(100) NULL ,
  `website` VARCHAR(50) NULL ,
  `geolat` FLOAT NULL ,
  `geolng` FLOAT NULL ,
  `avg_spending` INT NULL ,
  `seat_num` INT NULL ,
  `biz_hour_from` TIME NULL ,
  `biz_hour_to` TIME NULL ,
  `enabled` boolean NULL COMMENT 'Status (Enable/Disable)' ,
  `note` TEXT NULL ,
  `created` DATETIME NULL COMMENT 'Creation Date' ,
  `modified` DATETIME NULL ,
  `biz_day_from` VARCHAR(20) NULL ,
  `biz_day_to` VARCHAR(20) NULL ,
  `expire_date` DATETIME NULL ,
  `open_hour` VARCHAR(100) NULL COMMENT 'open hour text for display' ,
  `allow_review` boolean NULL DEFAULT 1 COMMENT 'is account allow user to comment? switch' ,
  PRIMARY KEY (`id`) )
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `kaigenie`.`categories`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `kaigenie`.`categories` ;

CREATE  TABLE IF NOT EXISTS `kaigenie`.`categories` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `name` VARCHAR(45) NOT NULL COMMENT 'Category Name' ,
  `description` VARCHAR(500) NULL COMMENT 'Category Description' ,
  `created` DATETIME NULL ,
  `modified` DATETIME NULL ,
  `enabled` boolean NULL ,
  `deleted` boolean NULL ,
  PRIMARY KEY (`id`) ,
  UNIQUE INDEX `catName_UNIQUE` (`name` ASC) )
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `kaigenie`.`groups`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `kaigenie`.`groups` ;

CREATE  TABLE IF NOT EXISTS `kaigenie`.`groups` (
  `id` INT NOT NULL COMMENT 'only three type of user: Admin (Internal Admin), Account Admin(External Admin), Member' ,
  `name` VARCHAR(45) NOT NULL ,
  `description` VARCHAR(45) NULL ,
  `created` DATETIME NULL ,
  `modified` DATETIME NULL ,
  PRIMARY KEY (`id`) )
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `kaigenie`.`users`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `kaigenie`.`users` ;

CREATE  TABLE IF NOT EXISTS `kaigenie`.`users` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `group_id` INT NOT NULL COMMENT 'Internal Admin, External Admin, Normal User' ,
  `username` VARCHAR(45) NULL ,
  `password` VARCHAR(45) NOT NULL ,
  `email` VARCHAR(45) NOT NULL ,
  `slave_email` VARCHAR(45) NULL COMMENT 'for emergency use, for example user forgot the email password' ,
  `first_name` VARCHAR(45) NULL ,
  `last_name` VARCHAR(45) NULL ,
  `confirm_code` VARCHAR(45) NULL ,
  `last_login` DATETIME NULL ,
  `created` DATETIME NULL ,
  `modified` DATETIME NULL ,
  `is_active` boolean NULL COMMENT 'is user active or not' ,
  `is_delete` boolean NULL COMMENT 'deleted user' ,
  `total_point` INT NULL ,
  PRIMARY KEY (`id`) ,
  UNIQUE INDEX `email_UNIQUE` (`email` ASC) ,
  INDEX `fk_Users_Group1_idx` (`group_id` ASC) ,
  CONSTRAINT `fk_Users_Group1`
    FOREIGN KEY (`group_id` )
    REFERENCES `kaigenie`.`groups` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `kaigenie`.`reviews`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `kaigenie`.`reviews` ;

CREATE  TABLE IF NOT EXISTS `kaigenie`.`reviews` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `account_id` INT NOT NULL ,
  `user_id` INT NOT NULL ,
  `comment` VARCHAR(4000) NOT NULL ,
  `status` CHAR(2) NULL COMMENT 'pending, approved, spam' ,
  `gene_rating` INT NULL COMMENT 'general rating' ,
  `service_rating` INT NULL ,
  `envi_rating` INT NULL ,
  `food_rating` INT NULL ,
  `suggest_item` VARCHAR(500) NULL COMMENT 'use comma seperate menu item id holding user suggest food item' ,
  `created` DATETIME NULL ,
  `modified` DATETIME NULL ,
  `modifiedBy` INT NULL ,
  `note` VARCHAR(500) NULL COMMENT 'comments that why it should be rejected' ,
  PRIMARY KEY (`id`) ,
  INDEX `fk_Reviews_Accounts1_idx` (`account_id` ASC) ,
  INDEX `fk_Reviews_Users1_idx` (`user_id` ASC) ,
  CONSTRAINT `fk_Reviews_Accounts1`
    FOREIGN KEY (`account_id` )
    REFERENCES `kaigenie`.`accounts` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_Reviews_Users1`
    FOREIGN KEY (`user_id` )
    REFERENCES `kaigenie`.`users` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `kaigenie`.`coupons`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `kaigenie`.`coupons` ;

CREATE  TABLE IF NOT EXISTS `kaigenie`.`coupons` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `account_id` INT NOT NULL ,
  `name` VARCHAR(45) NULL ,
  `description` TEXT NULL ,
  `start_date` DATETIME NULL ,
  `end_date` DATETIME NULL ,
  `offer_detail` VARCHAR(255) NULL ,
  `term` TEXT NULL ,
  `saving` VARCHAR(45) NULL ,
  `status` boolean NULL ,
  `created` DATETIME NULL ,
  `createdby` VARCHAR(45) NULL ,
  `modified` DATETIME NULL ,
  `modifiedby` VARCHAR(45) NULL ,
  PRIMARY KEY (`id`) ,
  INDEX `fk_Coupons_Accounts1_idx` (`account_id` ASC) ,
  CONSTRAINT `fk_Coupons_Accounts1`
    FOREIGN KEY (`account_id` )
    REFERENCES `kaigenie`.`accounts` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `kaigenie`.`orders`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `kaigenie`.`orders` ;

CREATE  TABLE IF NOT EXISTS `kaigenie`.`orders` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `code` VARCHAR(45) NULL ,
  `date` TIMESTAMP NULL ,
  `status` VARCHAR(45) NULL ,
  `coupon_id` INT NOT NULL ,
  `user_id` INT NOT NULL ,
  `used_date` DATETIME NULL ,
  `Orderscol` VARCHAR(45) NULL ,
  PRIMARY KEY (`id`) ,
  INDEX `fk_Orders_Coupons1_idx` (`coupon_id` ASC) ,
  INDEX `fk_Orders_User_idx` (`user_id` ASC) ,
  CONSTRAINT `fk_Orders_Coupons1`
    FOREIGN KEY (`coupon_id` )
    REFERENCES `kaigenie`.`coupons` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_Orders_User`
    FOREIGN KEY (`user_id` )
    REFERENCES `kaigenie`.`users` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `kaigenie`.`menus`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `kaigenie`.`menus` ;

CREATE  TABLE IF NOT EXISTS `kaigenie`.`menus` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `account_id` INT NOT NULL ,
  `name` VARCHAR(45) NULL ,
  `description` VARCHAR(500) NULL ,
  `type` VARCHAR(45) NULL ,
  `created` DATETIME NULL ,
  `modified` DATETIME NULL ,
  `is_published` boolean NULL COMMENT 'Menu was created' ,
  PRIMARY KEY (`id`) ,
  INDEX `fk_Menus_Accounts1_idx` (`account_id` ASC) ,
  CONSTRAINT `fk_Menus_Accounts1`
    FOREIGN KEY (`account_id` )
    REFERENCES `kaigenie`.`accounts` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `kaigenie`.`menuitem`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `kaigenie`.`menuitem` ;

CREATE  TABLE IF NOT EXISTS `kaigenie`.`menuitem` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `menu_id` INT NOT NULL ,
  `name` VARCHAR(45) NULL ,
  `description` VARCHAR(255) NULL ,
  `price` FLOAT NULL ,
  `valid_from` DATE NULL ,
  `valid_to` DATE NULL ,
  `is_recommend` boolean NULL ,
  `created` DATETIME NULL ,
  `modified` DATETIME NULL ,
  `currency` CHAR(3) NULL ,
  `symbol` CHAR(2) NULL ,
  PRIMARY KEY (`id`) ,
  INDEX `fk_MenuItem_Menus1_idx` (`menu_id` ASC) ,
  CONSTRAINT `fk_MenuItem_Menus1`
    FOREIGN KEY (`menu_id` )
    REFERENCES `kaigenie`.`menus` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `kaigenie`.`account_categories`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `kaigenie`.`account_categories` ;

CREATE  TABLE IF NOT EXISTS `kaigenie`.`account_categories` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `account_id` INT NOT NULL ,
  `category_id` INT NOT NULL ,
  `created` DATETIME NULL ,
  `createdBy` DATETIME NULL ,
  `deleted` boolean NULL DEFAULT 0 ,
  INDEX `fk_Accounts_has_Categoiries_Categoiries1_idx` (`category_id` ASC) ,
  INDEX `fk_Accounts_has_Categoiries_Accounts1_idx` (`account_id` ASC) ,
  PRIMARY KEY (`id`) ,
  CONSTRAINT `fk_Accounts_has_Categoiries_Accounts1`
    FOREIGN KEY (`account_id` )
    REFERENCES `kaigenie`.`accounts` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_Accounts_has_Categoiries_Categoiries1`
    FOREIGN KEY (`category_id` )
    REFERENCES `kaigenie`.`categories` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `kaigenie`.`registration`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `kaigenie`.`registration` ;

CREATE  TABLE IF NOT EXISTS `kaigenie`.`registration` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `user_id` INT NOT NULL ,
  `registration_key` VARCHAR(45) NULL ,
  `expire_date` DATETIME NULL ,
  `confirm_date` DATETIME NULL COMMENT 'user finished/activate the registration' ,
  `is_send` boolean NULL COMMENT 'is registration email was sent?' ,
  `created` DATETIME NULL ,
  `modified` DATETIME NULL ,
  PRIMARY KEY (`id`) ,
  UNIQUE INDEX `registration_key_UNIQUE` (`registration_key` ASC) ,
  INDEX `fk_UserProfile_Users1_idx` (`user_id` ASC) ,
  CONSTRAINT `fk_UserProfile_Users1`
    FOREIGN KEY (`user_id` )
    REFERENCES `kaigenie`.`users` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `kaigenie`.`address`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `kaigenie`.`address` ;

CREATE  TABLE IF NOT EXISTS `kaigenie`.`address` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `user_id` INT NOT NULL ,
  `name` VARCHAR(45) NULL ,
  `country` VARCHAR(45) NULL ,
  `state` VARCHAR(45) NULL ,
  `city` VARCHAR(45) NULL ,
  `street` VARCHAR(45) NULL ,
  PRIMARY KEY (`id`) ,
  INDEX `fk_Address_Users1_idx` (`user_id` ASC) ,
  CONSTRAINT `fk_Address_Users1`
    FOREIGN KEY (`user_id` )
    REFERENCES `kaigenie`.`users` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `kaigenie`.`features`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `kaigenie`.`features` ;

CREATE  TABLE IF NOT EXISTS `kaigenie`.`features` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `name` VARCHAR(45) NULL ,
  `description` VARCHAR(45) NULL ,
  `enabled` boolean NULL DEFAULT 1 ,
  `modified` DATETIME NULL ,
  `created` DATETIME NULL ,
  `is_deleted` boolean NULL DEFAULT 0 ,
  PRIMARY KEY (`id`) )
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `kaigenie`.`paymethods`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `kaigenie`.`paymethods` ;

CREATE  TABLE IF NOT EXISTS `kaigenie`.`paymethods` (
  `ID` INT NOT NULL AUTO_INCREMENT ,
  `pay_name` VARCHAR(45) NULL ,
  `pay_desc` VARCHAR(500) NULL ,
  PRIMARY KEY (`ID`) )
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `kaigenie`.`account_features`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `kaigenie`.`account_features` ;

CREATE  TABLE IF NOT EXISTS `kaigenie`.`account_features` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `account_id` INT NOT NULL ,
  `feature_id` INT NOT NULL ,
  `created` DATETIME NULL ,
  `modified` DATETIME NULL ,
  `updatedby` VARCHAR(45) NULL ,
  INDEX `fk_Accounts_has_Features_Features1_idx` (`feature_id` ASC) ,
  INDEX `fk_Accounts_has_Features_Accounts1_idx` (`account_id` ASC) ,
  PRIMARY KEY (`id`) ,
  CONSTRAINT `fk_Accounts_has_Features_Accounts1`
    FOREIGN KEY (`account_id` )
    REFERENCES `kaigenie`.`accounts` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_Accounts_has_Features_Features1`
    FOREIGN KEY (`feature_id` )
    REFERENCES `kaigenie`.`features` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `kaigenie`.`images`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `kaigenie`.`images` ;

CREATE  TABLE IF NOT EXISTS `kaigenie`.`images` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `name` VARCHAR(255) NULL ,
  `extension` VARCHAR(10) NULL ,
  `directory` VARCHAR(500) NULL ,
  `size` INT NULL ,
  `unique_name` VARCHAR(255) NULL ,
  `relative_path` VARCHAR(45) NULL COMMENT 'Relative path of web root' ,
  `mime_type` VARCHAR(10) NULL ,
  `created` DATETIME NULL ,
  `createdBy` VARCHAR(45) NULL ,
  `uploadBy` VARCHAR(45) NULL ,
  PRIMARY KEY (`id`) )
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `kaigenie`.`rewards`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `kaigenie`.`rewards` ;

CREATE  TABLE IF NOT EXISTS `kaigenie`.`rewards` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `user_id` INT NOT NULL ,
  `reason_id` VARCHAR(45) NULL COMMENT 'review_id or account_id' ,
  `reason` VARCHAR(200) NULL COMMENT 'reward from uploading picture or comments' ,
  `point` INT NULL COMMENT 'how many points user gets, depends on system setup.' ,
  `created` DATETIME NULL ,
  `modified` VARCHAR(45) NULL ,
  PRIMARY KEY (`id`) ,
  INDEX `fk_Rewards_Users1_idx` (`user_id` ASC) ,
  CONSTRAINT `fk_Rewards_Users1`
    FOREIGN KEY (`user_id` )
    REFERENCES `kaigenie`.`users` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `kaigenie`.`expenses`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `kaigenie`.`expenses` ;

CREATE  TABLE IF NOT EXISTS `kaigenie`.`expenses` (
  `ID` INT NOT NULL AUTO_INCREMENT ,
  `user_id` VARCHAR(45) NULL COMMENT 'comsumer' ,
  `point` INT NULL COMMENT 'total point was comsumed' ,
  `place` VARCHAR(45) NULL COMMENT 'consume place' ,
  `created` DATETIME NULL COMMENT 'when it happened' ,
  PRIMARY KEY (`ID`) ,
  CONSTRAINT `fk_expense_user_id`
    FOREIGN KEY (`ID` )
    REFERENCES `kaigenie`.`users` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `kaigenie`.`acos`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `kaigenie`.`acos` ;

CREATE  TABLE IF NOT EXISTS `kaigenie`.`acos` (
  `id` INT(10) NOT NULL AUTO_INCREMENT ,
  `parent_id` INT(10) NULL DEFAULT NULL ,
  `model` VARCHAR(255) NULL DEFAULT NULL ,
  `foreign_key` INT(10) NULL DEFAULT NULL ,
  `alias` VARCHAR(255) NULL DEFAULT NULL ,
  `lft` INT(10) NULL DEFAULT NULL ,
  `rght` INT(10) NULL DEFAULT NULL ,
  PRIMARY KEY (`id`) )
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `kaigenie`.`aros`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `kaigenie`.`aros` ;

CREATE  TABLE IF NOT EXISTS `kaigenie`.`aros` (
  `id` INT(10) NOT NULL AUTO_INCREMENT ,
  `parent_id` INT(10) NULL DEFAULT NULL ,
  `model` VARCHAR(255) NULL DEFAULT NULL ,
  `foreign_key` INT(10) NULL DEFAULT NULL ,
  `alias` VARCHAR(255) NULL DEFAULT NULL ,
  `lft` INT(10) NULL DEFAULT NULL ,
  `rght` INT(10) NULL DEFAULT NULL ,
  PRIMARY KEY (`id`) )
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `kaigenie`.`aros_acos`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `kaigenie`.`aros_acos` ;

CREATE  TABLE IF NOT EXISTS `kaigenie`.`aros_acos` (
  `id` INT(10) NOT NULL AUTO_INCREMENT ,
  `aro_id` INT(10) NOT NULL ,
  `aco_id` INT(10) NOT NULL ,
  `_create` VARCHAR(2) NOT NULL DEFAULT '0' ,
  `_read` VARCHAR(2) NOT NULL DEFAULT '0' ,
  `_update` VARCHAR(2) NOT NULL DEFAULT '0' ,
  `_delete` VARCHAR(2) NOT NULL DEFAULT '0' ,
  PRIMARY KEY (`id`) ,
  UNIQUE INDEX `ARO_ACO_KEY` (`aro_id` ASC, `aco_id` ASC) )
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `kaigenie`.`account_users`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `kaigenie`.`account_users` ;

CREATE  TABLE IF NOT EXISTS `kaigenie`.`account_users` (
  `ID` INT NOT NULL AUTO_INCREMENT ,
  `user_id` INT NOT NULL ,
  `account_id` INT NOT NULL ,
  `deleted` boolean NULL COMMENT 'is the user removed from the relationship' ,
  `expired_date` DATETIME NULL COMMENT 'User\'s manageship will expire at this day' ,
  `created` DATETIME NULL ,
  `modified` DATETIME NULL ,
  PRIMARY KEY (`ID`) ,
  INDEX `fk_accounts_users_user_id_idx` (`user_id` ASC) ,
  INDEX `fk_accounts_users_account_id_idx` (`account_id` ASC) ,
  CONSTRAINT `fk_accounts_users_user_id`
    FOREIGN KEY (`user_id` )
    REFERENCES `kaigenie`.`users` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_accounts_users_account_id`
    FOREIGN KEY (`account_id` )
    REFERENCES `kaigenie`.`accounts` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `kaigenie`.`account_images`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `kaigenie`.`account_images` ;

CREATE  TABLE IF NOT EXISTS `kaigenie`.`account_images` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `account_id` INT NOT NULL ,
  `image_id` INT NOT NULL ,
  `created` DATETIME NULL ,
  `modified` DATETIME NULL ,
  `primary` boolean NULL COMMENT 'primary image display as account portrait' ,
  PRIMARY KEY (`id`) ,
  INDEX `fk_account_images_account_id_idx` (`account_id` ASC) ,
  INDEX `fk_account_images_image_id_idx` (`image_id` ASC) ,
  CONSTRAINT `fk_account_images_account_id`
    FOREIGN KEY (`account_id` )
    REFERENCES `kaigenie`.`accounts` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_account_images_image_id`
    FOREIGN KEY (`image_id` )
    REFERENCES `kaigenie`.`images` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `kaigenie`.`menuitem_images`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `kaigenie`.`menuitem_images` ;

CREATE  TABLE IF NOT EXISTS `kaigenie`.`menuitem_images` (
  `id` INT NOT NULL AUTO_INCREMENT COMMENT 'one menu item could have multiple images attached, and only primary image will show on menu item list' ,
  `item_id` INT NOT NULL ,
  `image_id` INT NOT NULL ,
  `created` DATETIME NULL ,
  `modified` DATETIME NULL ,
  `is_primary` boolean NULL COMMENT 'show in menu item' ,
  PRIMARY KEY (`id`) ,
  INDEX `fk_item_images_image_id_idx` (`image_id` ASC) ,
  INDEX `fk_item_images_item_id_idx` (`item_id` ASC) ,
  CONSTRAINT `fk_item_images_image_id`
    FOREIGN KEY (`image_id` )
    REFERENCES `kaigenie`.`images` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_item_images_item_id`
    FOREIGN KEY (`item_id` )
    REFERENCES `kaigenie`.`menuitem` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `kaigenie`.`review_images`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `kaigenie`.`review_images` ;

CREATE  TABLE IF NOT EXISTS `kaigenie`.`review_images` (
  `id` INT NOT NULL AUTO_INCREMENT COMMENT 'one review could attach multiple images, but one image only belong to one review' ,
  `review_id` INT NOT NULL ,
  `image_id` INT NOT NULL ,
  `created` DATETIME NULL ,
  `updated` DATETIME NULL ,
  `is_deleted` boolean NULL ,
  PRIMARY KEY (`id`) ,
  INDEX `fk_review_images_review_id_idx` (`review_id` ASC) ,
  INDEX `fk_review_images_image_id_idx` (`image_id` ASC) ,
  CONSTRAINT `fk_review_images_review_id`
    FOREIGN KEY (`review_id` )
    REFERENCES `kaigenie`.`reviews` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_review_images_image_id`
    FOREIGN KEY (`image_id` )
    REFERENCES `kaigenie`.`images` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `kaigenie`.`login_tokens`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `kaigenie`.`login_tokens` ;

CREATE  TABLE IF NOT EXISTS `kaigenie`.`login_tokens` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `user_id` INT NOT NULL ,
  `token` CHAR(32) NOT NULL ,
  `duration` VARCHAR(32) NOT NULL ,
  `used` TINYINT NOT NULL ,
  `created` DATETIME NOT NULL ,
  `expired` DATETIME NOT NULL ,
  PRIMARY KEY (`id`) ,
  INDEX `idx_login_tokens_user_id` USING BTREE (`user_id` ASC) ,
  INDEX `idx_login_tokens_duration` (`token` ASC) ,
  INDEX `idx_login_tokens_expired` (`expired` ASC) ,
  CONSTRAINT `fk_login_tokens_user_id`
    FOREIGN KEY (`user_id` )
    REFERENCES `kaigenie`.`users` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;

USE `kaigenie` ;


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
