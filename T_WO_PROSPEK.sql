/*
 Navicat Premium Data Transfer

 Source Server         : NIAGA_DEV
 Source Server Type    : Oracle
 Source Server Version : 110200
 Source Host           : localhost:1521
 Source Schema         : NIAGA_DEV

 Target Server Type    : Oracle
 Target Server Version : 110200
 File Encoding         : 65001

 Date: 25/08/2020 18:08:46
*/


-- ----------------------------
-- Table structure for T_WO_PROSPEK
-- ----------------------------
DROP TABLE "NIAGA_DEV"."T_WO_PROSPEK";
CREATE TABLE "NIAGA_DEV"."T_WO_PROSPEK" (
  "ID_WO" NUMBER NOT NULL ,
  "KODE_WO" VARCHAR2(20 BYTE) ,
  "ID_CUSTOMER" NUMBER ,
  "NAMA" VARCHAR2(2000 BYTE) ,
  "JENIS" NUMBER ,
  "JENIS_RKAP" NUMBER ,
  "DESKRIPSI" VARCHAR2(4000 BYTE) ,
  "JENIS_NIAGA" NUMBER ,
  "NILAI" NUMBER ,
  "TANGGAL" DATE ,
  "PIC_ID" VARCHAR2(100 BYTE) ,
  "STATUS" NUMBER ,
  "USER_STATUS" VARCHAR2(100 BYTE) ,
  "WORK_ORDER_TYPE" VARCHAR2(100 BYTE) ,
  "MAINTENANCE_TYPE" VARCHAR2(100 BYTE) ,
  "WORK_GROUP" VARCHAR2(100 BYTE) ,
  "ACCOUNT_CODE" VARCHAR2(100 BYTE) ,
  "WOPREFIX" VARCHAR2(100 BYTE) ,
  "PROJECTNUMBER" VARCHAR2(100 BYTE) 
)
TABLESPACE "USERS"
LOGGING
NOCOMPRESS
PCTFREE 10
INITRANS 1
STORAGE (
  INITIAL 65536 
  NEXT 1048576 
  MINEXTENTS 1
  MAXEXTENTS 2147483645
  BUFFER_POOL DEFAULT
)
PARALLEL 1
NOCACHE
DISABLE ROW MOVEMENT
;

-- ----------------------------
-- Primary Key structure for table T_WO_PROSPEK
-- ----------------------------
ALTER TABLE "NIAGA_DEV"."T_WO_PROSPEK" ADD CONSTRAINT "T_WO_PROSPEK_PK" PRIMARY KEY ("ID_WO");

-- ----------------------------
-- Checks structure for table T_WO_PROSPEK
-- ----------------------------
ALTER TABLE "NIAGA_DEV"."T_WO_PROSPEK" ADD CONSTRAINT "SYS_C0076064" CHECK ("ID_WO" IS NOT NULL) NOT DEFERRABLE INITIALLY IMMEDIATE NORELY VALIDATE;

-- ----------------------------
-- Triggers structure for table T_WO_PROSPEK
-- ----------------------------
CREATE TRIGGER "NIAGA_DEV"."T_WO_PROSPEK_TRG" BEFORE INSERT ON "NIAGA_DEV"."T_WO_PROSPEK" REFERENCING OLD AS "OLD" NEW AS "NEW" FOR EACH ROW 
begin  
   if inserting then 
      if :NEW."ID_WO" is null then 
         select T_WO_PROSPEK_SEQ.nextval into :NEW."ID_WO" from dual; 
      end if; 
   end if; 
end;
/

-- ----------------------------
-- Foreign Keys structure for table T_WO_PROSPEK
-- ----------------------------
ALTER TABLE "NIAGA_DEV"."T_WO_PROSPEK" ADD CONSTRAINT "CUSTOMER_WO_FK" FOREIGN KEY ("ID_CUSTOMER") REFERENCES "NIAGA_DEV"."CUSTOMER" ("ID_CUSTOMER") ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE NORELY VALIDATE;
