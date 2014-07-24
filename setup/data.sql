INSERT INTO `data_categories` (`id`, `name`) VALUES
(1, 'NCT'),
(2, 'Annotations'),
(4, 'PubMed'),
(6, 'EudraCT'),
(7, 'isrctn'),
(8, 'Products'), 
(9, 'Areas');

INSERT INTO `settings` (`name`, `value`) VALUES
('results_per_page', '50');

INSERT INTO `users` (`id`, `username`, `password`, `fingerprint`, `email`, `userlevel`) VALUES
(1, 'root', 'aa2a8ecbebcc6d8113fd12ea4e9d96f5999f4f9e44f8e12f', NULL, 'root@example.com', 'root'),
(2, 'user', '290799c2acc02a8de9a714868f7ae14003ea57d05b07c596', NULL, 'user@example.com', 'admin');

INSERT INTO `user_permissions` (`id`, `name`, `type`, `level`) VALUES
(1, 'search', 'readonly', 1),
(2, 'heatmap', 'readonly', 1),
(3, 'heatmap', 'contained', 2),
(4, 'heatmap', 'admin', 3),
(5, 'heatmap', 'admin', 4),
(10, 'trial_tracker', 'readonly', 1),
(11, 'trial_tracker', 'contained', 2),
(12, 'trial_tracker', 'admin', 3),
(13, 'trial_tracker', 'admin', 4),
(14, 'update_scan', 'readonly', 1),
(15, 'update_scan', 'contained', 2),
(16, 'update_scan', 'admin', 3),
(17, 'update_scan', 'admin', 4),
(18, 'xml_import', 'editing', 1),
(19, 'user_management', 'admin', 1),
(20, 'field_editor', 'admin', 1),
(21, 'field_editor', 'core', 2),
(22, 'scheduler', 'contained', 1),
(23, 'scheduler', 'admin', 2),
(24, 'scheduler', 'admin', 3),
(25, 'editing', 'editing', 1),
(26, 'editing', 'editing', 2),
(27, 'editing', 'editing', 3),
(28, 'editing', 'core', 4),
(29, 'settings', 'admin', 1);

LOCK TABLES `commentics_version` WRITE;
/*!40000 ALTER TABLE `commentics_version` DISABLE KEYS */;
INSERT INTO `commentics_version` VALUES (1,'2.4','Installation','2013-10-11 14:21:04');
/*!40000 ALTER TABLE `commentics_version` ENABLE KEYS */;
UNLOCK TABLES;

LOCK TABLES `commentics_admins` WRITE;
/*!40000 ALTER TABLE `commentics_admins` DISABLE KEYS */;
INSERT INTO `commentics_admins` VALUES (1,'admin','5f4dcc3b5aa765d61d8327deb882cf99','user@example.com','24.213.29.234','b9ptsmtopwq09hivxjvs',1,'both',1,1,1,1,0,0,'2013-10-11 14:21:03',0,'',1,1,'2013-10-11 14:21:03');
/*!40000 ALTER TABLE `commentics_admins` ENABLE KEYS */;
UNLOCK TABLES;

LOCK TABLES `commentics_questions` WRITE;
/*!40000 ALTER TABLE `commentics_questions` DISABLE KEYS */;
INSERT INTO `commentics_questions` VALUES (1,'Enter the third letter of the word <i>castle</i>.','s'),(2,'Enter the word <i>shark</i> backwards.','krahs'),(3,'What is the opposite word of <i>weak</i>?','strong'),(4,'Is it true or false that green is a number?','false'),(5,'Which word <b>in</b> this sentence is bold?','in'),(6,'Which is darker: black or white?','black'),(7,'Enter the last letter of the word <i>satellite</i>.','e'),(8,'What is the opposite word of <i>small</i>?','big'),(9,'Out of 56, 14 or 27, which is the smallest?','14|fourteen'),(10,'Enter the word <i>hand</i> backwards.','dnah'),(11,'Type the numbers for four hundred seventy-two.','472'),(12,'Enter the fifth word of this sentence.','of'),(13,'Enter the third word of this sentence.','third'),(14,'What is the sum of 1 + 2 + 3?','6|six'),(15,'Enter the word <i>table</i> backwards.','elbat'),(16,'What is the day after Friday?','saturday'),(17,'Is ice cream hot or cold?','cold'),(18,'What is the next number: 10, 12, 14, ..?','16|sixteen'),(19,'What is the fifth month of the year?','may'),(20,'Type the word for the number 9.','nine');
/*!40000 ALTER TABLE `commentics_questions` ENABLE KEYS */;
UNLOCK TABLES;

LOCK TABLES `commentics_access` WRITE;
/*!40000 ALTER TABLE `commentics_access` DISABLE KEYS */;
INSERT INTO `commentics_access` VALUES (1,1,'admin','24.213.29.234','dashboard','2013-10-11 14:21:14'),(2,1,'admin','24.213.29.234','settings_system','2013-10-11 14:21:23'),(3,1,'admin','24.213.29.234','settings_security','2013-10-11 14:23:38'),(4,1,'admin','24.213.29.234','settings_system','2013-10-11 14:23:43'),(5,1,'admin','24.213.29.234','dashboard','2013-10-11 14:27:52');
/*!40000 ALTER TABLE `commentics_access` ENABLE KEYS */;
UNLOCK TABLES;

LOCK TABLES `commentics_logins` WRITE;
/*!40000 ALTER TABLE `commentics_logins` DISABLE KEYS */;
INSERT INTO `commentics_logins` VALUES (1,'2013-10-11 14:21:03'),(2,'2013-10-11 14:21:03');
/*!40000 ALTER TABLE `commentics_logins` ENABLE KEYS */;
UNLOCK TABLES;

INSERT INTO `commentics_settings` VALUES (1,'admin_panel','checklist_complete','1'),(2,'approval','approve_comments','0'),(3,'approval','approve_notifications','0'),(4,'approval','trust_users','0'),(5,'commentics','powered_by','text'),(6,'commentics','powered_by_new_window','1'),(7,'comments','show_average_rating','1'),(8,'comments','comments_order','1'),(9,'comments','show_website','1'),(10,'comments','show_town','1'),(11,'comments','show_country','1'),(12,'comments','show_comment_count','1'),(13,'comments','show_says','1'),(14,'comments','show_rating','1'),(15,'comments','show_date','1'),(16,'comments','show_like','1'),(17,'comments','show_dislike','1'),(18,'comments','show_flag','1'),(19,'comments','show_permalink','1'),(20,'comments','show_reply','1'),(21,'comments','show_rss_this_page','1'),(22,'comments','show_rss_all_pages','1'),(23,'comments','show_page_number','1'),(24,'comments','time_format','g:ia'),(25,'comments','date_time_format','jS F Y g:ia'),(26,'comments','enabled_pagination','1'),(27,'comments','show_pagination_top','1'),(28,'comments','show_pagination_bottom','1'),(29,'comments','comments_per_page','20'),(30,'comments','range_of_pages','2'),(31,'comments','js_vote_ok','1'),(32,'comments','flag_max_per_user','3'),(33,'comments','flag_min_per_comment','2'),(34,'comments','flag_disapprove','1'),(35,'comments','rich_snippets','0'),(36,'comments','rich_snippets_markup','Microformats'),(37,'comments','scroll_reply','1'),(38,'comments','scroll_speed','50'),(39,'comments','reply_depth','5'),(40,'comments','reply_arrow','1'),(41,'comments','show_sort_by','1'),(42,'comments','show_sort_by_1','1'),(43,'comments','show_sort_by_2','1'),(44,'comments','show_sort_by_3','1'),(45,'comments','show_sort_by_4','1'),(46,'comments','show_sort_by_5','1'),(47,'comments','show_sort_by_6','1'),(48,'comments','show_gravatar','1'),(49,'comments','gravatar_default','mm'),(50,'comments','gravatar_custom','http://'),(51,'comments','gravatar_size','70'),(52,'comments','gravatar_rating','g'),(53,'comments','show_topic','1'),(54,'comments','show_read_more','1'),(55,'comments','read_more_limit','500'),(56,'email','transport_method','php'),(57,'email','smtp_host','smtp.example.com'),(58,'email','smtp_port','25'),(59,'email','smtp_encrypt','off'),(60,'email','smtp_auth','0'),(61,'email','smtp_username',''),(62,'email','smtp_password',''),(63,'email','sendmail_path','/usr/sbin/sendmail'),(64,'email','setup_from_name','Larvol Sigma'),(65,'email','setup_from_email','comments@larvolsigma.com'),(66,'email','setup_reply_to','no-reply@larvolsigma.com'),(67,'email','subscriber_confirmation_subject','Comments: Subscription Confirmation'),(68,'email','subscriber_confirmation_from_name','Larvol Sigma'),(69,'email','subscriber_confirmation_from_email','comments@larvolsigma.com'),(70,'email','subscriber_confirmation_reply_to','no-reply@larvolsigma.com'),(71,'email','subscriber_notification_subject','Comments: Notification'),(72,'email','subscriber_notification_from_name','Larvol Sigma'),(73,'email','subscriber_notification_from_email','comments@larvolsigma.com'),(74,'email','subscriber_notification_reply_to','no-reply@larvolsigma.com'),(75,'email','admin_email_test_subject','Comments: Email Test'),(76,'email','admin_email_test_from_name','Larvol Sigma'),(77,'email','admin_email_test_from_email','comments@larvolsigma.com'),(78,'email','admin_email_test_reply_to','no-reply@larvolsigma.com'),(79,'email','admin_new_ban_subject','Comments: New Ban'),(80,'email','admin_new_ban_from_name','Larvol Sigma'),(81,'email','admin_new_ban_from_email','comments@larvolsigma.com'),(82,'email','admin_new_ban_reply_to','no-reply@larvolsigma.com'),(83,'email','admin_new_comment_approve_subject','New Comment: Approve'),(84,'email','admin_new_comment_approve_from_name','Larvol Sigma'),(85,'email','admin_new_comment_approve_from_email','comments@larvolsigma.com'),(86,'email','admin_new_comment_approve_reply_to','no-reply@larvolsigma.com'),(87,'email','admin_new_comment_okay_subject','New Comment: Okay'),(88,'email','admin_new_comment_okay_from_name','Larvol Sigma'),(89,'email','admin_new_comment_okay_from_email','comments@larvolsigma.com'),(90,'email','admin_new_comment_okay_reply_to','no-reply@larvolsigma.com'),(91,'email','admin_new_flag_subject','Comments: New Flag'),(92,'email','admin_new_flag_from_name','Larvol Sigma'),(93,'email','admin_new_flag_from_email','comments@larvolsigma.com'),(94,'email','admin_new_flag_reply_to','no-reply@larvolsigma.com'),(95,'email','admin_reset_password_subject','Comments: Password Reset'),(96,'email','admin_reset_password_from_name','Larvol Sigma'),(97,'email','admin_reset_password_from_email','comments@larvolsigma.com'),(98,'email','admin_reset_password_reply_to','no-reply@larvolsigma.com'),(99,'email','signature','Larvol Sigma\r\nhttp://www.larvolsigma.com'),(100,'error_reporting','error_reporting_admin','1'),(101,'error_reporting','error_reporting_frontend','1'),(102,'error_reporting','error_reporting_method','log'),(103,'form','enabled_form','1'),(104,'form','display_javascript_disabled','1'),(105,'form','enabled_email','0'),(106,'form','enabled_website','0'),(107,'form','enabled_town','0'),(108,'form','enabled_country','0'),(109,'form','enabled_rating','0'),(110,'form','enabled_question','0'),(111,'form','enabled_captcha','0'),(112,'form','enabled_notify','1'),(113,'form','enabled_remember','0'),(114,'form','enabled_privacy','0'),(115,'form','enabled_terms','0'),(116,'form','required_email','1'),(117,'form','required_website','0'),(118,'form','required_town','0'),(119,'form','required_country','0'),(120,'form','required_rating','0'),(121,'form','display_required_symbol','1'),(122,'form','display_required_symbol_message','1'),(123,'form','display_email_note','1'),(124,'form','default_name',''),(125,'form','default_email',''),(126,'form','default_website','http://'),(127,'form','default_town',''),(128,'form','default_country',''),(129,'form','default_rating',''),(130,'form','default_comment',''),(131,'form','default_notify','1'),(132,'form','default_remember','1'),(133,'form','default_privacy','0'),(134,'form','default_terms','0'),(135,'form','state_name','normal'),(136,'form','state_email','normal'),(137,'form','state_website','normal'),(138,'form','state_town','normal'),(139,'form','state_country','normal'),(140,'form','field_maximum_name','30'),(141,'form','field_maximum_email','100'),(142,'form','field_maximum_website','100'),(143,'form','field_maximum_town','30'),(144,'form','field_maximum_question','30'),(145,'form','field_maximum_captcha','4'),(146,'form','enabled_bb_code','1'),(147,'form','enabled_bb_code_bold','1'),(148,'form','enabled_bb_code_italic','1'),(149,'form','enabled_bb_code_underline','1'),(150,'form','enabled_bb_code_strike','1'),(151,'form','enabled_bb_code_superscript','1'),(152,'form','enabled_bb_code_subscript','1'),(153,'form','enabled_bb_code_code','1'),(154,'form','enabled_bb_code_php_code','1'),(155,'form','enabled_bb_code_quote','1'),(156,'form','enabled_bb_code_line','1'),(157,'form','enabled_bb_code_list_bullet','1'),(158,'form','enabled_bb_code_list_numeric','1'),(159,'form','enabled_bb_code_url','1'),(160,'form','enabled_bb_code_email','1'),(161,'form','enabled_bb_code_image','1'),(162,'form','enabled_bb_code_video','1'),(163,'form','enabled_smilies','0'),(164,'form','enabled_smilies_smile','1'),(165,'form','enabled_smilies_sad','1'),(166,'form','enabled_smilies_huh','1'),(167,'form','enabled_smilies_laugh','1'),(168,'form','enabled_smilies_mad','1'),(169,'form','enabled_smilies_tongue','1'),(170,'form','enabled_smilies_crying','1'),(171,'form','enabled_smilies_grin','1'),(172,'form','enabled_smilies_wink','1'),(173,'form','enabled_smilies_scared','1'),(174,'form','enabled_smilies_cool','1'),(175,'form','enabled_smilies_sleep','1'),(176,'form','enabled_smilies_blush','1'),(177,'form','enabled_smilies_unsure','1'),(178,'form','enabled_smilies_shocked','1'),(179,'form','enabled_counter','1'),(180,'form','enabled_preview','1'),(181,'form','agree_to_preview','0'),(182,'form','recaptcha_public_key',''),(183,'form','recaptcha_private_key',''),(184,'form','recaptcha_theme','white'),(185,'form','recaptcha_language','en'),(186,'form','repeat_ratings','disable'),(187,'form','hide_form','0'),(188,'form','captcha_type','securimage'),(189,'form','securimage_width','150'),(190,'form','securimage_height','50'),(191,'form','securimage_length','4'),(192,'form','securimage_perturbation','.75'),(193,'form','securimage_lines','5'),(194,'form','securimage_noise','1'),(195,'form','securimage_text_color','#707070'),(196,'form','securimage_line_color','#707070'),(197,'form','securimage_back_color','#F0F0F0'),(198,'form','securimage_noise_color','#707070'),(199,'language','language_frontend','english'),(200,'language','language_backend','english'),(201,'maintenance','maintenance_mode','0'),(202,'maintenance','maintenance_message','<p>Currently under general maintenance.</p><p>Please check back shortly. Thanks.</p>'),(203,'notice','notice_manage_comments','1'),(204,'notice','notice_layout_form_questions','1'),(205,'notice','notice_settings_admin_detection','1'),(206,'notice','notice_settings_email_sender','1'),(207,'order','sort_order_parts','2,1'),(208,'order','sort_order_fields','1,2,3,4,5,6'),(209,'order','sort_order_captchas','1,2'),(210,'order','sort_order_checkboxes','1,2,3,4'),(211,'order','sort_order_buttons','1,2'),(212,'order','split_screen','0'),(213,'processor','one_name_enabled','0'),(214,'processor','fix_name_enabled','0'),(215,'processor','detect_link_in_name_enabled','1'),(216,'processor','link_in_name_action','reject'),(217,'processor','reserved_names_enabled','1'),(218,'processor','reserved_names_action','reject'),(219,'processor','dummy_names_enabled','1'),(220,'processor','dummy_names_action','reject'),(221,'processor','banned_names_enabled','1'),(222,'processor','banned_names_action','ban'),(223,'processor','reserved_emails_enabled','1'),(224,'processor','reserved_emails_action','reject'),(225,'processor','dummy_emails_enabled','1'),(226,'processor','dummy_emails_action','reject'),(227,'processor','banned_emails_enabled','1'),(228,'processor','banned_emails_action','ban'),(229,'processor','approve_websites','0'),(230,'processor','validate_website_ping','0'),(231,'processor','website_new_window','1'),(232,'processor','website_nofollow','1'),(233,'processor','reserved_websites_enabled','1'),(234,'processor','reserved_websites_action','reject'),(235,'processor','dummy_websites_enabled','1'),(236,'processor','dummy_websites_action','reject'),(237,'processor','banned_websites_as_website_enabled','1'),(238,'processor','banned_websites_as_website_action','ban'),(239,'processor','banned_websites_as_comment_enabled','1'),(240,'processor','banned_websites_as_comment_action','approve'),(241,'processor','reserved_towns_enabled','1'),(242,'processor','reserved_towns_action','reject'),(243,'processor','dummy_towns_enabled','1'),(244,'processor','dummy_towns_action','reject'),(245,'processor','banned_towns_enabled','1'),(246,'processor','banned_towns_action','ban'),(247,'processor','fix_town_enabled','0'),(248,'processor','detect_link_in_town_enabled','1'),(249,'processor','link_in_town_action','reject'),(250,'processor','comment_minimum_characters','2'),(251,'processor','comment_minimum_words','1'),(252,'processor','comment_maximum_characters','1000'),(253,'processor','comment_maximum_lines','50'),(254,'processor','comment_maximum_smilies','5'),(255,'processor','comment_parser_convert_links','1'),(256,'processor','comment_parser_convert_emails','1'),(257,'processor','comment_links_new_window','1'),(258,'processor','comment_links_nofollow','1'),(259,'processor','comment_line_breaks','1'),(260,'processor','long_word_length_to_deny','100'),(261,'processor','swear_word_masking','*****'),(262,'processor','check_capitals_enabled','0'),(263,'processor','check_capitals_percentage','50'),(264,'processor','check_capitals_action','reject'),(265,'processor','mild_swear_words_enabled','1'),(266,'processor','mild_swear_words_action','mask'),(267,'processor','strong_swear_words_enabled','1'),(268,'processor','strong_swear_words_action','mask_approve'),(269,'processor','spam_words_enabled','1'),(270,'processor','spam_words_action','approve'),(271,'processor','detect_link_in_comment_enabled','1'),(272,'processor','link_in_comment_action','approve'),(273,'processor','approve_images','1'),(274,'processor','approve_videos','1'),(275,'processor','check_repeats_enabled','0'),(276,'processor','check_repeats_action','reject'),(277,'processor','flood_control_delay_enabled','1'),(278,'processor','flood_control_delay_time','5'),(279,'processor','flood_control_delay_all_pages','1'),(280,'processor','flood_control_maximum_enabled','1'),(281,'processor','flood_control_maximum_amount','60'),(282,'processor','flood_control_maximum_period','1'),(283,'processor','flood_control_maximum_all_pages','1'),(284,'processor','akismet_enabled','0'),(285,'processor','akismet_key',''),(286,'processor','form_cookie','0'),(287,'processor','form_cookie_days','365'),(288,'rss','rss_enabled','1'),(289,'rss','rss_title','Larvol Sigma'),(290,'rss','rss_link','http://www.larvolsigma.com'),(291,'rss','rss_description','Comments'),(292,'rss','rss_language','en'),(293,'rss','rss_image_enabled','1'),(294,'rss','rss_image_url','http://www.larvolsigma.com/favicon.ico'),(295,'rss','rss_image_width','16'),(296,'rss','rss_image_height','16'),(297,'rss','rss_most_recent_enabled','1'),(298,'rss','rss_most_recent_amount','30'),(299,'security','ban_cookie_days','30'),(300,'security','security_key','u6e4ns5qycoj1t8uedwa'),(301,'security','session_key','ddlm8ihfoai4mgjn0ovz'),(302,'security','check_referrer','1'),(303,'security','check_db_file','1'),(304,'security','check_honeypot','1'),(305,'security','check_time','1'),(306,'social','show_social','1'),(307,'social','social_new_window','1'),(308,'social','show_social_facebook','1'),(309,'social','show_social_delicious','1'),(310,'social','show_social_stumbleupon','1'),(311,'social','show_social_digg','1'),(312,'social','show_social_technorati','0'),(313,'social','show_social_google','1'),(314,'social','show_social_reddit','0'),(315,'social','show_social_myspace','0'),(316,'social','show_social_twitter','1'),(317,'social','show_social_linkedin','0'),(318,'system','admin_folder','control'),(319,'system','mysqldump_path',''),(320,'system','time_zone','America/Los_Angeles'),(321,'system','url_to_comments_folder','http://larvolsigma.com/comments/'),(322,'system','check_comments_url','1'),(323,'system','enabled_wysiwyg','1'),(324,'system','is_demo','0'),(325,'system','limit_comments','50'),(326,'system','delay_pages','1'),(327,'system','lower_pages','0'),(328,'system','admin_cookie_days','365'),(329,'tasks','task_enabled_delete_bans','1'),(330,'tasks','days_to_delete_bans','30'),(331,'tasks','task_enabled_delete_reporters','1'),(332,'tasks','days_to_delete_reporters','30'),(333,'tasks','task_enabled_delete_subscribers','1'),(334,'tasks','days_to_delete_subscribers','7'),(335,'tasks','task_enabled_delete_voters','1'),(336,'tasks','days_to_delete_voters','30'),(337,'viewers','viewers_enabled','1'),(338,'viewers','viewers_timeout','1200'),(339,'viewers','viewers_refresh_enabled','1'),(340,'viewers','viewers_refresh_time','60');




INSERT INTO `redtags`(`id`, `name`, `type`, `rUIS`, `formula`, `statement`, `LI_id`,`abstract_query`)
VALUES(1, 'New trial', 'New Trial', 6, NULL, "select larvol_id, cast(coalesce( firstreceived_date,current_date())as date) as added from data_history join data_trials dt using (larvol_id)  where adddate(firstreceived_date,%d)>= current_date() and overall_status_prev is null and (dt.phase = 'N/A' or dt.phase=0)",'B40E52DE-A4D6-4C85-8B48-F662A69F4503',NULL),
	(2, 'New P4 trial', 'Clinical Trial status', 8, NULL, "select larvol_id, cast(coalesce( firstreceived_date,current_date())as date) as added from data_history join data_trials dt using (larvol_id) where adddate(firstreceived_date,%d)>= current_date() and overall_status_prev is null and dt.phase = '4'",'43EBF0ED-D640-47D1-BA60-0D73B72282F2',NULL),
	(3, 'New P3 trial', 'Clinical Trial status', 10, NULL, "select larvol_id, cast(coalesce( firstreceived_date,current_date())as date) as added from data_history join data_trials dt using (larvol_id) where adddate(firstreceived_date,%d)>= current_date() and overall_status_prev is null and dt.phase = '3'",'3946F04E-A3BB-4DA3-9850-ADC5AAFC161D',NULL),
	(4, 'New P2/P3 trial', 'Clinical Trial status', 10, NULL, "select larvol_id, cast(coalesce( firstreceived_date,current_date())as date) as added from data_history join data_trials dt using (larvol_id) where adddate(firstreceived_date,%d)>= current_date() and overall_status_prev is null and dt.phase = '2/3'",'0BE6A68E-0DE1-413D-83B7-FD8998BED7E6',NULL),
	(5, 'New P2b trial', 'Clinical Trial status', 9, NULL, "select larvol_id, cast(coalesce( firstreceived_date,current_date())as date) as added from data_history join data_trials dt using (larvol_id) where adddate(firstreceived_date,%d)>= current_date() and overall_status_prev is null and dt.phase = '2b'",'C603180C-F0B6-4504-A4AA-DD979D657BC9',NULL),
	(6, 'New P2 trial', 'Clinical Trial status', 8, NULL, "select larvol_id, cast(coalesce( firstreceived_date,current_date())as date) as added from data_history join data_trials dt using (larvol_id) where adddate(firstreceived_date,%d)>= current_date() and overall_status_prev is null and dt.phase = '2'",'D133E268-D967-48FE-82F1-EFA47B5959F2',NULL),
	(7, 'New P2a trial', 'Clinical Trial status', 8, NULL, "select larvol_id, cast(coalesce( firstreceived_date,current_date())as date) as added from data_history join data_trials dt using (larvol_id) where adddate(firstreceived_date,%d)>= current_date() and overall_status_prev is null and dt.phase = '2a'",'8AD0C930-817F-4E5A-9F06-D4D196969966',NULL),
	(8, 'New P1/2 trial', 'Clinical Trial status', 8, NULL, "select larvol_id, cast(coalesce( firstreceived_date,current_date())as date) as added from data_history join data_trials dt using (larvol_id) where adddate(firstreceived_date,%d)>= current_date() and overall_status_prev is null and dt.phase = '1/2'",'89588D6C-2441-4A6A-B4E9-A2D1F417D517',NULL),
	(9, 'New P1 trial', 'Clinical Trial status', 7, NULL, "select larvol_id, cast(coalesce( firstreceived_date,current_date())as date) as added from data_history join data_trials dt using (larvol_id) where adddate(firstreceived_date,%d)>= current_date() and overall_status_prev is null and dt.phase = '1'",'3FA8CA8D-2F09-4212-956B-47CD1DB10ADC',NULL),
	(10, 'Trial initiation date', 'Trial status', 5, 'Initiation date: [date_format(start_date_prev,\'%b %Y\')] ->[date_format(start_date,\'%b %Y\')]', "select larvol_id, cast(coalesce( start_date_lastchanged,current_date())as date) as added from data_history join data_trials dt using (larvol_id) where adddate(start_date_lastchanged,%d)>= current_date() and adddate(start_date_prev,90)<=dt.start_date ",'CE614710-2CD9-48D0-A3F6-E1392FFC67D0',NULL),
	(11, 'Trial completion', 'Trial status', 7, '[overall_status_prev] -> Completed', 'SKIP','624ACA54-7385-409F-9AD3-AC0AEA1CCA6F',NULL),
	(12, 'Trial primary completion', 'Trial status', 8, NULL, 'SKIP','99728CA5-2922-4DE4-8ED6-2E4358FE07A3',NULL),
	(13, 'Trial completion date', 'Trial status', 3, 'Trial completion date: [date_format(end_date_prev,\'%b %Y\')] ->[date_format(end_date,\'%b %Y\')]', "select larvol_id, cast(coalesce( end_date_lastchanged,current_date())as date) as added from data_history join data_trials dt using (larvol_id) where adddate(end_date_lastchanged,%d)>= current_date() and adddate(end_date_prev,90)<=dt.end_date ",'73DEB650-E6F3-40B0-A056-BF1F93D2AE57',NULL),
	(14, 'Trial primary completion date', 'Trial status', 4, NULL, 'SKIP','99728CA5-2922-4DE4-8ED6-2E4358FE07A3',NULL),
	(15, 'Trial termination', 'Trial status', 9, '[overall_status_prev] -> Terminated', "select larvol_id, cast(coalesce( overall_status_lastchanged,current_date())as date) as added from data_history join data_trials dt using (larvol_id) where adddate(overall_status_lastchanged,%d)>= current_date() and overall_status_prev != 'Terminated' and dt.overall_status='Terminated'",'1C310D6F-145C-4666-9DE7-94350A7DC999',NULL),
	(16, 'Trial suspension', 'Trial status', 9, '[overall_status_prev] -> Suspended', "select larvol_id, cast(coalesce( overall_status_lastchanged,current_date())as date) as added from data_history join data_trials dt using (larvol_id) where adddate(overall_status_lastchanged,%d)>= current_date() and overall_status_prev != 'Suspended' and dt.overall_status='Suspended'",'B26B287B-4B4B-4159-B9BE-183ED1669B84',NULL),
	(17, 'Trial withdrawal', 'Trial status', 10, '[overall_status_prev] -> Withdrawn', "select larvol_id, cast(coalesce( overall_status_lastchanged,current_date())as date) as added from data_history join data_trials dt using (larvol_id) where adddate(overall_status_lastchanged,%d)>= current_date() and overall_status_prev != 'Withdrawn' and dt.overall_status='Withdrawn'",'4A249ED2-912A-42C7-93C9-9F9FEC4BE7F7',NULL),
	(18, 'Enrollment open', 'Enrollment status', 6, '[overall_status_prev] -> [overall_status]', "select larvol_id, cast(coalesce( overall_status_lastchanged,current_date())as date) as added from data_history join data_trials dt using (larvol_id) where adddate(overall_status_lastchanged,%d)>= current_date() and overall_status_prev NOT IN ('Recruiting','Enrolling by invitation') and dt.overall_status IN ('Recruiting','Enrolling by invitation')",'BC304BFE-CFB3-419F-8BCF-525FDB91C441',NULL),
	(19, 'Enrollment closed', 'Enrollment status', 5, '[overall_status_prev] -> Active, not recruiting', "select larvol_id, cast(coalesce( overall_status_lastchanged,current_date())as date) as added from data_history join data_trials dt using (larvol_id) where adddate(overall_status_lastchanged,%d)>= current_date() and overall_status_prev != 'Active, not recruiting' and dt.overall_status='Active, not recruiting'",'CFB6E9C6-4A6D-482A-9C7C-6EE33A7AD35B',NULL),
	(20, 'Target Enrollment', 'Enrollment status', 5, 'N=[enrollment_prev] -> [enrollment]', "select larvol_id, cast(coalesce( enrollment_lastchanged,current_date())as date) as added from data_history join data_trials dt using (larvol_id) where adddate(enrollment_lastchanged,%d)>= current_date() and abs(enrollment_prev-dt.enrollment)/enrollment_prev >= 0.2 and enrollment_prev >= 10",'3DAE8220-BDF9-46A8-9E51-92DE85DE8161',NULL),
	(21, 'Phase Classification', 'Clinical Trial status', 2, 'Phase classification: P[phase_prev] -> P[phase]', "select larvol_id, cast(coalesce( phase_lastchanged,current_date())as date) as added from data_history join data_trials dt using (larvol_id) where adddate(phase_lastchanged,%d)>= current_date() and ((phase_prev = "N/A" and dt.phase != "N/A") or (phase_prev != "N/A" and dt.phase = "N/A"))",'51BCAC2B-6EB7-42F8-850B-C03E9DA0A287',NULL),
	(22, 'Phase Shift', 'Clinical Trial status', 10, 'P[phase_prev] -> P[phase]', "select larvol_id, cast(coalesce( phase_lastchanged,current_date())as date) as added from data_history join data_trials dt using (larvol_id) where adddate(phase_lastchanged,%d)>= current_date() and phase_prev != dt.phase  and (phase_prev != "N/A" and dt.phase != "N/A")",'7A4EB458-CD4B-45F0-84A9-D887893215A0',NULL),
	(23,'Clinical Trial,Phase I','Other',4,'Phase 1 Data','SKIP',NULL,"select pm_id from pubmed_abstracts where publicationtype = 'Clinical Trial,Phase I'"),
	(24,'Clinical Trial,Phase II','Other',7,'Phase 2 Data','SKIP',NULL,"select pm_id from pubmed_abstracts where publicationtype = 'Clinical Trial,Phase II'"),
	(25,'Clinical Trial,Phase III','Other',8,'Phase 3 Data','SKIP',NULL,"select pm_id from pubmed_abstracts where publicationtype = 'Clinical Trial,Phase III'"),
	(26,'Clinical Trial,Phase IV','Other',7,'Phase 4 Data','SKIP',NULL,"select pm_id from pubmed_abstracts where publicationtype = 'Clinical Trial,Phase IV'"),
	(27,'Review','Other',5,'Review','SKIP',NULL,"select pm_id from pubmed_abstracts where publicationtype = 'Review',NULL");

INSERT INTO tis_scores(phase, score, category, input)
VALUES('N/A', 0.5, 1, 1),
('N/A', 0.2, 2, 1),
('N/A', 1, 2, 2),
('N/A', 0.1, 3, 1),
('N/A', 0.3, 3, 2),
('N/A', 1, 3, 3),
('N/A', 1, 4, 1),
('N/A', 0.2, 4, 2),
('N/A', 0.3, 4, 3),
('N/A', 0.4, 4, 4),
('0', 0.5, 1, 1),
('0', 0.2, 2, 1),
('0', 1, 2, 2),
('0', 0.1, 3, 1),
('0', 0.3, 3, 2),
('0', 1, 3, 3),
('0', 1, 4, 1),
('0', 0.2, 4, 2),
('0', 0.3, 4, 3),
('0', 0.4, 4, 4),
('1', 0.5, 1, 1),
('1', 0.2, 2, 1),
('1', 1, 2, 2),
('1', 0.1, 3, 1),
('1', 0.3, 3, 2),
('1', 1, 3, 3),
('1', 1, 4, 1),
('1', 0.2, 4, 2),
('1', 0.3, 4, 3),
('1', 0.4, 4, 4),
('2', 0.7, 1, 1),
('2', 0.2, 2, 1),
('2', 1, 2, 2),
('2', 0.1, 3, 1),
('2', 0.3, 3, 2),
('2', 1, 3, 3),
('2', 1, 4, 1),
('2', 0.2, 4, 2),
('2', 0.3, 4, 3),
('2', 0.4, 4, 4),
('3', 1, 1, 1),
('3', 0.2, 2, 1),
('3', 1, 2, 2),
('3', 0.1, 3, 1),
('3', 0.3, 3, 2),
('3', 1, 3, 3),
('3', 1, 4, 1),
('3', 0.2, 4, 2),
('3', 0.3, 4, 3),
('3', 0.4, 4, 4),
('4', 0.7, 1, 1),
('4', 0.2, 2, 1),
('4', 1, 2, 2),
('4', 0.1, 3, 1),
('4', 0.3, 3, 2),
('4', 1, 3, 3),
('4', 1, 4, 1),
('4', 0.2, 4, 2),
('4', 0.3, 4, 3),
('4', 0.4, 4, 4);
		
