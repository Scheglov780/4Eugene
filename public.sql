/*
 Navicat Premium Data Transfer

 Source Server         : !front.info92
 Source Server Type    : PostgreSQL
 Source Server Version : 120009
 Source Host           : front.info92:5432
 Source Catalog        : virki
 Source Schema         : public

 Target Server Type    : PostgreSQL
 Target Server Version : 120009
 File Encoding         : 65001

 Date: 03/02/2022 19:29:30
*/


-- ----------------------------
-- Sequence structure for _import_1cv1_items_cats_pk_seq
-- ----------------------------
DROP SEQUENCE IF EXISTS "public"."_import_1cv1_items_cats_pk_seq";
CREATE SEQUENCE "public"."_import_1cv1_items_cats_pk_seq" 
INCREMENT 1
MINVALUE  1
MAXVALUE 9223372036854775807
START 43617
CACHE 1;

-- ----------------------------
-- Sequence structure for _import_1cv1_items_pk_seq
-- ----------------------------
DROP SEQUENCE IF EXISTS "public"."_import_1cv1_items_pk_seq";
CREATE SEQUENCE "public"."_import_1cv1_items_pk_seq" 
INCREMENT 1
MINVALUE  1
MAXVALUE 9223372036854775807
START 44863
CACHE 1;

-- ----------------------------
-- Sequence structure for _import_1cv1_items_prices_pk_seq
-- ----------------------------
DROP SEQUENCE IF EXISTS "public"."_import_1cv1_items_prices_pk_seq";
CREATE SEQUENCE "public"."_import_1cv1_items_prices_pk_seq" 
INCREMENT 1
MINVALUE  1
MAXVALUE 9223372036854775807
START 103430
CACHE 1;

-- ----------------------------
-- Sequence structure for addresses_id_seq
-- ----------------------------
DROP SEQUENCE IF EXISTS "public"."addresses_id_seq";
CREATE SEQUENCE "public"."addresses_id_seq" 
INCREMENT 1
MINVALUE  1
MAXVALUE 2147483647
START 545
CACHE 1;

-- ----------------------------
-- Sequence structure for admin_news_id_seq
-- ----------------------------
DROP SEQUENCE IF EXISTS "public"."admin_news_id_seq";
CREATE SEQUENCE "public"."admin_news_id_seq" 
INCREMENT 1
MINVALUE  1
MAXVALUE 2147483647
START 39
CACHE 1;

-- ----------------------------
-- Sequence structure for admin_tabs_history_id_seq
-- ----------------------------
DROP SEQUENCE IF EXISTS "public"."admin_tabs_history_id_seq";
CREATE SEQUENCE "public"."admin_tabs_history_id_seq" 
INCREMENT 1
MINVALUE  1
MAXVALUE 2147483647
START 2188
CACHE 1;

-- ----------------------------
-- Sequence structure for banners_id_seq
-- ----------------------------
DROP SEQUENCE IF EXISTS "public"."banners_id_seq";
CREATE SEQUENCE "public"."banners_id_seq" 
INCREMENT 1
MINVALUE  1
MAXVALUE 2147483647
START 54
CACHE 1;

-- ----------------------------
-- Sequence structure for banrules_id_seq
-- ----------------------------
DROP SEQUENCE IF EXISTS "public"."banrules_id_seq";
CREATE SEQUENCE "public"."banrules_id_seq" 
INCREMENT 1
MINVALUE  1
MAXVALUE 2147483647
START 5
CACHE 1;

-- ----------------------------
-- Sequence structure for bills_comments_attaches_id_seq
-- ----------------------------
DROP SEQUENCE IF EXISTS "public"."bills_comments_attaches_id_seq";
CREATE SEQUENCE "public"."bills_comments_attaches_id_seq" 
INCREMENT 1
MINVALUE  1
MAXVALUE 9223372036854775807
START 1
CACHE 1;

-- ----------------------------
-- Sequence structure for bills_comments_id_seq
-- ----------------------------
DROP SEQUENCE IF EXISTS "public"."bills_comments_id_seq";
CREATE SEQUENCE "public"."bills_comments_id_seq" 
INCREMENT 1
MINVALUE  1
MAXVALUE 9223372036854775807
START 1
CACHE 1;

-- ----------------------------
-- Sequence structure for bills_id_seq
-- ----------------------------
DROP SEQUENCE IF EXISTS "public"."bills_id_seq";
CREATE SEQUENCE "public"."bills_id_seq" 
INCREMENT 1
MINVALUE  1
MAXVALUE 2147483647
START 1
CACHE 1;

-- ----------------------------
-- Sequence structure for bills_payments_id_seq
-- ----------------------------
DROP SEQUENCE IF EXISTS "public"."bills_payments_id_seq";
CREATE SEQUENCE "public"."bills_payments_id_seq" 
INCREMENT 1
MINVALUE  1
MAXVALUE 2147483647
START 1
CACHE 1;

-- ----------------------------
-- Sequence structure for blog_categories_id_seq
-- ----------------------------
DROP SEQUENCE IF EXISTS "public"."blog_categories_id_seq";
CREATE SEQUENCE "public"."blog_categories_id_seq" 
INCREMENT 1
MINVALUE  1
MAXVALUE 2147483647
START 11
CACHE 1;

-- ----------------------------
-- Sequence structure for blog_comments_id_seq
-- ----------------------------
DROP SEQUENCE IF EXISTS "public"."blog_comments_id_seq";
CREATE SEQUENCE "public"."blog_comments_id_seq" 
INCREMENT 1
MINVALUE  1
MAXVALUE 2147483647
START 15
CACHE 1;

-- ----------------------------
-- Sequence structure for blog_posts_id_seq
-- ----------------------------
DROP SEQUENCE IF EXISTS "public"."blog_posts_id_seq";
CREATE SEQUENCE "public"."blog_posts_id_seq" 
INCREMENT 1
MINVALUE  1
MAXVALUE 2147483647
START 41
CACHE 1;

-- ----------------------------
-- Sequence structure for brands_id_seq
-- ----------------------------
DROP SEQUENCE IF EXISTS "public"."brands_id_seq";
CREATE SEQUENCE "public"."brands_id_seq" 
INCREMENT 1
MINVALUE  1
MAXVALUE 9223372036854775807
START 564
CACHE 1;

-- ----------------------------
-- Sequence structure for cart_id_seq
-- ----------------------------
DROP SEQUENCE IF EXISTS "public"."cart_id_seq";
CREATE SEQUENCE "public"."cart_id_seq" 
INCREMENT 1
MINVALUE  1
MAXVALUE 9223372036854775807
START 55
CACHE 1;

-- ----------------------------
-- Sequence structure for categories_ext_id_seq
-- ----------------------------
DROP SEQUENCE IF EXISTS "public"."categories_ext_id_seq";
CREATE SEQUENCE "public"."categories_ext_id_seq" 
INCREMENT 1
MINVALUE  1
MAXVALUE 9223372036854775807
START 1732781
CACHE 1;

-- ----------------------------
-- Sequence structure for categories_ext_source_id_seq
-- ----------------------------
DROP SEQUENCE IF EXISTS "public"."categories_ext_source_id_seq";
CREATE SEQUENCE "public"."categories_ext_source_id_seq" 
INCREMENT 1
MINVALUE  1
MAXVALUE 9223372036854775807
START 43753
CACHE 1;

-- ----------------------------
-- Sequence structure for categories_ext_storage_pk_seq
-- ----------------------------
DROP SEQUENCE IF EXISTS "public"."categories_ext_storage_pk_seq";
CREATE SEQUENCE "public"."categories_ext_storage_pk_seq" 
INCREMENT 1
MINVALUE  1
MAXVALUE 9223372036854775807
START 11704
CACHE 1;

-- ----------------------------
-- Sequence structure for categories_prices_id_seq
-- ----------------------------
DROP SEQUENCE IF EXISTS "public"."categories_prices_id_seq";
CREATE SEQUENCE "public"."categories_prices_id_seq" 
INCREMENT 1
MINVALUE  1
MAXVALUE 9223372036854775807
START 233886
CACHE 1;

-- ----------------------------
-- Sequence structure for classifier_id_seq
-- ----------------------------
DROP SEQUENCE IF EXISTS "public"."classifier_id_seq";
CREATE SEQUENCE "public"."classifier_id_seq" 
INCREMENT 1
MINVALUE  1
MAXVALUE 2147483647
START 14900
CACHE 1;

-- ----------------------------
-- Sequence structure for classifier_props_id_seq
-- ----------------------------
DROP SEQUENCE IF EXISTS "public"."classifier_props_id_seq";
CREATE SEQUENCE "public"."classifier_props_id_seq" 
INCREMENT 1
MINVALUE  1
MAXVALUE 2147483647
START 66505
CACHE 1;

-- ----------------------------
-- Sequence structure for classifier_props_vals_id_seq
-- ----------------------------
DROP SEQUENCE IF EXISTS "public"."classifier_props_vals_id_seq";
CREATE SEQUENCE "public"."classifier_props_vals_id_seq" 
INCREMENT 1
MINVALUE  1
MAXVALUE 2147483647
START 937630
CACHE 1;

-- ----------------------------
-- Sequence structure for cms_content_history_id_seq
-- ----------------------------
DROP SEQUENCE IF EXISTS "public"."cms_content_history_id_seq";
CREATE SEQUENCE "public"."cms_content_history_id_seq" 
INCREMENT 1
MINVALUE  1
MAXVALUE 9223372036854775807
START 164
CACHE 1;

-- ----------------------------
-- Sequence structure for cms_custom_content_id_seq
-- ----------------------------
DROP SEQUENCE IF EXISTS "public"."cms_custom_content_id_seq";
CREATE SEQUENCE "public"."cms_custom_content_id_seq" 
INCREMENT 1
MINVALUE  1
MAXVALUE 2147483647
START 33
CACHE 1;

-- ----------------------------
-- Sequence structure for cms_email_events_id_seq
-- ----------------------------
DROP SEQUENCE IF EXISTS "public"."cms_email_events_id_seq";
CREATE SEQUENCE "public"."cms_email_events_id_seq" 
INCREMENT 1
MINVALUE  1
MAXVALUE 2147483647
START 35
CACHE 1;

-- ----------------------------
-- Sequence structure for cms_knowledge_base_id_seq
-- ----------------------------
DROP SEQUENCE IF EXISTS "public"."cms_knowledge_base_id_seq";
CREATE SEQUENCE "public"."cms_knowledge_base_id_seq" 
INCREMENT 1
MINVALUE  1
MAXVALUE 9223372036854775807
START 19724
CACHE 1;

-- ----------------------------
-- Sequence structure for cms_knowledge_base_img_id_seq
-- ----------------------------
DROP SEQUENCE IF EXISTS "public"."cms_knowledge_base_img_id_seq";
CREATE SEQUENCE "public"."cms_knowledge_base_img_id_seq" 
INCREMENT 1
MINVALUE  1
MAXVALUE 9223372036854775807
START 95954
CACHE 1;

-- ----------------------------
-- Sequence structure for cms_loaded_id_seq
-- ----------------------------
DROP SEQUENCE IF EXISTS "public"."cms_loaded_id_seq";
CREATE SEQUENCE "public"."cms_loaded_id_seq" 
INCREMENT 1
MINVALUE  1
MAXVALUE 2147483647
START 96
CACHE 1;

-- ----------------------------
-- Sequence structure for cms_menus_id_seq
-- ----------------------------
DROP SEQUENCE IF EXISTS "public"."cms_menus_id_seq";
CREATE SEQUENCE "public"."cms_menus_id_seq" 
INCREMENT 1
MINVALUE  1
MAXVALUE 2147483647
START 5
CACHE 1;

-- ----------------------------
-- Sequence structure for cms_metatags_id_seq
-- ----------------------------
DROP SEQUENCE IF EXISTS "public"."cms_metatags_id_seq";
CREATE SEQUENCE "public"."cms_metatags_id_seq" 
INCREMENT 1
MINVALUE  1
MAXVALUE 9223372036854775807
START 568947
CACHE 1;

-- ----------------------------
-- Sequence structure for cms_pages_content_id_seq
-- ----------------------------
DROP SEQUENCE IF EXISTS "public"."cms_pages_content_id_seq";
CREATE SEQUENCE "public"."cms_pages_content_id_seq" 
INCREMENT 1
MINVALUE  1
MAXVALUE 2147483647
START 86
CACHE 1;

-- ----------------------------
-- Sequence structure for cms_pages_id_seq
-- ----------------------------
DROP SEQUENCE IF EXISTS "public"."cms_pages_id_seq";
CREATE SEQUENCE "public"."cms_pages_id_seq" 
INCREMENT 1
MINVALUE  1
MAXVALUE 2147483647
START 52
CACHE 1;

-- ----------------------------
-- Sequence structure for currency_log_id_seq
-- ----------------------------
DROP SEQUENCE IF EXISTS "public"."currency_log_id_seq";
CREATE SEQUENCE "public"."currency_log_id_seq" 
INCREMENT 1
MINVALUE  1
MAXVALUE 2147483647
START 48791
CACHE 1;

-- ----------------------------
-- Sequence structure for debug_log_id_seq
-- ----------------------------
DROP SEQUENCE IF EXISTS "public"."debug_log_id_seq";
CREATE SEQUENCE "public"."debug_log_id_seq" 
INCREMENT 1
MINVALUE  1
MAXVALUE 9223372036854775807
START 6118
CACHE 1;

-- ----------------------------
-- Sequence structure for deliveries_id_seq
-- ----------------------------
DROP SEQUENCE IF EXISTS "public"."deliveries_id_seq";
CREATE SEQUENCE "public"."deliveries_id_seq" 
INCREMENT 1
MINVALUE  1
MAXVALUE 2147483647
START 9
CACHE 1;

-- ----------------------------
-- Sequence structure for dic_custom_val_id_seq
-- ----------------------------
DROP SEQUENCE IF EXISTS "public"."dic_custom_val_id_seq";
CREATE SEQUENCE "public"."dic_custom_val_id_seq" 
INCREMENT 1
MINVALUE  1
MAXVALUE 2147483647
START 1
CACHE 1;

-- ----------------------------
-- Sequence structure for events_id_seq
-- ----------------------------
DROP SEQUENCE IF EXISTS "public"."events_id_seq";
CREATE SEQUENCE "public"."events_id_seq" 
INCREMENT 1
MINVALUE  1
MAXVALUE 2147483647
START 28
CACHE 1;

-- ----------------------------
-- Sequence structure for events_log_id_seq
-- ----------------------------
DROP SEQUENCE IF EXISTS "public"."events_log_id_seq";
CREATE SEQUENCE "public"."events_log_id_seq" 
INCREMENT 1
MINVALUE  1
MAXVALUE 2147483647
START 844
CACHE 1;

-- ----------------------------
-- Sequence structure for favorites_id_seq
-- ----------------------------
DROP SEQUENCE IF EXISTS "public"."favorites_id_seq";
CREATE SEQUENCE "public"."favorites_id_seq" 
INCREMENT 1
MINVALUE  1
MAXVALUE 9223372036854775807
START 281447
CACHE 1;

-- ----------------------------
-- Sequence structure for formulas_id_seq
-- ----------------------------
DROP SEQUENCE IF EXISTS "public"."formulas_id_seq";
CREATE SEQUENCE "public"."formulas_id_seq" 
INCREMENT 1
MINVALUE  1
MAXVALUE 2147483647
START 11
CACHE 1;

-- ----------------------------
-- Sequence structure for fulltext_stem_id_seq
-- ----------------------------
DROP SEQUENCE IF EXISTS "public"."fulltext_stem_id_seq";
CREATE SEQUENCE "public"."fulltext_stem_id_seq" 
INCREMENT 1
MINVALUE  1
MAXVALUE 2147483647
START 384172
CACHE 1;

-- ----------------------------
-- Sequence structure for geo_cities_id_seq
-- ----------------------------
DROP SEQUENCE IF EXISTS "public"."geo_cities_id_seq";
CREATE SEQUENCE "public"."geo_cities_id_seq" 
INCREMENT 1
MINVALUE  1
MAXVALUE 9223372036854775807
START 3299
CACHE 1;

-- ----------------------------
-- Sequence structure for img_hashes_id_seq
-- ----------------------------
DROP SEQUENCE IF EXISTS "public"."img_hashes_id_seq";
CREATE SEQUENCE "public"."img_hashes_id_seq" 
INCREMENT 1
MINVALUE  1
MAXVALUE 9223372036854775807
START 1476512
CACHE 1;

-- ----------------------------
-- Sequence structure for lands_land_id_seq
-- ----------------------------
DROP SEQUENCE IF EXISTS "public"."lands_land_id_seq";
CREATE SEQUENCE "public"."lands_land_id_seq" 
INCREMENT 1
MINVALUE  1
MAXVALUE 2147483647
START 21725
CACHE 1;

-- ----------------------------
-- Sequence structure for local_items_attributes_attribute_id_seq
-- ----------------------------
DROP SEQUENCE IF EXISTS "public"."local_items_attributes_attribute_id_seq";
CREATE SEQUENCE "public"."local_items_attributes_attribute_id_seq" 
INCREMENT 1
MINVALUE  1
MAXVALUE 9223372036854775807
START 665
CACHE 1;

-- ----------------------------
-- Sequence structure for local_items_pictures_picture_id_seq
-- ----------------------------
DROP SEQUENCE IF EXISTS "public"."local_items_pictures_picture_id_seq";
CREATE SEQUENCE "public"."local_items_pictures_picture_id_seq" 
INCREMENT 1
MINVALUE  1
MAXVALUE 9223372036854775807
START 217
CACHE 1;

-- ----------------------------
-- Sequence structure for local_items_pids_pid_id_seq
-- ----------------------------
DROP SEQUENCE IF EXISTS "public"."local_items_pids_pid_id_seq";
CREATE SEQUENCE "public"."local_items_pids_pid_id_seq" 
INCREMENT 1
MINVALUE  1
MAXVALUE 9223372036854775807
START 80
CACHE 1;

-- ----------------------------
-- Sequence structure for local_items_pids_vids_vid_id_seq
-- ----------------------------
DROP SEQUENCE IF EXISTS "public"."local_items_pids_vids_vid_id_seq";
CREATE SEQUENCE "public"."local_items_pids_vids_vid_id_seq" 
INCREMENT 1
MINVALUE  1
MAXVALUE 9223372036854775807
START 660
CACHE 1;

-- ----------------------------
-- Sequence structure for log_api_requests_id_seq
-- ----------------------------
DROP SEQUENCE IF EXISTS "public"."log_api_requests_id_seq";
CREATE SEQUENCE "public"."log_api_requests_id_seq" 
INCREMENT 1
MINVALUE  1
MAXVALUE 9223372036854775807
START 2
CACHE 1;

-- ----------------------------
-- Sequence structure for log_dsg_buffer_id_seq
-- ----------------------------
DROP SEQUENCE IF EXISTS "public"."log_dsg_buffer_id_seq";
CREATE SEQUENCE "public"."log_dsg_buffer_id_seq" 
INCREMENT 1
MINVALUE  1
MAXVALUE 9223372036854775807
START 2
CACHE 1;

-- ----------------------------
-- Sequence structure for log_dsg_details_id_seq
-- ----------------------------
DROP SEQUENCE IF EXISTS "public"."log_dsg_details_id_seq";
CREATE SEQUENCE "public"."log_dsg_details_id_seq" 
INCREMENT 1
MINVALUE  1
MAXVALUE 9223372036854775807
START 2
CACHE 1;

-- ----------------------------
-- Sequence structure for log_dsg_id_seq
-- ----------------------------
DROP SEQUENCE IF EXISTS "public"."log_dsg_id_seq";
CREATE SEQUENCE "public"."log_dsg_id_seq" 
INCREMENT 1
MINVALUE  1
MAXVALUE 9223372036854775807
START 964
CACHE 1;

-- ----------------------------
-- Sequence structure for log_dsg_translator_id_seq
-- ----------------------------
DROP SEQUENCE IF EXISTS "public"."log_dsg_translator_id_seq";
CREATE SEQUENCE "public"."log_dsg_translator_id_seq" 
INCREMENT 1
MINVALUE  1
MAXVALUE 9223372036854775807
START 14
CACHE 1;

-- ----------------------------
-- Sequence structure for log_http_requests_id_seq
-- ----------------------------
DROP SEQUENCE IF EXISTS "public"."log_http_requests_id_seq";
CREATE SEQUENCE "public"."log_http_requests_id_seq" 
INCREMENT 1
MINVALUE  1
MAXVALUE 9223372036854775807
START 1235548
CACHE 1;

-- ----------------------------
-- Sequence structure for log_iot_id_seq
-- ----------------------------
DROP SEQUENCE IF EXISTS "public"."log_iot_id_seq";
CREATE SEQUENCE "public"."log_iot_id_seq" 
INCREMENT 1
MINVALUE  1
MAXVALUE 9223372036854775807
START 1
CACHE 1;

-- ----------------------------
-- Sequence structure for log_item_requests_id_seq
-- ----------------------------
DROP SEQUENCE IF EXISTS "public"."log_item_requests_id_seq";
CREATE SEQUENCE "public"."log_item_requests_id_seq" 
INCREMENT 1
MINVALUE  1
MAXVALUE 9223372036854775807
START 3266994
CACHE 1;

-- ----------------------------
-- Sequence structure for log_queries_requests_id_seq
-- ----------------------------
DROP SEQUENCE IF EXISTS "public"."log_queries_requests_id_seq";
CREATE SEQUENCE "public"."log_queries_requests_id_seq" 
INCREMENT 1
MINVALUE  1
MAXVALUE 9223372036854775807
START 26261
CACHE 1;

-- ----------------------------
-- Sequence structure for log_site_errors_id_seq
-- ----------------------------
DROP SEQUENCE IF EXISTS "public"."log_site_errors_id_seq";
CREATE SEQUENCE "public"."log_site_errors_id_seq" 
INCREMENT 1
MINVALUE  1
MAXVALUE 9223372036854775807
START 5577
CACHE 1;

-- ----------------------------
-- Sequence structure for log_translations_id_seq
-- ----------------------------
DROP SEQUENCE IF EXISTS "public"."log_translations_id_seq";
CREATE SEQUENCE "public"."log_translations_id_seq" 
INCREMENT 1
MINVALUE  1
MAXVALUE 9223372036854775807
START 91
CACHE 1;

-- ----------------------------
-- Sequence structure for log_translator_keys_id_seq
-- ----------------------------
DROP SEQUENCE IF EXISTS "public"."log_translator_keys_id_seq";
CREATE SEQUENCE "public"."log_translator_keys_id_seq" 
INCREMENT 1
MINVALUE  1
MAXVALUE 9223372036854775807
START 475
CACHE 1;

-- ----------------------------
-- Sequence structure for log_user_activity_id_seq
-- ----------------------------
DROP SEQUENCE IF EXISTS "public"."log_user_activity_id_seq";
CREATE SEQUENCE "public"."log_user_activity_id_seq" 
INCREMENT 1
MINVALUE  1
MAXVALUE 2147483647
START 1
CACHE 1;

-- ----------------------------
-- Sequence structure for mail_queue_id_seq
-- ----------------------------
DROP SEQUENCE IF EXISTS "public"."mail_queue_id_seq";
CREATE SEQUENCE "public"."mail_queue_id_seq" 
INCREMENT 1
MINVALUE  1
MAXVALUE 2147483647
START 4585
CACHE 1;

-- ----------------------------
-- Sequence structure for messages_id_seq
-- ----------------------------
DROP SEQUENCE IF EXISTS "public"."messages_id_seq";
CREATE SEQUENCE "public"."messages_id_seq" 
INCREMENT 1
MINVALUE  1
MAXVALUE 2147483647
START 1655
CACHE 1;

-- ----------------------------
-- Sequence structure for obj_devices_manual_data_data_id_seq
-- ----------------------------
DROP SEQUENCE IF EXISTS "public"."obj_devices_manual_data_data_id_seq";
CREATE SEQUENCE "public"."obj_devices_manual_data_data_id_seq" 
INCREMENT 1
MINVALUE  1
MAXVALUE 2147483647
START 1
CACHE 1;

-- ----------------------------
-- Sequence structure for obj_devices_manual_devices_id_seq
-- ----------------------------
DROP SEQUENCE IF EXISTS "public"."obj_devices_manual_devices_id_seq";
CREATE SEQUENCE "public"."obj_devices_manual_devices_id_seq" 
INCREMENT 1
MINVALUE  1
MAXVALUE 2147483647
START 1073741824
CACHE 1;

-- ----------------------------
-- Sequence structure for obj_devices_tariffs_copy1_devices_tariffs_id_seq
-- ----------------------------
DROP SEQUENCE IF EXISTS "public"."obj_devices_tariffs_copy1_devices_tariffs_id_seq";
CREATE SEQUENCE "public"."obj_devices_tariffs_copy1_devices_tariffs_id_seq" 
INCREMENT 1
MINVALUE  1
MAXVALUE 2147483647
START 1
CACHE 1;

-- ----------------------------
-- Sequence structure for obj_devices_tariffs_devices_tariffs_id_seq
-- ----------------------------
DROP SEQUENCE IF EXISTS "public"."obj_devices_tariffs_devices_tariffs_id_seq";
CREATE SEQUENCE "public"."obj_devices_tariffs_devices_tariffs_id_seq" 
INCREMENT 1
MINVALUE  1
MAXVALUE 2147483647
START 1
CACHE 1;

-- ----------------------------
-- Sequence structure for obj_lands_devices_lands_devices_id_seq
-- ----------------------------
DROP SEQUENCE IF EXISTS "public"."obj_lands_devices_lands_devices_id_seq";
CREATE SEQUENCE "public"."obj_lands_devices_lands_devices_id_seq" 
INCREMENT 1
MINVALUE  1
MAXVALUE 2147483647
START 1
CACHE 1;

-- ----------------------------
-- Sequence structure for obj_lands_tariffs_lands_tariffs_id_seq
-- ----------------------------
DROP SEQUENCE IF EXISTS "public"."obj_lands_tariffs_lands_tariffs_id_seq";
CREATE SEQUENCE "public"."obj_lands_tariffs_lands_tariffs_id_seq" 
INCREMENT 1
MINVALUE  1
MAXVALUE 2147483647
START 1
CACHE 1;

-- ----------------------------
-- Sequence structure for obj_news_confirmations_news_confirmations_id_seq
-- ----------------------------
DROP SEQUENCE IF EXISTS "public"."obj_news_confirmations_news_confirmations_id_seq";
CREATE SEQUENCE "public"."obj_news_confirmations_news_confirmations_id_seq" 
INCREMENT 1
MINVALUE  1
MAXVALUE 2147483647
START 1
CACHE 1;

-- ----------------------------
-- Sequence structure for obj_news_news_id_seq
-- ----------------------------
DROP SEQUENCE IF EXISTS "public"."obj_news_news_id_seq";
CREATE SEQUENCE "public"."obj_news_news_id_seq" 
INCREMENT 1
MINVALUE  1
MAXVALUE 2147483647
START 1
CACHE 1;

-- ----------------------------
-- Sequence structure for obj_tariffs_acceptors_tariff_acceptors_id_seq
-- ----------------------------
DROP SEQUENCE IF EXISTS "public"."obj_tariffs_acceptors_tariff_acceptors_id_seq";
CREATE SEQUENCE "public"."obj_tariffs_acceptors_tariff_acceptors_id_seq" 
INCREMENT 1
MINVALUE  1
MAXVALUE 2147483647
START 1
CACHE 1;

-- ----------------------------
-- Sequence structure for obj_tariffs_tariffs_id_seq
-- ----------------------------
DROP SEQUENCE IF EXISTS "public"."obj_tariffs_tariffs_id_seq";
CREATE SEQUENCE "public"."obj_tariffs_tariffs_id_seq" 
INCREMENT 1
MINVALUE  1
MAXVALUE 2147483647
START 1
CACHE 1;

-- ----------------------------
-- Sequence structure for obj_votings_results_votings_results_id_seq
-- ----------------------------
DROP SEQUENCE IF EXISTS "public"."obj_votings_results_votings_results_id_seq";
CREATE SEQUENCE "public"."obj_votings_results_votings_results_id_seq" 
INCREMENT 1
MINVALUE  1
MAXVALUE 2147483647
START 1
CACHE 1;

-- ----------------------------
-- Sequence structure for obj_votings_votings_id_seq
-- ----------------------------
DROP SEQUENCE IF EXISTS "public"."obj_votings_votings_id_seq";
CREATE SEQUENCE "public"."obj_votings_votings_id_seq" 
INCREMENT 1
MINVALUE  1
MAXVALUE 2147483647
START 1
CACHE 1;

-- ----------------------------
-- Sequence structure for orders_comments_attaches_id_seq
-- ----------------------------
DROP SEQUENCE IF EXISTS "public"."orders_comments_attaches_id_seq";
CREATE SEQUENCE "public"."orders_comments_attaches_id_seq" 
INCREMENT 1
MINVALUE  1
MAXVALUE 9223372036854775807
START 40
CACHE 1;

-- ----------------------------
-- Sequence structure for orders_comments_id_seq
-- ----------------------------
DROP SEQUENCE IF EXISTS "public"."orders_comments_id_seq";
CREATE SEQUENCE "public"."orders_comments_id_seq" 
INCREMENT 1
MINVALUE  1
MAXVALUE 9223372036854775807
START 5335
CACHE 1;

-- ----------------------------
-- Sequence structure for orders_id_seq
-- ----------------------------
DROP SEQUENCE IF EXISTS "public"."orders_id_seq";
CREATE SEQUENCE "public"."orders_id_seq" 
INCREMENT 1
MINVALUE  1
MAXVALUE 2147483647
START 11848
CACHE 1;

-- ----------------------------
-- Sequence structure for orders_items_comments_attaches_id_seq
-- ----------------------------
DROP SEQUENCE IF EXISTS "public"."orders_items_comments_attaches_id_seq";
CREATE SEQUENCE "public"."orders_items_comments_attaches_id_seq" 
INCREMENT 1
MINVALUE  1
MAXVALUE 9223372036854775807
START 370
CACHE 1;

-- ----------------------------
-- Sequence structure for orders_items_comments_id_seq
-- ----------------------------
DROP SEQUENCE IF EXISTS "public"."orders_items_comments_id_seq";
CREATE SEQUENCE "public"."orders_items_comments_id_seq" 
INCREMENT 1
MINVALUE  1
MAXVALUE 9223372036854775807
START 18052
CACHE 1;

-- ----------------------------
-- Sequence structure for orders_items_id_seq
-- ----------------------------
DROP SEQUENCE IF EXISTS "public"."orders_items_id_seq";
CREATE SEQUENCE "public"."orders_items_id_seq" 
INCREMENT 1
MINVALUE  1
MAXVALUE 2147483647
START 72139
CACHE 1;

-- ----------------------------
-- Sequence structure for orders_payments_id_seq
-- ----------------------------
DROP SEQUENCE IF EXISTS "public"."orders_payments_id_seq";
CREATE SEQUENCE "public"."orders_payments_id_seq" 
INCREMENT 1
MINVALUE  1
MAXVALUE 2147483647
START 9075
CACHE 1;

-- ----------------------------
-- Sequence structure for orders_statuses_copy1_id_seq
-- ----------------------------
DROP SEQUENCE IF EXISTS "public"."orders_statuses_copy1_id_seq";
CREATE SEQUENCE "public"."orders_statuses_copy1_id_seq" 
INCREMENT 1
MINVALUE  1
MAXVALUE 2147483647
START 32
CACHE 1;

-- ----------------------------
-- Sequence structure for orders_statuses_id_seq
-- ----------------------------
DROP SEQUENCE IF EXISTS "public"."orders_statuses_id_seq";
CREATE SEQUENCE "public"."orders_statuses_id_seq" 
INCREMENT 1
MINVALUE  1
MAXVALUE 2147483647
START 32
CACHE 1;

-- ----------------------------
-- Sequence structure for parcels_cart_id_seq
-- ----------------------------
DROP SEQUENCE IF EXISTS "public"."parcels_cart_id_seq";
CREATE SEQUENCE "public"."parcels_cart_id_seq" 
INCREMENT 1
MINVALUE  1
MAXVALUE 9223372036854775807
START 1809
CACHE 1;

-- ----------------------------
-- Sequence structure for parcels_comments_attaches_id_seq
-- ----------------------------
DROP SEQUENCE IF EXISTS "public"."parcels_comments_attaches_id_seq";
CREATE SEQUENCE "public"."parcels_comments_attaches_id_seq" 
INCREMENT 1
MINVALUE  1
MAXVALUE 9223372036854775807
START 2
CACHE 1;

-- ----------------------------
-- Sequence structure for parcels_comments_id_seq
-- ----------------------------
DROP SEQUENCE IF EXISTS "public"."parcels_comments_id_seq";
CREATE SEQUENCE "public"."parcels_comments_id_seq" 
INCREMENT 1
MINVALUE  1
MAXVALUE 9223372036854775807
START 3
CACHE 1;

-- ----------------------------
-- Sequence structure for parcels_id_seq
-- ----------------------------
DROP SEQUENCE IF EXISTS "public"."parcels_id_seq";
CREATE SEQUENCE "public"."parcels_id_seq" 
INCREMENT 1
MINVALUE  1
MAXVALUE 2147483647
START 10
CACHE 1;

-- ----------------------------
-- Sequence structure for parcels_items_id_seq
-- ----------------------------
DROP SEQUENCE IF EXISTS "public"."parcels_items_id_seq";
CREATE SEQUENCE "public"."parcels_items_id_seq" 
INCREMENT 1
MINVALUE  1
MAXVALUE 2147483647
START 250
CACHE 1;

-- ----------------------------
-- Sequence structure for parcels_payments_id_seq
-- ----------------------------
DROP SEQUENCE IF EXISTS "public"."parcels_payments_id_seq";
CREATE SEQUENCE "public"."parcels_payments_id_seq" 
INCREMENT 1
MINVALUE  1
MAXVALUE 2147483647
START 2
CACHE 1;

-- ----------------------------
-- Sequence structure for parcels_statuses_id_seq
-- ----------------------------
DROP SEQUENCE IF EXISTS "public"."parcels_statuses_id_seq";
CREATE SEQUENCE "public"."parcels_statuses_id_seq" 
INCREMENT 1
MINVALUE  1
MAXVALUE 2147483647
START 17
CACHE 1;

-- ----------------------------
-- Sequence structure for pay_systems_id_seq
-- ----------------------------
DROP SEQUENCE IF EXISTS "public"."pay_systems_id_seq";
CREATE SEQUENCE "public"."pay_systems_id_seq" 
INCREMENT 1
MINVALUE  1
MAXVALUE 2147483647
START 35
CACHE 1;

-- ----------------------------
-- Sequence structure for pay_systems_log_id_seq
-- ----------------------------
DROP SEQUENCE IF EXISTS "public"."pay_systems_log_id_seq";
CREATE SEQUENCE "public"."pay_systems_log_id_seq" 
INCREMENT 1
MINVALUE  1
MAXVALUE 9223372036854775807
START 203
CACHE 1;

-- ----------------------------
-- Sequence structure for payments_id_seq
-- ----------------------------
DROP SEQUENCE IF EXISTS "public"."payments_id_seq";
CREATE SEQUENCE "public"."payments_id_seq" 
INCREMENT 1
MINVALUE  1
MAXVALUE 2147483647
START 9455
CACHE 1;

-- ----------------------------
-- Sequence structure for questions_id_seq
-- ----------------------------
DROP SEQUENCE IF EXISTS "public"."questions_id_seq";
CREATE SEQUENCE "public"."questions_id_seq" 
INCREMENT 1
MINVALUE  1
MAXVALUE 2147483647
START 926
CACHE 1;

-- ----------------------------
-- Sequence structure for reports_system_id_seq
-- ----------------------------
DROP SEQUENCE IF EXISTS "public"."reports_system_id_seq";
CREATE SEQUENCE "public"."reports_system_id_seq" 
INCREMENT 1
MINVALUE  1
MAXVALUE 2147483647
START 28
CACHE 1;

-- ----------------------------
-- Sequence structure for scheduled_jobs_id_seq
-- ----------------------------
DROP SEQUENCE IF EXISTS "public"."scheduled_jobs_id_seq";
CREATE SEQUENCE "public"."scheduled_jobs_id_seq" 
INCREMENT 1
MINVALUE  1
MAXVALUE 2147483647
START 21
CACHE 1;

-- ----------------------------
-- Sequence structure for t_source_category_id_seq
-- ----------------------------
DROP SEQUENCE IF EXISTS "public"."t_source_category_id_seq";
CREATE SEQUENCE "public"."t_source_category_id_seq" 
INCREMENT 1
MINVALUE  1
MAXVALUE 9223372036854775807
START 10834240
CACHE 1;

-- ----------------------------
-- Sequence structure for t_source_dictionary_id_seq
-- ----------------------------
DROP SEQUENCE IF EXISTS "public"."t_source_dictionary_id_seq";
CREATE SEQUENCE "public"."t_source_dictionary_id_seq" 
INCREMENT 1
MINVALUE  1
MAXVALUE 9223372036854775807
START 32304
CACHE 1;

-- ----------------------------
-- Sequence structure for t_source_dictionary_long_id_seq
-- ----------------------------
DROP SEQUENCE IF EXISTS "public"."t_source_dictionary_long_id_seq";
CREATE SEQUENCE "public"."t_source_dictionary_long_id_seq" 
INCREMENT 1
MINVALUE  1
MAXVALUE 9223372036854775807
START 8760
CACHE 1;

-- ----------------------------
-- Sequence structure for t_source_message_id_seq
-- ----------------------------
DROP SEQUENCE IF EXISTS "public"."t_source_message_id_seq";
CREATE SEQUENCE "public"."t_source_message_id_seq" 
INCREMENT 1
MINVALUE  1
MAXVALUE 2147483647
START 13314
CACHE 1;

-- ----------------------------
-- Sequence structure for t_source_pinned_id_seq
-- ----------------------------
DROP SEQUENCE IF EXISTS "public"."t_source_pinned_id_seq";
CREATE SEQUENCE "public"."t_source_pinned_id_seq" 
INCREMENT 1
MINVALUE  1
MAXVALUE 9223372036854775807
START 5
CACHE 1;

-- ----------------------------
-- Sequence structure for t_source_sentences_id_seq
-- ----------------------------
DROP SEQUENCE IF EXISTS "public"."t_source_sentences_id_seq";
CREATE SEQUENCE "public"."t_source_sentences_id_seq" 
INCREMENT 1
MINVALUE  1
MAXVALUE 9223372036854775807
START 10002
CACHE 1;

-- ----------------------------
-- Sequence structure for translator_keys_id_seq
-- ----------------------------
DROP SEQUENCE IF EXISTS "public"."translator_keys_id_seq";
CREATE SEQUENCE "public"."translator_keys_id_seq" 
INCREMENT 1
MINVALUE  1
MAXVALUE 2147483647
START 127
CACHE 1;

-- ----------------------------
-- Sequence structure for user_notice_id_seq
-- ----------------------------
DROP SEQUENCE IF EXISTS "public"."user_notice_id_seq";
CREATE SEQUENCE "public"."user_notice_id_seq" 
INCREMENT 1
MINVALUE  1
MAXVALUE 2147483647
START 2
CACHE 1;

-- ----------------------------
-- Sequence structure for users_lands_users_lands_id_seq
-- ----------------------------
DROP SEQUENCE IF EXISTS "public"."users_lands_users_lands_id_seq";
CREATE SEQUENCE "public"."users_lands_users_lands_id_seq" 
INCREMENT 1
MINVALUE  1
MAXVALUE 2147483647
START 1
CACHE 1;

-- ----------------------------
-- Sequence structure for users_uid_seq
-- ----------------------------
DROP SEQUENCE IF EXISTS "public"."users_uid_seq";
CREATE SEQUENCE "public"."users_uid_seq" 
INCREMENT 1
MINVALUE  1
MAXVALUE 2147483647
START 21725
CACHE 1;

-- ----------------------------
-- Sequence structure for warehouse_id_seq
-- ----------------------------
DROP SEQUENCE IF EXISTS "public"."warehouse_id_seq";
CREATE SEQUENCE "public"."warehouse_id_seq" 
INCREMENT 1
MINVALUE  1
MAXVALUE 2147483647
START 8
CACHE 1;

-- ----------------------------
-- Sequence structure for warehouse_place_id_seq
-- ----------------------------
DROP SEQUENCE IF EXISTS "public"."warehouse_place_id_seq";
CREATE SEQUENCE "public"."warehouse_place_id_seq" 
INCREMENT 1
MINVALUE  1
MAXVALUE 2147483647
START 45
CACHE 1;

-- ----------------------------
-- Sequence structure for warehouse_place_item_id_seq
-- ----------------------------
DROP SEQUENCE IF EXISTS "public"."warehouse_place_item_id_seq";
CREATE SEQUENCE "public"."warehouse_place_item_id_seq" 
INCREMENT 1
MINVALUE  1
MAXVALUE 2147483647
START 169
CACHE 1;

-- ----------------------------
-- Sequence structure for weights_id_seq
-- ----------------------------
DROP SEQUENCE IF EXISTS "public"."weights_id_seq";
CREATE SEQUENCE "public"."weights_id_seq" 
INCREMENT 1
MINVALUE  1
MAXVALUE 9223372036854775807
START 23105
CACHE 1;

-- ----------------------------
-- Table structure for _import_1cv1_items
-- ----------------------------
DROP TABLE IF EXISTS "public"."_import_1cv1_items";
CREATE TABLE "public"."_import_1cv1_items" (
  "pk" int8 NOT NULL GENERATED BY DEFAULT AS IDENTITY (
INCREMENT 1
MINVALUE  1
MAXVALUE 9223372036854775807
START 44863
),
  "ds_source" varchar(32) COLLATE "pg_catalog"."default",
  "id" varchar(45) COLLATE "pg_catalog"."default",
  "article" varchar(255) COLLATE "pg_catalog"."default",
  "name" varchar(1024) COLLATE "pg_catalog"."default",
  "title" varchar(1024) COLLATE "pg_catalog"."default",
  "pce" varchar(32) COLLATE "pg_catalog"."default",
  "remain" int4 DEFAULT 0,
  "image" varchar(1024) COLLATE "pg_catalog"."default"
)
;
COMMENT ON COLUMN "public"."_import_1cv1_items"."id" IS 'Ид';
COMMENT ON COLUMN "public"."_import_1cv1_items"."article" IS 'Артикул';
COMMENT ON COLUMN "public"."_import_1cv1_items"."name" IS 'Наименование';
COMMENT ON COLUMN "public"."_import_1cv1_items"."title" IS 'ПолноеНаименование';
COMMENT ON COLUMN "public"."_import_1cv1_items"."pce" IS 'БазоваяЕдиница';
COMMENT ON COLUMN "public"."_import_1cv1_items"."remain" IS 'Остаток';
COMMENT ON COLUMN "public"."_import_1cv1_items"."image" IS 'Путь к изображению';
COMMENT ON TABLE "public"."_import_1cv1_items" IS 'Сырые импортированные товары';

-- ----------------------------
-- Table structure for _import_1cv1_items_cats
-- ----------------------------
DROP TABLE IF EXISTS "public"."_import_1cv1_items_cats";
CREATE TABLE "public"."_import_1cv1_items_cats" (
  "pk" int8 NOT NULL GENERATED BY DEFAULT AS IDENTITY (
INCREMENT 1
MINVALUE  1
MAXVALUE 9223372036854775807
START 43617
),
  "ds_source" varchar(32) COLLATE "pg_catalog"."default",
  "item_id" varchar(45) COLLATE "pg_catalog"."default" NOT NULL,
  "cat_id" varchar(45) COLLATE "pg_catalog"."default" NOT NULL
)
;
COMMENT ON COLUMN "public"."_import_1cv1_items_cats"."pk" IS 'PK';
COMMENT ON COLUMN "public"."_import_1cv1_items_cats"."item_id" IS 'ИД товара';
COMMENT ON COLUMN "public"."_import_1cv1_items_cats"."cat_id" IS 'ИД категории';
COMMENT ON TABLE "public"."_import_1cv1_items_cats" IS 'Сырые импортированные категории товаров';

-- ----------------------------
-- Table structure for _import_1cv1_items_prices
-- ----------------------------
DROP TABLE IF EXISTS "public"."_import_1cv1_items_prices";
CREATE TABLE "public"."_import_1cv1_items_prices" (
  "pk" int8 NOT NULL GENERATED BY DEFAULT AS IDENTITY (
INCREMENT 1
MINVALUE  1
MAXVALUE 9223372036854775807
START 103430
),
  "ds_source" varchar(32) COLLATE "pg_catalog"."default",
  "item_id" varchar(45) COLLATE "pg_catalog"."default",
  "price_type" varchar(64) COLLATE "pg_catalog"."default",
  "price_currency" varchar(3) COLLATE "pg_catalog"."default",
  "price" numeric(8,2) DEFAULT 0.00
)
;
COMMENT ON COLUMN "public"."_import_1cv1_items_prices"."pk" IS 'PK';
COMMENT ON COLUMN "public"."_import_1cv1_items_prices"."item_id" IS 'ИД товара';
COMMENT ON COLUMN "public"."_import_1cv1_items_prices"."price_type" IS 'Тип цены';
COMMENT ON COLUMN "public"."_import_1cv1_items_prices"."price" IS 'Цена';
COMMENT ON TABLE "public"."_import_1cv1_items_prices" IS 'Сырые импортированные цены товаров';

-- ----------------------------
-- Table structure for access_rights
-- ----------------------------
DROP TABLE IF EXISTS "public"."access_rights";
CREATE TABLE "public"."access_rights" (
  "role" varchar(64) COLLATE "pg_catalog"."default" NOT NULL,
  "description" text COLLATE "pg_catalog"."default",
  "allow" text COLLATE "pg_catalog"."default",
  "deny" text COLLATE "pg_catalog"."default"
)
;
COMMENT ON COLUMN "public"."access_rights"."role" IS 'Роль пользователя';
COMMENT ON COLUMN "public"."access_rights"."description" IS 'Описание роли пользователя';
COMMENT ON COLUMN "public"."access_rights"."allow" IS 'Разрешающие правила';
COMMENT ON COLUMN "public"."access_rights"."deny" IS 'Запрещающие правила (имеют приоритет над разрешающими)';
COMMENT ON TABLE "public"."access_rights" IS 'Права доступа пользователей';

-- ----------------------------
-- Table structure for addresses
-- ----------------------------
DROP TABLE IF EXISTS "public"."addresses";
CREATE TABLE "public"."addresses" (
  "id" int4 NOT NULL GENERATED BY DEFAULT AS IDENTITY (
INCREMENT 1
MINVALUE  1
MAXVALUE 2147483647
START 545
),
  "uid" int4 NOT NULL,
  "country" varchar(3) COLLATE "pg_catalog"."default" NOT NULL,
  "city" varchar(128) COLLATE "pg_catalog"."default" NOT NULL,
  "index" varchar(32) COLLATE "pg_catalog"."default" NOT NULL,
  "phone" varchar(32) COLLATE "pg_catalog"."default" NOT NULL,
  "address" varchar(256) COLLATE "pg_catalog"."default" NOT NULL,
  "firstname" varchar(32) COLLATE "pg_catalog"."default",
  "patroname" varchar(128) COLLATE "pg_catalog"."default",
  "lastname" varchar(128) COLLATE "pg_catalog"."default",
  "region" varchar(500) COLLATE "pg_catalog"."default",
  "enabled" int2 NOT NULL DEFAULT 1,
  "is_delivery_point" int2 DEFAULT 0
)
;
COMMENT ON COLUMN "public"."addresses"."uid" IS 'id пользователя';
COMMENT ON COLUMN "public"."addresses"."country" IS 'Страна';
COMMENT ON COLUMN "public"."addresses"."city" IS 'Город';
COMMENT ON COLUMN "public"."addresses"."index" IS 'Почтовый индекс';
COMMENT ON COLUMN "public"."addresses"."phone" IS 'Телефон';
COMMENT ON COLUMN "public"."addresses"."address" IS 'Улица, дом, квартира';
COMMENT ON COLUMN "public"."addresses"."firstname" IS 'Имя';
COMMENT ON COLUMN "public"."addresses"."patroname" IS 'Отчество';
COMMENT ON COLUMN "public"."addresses"."lastname" IS 'Фамилия';
COMMENT ON COLUMN "public"."addresses"."region" IS 'Регион';
COMMENT ON COLUMN "public"."addresses"."enabled" IS 'Включен ли адрес';
COMMENT ON COLUMN "public"."addresses"."is_delivery_point" IS 'Адрес пункта выдачи товара';
COMMENT ON TABLE "public"."addresses" IS 'Адреса пользователей';

-- ----------------------------
-- Table structure for api
-- ----------------------------
DROP TABLE IF EXISTS "public"."api";
CREATE TABLE "public"."api" (
  "function" varchar(128) COLLATE "pg_catalog"."default" NOT NULL,
  "description" text COLLATE "pg_catalog"."default",
  "query" text COLLATE "pg_catalog"."default",
  "enabled" int2 NOT NULL DEFAULT 0
)
;
COMMENT ON COLUMN "public"."api"."function" IS 'Имя функции';
COMMENT ON COLUMN "public"."api"."description" IS 'Описание';
COMMENT ON COLUMN "public"."api"."query" IS 'SQL-запрос';
COMMENT ON COLUMN "public"."api"."enabled" IS 'Включено';
COMMENT ON TABLE "public"."api" IS 'API сайта';

-- ----------------------------
-- Table structure for banners
-- ----------------------------
DROP TABLE IF EXISTS "public"."banners";
CREATE TABLE "public"."banners" (
  "id" int4 NOT NULL GENERATED BY DEFAULT AS IDENTITY (
INCREMENT 1
MINVALUE  1
MAXVALUE 2147483647
START 54
),
  "front_theme" varchar(64) COLLATE "pg_catalog"."default",
  "img_src" varchar(1024) COLLATE "pg_catalog"."default" NOT NULL,
  "html_content" text COLLATE "pg_catalog"."default",
  "href" varchar(1024) COLLATE "pg_catalog"."default" NOT NULL,
  "title" varchar(256) COLLATE "pg_catalog"."default" NOT NULL,
  "enabled" int4 NOT NULL DEFAULT 0,
  "banner_order" int4 DEFAULT 0
)
;
COMMENT ON COLUMN "public"."banners"."id" IS 'ID';
COMMENT ON COLUMN "public"."banners"."front_theme" IS 'Тема фронта';
COMMENT ON COLUMN "public"."banners"."img_src" IS 'Путь к изображению';
COMMENT ON COLUMN "public"."banners"."html_content" IS 'HTML-код баннера';
COMMENT ON COLUMN "public"."banners"."href" IS 'Ссылка';
COMMENT ON COLUMN "public"."banners"."title" IS 'Title';
COMMENT ON COLUMN "public"."banners"."enabled" IS 'Вкл';
COMMENT ON TABLE "public"."banners" IS 'Баннеры';

-- ----------------------------
-- Table structure for banrules
-- ----------------------------
DROP TABLE IF EXISTS "public"."banrules";
CREATE TABLE "public"."banrules" (
  "id" int4 NOT NULL GENERATED BY DEFAULT AS IDENTITY (
INCREMENT 1
MINVALUE  1
MAXVALUE 2147483647
START 5
),
  "description" text COLLATE "pg_catalog"."default",
  "request_rule" varchar(4000) COLLATE "pg_catalog"."default",
  "rule_order" int4 DEFAULT 0,
  "enabled" int4 DEFAULT 0
)
;
COMMENT ON COLUMN "public"."banrules"."id" IS 'ID';
COMMENT ON COLUMN "public"."banrules"."description" IS 'Описание';
COMMENT ON COLUMN "public"."banrules"."request_rule" IS 'Условие запроса';
COMMENT ON COLUMN "public"."banrules"."rule_order" IS 'Порядок отработки правила';
COMMENT ON TABLE "public"."banrules" IS 'Правила HTTP request - фильтра';

-- ----------------------------
-- Table structure for bills
-- ----------------------------
DROP TABLE IF EXISTS "public"."bills";
CREATE TABLE "public"."bills" (
  "id" int4 NOT NULL GENERATED BY DEFAULT AS IDENTITY (
INCREMENT 1
MINVALUE  1
MAXVALUE 2147483647
START 1
),
  "tariff_object_id" int4 NOT NULL,
  "status" varchar(128) COLLATE "pg_catalog"."default" NOT NULL DEFAULT 'IN_PROCESS'::character varying,
  "date" timestamptz(6) NOT NULL DEFAULT now(),
  "manager_id" int4 NOT NULL,
  "tariff_id" int4 NOT NULL,
  "summ" numeric(12,2) DEFAULT 0,
  "manual_summ" numeric(12,2) DEFAULT NULL::numeric,
  "frozen" int2 DEFAULT 0,
  "code" varchar(32) COLLATE "pg_catalog"."default"
)
;
COMMENT ON COLUMN "public"."bills"."id" IS 'ID счёта (bid в связанных таблицах)';
COMMENT ON COLUMN "public"."bills"."tariff_object_id" IS 'ID объекта, на который выставлен счёт (это может быть прибор, участок и т.п.) - определяется через тариф!';
COMMENT ON COLUMN "public"."bills"."status" IS 'ID (value) статуса счёта';
COMMENT ON COLUMN "public"."bills"."date" IS 'Дата выставления счёта';
COMMENT ON COLUMN "public"."bills"."manager_id" IS 'UID менеджера, выставившего счтёт';
COMMENT ON COLUMN "public"."bills"."tariff_id" IS 'Сервис, услуга или ресурс, за который выставляется счёт';
COMMENT ON COLUMN "public"."bills"."summ" IS 'Сумма счёта';
COMMENT ON COLUMN "public"."bills"."manual_summ" IS 'Сумма счёта вручную';
COMMENT ON COLUMN "public"."bills"."frozen" IS 'Счёт проверен и подтверждён, изменения заблокированы';
COMMENT ON TABLE "public"."bills" IS 'Счета';

-- ----------------------------
-- Table structure for bills_comments
-- ----------------------------
DROP TABLE IF EXISTS "public"."bills_comments";
CREATE TABLE "public"."bills_comments" (
  "id" int8 NOT NULL GENERATED BY DEFAULT AS IDENTITY (
INCREMENT 1
MINVALUE  1
MAXVALUE 9223372036854775807
START 1
),
  "bid" int4 NOT NULL,
  "uid" int4 NOT NULL,
  "date" timestamptz(6) NOT NULL,
  "message" text COLLATE "pg_catalog"."default" NOT NULL,
  "internal" int2 NOT NULL DEFAULT 0
)
;
COMMENT ON COLUMN "public"."bills_comments"."id" IS 'ID комментария';
COMMENT ON COLUMN "public"."bills_comments"."bid" IS 'ID счёта';
COMMENT ON COLUMN "public"."bills_comments"."uid" IS 'Автор сообщения';
COMMENT ON COLUMN "public"."bills_comments"."date" IS 'Дата сообщения';
COMMENT ON COLUMN "public"."bills_comments"."message" IS 'Текст сообщения';
COMMENT ON COLUMN "public"."bills_comments"."internal" IS 'Внутреннее сообщение (не видно клиентам)';
COMMENT ON TABLE "public"."bills_comments" IS 'Комментарии к счёту';

-- ----------------------------
-- Table structure for bills_comments_attaches
-- ----------------------------
DROP TABLE IF EXISTS "public"."bills_comments_attaches";
CREATE TABLE "public"."bills_comments_attaches" (
  "id" int8 NOT NULL GENERATED BY DEFAULT AS IDENTITY (
INCREMENT 1
MINVALUE  1
MAXVALUE 9223372036854775807
START 1
),
  "comment_id" int8 NOT NULL,
  "attach" bytea
)
;
COMMENT ON COLUMN "public"."bills_comments_attaches"."id" IS 'ID приложения к сообщению';
COMMENT ON COLUMN "public"."bills_comments_attaches"."comment_id" IS 'ID комментария';
COMMENT ON COLUMN "public"."bills_comments_attaches"."attach" IS 'Двичное тело приложения, строго картинка jpg или png';
COMMENT ON TABLE "public"."bills_comments_attaches" IS 'Изображения комментариев к счетам';

-- ----------------------------
-- Table structure for bills_payments
-- ----------------------------
DROP TABLE IF EXISTS "public"."bills_payments";
CREATE TABLE "public"."bills_payments" (
  "id" int4 NOT NULL GENERATED BY DEFAULT AS IDENTITY (
INCREMENT 1
MINVALUE  1
MAXVALUE 2147483647
START 1
),
  "bid" int4 NOT NULL,
  "uid" int4 NOT NULL,
  "summ" numeric(12,2) NOT NULL,
  "date" timestamptz(6) NOT NULL,
  "descr" text COLLATE "pg_catalog"."default"
)
;
COMMENT ON COLUMN "public"."bills_payments"."id" IS 'ID платежа';
COMMENT ON COLUMN "public"."bills_payments"."bid" IS 'ID счёта';
COMMENT ON COLUMN "public"."bills_payments"."uid" IS 'ID пользователя или менеджера, проведшего платёж';
COMMENT ON COLUMN "public"."bills_payments"."summ" IS 'Сумма платежа во внутренней валюте';
COMMENT ON COLUMN "public"."bills_payments"."date" IS 'Дата проведения платежа';
COMMENT ON COLUMN "public"."bills_payments"."descr" IS 'Описание платежа';
COMMENT ON TABLE "public"."bills_payments" IS 'Таблица платежей по счетам';

-- ----------------------------
-- Table structure for bills_statuses
-- ----------------------------
DROP TABLE IF EXISTS "public"."bills_statuses";
CREATE TABLE "public"."bills_statuses" (
  "id" int4 NOT NULL GENERATED BY DEFAULT AS IDENTITY (
INCREMENT 1
MINVALUE  1
MAXVALUE 2147483647
START 32
),
  "value" varchar(128) COLLATE "pg_catalog"."default" NOT NULL,
  "name" varchar(256) COLLATE "pg_catalog"."default" NOT NULL,
  "descr" text COLLATE "pg_catalog"."default",
  "manual" int2 DEFAULT 0,
  "aplyment_criteria" text COLLATE "pg_catalog"."default",
  "auto_criteria" text COLLATE "pg_catalog"."default",
  "order_in_process" int2 DEFAULT 100,
  "enabled" int2 DEFAULT 0,
  "parent_status_value" varchar(128) COLLATE "pg_catalog"."default"
)
;
COMMENT ON COLUMN "public"."bills_statuses"."id" IS 'id записи статуса счёта. Внимание, в расчётах не используется!';
COMMENT ON COLUMN "public"."bills_statuses"."value" IS 'ID статуса счёта';
COMMENT ON COLUMN "public"."bills_statuses"."descr" IS 'Описание статуса счёта';
COMMENT ON COLUMN "public"."bills_statuses"."manual" IS 'Устанавливается ли статус вручную';
COMMENT ON COLUMN "public"."bills_statuses"."aplyment_criteria" IS 'Условие применения статуса к заказу';
COMMENT ON COLUMN "public"."bills_statuses"."auto_criteria" IS 'Условие вычисления статуса';
COMMENT ON COLUMN "public"."bills_statuses"."order_in_process" IS 'Порядок статуса в бизнес-процессе';
COMMENT ON COLUMN "public"."bills_statuses"."enabled" IS 'Включен ли статус';
COMMENT ON COLUMN "public"."bills_statuses"."parent_status_value" IS 'Value статуса, определяющего поведение';
COMMENT ON TABLE "public"."bills_statuses" IS 'Статусы счёта';

-- ----------------------------
-- Table structure for blog_categories
-- ----------------------------
DROP TABLE IF EXISTS "public"."blog_categories";
CREATE TABLE "public"."blog_categories" (
  "id" int4 NOT NULL GENERATED BY DEFAULT AS IDENTITY (
INCREMENT 1
MINVALUE  1
MAXVALUE 2147483647
START 11
),
  "name" varchar(255) COLLATE "pg_catalog"."default",
  "description" text COLLATE "pg_catalog"."default",
  "enabled" int2 NOT NULL DEFAULT 1,
  "access_rights_post" varchar(255) COLLATE "pg_catalog"."default",
  "access_rights_comment" varchar(255) COLLATE "pg_catalog"."default"
)
;
COMMENT ON COLUMN "public"."blog_categories"."id" IS 'PK';
COMMENT ON COLUMN "public"."blog_categories"."name" IS 'Категория';
COMMENT ON COLUMN "public"."blog_categories"."description" IS 'Описание';
COMMENT ON COLUMN "public"."blog_categories"."enabled" IS 'Вкл';
COMMENT ON COLUMN "public"."blog_categories"."access_rights_post" IS 'Права на создание поста (роли и id пользователей, через разделитель)';
COMMENT ON COLUMN "public"."blog_categories"."access_rights_comment" IS 'Права на создание коммента (роли и id пользователей, через разделитель)';
COMMENT ON TABLE "public"."blog_categories" IS 'Категории блога';

-- ----------------------------
-- Table structure for blog_comments
-- ----------------------------
DROP TABLE IF EXISTS "public"."blog_comments";
CREATE TABLE "public"."blog_comments" (
  "id" int4 NOT NULL GENERATED BY DEFAULT AS IDENTITY (
INCREMENT 1
MINVALUE  1
MAXVALUE 2147483647
START 15
),
  "uid" int4 NOT NULL DEFAULT 0,
  "post_id" int4 NOT NULL,
  "created" timestamptz(6) NOT NULL,
  "title" varchar(255) COLLATE "pg_catalog"."default" NOT NULL,
  "body" text COLLATE "pg_catalog"."default",
  "enabled" int2 DEFAULT 1,
  "rating" int2 DEFAULT 0
)
;
COMMENT ON COLUMN "public"."blog_comments"."id" IS 'PK';
COMMENT ON COLUMN "public"."blog_comments"."uid" IS 'ID пользователя';
COMMENT ON COLUMN "public"."blog_comments"."post_id" IS 'ID поста';
COMMENT ON COLUMN "public"."blog_comments"."created" IS 'Создано';
COMMENT ON COLUMN "public"."blog_comments"."title" IS 'Заголовок';
COMMENT ON COLUMN "public"."blog_comments"."enabled" IS 'Вкл';
COMMENT ON COLUMN "public"."blog_comments"."rating" IS 'Рейтинг поста от 0 до 5';
COMMENT ON TABLE "public"."blog_comments" IS 'Комментарии к постам блогов';

-- ----------------------------
-- Table structure for blog_posts
-- ----------------------------
DROP TABLE IF EXISTS "public"."blog_posts";
CREATE TABLE "public"."blog_posts" (
  "id" int4 NOT NULL GENERATED BY DEFAULT AS IDENTITY (
INCREMENT 1
MINVALUE  1
MAXVALUE 2147483647
START 41
),
  "uid" int4 NOT NULL DEFAULT 0,
  "category_id" int4 NOT NULL DEFAULT 0,
  "title" varchar(255) COLLATE "pg_catalog"."default",
  "tags" varchar(255) COLLATE "pg_catalog"."default",
  "body" text COLLATE "pg_catalog"."default" NOT NULL,
  "created" timestamptz(6) NOT NULL,
  "start_date" timestamptz(6),
  "end_date" timestamptz(6),
  "enabled" int2 NOT NULL DEFAULT 1,
  "comments_enabled" int2 NOT NULL DEFAULT 1
)
;
COMMENT ON COLUMN "public"."blog_posts"."id" IS 'PK';
COMMENT ON COLUMN "public"."blog_posts"."uid" IS 'ID пользователя';
COMMENT ON COLUMN "public"."blog_posts"."category_id" IS 'ID категории';
COMMENT ON COLUMN "public"."blog_posts"."title" IS 'Заголовок';
COMMENT ON COLUMN "public"."blog_posts"."tags" IS 'Тэги';
COMMENT ON COLUMN "public"."blog_posts"."body" IS 'Сообщение';
COMMENT ON COLUMN "public"."blog_posts"."created" IS 'Создано';
COMMENT ON COLUMN "public"."blog_posts"."start_date" IS 'Начало публикации';
COMMENT ON COLUMN "public"."blog_posts"."end_date" IS 'Конец публикации';
COMMENT ON COLUMN "public"."blog_posts"."enabled" IS 'Вкл';
COMMENT ON COLUMN "public"."blog_posts"."comments_enabled" IS 'Вкл комментарии';
COMMENT ON TABLE "public"."blog_posts" IS 'Посты блога';

-- ----------------------------
-- Table structure for brands
-- ----------------------------
DROP TABLE IF EXISTS "public"."brands";
CREATE TABLE "public"."brands" (
  "id" int8 NOT NULL GENERATED BY DEFAULT AS IDENTITY (
INCREMENT 1
MINVALUE  1
MAXVALUE 9223372036854775807
START 564
),
  "name" varchar(128) COLLATE "pg_catalog"."default" NOT NULL,
  "enabled" int2 NOT NULL DEFAULT 0,
  "img_src" varchar(256) COLLATE "pg_catalog"."default",
  "vid" int8,
  "query" varchar(256) COLLATE "pg_catalog"."default",
  "url" varchar(512) COLLATE "pg_catalog"."default" NOT NULL
)
;
COMMENT ON TABLE "public"."brands" IS 'Бренды';

-- ----------------------------
-- Table structure for cache
-- ----------------------------
DROP TABLE IF EXISTS "public"."cache";
CREATE TABLE "public"."cache" (
  "id" char(128) COLLATE "pg_catalog"."default" NOT NULL,
  "expire" int4 DEFAULT 0,
  "value" bytea
)
;
COMMENT ON TABLE "public"."cache" IS 'Общий кэш';

-- ----------------------------
-- Table structure for cart
-- ----------------------------
DROP TABLE IF EXISTS "public"."cart";
CREATE TABLE "public"."cart" (
  "id" int8 NOT NULL GENERATED BY DEFAULT AS IDENTITY (
INCREMENT 1
MINVALUE  1
MAXVALUE 9223372036854775807
START 55
),
  "uid" int4 NOT NULL DEFAULT 0,
  "cid" varchar(45) COLLATE "pg_catalog"."default",
  "iid" varchar(45) COLLATE "pg_catalog"."default" NOT NULL,
  "num" int4 NOT NULL DEFAULT 0,
  "price" numeric(12,2) DEFAULT 0.00,
  "express_fee" numeric(12,2) DEFAULT 0.00,
  "pic_url" varchar(256) COLLATE "pg_catalog"."default",
  "weight" numeric(12,2) DEFAULT 0.00,
  "input_props" varchar(512) COLLATE "pg_catalog"."default" NOT NULL,
  "desc" text COLLATE "pg_catalog"."default",
  "date" timestamptz(6),
  "guest_uid" varchar(32) COLLATE "pg_catalog"."default",
  "store" int2 NOT NULL DEFAULT 0,
  "order" int2 NOT NULL DEFAULT 1,
  "updated" timestamptz(6),
  "ds_source" varchar(32) COLLATE "pg_catalog"."default",
  "ds_type" varchar(16) COLLATE "pg_catalog"."default"
)
;
COMMENT ON COLUMN "public"."cart"."price" IS 'Цена товара на таобао';
COMMENT ON COLUMN "public"."cart"."express_fee" IS 'Стоимость доставки одного товара';
COMMENT ON COLUMN "public"."cart"."pic_url" IS 'Изображение товара';
COMMENT ON COLUMN "public"."cart"."store" IS 'Сохранять ли лот в корзине после заказа';
COMMENT ON COLUMN "public"."cart"."order" IS 'Включать ли лот в заказ';
COMMENT ON COLUMN "public"."cart"."updated" IS 'Время последнего обновления информации о товаре';
COMMENT ON COLUMN "public"."cart"."ds_source" IS 'Тип источника данных категории';
COMMENT ON TABLE "public"."cart" IS 'Корзины пользователей';

-- ----------------------------
-- Table structure for categories_ext
-- ----------------------------
DROP TABLE IF EXISTS "public"."categories_ext";
CREATE TABLE "public"."categories_ext" (
  "id" int8 NOT NULL GENERATED BY DEFAULT AS IDENTITY (
INCREMENT 1
MINVALUE  1
MAXVALUE 9223372036854775807
START 1732781
),
  "ds_source" varchar(32) COLLATE "pg_catalog"."default",
  "cid" varchar(45) COLLATE "pg_catalog"."default",
  "ru" varchar(512) COLLATE "pg_catalog"."default",
  "en" varchar(512) COLLATE "pg_catalog"."default",
  "parent" int8 DEFAULT '-1'::integer,
  "status" int2 DEFAULT 1,
  "url" varchar(512) COLLATE "pg_catalog"."default",
  "zh" varchar(512) COLLATE "pg_catalog"."default",
  "query" varchar(512) COLLATE "pg_catalog"."default",
  "level" int4,
  "order_in_level" int4 DEFAULT 0,
  "manual" int4 DEFAULT 0,
  "decorate" text COLLATE "pg_catalog"."default"
)
;
COMMENT ON COLUMN "public"."categories_ext"."ds_source" IS 'Тип источника данных категории';
COMMENT ON COLUMN "public"."categories_ext"."decorate" IS 'html для декорирования категории';

-- ----------------------------
-- Table structure for categories_ext_source
-- ----------------------------
DROP TABLE IF EXISTS "public"."categories_ext_source";
CREATE TABLE "public"."categories_ext_source" (
  "id" int8 NOT NULL GENERATED BY DEFAULT AS IDENTITY (
INCREMENT 1
MINVALUE  1
MAXVALUE 9223372036854775807
START 43753
),
  "ds_source" varchar(32) COLLATE "pg_catalog"."default" NOT NULL,
  "cid" varchar(45) COLLATE "pg_catalog"."default",
  "ru" varchar(512) COLLATE "pg_catalog"."default",
  "en" varchar(512) COLLATE "pg_catalog"."default",
  "parent" int8 DEFAULT '-1'::integer,
  "status" int2 DEFAULT 1,
  "url" varchar(512) COLLATE "pg_catalog"."default",
  "zh" varchar(512) COLLATE "pg_catalog"."default",
  "query" varchar(512) COLLATE "pg_catalog"."default",
  "level" int4,
  "order_in_level" int4 DEFAULT 0,
  "manual" int4 DEFAULT 0,
  "decorate" text COLLATE "pg_catalog"."default"
)
;
COMMENT ON COLUMN "public"."categories_ext_source"."ds_source" IS 'Тип источника данных категории';
COMMENT ON COLUMN "public"."categories_ext_source"."decorate" IS 'html для декорирования категории';
COMMENT ON TABLE "public"."categories_ext_source" IS 'Поисковые категории';

-- ----------------------------
-- Table structure for categories_ext_sources
-- ----------------------------
DROP TABLE IF EXISTS "public"."categories_ext_sources";
CREATE TABLE "public"."categories_ext_sources" (
  "ds_source" varchar(32) COLLATE "pg_catalog"."default" NOT NULL,
  "description" text COLLATE "pg_catalog"."default",
  "enabled" int2 DEFAULT 0,
  "prefered_search" varchar(255) COLLATE "pg_catalog"."default",
  "original_lang" varchar(3) COLLATE "pg_catalog"."default" DEFAULT 'zh'::character varying
)
;
COMMENT ON COLUMN "public"."categories_ext_sources"."ds_source" IS 'PK';
COMMENT ON COLUMN "public"."categories_ext_sources"."description" IS 'Описание источника данных';
COMMENT ON COLUMN "public"."categories_ext_sources"."enabled" IS 'Вкл.';
COMMENT ON COLUMN "public"."categories_ext_sources"."original_lang" IS 'Язык оригинала источника';
COMMENT ON TABLE "public"."categories_ext_sources" IS 'Источники данных товаров';

-- ----------------------------
-- Table structure for categories_ext_storage
-- ----------------------------
DROP TABLE IF EXISTS "public"."categories_ext_storage";
CREATE TABLE "public"."categories_ext_storage" (
  "pk" int8 NOT NULL GENERATED BY DEFAULT AS IDENTITY (
INCREMENT 1
MINVALUE  1
MAXVALUE 9223372036854775807
START 11704
),
  "store_name" varchar(512) COLLATE "pg_catalog"."default",
  "store_date" timestamptz(6) NOT NULL,
  "id" int8 NOT NULL,
  "cid" varchar(45) COLLATE "pg_catalog"."default",
  "ru" varchar(512) COLLATE "pg_catalog"."default",
  "en" varchar(512) COLLATE "pg_catalog"."default",
  "parent" int8 DEFAULT '-1'::integer,
  "status" int2 DEFAULT 1,
  "url" varchar(512) COLLATE "pg_catalog"."default",
  "zh" varchar(512) COLLATE "pg_catalog"."default",
  "query" varchar(512) COLLATE "pg_catalog"."default",
  "level" int4,
  "order_in_level" int4 DEFAULT 0,
  "manual" int4 DEFAULT 0,
  "decorate" text COLLATE "pg_catalog"."default",
  "ds_source" varchar(32) COLLATE "pg_catalog"."default"
)
;
COMMENT ON COLUMN "public"."categories_ext_storage"."decorate" IS 'html для декорирования категории';
COMMENT ON COLUMN "public"."categories_ext_storage"."ds_source" IS 'Тип источника данных категории';
COMMENT ON TABLE "public"."categories_ext_storage" IS 'Хранилище поисковых категорий';

-- ----------------------------
-- Table structure for categories_prices
-- ----------------------------
DROP TABLE IF EXISTS "public"."categories_prices";
CREATE TABLE "public"."categories_prices" (
  "id" int8 NOT NULL GENERATED BY DEFAULT AS IDENTITY (
INCREMENT 1
MINVALUE  1
MAXVALUE 9223372036854775807
START 233886
),
  "cid" varchar(45) COLLATE "pg_catalog"."default" NOT NULL,
  "query" varchar(220) COLLATE "pg_catalog"."default",
  "begin0" numeric(12,2) NOT NULL,
  "end0" numeric(12,2) NOT NULL,
  "percent0" numeric(4,2) NOT NULL,
  "begin1" numeric(12,2) NOT NULL,
  "end1" numeric(12,2) NOT NULL,
  "percent1" numeric(4,2) NOT NULL,
  "begin2" numeric(12,2) NOT NULL,
  "end2" numeric(12,2) NOT NULL,
  "percent2" numeric(4,2) NOT NULL,
  "begin3" numeric(12,2) NOT NULL,
  "end3" numeric(12,2) NOT NULL,
  "percent3" numeric(4,2) NOT NULL,
  "begin4" numeric(12,2) NOT NULL,
  "end4" numeric(12,2) NOT NULL,
  "percent4" numeric(4,2) NOT NULL,
  "date" timestamptz(6) NOT NULL,
  "ds_source" varchar(32) COLLATE "pg_catalog"."default"
)
;
COMMENT ON COLUMN "public"."categories_prices"."date" IS 'Дата последнего обновления';
COMMENT ON COLUMN "public"."categories_prices"."ds_source" IS 'Тип источника данных категории';
COMMENT ON TABLE "public"."categories_prices" IS 'Распределение цен по категориям';

-- ----------------------------
-- Table structure for classifier
-- ----------------------------
DROP TABLE IF EXISTS "public"."classifier";
CREATE TABLE "public"."classifier" (
  "id" int4 NOT NULL GENERATED BY DEFAULT AS IDENTITY (
INCREMENT 1
MINVALUE  1
MAXVALUE 2147483647
START 14900
),
  "cid" varchar(45) COLLATE "pg_catalog"."default",
  "ru" varchar(512) COLLATE "pg_catalog"."default",
  "en" varchar(512) COLLATE "pg_catalog"."default",
  "parent" varchar(45) COLLATE "pg_catalog"."default" DEFAULT '0'::character varying,
  "is_parent" int2 DEFAULT 0,
  "onmain" int2 DEFAULT 0,
  "status" int2 DEFAULT 1,
  "translated" int2 DEFAULT 0,
  "url" varchar(512) COLLATE "pg_catalog"."default",
  "zh" varchar(512) COLLATE "pg_catalog"."default",
  "query" varchar(512) COLLATE "pg_catalog"."default",
  "level" int4,
  "ds_source" varchar(32) COLLATE "pg_catalog"."default" NOT NULL
)
;
COMMENT ON TABLE "public"."classifier" IS 'Классификатор товаров';

-- ----------------------------
-- Table structure for classifier_props
-- ----------------------------
DROP TABLE IF EXISTS "public"."classifier_props";
CREATE TABLE "public"."classifier_props" (
  "id" int4 NOT NULL GENERATED BY DEFAULT AS IDENTITY (
INCREMENT 1
MINVALUE  1
MAXVALUE 2147483647
START 66505
),
  "cid" varchar(45) COLLATE "pg_catalog"."default",
  "pid" int8 NOT NULL,
  "zh" varchar(255) COLLATE "pg_catalog"."default",
  "ru" varchar(255) COLLATE "pg_catalog"."default",
  "en" varchar(255) COLLATE "pg_catalog"."default",
  "hidden" int2,
  "is_sale_prop" int2,
  "is_input_prop" int2,
  "is_key_prop" int2,
  "is_color_prop" int2,
  "is_enum_prop" int2,
  "is_item_prop" int2,
  "must" int2,
  "multi" int2,
  "status" int2
)
;
COMMENT ON COLUMN "public"."classifier_props"."id" IS 'PK';
COMMENT ON COLUMN "public"."classifier_props"."pid" IS 'ID свойства категории таобао';
COMMENT ON COLUMN "public"."classifier_props"."zh" IS 'Китайское название свойства';
COMMENT ON COLUMN "public"."classifier_props"."ru" IS 'Русское название свойства';
COMMENT ON COLUMN "public"."classifier_props"."en" IS 'Английское название свойства';
COMMENT ON COLUMN "public"."classifier_props"."hidden" IS 'Скрытое свойство?';
COMMENT ON COLUMN "public"."classifier_props"."is_sale_prop" IS 'Торговое свойство?';
COMMENT ON COLUMN "public"."classifier_props"."is_input_prop" IS 'Свойство введено вручную продавцом?';
COMMENT ON COLUMN "public"."classifier_props"."is_key_prop" IS 'Ключевое свойство?';
COMMENT ON COLUMN "public"."classifier_props"."is_color_prop" IS 'Цвет?';
COMMENT ON COLUMN "public"."classifier_props"."is_enum_prop" IS 'Перечислимое свойство?';
COMMENT ON COLUMN "public"."classifier_props"."is_item_prop" IS 'Свойство, описывающее товар?';
COMMENT ON COLUMN "public"."classifier_props"."must" IS 'Обязательное свойство?';
COMMENT ON COLUMN "public"."classifier_props"."multi" IS 'Влияет на другие свойства?';
COMMENT ON COLUMN "public"."classifier_props"."status" IS 'Включено?';
COMMENT ON TABLE "public"."classifier_props" IS 'Свойства категорий товаров таобао с переводами';

-- ----------------------------
-- Table structure for classifier_props_vals
-- ----------------------------
DROP TABLE IF EXISTS "public"."classifier_props_vals";
CREATE TABLE "public"."classifier_props_vals" (
  "id" int4 NOT NULL GENERATED BY DEFAULT AS IDENTITY (
INCREMENT 1
MINVALUE  1
MAXVALUE 2147483647
START 937630
),
  "cid" varchar(45) COLLATE "pg_catalog"."default",
  "pid" int8 NOT NULL,
  "vid" int8 NOT NULL,
  "zh" varchar(255) COLLATE "pg_catalog"."default",
  "ru" varchar(255) COLLATE "pg_catalog"."default",
  "en" varchar(255) COLLATE "pg_catalog"."default"
)
;
COMMENT ON COLUMN "public"."classifier_props_vals"."id" IS 'PK';
COMMENT ON COLUMN "public"."classifier_props_vals"."pid" IS 'ID свойства';
COMMENT ON COLUMN "public"."classifier_props_vals"."vid" IS 'ID значения свойства';
COMMENT ON COLUMN "public"."classifier_props_vals"."zh" IS 'Китайское название';
COMMENT ON COLUMN "public"."classifier_props_vals"."ru" IS 'Русское название';
COMMENT ON COLUMN "public"."classifier_props_vals"."en" IS 'Английское название';
COMMENT ON TABLE "public"."classifier_props_vals" IS 'Значения свойств категорий товаров таобао с переводами';

-- ----------------------------
-- Table structure for cms_content_history
-- ----------------------------
DROP TABLE IF EXISTS "public"."cms_content_history";
CREATE TABLE "public"."cms_content_history" (
  "id" int8 NOT NULL GENERATED BY DEFAULT AS IDENTITY (
INCREMENT 1
MINVALUE  1
MAXVALUE 9223372036854775807
START 164
),
  "table_name" varchar(255) COLLATE "pg_catalog"."default" NOT NULL,
  "content_id" varchar(255) COLLATE "pg_catalog"."default" NOT NULL,
  "lang" varchar(8) COLLATE "pg_catalog"."default" NOT NULL,
  "date" timestamptz(6) NOT NULL,
  "content" text COLLATE "pg_catalog"."default"
)
;
COMMENT ON COLUMN "public"."cms_content_history"."id" IS 'PK';
COMMENT ON COLUMN "public"."cms_content_history"."table_name" IS 'Имя таблицы CMS';
COMMENT ON COLUMN "public"."cms_content_history"."content_id" IS 'id контента';
COMMENT ON TABLE "public"."cms_content_history" IS 'История изменения контента CMS';

-- ----------------------------
-- Table structure for cms_custom_content
-- ----------------------------
DROP TABLE IF EXISTS "public"."cms_custom_content";
CREATE TABLE "public"."cms_custom_content" (
  "id" int4 NOT NULL GENERATED BY DEFAULT AS IDENTITY (
INCREMENT 1
MINVALUE  1
MAXVALUE 2147483647
START 33
),
  "content_id" varchar(255) COLLATE "pg_catalog"."default",
  "lang" varchar(8) COLLATE "pg_catalog"."default" NOT NULL DEFAULT '*'::character varying,
  "content_data" text COLLATE "pg_catalog"."default",
  "enabled" int2 NOT NULL DEFAULT 0
)
;
COMMENT ON COLUMN "public"."cms_custom_content"."id" IS 'id контента';
COMMENT ON COLUMN "public"."cms_custom_content"."content_id" IS 'Идентификатор кастомного контента';
COMMENT ON COLUMN "public"."cms_custom_content"."lang" IS 'Язык контента';
COMMENT ON COLUMN "public"."cms_custom_content"."content_data" IS 'php-код контента (синтаксис View)';
COMMENT ON TABLE "public"."cms_custom_content" IS 'CMS - кастомный контент';

-- ----------------------------
-- Table structure for cms_email_events
-- ----------------------------
DROP TABLE IF EXISTS "public"."cms_email_events";
CREATE TABLE "public"."cms_email_events" (
  "id" int4 NOT NULL GENERATED BY DEFAULT AS IDENTITY (
INCREMENT 1
MINVALUE  1
MAXVALUE 2147483647
START 35
),
  "template" text COLLATE "pg_catalog"."default",
  "template_sms" text COLLATE "pg_catalog"."default",
  "layout" varchar(255) COLLATE "pg_catalog"."default",
  "class" varchar(255) COLLATE "pg_catalog"."default" NOT NULL,
  "action" varchar(255) COLLATE "pg_catalog"."default" NOT NULL,
  "condition" text COLLATE "pg_catalog"."default",
  "relevant_fields" text COLLATE "pg_catalog"."default",
  "recipients" text COLLATE "pg_catalog"."default",
  "regular" int8 NOT NULL DEFAULT 0,
  "enabled" int4 NOT NULL DEFAULT 0,
  "tests" text COLLATE "pg_catalog"."default"
)
;
COMMENT ON COLUMN "public"."cms_email_events"."template" IS 'Шаблон сообщения (синтаксис View)';
COMMENT ON COLUMN "public"."cms_email_events"."layout" IS 'Оформление (cms: контент блоков в формате email:*)';
COMMENT ON COLUMN "public"."cms_email_events"."class" IS 'Класс события';
COMMENT ON COLUMN "public"."cms_email_events"."action" IS 'Тип события';
COMMENT ON COLUMN "public"."cms_email_events"."condition" IS 'Условие';
COMMENT ON COLUMN "public"."cms_email_events"."recipients" IS 'Получатели';
COMMENT ON COLUMN "public"."cms_email_events"."regular" IS 'Частота повторения, сек (0 - не повторять)';
COMMENT ON COLUMN "public"."cms_email_events"."enabled" IS 'Включено';
COMMENT ON TABLE "public"."cms_email_events" IS 'Контент и параметры почтовых отправлений по различным событи';

-- ----------------------------
-- Table structure for cms_email_unsubscribe
-- ----------------------------
DROP TABLE IF EXISTS "public"."cms_email_unsubscribe";
CREATE TABLE "public"."cms_email_unsubscribe" (
  "uid" int4 NOT NULL,
  "event_id" int4 NOT NULL,
  "date_from" timestamptz(6)
)
;
COMMENT ON COLUMN "public"."cms_email_unsubscribe"."uid" IS 'ID пользователя';
COMMENT ON COLUMN "public"."cms_email_unsubscribe"."event_id" IS 'ID события';
COMMENT ON COLUMN "public"."cms_email_unsubscribe"."date_from" IS 'Дата, с которой работает отписка';
COMMENT ON TABLE "public"."cms_email_unsubscribe" IS 'Отписка от почтовых оповещений (действует 45 дней)';

-- ----------------------------
-- Table structure for cms_knowledge_base
-- ----------------------------
DROP TABLE IF EXISTS "public"."cms_knowledge_base";
CREATE TABLE "public"."cms_knowledge_base" (
  "id" int8 NOT NULL GENERATED BY DEFAULT AS IDENTITY (
INCREMENT 1
MINVALUE  1
MAXVALUE 9223372036854775807
START 19724
),
  "lang" char(2) COLLATE "pg_catalog"."default",
  "tag" varchar(255) COLLATE "pg_catalog"."default",
  "key" text COLLATE "pg_catalog"."default" NOT NULL,
  "value" text COLLATE "pg_catalog"."default" NOT NULL,
  "search" text COLLATE "pg_catalog"."default"
)
;
COMMENT ON COLUMN "public"."cms_knowledge_base"."id" IS 'PK';
COMMENT ON COLUMN "public"."cms_knowledge_base"."lang" IS 'Язык';
COMMENT ON TABLE "public"."cms_knowledge_base" IS 'База знаний';

-- ----------------------------
-- Table structure for cms_knowledge_base_img
-- ----------------------------
DROP TABLE IF EXISTS "public"."cms_knowledge_base_img";
CREATE TABLE "public"."cms_knowledge_base_img" (
  "id" int8 NOT NULL GENERATED BY DEFAULT AS IDENTITY (
INCREMENT 1
MINVALUE  1
MAXVALUE 9223372036854775807
START 95954
),
  "path" varchar(255) COLLATE "pg_catalog"."default" NOT NULL,
  "filename" varchar(255) COLLATE "pg_catalog"."default" NOT NULL,
  "enabled" int2 NOT NULL DEFAULT 1,
  "en" text COLLATE "pg_catalog"."default",
  "zh" text COLLATE "pg_catalog"."default",
  "ru" text COLLATE "pg_catalog"."default"
)
;
COMMENT ON COLUMN "public"."cms_knowledge_base_img"."path" IS 'Путь к файлам';
COMMENT ON COLUMN "public"."cms_knowledge_base_img"."filename" IS 'Имя файла';
COMMENT ON COLUMN "public"."cms_knowledge_base_img"."enabled" IS 'Вкл';
COMMENT ON COLUMN "public"."cms_knowledge_base_img"."en" IS 'Текст для поиска и подбора изображения';
COMMENT ON COLUMN "public"."cms_knowledge_base_img"."zh" IS 'Текст для поиска и подбора изображения';
COMMENT ON COLUMN "public"."cms_knowledge_base_img"."ru" IS 'Текст для поиска и подбора изображения';
COMMENT ON TABLE "public"."cms_knowledge_base_img" IS 'База изображений';

-- ----------------------------
-- Table structure for cms_loaded
-- ----------------------------
DROP TABLE IF EXISTS "public"."cms_loaded";
CREATE TABLE "public"."cms_loaded" (
  "id" int4 NOT NULL GENERATED BY DEFAULT AS IDENTITY (
INCREMENT 1
MINVALUE  1
MAXVALUE 2147483647
START 96
),
  "page_id" varchar(1024) COLLATE "pg_catalog"."default" NOT NULL,
  "content_data" text COLLATE "pg_catalog"."default",
  "title" varchar(1024) COLLATE "pg_catalog"."default",
  "description" varchar(1024) COLLATE "pg_catalog"."default",
  "keywords" varchar(1024) COLLATE "pg_catalog"."default"
)
;
COMMENT ON COLUMN "public"."cms_loaded"."id" IS 'id контента страницы';
COMMENT ON COLUMN "public"."cms_loaded"."page_id" IS 'id страницы контента';
COMMENT ON COLUMN "public"."cms_loaded"."content_data" IS 'php-код контента (синтаксис View)';
COMMENT ON COLUMN "public"."cms_loaded"."title" IS 'title страницы';
COMMENT ON COLUMN "public"."cms_loaded"."description" IS 'description страницы';
COMMENT ON COLUMN "public"."cms_loaded"."keywords" IS 'keywords страницы';
COMMENT ON TABLE "public"."cms_loaded" IS 'Импорт контента';

-- ----------------------------
-- Table structure for cms_menus
-- ----------------------------
DROP TABLE IF EXISTS "public"."cms_menus";
CREATE TABLE "public"."cms_menus" (
  "id" int4 NOT NULL GENERATED BY DEFAULT AS IDENTITY (
INCREMENT 1
MINVALUE  1
MAXVALUE 2147483647
START 5
),
  "menu_id" varchar(255) COLLATE "pg_catalog"."default",
  "menu_data" text COLLATE "pg_catalog"."default",
  "enabled" int2 NOT NULL DEFAULT 0,
  "SEO" int2 NOT NULL DEFAULT 1
)
;
COMMENT ON COLUMN "public"."cms_menus"."id" IS 'PK навигационного меню';
COMMENT ON COLUMN "public"."cms_menus"."menu_id" IS 'Идентификатор меню';
COMMENT ON COLUMN "public"."cms_menus"."menu_data" IS 'php-код меню (синтаксис View)';
COMMENT ON COLUMN "public"."cms_menus"."enabled" IS 'Включено';
COMMENT ON COLUMN "public"."cms_menus"."SEO" IS 'Контент доступен поисковикам';
COMMENT ON TABLE "public"."cms_menus" IS 'CMS-контент меню';

-- ----------------------------
-- Table structure for cms_metatags
-- ----------------------------
DROP TABLE IF EXISTS "public"."cms_metatags";
CREATE TABLE "public"."cms_metatags" (
  "id" int8 NOT NULL GENERATED BY DEFAULT AS IDENTITY (
INCREMENT 1
MINVALUE  1
MAXVALUE 9223372036854775807
START 568947
),
  "lang" char(2) COLLATE "pg_catalog"."default",
  "key" varchar(255) COLLATE "pg_catalog"."default" NOT NULL,
  "tag" varchar(64) COLLATE "pg_catalog"."default" NOT NULL,
  "value" text COLLATE "pg_catalog"."default" NOT NULL
)
;
COMMENT ON COLUMN "public"."cms_metatags"."id" IS 'PK';
COMMENT ON COLUMN "public"."cms_metatags"."lang" IS 'Язык';
COMMENT ON COLUMN "public"."cms_metatags"."key" IS 'Ключ (url или хэш)';
COMMENT ON COLUMN "public"."cms_metatags"."tag" IS 'Тэг';
COMMENT ON TABLE "public"."cms_metatags" IS 'Meta тэги по языку и url или хэшу';

-- ----------------------------
-- Table structure for cms_pages
-- ----------------------------
DROP TABLE IF EXISTS "public"."cms_pages";
CREATE TABLE "public"."cms_pages" (
  "id" int4 NOT NULL GENERATED BY DEFAULT AS IDENTITY (
INCREMENT 1
MINVALUE  1
MAXVALUE 2147483647
START 52
),
  "parent" int4 NOT NULL DEFAULT 1,
  "order_in_level" int4,
  "page_id" varchar(255) COLLATE "pg_catalog"."default",
  "url" varchar(255) COLLATE "pg_catalog"."default",
  "enabled" int2 NOT NULL DEFAULT 0,
  "SEO" int2 NOT NULL DEFAULT 1,
  "page_group" varchar(255) COLLATE "pg_catalog"."default" DEFAULT NULL::character varying
)
;
COMMENT ON COLUMN "public"."cms_pages"."id" IS 'id ссылки\страницы';
COMMENT ON COLUMN "public"."cms_pages"."parent" IS 'id родительской страницы';
COMMENT ON COLUMN "public"."cms_pages"."order_in_level" IS 'Порядок выдачи в уровне';
COMMENT ON COLUMN "public"."cms_pages"."page_id" IS 'Идентификатор страницыссылки';
COMMENT ON COLUMN "public"."cms_pages"."url" IS 'url на страницу (путь /articles/ добавляется автоматически)';
COMMENT ON COLUMN "public"."cms_pages"."enabled" IS 'Включено';
COMMENT ON COLUMN "public"."cms_pages"."SEO" IS 'Контент доступен поисковикам';
COMMENT ON COLUMN "public"."cms_pages"."page_group" IS 'Группа страниц';
COMMENT ON TABLE "public"."cms_pages" IS 'CMS-контент страницы\ссылки';

-- ----------------------------
-- Table structure for cms_pages_content
-- ----------------------------
DROP TABLE IF EXISTS "public"."cms_pages_content";
CREATE TABLE "public"."cms_pages_content" (
  "id" int4 NOT NULL GENERATED BY DEFAULT AS IDENTITY (
INCREMENT 1
MINVALUE  1
MAXVALUE 2147483647
START 86
),
  "page_id" varchar(255) COLLATE "pg_catalog"."default" NOT NULL,
  "lang" varchar(8) COLLATE "pg_catalog"."default" NOT NULL,
  "content_data" text COLLATE "pg_catalog"."default",
  "title" varchar(1024) COLLATE "pg_catalog"."default",
  "description" varchar(1024) COLLATE "pg_catalog"."default",
  "keywords" varchar(1024) COLLATE "pg_catalog"."default"
)
;
COMMENT ON COLUMN "public"."cms_pages_content"."id" IS 'id контента страницы';
COMMENT ON COLUMN "public"."cms_pages_content"."page_id" IS 'id страницы контента';
COMMENT ON COLUMN "public"."cms_pages_content"."lang" IS 'Язык контента страницы';
COMMENT ON COLUMN "public"."cms_pages_content"."content_data" IS 'php-код контента (синтаксис View)';
COMMENT ON COLUMN "public"."cms_pages_content"."title" IS 'title страницы';
COMMENT ON COLUMN "public"."cms_pages_content"."description" IS 'description страницы';
COMMENT ON COLUMN "public"."cms_pages_content"."keywords" IS 'keywords страницы';
COMMENT ON TABLE "public"."cms_pages_content" IS 'CMS-контент страниц';

-- ----------------------------
-- Table structure for config
-- ----------------------------
DROP TABLE IF EXISTS "public"."config";
CREATE TABLE "public"."config" (
  "id" varchar(256) COLLATE "pg_catalog"."ru_RU.utf8" NOT NULL,
  "label" varchar(256) COLLATE "pg_catalog"."default",
  "value" text COLLATE "pg_catalog"."default",
  "default_value" text COLLATE "pg_catalog"."default",
  "in_wizard" int2 DEFAULT 0,
  "is_update" int2 NOT NULL DEFAULT 0
)
;
COMMENT ON TABLE "public"."config" IS 'Параметры системы';

-- ----------------------------
-- Table structure for currency_log
-- ----------------------------
DROP TABLE IF EXISTS "public"."currency_log";
CREATE TABLE "public"."currency_log" (
  "id" int4 NOT NULL GENERATED BY DEFAULT AS IDENTITY (
INCREMENT 1
MINVALUE  1
MAXVALUE 2147483647
START 48791
),
  "currency" varchar(6) COLLATE "pg_catalog"."default" NOT NULL DEFAULT ''::character varying,
  "date" timestamptz(6) NOT NULL,
  "rate" numeric(16,8) DEFAULT 0.00000000
)
;
COMMENT ON COLUMN "public"."currency_log"."id" IS 'PK';
COMMENT ON COLUMN "public"."currency_log"."currency" IS 'Валюта';
COMMENT ON COLUMN "public"."currency_log"."date" IS 'Время изменения валюты';
COMMENT ON COLUMN "public"."currency_log"."rate" IS 'Курс к валюте, принятой за единицу';
COMMENT ON TABLE "public"."currency_log" IS 'История курсов валют';

-- ----------------------------
-- Table structure for debug_log
-- ----------------------------
DROP TABLE IF EXISTS "public"."debug_log";
CREATE TABLE "public"."debug_log" (
  "id" int8 NOT NULL GENERATED BY DEFAULT AS IDENTITY (
INCREMENT 1
MINVALUE  1
MAXVALUE 9223372036854775807
START 6118
),
  "val" text COLLATE "pg_catalog"."default",
  "date" timestamptz(6)
)
;
COMMENT ON TABLE "public"."debug_log" IS 'Лог отладочной информации';

-- ----------------------------
-- Table structure for deliveries
-- ----------------------------
DROP TABLE IF EXISTS "public"."deliveries";
CREATE TABLE "public"."deliveries" (
  "id" int4 NOT NULL GENERATED BY DEFAULT AS IDENTITY (
INCREMENT 1
MINVALUE  1
MAXVALUE 2147483647
START 9
),
  "delivery_id" varchar(128) COLLATE "pg_catalog"."default",
  "enabled" int2 NOT NULL DEFAULT 0,
  "name" varchar(383) COLLATE "pg_catalog"."default",
  "description" text COLLATE "pg_catalog"."default",
  "currency" varchar(32) COLLATE "pg_catalog"."default",
  "min_weight" numeric(12,2) NOT NULL DEFAULT 0.00,
  "max_weight" numeric(12,2) NOT NULL DEFAULT 0.00,
  "fees" text COLLATE "pg_catalog"."default",
  "group" varchar(64) COLLATE "pg_catalog"."default"
)
;
COMMENT ON COLUMN "public"."deliveries"."id" IS 'Внутренний идентификатор доставки';
COMMENT ON COLUMN "public"."deliveries"."delivery_id" IS 'id службы доставки';
COMMENT ON COLUMN "public"."deliveries"."enabled" IS 'Служба доставки активна';
COMMENT ON COLUMN "public"."deliveries"."name" IS 'Название службы доставки';
COMMENT ON COLUMN "public"."deliveries"."currency" IS 'Валюта расчётов стоимости доставки, ммаленькими буквами';
COMMENT ON COLUMN "public"."deliveries"."min_weight" IS 'Минимальный вес в граммах';
COMMENT ON COLUMN "public"."deliveries"."max_weight" IS 'Максимальный вес в граммах';
COMMENT ON COLUMN "public"."deliveries"."fees" IS 'Стоимости доставки в разные страны';
COMMENT ON COLUMN "public"."deliveries"."group" IS 'Группа доставки';
COMMENT ON TABLE "public"."deliveries" IS 'Настройки служб доставки';

-- ----------------------------
-- Table structure for dic_custom
-- ----------------------------
DROP TABLE IF EXISTS "public"."dic_custom";
CREATE TABLE "public"."dic_custom" (
  "val_id" int4 NOT NULL GENERATED BY DEFAULT AS IDENTITY (
INCREMENT 1
MINVALUE  1
MAXVALUE 2147483647
START 1
),
  "val_group" varchar(128) COLLATE "pg_catalog"."default" NOT NULL DEFAULT NULL::character varying,
  "val_name" varchar(128) COLLATE "pg_catalog"."default" DEFAULT NULL::character varying,
  "val_description" text COLLATE "pg_catalog"."default" DEFAULT NULL::character varying
)
;
COMMENT ON COLUMN "public"."dic_custom"."val_id" IS 'PK';
COMMENT ON COLUMN "public"."dic_custom"."val_group" IS 'Группа справочника';
COMMENT ON COLUMN "public"."dic_custom"."val_name" IS 'Значение параметра';
COMMENT ON COLUMN "public"."dic_custom"."val_description" IS 'Описание параметра';
COMMENT ON TABLE "public"."dic_custom" IS 'Общий словарь кастомных значений';

-- ----------------------------
-- Table structure for events
-- ----------------------------
DROP TABLE IF EXISTS "public"."events";
CREATE TABLE "public"."events" (
  "id" int4 NOT NULL GENERATED BY DEFAULT AS IDENTITY (
INCREMENT 1
MINVALUE  1
MAXVALUE 2147483647
START 28
),
  "event_name" varchar(128) COLLATE "pg_catalog"."default",
  "event_descr" text COLLATE "pg_catalog"."default",
  "event_rules" text COLLATE "pg_catalog"."default",
  "event_action" text COLLATE "pg_catalog"."default",
  "enabled" int4 NOT NULL DEFAULT 0,
  "internal" int4 NOT NULL DEFAULT 0
)
;
COMMENT ON COLUMN "public"."events"."id" IS 'id описания события';
COMMENT ON COLUMN "public"."events"."event_name" IS 'Системное имя события';
COMMENT ON COLUMN "public"."events"."event_descr" IS 'Описание события';
COMMENT ON COLUMN "public"."events"."event_rules" IS 'Условие срабатывания события';
COMMENT ON COLUMN "public"."events"."event_action" IS 'Действия события';
COMMENT ON COLUMN "public"."events"."enabled" IS 'Событие активно';
COMMENT ON COLUMN "public"."events"."internal" IS 'Внутреннее событие, не отображается на фронт';
COMMENT ON TABLE "public"."events" IS 'Настройки обработчика событий';

-- ----------------------------
-- Table structure for events_log
-- ----------------------------
DROP TABLE IF EXISTS "public"."events_log";
CREATE TABLE "public"."events_log" (
  "id" int4 NOT NULL GENERATED BY DEFAULT AS IDENTITY (
INCREMENT 1
MINVALUE  1
MAXVALUE 2147483647
START 844
),
  "date" timestamptz(6) NOT NULL,
  "uid" int4 NOT NULL,
  "event_name" varchar(128) COLLATE "pg_catalog"."default",
  "subject_id" int4 NOT NULL,
  "subject_value" text COLLATE "pg_catalog"."default"
)
;
COMMENT ON COLUMN "public"."events_log"."id" IS 'id события';
COMMENT ON COLUMN "public"."events_log"."date" IS 'Дата события';
COMMENT ON COLUMN "public"."events_log"."uid" IS 'id пользователя, инициировавшего событие';
COMMENT ON COLUMN "public"."events_log"."event_name" IS 'Имя типа события';
COMMENT ON COLUMN "public"."events_log"."subject_id" IS 'id объекта, относительно которого сработало событие';
COMMENT ON COLUMN "public"."events_log"."subject_value" IS 'Описание конкретного события';
COMMENT ON TABLE "public"."events_log" IS 'Лог событий';

-- ----------------------------
-- Table structure for favorites
-- ----------------------------
DROP TABLE IF EXISTS "public"."favorites";
CREATE TABLE "public"."favorites" (
  "id" int8 NOT NULL GENERATED BY DEFAULT AS IDENTITY (
INCREMENT 1
MINVALUE  1
MAXVALUE 9223372036854775807
START 281447
),
  "uid" int4 NOT NULL,
  "num_iid" varchar(45) COLLATE "pg_catalog"."default" NOT NULL,
  "date" timestamptz(6) NOT NULL DEFAULT now(),
  "cid" varchar(45) COLLATE "pg_catalog"."default",
  "express_fee" numeric(12,2),
  "price" numeric(12,2),
  "promotion_price" numeric(12,2),
  "pic_url" varchar(512) COLLATE "pg_catalog"."default",
  "seller_rate" numeric(12,2) DEFAULT 0.00,
  "title" text COLLATE "pg_catalog"."default",
  "dsg_item" text COLLATE "pg_catalog"."default",
  "ds_source" varchar(32) COLLATE "pg_catalog"."default",
  "ds_type" varchar(16) COLLATE "pg_catalog"."default"
)
;
COMMENT ON COLUMN "public"."favorites"."dsg_item" IS 'DSG-описание товара, полностью';
COMMENT ON COLUMN "public"."favorites"."ds_source" IS 'Тип источника данных категории';
COMMENT ON COLUMN "public"."favorites"."ds_type" IS 'Суб-источниктип';
COMMENT ON TABLE "public"."favorites" IS 'Избранные (отложенные) пользователями товары';

-- ----------------------------
-- Table structure for featured
-- ----------------------------
DROP TABLE IF EXISTS "public"."featured";
CREATE TABLE "public"."featured" (
  "num_iid" varchar(45) COLLATE "pg_catalog"."default" NOT NULL,
  "ds_source" varchar(32) COLLATE "pg_catalog"."default" NOT NULL,
  "date" timestamptz(6) NOT NULL DEFAULT now(),
  "cid" varchar(45) COLLATE "pg_catalog"."default",
  "express_fee" numeric(12,2) DEFAULT 0.00,
  "price" numeric(12,2) DEFAULT 0.00,
  "promotion_price" numeric(12,2) DEFAULT 0.00,
  "pic_url" varchar(512) COLLATE "pg_catalog"."default",
  "seller_rate" numeric(12,2) DEFAULT 0.00,
  "title" text COLLATE "pg_catalog"."default",
  "ds_type" varchar(16) COLLATE "pg_catalog"."default"
)
;
COMMENT ON COLUMN "public"."featured"."ds_source" IS 'Тип источника данных категории';
COMMENT ON COLUMN "public"."featured"."ds_type" IS 'Суб-источниктип';

-- ----------------------------
-- Table structure for formulas
-- ----------------------------
DROP TABLE IF EXISTS "public"."formulas";
CREATE TABLE "public"."formulas" (
  "id" int4 NOT NULL GENERATED BY DEFAULT AS IDENTITY (
INCREMENT 1
MINVALUE  1
MAXVALUE 2147483647
START 11
),
  "formula_id" varchar(256) COLLATE "pg_catalog"."default",
  "formula" text COLLATE "pg_catalog"."default",
  "description" text COLLATE "pg_catalog"."default"
)
;
COMMENT ON COLUMN "public"."formulas"."id" IS 'PK';
COMMENT ON COLUMN "public"."formulas"."formula_id" IS 'id формулы';
COMMENT ON COLUMN "public"."formulas"."formula" IS 'Формула расчёта, php';
COMMENT ON COLUMN "public"."formulas"."description" IS 'Описание формулы';
COMMENT ON TABLE "public"."formulas" IS 'Формулы, по которым рассчитываются различные цены, стоимости';

-- ----------------------------
-- Table structure for fulltext_stem
-- ----------------------------
DROP TABLE IF EXISTS "public"."fulltext_stem";
CREATE TABLE "public"."fulltext_stem" (
  "id" int4 NOT NULL GENERATED BY DEFAULT AS IDENTITY (
INCREMENT 1
MINVALUE  1
MAXVALUE 2147483647
START 384172
),
  "src" varchar(64) COLLATE "pg_catalog"."default" NOT NULL,
  "result" varchar(64) COLLATE "pg_catalog"."default" NOT NULL
)
;

-- ----------------------------
-- Table structure for geo_cities
-- ----------------------------
DROP TABLE IF EXISTS "public"."geo_cities";
CREATE TABLE "public"."geo_cities" (
  "id" int8 NOT NULL GENERATED BY DEFAULT AS IDENTITY (
INCREMENT 1
MINVALUE  1
MAXVALUE 9223372036854775807
START 3299
),
  "city" varchar(128) COLLATE "pg_catalog"."default",
  "region" varchar(255) COLLATE "pg_catalog"."default",
  "state" varchar(255) COLLATE "pg_catalog"."default",
  "population" int8,
  "country" char(2) COLLATE "pg_catalog"."default"
)
;

-- ----------------------------
-- Table structure for img_hashes
-- ----------------------------
DROP TABLE IF EXISTS "public"."img_hashes";
CREATE TABLE "public"."img_hashes" (
  "id" int8 NOT NULL GENERATED BY DEFAULT AS IDENTITY (
INCREMENT 1
MINVALUE  1
MAXVALUE 9223372036854775807
START 1476512
),
  "original_url" varchar(512) COLLATE "pg_catalog"."default" NOT NULL,
  "hash" varchar(96) COLLATE "pg_catalog"."default" NOT NULL,
  "created" timestamptz(6) NOT NULL,
  "last_access" timestamptz(6) NOT NULL,
  "size" int8 DEFAULT 0,
  "static" int2 DEFAULT 0
)
;
COMMENT ON TABLE "public"."img_hashes" IS 'Хэши сопоставления ссылки на изображение и файла';

-- ----------------------------
-- Table structure for local_items
-- ----------------------------
DROP TABLE IF EXISTS "public"."local_items";
CREATE TABLE "public"."local_items" (
  "item_id" varchar(45) COLLATE "pg_catalog"."default" NOT NULL,
  "uid" int4 NOT NULL,
  "ds_source" varchar(32) COLLATE "pg_catalog"."default" NOT NULL,
  "cid" varchar(45) COLLATE "pg_catalog"."default",
  "picture_url" varchar(255) COLLATE "pg_catalog"."default",
  "description_url" varchar(255) COLLATE "pg_catalog"."default",
  "pid" int8,
  "title" text COLLATE "pg_catalog"."default",
  "location" varchar(255) COLLATE "pg_catalog"."default",
  "sold_items" int4,
  "pce" varchar(24) COLLATE "pg_catalog"."default",
  "language" char(3) COLLATE "pg_catalog"."default" NOT NULL,
  "currency" char(3) COLLATE "pg_catalog"."default" DEFAULT 'rur'::bpchar,
  "price" numeric(10,2),
  "price_promo" numeric(10,2),
  "price_delivery" numeric(10,2),
  "in_stock" int4,
  "seller_id" int8,
  "seller_id_encripted" varchar(32) COLLATE "pg_catalog"."default",
  "seller_nick" varchar(32) COLLATE "pg_catalog"."default",
  "seller_rate" int2,
  "updated" timestamptz(6),
  "queried" int4 DEFAULT 1
)
;
COMMENT ON COLUMN "public"."local_items"."item_id" IS 'id товара';
COMMENT ON COLUMN "public"."local_items"."ds_source" IS 'ID источника';
COMMENT ON COLUMN "public"."local_items"."cid" IS 'ID категории';
COMMENT ON COLUMN "public"."local_items"."picture_url" IS 'URL изображения';
COMMENT ON COLUMN "public"."local_items"."description_url" IS 'URL описания';
COMMENT ON COLUMN "public"."local_items"."pid" IS 'Ключ поиска похожих товаров';
COMMENT ON COLUMN "public"."local_items"."title" IS 'Название товара';
COMMENT ON COLUMN "public"."local_items"."location" IS 'Локация товара';
COMMENT ON COLUMN "public"."local_items"."sold_items" IS 'Количество проданных';
COMMENT ON COLUMN "public"."local_items"."pce" IS 'Единица измерения';
COMMENT ON COLUMN "public"."local_items"."language" IS 'Язык источника';
COMMENT ON COLUMN "public"."local_items"."currency" IS 'Валюта цены';
COMMENT ON COLUMN "public"."local_items"."price" IS 'Цена';
COMMENT ON COLUMN "public"."local_items"."price_promo" IS 'Цена со скидкой';
COMMENT ON COLUMN "public"."local_items"."price_delivery" IS 'Стоимость доставки';
COMMENT ON COLUMN "public"."local_items"."in_stock" IS 'Остаток на складе';
COMMENT ON COLUMN "public"."local_items"."seller_id" IS 'ID продавца';
COMMENT ON COLUMN "public"."local_items"."seller_id_encripted" IS 'Код продавца';
COMMENT ON COLUMN "public"."local_items"."seller_nick" IS 'Ник продавца';
COMMENT ON COLUMN "public"."local_items"."seller_rate" IS 'Рейтинг продавца';
COMMENT ON COLUMN "public"."local_items"."updated" IS 'Дата обновления';
COMMENT ON COLUMN "public"."local_items"."queried" IS 'Количество просмотров';
COMMENT ON TABLE "public"."local_items" IS 'local - товары';

-- ----------------------------
-- Table structure for local_items_attributes
-- ----------------------------
DROP TABLE IF EXISTS "public"."local_items_attributes";
CREATE TABLE "public"."local_items_attributes" (
  "attribute_id" int8 NOT NULL GENERATED BY DEFAULT AS IDENTITY (
INCREMENT 1
MINVALUE  1
MAXVALUE 9223372036854775807
START 665
),
  "item_id" varchar(45) COLLATE "pg_catalog"."default" NOT NULL,
  "ds_source" varchar(32) COLLATE "pg_catalog"."default" NOT NULL,
  "uid" int4 NOT NULL,
  "property" text COLLATE "pg_catalog"."default",
  "values" text COLLATE "pg_catalog"."default"
)
;
COMMENT ON COLUMN "public"."local_items_attributes"."attribute_id" IS 'ID атрибута';
COMMENT ON COLUMN "public"."local_items_attributes"."item_id" IS 'ID товара';
COMMENT ON COLUMN "public"."local_items_attributes"."ds_source" IS 'ID источника';
COMMENT ON TABLE "public"."local_items_attributes" IS 'local - атрибуты товаров';

-- ----------------------------
-- Table structure for local_items_pictures
-- ----------------------------
DROP TABLE IF EXISTS "public"."local_items_pictures";
CREATE TABLE "public"."local_items_pictures" (
  "picture_id" int8 NOT NULL GENERATED BY DEFAULT AS IDENTITY (
INCREMENT 1
MINVALUE  1
MAXVALUE 9223372036854775807
START 217
),
  "item_id" varchar(45) COLLATE "pg_catalog"."default" NOT NULL,
  "ds_source" varchar(32) COLLATE "pg_catalog"."default" NOT NULL,
  "uid" int4 NOT NULL,
  "picture_url" varchar(255) COLLATE "pg_catalog"."default"
)
;
COMMENT ON COLUMN "public"."local_items_pictures"."picture_id" IS 'PK';
COMMENT ON COLUMN "public"."local_items_pictures"."item_id" IS 'ID товара';
COMMENT ON COLUMN "public"."local_items_pictures"."ds_source" IS 'ID источника';
COMMENT ON TABLE "public"."local_items_pictures" IS 'local - ссылки на изображения товаров';

-- ----------------------------
-- Table structure for local_items_pids
-- ----------------------------
DROP TABLE IF EXISTS "public"."local_items_pids";
CREATE TABLE "public"."local_items_pids" (
  "pid_id" int8 NOT NULL GENERATED BY DEFAULT AS IDENTITY (
INCREMENT 1
MINVALUE  1
MAXVALUE 9223372036854775807
START 80
),
  "item_id" varchar(45) COLLATE "pg_catalog"."default" NOT NULL,
  "ds_source" varchar(32) COLLATE "pg_catalog"."default" NOT NULL,
  "uid" int4 NOT NULL,
  "key" varchar(45) COLLATE "pg_catalog"."default" DEFAULT ''::character varying,
  "title" text COLLATE "pg_catalog"."default"
)
;
COMMENT ON COLUMN "public"."local_items_pids"."ds_source" IS 'ID источника';
COMMENT ON TABLE "public"."local_items_pids" IS 'local - свойства товаров';

-- ----------------------------
-- Table structure for local_items_pids_vids
-- ----------------------------
DROP TABLE IF EXISTS "public"."local_items_pids_vids";
CREATE TABLE "public"."local_items_pids_vids" (
  "vid_id" int8 NOT NULL GENERATED BY DEFAULT AS IDENTITY (
INCREMENT 1
MINVALUE  1
MAXVALUE 9223372036854775807
START 660
),
  "item_id" varchar(45) COLLATE "pg_catalog"."default" NOT NULL,
  "ds_source" varchar(32) COLLATE "pg_catalog"."default" NOT NULL,
  "uid" int4 NOT NULL,
  "pid_id" int8 NOT NULL,
  "key" varchar(45) COLLATE "pg_catalog"."default" DEFAULT ''::character varying,
  "title" text COLLATE "pg_catalog"."default",
  "picture_url" varchar(255) COLLATE "pg_catalog"."default"
)
;
COMMENT ON COLUMN "public"."local_items_pids_vids"."ds_source" IS 'ID источника';
COMMENT ON TABLE "public"."local_items_pids_vids" IS 'local - значения свойств товаров';

-- ----------------------------
-- Table structure for local_items_prices
-- ----------------------------
DROP TABLE IF EXISTS "public"."local_items_prices";
CREATE TABLE "public"."local_items_prices" (
  "sku_id" varchar(45) COLLATE "pg_catalog"."default" NOT NULL,
  "item_id" varchar(45) COLLATE "pg_catalog"."default" NOT NULL,
  "ds_source" varchar(32) COLLATE "pg_catalog"."default" NOT NULL,
  "price_type" varchar(32) COLLATE "pg_catalog"."default" NOT NULL,
  "uid" int4 NOT NULL,
  "price" numeric(10,2),
  "price_promo" numeric(10,2)
)
;
COMMENT ON COLUMN "public"."local_items_prices"."ds_source" IS 'ID источника';
COMMENT ON TABLE "public"."local_items_prices" IS 'local - цены товаров и SKU';

-- ----------------------------
-- Table structure for local_items_search
-- ----------------------------
DROP TABLE IF EXISTS "public"."local_items_search";
CREATE TABLE "public"."local_items_search" (
  "item_id" varchar(45) COLLATE "pg_catalog"."default" NOT NULL,
  "ds_source" varchar(32) COLLATE "pg_catalog"."default" NOT NULL,
  "uid" int4 NOT NULL,
  "keywords" text COLLATE "pg_catalog"."default"
)
;
COMMENT ON COLUMN "public"."local_items_search"."item_id" IS 'id товара';
COMMENT ON COLUMN "public"."local_items_search"."ds_source" IS 'ID источника';
COMMENT ON TABLE "public"."local_items_search" IS 'local - товары';

-- ----------------------------
-- Table structure for local_items_skus
-- ----------------------------
DROP TABLE IF EXISTS "public"."local_items_skus";
CREATE TABLE "public"."local_items_skus" (
  "sku_id" varchar(45) COLLATE "pg_catalog"."default" NOT NULL,
  "item_id" varchar(45) COLLATE "pg_catalog"."default" NOT NULL,
  "ds_source" varchar(32) COLLATE "pg_catalog"."default" NOT NULL,
  "uid" int4 NOT NULL,
  "in_stock" int4,
  "pids_vids" text COLLATE "pg_catalog"."default"
)
;
COMMENT ON COLUMN "public"."local_items_skus"."ds_source" IS 'ID источника';
COMMENT ON TABLE "public"."local_items_skus" IS 'local - атрибуты товаров';

-- ----------------------------
-- Table structure for log_api_requests
-- ----------------------------
DROP TABLE IF EXISTS "public"."log_api_requests";
CREATE TABLE "public"."log_api_requests" (
  "type" varchar(64) COLLATE "pg_catalog"."default",
  "key" varchar(1024) COLLATE "pg_catalog"."default",
  "date" timestamptz(6) NOT NULL,
  "id" int8 NOT NULL GENERATED BY DEFAULT AS IDENTITY (
INCREMENT 1
MINVALUE  1
MAXVALUE 9223372036854775807
START 2
)
)
;
COMMENT ON TABLE "public"."log_api_requests" IS 'Лог использования различных ключей АПИ';

-- ----------------------------
-- Table structure for log_dsg
-- ----------------------------
DROP TABLE IF EXISTS "public"."log_dsg";
CREATE TABLE "public"."log_dsg" (
  "id" int8 NOT NULL GENERATED BY DEFAULT AS IDENTITY (
INCREMENT 1
MINVALUE  1
MAXVALUE 9223372036854775807
START 964
),
  "date" timestamptz(6) NOT NULL,
  "duration" numeric(5,2) NOT NULL DEFAULT 0.00,
  "cache_id" char(32) COLLATE "pg_catalog"."default",
  "result" varchar(64) COLLATE "pg_catalog"."default" NOT NULL DEFAULT 'OK'::character varying,
  "type" varchar(32) COLLATE "pg_catalog"."default" NOT NULL DEFAULT 'undefined'::character varying,
  "from_host" varchar(48) COLLATE "pg_catalog"."default",
  "from_ip" varchar(15) COLLATE "pg_catalog"."default" NOT NULL,
  "ds_proxy" varchar(48) COLLATE "pg_catalog"."default",
  "http_proxy" varchar(48) COLLATE "pg_catalog"."default",
  "debug" varchar(1024) COLLATE "pg_catalog"."default",
  "date_day" int2 NOT NULL
)
;
COMMENT ON COLUMN "public"."log_dsg"."id" IS 'PK';
COMMENT ON COLUMN "public"."log_dsg"."date" IS 'Дата операции';
COMMENT ON COLUMN "public"."log_dsg"."duration" IS 'Длительность операции, сек';
COMMENT ON COLUMN "public"."log_dsg"."cache_id" IS 'Хэш кэша';
COMMENT ON COLUMN "public"."log_dsg"."result" IS 'Результат операции';
COMMENT ON COLUMN "public"."log_dsg"."type" IS 'Тип операции';
COMMENT ON COLUMN "public"."log_dsg"."from_host" IS 'Хост инициатора';
COMMENT ON COLUMN "public"."log_dsg"."from_ip" IS 'IP инициатора';
COMMENT ON COLUMN "public"."log_dsg"."ds_proxy" IS 'Использованный DSGProxy';
COMMENT ON COLUMN "public"."log_dsg"."http_proxy" IS 'Использованный HTTP-прокси';
COMMENT ON COLUMN "public"."log_dsg"."debug" IS 'Отладочная информация';
COMMENT ON COLUMN "public"."log_dsg"."date_day" IS 'День даты для партишионинга';
COMMENT ON TABLE "public"."log_dsg" IS 'Лог всех операций по GSG';

-- ----------------------------
-- Table structure for log_dsg_buffer
-- ----------------------------
DROP TABLE IF EXISTS "public"."log_dsg_buffer";
CREATE TABLE "public"."log_dsg_buffer" (
  "id" int8 NOT NULL GENERATED BY DEFAULT AS IDENTITY (
INCREMENT 1
MINVALUE  1
MAXVALUE 9223372036854775807
START 2
),
  "date" timestamptz(6) NOT NULL,
  "duration" numeric(5,2) NOT NULL DEFAULT 0.00,
  "cache_id" char(32) COLLATE "pg_catalog"."default",
  "result" varchar(64) COLLATE "pg_catalog"."default" NOT NULL DEFAULT 'OK'::character varying,
  "type" varchar(32) COLLATE "pg_catalog"."default" NOT NULL DEFAULT 'undefined'::character varying,
  "from_host" varchar(48) COLLATE "pg_catalog"."default",
  "from_ip" varchar(15) COLLATE "pg_catalog"."default" NOT NULL,
  "ds_proxy" varchar(48) COLLATE "pg_catalog"."default",
  "http_proxy" varchar(48) COLLATE "pg_catalog"."default",
  "debug" varchar(1024) COLLATE "pg_catalog"."default"
)
;
COMMENT ON COLUMN "public"."log_dsg_buffer"."id" IS 'PK';
COMMENT ON COLUMN "public"."log_dsg_buffer"."date" IS 'Дата операции';
COMMENT ON COLUMN "public"."log_dsg_buffer"."duration" IS 'Длительность операции, сек';
COMMENT ON COLUMN "public"."log_dsg_buffer"."cache_id" IS 'Хэш кэша';
COMMENT ON COLUMN "public"."log_dsg_buffer"."result" IS 'Результат операции';
COMMENT ON COLUMN "public"."log_dsg_buffer"."type" IS 'Тип операции';
COMMENT ON COLUMN "public"."log_dsg_buffer"."from_host" IS 'Хост инициатора';
COMMENT ON COLUMN "public"."log_dsg_buffer"."from_ip" IS 'IP инициатора';
COMMENT ON COLUMN "public"."log_dsg_buffer"."ds_proxy" IS 'Использованный DSGProxy';
COMMENT ON COLUMN "public"."log_dsg_buffer"."http_proxy" IS 'Использованный HTTP-прокси';
COMMENT ON COLUMN "public"."log_dsg_buffer"."debug" IS 'Отладочная информация';
COMMENT ON TABLE "public"."log_dsg_buffer" IS 'Лог всех операций по GSG - буфер';

-- ----------------------------
-- Table structure for log_dsg_details
-- ----------------------------
DROP TABLE IF EXISTS "public"."log_dsg_details";
CREATE TABLE "public"."log_dsg_details" (
  "id" int8 NOT NULL GENERATED BY DEFAULT AS IDENTITY (
INCREMENT 1
MINVALUE  1
MAXVALUE 9223372036854775807
START 2
),
  "log_dsg_id" int8 NOT NULL,
  "data" text COLLATE "pg_catalog"."default"
)
;
COMMENT ON COLUMN "public"."log_dsg_details"."id" IS 'PK';

-- ----------------------------
-- Table structure for log_dsg_translator
-- ----------------------------
DROP TABLE IF EXISTS "public"."log_dsg_translator";
CREATE TABLE "public"."log_dsg_translator" (
  "id" int8 NOT NULL GENERATED BY DEFAULT AS IDENTITY (
INCREMENT 1
MINVALUE  1
MAXVALUE 9223372036854775807
START 14
),
  "date" timestamptz(6) NOT NULL,
  "duration" numeric(5,2) NOT NULL DEFAULT 0.00,
  "remote" int4 NOT NULL DEFAULT 0,
  "local" int4 NOT NULL DEFAULT 0,
  "from_host" varchar(64) COLLATE "pg_catalog"."default",
  "from_ip" varchar(15) COLLATE "pg_catalog"."default" NOT NULL
)
;
COMMENT ON COLUMN "public"."log_dsg_translator"."id" IS 'PK';
COMMENT ON COLUMN "public"."log_dsg_translator"."date" IS 'Дата операции';
COMMENT ON COLUMN "public"."log_dsg_translator"."duration" IS 'Длительность операции, сек';
COMMENT ON COLUMN "public"."log_dsg_translator"."remote" IS 'Размер данных внешнего перевода';
COMMENT ON COLUMN "public"."log_dsg_translator"."local" IS 'Размер данных локального перевода';
COMMENT ON COLUMN "public"."log_dsg_translator"."from_host" IS 'Хост инициатора';
COMMENT ON COLUMN "public"."log_dsg_translator"."from_ip" IS 'IP инициатора';
COMMENT ON TABLE "public"."log_dsg_translator" IS 'Лог DSG для переводчика';

-- ----------------------------
-- Table structure for log_http_requests
-- ----------------------------
DROP TABLE IF EXISTS "public"."log_http_requests";
CREATE TABLE "public"."log_http_requests" (
  "id" int8 NOT NULL GENERATED BY DEFAULT AS IDENTITY (
INCREMENT 1
MINVALUE  1
MAXVALUE 9223372036854775807
START 1235548
),
  "session" varchar(32) COLLATE "pg_catalog"."default" NOT NULL,
  "url" text COLLATE "pg_catalog"."default",
  "referer" text COLLATE "pg_catalog"."default",
  "useragent" text COLLATE "pg_catalog"."default",
  "ip" varchar(15) COLLATE "pg_catalog"."default",
  "uid" int4,
  "date" timestamptz(6) NOT NULL DEFAULT now(),
  "duration" int2 NOT NULL DEFAULT 0
)
;
COMMENT ON COLUMN "public"."log_http_requests"."duration" IS 'Время выполнения, сек';

-- ----------------------------
-- Table structure for log_iot
-- ----------------------------
DROP TABLE IF EXISTS "public"."log_iot";
CREATE TABLE "public"."log_iot" (
  "id" int8 NOT NULL GENERATED BY DEFAULT AS IDENTITY (
INCREMENT 1
MINVALUE  1
MAXVALUE 9223372036854775807
START 1
),
  "datetime" timestamptz(6),
  "message" text COLLATE "pg_catalog"."default"
)
;
COMMENT ON TABLE "public"."log_iot" IS 'Лог событий IoT';

-- ----------------------------
-- Table structure for log_item_requests
-- ----------------------------
DROP TABLE IF EXISTS "public"."log_item_requests";
CREATE TABLE "public"."log_item_requests" (
  "id" int8 NOT NULL GENERATED BY DEFAULT AS IDENTITY (
INCREMENT 1
MINVALUE  1
MAXVALUE 9223372036854775807
START 3266994
),
  "date" timestamptz(6) NOT NULL DEFAULT now(),
  "session" varchar(64) COLLATE "pg_catalog"."default",
  "uid" int4,
  "num_iid" varchar(45) COLLATE "pg_catalog"."default" NOT NULL,
  "cid" varchar(45) COLLATE "pg_catalog"."default",
  "express_fee" numeric(12,2),
  "price" numeric(12,2),
  "promotion_price" numeric(12,2),
  "nick" varchar(64) COLLATE "pg_catalog"."default",
  "seller_rate" numeric(12,2) DEFAULT 0.00,
  "pic_url" varchar(256) COLLATE "pg_catalog"."default",
  "title" text COLLATE "pg_catalog"."default",
  "prop_names" text COLLATE "pg_catalog"."default",
  "ds_source" varchar(32) COLLATE "pg_catalog"."default",
  "ds_type" varchar(16) COLLATE "pg_catalog"."default"
)
;
COMMENT ON COLUMN "public"."log_item_requests"."ds_source" IS 'Тип источника данных категории';
COMMENT ON COLUMN "public"."log_item_requests"."ds_type" IS 'Суб-источниктип';

-- ----------------------------
-- Table structure for log_items_requests
-- ----------------------------
DROP TABLE IF EXISTS "public"."log_items_requests";
CREATE TABLE "public"."log_items_requests" (
  "num_iid" varchar(45) COLLATE "pg_catalog"."default" NOT NULL,
  "cid" varchar(45) COLLATE "pg_catalog"."default" NOT NULL,
  "query" varchar(64) COLLATE "pg_catalog"."default" NOT NULL,
  "uniqpid" int8 DEFAULT 0,
  "express_fee" numeric(12,2) DEFAULT 0.00,
  "price" numeric(12,2) DEFAULT 0.00,
  "promotion_price" numeric(12,2) DEFAULT 0.00,
  "pic_url" varchar(192) COLLATE "pg_catalog"."default",
  "seller_rate" numeric(12,2) DEFAULT 0.00,
  "title" text COLLATE "pg_catalog"."default",
  "date" timestamptz(6) NOT NULL DEFAULT now(),
  "nick" varchar(32) COLLATE "pg_catalog"."default",
  "ds_source" varchar(32) COLLATE "pg_catalog"."default" NOT NULL,
  "ds_type" varchar(16) COLLATE "pg_catalog"."default",
  "date_day" int2 NOT NULL
)
;
COMMENT ON COLUMN "public"."log_items_requests"."uniqpid" IS 'Ключ поиска похожих товаров';
COMMENT ON COLUMN "public"."log_items_requests"."ds_source" IS 'Тип источника данных категории';
COMMENT ON COLUMN "public"."log_items_requests"."ds_type" IS 'Суб-источниктип';
COMMENT ON TABLE "public"."log_items_requests" IS 'Лог товаров, просмотренныхв поисковой выдаче (с данными)';

-- ----------------------------
-- Table structure for log_queries_requests
-- ----------------------------
DROP TABLE IF EXISTS "public"."log_queries_requests";
CREATE TABLE "public"."log_queries_requests" (
  "id" int8 NOT NULL GENERATED BY DEFAULT AS IDENTITY (
INCREMENT 1
MINVALUE  1
MAXVALUE 9223372036854775807
START 26261
),
  "date" timestamptz(6) NOT NULL DEFAULT now(),
  "session" varchar(64) COLLATE "pg_catalog"."default",
  "uid" int4,
  "res_count" int8 NOT NULL,
  "cid" varchar(45) COLLATE "pg_catalog"."default",
  "query" varchar(512) COLLATE "pg_catalog"."default",
  "ds_source" varchar(32) COLLATE "pg_catalog"."default"
)
;
COMMENT ON COLUMN "public"."log_queries_requests"."ds_source" IS 'Тип источника данных категории';

-- ----------------------------
-- Table structure for log_site_errors
-- ----------------------------
DROP TABLE IF EXISTS "public"."log_site_errors";
CREATE TABLE "public"."log_site_errors" (
  "id" int8 NOT NULL GENERATED BY DEFAULT AS IDENTITY (
INCREMENT 1
MINVALUE  1
MAXVALUE 9223372036854775807
START 5577
),
  "error_message" varchar(4000) COLLATE "pg_catalog"."default",
  "error_description" text COLLATE "pg_catalog"."default",
  "error_label" varchar(4000) COLLATE "pg_catalog"."default",
  "error_date" timestamptz(6),
  "error_request" text COLLATE "pg_catalog"."default",
  "custom_data" text COLLATE "pg_catalog"."default"
)
;
COMMENT ON TABLE "public"."log_site_errors" IS 'Лог ошибок сайта';

-- ----------------------------
-- Table structure for log_source_cookies
-- ----------------------------
DROP TABLE IF EXISTS "public"."log_source_cookies";
CREATE TABLE "public"."log_source_cookies" (
  "name" varchar(128) COLLATE "pg_catalog"."default" NOT NULL,
  "domain" varchar(128) COLLATE "pg_catalog"."default" NOT NULL,
  "interface" varchar(128) COLLATE "pg_catalog"."default" NOT NULL,
  "value" varchar(256) COLLATE "pg_catalog"."default",
  "date" timestamptz(6)
)
;

-- ----------------------------
-- Table structure for log_translations
-- ----------------------------
DROP TABLE IF EXISTS "public"."log_translations";
CREATE TABLE "public"."log_translations" (
  "id" int8 NOT NULL GENERATED BY DEFAULT AS IDENTITY (
INCREMENT 1
MINVALUE  1
MAXVALUE 9223372036854775807
START 91
),
  "table_name" varchar(64) COLLATE "pg_catalog"."default" NOT NULL,
  "message_id" int8 NOT NULL,
  "host" varchar(64) COLLATE "pg_catalog"."default" NOT NULL,
  "uid" int4 NOT NULL,
  "date" timestamptz(6) NOT NULL,
  "message" text COLLATE "pg_catalog"."default" NOT NULL,
  "translation" text COLLATE "pg_catalog"."default" NOT NULL,
  "from" char(2) COLLATE "pg_catalog"."default" NOT NULL,
  "to" char(2) COLLATE "pg_catalog"."default" NOT NULL
)
;
COMMENT ON TABLE "public"."log_translations" IS 'Лог редактирования переводов';

-- ----------------------------
-- Table structure for log_translator_keys
-- ----------------------------
DROP TABLE IF EXISTS "public"."log_translator_keys";
CREATE TABLE "public"."log_translator_keys" (
  "id" int8 NOT NULL GENERATED BY DEFAULT AS IDENTITY (
INCREMENT 1
MINVALUE  1
MAXVALUE 9223372036854775807
START 475
),
  "date" timestamptz(6) NOT NULL,
  "keyid" int2 NOT NULL,
  "result" int2 NOT NULL,
  "chars" int4 NOT NULL,
  "function" varchar(32) COLLATE "pg_catalog"."default"
)
;
COMMENT ON TABLE "public"."log_translator_keys" IS 'Лог использования ключей переводчика';

-- ----------------------------
-- Table structure for log_user_activity
-- ----------------------------
DROP TABLE IF EXISTS "public"."log_user_activity";
CREATE TABLE "public"."log_user_activity" (
  "id" int4 NOT NULL GENERATED BY DEFAULT AS IDENTITY (
INCREMENT 1
MINVALUE  1
MAXVALUE 2147483647
START 1
),
  "uid" int4 NOT NULL,
  "date" timestamptz(6) NOT NULL,
  "module" varchar(64) COLLATE "pg_catalog"."default" NOT NULL,
  "controller" varchar(64) COLLATE "pg_catalog"."default" NOT NULL,
  "action" varchar(64) COLLATE "pg_catalog"."default" NOT NULL DEFAULT 1,
  "count" int4 DEFAULT 1
)
;
COMMENT ON COLUMN "public"."log_user_activity"."id" IS 'id записи истории';
COMMENT ON COLUMN "public"."log_user_activity"."module" IS 'Модуль';
COMMENT ON COLUMN "public"."log_user_activity"."controller" IS 'Контроллер';
COMMENT ON COLUMN "public"."log_user_activity"."action" IS 'Экшен';
COMMENT ON COLUMN "public"."log_user_activity"."count" IS 'Количество обращений';
COMMENT ON TABLE "public"."log_user_activity" IS 'История действий пользователей';

-- ----------------------------
-- Table structure for mail_queue
-- ----------------------------
DROP TABLE IF EXISTS "public"."mail_queue";
CREATE TABLE "public"."mail_queue" (
  "id" int4 NOT NULL GENERATED BY DEFAULT AS IDENTITY (
INCREMENT 1
MINVALUE  1
MAXVALUE 2147483647
START 4585
),
  "from" varchar(512) COLLATE "pg_catalog"."default" NOT NULL,
  "from_name" varchar(512) COLLATE "pg_catalog"."default",
  "to" varchar(512) COLLATE "pg_catalog"."default" NOT NULL,
  "subj" varchar(1024) COLLATE "pg_catalog"."default",
  "body" text COLLATE "pg_catalog"."default" NOT NULL,
  "priority" int4 NOT NULL DEFAULT 0,
  "created" timestamptz(6) NOT NULL,
  "processed" timestamptz(6),
  "result" varchar(255) COLLATE "pg_catalog"."default",
  "event_id" int4 DEFAULT 0,
  "posting_id" varchar(32) COLLATE "pg_catalog"."default",
  "attaches" text COLLATE "pg_catalog"."default"
)
;
COMMENT ON COLUMN "public"."mail_queue"."priority" IS 'Больше -> выше';
COMMENT ON TABLE "public"."mail_queue" IS 'Очередь отправки почтовых сообщений';

-- ----------------------------
-- Table structure for messages
-- ----------------------------
DROP TABLE IF EXISTS "public"."messages";
CREATE TABLE "public"."messages" (
  "id" int4 NOT NULL GENERATED BY DEFAULT AS IDENTITY (
INCREMENT 1
MINVALUE  1
MAXVALUE 2147483647
START 1655
),
  "question" text COLLATE "pg_catalog"."default",
  "email" varchar(128) COLLATE "pg_catalog"."default",
  "uid" int4,
  "qid" int4,
  "date" int4,
  "parent" int4 NOT NULL DEFAULT 0,
  "status" int4 NOT NULL DEFAULT 1
)
;
COMMENT ON TABLE "public"."messages" IS 'Поддержка - сообщения в вопросах';

-- ----------------------------
-- Table structure for module_news
-- ----------------------------
DROP TABLE IF EXISTS "public"."module_news";
CREATE TABLE "public"."module_news" (
  "id" int4 NOT NULL GENERATED BY DEFAULT AS IDENTITY (
INCREMENT 1
MINVALUE  1
MAXVALUE 2147483647
START 39
),
  "uid" int4 NOT NULL,
  "date" timestamptz(6) NOT NULL,
  "message" varchar(4000) COLLATE "pg_catalog"."default" NOT NULL,
  "module" varchar(64) COLLATE "pg_catalog"."default" NOT NULL
)
;
COMMENT ON COLUMN "public"."module_news"."id" IS 'ID сообщения';
COMMENT ON COLUMN "public"."module_news"."uid" IS 'UID отправителя';
COMMENT ON COLUMN "public"."module_news"."date" IS 'Дата сообщения';
COMMENT ON COLUMN "public"."module_news"."message" IS 'Текст сообщения';
COMMENT ON COLUMN "public"."module_news"."module" IS 'Модуль';
COMMENT ON TABLE "public"."module_news" IS 'Внутренние сообщения, новости системы';

-- ----------------------------
-- Table structure for module_tabs_history
-- ----------------------------
DROP TABLE IF EXISTS "public"."module_tabs_history";
CREATE TABLE "public"."module_tabs_history" (
  "id" int4 NOT NULL GENERATED BY DEFAULT AS IDENTITY (
INCREMENT 1
MINVALUE  1
MAXVALUE 2147483647
START 2188
),
  "href" varchar(1024) COLLATE "pg_catalog"."default" NOT NULL,
  "name" varchar(512) COLLATE "pg_catalog"."default" NOT NULL,
  "title" varchar(1024) COLLATE "pg_catalog"."default",
  "uid" int4 NOT NULL,
  "date" timestamptz(6) NOT NULL,
  "module" varchar(64) COLLATE "pg_catalog"."default" NOT NULL
)
;
COMMENT ON COLUMN "public"."module_tabs_history"."id" IS 'id записи истории';
COMMENT ON COLUMN "public"."module_tabs_history"."href" IS 'Ссылка';
COMMENT ON COLUMN "public"."module_tabs_history"."name" IS 'Имя ссылки';
COMMENT ON COLUMN "public"."module_tabs_history"."title" IS 'title ссылки';
COMMENT ON COLUMN "public"."module_tabs_history"."module" IS 'Модуль';
COMMENT ON TABLE "public"."module_tabs_history" IS 'История вкладок админки';

-- ----------------------------
-- Table structure for obj_devices_manual
-- ----------------------------
DROP TABLE IF EXISTS "public"."obj_devices_manual";
CREATE TABLE "public"."obj_devices_manual" (
  "devices_id" int4 NOT NULL GENERATED BY DEFAULT AS IDENTITY (
INCREMENT 1
MINVALUE  1
MAXVALUE 2147483647
START 1073741824
),
  "source" varchar(255) COLLATE "pg_catalog"."default" NOT NULL DEFAULT 'manual'::character varying,
  "name" varchar(255) COLLATE "pg_catalog"."default" DEFAULT 'New device'::character varying,
  "active" int2 DEFAULT 1,
  "properties" jsonb,
  "model_id" int4,
  "device_type_id" int4,
  "device_group_id" int4,
  "report_period_update" int4 DEFAULT 3600,
  "desc" text COLLATE "pg_catalog"."default",
  "created_at" timestamptz(6) DEFAULT now(),
  "updated_at" timestamptz(6),
  "deleted_at" timestamptz(6),
  "device_usage_id" int4,
  "device_status_id" int4,
  "device_serial_number" varchar(128) COLLATE "pg_catalog"."default"
)
;
COMMENT ON COLUMN "public"."obj_devices_manual"."devices_id" IS 'PK';
COMMENT ON COLUMN "public"."obj_devices_manual"."source" IS 'Источник данных';
COMMENT ON COLUMN "public"."obj_devices_manual"."name" IS 'Название прибора';
COMMENT ON COLUMN "public"."obj_devices_manual"."active" IS 'Активен';
COMMENT ON COLUMN "public"."obj_devices_manual"."properties" IS 'Свойства прибора';
COMMENT ON COLUMN "public"."obj_devices_manual"."report_period_update" IS 'Интервал обновления, сек';
COMMENT ON COLUMN "public"."obj_devices_manual"."desc" IS 'Описание';
COMMENT ON COLUMN "public"."obj_devices_manual"."created_at" IS 'Создан';
COMMENT ON COLUMN "public"."obj_devices_manual"."updated_at" IS 'Обновлён';
COMMENT ON COLUMN "public"."obj_devices_manual"."deleted_at" IS 'Удалён';
COMMENT ON COLUMN "public"."obj_devices_manual"."device_usage_id" IS 'Способ использования прибора';
COMMENT ON COLUMN "public"."obj_devices_manual"."device_status_id" IS 'Статус прибора';
COMMENT ON COLUMN "public"."obj_devices_manual"."device_serial_number" IS 'Серийный номер прибора';
COMMENT ON TABLE "public"."obj_devices_manual" IS 'Приборы учета и контроля - оффлайн или собственные';

-- ----------------------------
-- Table structure for obj_devices_manual_data
-- ----------------------------
DROP TABLE IF EXISTS "public"."obj_devices_manual_data";
CREATE TABLE "public"."obj_devices_manual_data" (
  "data_id" int4 NOT NULL GENERATED BY DEFAULT AS IDENTITY (
INCREMENT 1
MINVALUE  1
MAXVALUE 2147483647
START 1
),
  "device_id" int4 NOT NULL,
  "data_updated" timestamptz(6) NOT NULL DEFAULT now(),
  "uid" int4,
  "tariff1_val" float8,
  "tariff2_val" float8,
  "tariff3_val" float8,
  "data_source" int4
)
;
COMMENT ON COLUMN "public"."obj_devices_manual_data"."data_id" IS 'Unique identifier of metering device model';
COMMENT ON TABLE "public"."obj_devices_manual_data" IS 'Показания оффлайн приборов';

-- ----------------------------
-- Table structure for obj_devices_startpoints
-- ----------------------------
DROP TABLE IF EXISTS "public"."obj_devices_startpoints";
CREATE TABLE "public"."obj_devices_startpoints" (
  "devices_startpoint_id" int4 NOT NULL GENERATED BY DEFAULT AS IDENTITY (
INCREMENT 1
MINVALUE  1
MAXVALUE 2147483647
START 1
),
  "devices_id" int4 NOT NULL,
  "created" timestamptz(6) NOT NULL DEFAULT now(),
  "deleted" timestamptz(6),
  "startpoint_value1" float8,
  "startpoint_value2" float8,
  "startpoint_value3" float8,
  "uid" int4 NOT NULL DEFAULT 0,
  "balance" float8
)
;
COMMENT ON COLUMN "public"."obj_devices_startpoints"."devices_startpoint_id" IS 'PK';
COMMENT ON COLUMN "public"."obj_devices_startpoints"."devices_id" IS 'ID прибора';
COMMENT ON COLUMN "public"."obj_devices_startpoints"."created" IS 'Дата назначения';
COMMENT ON COLUMN "public"."obj_devices_startpoints"."deleted" IS 'Дата удаления';
COMMENT ON COLUMN "public"."obj_devices_startpoints"."startpoint_value1" IS 'Значение 1';
COMMENT ON COLUMN "public"."obj_devices_startpoints"."startpoint_value2" IS 'Значение 2';
COMMENT ON COLUMN "public"."obj_devices_startpoints"."startpoint_value3" IS 'Значение 3';
COMMENT ON COLUMN "public"."obj_devices_startpoints"."uid" IS 'Кто установил?';
COMMENT ON COLUMN "public"."obj_devices_startpoints"."balance" IS 'Баланс на момент установки старт-поинт';
COMMENT ON TABLE "public"."obj_devices_startpoints" IS 'Связь прибора и тарифов';

-- ----------------------------
-- Table structure for obj_devices_tariffs
-- ----------------------------
DROP TABLE IF EXISTS "public"."obj_devices_tariffs";
CREATE TABLE "public"."obj_devices_tariffs" (
  "devices_tariffs_id" int4 NOT NULL GENERATED BY DEFAULT AS IDENTITY (
INCREMENT 1
MINVALUE  1
MAXVALUE 2147483647
START 1
),
  "devices_id" int4 NOT NULL,
  "tariffs_id" int4 NOT NULL,
  "created" timestamptz(6) NOT NULL DEFAULT now(),
  "deleted" timestamptz(6)
)
;
COMMENT ON COLUMN "public"."obj_devices_tariffs"."devices_tariffs_id" IS 'PK';
COMMENT ON COLUMN "public"."obj_devices_tariffs"."devices_id" IS 'ID прибора';
COMMENT ON COLUMN "public"."obj_devices_tariffs"."tariffs_id" IS 'ID тарифа';
COMMENT ON COLUMN "public"."obj_devices_tariffs"."created" IS 'Дата назначения';
COMMENT ON COLUMN "public"."obj_devices_tariffs"."deleted" IS 'Дата удаления';
COMMENT ON TABLE "public"."obj_devices_tariffs" IS 'Связь прибора и тарифов';

-- ----------------------------
-- Table structure for obj_lands
-- ----------------------------
DROP TABLE IF EXISTS "public"."obj_lands";
CREATE TABLE "public"."obj_lands" (
  "lands_id" int4 NOT NULL GENERATED BY DEFAULT AS IDENTITY (
INCREMENT 1
MINVALUE  1
MAXVALUE 2147483647
START 21725
),
  "land_number" varchar(64) COLLATE "pg_catalog"."default" DEFAULT NULL::character varying,
  "land_number_cadastral" varchar(128) COLLATE "pg_catalog"."default" DEFAULT NULL::character varying,
  "status" int2 DEFAULT 0,
  "address" text COLLATE "pg_catalog"."default" DEFAULT NULL::character varying,
  "created" timestamptz(6) DEFAULT now(),
  "comments" text COLLATE "pg_catalog"."default",
  "land_group" varchar(64) COLLATE "pg_catalog"."default" DEFAULT 'Вирки-2'::character varying,
  "land_area" numeric(8,2),
  "land_geo_latitude" numeric(10,6),
  "land_geo_longitude" numeric(10,6),
  "land_type" int4 DEFAULT 11
)
;
COMMENT ON COLUMN "public"."obj_lands"."lands_id" IS 'PK';
COMMENT ON COLUMN "public"."obj_lands"."land_number" IS 'Номер участка (с литерами)';
COMMENT ON COLUMN "public"."obj_lands"."land_number_cadastral" IS 'Кадастровый номер участка';
COMMENT ON COLUMN "public"."obj_lands"."status" IS 'Данные проверены';
COMMENT ON COLUMN "public"."obj_lands"."address" IS 'Почтовый адрес участка, если есть';
COMMENT ON COLUMN "public"."obj_lands"."created" IS 'Дата создания';
COMMENT ON COLUMN "public"."obj_lands"."comments" IS 'Комментарии';
COMMENT ON COLUMN "public"."obj_lands"."land_group" IS 'СНТ, поселок или группа участков';
COMMENT ON COLUMN "public"."obj_lands"."land_area" IS 'Площадь участка, кв.м.';
COMMENT ON COLUMN "public"."obj_lands"."land_geo_latitude" IS 'Широта';
COMMENT ON COLUMN "public"."obj_lands"."land_geo_longitude" IS 'Долгота';
COMMENT ON COLUMN "public"."obj_lands"."land_type" IS 'Статус участка';
COMMENT ON TABLE "public"."obj_lands" IS 'Участки СНТ или посёлка';

-- ----------------------------
-- Table structure for obj_lands_devices
-- ----------------------------
DROP TABLE IF EXISTS "public"."obj_lands_devices";
CREATE TABLE "public"."obj_lands_devices" (
  "lands_id" int4 NOT NULL,
  "devices_id" int4 NOT NULL,
  "created" timestamptz(6) NOT NULL DEFAULT now(),
  "deleted" timestamptz(6),
  "lands_devices_id" int4 NOT NULL GENERATED BY DEFAULT AS IDENTITY (
INCREMENT 1
MINVALUE  1
MAXVALUE 2147483647
START 1
)
)
;
COMMENT ON COLUMN "public"."obj_lands_devices"."lands_id" IS 'ID участка';
COMMENT ON COLUMN "public"."obj_lands_devices"."devices_id" IS 'ID прибора';
COMMENT ON COLUMN "public"."obj_lands_devices"."created" IS 'Дата назначения';
COMMENT ON COLUMN "public"."obj_lands_devices"."deleted" IS 'Дата удаления';
COMMENT ON COLUMN "public"."obj_lands_devices"."lands_devices_id" IS 'PK';
COMMENT ON TABLE "public"."obj_lands_devices" IS 'Связь участка и приборов учета';

-- ----------------------------
-- Table structure for obj_lands_tariffs
-- ----------------------------
DROP TABLE IF EXISTS "public"."obj_lands_tariffs";
CREATE TABLE "public"."obj_lands_tariffs" (
  "lands_tariffs_id" int4 NOT NULL GENERATED BY DEFAULT AS IDENTITY (
INCREMENT 1
MINVALUE  1
MAXVALUE 2147483647
START 1
),
  "lands_id" int4 NOT NULL,
  "tariffs_id" int4 NOT NULL,
  "created" timestamptz(6) NOT NULL DEFAULT now(),
  "deleted" timestamptz(6)
)
;
COMMENT ON COLUMN "public"."obj_lands_tariffs"."lands_tariffs_id" IS 'PK';
COMMENT ON COLUMN "public"."obj_lands_tariffs"."lands_id" IS 'ID участка';
COMMENT ON COLUMN "public"."obj_lands_tariffs"."tariffs_id" IS 'ID тарифа';
COMMENT ON COLUMN "public"."obj_lands_tariffs"."created" IS 'Дата назначения';
COMMENT ON COLUMN "public"."obj_lands_tariffs"."deleted" IS 'Дата удаления';
COMMENT ON TABLE "public"."obj_lands_tariffs" IS 'Связь участка и тарифов';

-- ----------------------------
-- Table structure for obj_news
-- ----------------------------
DROP TABLE IF EXISTS "public"."obj_news";
CREATE TABLE "public"."obj_news" (
  "news_id" int4 NOT NULL GENERATED BY DEFAULT AS IDENTITY (
INCREMENT 1
MINVALUE  1
MAXVALUE 2147483647
START 1
),
  "news_header" text COLLATE "pg_catalog"."default" DEFAULT 'Очередная новость'::character varying,
  "news_body" text COLLATE "pg_catalog"."default" DEFAULT NULL::character varying,
  "news_author" int4 NOT NULL DEFAULT 1,
  "created" timestamptz(6) DEFAULT now(),
  "comments" text COLLATE "pg_catalog"."default",
  "enabled" int2 DEFAULT (1)::smallint,
  "news_type" int4 NOT NULL DEFAULT 63,
  "date_actual_start" timestamptz(6),
  "date_actual_end" timestamptz(6),
  "recipients" text COLLATE "pg_catalog"."default",
  "confirmation_needed" int2 DEFAULT (0)::smallint,
  "absolute_order" int4
)
;
COMMENT ON COLUMN "public"."obj_news"."news_id" IS 'PK';
COMMENT ON COLUMN "public"."obj_news"."news_header" IS 'Заголовок сообщения';
COMMENT ON COLUMN "public"."obj_news"."news_body" IS 'Тело сообщения';
COMMENT ON COLUMN "public"."obj_news"."news_author" IS 'Автор';
COMMENT ON COLUMN "public"."obj_news"."created" IS 'Дата создания';
COMMENT ON COLUMN "public"."obj_news"."comments" IS 'Комментарии';
COMMENT ON COLUMN "public"."obj_news"."enabled" IS 'Включено';
COMMENT ON COLUMN "public"."obj_news"."news_type" IS 'Тип сообщения';
COMMENT ON COLUMN "public"."obj_news"."date_actual_start" IS 'Начало публикации';
COMMENT ON COLUMN "public"."obj_news"."date_actual_end" IS 'Окончание публикации';
COMMENT ON COLUMN "public"."obj_news"."recipients" IS 'Получатели';
COMMENT ON COLUMN "public"."obj_news"."confirmation_needed" IS 'Нужно подтверждение прочтения';
COMMENT ON COLUMN "public"."obj_news"."absolute_order" IS 'Безусловная сортировка в выдаче';
COMMENT ON TABLE "public"."obj_news" IS 'Новости и объявления';

-- ----------------------------
-- Table structure for obj_news_confirmations
-- ----------------------------
DROP TABLE IF EXISTS "public"."obj_news_confirmations";
CREATE TABLE "public"."obj_news_confirmations" (
  "news_confirmations_id" int4 NOT NULL GENERATED BY DEFAULT AS IDENTITY (
INCREMENT 1
MINVALUE  1
MAXVALUE 2147483647
START 1
),
  "news_id" int4 NOT NULL,
  "uid" int4 NOT NULL,
  "created" timestamptz(6) NOT NULL DEFAULT now(),
  "result" int2 DEFAULT 1
)
;
COMMENT ON COLUMN "public"."obj_news_confirmations"."news_confirmations_id" IS 'PK';
COMMENT ON COLUMN "public"."obj_news_confirmations"."news_id" IS 'ID новости';
COMMENT ON COLUMN "public"."obj_news_confirmations"."uid" IS 'ID пользователя';
COMMENT ON COLUMN "public"."obj_news_confirmations"."created" IS 'Дата подтверждения просмотра';
COMMENT ON COLUMN "public"."obj_news_confirmations"."result" IS 'Результат';
COMMENT ON TABLE "public"."obj_news_confirmations" IS 'Подтверждения прочтения новостей и объявлений';

-- ----------------------------
-- Table structure for obj_tariffs
-- ----------------------------
DROP TABLE IF EXISTS "public"."obj_tariffs";
CREATE TABLE "public"."obj_tariffs" (
  "tariffs_id" int4 NOT NULL GENERATED BY DEFAULT AS IDENTITY (
INCREMENT 1
MINVALUE  1
MAXVALUE 2147483647
START 1
),
  "tariff_name" varchar(256) COLLATE "pg_catalog"."default" DEFAULT 'Новый тариф'::character varying,
  "tariff_description" text COLLATE "pg_catalog"."default" DEFAULT NULL::character varying,
  "tariff_rules" jsonb,
  "created" timestamptz(6) DEFAULT now(),
  "comments" text COLLATE "pg_catalog"."default",
  "enabled" int2 DEFAULT (1)::smallint,
  "acceptor_id" int4 NOT NULL DEFAULT 1,
  "tariff_short_name" varchar(48) COLLATE "pg_catalog"."default"
)
;
COMMENT ON COLUMN "public"."obj_tariffs"."tariffs_id" IS 'PK';
COMMENT ON COLUMN "public"."obj_tariffs"."tariff_name" IS 'Название тарифа';
COMMENT ON COLUMN "public"."obj_tariffs"."tariff_description" IS 'Описание тарифа';
COMMENT ON COLUMN "public"."obj_tariffs"."tariff_rules" IS 'Правила тарифа';
COMMENT ON COLUMN "public"."obj_tariffs"."created" IS 'Дата создания';
COMMENT ON COLUMN "public"."obj_tariffs"."comments" IS 'Комментарии';
COMMENT ON COLUMN "public"."obj_tariffs"."enabled" IS 'Тариф включен';
COMMENT ON COLUMN "public"."obj_tariffs"."acceptor_id" IS 'ID реквизитов получателя';
COMMENT ON COLUMN "public"."obj_tariffs"."tariff_short_name" IS 'Короткое название тарифа';
COMMENT ON TABLE "public"."obj_tariffs" IS 'Тарифы для приборов учета';

-- ----------------------------
-- Table structure for obj_tariffs_acceptors
-- ----------------------------
DROP TABLE IF EXISTS "public"."obj_tariffs_acceptors";
CREATE TABLE "public"."obj_tariffs_acceptors" (
  "tariff_acceptors_id" int4 NOT NULL GENERATED BY DEFAULT AS IDENTITY (
INCREMENT 1
MINVALUE  1
MAXVALUE 2147483647
START 1
),
  "name" varchar(256) COLLATE "pg_catalog"."default" DEFAULT 'Новый получатель платежей'::character varying,
  "address" text COLLATE "pg_catalog"."default",
  "OGRN" text COLLATE "pg_catalog"."default",
  "INN" text COLLATE "pg_catalog"."default",
  "KPPacceptor" text COLLATE "pg_catalog"."default",
  "schet" text COLLATE "pg_catalog"."default",
  "valuta" text COLLATE "pg_catalog"."default",
  "bank" text COLLATE "pg_catalog"."default",
  "KPPbank" text COLLATE "pg_catalog"."default",
  "BIK" text COLLATE "pg_catalog"."default",
  "korrSchet" text COLLATE "pg_catalog"."default",
  "created" timestamptz(6) DEFAULT now(),
  "comments" text COLLATE "pg_catalog"."default",
  "enabled" int2 DEFAULT (1)::smallint
)
;
COMMENT ON COLUMN "public"."obj_tariffs_acceptors"."tariff_acceptors_id" IS 'PK';
COMMENT ON COLUMN "public"."obj_tariffs_acceptors"."name" IS 'Название';
COMMENT ON COLUMN "public"."obj_tariffs_acceptors"."address" IS 'Адрес';
COMMENT ON COLUMN "public"."obj_tariffs_acceptors"."OGRN" IS 'ОГРН';
COMMENT ON COLUMN "public"."obj_tariffs_acceptors"."INN" IS 'ИНН';
COMMENT ON COLUMN "public"."obj_tariffs_acceptors"."KPPacceptor" IS 'КПП получателя';
COMMENT ON COLUMN "public"."obj_tariffs_acceptors"."schet" IS 'Счёт';
COMMENT ON COLUMN "public"."obj_tariffs_acceptors"."valuta" IS 'Валюта';
COMMENT ON COLUMN "public"."obj_tariffs_acceptors"."bank" IS 'Банк';
COMMENT ON COLUMN "public"."obj_tariffs_acceptors"."KPPbank" IS 'КПП банка';
COMMENT ON COLUMN "public"."obj_tariffs_acceptors"."BIK" IS 'БИК';
COMMENT ON COLUMN "public"."obj_tariffs_acceptors"."korrSchet" IS 'Корр.счёт';
COMMENT ON COLUMN "public"."obj_tariffs_acceptors"."created" IS 'Дата создания';
COMMENT ON COLUMN "public"."obj_tariffs_acceptors"."comments" IS 'Комментарии';
COMMENT ON COLUMN "public"."obj_tariffs_acceptors"."enabled" IS 'Получатель включен';
COMMENT ON TABLE "public"."obj_tariffs_acceptors" IS 'Получатели средств при оплате по тарифам';

-- ----------------------------
-- Table structure for obj_users_lands
-- ----------------------------
DROP TABLE IF EXISTS "public"."obj_users_lands";
CREATE TABLE "public"."obj_users_lands" (
  "users_lands_id" int4 NOT NULL GENERATED BY DEFAULT AS IDENTITY (
INCREMENT 1
MINVALUE  1
MAXVALUE 2147483647
START 1
),
  "uid" int4 NOT NULL,
  "lands_id" int4 NOT NULL,
  "created" timestamptz(6) NOT NULL DEFAULT now(),
  "deleted" timestamptz(6)
)
;
COMMENT ON COLUMN "public"."obj_users_lands"."users_lands_id" IS 'PK';
COMMENT ON COLUMN "public"."obj_users_lands"."uid" IS 'ID пользователя';
COMMENT ON COLUMN "public"."obj_users_lands"."lands_id" IS 'ID участка';
COMMENT ON COLUMN "public"."obj_users_lands"."created" IS 'Дата назначения';
COMMENT ON COLUMN "public"."obj_users_lands"."deleted" IS 'Дата удаления';
COMMENT ON TABLE "public"."obj_users_lands" IS 'Связь пользователя и участка';

-- ----------------------------
-- Table structure for obj_votings
-- ----------------------------
DROP TABLE IF EXISTS "public"."obj_votings";
CREATE TABLE "public"."obj_votings" (
  "votings_id" int4 NOT NULL GENERATED BY DEFAULT AS IDENTITY (
INCREMENT 1
MINVALUE  1
MAXVALUE 2147483647
START 1
),
  "votings_type" int4 NOT NULL DEFAULT 63,
  "votings_header" text COLLATE "pg_catalog"."default" DEFAULT 'Новое голосование'::character varying,
  "votings_query" text COLLATE "pg_catalog"."default" DEFAULT NULL::character varying,
  "votings_variants" json NOT NULL,
  "votings_summary" text COLLATE "pg_catalog"."default",
  "votings_author" int4 NOT NULL DEFAULT 1,
  "date_actual_start" timestamptz(6),
  "date_actual_end" timestamptz(6),
  "recipients" text COLLATE "pg_catalog"."default",
  "created" timestamptz(6) DEFAULT now(),
  "enabled" int2 DEFAULT (1)::smallint,
  "comments" text COLLATE "pg_catalog"."default"
)
;
COMMENT ON COLUMN "public"."obj_votings"."votings_id" IS 'PK';
COMMENT ON COLUMN "public"."obj_votings"."votings_type" IS 'Тип голосования';
COMMENT ON COLUMN "public"."obj_votings"."votings_header" IS 'Заголовок голосования';
COMMENT ON COLUMN "public"."obj_votings"."votings_query" IS 'Вопрос голосования';
COMMENT ON COLUMN "public"."obj_votings"."votings_variants" IS 'Параметры голосования, варианты ответов, кворум и т.п.';
COMMENT ON COLUMN "public"."obj_votings"."votings_summary" IS 'Итоги голосования';
COMMENT ON COLUMN "public"."obj_votings"."votings_author" IS 'Автор';
COMMENT ON COLUMN "public"."obj_votings"."date_actual_start" IS 'Начало публикации';
COMMENT ON COLUMN "public"."obj_votings"."date_actual_end" IS 'Окончание публикации';
COMMENT ON COLUMN "public"."obj_votings"."recipients" IS 'Участники';
COMMENT ON COLUMN "public"."obj_votings"."created" IS 'Дата создания';
COMMENT ON COLUMN "public"."obj_votings"."enabled" IS 'Включено';
COMMENT ON COLUMN "public"."obj_votings"."comments" IS 'Комментарии';
COMMENT ON TABLE "public"."obj_votings" IS 'Опросы и голосования';

-- ----------------------------
-- Table structure for obj_votings_results
-- ----------------------------
DROP TABLE IF EXISTS "public"."obj_votings_results";
CREATE TABLE "public"."obj_votings_results" (
  "votings_results_id" int4 NOT NULL GENERATED BY DEFAULT AS IDENTITY (
INCREMENT 1
MINVALUE  1
MAXVALUE 2147483647
START 1
),
  "votings_id" int4 NOT NULL,
  "uid" int4 NOT NULL,
  "created" timestamptz(6) NOT NULL DEFAULT now(),
  "result" varchar(256) COLLATE "pg_catalog"."default" DEFAULT NULL::character varying
)
;
COMMENT ON COLUMN "public"."obj_votings_results"."votings_results_id" IS 'PK';
COMMENT ON COLUMN "public"."obj_votings_results"."votings_id" IS 'ID голосования';
COMMENT ON COLUMN "public"."obj_votings_results"."uid" IS 'ID пользователя';
COMMENT ON COLUMN "public"."obj_votings_results"."created" IS 'Дата голосования';
COMMENT ON COLUMN "public"."obj_votings_results"."result" IS 'Результат';
COMMENT ON TABLE "public"."obj_votings_results" IS 'Результаты опросов и голосований';

-- ----------------------------
-- Table structure for orders
-- ----------------------------
DROP TABLE IF EXISTS "public"."orders";
CREATE TABLE "public"."orders" (
  "id" int4 NOT NULL GENERATED BY DEFAULT AS IDENTITY (
INCREMENT 1
MINVALUE  1
MAXVALUE 2147483647
START 11848
),
  "uid" int4 NOT NULL,
  "status" varchar(128) COLLATE "pg_catalog"."default",
  "date" int4,
  "manager" int4 DEFAULT 0,
  "weight" numeric(12,2),
  "delivery" numeric(12,2),
  "sum" numeric(12,2),
  "code" varchar(128) COLLATE "pg_catalog"."default",
  "addresses_id" int4,
  "delivery_id" varchar(64) COLLATE "pg_catalog"."default",
  "manual_weight" numeric(12,2),
  "manual_delivery" numeric(12,2),
  "manual_sum" numeric(12,2),
  "frozen" int2 DEFAULT 0
)
;
COMMENT ON COLUMN "public"."orders"."id" IS 'ID заказа (oid в связанных таблицах)';
COMMENT ON COLUMN "public"."orders"."uid" IS 'ID пользователя, сделавшего заказ';
COMMENT ON COLUMN "public"."orders"."status" IS 'ID (value) статуса заказа';
COMMENT ON COLUMN "public"."orders"."date" IS 'Дата поступления заказа от покупателя';
COMMENT ON COLUMN "public"."orders"."manager" IS 'UID менеджера заказа';
COMMENT ON COLUMN "public"."orders"."weight" IS 'Вес заказа в граммах при отправке покупателю, фактически';
COMMENT ON COLUMN "public"."orders"."delivery" IS 'Стоимость доставки заказа покупателю, расчётная, во внутренней валюте';
COMMENT ON COLUMN "public"."orders"."sum" IS 'Стоимость заказа для покупателя, во внутренней валюте, расчётная';
COMMENT ON COLUMN "public"."orders"."code" IS 'Трек-код посылки, отправленной заказчику';
COMMENT ON COLUMN "public"."orders"."addresses_id" IS 'ID адреса получателя заказа';
COMMENT ON COLUMN "public"."orders"."delivery_id" IS 'ID (название) выбранной службы доставки';
COMMENT ON COLUMN "public"."orders"."manual_weight" IS 'Вес в граммах на складе при отправке';
COMMENT ON COLUMN "public"."orders"."manual_delivery" IS 'Стоимость доставаки, введённая вручную';
COMMENT ON COLUMN "public"."orders"."manual_sum" IS 'Стоимость товаров, введённая вручную';
COMMENT ON COLUMN "public"."orders"."frozen" IS 'Заказ проверен и подтверждён, изменения заблокированы';
COMMENT ON TABLE "public"."orders" IS 'Заказы';

-- ----------------------------
-- Table structure for orders_comments
-- ----------------------------
DROP TABLE IF EXISTS "public"."orders_comments";
CREATE TABLE "public"."orders_comments" (
  "id" int8 NOT NULL GENERATED BY DEFAULT AS IDENTITY (
INCREMENT 1
MINVALUE  1
MAXVALUE 9223372036854775807
START 5335
),
  "oid" int4 NOT NULL,
  "uid" int4 NOT NULL,
  "date" timestamptz(6) NOT NULL,
  "message" text COLLATE "pg_catalog"."default" NOT NULL,
  "internal" int2 NOT NULL DEFAULT 0
)
;
COMMENT ON COLUMN "public"."orders_comments"."id" IS 'ID комментария';
COMMENT ON COLUMN "public"."orders_comments"."oid" IS 'ID заказа';
COMMENT ON COLUMN "public"."orders_comments"."uid" IS 'Автор сообщения';
COMMENT ON COLUMN "public"."orders_comments"."date" IS 'Дата сообщения';
COMMENT ON COLUMN "public"."orders_comments"."message" IS 'Текст сообщения';
COMMENT ON COLUMN "public"."orders_comments"."internal" IS 'Внутреннее сообщение (не видно клиентам)';
COMMENT ON TABLE "public"."orders_comments" IS 'Комментарии к заказу';

-- ----------------------------
-- Table structure for orders_comments_attaches
-- ----------------------------
DROP TABLE IF EXISTS "public"."orders_comments_attaches";
CREATE TABLE "public"."orders_comments_attaches" (
  "id" int8 NOT NULL GENERATED BY DEFAULT AS IDENTITY (
INCREMENT 1
MINVALUE  1
MAXVALUE 9223372036854775807
START 40
),
  "comment_id" int8 NOT NULL,
  "attach" bytea
)
;
COMMENT ON COLUMN "public"."orders_comments_attaches"."id" IS 'ID приложения к сообщению';
COMMENT ON COLUMN "public"."orders_comments_attaches"."comment_id" IS 'ID комментария';
COMMENT ON COLUMN "public"."orders_comments_attaches"."attach" IS 'Двичное тело приложения, строго картинка jpg или png';
COMMENT ON TABLE "public"."orders_comments_attaches" IS 'Изображения комментариев к заказам';

-- ----------------------------
-- Table structure for orders_items
-- ----------------------------
DROP TABLE IF EXISTS "public"."orders_items";
CREATE TABLE "public"."orders_items" (
  "id" int4 NOT NULL GENERATED BY DEFAULT AS IDENTITY (
INCREMENT 1
MINVALUE  1
MAXVALUE 2147483647
START 72139
),
  "oid" int4,
  "iid" varchar(45) COLLATE "pg_catalog"."default" NOT NULL,
  "pic_url" varchar(1024) COLLATE "pg_catalog"."default" NOT NULL,
  "sku_id" varchar(256) COLLATE "pg_catalog"."default",
  "props" varchar(4000) COLLATE "pg_catalog"."default",
  "title" text COLLATE "pg_catalog"."default",
  "seller_nick" varchar(1024) COLLATE "pg_catalog"."default",
  "seller_id" varchar(45) COLLATE "pg_catalog"."default" NOT NULL DEFAULT ''::character varying,
  "status" int2 NOT NULL DEFAULT 1,
  "num" numeric(12,2) NOT NULL DEFAULT 0.00,
  "weight" numeric(12,2) NOT NULL DEFAULT 0.00,
  "express_fee" numeric(12,2) NOT NULL DEFAULT 0.00,
  "input_props" text COLLATE "pg_catalog"."default",
  "source_price" numeric(12,2) NOT NULL DEFAULT 0.00,
  "source_promotion_price" numeric(12,2) NOT NULL DEFAULT 0.00,
  "tid" varchar(4000) COLLATE "pg_catalog"."default",
  "track_code" varchar(4000) COLLATE "pg_catalog"."default",
  "actual_num" numeric(12,2),
  "actual_lot_weight" numeric(12,2),
  "actual_lot_express_fee" numeric(12,2),
  "actual_lot_price" numeric(12,2),
  "ds_source" varchar(32) COLLATE "pg_catalog"."default",
  "ds_type" varchar(16) COLLATE "pg_catalog"."default"
)
;
COMMENT ON COLUMN "public"."orders_items"."id" IS 'ID лота в заказе';
COMMENT ON COLUMN "public"."orders_items"."oid" IS 'ID заказа';
COMMENT ON COLUMN "public"."orders_items"."iid" IS 'Item ID товара лота';
COMMENT ON COLUMN "public"."orders_items"."pic_url" IS 'url картинки товара';
COMMENT ON COLUMN "public"."orders_items"."sku_id" IS 'SKU id';
COMMENT ON COLUMN "public"."orders_items"."props" IS 'PID:VID товара (SKU)';
COMMENT ON COLUMN "public"."orders_items"."title" IS 'Название товара';
COMMENT ON COLUMN "public"."orders_items"."seller_nick" IS 'Ник продавца';
COMMENT ON COLUMN "public"."orders_items"."seller_id" IS 'ID продавца';
COMMENT ON COLUMN "public"."orders_items"."status" IS 'ID статуса лота';
COMMENT ON COLUMN "public"."orders_items"."num" IS 'Кол-во товаров в заказе';
COMMENT ON COLUMN "public"."orders_items"."weight" IS 'Вес 1 шт. товара';
COMMENT ON COLUMN "public"."orders_items"."express_fee" IS 'Стоимость доставки по Китаю';
COMMENT ON COLUMN "public"."orders_items"."input_props" IS 'Свойства товара лота';
COMMENT ON COLUMN "public"."orders_items"."source_price" IS 'Цена на таобао без скидки и доставки';
COMMENT ON COLUMN "public"."orders_items"."source_promotion_price" IS 'Цена на таобао со скидкой, но без доставки';
COMMENT ON COLUMN "public"."orders_items"."tid" IS 'Trade ID, id сделки на таобао';
COMMENT ON COLUMN "public"."orders_items"."track_code" IS 'Трек-код сделки на таоао';
COMMENT ON COLUMN "public"."orders_items"."actual_num" IS 'Реальное количество товара, которое можно закупить';
COMMENT ON COLUMN "public"."orders_items"."actual_lot_weight" IS 'Реальный вес в граммах всего лота (а не 1 шт как в weight)';
COMMENT ON COLUMN "public"."orders_items"."actual_lot_express_fee" IS 'Реальная цена доставки по Китаю всего лота (а не одной единицы товара)';
COMMENT ON COLUMN "public"."orders_items"."actual_lot_price" IS 'Реальная цена товаров лота';
COMMENT ON COLUMN "public"."orders_items"."ds_source" IS 'Тип источника данных категории';

-- ----------------------------
-- Table structure for orders_items_comments
-- ----------------------------
DROP TABLE IF EXISTS "public"."orders_items_comments";
CREATE TABLE "public"."orders_items_comments" (
  "id" int8 NOT NULL GENERATED BY DEFAULT AS IDENTITY (
INCREMENT 1
MINVALUE  1
MAXVALUE 9223372036854775807
START 18052
),
  "item_id" int4 NOT NULL,
  "uid" int4 NOT NULL,
  "date" timestamptz(6) NOT NULL,
  "message" text COLLATE "pg_catalog"."default" NOT NULL,
  "internal" int2 NOT NULL DEFAULT 0
)
;
COMMENT ON COLUMN "public"."orders_items_comments"."id" IS 'id комментария к лоту';
COMMENT ON COLUMN "public"."orders_items_comments"."item_id" IS 'Id лота заказа';
COMMENT ON COLUMN "public"."orders_items_comments"."uid" IS 'id пользователя - автора сообщения';
COMMENT ON COLUMN "public"."orders_items_comments"."date" IS 'Дата сообщения';
COMMENT ON COLUMN "public"."orders_items_comments"."message" IS 'Текст сообщения';
COMMENT ON COLUMN "public"."orders_items_comments"."internal" IS 'Только для менеджеров, не показывать пользователю';
COMMENT ON TABLE "public"."orders_items_comments" IS 'Комментарии к лотам';

-- ----------------------------
-- Table structure for orders_items_comments_attaches
-- ----------------------------
DROP TABLE IF EXISTS "public"."orders_items_comments_attaches";
CREATE TABLE "public"."orders_items_comments_attaches" (
  "id" int8 NOT NULL GENERATED BY DEFAULT AS IDENTITY (
INCREMENT 1
MINVALUE  1
MAXVALUE 9223372036854775807
START 370
),
  "comment_id" int8 NOT NULL,
  "attach" bytea
)
;
COMMENT ON COLUMN "public"."orders_items_comments_attaches"."id" IS 'id приложения к коментарию лота';
COMMENT ON COLUMN "public"."orders_items_comments_attaches"."comment_id" IS 'id комментария к лоту';
COMMENT ON COLUMN "public"."orders_items_comments_attaches"."attach" IS 'Двичное тело приложения, строго картинка jpg или png';
COMMENT ON TABLE "public"."orders_items_comments_attaches" IS 'Изображения комментариев к лотам';

-- ----------------------------
-- Table structure for orders_items_statuses
-- ----------------------------
DROP TABLE IF EXISTS "public"."orders_items_statuses";
CREATE TABLE "public"."orders_items_statuses" (
  "id" int2 NOT NULL,
  "name" varchar(512) COLLATE "pg_catalog"."default",
  "desc" text COLLATE "pg_catalog"."default",
  "excluded" int2 NOT NULL DEFAULT 0,
  "parcelable" int2 NOT NULL DEFAULT 0
)
;
COMMENT ON COLUMN "public"."orders_items_statuses"."id" IS 'id статуса посылки (лота)';
COMMENT ON COLUMN "public"."orders_items_statuses"."excluded" IS 'Не включать стоимость в заказ';
COMMENT ON COLUMN "public"."orders_items_statuses"."parcelable" IS 'Лот готов к посылке';
COMMENT ON TABLE "public"."orders_items_statuses" IS 'Статусы посылок \ лотов заказа';

-- ----------------------------
-- Table structure for orders_payments
-- ----------------------------
DROP TABLE IF EXISTS "public"."orders_payments";
CREATE TABLE "public"."orders_payments" (
  "id" int4 NOT NULL GENERATED BY DEFAULT AS IDENTITY (
INCREMENT 1
MINVALUE  1
MAXVALUE 2147483647
START 9075
),
  "oid" int4 NOT NULL,
  "uid" int4 NOT NULL,
  "summ" numeric(12,2) NOT NULL,
  "date" timestamptz(6) NOT NULL,
  "descr" text COLLATE "pg_catalog"."default"
)
;
COMMENT ON COLUMN "public"."orders_payments"."id" IS 'ID платежа';
COMMENT ON COLUMN "public"."orders_payments"."oid" IS 'ID заказа';
COMMENT ON COLUMN "public"."orders_payments"."uid" IS 'ID пользователя или менеджера, проведшего платёж';
COMMENT ON COLUMN "public"."orders_payments"."summ" IS 'Сумма платежа во внутренней валюте';
COMMENT ON COLUMN "public"."orders_payments"."date" IS 'Дата проведения платежа';
COMMENT ON COLUMN "public"."orders_payments"."descr" IS 'Описание платежа';
COMMENT ON TABLE "public"."orders_payments" IS 'Таблица платежей по заказу';

-- ----------------------------
-- Table structure for orders_statuses
-- ----------------------------
DROP TABLE IF EXISTS "public"."orders_statuses";
CREATE TABLE "public"."orders_statuses" (
  "id" int4 NOT NULL GENERATED BY DEFAULT AS IDENTITY (
INCREMENT 1
MINVALUE  1
MAXVALUE 2147483647
START 32
),
  "value" varchar(128) COLLATE "pg_catalog"."default" NOT NULL,
  "name" varchar(256) COLLATE "pg_catalog"."default" NOT NULL,
  "descr" text COLLATE "pg_catalog"."default",
  "manual" int2 DEFAULT 0,
  "aplyment_criteria" text COLLATE "pg_catalog"."default",
  "auto_criteria" text COLLATE "pg_catalog"."default",
  "order_in_process" int2 DEFAULT 100,
  "enabled" int2 DEFAULT 0,
  "parent_status_value" varchar(128) COLLATE "pg_catalog"."default"
)
;
COMMENT ON COLUMN "public"."orders_statuses"."id" IS 'id записи заказа. Внимание, в расчётах не используется!';
COMMENT ON COLUMN "public"."orders_statuses"."value" IS 'ID заказа для расчётов';
COMMENT ON COLUMN "public"."orders_statuses"."descr" IS 'Описание статуса заказа';
COMMENT ON COLUMN "public"."orders_statuses"."manual" IS 'Устанавливается ли статус вручную';
COMMENT ON COLUMN "public"."orders_statuses"."aplyment_criteria" IS 'Условие применения статуса к заказу';
COMMENT ON COLUMN "public"."orders_statuses"."auto_criteria" IS 'Условие вычисления статуса';
COMMENT ON COLUMN "public"."orders_statuses"."order_in_process" IS 'Порядок статуса в бизнес-процессе';
COMMENT ON COLUMN "public"."orders_statuses"."enabled" IS 'Включен ли статус';
COMMENT ON COLUMN "public"."orders_statuses"."parent_status_value" IS 'Value статуса, определяющего поведение';
COMMENT ON TABLE "public"."orders_statuses" IS 'Статусы заказа';

-- ----------------------------
-- Table structure for parcels
-- ----------------------------
DROP TABLE IF EXISTS "public"."parcels";
CREATE TABLE "public"."parcels" (
  "id" int4 NOT NULL GENERATED BY DEFAULT AS IDENTITY (
INCREMENT 1
MINVALUE  1
MAXVALUE 2147483647
START 10
),
  "uid" int4 NOT NULL,
  "status" varchar(128) COLLATE "pg_catalog"."default" NOT NULL,
  "date" int4,
  "manager" int4 DEFAULT 0,
  "weight" numeric(12,2),
  "manual_weight" numeric(12,2),
  "sum" numeric(12,2),
  "manual_sum" numeric(12,2),
  "code" varchar(128) COLLATE "pg_catalog"."default",
  "addresses_id" int4,
  "delivery_id" varchar(64) COLLATE "pg_catalog"."default"
)
;
COMMENT ON COLUMN "public"."parcels"."id" IS 'ID посылки (pid в связанных таблицах)';
COMMENT ON COLUMN "public"."parcels"."uid" IS 'ID пользователя, заказавшего посылку';
COMMENT ON COLUMN "public"."parcels"."status" IS 'ID (value) статуса посылки';
COMMENT ON COLUMN "public"."parcels"."date" IS 'Дата создания посылки';
COMMENT ON COLUMN "public"."parcels"."manager" IS 'UID менеджера посылки';
COMMENT ON COLUMN "public"."parcels"."weight" IS 'Вес посылки в граммах при отправке покупателю, фактически';
COMMENT ON COLUMN "public"."parcels"."sum" IS 'Заявленная стоимость посылки';
COMMENT ON COLUMN "public"."parcels"."code" IS 'Трек-код посылки, отправленной заказчику';
COMMENT ON COLUMN "public"."parcels"."addresses_id" IS 'ID адреса получателя заказа';
COMMENT ON COLUMN "public"."parcels"."delivery_id" IS 'ID (название) выбранной службы доставки';
COMMENT ON TABLE "public"."parcels" IS 'Посылки';

-- ----------------------------
-- Table structure for parcels_cart
-- ----------------------------
DROP TABLE IF EXISTS "public"."parcels_cart";
CREATE TABLE "public"."parcels_cart" (
  "id" int8 NOT NULL GENERATED BY DEFAULT AS IDENTITY (
INCREMENT 1
MINVALUE  1
MAXVALUE 9223372036854775807
START 1809
),
  "uid" int4 NOT NULL,
  "iid" int4 NOT NULL DEFAULT 0,
  "num" int4 NOT NULL DEFAULT 0,
  "date" timestamptz(6),
  "order" int2 NOT NULL DEFAULT 1
)
;
COMMENT ON COLUMN "public"."parcels_cart"."order" IS 'Включать ли лот в заказ';
COMMENT ON TABLE "public"."parcels_cart" IS 'Корзины посылок пользователей';

-- ----------------------------
-- Table structure for parcels_comments
-- ----------------------------
DROP TABLE IF EXISTS "public"."parcels_comments";
CREATE TABLE "public"."parcels_comments" (
  "id" int8 NOT NULL GENERATED BY DEFAULT AS IDENTITY (
INCREMENT 1
MINVALUE  1
MAXVALUE 9223372036854775807
START 3
),
  "pid" int4 NOT NULL,
  "uid" int4 NOT NULL,
  "date" timestamptz(6) NOT NULL,
  "message" text COLLATE "pg_catalog"."default" NOT NULL,
  "internal" int2 NOT NULL DEFAULT 0
)
;
COMMENT ON COLUMN "public"."parcels_comments"."id" IS 'ID комментария';
COMMENT ON COLUMN "public"."parcels_comments"."pid" IS 'ID посылки';
COMMENT ON COLUMN "public"."parcels_comments"."uid" IS 'Автор сообщения';
COMMENT ON COLUMN "public"."parcels_comments"."date" IS 'Дата сообщения';
COMMENT ON COLUMN "public"."parcels_comments"."message" IS 'Текст сообщения';
COMMENT ON COLUMN "public"."parcels_comments"."internal" IS 'Внутреннее сообщение (не видно клиентам)';
COMMENT ON TABLE "public"."parcels_comments" IS 'Комментарии к посылке';

-- ----------------------------
-- Table structure for parcels_comments_attaches
-- ----------------------------
DROP TABLE IF EXISTS "public"."parcels_comments_attaches";
CREATE TABLE "public"."parcels_comments_attaches" (
  "id" int8 NOT NULL GENERATED BY DEFAULT AS IDENTITY (
INCREMENT 1
MINVALUE  1
MAXVALUE 9223372036854775807
START 2
),
  "comment_id" int8 NOT NULL,
  "attach" bytea
)
;
COMMENT ON COLUMN "public"."parcels_comments_attaches"."id" IS 'ID приложения к сообщению';
COMMENT ON COLUMN "public"."parcels_comments_attaches"."comment_id" IS 'ID комментария';
COMMENT ON COLUMN "public"."parcels_comments_attaches"."attach" IS 'Двичное тело приложения, строго картинка jpg или png';
COMMENT ON TABLE "public"."parcels_comments_attaches" IS 'Изображения комментариев к посылкам';

-- ----------------------------
-- Table structure for parcels_items
-- ----------------------------
DROP TABLE IF EXISTS "public"."parcels_items";
CREATE TABLE "public"."parcels_items" (
  "id" int4 NOT NULL GENERATED BY DEFAULT AS IDENTITY (
INCREMENT 1
MINVALUE  1
MAXVALUE 2147483647
START 250
),
  "pid" int4 NOT NULL,
  "iid" int4 NOT NULL,
  "num" int4,
  "date" timestamptz(6)
)
;
COMMENT ON COLUMN "public"."parcels_items"."id" IS 'ID лота в посылке';
COMMENT ON COLUMN "public"."parcels_items"."pid" IS 'ID посылки';
COMMENT ON COLUMN "public"."parcels_items"."iid" IS 'ID лота в заказе';
COMMENT ON TABLE "public"."parcels_items" IS 'Посылки - лоты';

-- ----------------------------
-- Table structure for parcels_payments
-- ----------------------------
DROP TABLE IF EXISTS "public"."parcels_payments";
CREATE TABLE "public"."parcels_payments" (
  "id" int4 NOT NULL GENERATED BY DEFAULT AS IDENTITY (
INCREMENT 1
MINVALUE  1
MAXVALUE 2147483647
START 2
),
  "pid" int4 NOT NULL,
  "uid" int4 NOT NULL,
  "summ" numeric(12,2) NOT NULL,
  "date" timestamptz(6) NOT NULL,
  "descr" text COLLATE "pg_catalog"."default"
)
;
COMMENT ON COLUMN "public"."parcels_payments"."id" IS 'ID платежа';
COMMENT ON COLUMN "public"."parcels_payments"."pid" IS 'ID посылки';
COMMENT ON COLUMN "public"."parcels_payments"."uid" IS 'ID пользователя или менеджера, проведшего платёж';
COMMENT ON COLUMN "public"."parcels_payments"."summ" IS 'Сумма платежа во внутренней валюте';
COMMENT ON COLUMN "public"."parcels_payments"."date" IS 'Дата проведения платежа';
COMMENT ON COLUMN "public"."parcels_payments"."descr" IS 'Описание платежа';
COMMENT ON TABLE "public"."parcels_payments" IS 'Таблица платежей по посылке';

-- ----------------------------
-- Table structure for parcels_statuses
-- ----------------------------
DROP TABLE IF EXISTS "public"."parcels_statuses";
CREATE TABLE "public"."parcels_statuses" (
  "id" int4 NOT NULL GENERATED BY DEFAULT AS IDENTITY (
INCREMENT 1
MINVALUE  1
MAXVALUE 2147483647
START 17
),
  "value" varchar(128) COLLATE "pg_catalog"."default" NOT NULL,
  "name" varchar(256) COLLATE "pg_catalog"."default" NOT NULL,
  "descr" text COLLATE "pg_catalog"."default",
  "manual" int2 DEFAULT 0,
  "aplyment_criteria" text COLLATE "pg_catalog"."default",
  "auto_criteria" text COLLATE "pg_catalog"."default",
  "order_in_process" int2 DEFAULT 100,
  "enabled" int2 DEFAULT 0,
  "parent_status_value" varchar(128) COLLATE "pg_catalog"."default"
)
;
COMMENT ON COLUMN "public"."parcels_statuses"."id" IS 'id записи заказа. Внимание, в расчётах не используется!';
COMMENT ON COLUMN "public"."parcels_statuses"."value" IS 'ID заказа для расчётов';
COMMENT ON COLUMN "public"."parcels_statuses"."descr" IS 'Описание статуса заказа';
COMMENT ON COLUMN "public"."parcels_statuses"."manual" IS 'Устанавливается ли статус вручную';
COMMENT ON COLUMN "public"."parcels_statuses"."aplyment_criteria" IS 'Условие применения статуса к заказу';
COMMENT ON COLUMN "public"."parcels_statuses"."auto_criteria" IS 'Условие вычисления статуса';
COMMENT ON COLUMN "public"."parcels_statuses"."order_in_process" IS 'Порядок статуса в бизнес-процессе';
COMMENT ON COLUMN "public"."parcels_statuses"."enabled" IS 'Включен ли статус';
COMMENT ON COLUMN "public"."parcels_statuses"."parent_status_value" IS 'Value статуса, определяющего поведение';
COMMENT ON TABLE "public"."parcels_statuses" IS 'Статусы посылки';

-- ----------------------------
-- Table structure for pay_systems
-- ----------------------------
DROP TABLE IF EXISTS "public"."pay_systems";
CREATE TABLE "public"."pay_systems" (
  "id" int4 NOT NULL GENERATED BY DEFAULT AS IDENTITY (
INCREMENT 1
MINVALUE  1
MAXVALUE 2147483647
START 35
),
  "enabled" int4 DEFAULT 0,
  "logo_img" varchar(512) COLLATE "pg_catalog"."default",
  "int_name" varchar(256) COLLATE "pg_catalog"."default",
  "int_type" varchar(256) COLLATE "pg_catalog"."default",
  "name_ru" varchar(256) COLLATE "pg_catalog"."default",
  "name_en" varchar(256) COLLATE "pg_catalog"."default",
  "descr_ru" text COLLATE "pg_catalog"."default",
  "descr_en" text COLLATE "pg_catalog"."default",
  "parameters" text COLLATE "pg_catalog"."default",
  "form_ru" text COLLATE "pg_catalog"."default",
  "form_en" text COLLATE "pg_catalog"."default"
)
;
COMMENT ON TABLE "public"."pay_systems" IS 'Описания платёжных систем';

-- ----------------------------
-- Table structure for pay_systems_log
-- ----------------------------
DROP TABLE IF EXISTS "public"."pay_systems_log";
CREATE TABLE "public"."pay_systems_log" (
  "id" int8 NOT NULL GENERATED BY DEFAULT AS IDENTITY (
INCREMENT 1
MINVALUE  1
MAXVALUE 9223372036854775807
START 203
),
  "date" timestamptz(6) NOT NULL,
  "from_ip" varchar(255) COLLATE "pg_catalog"."default",
  "action" varchar(255) COLLATE "pg_catalog"."default",
  "sender" varchar(255) COLLATE "pg_catalog"."default",
  "data" text COLLATE "pg_catalog"."default"
)
;
COMMENT ON COLUMN "public"."pay_systems_log"."id" IS 'PK';
COMMENT ON COLUMN "public"."pay_systems_log"."date" IS 'Время транзакции';
COMMENT ON COLUMN "public"."pay_systems_log"."from_ip" IS 'IP-адрес, с которого вызывается транзакция';
COMMENT ON COLUMN "public"."pay_systems_log"."action" IS 'Тип транзакции';
COMMENT ON COLUMN "public"."pay_systems_log"."sender" IS 'Имя платёжной системы';
COMMENT ON COLUMN "public"."pay_systems_log"."data" IS 'Данные';
COMMENT ON TABLE "public"."pay_systems_log" IS 'Лог транзакций платёных систем';

-- ----------------------------
-- Table structure for payments
-- ----------------------------
DROP TABLE IF EXISTS "public"."payments";
CREATE TABLE "public"."payments" (
  "id" int4 NOT NULL GENERATED BY DEFAULT AS IDENTITY (
INCREMENT 1
MINVALUE  1
MAXVALUE 2147483647
START 9455
),
  "sum" numeric(12,2) NOT NULL DEFAULT 0.00,
  "description" varchar(256) COLLATE "pg_catalog"."default",
  "status" int2 NOT NULL,
  "uid" int4 NOT NULL,
  "check_summ" numeric(12,2) DEFAULT 0.00,
  "oid" int4,
  "comment" text COLLATE "pg_catalog"."default",
  "manager_id" int4 DEFAULT 1,
  "date" timestamptz(6) NOT NULL DEFAULT now()
)
;
COMMENT ON COLUMN "public"."payments"."sum" IS 'Сумма платежа';
COMMENT ON COLUMN "public"."payments"."description" IS 'Описание платежа';
COMMENT ON COLUMN "public"."payments"."status" IS '1 - Зачисление или возврат средств
2 - Снятие средств
3 - Ожидание зачисления средств
4 - Отмена ожидания зачисления средств
5 - Отправка внутреннего перевода средств
6 - Получение внутреннего перевода средств';
COMMENT ON COLUMN "public"."payments"."uid" IS 'ID пользователя, которому принадлежит счёт';
COMMENT ON COLUMN "public"."payments"."check_summ" IS 'Контрольная сумма платежа';
COMMENT ON COLUMN "public"."payments"."oid" IS 'ID объекта. по которому произведён платёж (счёт, заказ)';
COMMENT ON COLUMN "public"."payments"."comment" IS 'Комментарий';
COMMENT ON COLUMN "public"."payments"."manager_id" IS 'ID менеджера, проведшего транзакцию';
COMMENT ON COLUMN "public"."payments"."date" IS 'Дата платежа';
COMMENT ON TABLE "public"."payments" IS 'Операции со счётом пользователя (кроме заказов)';

-- ----------------------------
-- Table structure for questions
-- ----------------------------
DROP TABLE IF EXISTS "public"."questions";
CREATE TABLE "public"."questions" (
  "id" int4 NOT NULL GENERATED BY DEFAULT AS IDENTITY (
INCREMENT 1
MINVALUE  1
MAXVALUE 2147483647
START 926
),
  "theme" varchar(128) COLLATE "pg_catalog"."default",
  "date" int4,
  "uid" int4,
  "category" int4 NOT NULL DEFAULT 1,
  "date_change" int4,
  "order_id" int4,
  "file" varchar(1024) COLLATE "pg_catalog"."default",
  "status" int2 NOT NULL DEFAULT 1,
  "email" varchar(256) COLLATE "pg_catalog"."default"
)
;
COMMENT ON COLUMN "public"."questions"."email" IS 'Email пользователя, если он гость';
COMMENT ON TABLE "public"."questions" IS 'Поддержка - вопросы';

-- ----------------------------
-- Table structure for reports_system
-- ----------------------------
DROP TABLE IF EXISTS "public"."reports_system";
CREATE TABLE "public"."reports_system" (
  "id" int4 NOT NULL GENERATED BY DEFAULT AS IDENTITY (
INCREMENT 1
MINVALUE  1
MAXVALUE 2147483647
START 28
),
  "internal_name" varchar(512) COLLATE "pg_catalog"."default",
  "name" varchar(2048) COLLATE "pg_catalog"."default",
  "description" text COLLATE "pg_catalog"."default",
  "script" text COLLATE "pg_catalog"."default" NOT NULL,
  "group" varchar(512) COLLATE "pg_catalog"."default",
  "enabled" int2 NOT NULL DEFAULT 0,
  "order" int2 DEFAULT 0
)
;
COMMENT ON COLUMN "public"."reports_system"."id" IS 'id отчёта';
COMMENT ON COLUMN "public"."reports_system"."internal_name" IS 'Внутренее имя отчёта';
COMMENT ON COLUMN "public"."reports_system"."name" IS 'Отображаемое имя отчёта';
COMMENT ON COLUMN "public"."reports_system"."description" IS 'Описание отчёта';
COMMENT ON COLUMN "public"."reports_system"."group" IS 'Группа отчётов';
COMMENT ON COLUMN "public"."reports_system"."enabled" IS 'Включен ли отчёт';
COMMENT ON TABLE "public"."reports_system" IS 'Отчёты';

-- ----------------------------
-- Table structure for scheduled_jobs
-- ----------------------------
DROP TABLE IF EXISTS "public"."scheduled_jobs";
CREATE TABLE "public"."scheduled_jobs" (
  "id" int4 NOT NULL GENERATED BY DEFAULT AS IDENTITY (
INCREMENT 1
MINVALUE  1
MAXVALUE 2147483647
START 21
),
  "job_script" text COLLATE "pg_catalog"."default",
  "job_start_time" timestamptz(6),
  "job_stop_time" timestamptz(6),
  "job_interval" int8 DEFAULT '-1'::integer,
  "job_description" text COLLATE "pg_catalog"."default"
)
;
COMMENT ON COLUMN "public"."scheduled_jobs"."id" IS 'PK';
COMMENT ON COLUMN "public"."scheduled_jobs"."job_script" IS 'Скрипт задания, в формате eval';
COMMENT ON COLUMN "public"."scheduled_jobs"."job_start_time" IS 'Время начала выполнения скрипта';
COMMENT ON COLUMN "public"."scheduled_jobs"."job_stop_time" IS 'Время завершения скрипта';
COMMENT ON COLUMN "public"."scheduled_jobs"."job_interval" IS 'Интервал в секундах для выполнения задания. -1 - выкл, 0 - 1 раз в job_start_time';
COMMENT ON COLUMN "public"."scheduled_jobs"."job_description" IS 'Описание скрипта';
COMMENT ON TABLE "public"."scheduled_jobs" IS 'Таблица запланированных заданий';

-- ----------------------------
-- Table structure for seo_keywords
-- ----------------------------
DROP TABLE IF EXISTS "public"."seo_keywords";
CREATE TABLE "public"."seo_keywords" (
  "lang" varchar(2) COLLATE "pg_catalog"."default" NOT NULL,
  "keyword" varchar(255) COLLATE "pg_catalog"."default" NOT NULL,
  "cnt" int4
)
;
COMMENT ON TABLE "public"."seo_keywords" IS 'Ключевики для SEO';

-- ----------------------------
-- Table structure for src_nekta_data_type1
-- ----------------------------
DROP TABLE IF EXISTS "public"."src_nekta_data_type1";
CREATE TABLE "public"."src_nekta_data_type1" (
  "device_id" int4 NOT NULL,
  "realdatetime" timestamptz(6) NOT NULL,
  "rssi" int2,
  "tariff1" numeric(10,3),
  "tariff2" numeric(10,3),
  "tariff3" numeric(10,3),
  "datetime" timestamptz(6),
  "station_id" varchar COLLATE "pg_catalog"."default",
  "transformation_ratio" float8,
  "transformation_ratio_current" float8,
  "transformation_ratio_voltage" float8,
  "start_tariff1" float8,
  "end_tariff1" float8,
  "delta_tariff1" float8,
  "start_tariff1_kkt" float8,
  "end_tariff1_kkt" float8,
  "delta_tariff1_kkt" float8,
  "start_tariff2" float8,
  "end_tariff2" float8,
  "delta_tariff2" float8,
  "start_tariff2_kkt" float8,
  "end_tariff2_kkt" float8,
  "delta_tariff2_kkt" float8,
  "start_tariff3" float8,
  "end_tariff3" float8,
  "delta_tariff3" float8,
  "start_tariff3_kkt" float8,
  "end_tariff3_kkt" float8,
  "delta_tariff3_kkt" float8
)
;
COMMENT ON TABLE "public"."src_nekta_data_type1" IS 'Ежедневные показания по тарифам /api/device/messages Get device messages
https://core.nekta.cloud/api/documentation';

-- ----------------------------
-- Table structure for src_nekta_data_type5
-- ----------------------------
DROP TABLE IF EXISTS "public"."src_nekta_data_type5";
CREATE TABLE "public"."src_nekta_data_type5" (
  "device_id" int4 NOT NULL,
  "realdatetime" timestamptz(6) NOT NULL,
  "rssi" int2,
  "datetime" timestamptz(6),
  "station_id" varchar(16) COLLATE "pg_catalog"."default",
  "power_a_plus" numeric(10,3),
  "incorrect_profile" bool,
  "incomplete_cut_flag" bool,
  "transformation_ratio_current" float8,
  "transformation_ratio_voltage" float8
)
;
COMMENT ON TABLE "public"."src_nekta_data_type5" IS 'Мгновенная потребляемая мощность /api/device/messages Get device messages
https://core.nekta.cloud/api/documentation';

-- ----------------------------
-- Table structure for src_nekta_data_type6
-- ----------------------------
DROP TABLE IF EXISTS "public"."src_nekta_data_type6";
CREATE TABLE "public"."src_nekta_data_type6" (
  "device_id" int4 NOT NULL,
  "realdatetime" timestamptz(6) NOT NULL,
  "freq" numeric(5,2),
  "coruu3" varchar(32) COLLATE "pg_catalog"."default",
  "status" int2,
  "current1" float8,
  "datetime" timestamptz(6),
  "voltage1" numeric(5,2)
)
;
COMMENT ON TABLE "public"."src_nekta_data_type6" IS '/api/device/messages Get device messages 
https://core.nekta.cloud/api/documentation';

-- ----------------------------
-- Table structure for src_nekta_device_groups
-- ----------------------------
DROP TABLE IF EXISTS "public"."src_nekta_device_groups";
CREATE TABLE "public"."src_nekta_device_groups" (
  "id" int4 NOT NULL,
  "name" varchar(255) COLLATE "pg_catalog"."default" NOT NULL,
  "slug" varchar(255) COLLATE "pg_catalog"."default"
)
;
COMMENT ON TABLE "public"."src_nekta_device_groups" IS 'Группы устройств Nekta';

-- ----------------------------
-- Table structure for src_nekta_device_models
-- ----------------------------
DROP TABLE IF EXISTS "public"."src_nekta_device_models";
CREATE TABLE "public"."src_nekta_device_models" (
  "id" int4 NOT NULL,
  "name" varchar(255) COLLATE "pg_catalog"."default",
  "slug" varchar(255) COLLATE "pg_catalog"."default",
  "device_brand_id" int4,
  "device_group_id" int4,
  "device_type_id" int4,
  "protocol_id" int4,
  "active" bool,
  "control_relay" bool,
  "options" jsonb,
  "tabs" jsonb,
  "rules" jsonb,
  "poll_rules" jsonb,
  "server_interface" jsonb,
  "gateway_interface" jsonb,
  "impulse_weight" jsonb
)
;
COMMENT ON TABLE "public"."src_nekta_device_models" IS 'Модели устройств Nekta';

-- ----------------------------
-- Table structure for src_nekta_device_types
-- ----------------------------
DROP TABLE IF EXISTS "public"."src_nekta_device_types";
CREATE TABLE "public"."src_nekta_device_types" (
  "id" int4 NOT NULL,
  "name" varchar(255) COLLATE "pg_catalog"."default",
  "slug" varchar(255) COLLATE "pg_catalog"."default",
  "device_group_id" int4
)
;
COMMENT ON TABLE "public"."src_nekta_device_types" IS 'Типы устройств Nekta';

-- ----------------------------
-- Table structure for src_nekta_metering_devices
-- ----------------------------
DROP TABLE IF EXISTS "public"."src_nekta_metering_devices";
CREATE TABLE "public"."src_nekta_metering_devices" (
  "id" int4 NOT NULL,
  "name" varchar(255) COLLATE "pg_catalog"."default",
  "device_id" varchar(16) COLLATE "pg_catalog"."default",
  "active" int2,
  "protocol_id" int4,
  "gateway_id" int4,
  "properties" jsonb,
  "device_timezone" int2,
  "interface_id" int4,
  "creator_id" int4,
  "company_creator_id" int4,
  "model_class_id" int4,
  "model_id" int4,
  "device_type_id" int4,
  "device_group_id" int4,
  "report_period_update" int4,
  "impulse_weight" float8,
  "starting_value" float8,
  "transformation_ratio" float8,
  "desc" text COLLATE "pg_catalog"."default",
  "last_active" timestamptz(6),
  "last_message" jsonb,
  "last_message_type" jsonb,
  "status" jsonb,
  "created_at" timestamptz(6),
  "updated_at" timestamptz(6),
  "deleted_at" timestamptz(6),
  "archived_at" timestamptz(6),
  "on_dashboard" bool,
  "address" jsonb,
  "active_polling" int4,
  "data_updated" timestamptz(6)
)
;
COMMENT ON COLUMN "public"."src_nekta_metering_devices"."id" IS 'Unique identifier of metering device model';
COMMENT ON COLUMN "public"."src_nekta_metering_devices"."name" IS 'Metering device model name';
COMMENT ON TABLE "public"."src_nekta_metering_devices" IS '/api/device/model/metering_devices
Get a list of metering devices models
See https://core.nekta.cloud/api/documentation';

-- ----------------------------
-- Table structure for t_category
-- ----------------------------
DROP TABLE IF EXISTS "public"."t_category";
CREATE TABLE "public"."t_category" (
  "id" int8 NOT NULL,
  "language" char(2) COLLATE "pg_catalog"."default" NOT NULL,
  "freq" int4 NOT NULL DEFAULT 0,
  "status" int2 NOT NULL DEFAULT 0,
  "translation" text COLLATE "pg_catalog"."default" NOT NULL
)
;
COMMENT ON COLUMN "public"."t_category"."id" IS 'PK';
COMMENT ON COLUMN "public"."t_category"."language" IS 'Язык перевода';
COMMENT ON COLUMN "public"."t_category"."freq" IS 'Количество вызовов перевода';
COMMENT ON COLUMN "public"."t_category"."status" IS 'Состояние перевода (1 - переведено и проверено носителем языка)';
COMMENT ON COLUMN "public"."t_category"."translation" IS 'Перевод';
COMMENT ON TABLE "public"."t_category" IS 'Значения переводов';

-- ----------------------------
-- Table structure for t_dictionary
-- ----------------------------
DROP TABLE IF EXISTS "public"."t_dictionary";
CREATE TABLE "public"."t_dictionary" (
  "id" int8 NOT NULL,
  "language" char(2) COLLATE "pg_catalog"."default" NOT NULL,
  "freq" int4 NOT NULL DEFAULT 0,
  "status" int2 NOT NULL DEFAULT 0,
  "translation" text COLLATE "pg_catalog"."default" NOT NULL
)
;
COMMENT ON COLUMN "public"."t_dictionary"."id" IS 'PK';
COMMENT ON COLUMN "public"."t_dictionary"."language" IS 'Язык перевода';
COMMENT ON COLUMN "public"."t_dictionary"."freq" IS 'Количество вызовов перевода';
COMMENT ON COLUMN "public"."t_dictionary"."status" IS 'Состояние перевода (1 - переведено и проверено носителем языка)';
COMMENT ON COLUMN "public"."t_dictionary"."translation" IS 'Перевод';
COMMENT ON TABLE "public"."t_dictionary" IS 'Значения переводов';

-- ----------------------------
-- Table structure for t_dictionary_long
-- ----------------------------
DROP TABLE IF EXISTS "public"."t_dictionary_long";
CREATE TABLE "public"."t_dictionary_long" (
  "id" int8 NOT NULL,
  "language" char(2) COLLATE "pg_catalog"."default" NOT NULL,
  "freq" int4 NOT NULL DEFAULT 0,
  "status" int2 NOT NULL DEFAULT 0,
  "translation" text COLLATE "pg_catalog"."default" NOT NULL
)
;
COMMENT ON COLUMN "public"."t_dictionary_long"."id" IS 'PK';
COMMENT ON COLUMN "public"."t_dictionary_long"."language" IS 'Язык перевода';
COMMENT ON COLUMN "public"."t_dictionary_long"."freq" IS 'Количество вызовов перевода';
COMMENT ON COLUMN "public"."t_dictionary_long"."status" IS 'Состояние перевода (1 - переведено и проверено носителем языка)';
COMMENT ON COLUMN "public"."t_dictionary_long"."translation" IS 'Перевод';
COMMENT ON TABLE "public"."t_dictionary_long" IS 'Значения переводов';

-- ----------------------------
-- Table structure for t_message
-- ----------------------------
DROP TABLE IF EXISTS "public"."t_message";
CREATE TABLE "public"."t_message" (
  "id" int4 NOT NULL,
  "language" varchar(6) COLLATE "pg_catalog"."default" NOT NULL,
  "translation" text COLLATE "pg_catalog"."default" NOT NULL,
  "corrected" timestamptz(6)
)
;
COMMENT ON TABLE "public"."t_message" IS 'Варианты переводов интерфейса на разные языки';

-- ----------------------------
-- Table structure for t_pinned
-- ----------------------------
DROP TABLE IF EXISTS "public"."t_pinned";
CREATE TABLE "public"."t_pinned" (
  "id" int8 NOT NULL,
  "language" char(2) COLLATE "pg_catalog"."default" NOT NULL,
  "freq" int4 NOT NULL DEFAULT 0,
  "status" int2 NOT NULL DEFAULT 0,
  "translation" text COLLATE "pg_catalog"."default" NOT NULL
)
;
COMMENT ON COLUMN "public"."t_pinned"."id" IS 'PK';
COMMENT ON COLUMN "public"."t_pinned"."language" IS 'Язык перевода';
COMMENT ON COLUMN "public"."t_pinned"."freq" IS 'Количество вызовов перевода';
COMMENT ON COLUMN "public"."t_pinned"."status" IS 'Состояние перевода (1 - переведено и проверено носителем языка)';
COMMENT ON COLUMN "public"."t_pinned"."translation" IS 'Перевод';
COMMENT ON TABLE "public"."t_pinned" IS 'Значения переводов';

-- ----------------------------
-- Table structure for t_sentences
-- ----------------------------
DROP TABLE IF EXISTS "public"."t_sentences";
CREATE TABLE "public"."t_sentences" (
  "id" int8 NOT NULL,
  "language" char(2) COLLATE "pg_catalog"."default" NOT NULL,
  "freq" int4 NOT NULL DEFAULT 0,
  "status" int2 NOT NULL DEFAULT 0,
  "translation" text COLLATE "pg_catalog"."default" NOT NULL
)
;
COMMENT ON COLUMN "public"."t_sentences"."id" IS 'PK';
COMMENT ON COLUMN "public"."t_sentences"."language" IS 'Язык перевода';
COMMENT ON COLUMN "public"."t_sentences"."freq" IS 'Количество вызовов перевода';
COMMENT ON COLUMN "public"."t_sentences"."status" IS 'Состояние перевода (1 - переведено и проверено носителем языка)';
COMMENT ON COLUMN "public"."t_sentences"."translation" IS 'Перевод';
COMMENT ON TABLE "public"."t_sentences" IS 'Значения переводов';

-- ----------------------------
-- Table structure for t_source_category
-- ----------------------------
DROP TABLE IF EXISTS "public"."t_source_category";
CREATE TABLE "public"."t_source_category" (
  "message_md5" char(32) COLLATE "pg_catalog"."default" NOT NULL,
  "language" char(2) COLLATE "pg_catalog"."default" NOT NULL,
  "category" char(16) COLLATE "pg_catalog"."default" NOT NULL,
  "id" int8 NOT NULL GENERATED BY DEFAULT AS IDENTITY (
INCREMENT 1
MINVALUE  1
MAXVALUE 9223372036854775807
START 10834240
),
  "message" text COLLATE "pg_catalog"."default" NOT NULL
)
;
COMMENT ON COLUMN "public"."t_source_category"."message_md5" IS 'Хэш оригинального текста';
COMMENT ON COLUMN "public"."t_source_category"."language" IS 'Исходный язык';
COMMENT ON COLUMN "public"."t_source_category"."category" IS 'Категория перевода';
COMMENT ON COLUMN "public"."t_source_category"."id" IS 'PK';
COMMENT ON COLUMN "public"."t_source_category"."message" IS 'Исходный текст';
COMMENT ON TABLE "public"."t_source_category" IS 'Основной словарь переводчика';

-- ----------------------------
-- Table structure for t_source_dictionary
-- ----------------------------
DROP TABLE IF EXISTS "public"."t_source_dictionary";
CREATE TABLE "public"."t_source_dictionary" (
  "message_md5" char(32) COLLATE "pg_catalog"."default" NOT NULL,
  "language" char(2) COLLATE "pg_catalog"."default" NOT NULL,
  "category" char(16) COLLATE "pg_catalog"."default" NOT NULL,
  "id" int8 NOT NULL GENERATED BY DEFAULT AS IDENTITY (
INCREMENT 1
MINVALUE  1
MAXVALUE 9223372036854775807
START 32304
),
  "message" text COLLATE "pg_catalog"."default" NOT NULL
)
;
COMMENT ON COLUMN "public"."t_source_dictionary"."message_md5" IS 'Хэш оригинального текста';
COMMENT ON COLUMN "public"."t_source_dictionary"."language" IS 'Исходный язык';
COMMENT ON COLUMN "public"."t_source_dictionary"."category" IS 'Категория перевода';
COMMENT ON COLUMN "public"."t_source_dictionary"."id" IS 'PK';
COMMENT ON COLUMN "public"."t_source_dictionary"."message" IS 'Исходный текст';
COMMENT ON TABLE "public"."t_source_dictionary" IS 'Основной словарь переводчика';

-- ----------------------------
-- Table structure for t_source_dictionary_long
-- ----------------------------
DROP TABLE IF EXISTS "public"."t_source_dictionary_long";
CREATE TABLE "public"."t_source_dictionary_long" (
  "message_md5" char(32) COLLATE "pg_catalog"."default" NOT NULL,
  "language" char(2) COLLATE "pg_catalog"."default" NOT NULL,
  "category" char(16) COLLATE "pg_catalog"."default" NOT NULL,
  "id" int8 NOT NULL GENERATED BY DEFAULT AS IDENTITY (
INCREMENT 1
MINVALUE  1
MAXVALUE 9223372036854775807
START 8760
),
  "message" text COLLATE "pg_catalog"."default" NOT NULL,
  "message_length" int4 NOT NULL DEFAULT 0
)
;
COMMENT ON COLUMN "public"."t_source_dictionary_long"."message_md5" IS 'Хэш оригинального текста';
COMMENT ON COLUMN "public"."t_source_dictionary_long"."language" IS 'Исходный язык';
COMMENT ON COLUMN "public"."t_source_dictionary_long"."category" IS 'Категория перевода';
COMMENT ON COLUMN "public"."t_source_dictionary_long"."id" IS 'PK';
COMMENT ON COLUMN "public"."t_source_dictionary_long"."message" IS 'Исходный текст';
COMMENT ON COLUMN "public"."t_source_dictionary_long"."message_length" IS 'Длина текста';
COMMENT ON TABLE "public"."t_source_dictionary_long" IS 'Основной словарь переводчика';

-- ----------------------------
-- Table structure for t_source_message
-- ----------------------------
DROP TABLE IF EXISTS "public"."t_source_message";
CREATE TABLE "public"."t_source_message" (
  "id" int4 NOT NULL GENERATED BY DEFAULT AS IDENTITY (
INCREMENT 1
MINVALUE  1
MAXVALUE 2147483647
START 13314
),
  "category" char(16) COLLATE "pg_catalog"."default" NOT NULL,
  "message" text COLLATE "pg_catalog"."default" NOT NULL,
  "message_md5" char(32) COLLATE "pg_catalog"."default" NOT NULL
)
;
COMMENT ON COLUMN "public"."t_source_message"."message_md5" IS 'Хэш текста';
COMMENT ON TABLE "public"."t_source_message" IS 'Сообщения интерфейса для перевода';

-- ----------------------------
-- Table structure for t_source_pinned
-- ----------------------------
DROP TABLE IF EXISTS "public"."t_source_pinned";
CREATE TABLE "public"."t_source_pinned" (
  "message_md5" char(32) COLLATE "pg_catalog"."default" NOT NULL,
  "language" char(2) COLLATE "pg_catalog"."default" NOT NULL,
  "category" char(16) COLLATE "pg_catalog"."default" NOT NULL,
  "id" int8 NOT NULL GENERATED BY DEFAULT AS IDENTITY (
INCREMENT 1
MINVALUE  1
MAXVALUE 9223372036854775807
START 5
),
  "message" text COLLATE "pg_catalog"."default" NOT NULL
)
;
COMMENT ON COLUMN "public"."t_source_pinned"."message_md5" IS 'Хэш оригинального текста';
COMMENT ON COLUMN "public"."t_source_pinned"."language" IS 'Исходный язык';
COMMENT ON COLUMN "public"."t_source_pinned"."category" IS 'Категория перевода';
COMMENT ON COLUMN "public"."t_source_pinned"."id" IS 'PK';
COMMENT ON COLUMN "public"."t_source_pinned"."message" IS 'Исходный текст';
COMMENT ON TABLE "public"."t_source_pinned" IS 'Основной словарь переводчика';

-- ----------------------------
-- Table structure for t_source_sentences
-- ----------------------------
DROP TABLE IF EXISTS "public"."t_source_sentences";
CREATE TABLE "public"."t_source_sentences" (
  "message_md5" char(32) COLLATE "pg_catalog"."default" NOT NULL,
  "language" char(2) COLLATE "pg_catalog"."default" NOT NULL,
  "category" char(16) COLLATE "pg_catalog"."default" NOT NULL,
  "id" int8 NOT NULL GENERATED BY DEFAULT AS IDENTITY (
INCREMENT 1
MINVALUE  1
MAXVALUE 9223372036854775807
START 10002
),
  "message" text COLLATE "pg_catalog"."default" NOT NULL
)
;
COMMENT ON COLUMN "public"."t_source_sentences"."message_md5" IS 'Хэш оригинального текста';
COMMENT ON COLUMN "public"."t_source_sentences"."language" IS 'Исходный язык';
COMMENT ON COLUMN "public"."t_source_sentences"."category" IS 'Категория перевода';
COMMENT ON COLUMN "public"."t_source_sentences"."id" IS 'PK';
COMMENT ON COLUMN "public"."t_source_sentences"."message" IS 'Исходный текст';
COMMENT ON TABLE "public"."t_source_sentences" IS 'Основной словарь переводчика';

-- ----------------------------
-- Table structure for translator_keys
-- ----------------------------
DROP TABLE IF EXISTS "public"."translator_keys";
CREATE TABLE "public"."translator_keys" (
  "id" int4 NOT NULL GENERATED BY DEFAULT AS IDENTITY (
INCREMENT 1
MINVALUE  1
MAXVALUE 2147483647
START 127
),
  "key" varchar(128) COLLATE "pg_catalog"."default" NOT NULL DEFAULT '000000000000000000000000'::character varying,
  "type" varchar(32) COLLATE "pg_catalog"."default" NOT NULL DEFAULT 'BingV2'::character varying,
  "enabled" int2 NOT NULL DEFAULT 0,
  "banned" int2 NOT NULL DEFAULT 0,
  "banned_date" timestamptz(6),
  "descr" text COLLATE "pg_catalog"."default"
)
;
COMMENT ON TABLE "public"."translator_keys" IS 'Ключи переводчика';

-- ----------------------------
-- Table structure for user_notice
-- ----------------------------
DROP TABLE IF EXISTS "public"."user_notice";
CREATE TABLE "public"."user_notice" (
  "id" int4 NOT NULL GENERATED BY DEFAULT AS IDENTITY (
INCREMENT 1
MINVALUE  1
MAXVALUE 2147483647
START 2
),
  "sum" numeric(12,2) DEFAULT 0.00,
  "uid" int4,
  "msg" varchar(1024) COLLATE "pg_catalog"."default",
  "status" int2,
  "data" text COLLATE "pg_catalog"."default"
)
;
COMMENT ON TABLE "public"."user_notice" IS 'Внутренние оповещения пользователей';

-- ----------------------------
-- Table structure for users
-- ----------------------------
DROP TABLE IF EXISTS "public"."users";
CREATE TABLE "public"."users" (
  "uid" int4 NOT NULL GENERATED BY DEFAULT AS IDENTITY (
INCREMENT 1
MINVALUE  1
MAXVALUE 2147483647
START 21725
),
  "email" varchar(64) COLLATE "pg_catalog"."default" DEFAULT NULL::character varying,
  "password" varchar(128) COLLATE "pg_catalog"."default" DEFAULT NULL::character varying,
  "status" int2 DEFAULT 0,
  "role" varchar(64) COLLATE "pg_catalog"."default" DEFAULT NULL::character varying,
  "phone" varchar(32) COLLATE "pg_catalog"."default" DEFAULT NULL::character varying,
  "default_manager" int4,
  "created" timestamptz(6) DEFAULT now(),
  "fullname" varchar(255) COLLATE "pg_catalog"."default" NOT NULL DEFAULT NULL::character varying,
  "contacts" text COLLATE "pg_catalog"."default",
  "comments" text COLLATE "pg_catalog"."default",
  "debtor_status" int4 DEFAULT 1,
  "post_address" text COLLATE "pg_catalog"."default",
  "personal_data" text COLLATE "pg_catalog"."default",
  "contracts" text COLLATE "pg_catalog"."default",
  "checked" int2 DEFAULT 0
)
;
COMMENT ON COLUMN "public"."users"."uid" IS 'ID пользователя';
COMMENT ON COLUMN "public"."users"."email" IS 'Электронная почта';
COMMENT ON COLUMN "public"."users"."password" IS 'Пароль (хэшированный)';
COMMENT ON COLUMN "public"."users"."status" IS 'Статус';
COMMENT ON COLUMN "public"."users"."role" IS 'Роль';
COMMENT ON COLUMN "public"."users"."phone" IS 'Телефон';
COMMENT ON COLUMN "public"."users"."default_manager" IS 'Персональный менеджер';
COMMENT ON COLUMN "public"."users"."created" IS 'Создан';
COMMENT ON COLUMN "public"."users"."fullname" IS 'ФИО';
COMMENT ON COLUMN "public"."users"."contacts" IS 'Контакты';
COMMENT ON COLUMN "public"."users"."comments" IS 'Комментарии';
COMMENT ON COLUMN "public"."users"."debtor_status" IS 'Статус должника';
COMMENT ON COLUMN "public"."users"."post_address" IS 'Почтовый адрес';
COMMENT ON COLUMN "public"."users"."personal_data" IS 'Персональные данные';
COMMENT ON COLUMN "public"."users"."contracts" IS 'Договоры';
COMMENT ON COLUMN "public"."users"."checked" IS 'Данные проверены';
COMMENT ON TABLE "public"."users" IS 'Пользователи системы';

-- ----------------------------
-- Table structure for warehouse
-- ----------------------------
DROP TABLE IF EXISTS "public"."warehouse";
CREATE TABLE "public"."warehouse" (
  "id" int4 NOT NULL GENERATED BY DEFAULT AS IDENTITY (
INCREMENT 1
MINVALUE  1
MAXVALUE 2147483647
START 8
),
  "warehouse_name" varchar(200) COLLATE "pg_catalog"."default" NOT NULL,
  "warehouse_description" text COLLATE "pg_catalog"."default"
)
;
COMMENT ON COLUMN "public"."warehouse"."id" IS 'ID склада';
COMMENT ON COLUMN "public"."warehouse"."warehouse_name" IS 'Название склада';
COMMENT ON COLUMN "public"."warehouse"."warehouse_description" IS 'Описание склада';
COMMENT ON TABLE "public"."warehouse" IS 'Склады';

-- ----------------------------
-- Table structure for warehouse_place
-- ----------------------------
DROP TABLE IF EXISTS "public"."warehouse_place";
CREATE TABLE "public"."warehouse_place" (
  "id" int4 NOT NULL GENERATED BY DEFAULT AS IDENTITY (
INCREMENT 1
MINVALUE  1
MAXVALUE 2147483647
START 45
),
  "wid" int4 NOT NULL,
  "warehouse_place_name" varchar(200) COLLATE "pg_catalog"."default",
  "warehouse_place_description" text COLLATE "pg_catalog"."default"
)
;
COMMENT ON COLUMN "public"."warehouse_place"."id" IS 'ID места на складе';
COMMENT ON COLUMN "public"."warehouse_place"."wid" IS 'ID склада';
COMMENT ON COLUMN "public"."warehouse_place"."warehouse_place_name" IS 'Название места на складе';
COMMENT ON COLUMN "public"."warehouse_place"."warehouse_place_description" IS 'Описание места на складе';
COMMENT ON TABLE "public"."warehouse_place" IS 'Места на складе';

-- ----------------------------
-- Table structure for warehouse_place_item
-- ----------------------------
DROP TABLE IF EXISTS "public"."warehouse_place_item";
CREATE TABLE "public"."warehouse_place_item" (
  "id" int4 NOT NULL GENERATED BY DEFAULT AS IDENTITY (
INCREMENT 1
MINVALUE  1
MAXVALUE 2147483647
START 169
),
  "order_item_id" int4,
  "track" varchar(200) COLLATE "pg_catalog"."default",
  "tid" varchar(200) COLLATE "pg_catalog"."default",
  "warehouse_place_id" int4 NOT NULL,
  "date_in" timestamptz(6) NOT NULL,
  "date_out" timestamptz(6),
  "uid_in" int4 NOT NULL,
  "uid_out" int4,
  "comments" text COLLATE "pg_catalog"."default"
)
;
COMMENT ON COLUMN "public"."warehouse_place_item"."id" IS 'id лота на складе';
COMMENT ON COLUMN "public"."warehouse_place_item"."order_item_id" IS 'ID лота';
COMMENT ON COLUMN "public"."warehouse_place_item"."track" IS 'Трэк-код лота';
COMMENT ON COLUMN "public"."warehouse_place_item"."tid" IS 'Код сделки товара';
COMMENT ON COLUMN "public"."warehouse_place_item"."warehouse_place_id" IS 'ID или описание размещения на складе';
COMMENT ON COLUMN "public"."warehouse_place_item"."date_in" IS 'Дата прихода на склад';
COMMENT ON COLUMN "public"."warehouse_place_item"."date_out" IS 'Дата расхода со склада';
COMMENT ON COLUMN "public"."warehouse_place_item"."uid_in" IS 'ID менеджера, получившего товар на складе';
COMMENT ON COLUMN "public"."warehouse_place_item"."uid_out" IS 'ID менеджера, отправившего товар со склада';
COMMENT ON COLUMN "public"."warehouse_place_item"."comments" IS 'Комментарий';
COMMENT ON TABLE "public"."warehouse_place_item" IS 'Товары на складе';

-- ----------------------------
-- Table structure for weights
-- ----------------------------
DROP TABLE IF EXISTS "public"."weights";
CREATE TABLE "public"."weights" (
  "id" int8 NOT NULL GENERATED BY DEFAULT AS IDENTITY (
INCREMENT 1
MINVALUE  1
MAXVALUE 9223372036854775807
START 23105
),
  "cid" varchar(45) COLLATE "pg_catalog"."default",
  "num_iid" varchar(45) COLLATE "pg_catalog"."default" NOT NULL DEFAULT '0'::character varying,
  "min_weight" numeric(12,2) NOT NULL DEFAULT 0.00,
  "max_weight" numeric(12,2) NOT NULL,
  "checked" int4 NOT NULL DEFAULT 0,
  "ds_source" varchar(32) COLLATE "pg_catalog"."default"
)
;
COMMENT ON COLUMN "public"."weights"."ds_source" IS 'Тип источника данных категории';
COMMENT ON TABLE "public"."weights" IS 'Веса товаров по категориям';

-- ----------------------------
-- Procedure structure for ClearItemsLog
-- ----------------------------
DROP PROCEDURE IF EXISTS "public"."ClearItemsLog"();
CREATE OR REPLACE PROCEDURE "public"."ClearItemsLog"()
 AS $BODY$
BEGIN

delete from img_hashes
 where last_access < (CURRENT_DATE - INTERVAL '14 DAY');
-- OPTIMIZE TABLE img_hashes;

delete from log_dsg
 where log_dsg.date < (CURRENT_DATE - INTERVAL '14 DAY');
-- OPTIMIZE TABLE log_dsg;
/*
delete from log_items_requests PARTITION (p00)
 WHERE log_items_requests.date_day not in (day(now()),day(DATE_ADD(Now(), INTERVAL -24 HOUR)),day(DATE_ADD(Now(), INTERVAL -48 HOUR)));
ALTER TABLE log_items_requests REBUILD PARTITION p00;
ALTER TABLE log_items_requests ANALYZE PARTITION p00;
delete from log_items_requests PARTITION (p01)
 WHERE log_items_requests.date_day not in (day(now()),day(DATE_ADD(Now(), INTERVAL -24 HOUR)),day(DATE_ADD(Now(), INTERVAL -48 HOUR)));
ALTER TABLE log_items_requests REBUILD PARTITION p01;
ALTER TABLE log_items_requests ANALYZE PARTITION p01;
delete from log_items_requests PARTITION (p02)
 WHERE log_items_requests.date_day not in (day(now()),day(DATE_ADD(Now(), INTERVAL -24 HOUR)),day(DATE_ADD(Now(), INTERVAL -48 HOUR)));
ALTER TABLE log_items_requests REBUILD PARTITION p02;
ALTER TABLE log_items_requests ANALYZE PARTITION p02;
delete from log_items_requests PARTITION (p03)
 WHERE log_items_requests.date_day not in (day(now()),day(DATE_ADD(Now(), INTERVAL -24 HOUR)),day(DATE_ADD(Now(), INTERVAL -48 HOUR)));
ALTER TABLE log_items_requests REBUILD PARTITION p03;
ALTER TABLE log_items_requests ANALYZE PARTITION p03;
delete from log_items_requests PARTITION (p04)
 WHERE log_items_requests.date_day not in (day(now()),day(DATE_ADD(Now(), INTERVAL -24 HOUR)),day(DATE_ADD(Now(), INTERVAL -48 HOUR)));
ALTER TABLE log_items_requests REBUILD PARTITION p04;
ALTER TABLE log_items_requests ANALYZE PARTITION p04;
delete from log_items_requests PARTITION (p05)
 WHERE log_items_requests.date_day not in (day(now()),day(DATE_ADD(Now(), INTERVAL -24 HOUR)),day(DATE_ADD(Now(), INTERVAL -48 HOUR)));
ALTER TABLE log_items_requests REBUILD PARTITION p05;
ALTER TABLE log_items_requests ANALYZE PARTITION p05;
delete from log_items_requests PARTITION (p06)
 WHERE log_items_requests.date_day not in (day(now()),day(DATE_ADD(Now(), INTERVAL -24 HOUR)),day(DATE_ADD(Now(), INTERVAL -48 HOUR)));
ALTER TABLE log_items_requests REBUILD PARTITION p06;
ALTER TABLE log_items_requests ANALYZE PARTITION p06;
delete from log_items_requests PARTITION (p07)
 WHERE log_items_requests.date_day not in (day(now()),day(DATE_ADD(Now(), INTERVAL -24 HOUR)),day(DATE_ADD(Now(), INTERVAL -48 HOUR)));
ALTER TABLE log_items_requests REBUILD PARTITION p07;
ALTER TABLE log_items_requests ANALYZE PARTITION p07;
delete from log_items_requests PARTITION (p08)
 WHERE log_items_requests.date_day not in (day(now()),day(DATE_ADD(Now(), INTERVAL -24 HOUR)),day(DATE_ADD(Now(), INTERVAL -48 HOUR)));
ALTER TABLE log_items_requests REBUILD PARTITION p08;
ALTER TABLE log_items_requests ANALYZE PARTITION p08;
delete from log_items_requests PARTITION (p09)
 WHERE log_items_requests.date_day not in (day(now()),day(DATE_ADD(Now(), INTERVAL -24 HOUR)),day(DATE_ADD(Now(), INTERVAL -48 HOUR)));
ALTER TABLE log_items_requests REBUILD PARTITION p09;
ALTER TABLE log_items_requests ANALYZE PARTITION p09;
delete from log_items_requests PARTITION (p10)
 WHERE log_items_requests.date_day not in (day(now()),day(DATE_ADD(Now(), INTERVAL -24 HOUR)),day(DATE_ADD(Now(), INTERVAL -48 HOUR)));
ALTER TABLE log_items_requests REBUILD PARTITION p10;
ALTER TABLE log_items_requests ANALYZE PARTITION p10;
delete from log_items_requests PARTITION (p11)
 WHERE log_items_requests.date_day not in (day(now()),day(DATE_ADD(Now(), INTERVAL -24 HOUR)),day(DATE_ADD(Now(), INTERVAL -48 HOUR)));
ALTER TABLE log_items_requests REBUILD PARTITION p11;
ALTER TABLE log_items_requests ANALYZE PARTITION p11;
delete from log_items_requests PARTITION (p12)
 WHERE log_items_requests.date_day not in (day(now()),day(DATE_ADD(Now(), INTERVAL -24 HOUR)),day(DATE_ADD(Now(), INTERVAL -48 HOUR)));
ALTER TABLE log_items_requests REBUILD PARTITION p12;
ALTER TABLE log_items_requests ANALYZE PARTITION p12;
delete from log_items_requests PARTITION (p13)
 WHERE log_items_requests.date_day not in (day(now()),day(DATE_ADD(Now(), INTERVAL -24 HOUR)),day(DATE_ADD(Now(), INTERVAL -48 HOUR)));
ALTER TABLE log_items_requests REBUILD PARTITION p13;
ALTER TABLE log_items_requests ANALYZE PARTITION p13;
delete from log_items_requests PARTITION (p14)
 WHERE log_items_requests.date_day not in (day(now()),day(DATE_ADD(Now(), INTERVAL -24 HOUR)),day(DATE_ADD(Now(), INTERVAL -48 HOUR)));
ALTER TABLE log_items_requests REBUILD PARTITION p14;
ALTER TABLE log_items_requests ANALYZE PARTITION p14;
delete from log_items_requests PARTITION (p15)
 WHERE log_items_requests.date_day not in (day(now()),day(DATE_ADD(Now(), INTERVAL -24 HOUR)),day(DATE_ADD(Now(), INTERVAL -48 HOUR)));
ALTER TABLE log_items_requests REBUILD PARTITION p15;
ALTER TABLE log_items_requests ANALYZE PARTITION p15;
delete from log_items_requests PARTITION (p16)
 WHERE log_items_requests.date_day not in (day(now()),day(DATE_ADD(Now(), INTERVAL -24 HOUR)),day(DATE_ADD(Now(), INTERVAL -48 HOUR)));
ALTER TABLE log_items_requests REBUILD PARTITION p16;
ALTER TABLE log_items_requests ANALYZE PARTITION p16;
delete from log_items_requests PARTITION (p17)
 WHERE log_items_requests.date_day not in (day(now()),day(DATE_ADD(Now(), INTERVAL -24 HOUR)),day(DATE_ADD(Now(), INTERVAL -48 HOUR)));
ALTER TABLE log_items_requests REBUILD PARTITION p17;
ALTER TABLE log_items_requests ANALYZE PARTITION p17;
delete from log_items_requests PARTITION (p18)
 WHERE log_items_requests.date_day not in (day(now()),day(DATE_ADD(Now(), INTERVAL -24 HOUR)),day(DATE_ADD(Now(), INTERVAL -48 HOUR)));
ALTER TABLE log_items_requests REBUILD PARTITION p18;
ALTER TABLE log_items_requests ANALYZE PARTITION p18;
delete from log_items_requests PARTITION (p19)
 WHERE log_items_requests.date_day not in (day(now()),day(DATE_ADD(Now(), INTERVAL -24 HOUR)),day(DATE_ADD(Now(), INTERVAL -48 HOUR)));
ALTER TABLE log_items_requests REBUILD PARTITION p19;
ALTER TABLE log_items_requests ANALYZE PARTITION p19;
delete from log_items_requests PARTITION (p20)
 WHERE log_items_requests.date_day not in (day(now()),day(DATE_ADD(Now(), INTERVAL -24 HOUR)),day(DATE_ADD(Now(), INTERVAL -48 HOUR)));
ALTER TABLE log_items_requests REBUILD PARTITION p20;
ALTER TABLE log_items_requests ANALYZE PARTITION p20;
delete from log_items_requests PARTITION (p21)
 WHERE log_items_requests.date_day not in (day(now()),day(DATE_ADD(Now(), INTERVAL -24 HOUR)),day(DATE_ADD(Now(), INTERVAL -48 HOUR)));
ALTER TABLE log_items_requests REBUILD PARTITION p21;
ALTER TABLE log_items_requests ANALYZE PARTITION p21;
delete from log_items_requests PARTITION (p22)
 WHERE log_items_requests.date_day not in (day(now()),day(DATE_ADD(Now(), INTERVAL -24 HOUR)),day(DATE_ADD(Now(), INTERVAL -48 HOUR)));
ALTER TABLE log_items_requests REBUILD PARTITION p22;
ALTER TABLE log_items_requests ANALYZE PARTITION p22;
delete from log_items_requests PARTITION (p23)
 WHERE log_items_requests.date_day not in (day(now()),day(DATE_ADD(Now(), INTERVAL -24 HOUR)),day(DATE_ADD(Now(), INTERVAL -48 HOUR)));
ALTER TABLE log_items_requests REBUILD PARTITION p23;
ALTER TABLE log_items_requests ANALYZE PARTITION p23;
delete from log_items_requests PARTITION (p24)
 WHERE log_items_requests.date_day not in (day(now()),day(DATE_ADD(Now(), INTERVAL -24 HOUR)),day(DATE_ADD(Now(), INTERVAL -48 HOUR)));
ALTER TABLE log_items_requests REBUILD PARTITION p24;
ALTER TABLE log_items_requests ANALYZE PARTITION p24;
delete from log_items_requests PARTITION (p25)
 WHERE log_items_requests.date_day not in (day(now()),day(DATE_ADD(Now(), INTERVAL -24 HOUR)),day(DATE_ADD(Now(), INTERVAL -48 HOUR)));
ALTER TABLE log_items_requests REBUILD PARTITION p25;
ALTER TABLE log_items_requests ANALYZE PARTITION p25;
delete from log_items_requests PARTITION (p26)
 WHERE log_items_requests.date_day not in (day(now()),day(DATE_ADD(Now(), INTERVAL -24 HOUR)),day(DATE_ADD(Now(), INTERVAL -48 HOUR)));
ALTER TABLE log_items_requests REBUILD PARTITION p26;
ALTER TABLE log_items_requests ANALYZE PARTITION p26;
delete from log_items_requests PARTITION (p27)
 WHERE log_items_requests.date_day not in (day(now()),day(DATE_ADD(Now(), INTERVAL -24 HOUR)),day(DATE_ADD(Now(), INTERVAL -48 HOUR)));
ALTER TABLE log_items_requests REBUILD PARTITION p27;
ALTER TABLE log_items_requests ANALYZE PARTITION p27;
delete from log_items_requests PARTITION (p28)
 WHERE log_items_requests.date_day not in (day(now()),day(DATE_ADD(Now(), INTERVAL -24 HOUR)),day(DATE_ADD(Now(), INTERVAL -48 HOUR)));
ALTER TABLE log_items_requests REBUILD PARTITION p28;
ALTER TABLE log_items_requests ANALYZE PARTITION p28;
delete from log_items_requests PARTITION (p29)
 WHERE log_items_requests.date_day not in (day(now()),day(DATE_ADD(Now(), INTERVAL -24 HOUR)),day(DATE_ADD(Now(), INTERVAL -48 HOUR)));
ALTER TABLE log_items_requests REBUILD PARTITION p29;
ALTER TABLE log_items_requests ANALYZE PARTITION p29;
delete from log_items_requests PARTITION (p30)
 WHERE log_items_requests.date_day not in (day(now()),day(DATE_ADD(Now(), INTERVAL -24 HOUR)),day(DATE_ADD(Now(), INTERVAL -48 HOUR)));
ALTER TABLE log_items_requests REBUILD PARTITION p30;
ALTER TABLE log_items_requests ANALYZE PARTITION p30;
delete from log_items_requests PARTITION (p31)
 WHERE log_items_requests.date_day not in (day(now()),day(DATE_ADD(Now(), INTERVAL -24 HOUR)),day(DATE_ADD(Now(), INTERVAL -48 HOUR)));
ALTER TABLE log_items_requests REBUILD PARTITION p31;
ALTER TABLE log_items_requests ANALYZE PARTITION p31;
*/
END;

$BODY$
  LANGUAGE plpgsql;

-- ----------------------------
-- Function structure for armor
-- ----------------------------
DROP FUNCTION IF EXISTS "public"."armor"(bytea, _text, _text);
CREATE OR REPLACE FUNCTION "public"."armor"(bytea, _text, _text)
  RETURNS "pg_catalog"."text" AS '$libdir/pgcrypto', 'pg_armor'
  LANGUAGE c IMMUTABLE STRICT
  COST 1;

-- ----------------------------
-- Function structure for armor
-- ----------------------------
DROP FUNCTION IF EXISTS "public"."armor"(bytea);
CREATE OR REPLACE FUNCTION "public"."armor"(bytea)
  RETURNS "pg_catalog"."text" AS '$libdir/pgcrypto', 'pg_armor'
  LANGUAGE c IMMUTABLE STRICT
  COST 1;

-- ----------------------------
-- Function structure for chinese_split
-- ----------------------------
DROP FUNCTION IF EXISTS "public"."chinese_split"("message" text, "language" varchar, "delimiter" varchar, "translate" int2);
CREATE OR REPLACE FUNCTION "public"."chinese_split"("message" text, "language" varchar, "delimiter" varchar, "translate" int2)
  RETURNS "pg_catalog"."text" AS $BODY$
BEGIN
/*
DECLARE result TEXT DEFAULT '';
    DECLARE _message TEXT DEFAULT '';
    DECLARE i INT DEFAULT 0;
    DECLARE part TEXT DEFAULT NULL;
    DECLARE clearPart TEXT DEFAULT '';
    DECLARE translation TEXT DEFAULT '';

    SET _message = CONVERT(PREG_REPLACE(_utf8 '/[??«»,,?!’.\\/\\\\\(\\)\\[\\]\s()\"\'\\*\\-\\$\#\%]+/u', ' ', message)
                           USING
                           UTF8);
    SET _message = CONVERT(PREG_REPLACE(
                               '/([^\\x3000-\\x303F\\x31C0-\\x31EF\\x3200-\\x32FF\\x3300-\\x33FF\\x3300-\\x33FF\\x4E00-\\x9FFF\\xFE30-\\xFE4F]+)/u',
                               ' $1 ', _message) USING UTF8);
    SET i = 1;
    partloop: WHILE (i > 0) DO
      SET part = NULL;
      SET clearPart = '';
      SET translation = '';
      SET part = CONVERT(PREG_CAPTURE('/(@f0:^|\\s+)([^\\s]+)/u', _message, 1, i) USING UTF8);
      IF (part IS NULL)
      THEN
        SET i = 0;
        LEAVE partloop;
      ELSE
        SET i = i + 1;
        SET clearPart = trim(part);
        IF (translate > 0)
        THEN
          IF ((CHAR_LENGTH(TRIM(CONVERT(PREG_REPLACE(
                                            '/[^\\x3000-\\x303F\\x31C0-\\x31EF\\x3200-\\x32FF\\x3300-\\x33FF\\x3300-\\x33FF\\x4E00-\\x9FFF\\xFE30-\\xFE4F]+/u',
                                            '', clearPart) USING UTF8))) !=
               CHAR_LENGTH(clearPart))
              AND (CHAR_LENGTH(clearPart) > 0))
          THEN -- is Chinese
            SET translation = t('top10000', clearPart, 'zh', language, 0);
            IF (CHAR_LENGTH(translation) > 0)
            THEN
              SET clearPart = translation;
            ELSE
              SET translation = t('default', clearPart, 'zh', language, 0);
              IF (CHAR_LENGTH(translation) > 0)
              THEN
                SET clearPart = translation;
              ELSE
                IF (translate = 2)
                THEN
                  RETURN message;
                END IF;
              END IF;
            END IF;
          END IF;
        END IF;
        IF (CHAR_LENGTH(clearPart) > 0)
        THEN
          SET result = trim(delimiter FROM concat(result, delimiter, clearPart));
        END IF;
      END IF;
    END WHILE;

    RETURN trim(result);
*/
    RETURN "message";
  END;
$BODY$
  LANGUAGE plpgsql VOLATILE
  COST 100;

-- ----------------------------
-- Function structure for crypt
-- ----------------------------
DROP FUNCTION IF EXISTS "public"."crypt"(text, text);
CREATE OR REPLACE FUNCTION "public"."crypt"(text, text)
  RETURNS "pg_catalog"."text" AS '$libdir/pgcrypto', 'pg_crypt'
  LANGUAGE c IMMUTABLE STRICT
  COST 1;

-- ----------------------------
-- Function structure for dearmor
-- ----------------------------
DROP FUNCTION IF EXISTS "public"."dearmor"(text);
CREATE OR REPLACE FUNCTION "public"."dearmor"(text)
  RETURNS "pg_catalog"."bytea" AS '$libdir/pgcrypto', 'pg_dearmor'
  LANGUAGE c IMMUTABLE STRICT
  COST 1;

-- ----------------------------
-- Function structure for decrypt
-- ----------------------------
DROP FUNCTION IF EXISTS "public"."decrypt"(bytea, bytea, text);
CREATE OR REPLACE FUNCTION "public"."decrypt"(bytea, bytea, text)
  RETURNS "pg_catalog"."bytea" AS '$libdir/pgcrypto', 'pg_decrypt'
  LANGUAGE c IMMUTABLE STRICT
  COST 1;

-- ----------------------------
-- Function structure for decrypt_iv
-- ----------------------------
DROP FUNCTION IF EXISTS "public"."decrypt_iv"(bytea, bytea, bytea, text);
CREATE OR REPLACE FUNCTION "public"."decrypt_iv"(bytea, bytea, bytea, text)
  RETURNS "pg_catalog"."bytea" AS '$libdir/pgcrypto', 'pg_decrypt_iv'
  LANGUAGE c IMMUTABLE STRICT
  COST 1;

-- ----------------------------
-- Function structure for difference
-- ----------------------------
DROP FUNCTION IF EXISTS "public"."difference"(text, text);
CREATE OR REPLACE FUNCTION "public"."difference"(text, text)
  RETURNS "pg_catalog"."int4" AS '$libdir/fuzzystrmatch', 'difference'
  LANGUAGE c IMMUTABLE STRICT
  COST 1;

-- ----------------------------
-- Function structure for digest
-- ----------------------------
DROP FUNCTION IF EXISTS "public"."digest"(text, text);
CREATE OR REPLACE FUNCTION "public"."digest"(text, text)
  RETURNS "pg_catalog"."bytea" AS '$libdir/pgcrypto', 'pg_digest'
  LANGUAGE c IMMUTABLE STRICT
  COST 1;

-- ----------------------------
-- Function structure for digest
-- ----------------------------
DROP FUNCTION IF EXISTS "public"."digest"(bytea, text);
CREATE OR REPLACE FUNCTION "public"."digest"(bytea, text)
  RETURNS "pg_catalog"."bytea" AS '$libdir/pgcrypto', 'pg_digest'
  LANGUAGE c IMMUTABLE STRICT
  COST 1;

-- ----------------------------
-- Function structure for dmetaphone
-- ----------------------------
DROP FUNCTION IF EXISTS "public"."dmetaphone"(text);
CREATE OR REPLACE FUNCTION "public"."dmetaphone"(text)
  RETURNS "pg_catalog"."text" AS '$libdir/fuzzystrmatch', 'dmetaphone'
  LANGUAGE c IMMUTABLE STRICT
  COST 1;

-- ----------------------------
-- Function structure for dmetaphone_alt
-- ----------------------------
DROP FUNCTION IF EXISTS "public"."dmetaphone_alt"(text);
CREATE OR REPLACE FUNCTION "public"."dmetaphone_alt"(text)
  RETURNS "pg_catalog"."text" AS '$libdir/fuzzystrmatch', 'dmetaphone_alt'
  LANGUAGE c IMMUTABLE STRICT
  COST 1;

-- ----------------------------
-- Function structure for dv_html2plain
-- ----------------------------
DROP FUNCTION IF EXISTS "public"."dv_html2plain"("context" text);
CREATE OR REPLACE FUNCTION "public"."dv_html2plain"("context" text)
  RETURNS "pg_catalog"."text" AS $BODY$
BEGIN
/*
DECLARE sstart BIGINT UNSIGNED;
DECLARE ends BIGINT UNSIGNED;
IF content IS NOT NULL THEN
SET sstart = LOCATE('<', content, 1);
REPEAT
SET ends = LOCATE('>', content, sstart);
if (sstart>0 and ends>0) then
SET content = CONCAT(SUBSTRING( content, 1 ,sstart -1) ,SUBSTRING(content, ends +1 )) ;
end if;
SET sstart = LOCATE('<', content, 1);
UNTIL sstart < 1 END REPEAT;
END IF;
return content;
*/
    RETURN "content";
  END;
$BODY$
  LANGUAGE plpgsql VOLATILE
  COST 100;

-- ----------------------------
-- Function structure for dv_stem
-- ----------------------------
DROP FUNCTION IF EXISTS "public"."dv_stem"("content" text, "delimiter_chars" varchar);
CREATE OR REPLACE FUNCTION "public"."dv_stem"("content" text, "delimiter_chars" varchar)
  RETURNS "pg_catalog"."text" AS $BODY$
BEGIN
/*
    DECLARE base_delimiter VARCHAR(1) DEFAULT ' ';
    DECLARE cur_delimiter VARCHAR(1) DEFAULT ' ';
    DECLARE def_delimiter_chars VARCHAR(32) DEFAULT ' ''[](){}:,-!.?";\/';    
    DECLARE source LONGTEXT DEFAULT '';
    DECLARE result LONGTEXT DEFAULT '';
    DECLARE i BIGINT DEFAULT 0;

    IF (NOT isnull(delimiter_chars)) then
     set def_delimiter_chars=delimiter_chars;
    end if;
 SET i=1;
 SET source = content;
    WHILE (i<=CHAR_LENGTH(def_delimiter_chars)) DO
     SET cur_delimiter=SUBSTR(def_delimiter_chars,i,1);
     IF (cur_delimiter!=base_delimiter) THEN
     SET source = REPLACE(source,cur_delimiter,base_delimiter);
     END IF;
     SET i=i+1;
    END WHILE;
    set result=source;
      RETURN result;
*/
    RETURN "content";
  END;
$BODY$
  LANGUAGE plpgsql VOLATILE
  COST 100;

-- ----------------------------
-- Function structure for encrypt
-- ----------------------------
DROP FUNCTION IF EXISTS "public"."encrypt"(bytea, bytea, text);
CREATE OR REPLACE FUNCTION "public"."encrypt"(bytea, bytea, text)
  RETURNS "pg_catalog"."bytea" AS '$libdir/pgcrypto', 'pg_encrypt'
  LANGUAGE c IMMUTABLE STRICT
  COST 1;

-- ----------------------------
-- Function structure for encrypt_iv
-- ----------------------------
DROP FUNCTION IF EXISTS "public"."encrypt_iv"(bytea, bytea, bytea, text);
CREATE OR REPLACE FUNCTION "public"."encrypt_iv"(bytea, bytea, bytea, text)
  RETURNS "pg_catalog"."bytea" AS '$libdir/pgcrypto', 'pg_encrypt_iv'
  LANGUAGE c IMMUTABLE STRICT
  COST 1;

-- ----------------------------
-- Function structure for gen_random_bytes
-- ----------------------------
DROP FUNCTION IF EXISTS "public"."gen_random_bytes"(int4);
CREATE OR REPLACE FUNCTION "public"."gen_random_bytes"(int4)
  RETURNS "pg_catalog"."bytea" AS '$libdir/pgcrypto', 'pg_random_bytes'
  LANGUAGE c VOLATILE STRICT
  COST 1;

-- ----------------------------
-- Function structure for gen_random_uuid
-- ----------------------------
DROP FUNCTION IF EXISTS "public"."gen_random_uuid"();
CREATE OR REPLACE FUNCTION "public"."gen_random_uuid"()
  RETURNS "pg_catalog"."uuid" AS '$libdir/pgcrypto', 'pg_random_uuid'
  LANGUAGE c VOLATILE
  COST 1;

-- ----------------------------
-- Function structure for gen_salt
-- ----------------------------
DROP FUNCTION IF EXISTS "public"."gen_salt"(text);
CREATE OR REPLACE FUNCTION "public"."gen_salt"(text)
  RETURNS "pg_catalog"."text" AS '$libdir/pgcrypto', 'pg_gen_salt'
  LANGUAGE c VOLATILE STRICT
  COST 1;

-- ----------------------------
-- Function structure for gen_salt
-- ----------------------------
DROP FUNCTION IF EXISTS "public"."gen_salt"(text, int4);
CREATE OR REPLACE FUNCTION "public"."gen_salt"(text, int4)
  RETURNS "pg_catalog"."text" AS '$libdir/pgcrypto', 'pg_gen_salt_rounds'
  LANGUAGE c VOLATILE STRICT
  COST 1;

-- ----------------------------
-- Function structure for hmac
-- ----------------------------
DROP FUNCTION IF EXISTS "public"."hmac"(bytea, bytea, text);
CREATE OR REPLACE FUNCTION "public"."hmac"(bytea, bytea, text)
  RETURNS "pg_catalog"."bytea" AS '$libdir/pgcrypto', 'pg_hmac'
  LANGUAGE c IMMUTABLE STRICT
  COST 1;

-- ----------------------------
-- Function structure for hmac
-- ----------------------------
DROP FUNCTION IF EXISTS "public"."hmac"(text, text, text);
CREATE OR REPLACE FUNCTION "public"."hmac"(text, text, text)
  RETURNS "pg_catalog"."bytea" AS '$libdir/pgcrypto', 'pg_hmac'
  LANGUAGE c IMMUTABLE STRICT
  COST 1;

-- ----------------------------
-- Function structure for levenshtein
-- ----------------------------
DROP FUNCTION IF EXISTS "public"."levenshtein"(text, text);
CREATE OR REPLACE FUNCTION "public"."levenshtein"(text, text)
  RETURNS "pg_catalog"."int4" AS '$libdir/fuzzystrmatch', 'levenshtein'
  LANGUAGE c IMMUTABLE STRICT
  COST 1;

-- ----------------------------
-- Function structure for levenshtein
-- ----------------------------
DROP FUNCTION IF EXISTS "public"."levenshtein"(text, text, int4, int4, int4);
CREATE OR REPLACE FUNCTION "public"."levenshtein"(text, text, int4, int4, int4)
  RETURNS "pg_catalog"."int4" AS '$libdir/fuzzystrmatch', 'levenshtein_with_costs'
  LANGUAGE c IMMUTABLE STRICT
  COST 1;

-- ----------------------------
-- Function structure for levenshtein_less_equal
-- ----------------------------
DROP FUNCTION IF EXISTS "public"."levenshtein_less_equal"(text, text, int4, int4, int4, int4);
CREATE OR REPLACE FUNCTION "public"."levenshtein_less_equal"(text, text, int4, int4, int4, int4)
  RETURNS "pg_catalog"."int4" AS '$libdir/fuzzystrmatch', 'levenshtein_less_equal_with_costs'
  LANGUAGE c IMMUTABLE STRICT
  COST 1;

-- ----------------------------
-- Function structure for levenshtein_less_equal
-- ----------------------------
DROP FUNCTION IF EXISTS "public"."levenshtein_less_equal"(text, text, int4);
CREATE OR REPLACE FUNCTION "public"."levenshtein_less_equal"(text, text, int4)
  RETURNS "pg_catalog"."int4" AS '$libdir/fuzzystrmatch', 'levenshtein_less_equal'
  LANGUAGE c IMMUTABLE STRICT
  COST 1;

-- ----------------------------
-- Function structure for metaphone
-- ----------------------------
DROP FUNCTION IF EXISTS "public"."metaphone"(text, int4);
CREATE OR REPLACE FUNCTION "public"."metaphone"(text, int4)
  RETURNS "pg_catalog"."text" AS '$libdir/fuzzystrmatch', 'metaphone'
  LANGUAGE c IMMUTABLE STRICT
  COST 1;

-- ----------------------------
-- Function structure for pgp_armor_headers
-- ----------------------------
DROP FUNCTION IF EXISTS "public"."pgp_armor_headers"(text, OUT "key" text, OUT "value" text);
CREATE OR REPLACE FUNCTION "public"."pgp_armor_headers"(IN text, OUT "key" text, OUT "value" text)
  RETURNS SETOF "pg_catalog"."record" AS '$libdir/pgcrypto', 'pgp_armor_headers'
  LANGUAGE c IMMUTABLE STRICT
  COST 1
  ROWS 1000;

-- ----------------------------
-- Function structure for pgp_key_id
-- ----------------------------
DROP FUNCTION IF EXISTS "public"."pgp_key_id"(bytea);
CREATE OR REPLACE FUNCTION "public"."pgp_key_id"(bytea)
  RETURNS "pg_catalog"."text" AS '$libdir/pgcrypto', 'pgp_key_id_w'
  LANGUAGE c IMMUTABLE STRICT
  COST 1;

-- ----------------------------
-- Function structure for pgp_pub_decrypt
-- ----------------------------
DROP FUNCTION IF EXISTS "public"."pgp_pub_decrypt"(bytea, bytea, text, text);
CREATE OR REPLACE FUNCTION "public"."pgp_pub_decrypt"(bytea, bytea, text, text)
  RETURNS "pg_catalog"."text" AS '$libdir/pgcrypto', 'pgp_pub_decrypt_text'
  LANGUAGE c IMMUTABLE STRICT
  COST 1;

-- ----------------------------
-- Function structure for pgp_pub_decrypt
-- ----------------------------
DROP FUNCTION IF EXISTS "public"."pgp_pub_decrypt"(bytea, bytea, text);
CREATE OR REPLACE FUNCTION "public"."pgp_pub_decrypt"(bytea, bytea, text)
  RETURNS "pg_catalog"."text" AS '$libdir/pgcrypto', 'pgp_pub_decrypt_text'
  LANGUAGE c IMMUTABLE STRICT
  COST 1;

-- ----------------------------
-- Function structure for pgp_pub_decrypt
-- ----------------------------
DROP FUNCTION IF EXISTS "public"."pgp_pub_decrypt"(bytea, bytea);
CREATE OR REPLACE FUNCTION "public"."pgp_pub_decrypt"(bytea, bytea)
  RETURNS "pg_catalog"."text" AS '$libdir/pgcrypto', 'pgp_pub_decrypt_text'
  LANGUAGE c IMMUTABLE STRICT
  COST 1;

-- ----------------------------
-- Function structure for pgp_pub_decrypt_bytea
-- ----------------------------
DROP FUNCTION IF EXISTS "public"."pgp_pub_decrypt_bytea"(bytea, bytea, text);
CREATE OR REPLACE FUNCTION "public"."pgp_pub_decrypt_bytea"(bytea, bytea, text)
  RETURNS "pg_catalog"."bytea" AS '$libdir/pgcrypto', 'pgp_pub_decrypt_bytea'
  LANGUAGE c IMMUTABLE STRICT
  COST 1;

-- ----------------------------
-- Function structure for pgp_pub_decrypt_bytea
-- ----------------------------
DROP FUNCTION IF EXISTS "public"."pgp_pub_decrypt_bytea"(bytea, bytea);
CREATE OR REPLACE FUNCTION "public"."pgp_pub_decrypt_bytea"(bytea, bytea)
  RETURNS "pg_catalog"."bytea" AS '$libdir/pgcrypto', 'pgp_pub_decrypt_bytea'
  LANGUAGE c IMMUTABLE STRICT
  COST 1;

-- ----------------------------
-- Function structure for pgp_pub_decrypt_bytea
-- ----------------------------
DROP FUNCTION IF EXISTS "public"."pgp_pub_decrypt_bytea"(bytea, bytea, text, text);
CREATE OR REPLACE FUNCTION "public"."pgp_pub_decrypt_bytea"(bytea, bytea, text, text)
  RETURNS "pg_catalog"."bytea" AS '$libdir/pgcrypto', 'pgp_pub_decrypt_bytea'
  LANGUAGE c IMMUTABLE STRICT
  COST 1;

-- ----------------------------
-- Function structure for pgp_pub_encrypt
-- ----------------------------
DROP FUNCTION IF EXISTS "public"."pgp_pub_encrypt"(text, bytea);
CREATE OR REPLACE FUNCTION "public"."pgp_pub_encrypt"(text, bytea)
  RETURNS "pg_catalog"."bytea" AS '$libdir/pgcrypto', 'pgp_pub_encrypt_text'
  LANGUAGE c VOLATILE STRICT
  COST 1;

-- ----------------------------
-- Function structure for pgp_pub_encrypt
-- ----------------------------
DROP FUNCTION IF EXISTS "public"."pgp_pub_encrypt"(text, bytea, text);
CREATE OR REPLACE FUNCTION "public"."pgp_pub_encrypt"(text, bytea, text)
  RETURNS "pg_catalog"."bytea" AS '$libdir/pgcrypto', 'pgp_pub_encrypt_text'
  LANGUAGE c VOLATILE STRICT
  COST 1;

-- ----------------------------
-- Function structure for pgp_pub_encrypt_bytea
-- ----------------------------
DROP FUNCTION IF EXISTS "public"."pgp_pub_encrypt_bytea"(bytea, bytea);
CREATE OR REPLACE FUNCTION "public"."pgp_pub_encrypt_bytea"(bytea, bytea)
  RETURNS "pg_catalog"."bytea" AS '$libdir/pgcrypto', 'pgp_pub_encrypt_bytea'
  LANGUAGE c VOLATILE STRICT
  COST 1;

-- ----------------------------
-- Function structure for pgp_pub_encrypt_bytea
-- ----------------------------
DROP FUNCTION IF EXISTS "public"."pgp_pub_encrypt_bytea"(bytea, bytea, text);
CREATE OR REPLACE FUNCTION "public"."pgp_pub_encrypt_bytea"(bytea, bytea, text)
  RETURNS "pg_catalog"."bytea" AS '$libdir/pgcrypto', 'pgp_pub_encrypt_bytea'
  LANGUAGE c VOLATILE STRICT
  COST 1;

-- ----------------------------
-- Function structure for pgp_sym_decrypt
-- ----------------------------
DROP FUNCTION IF EXISTS "public"."pgp_sym_decrypt"(bytea, text);
CREATE OR REPLACE FUNCTION "public"."pgp_sym_decrypt"(bytea, text)
  RETURNS "pg_catalog"."text" AS '$libdir/pgcrypto', 'pgp_sym_decrypt_text'
  LANGUAGE c IMMUTABLE STRICT
  COST 1;

-- ----------------------------
-- Function structure for pgp_sym_decrypt
-- ----------------------------
DROP FUNCTION IF EXISTS "public"."pgp_sym_decrypt"(bytea, text, text);
CREATE OR REPLACE FUNCTION "public"."pgp_sym_decrypt"(bytea, text, text)
  RETURNS "pg_catalog"."text" AS '$libdir/pgcrypto', 'pgp_sym_decrypt_text'
  LANGUAGE c IMMUTABLE STRICT
  COST 1;

-- ----------------------------
-- Function structure for pgp_sym_decrypt_bytea
-- ----------------------------
DROP FUNCTION IF EXISTS "public"."pgp_sym_decrypt_bytea"(bytea, text, text);
CREATE OR REPLACE FUNCTION "public"."pgp_sym_decrypt_bytea"(bytea, text, text)
  RETURNS "pg_catalog"."bytea" AS '$libdir/pgcrypto', 'pgp_sym_decrypt_bytea'
  LANGUAGE c IMMUTABLE STRICT
  COST 1;

-- ----------------------------
-- Function structure for pgp_sym_decrypt_bytea
-- ----------------------------
DROP FUNCTION IF EXISTS "public"."pgp_sym_decrypt_bytea"(bytea, text);
CREATE OR REPLACE FUNCTION "public"."pgp_sym_decrypt_bytea"(bytea, text)
  RETURNS "pg_catalog"."bytea" AS '$libdir/pgcrypto', 'pgp_sym_decrypt_bytea'
  LANGUAGE c IMMUTABLE STRICT
  COST 1;

-- ----------------------------
-- Function structure for pgp_sym_encrypt
-- ----------------------------
DROP FUNCTION IF EXISTS "public"."pgp_sym_encrypt"(text, text);
CREATE OR REPLACE FUNCTION "public"."pgp_sym_encrypt"(text, text)
  RETURNS "pg_catalog"."bytea" AS '$libdir/pgcrypto', 'pgp_sym_encrypt_text'
  LANGUAGE c VOLATILE STRICT
  COST 1;

-- ----------------------------
-- Function structure for pgp_sym_encrypt
-- ----------------------------
DROP FUNCTION IF EXISTS "public"."pgp_sym_encrypt"(text, text, text);
CREATE OR REPLACE FUNCTION "public"."pgp_sym_encrypt"(text, text, text)
  RETURNS "pg_catalog"."bytea" AS '$libdir/pgcrypto', 'pgp_sym_encrypt_text'
  LANGUAGE c VOLATILE STRICT
  COST 1;

-- ----------------------------
-- Function structure for pgp_sym_encrypt_bytea
-- ----------------------------
DROP FUNCTION IF EXISTS "public"."pgp_sym_encrypt_bytea"(bytea, text);
CREATE OR REPLACE FUNCTION "public"."pgp_sym_encrypt_bytea"(bytea, text)
  RETURNS "pg_catalog"."bytea" AS '$libdir/pgcrypto', 'pgp_sym_encrypt_bytea'
  LANGUAGE c VOLATILE STRICT
  COST 1;

-- ----------------------------
-- Function structure for pgp_sym_encrypt_bytea
-- ----------------------------
DROP FUNCTION IF EXISTS "public"."pgp_sym_encrypt_bytea"(bytea, text, text);
CREATE OR REPLACE FUNCTION "public"."pgp_sym_encrypt_bytea"(bytea, text, text)
  RETURNS "pg_catalog"."bytea" AS '$libdir/pgcrypto', 'pgp_sym_encrypt_bytea'
  LANGUAGE c VOLATILE STRICT
  COST 1;

-- ----------------------------
-- Function structure for soundex
-- ----------------------------
DROP FUNCTION IF EXISTS "public"."soundex"(text);
CREATE OR REPLACE FUNCTION "public"."soundex"(text)
  RETURNS "pg_catalog"."text" AS '$libdir/fuzzystrmatch', 'soundex'
  LANGUAGE c IMMUTABLE STRICT
  COST 1;

-- ----------------------------
-- Function structure for t
-- ----------------------------
DROP FUNCTION IF EXISTS "public"."t"("in_category" varchar, "in_message" text, "in_source" varchar, "in_language" varchar, "with_id" int4);
CREATE OR REPLACE FUNCTION "public"."t"("in_category" varchar, "in_message" text, "in_source" varchar, "in_language" varchar, "with_id" int4)
  RETURNS "pg_catalog"."text" AS $BODY$
BEGIN
/*
    DECLARE source_dictionary_id BIGINT DEFAULT 0;
    DECLARE out_translation TEXT DEFAULT '';
    DECLARE out_translation_category VARCHAR(32) DEFAULT '*';
    DECLARE use_long VARCHAR(1) DEFAULT 'S';
    IF (in_category = 'category')
    THEN
      SELECT
        sd.id,
        sd.category
      INTO source_dictionary_id, out_translation_category
      FROM t_source_category sd
      WHERE
        (sd.category = in_category OR in_category = '*') AND
        sd.language = in_source AND
        message_md5 = md5(in_message)
      LIMIT 1;

      IF (source_dictionary_id > 0)
      THEN
        SELECT dd.translation
        INTO out_translation
        FROM t_category dd
        WHERE
          dd.id = source_dictionary_id AND dd.language = in_language
        LIMIT 1;
        IF (LENGTH(out_translation) > 0)
        THEN
          UPDATE t_category dd
          SET freq = freq + 1
          WHERE
            dd.id = source_dictionary_id AND dd.language = in_language
          LIMIT 1;
        END IF;
      END IF;
    ELSEIF (in_category = 'top10000')
      THEN
        SELECT
          sd.id,
          sd.category
        INTO source_dictionary_id, out_translation_category
        FROM t_source_sentences sd
        WHERE
          (sd.category = in_category OR in_category = '*') AND
          sd.language = in_source AND
          message_md5 = md5(in_message)
        LIMIT 1;

        IF (source_dictionary_id > 0)
        THEN
          SELECT dd.translation
          INTO out_translation
          FROM t_sentences dd
          WHERE
            dd.id = source_dictionary_id AND dd.language = in_language
          LIMIT 1;
        END IF;  
    ELSE -- ????? ???????
      IF (CHAR_LENGTH(in_message) <= 32 AND (in_category <> 'item_title'))
      THEN
        SELECT
          sd.id,
          sd.category
        INTO source_dictionary_id, out_translation_category
        FROM t_source_dictionary sd
        WHERE
          (sd.category = in_category OR in_category = '*') AND
          sd.language = in_source AND
          message_md5 = md5(in_message)
        LIMIT 1;
        IF (source_dictionary_id > 0)
        THEN
          SELECT dd.translation
          INTO out_translation
          FROM t_dictionary dd
          WHERE
            dd.id = source_dictionary_id AND dd.language = in_language
          LIMIT 1;
          IF (LENGTH(out_translation) > 0)
          THEN
            UPDATE t_dictionary dd
            SET freq = freq + 1
            WHERE
              dd.id = source_dictionary_id AND dd.language = in_language
            LIMIT 1;
          END IF;
        END IF;
      ELSE
        SET use_long = 'L';
        SELECT
          sd.id,
          sd.category
        INTO source_dictionary_id, out_translation_category
        FROM t_source_dictionary_long sd
        WHERE
          (sd.category = in_category OR in_category = '*') AND
          sd.language = in_source AND
          message_md5 = md5(in_message)
        LIMIT 1;
        IF (source_dictionary_id > 0)
        THEN
          SELECT dd.translation
          INTO out_translation
          FROM t_dictionary_long dd
          WHERE
            dd.id = source_dictionary_id AND dd.language = in_language
          LIMIT 1;
          IF (LENGTH(out_translation) > 0)
          THEN
            UPDATE t_dictionary_long dd
            SET freq = freq + 1
            WHERE
              dd.id = source_dictionary_id AND dd.language = in_language
            LIMIT 1;
          END IF;
        END IF;
      END IF;
    END IF;
    IF (with_id > 0)
    THEN
      RETURN concat('[', out_translation_category, ']', '[', source_dictionary_id, ']','[',use_long,']', out_translation);
    ELSE
      RETURN out_translation;
    END IF;
*/
    RETURN in_message;
  END;
$BODY$
  LANGUAGE plpgsql VOLATILE
  COST 100;

-- ----------------------------
-- Function structure for text_soundex
-- ----------------------------
DROP FUNCTION IF EXISTS "public"."text_soundex"(text);
CREATE OR REPLACE FUNCTION "public"."text_soundex"(text)
  RETURNS "pg_catalog"."text" AS '$libdir/fuzzystrmatch', 'soundex'
  LANGUAGE c IMMUTABLE STRICT
  COST 1;

-- ----------------------------
-- Function structure for trg_cat_ext_before_update_fn
-- ----------------------------
DROP FUNCTION IF EXISTS "public"."trg_cat_ext_before_update_fn"();
CREATE OR REPLACE FUNCTION "public"."trg_cat_ext_before_update_fn"()
  RETURNS "pg_catalog"."trigger" AS $BODY$ BEGIN
	IF
		( TG_OP = 'UPDATE' ) THEN
		IF
			( NEW.url != OLD.url ) THEN
				UPDATE cms_metatags mt 
				SET mt."key" = NEW.url 
			WHERE
				mt."key" = OLD.url;
			
		END IF;
		
	END IF;
	RETURN NEW;
	
END;
$BODY$
  LANGUAGE plpgsql VOLATILE
  COST 100;

-- ----------------------------
-- Function structure for trg_cms_knowledge_base_fn
-- ----------------------------
DROP FUNCTION IF EXISTS "public"."trg_cms_knowledge_base_fn"();
CREATE OR REPLACE FUNCTION "public"."trg_cms_knowledge_base_fn"()
  RETURNS "pg_catalog"."trigger" AS $BODY$ BEGIN
	IF
		( TG_OP = 'INSERT' ) THEN
			NEW."search" := dv_stem ( NEW."value", NULL );
		ELSIF ( TG_OP = 'UPDATE' ) THEN
			NEW."search" := dv_stem ( NEW."value", NULL );
			
		END IF;
		RETURN NEW;
		
	END;
	$BODY$
  LANGUAGE plpgsql VOLATILE
  COST 100;

-- ----------------------------
-- Function structure for trg_custom_content_history_fn
-- ----------------------------
DROP FUNCTION IF EXISTS "public"."trg_custom_content_history_fn"();
CREATE OR REPLACE FUNCTION "public"."trg_custom_content_history_fn"()
  RETURNS "pg_catalog"."trigger" AS $BODY$ DECLARE
md5Old VARCHAR ( 32 );
md5New VARCHAR ( 32 );
BEGIN
	IF
		( TG_OP = 'UPDATE' ) THEN
			md5Old := md5( OLD.content_data );
		md5New := md5( NEW.content_data );
		IF
			( md5Old <> md5New ) THEN
				INSERT INTO cms_content_history ( "table_name", content_id, lang, "date", "content" )
			VALUES
				( 'cms_custom_content', OLD.content_id, OLD.lang, Now( ), OLD.content_data );
			
		END IF;
		
	END IF;
	RETURN NEW;
	
END;
$BODY$
  LANGUAGE plpgsql VOLATILE
  COST 100;

-- ----------------------------
-- Function structure for trg_menus_history_fn
-- ----------------------------
DROP FUNCTION IF EXISTS "public"."trg_menus_history_fn"();
CREATE OR REPLACE FUNCTION "public"."trg_menus_history_fn"()
  RETURNS "pg_catalog"."trigger" AS $BODY$ DECLARE
	md5Old VARCHAR ( 32 );
	md5New VARCHAR ( 32 );
	BEGIN
		IF
			( TG_OP = 'UPDATE' ) THEN
				md5Old := md5( OLD.menu_data );
			md5New := md5( NEW.menu_data );
			IF
				( md5Old <> md5New ) THEN
					INSERT INTO cms_content_history ( "table_name", content_id, lang, "date", "content" )
				VALUES
					( 'cms_menus', OLD.menu_id, '*', Now( ), OLD.menu_data );
				
			END IF;
			
		END IF;
		RETURN NEW;
		
	END;
	$BODY$
  LANGUAGE plpgsql VOLATILE
  COST 100;

-- ----------------------------
-- Function structure for trg_page_content_history_fn
-- ----------------------------
DROP FUNCTION IF EXISTS "public"."trg_page_content_history_fn"();
CREATE OR REPLACE FUNCTION "public"."trg_page_content_history_fn"()
  RETURNS "pg_catalog"."trigger" AS $BODY$ DECLARE
	md5Old VARCHAR ( 32 );
	md5New VARCHAR ( 32 );
	BEGIN
		IF
			( TG_OP = 'UPDATE' ) THEN
				md5Old := md5( OLD.content_data );
			md5New := md5( NEW.content_data );
			IF
				( md5Old <> md5New ) THEN
					INSERT INTO cms_content_history ( "table_name", content_id, lang, "date", "content" )
				VALUES
					( 'cms_pages_content', OLD.page_id, OLD.lang, Now( ), OLD.content_data );
				
			END IF;
			
		END IF;
		RETURN NEW;
		
	END;
	$BODY$
  LANGUAGE plpgsql VOLATILE
  COST 100;

-- ----------------------------
-- Function structure for trg_update_currency_log_fn
-- ----------------------------
DROP FUNCTION IF EXISTS "public"."trg_update_currency_log_fn"();
CREATE OR REPLACE FUNCTION "public"."trg_update_currency_log_fn"()
  RETURNS "pg_catalog"."trigger" AS $BODY$ BEGIN
		IF
			( TG_OP = 'UPDATE' ) THEN
			IF
				( NEW."id" LIKE'rate\_%' AND OLD."value"::numeric(16,8) <> NEW."value"::numeric(16,8)) THEN
					INSERT INTO currency_log ( currency, "date", rate )
				VALUES
					( SUBSTR( NEW."id", 6)::varchar, Now(), NEW."value"::numeric(16,8));
				
			END IF;
		END IF;
		RETURN NEW;
	END;
$BODY$
  LANGUAGE plpgsql VOLATILE
  COST 100;

-- ----------------------------
-- View structure for bills_view
-- ----------------------------
DROP VIEW IF EXISTS "public"."bills_view";
CREATE VIEW "public"."bills_view" AS  SELECT t.id,
    t.tariff_object_id,
    t.status,
    t.date,
    t.manager_id,
    t.tariff_id,
    t.summ,
    t.manual_summ,
    t.frozen,
    t.code,
    ot.tariff_name,
    ot.tariff_short_name,
    uu.fullname AS user_name,
    uu.uid,
    (ol.land_group::text || '/№'::text) || ol.land_number::text AS land_name,
    ol.lands_id,
    (ta.name::text || ', '::text) || ta.bank AS acceptor_name,
    mm.fullname AS manager_name,
    bs.name AS status_name,
    ( SELECT sum(bp2.summ) AS sum
           FROM bills_payments bp2
          WHERE bp2.bid = t.id) AS paid_summ,
    row_to_json(ot.*) AS j_tariff,
    row_to_json(ta.*) AS j_acceptor,
    ( SELECT jsonb_agg(rpayments.*) AS jsonb_agg
           FROM ( SELECT bp.id,
                    bp.bid,
                    bp.uid,
                    bp.summ,
                    bp.date,
                    bp.descr
                   FROM bills_payments bp
                  WHERE bp.bid = t.id
                  ORDER BY bp.date) rpayments) AS j_payments,
    row_to_json(uu.*) AS j_user,
    row_to_json(ol.*) AS j_land
   FROM bills t
     LEFT JOIN obj_tariffs ot ON ot.tariffs_id = t.tariff_id
     LEFT JOIN users mm ON mm.uid = t.manager_id
     LEFT JOIN obj_tariffs_acceptors ta ON ta.tariff_acceptors_id = ot.acceptor_id
     LEFT JOIN bills_statuses bs ON bs.value::text = t.status::text
     LEFT JOIN obj_lands_tariffs olt ON olt.lands_id = t.tariff_object_id AND olt.tariffs_id = ot.tariffs_id AND olt.deleted IS NULL AND (ot.tariff_rules ->> 'target'::text) = 'land'::text
     LEFT JOIN obj_devices_tariffs odt ON odt.devices_id = t.tariff_object_id AND odt.tariffs_id = ot.tariffs_id AND odt.deleted IS NULL AND (ot.tariff_rules ->> 'target'::text) = 'device'::text
     LEFT JOIN obj_lands_devices oldd ON oldd.devices_id = odt.devices_id AND oldd.deleted IS NULL
     LEFT JOIN obj_lands ol ON ol.lands_id = COALESCE(olt.lands_id, oldd.lands_id)
     LEFT JOIN obj_users_lands ul ON ul.lands_id = ol.lands_id AND ul.deleted IS NULL
     LEFT JOIN users uu ON uu.uid = ul.uid;
COMMENT ON VIEW "public"."bills_view" IS 'Счета';

-- ----------------------------
-- View structure for bills_for_statuses_view
-- ----------------------------
DROP VIEW IF EXISTS "public"."bills_for_statuses_view";
CREATE VIEW "public"."bills_for_statuses_view" AS  SELECT t.id,
    t.tariff_object_id,
    t.status,
    t.date,
    t.manager_id,
    t.tariff_id,
    t.summ,
    t.manual_summ,
    t.frozen,
    t.code,
    COALESCE(t.manual_summ, t.summ) AS actual_summ,
    uu.uid,
    ol.lands_id,
    ( SELECT sum(bp2.summ) AS sum
           FROM bills_payments bp2
          WHERE bp2.bid = t.id) AS paid_summ
   FROM bills t
     LEFT JOIN obj_tariffs ot ON ot.tariffs_id = t.tariff_id
     LEFT JOIN users mm ON mm.uid = t.manager_id
     LEFT JOIN obj_tariffs_acceptors ta ON ta.tariff_acceptors_id = ot.acceptor_id
     LEFT JOIN bills_statuses bs ON bs.value::text = t.status::text
     LEFT JOIN obj_lands_tariffs olt ON olt.lands_id = t.tariff_object_id AND olt.tariffs_id = ot.tariffs_id AND olt.deleted IS NULL AND (ot.tariff_rules ->> 'target'::text) = 'land'::text
     LEFT JOIN obj_devices_tariffs odt ON odt.devices_id = t.tariff_object_id AND odt.tariffs_id = ot.tariffs_id AND odt.deleted IS NULL AND (ot.tariff_rules ->> 'target'::text) = 'device'::text
     LEFT JOIN obj_lands_devices oldd ON
        CASE
            WHEN odt.devices_id IS NOT NULL THEN oldd.devices_id = odt.devices_id AND oldd.deleted IS NULL
            WHEN (ot.tariff_rules ->> 'target'::text) = 'device'::text THEN oldd.devices_id = t.tariff_object_id
            ELSE NULL::boolean
        END
     LEFT JOIN obj_lands ol ON ol.lands_id =
        CASE
            WHEN olt.lands_id IS NOT NULL THEN olt.lands_id
            WHEN oldd.lands_id IS NOT NULL THEN oldd.lands_id
            WHEN (ot.tariff_rules ->> 'target'::text) = 'land'::text THEN t.tariff_object_id
            ELSE NULL::integer
        END
     LEFT JOIN obj_users_lands ul ON ul.lands_id = ol.lands_id AND ul.deleted IS NULL
     LEFT JOIN users uu ON uu.uid = ul.uid;

-- ----------------------------
-- View structure for src_device_models
-- ----------------------------
DROP VIEW IF EXISTS "public"."src_device_models";
CREATE VIEW "public"."src_device_models" AS  SELECT src_nekta_device_models.id,
    src_nekta_device_models.name,
    src_nekta_device_models.slug,
    src_nekta_device_models.device_brand_id,
    src_nekta_device_models.device_group_id,
    src_nekta_device_models.device_type_id,
    src_nekta_device_models.protocol_id,
    src_nekta_device_models.active,
    src_nekta_device_models.control_relay,
    src_nekta_device_models.options,
    src_nekta_device_models.tabs,
    src_nekta_device_models.rules,
    src_nekta_device_models.poll_rules,
    src_nekta_device_models.server_interface,
    src_nekta_device_models.gateway_interface,
    src_nekta_device_models.impulse_weight
   FROM src_nekta_device_models
UNION ALL
 SELECT 100001 AS id,
    '*Неизвестный'::character varying AS name,
    '*Unknown'::character varying AS slug,
    NULL::integer AS device_brand_id,
    NULL::integer AS device_group_id,
    NULL::integer AS device_type_id,
    NULL::integer AS protocol_id,
    true AS active,
    false AS control_relay,
    NULL::jsonb AS options,
    NULL::jsonb AS tabs,
    NULL::jsonb AS rules,
    NULL::jsonb AS poll_rules,
    NULL::jsonb AS server_interface,
    NULL::jsonb AS gateway_interface,
    NULL::jsonb AS impulse_weight;

-- ----------------------------
-- View structure for obj_devices_data_view
-- ----------------------------
DROP VIEW IF EXISTS "public"."obj_devices_data_view";
CREATE VIEW "public"."obj_devices_data_view" AS  SELECT 'manual'::text AS source,
    tt.device_id,
    tt.data_updated,
    tt.tariff1_val - COALESCE(lag(tt.tariff1_val) OVER (PARTITION BY tt.device_id ORDER BY tt.data_updated), 0::double precision) AS delta_tariff1,
    tt.tariff2_val - COALESCE(lag(tt.tariff2_val) OVER (PARTITION BY tt.device_id ORDER BY tt.data_updated), 0::double precision) AS delta_tariff2,
    tt.tariff3_val - COALESCE(lag(tt.tariff3_val) OVER (PARTITION BY tt.device_id ORDER BY tt.data_updated), 0::double precision) AS delta_tariff3,
    tt.uid
   FROM obj_devices_manual_data tt
UNION ALL
 SELECT 'nekta'::text AS source,
    tt2.device_id,
    tt2.datetime AS data_updated,
    tt2.delta_tariff1,
    tt2.delta_tariff2,
    tt2.delta_tariff3,
    0 AS uid
   FROM src_nekta_data_type1 tt2
  ORDER BY 1, 2, 3;
COMMENT ON VIEW "public"."obj_devices_data_view" IS 'Вьюшка данных от всех приборов всех источников';

-- ----------------------------
-- View structure for obj_devices_view
-- ----------------------------
DROP VIEW IF EXISTS "public"."obj_devices_view";
CREATE VIEW "public"."obj_devices_view" AS  SELECT od.devices_id,
    od.source,
    od.name,
    od.active,
    od.device_serial_number,
    jsonb_pretty(od.properties) AS properties,
    od.model_id,
    name_model.name AS model_id_name,
    od.device_type_id,
    name_type.name AS device_type_id_name,
    od.device_group_id,
    name_group.name AS device_group_id_name,
    od.report_period_update,
    od."desc",
        CASE
            WHEN od.source::text = 'manual'::text THEN dd1.data_updated
            ELSE ss.last_active
        END AS last_active,
    now() -
        CASE
            WHEN od.source::text = 'manual'::text THEN dd1.data_updated
            ELSE ss.last_active
        END AS last_active_left,
    jsonb_pretty(ss.last_message) AS last_message,
        CASE
            WHEN od.source::text = 'manual'::text THEN dd1.tariff1_val::numeric(10,3)
            ELSE (ss.last_message -> 'tariff1'::text)::numeric(10,3)
        END AS value1,
        CASE
            WHEN od.source::text = 'manual'::text THEN dd1.tariff2_val::numeric(10,3)
            ELSE (ss.last_message -> 'tariff2'::text)::numeric(10,3)
        END AS value2,
        CASE
            WHEN od.source::text = 'manual'::text THEN dd1.tariff3_val::numeric(10,3)
            ELSE (ss.last_message -> 'tariff3'::text)::numeric(10,3)
        END AS value3,
    oddv2.d90tariff1::numeric(10,3) AS d90value1,
    oddv2.d90tariff2::numeric(10,3) AS d90value2,
    oddv2.d90tariff3::numeric(10,3) AS d90value3,
    sp.startpoint_value1::numeric(10,3) AS starting_value1,
    sp.startpoint_value2::numeric(10,3) AS starting_value2,
    sp.startpoint_value3::numeric(10,3) AS starting_value3,
    sp.balance AS starting_balance,
    sp.created AS starting_date,
    jsonb_pretty(ss.status) AS status,
    od.created_at,
    now() - od.created_at AS created_at_left,
    od.updated_at,
    now() - od.updated_at AS updated_at_left,
    od.deleted_at,
    now() - od.deleted_at AS deleted_at_left,
    ss.address,
        CASE
            WHEN od.source::text = 'manual'::text THEN dd1.data_updated
            ELSE ss.data_updated
        END AS data_updated,
    now() -
        CASE
            WHEN od.source::text = 'manual'::text THEN dd1.data_updated
            ELSE ss.data_updated
        END AS data_updated_left,
    od.device_usage_id,
    dc_usage.val_name AS device_usage_name,
    od.device_status_id,
    dc_status.val_name AS device_status_name,
    ( SELECT jsonb_agg(rtariffs.*) AS jsonb_agg
           FROM ( SELECT ul.devices_tariffs_id,
                    ul.devices_id,
                    ll.tariffs_id,
                    ll.tariff_name,
                    ll.tariff_description,
                    ll.tariff_rules,
                    ll.created,
                    ll.comments,
                    ll.enabled,
                    ll.acceptor_id,
                    ll.tariff_short_name
                   FROM obj_devices_tariffs ul
                     LEFT JOIN obj_tariffs ll ON ll.tariffs_id = ul.tariffs_id
                  WHERE ul.devices_id = od.devices_id AND ul.deleted IS NULL
                  ORDER BY ul.created) rtariffs) AS tariffs,
    ( SELECT jsonb_agg(rlands.*) AS jsonb_agg
           FROM ( SELECT ul.lands_devices_id,
                    ul.devices_id,
                    ll.lands_id,
                    ll.land_number,
                    ll.land_number_cadastral,
                    ll.status,
                    ll.address,
                    ll.created,
                    ll.comments,
                    ll.land_group,
                    ll.land_area,
                    ll.land_geo_latitude,
                    ll.land_geo_longitude,
                    ll.land_type
                   FROM obj_lands_devices ul
                     LEFT JOIN obj_lands ll ON ll.lands_id = ul.lands_id
                  WHERE ul.devices_id = od.devices_id AND ul.deleted IS NULL
                  ORDER BY ul.created) rlands) AS lands,
    ( SELECT jsonb_agg(rusers.*) AS jsonb_agg
           FROM ( SELECT ld.users_lands_id,
                    ld.uid,
                    dd.uid,
                    dd.email,
                    dd.password,
                    dd.status,
                    dd.role,
                    dd.phone,
                    dd.default_manager,
                    dd.created,
                    dd.fullname,
                    dd.contacts,
                    dd.comments,
                    dd.debtor_status,
                    dd.post_address,
                    dd.personal_data,
                    dd.contracts
                   FROM obj_users_lands ld
                     LEFT JOIN users dd ON dd.uid = ld.uid
                  WHERE (ld.lands_id IN ( SELECT ul.lands_id
                           FROM obj_lands_devices ul
                          WHERE ul.devices_id = od.devices_id AND ul.deleted IS NULL)) AND ld.deleted IS NULL
                  ORDER BY ld.created) rusers(users_lands_id, uid, uid_1, email, password, status, role, phone, default_manager, created, fullname, contacts, comments, debtor_status, post_address, personal_data, contracts)) AS users
   FROM obj_devices_manual od
     LEFT JOIN LATERAL ( SELECT ll.land_group,
            ll.land_number
           FROM obj_lands_devices ul
             LEFT JOIN obj_lands ll ON ll.lands_id = ul.lands_id
          WHERE ul.devices_id = od.devices_id AND ul.deleted IS NULL
          ORDER BY ul.created
         LIMIT 1) lll ON true
     LEFT JOIN LATERAL ( SELECT sum(oddv.delta_tariff1) AS d90tariff1,
            sum(oddv.delta_tariff2) AS d90tariff2,
            sum(oddv.delta_tariff3) AS d90tariff3
           FROM obj_devices_data_view oddv
          WHERE oddv.device_id = od.devices_id AND oddv.data_updated >= (now() - '90 days'::interval)) oddv2 ON true
     LEFT JOIN src_nekta_metering_devices ss ON ss.id = od.devices_id
     LEFT JOIN ( SELECT dd.device_id,
            max(dd.tariff1_val) AS tariff1_val,
            max(dd.tariff2_val) AS tariff2_val,
            max(dd.tariff3_val) AS tariff3_val,
            max(dd.data_updated) AS data_updated
           FROM obj_devices_manual_data dd
          GROUP BY dd.device_id) dd1 ON dd1.device_id = od.devices_id
     LEFT JOIN dic_custom dc_usage ON dc_usage.val_id = od.device_usage_id
     LEFT JOIN dic_custom dc_status ON dc_status.val_id = od.device_status_id
     LEFT JOIN src_device_models name_model ON name_model.id = od.model_id
     LEFT JOIN src_nekta_device_types name_type ON name_type.id = od.device_type_id
     LEFT JOIN src_nekta_device_groups name_group ON name_group.id = od.device_group_id
     LEFT JOIN obj_devices_startpoints sp ON sp.devices_id = od.devices_id AND sp.deleted IS NULL;

-- ----------------------------
-- View structure for obj_structure_view
-- ----------------------------
DROP VIEW IF EXISTS "public"."obj_structure_view";
CREATE VIEW "public"."obj_structure_view" AS  WITH objects AS (
         SELECT 0 AS tree_id,
            NULL::integer AS tree_parent_id,
            0 AS tree_order_in_level,
            NULL::integer AS obj_id,
            NULL::text AS obj_type,
            NULL::text AS obj_group,
            'root'::text AS obj_name
        UNION ALL
         SELECT '12000000000000'::bigint AS tree_id,
            0 AS tree_parent_id,
            0 AS tree_order_in_level,
            NULL::integer AS obj_id,
            'structure'::text AS obj_type,
            NULL::text AS obj_group,
            'Все участки'::text AS obj_name
        UNION ALL
         SELECT '1000000000000'::bigint + ll.lands_id AS tree_id,
            '12000000000000'::bigint AS tree_parent_id,
            0 AS tree_order_in_level,
            ll.lands_id AS obj_id,
            'land'::text AS obj_type,
            ll.land_group AS obj_group,
            ll.land_number::text AS obj_name
           FROM obj_lands ll
        UNION ALL
         SELECT '2000000000000'::bigint + uu.uid AS tree_id,
            '1000000000000'::bigint + ul.lands_id AS tree_parent_id,
            0 AS tree_order_in_level,
            uu.uid AS obj_id,
            'user'::text AS obj_type,
            NULL::text AS obj_group,
            uu.fullname AS obj_name
           FROM users uu
             JOIN obj_users_lands ul ON ul.uid = uu.uid AND ul.deleted IS NULL
        UNION ALL
         SELECT '3000000000000'::bigint + dd.devices_id AS tree_id,
            '1000000000000'::bigint + ld.lands_id AS tree_parent_id,
            0 AS tree_order_in_level,
            dd.devices_id AS obj_id,
            'device'::text AS obj_type,
            dd.source AS obj_group,
            dd.device_type_id_name::text AS obj_name
           FROM obj_devices_view dd
             JOIN obj_lands_devices ld ON ld.devices_id = dd.devices_id AND ld.deleted IS NULL
        UNION ALL
         SELECT '4000000000000'::bigint AS tree_id,
            0 AS tree_parent_id,
            1 AS tree_order_in_level,
            NULL::integer AS obj_id,
            'structure'::text AS obj_type,
            NULL::text AS obj_group,
            'Участки без приборов учёта'::text AS obj_name
        UNION ALL
         SELECT '5000000000000'::bigint + ll.lands_id AS tree_id,
            '4000000000000'::bigint AS tree_parent_id,
            0 AS tree_order_in_level,
            ll.lands_id AS obj_id,
            'land'::text AS obj_type,
            ll.land_group AS obj_group,
            ll.land_number::text AS obj_name
           FROM obj_lands ll
          WHERE NOT (ll.lands_id IN ( SELECT ld.lands_id
                   FROM obj_lands_devices ld
                  WHERE ld.deleted IS NULL))
        UNION ALL
         SELECT '6000000000000'::bigint AS tree_id,
            0 AS tree_parent_id,
            2 AS tree_order_in_level,
            NULL::integer AS obj_id,
            'structure'::text AS obj_type,
            NULL::text AS obj_group,
            'Участки без владельцев'::text AS obj_name
        UNION ALL
         SELECT '7000000000000'::bigint + ll.lands_id AS tree_id,
            '6000000000000'::bigint AS tree_parent_id,
            0 AS tree_order_in_level,
            ll.lands_id AS obj_id,
            'land'::text AS obj_type,
            ll.land_group AS obj_group,
            ll.land_number::text AS obj_name
           FROM obj_lands ll
          WHERE NOT (ll.lands_id IN ( SELECT ul.lands_id
                   FROM obj_users_lands ul
                  WHERE ul.deleted IS NULL))
        UNION ALL
         SELECT '8000000000000'::bigint AS tree_id,
            0 AS tree_parent_id,
            3 AS tree_order_in_level,
            NULL::integer AS obj_id,
            'structure'::text AS obj_type,
            NULL::text AS obj_group,
            'Приборы учёта без участков'::text AS obj_name
        UNION ALL
         SELECT '9000000000000'::bigint + dd.devices_id AS tree_id,
            '8000000000000'::bigint AS tree_parent_id,
            0 AS tree_order_in_level,
            dd.devices_id AS obj_id,
            'device'::text AS obj_type,
            dd.source AS obj_group,
            dd.device_type_id_name::text AS obj_name
           FROM obj_devices_view dd
          WHERE NOT (dd.devices_id IN ( SELECT ld.devices_id
                   FROM obj_lands_devices ld
                  WHERE ld.deleted IS NULL))
        UNION ALL
         SELECT '10000000000000'::bigint AS tree_id,
            0 AS tree_parent_id,
            4 AS tree_order_in_level,
            NULL::integer AS obj_id,
            'structure'::text AS obj_type,
            NULL::text AS obj_group,
            'Абоненты без участков'::text AS obj_name
        UNION ALL
         SELECT '11000000000000'::bigint + uu.uid AS tree_id,
            '10000000000000'::bigint AS tree_parent_id,
            0 AS tree_order_in_level,
            uu.uid AS obj_id,
            'user'::text AS obj_type,
            NULL::text AS obj_group,
            uu.fullname AS obj_name
           FROM users uu
          WHERE uu.role::text !~* '.*(?:admin|manager|operator|user).*'::text AND NOT (uu.uid IN ( SELECT ul.uid
                   FROM obj_users_lands ul
                  WHERE ul.deleted IS NULL))
        UNION ALL
         SELECT '14000000000000'::bigint AS tree_id,
            0 AS tree_parent_id,
            4 AS tree_order_in_level,
            NULL::integer AS obj_id,
            'structure'::text AS obj_type,
            NULL::text AS obj_group,
            'Участки без тарифов'::text AS obj_name
        UNION ALL
         SELECT '15000000000000'::bigint + ll.lands_id AS tree_id,
            '14000000000000'::bigint AS tree_parent_id,
            0 AS tree_order_in_level,
            ll.lands_id AS obj_id,
            'land'::text AS obj_type,
            ll.land_group AS obj_group,
            ll.land_number::text AS obj_name
           FROM obj_lands ll
          WHERE NOT (ll.lands_id IN ( SELECT lt.lands_id
                   FROM obj_lands_tariffs lt
                  WHERE lt.deleted IS NULL))
        UNION ALL
         SELECT '16000000000000'::bigint AS tree_id,
            0 AS tree_parent_id,
            4 AS tree_order_in_level,
            NULL::integer AS obj_id,
            'structure'::text AS obj_type,
            NULL::text AS obj_group,
            'Приборы учёта без тарифов'::text AS obj_name
        UNION ALL
         SELECT '17000000000000'::bigint + dd.devices_id AS tree_id,
            '16000000000000'::bigint AS tree_parent_id,
            0 AS tree_order_in_level,
            dd.devices_id AS obj_id,
            'device'::text AS obj_type,
            dd.source AS obj_group,
            COALESCE(dd.name::text, dd.device_type_id_name::text) AS obj_name
           FROM obj_devices_view dd
          WHERE NOT (dd.devices_id IN ( SELECT ld.devices_id
                   FROM obj_devices_tariffs ld
                  WHERE ld.deleted IS NULL))
        UNION ALL
         SELECT '19000000000000'::bigint AS tree_id,
            0 AS tree_parent_id,
            5 AS tree_order_in_level,
            NULL::integer AS obj_id,
            'structure'::text AS obj_type,
            NULL::text AS obj_group,
            'Приборы учёта без начальных данных'::text AS obj_name
        UNION ALL
         SELECT '18000000000000'::bigint + dd.devices_id AS tree_id,
            '19000000000000'::bigint AS tree_parent_id,
            0 AS tree_order_in_level,
            dd.devices_id AS obj_id,
            'device'::text AS obj_type,
            dd.source AS obj_group,
            COALESCE(dd.name::text, dd.device_type_id_name::text) AS obj_name
           FROM obj_devices_view dd
          WHERE dd.starting_value1 IS NULL AND dd.starting_value2 IS NULL AND dd.starting_value3 IS NULL
        )
 SELECT objects.tree_id,
    objects.tree_parent_id,
    objects.tree_order_in_level,
    ( SELECT count(0) AS count
           FROM objects oo
          WHERE oo.tree_parent_id = objects.tree_id) AS tree_children_count,
    objects.obj_id,
    objects.obj_type,
    objects.obj_group,
    objects.obj_name,
        CASE
            WHEN objects.obj_type = 'land'::text AND objects.tree_parent_id = '12000000000000'::bigint THEN COALESCE(( SELECT 1
               FROM objects oo
              WHERE oo.tree_parent_id = objects.tree_id AND oo.obj_type = 'user'::text
             LIMIT 1), 0) + COALESCE(( SELECT 2
               FROM objects oo
              WHERE oo.tree_parent_id = objects.tree_id AND oo.obj_type = 'device'::text
             LIMIT 1), 0)
            ELSE NULL::integer
        END AS obj_assigned,
        CASE
            WHEN objects.obj_type = 'land'::text AND objects.tree_parent_id = '12000000000000'::bigint THEN ( SELECT jsonb_agg(od.*) AS jsonb_agg
               FROM ( SELECT t.lands_id,
                        t.land_number,
                        t.land_number_cadastral,
                        t.status,
                        t.address,
                        t.created,
                        t.comments,
                        t.land_group,
                        t.land_area,
                        t.land_geo_latitude,
                        t.land_geo_longitude,
                        t.land_type,
                        ( SELECT dc.val_name
                               FROM dic_custom dc
                              WHERE dc.val_id = t.land_type AND dc.val_group::text = 'LAND_TYPE'::text) AS land_type_name,
                        ( SELECT jsonb_agg(rdevices.*) AS jsonb_agg
                               FROM ( SELECT ul.lands_devices_id,
                                        ul.lands_id,
                                        ll.devices_id,
                                        ll.source,
                                        ll.name,
                                        ll.active,
                                        ll.model_id,
                                        ll.model_id_name,
                                        ll.device_type_id,
                                        ll.device_type_id_name,
                                        ll.device_group_id,
                                        ll.device_group_id_name,
                                        ll.report_period_update,
                                        ll."desc",
                                        ll.last_active,
                                        ll.last_active_left,
                                        ll.value1,
                                        ll.value2,
                                        ll.value3,
                                        ll.starting_value1,
                                        ll.starting_value2,
                                        ll.starting_value3,
                                        ll.starting_balance,
                                        ll.starting_date,
                                        ll.status,
                                        ll.created_at,
                                        ll.created_at_left,
                                        ll.updated_at,
                                        ll.updated_at_left,
                                        ll.deleted_at,
                                        ll.deleted_at_left,
                                        ll.address,
                                        ll.data_updated,
                                        ll.data_updated_left,
                                        ll.device_usage_id,
                                        ll.device_usage_name,
                                        ll.device_status_id,
                                        ll.device_status_name,
                                        ( SELECT count(0) AS count
    FROM obj_devices_tariffs odt
   WHERE odt.devices_id = ul.devices_id AND odt.deleted IS NULL) AS tariffs_count
                                       FROM obj_lands_devices ul
                                         LEFT JOIN obj_devices_view ll ON ll.devices_id = ul.devices_id
                                      WHERE ul.lands_id = t.lands_id AND ul.deleted IS NULL
                                      ORDER BY ul.created) rdevices) AS devices,
                        ( SELECT jsonb_agg(rtariffs.*) AS jsonb_agg
                               FROM ( SELECT olt.lands_tariffs_id,
                                        olt.lands_id,
                                        ot.tariffs_id,
                                        ot.tariff_name,
                                        ot.tariff_description,
                                        ot.tariff_rules,
                                        ot.created,
                                        ot.comments,
                                        ot.enabled,
                                        ot.acceptor_id AS acceptor,
                                        ot.tariff_short_name
                                       FROM obj_lands_tariffs olt
                                         LEFT JOIN obj_tariffs ot ON ot.tariffs_id = olt.tariffs_id
                                      WHERE olt.lands_id = t.lands_id AND olt.deleted IS NULL
                                      ORDER BY olt.created) rtariffs) AS tariffs,
                        ( SELECT jsonb_agg(rusers.*) AS jsonb_agg
                               FROM ( SELECT ld.users_lands_id,
                                        ld.lands_id,
                                        dd.uid,
                                        dd.email,
                                        dd.password,
                                        dd.status,
                                        dd.role,
                                        dd.phone,
                                        dd.default_manager,
                                        dd.created,
                                        dd.fullname,
                                        dd.contacts,
                                        dd.comments,
                                        dd.debtor_status,
                                        dd.post_address,
                                        dd.personal_data,
                                        dd.contracts
                                       FROM obj_users_lands ld
                                         LEFT JOIN users dd ON dd.uid = ld.uid
                                      WHERE ld.lands_id = t.lands_id AND ld.deleted IS NULL
                                      ORDER BY ld.created) rusers) AS users
                       FROM obj_lands t
                      WHERE t.lands_id = objects.obj_id) od)
            WHEN objects.obj_type = 'device'::text AND objects.tree_parent_id = '19000000000000'::bigint THEN ( SELECT jsonb_agg(dd.*) AS jsonb_agg
               FROM ( SELECT odv.devices_id,
                        odv.source,
                        odv.name,
                        odv.active,
                        odv.device_serial_number,
                        odv.properties,
                        odv.model_id,
                        odv.model_id_name,
                        odv.device_type_id,
                        odv.device_type_id_name,
                        odv.device_group_id,
                        odv.device_group_id_name,
                        odv.report_period_update,
                        odv."desc",
                        odv.last_active,
                        odv.last_active_left,
                        odv.last_message,
                        odv.value1,
                        odv.value2,
                        odv.value3,
                        odv.d90value1,
                        odv.d90value2,
                        odv.d90value3,
                        odv.starting_value1,
                        odv.starting_value2,
                        odv.starting_value3,
                        odv.starting_balance,
                        odv.starting_date,
                        odv.status,
                        odv.created_at,
                        odv.created_at_left,
                        odv.updated_at,
                        odv.updated_at_left,
                        odv.deleted_at,
                        odv.deleted_at_left,
                        odv.address,
                        odv.data_updated,
                        odv.data_updated_left,
                        odv.device_usage_id,
                        odv.device_usage_name,
                        odv.device_status_id,
                        odv.device_status_name
                       FROM obj_devices_view odv
                      WHERE odv.devices_id = objects.obj_id) dd)
            ELSE NULL::jsonb
        END AS obj_data
   FROM objects
  ORDER BY (objects.tree_id = 0) DESC, objects.tree_parent_id, objects.tree_order_in_level, (objects.obj_type = 'user'::text) DESC, objects.obj_group, ("substring"(objects.obj_name, '(\d+)'::text)::integer), objects.obj_name;

-- ----------------------------
-- Alter sequences owned by
-- ----------------------------
ALTER SEQUENCE "public"."_import_1cv1_items_cats_pk_seq"
OWNED BY "public"."_import_1cv1_items_cats"."pk";
SELECT setval('"public"."_import_1cv1_items_cats_pk_seq"', 43617, true);

-- ----------------------------
-- Alter sequences owned by
-- ----------------------------
ALTER SEQUENCE "public"."_import_1cv1_items_pk_seq"
OWNED BY "public"."_import_1cv1_items"."pk";
SELECT setval('"public"."_import_1cv1_items_pk_seq"', 44863, true);

-- ----------------------------
-- Alter sequences owned by
-- ----------------------------
ALTER SEQUENCE "public"."_import_1cv1_items_prices_pk_seq"
OWNED BY "public"."_import_1cv1_items_prices"."pk";
SELECT setval('"public"."_import_1cv1_items_prices_pk_seq"', 103430, true);

-- ----------------------------
-- Alter sequences owned by
-- ----------------------------
ALTER SEQUENCE "public"."addresses_id_seq"
OWNED BY "public"."addresses"."id";
SELECT setval('"public"."addresses_id_seq"', 3, true);

-- ----------------------------
-- Alter sequences owned by
-- ----------------------------
ALTER SEQUENCE "public"."admin_news_id_seq"
OWNED BY "public"."module_news"."id";
SELECT setval('"public"."admin_news_id_seq"', 3, true);

-- ----------------------------
-- Alter sequences owned by
-- ----------------------------
ALTER SEQUENCE "public"."admin_tabs_history_id_seq"
OWNED BY "public"."module_tabs_history"."id";
SELECT setval('"public"."admin_tabs_history_id_seq"', 4401, true);

-- ----------------------------
-- Alter sequences owned by
-- ----------------------------
ALTER SEQUENCE "public"."banners_id_seq"
OWNED BY "public"."banners"."id";
SELECT setval('"public"."banners_id_seq"', 24, true);

-- ----------------------------
-- Alter sequences owned by
-- ----------------------------
ALTER SEQUENCE "public"."banrules_id_seq"
OWNED BY "public"."banrules"."id";
SELECT setval('"public"."banrules_id_seq"', 6, true);

-- ----------------------------
-- Alter sequences owned by
-- ----------------------------
ALTER SEQUENCE "public"."bills_comments_attaches_id_seq"
OWNED BY "public"."bills_comments_attaches"."id";
SELECT setval('"public"."bills_comments_attaches_id_seq"', 2, false);

-- ----------------------------
-- Alter sequences owned by
-- ----------------------------
ALTER SEQUENCE "public"."bills_comments_id_seq"
OWNED BY "public"."bills_comments"."id";
SELECT setval('"public"."bills_comments_id_seq"', 2, false);

-- ----------------------------
-- Alter sequences owned by
-- ----------------------------
ALTER SEQUENCE "public"."bills_id_seq"
OWNED BY "public"."bills"."id";
SELECT setval('"public"."bills_id_seq"', 73762, true);

-- ----------------------------
-- Alter sequences owned by
-- ----------------------------
ALTER SEQUENCE "public"."bills_payments_id_seq"
OWNED BY "public"."bills_payments"."id";
SELECT setval('"public"."bills_payments_id_seq"', 12658, true);

-- ----------------------------
-- Alter sequences owned by
-- ----------------------------
ALTER SEQUENCE "public"."blog_categories_id_seq"
OWNED BY "public"."blog_categories"."id";
SELECT setval('"public"."blog_categories_id_seq"', 4, true);

-- ----------------------------
-- Alter sequences owned by
-- ----------------------------
ALTER SEQUENCE "public"."blog_comments_id_seq"
OWNED BY "public"."blog_comments"."id";
SELECT setval('"public"."blog_comments_id_seq"', 3, true);

-- ----------------------------
-- Alter sequences owned by
-- ----------------------------
ALTER SEQUENCE "public"."blog_posts_id_seq"
OWNED BY "public"."blog_posts"."id";
SELECT setval('"public"."blog_posts_id_seq"', 3, true);

-- ----------------------------
-- Alter sequences owned by
-- ----------------------------
ALTER SEQUENCE "public"."brands_id_seq"
OWNED BY "public"."brands"."id";
SELECT setval('"public"."brands_id_seq"', 564, true);

-- ----------------------------
-- Alter sequences owned by
-- ----------------------------
ALTER SEQUENCE "public"."cart_id_seq"
OWNED BY "public"."cart"."id";
SELECT setval('"public"."cart_id_seq"', 3, true);

-- ----------------------------
-- Alter sequences owned by
-- ----------------------------
ALTER SEQUENCE "public"."categories_ext_id_seq"
OWNED BY "public"."categories_ext"."id";
SELECT setval('"public"."categories_ext_id_seq"', 521275, true);

-- ----------------------------
-- Alter sequences owned by
-- ----------------------------
ALTER SEQUENCE "public"."categories_ext_source_id_seq"
OWNED BY "public"."categories_ext_source"."id";
SELECT setval('"public"."categories_ext_source_id_seq"', 43753, true);

-- ----------------------------
-- Alter sequences owned by
-- ----------------------------
ALTER SEQUENCE "public"."categories_ext_storage_pk_seq"
OWNED BY "public"."categories_ext_storage"."pk";
SELECT setval('"public"."categories_ext_storage_pk_seq"', 11704, true);

-- ----------------------------
-- Alter sequences owned by
-- ----------------------------
ALTER SEQUENCE "public"."categories_prices_id_seq"
OWNED BY "public"."categories_prices"."id";
SELECT setval('"public"."categories_prices_id_seq"', 233880, true);

-- ----------------------------
-- Alter sequences owned by
-- ----------------------------
ALTER SEQUENCE "public"."classifier_id_seq"
OWNED BY "public"."classifier"."id";
SELECT setval('"public"."classifier_id_seq"', 14900, true);

-- ----------------------------
-- Alter sequences owned by
-- ----------------------------
ALTER SEQUENCE "public"."classifier_props_id_seq"
OWNED BY "public"."classifier_props"."id";
SELECT setval('"public"."classifier_props_id_seq"', 66505, true);

-- ----------------------------
-- Alter sequences owned by
-- ----------------------------
ALTER SEQUENCE "public"."classifier_props_vals_id_seq"
OWNED BY "public"."classifier_props_vals"."id";
SELECT setval('"public"."classifier_props_vals_id_seq"', 937630, true);

-- ----------------------------
-- Alter sequences owned by
-- ----------------------------
ALTER SEQUENCE "public"."cms_content_history_id_seq"
OWNED BY "public"."cms_content_history"."id";
SELECT setval('"public"."cms_content_history_id_seq"', 365, true);

-- ----------------------------
-- Alter sequences owned by
-- ----------------------------
ALTER SEQUENCE "public"."cms_custom_content_id_seq"
OWNED BY "public"."cms_custom_content"."id";
SELECT setval('"public"."cms_custom_content_id_seq"', 53, true);

-- ----------------------------
-- Alter sequences owned by
-- ----------------------------
ALTER SEQUENCE "public"."cms_email_events_id_seq"
OWNED BY "public"."cms_email_events"."id";
SELECT setval('"public"."cms_email_events_id_seq"', 35, true);

-- ----------------------------
-- Alter sequences owned by
-- ----------------------------
ALTER SEQUENCE "public"."cms_knowledge_base_id_seq"
OWNED BY "public"."cms_knowledge_base"."id";
SELECT setval('"public"."cms_knowledge_base_id_seq"', 19724, true);

-- ----------------------------
-- Alter sequences owned by
-- ----------------------------
ALTER SEQUENCE "public"."cms_knowledge_base_img_id_seq"
OWNED BY "public"."cms_knowledge_base_img"."id";
SELECT setval('"public"."cms_knowledge_base_img_id_seq"', 95954, true);

-- ----------------------------
-- Alter sequences owned by
-- ----------------------------
ALTER SEQUENCE "public"."cms_loaded_id_seq"
OWNED BY "public"."cms_loaded"."id";
SELECT setval('"public"."cms_loaded_id_seq"', 3, true);

-- ----------------------------
-- Alter sequences owned by
-- ----------------------------
ALTER SEQUENCE "public"."cms_menus_id_seq"
OWNED BY "public"."cms_menus"."id";
SELECT setval('"public"."cms_menus_id_seq"', 5, true);

-- ----------------------------
-- Alter sequences owned by
-- ----------------------------
ALTER SEQUENCE "public"."cms_metatags_id_seq"
OWNED BY "public"."cms_metatags"."id";
SELECT setval('"public"."cms_metatags_id_seq"', 568947, true);

-- ----------------------------
-- Alter sequences owned by
-- ----------------------------
ALTER SEQUENCE "public"."cms_pages_content_id_seq"
OWNED BY "public"."cms_pages_content"."id";
SELECT setval('"public"."cms_pages_content_id_seq"', 73, true);

-- ----------------------------
-- Alter sequences owned by
-- ----------------------------
ALTER SEQUENCE "public"."cms_pages_id_seq"
OWNED BY "public"."cms_pages"."id";
SELECT setval('"public"."cms_pages_id_seq"', 71, true);

-- ----------------------------
-- Alter sequences owned by
-- ----------------------------
ALTER SEQUENCE "public"."currency_log_id_seq"
OWNED BY "public"."currency_log"."id";
SELECT setval('"public"."currency_log_id_seq"', 49746, true);

-- ----------------------------
-- Alter sequences owned by
-- ----------------------------
ALTER SEQUENCE "public"."debug_log_id_seq"
OWNED BY "public"."debug_log"."id";
SELECT setval('"public"."debug_log_id_seq"', 6118, true);

-- ----------------------------
-- Alter sequences owned by
-- ----------------------------
ALTER SEQUENCE "public"."deliveries_id_seq"
OWNED BY "public"."deliveries"."id";
SELECT setval('"public"."deliveries_id_seq"', 9, true);

-- ----------------------------
-- Alter sequences owned by
-- ----------------------------
ALTER SEQUENCE "public"."dic_custom_val_id_seq"
OWNED BY "public"."dic_custom"."val_id";
SELECT setval('"public"."dic_custom_val_id_seq"', 79, true);

-- ----------------------------
-- Alter sequences owned by
-- ----------------------------
ALTER SEQUENCE "public"."events_id_seq"
OWNED BY "public"."events"."id";
SELECT setval('"public"."events_id_seq"', 28, true);

-- ----------------------------
-- Alter sequences owned by
-- ----------------------------
ALTER SEQUENCE "public"."events_log_id_seq"
OWNED BY "public"."events_log"."id";
SELECT setval('"public"."events_log_id_seq"', 3, true);

-- ----------------------------
-- Alter sequences owned by
-- ----------------------------
ALTER SEQUENCE "public"."favorites_id_seq"
OWNED BY "public"."favorites"."id";
SELECT setval('"public"."favorites_id_seq"', 3, true);

-- ----------------------------
-- Alter sequences owned by
-- ----------------------------
ALTER SEQUENCE "public"."formulas_id_seq"
OWNED BY "public"."formulas"."id";
SELECT setval('"public"."formulas_id_seq"', 11, true);

-- ----------------------------
-- Alter sequences owned by
-- ----------------------------
ALTER SEQUENCE "public"."fulltext_stem_id_seq"
OWNED BY "public"."fulltext_stem"."id";
SELECT setval('"public"."fulltext_stem_id_seq"', 384172, true);

-- ----------------------------
-- Alter sequences owned by
-- ----------------------------
ALTER SEQUENCE "public"."geo_cities_id_seq"
OWNED BY "public"."geo_cities"."id";
SELECT setval('"public"."geo_cities_id_seq"', 3299, true);

-- ----------------------------
-- Alter sequences owned by
-- ----------------------------
ALTER SEQUENCE "public"."img_hashes_id_seq"
OWNED BY "public"."img_hashes"."id";
SELECT setval('"public"."img_hashes_id_seq"', 3, true);

-- ----------------------------
-- Alter sequences owned by
-- ----------------------------
ALTER SEQUENCE "public"."lands_land_id_seq"
OWNED BY "public"."obj_lands"."lands_id";
SELECT setval('"public"."lands_land_id_seq"', 350, true);

-- ----------------------------
-- Alter sequences owned by
-- ----------------------------
ALTER SEQUENCE "public"."local_items_attributes_attribute_id_seq"
OWNED BY "public"."local_items_attributes"."attribute_id";
SELECT setval('"public"."local_items_attributes_attribute_id_seq"', 665, true);

-- ----------------------------
-- Alter sequences owned by
-- ----------------------------
ALTER SEQUENCE "public"."local_items_pictures_picture_id_seq"
OWNED BY "public"."local_items_pictures"."picture_id";
SELECT setval('"public"."local_items_pictures_picture_id_seq"', 217, true);

-- ----------------------------
-- Alter sequences owned by
-- ----------------------------
ALTER SEQUENCE "public"."local_items_pids_pid_id_seq"
OWNED BY "public"."local_items_pids"."pid_id";
SELECT setval('"public"."local_items_pids_pid_id_seq"', 80, true);

-- ----------------------------
-- Alter sequences owned by
-- ----------------------------
ALTER SEQUENCE "public"."local_items_pids_vids_vid_id_seq"
OWNED BY "public"."local_items_pids_vids"."vid_id";
SELECT setval('"public"."local_items_pids_vids_vid_id_seq"', 660, true);

-- ----------------------------
-- Alter sequences owned by
-- ----------------------------
ALTER SEQUENCE "public"."log_api_requests_id_seq"
OWNED BY "public"."log_api_requests"."id";
SELECT setval('"public"."log_api_requests_id_seq"', 3, true);

-- ----------------------------
-- Alter sequences owned by
-- ----------------------------
ALTER SEQUENCE "public"."log_dsg_buffer_id_seq"
OWNED BY "public"."log_dsg_buffer"."id";
SELECT setval('"public"."log_dsg_buffer_id_seq"', 39, true);

-- ----------------------------
-- Alter sequences owned by
-- ----------------------------
ALTER SEQUENCE "public"."log_dsg_details_id_seq"
OWNED BY "public"."log_dsg_details"."id";
SELECT setval('"public"."log_dsg_details_id_seq"', 3, true);

-- ----------------------------
-- Alter sequences owned by
-- ----------------------------
ALTER SEQUENCE "public"."log_dsg_id_seq"
OWNED BY "public"."log_dsg"."id";
SELECT setval('"public"."log_dsg_id_seq"', 3, true);

-- ----------------------------
-- Alter sequences owned by
-- ----------------------------
ALTER SEQUENCE "public"."log_dsg_translator_id_seq"
OWNED BY "public"."log_dsg_translator"."id";
SELECT setval('"public"."log_dsg_translator_id_seq"', 14, true);

-- ----------------------------
-- Alter sequences owned by
-- ----------------------------
ALTER SEQUENCE "public"."log_http_requests_id_seq"
OWNED BY "public"."log_http_requests"."id";
SELECT setval('"public"."log_http_requests_id_seq"', 1237351, true);

-- ----------------------------
-- Alter sequences owned by
-- ----------------------------
ALTER SEQUENCE "public"."log_iot_id_seq"
OWNED BY "public"."log_iot"."id";
SELECT setval('"public"."log_iot_id_seq"', 565338, true);

-- ----------------------------
-- Alter sequences owned by
-- ----------------------------
ALTER SEQUENCE "public"."log_item_requests_id_seq"
OWNED BY "public"."log_item_requests"."id";
SELECT setval('"public"."log_item_requests_id_seq"', 3267011, true);

-- ----------------------------
-- Alter sequences owned by
-- ----------------------------
ALTER SEQUENCE "public"."log_queries_requests_id_seq"
OWNED BY "public"."log_queries_requests"."id";
SELECT setval('"public"."log_queries_requests_id_seq"', 26274, true);

-- ----------------------------
-- Alter sequences owned by
-- ----------------------------
ALTER SEQUENCE "public"."log_site_errors_id_seq"
OWNED BY "public"."log_site_errors"."id";
SELECT setval('"public"."log_site_errors_id_seq"', 37238, true);

-- ----------------------------
-- Alter sequences owned by
-- ----------------------------
ALTER SEQUENCE "public"."log_translations_id_seq"
OWNED BY "public"."log_translations"."id";
SELECT setval('"public"."log_translations_id_seq"', 91, true);

-- ----------------------------
-- Alter sequences owned by
-- ----------------------------
ALTER SEQUENCE "public"."log_translator_keys_id_seq"
OWNED BY "public"."log_translator_keys"."id";
SELECT setval('"public"."log_translator_keys_id_seq"', 112, true);

-- ----------------------------
-- Alter sequences owned by
-- ----------------------------
ALTER SEQUENCE "public"."log_user_activity_id_seq"
OWNED BY "public"."log_user_activity"."id";
SELECT setval('"public"."log_user_activity_id_seq"', 6540, true);

-- ----------------------------
-- Alter sequences owned by
-- ----------------------------
ALTER SEQUENCE "public"."mail_queue_id_seq"
OWNED BY "public"."mail_queue"."id";
SELECT setval('"public"."mail_queue_id_seq"', 192, true);

-- ----------------------------
-- Alter sequences owned by
-- ----------------------------
ALTER SEQUENCE "public"."messages_id_seq"
OWNED BY "public"."messages"."id";
SELECT setval('"public"."messages_id_seq"', 1659, true);

-- ----------------------------
-- Alter sequences owned by
-- ----------------------------
ALTER SEQUENCE "public"."obj_devices_manual_data_data_id_seq"
OWNED BY "public"."obj_devices_manual_data"."data_id";
SELECT setval('"public"."obj_devices_manual_data_data_id_seq"', 2297, true);

-- ----------------------------
-- Alter sequences owned by
-- ----------------------------
ALTER SEQUENCE "public"."obj_devices_manual_devices_id_seq"
OWNED BY "public"."obj_devices_manual"."devices_id";
SELECT setval('"public"."obj_devices_manual_devices_id_seq"', 1073742354, true);

-- ----------------------------
-- Alter sequences owned by
-- ----------------------------
ALTER SEQUENCE "public"."obj_devices_tariffs_copy1_devices_tariffs_id_seq"
OWNED BY "public"."obj_devices_startpoints"."devices_startpoint_id";
SELECT setval('"public"."obj_devices_tariffs_copy1_devices_tariffs_id_seq"', 17, true);

-- ----------------------------
-- Alter sequences owned by
-- ----------------------------
ALTER SEQUENCE "public"."obj_devices_tariffs_devices_tariffs_id_seq"
OWNED BY "public"."obj_devices_tariffs"."devices_tariffs_id";
SELECT setval('"public"."obj_devices_tariffs_devices_tariffs_id_seq"', 547, true);

-- ----------------------------
-- Alter sequences owned by
-- ----------------------------
ALTER SEQUENCE "public"."obj_lands_devices_lands_devices_id_seq"
OWNED BY "public"."obj_lands_devices"."lands_devices_id";
SELECT setval('"public"."obj_lands_devices_lands_devices_id_seq"', 363, true);

-- ----------------------------
-- Alter sequences owned by
-- ----------------------------
ALTER SEQUENCE "public"."obj_lands_tariffs_lands_tariffs_id_seq"
OWNED BY "public"."obj_lands_tariffs"."lands_tariffs_id";
SELECT setval('"public"."obj_lands_tariffs_lands_tariffs_id_seq"', 1040, true);

-- ----------------------------
-- Alter sequences owned by
-- ----------------------------
ALTER SEQUENCE "public"."obj_news_confirmations_news_confirmations_id_seq"
OWNED BY "public"."obj_news_confirmations"."news_confirmations_id";
SELECT setval('"public"."obj_news_confirmations_news_confirmations_id_seq"', 114, true);

-- ----------------------------
-- Alter sequences owned by
-- ----------------------------
ALTER SEQUENCE "public"."obj_news_news_id_seq"
OWNED BY "public"."obj_news"."news_id";
SELECT setval('"public"."obj_news_news_id_seq"', 484, true);

-- ----------------------------
-- Alter sequences owned by
-- ----------------------------
ALTER SEQUENCE "public"."obj_tariffs_acceptors_tariff_acceptors_id_seq"
OWNED BY "public"."obj_tariffs_acceptors"."tariff_acceptors_id";
SELECT setval('"public"."obj_tariffs_acceptors_tariff_acceptors_id_seq"', 3, true);

-- ----------------------------
-- Alter sequences owned by
-- ----------------------------
ALTER SEQUENCE "public"."obj_tariffs_tariffs_id_seq"
OWNED BY "public"."obj_tariffs"."tariffs_id";
SELECT setval('"public"."obj_tariffs_tariffs_id_seq"', 14, true);

-- ----------------------------
-- Alter sequences owned by
-- ----------------------------
ALTER SEQUENCE "public"."obj_votings_results_votings_results_id_seq"
OWNED BY "public"."obj_votings_results"."votings_results_id";
SELECT setval('"public"."obj_votings_results_votings_results_id_seq"', 29690, true);

-- ----------------------------
-- Alter sequences owned by
-- ----------------------------
ALTER SEQUENCE "public"."obj_votings_votings_id_seq"
OWNED BY "public"."obj_votings"."votings_id";
SELECT setval('"public"."obj_votings_votings_id_seq"', 115, true);

-- ----------------------------
-- Alter sequences owned by
-- ----------------------------
ALTER SEQUENCE "public"."orders_comments_attaches_id_seq"
OWNED BY "public"."orders_comments_attaches"."id";
SELECT setval('"public"."orders_comments_attaches_id_seq"', 3, true);

-- ----------------------------
-- Alter sequences owned by
-- ----------------------------
ALTER SEQUENCE "public"."orders_comments_id_seq"
OWNED BY "public"."orders_comments"."id";
SELECT setval('"public"."orders_comments_id_seq"', 3, true);

-- ----------------------------
-- Alter sequences owned by
-- ----------------------------
ALTER SEQUENCE "public"."orders_id_seq"
OWNED BY "public"."orders"."id";
SELECT setval('"public"."orders_id_seq"', 3, true);

-- ----------------------------
-- Alter sequences owned by
-- ----------------------------
ALTER SEQUENCE "public"."orders_items_comments_attaches_id_seq"
OWNED BY "public"."orders_items_comments_attaches"."id";
SELECT setval('"public"."orders_items_comments_attaches_id_seq"', 3, true);

-- ----------------------------
-- Alter sequences owned by
-- ----------------------------
ALTER SEQUENCE "public"."orders_items_comments_id_seq"
OWNED BY "public"."orders_items_comments"."id";
SELECT setval('"public"."orders_items_comments_id_seq"', 3, true);

-- ----------------------------
-- Alter sequences owned by
-- ----------------------------
ALTER SEQUENCE "public"."orders_items_id_seq"
OWNED BY "public"."orders_items"."id";
SELECT setval('"public"."orders_items_id_seq"', 3, true);

-- ----------------------------
-- Alter sequences owned by
-- ----------------------------
ALTER SEQUENCE "public"."orders_payments_id_seq"
OWNED BY "public"."orders_payments"."id";
SELECT setval('"public"."orders_payments_id_seq"', 3, true);

-- ----------------------------
-- Alter sequences owned by
-- ----------------------------
ALTER SEQUENCE "public"."orders_statuses_copy1_id_seq"
OWNED BY "public"."bills_statuses"."id";
SELECT setval('"public"."orders_statuses_copy1_id_seq"', 33, false);

-- ----------------------------
-- Alter sequences owned by
-- ----------------------------
ALTER SEQUENCE "public"."orders_statuses_id_seq"
OWNED BY "public"."orders_statuses"."id";
SELECT setval('"public"."orders_statuses_id_seq"', 32, true);

-- ----------------------------
-- Alter sequences owned by
-- ----------------------------
ALTER SEQUENCE "public"."parcels_cart_id_seq"
OWNED BY "public"."parcels_cart"."id";
SELECT setval('"public"."parcels_cart_id_seq"', 3, true);

-- ----------------------------
-- Alter sequences owned by
-- ----------------------------
ALTER SEQUENCE "public"."parcels_comments_attaches_id_seq"
OWNED BY "public"."parcels_comments_attaches"."id";
SELECT setval('"public"."parcels_comments_attaches_id_seq"', 3, true);

-- ----------------------------
-- Alter sequences owned by
-- ----------------------------
ALTER SEQUENCE "public"."parcels_comments_id_seq"
OWNED BY "public"."parcels_comments"."id";
SELECT setval('"public"."parcels_comments_id_seq"', 3, true);

-- ----------------------------
-- Alter sequences owned by
-- ----------------------------
ALTER SEQUENCE "public"."parcels_id_seq"
OWNED BY "public"."parcels"."id";
SELECT setval('"public"."parcels_id_seq"', 3, true);

-- ----------------------------
-- Alter sequences owned by
-- ----------------------------
ALTER SEQUENCE "public"."parcels_items_id_seq"
OWNED BY "public"."parcels_items"."id";
SELECT setval('"public"."parcels_items_id_seq"', 3, true);

-- ----------------------------
-- Alter sequences owned by
-- ----------------------------
ALTER SEQUENCE "public"."parcels_payments_id_seq"
OWNED BY "public"."parcels_payments"."id";
SELECT setval('"public"."parcels_payments_id_seq"', 3, true);

-- ----------------------------
-- Alter sequences owned by
-- ----------------------------
ALTER SEQUENCE "public"."parcels_statuses_id_seq"
OWNED BY "public"."parcels_statuses"."id";
SELECT setval('"public"."parcels_statuses_id_seq"', 16, true);

-- ----------------------------
-- Alter sequences owned by
-- ----------------------------
ALTER SEQUENCE "public"."pay_systems_id_seq"
OWNED BY "public"."pay_systems"."id";
SELECT setval('"public"."pay_systems_id_seq"', 35, true);

-- ----------------------------
-- Alter sequences owned by
-- ----------------------------
ALTER SEQUENCE "public"."pay_systems_log_id_seq"
OWNED BY "public"."pay_systems_log"."id";
SELECT setval('"public"."pay_systems_log_id_seq"', 203, true);

-- ----------------------------
-- Alter sequences owned by
-- ----------------------------
ALTER SEQUENCE "public"."payments_id_seq"
OWNED BY "public"."payments"."id";
SELECT setval('"public"."payments_id_seq"', 54, true);

-- ----------------------------
-- Alter sequences owned by
-- ----------------------------
ALTER SEQUENCE "public"."questions_id_seq"
OWNED BY "public"."questions"."id";
SELECT setval('"public"."questions_id_seq"', 930, true);

-- ----------------------------
-- Alter sequences owned by
-- ----------------------------
ALTER SEQUENCE "public"."reports_system_id_seq"
OWNED BY "public"."reports_system"."id";
SELECT setval('"public"."reports_system_id_seq"', 28, true);

-- ----------------------------
-- Alter sequences owned by
-- ----------------------------
ALTER SEQUENCE "public"."scheduled_jobs_id_seq"
OWNED BY "public"."scheduled_jobs"."id";
SELECT setval('"public"."scheduled_jobs_id_seq"', 20, true);

-- ----------------------------
-- Alter sequences owned by
-- ----------------------------
ALTER SEQUENCE "public"."t_source_category_id_seq"
OWNED BY "public"."t_source_category"."id";
SELECT setval('"public"."t_source_category_id_seq"', 10834240, true);

-- ----------------------------
-- Alter sequences owned by
-- ----------------------------
ALTER SEQUENCE "public"."t_source_dictionary_id_seq"
OWNED BY "public"."t_source_dictionary"."id";
SELECT setval('"public"."t_source_dictionary_id_seq"', 32212, true);

-- ----------------------------
-- Alter sequences owned by
-- ----------------------------
ALTER SEQUENCE "public"."t_source_dictionary_long_id_seq"
OWNED BY "public"."t_source_dictionary_long"."id";
SELECT setval('"public"."t_source_dictionary_long_id_seq"', 8582, true);

-- ----------------------------
-- Alter sequences owned by
-- ----------------------------
ALTER SEQUENCE "public"."t_source_message_id_seq"
OWNED BY "public"."t_source_message"."id";
SELECT setval('"public"."t_source_message_id_seq"', 13412, true);

-- ----------------------------
-- Alter sequences owned by
-- ----------------------------
ALTER SEQUENCE "public"."t_source_pinned_id_seq"
OWNED BY "public"."t_source_pinned"."id";
SELECT setval('"public"."t_source_pinned_id_seq"', 5, true);

-- ----------------------------
-- Alter sequences owned by
-- ----------------------------
ALTER SEQUENCE "public"."t_source_sentences_id_seq"
OWNED BY "public"."t_source_sentences"."id";
SELECT setval('"public"."t_source_sentences_id_seq"', 10002, true);

-- ----------------------------
-- Alter sequences owned by
-- ----------------------------
ALTER SEQUENCE "public"."translator_keys_id_seq"
OWNED BY "public"."translator_keys"."id";
SELECT setval('"public"."translator_keys_id_seq"', 127, true);

-- ----------------------------
-- Alter sequences owned by
-- ----------------------------
ALTER SEQUENCE "public"."user_notice_id_seq"
OWNED BY "public"."user_notice"."id";
SELECT setval('"public"."user_notice_id_seq"', 9, true);

-- ----------------------------
-- Alter sequences owned by
-- ----------------------------
ALTER SEQUENCE "public"."users_lands_users_lands_id_seq"
OWNED BY "public"."obj_users_lands"."users_lands_id";
SELECT setval('"public"."users_lands_users_lands_id_seq"', 2095, true);

-- ----------------------------
-- Alter sequences owned by
-- ----------------------------
ALTER SEQUENCE "public"."users_uid_seq"
OWNED BY "public"."users"."uid";
SELECT setval('"public"."users_uid_seq"', 22256, true);

-- ----------------------------
-- Alter sequences owned by
-- ----------------------------
ALTER SEQUENCE "public"."warehouse_id_seq"
OWNED BY "public"."warehouse"."id";
SELECT setval('"public"."warehouse_id_seq"', 8, true);

-- ----------------------------
-- Alter sequences owned by
-- ----------------------------
ALTER SEQUENCE "public"."warehouse_place_id_seq"
OWNED BY "public"."warehouse_place"."id";
SELECT setval('"public"."warehouse_place_id_seq"', 45, true);

-- ----------------------------
-- Alter sequences owned by
-- ----------------------------
ALTER SEQUENCE "public"."warehouse_place_item_id_seq"
OWNED BY "public"."warehouse_place_item"."id";
SELECT setval('"public"."warehouse_place_item_id_seq"', 169, true);

-- ----------------------------
-- Alter sequences owned by
-- ----------------------------
ALTER SEQUENCE "public"."weights_id_seq"
OWNED BY "public"."weights"."id";
SELECT setval('"public"."weights_id_seq"', 23105, true);

-- ----------------------------
-- Indexes structure for table _import_1cv1_items
-- ----------------------------
CREATE INDEX "idx_ds_source2" ON "public"."_import_1cv1_items" USING btree (
  "ds_source" COLLATE "pg_catalog"."default" "pg_catalog"."text_ops" ASC NULLS LAST
);
CREATE INDEX "idx_id" ON "public"."_import_1cv1_items" USING btree (
  "id" COLLATE "pg_catalog"."default" "pg_catalog"."text_ops" ASC NULLS LAST
);
CREATE INDEX "idx_remain" ON "public"."_import_1cv1_items" USING btree (
  "remain" "pg_catalog"."int4_ops" ASC NULLS LAST
);

-- ----------------------------
-- Uniques structure for table _import_1cv1_items
-- ----------------------------
ALTER TABLE "public"."_import_1cv1_items" ADD CONSTRAINT "_import_1cv1_items_constr" UNIQUE ("pk");

-- ----------------------------
-- Primary Key structure for table _import_1cv1_items
-- ----------------------------
ALTER TABLE "public"."_import_1cv1_items" ADD CONSTRAINT "_import_1cv1_items_pkey" PRIMARY KEY ("pk");

-- ----------------------------
-- Indexes structure for table _import_1cv1_items_cats
-- ----------------------------
CREATE INDEX "idx_cat_id" ON "public"."_import_1cv1_items_cats" USING btree (
  "cat_id" COLLATE "pg_catalog"."default" "pg_catalog"."text_ops" ASC NULLS LAST
);
CREATE INDEX "idx_ds_source" ON "public"."_import_1cv1_items_cats" USING btree (
  "ds_source" COLLATE "pg_catalog"."default" "pg_catalog"."text_ops" ASC NULLS LAST
);
CREATE INDEX "idx_item_id" ON "public"."_import_1cv1_items_cats" USING btree (
  "item_id" COLLATE "pg_catalog"."default" "pg_catalog"."text_ops" ASC NULLS LAST
);

-- ----------------------------
-- Uniques structure for table _import_1cv1_items_cats
-- ----------------------------
ALTER TABLE "public"."_import_1cv1_items_cats" ADD CONSTRAINT "_import_1cv1_items_cats_constr" UNIQUE ("pk");

-- ----------------------------
-- Primary Key structure for table _import_1cv1_items_cats
-- ----------------------------
ALTER TABLE "public"."_import_1cv1_items_cats" ADD CONSTRAINT "_import_1cv1_items_cats_pkey" PRIMARY KEY ("pk");

-- ----------------------------
-- Indexes structure for table _import_1cv1_items_prices
-- ----------------------------
CREATE INDEX "idx_ds_source_import_1cv1_items_prices" ON "public"."_import_1cv1_items_prices" USING btree (
  "ds_source" COLLATE "pg_catalog"."default" "pg_catalog"."text_ops" ASC NULLS LAST
);
CREATE INDEX "idx_item_id_import_1cv1_items_prices" ON "public"."_import_1cv1_items_prices" USING btree (
  "item_id" COLLATE "pg_catalog"."default" "pg_catalog"."text_ops" ASC NULLS LAST
);
CREATE INDEX "idx_price" ON "public"."_import_1cv1_items_prices" USING btree (
  "price" "pg_catalog"."numeric_ops" ASC NULLS LAST
);
CREATE INDEX "idx_price_currency" ON "public"."_import_1cv1_items_prices" USING btree (
  "price_currency" COLLATE "pg_catalog"."default" "pg_catalog"."text_ops" ASC NULLS LAST
);
CREATE INDEX "idx_price_type" ON "public"."_import_1cv1_items_prices" USING btree (
  "price_type" COLLATE "pg_catalog"."default" "pg_catalog"."text_ops" ASC NULLS LAST
);

-- ----------------------------
-- Uniques structure for table _import_1cv1_items_prices
-- ----------------------------
ALTER TABLE "public"."_import_1cv1_items_prices" ADD CONSTRAINT "_import_1cv1_items_prices_constr" UNIQUE ("pk");

-- ----------------------------
-- Primary Key structure for table _import_1cv1_items_prices
-- ----------------------------
ALTER TABLE "public"."_import_1cv1_items_prices" ADD CONSTRAINT "_import_1cv1_items_prices_pkey" PRIMARY KEY ("pk");

-- ----------------------------
-- Indexes structure for table access_rights
-- ----------------------------
CREATE INDEX "idx_role_pk" ON "public"."access_rights" USING btree (
  "role" COLLATE "pg_catalog"."default" "pg_catalog"."text_ops" ASC NULLS LAST
);

-- ----------------------------
-- Primary Key structure for table access_rights
-- ----------------------------
ALTER TABLE "public"."access_rights" ADD CONSTRAINT "access_rights_pkey" PRIMARY KEY ("role");

-- ----------------------------
-- Indexes structure for table addresses
-- ----------------------------
CREATE INDEX "fk_to_uisers" ON "public"."addresses" USING btree (
  "uid" "pg_catalog"."int4_ops" ASC NULLS LAST
);
CREATE INDEX "idx_enabled" ON "public"."addresses" USING btree (
  "enabled" "pg_catalog"."int2_ops" ASC NULLS LAST
);
CREATE INDEX "idx_is_delivery_point" ON "public"."addresses" USING btree (
  "is_delivery_point" "pg_catalog"."int2_ops" ASC NULLS LAST
);

-- ----------------------------
-- Primary Key structure for table addresses
-- ----------------------------
ALTER TABLE "public"."addresses" ADD CONSTRAINT "addresses_pkey" PRIMARY KEY ("id");

-- ----------------------------
-- Primary Key structure for table api
-- ----------------------------
ALTER TABLE "public"."api" ADD CONSTRAINT "api_pkey" PRIMARY KEY ("function");

-- ----------------------------
-- Indexes structure for table banners
-- ----------------------------
CREATE INDEX "idx_all" ON "public"."banners" USING btree (
  "enabled" "pg_catalog"."int4_ops" ASC NULLS LAST,
  "front_theme" COLLATE "pg_catalog"."default" "pg_catalog"."text_ops" ASC NULLS LAST,
  "banner_order" "pg_catalog"."int4_ops" ASC NULLS LAST
);
CREATE INDEX "idx_banner_order" ON "public"."banners" USING btree (
  "banner_order" "pg_catalog"."int4_ops" ASC NULLS LAST
);
CREATE INDEX "idx_enabled_banners" ON "public"."banners" USING btree (
  "enabled" "pg_catalog"."int4_ops" ASC NULLS LAST
);
CREATE INDEX "idx_front_theme" ON "public"."banners" USING btree (
  "front_theme" COLLATE "pg_catalog"."default" "pg_catalog"."text_ops" ASC NULLS LAST
);

-- ----------------------------
-- Primary Key structure for table banners
-- ----------------------------
ALTER TABLE "public"."banners" ADD CONSTRAINT "banners_pkey" PRIMARY KEY ("id");

-- ----------------------------
-- Indexes structure for table banrules
-- ----------------------------
CREATE INDEX "idx_enabled_banrules" ON "public"."banrules" USING btree (
  "enabled" "pg_catalog"."int4_ops" ASC NULLS LAST
);
CREATE INDEX "idx_enabled_rule_order" ON "public"."banrules" USING btree (
  "enabled" "pg_catalog"."int4_ops" ASC NULLS LAST,
  "rule_order" "pg_catalog"."int4_ops" ASC NULLS LAST
);
CREATE INDEX "idx_rule_order" ON "public"."banrules" USING btree (
  "rule_order" "pg_catalog"."int4_ops" ASC NULLS LAST
);

-- ----------------------------
-- Primary Key structure for table banrules
-- ----------------------------
ALTER TABLE "public"."banrules" ADD CONSTRAINT "banrules_pkey" PRIMARY KEY ("id");

-- ----------------------------
-- Indexes structure for table bills
-- ----------------------------
CREATE INDEX "bills_code_index1" ON "public"."bills" USING btree (
  "code" COLLATE "pg_catalog"."default" "pg_catalog"."text_ops" ASC NULLS LAST
);
CREATE INDEX "bills_code_index2" ON "public"."bills" USING btree (
  replace(code::text, '-'::text, ''::text) COLLATE "pg_catalog"."default" "pg_catalog"."text_ops" ASC NULLS LAST
);
CREATE INDEX "bills_id_status_idx" ON "public"."bills" USING btree (
  "id" "pg_catalog"."int4_ops" ASC NULLS LAST,
  "status" COLLATE "pg_catalog"."default" "pg_catalog"."text_ops" ASC NULLS LAST
);
CREATE INDEX "idx_bills_date" ON "public"."bills" USING btree (
  "date" "pg_catalog"."timestamptz_ops" ASC NULLS LAST
);
CREATE INDEX "idx_bills_id_manager" ON "public"."bills" USING btree (
  "id" "pg_catalog"."int4_ops" ASC NULLS LAST,
  "manager_id" "pg_catalog"."int4_ops" ASC NULLS LAST
);
CREATE INDEX "idx_bills_manager" ON "public"."bills" USING btree (
  "manager_id" "pg_catalog"."int4_ops" ASC NULLS LAST
);
CREATE INDEX "idx_bills_manual_sum" ON "public"."bills" USING btree (
  "manual_summ" "pg_catalog"."numeric_ops" ASC NULLS LAST
);
CREATE INDEX "idx_bills_status" ON "public"."bills" USING btree (
  "status" COLLATE "pg_catalog"."default" "pg_catalog"."text_ops" ASC NULLS LAST
);
CREATE INDEX "idx_bills_status_hash" ON "public"."bills" USING hash (
  "status" COLLATE "pg_catalog"."default" "pg_catalog"."text_ops"
);
CREATE INDEX "idx_bills_summ" ON "public"."bills" USING btree (
  "summ" "pg_catalog"."numeric_ops" ASC NULLS LAST
);
CREATE INDEX "idx_bills_tariff_object_id" ON "public"."bills" USING btree (
  "tariff_object_id" "pg_catalog"."int4_ops" ASC NULLS LAST
);
CREATE INDEX "idx_bills_tariff_object_id_status" ON "public"."bills" USING btree (
  "tariff_object_id" "pg_catalog"."int4_ops" ASC NULLS LAST,
  "status" COLLATE "pg_catalog"."default" "pg_catalog"."text_ops" ASC NULLS LAST
);

-- ----------------------------
-- Primary Key structure for table bills
-- ----------------------------
ALTER TABLE "public"."bills" ADD CONSTRAINT "bills_pkey" PRIMARY KEY ("id");

-- ----------------------------
-- Indexes structure for table bills_comments
-- ----------------------------
CREATE INDEX "idx_bills_comments_bid" ON "public"."bills_comments" USING btree (
  "bid" "pg_catalog"."int4_ops" ASC NULLS LAST
);
CREATE INDEX "idx_bills_comments_internal" ON "public"."bills_comments" USING btree (
  "internal" "pg_catalog"."int2_ops" ASC NULLS LAST
);
CREATE INDEX "idx_date_bills_comments" ON "public"."bills_comments" USING btree (
  "date" "pg_catalog"."timestamptz_ops" ASC NULLS LAST
);

-- ----------------------------
-- Primary Key structure for table bills_comments
-- ----------------------------
ALTER TABLE "public"."bills_comments" ADD CONSTRAINT "bills_comments_pkey" PRIMARY KEY ("id");

-- ----------------------------
-- Indexes structure for table bills_comments_attaches
-- ----------------------------
CREATE INDEX "idx_bills_cattach_commentid" ON "public"."bills_comments_attaches" USING btree (
  "comment_id" "pg_catalog"."int8_ops" ASC NULLS LAST
);

-- ----------------------------
-- Primary Key structure for table bills_comments_attaches
-- ----------------------------
ALTER TABLE "public"."bills_comments_attaches" ADD CONSTRAINT "bills_comments_attaches_pkey" PRIMARY KEY ("id");

-- ----------------------------
-- Indexes structure for table bills_payments
-- ----------------------------
CREATE INDEX "idx_bid_bills_payments" ON "public"."bills_payments" USING btree (
  "bid" "pg_catalog"."int4_ops" ASC NULLS LAST
);
CREATE INDEX "idx_bills_payments_summ" ON "public"."bills_payments" USING btree (
  "summ" "pg_catalog"."numeric_ops" ASC NULLS LAST
);
CREATE INDEX "idx_date_bills_payments" ON "public"."bills_payments" USING btree (
  "date" "pg_catalog"."timestamptz_ops" ASC NULLS LAST
);
CREATE INDEX "idx_uid_bills_payments" ON "public"."bills_payments" USING btree (
  "uid" "pg_catalog"."int4_ops" ASC NULLS LAST
);

-- ----------------------------
-- Primary Key structure for table bills_payments
-- ----------------------------
ALTER TABLE "public"."bills_payments" ADD CONSTRAINT "bills_payments_pkey" PRIMARY KEY ("id");

-- ----------------------------
-- Indexes structure for table bills_statuses
-- ----------------------------
CREATE INDEX "idx_bill_enabled_manual" ON "public"."bills_statuses" USING btree (
  "enabled" "pg_catalog"."int2_ops" ASC NULLS LAST,
  "manual" "pg_catalog"."int2_ops" ASC NULLS LAST
);
CREATE INDEX "idx_bill_enabled_manual_process" ON "public"."bills_statuses" USING btree (
  "enabled" "pg_catalog"."int2_ops" ASC NULLS LAST,
  "manual" "pg_catalog"."int2_ops" ASC NULLS LAST,
  "order_in_process" "pg_catalog"."int2_ops" ASC NULLS LAST
);
CREATE INDEX "idx_bill_in_process" ON "public"."bills_statuses" USING btree (
  "order_in_process" "pg_catalog"."int2_ops" ASC NULLS LAST
);
CREATE INDEX "idx_bill_status_enabled" ON "public"."bills_statuses" USING btree (
  "enabled" "pg_catalog"."int2_ops" ASC NULLS LAST
);
CREATE INDEX "idx_bill_status_manual" ON "public"."bills_statuses" USING btree (
  "manual" "pg_catalog"."int2_ops" ASC NULLS LAST
);
CREATE INDEX "idx_bill_status_name" ON "public"."bills_statuses" USING btree (
  "name" COLLATE "pg_catalog"."default" "pg_catalog"."text_ops" ASC NULLS LAST
);
CREATE INDEX "idx_bill_status_value" ON "public"."bills_statuses" USING btree (
  "value" COLLATE "pg_catalog"."default" "pg_catalog"."text_ops" ASC NULLS LAST
);
CREATE INDEX "idx_bill_status_value_hash" ON "public"."bills_statuses" USING hash (
  "value" COLLATE "pg_catalog"."default" "pg_catalog"."text_ops"
);
CREATE INDEX "idx_parent_status_bill_parent_statuses" ON "public"."bills_statuses" USING btree (
  "parent_status_value" COLLATE "pg_catalog"."default" "pg_catalog"."text_ops" ASC NULLS LAST
);

-- ----------------------------
-- Uniques structure for table bills_statuses
-- ----------------------------
ALTER TABLE "public"."bills_statuses" ADD CONSTRAINT "orders_statuses_copy1_value_key" UNIQUE ("value");

-- ----------------------------
-- Primary Key structure for table bills_statuses
-- ----------------------------
ALTER TABLE "public"."bills_statuses" ADD CONSTRAINT "orders_statuses_copy1_pkey" PRIMARY KEY ("id");

-- ----------------------------
-- Indexes structure for table blog_categories
-- ----------------------------
CREATE INDEX "idx_access_rights_comment" ON "public"."blog_categories" USING btree (
  "access_rights_comment" COLLATE "pg_catalog"."default" "pg_catalog"."text_ops" ASC NULLS LAST
);
CREATE INDEX "idx_access_rights_post" ON "public"."blog_categories" USING btree (
  "access_rights_post" COLLATE "pg_catalog"."default" "pg_catalog"."text_ops" ASC NULLS LAST
);
CREATE INDEX "idx_enabled_blog_categories" ON "public"."blog_categories" USING btree (
  "enabled" "pg_catalog"."int2_ops" ASC NULLS LAST
);
CREATE INDEX "idx_name" ON "public"."blog_categories" USING btree (
  "name" COLLATE "pg_catalog"."default" "pg_catalog"."text_ops" ASC NULLS LAST
);

-- ----------------------------
-- Primary Key structure for table blog_categories
-- ----------------------------
ALTER TABLE "public"."blog_categories" ADD CONSTRAINT "blog_categories_pkey" PRIMARY KEY ("id");

-- ----------------------------
-- Indexes structure for table blog_comments
-- ----------------------------
CREATE INDEX "idx_created" ON "public"."blog_comments" USING btree (
  "created" "pg_catalog"."timestamptz_ops" ASC NULLS LAST
);
CREATE INDEX "idx_enabled_blog_comments" ON "public"."blog_comments" USING btree (
  "enabled" "pg_catalog"."int2_ops" ASC NULLS LAST
);
CREATE INDEX "idx_post_id" ON "public"."blog_comments" USING btree (
  "post_id" "pg_catalog"."int4_ops" ASC NULLS LAST
);
CREATE INDEX "idx_uid_blog_comments" ON "public"."blog_comments" USING btree (
  "uid" "pg_catalog"."int4_ops" ASC NULLS LAST
);

-- ----------------------------
-- Primary Key structure for table blog_comments
-- ----------------------------
ALTER TABLE "public"."blog_comments" ADD CONSTRAINT "blog_comments_pkey" PRIMARY KEY ("id");

-- ----------------------------
-- Indexes structure for table blog_posts
-- ----------------------------
CREATE INDEX "idx_category_id" ON "public"."blog_posts" USING btree (
  "category_id" "pg_catalog"."int4_ops" ASC NULLS LAST
);
CREATE INDEX "idx_comments_enabled" ON "public"."blog_posts" USING btree (
  "comments_enabled" "pg_catalog"."int2_ops" ASC NULLS LAST
);
CREATE INDEX "idx_created_blog_posts" ON "public"."blog_posts" USING btree (
  "created" "pg_catalog"."timestamptz_ops" ASC NULLS LAST
);
CREATE INDEX "idx_enabled_blog_posts" ON "public"."blog_posts" USING btree (
  "enabled" "pg_catalog"."int2_ops" ASC NULLS LAST
);
CREATE INDEX "idx_end_date" ON "public"."blog_posts" USING btree (
  "end_date" "pg_catalog"."timestamptz_ops" ASC NULLS LAST
);
CREATE INDEX "idx_start_date" ON "public"."blog_posts" USING btree (
  "start_date" "pg_catalog"."timestamptz_ops" ASC NULLS LAST
);
CREATE INDEX "idx_uid_blog_posts" ON "public"."blog_posts" USING btree (
  "uid" "pg_catalog"."int4_ops" ASC NULLS LAST
);

-- ----------------------------
-- Primary Key structure for table blog_posts
-- ----------------------------
ALTER TABLE "public"."blog_posts" ADD CONSTRAINT "blog_posts_pkey" PRIMARY KEY ("id");

-- ----------------------------
-- Indexes structure for table brands
-- ----------------------------
CREATE INDEX "idx_brands_enabled" ON "public"."brands" USING btree (
  "enabled" "pg_catalog"."int2_ops" ASC NULLS LAST
);
CREATE INDEX "idx_brands_img_src" ON "public"."brands" USING btree (
  "img_src" COLLATE "pg_catalog"."default" "pg_catalog"."text_ops" ASC NULLS LAST
);
CREATE INDEX "idx_brands_name" ON "public"."brands" USING btree (
  "name" COLLATE "pg_catalog"."default" "pg_catalog"."text_ops" ASC NULLS LAST
);
CREATE INDEX "idx_brands_url" ON "public"."brands" USING btree (
  "url" COLLATE "pg_catalog"."default" "pg_catalog"."text_ops" ASC NULLS LAST
);

-- ----------------------------
-- Primary Key structure for table brands
-- ----------------------------
ALTER TABLE "public"."brands" ADD CONSTRAINT "brands_pkey" PRIMARY KEY ("id");

-- ----------------------------
-- Indexes structure for table cache
-- ----------------------------
CREATE INDEX "idx_expire" ON "public"."cache" USING btree (
  "expire" "pg_catalog"."int4_ops" ASC NULLS LAST
);

-- ----------------------------
-- Primary Key structure for table cache
-- ----------------------------
ALTER TABLE "public"."cache" ADD CONSTRAINT "cache_pkey" PRIMARY KEY ("id");

-- ----------------------------
-- Indexes structure for table cart
-- ----------------------------
CREATE INDEX "cart_uid" ON "public"."cart" USING btree (
  "uid" "pg_catalog"."int4_ops" ASC NULLS LAST
);
CREATE INDEX "idx_cart_date" ON "public"."cart" USING btree (
  "date" "pg_catalog"."timestamptz_ops" ASC NULLS LAST
);
CREATE INDEX "idx_cart_iid" ON "public"."cart" USING btree (
  "iid" COLLATE "pg_catalog"."default" "pg_catalog"."text_ops" ASC NULLS LAST
);
CREATE INDEX "idx_cart_num" ON "public"."cart" USING btree (
  "num" "pg_catalog"."int4_ops" ASC NULLS LAST
);
CREATE INDEX "idx_ds_source_cart" ON "public"."cart" USING btree (
  "ds_source" COLLATE "pg_catalog"."default" "pg_catalog"."text_ops" ASC NULLS LAST
);
CREATE INDEX "idx_guest_uid" ON "public"."cart" USING btree (
  "guest_uid" COLLATE "pg_catalog"."default" "pg_catalog"."text_ops" ASC NULLS LAST
);
CREATE INDEX "idx_input_props" ON "public"."cart" USING btree (
  "input_props" COLLATE "pg_catalog"."default" "pg_catalog"."text_ops" ASC NULLS LAST
);
CREATE INDEX "idx_order" ON "public"."cart" USING btree (
  "order" "pg_catalog"."int2_ops" ASC NULLS LAST
);
CREATE INDEX "idx_store" ON "public"."cart" USING btree (
  "store" "pg_catalog"."int2_ops" ASC NULLS LAST
);
CREATE INDEX "idx_unique" ON "public"."cart" USING btree (
  "uid" "pg_catalog"."int4_ops" ASC NULLS LAST,
  "guest_uid" COLLATE "pg_catalog"."default" "pg_catalog"."text_ops" ASC NULLS LAST,
  "ds_source" COLLATE "pg_catalog"."default" "pg_catalog"."text_ops" ASC NULLS LAST,
  "iid" COLLATE "pg_catalog"."default" "pg_catalog"."text_ops" ASC NULLS LAST,
  "input_props" COLLATE "pg_catalog"."default" "pg_catalog"."text_ops" ASC NULLS LAST
);

-- ----------------------------
-- Uniques structure for table cart
-- ----------------------------
ALTER TABLE "public"."cart" ADD CONSTRAINT "cart_constr" UNIQUE ("uid", "guest_uid", "ds_source", "iid", "input_props");

-- ----------------------------
-- Primary Key structure for table cart
-- ----------------------------
ALTER TABLE "public"."cart" ADD CONSTRAINT "cart_pkey" PRIMARY KEY ("id");

-- ----------------------------
-- Indexes structure for table categories_ext
-- ----------------------------
CREATE INDEX "categories_cat_level" ON "public"."categories_ext" USING btree (
  "level" "pg_catalog"."int4_ops" ASC NULLS LAST
);
CREATE INDEX "categories_url" ON "public"."categories_ext" USING btree (
  "url" COLLATE "pg_catalog"."default" "pg_catalog"."text_ops" ASC NULLS LAST
);
CREATE INDEX "fk_ds_source" ON "public"."categories_ext" USING btree (
  "ds_source" COLLATE "pg_catalog"."default" "pg_catalog"."text_ops" ASC NULLS LAST
);
CREATE INDEX "idx_cat_ext_cid" ON "public"."categories_ext" USING btree (
  "cid" COLLATE "pg_catalog"."default" "pg_catalog"."text_ops" ASC NULLS LAST
);
CREATE INDEX "idx_cat_ext_cn" ON "public"."categories_ext" USING btree (
  "zh" COLLATE "pg_catalog"."default" "pg_catalog"."text_ops" ASC NULLS LAST
);
CREATE INDEX "idx_cat_ext_query" ON "public"."categories_ext" USING btree (
  "query" COLLATE "pg_catalog"."default" "pg_catalog"."text_ops" ASC NULLS LAST
);
CREATE INDEX "idx_cat_manual" ON "public"."categories_ext" USING btree (
  "manual" "pg_catalog"."int4_ops" ASC NULLS LAST
);
CREATE INDEX "idx_cat_order_in_level" ON "public"."categories_ext" USING btree (
  "order_in_level" "pg_catalog"."int4_ops" ASC NULLS LAST
);
CREATE INDEX "idx_cat_parent" ON "public"."categories_ext" USING btree (
  "parent" "pg_catalog"."int8_ops" ASC NULLS LAST
);
CREATE INDEX "idx_cat_status" ON "public"."categories_ext" USING btree (
  "status" "pg_catalog"."int2_ops" ASC NULLS LAST
);
CREATE INDEX "idx_cid_query" ON "public"."categories_ext" USING btree (
  "cid" COLLATE "pg_catalog"."default" "pg_catalog"."text_ops" ASC NULLS LAST,
  "query" COLLATE "pg_catalog"."default" "pg_catalog"."text_ops" ASC NULLS LAST
);
CREATE INDEX "idx_ft_en" ON "public"."categories_ext" USING gin (
  to_tsvector('english'::regconfig, en::text) "pg_catalog"."tsvector_ops"
);
CREATE INDEX "idx_ft_ru" ON "public"."categories_ext" USING gin (
  to_tsvector('russian'::regconfig, ru::text) "pg_catalog"."tsvector_ops"
);
CREATE INDEX "idx_ft_ruenzh" ON "public"."categories_ext" USING gin (
  to_tsvector('russian'::regconfig, (((ru::text || ' '::text) || en::text) || ' '::text) || zh::text) "pg_catalog"."tsvector_ops"
);
CREATE INDEX "idx_ft_zh" ON "public"."categories_ext" USING gin (
  to_tsvector('english'::regconfig, zh::text) "pg_catalog"."tsvector_ops"
);
CREATE INDEX "idx_id_parent" ON "public"."categories_ext" USING btree (
  "id" "pg_catalog"."int8_ops" ASC NULLS LAST,
  "parent" "pg_catalog"."int8_ops" ASC NULLS LAST
);
CREATE INDEX "idx_parent_id" ON "public"."categories_ext" USING btree (
  "parent" "pg_catalog"."int8_ops" ASC NULLS LAST,
  "id" "pg_catalog"."int8_ops" ASC NULLS LAST
);
CREATE INDEX "idx_parent_status" ON "public"."categories_ext" USING btree (
  "parent" "pg_catalog"."int8_ops" ASC NULLS LAST,
  "status" "pg_catalog"."int2_ops" ASC NULLS LAST
);
CREATE INDEX "idx_url_status" ON "public"."categories_ext" USING btree (
  "url" COLLATE "pg_catalog"."default" "pg_catalog"."text_ops" ASC NULLS LAST,
  "status" "pg_catalog"."int2_ops" ASC NULLS LAST
);

-- ----------------------------
-- Triggers structure for table categories_ext
-- ----------------------------
CREATE TRIGGER "trg_cat_ext_before_update" BEFORE UPDATE ON "public"."categories_ext"
FOR EACH ROW
EXECUTE PROCEDURE "public"."trg_cat_ext_before_update_fn"();

-- ----------------------------
-- Primary Key structure for table categories_ext
-- ----------------------------
ALTER TABLE "public"."categories_ext" ADD CONSTRAINT "categories_ext_pkey" PRIMARY KEY ("id");

-- ----------------------------
-- Indexes structure for table categories_ext_source
-- ----------------------------
CREATE INDEX "categories_cat_level_categories_ext_storage" ON "public"."categories_ext_source" USING btree (
  "level" "pg_catalog"."int4_ops" ASC NULLS LAST
);
CREATE INDEX "idx_cat_ext_cid_categories_ext_storage" ON "public"."categories_ext_source" USING btree (
  "cid" COLLATE "pg_catalog"."default" "pg_catalog"."text_ops" ASC NULLS LAST
);
CREATE INDEX "idx_cat_ext_query_categories_ext_storage" ON "public"."categories_ext_source" USING btree (
  "query" COLLATE "pg_catalog"."default" "pg_catalog"."text_ops" ASC NULLS LAST
);
CREATE INDEX "idx_cat_order_in_level_categories_ext_storage" ON "public"."categories_ext_source" USING btree (
  "order_in_level" "pg_catalog"."int4_ops" ASC NULLS LAST
);
CREATE INDEX "idx_cat_parent_categories_ext_storage" ON "public"."categories_ext_source" USING btree (
  "parent" "pg_catalog"."int8_ops" ASC NULLS LAST
);
CREATE INDEX "idx_cat_status_categories_ext_storage" ON "public"."categories_ext_source" USING btree (
  "status" "pg_catalog"."int2_ops" ASC NULLS LAST
);
CREATE INDEX "idx_ds_source_categories_ext_storage2" ON "public"."categories_ext_source" USING btree (
  "ds_source" COLLATE "pg_catalog"."default" "pg_catalog"."text_ops" ASC NULLS LAST
);
CREATE INDEX "idx_id_categories_ext_storage2" ON "public"."categories_ext_source" USING btree (
  "id" "pg_catalog"."int8_ops" ASC NULLS LAST
);

-- ----------------------------
-- Uniques structure for table categories_ext_source
-- ----------------------------
ALTER TABLE "public"."categories_ext_source" ADD CONSTRAINT "categories_ext_source_constr" UNIQUE ("id", "ds_source");

-- ----------------------------
-- Primary Key structure for table categories_ext_source
-- ----------------------------
ALTER TABLE "public"."categories_ext_source" ADD CONSTRAINT "categories_ext_source_pkey" PRIMARY KEY ("id", "ds_source");

-- ----------------------------
-- Indexes structure for table categories_ext_sources
-- ----------------------------
CREATE INDEX "idx_enabled_categories_ext_sources" ON "public"."categories_ext_sources" USING btree (
  "enabled" "pg_catalog"."int2_ops" ASC NULLS LAST
);
CREATE INDEX "idx_original_lang" ON "public"."categories_ext_sources" USING btree (
  "original_lang" COLLATE "pg_catalog"."default" "pg_catalog"."text_ops" ASC NULLS LAST
);

-- ----------------------------
-- Primary Key structure for table categories_ext_sources
-- ----------------------------
ALTER TABLE "public"."categories_ext_sources" ADD CONSTRAINT "categories_ext_sources_pkey" PRIMARY KEY ("ds_source");

-- ----------------------------
-- Indexes structure for table categories_ext_storage
-- ----------------------------
CREATE INDEX "idx_ds_source_categories_ext_storage" ON "public"."categories_ext_storage" USING btree (
  "ds_source" COLLATE "pg_catalog"."default" "pg_catalog"."text_ops" ASC NULLS LAST
);
CREATE INDEX "idx_store_date" ON "public"."categories_ext_storage" USING btree (
  "store_date" "pg_catalog"."timestamptz_ops" ASC NULLS LAST
);
CREATE INDEX "idx_store_name" ON "public"."categories_ext_storage" USING btree (
  "store_name" COLLATE "pg_catalog"."default" "pg_catalog"."text_ops" ASC NULLS LAST
);

-- ----------------------------
-- Primary Key structure for table categories_ext_storage
-- ----------------------------
ALTER TABLE "public"."categories_ext_storage" ADD CONSTRAINT "categories_ext_storage_pkey" PRIMARY KEY ("pk");

-- ----------------------------
-- Indexes structure for table categories_prices
-- ----------------------------
CREATE INDEX "categories_prices_covered" ON "public"."categories_prices" USING btree (
  "ds_source" COLLATE "pg_catalog"."default" "pg_catalog"."text_ops" ASC NULLS LAST,
  "cid" COLLATE "pg_catalog"."default" "pg_catalog"."text_ops" ASC NULLS LAST,
  "query" COLLATE "pg_catalog"."default" "pg_catalog"."text_ops" ASC NULLS LAST,
  "begin0" "pg_catalog"."numeric_ops" ASC NULLS LAST,
  "end0" "pg_catalog"."numeric_ops" ASC NULLS LAST,
  "percent0" "pg_catalog"."numeric_ops" ASC NULLS LAST,
  "begin1" "pg_catalog"."numeric_ops" ASC NULLS LAST,
  "end1" "pg_catalog"."numeric_ops" ASC NULLS LAST,
  "percent1" "pg_catalog"."numeric_ops" ASC NULLS LAST,
  "begin2" "pg_catalog"."numeric_ops" ASC NULLS LAST,
  "end2" "pg_catalog"."numeric_ops" ASC NULLS LAST,
  "percent2" "pg_catalog"."numeric_ops" ASC NULLS LAST,
  "begin3" "pg_catalog"."numeric_ops" ASC NULLS LAST,
  "end3" "pg_catalog"."numeric_ops" ASC NULLS LAST,
  "percent3" "pg_catalog"."numeric_ops" ASC NULLS LAST,
  "begin4" "pg_catalog"."numeric_ops" ASC NULLS LAST,
  "end4" "pg_catalog"."numeric_ops" ASC NULLS LAST,
  "percent4" "pg_catalog"."numeric_ops" ASC NULLS LAST,
  "date" "pg_catalog"."timestamptz_ops" ASC NULLS LAST
);
CREATE INDEX "categories_prices_search" ON "public"."categories_prices" USING btree (
  "ds_source" COLLATE "pg_catalog"."default" "pg_catalog"."text_ops" ASC NULLS LAST,
  "cid" COLLATE "pg_catalog"."default" "pg_catalog"."text_ops" ASC NULLS LAST,
  "query" COLLATE "pg_catalog"."default" "pg_catalog"."text_ops" ASC NULLS LAST
);

-- ----------------------------
-- Uniques structure for table categories_prices
-- ----------------------------
ALTER TABLE "public"."categories_prices" ADD CONSTRAINT "categories_prices_constr" UNIQUE ("ds_source", "cid", "query");

-- ----------------------------
-- Primary Key structure for table categories_prices
-- ----------------------------
ALTER TABLE "public"."categories_prices" ADD CONSTRAINT "categories_prices_pkey" PRIMARY KEY ("id");

-- ----------------------------
-- Indexes structure for table classifier
-- ----------------------------
CREATE INDEX "categories_cat_level_classifier" ON "public"."classifier" USING btree (
  "level" "pg_catalog"."int4_ops" ASC NULLS LAST
);
CREATE INDEX "categories_is_parent" ON "public"."classifier" USING btree (
  "is_parent" "pg_catalog"."int2_ops" ASC NULLS LAST
);
CREATE INDEX "categories_onmain" ON "public"."classifier" USING btree (
  "onmain" "pg_catalog"."int2_ops" ASC NULLS LAST
);
CREATE INDEX "categories_status" ON "public"."classifier" USING btree (
  "status" "pg_catalog"."int2_ops" ASC NULLS LAST
);
CREATE INDEX "categories_url_classifier" ON "public"."classifier" USING btree (
  "url" COLLATE "pg_catalog"."default" "pg_catalog"."text_ops" ASC NULLS LAST
);
CREATE INDEX "cid" ON "public"."classifier" USING btree (
  "ds_source" COLLATE "pg_catalog"."default" "pg_catalog"."text_ops" ASC NULLS LAST,
  "cid" COLLATE "pg_catalog"."default" "pg_catalog"."text_ops" ASC NULLS LAST
);
CREATE INDEX "idx_cat_parent_classifier" ON "public"."classifier" USING btree (
  "parent" COLLATE "pg_catalog"."default" "pg_catalog"."text_ops" ASC NULLS LAST
);
CREATE INDEX "idx_cat_status_classifier" ON "public"."classifier" USING btree (
  "status" "pg_catalog"."int2_ops" ASC NULLS LAST
);
CREATE INDEX "idx_cid" ON "public"."classifier" USING btree (
  "cid" COLLATE "pg_catalog"."default" "pg_catalog"."text_ops" ASC NULLS LAST
);
CREATE INDEX "idx_cid_en" ON "public"."classifier" USING btree (
  "cid" COLLATE "pg_catalog"."default" "pg_catalog"."text_ops" ASC NULLS LAST,
  "en" COLLATE "pg_catalog"."default" "pg_catalog"."text_ops" ASC NULLS LAST
);
CREATE INDEX "idx_cid_ru" ON "public"."classifier" USING btree (
  "cid" COLLATE "pg_catalog"."default" "pg_catalog"."text_ops" ASC NULLS LAST,
  "ru" COLLATE "pg_catalog"."default" "pg_catalog"."text_ops" ASC NULLS LAST
);
CREATE INDEX "idx_cid_ru_en" ON "public"."classifier" USING btree (
  "cid" COLLATE "pg_catalog"."default" "pg_catalog"."text_ops" ASC NULLS LAST,
  "ru" COLLATE "pg_catalog"."default" "pg_catalog"."text_ops" ASC NULLS LAST,
  "en" COLLATE "pg_catalog"."default" "pg_catalog"."text_ops" ASC NULLS LAST
);
CREATE INDEX "idx_ds_source_cid_parent" ON "public"."classifier" USING btree (
  "ds_source" COLLATE "pg_catalog"."default" "pg_catalog"."text_ops" ASC NULLS LAST,
  "cid" COLLATE "pg_catalog"."default" "pg_catalog"."text_ops" ASC NULLS LAST,
  "parent" COLLATE "pg_catalog"."default" "pg_catalog"."text_ops" ASC NULLS LAST
);
CREATE INDEX "idx_ds_source_classifier" ON "public"."classifier" USING btree (
  "ds_source" COLLATE "pg_catalog"."default" "pg_catalog"."text_ops" ASC NULLS LAST
);
CREATE INDEX "idx_ru_en" ON "public"."classifier" USING btree (
  "ru" COLLATE "pg_catalog"."default" "pg_catalog"."text_ops" ASC NULLS LAST,
  "en" COLLATE "pg_catalog"."default" "pg_catalog"."text_ops" ASC NULLS LAST
);

-- ----------------------------
-- Primary Key structure for table classifier
-- ----------------------------
ALTER TABLE "public"."classifier" ADD CONSTRAINT "classifier_pkey" PRIMARY KEY ("id");

-- ----------------------------
-- Indexes structure for table classifier_props
-- ----------------------------
CREATE INDEX "idx_cat_props1" ON "public"."classifier_props" USING btree (
  "cid" COLLATE "pg_catalog"."default" "pg_catalog"."text_ops" ASC NULLS LAST,
  "pid" "pg_catalog"."int8_ops" ASC NULLS LAST
);
CREATE INDEX "idx_cat_props2" ON "public"."classifier_props" USING btree (
  "pid" "pg_catalog"."int8_ops" ASC NULLS LAST
);
CREATE INDEX "idx_cat_props_01" ON "public"."classifier_props" USING btree (
  "hidden" "pg_catalog"."int2_ops" ASC NULLS LAST
);
CREATE INDEX "idx_cat_props_02" ON "public"."classifier_props" USING btree (
  "is_sale_prop" "pg_catalog"."int2_ops" ASC NULLS LAST
);
CREATE INDEX "idx_cat_props_03" ON "public"."classifier_props" USING btree (
  "is_input_prop" "pg_catalog"."int2_ops" ASC NULLS LAST
);
CREATE INDEX "idx_cat_props_04" ON "public"."classifier_props" USING btree (
  "is_key_prop" "pg_catalog"."int2_ops" ASC NULLS LAST
);
CREATE INDEX "idx_cat_props_05" ON "public"."classifier_props" USING btree (
  "is_color_prop" "pg_catalog"."int2_ops" ASC NULLS LAST
);
CREATE INDEX "idx_cat_props_06" ON "public"."classifier_props" USING btree (
  "is_enum_prop" "pg_catalog"."int2_ops" ASC NULLS LAST
);
CREATE INDEX "idx_cat_props_07" ON "public"."classifier_props" USING btree (
  "is_item_prop" "pg_catalog"."int2_ops" ASC NULLS LAST
);
CREATE INDEX "idx_cat_props_08" ON "public"."classifier_props" USING btree (
  "must" "pg_catalog"."int2_ops" ASC NULLS LAST
);
CREATE INDEX "idx_cat_props_09" ON "public"."classifier_props" USING btree (
  "multi" "pg_catalog"."int2_ops" ASC NULLS LAST
);
CREATE INDEX "idx_cat_props_10" ON "public"."classifier_props" USING btree (
  "status" "pg_catalog"."int2_ops" ASC NULLS LAST
);

-- ----------------------------
-- Primary Key structure for table classifier_props
-- ----------------------------
ALTER TABLE "public"."classifier_props" ADD CONSTRAINT "classifier_props_pkey" PRIMARY KEY ("id");

-- ----------------------------
-- Indexes structure for table classifier_props_vals
-- ----------------------------
CREATE INDEX "idx_cat_props_vals1" ON "public"."classifier_props_vals" USING btree (
  "cid" COLLATE "pg_catalog"."default" "pg_catalog"."text_ops" ASC NULLS LAST,
  "pid" "pg_catalog"."int8_ops" ASC NULLS LAST,
  "vid" "pg_catalog"."int8_ops" ASC NULLS LAST
);
CREATE INDEX "idx_cat_props_vals2" ON "public"."classifier_props_vals" USING btree (
  "pid" "pg_catalog"."int8_ops" ASC NULLS LAST,
  "vid" "pg_catalog"."int8_ops" ASC NULLS LAST
);
CREATE INDEX "idx_cat_props_vals3" ON "public"."classifier_props_vals" USING btree (
  "zh" COLLATE "pg_catalog"."default" "pg_catalog"."text_ops" ASC NULLS LAST
);
CREATE INDEX "idx_cat_props_vals4" ON "public"."classifier_props_vals" USING btree (
  "ru" COLLATE "pg_catalog"."default" "pg_catalog"."text_ops" ASC NULLS LAST
);
CREATE INDEX "idx_cat_props_vals5" ON "public"."classifier_props_vals" USING btree (
  "en" COLLATE "pg_catalog"."default" "pg_catalog"."text_ops" ASC NULLS LAST
);

-- ----------------------------
-- Primary Key structure for table classifier_props_vals
-- ----------------------------
ALTER TABLE "public"."classifier_props_vals" ADD CONSTRAINT "classifier_props_vals_pkey" PRIMARY KEY ("id");

-- ----------------------------
-- Indexes structure for table cms_content_history
-- ----------------------------
CREATE INDEX "idx_content_id" ON "public"."cms_content_history" USING btree (
  "content_id" COLLATE "pg_catalog"."default" "pg_catalog"."text_ops" ASC NULLS LAST
);
CREATE INDEX "idx_date_cms_content_history" ON "public"."cms_content_history" USING btree (
  "date" "pg_catalog"."timestamptz_ops" ASC NULLS LAST
);
CREATE INDEX "idx_lang" ON "public"."cms_content_history" USING btree (
  "lang" COLLATE "pg_catalog"."default" "pg_catalog"."text_ops" ASC NULLS LAST
);
CREATE INDEX "idx_table_name" ON "public"."cms_content_history" USING btree (
  "table_name" COLLATE "pg_catalog"."default" "pg_catalog"."text_ops" ASC NULLS LAST
);

-- ----------------------------
-- Primary Key structure for table cms_content_history
-- ----------------------------
ALTER TABLE "public"."cms_content_history" ADD CONSTRAINT "cms_content_history_pkey" PRIMARY KEY ("id");

-- ----------------------------
-- Indexes structure for table cms_custom_content
-- ----------------------------
CREATE INDEX "idx_cont_lang_enabled" ON "public"."cms_custom_content" USING btree (
  "content_id" COLLATE "pg_catalog"."default" "pg_catalog"."text_ops" ASC NULLS LAST,
  "lang" COLLATE "pg_catalog"."default" "pg_catalog"."text_ops" ASC NULLS LAST,
  "enabled" "pg_catalog"."int2_ops" ASC NULLS LAST
);
CREATE INDEX "idx_content_id_ lang" ON "public"."cms_custom_content" USING btree (
  "content_id" COLLATE "pg_catalog"."default" "pg_catalog"."text_ops" ASC NULLS LAST,
  "lang" COLLATE "pg_catalog"."default" "pg_catalog"."text_ops" ASC NULLS LAST
);
CREATE INDEX "idx_content_id_cms_custom_content" ON "public"."cms_custom_content" USING btree (
  "content_id" COLLATE "pg_catalog"."default" "pg_catalog"."text_ops" ASC NULLS LAST
);

-- ----------------------------
-- Triggers structure for table cms_custom_content
-- ----------------------------
CREATE TRIGGER "trg_custom_content_history" BEFORE UPDATE ON "public"."cms_custom_content"
FOR EACH ROW
EXECUTE PROCEDURE "public"."trg_custom_content_history_fn"();

-- ----------------------------
-- Primary Key structure for table cms_custom_content
-- ----------------------------
ALTER TABLE "public"."cms_custom_content" ADD CONSTRAINT "cms_custom_content_pkey" PRIMARY KEY ("id");

-- ----------------------------
-- Indexes structure for table cms_email_events
-- ----------------------------
CREATE INDEX "idx_action" ON "public"."cms_email_events" USING btree (
  "action" COLLATE "pg_catalog"."default" "pg_catalog"."text_ops" ASC NULLS LAST
);
CREATE INDEX "idx_class" ON "public"."cms_email_events" USING btree (
  "class" COLLATE "pg_catalog"."default" "pg_catalog"."text_ops" ASC NULLS LAST
);
CREATE INDEX "idx_mail_event_enabled" ON "public"."cms_email_events" USING btree (
  "enabled" "pg_catalog"."int4_ops" ASC NULLS LAST
);
CREATE INDEX "idx_regilar" ON "public"."cms_email_events" USING btree (
  "regular" "pg_catalog"."int8_ops" ASC NULLS LAST
);

-- ----------------------------
-- Primary Key structure for table cms_email_events
-- ----------------------------
ALTER TABLE "public"."cms_email_events" ADD CONSTRAINT "cms_email_events_pkey" PRIMARY KEY ("id");

-- ----------------------------
-- Indexes structure for table cms_email_unsubscribe
-- ----------------------------
CREATE INDEX "idx_date_from" ON "public"."cms_email_unsubscribe" USING btree (
  "date_from" "pg_catalog"."timestamptz_ops" ASC NULLS LAST
);

-- ----------------------------
-- Uniques structure for table cms_email_unsubscribe
-- ----------------------------
ALTER TABLE "public"."cms_email_unsubscribe" ADD CONSTRAINT "cms_email_unsubscribe_constr" UNIQUE ("uid", "event_id");

-- ----------------------------
-- Primary Key structure for table cms_email_unsubscribe
-- ----------------------------
ALTER TABLE "public"."cms_email_unsubscribe" ADD CONSTRAINT "cms_email_unsubscribe_pkey" PRIMARY KEY ("uid", "event_id");

-- ----------------------------
-- Indexes structure for table cms_knowledge_base
-- ----------------------------
CREATE INDEX "idx_key" ON "public"."cms_knowledge_base" USING gin (
  to_tsvector('russian'::regconfig, key) "pg_catalog"."tsvector_ops"
);
CREATE INDEX "idx_lang_cms_knowledge_base" ON "public"."cms_knowledge_base" USING btree (
  "lang" COLLATE "pg_catalog"."default" "pg_catalog"."bpchar_ops" ASC NULLS LAST
);
CREATE INDEX "idx_search" ON "public"."cms_knowledge_base" USING gin (
  to_tsvector('russian'::regconfig, search) "pg_catalog"."tsvector_ops"
);
CREATE INDEX "idx_tag" ON "public"."cms_knowledge_base" USING btree (
  "tag" COLLATE "pg_catalog"."default" "pg_catalog"."text_ops" ASC NULLS LAST
);

-- ----------------------------
-- Triggers structure for table cms_knowledge_base
-- ----------------------------
CREATE TRIGGER "trg_cms_knowledge_base" BEFORE INSERT OR UPDATE ON "public"."cms_knowledge_base"
FOR EACH ROW
EXECUTE PROCEDURE "public"."trg_cms_knowledge_base_fn"();

-- ----------------------------
-- Primary Key structure for table cms_knowledge_base
-- ----------------------------
ALTER TABLE "public"."cms_knowledge_base" ADD CONSTRAINT "cms_knowledge_base_pkey" PRIMARY KEY ("id");

-- ----------------------------
-- Indexes structure for table cms_knowledge_base_img
-- ----------------------------
CREATE INDEX "idx_en" ON "public"."cms_knowledge_base_img" USING btree (
  "en" COLLATE "pg_catalog"."default" "pg_catalog"."text_ops" ASC NULLS LAST
);
CREATE INDEX "idx_en_ft" ON "public"."cms_knowledge_base_img" USING gin (
  to_tsvector('english'::regconfig, en) "pg_catalog"."tsvector_ops"
);
CREATE INDEX "idx_enabled_cms_knowledge_base_img" ON "public"."cms_knowledge_base_img" USING btree (
  "enabled" "pg_catalog"."int2_ops" ASC NULLS LAST
);
CREATE INDEX "idx_filename" ON "public"."cms_knowledge_base_img" USING btree (
  "filename" COLLATE "pg_catalog"."default" "pg_catalog"."text_ops" ASC NULLS LAST
);
CREATE INDEX "idx_path" ON "public"."cms_knowledge_base_img" USING btree (
  "path" COLLATE "pg_catalog"."default" "pg_catalog"."text_ops" ASC NULLS LAST
);
CREATE INDEX "idx_path_filename" ON "public"."cms_knowledge_base_img" USING btree (
  "path" COLLATE "pg_catalog"."default" "pg_catalog"."text_ops" ASC NULLS LAST,
  "filename" COLLATE "pg_catalog"."default" "pg_catalog"."text_ops" ASC NULLS LAST
);
CREATE INDEX "idx_path_ft" ON "public"."cms_knowledge_base_img" USING gin (
  to_tsvector('english'::regconfig, path::text) "pg_catalog"."tsvector_ops"
);
CREATE INDEX "idx_ru" ON "public"."cms_knowledge_base_img" USING btree (
  "ru" COLLATE "pg_catalog"."default" "pg_catalog"."text_ops" ASC NULLS LAST
);
CREATE INDEX "idx_ru_ft" ON "public"."cms_knowledge_base_img" USING gin (
  to_tsvector('russian'::regconfig, ru) "pg_catalog"."tsvector_ops"
);
CREATE INDEX "idx_zh" ON "public"."cms_knowledge_base_img" USING btree (
  "zh" COLLATE "pg_catalog"."default" "pg_catalog"."text_ops" ASC NULLS LAST
);
CREATE INDEX "idx_zh_ft" ON "public"."cms_knowledge_base_img" USING gin (
  to_tsvector('english'::regconfig, zh) "pg_catalog"."tsvector_ops"
);

-- ----------------------------
-- Primary Key structure for table cms_knowledge_base_img
-- ----------------------------
ALTER TABLE "public"."cms_knowledge_base_img" ADD CONSTRAINT "cms_knowledge_base_img_pkey" PRIMARY KEY ("id");

-- ----------------------------
-- Indexes structure for table cms_loaded
-- ----------------------------
CREATE INDEX "idx_page_id" ON "public"."cms_loaded" USING btree (
  "page_id" COLLATE "pg_catalog"."default" "pg_catalog"."text_ops" ASC NULLS LAST
);

-- ----------------------------
-- Primary Key structure for table cms_loaded
-- ----------------------------
ALTER TABLE "public"."cms_loaded" ADD CONSTRAINT "cms_loaded_pkey" PRIMARY KEY ("id");

-- ----------------------------
-- Indexes structure for table cms_menus
-- ----------------------------
CREATE INDEX "idx_enabled_cms_menus" ON "public"."cms_menus" USING btree (
  "enabled" "pg_catalog"."int2_ops" ASC NULLS LAST
);
CREATE INDEX "idx_menu_id" ON "public"."cms_menus" USING btree (
  "menu_id" COLLATE "pg_catalog"."default" "pg_catalog"."text_ops" ASC NULLS LAST
);
CREATE INDEX "idx_seo" ON "public"."cms_menus" USING btree (
  "SEO" "pg_catalog"."int2_ops" ASC NULLS LAST
);

-- ----------------------------
-- Triggers structure for table cms_menus
-- ----------------------------
CREATE TRIGGER "trg_menus_history" BEFORE UPDATE ON "public"."cms_menus"
FOR EACH ROW
EXECUTE PROCEDURE "public"."trg_menus_history_fn"();

-- ----------------------------
-- Primary Key structure for table cms_menus
-- ----------------------------
ALTER TABLE "public"."cms_menus" ADD CONSTRAINT "cms_menus_pkey" PRIMARY KEY ("id");

-- ----------------------------
-- Indexes structure for table cms_metatags
-- ----------------------------
CREATE INDEX "idx_uniquekeys" ON "public"."cms_metatags" USING btree (
  "tag" COLLATE "pg_catalog"."default" "pg_catalog"."text_ops" ASC NULLS LAST,
  "key" COLLATE "pg_catalog"."default" "pg_catalog"."text_ops" ASC NULLS LAST,
  "lang" COLLATE "pg_catalog"."default" "pg_catalog"."bpchar_ops" ASC NULLS LAST
);

-- ----------------------------
-- Uniques structure for table cms_metatags
-- ----------------------------
ALTER TABLE "public"."cms_metatags" ADD CONSTRAINT "idx_uniquekeys_constrain" UNIQUE ("tag", "key", "lang");

-- ----------------------------
-- Primary Key structure for table cms_metatags
-- ----------------------------
ALTER TABLE "public"."cms_metatags" ADD CONSTRAINT "cms_metatags_pkey" PRIMARY KEY ("id");

-- ----------------------------
-- Indexes structure for table cms_pages
-- ----------------------------
CREATE INDEX "cms_pages_page_group_idx" ON "public"."cms_pages" USING btree (
  "page_group" COLLATE "pg_catalog"."default" "pg_catalog"."text_ops" ASC NULLS LAST
);
CREATE INDEX "idx_enabled_cms_pages" ON "public"."cms_pages" USING btree (
  "enabled" "pg_catalog"."int2_ops" ASC NULLS LAST
);
CREATE INDEX "idx_order_in_level" ON "public"."cms_pages" USING btree (
  "order_in_level" "pg_catalog"."int4_ops" ASC NULLS LAST
);
CREATE INDEX "idx_page_id_cms_pages" ON "public"."cms_pages" USING btree (
  "page_id" COLLATE "pg_catalog"."default" "pg_catalog"."text_ops" ASC NULLS LAST
);
CREATE INDEX "idx_parent" ON "public"."cms_pages" USING btree (
  "parent" "pg_catalog"."int4_ops" ASC NULLS LAST
);
CREATE INDEX "idx_seo_cms_pages" ON "public"."cms_pages" USING btree (
  "SEO" "pg_catalog"."int2_ops" ASC NULLS LAST
);
CREATE INDEX "idx_url" ON "public"."cms_pages" USING btree (
  "url" COLLATE "pg_catalog"."default" "pg_catalog"."text_ops" ASC NULLS LAST
);
CREATE INDEX "idx_url_enabled_seo" ON "public"."cms_pages" USING btree (
  "url" COLLATE "pg_catalog"."default" "pg_catalog"."text_ops" ASC NULLS LAST,
  "enabled" "pg_catalog"."int2_ops" ASC NULLS LAST,
  "SEO" "pg_catalog"."int2_ops" ASC NULLS LAST
);

-- ----------------------------
-- Uniques structure for table cms_pages
-- ----------------------------
ALTER TABLE "public"."cms_pages" ADD CONSTRAINT "unique_cms_pages_page_id" UNIQUE ("page_id");

-- ----------------------------
-- Primary Key structure for table cms_pages
-- ----------------------------
ALTER TABLE "public"."cms_pages" ADD CONSTRAINT "cms_pages_pkey" PRIMARY KEY ("id");

-- ----------------------------
-- Indexes structure for table cms_pages_content
-- ----------------------------
CREATE INDEX "idx_page_id_cms_pages_content" ON "public"."cms_pages_content" USING btree (
  "page_id" COLLATE "pg_catalog"."default" "pg_catalog"."text_ops" ASC NULLS LAST
);
CREATE INDEX "idx_page_id_lang" ON "public"."cms_pages_content" USING btree (
  "page_id" COLLATE "pg_catalog"."default" "pg_catalog"."text_ops" ASC NULLS LAST,
  "lang" COLLATE "pg_catalog"."default" "pg_catalog"."text_ops" ASC NULLS LAST
);

-- ----------------------------
-- Triggers structure for table cms_pages_content
-- ----------------------------
CREATE TRIGGER "trg_page_content_history" BEFORE UPDATE ON "public"."cms_pages_content"
FOR EACH ROW
EXECUTE PROCEDURE "public"."trg_page_content_history_fn"();

-- ----------------------------
-- Primary Key structure for table cms_pages_content
-- ----------------------------
ALTER TABLE "public"."cms_pages_content" ADD CONSTRAINT "cms_pages_content_pkey" PRIMARY KEY ("id");

-- ----------------------------
-- Indexes structure for table config
-- ----------------------------
CREATE UNIQUE INDEX "config_pkey" ON "public"."config" USING btree (
  "id" COLLATE "pg_catalog"."ru_RU.utf8" "pg_catalog"."text_ops" ASC NULLS LAST
);

-- ----------------------------
-- Triggers structure for table config
-- ----------------------------
CREATE TRIGGER "trg_update_currency_log" AFTER UPDATE ON "public"."config"
FOR EACH ROW
EXECUTE PROCEDURE "public"."trg_update_currency_log_fn"();

-- ----------------------------
-- Primary Key structure for table config
-- ----------------------------
ALTER TABLE "public"."config" ADD CONSTRAINT "config_pkey" PRIMARY KEY ("id");

-- ----------------------------
-- Indexes structure for table currency_log
-- ----------------------------
CREATE INDEX "idx_currency" ON "public"."currency_log" USING btree (
  "currency" COLLATE "pg_catalog"."default" "pg_catalog"."text_ops" ASC NULLS LAST
);
CREATE INDEX "idx_date_currency_log" ON "public"."currency_log" USING btree (
  "date" "pg_catalog"."timestamptz_ops" ASC NULLS LAST
);

-- ----------------------------
-- Primary Key structure for table currency_log
-- ----------------------------
ALTER TABLE "public"."currency_log" ADD CONSTRAINT "currency_log_pkey" PRIMARY KEY ("id");

-- ----------------------------
-- Primary Key structure for table debug_log
-- ----------------------------
ALTER TABLE "public"."debug_log" ADD CONSTRAINT "debug_log_pkey" PRIMARY KEY ("id");

-- ----------------------------
-- Indexes structure for table deliveries
-- ----------------------------
CREATE INDEX "idx_delivery_id" ON "public"."deliveries" USING btree (
  "delivery_id" COLLATE "pg_catalog"."default" "pg_catalog"."text_ops" ASC NULLS LAST
);
CREATE INDEX "idx_enabled_deliveries" ON "public"."deliveries" USING btree (
  "enabled" "pg_catalog"."int2_ops" ASC NULLS LAST
);
CREATE INDEX "idx_enabled_min_max" ON "public"."deliveries" USING btree (
  "enabled" "pg_catalog"."int2_ops" ASC NULLS LAST,
  "min_weight" "pg_catalog"."numeric_ops" ASC NULLS LAST,
  "max_weight" "pg_catalog"."numeric_ops" ASC NULLS LAST
);
CREATE INDEX "idx_group" ON "public"."deliveries" USING btree (
  "group" COLLATE "pg_catalog"."default" "pg_catalog"."text_ops" ASC NULLS LAST
);
CREATE INDEX "idx_max_weight" ON "public"."deliveries" USING btree (
  "max_weight" "pg_catalog"."numeric_ops" ASC NULLS LAST
);
CREATE INDEX "idx_min_weight" ON "public"."deliveries" USING btree (
  "min_weight" "pg_catalog"."numeric_ops" ASC NULLS LAST
);

-- ----------------------------
-- Primary Key structure for table deliveries
-- ----------------------------
ALTER TABLE "public"."deliveries" ADD CONSTRAINT "deliveries_pkey" PRIMARY KEY ("id");

-- ----------------------------
-- Indexes structure for table dic_custom
-- ----------------------------
CREATE INDEX "dic_custom_val_group_idx" ON "public"."dic_custom" USING btree (
  "val_group" COLLATE "pg_catalog"."default" "pg_catalog"."text_ops" ASC NULLS LAST
);
CREATE INDEX "dic_custom_val_name_idx" ON "public"."dic_custom" USING btree (
  "val_name" COLLATE "pg_catalog"."default" "pg_catalog"."text_ops" ASC NULLS LAST
);

-- ----------------------------
-- Primary Key structure for table dic_custom
-- ----------------------------
ALTER TABLE "public"."dic_custom" ADD CONSTRAINT "dic_custom_pkey" PRIMARY KEY ("val_id");

-- ----------------------------
-- Indexes structure for table events
-- ----------------------------
CREATE INDEX "events_enabled" ON "public"."events" USING btree (
  "enabled" "pg_catalog"."int4_ops" ASC NULLS LAST
);
CREATE INDEX "events_name" ON "public"."events" USING btree (
  "event_name" COLLATE "pg_catalog"."default" "pg_catalog"."text_ops" ASC NULLS LAST
);
CREATE INDEX "idx_event_name_enabled" ON "public"."events" USING btree (
  "event_name" COLLATE "pg_catalog"."default" "pg_catalog"."text_ops" ASC NULLS LAST,
  "enabled" "pg_catalog"."int4_ops" ASC NULLS LAST
);

-- ----------------------------
-- Uniques structure for table events
-- ----------------------------
ALTER TABLE "public"."events" ADD CONSTRAINT "unique_events_event_name" UNIQUE ("event_name");

-- ----------------------------
-- Primary Key structure for table events
-- ----------------------------
ALTER TABLE "public"."events" ADD CONSTRAINT "events_pkey" PRIMARY KEY ("id");

-- ----------------------------
-- Indexes structure for table events_log
-- ----------------------------
CREATE INDEX "eventlog__name" ON "public"."events_log" USING btree (
  "event_name" COLLATE "pg_catalog"."default" "pg_catalog"."text_ops" ASC NULLS LAST
);
CREATE INDEX "eventlog_date" ON "public"."events_log" USING btree (
  "date" "pg_catalog"."timestamptz_ops" ASC NULLS LAST
);
CREATE INDEX "eventlog_subj_id" ON "public"."events_log" USING btree (
  "subject_id" "pg_catalog"."int4_ops" ASC NULLS LAST
);
CREATE INDEX "eventlog_uid" ON "public"."events_log" USING btree (
  "uid" "pg_catalog"."int4_ops" ASC NULLS LAST
);
CREATE INDEX "idx_subj_name_date" ON "public"."events_log" USING btree (
  "subject_id" "pg_catalog"."int4_ops" ASC NULLS LAST,
  "event_name" COLLATE "pg_catalog"."default" "pg_catalog"."text_ops" ASC NULLS LAST,
  "date" "pg_catalog"."timestamptz_ops" ASC NULLS LAST
);

-- ----------------------------
-- Primary Key structure for table events_log
-- ----------------------------
ALTER TABLE "public"."events_log" ADD CONSTRAINT "events_log_pkey" PRIMARY KEY ("id");

-- ----------------------------
-- Indexes structure for table favorites
-- ----------------------------
CREATE INDEX "idx_cid_uid_copy1" ON "public"."favorites" USING btree (
  "cid" COLLATE "pg_catalog"."default" "pg_catalog"."text_ops" ASC NULLS LAST,
  "uid" "pg_catalog"."int4_ops" ASC NULLS LAST
);
CREATE INDEX "idx_ds_source_favorites_copy1" ON "public"."favorites" USING btree (
  "ds_source" COLLATE "pg_catalog"."default" "pg_catalog"."text_ops" ASC NULLS LAST
);
CREATE INDEX "idx_express_fee_copy1" ON "public"."favorites" USING btree (
  "express_fee" "pg_catalog"."numeric_ops" ASC NULLS LAST
);
CREATE INDEX "idx_favorites_cid_copy1" ON "public"."favorites" USING btree (
  "cid" COLLATE "pg_catalog"."default" "pg_catalog"."text_ops" ASC NULLS LAST
);
CREATE INDEX "idx_favorites_date_copy1" ON "public"."favorites" USING btree (
  "date" "pg_catalog"."timestamptz_ops" ASC NULLS LAST
);
CREATE INDEX "idx_favorites_price_copy1" ON "public"."favorites" USING btree (
  "price" "pg_catalog"."numeric_ops" ASC NULLS LAST
);
CREATE INDEX "idx_favorites_promotion_price_copy1" ON "public"."favorites" USING btree (
  "promotion_price" "pg_catalog"."numeric_ops" ASC NULLS LAST
);
CREATE INDEX "idx_favorites_uid_copy1" ON "public"."favorites" USING btree (
  "uid" "pg_catalog"."int4_ops" ASC NULLS LAST
);
CREATE INDEX "idx_iid_prices_copy1" ON "public"."favorites" USING btree (
  "num_iid" COLLATE "pg_catalog"."default" "pg_catalog"."text_ops" ASC NULLS LAST,
  "express_fee" "pg_catalog"."numeric_ops" ASC NULLS LAST,
  "price" "pg_catalog"."numeric_ops" ASC NULLS LAST,
  "promotion_price" "pg_catalog"."numeric_ops" ASC NULLS LAST
);
CREATE INDEX "idx_uid_numid_favs_unique_copy1" ON "public"."favorites" USING btree (
  "uid" "pg_catalog"."int4_ops" ASC NULLS LAST,
  "ds_source" COLLATE "pg_catalog"."default" "pg_catalog"."text_ops" ASC NULLS LAST,
  "num_iid" COLLATE "pg_catalog"."default" "pg_catalog"."text_ops" ASC NULLS LAST
);

-- ----------------------------
-- Uniques structure for table favorites
-- ----------------------------
ALTER TABLE "public"."favorites" ADD CONSTRAINT "favorites_constr" UNIQUE ("uid", "ds_source", "num_iid");

-- ----------------------------
-- Primary Key structure for table favorites
-- ----------------------------
ALTER TABLE "public"."favorites" ADD CONSTRAINT "favorites_copy1_pkey" PRIMARY KEY ("id", "uid");

-- ----------------------------
-- Indexes structure for table featured
-- ----------------------------
CREATE INDEX "idx_log_items_request_cid" ON "public"."featured" USING btree (
  "cid" COLLATE "pg_catalog"."default" "pg_catalog"."text_ops" ASC NULLS LAST
);
CREATE INDEX "idx_log_items_request_date" ON "public"."featured" USING btree (
  "date" "pg_catalog"."timestamptz_ops" ASC NULLS LAST
);
CREATE INDEX "idx_log_items_request_price" ON "public"."featured" USING btree (
  "price" "pg_catalog"."numeric_ops" ASC NULLS LAST
);
CREATE INDEX "idx_log_items_request_promotion_price" ON "public"."featured" USING btree (
  "promotion_price" "pg_catalog"."numeric_ops" ASC NULLS LAST
);

-- ----------------------------
-- Uniques structure for table featured
-- ----------------------------
ALTER TABLE "public"."featured" ADD CONSTRAINT "featured_constr" UNIQUE ("num_iid", "ds_source");

-- ----------------------------
-- Primary Key structure for table featured
-- ----------------------------
ALTER TABLE "public"."featured" ADD CONSTRAINT "featured_pkey" PRIMARY KEY ("num_iid", "ds_source");

-- ----------------------------
-- Indexes structure for table formulas
-- ----------------------------
CREATE INDEX "idx_formula_id" ON "public"."formulas" USING btree (
  "formula_id" COLLATE "pg_catalog"."default" "pg_catalog"."text_ops" ASC NULLS LAST
);

-- ----------------------------
-- Primary Key structure for table formulas
-- ----------------------------
ALTER TABLE "public"."formulas" ADD CONSTRAINT "formulas_pkey" PRIMARY KEY ("id");

-- ----------------------------
-- Indexes structure for table fulltext_stem
-- ----------------------------
CREATE INDEX "idx_result_fulltext_stem" ON "public"."fulltext_stem" USING btree (
  "result" COLLATE "pg_catalog"."default" "pg_catalog"."text_ops" ASC NULLS LAST
);
CREATE INDEX "idx_src" ON "public"."fulltext_stem" USING btree (
  "src" COLLATE "pg_catalog"."default" "pg_catalog"."text_ops" ASC NULLS LAST
);

-- ----------------------------
-- Primary Key structure for table fulltext_stem
-- ----------------------------
ALTER TABLE "public"."fulltext_stem" ADD CONSTRAINT "fulltext_stem_pkey" PRIMARY KEY ("id");

-- ----------------------------
-- Indexes structure for table geo_cities
-- ----------------------------
CREATE INDEX "idx_city" ON "public"."geo_cities" USING btree (
  "city" COLLATE "pg_catalog"."default" "pg_catalog"."text_ops" ASC NULLS LAST
);
CREATE INDEX "idx_country" ON "public"."geo_cities" USING btree (
  "country" COLLATE "pg_catalog"."default" "pg_catalog"."bpchar_ops" ASC NULLS LAST
);
CREATE INDEX "idx_population" ON "public"."geo_cities" USING btree (
  "population" "pg_catalog"."int8_ops" ASC NULLS LAST
);
CREATE INDEX "idx_region" ON "public"."geo_cities" USING btree (
  "region" COLLATE "pg_catalog"."default" "pg_catalog"."text_ops" ASC NULLS LAST
);
CREATE INDEX "idx_state" ON "public"."geo_cities" USING btree (
  "state" COLLATE "pg_catalog"."default" "pg_catalog"."text_ops" ASC NULLS LAST
);

-- ----------------------------
-- Primary Key structure for table geo_cities
-- ----------------------------
ALTER TABLE "public"."geo_cities" ADD CONSTRAINT "geo_cities_pkey" PRIMARY KEY ("id");

-- ----------------------------
-- Indexes structure for table img_hashes
-- ----------------------------
CREATE INDEX "idx_img_hashes_created" ON "public"."img_hashes" USING btree (
  "created" "pg_catalog"."timestamptz_ops" ASC NULLS LAST
);
CREATE INDEX "idx_img_hashes_hash" ON "public"."img_hashes" USING btree (
  "hash" COLLATE "pg_catalog"."default" "pg_catalog"."text_ops" ASC NULLS LAST
);
CREATE INDEX "idx_img_hashes_last_access" ON "public"."img_hashes" USING btree (
  "last_access" "pg_catalog"."timestamptz_ops" ASC NULLS LAST
);

-- ----------------------------
-- Uniques structure for table img_hashes
-- ----------------------------
ALTER TABLE "public"."img_hashes" ADD CONSTRAINT "img_hashes_constr" UNIQUE ("hash");

-- ----------------------------
-- Primary Key structure for table img_hashes
-- ----------------------------
ALTER TABLE "public"."img_hashes" ADD CONSTRAINT "img_hashes_pkey" PRIMARY KEY ("id");

-- ----------------------------
-- Indexes structure for table local_items
-- ----------------------------
CREATE INDEX "idx_cid_local_items" ON "public"."local_items" USING btree (
  "cid" COLLATE "pg_catalog"."default" "pg_catalog"."text_ops" ASC NULLS LAST
);
CREATE INDEX "idx_ds_source_item_id_uid" ON "public"."local_items" USING btree (
  "ds_source" COLLATE "pg_catalog"."default" "pg_catalog"."text_ops" ASC NULLS LAST,
  "item_id" COLLATE "pg_catalog"."default" "pg_catalog"."text_ops" ASC NULLS LAST,
  "uid" "pg_catalog"."int4_ops" ASC NULLS LAST
);
CREATE INDEX "idx_ds_source_local_items" ON "public"."local_items" USING btree (
  "ds_source" COLLATE "pg_catalog"."default" "pg_catalog"."text_ops" ASC NULLS LAST
);
CREATE INDEX "idx_in_stock" ON "public"."local_items" USING btree (
  "in_stock" "pg_catalog"."int4_ops" ASC NULLS LAST
);
CREATE INDEX "idx_item_id_local_items" ON "public"."local_items" USING btree (
  "item_id" COLLATE "pg_catalog"."default" "pg_catalog"."text_ops" ASC NULLS LAST
);
CREATE INDEX "idx_price_delivery" ON "public"."local_items" USING btree (
  "price_delivery" "pg_catalog"."numeric_ops" ASC NULLS LAST
);
CREATE INDEX "idx_price_local_items" ON "public"."local_items" USING btree (
  "price" "pg_catalog"."numeric_ops" ASC NULLS LAST
);
CREATE INDEX "idx_price_promo" ON "public"."local_items" USING btree (
  "price_promo" "pg_catalog"."numeric_ops" ASC NULLS LAST
);
CREATE INDEX "idx_queried" ON "public"."local_items" USING btree (
  "queried" "pg_catalog"."int4_ops" ASC NULLS LAST
);
CREATE INDEX "idx_seller_id" ON "public"."local_items" USING btree (
  "seller_id" "pg_catalog"."int8_ops" ASC NULLS LAST
);
CREATE INDEX "idx_seller_nick" ON "public"."local_items" USING btree (
  "seller_nick" COLLATE "pg_catalog"."default" "pg_catalog"."text_ops" ASC NULLS LAST
);
CREATE INDEX "idx_sold_items" ON "public"."local_items" USING btree (
  "sold_items" "pg_catalog"."int4_ops" ASC NULLS LAST
);
CREATE INDEX "idx_uid_local_items" ON "public"."local_items" USING btree (
  "uid" "pg_catalog"."int4_ops" ASC NULLS LAST
);
CREATE INDEX "idx_updated" ON "public"."local_items" USING btree (
  "updated" "pg_catalog"."timestamptz_ops" ASC NULLS LAST
);

-- ----------------------------
-- Uniques structure for table local_items
-- ----------------------------
ALTER TABLE "public"."local_items" ADD CONSTRAINT "local_items_constr" UNIQUE ("item_id", "uid", "ds_source");

-- ----------------------------
-- Primary Key structure for table local_items
-- ----------------------------
ALTER TABLE "public"."local_items" ADD CONSTRAINT "local_items_pkey" PRIMARY KEY ("ds_source", "item_id", "uid");

-- ----------------------------
-- Indexes structure for table local_items_attributes
-- ----------------------------
CREATE INDEX "idx_ds_source_item_id_uid_local_items_attributes" ON "public"."local_items_attributes" USING btree (
  "ds_source" COLLATE "pg_catalog"."default" "pg_catalog"."text_ops" ASC NULLS LAST,
  "item_id" COLLATE "pg_catalog"."default" "pg_catalog"."text_ops" ASC NULLS LAST,
  "uid" "pg_catalog"."int4_ops" ASC NULLS LAST
);

-- ----------------------------
-- Primary Key structure for table local_items_attributes
-- ----------------------------
ALTER TABLE "public"."local_items_attributes" ADD CONSTRAINT "local_items_attributes_pkey" PRIMARY KEY ("attribute_id", "ds_source", "item_id", "uid");

-- ----------------------------
-- Indexes structure for table local_items_pictures
-- ----------------------------
CREATE INDEX "idx_ds_source_item_id_uid_local_items_pictures" ON "public"."local_items_pictures" USING btree (
  "ds_source" COLLATE "pg_catalog"."default" "pg_catalog"."text_ops" ASC NULLS LAST,
  "item_id" COLLATE "pg_catalog"."default" "pg_catalog"."text_ops" ASC NULLS LAST,
  "uid" "pg_catalog"."int4_ops" ASC NULLS LAST
);

-- ----------------------------
-- Primary Key structure for table local_items_pictures
-- ----------------------------
ALTER TABLE "public"."local_items_pictures" ADD CONSTRAINT "local_items_pictures_pkey" PRIMARY KEY ("picture_id", "ds_source", "item_id", "uid");

-- ----------------------------
-- Indexes structure for table local_items_pids
-- ----------------------------
CREATE INDEX "idx_ds_source_item_id_uid_local_items_pids" ON "public"."local_items_pids" USING btree (
  "ds_source" COLLATE "pg_catalog"."default" "pg_catalog"."text_ops" ASC NULLS LAST,
  "item_id" COLLATE "pg_catalog"."default" "pg_catalog"."text_ops" ASC NULLS LAST,
  "uid" "pg_catalog"."int4_ops" ASC NULLS LAST
);

-- ----------------------------
-- Primary Key structure for table local_items_pids
-- ----------------------------
ALTER TABLE "public"."local_items_pids" ADD CONSTRAINT "local_items_pids_pkey" PRIMARY KEY ("pid_id", "ds_source", "item_id", "uid");

-- ----------------------------
-- Indexes structure for table local_items_pids_vids
-- ----------------------------
CREATE INDEX "idx_ds_source_item_id_uid_local_items_pids_vids" ON "public"."local_items_pids_vids" USING btree (
  "ds_source" COLLATE "pg_catalog"."default" "pg_catalog"."text_ops" ASC NULLS LAST,
  "item_id" COLLATE "pg_catalog"."default" "pg_catalog"."text_ops" ASC NULLS LAST,
  "uid" "pg_catalog"."int4_ops" ASC NULLS LAST
);
CREATE INDEX "idx_pid_id" ON "public"."local_items_pids_vids" USING btree (
  "pid_id" "pg_catalog"."int8_ops" ASC NULLS LAST
);

-- ----------------------------
-- Primary Key structure for table local_items_pids_vids
-- ----------------------------
ALTER TABLE "public"."local_items_pids_vids" ADD CONSTRAINT "local_items_pids_vids_pkey" PRIMARY KEY ("vid_id", "ds_source", "item_id", "uid");

-- ----------------------------
-- Indexes structure for table local_items_prices
-- ----------------------------
CREATE INDEX "idx_ds_source_item_id_uid_local_items_prices" ON "public"."local_items_prices" USING btree (
  "ds_source" COLLATE "pg_catalog"."default" "pg_catalog"."text_ops" ASC NULLS LAST,
  "item_id" COLLATE "pg_catalog"."default" "pg_catalog"."text_ops" ASC NULLS LAST,
  "uid" "pg_catalog"."int4_ops" ASC NULLS LAST
);

-- ----------------------------
-- Uniques structure for table local_items_prices
-- ----------------------------
ALTER TABLE "public"."local_items_prices" ADD CONSTRAINT "local_items_prices_constr" UNIQUE ("sku_id", "item_id", "ds_source", "price_type", "uid");

-- ----------------------------
-- Primary Key structure for table local_items_prices
-- ----------------------------
ALTER TABLE "public"."local_items_prices" ADD CONSTRAINT "local_items_prices_pkey" PRIMARY KEY ("ds_source", "item_id", "sku_id", "uid", "price_type");

-- ----------------------------
-- Indexes structure for table local_items_search
-- ----------------------------
CREATE INDEX "idx_ds_source_keywords_en" ON "public"."local_items_search" USING gin (
  to_tsvector('english'::regconfig, keywords) "pg_catalog"."tsvector_ops"
);
CREATE INDEX "idx_ds_source_keywords_ru" ON "public"."local_items_search" USING gin (
  to_tsvector('russian'::regconfig, keywords) "pg_catalog"."tsvector_ops"
);
CREATE INDEX "idx_ds_source_local_items_search" ON "public"."local_items_search" USING btree (
  "ds_source" COLLATE "pg_catalog"."default" "pg_catalog"."text_ops" ASC NULLS LAST
);

-- ----------------------------
-- Uniques structure for table local_items_search
-- ----------------------------
ALTER TABLE "public"."local_items_search" ADD CONSTRAINT "local_items_search_constr" UNIQUE ("item_id", "ds_source", "uid");

-- ----------------------------
-- Primary Key structure for table local_items_search
-- ----------------------------
ALTER TABLE "public"."local_items_search" ADD CONSTRAINT "local_items_search_pkey" PRIMARY KEY ("ds_source", "item_id", "uid");

-- ----------------------------
-- Indexes structure for table local_items_skus
-- ----------------------------
CREATE INDEX "idx_ds_source_item_id_uid_local_items_skus" ON "public"."local_items_skus" USING btree (
  "ds_source" COLLATE "pg_catalog"."default" "pg_catalog"."text_ops" ASC NULLS LAST,
  "item_id" COLLATE "pg_catalog"."default" "pg_catalog"."text_ops" ASC NULLS LAST,
  "uid" "pg_catalog"."int4_ops" ASC NULLS LAST
);

-- ----------------------------
-- Primary Key structure for table local_items_skus
-- ----------------------------
ALTER TABLE "public"."local_items_skus" ADD CONSTRAINT "local_items_skus_pkey" PRIMARY KEY ("ds_source", "item_id", "sku_id", "uid");

-- ----------------------------
-- Indexes structure for table log_api_requests
-- ----------------------------
CREATE INDEX "idx_log_http_request_date" ON "public"."log_api_requests" USING btree (
  "date" "pg_catalog"."timestamptz_ops" ASC NULLS LAST
);
CREATE INDEX "idx_log_http_request_key" ON "public"."log_api_requests" USING btree (
  "key" COLLATE "pg_catalog"."default" "pg_catalog"."text_ops" ASC NULLS LAST
);
CREATE INDEX "idx_log_http_request_type" ON "public"."log_api_requests" USING btree (
  "type" COLLATE "pg_catalog"."default" "pg_catalog"."text_ops" ASC NULLS LAST
);

-- ----------------------------
-- Primary Key structure for table log_api_requests
-- ----------------------------
ALTER TABLE "public"."log_api_requests" ADD CONSTRAINT "log_api_requests_pkey" PRIMARY KEY ("id", "date");

-- ----------------------------
-- Indexes structure for table log_dsg
-- ----------------------------
CREATE INDEX "idx_date_log_dsg" ON "public"."log_dsg" USING btree (
  "date" "pg_catalog"."timestamptz_ops" ASC NULLS LAST
);
CREATE INDEX "idx_date_type" ON "public"."log_dsg" USING btree (
  "date" "pg_catalog"."timestamptz_ops" ASC NULLS LAST,
  "type" COLLATE "pg_catalog"."default" "pg_catalog"."text_ops" ASC NULLS LAST
);
CREATE INDEX "idx_ds_proxy" ON "public"."log_dsg" USING btree (
  "ds_proxy" COLLATE "pg_catalog"."default" "pg_catalog"."text_ops" ASC NULLS LAST
);
CREATE INDEX "idx_from_host" ON "public"."log_dsg" USING btree (
  "from_host" COLLATE "pg_catalog"."default" "pg_catalog"."text_ops" ASC NULLS LAST
);
CREATE INDEX "idx_from_ip" ON "public"."log_dsg" USING btree (
  "from_ip" COLLATE "pg_catalog"."default" "pg_catalog"."text_ops" ASC NULLS LAST
);
CREATE INDEX "idx_http_proxy" ON "public"."log_dsg" USING btree (
  "http_proxy" COLLATE "pg_catalog"."default" "pg_catalog"."text_ops" ASC NULLS LAST
);
CREATE INDEX "idx_result" ON "public"."log_dsg" USING btree (
  "result" COLLATE "pg_catalog"."default" "pg_catalog"."text_ops" ASC NULLS LAST
);
CREATE INDEX "idx_type" ON "public"."log_dsg" USING btree (
  "type" COLLATE "pg_catalog"."default" "pg_catalog"."text_ops" ASC NULLS LAST
);

-- ----------------------------
-- Primary Key structure for table log_dsg
-- ----------------------------
ALTER TABLE "public"."log_dsg" ADD CONSTRAINT "log_dsg_pkey" PRIMARY KEY ("id", "date_day");

-- ----------------------------
-- Primary Key structure for table log_dsg_buffer
-- ----------------------------
ALTER TABLE "public"."log_dsg_buffer" ADD CONSTRAINT "log_dsg_buffer_pkey" PRIMARY KEY ("id");

-- ----------------------------
-- Indexes structure for table log_dsg_details
-- ----------------------------
CREATE INDEX "idx_log_dsg_id" ON "public"."log_dsg_details" USING btree (
  "log_dsg_id" "pg_catalog"."int8_ops" ASC NULLS LAST
);

-- ----------------------------
-- Primary Key structure for table log_dsg_details
-- ----------------------------
ALTER TABLE "public"."log_dsg_details" ADD CONSTRAINT "log_dsg_details_pkey" PRIMARY KEY ("id");

-- ----------------------------
-- Indexes structure for table log_dsg_translator
-- ----------------------------
CREATE INDEX "idx_date_log_dsg_translator" ON "public"."log_dsg_translator" USING btree (
  "date" "pg_catalog"."timestamptz_ops" ASC NULLS LAST
);
CREATE INDEX "idx_duration" ON "public"."log_dsg_translator" USING btree (
  "duration" "pg_catalog"."numeric_ops" ASC NULLS LAST
);
CREATE INDEX "idx_from_host_log_dsg_translator" ON "public"."log_dsg_translator" USING btree (
  "from_host" COLLATE "pg_catalog"."default" "pg_catalog"."text_ops" ASC NULLS LAST
);
CREATE INDEX "idx_from_ip_log_dsg_translator" ON "public"."log_dsg_translator" USING btree (
  "from_ip" COLLATE "pg_catalog"."default" "pg_catalog"."text_ops" ASC NULLS LAST
);
CREATE INDEX "idx_length" ON "public"."log_dsg_translator" USING btree (
  "local" "pg_catalog"."int4_ops" ASC NULLS LAST
);
CREATE INDEX "idx_remote" ON "public"."log_dsg_translator" USING btree (
  "remote" "pg_catalog"."int4_ops" ASC NULLS LAST
);

-- ----------------------------
-- Primary Key structure for table log_dsg_translator
-- ----------------------------
ALTER TABLE "public"."log_dsg_translator" ADD CONSTRAINT "log_dsg_translator_pkey" PRIMARY KEY ("id", "from_ip");

-- ----------------------------
-- Indexes structure for table log_http_requests
-- ----------------------------
CREATE INDEX "idx_duration_log_http_requests" ON "public"."log_http_requests" USING btree (
  "duration" "pg_catalog"."int2_ops" ASC NULLS LAST
);
CREATE INDEX "idx_ft_referer" ON "public"."log_http_requests" USING gin (
  to_tsvector('english'::regconfig, referer) "pg_catalog"."tsvector_ops"
);
CREATE INDEX "idx_ft_url" ON "public"."log_http_requests" USING gin (
  to_tsvector('english'::regconfig, url) "pg_catalog"."tsvector_ops"
);
CREATE INDEX "idx_ft_useragent" ON "public"."log_http_requests" USING gin (
  to_tsvector('english'::regconfig, useragent) "pg_catalog"."tsvector_ops"
);
CREATE INDEX "idx_log_http_request_date_log_http_requests" ON "public"."log_http_requests" USING btree (
  "date" "pg_catalog"."timestamptz_ops" ASC NULLS LAST
);
CREATE INDEX "idx_log_http_request_ip" ON "public"."log_http_requests" USING btree (
  "ip" COLLATE "pg_catalog"."default" "pg_catalog"."text_ops" ASC NULLS LAST
);
CREATE INDEX "idx_log_http_request_session" ON "public"."log_http_requests" USING btree (
  "session" COLLATE "pg_catalog"."default" "pg_catalog"."text_ops" ASC NULLS LAST
);
CREATE INDEX "idx_log_http_request_uid" ON "public"."log_http_requests" USING btree (
  "uid" "pg_catalog"."int4_ops" ASC NULLS LAST
);

-- ----------------------------
-- Primary Key structure for table log_http_requests
-- ----------------------------
ALTER TABLE "public"."log_http_requests" ADD CONSTRAINT "log_http_requests_pkey" PRIMARY KEY ("id");

-- ----------------------------
-- Indexes structure for table log_iot
-- ----------------------------
CREATE INDEX "log_iot_datetime_idx" ON "public"."log_iot" USING btree (
  "datetime" "pg_catalog"."timestamptz_ops" ASC NULLS LAST
);

-- ----------------------------
-- Primary Key structure for table log_iot
-- ----------------------------
ALTER TABLE "public"."log_iot" ADD CONSTRAINT "log_iot_pkey" PRIMARY KEY ("id");

-- ----------------------------
-- Indexes structure for table log_item_requests
-- ----------------------------
CREATE INDEX "idx_ds_source_log_item_requests" ON "public"."log_item_requests" USING btree (
  "ds_source" COLLATE "pg_catalog"."default" "pg_catalog"."text_ops" ASC NULLS LAST
);
CREATE INDEX "idx_ds_src_num_id" ON "public"."log_item_requests" USING btree (
  "ds_source" COLLATE "pg_catalog"."default" "pg_catalog"."text_ops" ASC NULLS LAST,
  "num_iid" COLLATE "pg_catalog"."default" "pg_catalog"."text_ops" ASC NULLS LAST,
  "cid" COLLATE "pg_catalog"."default" "pg_catalog"."text_ops" ASC NULLS LAST
);
CREATE INDEX "idx_iid_uid_cid_date" ON "public"."log_item_requests" USING btree (
  "date" "pg_catalog"."timestamptz_ops" ASC NULLS LAST,
  "ds_source" COLLATE "pg_catalog"."default" "pg_catalog"."text_ops" ASC NULLS LAST,
  "cid" COLLATE "pg_catalog"."default" "pg_catalog"."text_ops" ASC NULLS LAST,
  "uid" "pg_catalog"."int4_ops" ASC NULLS LAST,
  "num_iid" COLLATE "pg_catalog"."default" "pg_catalog"."text_ops" ASC NULLS LAST
);
CREATE INDEX "idx_log_item_req_cid_uid" ON "public"."log_item_requests" USING btree (
  "ds_source" COLLATE "pg_catalog"."default" "pg_catalog"."text_ops" ASC NULLS LAST,
  "cid" COLLATE "pg_catalog"."default" "pg_catalog"."text_ops" ASC NULLS LAST,
  "num_iid" COLLATE "pg_catalog"."default" "pg_catalog"."text_ops" ASC NULLS LAST
);
CREATE INDEX "idx_log_item_request_cid" ON "public"."log_item_requests" USING btree (
  "cid" COLLATE "pg_catalog"."default" "pg_catalog"."text_ops" ASC NULLS LAST
);
CREATE INDEX "idx_log_item_request_date" ON "public"."log_item_requests" USING btree (
  "date" "pg_catalog"."timestamptz_ops" ASC NULLS LAST
);
CREATE INDEX "idx_log_item_request_nick" ON "public"."log_item_requests" USING btree (
  "nick" COLLATE "pg_catalog"."default" "pg_catalog"."text_ops" ASC NULLS LAST
);
CREATE INDEX "idx_log_item_request_num_iid" ON "public"."log_item_requests" USING btree (
  "num_iid" COLLATE "pg_catalog"."default" "pg_catalog"."text_ops" ASC NULLS LAST
);
CREATE INDEX "idx_log_item_request_price" ON "public"."log_item_requests" USING btree (
  "price" "pg_catalog"."numeric_ops" ASC NULLS LAST
);
CREATE INDEX "idx_log_item_request_promotion_price" ON "public"."log_item_requests" USING btree (
  "promotion_price" "pg_catalog"."numeric_ops" ASC NULLS LAST
);
CREATE INDEX "idx_log_item_request_session" ON "public"."log_item_requests" USING btree (
  "session" COLLATE "pg_catalog"."default" "pg_catalog"."text_ops" ASC NULLS LAST
);
CREATE INDEX "idx_log_item_request_uid" ON "public"."log_item_requests" USING btree (
  "uid" "pg_catalog"."int4_ops" ASC NULLS LAST
);
CREATE INDEX "idx_nick_seller_rate" ON "public"."log_item_requests" USING btree (
  "nick" COLLATE "pg_catalog"."default" "pg_catalog"."text_ops" ASC NULLS LAST,
  "seller_rate" "pg_catalog"."numeric_ops" ASC NULLS LAST
);
CREATE INDEX "idx_num_iid_fee_price" ON "public"."log_item_requests" USING btree (
  "ds_source" COLLATE "pg_catalog"."default" "pg_catalog"."text_ops" ASC NULLS LAST,
  "num_iid" COLLATE "pg_catalog"."default" "pg_catalog"."text_ops" ASC NULLS LAST,
  "express_fee" "pg_catalog"."numeric_ops" ASC NULLS LAST,
  "price" "pg_catalog"."numeric_ops" ASC NULLS LAST,
  "promotion_price" "pg_catalog"."numeric_ops" ASC NULLS LAST
);

-- ----------------------------
-- Primary Key structure for table log_item_requests
-- ----------------------------
ALTER TABLE "public"."log_item_requests" ADD CONSTRAINT "log_item_requests_pkey" PRIMARY KEY ("id");

-- ----------------------------
-- Indexes structure for table log_items_requests
-- ----------------------------
CREATE INDEX "idx_cid_log_items_requests" ON "public"."log_items_requests" USING btree (
  "cid" COLLATE "pg_catalog"."default" "pg_catalog"."text_ops" ASC NULLS LAST
);
CREATE INDEX "idx_date_log_items_requests" ON "public"."log_items_requests" USING btree (
  "date" "pg_catalog"."timestamptz_ops" ASC NULLS LAST
);
CREATE INDEX "idx_nick" ON "public"."log_items_requests" USING btree (
  "nick" COLLATE "pg_catalog"."default" "pg_catalog"."text_ops" ASC NULLS LAST
);
CREATE INDEX "idx_num_iid_date" ON "public"."log_items_requests" USING btree (
  "ds_source" COLLATE "pg_catalog"."default" "pg_catalog"."text_ops" ASC NULLS LAST,
  "num_iid" COLLATE "pg_catalog"."default" "pg_catalog"."text_ops" ASC NULLS LAST,
  "date" "pg_catalog"."timestamptz_ops" ASC NULLS LAST
);
CREATE INDEX "idx_num_iid_day" ON "public"."log_items_requests" USING btree (
  "ds_source" COLLATE "pg_catalog"."default" "pg_catalog"."text_ops" ASC NULLS LAST,
  "num_iid" COLLATE "pg_catalog"."default" "pg_catalog"."text_ops" ASC NULLS LAST,
  "date_day" "pg_catalog"."int2_ops" ASC NULLS LAST
);
CREATE INDEX "idx_query" ON "public"."log_items_requests" USING btree (
  "query" COLLATE "pg_catalog"."default" "pg_catalog"."text_ops" ASC NULLS LAST
);

-- ----------------------------
-- Uniques structure for table log_items_requests
-- ----------------------------
ALTER TABLE "public"."log_items_requests" ADD CONSTRAINT "log_items_requests_constr" UNIQUE ("num_iid", "cid", "query", "date_day", "ds_source");

-- ----------------------------
-- Primary Key structure for table log_items_requests
-- ----------------------------
ALTER TABLE "public"."log_items_requests" ADD CONSTRAINT "log_items_requests_pkey" PRIMARY KEY ("num_iid", "cid", "query", "date_day", "ds_source");

-- ----------------------------
-- Indexes structure for table log_queries_requests
-- ----------------------------
CREATE INDEX "idx_cid_query_date" ON "public"."log_queries_requests" USING btree (
  "cid" COLLATE "pg_catalog"."default" "pg_catalog"."text_ops" ASC NULLS LAST,
  "query" COLLATE "pg_catalog"."default" "pg_catalog"."text_ops" ASC NULLS LAST,
  "date" "pg_catalog"."timestamptz_ops" ASC NULLS LAST
);
CREATE INDEX "idx_ds_source_log_queries_requests" ON "public"."log_queries_requests" USING btree (
  "ds_source" COLLATE "pg_catalog"."default" "pg_catalog"."text_ops" ASC NULLS LAST
);
CREATE INDEX "idx_log_queries_request_cid" ON "public"."log_queries_requests" USING btree (
  "cid" COLLATE "pg_catalog"."default" "pg_catalog"."text_ops" ASC NULLS LAST
);
CREATE INDEX "idx_log_queries_request_date" ON "public"."log_queries_requests" USING btree (
  "date" "pg_catalog"."timestamptz_ops" ASC NULLS LAST
);
CREATE INDEX "idx_log_queries_request_query" ON "public"."log_queries_requests" USING btree (
  "query" COLLATE "pg_catalog"."default" "pg_catalog"."text_ops" ASC NULLS LAST
);
CREATE INDEX "idx_log_queries_request_res_count" ON "public"."log_queries_requests" USING btree (
  "res_count" "pg_catalog"."int8_ops" ASC NULLS LAST
);
CREATE INDEX "idx_log_queries_request_session" ON "public"."log_queries_requests" USING btree (
  "session" COLLATE "pg_catalog"."default" "pg_catalog"."text_ops" ASC NULLS LAST
);
CREATE INDEX "idx_log_queries_request_uid" ON "public"."log_queries_requests" USING btree (
  "uid" "pg_catalog"."int4_ops" ASC NULLS LAST
);
CREATE INDEX "idx_log_queries_text_query_en" ON "public"."log_queries_requests" USING gin (
  to_tsvector('english'::regconfig, query::text) "pg_catalog"."tsvector_ops"
);
CREATE INDEX "idx_log_queries_text_query_ru" ON "public"."log_queries_requests" USING gin (
  to_tsvector('russian'::regconfig, query::text) "pg_catalog"."tsvector_ops"
);
CREATE INDEX "idx_query_res_count" ON "public"."log_queries_requests" USING btree (
  "query" COLLATE "pg_catalog"."default" "pg_catalog"."text_ops" ASC NULLS LAST,
  "res_count" "pg_catalog"."int8_ops" ASC NULLS LAST
);

-- ----------------------------
-- Primary Key structure for table log_queries_requests
-- ----------------------------
ALTER TABLE "public"."log_queries_requests" ADD CONSTRAINT "log_queries_requests_pkey" PRIMARY KEY ("id");

-- ----------------------------
-- Indexes structure for table log_site_errors
-- ----------------------------
CREATE INDEX "idx_log_site_errors_date" ON "public"."log_site_errors" USING btree (
  "error_date" "pg_catalog"."timestamptz_ops" ASC NULLS LAST
);
CREATE INDEX "idx_log_site_errors_err_mess" ON "public"."log_site_errors" USING btree (
  "error_message" COLLATE "pg_catalog"."default" "pg_catalog"."text_ops" ASC NULLS LAST
);
CREATE INDEX "idx_log_site_errors_label" ON "public"."log_site_errors" USING btree (
  "error_label" COLLATE "pg_catalog"."default" "pg_catalog"."text_ops" ASC NULLS LAST
);

-- ----------------------------
-- Primary Key structure for table log_site_errors
-- ----------------------------
ALTER TABLE "public"."log_site_errors" ADD CONSTRAINT "log_site_errors_pkey" PRIMARY KEY ("id");

-- ----------------------------
-- Indexes structure for table log_source_cookies
-- ----------------------------
CREATE INDEX "idx_date_log_source_cookies" ON "public"."log_source_cookies" USING hash (
  "date" "pg_catalog"."timestamptz_ops"
);
CREATE INDEX "idx_domain" ON "public"."log_source_cookies" USING hash (
  "domain" COLLATE "pg_catalog"."default" "pg_catalog"."text_ops"
);
CREATE INDEX "idx_interface" ON "public"."log_source_cookies" USING hash (
  "interface" COLLATE "pg_catalog"."default" "pg_catalog"."text_ops"
);
CREATE INDEX "idx_name_log_source_cookies" ON "public"."log_source_cookies" USING hash (
  "name" COLLATE "pg_catalog"."default" "pg_catalog"."text_ops"
);

-- ----------------------------
-- Uniques structure for table log_source_cookies
-- ----------------------------
ALTER TABLE "public"."log_source_cookies" ADD CONSTRAINT "log_source_cookies_constr" UNIQUE ("name", "domain", "interface");

-- ----------------------------
-- Primary Key structure for table log_source_cookies
-- ----------------------------
ALTER TABLE "public"."log_source_cookies" ADD CONSTRAINT "log_source_cookies_pkey" PRIMARY KEY ("name", "domain", "interface");

-- ----------------------------
-- Indexes structure for table log_translations
-- ----------------------------
CREATE INDEX "idx_date_log_translations" ON "public"."log_translations" USING btree (
  "date" "pg_catalog"."timestamptz_ops" ASC NULLS LAST
);
CREATE INDEX "idx_from" ON "public"."log_translations" USING btree (
  "from" COLLATE "pg_catalog"."default" "pg_catalog"."bpchar_ops" ASC NULLS LAST
);
CREATE INDEX "idx_host" ON "public"."log_translations" USING btree (
  "host" COLLATE "pg_catalog"."default" "pg_catalog"."text_ops" ASC NULLS LAST
);
CREATE INDEX "idx_message_id" ON "public"."log_translations" USING btree (
  "message_id" "pg_catalog"."int8_ops" ASC NULLS LAST
);
CREATE INDEX "idx_table_name_log_translations" ON "public"."log_translations" USING btree (
  "table_name" COLLATE "pg_catalog"."default" "pg_catalog"."text_ops" ASC NULLS LAST
);
CREATE INDEX "idx_to" ON "public"."log_translations" USING btree (
  "to" COLLATE "pg_catalog"."default" "pg_catalog"."bpchar_ops" ASC NULLS LAST
);
CREATE INDEX "idx_uid_log_translations" ON "public"."log_translations" USING btree (
  "uid" "pg_catalog"."int4_ops" ASC NULLS LAST
);

-- ----------------------------
-- Primary Key structure for table log_translations
-- ----------------------------
ALTER TABLE "public"."log_translations" ADD CONSTRAINT "log_translations_pkey" PRIMARY KEY ("id");

-- ----------------------------
-- Indexes structure for table log_translator_keys
-- ----------------------------
CREATE INDEX "idx_log_http_request_date_log_translator_keys" ON "public"."log_translator_keys" USING btree (
  "date" "pg_catalog"."timestamptz_ops" ASC NULLS LAST
);
CREATE INDEX "idx_log_keyid" ON "public"."log_translator_keys" USING btree (
  "keyid" "pg_catalog"."int2_ops" ASC NULLS LAST
);
CREATE INDEX "idx_log_resut" ON "public"."log_translator_keys" USING btree (
  "result" "pg_catalog"."int2_ops" ASC NULLS LAST
);

-- ----------------------------
-- Primary Key structure for table log_translator_keys
-- ----------------------------
ALTER TABLE "public"."log_translator_keys" ADD CONSTRAINT "log_translator_keys_pkey" PRIMARY KEY ("id", "date");

-- ----------------------------
-- Indexes structure for table log_user_activity
-- ----------------------------
CREATE INDEX "log_user_activity_action_idx" ON "public"."log_user_activity" USING btree (
  "action" COLLATE "pg_catalog"."default" "pg_catalog"."text_ops" ASC NULLS LAST
);
CREATE INDEX "log_user_activity_controller_idx" ON "public"."log_user_activity" USING btree (
  "controller" COLLATE "pg_catalog"."default" "pg_catalog"."text_ops" ASC NULLS LAST
);
CREATE INDEX "log_user_activity_date_idx" ON "public"."log_user_activity" USING btree (
  "date" "pg_catalog"."timestamptz_ops" ASC NULLS LAST
);
CREATE INDEX "log_user_activity_module_idx" ON "public"."log_user_activity" USING btree (
  "module" COLLATE "pg_catalog"."default" "pg_catalog"."text_ops" ASC NULLS LAST
);
CREATE UNIQUE INDEX "log_user_activity_uid_date_module_controller_action_idx" ON "public"."log_user_activity" USING btree (
  "uid" "pg_catalog"."int4_ops" ASC NULLS LAST,
  "date" "pg_catalog"."timestamptz_ops" ASC NULLS LAST,
  "module" COLLATE "pg_catalog"."default" "pg_catalog"."text_ops" ASC NULLS LAST,
  "controller" COLLATE "pg_catalog"."default" "pg_catalog"."text_ops" ASC NULLS LAST,
  "action" COLLATE "pg_catalog"."default" "pg_catalog"."text_ops" ASC NULLS LAST
);
CREATE INDEX "log_user_activity_uid_idx" ON "public"."log_user_activity" USING btree (
  "uid" "pg_catalog"."int4_ops" ASC NULLS LAST
);

-- ----------------------------
-- Uniques structure for table log_user_activity
-- ----------------------------
ALTER TABLE "public"."log_user_activity" ADD CONSTRAINT "log_user_activity_uid_date_module_controller_action_key" UNIQUE ("uid", "date", "module", "controller", "action");

-- ----------------------------
-- Primary Key structure for table log_user_activity
-- ----------------------------
ALTER TABLE "public"."log_user_activity" ADD CONSTRAINT "log_user_activity_pkey" PRIMARY KEY ("id");

-- ----------------------------
-- Indexes structure for table mail_queue
-- ----------------------------
CREATE INDEX "idx_created_mail_queue" ON "public"."mail_queue" USING btree (
  "created" "pg_catalog"."timestamptz_ops" ASC NULLS LAST
);
CREATE INDEX "idx_event_id" ON "public"."mail_queue" USING btree (
  "event_id" "pg_catalog"."int4_ops" ASC NULLS LAST
);
CREATE INDEX "idx_from_mail_queue" ON "public"."mail_queue" USING btree (
  "from" COLLATE "pg_catalog"."default" "pg_catalog"."text_ops" ASC NULLS LAST
);
CREATE INDEX "idx_posting_id" ON "public"."mail_queue" USING btree (
  "posting_id" COLLATE "pg_catalog"."default" "pg_catalog"."text_ops" ASC NULLS LAST
);
CREATE INDEX "idx_priority" ON "public"."mail_queue" USING btree (
  "priority" "pg_catalog"."int4_ops" ASC NULLS LAST
);
CREATE INDEX "idx_processed" ON "public"."mail_queue" USING btree (
  "processed" "pg_catalog"."timestamptz_ops" ASC NULLS LAST
);
CREATE INDEX "idx_result_mail_queue" ON "public"."mail_queue" USING btree (
  "result" COLLATE "pg_catalog"."default" "pg_catalog"."text_ops" ASC NULLS LAST
);

-- ----------------------------
-- Primary Key structure for table mail_queue
-- ----------------------------
ALTER TABLE "public"."mail_queue" ADD CONSTRAINT "mail_queue_pkey" PRIMARY KEY ("id");

-- ----------------------------
-- Indexes structure for table messages
-- ----------------------------
CREATE INDEX "messages_date" ON "public"."messages" USING btree (
  "date" "pg_catalog"."int4_ops" ASC NULLS LAST
);
CREATE INDEX "messages_email" ON "public"."messages" USING btree (
  "email" COLLATE "pg_catalog"."default" "pg_catalog"."text_ops" ASC NULLS LAST
);
CREATE INDEX "messages_id" ON "public"."messages" USING btree (
  "id" "pg_catalog"."int4_ops" ASC NULLS LAST
);
CREATE INDEX "messages_parent" ON "public"."messages" USING btree (
  "parent" "pg_catalog"."int4_ops" ASC NULLS LAST
);
CREATE INDEX "messages_qid" ON "public"."messages" USING btree (
  "qid" "pg_catalog"."int4_ops" ASC NULLS LAST
);
CREATE INDEX "messages_status" ON "public"."messages" USING btree (
  "status" "pg_catalog"."int4_ops" ASC NULLS LAST
);
CREATE INDEX "messages_uid" ON "public"."messages" USING btree (
  "uid" "pg_catalog"."int4_ops" ASC NULLS LAST
);

-- ----------------------------
-- Primary Key structure for table messages
-- ----------------------------
ALTER TABLE "public"."messages" ADD CONSTRAINT "messages_pkey" PRIMARY KEY ("id");

-- ----------------------------
-- Indexes structure for table module_news
-- ----------------------------
CREATE INDEX "idx_mess_date" ON "public"."module_news" USING btree (
  "date" "pg_catalog"."timestamptz_ops" ASC NULLS LAST
);
CREATE INDEX "idx_mess_uid" ON "public"."module_news" USING btree (
  "uid" "pg_catalog"."int4_ops" ASC NULLS LAST
);
CREATE INDEX "module_news_module_idx" ON "public"."module_news" USING btree (
  "module" COLLATE "pg_catalog"."default" "pg_catalog"."text_ops" ASC NULLS LAST
);

-- ----------------------------
-- Primary Key structure for table module_news
-- ----------------------------
ALTER TABLE "public"."module_news" ADD CONSTRAINT "admin_news_pkey" PRIMARY KEY ("id");

-- ----------------------------
-- Indexes structure for table module_tabs_history
-- ----------------------------
CREATE INDEX "admin_tabs_history_href_name_uid_date_idx" ON "public"."module_tabs_history" USING btree (
  "uid" "pg_catalog"."int4_ops" ASC NULLS LAST,
  "module" COLLATE "pg_catalog"."default" "pg_catalog"."text_ops" ASC NULLS LAST,
  "date" "pg_catalog"."timestamptz_ops" ASC NULLS LAST,
  "href" COLLATE "pg_catalog"."default" "pg_catalog"."text_ops" ASC NULLS LAST
);
CREATE INDEX "admin_tabs_history_module_idx" ON "public"."module_tabs_history" USING btree (
  "module" COLLATE "pg_catalog"."default" "pg_catalog"."text_ops" ASC NULLS LAST
);
CREATE INDEX "idx_date" ON "public"."module_tabs_history" USING btree (
  "date" "pg_catalog"."timestamptz_ops" ASC NULLS LAST
);
CREATE INDEX "idx_href" ON "public"."module_tabs_history" USING btree (
  "href" COLLATE "pg_catalog"."default" "pg_catalog"."text_ops" ASC NULLS LAST
);
CREATE INDEX "idx_uid" ON "public"."module_tabs_history" USING btree (
  "uid" "pg_catalog"."int4_ops" ASC NULLS LAST
);

-- ----------------------------
-- Primary Key structure for table module_tabs_history
-- ----------------------------
ALTER TABLE "public"."module_tabs_history" ADD CONSTRAINT "admin_tabs_history_pkey" PRIMARY KEY ("id");

-- ----------------------------
-- Indexes structure for table obj_devices_manual
-- ----------------------------
CREATE INDEX "obj_devices_manual_active_idx" ON "public"."obj_devices_manual" USING btree (
  "active" "pg_catalog"."int2_ops" ASC NULLS LAST
);
CREATE INDEX "obj_devices_manual_created_at_idx" ON "public"."obj_devices_manual" USING btree (
  "created_at" "pg_catalog"."timestamptz_ops" ASC NULLS LAST
);
CREATE INDEX "obj_devices_manual_deleted_at_idx" ON "public"."obj_devices_manual" USING btree (
  "deleted_at" "pg_catalog"."timestamptz_ops" ASC NULLS LAST
);
CREATE INDEX "obj_devices_manual_device_serial_number_idx" ON "public"."obj_devices_manual" USING btree (
  "device_serial_number" COLLATE "pg_catalog"."default" "pg_catalog"."text_ops" ASC NULLS LAST
);
CREATE INDEX "obj_devices_manual_device_status_id_idx" ON "public"."obj_devices_manual" USING btree (
  "device_status_id" "pg_catalog"."int4_ops" ASC NULLS LAST
);
CREATE INDEX "obj_devices_manual_device_usage_id_idx" ON "public"."obj_devices_manual" USING btree (
  "device_usage_id" "pg_catalog"."int4_ops" ASC NULLS LAST
);
CREATE INDEX "obj_devices_manual_source_idx" ON "public"."obj_devices_manual" USING btree (
  "source" COLLATE "pg_catalog"."default" "pg_catalog"."text_ops" ASC NULLS LAST
);
CREATE INDEX "obj_devices_manual_updated_at_idx" ON "public"."obj_devices_manual" USING btree (
  "updated_at" "pg_catalog"."timestamptz_ops" ASC NULLS LAST
);

-- ----------------------------
-- Primary Key structure for table obj_devices_manual
-- ----------------------------
ALTER TABLE "public"."obj_devices_manual" ADD CONSTRAINT "obj_devices_manual_pkey" PRIMARY KEY ("devices_id");

-- ----------------------------
-- Indexes structure for table obj_devices_manual_data
-- ----------------------------
CREATE INDEX "obj_devices_manual_data_data_source_idx" ON "public"."obj_devices_manual_data" USING btree (
  "data_source" "pg_catalog"."int4_ops" ASC NULLS LAST
);
CREATE INDEX "obj_devices_manual_data_data_updated_idx" ON "public"."obj_devices_manual_data" USING btree (
  "data_updated" "pg_catalog"."timestamptz_ops" ASC NULLS LAST
);
CREATE INDEX "obj_devices_manual_data_device_id_data_updated_idx" ON "public"."obj_devices_manual_data" USING btree (
  "device_id" "pg_catalog"."int4_ops" ASC NULLS LAST,
  "data_updated" "pg_catalog"."timestamptz_ops" ASC NULLS LAST
);
CREATE INDEX "obj_devices_manual_data_device_id_idx" ON "public"."obj_devices_manual_data" USING btree (
  "device_id" "pg_catalog"."int4_ops" ASC NULLS LAST
);
CREATE INDEX "obj_devices_manual_data_tariff1_val_idx" ON "public"."obj_devices_manual_data" USING btree (
  "tariff1_val" "pg_catalog"."float8_ops" ASC NULLS LAST
);
CREATE INDEX "obj_devices_manual_data_tariff2_val_idx" ON "public"."obj_devices_manual_data" USING btree (
  "tariff2_val" "pg_catalog"."float8_ops" ASC NULLS LAST
);
CREATE INDEX "obj_devices_manual_data_tariff3_val_idx" ON "public"."obj_devices_manual_data" USING btree (
  "tariff3_val" "pg_catalog"."float8_ops" ASC NULLS LAST
);
CREATE INDEX "obj_devices_manual_data_uid_idx" ON "public"."obj_devices_manual_data" USING btree (
  "uid" "pg_catalog"."int4_ops" ASC NULLS LAST
);

-- ----------------------------
-- Primary Key structure for table obj_devices_manual_data
-- ----------------------------
ALTER TABLE "public"."obj_devices_manual_data" ADD CONSTRAINT "obj_devices_manual_data_pkey" PRIMARY KEY ("data_id");

-- ----------------------------
-- Indexes structure for table obj_devices_startpoints
-- ----------------------------
CREATE INDEX "obj_devices_startpoints_created_idx" ON "public"."obj_devices_startpoints" USING btree (
  "created" "pg_catalog"."timestamptz_ops" ASC NULLS LAST
);
CREATE INDEX "obj_devices_startpoints_deleted_idx" ON "public"."obj_devices_startpoints" USING btree (
  "deleted" "pg_catalog"."timestamptz_ops" ASC NULLS LAST
);
CREATE INDEX "obj_devices_startpoints_devices_id_created_deleted_idx" ON "public"."obj_devices_startpoints" USING btree (
  "devices_id" "pg_catalog"."int4_ops" ASC NULLS LAST,
  "created" "pg_catalog"."timestamptz_ops" ASC NULLS LAST,
  "deleted" "pg_catalog"."timestamptz_ops" ASC NULLS LAST
);
CREATE INDEX "obj_devices_startpoints_devices_id_idx" ON "public"."obj_devices_startpoints" USING btree (
  "devices_id" "pg_catalog"."int4_ops" ASC NULLS LAST
);
CREATE UNIQUE INDEX "obj_devices_startpoints_devices_id_idx1" ON "public"."obj_devices_startpoints" USING btree (
  "devices_id" "pg_catalog"."int4_ops" ASC NULLS LAST
) WHERE deleted IS NULL;
CREATE INDEX "obj_devices_startpoints_uid_idx" ON "public"."obj_devices_startpoints" USING btree (
  "uid" "pg_catalog"."int4_ops" ASC NULLS LAST
);

-- ----------------------------
-- Primary Key structure for table obj_devices_startpoints
-- ----------------------------
ALTER TABLE "public"."obj_devices_startpoints" ADD CONSTRAINT "obj_devices_startpoints_pkey" PRIMARY KEY ("devices_startpoint_id");

-- ----------------------------
-- Indexes structure for table obj_devices_tariffs
-- ----------------------------
CREATE INDEX "devices_tariffs_created_idx" ON "public"."obj_devices_tariffs" USING btree (
  "created" "pg_catalog"."timestamptz_ops" ASC NULLS LAST
);
CREATE INDEX "devices_tariffs_deleted_idx_copy1" ON "public"."obj_devices_tariffs" USING btree (
  "deleted" "pg_catalog"."timestamptz_ops" ASC NULLS LAST
);
CREATE INDEX "devices_tariffs_devices_id_idx_copy1" ON "public"."obj_devices_tariffs" USING btree (
  "tariffs_id" "pg_catalog"."int4_ops" ASC NULLS LAST
);
CREATE UNIQUE INDEX "devices_tariffs_devices_id_tariffs_id_deleted_idx" ON "public"."obj_devices_tariffs" USING btree (
  "devices_id" "pg_catalog"."int4_ops" ASC NULLS LAST,
  "tariffs_id" "pg_catalog"."int4_ops" ASC NULLS LAST
) WHERE deleted IS NULL;
CREATE INDEX "devices_tariffs_devices_idx" ON "public"."obj_devices_tariffs" USING btree (
  "devices_id" "pg_catalog"."int4_ops" ASC NULLS LAST
);

-- ----------------------------
-- Primary Key structure for table obj_devices_tariffs
-- ----------------------------
ALTER TABLE "public"."obj_devices_tariffs" ADD CONSTRAINT "obj_devices_tariffs_pkey" PRIMARY KEY ("devices_tariffs_id");

-- ----------------------------
-- Indexes structure for table obj_lands
-- ----------------------------
CREATE INDEX "lands_created_idx" ON "public"."obj_lands" USING btree (
  "created" "pg_catalog"."timestamptz_ops" ASC NULLS LAST
);
CREATE INDEX "lands_land_group_idx" ON "public"."obj_lands" USING btree (
  "land_group" COLLATE "pg_catalog"."default" "pg_catalog"."text_ops" ASC NULLS LAST
);
CREATE UNIQUE INDEX "lands_land_group_land_number_land_number_cadastral_idx" ON "public"."obj_lands" USING btree (
  "land_group" COLLATE "pg_catalog"."default" "pg_catalog"."text_ops" ASC NULLS LAST,
  "land_number" COLLATE "pg_catalog"."default" "pg_catalog"."text_ops" ASC NULLS LAST,
  "land_number_cadastral" COLLATE "pg_catalog"."default" "pg_catalog"."text_ops" ASC NULLS LAST
);
CREATE INDEX "lands_land_number_cadastral_idx" ON "public"."obj_lands" USING btree (
  "land_number_cadastral" COLLATE "pg_catalog"."default" "pg_catalog"."text_ops" ASC NULLS LAST
);
CREATE INDEX "lands_land_number_idx" ON "public"."obj_lands" USING btree (
  "land_number" COLLATE "pg_catalog"."default" "pg_catalog"."text_ops" ASC NULLS LAST
);
CREATE INDEX "lands_status_idx" ON "public"."obj_lands" USING btree (
  "status" "pg_catalog"."int2_ops" ASC NULLS LAST
);
CREATE INDEX "obj_lands_land_type_idx" ON "public"."obj_lands" USING btree (
  "land_type" "pg_catalog"."int4_ops" ASC NULLS LAST
);

-- ----------------------------
-- Primary Key structure for table obj_lands
-- ----------------------------
ALTER TABLE "public"."obj_lands" ADD CONSTRAINT "lands_pkey" PRIMARY KEY ("lands_id");

-- ----------------------------
-- Indexes structure for table obj_lands_devices
-- ----------------------------
CREATE INDEX "lands_devices_created_idx" ON "public"."obj_lands_devices" USING btree (
  "created" "pg_catalog"."timestamptz_ops" ASC NULLS LAST
);
CREATE INDEX "lands_devices_deleted_idx" ON "public"."obj_lands_devices" USING btree (
  "deleted" "pg_catalog"."timestamptz_ops" ASC NULLS LAST
);
CREATE INDEX "lands_devices_devices_id_idx" ON "public"."obj_lands_devices" USING btree (
  "devices_id" "pg_catalog"."int4_ops" ASC NULLS LAST
);
CREATE UNIQUE INDEX "lands_devices_lands_devices_id_deleted_idx" ON "public"."obj_lands_devices" USING btree (
  "lands_id" "pg_catalog"."int4_ops" ASC NULLS LAST,
  "devices_id" "pg_catalog"."int4_ops" ASC NULLS LAST
) WHERE deleted IS NULL;
CREATE INDEX "lands_devices_lands_idx" ON "public"."obj_lands_devices" USING btree (
  "lands_id" "pg_catalog"."int4_ops" ASC NULLS LAST
);

-- ----------------------------
-- Primary Key structure for table obj_lands_devices
-- ----------------------------
ALTER TABLE "public"."obj_lands_devices" ADD CONSTRAINT "obj_lands_devices_pkey" PRIMARY KEY ("lands_devices_id");

-- ----------------------------
-- Indexes structure for table obj_lands_tariffs
-- ----------------------------
CREATE INDEX "lands_tariffs_created_idx" ON "public"."obj_lands_tariffs" USING btree (
  "created" "pg_catalog"."timestamptz_ops" ASC NULLS LAST
);
CREATE INDEX "lands_tariffs_deleted_idx" ON "public"."obj_lands_tariffs" USING btree (
  "deleted" "pg_catalog"."timestamptz_ops" ASC NULLS LAST
);
CREATE INDEX "lands_tariffs_devices_id_idx" ON "public"."obj_lands_tariffs" USING btree (
  "tariffs_id" "pg_catalog"."int4_ops" ASC NULLS LAST
);
CREATE UNIQUE INDEX "lands_tariffs_lands_id_tariffs_id_deleted_idx" ON "public"."obj_lands_tariffs" USING btree (
  "lands_id" "pg_catalog"."int4_ops" ASC NULLS LAST,
  "tariffs_id" "pg_catalog"."int4_ops" ASC NULLS LAST
) WHERE deleted IS NULL;
CREATE INDEX "lands_tariffs_lands_idx" ON "public"."obj_lands_tariffs" USING btree (
  "lands_id" "pg_catalog"."int4_ops" ASC NULLS LAST
);

-- ----------------------------
-- Uniques structure for table obj_lands_tariffs
-- ----------------------------
ALTER TABLE "public"."obj_lands_tariffs" ADD CONSTRAINT "obj_lands_tariffs_lands_id_tariffs_id_created_key" UNIQUE ("lands_id", "tariffs_id", "created");
ALTER TABLE "public"."obj_lands_tariffs" ADD CONSTRAINT "obj_lands_tariffs_lands_id_tariffs_id_deleted_key" UNIQUE ("lands_id", "tariffs_id", "deleted");

-- ----------------------------
-- Primary Key structure for table obj_lands_tariffs
-- ----------------------------
ALTER TABLE "public"."obj_lands_tariffs" ADD CONSTRAINT "obj_lands_tariffs_pkey" PRIMARY KEY ("lands_tariffs_id");

-- ----------------------------
-- Indexes structure for table obj_news
-- ----------------------------
CREATE INDEX "obj_news_absolute_order_idx" ON "public"."obj_news" USING btree (
  "absolute_order" "pg_catalog"."int4_ops" ASC NULLS LAST
);
CREATE INDEX "obj_news_confirmation_needed_idx" ON "public"."obj_news" USING btree (
  "confirmation_needed" "pg_catalog"."int2_ops" ASC NULLS LAST
);
CREATE INDEX "obj_news_created_idx" ON "public"."obj_news" USING btree (
  "created" "pg_catalog"."timestamptz_ops" ASC NULLS LAST
);
CREATE INDEX "obj_news_date_actual_end_idx" ON "public"."obj_news" USING btree (
  "date_actual_end" "pg_catalog"."timestamptz_ops" ASC NULLS LAST
);
CREATE INDEX "obj_news_date_actual_start_idx" ON "public"."obj_news" USING btree (
  "date_actual_start" "pg_catalog"."timestamptz_ops" ASC NULLS LAST
);
CREATE INDEX "obj_news_enabled_idx" ON "public"."obj_news" USING btree (
  "enabled" "pg_catalog"."int2_ops" ASC NULLS LAST
);
CREATE INDEX "obj_news_news_author_idx" ON "public"."obj_news" USING btree (
  "news_author" "pg_catalog"."int4_ops" ASC NULLS LAST
);
CREATE INDEX "obj_news_news_type_idx" ON "public"."obj_news" USING btree (
  "news_type" "pg_catalog"."int4_ops" ASC NULLS LAST
);

-- ----------------------------
-- Primary Key structure for table obj_news
-- ----------------------------
ALTER TABLE "public"."obj_news" ADD CONSTRAINT "obj_news_pkey" PRIMARY KEY ("news_id");

-- ----------------------------
-- Indexes structure for table obj_news_confirmations
-- ----------------------------
CREATE INDEX "obj_news_confirmations_created_idx" ON "public"."obj_news_confirmations" USING btree (
  "created" "pg_catalog"."timestamptz_ops" ASC NULLS LAST
);
CREATE INDEX "obj_news_confirmations_news_id_idx" ON "public"."obj_news_confirmations" USING btree (
  "news_id" "pg_catalog"."int4_ops" ASC NULLS LAST
);
CREATE UNIQUE INDEX "obj_news_confirmations_news_id_uid_idx" ON "public"."obj_news_confirmations" USING btree (
  "news_id" "pg_catalog"."int4_ops" ASC NULLS LAST,
  "uid" "pg_catalog"."int4_ops" ASC NULLS LAST
);
CREATE INDEX "obj_news_confirmations_result_idx" ON "public"."obj_news_confirmations" USING btree (
  "result" "pg_catalog"."int2_ops" ASC NULLS LAST
);
CREATE INDEX "obj_news_confirmations_uid_idx" ON "public"."obj_news_confirmations" USING btree (
  "uid" "pg_catalog"."int4_ops" ASC NULLS LAST
);

-- ----------------------------
-- Uniques structure for table obj_news_confirmations
-- ----------------------------
ALTER TABLE "public"."obj_news_confirmations" ADD CONSTRAINT "obj_news_confirmations_news_id_uid_key" UNIQUE ("news_id", "uid");

-- ----------------------------
-- Primary Key structure for table obj_news_confirmations
-- ----------------------------
ALTER TABLE "public"."obj_news_confirmations" ADD CONSTRAINT "obj_news_confirmations_pkey" PRIMARY KEY ("news_confirmations_id");

-- ----------------------------
-- Indexes structure for table obj_tariffs
-- ----------------------------
CREATE INDEX "obj_tariffs_acceptor_idx" ON "public"."obj_tariffs" USING btree (
  "acceptor_id" "pg_catalog"."int4_ops" ASC NULLS LAST
);
CREATE INDEX "obj_tariffs_created_idx" ON "public"."obj_tariffs" USING btree (
  "created" "pg_catalog"."timestamptz_ops" ASC NULLS LAST
);
CREATE INDEX "obj_tariffs_enabled_idx" ON "public"."obj_tariffs" USING btree (
  "enabled" "pg_catalog"."int2_ops" ASC NULLS LAST
);
CREATE INDEX "obj_tariffs_tariff_name_idx" ON "public"."obj_tariffs" USING btree (
  "tariff_name" COLLATE "pg_catalog"."default" "pg_catalog"."text_ops" ASC NULLS LAST
);
CREATE INDEX "obj_tariffs_tariff_rules_idx" ON "public"."obj_tariffs" USING btree (
  "tariff_rules" "pg_catalog"."jsonb_ops" ASC NULLS LAST
);
CREATE INDEX "obj_tariffs_tariff_short_name_idx" ON "public"."obj_tariffs" USING btree (
  "tariff_short_name" COLLATE "pg_catalog"."default" "pg_catalog"."text_ops" ASC NULLS LAST
);

-- ----------------------------
-- Primary Key structure for table obj_tariffs
-- ----------------------------
ALTER TABLE "public"."obj_tariffs" ADD CONSTRAINT "obj_tariffs_pkey" PRIMARY KEY ("tariffs_id");

-- ----------------------------
-- Indexes structure for table obj_tariffs_acceptors
-- ----------------------------
CREATE INDEX "obj_tariffs_acceptors_created_idx" ON "public"."obj_tariffs_acceptors" USING btree (
  "created" "pg_catalog"."timestamptz_ops" ASC NULLS LAST
);
CREATE INDEX "obj_tariffs_acceptors_enabled_idx" ON "public"."obj_tariffs_acceptors" USING btree (
  "enabled" "pg_catalog"."int2_ops" ASC NULLS LAST
);

-- ----------------------------
-- Primary Key structure for table obj_tariffs_acceptors
-- ----------------------------
ALTER TABLE "public"."obj_tariffs_acceptors" ADD CONSTRAINT "obj_tariffs_acceptors_pkey" PRIMARY KEY ("tariff_acceptors_id");

-- ----------------------------
-- Indexes structure for table obj_users_lands
-- ----------------------------
CREATE INDEX "obj_users_lands_users_lands_id_uid_deleted_created_idx" ON "public"."obj_users_lands" USING btree (
  "users_lands_id" "pg_catalog"."int4_ops" ASC NULLS LAST,
  "uid" "pg_catalog"."int4_ops" ASC NULLS LAST,
  "deleted" "pg_catalog"."timestamptz_ops" ASC NULLS LAST,
  "created" "pg_catalog"."timestamptz_ops" ASC NULLS LAST
);
CREATE INDEX "users_lands_created_idx" ON "public"."obj_users_lands" USING btree (
  "created" "pg_catalog"."timestamptz_ops" ASC NULLS LAST
);
CREATE INDEX "users_lands_deleted_idx" ON "public"."obj_users_lands" USING btree (
  "deleted" "pg_catalog"."timestamptz_ops" ASC NULLS LAST
);
CREATE INDEX "users_lands_lands_id_idx" ON "public"."obj_users_lands" USING btree (
  "lands_id" "pg_catalog"."int4_ops" ASC NULLS LAST
);
CREATE INDEX "users_lands_uid_idx" ON "public"."obj_users_lands" USING btree (
  "uid" "pg_catalog"."int4_ops" ASC NULLS LAST
);
CREATE UNIQUE INDEX "users_lands_uid_lands_id_deleted_idx" ON "public"."obj_users_lands" USING btree (
  "uid" "pg_catalog"."int4_ops" ASC NULLS LAST,
  "lands_id" "pg_catalog"."int4_ops" ASC NULLS LAST
) WHERE deleted IS NULL;

-- ----------------------------
-- Primary Key structure for table obj_users_lands
-- ----------------------------
ALTER TABLE "public"."obj_users_lands" ADD CONSTRAINT "users_lands_pkey" PRIMARY KEY ("users_lands_id");

-- ----------------------------
-- Indexes structure for table obj_votings
-- ----------------------------
CREATE INDEX "obj_votings_created_idx" ON "public"."obj_votings" USING btree (
  "created" "pg_catalog"."timestamptz_ops" ASC NULLS LAST
);
CREATE INDEX "obj_votings_date_actual_end_idx" ON "public"."obj_votings" USING btree (
  "date_actual_end" "pg_catalog"."timestamptz_ops" ASC NULLS LAST
);
CREATE INDEX "obj_votings_date_actual_start_idx" ON "public"."obj_votings" USING btree (
  "date_actual_start" "pg_catalog"."timestamptz_ops" ASC NULLS LAST
);
CREATE INDEX "obj_votings_enabled_idx" ON "public"."obj_votings" USING btree (
  "enabled" "pg_catalog"."int2_ops" ASC NULLS LAST
);
CREATE INDEX "obj_votings_votings_type_idx" ON "public"."obj_votings" USING btree (
  "votings_type" "pg_catalog"."int4_ops" ASC NULLS LAST
);

-- ----------------------------
-- Primary Key structure for table obj_votings
-- ----------------------------
ALTER TABLE "public"."obj_votings" ADD CONSTRAINT "obj_votings_pkey" PRIMARY KEY ("votings_id");

-- ----------------------------
-- Indexes structure for table obj_votings_results
-- ----------------------------
CREATE INDEX "obj_votings_results_created_idx" ON "public"."obj_votings_results" USING btree (
  "created" "pg_catalog"."timestamptz_ops" ASC NULLS LAST
);
CREATE INDEX "obj_votings_results_result_idx" ON "public"."obj_votings_results" USING btree (
  "result" COLLATE "pg_catalog"."default" "pg_catalog"."text_ops" ASC NULLS LAST
);
CREATE INDEX "obj_votings_results_uid_idx" ON "public"."obj_votings_results" USING btree (
  "uid" "pg_catalog"."int4_ops" ASC NULLS LAST
);
CREATE INDEX "obj_votings_results_votings_id_idx" ON "public"."obj_votings_results" USING btree (
  "votings_id" "pg_catalog"."int4_ops" ASC NULLS LAST
);
CREATE UNIQUE INDEX "obj_votings_results_votings_id_uid_idx" ON "public"."obj_votings_results" USING btree (
  "votings_id" "pg_catalog"."int4_ops" ASC NULLS LAST,
  "uid" "pg_catalog"."int4_ops" ASC NULLS LAST
);

-- ----------------------------
-- Uniques structure for table obj_votings_results
-- ----------------------------
ALTER TABLE "public"."obj_votings_results" ADD CONSTRAINT "obj_votings_id_uid_key" UNIQUE ("votings_id", "uid");

-- ----------------------------
-- Primary Key structure for table obj_votings_results
-- ----------------------------
ALTER TABLE "public"."obj_votings_results" ADD CONSTRAINT "obj_votings_results_pkey" PRIMARY KEY ("votings_results_id");

-- ----------------------------
-- Indexes structure for table orders
-- ----------------------------
CREATE INDEX "idx_id_manager" ON "public"."orders" USING btree (
  "id" "pg_catalog"."int4_ops" ASC NULLS LAST,
  "manager" "pg_catalog"."int4_ops" ASC NULLS LAST
);
CREATE INDEX "idx_manual_delivery" ON "public"."orders" USING btree (
  "manual_delivery" "pg_catalog"."numeric_ops" ASC NULLS LAST
);
CREATE INDEX "idx_manual_sum" ON "public"."orders" USING btree (
  "manual_sum" "pg_catalog"."numeric_ops" ASC NULLS LAST
);
CREATE INDEX "idx_order_addresses" ON "public"."orders" USING btree (
  "addresses_id" "pg_catalog"."int4_ops" ASC NULLS LAST
);
CREATE INDEX "idx_order_code" ON "public"."orders" USING btree (
  "code" COLLATE "pg_catalog"."default" "pg_catalog"."text_ops" ASC NULLS LAST
);
CREATE INDEX "idx_order_date" ON "public"."orders" USING btree (
  "date" "pg_catalog"."int4_ops" ASC NULLS LAST
);
CREATE INDEX "idx_order_delivery" ON "public"."orders" USING btree (
  "delivery_id" COLLATE "pg_catalog"."default" "pg_catalog"."text_ops" ASC NULLS LAST
);
CREATE INDEX "idx_order_store_weight" ON "public"."orders" USING btree (
  "manual_weight" "pg_catalog"."numeric_ops" ASC NULLS LAST
);
CREATE INDEX "idx_order_sum" ON "public"."orders" USING btree (
  "sum" "pg_catalog"."numeric_ops" ASC NULLS LAST
);
CREATE INDEX "idx_orders_manager" ON "public"."orders" USING btree (
  "manager" "pg_catalog"."int4_ops" ASC NULLS LAST
);
CREATE INDEX "idx_orders_status" ON "public"."orders" USING btree (
  "status" COLLATE "pg_catalog"."default" "pg_catalog"."text_ops" ASC NULLS LAST
);
CREATE INDEX "idx_orders_uid" ON "public"."orders" USING btree (
  "uid" "pg_catalog"."int4_ops" ASC NULLS LAST
);
CREATE INDEX "idx_orders_weight" ON "public"."orders" USING btree (
  "weight" "pg_catalog"."numeric_ops" ASC NULLS LAST
);
CREATE INDEX "idx_uid_status" ON "public"."orders" USING btree (
  "uid" "pg_catalog"."int4_ops" ASC NULLS LAST,
  "status" COLLATE "pg_catalog"."default" "pg_catalog"."text_ops" ASC NULLS LAST
);

-- ----------------------------
-- Primary Key structure for table orders
-- ----------------------------
ALTER TABLE "public"."orders" ADD CONSTRAINT "orders_pkey" PRIMARY KEY ("id");

-- ----------------------------
-- Indexes structure for table orders_comments
-- ----------------------------
CREATE INDEX "idx_date_orders_comments" ON "public"."orders_comments" USING btree (
  "date" "pg_catalog"."timestamptz_ops" ASC NULLS LAST
);
CREATE INDEX "idx_internal" ON "public"."orders_comments" USING btree (
  "internal" "pg_catalog"."int2_ops" ASC NULLS LAST
);
CREATE INDEX "idx_oid" ON "public"."orders_comments" USING btree (
  "oid" "pg_catalog"."int4_ops" ASC NULLS LAST
);

-- ----------------------------
-- Primary Key structure for table orders_comments
-- ----------------------------
ALTER TABLE "public"."orders_comments" ADD CONSTRAINT "orders_comments_pkey" PRIMARY KEY ("id");

-- ----------------------------
-- Indexes structure for table orders_comments_attaches
-- ----------------------------
CREATE INDEX "idx_cattach_commentid" ON "public"."orders_comments_attaches" USING btree (
  "comment_id" "pg_catalog"."int8_ops" ASC NULLS LAST
);

-- ----------------------------
-- Primary Key structure for table orders_comments_attaches
-- ----------------------------
ALTER TABLE "public"."orders_comments_attaches" ADD CONSTRAINT "orders_comments_attaches_pkey" PRIMARY KEY ("id");

-- ----------------------------
-- Indexes structure for table orders_items
-- ----------------------------
CREATE INDEX "idx_ds_source_orders_items" ON "public"."orders_items" USING btree (
  "ds_source" COLLATE "pg_catalog"."default" "pg_catalog"."text_ops" ASC NULLS LAST
);
CREATE INDEX "idx_iid_orders_items" ON "public"."orders_items" USING btree (
  "iid" COLLATE "pg_catalog"."default" "pg_catalog"."text_ops" ASC NULLS LAST
);
CREATE INDEX "idx_iid_status_orders_items" ON "public"."orders_items" USING btree (
  "status" "pg_catalog"."int2_ops" ASC NULLS LAST,
  "iid" COLLATE "pg_catalog"."default" "pg_catalog"."text_ops" ASC NULLS LAST
);
CREATE INDEX "idx_oid_seller_id_orders_items" ON "public"."orders_items" USING btree (
  "oid" "pg_catalog"."int4_ops" ASC NULLS LAST,
  "seller_id" COLLATE "pg_catalog"."default" "pg_catalog"."text_ops" ASC NULLS LAST
);
CREATE INDEX "idx_oid_status_orders_items" ON "public"."orders_items" USING btree (
  "oid" "pg_catalog"."int4_ops" ASC NULLS LAST,
  "status" "pg_catalog"."int2_ops" ASC NULLS LAST
);
CREATE INDEX "idx_parcel_1_orders_items" ON "public"."orders_items" USING btree (
  "oid" "pg_catalog"."int4_ops" ASC NULLS LAST
);
CREATE INDEX "idx_parcels_status_orders_items" ON "public"."orders_items" USING btree (
  "status" "pg_catalog"."int2_ops" ASC NULLS LAST
);
CREATE INDEX "idx_status_oid" ON "public"."orders_items" USING btree (
  "status" "pg_catalog"."int2_ops" ASC NULLS LAST,
  "oid" "pg_catalog"."int4_ops" ASC NULLS LAST
);

-- ----------------------------
-- Primary Key structure for table orders_items
-- ----------------------------
ALTER TABLE "public"."orders_items" ADD CONSTRAINT "orders_items_pkey" PRIMARY KEY ("id");

-- ----------------------------
-- Indexes structure for table orders_items_comments
-- ----------------------------
CREATE INDEX "idx_date_orders_items_comments" ON "public"."orders_items_comments" USING btree (
  "date" "pg_catalog"."timestamptz_ops" ASC NULLS LAST
);
CREATE INDEX "idx_internal_orders_items_comments" ON "public"."orders_items_comments" USING btree (
  "internal" "pg_catalog"."int2_ops" ASC NULLS LAST
);
CREATE INDEX "idx_itemid" ON "public"."orders_items_comments" USING btree (
  "item_id" "pg_catalog"."int4_ops" ASC NULLS LAST
);
CREATE INDEX "idx_uid_orders_items_comments" ON "public"."orders_items_comments" USING btree (
  "uid" "pg_catalog"."int4_ops" ASC NULLS LAST
);

-- ----------------------------
-- Primary Key structure for table orders_items_comments
-- ----------------------------
ALTER TABLE "public"."orders_items_comments" ADD CONSTRAINT "orders_items_comments_pkey" PRIMARY KEY ("id");

-- ----------------------------
-- Indexes structure for table orders_items_comments_attaches
-- ----------------------------
CREATE INDEX "idx_ciattach_commentid" ON "public"."orders_items_comments_attaches" USING btree (
  "comment_id" "pg_catalog"."int8_ops" ASC NULLS LAST
);

-- ----------------------------
-- Primary Key structure for table orders_items_comments_attaches
-- ----------------------------
ALTER TABLE "public"."orders_items_comments_attaches" ADD CONSTRAINT "orders_items_comments_attaches_pkey" PRIMARY KEY ("id");

-- ----------------------------
-- Indexes structure for table orders_items_statuses
-- ----------------------------
CREATE INDEX "idx_excluded" ON "public"."orders_items_statuses" USING btree (
  "excluded" "pg_catalog"."int2_ops" ASC NULLS LAST
);
CREATE INDEX "idx_name_orders_items_statuses" ON "public"."orders_items_statuses" USING btree (
  "name" COLLATE "pg_catalog"."default" "pg_catalog"."text_ops" ASC NULLS LAST
);
CREATE INDEX "idx_parcelable" ON "public"."orders_items_statuses" USING btree (
  "parcelable" "pg_catalog"."int2_ops" ASC NULLS LAST
);

-- ----------------------------
-- Primary Key structure for table orders_items_statuses
-- ----------------------------
ALTER TABLE "public"."orders_items_statuses" ADD CONSTRAINT "orders_items_statuses_pkey" PRIMARY KEY ("id");

-- ----------------------------
-- Indexes structure for table orders_payments
-- ----------------------------
CREATE INDEX "idx_date_orders_payments" ON "public"."orders_payments" USING btree (
  "date" "pg_catalog"."timestamptz_ops" ASC NULLS LAST
);
CREATE INDEX "idx_oid_orders_payments" ON "public"."orders_payments" USING btree (
  "oid" "pg_catalog"."int4_ops" ASC NULLS LAST
);
CREATE INDEX "idx_summ" ON "public"."orders_payments" USING btree (
  "summ" "pg_catalog"."numeric_ops" ASC NULLS LAST
);
CREATE INDEX "idx_uid_orders_payments" ON "public"."orders_payments" USING btree (
  "uid" "pg_catalog"."int4_ops" ASC NULLS LAST
);

-- ----------------------------
-- Primary Key structure for table orders_payments
-- ----------------------------
ALTER TABLE "public"."orders_payments" ADD CONSTRAINT "orders_payments_pkey" PRIMARY KEY ("id");

-- ----------------------------
-- Indexes structure for table orders_statuses
-- ----------------------------
CREATE INDEX "idx_enabled_manual" ON "public"."orders_statuses" USING btree (
  "enabled" "pg_catalog"."int2_ops" ASC NULLS LAST,
  "manual" "pg_catalog"."int2_ops" ASC NULLS LAST
);
CREATE INDEX "idx_enabled_manual_process" ON "public"."orders_statuses" USING btree (
  "enabled" "pg_catalog"."int2_ops" ASC NULLS LAST,
  "manual" "pg_catalog"."int2_ops" ASC NULLS LAST,
  "order_in_process" "pg_catalog"."int2_ops" ASC NULLS LAST
);
CREATE INDEX "idx_order_in_process" ON "public"."orders_statuses" USING btree (
  "order_in_process" "pg_catalog"."int2_ops" ASC NULLS LAST
);
CREATE INDEX "idx_order_status_enabled" ON "public"."orders_statuses" USING btree (
  "enabled" "pg_catalog"."int2_ops" ASC NULLS LAST
);
CREATE INDEX "idx_order_status_manual" ON "public"."orders_statuses" USING btree (
  "manual" "pg_catalog"."int2_ops" ASC NULLS LAST
);
CREATE INDEX "idx_order_status_name" ON "public"."orders_statuses" USING btree (
  "name" COLLATE "pg_catalog"."default" "pg_catalog"."text_ops" ASC NULLS LAST
);
CREATE INDEX "idx_order_status_value" ON "public"."orders_statuses" USING btree (
  "value" COLLATE "pg_catalog"."default" "pg_catalog"."text_ops" ASC NULLS LAST
);
CREATE INDEX "idx_parent_status_orders_statuses" ON "public"."orders_statuses" USING btree (
  "parent_status_value" COLLATE "pg_catalog"."default" "pg_catalog"."text_ops" ASC NULLS LAST
);

-- ----------------------------
-- Uniques structure for table orders_statuses
-- ----------------------------
ALTER TABLE "public"."orders_statuses" ADD CONSTRAINT "unique_orders_statuses_value" UNIQUE ("value");

-- ----------------------------
-- Primary Key structure for table orders_statuses
-- ----------------------------
ALTER TABLE "public"."orders_statuses" ADD CONSTRAINT "orders_statuses_pkey" PRIMARY KEY ("id");

-- ----------------------------
-- Indexes structure for table parcels
-- ----------------------------
CREATE INDEX "idx_id_parcels_manager" ON "public"."parcels" USING btree (
  "id" "pg_catalog"."int4_ops" ASC NULLS LAST,
  "manager" "pg_catalog"."int4_ops" ASC NULLS LAST
);
CREATE INDEX "idx_parcels_addresses" ON "public"."parcels" USING btree (
  "addresses_id" "pg_catalog"."int4_ops" ASC NULLS LAST
);
CREATE INDEX "idx_parcels_code" ON "public"."parcels" USING btree (
  "code" COLLATE "pg_catalog"."default" "pg_catalog"."text_ops" ASC NULLS LAST
);
CREATE INDEX "idx_parcels_date" ON "public"."parcels" USING btree (
  "date" "pg_catalog"."int4_ops" ASC NULLS LAST
);
CREATE INDEX "idx_parcels_delivery" ON "public"."parcels" USING btree (
  "delivery_id" COLLATE "pg_catalog"."default" "pg_catalog"."text_ops" ASC NULLS LAST
);
CREATE INDEX "idx_parcels_manager" ON "public"."parcels" USING btree (
  "manager" "pg_catalog"."int4_ops" ASC NULLS LAST
);
CREATE INDEX "idx_parcels_status" ON "public"."parcels" USING btree (
  "status" COLLATE "pg_catalog"."default" "pg_catalog"."text_ops" ASC NULLS LAST
);
CREATE INDEX "idx_parcels_sum" ON "public"."parcels" USING btree (
  "sum" "pg_catalog"."numeric_ops" ASC NULLS LAST
);
CREATE INDEX "idx_parcels_uid" ON "public"."parcels" USING btree (
  "uid" "pg_catalog"."int4_ops" ASC NULLS LAST
);
CREATE INDEX "idx_parcels_weight" ON "public"."parcels" USING btree (
  "weight" "pg_catalog"."numeric_ops" ASC NULLS LAST
);
CREATE INDEX "idx_uid_parcels_status" ON "public"."parcels" USING btree (
  "uid" "pg_catalog"."int4_ops" ASC NULLS LAST,
  "status" COLLATE "pg_catalog"."default" "pg_catalog"."text_ops" ASC NULLS LAST
);

-- ----------------------------
-- Primary Key structure for table parcels
-- ----------------------------
ALTER TABLE "public"."parcels" ADD CONSTRAINT "parcels_pkey" PRIMARY KEY ("id");

-- ----------------------------
-- Indexes structure for table parcels_cart
-- ----------------------------
CREATE INDEX "cart_uid_parcels_cart" ON "public"."parcels_cart" USING btree (
  "uid" "pg_catalog"."int4_ops" ASC NULLS LAST
);
CREATE INDEX "idx_cart_date_parcels_cart" ON "public"."parcels_cart" USING btree (
  "date" "pg_catalog"."timestamptz_ops" ASC NULLS LAST
);
CREATE INDEX "idx_cart_iid_parcels_cart" ON "public"."parcels_cart" USING btree (
  "iid" "pg_catalog"."int4_ops" ASC NULLS LAST
);
CREATE INDEX "idx_cart_num_parcels_cart" ON "public"."parcels_cart" USING btree (
  "num" "pg_catalog"."int4_ops" ASC NULLS LAST
);
CREATE INDEX "idx_unique_parcels_cart" ON "public"."parcels_cart" USING btree (
  "uid" "pg_catalog"."int4_ops" ASC NULLS LAST,
  "iid" "pg_catalog"."int4_ops" ASC NULLS LAST
);

-- ----------------------------
-- Uniques structure for table parcels_cart
-- ----------------------------
ALTER TABLE "public"."parcels_cart" ADD CONSTRAINT "parcels_cart_constr" UNIQUE ("uid", "id");

-- ----------------------------
-- Primary Key structure for table parcels_cart
-- ----------------------------
ALTER TABLE "public"."parcels_cart" ADD CONSTRAINT "parcels_cart_pkey" PRIMARY KEY ("id");

-- ----------------------------
-- Indexes structure for table parcels_comments
-- ----------------------------
CREATE INDEX "idx_date_parcels_comments" ON "public"."parcels_comments" USING btree (
  "date" "pg_catalog"."timestamptz_ops" ASC NULLS LAST
);
CREATE INDEX "idx_internal_parcels_comments" ON "public"."parcels_comments" USING btree (
  "internal" "pg_catalog"."int2_ops" ASC NULLS LAST
);
CREATE INDEX "idx_pid" ON "public"."parcels_comments" USING btree (
  "pid" "pg_catalog"."int4_ops" ASC NULLS LAST
);
CREATE INDEX "idx_uid_parcels_comments" ON "public"."parcels_comments" USING btree (
  "uid" "pg_catalog"."int4_ops" ASC NULLS LAST
);

-- ----------------------------
-- Primary Key structure for table parcels_comments
-- ----------------------------
ALTER TABLE "public"."parcels_comments" ADD CONSTRAINT "parcels_comments_pkey" PRIMARY KEY ("id");

-- ----------------------------
-- Indexes structure for table parcels_comments_attaches
-- ----------------------------
CREATE INDEX "idx_cattach_commentid_parcels_comments_attaches" ON "public"."parcels_comments_attaches" USING btree (
  "comment_id" "pg_catalog"."int8_ops" ASC NULLS LAST
);

-- ----------------------------
-- Primary Key structure for table parcels_comments_attaches
-- ----------------------------
ALTER TABLE "public"."parcels_comments_attaches" ADD CONSTRAINT "parcels_comments_attaches_pkey" PRIMARY KEY ("id");

-- ----------------------------
-- Indexes structure for table parcels_items
-- ----------------------------
CREATE INDEX "idx_iid" ON "public"."parcels_items" USING btree (
  "iid" "pg_catalog"."int4_ops" ASC NULLS LAST
);
CREATE INDEX "idx_iid_status" ON "public"."parcels_items" USING btree (
  "iid" "pg_catalog"."int4_ops" ASC NULLS LAST
);
CREATE INDEX "idx_oid_seller_id" ON "public"."parcels_items" USING btree (
  "pid" "pg_catalog"."int4_ops" ASC NULLS LAST
);
CREATE INDEX "idx_oid_status" ON "public"."parcels_items" USING btree (
  "pid" "pg_catalog"."int4_ops" ASC NULLS LAST
);
CREATE INDEX "idx_parcel_1" ON "public"."parcels_items" USING btree (
  "pid" "pg_catalog"."int4_ops" ASC NULLS LAST
);

-- ----------------------------
-- Primary Key structure for table parcels_items
-- ----------------------------
ALTER TABLE "public"."parcels_items" ADD CONSTRAINT "parcels_items_pkey" PRIMARY KEY ("id");

-- ----------------------------
-- Indexes structure for table parcels_payments
-- ----------------------------
CREATE INDEX "idx_date_parcels_payments" ON "public"."parcels_payments" USING btree (
  "date" "pg_catalog"."timestamptz_ops" ASC NULLS LAST
);
CREATE INDEX "idx_pid_parcels_payments" ON "public"."parcels_payments" USING btree (
  "pid" "pg_catalog"."int4_ops" ASC NULLS LAST
);
CREATE INDEX "idx_summ_parcels_payments" ON "public"."parcels_payments" USING btree (
  "summ" "pg_catalog"."numeric_ops" ASC NULLS LAST
);
CREATE INDEX "idx_uid_parcels_payments" ON "public"."parcels_payments" USING btree (
  "uid" "pg_catalog"."int4_ops" ASC NULLS LAST
);

-- ----------------------------
-- Primary Key structure for table parcels_payments
-- ----------------------------
ALTER TABLE "public"."parcels_payments" ADD CONSTRAINT "parcels_payments_pkey" PRIMARY KEY ("id");

-- ----------------------------
-- Indexes structure for table parcels_statuses
-- ----------------------------
CREATE INDEX "idx_enabled_manual_parcels_statuses" ON "public"."parcels_statuses" USING btree (
  "enabled" "pg_catalog"."int2_ops" ASC NULLS LAST,
  "manual" "pg_catalog"."int2_ops" ASC NULLS LAST
);
CREATE INDEX "idx_enabled_manual_process_parcels_statuses" ON "public"."parcels_statuses" USING btree (
  "enabled" "pg_catalog"."int2_ops" ASC NULLS LAST,
  "manual" "pg_catalog"."int2_ops" ASC NULLS LAST,
  "order_in_process" "pg_catalog"."int2_ops" ASC NULLS LAST
);
CREATE INDEX "idx_order_in_process_parcels_statuses" ON "public"."parcels_statuses" USING btree (
  "order_in_process" "pg_catalog"."int2_ops" ASC NULLS LAST
);
CREATE INDEX "idx_order_status_enabled_parcels_statuses" ON "public"."parcels_statuses" USING btree (
  "enabled" "pg_catalog"."int2_ops" ASC NULLS LAST
);
CREATE INDEX "idx_order_status_manual_parcels_statuses" ON "public"."parcels_statuses" USING btree (
  "manual" "pg_catalog"."int2_ops" ASC NULLS LAST
);
CREATE INDEX "idx_order_status_name_parcels_statuses" ON "public"."parcels_statuses" USING btree (
  "name" COLLATE "pg_catalog"."default" "pg_catalog"."text_ops" ASC NULLS LAST
);
CREATE INDEX "idx_order_status_value_parcels_statuses" ON "public"."parcels_statuses" USING btree (
  "value" COLLATE "pg_catalog"."default" "pg_catalog"."text_ops" ASC NULLS LAST
);
CREATE INDEX "idx_parent_status_parcels_statuses" ON "public"."parcels_statuses" USING btree (
  "parent_status_value" COLLATE "pg_catalog"."default" "pg_catalog"."text_ops" ASC NULLS LAST
);

-- ----------------------------
-- Uniques structure for table parcels_statuses
-- ----------------------------
ALTER TABLE "public"."parcels_statuses" ADD CONSTRAINT "unique_value" UNIQUE ("value");

-- ----------------------------
-- Primary Key structure for table parcels_statuses
-- ----------------------------
ALTER TABLE "public"."parcels_statuses" ADD CONSTRAINT "parcels_statuses_pkey" PRIMARY KEY ("id");

-- ----------------------------
-- Indexes structure for table pay_systems
-- ----------------------------
CREATE INDEX "int_type" ON "public"."pay_systems" USING btree (
  "int_type" COLLATE "pg_catalog"."default" "pg_catalog"."text_ops" ASC NULLS LAST
);
CREATE INDEX "pay_systems_enabled" ON "public"."pay_systems" USING btree (
  "enabled" "pg_catalog"."int4_ops" ASC NULLS LAST
);
CREATE INDEX "pay_systems_intname" ON "public"."pay_systems" USING btree (
  "int_name" COLLATE "pg_catalog"."default" "pg_catalog"."text_ops" ASC NULLS LAST
);

-- ----------------------------
-- Primary Key structure for table pay_systems
-- ----------------------------
ALTER TABLE "public"."pay_systems" ADD CONSTRAINT "pay_systems_pkey" PRIMARY KEY ("id");

-- ----------------------------
-- Primary Key structure for table pay_systems_log
-- ----------------------------
ALTER TABLE "public"."pay_systems_log" ADD CONSTRAINT "pay_systems_log_pkey" PRIMARY KEY ("id");

-- ----------------------------
-- Indexes structure for table payments
-- ----------------------------
CREATE INDEX "idx_oid_payments" ON "public"."payments" USING btree (
  "oid" "pg_catalog"."int4_ops" ASC NULLS LAST
);
CREATE INDEX "idx_payments_status" ON "public"."payments" USING btree (
  "status" "pg_catalog"."int2_ops" ASC NULLS LAST
);
CREATE INDEX "idx_payments_uid" ON "public"."payments" USING btree (
  "uid" "pg_catalog"."int4_ops" ASC NULLS LAST
);
CREATE INDEX "idx_uid_status_payments" ON "public"."payments" USING btree (
  "uid" "pg_catalog"."int4_ops" ASC NULLS LAST,
  "status" "pg_catalog"."int2_ops" ASC NULLS LAST
);
CREATE INDEX "payments_date_idx" ON "public"."payments" USING btree (
  "date" "pg_catalog"."timestamptz_ops" ASC NULLS LAST
);
CREATE INDEX "payments_manager_id_idx" ON "public"."payments" USING btree (
  "manager_id" "pg_catalog"."int4_ops" ASC NULLS LAST
);

-- ----------------------------
-- Primary Key structure for table payments
-- ----------------------------
ALTER TABLE "public"."payments" ADD CONSTRAINT "payments_pkey" PRIMARY KEY ("id");

-- ----------------------------
-- Indexes structure for table questions
-- ----------------------------
CREATE INDEX "fk_questions_users" ON "public"."questions" USING btree (
  "uid" "pg_catalog"."int4_ops" ASC NULLS LAST
);
CREATE INDEX "idx_email" ON "public"."questions" USING btree (
  "email" COLLATE "pg_catalog"."default" "pg_catalog"."text_ops" ASC NULLS LAST
);
CREATE INDEX "questions_dch" ON "public"."questions" USING btree (
  "date_change" "pg_catalog"."int4_ops" ASC NULLS LAST
);
CREATE INDEX "questions_oid" ON "public"."questions" USING btree (
  "order_id" "pg_catalog"."int4_ops" ASC NULLS LAST
);
CREATE INDEX "questions_pk" ON "public"."questions" USING btree (
  "id" "pg_catalog"."int4_ops" ASC NULLS LAST
);
CREATE INDEX "questions_status" ON "public"."questions" USING btree (
  "status" "pg_catalog"."int2_ops" ASC NULLS LAST
);
CREATE INDEX "questions_uid" ON "public"."questions" USING btree (
  "date" "pg_catalog"."int4_ops" ASC NULLS LAST
);

-- ----------------------------
-- Primary Key structure for table questions
-- ----------------------------
ALTER TABLE "public"."questions" ADD CONSTRAINT "questions_pkey" PRIMARY KEY ("id");

-- ----------------------------
-- Indexes structure for table reports_system
-- ----------------------------
CREATE INDEX "idx_enabled_reports_system" ON "public"."reports_system" USING btree (
  "enabled" "pg_catalog"."int2_ops" ASC NULLS LAST
);
CREATE INDEX "idx_group_reports_system" ON "public"."reports_system" USING btree (
  "group" COLLATE "pg_catalog"."default" "pg_catalog"."text_ops" ASC NULLS LAST
);
CREATE INDEX "idx_int_name" ON "public"."reports_system" USING btree (
  "internal_name" COLLATE "pg_catalog"."default" "pg_catalog"."text_ops" ASC NULLS LAST
);
CREATE INDEX "idx_order_reports_system" ON "public"."reports_system" USING btree (
  "order" "pg_catalog"."int2_ops" ASC NULLS LAST
);

-- ----------------------------
-- Primary Key structure for table reports_system
-- ----------------------------
ALTER TABLE "public"."reports_system" ADD CONSTRAINT "reports_system_pkey" PRIMARY KEY ("id");

-- ----------------------------
-- Indexes structure for table scheduled_jobs
-- ----------------------------
CREATE INDEX "idx_job_interval" ON "public"."scheduled_jobs" USING btree (
  "job_interval" "pg_catalog"."int8_ops" ASC NULLS LAST
);
CREATE INDEX "idx_job_start_time" ON "public"."scheduled_jobs" USING btree (
  "job_start_time" "pg_catalog"."timestamptz_ops" ASC NULLS LAST
);
CREATE INDEX "idx_job_stop_time" ON "public"."scheduled_jobs" USING btree (
  "job_stop_time" "pg_catalog"."timestamptz_ops" ASC NULLS LAST
);

-- ----------------------------
-- Primary Key structure for table scheduled_jobs
-- ----------------------------
ALTER TABLE "public"."scheduled_jobs" ADD CONSTRAINT "scheduled_jobs_pkey" PRIMARY KEY ("id");

-- ----------------------------
-- Indexes structure for table seo_keywords
-- ----------------------------
CREATE INDEX "idx_cnt" ON "public"."seo_keywords" USING btree (
  "cnt" "pg_catalog"."int4_ops" ASC NULLS LAST
);
CREATE INDEX "idx_lang_seo_keywords" ON "public"."seo_keywords" USING btree (
  "lang" COLLATE "pg_catalog"."default" "pg_catalog"."text_ops" ASC NULLS LAST
);

-- ----------------------------
-- Primary Key structure for table seo_keywords
-- ----------------------------
ALTER TABLE "public"."seo_keywords" ADD CONSTRAINT "seo_keywords_pkey" PRIMARY KEY ("lang", "keyword");

-- ----------------------------
-- Indexes structure for table src_nekta_data_type1
-- ----------------------------
CREATE INDEX "src_nekta_data_type1_device_id_idx" ON "public"."src_nekta_data_type1" USING btree (
  "device_id" "pg_catalog"."int4_ops" ASC NULLS LAST
);
CREATE INDEX "src_nekta_data_type1_realdatetime_idx" ON "public"."src_nekta_data_type1" USING btree (
  "realdatetime" "pg_catalog"."timestamptz_ops" ASC NULLS LAST
);

-- ----------------------------
-- Primary Key structure for table src_nekta_data_type1
-- ----------------------------
ALTER TABLE "public"."src_nekta_data_type1" ADD CONSTRAINT "src_nekta_data_type1_pkey" PRIMARY KEY ("device_id", "realdatetime");

-- ----------------------------
-- Indexes structure for table src_nekta_data_type5
-- ----------------------------
CREATE INDEX "src_nekta_data_type5_device_id_idx" ON "public"."src_nekta_data_type5" USING btree (
  "device_id" "pg_catalog"."int4_ops" ASC NULLS LAST
);
CREATE INDEX "src_nekta_data_type5_realdatetime_idx" ON "public"."src_nekta_data_type5" USING btree (
  "realdatetime" "pg_catalog"."timestamptz_ops" ASC NULLS LAST
);

-- ----------------------------
-- Primary Key structure for table src_nekta_data_type5
-- ----------------------------
ALTER TABLE "public"."src_nekta_data_type5" ADD CONSTRAINT "src_nekta_data_type5_pkey" PRIMARY KEY ("device_id", "realdatetime");

-- ----------------------------
-- Indexes structure for table src_nekta_data_type6
-- ----------------------------
CREATE INDEX "src_nekta_data_type6_device_id_idx" ON "public"."src_nekta_data_type6" USING btree (
  "device_id" "pg_catalog"."int4_ops" ASC NULLS LAST
);
CREATE INDEX "src_nekta_data_type6_realdatetime_idx" ON "public"."src_nekta_data_type6" USING btree (
  "realdatetime" "pg_catalog"."timestamptz_ops" ASC NULLS LAST
);

-- ----------------------------
-- Primary Key structure for table src_nekta_data_type6
-- ----------------------------
ALTER TABLE "public"."src_nekta_data_type6" ADD CONSTRAINT "src_nekta_data_type6_pkey" PRIMARY KEY ("device_id", "realdatetime");

-- ----------------------------
-- Indexes structure for table src_nekta_device_groups
-- ----------------------------
CREATE INDEX "src_nekta_device_groups_name_idx" ON "public"."src_nekta_device_groups" USING btree (
  "name" COLLATE "pg_catalog"."default" "pg_catalog"."text_ops" ASC NULLS LAST
);

-- ----------------------------
-- Primary Key structure for table src_nekta_device_groups
-- ----------------------------
ALTER TABLE "public"."src_nekta_device_groups" ADD CONSTRAINT "src_nekta_device_groups_pkey" PRIMARY KEY ("id");

-- ----------------------------
-- Indexes structure for table src_nekta_device_models
-- ----------------------------
CREATE INDEX "src_nekta_device_models_active_idx" ON "public"."src_nekta_device_models" USING btree (
  "active" "pg_catalog"."bool_ops" ASC NULLS LAST
);
CREATE INDEX "src_nekta_device_models_device_brand_id_idx" ON "public"."src_nekta_device_models" USING btree (
  "device_brand_id" "pg_catalog"."int4_ops" ASC NULLS LAST
);
CREATE INDEX "src_nekta_device_models_device_group_id_idx" ON "public"."src_nekta_device_models" USING btree (
  "device_group_id" "pg_catalog"."int4_ops" ASC NULLS LAST
);
CREATE INDEX "src_nekta_device_models_device_type_id_idx" ON "public"."src_nekta_device_models" USING btree (
  "device_type_id" "pg_catalog"."int4_ops" ASC NULLS LAST
);
CREATE INDEX "src_nekta_device_models_name_idx" ON "public"."src_nekta_device_models" USING btree (
  "name" COLLATE "pg_catalog"."default" "pg_catalog"."text_ops" ASC NULLS LAST
);
CREATE INDEX "src_nekta_device_models_protocol_id_idx" ON "public"."src_nekta_device_models" USING btree (
  "protocol_id" "pg_catalog"."int4_ops" ASC NULLS LAST
);

-- ----------------------------
-- Primary Key structure for table src_nekta_device_models
-- ----------------------------
ALTER TABLE "public"."src_nekta_device_models" ADD CONSTRAINT "src_nekta_device_models_pkey" PRIMARY KEY ("id");

-- ----------------------------
-- Indexes structure for table src_nekta_device_types
-- ----------------------------
CREATE INDEX "src_nekta_device_types_device_group_id_idx" ON "public"."src_nekta_device_types" USING btree (
  "device_group_id" "pg_catalog"."int4_ops" ASC NULLS LAST
);
CREATE INDEX "src_nekta_device_types_name_idx" ON "public"."src_nekta_device_types" USING btree (
  "name" COLLATE "pg_catalog"."default" "pg_catalog"."text_ops" ASC NULLS LAST
);

-- ----------------------------
-- Primary Key structure for table src_nekta_device_types
-- ----------------------------
ALTER TABLE "public"."src_nekta_device_types" ADD CONSTRAINT "src_nekta_device_types_pkey" PRIMARY KEY ("id");

-- ----------------------------
-- Indexes structure for table src_nekta_metering_devices
-- ----------------------------
CREATE INDEX "src_nekta_metering_devices_active_idx" ON "public"."src_nekta_metering_devices" USING btree (
  "active" "pg_catalog"."int2_ops" ASC NULLS LAST
);
CREATE INDEX "src_nekta_metering_devices_address_idx" ON "public"."src_nekta_metering_devices" USING gin (
  "address" "pg_catalog"."jsonb_ops"
) WITH (FASTUPDATE = on, GIN_PENDING_LIST_LIMIT = 4096);
CREATE INDEX "src_nekta_metering_devices_created_at_idx" ON "public"."src_nekta_metering_devices" USING btree (
  "created_at" "pg_catalog"."timestamptz_ops" ASC NULLS LAST
);
CREATE INDEX "src_nekta_metering_devices_deleted_at_idx" ON "public"."src_nekta_metering_devices" USING btree (
  "deleted_at" "pg_catalog"."timestamptz_ops" ASC NULLS LAST
);
CREATE INDEX "src_nekta_metering_devices_id_idx" ON "public"."src_nekta_metering_devices" USING btree (
  "id" "pg_catalog"."int4_ops" ASC NULLS LAST
);
CREATE INDEX "src_nekta_metering_devices_last_active_idx" ON "public"."src_nekta_metering_devices" USING btree (
  "last_active" "pg_catalog"."timestamptz_ops" ASC NULLS LAST
);
CREATE INDEX "src_nekta_metering_devices_last_message_idx" ON "public"."src_nekta_metering_devices" USING btree (
  "last_message" "pg_catalog"."jsonb_ops" ASC NULLS LAST
);
CREATE INDEX "src_nekta_metering_devices_last_message_type_idx" ON "public"."src_nekta_metering_devices" USING btree (
  "last_message_type" "pg_catalog"."jsonb_ops" ASC NULLS LAST
);
CREATE INDEX "src_nekta_metering_devices_properties_idx" ON "public"."src_nekta_metering_devices" USING gin (
  "properties" "pg_catalog"."jsonb_ops"
) WITH (FASTUPDATE = on, GIN_PENDING_LIST_LIMIT = 4096);
CREATE INDEX "src_nekta_metering_devices_status_idx" ON "public"."src_nekta_metering_devices" USING gin (
  "status" "pg_catalog"."jsonb_ops"
) WITH (FASTUPDATE = on, GIN_PENDING_LIST_LIMIT = 4096);
CREATE INDEX "src_nekta_metering_devices_updated_at_idx" ON "public"."src_nekta_metering_devices" USING btree (
  "updated_at" "pg_catalog"."timestamptz_ops" ASC NULLS LAST
);

-- ----------------------------
-- Primary Key structure for table src_nekta_metering_devices
-- ----------------------------
ALTER TABLE "public"."src_nekta_metering_devices" ADD CONSTRAINT "src_nekta_metering_devices_pkey" PRIMARY KEY ("id");

-- ----------------------------
-- Uniques structure for table t_category
-- ----------------------------
ALTER TABLE "public"."t_category" ADD CONSTRAINT "t_category_constr" UNIQUE ("id", "language");

-- ----------------------------
-- Primary Key structure for table t_category
-- ----------------------------
ALTER TABLE "public"."t_category" ADD CONSTRAINT "t_category_pkey" PRIMARY KEY ("id", "language");

-- ----------------------------
-- Primary Key structure for table t_dictionary
-- ----------------------------
ALTER TABLE "public"."t_dictionary" ADD CONSTRAINT "t_dictionary_pkey" PRIMARY KEY ("id", "language");

-- ----------------------------
-- Primary Key structure for table t_dictionary_long
-- ----------------------------
ALTER TABLE "public"."t_dictionary_long" ADD CONSTRAINT "t_dictionary_long_pkey" PRIMARY KEY ("id", "language");

-- ----------------------------
-- Indexes structure for table t_message
-- ----------------------------
CREATE INDEX "idx_corrected" ON "public"."t_message" USING btree (
  "corrected" "pg_catalog"."timestamptz_ops" ASC NULLS LAST
);

-- ----------------------------
-- Uniques structure for table t_message
-- ----------------------------
ALTER TABLE "public"."t_message" ADD CONSTRAINT "t_message_unique_constr" UNIQUE ("id", "language");

-- ----------------------------
-- Primary Key structure for table t_message
-- ----------------------------
ALTER TABLE "public"."t_message" ADD CONSTRAINT "t_message_pkey" PRIMARY KEY ("id", "language");

-- ----------------------------
-- Uniques structure for table t_pinned
-- ----------------------------
ALTER TABLE "public"."t_pinned" ADD CONSTRAINT "t_pinned_constr" UNIQUE ("id", "language");

-- ----------------------------
-- Primary Key structure for table t_pinned
-- ----------------------------
ALTER TABLE "public"."t_pinned" ADD CONSTRAINT "t_pinned_pkey" PRIMARY KEY ("id", "language");

-- ----------------------------
-- Primary Key structure for table t_sentences
-- ----------------------------
ALTER TABLE "public"."t_sentences" ADD CONSTRAINT "t_sentences_pkey" PRIMARY KEY ("id", "language");

-- ----------------------------
-- Indexes structure for table t_source_category
-- ----------------------------
CREATE INDEX "idx_id_t_source_category" ON "public"."t_source_category" USING btree (
  "id" "pg_catalog"."int8_ops" ASC NULLS LAST
);

-- ----------------------------
-- Uniques structure for table t_source_category
-- ----------------------------
ALTER TABLE "public"."t_source_category" ADD CONSTRAINT "t_source_category_constr" UNIQUE ("message_md5", "language", "category");

-- ----------------------------
-- Primary Key structure for table t_source_category
-- ----------------------------
ALTER TABLE "public"."t_source_category" ADD CONSTRAINT "t_source_category_pkey" PRIMARY KEY ("message_md5", "language", "category");

-- ----------------------------
-- Indexes structure for table t_source_dictionary
-- ----------------------------
CREATE INDEX "idx_id_t_source_dictionary" ON "public"."t_source_dictionary" USING btree (
  "id" "pg_catalog"."int8_ops" ASC NULLS LAST
);

-- ----------------------------
-- Uniques structure for table t_source_dictionary
-- ----------------------------
ALTER TABLE "public"."t_source_dictionary" ADD CONSTRAINT "t_source_dictionary_constr" UNIQUE ("message_md5", "language", "category");

-- ----------------------------
-- Primary Key structure for table t_source_dictionary
-- ----------------------------
ALTER TABLE "public"."t_source_dictionary" ADD CONSTRAINT "t_source_dictionary_pkey" PRIMARY KEY ("message_md5", "language", "category");

-- ----------------------------
-- Indexes structure for table t_source_dictionary_long
-- ----------------------------
CREATE INDEX "idx_id_t_source_dictionary_long" ON "public"."t_source_dictionary_long" USING btree (
  "id" "pg_catalog"."int8_ops" ASC NULLS LAST
);
CREATE INDEX "idx_mearch_by_text" ON "public"."t_source_dictionary_long" USING btree (
  "message_length" "pg_catalog"."int4_ops" ASC NULLS LAST,
  "language" COLLATE "pg_catalog"."default" "pg_catalog"."bpchar_ops" ASC NULLS LAST,
  "category" COLLATE "pg_catalog"."default" "pg_catalog"."bpchar_ops" ASC NULLS LAST
);
CREATE INDEX "idx_message_en" ON "public"."t_source_dictionary_long" USING gin (
  to_tsvector('english'::regconfig, message) "pg_catalog"."tsvector_ops"
);
CREATE INDEX "idx_message_ru" ON "public"."t_source_dictionary_long" USING gin (
  to_tsvector('russian'::regconfig, message) "pg_catalog"."tsvector_ops"
);

-- ----------------------------
-- Uniques structure for table t_source_dictionary_long
-- ----------------------------
ALTER TABLE "public"."t_source_dictionary_long" ADD CONSTRAINT "t_source_dictionary_long_constr" UNIQUE ("message_md5", "language", "category");

-- ----------------------------
-- Primary Key structure for table t_source_dictionary_long
-- ----------------------------
ALTER TABLE "public"."t_source_dictionary_long" ADD CONSTRAINT "t_source_dictionary_long_pkey" PRIMARY KEY ("message_md5", "language", "category");

-- ----------------------------
-- Indexes structure for table t_source_message
-- ----------------------------
CREATE INDEX "idx_for_search" ON "public"."t_source_message" USING btree (
  "category" COLLATE "pg_catalog"."default" "pg_catalog"."bpchar_ops" ASC NULLS LAST,
  "message_md5" COLLATE "pg_catalog"."default" "pg_catalog"."bpchar_ops" ASC NULLS LAST
);

-- ----------------------------
-- Uniques structure for table t_source_message
-- ----------------------------
ALTER TABLE "public"."t_source_message" ADD CONSTRAINT "t_source_message_unique_constr" UNIQUE ("category", "message_md5");

-- ----------------------------
-- Primary Key structure for table t_source_message
-- ----------------------------
ALTER TABLE "public"."t_source_message" ADD CONSTRAINT "t_source_message_pkey" PRIMARY KEY ("id");

-- ----------------------------
-- Indexes structure for table t_source_pinned
-- ----------------------------
CREATE INDEX "idx_id_t_source_pinned" ON "public"."t_source_pinned" USING btree (
  "id" "pg_catalog"."int8_ops" ASC NULLS LAST
);

-- ----------------------------
-- Uniques structure for table t_source_pinned
-- ----------------------------
ALTER TABLE "public"."t_source_pinned" ADD CONSTRAINT "t_source_pinned_constr" UNIQUE ("message_md5", "language", "category");

-- ----------------------------
-- Primary Key structure for table t_source_pinned
-- ----------------------------
ALTER TABLE "public"."t_source_pinned" ADD CONSTRAINT "t_source_pinned_pkey" PRIMARY KEY ("message_md5", "language", "category");

-- ----------------------------
-- Indexes structure for table t_source_sentences
-- ----------------------------
CREATE INDEX "idx_id_t_source_sentences" ON "public"."t_source_sentences" USING btree (
  "id" "pg_catalog"."int8_ops" ASC NULLS LAST
);

-- ----------------------------
-- Uniques structure for table t_source_sentences
-- ----------------------------
ALTER TABLE "public"."t_source_sentences" ADD CONSTRAINT "t_source_sentences_constr" UNIQUE ("message_md5", "language", "category");

-- ----------------------------
-- Primary Key structure for table t_source_sentences
-- ----------------------------
ALTER TABLE "public"."t_source_sentences" ADD CONSTRAINT "t_source_sentences_pkey" PRIMARY KEY ("message_md5", "language", "category");

-- ----------------------------
-- Indexes structure for table translator_keys
-- ----------------------------
CREATE INDEX "idx_banned" ON "public"."translator_keys" USING btree (
  "banned" "pg_catalog"."int2_ops" ASC NULLS LAST
);
CREATE INDEX "idx_banned_date" ON "public"."translator_keys" USING btree (
  "banned_date" "pg_catalog"."timestamptz_ops" ASC NULLS LAST
);
CREATE INDEX "idx_enabled_banned" ON "public"."translator_keys" USING btree (
  "enabled" "pg_catalog"."int2_ops" ASC NULLS LAST,
  "banned" "pg_catalog"."int2_ops" ASC NULLS LAST
);
CREATE INDEX "idx_enabled_translator_keys" ON "public"."translator_keys" USING btree (
  "enabled" "pg_catalog"."int2_ops" ASC NULLS LAST
);
CREATE INDEX "idx_id_translator_keys" ON "public"."translator_keys" USING btree (
  "id" "pg_catalog"."int4_ops" ASC NULLS LAST
);
CREATE INDEX "idx_key_translator_keys" ON "public"."translator_keys" USING btree (
  "key" COLLATE "pg_catalog"."default" "pg_catalog"."text_ops" ASC NULLS LAST
);
CREATE INDEX "idx_type_translator_keys" ON "public"."translator_keys" USING btree (
  "type" COLLATE "pg_catalog"."default" "pg_catalog"."text_ops" ASC NULLS LAST
);

-- ----------------------------
-- Primary Key structure for table translator_keys
-- ----------------------------
ALTER TABLE "public"."translator_keys" ADD CONSTRAINT "translator_keys_pkey" PRIMARY KEY ("id");

-- ----------------------------
-- Indexes structure for table user_notice
-- ----------------------------
CREATE INDEX "fk_user_notice_users" ON "public"."user_notice" USING btree (
  "uid" "pg_catalog"."int4_ops" ASC NULLS LAST
);

-- ----------------------------
-- Primary Key structure for table user_notice
-- ----------------------------
ALTER TABLE "public"."user_notice" ADD CONSTRAINT "user_notice_pkey" PRIMARY KEY ("id");

-- ----------------------------
-- Indexes structure for table users
-- ----------------------------
CREATE INDEX "email" ON "public"."users" USING btree (
  "email" COLLATE "pg_catalog"."default" "pg_catalog"."text_ops" ASC NULLS LAST,
  "phone" COLLATE "pg_catalog"."default" "pg_catalog"."text_ops" ASC NULLS LAST
);
CREATE INDEX "idx_email_users" ON "public"."users" USING btree (
  "email" COLLATE "pg_catalog"."default" "pg_catalog"."text_ops" ASC NULLS LAST
);
CREATE INDEX "idx_phone" ON "public"."users" USING btree (
  "phone" COLLATE "pg_catalog"."default" "pg_catalog"."text_ops" ASC NULLS LAST
);
CREATE INDEX "idx_status_role" ON "public"."users" USING btree (
  "status" "pg_catalog"."int2_ops" ASC NULLS LAST,
  "role" COLLATE "pg_catalog"."default" "pg_catalog"."text_ops" ASC NULLS LAST
);
CREATE INDEX "idx_status_uid" ON "public"."users" USING btree (
  "status" "pg_catalog"."int2_ops" ASC NULLS LAST,
  "uid" "pg_catalog"."int4_ops" ASC NULLS LAST
);
CREATE INDEX "users_created_idx" ON "public"."users" USING btree (
  "created" "pg_catalog"."timestamptz_ops" ASC NULLS LAST
);
CREATE INDEX "users_debtor_status_idx" ON "public"."users" USING btree (
  "debtor_status" "pg_catalog"."int4_ops" ASC NULLS LAST
);
CREATE INDEX "users_def_manager" ON "public"."users" USING btree (
  "default_manager" "pg_catalog"."int4_ops" ASC NULLS LAST
);
CREATE INDEX "users_fullname_idx" ON "public"."users" USING btree (
  "fullname" COLLATE "pg_catalog"."default" "pg_catalog"."text_ops" ASC NULLS LAST
);
CREATE INDEX "users_password" ON "public"."users" USING btree (
  "password" COLLATE "pg_catalog"."default" "pg_catalog"."text_ops" ASC NULLS LAST
);
CREATE INDEX "users_role" ON "public"."users" USING btree (
  "role" COLLATE "pg_catalog"."default" "pg_catalog"."text_ops" ASC NULLS LAST
);
CREATE INDEX "users_status" ON "public"."users" USING btree (
  "status" "pg_catalog"."int2_ops" ASC NULLS LAST
);

-- ----------------------------
-- Primary Key structure for table users
-- ----------------------------
ALTER TABLE "public"."users" ADD CONSTRAINT "users_pkey" PRIMARY KEY ("uid");

-- ----------------------------
-- Uniques structure for table warehouse
-- ----------------------------
ALTER TABLE "public"."warehouse" ADD CONSTRAINT "unique_id" UNIQUE ("id");

-- ----------------------------
-- Primary Key structure for table warehouse
-- ----------------------------
ALTER TABLE "public"."warehouse" ADD CONSTRAINT "warehouse_pkey" PRIMARY KEY ("id", "warehouse_name");

-- ----------------------------
-- Indexes structure for table warehouse_place
-- ----------------------------
CREATE INDEX "idx_wid" ON "public"."warehouse_place" USING btree (
  "wid" "pg_catalog"."int4_ops" ASC NULLS LAST
);
CREATE INDEX "idx_wid_warehouse_place_name" ON "public"."warehouse_place" USING btree (
  "wid" "pg_catalog"."int4_ops" ASC NULLS LAST,
  "warehouse_place_name" COLLATE "pg_catalog"."default" "pg_catalog"."text_ops" ASC NULLS LAST
);

-- ----------------------------
-- Primary Key structure for table warehouse_place
-- ----------------------------
ALTER TABLE "public"."warehouse_place" ADD CONSTRAINT "warehouse_place_pkey" PRIMARY KEY ("id");

-- ----------------------------
-- Indexes structure for table warehouse_place_item
-- ----------------------------
CREATE INDEX "idx_date_in" ON "public"."warehouse_place_item" USING btree (
  "date_in" "pg_catalog"."timestamptz_ops" ASC NULLS LAST
);
CREATE INDEX "idx_date_out" ON "public"."warehouse_place_item" USING btree (
  "date_out" "pg_catalog"."timestamptz_ops" ASC NULLS LAST
);
CREATE INDEX "idx_order_item_id" ON "public"."warehouse_place_item" USING btree (
  "order_item_id" "pg_catalog"."int4_ops" ASC NULLS LAST
);
CREATE INDEX "idx_store_id" ON "public"."warehouse_place_item" USING btree (
  "warehouse_place_id" "pg_catalog"."int4_ops" ASC NULLS LAST
);
CREATE INDEX "idx_tid" ON "public"."warehouse_place_item" USING btree (
  "tid" COLLATE "pg_catalog"."default" "pg_catalog"."text_ops" ASC NULLS LAST
);
CREATE INDEX "idx_uid_in" ON "public"."warehouse_place_item" USING btree (
  "uid_in" "pg_catalog"."int4_ops" ASC NULLS LAST
);
CREATE INDEX "idx_uid_out" ON "public"."warehouse_place_item" USING btree (
  "uid_out" "pg_catalog"."int4_ops" ASC NULLS LAST
);

-- ----------------------------
-- Primary Key structure for table warehouse_place_item
-- ----------------------------
ALTER TABLE "public"."warehouse_place_item" ADD CONSTRAINT "warehouse_place_item_pkey" PRIMARY KEY ("id");

-- ----------------------------
-- Indexes structure for table weights
-- ----------------------------
CREATE INDEX "idx_cid_num_id_unique" ON "public"."weights" USING btree (
  "ds_source" COLLATE "pg_catalog"."default" "pg_catalog"."text_ops" ASC NULLS LAST,
  "cid" COLLATE "pg_catalog"."default" "pg_catalog"."text_ops" ASC NULLS LAST,
  "num_iid" COLLATE "pg_catalog"."default" "pg_catalog"."text_ops" ASC NULLS LAST
);
CREATE INDEX "idx_ds_source_weights" ON "public"."weights" USING btree (
  "ds_source" COLLATE "pg_catalog"."default" "pg_catalog"."text_ops" ASC NULLS LAST
);
CREATE INDEX "idx_weight_checked" ON "public"."weights" USING btree (
  "checked" "pg_catalog"."int4_ops" ASC NULLS LAST
);
CREATE INDEX "idx_weight_cid" ON "public"."weights" USING btree (
  "ds_source" COLLATE "pg_catalog"."default" "pg_catalog"."text_ops" ASC NULLS LAST,
  "cid" COLLATE "pg_catalog"."default" "pg_catalog"."text_ops" ASC NULLS LAST
);
CREATE INDEX "idx_weight_maxw" ON "public"."weights" USING btree (
  "max_weight" "pg_catalog"."numeric_ops" ASC NULLS LAST
);
CREATE INDEX "idx_weight_minw" ON "public"."weights" USING btree (
  "min_weight" "pg_catalog"."numeric_ops" ASC NULLS LAST
);
CREATE INDEX "idx_weight_num_iid" ON "public"."weights" USING btree (
  "ds_source" COLLATE "pg_catalog"."default" "pg_catalog"."text_ops" ASC NULLS LAST,
  "num_iid" COLLATE "pg_catalog"."default" "pg_catalog"."text_ops" ASC NULLS LAST
);

-- ----------------------------
-- Primary Key structure for table weights
-- ----------------------------
ALTER TABLE "public"."weights" ADD CONSTRAINT "weights_pkey" PRIMARY KEY ("id");

-- ----------------------------
-- Foreign Keys structure for table addresses
-- ----------------------------
ALTER TABLE "public"."addresses" ADD CONSTRAINT "fk_to_uisers" FOREIGN KEY ("uid") REFERENCES "public"."users" ("uid") ON DELETE CASCADE ON UPDATE CASCADE;

-- ----------------------------
-- Foreign Keys structure for table bills
-- ----------------------------
ALTER TABLE "public"."bills" ADD CONSTRAINT "bills_manager_fkey" FOREIGN KEY ("manager_id") REFERENCES "public"."users" ("uid") ON DELETE CASCADE ON UPDATE CASCADE;
ALTER TABLE "public"."bills" ADD CONSTRAINT "bills_status_fkey" FOREIGN KEY ("status") REFERENCES "public"."bills_statuses" ("value") ON DELETE CASCADE ON UPDATE CASCADE;

-- ----------------------------
-- Foreign Keys structure for table bills_comments
-- ----------------------------
ALTER TABLE "public"."bills_comments" ADD CONSTRAINT "bills_comments_bid_fkey" FOREIGN KEY ("bid") REFERENCES "public"."bills" ("id") ON DELETE CASCADE ON UPDATE CASCADE;
ALTER TABLE "public"."bills_comments" ADD CONSTRAINT "bills_comments_uid_fkey" FOREIGN KEY ("uid") REFERENCES "public"."users" ("uid") ON DELETE CASCADE ON UPDATE CASCADE;

-- ----------------------------
-- Foreign Keys structure for table bills_comments_attaches
-- ----------------------------
ALTER TABLE "public"."bills_comments_attaches" ADD CONSTRAINT "bills_comments_attaches_comment_id_fkey" FOREIGN KEY ("comment_id") REFERENCES "public"."bills_comments" ("id") ON DELETE CASCADE ON UPDATE CASCADE;

-- ----------------------------
-- Foreign Keys structure for table bills_payments
-- ----------------------------
ALTER TABLE "public"."bills_payments" ADD CONSTRAINT "bills_payments_bid_fkey" FOREIGN KEY ("bid") REFERENCES "public"."bills" ("id") ON DELETE CASCADE ON UPDATE CASCADE;
ALTER TABLE "public"."bills_payments" ADD CONSTRAINT "bills_payments_uid_fkey" FOREIGN KEY ("uid") REFERENCES "public"."users" ("uid") ON DELETE CASCADE ON UPDATE CASCADE;

-- ----------------------------
-- Foreign Keys structure for table blog_comments
-- ----------------------------
ALTER TABLE "public"."blog_comments" ADD CONSTRAINT "blog_comments_ibfk_1" FOREIGN KEY ("post_id") REFERENCES "public"."blog_posts" ("id") ON DELETE CASCADE ON UPDATE CASCADE;
ALTER TABLE "public"."blog_comments" ADD CONSTRAINT "blog_comments_ibfk_2" FOREIGN KEY ("uid") REFERENCES "public"."users" ("uid") ON DELETE CASCADE ON UPDATE CASCADE;

-- ----------------------------
-- Foreign Keys structure for table blog_posts
-- ----------------------------
ALTER TABLE "public"."blog_posts" ADD CONSTRAINT "blog_posts_ibfk_1" FOREIGN KEY ("category_id") REFERENCES "public"."blog_categories" ("id") ON DELETE CASCADE ON UPDATE CASCADE;
ALTER TABLE "public"."blog_posts" ADD CONSTRAINT "blog_posts_ibfk_2" FOREIGN KEY ("uid") REFERENCES "public"."users" ("uid") ON DELETE CASCADE ON UPDATE CASCADE;

-- ----------------------------
-- Foreign Keys structure for table cart
-- ----------------------------
ALTER TABLE "public"."cart" ADD CONSTRAINT "fk_ds_source1" FOREIGN KEY ("ds_source") REFERENCES "public"."categories_ext_sources" ("ds_source") ON DELETE CASCADE ON UPDATE CASCADE;

-- ----------------------------
-- Foreign Keys structure for table categories_ext
-- ----------------------------
ALTER TABLE "public"."categories_ext" ADD CONSTRAINT "fk_ds_source" FOREIGN KEY ("ds_source") REFERENCES "public"."categories_ext_sources" ("ds_source") ON DELETE CASCADE ON UPDATE CASCADE;
ALTER TABLE "public"."categories_ext" ADD CONSTRAINT "fk_parent_to_id" FOREIGN KEY ("parent") REFERENCES "public"."categories_ext" ("id") ON DELETE CASCADE ON UPDATE CASCADE;

-- ----------------------------
-- Foreign Keys structure for table categories_ext_source
-- ----------------------------
ALTER TABLE "public"."categories_ext_source" ADD CONSTRAINT "fk_ds_source2" FOREIGN KEY ("ds_source") REFERENCES "public"."categories_ext_sources" ("ds_source") ON DELETE CASCADE ON UPDATE CASCADE;

-- ----------------------------
-- Foreign Keys structure for table categories_prices
-- ----------------------------
ALTER TABLE "public"."categories_prices" ADD CONSTRAINT "fk_ds_source4" FOREIGN KEY ("ds_source") REFERENCES "public"."categories_ext_sources" ("ds_source") ON DELETE CASCADE ON UPDATE CASCADE;

-- ----------------------------
-- Foreign Keys structure for table cms_pages
-- ----------------------------
ALTER TABLE "public"."cms_pages" ADD CONSTRAINT "cms_pages_ibfk_1" FOREIGN KEY ("parent") REFERENCES "public"."cms_pages" ("id") ON DELETE CASCADE ON UPDATE CASCADE;

-- ----------------------------
-- Foreign Keys structure for table cms_pages_content
-- ----------------------------
ALTER TABLE "public"."cms_pages_content" ADD CONSTRAINT "cms_pages_content_ibfk_1" FOREIGN KEY ("page_id") REFERENCES "public"."cms_pages" ("page_id") ON DELETE CASCADE ON UPDATE CASCADE;

-- ----------------------------
-- Foreign Keys structure for table events_log
-- ----------------------------
ALTER TABLE "public"."events_log" ADD CONSTRAINT "fk_eventlog_e" FOREIGN KEY ("event_name") REFERENCES "public"."events" ("event_name") ON DELETE CASCADE ON UPDATE CASCADE;
ALTER TABLE "public"."events_log" ADD CONSTRAINT "fk_eventlog_uid" FOREIGN KEY ("uid") REFERENCES "public"."users" ("uid") ON DELETE CASCADE ON UPDATE CASCADE;

-- ----------------------------
-- Foreign Keys structure for table featured
-- ----------------------------
ALTER TABLE "public"."featured" ADD CONSTRAINT "fk_ds_source6" FOREIGN KEY ("ds_source") REFERENCES "public"."categories_ext_sources" ("ds_source") ON DELETE CASCADE ON UPDATE CASCADE;

-- ----------------------------
-- Foreign Keys structure for table log_user_activity
-- ----------------------------
ALTER TABLE "public"."log_user_activity" ADD CONSTRAINT "log_user_activity_uid_fkey" FOREIGN KEY ("uid") REFERENCES "public"."users" ("uid") ON DELETE CASCADE ON UPDATE CASCADE;

-- ----------------------------
-- Foreign Keys structure for table messages
-- ----------------------------
ALTER TABLE "public"."messages" ADD CONSTRAINT "fk_to_questions" FOREIGN KEY ("qid") REFERENCES "public"."questions" ("id") ON DELETE CASCADE ON UPDATE CASCADE;

-- ----------------------------
-- Foreign Keys structure for table module_news
-- ----------------------------
ALTER TABLE "public"."module_news" ADD CONSTRAINT "fk_admmess_to_uid" FOREIGN KEY ("uid") REFERENCES "public"."users" ("uid") ON DELETE CASCADE ON UPDATE CASCADE;

-- ----------------------------
-- Foreign Keys structure for table module_tabs_history
-- ----------------------------
ALTER TABLE "public"."module_tabs_history" ADD CONSTRAINT "fk_admin_history_to_uid" FOREIGN KEY ("uid") REFERENCES "public"."users" ("uid") ON DELETE CASCADE ON UPDATE CASCADE;

-- ----------------------------
-- Foreign Keys structure for table obj_devices_manual_data
-- ----------------------------
ALTER TABLE "public"."obj_devices_manual_data" ADD CONSTRAINT "obj_devices_manual_data_device_id_fkey" FOREIGN KEY ("device_id") REFERENCES "public"."obj_devices_manual" ("devices_id") ON DELETE CASCADE ON UPDATE RESTRICT;

-- ----------------------------
-- Foreign Keys structure for table obj_devices_startpoints
-- ----------------------------
ALTER TABLE "public"."obj_devices_startpoints" ADD CONSTRAINT "obj_devices_startpoints_devices_id_fkey" FOREIGN KEY ("devices_id") REFERENCES "public"."obj_devices_manual" ("devices_id") ON DELETE CASCADE ON UPDATE CASCADE;
ALTER TABLE "public"."obj_devices_startpoints" ADD CONSTRAINT "obj_devices_startpoints_uid_fkey" FOREIGN KEY ("uid") REFERENCES "public"."users" ("uid") ON DELETE CASCADE ON UPDATE CASCADE;

-- ----------------------------
-- Foreign Keys structure for table obj_devices_tariffs
-- ----------------------------
ALTER TABLE "public"."obj_devices_tariffs" ADD CONSTRAINT "obj_devices_tariffs_devices_id_fkey" FOREIGN KEY ("devices_id") REFERENCES "public"."obj_devices_manual" ("devices_id") ON DELETE CASCADE ON UPDATE CASCADE;
ALTER TABLE "public"."obj_devices_tariffs" ADD CONSTRAINT "obj_devices_tariffs_tariffs_id_fkey" FOREIGN KEY ("tariffs_id") REFERENCES "public"."obj_tariffs" ("tariffs_id") ON DELETE CASCADE ON UPDATE CASCADE;

-- ----------------------------
-- Foreign Keys structure for table obj_lands_devices
-- ----------------------------
ALTER TABLE "public"."obj_lands_devices" ADD CONSTRAINT "obj_lands_devices_devices_id_fkey" FOREIGN KEY ("devices_id") REFERENCES "public"."obj_devices_manual" ("devices_id") ON DELETE CASCADE ON UPDATE CASCADE;
ALTER TABLE "public"."obj_lands_devices" ADD CONSTRAINT "obj_lands_devices_lands_id_fkey" FOREIGN KEY ("lands_id") REFERENCES "public"."obj_lands" ("lands_id") ON DELETE CASCADE ON UPDATE CASCADE;

-- ----------------------------
-- Foreign Keys structure for table obj_lands_tariffs
-- ----------------------------
ALTER TABLE "public"."obj_lands_tariffs" ADD CONSTRAINT "obj_lands_tariffs_lands_id_fkey" FOREIGN KEY ("lands_id") REFERENCES "public"."obj_lands" ("lands_id") ON DELETE CASCADE ON UPDATE CASCADE;
ALTER TABLE "public"."obj_lands_tariffs" ADD CONSTRAINT "obj_lands_tariffs_tariffs_id_fkey" FOREIGN KEY ("tariffs_id") REFERENCES "public"."obj_tariffs" ("tariffs_id") ON DELETE CASCADE ON UPDATE CASCADE;

-- ----------------------------
-- Foreign Keys structure for table obj_news
-- ----------------------------
ALTER TABLE "public"."obj_news" ADD CONSTRAINT "obj_news_news_author_fkey" FOREIGN KEY ("news_author") REFERENCES "public"."users" ("uid") ON DELETE CASCADE ON UPDATE RESTRICT;
ALTER TABLE "public"."obj_news" ADD CONSTRAINT "obj_news_news_type_fkey" FOREIGN KEY ("news_type") REFERENCES "public"."dic_custom" ("val_id") ON DELETE RESTRICT ON UPDATE RESTRICT;

-- ----------------------------
-- Foreign Keys structure for table obj_news_confirmations
-- ----------------------------
ALTER TABLE "public"."obj_news_confirmations" ADD CONSTRAINT "obj_news_confirmations_news_id_fkey" FOREIGN KEY ("news_id") REFERENCES "public"."obj_news" ("news_id") ON DELETE CASCADE ON UPDATE CASCADE;
ALTER TABLE "public"."obj_news_confirmations" ADD CONSTRAINT "obj_news_confirmations_uid_fkey" FOREIGN KEY ("uid") REFERENCES "public"."users" ("uid") ON DELETE CASCADE ON UPDATE CASCADE;

-- ----------------------------
-- Foreign Keys structure for table obj_tariffs
-- ----------------------------
ALTER TABLE "public"."obj_tariffs" ADD CONSTRAINT "obj_tariffs_acceptor_fkey" FOREIGN KEY ("acceptor_id") REFERENCES "public"."obj_tariffs_acceptors" ("tariff_acceptors_id") ON DELETE RESTRICT ON UPDATE CASCADE;

-- ----------------------------
-- Foreign Keys structure for table obj_users_lands
-- ----------------------------
ALTER TABLE "public"."obj_users_lands" ADD CONSTRAINT "users_lands_lands_id_fkey" FOREIGN KEY ("lands_id") REFERENCES "public"."obj_lands" ("lands_id") ON DELETE CASCADE ON UPDATE CASCADE;
ALTER TABLE "public"."obj_users_lands" ADD CONSTRAINT "users_lands_uid_fkey" FOREIGN KEY ("uid") REFERENCES "public"."users" ("uid") ON DELETE CASCADE ON UPDATE CASCADE;

-- ----------------------------
-- Foreign Keys structure for table obj_votings
-- ----------------------------
ALTER TABLE "public"."obj_votings" ADD CONSTRAINT "obj_votings_votings_author_fkey" FOREIGN KEY ("votings_author") REFERENCES "public"."users" ("uid") ON DELETE RESTRICT ON UPDATE RESTRICT;
ALTER TABLE "public"."obj_votings" ADD CONSTRAINT "obj_votings_votings_type_fkey" FOREIGN KEY ("votings_type") REFERENCES "public"."dic_custom" ("val_id") ON DELETE RESTRICT ON UPDATE RESTRICT;

-- ----------------------------
-- Foreign Keys structure for table obj_votings_results
-- ----------------------------
ALTER TABLE "public"."obj_votings_results" ADD CONSTRAINT "obj_votings_results_uid_fkey" FOREIGN KEY ("uid") REFERENCES "public"."users" ("uid") ON DELETE CASCADE ON UPDATE CASCADE;
ALTER TABLE "public"."obj_votings_results" ADD CONSTRAINT "obj_votings_results_voting_id_fkey" FOREIGN KEY ("votings_id") REFERENCES "public"."obj_votings" ("votings_id") ON DELETE CASCADE ON UPDATE CASCADE;

-- ----------------------------
-- Foreign Keys structure for table orders
-- ----------------------------
ALTER TABLE "public"."orders" ADD CONSTRAINT "fk_orders_managers" FOREIGN KEY ("manager") REFERENCES "public"."users" ("uid") ON DELETE CASCADE ON UPDATE CASCADE;
ALTER TABLE "public"."orders" ADD CONSTRAINT "fk_orders_users" FOREIGN KEY ("uid") REFERENCES "public"."users" ("uid") ON DELETE CASCADE ON UPDATE CASCADE;
ALTER TABLE "public"."orders" ADD CONSTRAINT "fk_to_statuses" FOREIGN KEY ("status") REFERENCES "public"."orders_statuses" ("value") ON DELETE CASCADE ON UPDATE CASCADE;

-- ----------------------------
-- Foreign Keys structure for table orders_comments
-- ----------------------------
ALTER TABLE "public"."orders_comments" ADD CONSTRAINT "fk_orders" FOREIGN KEY ("oid") REFERENCES "public"."orders" ("id") ON DELETE CASCADE ON UPDATE CASCADE;
ALTER TABLE "public"."orders_comments" ADD CONSTRAINT "fk_users" FOREIGN KEY ("uid") REFERENCES "public"."users" ("uid") ON DELETE CASCADE ON UPDATE CASCADE;

-- ----------------------------
-- Foreign Keys structure for table orders_comments_attaches
-- ----------------------------
ALTER TABLE "public"."orders_comments_attaches" ADD CONSTRAINT "fk_to_comments" FOREIGN KEY ("comment_id") REFERENCES "public"."orders_comments" ("id") ON DELETE CASCADE ON UPDATE CASCADE;

-- ----------------------------
-- Foreign Keys structure for table orders_items
-- ----------------------------
ALTER TABLE "public"."orders_items" ADD CONSTRAINT "fk_ds_source10" FOREIGN KEY ("ds_source") REFERENCES "public"."categories_ext_sources" ("ds_source") ON DELETE CASCADE ON UPDATE CASCADE;
ALTER TABLE "public"."orders_items" ADD CONSTRAINT "fk_items_status" FOREIGN KEY ("status") REFERENCES "public"."orders_items_statuses" ("id") ON DELETE CASCADE ON UPDATE CASCADE;
ALTER TABLE "public"."orders_items" ADD CONSTRAINT "fk_orders_items" FOREIGN KEY ("oid") REFERENCES "public"."orders" ("id") ON DELETE CASCADE ON UPDATE CASCADE;

-- ----------------------------
-- Foreign Keys structure for table orders_items_comments
-- ----------------------------
ALTER TABLE "public"."orders_items_comments" ADD CONSTRAINT "fk_to_item1" FOREIGN KEY ("item_id") REFERENCES "public"."orders_items" ("id") ON DELETE CASCADE ON UPDATE CASCADE;
ALTER TABLE "public"."orders_items_comments" ADD CONSTRAINT "fk_to_user1" FOREIGN KEY ("uid") REFERENCES "public"."users" ("uid") ON DELETE CASCADE ON UPDATE CASCADE;

-- ----------------------------
-- Foreign Keys structure for table orders_items_comments_attaches
-- ----------------------------
ALTER TABLE "public"."orders_items_comments_attaches" ADD CONSTRAINT "fk_to_orderitemscomments" FOREIGN KEY ("comment_id") REFERENCES "public"."orders_items_comments" ("id") ON DELETE CASCADE ON UPDATE CASCADE;

-- ----------------------------
-- Foreign Keys structure for table orders_payments
-- ----------------------------
ALTER TABLE "public"."orders_payments" ADD CONSTRAINT "fk_to_orders" FOREIGN KEY ("oid") REFERENCES "public"."orders" ("id") ON DELETE CASCADE ON UPDATE CASCADE;
ALTER TABLE "public"."orders_payments" ADD CONSTRAINT "fk_to_users2" FOREIGN KEY ("uid") REFERENCES "public"."users" ("uid") ON DELETE CASCADE ON UPDATE CASCADE;

-- ----------------------------
-- Foreign Keys structure for table parcels
-- ----------------------------
ALTER TABLE "public"."parcels" ADD CONSTRAINT "parcels_ibfk_1" FOREIGN KEY ("manager") REFERENCES "public"."users" ("uid") ON DELETE CASCADE ON UPDATE CASCADE;
ALTER TABLE "public"."parcels" ADD CONSTRAINT "parcels_ibfk_2" FOREIGN KEY ("uid") REFERENCES "public"."users" ("uid") ON DELETE CASCADE ON UPDATE CASCADE;
ALTER TABLE "public"."parcels" ADD CONSTRAINT "parcels_ibfk_3" FOREIGN KEY ("addresses_id") REFERENCES "public"."addresses" ("id") ON DELETE CASCADE ON UPDATE CASCADE;
ALTER TABLE "public"."parcels" ADD CONSTRAINT "parcels_ibfk_4" FOREIGN KEY ("status") REFERENCES "public"."parcels_statuses" ("value") ON DELETE CASCADE ON UPDATE CASCADE;

-- ----------------------------
-- Foreign Keys structure for table parcels_cart
-- ----------------------------
ALTER TABLE "public"."parcels_cart" ADD CONSTRAINT "fk_to_orders_items" FOREIGN KEY ("iid") REFERENCES "public"."orders_items" ("id") ON DELETE CASCADE ON UPDATE CASCADE;
ALTER TABLE "public"."parcels_cart" ADD CONSTRAINT "fk_to_users" FOREIGN KEY ("uid") REFERENCES "public"."users" ("uid") ON DELETE CASCADE ON UPDATE CASCADE;

-- ----------------------------
-- Foreign Keys structure for table parcels_comments
-- ----------------------------
ALTER TABLE "public"."parcels_comments" ADD CONSTRAINT "parcels_comments_ibfk_1" FOREIGN KEY ("pid") REFERENCES "public"."parcels" ("id") ON DELETE CASCADE ON UPDATE CASCADE;
ALTER TABLE "public"."parcels_comments" ADD CONSTRAINT "parcels_comments_ibfk_2" FOREIGN KEY ("uid") REFERENCES "public"."users" ("uid") ON DELETE CASCADE ON UPDATE CASCADE;

-- ----------------------------
-- Foreign Keys structure for table parcels_comments_attaches
-- ----------------------------
ALTER TABLE "public"."parcels_comments_attaches" ADD CONSTRAINT "parcels_comments_attaches_ibfk_1" FOREIGN KEY ("comment_id") REFERENCES "public"."parcels_comments" ("id") ON DELETE CASCADE ON UPDATE CASCADE;

-- ----------------------------
-- Foreign Keys structure for table parcels_items
-- ----------------------------
ALTER TABLE "public"."parcels_items" ADD CONSTRAINT "parcels_items_ibfk_3" FOREIGN KEY ("pid") REFERENCES "public"."parcels" ("id") ON DELETE CASCADE ON UPDATE CASCADE;
ALTER TABLE "public"."parcels_items" ADD CONSTRAINT "parcels_items_ibfk_4" FOREIGN KEY ("iid") REFERENCES "public"."orders_items" ("id") ON DELETE CASCADE ON UPDATE CASCADE;

-- ----------------------------
-- Foreign Keys structure for table parcels_payments
-- ----------------------------
ALTER TABLE "public"."parcels_payments" ADD CONSTRAINT "parcels_payments_ibfk_1" FOREIGN KEY ("pid") REFERENCES "public"."parcels" ("id") ON DELETE CASCADE ON UPDATE CASCADE;
ALTER TABLE "public"."parcels_payments" ADD CONSTRAINT "parcels_payments_ibfk_2" FOREIGN KEY ("uid") REFERENCES "public"."users" ("uid") ON DELETE CASCADE ON UPDATE CASCADE;

-- ----------------------------
-- Foreign Keys structure for table payments
-- ----------------------------
ALTER TABLE "public"."payments" ADD CONSTRAINT "fk_payments_users" FOREIGN KEY ("uid") REFERENCES "public"."users" ("uid") ON DELETE CASCADE ON UPDATE RESTRICT;
ALTER TABLE "public"."payments" ADD CONSTRAINT "payments_manager_id_fkey" FOREIGN KEY ("manager_id") REFERENCES "public"."users" ("uid") ON DELETE CASCADE ON UPDATE RESTRICT;

-- ----------------------------
-- Foreign Keys structure for table t_message
-- ----------------------------
ALTER TABLE "public"."t_message" ADD CONSTRAINT "fk_to source_messages" FOREIGN KEY ("id") REFERENCES "public"."t_source_message" ("id") ON DELETE CASCADE ON UPDATE CASCADE;

-- ----------------------------
-- Foreign Keys structure for table user_notice
-- ----------------------------
ALTER TABLE "public"."user_notice" ADD CONSTRAINT "fk_user_notice_users" FOREIGN KEY ("uid") REFERENCES "public"."users" ("uid") ON DELETE CASCADE ON UPDATE CASCADE;

-- ----------------------------
-- Foreign Keys structure for table users
-- ----------------------------
ALTER TABLE "public"."users" ADD CONSTRAINT "fk_to_roles" FOREIGN KEY ("role") REFERENCES "public"."access_rights" ("role") ON DELETE RESTRICT ON UPDATE RESTRICT;
ALTER TABLE "public"."users" ADD CONSTRAINT "users_debtor_status_fkey" FOREIGN KEY ("debtor_status") REFERENCES "public"."dic_custom" ("val_id") ON DELETE RESTRICT ON UPDATE RESTRICT;

-- ----------------------------
-- Foreign Keys structure for table warehouse_place
-- ----------------------------
ALTER TABLE "public"."warehouse_place" ADD CONSTRAINT "wh_wid_id" FOREIGN KEY ("wid") REFERENCES "public"."warehouse" ("id") ON DELETE CASCADE ON UPDATE CASCADE;

-- ----------------------------
-- Foreign Keys structure for table warehouse_place_item
-- ----------------------------
ALTER TABLE "public"."warehouse_place_item" ADD CONSTRAINT "fk_warehouse_place_id" FOREIGN KEY ("warehouse_place_id") REFERENCES "public"."warehouse_place" ("id") ON DELETE CASCADE ON UPDATE CASCADE;

-- ----------------------------
-- Foreign Keys structure for table weights
-- ----------------------------
ALTER TABLE "public"."weights" ADD CONSTRAINT "fk_ds_source12" FOREIGN KEY ("ds_source") REFERENCES "public"."categories_ext_sources" ("ds_source") ON DELETE CASCADE ON UPDATE CASCADE;
