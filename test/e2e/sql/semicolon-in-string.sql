-- select * from wp_posts as p where p.post_status='publish' and p.post_type='sfwd-question'
insert into wp_posts values(
	/* ID */                       '31',
	/* post_author */              '1',
	/* post_date */                '2021-02-24 17:58:33',
	/* post_date_gmt */            '2021-02-24 17:58:33',
	/* post_content */             'a:2:{i:0;s:0:\"\";s:18:\"sfwd-question_quiz\";i:8;}\0', -- test serialized string
	/* post_title */               'Basic Math',
	/* post_excerpt */             '',
	/* post_status */              'publish',
	/* comment_status */           'closed',
	/* ping_status */              'closed',
	/* post_password */            '',
	/* post_name */                'basic-math',
	/* to_ping */                  '',
	/* pinged */                   '',
	/* post_modified */            '2021-02-24 17:58:48',
	/* post_modified_gmt */        '2021-02-24 17:58:48',
	/* post_content_filtered */    '',
	/* post_parent */              '0',
	/* guid */                     'http://localhost:8888?post_type=sfwd-question&#038;p=31',
	/* menu_order */               '1',
	/* post_type */                'sfwd-question',
	/* post_mime_type */           '',
	/* comment_count */            '0'
);
